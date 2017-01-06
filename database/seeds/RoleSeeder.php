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
        $admin=new Role();
        $admin->name='admin';
        $admin->display_name='Administrador';
        $admin->description='Administrador del Sistema';
        $admin->save();



        $administrar_permisos=Permission::where('name','admin_permissions')->first();
        $administrar_roles=Permission::where('name','admin_roles')->first();
        $administrar_usuarios=Permission::where('name','admin_users')->first();

        $admin->attachPermission($administrar_permisos);
        $admin->attachPermission($administrar_roles);
        $admin->attachPermission($administrar_usuarios);
    }
}