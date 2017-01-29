<?php

use App\Imagen;
use Illuminate\Database\Seeder;

class ImagenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testlab=New Imagen();
        $testlab->title='TestLab';
        $testlab->file_name='testlab.png';
        $testlab->description='Imagen por defecto';
        $testlab->default=true;
        $testlab->save();

        $sucursal=New Imagen();
        $sucursal->title='Sucursal';
        $sucursal->file_name='sucursal.png';
        $sucursal->description='Imagen para sucursales';
        $sucursal->save();
    }
}
