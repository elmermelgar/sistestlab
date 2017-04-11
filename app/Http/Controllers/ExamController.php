<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Exam;
use App\Exam_category;
use App\Grouping;
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
    public function index($id)
    {
//        dd(Exam::where(array('sucursal_id' => $id))->get());
        return view('examen.index', ['examnes' => Exam::where(array('sucursal_id' => $id))->get(), 'sucursal_id'=>$id, 'sucursal'=> Sucursal::find($id)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id1, $id2)
    {
//
        return view('examen.exam_detail.detail', ['examen' => Exam::find($id2), 'sucursal'=> Sucursal::find($id1)]);
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
        Notify::success('Examen registrado correctamente');
        return redirect('examenes/' . $request->sucursal_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
