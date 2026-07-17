<?php
/**
 * Fejléc – minden sablon ezt tölti be (get_header()).
 *
 * @package latoter-optika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$latoter_on_service = is_page_template( 'page-szolgaltatas.php' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php if ( is_front_page() ) : ?>
  <meta name="description" content="Egyedi szemüvegkészítés, prémium keretek és gyors javítás Siófok szívében. Napszemüvegek dioptriával is. Foglaljon időpontot online!" />
  <meta property="og:title" content="Látótér Optika Siófok" />
  <meta property="og:description" content="Egyedi szemüvegek, prémium keretek és villámgyors javítás a Balaton partján." />
  <meta property="og:type" content="website" />
  <?php endif; ?>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="ltv-wrap">

  <!-- FEJLÉC -->
  <header class="ltv-header" id="ltv-header">
    <nav class="ltv-nav ltv-container">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ltv-nav__logo" aria-label="Látótér Optika">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo-latoter.jpg' ); ?>" alt="Látótér Optika" />
      </a>
      <button class="ltv-nav__burger" id="ltv-burger" aria-label="Menü megnyitása" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
      <ul class="ltv-nav__menu" id="ltv-menu">
        <li class="ltv-nav__item">
          <a href="<?php echo esc_url( home_url( '/#szolgaltatasok' ) ); ?>" class="ltv-nav__link ltv-nav__link--drop">
            Szolgáltatások
            <svg class="ltv-nav__caret" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
          <ul class="ltv-dropdown">
            <?php
            foreach ( latoter_service_pages() as $latoter_slug => $latoter_title ) :
                $latoter_url    = latoter_service_link( $latoter_slug );
                $latoter_is_cur = ( is_page() && get_post_field( 'post_name', get_queried_object_id() ) === $latoter_slug );
                ?>
            <li><a href="<?php echo esc_url( $latoter_url ); ?>"<?php echo $latoter_is_cur ? ' class="is-active"' : ''; ?>><?php echo esc_html( $latoter_title ); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li><a href="<?php echo esc_url( home_url( '/#rolunk' ) ); ?>" class="ltv-nav__link">Rólunk</a></li>
        <li><a href="<?php echo esc_url( home_url( '/#markak' ) ); ?>" class="ltv-nav__link">Márkák</a></li>
        <li><a href="<?php echo esc_url( home_url( '/#kapcsolat' ) ); ?>" class="ltv-nav__link">Kapcsolat</a></li>
        <li><a href="<?php echo esc_url( home_url( '/#foglalas' ) ); ?>" class="ltv-btn ltv-btn--solid ltv-nav__cta">Időpontot foglalok</a></li>
      </ul>
    </nav>
  </header>

  <main>
