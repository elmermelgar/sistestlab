<?php

use Illuminate\Database\Seeder;

class ActivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $sucursal_ids = \App\Sucursal::pluck('id')->all();
        $estado = \App\Estado::where([
            ['name', 'en_uso'],
            ['tipo', 'activo'],
        ])->first();
        factory(App\Activo::class, 25)->create()->each(function ($activo) use ($faker, $sucursal_ids, $estado) {
            if ($activo->tipo == 'recurso') {
                $sucursal_selected = $faker->randomElements($sucursal_ids, 2);
                foreach ($sucursal_selected as $sucursal_id) {
                    \App\Inventario::create([
                        'sucursal_id' => $sucursal_id,
                        'activo_id' => $activo->id,
                        'estado_id' => $estado->id,
                        'ubicacion' => $faker->sentence(2),
                        'minimo' => $faker->numberBetween(5, 20),
                        'maximo' => $faker->numberBetween(50, 150)
                    ]);
                    $existencias = $faker->numberBetween(1, 3);
                    for ($i = 0; $i < $existencias; $i++) {
                        \App\Existencia::create([
                            'sucursal_id' => $sucursal_id,
                            'activo_id' => $activo->id,
                            'cantidad' => $faker->numberBetween(10, 100),
                            'precio' => $faker->randomFloat(2, 1, 999),
                            'lote' => $faker->randomNumber(9),
                            'fecha_adquisicion' => $faker->date('Y-m-d', 'now'),
                            'fecha_vencimiento' => $faker->date('Y-m-d')
                        ]);
                    }
                }
            }
        });
    }
}
