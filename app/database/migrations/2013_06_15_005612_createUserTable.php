<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->create();
			$table->timestamps();
			$table->string('id');
			$table->primary('id');

			$table->string('vine_session_id')->nullable();
			$table->string('email')->nullable();
			$table->integer('followers');
			$table->string('avatar');
			$table->string('username');
			$table->string('twitter')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}