<?php

use Faker\Generator as Faker;

$factory->define(\App\Customer::class, function (Faker $faker) {
    $juridica = $faker->boolean;
    $sucursales = \App\Sucursal::pluck('id')->all();
    return [
        'sucursal_id' => $faker->randomElement($sucursales),
        'identity_document' => $faker->randomNumber(9, true),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone_number' => $faker->randomNumber(8, true),
        'address' => $faker->address,
        'juridical_person' => $juridica,
        'origin_center' => $juridica && $faker->boolean,
        'trade_name' => $faker->sentence(1),
        'nit' => $faker->randomNumber(9, true) . $faker->randomNumber(5, true),
        'comment' => $faker->sentence(3),
    ];
});
