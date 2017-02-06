<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jleon\LaravelPnotify\Notify;

class RoleController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista los roles del sistema
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::all();
        return view('role.index', ['roles' => $roles]);
    }

    /**
     * Muestra el rol especificado
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($role = Role::find($id)) {
            return view('role.show', ['role' => $role, 'perms' => Permission::all()]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Muestra el formulario crear un rol
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('role.edit', ['role' => null]);
    }

    /**
     * Muestra el formulario para actualizar un rol
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($role = Role::find($id)) {
            if ($role->locked) {
                Notify::warning('Al modificarlo, las funciones de este rol podrían quedar fuera de contexto.',
                    'Se recomienda no modificar este rol')->sticky();
            }
            return view('role.edit', ['role' => $role, 'edit' => true]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Elimina un rol no bloqueado
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request){
        if($request->id&&$role=Role::find($request->id)){
            $role->users()->sync([]); // Delete relationship data
            $role->perms()->sync([]); // Delete relationship data
            $role->forceDelete();
            Notify::warning('Se ha eliminado el rol');
        }
        return redirect('roles');
    }

    /**
     * Almacena la informacio de un rol
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->id && $role = Role::find($request->id)) {
            if ($role->locked) {
                $role->update($request->except(['id', 'name', '_token']));
            } else {
                $role->update($request->except(['id', '_token']));
            }
        } else {
            $role = Role::create($request->except(['id', '_token']));
        }
        Notify::success('Rol guardado correctamente');
        return redirect('roles/' . $role->id);
    }

    /**
     * Recibe los permisos a asignar
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPerms(Request $request)
    {
        if ($role = Role::find($request->input('id'))) {
            if ($role->loked) {
                Notify::error('No se pueden asignar o remover permisos a este rol');
                return redirect()->back();
            }
            if ($perms = $request->input('perms')) {
                $this->assignPerms($perms, $role);
            } else {
                $this->removePerms($role);
            }
        }
        Notify::success('¡Permisos asignados correctamente!');
        return redirect()->back();
    }

    /**
     * Asigna permisos al rol especificado
     * @param $perms
     * @param Role $role
     */
    public function assignPerms($perms, Role $role)
    {
        $this->removePerms($role);
        foreach ($perms as $id) {
            $perm = Permission::find($id);
            if (!$role->hasPermission($perm->name)) {
                $role->attachPermission($perm);
            }
        }
    }

    /**
     * Remueve todos los permisos del rol especificado
     * Es más eficiente que el método proporcionado por Entrust
     * @param Role $role
     */
    public function removePerms(Role $role)
    {
        DB::table('permission_role')->where('role_id', $role->id)->delete();
    }
}
