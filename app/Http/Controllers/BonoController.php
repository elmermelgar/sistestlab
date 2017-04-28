<?php

namespace App\Http\Controllers;

use App\Bono;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class BonoController extends Controller
{

    /**
     * BonoController constructor.
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
        Notify::info('Para aplicar bonos dirijasé al perfil del recolector a quien quiera bonificar.');
        return view('bono.index', ['bonos' => Bono::all()]);
    }

    /**
     * Retorna el formulario para crear un nuevo bonos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('bono.edit', ['bono' => null]);
    }

    /**
     * Retorna el formulario para editar un bono
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($bono = Bono::find($id)) {
            return view('bono.edit',['bono'=>$bono]);
        }
        return abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        if ($request->id && $bono = Bono::find($request->id)) {
            try{
                $bono->delete();
                Notify::info('Se eliminó el bono');
                return redirect()->action('BonoController@index');
            }catch (QueryException $e){
                Notify::error('El bono ha sido aplicado y no puede eliminarse');
                return back();
            }
        }
        Notify::error('No se ha eliminado el bono');
        return back();
    }

    /**
     * Almacena un bono
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if ($request->id && $bono = Bono::find($request->id)) {
            $bono->update($request->all());
        } else {
            $bono=Bono::create($request->all());
        }
        Notify::success('El bono se guardo correctamente');
        return redirect()->action('BonoController@index');
    }
}
