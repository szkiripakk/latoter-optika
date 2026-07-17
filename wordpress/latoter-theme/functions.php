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

	// Megosztott stílusrendszer (a teljes dizájn; dokumentáció: STYLE.md a repóban).
	wp_enqueue_style( 'latoter-ltv', get_template_directory_uri() . '/assets/ltv.css', array( 'latoter-fonts' ), '1.3.0' );

	// A téma style.css (WordPress miatt kötelező; a fő CSS az assets/ltv.css-ben van).
	wp_enqueue_style( 'latoter-style', get_stylesheet_uri(), array( 'latoter-ltv' ), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'latoter_assets' );

/**
 * Szolgáltatás-oldalak: slug => megjelenő cím. A menü, a főoldali bento és a
 * kapcsolódó szolgáltatások is ebből épülnek – itt lehet a sorrendet állítani.
 *
 * @return array
 */
function latoter_service_pages() {
	return array(
		'egyedi-szemuvegkeszites'    => 'Egyedi szemüvegkészítés',
		'napszemuvegek'              => 'Napszemüvegek',
		'gyors-javitas-es-beallitas' => 'Gyors javítás és beállítás',
		'latasvizsgalat'             => 'Látásvizsgálat',
		'premium-keretek'            => 'Prémium keretek',
	);
}

/**
 * Egy szolgáltatás-oldal linkje a slug alapján. Ha az oldal még nincs
 * létrehozva, a főoldal szolgáltatások szekciójára mutat.
 *
 * @param string $slug
 * @return string
 */
function latoter_service_link( $slug ) {
	$page = get_page_by_path( $slug );
	if ( $page instanceof WP_Post ) {
		return get_permalink( $page );
	}
	return home_url( '/#szolgaltatasok' );
}

/**
 * Szolgáltatás-oldal alap hero-képe (ha nincs beállítva kiemelt kép).
 *
 * @param string $slug
 * @return string
 */
function latoter_service_hero_image( $slug ) {
	$map = array(
		'egyedi-szemuvegkeszites'    => 'svc-egyedi-hero.jpg',
		'napszemuvegek'              => 'svc-napszemuveg-hero.jpg',
		'gyors-javitas-es-beallitas' => 'opt-family-fitting.png',
		'latasvizsgalat'             => 'svc-latasvizsgalat-hero.jpg',
		'premium-keretek'            => 'svc-premium-hero.jpg',
	);
	$file = isset( $map[ $slug ] ) ? $map[ $slug ] : 'svc-egyedi-hero.jpg';
	return get_template_directory_uri() . '/images/' . $file;
}

/**
 * A szolgáltatás-oldalak kezdő tartalma (Gutenberg-blokkok, szerkeszthető).
 *
 * @return array slug => array( title, excerpt, content )
 */
