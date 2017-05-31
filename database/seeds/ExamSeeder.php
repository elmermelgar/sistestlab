<?php

use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = factory(App\Profile::class, 100)->create()->each(function($profile) {
            $profile->exams()->attach(factory(App\Exam::class, 3)->create());
        });
    }
}
