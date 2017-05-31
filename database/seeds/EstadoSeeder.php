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



        ];

        foreach ($estados as $key => $estado) {
            Estado::create($estado);
        }

    }
}
