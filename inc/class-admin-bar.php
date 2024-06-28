<?php

namespace Big_Bite\Release_Notes;

/**
 * Class for managing the version shown in the admin bar
 */
class AdminBar {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_bar_menu', [ $this, 'register_link' ], PHP_INT_MAX );
	}

	/**
	 * Register the Version node in the admin bar
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar - admin bar
	 * @return void
	 */
	public function register_link( \WP_Admin_Bar $wp_admin_bar ): void {
		$latest_release = ReleaseNote::get_latest();

		if ( ! $latest_release ) {
			return;
		}

		$last_week    = strtotime( '-1 week' );
		$release_date = strtotime( $latest_release->post_date_gmt );

		$is_pre_release = get_post_meta( $latest_release->ID, 'is_pre_release', true );

		$version  = get_post_meta( $latest_release->ID, 'version', true );
		$base_url = admin_url( 'admin.php?page=release-notes' );

		$wp_admin_bar->add_node( [
			'id'     => 'release-note-version',
			'title'  => sprintf( 'Version %s', $version ),
			'href'   => sprintf( '%s&release-id=%d', $base_url, $latest_release->ID ),
			'parent' => 'top-secondary',
			'meta'   => [
				'class' => $is_pre_release ? 'release-note is-pre-release' : 'release-note',
			],
		] );

		$wp_admin_bar->add_node( [
			'id'     => 'release-note-all',
			'title'  => 'View all releases',
			'href'   => $base_url,
			'parent' => 'release-note-version',
		] );
	}
}
