<?php

use Illuminate\Database\Seeder;

class SpermogramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $esperm1 = new \App\Spermogram();
        $esperm1->name = '1 Hora';
        $esperm1->save();

        $esperm2 = new \App\Spermogram();
        $esperm2->name = '2 Horas';
        $esperm2->save();

        $esperm3 = new \App\Spermogram();
        $esperm3->name = '3 Horas';
        $esperm3->save();

        $esperm4 = new \App\Spermogram();
        $esperm4->name = '4 Horas';
        $esperm4->save();
    }
}
