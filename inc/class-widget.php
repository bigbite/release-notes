<?php

namespace Big_Bite\release_notes;

use WP_Query;

/**
 * WP Dashboard Widget
 */
class Widget {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'register_widget' ] );
	}

	/**
	 * Register wp dashboard widget and re-order it.
	 *
	 * @return void
	 */
	public function register_widget(): void {
		global $wp_meta_boxes;

		if ( ! ReleaseNote::get_latest() ) {
			return;
		}

		wp_add_dashboard_widget(
			'release_notes_widget',
			'Whats Changed?',
			[ $this, 'render_widget' ],
		);

		// force the widget to be at the top.
		$dashboard   = $wp_meta_boxes['dashboard']['normal']['core'];
		$main_widget = [ 'release_notes_widget' => $dashboard['release_notes_widget'] ];
		unset( $dashboard['release_notes_widget'] );

		$wp_meta_boxes['dashboard']['normal']['core'] = array_merge( $main_widget, $dashboard ); // phpcs:ignore
	}

	/**
	 * Render WP widget
	 *
	 * @return void
	 */
	public function render_widget(): void {
		// get latest post.
		$latest_query = new WP_Query( [
			'post_type'      => 'release-note',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
		] );

		if ( $latest_query->have_posts() ) {
			while ( $latest_query->have_posts() ) {
				$latest_query->the_post();
				require_once __DIR__ . '/views/release-notes-widget.php';
			}
		}
	}
}
