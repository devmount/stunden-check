<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        DB::table('accounts')->insert([
            'active' => true,
            'start' => now(),
            'target_hours' => 24,
            'separate_accounting' => false,
            'created_at' => now(),
        ]);

        // create corresponding user
        DB::table('users')->insert([
            'firstname' => 'Ada',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Joh.3,16'),
            'is_admin' => true,
            'created_at' => now(),
            'account_id' => 1,
        ]);
    }
}
