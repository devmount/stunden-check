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
      Schema::table('users', function($table) {
				$table->foreign('account_id')->change()->onDelete('cascade');
			});
      Schema::table('excemptions', function($table) {
				$table->foreign('user_id')->change()->onDelete('cascade');
			});
      Schema::table('positions', function($table) {
				$table->foreign('user_id')->change()->onDelete('cascade');
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
