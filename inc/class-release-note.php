<?php
namespace Big_Bite\Release_Notes;

/**
 * Helper for fetching latest release-note
 */
class ReleaseNote {
	/**
	 * Get latest release note
	 *
	 * @return boolean|\WP_Post
	 */
	public static function get_latest(): bool|\WP_Post {
		$args = [
			'numberposts' => 1,
			'post_type'   => 'release-note',
			'post_status' => 'publish',
		];

		$latest = get_posts( $args );

		if ( 0 === count( $latest ) ) {
			return false;
		}

		return $latest[0];
	}

	/**
	 * Get latest release note version.
	 *
	 * @return string
	 */
	public static function get_latest_version(): string {
		$latest = self::get_latest();
		return get_post_meta( $latest->ID, 'version', true );
	}

	/**
	 * Check if the user has already seen this release.
	 *
	 * @param int      $id - release id.
	 * @param int|bool $user_id - user id.
	 * @return bool
	 */
	public static function has_viewed( int $id, int|bool $user_id = false ): bool {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		$last_viewed_version = get_user_meta( $user_id, 'latest_version_viewed', true );

		if ( ! $last_viewed_version ) {
			return false;
		}

		$version = get_post_meta( $id, 'version', true );

		return version_compare( $last_viewed_version, $version, '>=' );
	}

	/**
	 * Set latest version as viewed in user meta.
	 *
	 * @param int      $id - release id.
	 * @param int|bool $user_id - user id.
	 * @return void
	 */
	public static function set_viewed( int $id, int|bool $user_id = false ): void {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		$version             = get_post_meta( $id, 'version', true );
		$last_viewed_version = get_user_meta( $user_id, 'latest_version_viewed', true );

		if ( ! $last_viewed_version || version_compare( $last_viewed_version, $version, '<' ) ) {
			update_user_meta( $user_id, 'latest_version_viewed', $version );
		}
	}
}
