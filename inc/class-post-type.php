<?php
namespace Big_Bite\release_notes;

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
			'version',
			[
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'string',
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
			'name'                  => _x( 'Release Notes', 'Post Type General Name' ),
			'singular_name'         => _x( 'Release Note', 'Post Type Singular Name' ),
			'menu_name'             => __( 'Release Notes' ),
			'name_admin_bar'        => __( 'Release Note' ),
			'archives'              => __( 'Release Notes' ),
			'attributes'            => __( 'Release Note Attributes' ),
			'parent_item_colon'     => __( 'Parent Release:' ),
			'all_items'             => __( 'All Release Notes' ),
			'add_new_item'          => __( 'Add New Release Note' ),
			'add_new'               => __( 'Add New' ),
			'new_item'              => __( 'New Release Note' ),
			'edit_item'             => __( 'Edit Release Note' ),
			'update_item'           => __( 'Update Release Note' ),
			'view_item'             => __( 'View Release Note' ),
			'view_items'            => __( 'View Release Note' ),
			'search_items'          => __( 'Search Release Note' ),
			'not_found'             => __( 'Not found' ),
			'not_found_in_trash'    => __( 'Not found in Trash' ),
			'featured_image'        => __( 'Featured Image' ),
			'set_featured_image'    => __( 'Set featured image' ),
			'remove_featured_image' => __( 'Remove featured image' ),
			'use_featured_image'    => __( 'Use as featured image' ),
			'insert_into_item'      => __( 'Insert into Release Note' ),
			'uploaded_to_this_item' => __( 'Uploaded to this release note' ),
			'items_list'            => __( 'Release Notes list' ),
			'items_list_navigation' => __( 'Release Notes list navigation' ),
			'filter_items_list'     => __( 'Filter Release Notes list' ),
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
			'label'               => __( 'Release Note' ),
			'description'         => __( 'Release Notes' ),
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
				'core/paragraph',
				'core/list-item',
				'core/image',
				'core/video'
			],
			default => $allowed_block_types,
		};
	}
}
