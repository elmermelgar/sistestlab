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

        $permission = [
            [
                'name' => 'admin_permissions',
                'display_name' => 'Administrar Permisos',
                'description' => 'Crea, modifica y actualiza permisos asignables a usuarios'
            ],
            [
                'name' => 'admin_roles',
                'display_name' => 'Administrar Roles',
                'description' => 'Crea, modifica y actualiza roles asignables a usuarios'
            ],
            [
                'name' => 'admin_users',
                'display_name' => 'Administrar Usuarios',
                'description' => 'Registra, habilita, deshabilita, modifica y asigna role a usuarios'
            ],
            [
                'name' => 'admin_sucursales',
                'display_name' => 'Administrar Sucursales',
                'description' => 'Registra, modifica y asigna logos a sucursales'
            ],
            [
                'name' => 'admin_imagenes',
                'display_name' => 'Administrar Imagenes',
                'description' => 'Sube, modifica y elimina imagenes'
            ],
            [
                'name' => 'admin_caja',
                'display_name' => 'Administrar Caja',
                'description' => 'Abre y cierra la caja de una sucursal'
            ],
            [
                'name' => 'admin_clientes',
                'display_name' => 'Administrar Clientes',
                'description' => 'Registra y da de baja a clientes'
            ],
            [
                'name' => 'admin_pacientes',
                'display_name' => 'Administrar Pacientes',
                'description' => 'Registra y da de baja a pacientes'
            ],
            [
                'name' => 'admin_origenes',
                'display_name' => 'Administrar Centros de Origen',
                'description' => 'Registra y da de baja a centros de origenes'
            ]
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }

    }
}
