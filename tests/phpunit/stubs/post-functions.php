<?php

declare( strict_types = 1 );

function get_posts( array $args = [] ) {
	$q = new WP_Query( $args );

	return array_fill( 0, $q->post_count, new WP_Post( [] ) );
}

function get_the_ID() {
	return 1;
}

function get_the_title() {
	return 'post-title';
}

function the_title() {
	echo get_the_title();
}

function get_the_content() {
	return 'post-content';
}

function the_content() {
	echo get_the_content();
}

function get_post_meta() {
	return 'meta-value';
}
