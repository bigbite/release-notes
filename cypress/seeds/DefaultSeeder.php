<?php

use WP_Cypress\Seeder\Seeder;
use WP_Cypress\Fixtures;

class DefaultSeeder extends Seeder {
	public function run() {
		$this->call([
			'ReleaseNoteSeeder'
	]);
	}
}
