# Látótér Optika — Stílus- és designrendszer

> **Ez a fájl a mérvadó.** Minden új oldalt és módosítást az itt leírt
> rendszer alapján kell felépíteni. A meglévő stílust (tokenek, komponensek,
> szabályok) **csak külön, kifejezett kérésre** szabad megváltoztatni.
>
> **Implementáció (kód):** `assets/ltv.css` (stílus) + `assets/ltv.js` (viselkedés).
> Ez a két fájl a rendszer egyetlen forrása; minden HTML-oldal ezekre hivatkozik.

---

## 0. Alapelvek

- **Beágyazható widget-szemlélet.** Minden CSS-szabály a `#ltv-wrap` konténer
  alá van scope-olva, és sok helyen `!important` védi a WordPress-témák
  felülírásaitól. Új szabályt **mindig** `#ltv-wrap`-pel kezdve írj.
- **Light lock.** A dizájn világos, meleg, „balatoni nyár" hangulatú. Nincs
  sötét mód.
- **Egy marquee az oldalon.** Mozgó (végtelen görgő) elemből maximum egy lehet
  oldalanként (a főoldali galéria). Aloldalakon ne használj marquee-t.
- **Max. 3 eyebrow / oldal.** A `.ltv-eyebrow` (kis nagybetűs címke) elemből
  legfeljebb három legyen egy oldalon.
- **Redukált mozgás tisztelete.** Minden animáció kikapcsol
  `prefers-reduced-motion: reduce` esetén (már be van építve az `ltv.css`-be).

---

## 1. Színek (design tokenek)

CSS-változóként a `:root`-ban. Mindig a változót használd, sose nyers hex-et.

| Token | Érték | Használat |
|---|---|---|
| `--ltv-green-900` | `#4A5A38` | mély zsálya – szöveg-akcent, `<strong>` kiemelés címben |
| `--ltv-green` | `#6B7E52` | elsődleges akcent, tömör gomb, ikon-háttér |
| `--ltv-green-mid` | `#7A9060` | köztes zöld |
| `--ltv-green-soft` | `#B7C396` | világos zsálya – hover-keret |
| `--ltv-green-pale` | `#E0E7D7` | halvány zsálya – szekció-háttér (Rólunk, Kapcsolat), tint |
| `--ltv-ink` | `#26231C` | meleg off-black – alap szövegszín, lábléc-háttér |
| `--ltv-paper` | `#FCFCFA` | off-white – oldalháttér |
| `--ltv-gray` | `#6E6A61` | másodlagos szöveg, lead, leírás |
| `--ltv-line` | `rgba(38,35,28,0.12)` | vékony elválasztó vonal, keret |

Fehér = `#FFFFFF` (sötét háttéren lévő szöveg, kártyák belseje).

---

## 2. Tipográfia

- **Display font:** `Bricolage Grotesque` (`--ltv-font-display`) — címsorok
  (`h1–h3`), márkanevek, gombokon belüli hangsúlyos számok. Súlyok: 500/600/700.
- **Szövegtörzs font:** `Outfit` (`--ltv-font-body`) — bekezdés, menü, gomb.
  Súlyok: 400/500/600.
- Betöltés (minden oldal `<head>`-jében, változatlanul):
  ```html
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,600;12..96,700&family=Outfit:wght@400;500;600&display=swap" rel="stylesheet" />
  ```