function latoter_service_definitions() {
	$defs = array();

	$defs['egyedi-szemuvegkeszites'] = array(
		'Egyedi szemüvegkészítés',
		'Olyan szemüveget készítünk, amit öröm hordani – kerettől a lencséig minden az Ön szeméhez igazítva.',
		"<!-- wp:paragraph --><p>Nálunk a szemüveg nem polcról leemelt termék, hanem <strong>személyre szabott munka</strong>. A pontos látásvizsgálat után közösen választjuk ki a keretet és a lencsét, majd jól felszerelt műhelyünkben, helyben készítjük el – így a végeredmény tökéletesen illeszkedik az arcához, a látásához és az életviteléhez.</p><!-- /wp:paragraph -->\n<!-- wp:paragraph --><p>Legyen szó első szemüvegről, multifokális lencséről vagy egy régi kedvenc újragondolásáról, végigkísérjük a folyamaton, és őszintén elmondjuk, mi az, ami valóban Önnek való.</p><!-- /wp:paragraph -->\n<!-- wp:heading --><h2>Amit az <strong>egyediség</strong> jelent nálunk</h2><!-- /wp:heading -->\n<!-- wp:list --><ul><li>Pontos, modern műszeres látásvizsgálat</li><li>A lencse a keret formájához és a pupillatávolságához csiszolva</li><li>Helyben, a saját műhelyünkben készítjük</li><li>Őszinte tanácsadás – azt ajánljuk, ami Önnek jó</li></ul><!-- /wp:list -->\n<!-- wp:heading --><h2>Így készül el az <strong>Ön szemüvege</strong></h2><!-- /wp:heading -->\n<!-- wp:list {\"ordered\":true} --><ol><li>Látásvizsgálat és igényfelmérés</li><li>Keret- és lencseválasztás közösen</li><li>Helyben elkészítjük</li><li>Az arcára igazítjuk és átadjuk</li></ol><!-- /wp:list -->",
	);

	$defs['napszemuvegek'] = array(
		'Napszemüvegek',
		'UV400 szűrős és polarizált lencsék, akár saját dioptriával – hogy a vízparti nyár tényleg felhőtlen legyen.',
		"<!-- wp:paragraph --><p>A Balaton partján a nap kétszer süt: egyszer az égről, egyszer a vízfelszínről visszaverődve. Egy jó napszemüveg ezért nemcsak stílus kérdése, hanem <strong>szemvédelem</strong> is. Nálunk olyan darabot talál, amely valóban szűri a káros UV-sugárzást, nem csak sötétít.</p><!-- /wp:paragraph -->\n<!-- wp:paragraph --><p>Válasszon divatos kész napszemüveget, vagy kérje <strong>saját dioptriájával</strong> – így vezetés, strandolás vagy városi séta közben is élesen és védetten lát.</p><!-- /wp:paragraph -->\n<!-- wp:heading --><h2>Amire a nyáron <strong>szüksége van</strong></h2><!-- /wp:heading -->\n<!-- wp:list --><ul><li>UV400 védelem a káros sugárzás ellen</li><li>Polarizált lencsék a zavaró csillogás ellen</li><li>Napvédő lencse saját dioptriával is</li><li>Divatos márkák: Ray-Ban, Oakley, Carrera, Police és mások</li></ul><!-- /wp:list -->\n<!-- wp:paragraph --><p>Gyerekméretek és szemüvegre húzható klipszes megoldások is nálunk – segítünk megtalálni az arcformájához illőt.</p><!-- /wp:paragraph -->",
	);

	$defs['gyors-javitas-es-beallitas'] = array(
		'Gyors javítás és beállítás',
		'Eltört a szár? Meglazult a csavar? Nyaralás közben is megoldjuk – sokszor még aznap.',
		"<!-- wp:paragraph --><p>Egy szemüveg akkor romlik el, amikor a legkevésbé sem várná – pont a nyaralás közepén. Nálunk nem kell hetekig várnia: a legtöbb <strong>apró hibát helyben, gyorsan</strong> orvosoljuk, hogy tisztán lásson tovább.</p><!-- /wp:paragraph -->\n<!-- wp:paragraph --><p>Akár nálunk készült a szemüveg, akár máshol vette, hozza be nyugodtan – megnézzük, és őszintén megmondjuk, mi a helyzet vele.</p><!-- /wp:paragraph -->\n<!-- wp:heading --><h2>Miben tudunk <strong>segíteni</strong></h2><!-- /wp:heading -->\n<!-- wp:list --><ul><li>Törött vagy meglazult szár, csuklópánt javítása, cseréje</li><li>Meglazult csavar utánahúzása, pótlása</li><li>Orrtámasz csere a kényelemért</li><li>Elgörbült keret visszaigazítása</li></ul><!-- /wp:list -->\n<!-- wp:paragraph --><p>A nálunk vásárolt szemüvegek utánállítása ingyenes, és igény szerint ultrahangos tisztítást is vállalunk. Ha valamit nem éri meg javítani, azt is őszintén elmondjuk.</p><!-- /wp:paragraph -->",
	);

	$defs['latasvizsgalat'] = array(
		'Látásvizsgálat',
		'Szakértő optometristáink modern műszerekkel, alaposan és nyugodt tempóban mérik fel a látását.',
		"<!-- wp:paragraph --><p>A jó szemüveg alapja a <strong>pontos látásvizsgálat</strong>. Nálunk nem sietünk el semmit: végigbeszéljük, hogyan használja a szemét a mindennapokban – olvasás, képernyő, vezetés, sport –, és ehhez mérjük fel a látását.</p><!-- /wp:paragraph -->\n<!-- wp:paragraph --><p>A vizsgálat <strong>fájdalommentes és gyors</strong>, mégis alapos. A végén érthetően elmagyarázzuk az eredményt, és megbeszéljük, milyen megoldás illik leginkább Önhöz.</p><!-- /wp:paragraph -->\n<!-- wp:heading --><h2>Hogyan zajlik a <strong>vizsgálat</strong></h2><!-- /wp:heading -->\n<!-- wp:list {\"ordered\":true} --><ol><li>Beszélgetés az igényeiről és panaszairól</li><li>Műszeres mérés kiindulásként</li><li>Finomhangolás próbalencsékkel</li><li>Eredmény és javaslat érthetően</li></ol><!-- /wp:list -->\n<!-- wp:heading --><h2>Kinek ajánljuk a <strong>rendszeres</strong> szűrést?</h2><!-- /wp:heading -->\n<!-- wp:list --><ul><li>Ha régen készült az utolsó vizsgálata</li><li>Ha sokat dolgozik képernyő előtt</li><li>Ha fejfájást, fáradt szemet tapasztal</li><li>Ha új szemüveget vagy kontaktlencsét szeretne</li></ul><!-- /wp:list -->",
	);

	$defs['premium-keretek'] = array(
		'Prémium keretek',
		'Gondosan válogatott kollekció a legmegbízhatóbb gyártóktól – korrekt áron, hogy megérje felpróbálni.',
		"<!-- wp:paragraph --><p>Egy jó keret évekig hűséges társ: kényelmes, tartós, és jól áll. Kínálatunkat úgy állítjuk össze, hogy csak olyan darabok kerüljenek a polcra, amelyeket <strong>mi magunk is szívesen hordanánk</strong> – minőségi anyagok, precíz megmunkálás, időtálló és divatos formák.</p><!-- /wp:paragraph -->\n<!-- wp:paragraph --><p>A prémium nálunk nem a legdrágábbat jelenti, hanem a <strong>legjobb választást</strong> az Ön arcához, stílusához és keretéhez. Segítünk eligazodni, és őszintén megmondjuk, mi áll jól.</p><!-- /wp:paragraph -->\n<!-- wp:heading --><h2>Amiért <strong>megéri</strong> nálunk választani</h2><!-- /wp:heading -->\n<!-- wp:list --><ul><li>Több mint 20 megbízható márka – Ray-Ban, Carrera, Lacoste, Hugo Boss és mások</li><li>Minőségi anyagok: acetát, titán, rugalmas keretek</li><li>Az arcformájához illő forma és szín</li><li>Átlátható, korrekt árak meglepetések nélkül</li></ul><!-- /wp:list -->\n<!-- wp:paragraph --><p>Női, férfi és gyerekkeretek minden korosztálynak. Próbálja fel nyugodtan – a kiválasztott keretbe helyben tesszük a lencsét.</p><!-- /wp:paragraph -->",
	);

	return $defs;
}

