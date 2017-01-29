<?php

use App\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $san_salvador=new Sucursal();
        $san_salvador->name='san_salvador';
        $san_salvador->display_name='San Salvador';
        $san_salvador->direccion='San Salvador';
        $san_salvador->save();

        $apastepeque=new Sucursal();
        $apastepeque->name='apastepeque';
        $apastepeque->display_name='Apastepeque';
        $apastepeque->direccion='Apastepeque';
        $apastepeque->save();

        $santa_clara=new Sucursal();
        $santa_clara->name='santa_clara';
        $santa_clara->display_name='Santa Clara';
        $santa_clara->direccion='Santa Clara';
        $santa_clara->save();

    }
}
