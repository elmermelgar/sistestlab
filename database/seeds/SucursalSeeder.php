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

        $cliente_san_salvador=new \App\Cliente();
        $cliente_san_salvador->persona_juridica=true;
        $cliente_san_salvador->razon_social='TestLab S.A. de C.V.';
        $cliente_san_salvador->telefono='22222222';
        $cliente_san_salvador->giro='Servicios de analisis y estudios de diagnosticos';
        $cliente_san_salvador->descripcion='TestLab San Salvador';
        $cliente_san_salvador->save();

        $cliente_apastepeque=new \App\Cliente();
        $cliente_apastepeque->persona_juridica=true;
        $cliente_apastepeque->razon_social='TestLab S.A. de C.V.';
        $cliente_apastepeque->telefono='22222222';
        $cliente_apastepeque->descripcion='TestLab Apastepeque';
        $cliente_apastepeque->save();

        $cliente_santa_clara=new \App\Cliente();
        $cliente_santa_clara->persona_juridica=true;
        $cliente_santa_clara->razon_social='TestLab S.A. de C.V.';
        $cliente_santa_clara->telefono='22222222';
        $cliente_santa_clara->descripcion='TestLab Santa Clara';
        $cliente_santa_clara->save();

        $origen_san_salvador=new \App\CentroOrigen();
        $origen_san_salvador->cliente()->associate($cliente_san_salvador);
        $origen_san_salvador->name='testlab_san_salvador';
        $origen_san_salvador->display_name='TestLab San Salvador';
        $origen_san_salvador->email='labclinic.testlab@outlook.com';
        $origen_san_salvador->save();

        $origen_apastepeque=new \App\CentroOrigen();
        $origen_apastepeque->cliente()->associate($cliente_apastepeque);
        $origen_apastepeque->name='testlab_apastepeque';
        $origen_apastepeque->display_name='TestLab Apastepeque';
        $origen_apastepeque->email='testlab@testlab.com';
        $origen_apastepeque->save();

        $origen_santa_clara=new \App\CentroOrigen();
        $origen_santa_clara->cliente()->associate($cliente_santa_clara);
        $origen_santa_clara->name='testlab_santa_clara';
        $origen_santa_clara->display_name='TestLab Apastepeque';
        $origen_santa_clara->email='testlab@testlab.com';
        $origen_santa_clara->save();

    }
}
