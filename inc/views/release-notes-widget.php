<?php
	$version = get_post_meta( get_the_ID(), 'version', true );
	$date = get_post_meta( get_the_ID(), 'release_date', true );
?>

<article class="release-note-widget">
	<header class="release-note-header">
		<h1 class="release-note-title"><?php the_title(); ?></h1>
		<?php if ( ! empty( $date ) ) { ?>
			<span class="release-note-version"><?php echo esc_html( $date ); ?></span>
		<?php } ?>
		<?php if ( ! empty( $version ) ) { ?>
			<span class="release-note-version"><?php echo esc_html( $version ); ?></span>
		<?php } ?>
	</header>
	<div class="release-note-body">
		<?php the_content(); ?>
	</div>


	<footer class="release-note-footer">
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=release-notes' ) ); ?>">View All Release Notes</a>
	</footer>
</article>
