<?php

use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado1=new Estado();
        $estado1->name='uso';
        $estado1->display_name='En uso';
        $estado1->tipo='activo';
        $estado1->save();

        $estado2=new Estado();
        $estado2->name='activo';
        $estado2->display_name='Activo';
        $estado2->tipo='examen';
        $estado2->save();

    }
}
