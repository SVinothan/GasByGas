<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => '$2y$12$Gf2YjItx06rrJyWufikHd.bekB5TUyPDN466h37ruZxIbjaxfRqLm', //12345678
            'role' => 'SuperAdmin', 
        ]);

        // DB::table('roles')->insert([
        //     'name' => 'SuperAdmin',
        //     'guard_name' => 'web',
        // ]);

       
       
        $this->call(CitiesTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(RoleSeeder::class);

        $user=User::find(1);
        $user->assignRole('SuperAdmin');

    }
}
