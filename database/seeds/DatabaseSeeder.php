<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ImagenSeeder::class);
        $this->call(SucursalSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BonoSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(ReferenceTypeSeeder::class);
        $this->call(SampleSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProtozoariosSeeder::class);
        $this->call(SpermogramSeeder::class);
    }
}
