<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersDataTableSeeder');
		$this->call('ActionsDataTableSeeder');
		$this->call('GDObjectTableSeeder');
	}

}
