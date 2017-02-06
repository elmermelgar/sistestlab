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
        $administrar_permisos = new Permission();
        $administrar_permisos->name = 'admin_permissions';
        $administrar_permisos->display_name = 'Administrar Permisos';
        $administrar_permisos->description = 'Crea, modifica y actualiza permisos asignables a usuarios';
        $administrar_permisos->save();

        $administrar_roles = new Permission();
        $administrar_roles->name = 'admin_roles';
        $administrar_roles->display_name = 'Administrar Roles';
        $administrar_roles->description = 'Crea, modifica y actualiza role asignables a usuarios';
        $administrar_roles->save();

        $administrar_usuarios = new Permission();
        $administrar_usuarios->name = 'admin_users';
        $administrar_usuarios->display_name = "Administrar Usuarios";
        $administrar_usuarios->description = "Registra, habilita, deshabilita, modifica y asigna role a usuarios";
        $administrar_usuarios->save();

        $administrar_sucursales = new Permission();
        $administrar_sucursales->name = 'admin_sucursales';
        $administrar_sucursales->display_name = "Administrar Sucursales";
        $administrar_sucursales->description = "Registra, modifica y asigna logos a sucursales";
        $administrar_sucursales->save();

        $administrar_imagenes = new Permission();
        $administrar_imagenes->name = 'admin_imagenes';
        $administrar_imagenes->display_name = "Administrar Imágenes";
        $administrar_imagenes->description = "Sube, modifica y elimina imagenes";
        $administrar_imagenes->save();

        $administrar_caja = new Permission();
        $administrar_caja->name = 'admin_caja';
        $administrar_caja->display_name = 'Administrar Caja';
        $administrar_caja->description = 'Abre y cierra la caja de una sucursal';
        $administrar_caja->save();

    }
}
