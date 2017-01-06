<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrar_permisos=new Permission();
        $administrar_permisos->name='admin_permissions';
        $administrar_permisos->display_name='Administrar Permisos';
        $administrar_permisos->description='Crea, modifica y actualiza permisos asignables a usuarios';
        $administrar_permisos->save();

        $administrar_roles=new Permission();
        $administrar_roles->name='admin_roles';
        $administrar_roles->display_name='Administrar Roles';
        $administrar_roles->description='Crea, modifica y actualiza role asignables a usuarios';
        $administrar_roles->save();

        $administrar_usuarios=new Permission();
        $administrar_usuarios->name='admin_users';
        $administrar_usuarios->display_name="Administrar Usuarios";
        $administrar_usuarios->description="Registra, habilita, deshabilita, modifica y asigna role a usuarios";
        $administrar_usuarios->save();


    }
}
