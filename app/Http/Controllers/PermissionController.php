<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Jleon\LaravelPnotify\Notify;

class PermissionController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista los permisos del sistema
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('permission.index', ['permissions' => $permissions]);
    }

    /**
     * Muestra el formulario para editar un permiso
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if($permission=Permission::find($id)){
            Notify::warning('Al modificarlo, la función de este permiso podría quedar fuera de contexto.',
                'Se recomienda no modificar este permiso')->sticky();
            return view('permission.edit',['permission'=>$permission]);
        }
        return response()->view('errors.404',[],404);
    }

    /**
     * Actualiza la descripcion de un permiso
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if($permission=Permission::find($request->id)){
            $permission->update($request->only(['display_name','description']));
        }
        return redirect('permisos');
    }

}
