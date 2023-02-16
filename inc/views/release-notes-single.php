<?php

use Big_Bite\release_notes\ReleaseNote;

$release_id = isset( $_GET['release-id'] ) ? intval( $_GET['release-id'], 10 ) : false; // phpcs:ignore

if ( ! $release_id ) {
	require __DIR__ . '/release-notes-empty.php';
	return;
}

$query_args = [
	'post_type' => 'release-note',
	'p'         => $release_id,
];

$query = new WP_Query( $query_args );

if ( ! $query->have_posts() && 1 !== $current_page ) {
	require __DIR__ . '/release-notes-empty.php';
	return;
}

$base_url = admin_url( 'admin.php?page=release-notes' );
?>

<div class="release-notes-list">

<?php
if ( $query->have_posts() ) :
	while ( $query->have_posts() ) :
		$query->the_post();
		require __DIR__ . '/release-notes-item.php';
		ReleaseNote::set_viewed( get_the_ID() );
	endwhile;
endif;
?>
	<a class="release-notes-pagination" href="<?php echo esc_url( $base_url ); ?>">View All Releases</a>
</div>
