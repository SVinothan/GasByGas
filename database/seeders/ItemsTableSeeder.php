<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('items')->delete();
        
        \DB::table('items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Small Cylinder',
                'height_in_meter' => '0.50',
                'weight_in_kg' => '2.50',
                'capacity' => '0.00',
                'color' => '#2336c2',
                'user_id' => 1,
                'created_at' => '2025-01-21 10:21:10',
                'updated_at' => '2025-01-21 10:21:24',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Medium Cylinder',
                'height_in_meter' => '0.75',
                'weight_in_kg' => '5.00',
                'capacity' => '0.00',
                'color' => '#1d22c2',
                'user_id' => 1,
                'created_at' => '2025-01-21 10:21:56',
                'updated_at' => '2025-01-21 10:21:56',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Large Cylinder',
                'height_in_meter' => '1.00',
                'weight_in_kg' => '12.50',
                'capacity' => '0.00',
                'color' => '#0a2178',
                'user_id' => 1,
                'created_at' => '2025-01-21 10:22:28',
                'updated_at' => '2025-01-21 10:22:28',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Extra Large Cylinder',
                'height_in_meter' => '2.00',
                'weight_in_kg' => '20.00',
                'capacity' => '0.00',
                'color' => '#4172e3',
                'user_id' => 1,
                'created_at' => '2025-01-21 10:22:58',
                'updated_at' => '2025-01-21 10:22:58',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}