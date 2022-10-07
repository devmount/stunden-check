<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'active' => true,
			'start' => fake()->dateTimeBetween('-2 years'),
			'target_hours' => 24,
			'separate_accounting' => fake()->numberBetween(0, 1),
		];
	}

	/**
	 * Indicate that the model's active flag is false.
	 *
	 * @return static
	 */
	public function archived()
	{
		return $this->state(function (array $attributes) {
			return [
				'active' => false,
				'archived_at' => fake()->dateTimeBetween('-2 weeks'),
			];
		});
	}
}
