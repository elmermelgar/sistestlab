<?php

namespace App\Http\Controllers;

use App\Estado;
use App\ExamenPaciente;
use App\Factura;
use App\InvoiceProfile;
use App\Patient;
use App\Payment;
use App\Profile;
use App\Recolector;
use App\Services\SucursalService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jleon\LaravelPnotify\Notify;

class FacturaController extends Controller
{

    /**
     * FacturaController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la lista de facturas
     * @param Request $request
     * @param $sucursal_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $sucursal_id = null)
    {
        if (!$sucursal_id) {
            $sucursal_id = Auth::user()->account_id;
        }
        $estado_cerrada = Estado::where('name', Factura::CERRADA)->where('tipo', 'factura')->first();
        $query_factura = Factura::where('sucursal_id', $sucursal_id)
            ->where('tax_credit_id', null)
            ->orWhere('estado_id', '<>', $estado_cerrada->id);
        if ($request->numero) {
            $query_factura = $query_factura->filter($request->get('numero'));
        } else {
            $query_factura = $query_factura->orderBy('date', 'desc')->orderBy('time', 'desc');
        }
        return view('factura.index', [
            'facturas' => $query_factura->paginate(10),
        ]);
    }

    /**
     * Muestra la factura especificada
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($factura = Factura::find($id)) {
            //profiles->profile_invoice
            $profiles = $factura->profiles()->get()->groupBy('profile_id');
            $nivel_monto = round($factura->profiles()->sum('price') * $factura->nivel + 0.004, 2);
            if ($factura->credito_fiscal) {
                Notify::info('Esta factura ha sido marcada como parte de un crédito fiscal');
            }
            return view('factura.show', [
                'factura' => $factura,
                'sucursal' => $factura->sucursal,
                'facturador' => $factura->facturador,
                'profiles' => $profiles,
                'centro_origen' => $factura->centro_origen,
                'suma' => $factura->payments()->sum('amount'),
                'nivel_monto' => $nivel_monto,
                'edit' => false
            ]);
        }

        return abort(404);
    }

    /**
     * Muestra la vista para crear una factura a un centro de origen
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($centro_origen = false)
    {
        $centro_origen ? $centro_origen = true : $centro_origen = false;
        if (SucursalService::isOpen(Auth::user()->account->sucursal_id)) {
            $facturador = Auth::user()->account;
            return view('factura.edit', [
                'factura' => null,
                'sucursal' => $facturador->sucursal,
                'facturador' => $facturador,
                'recolectores' => Recolector::where('activo', true)->get(),
                'perfiles' => [],
                'centro_origen' => $centro_origen,
                'edit' => true,
            ]);
        } else {
            return view('sucursal.closed');
        }
    }

    /**
     * Muestra la factura especificada para que sea editada
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($factura = Factura::find($id)) {
            if ($factura->estado->name != Factura::BORRADOR) {
                Notify::warning('Esta factura no puede ser editada');
                return back();
            }
            $perfiles = $factura->profiles;
            return view('factura.edit', [
                'factura' => $factura,
                'sucursal' => $factura->sucursal,
                'facturador' => $factura->facturador,
                'recolectores' => Recolector::where('activo', true)->get(),
                'perfiles' => $perfiles,
                'centro_origen' => $factura->recolector ? true : false,
                'edit' => true
            ]);
        }

        return abort(404);
    }

    /**
     * Registra, en caja, el total y los montos de la factura
     * @param integer $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function facturar($id, Request $request)
    {
        if ($id == $request->factura_id) {
            $factura = Factura::find($id);
            $estado_abierta = Estado::where('name', Factura::ABIERTA)->where('tipo', 'factura')->first();
            $estado_cerrada = Estado::where('name', Factura::CERRADA)->where('tipo', 'factura')->first();
            $estado_facturado = Estado::where('name', 'facturado')->where('tipo', 'examen_paciente')->first();
            if ($factura->estado->name != Factura::BORRADOR) {
                Notify::warning('No se puede confirmar esta factura');
                return back();
            }

            $suma = $factura->profiles()->sum('price');
            $total = round($suma * (1 + $factura->nivel) + 0.004, 2);
            $request->merge(['total' => $total]);

            if ($request->amount <= 0 || $request->amount > $total) {
                Notify::error('No se puede facturar con monto cero o un pago mayor al total');
                return redirect()->back();
            }

            if ($request->amount == $total) {
                $request->merge(['estado_id' => $estado_cerrada->id]);
            } else {
                $request->merge(['estado_id' => $estado_abierta->id]);
            }

            $request->credito_fiscal ?
                $request->merge(['credito_fiscal' => true]) : $request->merge(['credito_fiscal' => false]);

            DB::table('examen_paciente')->whereIn('invoice_profile_id', $factura->profiles->pluck('id')->all())
                ->update(['estado_id' => $estado_facturado->id]);

            Payment::create($request->only(['sucursal_id', 'factura_id', 'amount', 'type']));
            $factura->date = Carbon::now();
            $factura->time = Carbon::now();
            $factura->update($request->all());

            Notify::success('Facturación completa');
            return redirect()->action("FacturaController@show", ['id' => $factura->id]);
        }
        return abort(404);
    }

    /**
     * Almacena una factura
     * @param Request $request
     * @return FacturaController|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //Empieza la transacción
        DB::beginTransaction();

        try {

            $estado_borrador = \App\Estado::where('name', Factura::BORRADOR)->where('tipo', 'factura')->first();
            $estado_sin_facturar = \App\Estado::where('name', 'sin_facturar')->where('tipo', 'examen_paciente')->first();
            $request->merge(['estado_id' => $estado_borrador->id]);

            if ($request->factura_id && $factura = Factura::find($request->factura_id)) {
                $factura->update($request->all());
                $invoice_profile = $factura->profiles->pluck('id');
            } else {
                $factura = Factura::create($request->all());
                $invoice_profile = collect([]);
            }

            //obtiene los arreglos de parámetros desde la petición
            $invoice_profile_ids = $request->invoice_profile_id;
            $profile_ids = $request->profile_id;
            $paciente_ids = $request->patient_id;
            $numero_boletas = $request->numero_boleta;
            $paciente_nombres = $request->paciente_nombre;
            $paciente_edades = $request->paciente_edad;
            $paciente_sexos = $request->paciente_sexo;

            /**
             * Elimina de la base de datos los perfiles, asociados previamente,
             * que han sido removidos en la edición de la factura.
             * Obtiene los id invoice_profile (diferencia) de la factura y los elimina.
             */
            $diff = $invoice_profile->diff($invoice_profile_ids)->all();
            InvoiceProfile::destroy($diff);

