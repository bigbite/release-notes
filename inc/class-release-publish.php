<?php

namespace Big_Bite\Release_Notes;

use stdClass;

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
	 * Get the elements that need styles applied
	 *
	 * @param string $element The text to get split
	 * @return array An array of the strings that need styles
	 */
	public function get_elements( string $raw ) {
		$raw_array = array_filter( wp_html_split( $raw ) );

		$tag_stack = [];
		$elements  = [];

		foreach ( $raw_array as $substr ) {
			// substring is an opening tag
			if ( 1 === preg_match( '/<[a-zA-Z-_]{1,}>/', $substr ) ) {
				$tag_stack[] = trim( $substr, '<>' );
				continue;
			}

			// substring is a closing tag
			if ( 1 === preg_match( '/<\/[a-zA-Z-_]{1,}>/', $substr ) ) {
				array_pop( $tag_stack );
				continue;
			}

			$elements[] = [
				'style' => $tag_stack,
				'text'  => $substr,
			];
		}

		return $elements;
	}

	/**
	 * Get the styles array for the text
	 *
	 * @param array $styles the element's style tag list
	 *
	 * @return string The styles array
	 */
	public function get_styles( array $styles ) {
		$arr = [
			'italic' => false,
			'bold'   => false,
			'strike' => false,
			'code'   => false,
		];

		foreach ( $styles as $style ) {
			switch ($style) {
				case 'em':
					$arr['italic'] = true;
					break;

				case 'strong':
					$arr['bold'] = true;
					break;

				case 's':
					$arr['strike'] = true;
					break;

				case 'code':
					$arr['code'] = true;
					break;

				default:
					break;
			}
		}

		return $arr;
	}

	public function format_rich_text( string $raw_element ) {
		$elements_arr = $this->get_elements( $raw_element );
		$rich_text_block_arr = [];

		foreach ( $elements_arr as $element ) {
			$styles = $this->get_styles( $element['style'] );

			if ( in_array( 'link', $element['style'] ) ) {
				$rich_text_block_arr[] = [
					'type'  => 'link',
					'url'   => explode( '|', $element['text'] )[0],
					'text'  => explode( '|', $element['text'] )[1],
					'style' => $styles,
				];
			} else {
				$rich_text_block_arr[] = [
					'type'  => 'text',
					'text'  => $element['text'],
					'style' => $styles,
				];
			}
		}

		return $rich_text_block_arr;
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

			$text = str_replace( $anchor[0], '<link>' . $link . '|' . $link_text  . '</link>', $text );
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
	 * An array of the formatted list items
	 *
	 * @var array
	 */
	protected $list_elements = [];

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

		$text = $this->format_rich_text( $text );

		$block_content = [
			'type' => 'rich_text',
			'elements' => [
				[
					'type' => 'rich_text_section',
					'elements' => $text
				]
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
		$regex = '/<\/?li>/m';
		$text = preg_replace( $regex, '', $element ) . "\n";

		if ( 0 === strlen( $text ) ) {
			return;
		}

		$text = $this->link_formatter( $text );

		$text = $this->format_rich_text( $text );

		$item = [
			'type'     => 'rich_text_list',
			'elements' => [
				[
					'type'     => 'rich_text_section',
					'elements' => $text
				]
			],
			'style'  => str_contains( end( $this->active_lists ), '<ul' ) ? 'bullet' : 'ordered',
			'indent' => count( $this->active_lists ) - 1
		];

		$this->list_elements[] = $item;
		return;
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

			return null;
		} elseif ( str_contains( $element, '<li' ) ) {
			$this->list_item_format( $element );
		} elseif ( str_contains( $element, '</ul' ) || str_contains( $element, '</ol' ) ) {
			array_pop( $this->active_lists );

			if ( 0 === count( $this->active_lists ) ) {
				$block_content = [
					'type' => 'rich_text',
					'elements' => $this->list_elements,
				];

				// $block_content = [
				// 	'type' => 'section',
				// 	'text' => [
				// 		'type' => 'mrkdwn',
				// 		'text' => json_encode( $this->list_elements )
				// 	]
				// ];

				$this->list_elements = [];
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
