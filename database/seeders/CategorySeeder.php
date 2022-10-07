<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// create basic categories
		DB::table('categories')->insert([
			'title' => 'Backen',
			'description' => 'Herstellung essbarer Leckereien'
		]);
		DB::table('categories')->insert([
			'title' => 'EDV',
			'description' => 'Website, Office, Nextcloud und weitere IT-Themen'
		]);
		DB::table('categories')->insert([
			'title' => 'Einkaufen',
			'description' => 'Bereitstellung benötigter Lebensmittel oder Materialien'
		]);
		DB::table('categories')->insert([
			'title' => 'Putzen',
			'description' => 'Reinigung von Räumen, Gegenständen oder dem Außenbereich'
		]);
		DB::table('categories')->insert([
			'title' => 'Reparatur',
			'description' => 'Instandsetzung beschädigter Gegenstände'
		]);
	}
}
