<?php
	$version    = get_post_meta( get_the_ID(), 'version', true );
	$date    = get_post_meta( get_the_ID(), 'release_date', true );
	$has_viewed = ! Big_Bite\release_notes\ReleaseNote::has_viewed( get_the_ID() );
?>

<article class="release-note-single<?php $has_viewed && print ' is-new'; ?>">
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
</article>
