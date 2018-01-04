<?php

use Faker\Generator as Faker;

$factory->define(\App\Patient::class, function (Faker $faker) {
    $sucursales = \App\Sucursal::pluck('id')->all();
    return [
        'sucursal_id' => $faker->randomElement($sucursales),
        'identity_document' => $faker->randomNumber(9, true),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone_number' => $faker->randomNumber(8, true),
        'birth_date' => $faker->date('Y-m-d', 'now'),
        'sex' => $faker->randomElement(['M', 'F']),
    ];
});
