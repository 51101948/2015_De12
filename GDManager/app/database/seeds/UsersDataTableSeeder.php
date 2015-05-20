<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UsersDataTableSeeder extends Seeder {

	public function run()
	{
		DB::table('user')->truncate();
		$users=[
			[
				'user_name' => 'npvinhloc',
				'password' => Hash::make('123456'),
				'email' => 'npvinhloc@gmail.com'],
			[
				'user_name' => 'lamvu',
				'password' => Hash::make('123456'),
				'email' => 'huonglam@gmail.com'],
			[
				'user_name' => 'hoantran',
				'password' => Hash::make('123456'),
				'email' => 'hoantran@gmail.com'],
			[
				'user_name' => 'duybinh',
				'password' => Hash::make('123456'),
				'email' => 'duybinh@gmail.com']
		];

		foreach ($users as $user) {
			# code...
			User::create($user);
		}
	}

}