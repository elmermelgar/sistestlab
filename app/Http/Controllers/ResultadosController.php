<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Exam_detail;
use App\ExamenPaciente;
use App\Exam;
use App\Protozoarios;
use App\User;
use App\Grouping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Jleon\LaravelPnotify\Notify;
use Carbon\Carbon;

class ResultadosController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //dd(auth()->user()->sucursal_id);
//        $ex_pac= ExamenPaciente::all();
//        dd($ex_pac->invoices->profile->pivot->sucursal_id);
        return view('examen.resultados.exams_paciente', [
            'examenes' => ExamenPaciente::all()
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
            'examenes' => ExamenPaciente::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function process()
    {
        return view('examen.resultados.exams_paciente_proceso', [
            'examenes' => ExamenPaciente::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
                if ($request->result[$index] != null)
                    $exam_paciente->detalles()->attach($exam_detail_id, ['result' => $request->result[$index], 'observation' => $request->observation[$index], 'protozoarios_type_id' => $request->protozoarios_type_id[$index]]);
            }
            $estado=Estado::where('name','proceso')->first();
            $exam_paciente->estado_id=$estado->id;
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
            'examen_paciente' => ExamenPaciente::find($id_xp),
            'groupings' => Grouping::where(['exam_id' => $id_ex])->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
