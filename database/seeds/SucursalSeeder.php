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
        $san_salvador = new Sucursal();
        $san_salvador->name = 'san_salvador';
        $san_salvador->display_name = 'San Salvador';
        $san_salvador->direccion = 'Calle San Antonio Abad. Centro Comercial San Luis Local 1-C. San Salvador';
        $san_salvador->telefono = '22255056';
        $san_salvador->save();

        $apastepeque = new Sucursal();
        $apastepeque->name = 'apastepeque';
        $apastepeque->display_name = 'Apastepeque';
        $apastepeque->direccion = 'Apastepeque';
        $apastepeque->telefono = '22222222';
        $apastepeque->save();

        $santa_clara = new Sucursal();
        $santa_clara->name = 'santa_clara';
        $santa_clara->display_name = 'Santa Clara';
        $santa_clara->direccion = 'Santa Clara';
        $santa_clara->telefono = '22222222';
        $santa_clara->save();

        $cliente_san_salvador = new \App\Customer();
        $cliente_san_salvador->sucursal_id = $san_salvador->id;
        $cliente_san_salvador->first_name = 'Yasmin Elizabeth';
        $cliente_san_salvador->last = 'Arévalo Lemus';
        $cliente_san_salvador->phone_number = '22255056';
        $cliente_san_salvador->juridical_person = false;
        $cliente_san_salvador->origin_center = true;
        $cliente_san_salvador->tradename = 'TestLab';
        $cliente_san_salvador->nit = '10010105811024';
        $cliente_san_salvador->nrc = '2393604';
        $cliente_san_salvador->business = 'Servicios de análisis y estudios de diagnóstico';
        $cliente_san_salvador->save();

    }
}
