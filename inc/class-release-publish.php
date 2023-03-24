<?php

namespace Big_Bite\Release_Notes;

/**
 * Slack Notifications.
 */
class ReleasePublish {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'transition_post_status', [ $this, 'post_status_transition' ], 10, 3 );
		add_action( 'test_scheduled_event', [ $this, 'test_scheduled_event' ] );
	}

	/**
	 * Convert a number into roman numerals for the lists
	 *
	 * @param int $number The number to be changed to a roman numeral
	 * @return string The roman numeral convertion for the number provided
	 */
	public function number_to_roman_numeral( int $number ) {
		$map          = [
			'm'  => 1000,
			'cm' => 900,
			'd'  => 500,
			'cd' => 400,
			'c'  => 100,
			'xc' => 90,
			'l'  => 50,
			'xl' => 40,
			'x'  => 10,
			'ix' => 9,
			'v'  => 5,
			'iv' => 4,
			'i'  => 1,
		];
		$return_value = '';
		while ( $number > 0 ) {
			foreach ( $map as $roman => $int ) {
				if ( $number >= $int ) {
					$number       -= $int;
					$return_value .= $roman;
					break;
				}
			}
		}
		return $return_value;
	}

	/**
	 * Convert a number into the respective letter for the lists
	 * e.g. 2 = b, 28 = ab
	 *
	 * @param int $count The number to be changed into letters
	 * @return string The alphabetic index conversion for the number provided
	 */
	public function number_to_alphabet( int $count ) {
		$alphabet = 'abcdefghijklmnopqrstuvwxyz';

		$length = strlen( $alphabet );

		if ( $count <= $length ) {
			return substr( $alphabet, $count - 1, 1 );
		}

		$pos = intval( floor( $count / $length ), 10 );
		$rem = $count % $length;

		if ( 0 === $rem ) {
			return substr( $alphabet, $pos - 2, 1 ) . substr( $alphabet, $length - 1, 1 );
		}

		$bullet = substr( $alphabet, $pos - 1, 1 );

		if ( $rem > 0 ) {
			$bullet .= substr( $alphabet, $rem - 1, 1 );
		}

		return $bullet;
	}

	/**
	 * Replace the html rich text formats with markdown formats
	 *
	 * @param string $text The string to have html rich text formats changed into markdown
	 * @return string The text with the correct markdown elements
	 */
	public function rich_text_formatter( string $text ) {
		$text = preg_replace( '/<\/?s>/m', '~', $text );
		$text = preg_replace( '/<\/?strong>/m', '*', $text );
		$text = preg_replace( '/<\/?em>/m', '_', $text );
		$text = preg_replace( '/<\/?code>/m', '`', $text );

		return $text;
	}

	/**
	 * Replace the html link with the Slack Markdown link
	 *
	 * @param string $text The string that contains a link to be converted from html to Slack markdown
	 * @return string The link in the slack markdown format
	 */
	public function link_formatter( string $text ) {
		if ( ! str_contains( $text, '<a' ) ) {
			return $text;
		}
		preg_match_all( '/<a.*>/m', $text, $anchors );

		foreach ( $anchors as $anchor ) {
			preg_match( '/href=\".*?.\"/m', strval( $anchor[0] ), $link );
			$link = str_replace( 'href="', '', $link[0] );
			$link = str_replace( '"', '', $link );

			$link_text = preg_replace( '/<\/?a.*?>/m', '', $anchor[0] );

			$text = str_replace( $anchor[0], '<' . $link . '|' . $link_text . '>', $text );
		}

		return $text;
	}

	/**
	 * Create cron job to send a message using the slack api
	 *
	 * @param string  $new_status The new status of the post
	 * @param string  $old_status The old status of the post
	 * @param WP_Post $post The post itself
	 */
	public function post_status_transition( $new_status, $old_status, $post ) {
		if ( $new_status === $old_status || 'publish' !== $new_status || 'release-note' !== $post->post_type ) {
			return;
		}

		wp_schedule_single_event( time(), 'test_scheduled_event', [ $post->ID ] );
	}

	/**
	 * An array of active lists
	 *
	 * @var array
	 */
	protected $active_lists = [];

	/**
	 * An array of the number of current items in each level of a list
	 *
	 * @var array
	 */
	protected $list_tally = [];

	/**
	 * The string for the final list
	 *
	 * @var string
	 */
	protected $list_str = '';

	/**
	 * Header formatter
	 *
	 * @param string $element The element that is having the header format applied
	 * @return string The formatted element
	 */
	public function header_format( $element ) {
		$regex = '/<\/?h\d>/m';
		$text  = preg_replace( $regex, '', $element );

		if ( str_contains( $text, '<a' ) ) {
			$text = preg_replace( '/<\/?a.*?>/m', '', $text );
		}

		$text = preg_replace( '/<\/?s>/m', '', $text );
		$text = preg_replace( '/<\/?strong>/m', '', $text );
		$text = preg_replace( '/<\/?em>/m', '', $text );
		$text = preg_replace( '/<\/?code>/m', '', $text );

		$block_content = [
			'type' => 'header',
			'text' => [
				'type' => 'plain_text',
				'text' => $text,
			],
		];

		return $block_content;
	}

	/**
	 * Paragraph formatter
	 *
	 * @param string $element The element that is having the paragraph format applied
	 * @return string The formatted element
	 */
	public function paragraph_format( $element ) {
		$regex = '/<\/?p>/m';
		$text  = preg_replace( $regex, '', $element );

		if ( 0 === strlen( $text ) ) {
			return;
		}

		$text = $this->link_formatter( $text );

		$text = $this->rich_text_formatter( $text );

		$block_content = [
			'type' => 'section',
			'text' => [
				'type' => 'mrkdwn',
				'text' => $text,
			],
		];

		return $block_content;
	}

	/**
	 * List Item formatter
	 *
	 * @param string $element The element that is having the list item format applied
	 */
	public function list_item_format( $element ) {
		$this->list_tally[ count( $this->list_tally ) - 1 ] = end( $this->list_tally ) + 1;

		$item = str_repeat( '      ', count( $this->active_lists ) - 1 );

		$regex = '/<\/?li>/m';

		if ( str_contains( end( $this->active_lists ), '<ul' ) ) {
			switch ( count( $this->active_lists ) % 3 ) {
				case 2:
					$item .= '○ ';
					break;

				case 0:
					$item .= '■ ';
					break;

				default:
					$item .= '• ';
					break;
			}
		} else {
			switch ( count( $this->active_lists ) % 3 ) {
				case 2:
					$item .= $this->number_to_alphabet( end( $this->list_tally ) ) . '. ';
					break;

				case 0:
					$item .= $this->number_to_roman_numeral( end( $this->list_tally ) ) . '. ';
					break;

				default:
					$item .= end( $this->list_tally ) . '. ';
					break;
			}
		}

		$text = preg_replace( $regex, '', $element ) . "\n";

		$text = $this->link_formatter( $text );

		$text = $this->rich_text_formatter( $text );

		$item .= $text;

		$this->list_str .= $item;
	}

	/**
	 * Image formatter
	 *
	 * @param string $element The element that is having the image format applied
	 * @return string The formatted element
	 */
	public function image_format( $element ) {
		preg_match( '/wp-image-\d*/m', $element, $image_id_class );

		$image_id  = intval( str_replace( 'wp-image-', '', $image_id_class[0] ), 10 );
		$image_url = wp_get_attachment_image_src( $image_id, 'medium' );

		$alt_text = explode( '"', explode( 'alt="', $element )[1] )[0];

		$block_content = [
			'type'      => 'image',
			'image_url' => $image_url,
			'alt_text'  => $alt_text,
		];

		return $block_content;
	}

	/**
	 * Convert the post content into sections for the slack api
	 *
	 * @param string $element The element that is being converted into the content
	 * @return string|null The array to be added to the blocks array or null
	 */
	public function format_content( $element ) {
		if ( str_contains( $element, '<h' ) ) {
			return $this->header_format( $element );

		} elseif ( str_contains( $element, '<p' ) ) {
			return $this->paragraph_format( $element );

		} elseif ( str_contains( $element, '<ul' ) || str_contains( $element, '<ol' ) ) {
			array_push( $this->active_lists, $element );
			array_push( $this->list_tally, 0 );

			return null;
		} elseif ( str_contains( $element, '<li' ) ) {
			$this->list_item_format( $element );
		} elseif ( str_contains( $element, '</ul' ) || str_contains( $element, '</ol' ) ) {
			array_pop( $this->active_lists );
			array_pop( $this->list_tally );

			if ( 0 === count( $this->active_lists ) ) {
				$block_content = [
					'type' => 'section',
					'text' => [
						'type' => 'mrkdwn',
						'text' => $this->list_str,
					],
				];

				$this->list_str = '';
				return $block_content;

			}
		} elseif ( str_contains( $element, '<img' ) ) {
			return $this->image_format( $element );
		}
		return null;
	}

	/**
	 * Send the release note message with the slack api
	 *
	 * @param int $id The ID of the post
	 */
	public function test_scheduled_event( $id ) {
		$options = get_option( 'bb_release_notes_settings', '' );

		if ( ! isset( $options['bb_release_notes_webhooks'] ) ) {
			return;
		}

		$url  = $options['bb_release_notes_webhooks'];
		$post = get_post( $id );

		$post_content = $post->post_content;

		$content = str_replace( "\n\n", "\n", preg_replace( '/<!--.*-->/m', '', $post_content ) );

		$content_arr = explode( "\n", $content );

		$header_title = [
			[
				'type' => 'header',
				'text' => [
					'type' => 'plain_text',
					'text' => get_post_meta( $id, 'is_pre_release', true ) ? __( 'New Pre-Release 🎉', 'release-notes' ) : __( 'New Release 🎉', 'release-notes' ),
				],
			],
		];

		$header_body = [
			[
				'type' => 'section',
				'text' => [
					'type' => 'plain_text',
					'text' => __( 'Version: ', 'release-notes' ) . get_post_meta( $id, 'version', true ),
				],
			],
			[
				'type' => 'section',
				'text' => [
					'type' => 'mrkdwn',
					'text' => __( 'View all details <https://release-notes.bigbite.site/wp-admin/admin.php?page=release-notes&release-id=', 'release-notes' ) . $post->ID . __( '|here>', 'release-notes' ),
				],
			],
			[
				'type' => 'divider',
			],
		];

		$blocks = array_merge( $header_title, $header_body );

		foreach ( $content_arr as $element ) {
			$formatted_element = $this->format_content( $element );

			if ( null !== $formatted_element ) {
				array_push( $blocks, $formatted_element );
			}
		}

		wp_remote_post( $url, [
			'body' => wp_json_encode( [
				'blocks' => $blocks,
			] ),
		] );
	}
}
