<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OutletsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('outlets')->delete();
        
        \DB::table('outlets')->insert(array (
            0 => 
            array (
                'id' => 1,
                'province_id' => 9,
                'district_id' => 9,
                'city_id' => 654,
                'outlet_name' => 'SV Murugesu',
                'address' => 'jaffna',
                'manager_id' => NULL,
                'user_id' => 1,
                'created_at' => '2025-01-21 10:25:31',
                'updated_at' => '2025-01-21 10:25:31',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'province_id' => 9,
                'district_id' => 9,
                'city_id' => 654,
                'outlet_name' => 'Thenu Stores',
                'address' => 'Jaffna',
                'manager_id' => NULL,
                'user_id' => 1,
                'created_at' => '2025-01-21 10:25:56',
                'updated_at' => '2025-01-21 10:25:56',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'province_id' => 9,
                'district_id' => 13,
                'city_id' => 1029,
                'outlet_name' => 'Mahendran Stores',
                'address' => 'Kilinochchi',
                'manager_id' => NULL,
                'user_id' => 1,
                'created_at' => '2025-01-21 10:26:29',
                'updated_at' => '2025-01-21 10:26:29',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'province_id' => 9,
                'district_id' => 13,
                'city_id' => 1029,
                'outlet_name' => 'Ganesha Stores',
                'address' => 'Kilinochchi',
                'manager_id' => NULL,
                'user_id' => 1,
                'created_at' => '2025-01-21 10:27:06',
                'updated_at' => '2025-01-21 10:27:06',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}