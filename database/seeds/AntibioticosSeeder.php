<?php

use Illuminate\Database\Seeder;
use App\Antibiotico;

class AntibioticosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $antibioticos = [
            [
                'name' => 'ACIDO NALIDIXICO',
            ],
            [
                'name' => 'AMIKASINA',
            ],
            [
                'name' => 'AMOXICILINA',
            ],
            [
                'name' => 'AMOXICILINA+ACIDO CLAVULAMICO',
            ],
            [
                'name' => 'AMPICILINA',
            ],
            [
                'name' => 'AMPICILINA+SULBACTAN',
            ],
            [
                'name' => 'AUGMENTIN',
            ],
            [
                'name' => 'AZITROMICINA',
            ],
            [
                'name' => 'CARBENICILINA',
            ],
            [
                'name' => 'CEFADROXIL',
            ],
            [
                'name' => 'CEFALOTINA',
            ],
            [
                'name' => 'CEFEPIME',
            ],
            [
                'name' => 'CEFIXIME',
            ],
            [
                'name' => 'CEFLACOR',
            ],
            [
                'name' => 'CEFOXITIN',
            ],
            [
                'name' => 'CEFTAZIDIME',
            ],
            [
                'name' => 'CEFTRIAZONE',
            ],
            [
                'name' => 'CEFUROXIME',
            ],
            [
                'name' => 'CIPROFLOXACINA',
            ],
            [
                'name' => 'CLINDAMICINA',
            ],
            [
                'name' => 'CLORANFENICOL',
            ],
            [
                'name' => 'DICLOXACILINA',
            ],
            [
                'name' => 'DURACEF',
            ],
            [
                'name' => 'ERITROMICINA',
            ],
            [
                'name' => 'FOSFOCIL',
            ],
            [
                'name' => 'GENTAMICINA',
            ],
            [
                'name' => 'IMIPIMEN',
            ],
            [
                'name' => 'KANAMICINA',
            ],
            [
                'name' => 'LEVOFLOXACINA',
            ],
            [
                'name' => 'MANDELATOS',
            ],
            [
                'name' => 'METICILINA',
            ],
            [
                'name' => 'NEOMICINA',
            ],
            [
                'name' => 'NETROMICINA',
            ],
            [
                'name' => 'NITROFURANTOINA',
            ],
            [
                'name' => 'NITROFURAZONA',
            ],
            [
                'name' => 'NORFLOXACINA',
            ],
            [
                'name' => 'PENICILINA',
            ],
            [
                'name' => 'ROCEPHIN',
            ],
            [
                'name' => 'STREPTOMICINA',
            ],
            [
                'name' => 'SULFISOXASOL',
            ],
            [
                'name' => 'TETRACICLINA',
            ],
            [
                'name' => 'TOBRAMICINA',
            ],
            [
                'name' => 'TRIMETROPIRM SULFAMETAZOLE',
            ],
            [
                'name' => 'VANCOMICINA',
            ],
            [
                'name' => 'CEFTRIZXONA',
            ],
            [
                'name' => 'CO-TRIMAZOLE',
            ],
            [
                'name' => 'FOSFOMICINA',
            ],
            [
                'name' => 'MOXIFLOXACINA',
            ],
            [
                'name' => 'OFLOXACINA',
            ],
            [
                'name' => 'OXACILINA',
            ],
            [
                'name' => 'RIFAMPICINA',
            ]

        ];

        foreach ($antibioticos as $key => $antibiotico) {
            Antibiotico::create($antibiotico);
        }
    }
}
