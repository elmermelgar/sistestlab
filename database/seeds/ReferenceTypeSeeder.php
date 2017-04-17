<?php

use Illuminate\Database\Seeder;
use App\ReferenceType;


class ReferenceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rf1=new ReferenceType();
        $rf1->name='ninguno';
        $rf1->display_name='Sin Valor de Referencia';
        $rf1->save();

        $rf2=new ReferenceType();
        $rf2->name='default';
        $rf2->display_name='Normal';
        $rf2->save();

        $rf3=new ReferenceType();
        $rf3->name='protozoarios';
        $rf3->display_name='Protozoarios';
        $rf3->save();

        $rf4=new ReferenceType();
        $rf4->name='espermograma';
        $rf4->display_name='Espermograma';
        $rf4->save();

    }
}
