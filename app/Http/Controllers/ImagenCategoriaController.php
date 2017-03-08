<?php

namespace App\Http\Controllers;

use App\ImagenCategoria;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class ImagenCategoriaController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra las categorias de imagenes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('imagen.categoria.index', ['categorias' => ImagenCategoria::all()]);
    }

    /**
     * Muestra el formulario para crear una categoria
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('imagen.categoria.edit', ['categoria' => null]);
    }

    /**
     * Muestra el formulario para editar la categoria
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('imagen.categoria.edit', ['categoria' => ImagenCategoria::find($id)]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        if ($request->id && $categoria = ImagenCategoria::find($request->id)) {
            try{
                $categoria->delete();
                Notify::info('Se eliminó la categoría');
                return redirect()->action('ImagenCategoriaController@index');
            }catch (QueryException $e){
                Notify::error('La categoría esta siendo usada y no puede eliminarse');
                return back();
            }
        }
        Notify::error('No se ha eliminado la categoría');
        return back();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if ($request->id && $categoria = ImagenCategoria::find($request->id)) {
            $categoria->update($request->all());
        } else {
            $categoria = ImagenCategoria::create($request->all());
        }
        Notify::success('La categoría se guardo correctamente');
        return redirect()->action('ImagenCategoriaController@index');
    }

}
