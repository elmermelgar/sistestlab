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
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Administrador del sistema',
                'locked' => true,
            ],
            [
                'name' => 'profesional',
                'display_name' => 'Profesional',
                'description' => 'Profesional',
                'locked' => true,
            ],
            [
                'name' => 'secretaria',
                'display_name' => 'Secretaria',
                'description' => 'Secretaria',
                'locked' => true,
            ],
            [
                'name' => 'cliente',
                'display_name' => 'Cliente',
                'description' => 'Cliente',
                'locked' => true,
            ],
        ];

        foreach ($roles as $key => $value) {
            Role::create($value);
        }


        $admin = Role::where('name', 'admin')->first();

        $administrar_permisos = Permission::where('name', 'admin_permissions')->first();
        $administrar_roles = Permission::where('name', 'admin_roles')->first();
        $administrar_usuarios = Permission::where('name', 'admin_users')->first();
        $administrar_sucursales = Permission::where('name', 'admin_sucursales')->first();
        $administrar_imagenes = Permission::where('name', 'admin_imagenes')->first();
        $administrar_caja = Permission::where('name', 'admin_caja')->first();
        $administrar_clientes = Permission::where('name', 'admin_clientes')->first();

        $admin->attachPermission($administrar_permisos);
        $admin->attachPermission($administrar_roles);
        $admin->attachPermission($administrar_usuarios);
        $admin->attachPermission($administrar_sucursales);
        $admin->attachPermission($administrar_imagenes);
        $admin->attachPermission($administrar_caja);
        $admin->attachPermission($administrar_clientes);
    }
}