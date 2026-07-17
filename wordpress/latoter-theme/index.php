<?php
/**
 * Tartalék sablon (fallback). Statikus előlap esetén a front-page.php fut;
 * ez a fájl marad a WordPress kötelező alapsablonja, és szintén a főoldal
 * tartalmát jeleníti meg, ha bármi ide esne vissza.
 *
 * @package latoter-optika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/home' );
get_footer();
