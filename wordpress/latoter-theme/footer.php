  </main>

  <!-- LÁBLÉC -->
  <footer class="ltv-footer">
    <div class="ltv-container">
      <div class="ltv-footer__row">
        <span class="ltv-footer__brand">Látótér Optika</span>
        <nav class="ltv-footer__nav" aria-label="Lábléc navigáció">
          <a href="<?php echo esc_url( home_url( '/#szolgaltatasok' ) ); ?>">Szolgáltatások</a>
          <a href="<?php echo esc_url( home_url( '/#rolunk' ) ); ?>">Rólunk</a>
          <a href="<?php echo esc_url( home_url( '/#markak' ) ); ?>">Márkák</a>
          <a href="<?php echo esc_url( home_url( '/#foglalas' ) ); ?>">Foglalás</a>
          <a href="<?php echo esc_url( home_url( '/#kapcsolat' ) ); ?>">Kapcsolat</a>
        </nav>
      </div>
      <div class="ltv-footer__meta">
        <span>© <span id="ltv-year"></span> Látótér Optika. Minden jog fenntartva.</span>
        <span><a href="#">Adatkezelési tájékoztató</a></span>
      </div>
    </div>
  </footer>

</div>

<script>
(function () {
  // === SZERKESZTHETŐ ADATOK (Testreszabóból) ===
  var CONTENT = {
    phone: '<?php echo esc_js( get_theme_mod( 'latoter_phone', '+36 XX XXX XXXX' ) ); ?>',
    email: '<?php echo esc_js( get_theme_mod( 'latoter_email', 'info@latoteroptika.hu' ) ); ?>',
    openingHours: [
      { day: 'Hétfő',     hours: '<?php echo esc_js( get_theme_mod( 'latoter_hours_mon', '10:00 - 17:00' ) ); ?>' },
      { day: 'Kedd',      hours: '<?php echo esc_js( get_theme_mod( 'latoter_hours_tue', '10:00 - 18:00' ) ); ?>' },
      { day: 'Szerda',    hours: '<?php echo esc_js( get_theme_mod( 'latoter_hours_wed', '10:00 - 17:00' ) ); ?>' },
      { day: 'Csütörtök', hours: '<?php echo esc_js( get_theme_mod( 'latoter_hours_thu', '10:00 - 17:00' ) ); ?>' },
      { day: 'Péntek',    hours: '<?php echo esc_js( get_theme_mod( 'latoter_hours_fri', '10:00 - 17:00' ) ); ?>' },
      { day: 'Szombat',   hours: '<?php echo esc_js( get_theme_mod( 'latoter_hours_sat', '10:00 - 13:00' ) ); ?>' },
      { day: 'Vasárnap',  hours: '<?php echo esc_js( get_theme_mod( 'latoter_hours_sun', 'Zárva' ) ); ?>' }
    ]
  };

  // === HAMBURGER + MOBIL FIÓK ===
  var burger = document.getElementById('ltv-burger');
  var menu = document.getElementById('ltv-menu');
  if (burger && menu) {
    var wrapEl = document.getElementById('ltv-wrap') || document.body;
    var overlay = document.createElement('div');
    overlay.className = 'ltv-nav__overlay';
    wrapEl.appendChild(overlay);

    function closeMenu() {
      burger.classList.remove('is-open');
      menu.classList.remove('is-open');
      overlay.classList.remove('is-on');
      burger.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('ltv-menu-open');
    }
    function openMenu() {
      burger.classList.add('is-open');
      menu.classList.add('is-open');
      overlay.classList.add('is-on');
      burger.setAttribute('aria-expanded', 'true');
      document.body.classList.add('ltv-menu-open');
    }
    burger.addEventListener('click', function () {
      if (burger.classList.contains('is-open')) { closeMenu(); } else { openMenu(); }
    });
    overlay.addEventListener('click', closeMenu);

    var dropLink = menu.querySelector('.ltv-nav__link--drop');
    if (dropLink) {
      dropLink.addEventListener('click', function (e) {
        if (window.matchMedia('(max-width: 960px)').matches) {
          e.preventDefault();
          var item = dropLink.closest('.ltv-nav__item');
          if (item) { item.classList.toggle('is-sub-open'); }
        }
      });
    }
    menu.querySelectorAll('a').forEach(function (a) {
      if (a === dropLink) { return; }
      a.addEventListener('click', closeMenu);
    });
    window.addEventListener('resize', function () {
      if (!window.matchMedia('(max-width: 960px)').matches) {
        closeMenu();
        var openItem = menu.querySelector('.ltv-nav__item.is-sub-open');
        if (openItem) { openItem.classList.remove('is-sub-open'); }
      }
    });
  }

  // === ÉV ===
  var yearEl = document.getElementById('ltv-year');
  if (yearEl) { yearEl.textContent = new Date().getFullYear(); }

  // === TELEFON + E-MAIL ===
  var telHref = 'tel:' + CONTENT.phone.replace(/\s/g, '');
  ['ltv-phone', 'ltv-contact-phone'].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) { el.href = telHref; el.textContent = CONTENT.phone; }
  });
  var emailEl = document.getElementById('ltv-contact-email');
  if (emailEl) { emailEl.href = 'mailto:' + CONTENT.email; emailEl.textContent = CONTENT.email; }

  // === NYITVATARTÁS (mai nap kiemelve) ===
  var hoursTable = document.getElementById('ltv-hours');
  if (hoursTable) {
    var jsToIdx = [6, 0, 1, 2, 3, 4, 5]; // JS getDay(): 0 = vasárnap
    var today = jsToIdx[new Date().getDay()];
    CONTENT.openingHours.forEach(function (row, i) {
      var tr = document.createElement('tr');
      if (i === today) tr.className = 'is-today';
      if (row.hours === 'Zárva') tr.className += ' is-closed';
      tr.innerHTML = '<td>' + row.day + '</td><td>' + row.hours + '</td>';
      hoursTable.appendChild(tr);
    });
  }

  // === GALÉRIA LOOP (sáv duplázása a folytonos futáshoz) ===
  var track = document.getElementById('ltv-gallery-track');
  if (track && !track.dataset.looped) {
    track.dataset.looped = '1';
    Array.prototype.slice.call(track.children).forEach(function (item) {
      var clone = item.cloneNode(true);
      clone.setAttribute('aria-hidden', 'true');
      track.appendChild(clone);
    });
  }

  // === REVEAL (IntersectionObserver, nem scroll-listener) ===
  var reveals = document.querySelectorAll('.ltv-reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('is-in'); });
  }

  // === MÁRKÁK LENYITÁS ===
  var brandsToggle = document.getElementById('ltv-brands-toggle');
  if (brandsToggle) {
    var hiddenBrands = document.querySelectorAll('#ltv-brands .ltv-brand.is-hidden');
    var collapsedLabel = 'Összes márka (+' + hiddenBrands.length + ')';
    brandsToggle.textContent = collapsedLabel;
    brandsToggle.addEventListener('click', function () {
      var expanded = brandsToggle.getAttribute('aria-expanded') === 'true';
      hiddenBrands.forEach(function (el) { el.classList.toggle('is-hidden', expanded); });
      brandsToggle.setAttribute('aria-expanded', String(!expanded));
      brandsToggle.textContent = expanded ? collapsedLabel : 'Kevesebb márka';
    });
  }

  // === FEJLÉC ÁRNYÉK (sentinel + IO, nem scroll-listener) ===
  var header = document.getElementById('ltv-header');
  var wrap = document.getElementById('ltv-wrap');
  if (header && wrap) {
    var sentinel = document.createElement('div');
    sentinel.style.cssText = 'position:absolute;top:0;height:1px;width:1px;';
    wrap.prepend(sentinel);
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        header.classList.toggle('is-scrolled', !entries[0].isIntersecting);
      }).observe(sentinel);
    }
  }
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
