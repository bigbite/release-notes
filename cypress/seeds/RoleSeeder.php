<?php

use WP_Cypress\Seeder\Seeder;
use WP_Cypress\Fixtures;

class RoleSeeder extends Seeder {
	public function run() {
		( new Fixtures\User( [
			'role'       => 'editor',
			'user_login' => 'editor',
		] ) )->create();

		( new Fixtures\User( [
			'role'       => 'admin',
			'user_login' => 'admin',
		] ) )->create();
	}
}