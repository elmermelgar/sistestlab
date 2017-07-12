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

        $sample3 = new Sample();
        $sample3->name = 'orina';
        $sample3->display_name = 'Orina';
        $sample3->description = 'Orina';
        $sample3->save();

        $sample4 = new Sample();
        $sample4->name = 'suero';
        $sample4->display_name = 'Suero';
        $sample4->description = 'Suero';
        $sample4->save();

        $sample5 = new Sample();
        $sample5->name = 'semen';
        $sample5->display_name = 'Semen';
        $sample5->description = 'Semen';
        $sample5->save();
    }
}
