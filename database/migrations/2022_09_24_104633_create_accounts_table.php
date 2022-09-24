<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->boolean('active')->default(true);
            $table->date('start');
            $table->decimal('targetHours', $precision = 8, $scale = 2);
            $table->boolean('separateAccounting')->default(false);
            $table->timestamps();
        });
        Schema::table('users', function($table) {
            $table->unsignedBigInteger('accountId');
            $table->foreign('accountId')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
        Schema::table('users', function($table) {
            $table->dropColumn('accountId');
        });
    }
};
