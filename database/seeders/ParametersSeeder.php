<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\InputType;
use App\Enums\DateCycle;

class ParametersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// create app parameters
		DB::table('parameters')->insert(['key' => 'cycle_accounting', 'value' => DateCycle::Annual  ]);
		DB::table('parameters')->insert(['key' => 'start_accounting', 'value' => '2022-08-01'       ]);
		DB::table('parameters')->insert(['key' => 'target_hours',     'value' => 24                 ]);
		DB::table('parameters')->insert(['key' => 'cycle_reminder',   'value' => DateCycle::Monthly ]);
		DB::table('parameters')->insert(['key' => 'start_reminder',   'value' => 1                  ]);
	}
}
