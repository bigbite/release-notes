<?php
	$version        = get_post_meta( get_the_ID(), 'version', true );
	$date           = get_post_meta( get_the_ID(), 'release_date', true );
	$is_pre_release = get_post_meta( get_the_ID(), 'is_pre_release', true );
	$version_string = 'Version <span class="release-note-meta release-note-version ' . ( empty( $version ) ? 'empty' : '' ) . '">[' . esc_html( $version ) . ']</span>';
?>

<article class="release-note-single <?php $is_pre_release && print ' is-pre-release'; ?>">
	<header class="release-note-header">
		<h1 class="release-note-title">[<?php the_title(); ?>] <?php echo ! empty( $version ) ? wp_kses_data( $version_string ) : ''; ?></h1>
		<div class="release-note-meta-wrapper">
			<p><?php _e( 'Release Date:', 'release-notes' ); ?></p>
			<span class="release-note-meta release-note-date
			<?php
			if ( empty( $date ) ) {
				echo 'empty';
			}
			?>
			"><?php echo esc_html( $date ); ?></span>
		</div>
	</header>
	<div class="release-note-body">
		<?php the_content(); ?>
	</div>
</article>
