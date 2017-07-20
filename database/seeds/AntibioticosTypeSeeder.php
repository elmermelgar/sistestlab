<?php

use Illuminate\Database\Seeder;

class AntibioticosTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rf1=new \App\Antibiotico_type();
        $rf1->name='Sensible';
        $rf1->save();

        $rf2=new \App\Antibiotico_type();
        $rf2->name='Intermedio';
        $rf2->save();

        $rf3=new \App\Antibiotico_type();
        $rf3->name='Resistente';
        $rf3->save();

    }
}
