<?php
/**
 * Used for utility functions.
 */

/**
 * Function to format the date correctly according to the date_format option.
 *
 * @param string $date - the current date.
 */
function get_formatted_date( $date ) {
	$format   = get_option( 'date_format' );
	$raw_date = new DateTime( $date );
	$date     = $raw_date->format( $format );

	return $date;
}
