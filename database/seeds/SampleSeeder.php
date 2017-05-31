<?php

use Illuminate\Database\Seeder;
use App\Sample;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sample1 = new Sample();
        $sample1->name = 'heces';
        $sample1->display_name = 'Heces';
        $sample1->description = 'Heces';
        $sample1->save();

        $sample2 = new Sample();
        $sample2->name = 'sangre';
        $sample2->display_name = 'Sangre';
        $sample2->description = 'Sangre';
        $sample2->save();
    }
}
