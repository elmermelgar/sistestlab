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
            ]




        ];

        foreach ($estados as $key => $estado) {
            Estado::create($estado);
        }

    }
}
