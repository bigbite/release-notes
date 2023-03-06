<?php

if ( ! function_exists( 'release_notes_render_mardown_parser' ) ) {
	function release_notes_render_mardown_parser() {
		return;
	}
}

/**
 * Registers the `twoyou/table` block on the server.
 */
function register_release_notes_mardown_parser() {
	register_block_type(
		__DIR__,
		array(
			'render_callback' => 'release_notes_render_mardown_parser',
		)
	);
}
add_action( 'init', 'register_release_notes_mardown_parser' );
