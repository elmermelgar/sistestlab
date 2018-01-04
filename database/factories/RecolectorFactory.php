<?php

use Faker\Generator as Faker;

$factory->define(App\Recolector::class, function (Faker $faker) {
    return [
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'dui' => $faker->randomNumber(9, true),
        'nit' => $faker->randomNumber(9, true) . $faker->randomNumber(5, true),
        'activo' => true,
    ];
});