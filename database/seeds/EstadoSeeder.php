<?php

use Illuminate\Database\Seeder;
use App\Estado;
use App\Sample;
use App\Category;

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

        $sample1=new Sample();
        $sample1->name='heces';
        $sample1->display_name='Heces';
        $sample1->description='Heces';
        $sample1->save();

        $sample2=new Sample();
        $sample2->name='sangre';
        $sample2->display_name='Sangre';
        $sample2->description='Sangre';
        $sample2->save();

        $category1=new Category();
        $category1->name='Química';
        $category1->description='Química';
        $category1->save();

        $category2=new Category();
        $category2->name='Coprología';
        $category2->description='Coprología';
        $category2->save();

    }
}
