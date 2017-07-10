<?php

use Illuminate\Database\Seeder;
use App\Estado;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = new Category();
        $category1->name = '(H)Hematología';
        $category1->description = '(H)Hematología';
        $category1->save();

        $category2 = new Category();
        $category2->name = '(I)Inmunología';
        $category2->description = '(I)Inmunología';
        $category2->save();

        $category3 = new Category();
        $category3->name = '(B)Bacteriología';
        $category3->description = '(B)Bacteriología';
        $category3->save();

        $category4 = new Category();
        $category4->name = '(P)Parasitología';
        $category4->description = '(P)Parasitología';
        $category4->save();

        $category5 = new Category();
        $category5->name = '(Q)Química';
        $category5->description = '(Q)Química';
        $category5->save();

        $category6 = new Category();
        $category6->name = '(S)Sangre';
        $category6->description = '(S)Sangre';
        $category6->save();

        $category7 = new Category();
        $category7->name = '(U)Uroanálisis';
        $category7->description = '(U)Uroanálisis';
        $category7->save();

        $category8 = new Category();
        $category8->name = '(BM)Biología Molecular';
        $category8->description = '(BM)Biología Molecular';
        $category8->save();

        $category9 = new Category();
        $category9->name = '(V)Virología';
        $category9->description = '(V)Virología';
        $category9->save();

        $category10 = new Category();
        $category10->name = '(DA)Drogas de Abuso';
        $category10->description = '(DA)Drogas de Abuso';
        $category10->save();

        $category10 = new Category();
        $category10->name = '(DT)Drogas Terapeutas';
        $category10->description = '(DT)Drogas Terapeutas';
        $category10->save();
    }
}
