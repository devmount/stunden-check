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
            $table->decimal('targetHours', $precision = 8, $scale = 2);
            $table->boolean('separateAccounting')->default('0');
            $table->timestamps();
        });
        Schema::table('users', function($table) {
            $table->unsignedBigInteger('accountId')->nullable();
            $table->foreign('accountId')->references('id')->on('accounts');
        });

        // insert admin account on create
        DB::table('accounts')->insert([
            'active' => true,
            'start' => now(),
            'targetHours' => 24,
            'separateAccounting' => false,
        ]);
        DB::table('users')->insert([
            'firstname' => 'Ada',
            'lastname' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Joh.3,16'),
            'isAdmin' => true,
            'accountId' => 1,
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
            $table->dropColumn('accountId');
        });
        Schema::dropIfExists('accounts');
    }
};
