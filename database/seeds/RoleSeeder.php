<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'Administrador';
        $admin->description = 'Administrador del Sistema';
        $admin->locked = true;
        $admin->save();

        $profesional = new Role();
        $profesional->name = 'profesional';
        $profesional->display_name = 'Profesional';
        $profesional->description = 'Profesional';
        $profesional->locked = true;
        $profesional->save();

        $secretaria = new Role();
        $secretaria->name = 'secretaria';
        $secretaria->display_name = 'Secretaria';
        $secretaria->description = 'Secretaria';
        $secretaria->locked = true;
        $secretaria->save();

        $cliente = new Role();
        $cliente->name = 'cliente';
        $cliente->display_name = 'Cliente';
        $cliente->description = 'Cliente';
        $cliente->locked = true;
        $cliente->save();


        $administrar_permisos = Permission::where('name', 'admin_permissions')->first();
        $administrar_roles = Permission::where('name', 'admin_roles')->first();
        $administrar_usuarios = Permission::where('name', 'admin_users')->first();
        $administrar_sucursales = Permission::where('name', 'admin_sucursales')->first();
        $administrar_imagenes = Permission::where('name', 'admin_imagenes')->first();
        $administrar_caja = Permission::where('name', 'admin_caja')->first();

        $admin->attachPermission($administrar_permisos);
        $admin->attachPermission($administrar_roles);
        $admin->attachPermission($administrar_usuarios);
        $admin->attachPermission($administrar_sucursales);
        $admin->attachPermission($administrar_imagenes);
        $admin->attachPermission($administrar_caja);
    }
}