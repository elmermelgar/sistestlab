<?php

use App\Bono;
use Illuminate\Database\Seeder;

class BonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bonos = [
            [
                'monto' => 1.50,
                'descripcion' => 'Bono de un dolar con cincuenta centavos',
            ],
            [
                'monto' => 3.00,
                'descripcion' => 'Bono de tres dolares',
            ],
        ];

        foreach ($bonos as $key => $value) {
            Bono::create($value);
        }
    }
}
