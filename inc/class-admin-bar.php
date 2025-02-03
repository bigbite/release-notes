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

		$version        = get_post_meta( $latest_release->ID, 'version', true );
		$version_object = get_post_meta( $latest_release->ID, 'version_object', true );
		$base_url       = admin_url( 'admin.php?page=release-notes' );

		$version_string = '0.0.0';
		$is_pre_release = false;

		if ( ! empty( $version ) ) {
			$version_string = $version;
			$is_pre_release = get_post_meta( get_the_ID(), 'is_pre_release', true );
		} elseif ( ! empty( $version_object ) ) {
			$version_string = sprintf(
				'%d.%d.%d%s%s',
				$version_object['major'],
				$version_object['minor'],
				$version_object['patch'],
				$version_object['prerelease'],
				$version_object['prerelease'] !== '' ? '.' . $version_object['prerelease_version'] : ''
			);

			$is_pre_release = $version_object['prerelease'] !== '';
		}

		$wp_admin_bar->add_node( [
			'id'     => 'release-note-version',
			'title'  => sprintf( 'Version %s', $version_string ),
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
