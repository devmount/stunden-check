<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\User;
use App\Models\Position;
use App\Models\Excemption;

class TestDataSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// get admin account
		$account = Account::find(1);
		$user = User::find(1);

		// handle missing admin account
		if (!$account || !$user) {
			$this->call([AdminSeeder::class]);
			$account = Account::find(1);
			$user = User::find(1);
		}

		// create positions for admin user
		Position::factory()
			->count(8)
			->for($user)
			->create();

		// create excemptions for admin user
		Excemption::factory()
			->count(2)
			->for($user)
			->create();

		// create corresponding admin user
		$partner = User::factory()
			->state([
				'firstname' => 'Beta',
				'lastname' => 'Tester',
				'email' => 'test@example.com',
				'password' => Hash::make(Str::random(12)),
				'is_admin' => false,
				'created_at' => now()
			])
			->for($account)
			->create();
	
		// create positions for admin user
		Position::factory()
			->count(3)
			->for($partner)
			->create();

		// create 30 active random additional accounts
		Account::factory()
			->count(30)
			->has(
				User::factory()
					->count(2)
					->has(Position::factory()->count(8))
					->has(Excemption::factory()->count(2))
			)
			->create();

		// create 10 archived random additional accounts
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