/**
 * Szolgáltatás-oldal extra szekciói (a statikus oldalak megfelelői):
 * összehasonlító kártyák, vélemények, statisztika, GYIK, kép-marquee, bento,
 * márka-logósáv – slugonként. A törzs (the_content) és ezek együtt adják ki az
 * oldalt. A dizájn az assets/ltv.css közös komponenseiből épül.
 *
 * @param string $slug
 */
function latoter_service_extra_sections( $slug ) {
	$tpl = get_template_directory_uri();

	if ( 'egyedi-szemuvegkeszites' === $slug ) :
		?>
    <section class="ltv-section ltv-about" style="padding-top: clamp(3rem,6vw,4.5rem); padding-bottom: clamp(3rem,6vw,4.5rem);">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal">Lencsék minden <strong>igényhez</strong></h2>
        <p class="ltv-section__lead ltv-reveal">Segítünk kiválasztani a látásához és életviteléhez illő lencsét.</p>
        <div class="ltv-compare">
          <div class="ltv-compare__card ltv-reveal"><h3 class="ltv-compare__title">Egyfókuszú</h3><p class="ltv-compare__tag">Tiszta látás egy távolságra</p><ul class="ltv-compare__list"><li>Távolra vagy olvasáshoz</li><li>Vékonyított kivitel is</li><li>Karcálló bevonattal</li></ul></div>
          <div class="ltv-compare__card ltv-reveal"><h3 class="ltv-compare__title">Multifokális</h3><p class="ltv-compare__tag">Közel és távol egyben</p><ul class="ltv-compare__list"><li>Zökkenőmentes átmenet</li><li>Nincs több cserélgetés</li><li>Tág, kényelmes látómezők</li></ul></div>
          <div class="ltv-compare__card ltv-reveal"><h3 class="ltv-compare__title">Kékfény-szűrő</h3><p class="ltv-compare__tag">Képernyő előtt is kímélő</p><ul class="ltv-compare__list"><li>Csökkenti a szemfáradást</li><li>Monitoros munkához ideális</li><li>Bármely lencsére kérhető</li></ul></div>
        </div>
      </div>
    </section>
    <section class="ltv-section">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal">Amit <strong>ügyfeleink</strong> mondanak</h2>
        <div class="ltv-reviews">
          <div class="ltv-review ltv-reveal"><div class="ltv-review__stars" aria-label="5 / 5 csillag">★★★★★</div><p class="ltv-review__text">„Türelmesen végigvezettek a keret- és lencseválasztáson, a szemüveg pár nap alatt elkészült. Nagyon elégedett vagyok."</p><p class="ltv-review__author">Kovács Anna</p></div>
          <div class="ltv-review ltv-reveal"><div class="ltv-review__stars" aria-label="5 / 5 csillag">★★★★★</div><p class="ltv-review__text">„Végre olyan szemüveget kaptam, ami tényleg kényelmes és jól is áll. Korrekt árak, kedves kiszolgálás."</p><p class="ltv-review__author">Nagy Péter</p></div>
          <div class="ltv-review ltv-reveal"><div class="ltv-review__stars" aria-label="5 / 5 csillag">★★★★★</div><p class="ltv-review__text">„Az egész családnak itt készítjük a szemüveget. Precíz munka, barátságos hangulat – csak ajánlani tudom."</p><p class="ltv-review__author">Szabó Judit</p></div>
        </div>
      </div>
    </section>
		<?php
	elseif ( 'napszemuvegek' === $slug ) :
		?>
    <section class="ltv-section ltv-about" style="padding-top: clamp(3rem,6vw,4.5rem); padding-bottom: clamp(3rem,6vw,4.5rem);">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal">Milyen <strong>lencsét</strong> válasszon?</h2>
        <p class="ltv-section__lead ltv-reveal">Nem mindegy, mi kerül a napszemüvegébe – segítünk eligazodni.</p>
        <div class="ltv-compare">
          <div class="ltv-compare__card ltv-reveal"><h3 class="ltv-compare__title">UV400</h3><p class="ltv-compare__tag">Alapvető szemvédelem</p><ul class="ltv-compare__list"><li>Kiszűri a káros UV-sugárzást</li><li>Minden napszemüvegünk alapja</li><li>Gyerekeknek is ajánlott</li></ul></div>
          <div class="ltv-compare__card ltv-reveal"><h3 class="ltv-compare__title">Polarizált</h3><p class="ltv-compare__tag">Csillogásmentes látás</p><ul class="ltv-compare__list"><li>Kioltja a vízről visszaverődő fényt</li><li>Vezetéshez, vízparthoz ideális</li><li>Kevésbé fárad a szem</li></ul></div>
          <div class="ltv-compare__card ltv-reveal"><h3 class="ltv-compare__title">Fotokromatikus</h3><p class="ltv-compare__tag">Fényre sötétedő</p><ul class="ltv-compare__list"><li>Kültéren sötétedik, bent kivilágosodik</li><li>Egy szemüveg két helyzetre</li><li>Dioptriával is kérhető</li></ul></div>
        </div>
      </div>
    </section>
    <section class="ltv-section">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal" style="margin-bottom: 2rem !important;">Kedvenc <strong>napszemüveg-márkák</strong></h2>
        <div class="ltv-logostrip ltv-reveal">
          <img src="<?php echo esc_url( $tpl . '/images/brands/ray-ban.png' ); ?>" alt="Ray-Ban" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/oakley.png' ); ?>" alt="Oakley" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/police.png' ); ?>" alt="Police" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/carrera.png' ); ?>" alt="Carrera" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/polaroid.png' ); ?>" alt="Polaroid" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/guess.png' ); ?>" alt="Guess" loading="lazy" onerror="this.remove()" />
        </div>
      </div>
    </section>
		<?php
	elseif ( 'gyors-javitas-es-beallitas' === $slug ) :
		?>
    <section class="ltv-section ltv-about" style="padding-top: clamp(3rem,6vw,4.5rem); padding-bottom: clamp(3rem,6vw,4.5rem);">
      <div class="ltv-container">
        <div class="ltv-stats">
          <div class="ltv-stat ltv-reveal"><div class="ltv-stat__num">Aznap</div><p class="ltv-stat__label">A legtöbb javítás megvárható</p></div>
          <div class="ltv-stat ltv-reveal"><div class="ltv-stat__num">Ingyenes</div><p class="ltv-stat__label">Utánállítás a nálunk vásárolt szemüvegre</p></div>
          <div class="ltv-stat ltv-reveal"><div class="ltv-stat__num">Bármi</div><p class="ltv-stat__label">Máshol vett szemüveget is megnézünk</p></div>
        </div>
      </div>
    </section>
    <section class="ltv-section">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal">Gyakori <strong>kérdések</strong></h2>
        <p class="ltv-section__lead ltv-reveal">A leggyakoribb kérdések a javításról és beállításról.</p>
        <div class="ltv-faq ltv-reveal">
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Kell előre időpontot kérnem egy javításhoz? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">Nem, a kisebb javításokhoz elég, ha benéz nyitvatartási időben – a legtöbbet néhány perc alatt, helyben megoldjuk.</div></details>
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Máshol vásárolt szemüveget is megjavítanak? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">Igen. Hozza be nyugodtan, megnézzük, és őszintén megmondjuk, mit tudunk vele kezdeni és mennyiért.</div></details>
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Mennyibe kerül egy javítás vagy beállítás? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">A beállítás és a nálunk vásárolt szemüvegek utánállítása ingyenes. Egyéb javításnál a felmérés után, előre megmondjuk az árat.</div></details>
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Nyaralás közben eltört a szemüvegem – tudnak segíteni? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">Ez a szakterületünk. Siófok szívében vagyunk, és a legtöbb hibát még aznap orvosoljuk, hogy folytathassa a pihenést.</div></details>
        </div>
      </div>
    </section>
		<?php
	elseif ( 'latasvizsgalat' === $slug ) :
		?>
    <section class="ltv-section ltv-about" style="padding-top: clamp(3rem,6vw,4.5rem); padding-bottom: clamp(3rem,6vw,4.5rem);">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal">Gyakori <strong>kérdések</strong></h2>
        <p class="ltv-section__lead ltv-reveal">Amit a látásvizsgálatról tudni érdemes.</p>
        <div class="ltv-faq ltv-reveal">
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Meddig tart egy látásvizsgálat? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">Általában 20–30 perc, de nem sürgetünk – annyi időt szánunk rá, amennyi a pontos eredményhez kell.</div></details>
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Kell előre időpontot foglalni? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">Ajánljuk, hogy ne kelljen várnia. Foglaljon online a Clearvisio rendszerében, vagy hívjon minket telefonon.</div></details>
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Fáj vagy kellemetlen a vizsgálat? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">Egyáltalán nem. A vizsgálat teljesen fájdalommentes, csak néhány kényelmes lépésből áll.</div></details>
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Milyen gyakran érdemes ellenőriztetni a látásomat? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">Panasz nélkül is 1–2 évente ajánlott. Ha fejfájást, fáradt szemet tapasztal, ne várjon vele.</div></details>
          <details class="ltv-faq__item"><summary class="ltv-faq__q">Gyermekem látását is megvizsgálják? <span class="ltv-faq__icon" aria-hidden="true"></span></summary><div class="ltv-faq__a">Igen, minden korosztályt szívesen látunk, és a legkisebbekre is türelmesen figyelünk.</div></details>
        </div>
      </div>
    </section>
    <section class="ltv-gallery" aria-label="Életképek az üzletből">
      <div class="ltv-gallery__track" id="ltv-gallery-track">
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $tpl . '/images/opt-frame-presentation.png' ); ?>" alt="Optikus kereteket mutat" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $tpl . '/images/exec-service.png' ); ?>" alt="Szakértő tanácsadás az üzletben" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $tpl . '/images/opt-mirror-new-look.png' ); ?>" alt="Hölgy az új szemüvegében a tükörben" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $tpl . '/images/exec-woman-city.png' ); ?>" alt="Elegáns hölgy szemüvegben" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $tpl . '/images/exec-man-cafe.png' ); ?>" alt="Férfi szemüvegben egy kávézóban" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $tpl . '/images/exec-senior.png' ); ?>" alt="Elégedett idős vásárló" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $tpl . '/images/opt-fitting-consultation.png' ); ?>" alt="Személyes tanácsadás az üzletben" loading="lazy" /></div>
        <div class="ltv-gallery__item"><img src="<?php echo esc_url( $tpl . '/images/exec-storefront.png' ); ?>" alt="A Látótér Optika üzlete" loading="lazy" /></div>
      </div>
    </section>
		<?php
	elseif ( 'premium-keretek' === $slug ) :
		?>
    <section class="ltv-section">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal">Minden <strong>stílushoz</strong> és korosztályhoz</h2>
        <p class="ltv-section__lead ltv-reveal">Válogatott keretek, amelyekben mindenki megtalálja a magáét.</p>
        <div class="ltv-bento">
          <div class="ltv-bento__cell ltv-bento__cell--main ltv-reveal"><img src="<?php echo esc_url( $tpl . '/images/exec-woman-city.png' ); ?>" alt="Elegáns hölgy szemüvegben a városban" class="ltv-bento__photo" loading="lazy" /><div class="ltv-bento__veil"></div><div class="ltv-bento__content"><h3 class="ltv-bento__title"><strong>Klasszikus</strong> elegancia</h3><p class="ltv-bento__desc">Időtálló formák, letisztult vonalak – a hétköznapokra és az ünnepekre egyaránt.</p></div></div>
          <div class="ltv-bento__cell ltv-bento__cell--img ltv-reveal"><img src="<?php echo esc_url( $tpl . '/images/exec-man-cafe.png' ); ?>" alt="Férfi szemüvegben egy kávézóban" class="ltv-bento__photo" loading="lazy" /><div class="ltv-bento__veil"></div><div class="ltv-bento__content"><h3 class="ltv-bento__title">Modern, férfias</h3><p class="ltv-bento__desc">Határozott keretek a mindennapokra.</p></div></div>
          <div class="ltv-bento__cell ltv-bento__cell--a ltv-reveal"><img src="<?php echo esc_url( $tpl . '/images/exec-youth-balaton.png' ); ?>" alt="Fiatalok szemüvegben a Balatonnál" class="ltv-bento__photo" loading="lazy" /><div class="ltv-bento__veil"></div><div class="ltv-bento__content"><h3 class="ltv-bento__title">Fiatalos, sportos</h3><p class="ltv-bento__desc">Könnyű, strapabíró darabok.</p></div></div>
          <div class="ltv-bento__cell ltv-bento__cell--b ltv-reveal"><img src="<?php echo esc_url( $tpl . '/images/exec-senior.png' ); ?>" alt="Elégedett idős vásárló szemüvegben" class="ltv-bento__photo" loading="lazy" /><div class="ltv-bento__veil"></div><div class="ltv-bento__content"><h3 class="ltv-bento__title">Kényelmes, időtálló</h3><p class="ltv-bento__desc">Minden generációnak.</p></div></div>
          <div class="ltv-bento__cell ltv-bento__cell--c ltv-reveal"><img src="<?php echo esc_url( $tpl . '/images/exec-man-balaton.png' ); ?>" alt="Férfi napszemüvegben a Balaton partján" class="ltv-bento__photo" loading="lazy" /><div class="ltv-bento__veil"></div><div class="ltv-bento__content"><h3 class="ltv-bento__title"><strong>Napszemüveg</strong> dioptriával</h3><p class="ltv-bento__desc">Prémium napszemüveg-keretek, akár saját dioptriával – a vízparti nyárra.</p></div></div>
        </div>
      </div>
    </section>
    <section class="ltv-section ltv-about" style="padding-top: clamp(3rem,6vw,4.5rem); padding-bottom: clamp(3rem,6vw,4.5rem);">
      <div class="ltv-container">
        <h2 class="ltv-section__title ltv-reveal" style="margin-bottom: 2rem !important;">Néhány <strong>keretmárkánk</strong></h2>
        <div class="ltv-logostrip ltv-reveal">
          <img src="<?php echo esc_url( $tpl . '/images/brands/ray-ban.png' ); ?>" alt="Ray-Ban" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/carrera.png' ); ?>" alt="Carrera" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/lacoste.png' ); ?>" alt="Lacoste" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/boss.png' ); ?>" alt="Boss" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/tom-tailor.png' ); ?>" alt="Tom Tailor" loading="lazy" onerror="this.remove()" />
          <img src="<?php echo esc_url( $tpl . '/images/brands/ralph-lauren.png' ); ?>" alt="Ralph Lauren" loading="lazy" onerror="this.remove()" />
        </div>
      </div>
    </section>
		<?php
	endif;
}

