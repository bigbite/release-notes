<?php

declare( strict_types = 1 );

/**
 * Stub for WP_Query
 */
class WP_Query {

	/**
	 * Query arguments.
	 *
	 * @var array
	 */
	public array $args;

	/**
	 * Current post.
	 *
	 * @var int
	 */
	public int $current = -1;

	/**
	 * Post count.
	 *
	 * @var int
	 */
	public int $post_count = 1;

	/**
	 * Constructor.
	 *
	 * @param array $args Query arguments.
	 */
	public function __construct( array $args ) {
		$this->args = $args;

		$this->post_count = $this->args['posts_per_page'];
	}

	/**
	 * Whether there are posts left in the loop.
	 *
	 * @return bool
	 */
	public function have_posts(): bool {
		if ( $this->current + 1 < $this->post_count ) {
			return true;
		}

		if ( $this->current + 1 === $this->post_count && $this->post_count > 0 ) {
			$this->current = -1;
		}

		return false;
	}

	/**
	 * Setup the current post.
	 *
	 * @return void
	 */
	public function the_post(): void {
		$this->current++;
	}

}
