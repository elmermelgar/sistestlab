<?php

use App\Account;
use App\Role;
use App\User;
use App\Sucursal;
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
        $san_salvador = Sucursal::where('name', 'san_salvador')->get()->first();

        $system_account = new Account();
        $system_account->id = 0;
        $system_account->sucursal_id = $san_salvador->id;
        $system_account->first_name = 'System';
        $system_account->phone_number = '00000000';
        $system_account->save();

        $nelson_account = Account::create([
            'sucursal_id' => $san_salvador->id,
            'first_name' => 'Nelson',
            'last_name' => 'Rivera',
            'phone_number' => '78688304'
        ]);
        $nelson = User::create([
            'account_id' => $nelson_account->id,
            'name' => $nelson_account->name(),
            'email' => 'rd12004@ues.edu.sv',
            'password' => bcrypt('asdasd'),
        ]);

        $elmer_account = Account::create([
            'sucursal_id' => $san_salvador->id,
            'first_name' => 'Elmer',
            'last_name' => 'Melgar',
            'phone_number' => '77777777'
        ]);
        $elmer = User::create([
            'account_id' => $elmer_account->id,
            'name' => $elmer_account->name(),
            'email' => 'elmermelgar999@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $admin = Role::where('name', 'admin')->first();

        $nelson->attachRole($admin);
        $elmer->attachRole($admin);

    }
}
