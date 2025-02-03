<?php
	$version        = get_post_meta( get_the_ID(), 'version', true );
	$version_object        = get_post_meta( get_the_ID(), 'version_object', true );
	$date                = get_post_meta( get_the_ID(), 'release_date', true );

	$version_string = '0.0.0';
	$is_pre_release = false;

	if ( ! empty( $version ) ) {
		$version_string = $version;
		$is_pre_release = get_post_meta( get_the_ID(), 'is_pre_release', true );
	} elseif ( ! empty( $version_object ) ) {
		$version_string = sprintf(
			'%d.%d.%d%s%s',
			$version_object['major'],
			$version_object['minor'],
			$version_object['patch'],
			$version_object['prerelease'],
			$version_object['prerelease'] !== '' ? '.' . $version_object['prerelease_version'] : ''
		);

		$is_pre_release = $version_object['prerelease'] !== '';
	}
?>

<article class="release-note-single<?php $is_pre_release && print ' is-pre-release'; ?>">
	<header class="release-note-header">
		<h1 class="release-note-title"><?php the_title(); ?></h1>
		<div class="release-note-meta-wrapper">
			<span class="release-note-meta release-note-date
			<?php
			if ( empty( $date ) ) {
				echo 'empty';
			}
			?>
			"><?php echo esc_html( $date ); ?></span>
		</div>
		<div class="release-note-meta-wrapper">
			<span class="release-note-meta release-note-version
			<?php
			if ( empty( $version_string ) ) {
				echo 'empty';
			}
			?>
			"><?php echo esc_html( $version_string ); ?></span>
		</div>
	</header>
	<div class="release-note-body">
		<?php the_content(); ?>
	</div>
</article>
