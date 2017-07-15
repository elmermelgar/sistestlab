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
        $sucursal_ids = \App\Sucursal::pluck('id');
        factory(App\Exam::class, 100)->create()->each(function ($exam) use ($sucursal_ids) {
            $profile = \App\Profile::create([
                'enabled' => true,
                'type' => \App\Http\Controllers\ProfileController::EXAMEN,
                'name' => $exam->name,
                'display_name' => $exam->display_name,
                'description' => $exam->observation
            ]);
            $exam->profiles()->attach($profile);

            foreach ($sucursal_ids as $index => $sucursal_id) {
                $profile->sucursales()->attach($sucursal_id, ['price' => $exam->precio + mt_rand(0, 5)]);
            }
        });
    }
}
