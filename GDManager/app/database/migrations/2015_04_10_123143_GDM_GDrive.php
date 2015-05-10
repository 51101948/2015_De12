<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GDMGDrive extends Migration {

	protected $fillable = array('user_id', 'token');

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('g_drive', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user_id')
				->references('user_id')->on('user')
				->onDelete('cascade');
			$table->string('token');
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
		Schema::drop('g_drive');
	}

}