            /**
             * se asocia cada perfil(examen o grupo de exámenes) a la factura
             * y se registra el respectivo precio
             */
            foreach ($invoice_profile_ids as $key => $ipi) {
                //Una entrada de factura es nueva cuando no tiene id(invoice_profile_id=0), solo entonces es registrada
                if ($ipi == 0) {
                    $profile = Profile::find($profile_ids[$key]);
                    $price = DB::table('profile_sucursal')
                        ->select('price')
                        ->where('profile_id', $profile->id)
                        ->where('sucursal_id', $request->sucursal_id)
                        ->first()->price;
                    $invoice_profile = InvoiceProfile::create([
                        'factura_id' => $factura->id,
                        'profile_id' => $profile->id,
                        'price' => $price
                    ]);

                    //cada examen del perfil se asocia con el paciente
                    foreach ($profile->exams as $exam) {
                        $examen_paciente = new ExamenPaciente();
                        $examen_paciente->invoice_profile_id = $invoice_profile->id;
                        $examen_paciente->exam_id = $exam->id;
                        $examen_paciente->estado_id = $estado_sin_facturar->id;
                        $examen_paciente->numero_boleta = $numero_boletas[$key];
                        if (!is_null($paciente_ids[$key]) && $paciente_ids[$key] != '') {
                            $paciente = Patient::find($paciente_ids[$key]);
                            $examen_paciente->patient_id = $paciente->id;
                            $examen_paciente->paciente_nombre = $paciente->name;
                            $examen_paciente->paciente_edad = Carbon::parse($paciente->fecha_nacimiento)->age;
                            $examen_paciente->paciente_sexo = $paciente->sexo;
                        } else {
                            $examen_paciente->paciente_nombre = $paciente_nombres[$key];
                            $examen_paciente->paciente_edad = $paciente_edades[$key];
                            $examen_paciente->paciente_sexo = $paciente_sexos[$key];
                        }
                        $examen_paciente->save();
                    }
                }
            }

