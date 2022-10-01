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
            $table->boolean('active')->default('1');
            $table->date('start');
            $table->decimal('target_hours', $precision = 8, $scale = 2);
            $table->boolean('separate_accounting')->default('0');
            $table->date('archived_at')->nullable();
            $table->timestamps();
        });
        Schema::table('users', function($table) {
            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('account_id');
        });
        Schema::dropIfExists('accounts');
    }
};
