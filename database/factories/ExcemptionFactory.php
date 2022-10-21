<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Excemption>
 */
class ExcemptionFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'start' => fake()->dateTimeInInterval('-1 month', '-3 days'),
			'end'   => fake()->dateTimeInInterval('-1 month', '+3 days'),
		];
	}
}
