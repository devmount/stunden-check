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
		// add column: note
		Schema::table('accounts', function (Blueprint $table) {
			$table->string('note')->nullable();
		});
		// second try for adding ondelete in last migration
		Schema::table('users', function($table) {
			$table->foreign('account_id')->onDelete('cascade')->change();
		});
		Schema::table('excemptions', function($table) {
			$table->foreign('user_id')->onDelete('cascade')->change();
		});
		Schema::table('positions', function($table) {
			$table->foreign('user_id')->onDelete('cascade')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('accounts', function (Blueprint $table) {
			$table->dropColumn('note');
		});
	}
};
