<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nelson = new User();
        $nelson->name = 'Nelson';
        $nelson->surname = 'Rivera';
        $nelson->email = 'rd12004@ues.edu.sv';
        $nelson->password = bcrypt('asdasd');
        $nelson->save();

        $elmer= new User();
        $elmer->name='Elmer';
        $elmer->surname='Melgar';
        $elmer->email='elmermelgar999@gmail.com';
        $elmer->password=bcrypt('123456');
        $elmer->save();

    }
}
