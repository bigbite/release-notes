<?php

namespace Big_Bite\release_notes;

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

		wp_enqueue_style(
			self::STYLE_NAME,
			plugins_url( $plugin_name . '/dist/styles/' . RELEASE_NOTES_EDITOR_CSS, $plugin_name ),
			[],
			(string) filemtime( RELEASE_NOTES_DIR . '/dist/styles/' . RELEASE_NOTES_EDITOR_CSS )
		);
	}
}
