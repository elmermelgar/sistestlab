<?php

namespace App\Http\Controllers;

use App\Antibiotico;
use App\Antibiotico_type;
use App\Estado;
use App\Exam_detail;
use App\ExamenPaciente;
use App\Exam;
use App\Protozoarios;
use App\Reference_value;
use App\Register_antibiotico;
use App\Spermogram;
use App\Sucursal;
use App\Grouping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\PDF;
use Jleon\LaravelPnotify\Notify;
use Carbon\Carbon;
use App\Services\InventarioService;

class ResultadosController extends Controller
{
    /**
     * @var InventarioService
     */
    private $inventarioService;

    /**
     * InventarioController constructor.
     */
    public function __construct(InventarioService $inventarioService)
    {
        $this->middleware('auth');
        $this->inventarioService = $inventarioService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $denegado = Estado::where('name', 'denegado')->first();
        $facturado = Estado::where('name', 'facturado')->first();
        $examenes = ExamenPaciente::whereIn('estado_id', [$facturado->id, $denegado->id])->get();
        return view('examen.resultados.exams_paciente', [
            'examenes' => $examenes
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return view('examen.resultados.exams_paciente_all', [
            'examenes' => ExamenPaciente::paginate(100)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function process()
    {
        $estado = Estado::where('name', 'proceso')->first();
        return view('examen.resultados.exams_paciente_proceso', [
            'examenes' => ExamenPaciente::where('estado_id', $estado->id)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeaprobar($id)
    {
//        dd($id);
        $exam_p = ExamenPaciente::find($id);
        $estado = Estado::where('name', 'validado')->first();
        $exam_activo = DB::table('exam_activo')->where('exam_id', '=', $exam_p->exam_id)->get();
        foreach ($exam_activo as $item) {
            $resultado = $this->inventarioService->descargar(
                auth()->user()->sucursal_id, $item->activo_id, $item->cantidad);
            if ($resultado != 0) {
                Notify::danger($this->inventarioService->messages[$resultado], 'Error!!');
                return back();
            }
        }
        $exam_p->account_id = auth()->user()->account_id;
        $exam_p->estado_id = $estado->id;
        $exam_p->fecha_validado = Carbon::now();
        $exam_p->save();
        Notify::success('Boleta de resultados aprobada correctamente');
        return back();
    }

    /**
     * @param Request $request
     * @return Redirect
     */
    public function results(Request $request)
    {
//        dd($request->examen_paciente_id .'===='.$request->result.'===='.$request->observation);
//        dd(count($request->exam_detail_id) . '========' . count($request->result));
//        dd($request);

        if (($exam_paciente = ExamenPaciente::find($request->examen_paciente_id)) && (count($request->exam_detail_id) == count($request->result))) {
            $exam_paciente->detalles()->detach();
            foreach ($request->exam_detail_id as $index => $exam_detail_id) {
                if ($request->result[$index] != null) {
                    //dd($request->out_range[$index]);
                    if ($request->out_range[$index]){
                        $out_range = true;
                    }else{
                        $out_range = false;
                    }
                    $exam_paciente->detalles()->attach($exam_detail_id, ['result' => $request->result[$index], 'observation' => $request->observation[$index], 'protozoarios_type_id' => $request->protozoarios_type_id[$index], 'spermogram_modality_id' => $request->spermogram_type_id[$index], 'out_range' => $out_range]);
                }
            }
            $estado = Estado::where('name', 'proceso')->first();
            $exam_paciente->estado_id = $estado->id;
            $exam_paciente->fecha_resultado = Carbon::now();
            $exam_paciente->save();
            Notify::success('Resultados guardados correctamente');
            return redirect()->action('ResultadosController@index');
        }
        Notify::danger('No se han guardado los resultados');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function complete($id_ex, $id_xp)
    {
        return view('examen.resultados.fill_results', [
            'examen' => Exam::find($id_ex),
            'details' => Exam_detail::all(),
            'proto_types' => Protozoarios::all(),
            'proto_nin' => Protozoarios::where('name', 'Ninguno')->first(),
            'sperm_types' => Spermogram::all(),
            'sperm_nin' => Spermogram::where('name', 'Ninguno')->first(),
            'examen_paciente' => ExamenPaciente::find($id_xp),
            'groupings' => Grouping::where(['exam_id' => $id_ex])->get(),
            'reference_values' => Reference_value::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id_ex, $id_xp
     * @return \Illuminate\Http\Response
     */
    public function ticket($id_ex, $id_xp)
    {
//        dd(Auth::user()->sucursal_id );
        return view('boleta.index', [
            'sucursal' => Auth::user()->account->sucursal,
            'examen' => Exam::find($id_ex),
            'details' => Exam_detail::all(),
            'proto_types' => Protozoarios::all(),
            'proto_nin' => Protozoarios::where('name', 'Ninguno')->first(),
            'sperm_types' => Spermogram::all(),
            'antibioticos' => Antibiotico::all(),
            'antibiotico_types' => Antibiotico_type::all(),
            'sperm_nin' => Spermogram::where('name', 'Ninguno')->first(),
            'registro_antibioticos' => Register_antibiotico::where('examen_paciente_id', $id_xp)->get(),
            'examen_paciente' => ExamenPaciente::find($id_xp),
            'groupings' => Grouping::where(['exam_id' => $id_ex])->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storedenegar(Request $request, $id)
    {
        $exam_p = ExamenPaciente::find($id);
        $estado = Estado::where('name', 'denegado')->first();
        $exam_p->account_id = auth()->user()->account_id;
        $exam_p->estado_id = $estado->id;
        $exam_p->observacion = $request->observacion;
        $exam_p->save();
        Notify::warning('La boleta de resultados a sido denegada');
        return back();
    }

    /**
     * Funci??n para imprimir la boleta.
     *
     * @param  int $id_ex, $id_xp
     * @return \Illuminate\Http\Response
     */
    public function print1($id_ex, $id_xp)
    {
        $vistaurl = "boleta.index";
        $sucursal = Auth::user()->account->sucursal;
        $examen = Exam::find($id_ex);
        $details = Exam_detail::all();
        $proto_types = Protozoarios::all();
        $proto_nin = Protozoarios::where('name', 'Ninguno')->first();
        $sperm_types = Spermogram::all();
        $antibioticos = Antibiotico::all();
        $antibiotico_types = Antibiotico_type::all();
        $sperm_nin = Spermogram::where('name', 'Ninguno')->first();
        $registro_antibioticos = Register_antibiotico::where('examen_paciente_id', $id_xp)->get();
        $examen_paciente = ExamenPaciente::find($id_xp);
        $groupings = Grouping::where(['exam_id' => $id_ex])->get();



//        $view= \View::make($vistaurl,compact('sucursal','examen','details','proto_types','proto_nin','sperm_types','sperm_nin','antibioticos','antibiotico_types','registro_antibioticos','examen_paciente','groupings'))->render();
//        $pdf= \App::make('dompdf.wrapper');
//        $pdf->loadHTML($view);
//        $pdf = PDF::loadView('boleta.index', $sucursal,$examen,$details,$proto_types,$proto_nin,$sperm_types,$antibioticos,$antibiotico_types,$sperm_nin,$registro_antibioticos,$examen_paciente,$groupings);
//        $pdf = \PDF::loadView('boleta.index', [
//            'sucursal' => Auth::user()->account->sucursal,
//            'examen' => Exam::find($id_ex),
//            'details' => Exam_detail::all(),
//            'proto_types' => Protozoarios::all(),
//            'proto_nin' => Protozoarios::where('name', 'Ninguno')->first(),
//            'sperm_types' => Spermogram::all(),
//            'antibioticos' => Antibiotico::all(),
//            'antibiotico_types' => Antibiotico_type::all(),
//            'sperm_nin' => Spermogram::where('name', 'Ninguno')->first(),
//            'registro_antibioticos' => Register_antibiotico::where('examen_paciente_id', $id_xp)->get(),
//            'examen_paciente' => ExamenPaciente::find($id_xp),
//            'groupings' => Grouping::where(['exam_id' => $id_ex])->get()
//        ]);
        $pdf = \PDF::loadView('boleta.intento',['examen_paciente' => $examen_paciente, 'examen' =>$examen,'groupings' =>$groupings, 'details' => $details, 'proto_types'=>$proto_types, 'registro_antibioticos'=>$registro_antibioticos, 'sperm_types'=>$sperm_types]);
        return $pdf->stream('reporte.pdf');

//        return $pdf->download('reporte');
    }
}
