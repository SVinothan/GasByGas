<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->insert([
            ['name' => 'SuperAdmin', 'guard_name' => 'web'],
            ['name' => 'OutletManager', 'guard_name' => 'web'],
            ['name' => 'Manager', 'guard_name' => 'web'],
            ['name' => 'DispatchOfficer', 'guard_name' => 'web'],
            ['name' => 'Customer', 'guard_name' => 'web'],
            
          
        ]);
    }
}
