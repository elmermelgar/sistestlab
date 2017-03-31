<?php

namespace App\Http\Controllers;

use App\Estado;
use App\Exam;
use App\Exam_category;
use App\Sample;
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
    public function index()
    {
        return view('examen.index');
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
        return view('examen.edit', ['examen' => null, 'samples' => $samples, 'estados' => $estado, 'categories' => $categories]);
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
        return redirect()->action('HomeController@index');
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
