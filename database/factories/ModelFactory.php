<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Exam::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'display_name' => $faker->sentence(3),
        'observation' => $faker->text(255),
        'precio' => $faker->randomFloat(2, 0, 100),
        'sucursal_id' => $faker->numberBetween(1, 3),
        'sample_id' => $faker->numberBetween(1, 2),
        'exam_category_id' => $faker->numberBetween(1, 2),
        'estado_id' => $faker->numberBetween(1, 2),
    ];
});

$factory->define(App\Profile::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'display_name' => $faker->sentence(3),
        'description' => $faker->text(255),
        'type' => $faker->numberBetween(0, 1),
        'enabled' => true,
    ];
});
