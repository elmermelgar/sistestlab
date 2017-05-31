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
        $category1->name = 'Química';
        $category1->description = 'Química';
        $category1->save();

        $category2 = new Category();
        $category2->name = 'Coprología';
        $category2->description = 'Coprología';
        $category2->save();

    }
}
