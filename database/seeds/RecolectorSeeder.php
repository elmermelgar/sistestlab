<?php

use Illuminate\Database\Seeder;

class RecolectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Recolector::class, 10)->create();
    }
}
