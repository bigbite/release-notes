<?php
namespace Big_Bite\Release_Notes;

/**
 * Release Note Post Type
 */
class PostType {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_type' ], 0 );
		add_filter( 'allowed_block_types_all', [ $this, 'allow_post_types' ], PHP_INT_MAX, 2 );
		add_action( 'init', [ $this, 'register_meta' ] );
	}

	/**
	 * Register post type meta
	 *
	 * @return void
	 */
	public function register_meta(): void {
		register_post_meta(
			'release-note',
			'version_object',
			[
				'show_in_rest' => [
					'schema' => [
							'type'       => 'object',
							'properties' => [
									'major' => [
											'type' => 'integer',
											'default' => 0,
									],
									'minor' => [
											'type' => 'integer',
											'default' => 0,
									],
									'patch' => [
											'type' => 'integer',
											'default' => 0,
									],
									'prerelease' => [
											'type' => 'string',
											'default' => '',
									],
									'prerelease_version' => [
											'type' => 'integer',
											'default' => 0,
									],
							],
					],
			],
				'single'       => true,
				'type'         => 'object',
				'default'      => [
					'major'                 => 0,
					'minor'                 => 0,
					'patch'                 => 0,
					'prerelease'            => '',
					'prerelease_version'    => 0,
				],
			]
		);

		/**
		 * Deprecated: This is for backwards compatibility with the old version meta
		 */
		register_post_meta(
			'release-note',
			'version',
			[
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			],
		);

		register_post_meta(
			'release-note',
			'release_date',
			[
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
			]
		);
		register_post_meta(
			'release-note',
			'is_pre_release',
			[
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'boolean',
				'default'      => false,
			]
		);
	}

	/**
	 * Register Post type.
	 *
	 * @return void
	 */
	public function register_post_type(): void {
		$labels = [
			'name'                  => _x( 'Release Notes', 'Post Type General Name', 'release-notes' ),
			'singular_name'         => _x( 'Release Note', 'Post Type Singular Name', 'release-notes' ),
			'menu_name'             => __( 'Release Notes', 'release-notes' ),
			'name_admin_bar'        => __( 'Release Note', 'release-notes' ),
			'archives'              => __( 'Release Notes', 'release-notes' ),
			'attributes'            => __( 'Release Note Attributes', 'release-notes' ),
			'parent_item_colon'     => __( 'Parent Release:', 'release-notes' ),
			'all_items'             => __( 'All Release Notes', 'release-notes' ),
			'add_new_item'          => __( 'Add New Release Note', 'release-notes' ),
			'add_new'               => __( 'Add New', 'release-notes' ),
			'new_item'              => __( 'New Release Note', 'release-notes' ),
			'edit_item'             => __( 'Edit Release Note', 'release-notes' ),
			'update_item'           => __( 'Update Release Note', 'release-notes' ),
			'view_item'             => __( 'View Release Note', 'release-notes' ),
			'view_items'            => __( 'View Release Note', 'release-notes' ),
			'search_items'          => __( 'Search Release Note', 'release-notes' ),
			'not_found'             => __( 'Not found', 'release-notes' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'release-notes' ),
			'featured_image'        => __( 'Featured Image', 'release-notes' ),
			'set_featured_image'    => __( 'Set featured image', 'release-notes' ),
			'remove_featured_image' => __( 'Remove featured image', 'release-notes' ),
			'use_featured_image'    => __( 'Use as featured image', 'release-notes' ),
			'insert_into_item'      => __( 'Insert into Release Note', 'release-notes' ),
			'uploaded_to_this_item' => __( 'Uploaded to this release note', 'release-notes' ),
			'items_list'            => __( 'Release Notes list', 'release-notes' ),
			'items_list_navigation' => __( 'Release Notes list navigation', 'release-notes' ),
			'filter_items_list'     => __( 'Filter Release Notes list', 'release-notes' ),
		];

		$capabilities = [
			'edit_post'          => 'manage_options',
			'read_post'          => 'manage_options',
			'delete_post'        => 'manage_options',
			'edit_posts'         => 'manage_options',
			'edit_others_posts'  => 'manage_options',
			'publish_posts'      => 'manage_options',
			'read_private_posts' => 'manage_options',
		];

		$args = [
			'label'               => __( 'Release Note', 'release-notes' ),
			'description'         => __( 'Release Notes', 'release-notes' ),
			'labels'              => $labels,
			'supports'            => [ 'title', 'editor', 'revisions', 'custom-fields' ],
			'taxonomies'          => [],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capabilities'        => $capabilities,
			'template'            => [
				[ 'core/heading', [ 'content' => 'Overview' ] ],
				[ 'core/paragraph' ],
				[ 'core/heading', [ 'content' => 'Added' ] ],
				[ 'core/list' ],
				[ 'core/heading', [ 'content' => 'Changed' ] ],
				[ 'core/list' ],
				[ 'core/heading', [ 'content' => 'Fixed' ] ],
				[ 'core/list' ],
			],
		];

		register_post_type( 'release-note', $args );
	}

	/**
	 * Register post type blocks
	 *
	 * @param array|bool               $allowed_block_types - current allowed block types
	 * @param \WP_Block_Editor_Context $context - editor context.
	 * @return array|bool
	 */
	public function allow_post_types( array|bool $allowed_block_types, \WP_Block_Editor_Context $context ): array|bool {
		if ( ! $context->post ) {
			return $allowed_block_types;
		}

		return match ( $context->post->post_type ) {
			'release-note' => [
				'core/heading',
				'core/paragraph',
				'core/list',
				'core/list-item',
				'core/image',
				'core/video',
				'release-notes/markdown-parser',
			],
			default => $allowed_block_types,
		};
	}
}
