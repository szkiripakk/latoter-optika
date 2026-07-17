<?php
/**
 * Template Name: Szolgáltatás oldal
 *
 * Egyetlen szolgáltatás aloldala. A törzs (bevezető, előnyök, lépések) a
 * WordPress-szerkesztőből (Gutenberg) szerkeszthető; a hero, a záró CTA és a
 * kapcsolódó szolgáltatások a sablonból jönnek. A hero képe a kiemelt kép,
 * vagy ha nincs, a slughoz tartozó alapkép.
 *
 * @package latoter-optika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$latoter_slug     = get_post_field( 'post_name', get_the_ID() );
	$latoter_subtitle = has_excerpt() ? get_the_excerpt() : '';
	$latoter_hero_img = latoter_service_hero_image( $latoter_slug );
	if ( has_post_thumbnail() ) {
		$latoter_hero_img = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	}
	?>

    <!-- ALOLDAL-HERO -->
    <section class="ltv-subhero">
      <img src="<?php echo esc_url( $latoter_hero_img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="ltv-subhero__bg" loading="eager" />
      <div class="ltv-subhero__scrim"></div>
      <div class="ltv-subhero__inner ltv-container">
        <nav class="ltv-breadcrumb" aria-label="Morzsamenü">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Főoldal</a>
          <span class="ltv-breadcrumb__sep">/</span>
          <a href="<?php echo esc_url( home_url( '/#szolgaltatasok' ) ); ?>">Szolgáltatások</a>
          <span class="ltv-breadcrumb__sep">/</span>
          <span aria-current="page"><?php the_title(); ?></span>
        </nav>
        <span class="ltv-subhero__eyebrow">Szolgáltatás</span>
        <h1 class="ltv-subhero__title"><?php the_title(); ?></h1>
        <?php if ( $latoter_subtitle ) : ?>
        <p class="ltv-subhero__sub"><?php echo esc_html( $latoter_subtitle ); ?></p>
        <?php endif; ?>
      </div>
    </section>

    <!-- TÖRZS (szerkeszthető a WordPress-szerkesztőben) -->
    <section class="ltv-section">
      <div class="ltv-container">
        <div class="ltv-content ltv-reveal">
          <?php the_content(); ?>
        </div>
      </div>
    </section>

    <!-- EXTRA SZEKCIÓK (slugonként: kártyák, GYIK, marquee, bento, logósáv) -->
    <?php latoter_service_extra_sections( $latoter_slug ); ?>

    <!-- ZÁRÓ CTA -->
    <section class="ltv-section" style="padding-top: 0;">
      <div class="ltv-container">
        <div class="ltv-cta ltv-reveal">
          <h2 class="ltv-cta__title">Kérdése van? Segítünk személyesen</h2>
          <p class="ltv-cta__text">Foglaljon időpontot, vagy ugorjon be hozzánk Siófok szívében – örömmel várjuk.</p>
          <div class="ltv-cta__ctas">
            <a href="<?php echo esc_url( home_url( '/#foglalas' ) ); ?>" class="ltv-btn ltv-btn--solid">Időpontot foglalok</a>
            <a href="<?php echo esc_url( home_url( '/#kapcsolat' ) ); ?>" class="ltv-btn ltv-btn--glass">Kapcsolat</a>
          </div>
        </div>
      </div>
    </section>

    <!-- KAPCSOLÓDÓ SZOLGÁLTATÁSOK -->
    <?php
    $latoter_related = array();
    foreach ( latoter_service_pages() as $latoter_rslug => $latoter_rtitle ) {
        if ( $latoter_rslug === $latoter_slug ) {
            continue;
        }
        $latoter_related[ $latoter_rslug ] = $latoter_rtitle;
    }
    $latoter_related = array_slice( $latoter_related, 0, 3, true );
    if ( $latoter_related ) :
        ?>
    <section class="ltv-section ltv-about" style="padding-top: clamp(3rem,6vw,4.5rem); padding-bottom: clamp(3rem,6vw,4.5rem);">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal" style="margin-bottom: 1.5rem !important;">További <strong>szolgáltatásaink</strong></h2>
        <div class="ltv-related__grid ltv-reveal">
          <?php foreach ( $latoter_related as $latoter_rslug => $latoter_rtitle ) : ?>
          <a href="<?php echo esc_url( latoter_service_link( $latoter_rslug ) ); ?>" class="ltv-related__card"><?php echo esc_html( $latoter_rtitle ); ?> <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
	<?php endif; ?>

	<?php
endwhile;

get_footer();
