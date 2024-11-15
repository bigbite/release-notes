<?php
	$version        = get_post_meta( get_the_ID(), 'version', true );
	$date           = get_post_meta( get_the_ID(), 'release_date', true );
	$version_string = '(version <span class="release-note-meta release-note-version ' . ( empty( $version ) ? 'empty' : '' ) . '">' . esc_html( $version ) . '</span>)';
?>

<article class="release-note-widget">
<header class="release-note-header">
		<h1 class="release-note-title"><?php the_title(); ?> <?php echo ! empty( $version ) ? wp_kses_data( $version_string ) : ''; ?></h1>
		<div class="release-note-meta-wrapper">
			<p><?php _e( 'Release Date:', 'release-notes' ); ?></p>
			<span class="release-note-meta release-note-date
			<?php
			if ( empty( $date ) ) {
				echo 'empty';
			}
			?>
			"><?php echo esc_html( get_formatted_date( $date ) ); ?></span>
		</div>
	</header>
	<div class="release-note-body">
		<?php the_content(); ?>
	</div>


	<footer class="release-note-footer">
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=release-notes' ) ); ?>"><?php _e( 'View All Release Notes', 'release-notes' ); ?></a>
	</footer>
</article>
