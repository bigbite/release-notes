<?php

namespace Big_Bite\release_notes;

/**
 * Slack Notifications.
 */
class ReleasePublish {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'transition_post_status', [ $this, 'post_status_transition' ], 10, 3 );
	}

  /**
   * @param int $number
   * @return string
   */
  function number_to_roman_numeral($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
  }

  protected $alphabet = 'abcdefghijklmnopqrstuvwxyz';

  public function number_to_alphabet( int $count ) {
    $length = strlen( $this->alphabet );

    if ( $count <= $length ) {
      return substr( $this->alphabet, $count - 1, 1 );
    }

    $pos = intval( floor( $count / $length ), 10 );
    $rem = $count % $length;
    
    if ( 0 === $rem ) {
      return substr( $this->alphabet, $pos - 2, 1 ) . substr( $this->alphabet, $length - 1, 1 );
    }

    $bullet = substr( $this->alphabet, $pos - 1, 1 );

    if ( $rem > 0 ) {
      $bullet .= substr( $this->alphabet, $rem - 1, 1 );
    }

    return $bullet;
  }

  public function rich_text_formatter( $text ) {
    $text = preg_replace("/<\/?s>/m", "~", $text);
    $text = preg_replace("/<\/?strong>/m", "*", $text);
    $text = preg_replace("/<\/?em>/m", "_", $text);
    $text = preg_replace("/<\/?code>/m", "`", $text);

    return $text;
  }

  public function link_formatter( $text ) {
    if ( ! str_contains( $text, '<a' ) ) {
      return $text;
    }
    preg_match_all("/<a.*>/m", $text, $anchors);

    foreach ($anchors as $anchor) {
      preg_match("/href=\".*?.\"/m", strval($anchor[0]), $link);
      $link = str_replace('href="', '', $link[0]);
      $link = str_replace('"', '', $link);

      $link_text = preg_replace("/<\/?a.*?>/m", '', $anchor[0]);

      $text = str_replace($anchor[0], '<' . $link . '|' . $link_text . '>', $text);
    }

    return $text;
  }

  public function post_status_transition( $new_status, $old_status, $post ) {
    if ($new_status === $old_status || 'publish' !== $new_status || 'release-note' !== $post->post_type) {
      return;
    }

    $options = get_option( 'bb_release_notes_settings', '' );

    if ( ! isset( $options['bb_release_notes_webhooks'] ) ) {
      return;
    }

    $url = $options['bb_release_notes_webhooks'];

    $post_content = $post->post_content;
    
    $content = str_replace( "\n\n", "\n", preg_replace( "/<!--.*-->/m", '', $post_content ) );

    $content_arr = explode("\n", $content);

    $blocks = [
      [
        'type' => 'header',
        'text' => [
          'type' => 'plain_text',
          'text' => 'New Release 🎉',
        ]
      ],
      [
        'type' => 'section',
        'text' => [
          'type' => 'mrkdwn',
          'text' => 'View all details <https://release-notes.bigbite.site/wp-admin/admin.php?page=release-notes&release-id=' . $post->ID . '|here>',
        ]
      ],
      [
        'type' => 'divider',
      ],
    ];

    $active_lists = [];

    $list_tally = [];

    $list_str = '';

    foreach ( $content_arr as $element ) {
      if (str_contains($element, '<h')) {
        $regex = "/<\/?h\d>/m";
        $text = preg_replace($regex, '', $element);
        
        if ( str_contains( $text, '<a' ) ) {
          $text = preg_replace("/<\/?a.*?>/m", '', $text);
        }

        $text = preg_replace("/<\/?s>/m", "", $text);
        $text = preg_replace("/<\/?strong>/m", "", $text);
        $text = preg_replace("/<\/?em>/m", "", $text);
        $text = preg_replace("/<\/?code>/m", "", $text);

        $block_content = [
          'type' => 'header',
          'text' => [
            'type' => 'plain_text',
            'text' => $text,
          ]
        ];

        array_push($blocks, $block_content);
      } elseif ( str_contains( $element, '<p' ) ) {
        $regex = "/<\/?p>/m";
        $text = preg_replace($regex, '', $element);

        if ( 0 === strlen($text) ) {
          continue;
        }

        $text = $this->link_formatter($text);

        $text = $this->rich_text_formatter($text);

        $block_content = [
          'type' => 'section',
          'text' => [
            'type' => 'mrkdwn',
            'text' => $text,
          ]
        ];

        array_push($blocks, $block_content);
      } elseif ( str_contains( $element, '<ul' ) || str_contains( $element, '<ol' ) ) {
        array_push( $active_lists, $element );
        array_push($list_tally, 0);
      } elseif ( str_contains( $element, '<li' ) ) {
        $list_tally[ count($list_tally) - 1 ] = end( $list_tally ) + 1;
        $item = '';

        for ($i=0; $i < count($active_lists); $i += 1) { 
          if ( 0 === $i ) {
            continue;
          }

          $item .= '      ';
        }

        $regex = "/<\/?li>/m";

        if ( str_contains( end($active_lists), '<ul' )) {
          switch (count($active_lists) % 3) {
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
        }

        if ( str_contains( end($active_lists), '<ol' )) {
          switch (count($active_lists) % 3) {
            case 2:
              $item .= $this->number_to_alphabet(end($list_tally)) . '. ';
              break;

            case 0:
              $item .= $this->number_to_roman_numeral(end($list_tally)) . '. ';
              break;
            
            default:
              $item .= end($list_tally) . '. ';
              break;
          }
        }

        $text = preg_replace($regex, '', $element) . "\n";

        $text = $this->link_formatter($text);

        $text = $this->rich_text_formatter($text);

        $item .= $text;

        $list_str .= $item;
      } elseif ( str_contains( $element, '</ul' ) || str_contains( $element, '</ol' ) ) {
        array_pop( $active_lists );
        array_pop( $list_tally );

        if ( 0 === count($active_lists) ) {
          $block_content = [
            'type' => 'section',
            'text' => [
              'type' => 'mrkdwn',
              'text' => $list_str,
            ]
          ];
  
          array_push($blocks, $block_content);

          $list_str = '';
        }
      } elseif ( str_contains( $element, '<img' ) ) {
        preg_match("/wp-image-\d*/m", $element, $image_id_class);
        $image_id = intval(str_replace("wp-image-", "", $image_id_class[0]), 10);
        $image_url = wp_get_attachment_image_src( $image_id, 'medium' );
        $alt_text = explode('"', explode( 'alt="', $element )[1])[0];

        $block_content = [
          'type' => 'image',
          'image_url' => $image_url,
          'alt_text' => $alt_text,
        ];

        array_push($blocks, $block_content);
      }
    }

    $response = wp_remote_post( $url, [
      'body' => json_encode([
        'blocks' => $blocks
      ]),
    ] );

    if ( is_wp_error($response) ) {
      wp_die( esc_html( $response->get_error_message() ) );
    }
  }
}
