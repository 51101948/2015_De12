<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GDObjectTableSeeder extends Seeder {

	public function run()
	{
		DB::table('g_d_object')->truncate();
		$Objects = [
			['name'=>'Google Driver'],
			['name'=>'Drop Box']
		];

		foreach ($Objects as $Object) {
			# code...
			GDObject::create($Object);
		}
	}

}