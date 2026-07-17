<?php
/**
 * Előlap (statikus főoldal). A tartalmat a Testreszabó vezérli.
 *
 * @package latoter-optika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/home' );
get_footer();