/**
 * Egyszeri beállítás: létrehozza a Főoldalt és az 5 szolgáltatás-oldalt,
 * beállítja a statikus előlapot, és a szolgáltatásokhoz hozzárendeli a
 * "Szolgáltatás oldal" sablont. Idempotens: ami már létezik, azt nem bántja.
 */
function latoter_provision_pages() {
	if ( wp_installing() ) {
		return;
	}
	if ( '2' === get_option( 'latoter_pages_provisioned' ) ) {
		return;
	}

	// 1) Statikus előlap ("Főoldal").
	$front = get_page_by_path( 'fooldal' );
	if ( ! ( $front instanceof WP_Post ) ) {
		$front_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_name'    => 'fooldal',
				'post_title'   => 'Főoldal',
				'post_content' => '<!-- wp:paragraph --><p>Ez az oldal a webhely előlapja. A főoldal megjelenését a téma vezérli, a szövegeket a <strong>Megjelenés → Testreszabás</strong> alatt szerkesztheti.</p><!-- /wp:paragraph -->',
			)
		);
	} else {
		$front_id = $front->ID;
	}
	if ( $front_id && ! is_wp_error( $front_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $front_id );
	}

	// 2) Szolgáltatás-oldalak.
	$order = 1;
	foreach ( latoter_service_definitions() as $slug => $def ) {
		$existing = get_page_by_path( $slug );
		if ( $existing instanceof WP_Post ) {
			if ( 'page-szolgaltatas.php' !== get_post_meta( $existing->ID, '_wp_page_template', true ) ) {
				update_post_meta( $existing->ID, '_wp_page_template', 'page-szolgaltatas.php' );
			}
			$order++;
			continue;
		}
		$new_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => $def[0],
				'post_excerpt' => $def[1],
				'post_content' => $def[2],
				'menu_order'   => $order,
			)
		);
		if ( $new_id && ! is_wp_error( $new_id ) ) {
			update_post_meta( $new_id, '_wp_page_template', 'page-szolgaltatas.php' );
		}
		$order++;
	}

	update_option( 'latoter_pages_provisioned', '2' );
	flush_rewrite_rules( false );
}
add_action( 'wp_loaded', 'latoter_provision_pages' );

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
 * Márkanévből fájlnév-barát "slug" (a logó fájlnevéhez).
 * Pl. "Ray-Ban" => "ray-ban", "Pull&Bear" => "pull-and-bear", "O'Neil" => "oneil".
 *
 * @param string $name
 * @return string
 */
function latoter_brand_slug( $name ) {
	$slug = str_replace( array( '&', "'" ), array( ' and ', '' ), (string) $name );
	$slug = strtolower( $slug );
	$slug = preg_replace( '/[^a-z0-9]+/', '-', $slug );
	return trim( $slug, '-' );
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
