<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Exam;
use App\ExamenPaciente;
use App\Factura;
use App\Recolector;
use App\Services\SucursalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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
            $examenes = $factura->examen_paciente->groupBy('exam_id');
            return view('factura.show', [
                'factura' => $factura,
                'sucursal' => $factura->sucursal,
                'user' => $factura->user,
                'examenes' => $examenes,
                'centro_origen' => $factura->centro_origen,
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
            return view('factura.facturar', [
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
            return view('factura.facturar', [
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
            return view('factura.facturar', [
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
        if ($id == $request->id) {
            $request->credito_fiscal ?
                $request->merge(['credito_fiscal' => true]) : $request->merge(['credito_fiscal' => false]);
            $factura = Factura::find($id);
            $total = 0;
            $examenes = $factura->examen_paciente->groupBy('exam_id');
            foreach ($examenes as $examen) {
                $subtotal = $examen->first()->exam->precio * $examen->count();
                $total += $subtotal;
            }
            $request->merge(['total'=>$total]);
            $factura->update($request->all());
            Notify::success('Facturación completa');
            return redirect()->action("FacturaController@index", ['id' => $factura->id]);
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
        if ($factura = Factura::find($request->factura_id)) {
            $factura->update($request->all());
        } else {
            dump($request->all());
            $factura = Factura::create($request->all());
            $exam_ids = $request->exam_id;
            $paciente_nombres = $request->paciente_nombre;
            $paciente_edades = $request->paciente_edad;
            $paciente_generos = $request->paciente_genero;

            foreach ($exam_ids as $key => $exam_id) {
                $examen_paciente = new ExamenPaciente();
                $examen_paciente->factura_id = $factura->id;
                $examen_paciente->exam_id = $exam_id;
                $examen_paciente->paciente_nombre = $paciente_nombres[$key];
                $examen_paciente->paciente_edad = $paciente_edades[$key];
                $examen_paciente->paciente_genero = $paciente_generos[$key];
                $examen_paciente->save();
            }

        }
        return redirect()->action("FacturaController@show", ['id' => $factura->id]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function searchCustomer(Request $request)
    {
        $razon_social = Input::get('razon_social');
        $cliente = Cliente::where('razon_social', '~*', $razon_social)->get();
        $resultado = [
            "total_count" => count($cliente),
            "incomplete_results" => false,
            "items" => $cliente,
        ];
        return json_encode($resultado);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function searchExam(Request $request)
    {
        $display_name = Input::get('display_name');
        $examen = Exam::where('display_name', '~*', $display_name)->get();
        $resultado = [
            "total_count" => count($examen),
            "incomplete_results" => false,
            "items" => $examen,
        ];
        return json_encode($resultado);
    }

}
