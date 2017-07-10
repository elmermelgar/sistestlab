<?php

use Illuminate\Database\Seeder;

class ProtozoariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proto1 = new \App\Protozoarios();
        $proto1->name = 'Ninguno';
        $proto1->save();

        $proto2 = new \App\Protozoarios();
        $proto2->name = 'Quistes';
        $proto2->save();

        $proto3 = new \App\Protozoarios();
        $proto3->name = 'Activos';
        $proto3->save();
    }
}
