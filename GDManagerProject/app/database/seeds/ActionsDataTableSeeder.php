<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ActionsDataTableSeeder extends Seeder {

	public function run()
	{
		DB::table('action')->truncate();
		$actions=[
			[
			'action_name' => 'copy'],//copy
			[
			'action_name' => 'move'],//move
			[
			'action_name' => 'download'],//download
			[
			'action_name' => 'upload'],//upload
			[
			'action_name' => 'delete']//delete
		];

		foreach ($actions as $action) {
			# code...
			Action::create($action);
		}
	}

}