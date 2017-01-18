<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $san_salvador=\App\Sucursal::where('name','san_salvador')->get()->first();

        $nelson = new User();
        $nelson->name = 'Nelson';
        $nelson->surname = 'Rivera';
        $nelson->email = 'rd12004@ues.edu.sv';
        $nelson->password = bcrypt('asdasd');
        $nelson->sucursal()->associate($san_salvador);
        $nelson->save();

        $elmer= new User();
        $elmer->name='Elmer';
        $elmer->surname='Melgar';
        $elmer->email='elmermelgar999@gmail.com';
        $elmer->password=bcrypt('123456');
        $elmer->sucursal()->associate($san_salvador);
        $elmer->save();

        $admin=Role::where('name','admin')->first();

        $nelson->attachRole($admin);
        $elmer->attachRole($admin);

    }
}
