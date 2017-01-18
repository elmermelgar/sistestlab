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
        $san_salvador->save();
    }
}