            //Exito, hace efectivos todos los cambios en la base de datos
            DB::commit();

        } catch (\Exception $e) {
            //Ocurre algun error, revierte todos los cambios en la base de datos y responde con un mensaje
            DB::rollBack();
            if ($e instanceof ValidationException) {
                foreach ($e->validator->errors()->all() as $error) {
                    Notify::error($error);
                }
                return back()->withInput();
            }
            \Log::error($e);
            Notify::error("No se guardó la factura");
            return back()->withInput();
        }

        Notify::success("La factura se guardó correctamente");
        return redirect()->action("FacturaController@show", ['id' => $factura->id]);
    }

    /**
     * Aplicar un recargo o un descuento a la facturas
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function nivel($id, Request $request)
    {
        if ($id == $request->factura_id && $factura = Factura::find($id)) {
            if ($factura->estado->name != Factura::BORRADOR) {
                Notify::error('Esta factura no se le puede aplicar un descuento o recargo');
                return back();
            }
            if ($request->nivel == 0) {
                $mensaje = "Nivel removido correctamente";
            } elseif ($request->nivel < 0 && $request->nivel >= -1) {
                $mensaje = "Descuento aplicado correctamente";
            } elseif ($request->nivel > 0 && $request->nivel <= 1) {
                $mensaje = "Recargo aplicado correctamente";
            } else {
                Notify::error('Solo puede aplicarse un nivel entre -100% y 100%');
                return back();
            }
            $factura->nivel = $request->nivel;
            $factura->save();
            Notify::success($mensaje);
            return redirect()->action("FacturaController@show", ['id' => $request->factura_id]);
        }
        return abort(404);
    }

    /**
     * Anula una factura
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function annul(Request $request)
    {
        if ($request->factura_id && $factura = Factura::find($request->factura_id)) {
            if ($factura->estado->name != Factura::BORRADOR) {
                Notify::error('Esta factura no puede anularse');
                return back();
            }
            $estado_anulada = Estado::where('name', Factura::ANULADA)->where('tipo', 'factura')->first();
            $factura->estado()->associate($estado_anulada);
            $factura->save();
        } else {
            Notify::error("Ninguna factura ha sido anulada");
            return back();
        }
        Notify::warning("La factura ha sido anulada");
        return redirect()->action("FacturaController@index");
    }

    /**
     * Almacena los pagos realizados por facturas
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payment($id, Request $request)
    {
        if ($id == $request->factura_id) {
            $factura = Factura::find($id);

            if (!SucursalService::isOpen($factura->sucursal->id)) {
                Notify::error('No se puede realizar un pago mientras la caja esté cerrada');
                return back();
            }

            $estado_cerrada = Estado::where('name', Factura::CERRADA)->where('tipo', 'factura')->first();
            if ($factura->estado->name != Factura::ABIERTA) {
                Notify::warning('No se puede realizar un pago de una factura que no esté abierta');
                return back();
            }

            $suma = $factura->payments()->sum('amount');
            $deuda = $factura->total - $suma;
            if ($request->amount <= 0 || $request->amount > $deuda) {
                Notify::error('No se puede realizar un pago con monto cero o un pago mayor a la deuda');
                return redirect()->back();
            }
            Payment::create($request->all());
            $suma = $suma + $request->amount;
            if ($suma == $factura->total) {
                $factura->estado()->associate($estado_cerrada);
                $factura->save();
            }
            Notify::success('Pago registrado');
            return redirect()->action("FacturaController@show", ['id' => $request->factura_id]);
        }
        return abort(404);
    }

}
