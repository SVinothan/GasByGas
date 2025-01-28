<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'province_id' => fake()->randomNumber(2),
            'district_id' => fake()->randomNumber(2),
            'city_id' => fake()->randomNumber(2),
            'outlet_id' => fake()->randomNumber(2),
            'full_name' => fake()->name(),
            'address' => fake()->city(),

        ];
    }
}
