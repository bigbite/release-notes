<?php

namespace Big_Bite\release_notes;

/**
 * Archive Page handler.
 */
class Archive {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_page' ], 1 );
	}

	/**
	 * Register Archive Page.
	 *
	 * @return void
	 */
	public function register_page(): void {
		add_menu_page(
			'Release Notes',
			'Release Notes',
			'read',
			'release-notes',
			[ $this, 'render_page' ],
			'dashicons-megaphone',
			2
		);
	}

	/**
	 * Render Archive Page.
	 *
	 * @return void
	 */
	public function render_page(): void {
		if ( ! empty( $_GET['release-id'] ) ) { // phpcs:ignore
			require_once __DIR__ . '/views/release-notes-single.php';
			return;
		}

		require_once __DIR__ . '/views/release-notes-list.php';
	}
}
