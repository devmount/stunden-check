<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default('1');
            $table->date('start');
            $table->decimal('target_hours', $precision = 8, $scale = 2);
            $table->boolean('separate_accounting')->default('0');
            $table->timestamps();
        });
        Schema::table('users', function($table) {
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        // insert admin account on create
        DB::table('accounts')->insert([
            'active' => true,
            'start' => now(),
            'target_hours' => 24,
            'separate_accounting' => false,
        ]);
        DB::table('users')->insert([
            'firstname' => 'Ada',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Joh.3,16'),
            'is_admin' => true,
            'account_id' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->truncate();
        Schema::table('users', function($table) {
            $table->dropColumn('account_id');
        });
        Schema::dropIfExists('accounts');
    }
};
