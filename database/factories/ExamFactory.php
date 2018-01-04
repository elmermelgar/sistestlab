<?php

use Faker\Generator as Faker;

$factory->define(\App\Exam::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'display_name' => $faker->sentence(3),
        'observation' => $faker->text(255),
        'precio' => $faker->randomFloat(2, 1, 100),
        'sample_id' => $faker->numberBetween(1, 2),
        'exam_category_id' => $faker->numberBetween(1, 2),
        'estado_id' => $faker->numberBetween(1, 2),
    ];
});
