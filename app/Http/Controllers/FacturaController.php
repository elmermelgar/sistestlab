<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Estado;
use App\ExamenPaciente;
use App\Factura;
use App\InvoiceProfile;
use App\Paciente;
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
            $sucursal_id = Auth::user()->sucursal->id;
        }
        $estado_cerrada = Estado::where('name', Factura::CERRADA)->where('tipo', 'factura')->first();
        $query_factura = Factura::where('sucursal_id', $sucursal_id)
            ->where('tax_credit_id', null)
            ->orWhere('estado_id', '<>', $estado_cerrada->id);
        if ($request->numero) {
            $query_factura = $query_factura->filter($request->get('numero'));
        } else {
            $query_factura = $query_factura->orderBy('created_at', 'desc');
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
            if ($factura->credito_fiscal) {
                Notify::info('Esta factura ha sido marcada como parte de un crédito fiscal');
            }
            return view('factura.show', [
                'factura' => $factura,
                'sucursal' => $factura->sucursal,
                'user' => $factura->user,
                'profiles' => $profiles,
                'centro_origen' => $factura->centro_origen,
                'suma' => $factura->payments()->sum('amount'),
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
        if (Auth::user()->sucursal && SucursalService::isOpen(Auth::user()->sucursal->id)) {
            $facturador = Auth::user();
            return view('factura.edit', [
                'factura' => null,
                'sucursal' => $facturador->sucursal,
                'user' => $facturador,
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
                'user' => $factura->user,
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

            $total = $factura->profiles()->sum('price');
            $request->merge(['total' => $total]);
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
            $paciente_ids = $request->paciente_id;
            $numero_boletas = $request->numero_boleta;
            $paciente_nombres = $request->paciente_nombre;
            $paciente_edades = $request->paciente_edad;
            $paciente_generos = $request->paciente_genero;

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
                            $paciente = Paciente::find($paciente_ids[$key]);
                            $examen_paciente->paciente_id = $paciente->id;
                            $examen_paciente->paciente_nombre = $paciente->getFullName();
                            $examen_paciente->paciente_edad = Carbon::parse($paciente->fecha_nacimiento)->age;
                            $examen_paciente->paciente_genero = $paciente->genero;
                        } else {
                            $examen_paciente->paciente_nombre = $paciente_nombres[$key];
                            $examen_paciente->paciente_edad = $paciente_edades[$key];
                            $examen_paciente->paciente_genero = $paciente_generos[$key];
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
            $estado_cerrada = Estado::where('name', Factura::CERRADA)->where('tipo', 'factura')->first();

            if ($factura->estado->name != Factura::ABIERTA) {
                Notify::warning('No se puede realizar un pago de una factura que no esté abierta');
                return back();
            }
            Payment::create($request->all());
            if ($factura->payments()->sum('amount') == $factura->total) {
                $factura->estado()->associate($estado_cerrada);
                $factura->save();
            }
            Notify::success('Pago registrado');
            return redirect()->action("FacturaController@show", ['id' => $request->factura_id]);
        }
        return abort(404);
    }

    /**
     * Busca y retorna a los clientes que coincidan con la razon social especificada
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchCustomer(Request $request)
    {
        try {
            //$razon_social = Input::get('razon_social');
            $cliente = Cliente::where('razon_social', '~*', $request->razon_social)->get();
            $resultado = [
                "total_count" => count($cliente),
                "incomplete_results" => false,
                "items" => $cliente,
            ];
        } catch (\Exception $e) {
            $resultado = [
                "total_count" => 0,
                "incomplete_results" => true,
                "items" => [],
            ];
        }
        return json_encode($resultado);
    }

    /**
     * Busca y retorna a los perfiles de examenes que coincidan con nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchProfile(Request $request)
    {
        try {
            $perfil = Profile::select(['id', 'name', 'display_name', 'type', 'description', 'price'])
                ->where('display_name', '~*', $request->display_name)
                ->where('sucursal_id', $request->sucursal_id)
                ->where('enabled', true)
                ->join('profile_sucursal', 'profiles.id', '=', 'profile_sucursal.profile_id')
                ->get();
            $resultado = [
                "total_count" => count($perfil),
                "incomplete_results" => false,
                "items" => $perfil,
            ];
        } catch (\Exception $e) {
            $resultado = [
                "total_count" => 0,
                "incomplete_results" => true,
                "items" => [],
            ];
        }
        return json_encode($resultado);
    }

    /**
     * Busca y retorna a los clientes que coincidan con nombre especificado
     * Retorna una cadena json para ser usada con Select2 AJAX
     * @param Request $request
     * @return string
     */
    public function searchPaciente(Request $request)
    {
        try {
            $pacientes = DB::table('pacientes_vw')->where('full_name', '~*', $request->full_name)->get();
            $resultado = [
                "total_count" => count($pacientes),
                "incomplete_results" => false,
                "items" => $pacientes,
            ];
        } catch (\Exception $e) {
            $resultado = [
                "total_count" => 0,
                "incomplete_results" => true,
                "items" => [],
            ];
        }
        return json_encode($resultado);
    }

}
