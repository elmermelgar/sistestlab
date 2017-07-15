<?php

use Illuminate\Database\Seeder;
use App\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $estados = [
            [
                'name' => 'uso',
                'display_name' => 'En uso',
                'tipo' => 'activo',
            ],
            [
                'name' => 'activo',
                'display_name' => 'Activo',
                'tipo' => 'examen',
            ],
            [
                'name' => 'habilitado',
                'display_name' => 'Habilitado',
                'tipo' => 'examen',
            ],
            [
                'name' => 'deshabilidato',
                'display_name' => 'Desabilitado',
                'tipo' => 'examen',
            ],
            [
                'name' => 'sin_facturar',
                'display_name' => 'Sin Facturar',
                'tipo' => 'examen_paciente',
            ],
            [
                'name' => 'facturado',
                'display_name' => 'Facturado',
                'tipo' => 'examen_paciente',
            ],
            [
                'name' => 'proceso',
                'display_name' => 'En Proceso',
                'tipo' => 'examen_paciente',
            ],
            [
                'name' => 'validado',
                'display_name' => 'Validado',
                'tipo' => 'examen_paciente',
            ],
            [
                'name' => 'denegado',
                'display_name' => 'Denegado',
                'tipo' => 'examen_paciente',
            ],
            [
                'name' => 'borrador',
                'display_name' => 'Borrador',
                'tipo' => 'factura',
            ],
            [
                'name' => 'abierta',
                'display_name' => 'Abierta',
                'tipo' => 'factura',
            ],
            [
                'name' => 'cerrada',
                'display_name' => 'Cerrada',
                'tipo' => 'factura',
            ],
            [
                'name' => 'anulada',
                'display_name' => 'Anulada',
                'tipo' => 'factura',
            ]

        ];

        foreach ($estados as $key => $estado) {
            Estado::create($estado);
        }

    }
}
