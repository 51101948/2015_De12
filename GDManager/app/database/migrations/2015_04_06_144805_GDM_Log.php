<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GDMLog extends Migration {

	protected $fillable = array('user_id', 'action_id', 'filename', 'from', 'to');

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('log', function(Blueprint $table)
		{
			$table->increments('log_id');
			$table->bigInteger('user_id')
				->references('user_id')->on('user')
				->onDelete('cascade');
			$table->bigInteger('action_id')
				->references('action_id')->on('action')
				->onDelete('cascade');
			$table->string('filename');
			$table->bigInteger('from')
				->references('id')->on('g_d_object')
				->onDelete('cascade');
			$table->bigInteger('to')
				->references('id')->on('g_d_object')
				->onDelete('cascade');
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
		Schema::drop('log');
	}

}
