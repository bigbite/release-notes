<?php

namespace Big_Bite\release_notes;

/**
 * Register Settings.
 */
class RegisterSettings {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_settings_page' ] );
    add_action('admin_init', [ $this, 'register_settings' ] );
	}

	/**
	 * Register Archive Page.
	 *
	 * @return void
	 */
	public function register_settings_page(): void {
		add_options_page(
			'Release Notes Settings',
			'Release Notes',
			'manage_options',
			'release-notes-settings',
			[ $this, 'render_setting_page' ]
		);
	}

	/**
	 * Render Archive Page.
	 *
	 * @return void
	 */
	public function render_setting_page(): void {
		?>
    <h2><?php __('Release Notes Settings') ?></h2>
    <form action="options.php" method="post">
      <?php
      settings_fields('bb_release_notes_settings');
      do_settings_sections( 'bb_release_notes' );
      ?>

      <input
        type="submit"
        name="submit"
        class="button button-primary"
        value="save"
      />
    </form>
    <?php
  }

  /**
   * register settings
   */
  function register_settings() {
    register_setting(
      'bb_release_notes_settings',
      'bb_release_notes_settings',
      [$this, 'bb_release_notes_validate_plugins'],
    );
    add_settings_section(
      'section_one',
      'Enter your Slack API Webhooks below:',
      function() {printf('');},
      'bb_release_notes',
    );
    add_settings_field(
      'bb_release_notes_webhooks',
      'Slack Webhooks:',
      [$this, 'render_webhooks_field'],
      'bb_release_notes',
      'section_one'
    );
  }

  /**
   * webhooks field renderer
   */
  function render_webhooks_field() {
    $options = get_option( 'bb_release_notes_settings' );
    printf(
      '<input type="text" name="%s" value="%s" style="width:500px;" />',
      esc_attr( 'bb_release_notes_settings[bb_release_notes_webhooks]' ),
      esc_attr( $options['bb_release_notes_webhooks'] ?? '' )
    );
  }

  /**
   * settings validate
   */
  function bb_release_notes_validate_plugins($input) {
    $output = [];
    $output['bb_release_notes_webhooks'] = $input['bb_release_notes_webhooks'];
    return($output);
  }
}
