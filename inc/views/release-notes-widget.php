<?php
	$version = get_post_meta( get_the_ID(), 'version', true );
?>

<article class="release-note-widget">
	<header class="release-note-header">
		<h1 class="release-note-title"><?php the_title(); ?></h1>
		<span class="release-note-version"><?php echo esc_html( $version ); ?></span>
	</header>
	<div class="release-note-body">
		<?php the_content(); ?>
	</div>


	<footer class="release-note-footer">
		<a href="<?php echo esc_url( admin_url( 'admin.php?page=release-notes' ) ); ?>">View All Release Notes</a>
	</footer>
</article>
