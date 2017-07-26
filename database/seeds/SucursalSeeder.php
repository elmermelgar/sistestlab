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
        $san_salvador->direccion='Calle San Antonio Abad. Centro Comercial San Luis Local 1-C. San Salvador';
        $san_salvador->telefono='22222222';
        $san_salvador->save();

        $apastepeque=new Sucursal();
        $apastepeque->name='apastepeque';
        $apastepeque->display_name='Apastepeque';
        $apastepeque->direccion='Apastepeque';
        $apastepeque->telefono='22222222';
        $apastepeque->save();

        $santa_clara=new Sucursal();
        $santa_clara->name='santa_clara';
        $santa_clara->display_name='Santa Clara';
        $santa_clara->direccion='Santa Clara';
        $santa_clara->telefono='22222222';
        $santa_clara->save();

        $cliente_san_salvador=new \App\Cliente();
        $cliente_san_salvador->persona_juridica=true;
        $cliente_san_salvador->centro_origen=true;
        $cliente_san_salvador->razon_social='TestLab S.A. de C.V. (San Salvador)';
        $cliente_san_salvador->nit='10010105811024';
        $cliente_san_salvador->nrc='2393604';
        $cliente_san_salvador->telefono='22222222';
        $cliente_san_salvador->giro='Servicios de analisis y estudios de diagnosticos';
        $cliente_san_salvador->descripcion='Sucursal San Salvador';
        $cliente_san_salvador->save();

        $cliente_apastepeque=new \App\Cliente();
        $cliente_apastepeque->persona_juridica=true;
        $cliente_apastepeque->centro_origen=true;
        $cliente_apastepeque->razon_social='TestLab S.A. de C.V. (Apastepeque)';
        $cliente_apastepeque->nit='10010105811024';
        $cliente_apastepeque->nrc='2393604';
        $cliente_apastepeque->telefono='22222222';
        $cliente_apastepeque->descripcion='Sucursal Apastepeque';
        $cliente_apastepeque->save();

        $cliente_santa_clara=new \App\Cliente();
        $cliente_santa_clara->persona_juridica=true;
        $cliente_santa_clara->centro_origen=true;
        $cliente_santa_clara->razon_social='TestLab S.A. de C.V. (Santa Clara)';
        $cliente_santa_clara->nit='10010105811024';
        $cliente_santa_clara->nrc='2393604';
        $cliente_santa_clara->telefono='22222222';
        $cliente_santa_clara->descripcion='Sucursal Santa Clara';
        $cliente_santa_clara->save();

    }
}
