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
        'dui' => $faker->randomNumber(9),
        'nit' => $faker->randomNumber(9) . $faker->randomNumber(5),
        'activo' => true,
    ];
});

$factory->define(App\Cliente::class, function (Faker\Generator $faker) {

    $juridica = $faker->boolean;
    return [
        'persona_juridica' => $juridica,
        'centro_origen' => $juridica && $faker->boolean,
        'razon_social' => $faker->name,
        'dui' => $faker->randomNumber(9),
        'nit' => $faker->randomNumber(9) . $faker->randomNumber(5),
        'telefono' => $faker->randomNumber(8),
        'descripcion' => $faker->sentence(3),
    ];
});

$factory->define(App\Paciente::class, function (Faker\Generator $faker) {

    return [
        'dui' => $faker->randomNumber(9),
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'telefono' => $faker->randomNumber(8),
        'fecha_nacimiento' => $faker->date('Y-m-d', 'now'),
        'sexo' => $faker->randomElement(['M', 'F']),
    ];
});
