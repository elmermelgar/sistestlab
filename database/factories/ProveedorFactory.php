<?php

use Faker\Generator as Faker;

$factory->define(\App\Proveedor::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'telefono' => $faker->randomNumber(8, true),
        'rubro' => $faker->sentence(1),
        'ubicacion' => $faker->address,
        'email' => $faker->email,
        'otros' => $faker->sentence(3)
    ];
});
