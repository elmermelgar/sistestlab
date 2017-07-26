<?php

namespace App\Http\Controllers;

use App\Activo;
use App\Estado;
use App\Exam;
use App\Exam_category;
use App\Exam_detail;
use App\Grouping;
use App\Profile;
use App\Reference_value;
use App\ReferenceType;
use App\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jleon\LaravelPnotify\Notify;

use Illuminate\Validation\ValidationException;
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
    public function index(Request $request)
    {
        return view('examen.index', ['examenes' => Exam::filter($request->get('display_name'))->paginate(20)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $examen = Exam::find($id);
        return view('examen.exam_detail.detail', [
            'examen' => $examen,
            'grupos' => Grouping::where(['exam_id' => $id])->get(),
            'activos' => Activo::all(),
            'details' => Exam_detail::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $estado = Estado::all();
        $samples = Sample::all();
        $categories = Exam_category::all();
        return view('examen.edit', [
            'examen' => null,
            'samples' => $samples,
            'estados' => $estado,
            'categories' => $categories
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
//        //Empieza la transacción
//        DB::beginTransaction();
//
//        try {

        $request->merge([
            'enabled' => true,
            'type' => ProfileController::EXAMEN,
            'description' => $request->observation
        ]);

        if ($request->id && $examen = Exam::find($request->id)) {
            $profile = Profile::where(['name' => $examen->name])->first();
            $profile->update($request->all());
            $examen->update($request->all());
        } else {
            $examen = Exam::create($request->all());
            $profile = Profile::create($request->all());
            $examen->profiles()->attach($profile);

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
        Notify::success('Guardado correctamente', 'Exito!!');
        return redirect('examenes/' . $examen->id);
    }

    /**
     * Guarda los agrupamientos de los examenes.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storegroup(Request $request)
    {
        $group = Grouping::create($request->all());

        Notify::success('Guardado correctamente', 'Exito!!');
        return redirect('examenes/' . $group->exam->id);
    }

    /**
     * Guarda los agrupamientos de los examenes.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storereference(Request $request)
    {
        $reference = Reference_value::create($request->all());

        Notify::success('Guardado correctamente', 'Exito!!');
        return redirect('examenes/' . $reference->exam_detail->grouping->exam->id . '/reference_value/' . $reference->exam_detail->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storedetail(Request $request)
    {
        if ($request->id && $detail = Exam_detail::find($request->id)) {
            $detail->update($request->all());
        } else {
            $detail = Exam_detail::create($request->all());
        }
        Notify::success('Guardado correctamente', 'Exito!!');
        return redirect('examenes/' . $detail->grouping->exam->id);
    }

    /**
     * Guardar las asociaciones de activos y examenes.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function store_examen_activo(Request $request)
    {
        if ($request->exam_id && $examen = Exam::find($request->exam_id)) {
            $examen->activos()->sync($request->activo_id);
        }

//        $activos = Activo::where(array('id' => $request->activo_id))->get();
//        $activos->exams()->sync($request->exam_id);
        Notify::success('Guardado correctamente', 'Exito!!');
        return redirect('examenes/' . $examen->id);
    }

    /**
     * Cargar vista para Editar el examen.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estado = Estado::all();
        $samples = Sample::all();
        $categories = Exam_category::all();
//        dd($examen = Exam::find($id));
        if ($examen = Exam::find($id)) {
            return view('examen.edit', [
                'examen' => $examen, 'samples' => $samples,
                'estados' => $estado,
                'categories' => $categories
            ]);
        }
        // return response()->view('errors.404', [], 404);
    }

    /**
     * Crear un nuevo Resultado.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create_detail($id)
    {
        return view('examen.exam_detail.edit', [
            'detail' => null,
            'examen' => Exam::find($id),
            'types' => ReferenceType::all(),
            'groupings' => Grouping::where(['exam_id' => $id])->get()
        ]);
    }

    /**
     * Asignar recursos al examen.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create_resources($id)
    {
        $examen = Exam::find($id);
        return view('examen.asignar_recursos.edit', [
            'examen_activo' => null,
            'examen' => $examen,
            'activos' => Activo::all()
        ]);
    }

    /**
     * Editar Resultados.
     *
     * @param  $exam_id
     * @param  $exam_detail_id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($exam_id, $exam_detail_id)
    {
        return view('examen.exam_detail.edit', [
            'detail' => Exam_detail::find($exam_detail_id),
            'examen' => Exam::find($exam_id),
            'types' => ReferenceType::all(),
            'groupings' => Grouping::where(['exam_id' => $exam_id])->get()
        ]);
    }

    /**
     * Ir a la vista de valores de referencia.
     *
     * @param $exam_id
     * @param $exam_detail_id
     * @return \Illuminate\Http\Response
     */
    public function reference_detail($exam_id, $exam_detail_id)
    {
        return view('examen.reference_value.index', [
            'detail' => Exam_detail::find($exam_detail_id),
            'examen' => Exam::find($exam_id),
            'references' => Reference_value::where(['exam_detail_id' => $exam_detail_id])->get()
        ]);
    }

    /**
     * Elimina detalles de examen.
     *
     * @param  int $exam_id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($exam_id, $exam_detail_id)
    {
        $examen = Exam::find($exam_id);
        $reference = Reference_value::where(['exam_detail_id' => $exam_detail_id])->first();
        $result=DB::table('results')->where([
            ['exam_detail_id', '=', $exam_detail_id],])->first();
        if ($result != null){
            Notify::error('No se puede eliminar este registro, porque tiene valores asosiados', 'Error!!');
        }else{
            if ($reference != null) {
                Notify::error('No se puede eliminar este registro, porque tiene asosiados', 'Error!!');
            } else {
                Exam_detail::destroy($exam_detail_id);
                Notify::warning('Registro eliminado correctamente', 'Eliminado!!');
            }
        }

        return redirect('examenes/' . $examen->id);
    }

    /**
     * Elimina grupos de examenes.
     *
     * @param  int $exam_id , $id2
     * @return \Illuminate\Http\Response
     */
    public function destroy_group($exam_id, $grouping_id)
    {
        $examen = Exam::find($exam_id);
        $details = Exam_detail::where(['grouping_id' => $grouping_id])->first();
        if ($details != null) {
            Notify::error('No se puede eliminar este registro, porque tiene asosiados', 'Error!!');
        } else {
            Grouping::destroy($grouping_id);
            Notify::warning('Registro eliminado correctamente', 'Eliminado!!');
        }
        return redirect('examenes/' . $examen->id);
    }

    /**
     * Elimina valores de referencia de los detalles de examenes.
     *
     * @param  $exam_id
     * @param  $exam_detail_id
     * @param  $reference_values_id
     * @return \Illuminate\Http\Response
     */
    public function destroy_reference($exam_id, $exam_detail_id, $reference_values_id)
    {

        Reference_value::destroy($reference_values_id);
        Notify::warning('Registro eliminado correctamente', 'Eliminado!!');
        return view('examen.reference_value.index', [
            'detail' => Exam_detail::find($exam_detail_id),
            'examen' => Exam::find($exam_id),
            'references' => Reference_value::where(['exam_detail_id' => $exam_detail_id])->get()
        ]);
    }

}
