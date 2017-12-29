<?php

namespace App\Http\Controllers;

use App\Antibiotico;
use App\Exam_detail;
use App\Register_antibiotico;
use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class AntibioticosController extends Controller
{
    /**
     * AntibioticosController constructor.
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
        return view('examen.antibioticos.index', ['antibioticos' => Antibiotico::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('examen.antibioticos.edit', ['antibiotico' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if ($request->id && $antibiotico = Antibiotico::find($request->id)) {
            try{
                $antibiotico->delete();
                Notify::info('Se eliminó el antibiótico');
                return redirect()->action('AntibioticosController@index');
            }catch (QueryException $e){
                Notify::error('El antibiótico ha sido utilizado y no puede eliminarse');
                return back();
            }
        }
        Notify::error('No se ha eliminado el antibiótico');
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->id && $antibiotico = Antibiotico::find($request->id)) {
            $antibiotico->update($request->all());
        } else {
            $antibiotico=Antibiotico::create($request->all());
        }
        Notify::success('El antibiótico se guardo correctamente');
        return redirect()->action('AntibioticosController@index');
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
        if ($antibiotico = Antibiotico::find($id)) {
            return view('examen.antibioticos.edit',['antibiotico'=>$antibiotico]);
        }
        return abort(404);
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
        Antibiotico::destroy($id);
        Notify::warning('Registro eliminado correctamente', 'Eliminado!!');
        return back();
    }
}
