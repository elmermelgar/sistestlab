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
        'precio' => $faker->randomFloat(2, 1, 100),
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

$factory->define(App\Recolector::class, function (Faker\Generator $faker) {

    return [
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'dui' => $faker->randomNumber(9, true),
        'nit' => $faker->randomNumber(9, true) . $faker->randomNumber(5, true),
        'activo' => true,
    ];
});

$factory->define(App\Customer::class, function (Faker\Generator $faker) {

    $juridica = $faker->boolean;
    $sucursales = \App\Sucursal::pluck('id')->all();
    return [
        'sucursal_id' => $faker->randomElement($sucursales),
        'identity_document' => $faker->randomNumber(9, true),
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName,
        'phone_number' => $faker->randomNumber(8, true),
        'address' => $faker->sentence(6),
        'juridical_person' => $juridica,
        'origin_center' => $juridica && $faker->boolean,
        'trade_name' => $faker->sentence(1),
        'nit' => $faker->randomNumber(9, true) . $faker->randomNumber(5, true),
        'comment' => $faker->sentence(3),
    ];
});

$factory->define(App\Patient::class, function (Faker\Generator $faker) {

    $sucursales = \App\Sucursal::pluck('id')->all();
    return [
        'sucursal_id' => $faker->randomElement($sucursales),
        'identity_document' => $faker->randomNumber(9, true),
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName,
        'phone_number' => $faker->randomNumber(8, true),
        'birth_date' => $faker->date('Y-m-d', 'now'),
        'sex' => $faker->randomElement(['M', 'F']),
    ];
});
