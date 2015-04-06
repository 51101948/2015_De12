<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GDMGDriver extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('g_driver', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user_id')
				->references('user_id')->on('user')
				->onDelete('cascade');
			$table->string('token');
			$table->date('expired_date');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('g_driver');
	}

}
