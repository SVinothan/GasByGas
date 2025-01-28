<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'height_in_meter' => fake()->randomFloat(2, 1, 100 ),
            'weight_in_kg' => fake()->randomFloat(2, 1, 100 ),
            'capacity' => fake()->randomFloat(2, 1, 100 ),
            'color' => '#'.fake()->randomNumber(6),
        ];
    }
}
