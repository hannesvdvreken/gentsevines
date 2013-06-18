<?php

use Illuminate\Database\Migrations\Migration;

class CreateVinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vines', function($table)
		{
			$table->create();
			$table->timestamps();
			$table->string('id');
			$table->primary('id');

			$table->string('venue')->nullable();
			$table->string('user_id');
			$table->text('thumbnail');
			$table->text('description')->nullable();
			$table->text('video');
			$table->string('posted_at');
			$table->string('tag');
			$table->boolean('invalid')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vines');
	}

}