<?php

use Faker\Generator as Faker;

$proveedores = \App\Proveedor::pluck('id')->all();

$factory->define(\App\Activo::class, function (Faker $faker) use ($proveedores) {
    return [
        'proveedor_id' => $faker->randomElement($proveedores),
        'nombre' => $faker->word,
        'tipo' => $faker->randomElement(['recurso', 'recurso', 'recurso', 'equipo']),
        'marca' => $faker->word,
        'modelo' => $faker->company,
        'serie' => $faker->randomNumber(9, true),
        'unidades' => $faker->randomElement(['ml', 'l', 'mg', 'g', 'lb', 'm', 'cm', 'mm', 'oz', 'gl', 'unidad', 'm2', 'm3']),
        'observacion' => $faker->sentence('4')
    ];
});
