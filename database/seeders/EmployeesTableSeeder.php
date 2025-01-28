<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employees')->delete();
        
        \DB::table('employees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'province_id' => NULL,
                'district_id' => NULL,
                'city_id' => NULL,
                'outlet_id' => NULL,
                'user_table_id' => 2,
                'full_name' => 'sabaratnam vinothan',
                'address' => 'kilinochchi',
                'email' => 'svinothan09@gmail.com',
                'mobile_no' => 771257152,
                'nic_no' => '972662194V',
                'role_id' => 3,
                'user_id' => 1,
                'created_at' => '2025-01-21 10:28:01',
                'updated_at' => '2025-01-21 10:28:01',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'province_id' => 9,
                'district_id' => 9,
                'city_id' => 654,
                'outlet_id' => 1,
                'user_table_id' => 3,
                'full_name' => 'J Jegapravin',
                'address' => 'jaffna',
                'email' => 'jjpravin@gmail.com',
                'mobile_no' => 771257153,
                'nic_no' => '982662194V',
                'role_id' => 2,
                'user_id' => 1,
                'created_at' => '2025-01-21 10:29:03',
                'updated_at' => '2025-01-21 10:29:03',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'province_id' => NULL,
                'district_id' => NULL,
                'city_id' => NULL,
                'outlet_id' => NULL,
                'user_table_id' => 5,
                'full_name' => 'sabaratnam vino',
                'address' => 'Kilinochchi',
                'email' => 'sabaratnamvinothan90@gmail.com',
                'mobile_no' => 776859221,
                'nic_no' => '972662196V',
                'role_id' => 4,
                'user_id' => 1,
                'created_at' => '2025-01-28 08:06:42',
                'updated_at' => '2025-01-28 08:06:42',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}