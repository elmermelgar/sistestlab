<?php

namespace App\Http\Controllers;

use App\Activo;
use App\Estado;
use App\Exam;
use App\Exam_category;
use App\Exam_detail;
use App\Grouping;
use App\Reference_value;
use App\ReferenceType;
use App\Sample;
use App\Sucursal;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Jleon\LaravelPnotify\Notify;
use Swift_TransportException;


class ExamController extends Controller
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
    public function index(Request $request, $id)
    {
//        dd(Exam::where(array('sucursal_id' => $id))->get());
//        dd($request->get('display_name'));
        return view('examen.index', ['examenes' => Exam::name($request->get('display_name'))->where(array('sucursal_id' => $id))->paginate(20), 'sucursal_id'=>$id, 'sucursal'=> Sucursal::find($id)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id1, $id2)
    {
        $examen = Exam::find($id2);
        return view('examen.exam_detail.detail',
            ['examen' => $examen, 'sucursal'=> Sucursal::find($id1),
                'grupos'=> Grouping::where(array('exam_id' => $id2))->get(),
                'activos'=> Activo::where(array('sucursal_id' => $examen->sucursal_id))->get(),
                'details'=> Exam_detail::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create($id)
    {
        $estado = Estado::all();
        $samples = Sample::all();
        $categories = Exam_category::all();
        return view('examen.edit', ['examen' => null, 'samples' => $samples, 'sucursal' => Sucursal::find($id), 'estados' => $estado, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        //Empieza la transacción
//        DB::beginTransaction();
//
//        try {

            if ($request->id && $examen = Exam::find($request->id)) {
                $examen->update($request->all());
            } else {
                $examen = Exam::create($request->all());

                $group = new Grouping();
                $group->name = '';
                $group->display_name = 'Sin Agrupamiento';
                $group->exam_id = $examen->id;
                $group->save();
            }

//            //Exito, hace efectivos todos los cambios en la base de datos
//            DB::commit();
//
//        } catch (\Exception $e) {
//            //Ocurre algun error, deshace los todos los cambios en la base de datos y responde con un mensaje
//            DB::rollBack();
//            if ($e instanceof ValidationException) {
//                foreach ($e->validator->errors()->all() as $error) {
//                    Notify::error($error);
//                }
//                return back()->withInput();
//            }
//            if ($e instanceof Swift_TransportException) {
//                Notify::error('No se ha podido guardar el examen por favor verifique que todos los datos sean correctos'.':(');
//            }
//            \Log::error($e);
//            return back()->withInput();
//        }

        //Se completó el registro del cliente exitosamente
        Notify::success('Guardado correctamente','Exito!!');
        return redirect('examenes/' . $examen->sucursal_id .'/'. $examen->id);
    }

    /**
     * Guarda los agrupamientos de los examenes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storegroup(Request $request)
    {
            $group = Grouping::create($request->all());

        Notify::success('Guardado correctamente','Exito!!');
        return redirect('examenes/' . $group->exam->sucursal_id .'/'. $group->exam->id);
    }

    /**
     * Guarda los agrupamientos de los examenes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storereference(Request $request)
    {
        $reference = Reference_value::create($request->all());

        Notify::success('Guardado correctamente','Exito!!');
        return redirect('examenes/examen/' . $reference->exam_detail->grouping->exam->id .'/'. $reference->exam_detail->id.'/reference_value');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storedetail(Request $request)
    {
        if ($request->id && $detail = Exam_detail::find($request->id)) {
            $detail->update($request->all());
        } else {
            $detail = Exam_detail::create($request->all());
        }
        Notify::success('Guardado correctamente','Exito!!');
        return redirect('examenes/' . $detail->grouping->exam->sucursal_id .'/'. $detail->grouping->exam->id);
    }

    /**
     * Guardar las asociaciones de activos y examenes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store_examen_activo(Request $request)
    {
        if ($request->exam_id && $examen = Exam::find($request->exam_id)) {
            $examen->activos()->sync($request->activo_id);
        }

//        $activos = Activo::where(array('id' => $request->activo_id))->get();
//        $activos->exams()->sync($request->exam_id);
        Notify::success('Guardado correctamente','Exito!!');
        return redirect('examenes/' . $examen->sucursal_id .'/'. $examen->id);
    }

    /**
     * Cargar vista para Editar el examen.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estado = Estado::all();
        $samples = Sample::all();
        $categories = Exam_category::all();
//        dd($examen = Exam::find($id));
        if ($examen = Exam::find($id)) {
            return view('examen.edit', ['examen' => $examen, 'samples' => $samples, 'sucursal' => Sucursal::find($id), 'estados' => $estado, 'categories' => $categories]);
        }
       // return response()->view('errors.404', [], 404);
    }

    /**
     * Crear un nuevo Resultado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_detail($id)
    {
        return view('examen.exam_detail.edit', ['detail' => null, 'examen' => Exam::find($id), 'types'=> ReferenceType::all(), 'groupings'=> Grouping::where(array('exam_id' => $id))->get()]);
    }

    /**
     * Asignar recursos al examen.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_resources($id)
    {
        $examen = Exam::find($id);
        return view('examen.asignar_recursos.edit', ['examen_activo' => null, 'examen' => $examen, 'activos'=> Activo::where(array('sucursal_id' => $examen->sucursal_id))->get()]);
    }

    /**
     * Editar Resultados.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id, $id2)
    {
        return view('examen.exam_detail.edit', ['detail' => Exam_detail::find($id2), 'examen' => Exam::find($id), 'types'=> ReferenceType::all(), 'groupings'=> Grouping::where(array('exam_id' => $id))->get()]);
    }

    /**
     * Ir a la vista de valores de referencia.
     *
     * @param  int  $id, $id2
     * @return \Illuminate\Http\Response
     */
    public function reference_detail($id, $id2)
    {
        return view('examen.reference_value.index', ['detail' => Exam_detail::find($id2), 'examen' => Exam::find($id), 'references'=> Reference_value::where(array('exam_detail_id' => $id2))->get()]);
    }

    /**
     * Elimina detalles de examen.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id, $id2)
    {
        $examen = Exam::find($id);
        $reference = Reference_value::where(array('exam_detail_id' => $id2))->first();
        if ($reference != null){
            Notify::error('No se puede eliminar este registro, porque tiene asosiados','Error!!');
            return redirect('examenes/' . $examen->sucursal_id .'/'. $examen->id);
        }else{
            Exam_detail::destroy($id2);
            Notify::warning('Registro eliminado correctamente','Eliminado!!');
            return redirect('examenes/' . $examen->sucursal_id .'/'. $examen->id);
        }
    }

    /**
     * Elimina grupos de examenes.
     *
     * @param  int  $id, $id2
     * @return \Illuminate\Http\Response
     */
    public function destroy_group($id, $id2)
    {
        $examen = Exam::find($id);
        $details = Exam_detail::where(array('grouping_id' => $id2))->first();
        if ($details != null){
            Notify::error('No se puede eliminar este registro, porque tiene asosiados','Error!!');
            return redirect('examenes/' . $examen->sucursal_id .'/'. $examen->id);
        }else{
            Grouping::destroy($id2);
            Notify::warning('Registro eliminado correctamente','Eliminado!!');
            return redirect('examenes/' . $examen->sucursal_id .'/'. $examen->id);
        }
    }

    /**
     * Elimina valores de referencia de los detalles de examenes.
     *
     * @param  int  $id, $id2, $id3
     * @return \Illuminate\Http\Response
     */
    public function destroy_reference($id, $id2, $id3)
    {

        Reference_value::destroy($id3);
        Notify::warning('Registro eliminado correctamente','Eliminado!!');
        return view('examen.reference_value.index', ['detail' => Exam_detail::find($id2), 'examen' => Exam::find($id), 'references'=> Reference_value::where(array('exam_detail_id' => $id2))->get()]);
    }

}
