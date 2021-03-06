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
        $profesional = Role::where('name', 'profesional')->first();

        $administrar_permisos = Permission::where('name', 'admin_permissions')->first();
        $administrar_roles = Permission::where('name', 'admin_roles')->first();
        $administrar_usuarios = Permission::where('name', 'admin_users')->first();
        $administrar_sucursales = Permission::where('name', 'admin_sucursales')->first();
        $administrar_imagenes = Permission::where('name', 'admin_imagenes')->first();
        $administrar_caja = Permission::where('name', 'admin_caja')->first();
        $administrar_clientes = Permission::where('name', 'admin_clientes')->first();
        $administrar_pacientes = Permission::where('name', 'admin_pacientes')->first();
        $administrar_bonos = Permission::where('name', 'admin_bonos')->first();
        $administrar_niveles = Permission::where('name', 'admin_niveles')->first();
        $administrar_recolectores = Permission::where('name', 'admin_recolectores')->first();
        $administrar_perfiles = Permission::where('name', 'admin_perfiles')->first();
        $administrar_examenes = Permission::where('name', 'admin_examenes')->first();
        $administrar_inventario = Permission::where('name', 'admin_inventario')->first();
        $facturar = Permission::where('name', 'facturar')->first();
        $credito_fiscal = Permission::where('name', 'credito_fiscal')->first();
        $validar_examen = Permission::where('name', 'validar_examen')->first();
        $presupuesto_rapido = Permission::where('name', 'presupuesto_rapido')->first();

        $admin->attachPermission($administrar_permisos);
        $admin->attachPermission($administrar_roles);
        $admin->attachPermission($administrar_usuarios);
        $admin->attachPermission($administrar_sucursales);
        $admin->attachPermission($administrar_imagenes);
        $admin->attachPermission($administrar_caja);
        $admin->attachPermission($administrar_clientes);
        $admin->attachPermission($administrar_pacientes);
        $admin->attachPermission($administrar_bonos);
        $admin->attachPermission($administrar_niveles);
        $admin->attachPermission($administrar_recolectores);
        $admin->attachPermission($administrar_perfiles);
        $admin->attachPermission($administrar_examenes);
        $admin->attachPermission($administrar_inventario);
        $admin->attachPermission($facturar);
        $admin->attachPermission($credito_fiscal);
        $admin->attachPermission($presupuesto_rapido);

        $profesional->attachPermission($validar_examen);
    }
}