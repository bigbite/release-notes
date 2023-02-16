<?php

use Big_Bite\release_notes\ReleaseNote;

$current_page = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'], 10 ) ) : 1; // phpcs:ignore

$query_args = [
	'post_type'      => 'release-note',
	'posts_per_page' => 5,
	'post_status'    => 'publish',
	'paged'          => $current_page,
];

$query = new WP_Query( $query_args );

if ( ! $query->have_posts() && 1 !== $current_page ) {
	wp_die( 'Page not found', 'Not found', '404' );
}

$base_url = admin_url( 'admin.php?page=release-notes' );
?>

<div class="release-notes-list">

<?php if ( $current_page > 1 ) : ?>
	<a class="release-notes-pagination" href="<?php printf( '%s&paged=%d', esc_url( $base_url ), esc_attr( $current_page - 1 ) ); ?>">Previous Page</a>
<?php endif; ?>

<?php
if ( $query->have_posts() ) :
	while ( $query->have_posts() ) :
		$query->the_post();
		require __DIR__ . '/release-notes-item.php';
	endwhile;
else :
	require __DIR__ . '/release-notes-empty.php';
endif;
?>
<?php if ( $current_page < $query->max_num_pages ) : ?>
	<a class="release-notes-pagination" href="<?php printf( '%s&paged=%d', esc_url( $base_url ), esc_attr( $current_page + 1 ) ); ?>">Next Page</a>
<?php endif; ?>
</div>

<?php
if ( 1 !== $current_page ) {
	return;
}

$latest = Big_Bite\release_notes\ReleaseNote::get_latest();

if ( $latest ) {
	Big_Bite\release_notes\ReleaseNote::set_viewed( $latest->ID );
}
?>
