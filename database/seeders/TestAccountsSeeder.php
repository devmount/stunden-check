<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;
use App\Models\Position;
use App\Models\Excemption;

class TestAccountsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// create 30 active random test accounts
		Account::factory()
			->count(30)
			->has(
				User::factory()
					->count(2)
					->has(Position::factory()->count(8))
					->has(Excemption::factory()->count(2))
			)
			->create();

		// create 10 archived random test accounts
		Account::factory()
			->count(10)
			->has(
				User::factory()
					->count(2)
					->has(Position::factory()->count(8))
					->has(Excemption::factory()->count(2))
			)
			->archived()
			->create();
	}
}
