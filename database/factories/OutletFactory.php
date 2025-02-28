<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outlet>
 */
class OutletFactory extends Factory
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
            'outlet_name' => fake()->name(),
        ];
    }
}
