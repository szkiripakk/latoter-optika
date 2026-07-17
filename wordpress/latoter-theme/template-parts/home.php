<?php
/**
 * Főoldal tartalma (a <main> belseje). A get_header() nyitja a <main>-t,
 * a get_footer() zárja. Tartalom: Testreszabóból (Customizer).
 *
 * @package latoter-optika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$latoter_tpl = get_template_directory_uri();

// Bento-cellák -> szolgáltatás-oldalak (slug).
$latoter_more = '<span class="ltv-bento__more">Részletek <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
?>

    <!-- 1 · HERO -->
    <section class="ltv-hero">
      <img src="<?php echo esc_url( $latoter_tpl . '/images/exec-balaton-promenade.png' ); ?>" alt="Napsütéses balatoni sétány Siófokon" class="ltv-hero__bg" loading="eager" />
      <div class="ltv-hero__scrim"></div>
      <div class="ltv-hero__inner ltv-container">
        <div class="ltv-hero__card">
          <span class="ltv-eyebrow"><?php echo esc_html( get_theme_mod( 'latoter_hero_eyebrow', 'Optika a Balaton partján' ) ); ?></span>
          <h1 class="ltv-hero__title"><?php echo esc_html( get_theme_mod( 'latoter_hero_title_1', 'Éles látás,' ) ); ?><br /><strong><?php echo esc_html( get_theme_mod( 'latoter_hero_title_2', 'szakértelemmel és gyorsasággal' ) ); ?></strong></h1>
          <p class="ltv-hero__sub"><?php echo esc_html( get_theme_mod( 'latoter_hero_sub', 'Személyre szabott szemüvegek, minőségi lencsék és egyedi keretek minden korosztály számára Siófok szívében.' ) ); ?></p>
          <div class="ltv-hero__ctas">
            <a href="#foglalas" class="ltv-btn ltv-btn--solid">Időpontot foglalok</a>
            <a href="#szolgaltatasok" class="ltv-btn ltv-btn--glass">Szolgáltatásaink</a>
          </div>
        </div>
      </div>
    </section>

    <!-- 2 · ÉRTÉKSÁV -->
    <div class="ltv-strip">
      <div class="ltv-container">
        <div class="ltv-strip__row">
          <div class="ltv-strip__item">Nyitva a teljes szezonban<em>hétfőtől szombatig</em></div>
          <div class="ltv-strip__item">Javítás akár megvárható<em>nyaralás közben is</em></div>
          <div class="ltv-strip__item">Dioptriás napszemüvegek<em>polaroid és UV szűrővel ellátva</em></div>
          <div class="ltv-strip__item">20+ megbízható márka<em>minden stílushoz</em></div>
        </div>
      </div>
    </div>

    <!-- 3 · SZOLGÁLTATÁSOK · bento (kattintható kártyák) -->
    <section id="szolgaltatasok" class="ltv-section">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal">Amiben igazán <strong>jók</strong> vagyunk</h2>
        <p class="ltv-section__lead ltv-reveal">Segítünk megtalálni a megfelelő keretet és lencsét, mindezt rövid időn belül.<br />Ami elromlott megjavítjuk, ami hiányzik elkészítjük.</p>

        <div class="ltv-bento">
          <a href="<?php echo esc_url( latoter_service_link( 'egyedi-szemuvegkeszites' ) ); ?>" class="ltv-bento__cell ltv-bento__cell--main ltv-reveal">
            <img src="<?php echo esc_url( $latoter_tpl . '/images/opt-fitting-consultation.png' ); ?>" alt="Személyes szemüveg-tanácsadás az üzletben" class="ltv-bento__photo" loading="lazy" />
            <div class="ltv-bento__veil"></div>
            <div class="ltv-bento__content">
              <h3 class="ltv-bento__title"><strong>Egyedi</strong> szemüvegkészítés</h3>
              <p class="ltv-bento__desc">Precíz látásvizsgálat után olyan szemüveget készítünk, amit öröm hordani. Kerettől a lencséig minden az Ön szeméhez igazítva.</p>
              <?php echo $latoter_more; // phpcs:ignore ?>
            </div>
          </a>

          <a href="<?php echo esc_url( latoter_service_link( 'napszemuvegek' ) ); ?>" class="ltv-bento__cell ltv-bento__cell--img ltv-reveal">
            <img src="<?php echo esc_url( $latoter_tpl . '/images/opt-sunglasses-wall.png' ); ?>" alt="Vásárlók napszemüveget válogatnak az üzletben" class="ltv-bento__photo" loading="lazy" />
            <div class="ltv-bento__veil"></div>
            <div class="ltv-bento__content">
              <h3 class="ltv-bento__title">Napszemüvegek</h3>
              <p class="ltv-bento__desc">UV400 szűrős lencsék, akár saját dioptriával. A vízparti nyár kötelező kelléke.</p>
              <?php echo $latoter_more; // phpcs:ignore ?>
            </div>
          </a>

          <a href="<?php echo esc_url( latoter_service_link( 'gyors-javitas-es-beallitas' ) ); ?>" class="ltv-bento__cell ltv-bento__cell--a ltv-reveal">
            <img src="<?php echo esc_url( $latoter_tpl . '/images/opt-family-fitting.png' ); ?>" alt="Szülők szemüveget igazítanak lányuk orrán" class="ltv-bento__photo" loading="lazy" />
            <div class="ltv-bento__veil"></div>
            <div class="ltv-bento__content">
              <h3 class="ltv-bento__title"><strong>Gyors</strong> javítás és beállítás</h3>
              <p class="ltv-bento__desc">Eltört a szár? Meglazult a csavar? Nyaralás közben is megoldjuk, sokszor még aznap.</p>
              <?php echo $latoter_more; // phpcs:ignore ?>
            </div>
          </a>

          <a href="<?php echo esc_url( latoter_service_link( 'latasvizsgalat' ) ); ?>" class="ltv-bento__cell ltv-bento__cell--b ltv-reveal">
            <img src="<?php echo esc_url( $latoter_tpl . '/images/opt-frame-presentation.png' ); ?>" alt="Optikus szemüvegkereteket mutat egy vásárlónak" class="ltv-bento__photo" loading="lazy" />
            <div class="ltv-bento__veil"></div>
            <div class="ltv-bento__content">
              <h3 class="ltv-bento__title">Látásvizsgálat</h3>
              <p class="ltv-bento__desc">Szakértő optometristáink modern műszerekkel végzik a látásvizsgálatot.</p>
              <?php echo $latoter_more; // phpcs:ignore ?>
            </div>
          </a>

          <a href="<?php echo esc_url( latoter_service_link( 'premium-keretek' ) ); ?>" class="ltv-bento__cell ltv-bento__cell--c ltv-reveal">
            <img src="<?php echo esc_url( $latoter_tpl . '/images/opt-premium-frame.png' ); ?>" alt="Hölgy prémium szemüvegkeretet vizsgál" class="ltv-bento__photo" loading="lazy" />
            <div class="ltv-bento__veil"></div>
            <div class="ltv-bento__content">
              <h3 class="ltv-bento__title"><strong>Prémium</strong> keretek</h3>
              <p class="ltv-bento__desc">Gondosan válogatott kollekció a legmegbízhatóbb gyártóktól, korrekt áron. Megéri felpróbálni.</p>
              <?php echo $latoter_more; // phpcs:ignore ?>
            </div>
          </a>
        </div>
      </div>
    </section>

    <!-- 4 · RÓLUNK -->
    <section id="rolunk" class="ltv-section ltv-about">
      <div class="ltv-container">
        <div class="ltv-about__grid">
          <div class="ltv-about__imgs ltv-reveal">
            <img src="<?php echo esc_url( $latoter_tpl . '/images/exec-grandma.png' ); ?>" alt="Nagymama és unokája szemüvegben" loading="lazy" />
            <img src="<?php echo esc_url( $latoter_tpl . '/images/exec-family.png' ); ?>" alt="Család az optikában" loading="lazy" />
          </div>
          <div class="ltv-reveal">
            <h2 class="ltv-section__title">A <strong>jó hangulat</strong> nálunk alapfelszereltség</h2>
            <p class="ltv-about__body">Családi vállalkozásként hiszünk abban, hogy minden szemüveg egyedi, ahogyan viselője is. Fontos, hogy mindenki számára megtaláljuk a tökéletes keretet a megfelelő lencsével. Jól felszerelt műhelyünkben precízen, helyben készítjük el szemüvegeinket.</p>
            <ul class="ltv-about__list">
              <li>Személyre szabott tanácsadás</li>
              <li>Helyben készített szemüvegek</li>
              <li>Minden generációt szívesen látunk</li>
              <li>Korrekt árak, meglepetések nélkül</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 5 · GALÉRIA MARQUEE -->
    <section class="ltv-gallery" aria-label="Életképek">
      <div class="ltv-gallery__track" id="ltv-gallery-track">
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/exec-woman-city.png' ); ?>" alt="Elegáns hölgy szemüvegben a városban" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/exec-friends-sunset.png' ); ?>" alt="Barátok a balatoni naplementében" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/opt-mirror-mother-daughter.png' ); ?>" alt="Anya és lánya közösen választanak szemüveget" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/exec-man-cafe.png' ); ?>" alt="Férfi szemüvegben egy kávézóban" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/exec-youth-balaton.png' ); ?>" alt="Fiatalok a Balatonnál" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/opt-mirror-new-look.png' ); ?>" alt="Hölgy megcsodálja új szemüvegét a tükörben" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/exec-senior.png' ); ?>" alt="Elégedett vásárló" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/exec-man-balaton.png' ); ?>" alt="Férfi napszemüvegben a Balaton partján" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/exec-storefront.png' ); ?>" alt="A Látótér Optika üzlete" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $latoter_tpl . '/images/exec-service.png' ); ?>" alt="Szakértő tanácsadás az üzletben" loading="lazy" /></div>
      </div>
    </section>

    <!-- 6 · MÁRKÁK -->
    <section id="markak" class="ltv-section ltv-brands">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal">Márkák, amikben <strong>megbízunk</strong></h2>
        <p class="ltv-section__lead ltv-reveal">Csak olyan keretet és lencsét adunk a kezébe, amit mi magunk is szívesen hordanánk.</p>
        <div class="ltv-brands__grid ltv-reveal" id="ltv-brands">
<?php
		$latoter_i = 0;
		foreach ( latoter_brands_list() as $latoter_brand ) :
			$latoter_slug   = latoter_brand_slug( $latoter_brand );
			$latoter_hidden = ( $latoter_i >= 12 ) ? ' is-hidden' : '';
			$latoter_logo   = get_template_directory_uri() . '/images/brands/' . $latoter_slug . '.png';
			?>
          <div class="ltv-brand<?php echo esc_attr( $latoter_hidden ); ?>"><img class="ltv-brand__logo" src="<?php echo esc_url( $latoter_logo ); ?>" alt="<?php echo esc_attr( $latoter_brand ); ?> logó" loading="lazy" onload="this.closest('.ltv-brand').classList.add('has-logo')" onerror="this.remove()"><span class="ltv-brand__name"><?php echo esc_html( $latoter_brand ); ?></span></div>
			<?php
			$latoter_i++;
		endforeach;
		?>
        </div>
        <div class="ltv-brands__more ltv-reveal">
          <button type="button" class="ltv-btn ltv-btn--glass" id="ltv-brands-toggle" aria-expanded="false">Összes márka</button>
        </div>
      </div>
    </section>

    <!-- 7 · NYÁRI SÁV -->
    <section class="ltv-band">
      <img src="<?php echo esc_url( $latoter_tpl . '/images/exec-friends-sunset.png' ); ?>" alt="Naplemente a Balatonnál" class="ltv-band__bg" loading="lazy" />
      <div class="ltv-band__scrim"></div>
      <div class="ltv-container">
        <div class="ltv-band__content ltv-reveal">
          <h2 class="ltv-band__title">A vízparton a nap <strong>kétszer süt</strong></h2>
          <p class="ltv-band__body">Stílusos napszemüvegeink UV400 védelemmel óvják szemeit. Polarizált lencséink csökkentik a vízfelszínről visszaverődő zavaró csillogást.<br />Napvédő lencséket pedig saját dioptriával is elkészítjük.</p>
        </div>
      </div>
    </section>

    <!-- 8 · IDŐPONTFOGLALÁS -->
    <section id="foglalas" class="ltv-section ltv-booking">
      <div class="ltv-container">
        <span class="ltv-eyebrow ltv-reveal">Online foglalás</span>
        <h2 class="ltv-section__title ltv-reveal">Pár kattintás, és <strong>várjuk</strong></h2>
        <p class="ltv-section__lead ltv-reveal">Foglaljon időpontot látásvizsgálatra vagy tanácsadásra a Clearvisio rendszerében, és érkezéskor már minden Önre vár.</p>
        <a href="<?php echo esc_url( get_theme_mod( 'latoter_booking_url', 'https://clearvis.io/hu/' ) ); ?>" target="_blank" rel="noopener noreferrer" class="ltv-btn ltv-btn--solid ltv-reveal">Kérjen időpontot</a>
        <p class="ltv-booking__explainer ltv-reveal">Kerülje el a sorbanállást!</p>
        <div class="ltv-reveal">
          <a href="tel:+36XXXXXXXXX" class="ltv-booking__phone" id="ltv-phone">+36 XX XXX XXXX</a>
          <p class="ltv-booking__note">Telefonon is szívesen segítünk nyitvatartási időben.</p>
        </div>
      </div>
    </section>

    <!-- 9 · KAPCSOLAT -->
    <section id="kapcsolat" class="ltv-section ltv-contact">
      <div class="ltv-container">
        <span class="ltv-eyebrow ltv-reveal">Kapcsolat</span>
        <h2 class="ltv-section__title ltv-reveal">Ugorjon be <strong>hozzánk</strong></h2>
        <div class="ltv-contact__grid" style="margin-top: 2.5rem;">
          <div class="ltv-reveal">
            <div class="ltv-contact__block">
              <p class="ltv-contact__label">Cím</p>
              <p class="ltv-contact__value"><?php echo esc_html( get_theme_mod( 'latoter_address', '8600 Siófok, Sió utca 6. Fsz. 1.' ) ); ?></p>
            </div>
            <div class="ltv-contact__block">
              <p class="ltv-contact__label">Telefon</p>
              <p class="ltv-contact__value"><a href="tel:+36XXXXXXXXX" id="ltv-contact-phone">+36 XX XXX XXXX</a></p>
            </div>
            <div class="ltv-contact__block">
              <p class="ltv-contact__label">E-mail</p>
              <p class="ltv-contact__value"><a href="mailto:info@latoteroptika.hu" id="ltv-contact-email">info@latoteroptika.hu</a></p>
            </div>
            <div class="ltv-contact__block">
              <p class="ltv-contact__label">Nyitvatartás</p>
              <table class="ltv-hours" id="ltv-hours"></table>
            </div>
          </div>
          <div class="ltv-contact__map ltv-reveal">
            <iframe
              src="https://www.google.com/maps?q=Si%C3%B3fok%2C%20Si%C3%B3%20utca%206&output=embed"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Látótér Optika térkép"
              aria-label="Térkép: Látótér Optika, Siófok, Sió utca 6."></iframe>
          </div>
        </div>
      </div>
    </section>
