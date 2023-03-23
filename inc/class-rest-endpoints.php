<?php

namespace Big_Bite\Release_Notes;

use League\CommonMark\GithubFlavoredMarkdownConverter;

/**
 * Class for managing the version shown in the admin bar
 */
class RestEndpoints {
	/**
	 * Initialise the hooks and filters.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'add_test_options' ] );
		add_action( 'rest_api_init', [ $this, 'register_route' ] );
	}

	/**
	 * add test options
	 */
	public function add_test_options() {
		add_option('release_notes_test_option');
	}

	/**
	 * Register the rest api routes
	 */
	public function register_route() {
		register_rest_route( 'release-notes/v1', '/new-release', [
			'methods'             => 'POST',
			'callback'            => [ $this, 'new_release' ],
			'permission_callback' => function () {
				return current_user_can( 'manage_options' );
			},
		] );
	}

	/**
	 * Create post when called from circle ci
	 */
	public function new_release( \WP_REST_Request $req ) {
		$params         = $req->get_params();
		$body           = $params['body'];
		$is_draft       = $params['isDraft'];
		$title          = $params['name'];
		$published_at   = $params['publishedAt'];
		$tag            = $params['tagName'];
		$is_pre_release = $params['isPrerelease'];

		if ( $is_draft ) {
			return;
		}

		$converter = new \League\CommonMark\GithubFlavoredMarkdownConverter([
			'html_input' => 'strip',
			'allow_unsafe_links' => false,
		]);

		$html = (string) $converter->convert( $body );

		$html = str_replace('"', '\"', $html);
		$html = str_replace("\n", '', $html);

		$attributes = wp_json_encode( [
			'html' => $html,
		] );

		$content = '<!-- wp:release-notes/markdown-parser ' . $attributes . ' /-->';
		wp_insert_post([
			'post_title'   => $title,
			'post_type'    => 'release-note',
			'post_content' => $content,
			'meta_input'   => [
				'release_date'   => explode('T', date('c', strtotime($published_at)))[0],
				'version'        => $tag,
				'is_pre_release' => $is_pre_release,
			]
		]);
		return;
	}
}
