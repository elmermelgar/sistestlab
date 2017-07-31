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
                'name' => 'admin_bonos',
                'display_name' => 'Administrar Bonos',
                'description' => 'Registra y elimina cantidades de bonos'
            ],
            [
                'name' => 'admin_niveles',
                'display_name' => 'Administrar Niveles de Ganancia',
                'description' => 'Registra y elimina niveles de ganancia'
            ],
            [
                'name' => 'admin_recolectores',
                'display_name' => 'Administrar Recolectores',
                'description' => 'Registra a recolectores de centros de origen'
            ],
            [
                'name' => 'facturar',
                'display_name' => 'Facturar',
                'description' => 'Registra facturas en la sucursal correspondiente'
            ],
            [
                'name' => 'credito_fiscal',
                'display_name' => 'Crédito Fiscal',
                'description' => 'Otorga créditos fiscales'
            ],
            [
                'name' => 'admin_perfiles',
                'display_name' => 'Administrar Perfiles',
                'description' => 'Registra y modifica los perfiles de examenes'
            ],
            [
                'name' => 'admin_examenes',
                'display_name' => 'Administrar Exámenes',
                'description' => 'Registra y modifica exámenes'
            ],
            [
                'name' => 'admin_inventario',
                'display_name' => 'Administrar Inventario',
                'description' => 'Registra y modifica activos. Realizar cargar y descargas de inventario'
            ]
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }

    }
}
