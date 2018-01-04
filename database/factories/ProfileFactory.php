<?php

use Faker\Generator as Faker;

$factory->define(\App\Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'display_name' => $faker->sentence(3),
        'description' => $faker->text(255),
        'type' => $faker->numberBetween(0, 1),
        'enabled' => true,
    ];
});
