<?php

use WP_Cypress\Seeder\Seeder;
use WP_Cypress\Fixtures;

class ReleaseNoteSeeder extends Seeder {
	public function run() {
		( new Fixtures\Post([
			'post_type' => 'release-note',
		]) )->create(10);
	}
}

