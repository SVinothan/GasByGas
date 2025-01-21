<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administrator',
                'role' => 'SuperAdmin',
                'employee_id' => NULL,
                'customer_id' => NULL,
                'is_active' => 1,
                'email' => 'admin@gmail.com',
                'email_verified_at' => '2025-01-21 10:07:41',
                'password' => '$2y$12$Gf2YjItx06rrJyWufikHd.bekB5TUyPDN466h37ruZxIbjaxfRqLm',
                'remember_token' => '1G2yPFPQO6',
                'created_at' => '2025-01-21 10:07:41',
                'updated_at' => '2025-01-21 10:07:41',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'sabaratnam vinothan',
                'role' => 'Manager',
                'employee_id' => '1',
                'customer_id' => NULL,
                'is_active' => 1,
                'email' => 'svinothan09@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$pIWKCR5pnrV4iL.vPqnK9eF7OlXH/pdUO2ocZ4nGcf8gJUQyXuHJa',
                'remember_token' => NULL,
                'created_at' => '2025-01-21 10:28:01',
                'updated_at' => '2025-01-21 10:28:01',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'J Jegapravin',
                'role' => 'OutletManager',
                'employee_id' => '2',
                'customer_id' => NULL,
                'is_active' => 1,
                'email' => 'jjpravin@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$LC435uOCz/LTBv8dMXnBBuoJdbR9EfpmCt2el6fFC.2gVC0Ldv906',
                'remember_token' => NULL,
                'created_at' => '2025-01-21 10:29:03',
                'updated_at' => '2025-01-21 10:29:03',
            ),
        ));
        
        
    }
}