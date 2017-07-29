<?php

use App\Imagen;
use App\ImagenCategoria;
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
        $categoria_sucursal = New ImagenCategoria();
        $categoria_sucursal->name = 'categoria_sucursal';
        $categoria_sucursal->display_name = 'Sucursales';
        $categoria_sucursal->description = 'Imagenes para sucursales';
        $categoria_sucursal->save();

        $categoria_otra = New ImagenCategoria();
        $categoria_otra->name = 'categoria_otra';
        $categoria_otra->display_name = 'Otras';
        $categoria_otra->description = 'Otras imagenes';
        $categoria_otra->save();

        $testlab = New Imagen();
        $testlab->title = 'TestLab';
        $testlab->file_name = 'testlab.png';
        $testlab->description = 'Imagen por defecto';
        $testlab->default = true;
        $testlab->imagen_categoria_id = $categoria_sucursal->id;
        $testlab->save();

        $sucursal = New Imagen();
        $sucursal->title = 'Sucursal';
        $sucursal->file_name = 'sucursal.png';
        $sucursal->description = 'Imagen para sucursales';
        $sucursal->imagen_categoria_id = $categoria_sucursal->id;
        $sucursal->save();

        $inventrario = New Imagen();
        $inventrario->title = 'Inventario';
        $inventrario->file_name = 'inventario.png';
        $inventrario->description = 'Imagen para inventario';
        $inventrario->imagen_categoria_id = $categoria_otra->id;
        $inventrario->save();
    }
}
