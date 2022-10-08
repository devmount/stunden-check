<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;
use App\Models\User;
use App\Models\Position;

class AdminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// create first admin account
		$account = Account::factory()
			->state([
				'active' => true,
				'start' => now(),
				'target_hours' => 24,
				'separate_accounting' => false,
				'created_at' => now(),
			])
			->create();

		// create corresponding admin user
		$user = User::factory()
			->state([
				'firstname' => 'App',
				'lastname' => 'Admin',
				'email' => 'admin@example.com',
				'password' => Hash::make('Joh.3,16'),
				'is_admin' => true,
				'created_at' => now()
			])
			->for($account)
			->create();;

		// create positions for admin user
		Position::factory()
			->count(8)
			->for($user)
			->create();
	}
}
