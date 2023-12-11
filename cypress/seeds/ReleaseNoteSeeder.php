<?php

use WP_Cypress\Seeder\Seeder;
use WP_Cypress\Fixtures;

class ReleaseNoteSeeder extends Seeder {
	public function run() {

		$release_note_template = '<!-- wp:heading -->
				<h2 class="wp-block-heading">Overview</h2>
				<!-- /wp:heading -->

				<!-- wp:paragraph -->
				<p> %s </p>
				<!-- /wp:paragraph -->

				<!-- wp:heading -->
				<h2 class="wp-block-heading">Added</h2>
				<!-- /wp:heading -->

				<!-- wp:list -->
				<ul><!-- wp:list-item -->
				<li> %s </li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li> %s </li>
				<!-- /wp:list-item --></ul>
				<!-- /wp:list -->

				<!-- wp:heading -->
				<h2 class="wp-block-heading">Changed</h2>
				<!-- /wp:heading -->

				<!-- wp:list -->
				<ul><!-- wp:list-item -->
				<li> %s </li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li> %s </li>
				<!-- /wp:list-item --></ul>
				<!-- /wp:list -->

				<!-- wp:heading -->
				<h2 class="wp-block-heading">Fixed</h2>
				<!-- /wp:heading -->

				<!-- wp:list -->
				<ul><!-- wp:list-item -->
				<li> %s </li>
				<!-- /wp:list-item -->

				<!-- wp:list-item -->
				<li> %s </li>
				<!-- /wp:list-item --></ul>
				<!-- /wp:list -->';

		( new Fixtures\Post([
			'post_type' => 'release-note',
			'post_date' => date("Y-m-d H:i:s", strtotime("Nov 10, 2023 15:01:10")),
			'post_content' => sprintf(
				$release_note_template,
				$this->faker->realText( 100 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				'1.5.0'
			),
			'post_meta' => [
				'version' => '1.5.0',
				'release_date' => date("Y-m-d", strtotime("Nov 10, 2023")),
			]
		]))->create(1);

		( new Fixtures\Post([
			'post_type' => 'release-note',
			'post_date' => date("Y-m-d H:i:s", strtotime("Dec 04, 2023 14:22:32")),
			'post_content' => sprintf(
				$release_note_template,
				$this->faker->realText( 100 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				$this->faker->realText( 40 ),
				'1.6.0'
			),
			'post_meta' => [
				'version' => '1.6.0',
				'release_date' => date("Y-m-d", strtotime("Dec 04, 2023")),
			],
			
		]))->create(1);
	}
}

