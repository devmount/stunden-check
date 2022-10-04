<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'completed_at' => fake()->dateTimeBetween('-6 months'),
            'hours' => fake()->numberBetween(1, 5),
            'description' => fake()->sentence(),
            'category_id' => fake()->numberBetween(1, 5),
        ];
    }
}
