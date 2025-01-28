<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'province_id' => 9,
                'district_id' => 9,
                'city_id' => 654,
                'user_table_id' => 4,
                'full_name' => 'sabaratnam vinoth',
                'address' => 'kilinochchi',
                'email' => 'mydynamica09@gmail.com',
                'mobile_no' => 766859221,
                'nic_no' => '972662195V',
                'type' => 'Individual',
                'bussiness_name' => NULL,
                'bussiness_reg_no' => NULL,
                'bussiness_reg_document' => NULL,
                'status' => 'Active',
                'status_date' => '2025-01-28',
                'status_by' => 1,
                'cylinder_limit' => 1,
                'user_id' => NULL,
                'created_at' => '2025-01-28 07:56:45',
                'updated_at' => '2025-01-28 08:02:11',
                'deleted_at' => NULL,
        ];
    }
}
