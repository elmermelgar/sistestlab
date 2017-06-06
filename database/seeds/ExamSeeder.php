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
        $exams = factory(App\Exam::class, 100)->create()->each(function ($exam) {
            $profile = \App\Profile::create([
                'enabled' => true,
                'type' => \App\Http\Controllers\ProfileController::EXAMEN,
                'name' => $exam->name,
                'display_name' => $exam->display_name,
                'description' => $exam->observation
            ]);
            $exam->profiles()->attach($profile);
        });
    }
}
