<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Exam;
use App\ExamenPaciente;
use App\Factura;
use App\InvoiceProfile;
use App\Payment;
use App\Profile;
use App\Recolector;
use App\Services\SucursalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\ValidationException;
use Jleon\LaravelPnotify\Notify;

class FacturaController extends Controller
{

    /**
     * Constante para el tipo de pago en efectivo
     */
    const EFECTIVO = 0;

    /**
     * Constante para el tipo de pago con debito
     */
    const DEBITO = 1;

    /**
     * FacturaController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la lista de facturas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('factura.index', ['facturas' => Factura::all()]);
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
     * Muestra la factura especificada para que sea editada
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($factura = Factura::find($id)) {
            $examenes = $factura->examen_paciente->groupBy('exam_id');
            return view('factura.edit', [
                'factura' => $factura,
                'sucursal' => $factura->sucursal,
                'user' => $factura->user,
                'recolectores' => Recolector::all(),
                'examenes' => $examenes,
                'centro_origen' => true,
                'edit' => true
            ]);
        }

        return abort(404);
    }

    /**
     * Muestra la vista para crear una factura a un centro de origen
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function facturar_centro_origen()
    {
        if (Auth::user()->sucursal && SucursalService::isOpen(Auth::user()->sucursal->id)) {
            $facturador = Auth::user();
            return view('factura.edit', [
                'factura' => null,
                'user' => $facturador,
                'sucursal' => $facturador->sucursal,
                'recolectores' => Recolector::all(),
                'centro_origen' => true,
                'edit' => true,
            ]);
        } else {
            return view('sucursal.closed');
        }
    }

    /**
     * Muestra la vista para crear una factura a un cliente registrado
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function facturar_cliente()
    {
        if (Auth::user()->sucursal && SucursalService::isOpen(Auth::user()->sucursal->id)) {
            $facturador = Auth::user();
            return view('factura.edit', [
                'factura' => null,
                'user' => $facturador,
                'sucursal' => $facturador->sucursal,
                'recolectores' => Recolector::all(),
                'centro_origen' => false,
                'edit' => true,
            ]);
        } else {
            return view('sucursal.closed');
        }
    }

    /**
     * Muestra la vista para crear una factura de credito fiscal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function facturar_credito_fiscal()
    {
        if (Auth::user()->sucursal && SucursalService::isOpen(Auth::user()->sucursal->id)) {
            $facturador = Auth::user();
            return view('factura.credito_fiscal', [
                'factura' => null,
                'user' => $facturador,
                'sucursal' => $facturador->sucursal,
                'recolectores' => Recolector::all(),
                'centro_origen' => true,
                'edit' => true,
            ]);
        } else {
            return view('sucursal.closed');
        }
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
            $request->credito_fiscal ?
                $request->merge(['credito_fiscal' => true]) : $request->merge(['credito_fiscal' => false]);
            $factura = Factura::find($id);
            $total = $factura->profiles()->sum('price');
            $request->merge(['total' => $total]);
            $factura->update($request->all());
            Payment::create($request->only(['factura_id', 'amount', 'type']));
            Notify::success('Facturación completa');
            return redirect()->action("FacturaController@show", ['id' => $factura->id]);
        }
        return abort(404);
    }

    /**
     * Almacena una factura
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        //Empieza la transacción
        DB::beginTransaction();

        try {

            if ($factura = Factura::find($request->factura_id)) {
                $factura->update($request->all());
            } else {
                $factura = Factura::create($request->all());
                $profile_ids = $request->profile_id;
                $numero_boletas = $request->numero_boleta;
                $paciente_nombres = $request->paciente_nombre;
                $paciente_edades = $request->paciente_edad;
                $paciente_generos = $request->paciente_genero;

                foreach ($profile_ids as $key => $profile_id) {
                    $profile = Profile::find($profile_id);
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

                    foreach ($profile->exams as $exam) {
                        $examen_paciente = new ExamenPaciente();
                        $examen_paciente->invoice_profile_id = $invoice_profile->id;
                        $examen_paciente->exam_id = $exam->id;
                        $examen_paciente->numero_boleta = $numero_boletas[$key];
                        $examen_paciente->paciente_nombre = $paciente_nombres[$key];
                        $examen_paciente->paciente_edad = $paciente_edades[$key];
                        $examen_paciente->paciente_genero = $paciente_generos[$key];
                        $examen_paciente->save();
                    }
                }

            }
            //Exito, hace efectivos todos los cambios en la base de datos
            DB::commit();

        } catch (\Exception $e) {
            //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
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
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payment($id, Request $request){
        if ($id == $request->factura_id) {
            Payment::create($request->all());
            Notify::success('Pago registrado');
            return redirect()->action("FacturaController@show", ['id' => $request->factura_id]);
        }
        return abort(404);
    }

    /**
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
     * @param Request $request
     * @return string
     */
    public function searchProfile(Request $request)
    {
        try {
            $perfil = Profile::select(['id', 'name', 'display_name', 'type', 'description', 'price'])
                ->where('display_name', '~*', $request->display_name)
                ->where('sucursal_id', $request->sucursal_id)
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

}