- Alap szövegméret: `1.0625rem`, sortáv `1.6`.
- Címsorok súlya 600, `<strong>` bennük 700 + `--ltv-green-900` szín (ez a
  visszatérő „kiemelt szó a címben" motívum).
- Reszponzív címméretek `clamp()`-pel (lásd komponensek).

---

## 3. Forma / sugár-rendszer (dokumentált szabály)

| Elem | Sugár | Token |
|---|---|---|
| Gombok | teljes pill | `999px` |
| Kártyák, képek, szekció-blokkok | `20px` | `--ltv-r-card` |
| Inputok, kisebb dobozok, legördülő, morzsa-kártyák | `12px` | `--ltv-r-input` |

Árnyékok: `--ltv-shadow` (`0 6px 28px …`), `--ltv-shadow-lg` (`0 18px 48px …`).
Easing: `--ltv-ease` = `cubic-bezier(0.16, 1, 0.3, 1)` — minden átmenethez ezt.

---

## 4. Elrendezés

- **Konténer:** `.ltv-container` — `max-width: 1280px`, középre, oldalpadding
  `clamp(1.25rem, 4vw, 2.5rem)`.
- **Szekció:** `.ltv-section` — függőleges padding `clamp(4.5rem, 9vw, 7.5rem)`.
- **Szekciócím-blokk:** `.ltv-section__title` (nagy, `clamp(2rem,4vw,3rem)`,
  `<strong>` zöld) + `.ltv-section__lead` (szürke, max 58ch).
- **Töréspontok:** `960px` (fő mobil-váltás: menü hamburgerré, rácsok 1 oszlop)
  és `560px` (kis mobil finomítások). Ne vezess be új töréspontot indok nélkül.

---

## 5. Komponensek (kód: `assets/ltv.css`)

### Gombok — `.ltv-btn`
- `.ltv-btn--solid`: tömör zöld, fehér szöveg (elsődleges CTA).
- `.ltv-btn--glass`: áttetsző, elmosott háttér, vékony keret (másodlagos).
- Sötét szekcióban (pl. `.ltv-cta`) a glass-gomb automatikusan világos
  változatra vált.
- Hover: `translateY(-2px)`.

### Fejléc — `.ltv-header` / `.ltv-nav`
- Sticky, elmosott áttetsző háttér; görgetéskor `is-scrolled` → árnyék.
- Menülink: `.ltv-nav__link` (pill hover-háttér `--ltv-green-pale`).
  Aktív oldal: `.is-active`.
- CTA a menüben: `.ltv-nav__cta` (kompakt tömör gomb).
- **Legördülő menü:** `.ltv-nav__item` > `.ltv-nav__link--drop` (+ caret SVG)
  és `.ltv-dropdown` allista. Desktopon hover/`focus-within`-re nyílik (van
  láthatatlan „híd" a rés fölött). Mobilon (`≤960px`) az allista beágyazottan,
  mindig látszóan, behúzva jelenik meg — nincs külön JS.

### Hero — `.ltv-hero`
Teljes képernyős kép + scrim + balra zárt üveg-kártya (`.ltv-hero__card`).
Csak a főoldalon.

### Értéksáv — `.ltv-strip`
4 oszlopos hairline sáv, cellánként fő szöveg + `<em>` alcím.

### Bento — `.ltv-bento`
12 oszlopos rács, 5 cella (`--main` 7×2, `--img`/`--a`/`--b` 5, `--c` 7).
A cella lehet `<a>` (kattintható, szolgáltatás-oldalra visz); ekkor a
`.ltv-bento__more` „Tovább →" affordancia jelenik meg. Kép + `.ltv-bento__veil`
sötét fátyol + `.ltv-bento__content` (fehér cím/leírás).

### Rólunk — `.ltv-about`
`--ltv-green-pale` háttér, 5/7 split, képpár + `.ltv-about__list` (pipás lista).

### Galéria — `.ltv-gallery`
Végtelen marquee (a JS duplázza a sávot). Oldalanként max 1.

### Márkák — `.ltv-brands`
`.ltv-brands__grid` logós kártyák (`.ltv-brand`). Ha a logó betöltődik,
`onload` → `has-logo` class → a **név elrejtve** (csak logó). Ha nincs logó,
`onerror` → kép törlődik → a **név marad**. Lenyitható (`is-hidden` + gomb).

### Nyári sáv — `.ltv-band`
Teljes szélességű kép + scrim + középre zárt állítás.

### Időpontfoglalás — `.ltv-booking`
Középre zárt CTA-blokk, Clearvisio-gomb + telefonszám.

### Kapcsolat — `.ltv-contact`
`--ltv-green-pale` háttér, 5/7 split: infóblokkok + nyitvatartás-tábla
(`.ltv-hours`, mai nap kiemelve JS-ből) + Google Maps iframe.

### Lábléc — `.ltv-footer`
`--ltv-ink` háttér, logó (invertálva) + navigáció + meta sor.

### Aloldal-komponensek (szolgáltatás-oldalak)
- `.ltv-subhero` — kompakt hero: kép + sötét scrim + eyebrow + `h1` + rövid
  intró + `.ltv-breadcrumb` morzsamenü.
- `.ltv-prose` — hosszabb szövegtörzs (max 70ch).
- `.ltv-split` (+ `--flip`) — kép/szöveg kétoszlopos blokk.
- `.ltv-feature-grid` / `.ltv-feature` — előny-kártyák ikonnal (auto-fit).
- `.ltv-steps` / `.ltv-step` — számozott folyamat-lépések.
- `.ltv-cta` — tömör záró CTA sáv (`--ltv-green-900` háttér).
- `.ltv-related` — kapcsolódó szolgáltatások kártyái.
- `.ltv-content` — WordPress-szerkesztő törzse (the_content): pipás `ul`,
  számozott `ol`, stilizált címek.
- `.ltv-stats` / `.ltv-stat` — statisztika-dobozok (nagy szám + felirat).
- `.ltv-compare` / `.ltv-compare__card` — összehasonlító kártyák (cím + tag +
  pipás lista), pl. lencsetípusok, UV/polarizált.
- `.ltv-faq` / `.ltv-faq__item` — GYIK accordion natív `<details>`/`<summary>`
  alapon (nincs JS-függés).
- `.ltv-reviews` / `.ltv-review` — vélemény-kártyák (csillag + idézet + név).
- `.ltv-logostrip` — kiemelt márkalogók vízszintes sávja (szürke → színes hover).
- Újrahasznosított blokkok aloldalon: `.ltv-bento` (kollekció-showcase),
  `.ltv-gallery` kép-marquee (oldalanként max 1, `#ltv-gallery-track` id-vel).

### Belépő animáció — `.ltv-reveal`
Bármely elemre tehető; IntersectionObserver adja rá az `is-in`-t (fölfelé
csúszás + halványulás). Ne használj scroll-listenert.

---

## 6. Oldalszerkezet és útvonalak

```
/                       index.html            (főoldal)
/szolgaltatasok/*.html                        (szolgáltatás-aloldalak)
/assets/ltv.css, /assets/ltv.js               (megosztott stílus + JS)
/images/*                                      (fotók)
/images/brands/*.png                           (márkalogók)
```

- **Főoldal** hivatkozásai: `assets/…`, `images/…`, `szolgaltatasok/…`.
- **Aloldalak** (`szolgaltatasok/`) hivatkozásai: `../assets/…`, `../images/…`,
  a főoldalra `../index.html#…`, testvéroldalra `sima-fájlnév.html`.
- Minden oldal váza: `<div id="ltv-wrap">` → `header.ltv-header` →
  `main` → `footer.ltv-footer`, a végén `<script src="…/assets/ltv.js">`.
- A `ltv.js` defenzív: az adott oldalon hiányzó elemek blokkjai kimaradnak,
  ezért minden oldalon ugyanaz a JS használható.

### Szolgáltatás-oldalak (fájlnév → cím)
| Fájl | Szolgáltatás |
|---|---|
| `egyedi-szemuvegkeszites.html` | Egyedi szemüvegkészítés |
| `napszemuvegek.html` | Napszemüvegek |
| `gyors-javitas-es-beallitas.html` | Gyors javítás és beállítás |
| `latasvizsgalat.html` | Látásvizsgálat |
| `premium-keretek.html` | Prémium keretek |

Ezek elérhetők: (a) a főoldali bento-kártyákra kattintva, (b) a fejléc
„Szolgáltatások" legördülő menüjéből.

---

## 7. Tartalmi hang

Magyar nyelv, közvetlen, meleg, családias. Kulcsmotívumok: Siófok / Balaton
partja, családi vállalkozás, helyben készített szemüveg, gyorsaság, korrekt ár.
Címekben egy szót emelj ki `<strong>`-gal (zöld).

---

## 8. WordPress-változat

A repó `wordpress/latoter-theme/index.php` egy port a főoldalról (a Local Sites
példány másolatával együtt). A statikus oldal (GitHub Pages, `index.html`) az
**élő, mérvadó** verzió. A szolgáltatás-aloldalak jelenleg a statikus oldalon
élnek; a WordPress-témába való portolásuk (PHP page-template) külön, kért lépés.
