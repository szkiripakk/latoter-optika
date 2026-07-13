<?php
/**
 * Látótér Optika téma – alapbeállítások és eszközök betöltése.
 *
 * @package latoter-optika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Közvetlen elérés tiltása.
}

/**
 * Téma-támogatások.
 */
function latoter_setup() {
	// A <title> tag-et a WordPress kezeli (wp_head), az admin > Beállítások > Általános alapján.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script' )
	);
}
add_action( 'after_setup_theme', 'latoter_setup' );

/**
 * Betűtípusok és a téma style.css betöltése.
 */
function latoter_assets() {
	// Előcsatlakozás a Google Fonts szerverekhez (gyorsabb betöltés).
	add_action(
		'wp_head',
		function () {
			echo '<link rel="preconnect" href="https://fonts.googleapis.com" />' . "\n";
			echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />' . "\n";
		},
		1
	);

	// Bricolage Grotesque (display) + Outfit (szöveg).
	wp_enqueue_style(
		'latoter-fonts',
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,600;12..96,700&family=Outfit:wght@400;500;600&display=swap',
		array(),
		null
	);

	// A téma style.css (WordPress miatt kötelező; a fő CSS az index.php-ben van).
	wp_enqueue_style( 'latoter-style', get_stylesheet_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'latoter_assets' );

/**
 * Alapértelmezett márkalista.
 *
 * @return array
 */
function latoter_default_brands() {
	return array(
		'Zeiss', 'Hoya', 'Ray-Ban', 'Vogue', 'Oakley', 'Police', 'Solano', 'Essilor',
		'Retro', 'Carrera', "O'Neil", 'Ana Hickmann', 'Swarovski', 'Lisa Sirani', 'Guess',
		'Tom Tailor', 'The Marc Jacobs', 'Carolina Herrera', 'CAT', 'Forbes', 'Jaguar',
		'Adidas', 'Pull&Bear', 'Vonbogen', 'Lacoste', 'Nike', 'Max&Co', 'Lee Cooper',
		'Vulkan', 'Stepper', 'Vaude', 'Rolling Stones', 'Hard Rock', 'Nici', 'Fila',
		'Smart', 'Cristal', 'Mango', 'Nano', 'Tommy Hilfiger', 'Aboriginal', 'Inflecto',
		'Ambrossi', 'Guy Laroche', 'Agatha Ruiz de la Prada', 'Under Armour',
		'Pierre Cardin', 'Polaroid', 'Moschino', "Levi's", 'Hugo', 'Boss',
		'Jean Louis Bertier', 'David Beckham', 'Armani Exchange', 'Ralph Lauren', 'Ozzie',
	);
}

/**
 * Aktuális márkalista (Testreszabóból, vagy az alapértelmezett).
 *
 * @return array
 */
function latoter_brands_list() {
	$raw = (string) get_theme_mod( 'latoter_brands', implode( "\n", latoter_default_brands() ) );
	$list = array();
	foreach ( preg_split( '/\r\n|\r|\n/', $raw ) as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$list[] = $line;
		}
	}
	return $list ? $list : latoter_default_brands();
}

/**
 * Alapértelmezett nyitvatartás: kulcs => array( nap neve, órák ).
 *
 * @return array
 */
function latoter_default_hours() {
	return array(
		'mon' => array( 'Hétfő', '10:00 - 17:00' ),
		'tue' => array( 'Kedd', '10:00 - 18:00' ),
		'wed' => array( 'Szerda', '10:00 - 17:00' ),
		'thu' => array( 'Csütörtök', '10:00 - 17:00' ),
		'fri' => array( 'Péntek', '10:00 - 17:00' ),
		'sat' => array( 'Szombat', '10:00 - 13:00' ),
		'sun' => array( 'Vasárnap', 'Zárva' ),
	);
}

/**
 * Testreszabó (Customizer) mezők: szövegek kód nélküli szerkesztéséhez.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function latoter_customize_register( $wp_customize ) {

	$wp_customize->add_panel(
		'latoter_panel',
		array(
			'title'    => 'Látótér – Tartalom',
			'priority' => 20,
		)
	);

	// --- HERO / FŐCÍM ---
	$wp_customize->add_section( 'latoter_hero', array( 'title' => 'Főcím (Hero)', 'panel' => 'latoter_panel' ) );

	$hero_fields = array(
		'latoter_hero_eyebrow' => array( 'Kis felirat', 'Optika a Balaton partján', 'text' ),
		'latoter_hero_title_1' => array( 'Cím – első sor', 'Éles látás,', 'text' ),
		'latoter_hero_title_2' => array( 'Cím – kiemelt (zöld) sor', 'szakértelemmel és gyorsasággal', 'text' ),
		'latoter_hero_sub'     => array( 'Alcím', 'Személyre szabott szemüvegek, minőségi lencsék és egyedi keretek minden korosztály számára Siófok szívében.', 'textarea' ),
	);
	foreach ( $hero_fields as $id => $f ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $f[1],
				'sanitize_callback' => ( 'textarea' === $f[2] ) ? 'sanitize_textarea_field' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control( $id, array( 'label' => $f[0], 'section' => 'latoter_hero', 'type' => $f[2] ) );
	}

	// --- KAPCSOLAT ---
	$wp_customize->add_section( 'latoter_contact', array( 'title' => 'Kapcsolat', 'panel' => 'latoter_panel' ) );

	$contact_fields = array(
		'latoter_phone'       => array( 'Telefonszám', '+36 XX XXX XXXX', 'text' ),
		'latoter_email'       => array( 'E-mail', 'info@latoteroptika.hu', 'text' ),
		'latoter_address'     => array( 'Cím', '8600 Siófok, Sió utca 6. Fsz. 1.', 'text' ),
		'latoter_booking_url' => array( 'Foglalási link (Clearvisio)', 'https://clearvis.io/hu/', 'url' ),
	);
	foreach ( $contact_fields as $id => $f ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $f[1],
				'sanitize_callback' => ( 'url' === $f[2] ) ? 'esc_url_raw' : 'sanitize_text_field',
			)
		);
		$wp_customize->add_control( $id, array( 'label' => $f[0], 'section' => 'latoter_contact', 'type' => ( 'url' === $f[2] ) ? 'url' : 'text' ) );
	}

	// --- NYITVATARTÁS ---
	$wp_customize->add_section( 'latoter_hours', array( 'title' => 'Nyitvatartás', 'panel' => 'latoter_panel' ) );

	foreach ( latoter_default_hours() as $key => $row ) {
		$id = 'latoter_hours_' . $key;
		$wp_customize->add_setting( $id, array( 'default' => $row[1], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $id, array( 'label' => $row[0], 'section' => 'latoter_hours', 'type' => 'text' ) );
	}

	// --- MÁRKÁK ---
	$wp_customize->add_section(
		'latoter_brands_sec',
		array(
			'title'       => 'Márkák',
			'panel'       => 'latoter_panel',
			'description' => 'Soronként egy márka.',
		)
	);
	$wp_customize->add_setting( 'latoter_brands', array( 'default' => implode( "\n", latoter_default_brands() ), 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'latoter_brands', array( 'label' => 'Márkalista (soronként egy)', 'section' => 'latoter_brands_sec', 'type' => 'textarea' ) );
}
add_action( 'customize_register', 'latoter_customize_register' );
