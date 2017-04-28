<?php

namespace App\Http\Controllers;

use App\Nivel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class NivelController extends Controller
{

    /**
     * NivelController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra la lista de bonos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('nivel.index', ['niveles' => Nivel::all()]);
    }

    /**
     * Retorna el formulario para crear un nuevo bonos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('nivel.edit', ['nivel' => null]);
    }

    /**
     * Retorna el formulario para editar un bono
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($nivel = Nivel::find($id)) {
            return view('nivel.edit',['nivel'=>$nivel]);
        }
        return abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        if ($request->id && $nivel = Nivel::find($request->id)) {
            try{
                $nivel->delete();
                Notify::info('Se eliminó el nivel');
                return redirect()->action('NivelController@index');
            }catch (QueryException $e){
                Notify::error('El nivel ha sido aplicado en la facturación y no puede eliminarse');
                return back();
            }
        }
        Notify::error('No se ha eliminado el nivel');
        return back();
    }

    /**
     * Almacena un bono
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->merge(['porcentaje'=>$request->porcentaje/100]);
        if ($request->id && $nivel = Nivel::find($request->id)) {
            $nivel->update($request->all());
        } else {
            $nivel=Nivel::create($request->all());
        }
        Notify::success('El nivel se guardo correctamente');
        return redirect()->action('NivelController@index');
    }
}
