<?php

namespace Big_Bite\Release_Notes;

/**
 * Loader for handling assets.
 */
class Loader {
	const SCRIPT_NAME = 'release-notes-script';
	const STYLE_NAME  = 'release-notes-style';

	/**
	 * Initialise the hooks and filters.
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ], 1 );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ], 1 );
		require_once plugin_dir_path( __FILE__ ) . '/gutenberg/blocks/markdown-parser/index.php';
	}

	/**
	 * Enqueue any required assets for the block editor.
	 *
	 * @return void
	 */
	public function enqueue_block_editor_assets() : void {
		$plugin_name = basename( RELEASE_NOTES_DIR );

		wp_enqueue_script(
			self::SCRIPT_NAME,
			plugins_url( $plugin_name . '/dist/scripts/' . RELEASE_NOTES_EDITOR_JS, $plugin_name ),
			[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-plugins', 'wp-edit-post' ],
			(string) filemtime( RELEASE_NOTES_DIR . '/dist/scripts/' . RELEASE_NOTES_EDITOR_JS ),
			false
		);
	}

	/**
	 * Enqueue any required assets for the admin.
	 *
	 * @return void
	 */
	public function enqueue_admin_assets(): void {
		$plugin_name = basename( RELEASE_NOTES_DIR );

		wp_enqueue_style(
			sprintf( self::STYLE_NAME, 'dashboard' ),
			plugins_url( $plugin_name . '/dist/styles/' . RELEASE_NOTES_DASHBOARD_CSS, $plugin_name ),
			[],
			(string) filemtime( RELEASE_NOTES_DIR . '/dist/styles/' . RELEASE_NOTES_DASHBOARD_CSS )
		);
	}
}
