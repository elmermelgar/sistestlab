<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
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
     * Muestra el formulario crear un rol
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('role.edit', ['role' => null]);
    }

    /**
     * Muestra el rol especificado
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($role = Role::find($id)) {
            return view('role.show', ['role' => $role,'perms'=>Permission::all()]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Muestra el formulario para actualizar un rol
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($role = Role::find($id)) {
            return view('role.edit', ['role' => $role,'edit'=>true]);
        }
        return response()->view('errors.404', [], 404);
    }

    /**
     * Almacena la informacio de un rol
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->id&&$role = Role::find($request->id)) {
            $role->update($request->except(['id', '_token']));
        } else {
            Role::create($request->except(['id', '_token']));
        }
        return redirect('roles');
    }

    /**
     * Recibe los permisos a asignar
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPerms(Request $request)
    {
        if ($role = Role::find($request->input('id'))) {
            if($role->name=='admin'){
                return redirect()->back();
            }
            if ($perms = $request->input('perms')) {
                $this->assignPerms($perms, $role);
            } else {
                $this->removePerms($role);
            }
        }
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
