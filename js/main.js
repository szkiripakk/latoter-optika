// === HAMBURGER MENÜ ===
const hamburger = document.getElementById('lto-hamburger');
const navMenu = document.getElementById('lto-nav-menu');

hamburger.addEventListener('click', () => {
  const isOpen = hamburger.classList.toggle('is-open');
  navMenu.classList.toggle('is-open', isOpen);
  hamburger.setAttribute('aria-expanded', String(isOpen));
});

navMenu.querySelectorAll('.lto-nav__link').forEach(link => {
  link.addEventListener('click', () => {
    hamburger.classList.remove('is-open');
    navMenu.classList.remove('is-open');
    hamburger.setAttribute('aria-expanded', 'false');
  });
});

// === AKTUÁLIS ÉV ===
document.getElementById('lto-year').textContent = new Date().getFullYear();

// === ELÉRHETŐSÉG KITÖLTÉSE ===
const phoneRaw = CONTENT.contact.phone.replace(/\s/g, '');
const phoneDisplay = CONTENT.contact.phoneDisplay;
const emailAddr = CONTENT.contact.email;

['lto-contact-phone', 'lto-booking-phone'].forEach(id => {
  const el = document.getElementById(id);
  if (el) {
    el.href = 'tel:' + phoneRaw;
    el.textContent = phoneDisplay;
  }
});

const emailEl = document.getElementById('lto-contact-email');
if (emailEl) {
  emailEl.href = 'mailto:' + emailAddr;
  emailEl.textContent = emailAddr;
}

// === NYITVATARTÁS ===
const hoursTable = document.getElementById('lto-contact-hours');
if (hoursTable) {
  // JS getDay(): 0=vasárnap, 1=hétfő … 6=szombat
  // content.js tömb: 0=hétfő … 5=szombat, 6=vasárnap
  const jsToContent = [6, 0, 1, 2, 3, 4, 5];
  const todayIndex = jsToContent[new Date().getDay()];

  CONTENT.openingHours.forEach((row, i) => {
    const tr = document.createElement('tr');
    const isClosed = row.hours === 'Zárva';
    if (i === todayIndex) tr.classList.add('lto-hours__day--today');
    tr.innerHTML = `
      <td>${row.day}</td>
      <td class="${isClosed ? 'lto-hours__time--closed' : ''}">${row.hours}</td>
    `;
    hoursTable.appendChild(tr);
  });
}

// === MÁRKÁK ===
const brandsGrid = document.getElementById('lto-brands-grid');
if (brandsGrid) {
  CONTENT.brands.forEach(brand => {
    const div = document.createElement('div');
    div.className = 'lto-brand-item';
    if (brand.logo) {
      div.innerHTML = `<img src="${brand.logo}" alt="${brand.name} logó" loading="lazy" />`;
    } else {
      div.innerHTML = `<span class="lto-brand-name">${brand.name}</span>`;
    }
    brandsGrid.appendChild(div);
  });
}

// === AKCIÓK ===
const promotionsGrid = document.getElementById('lto-promotions-grid');
if (promotionsGrid) {
  CONTENT.promotions.forEach(promo => {
    const div = document.createElement('div');
    div.className = 'lto-promo-card';
    div.innerHTML = `
      ${promo.badge ? `<span class="lto-promo-card__badge">${promo.badge}</span>` : ''}
      <h3 class="lto-promo-card__title">${promo.title}</h3>
      <p class="lto-promo-card__desc">${promo.description}</p>
      <a href="#idopontfoglalas" class="lto-btn lto-btn--primary">${promo.cta}</a>
    `;
    promotionsGrid.appendChild(div);
  });
}

// === GALÉRIA VÉGTELEN LOOP (a sávot megduplázzuk a folytonos görgetéshez) ===
(function () {
  const track = document.querySelector('.lto-gallery-strip__track');
  if (!track || track.dataset.looped) return;
  track.dataset.looped = '1';
  Array.prototype.slice.call(track.children).forEach((item) => {
    const clone = item.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    if (clone.id) clone.removeAttribute('id');
    clone.querySelectorAll('[id]').forEach((el) => el.removeAttribute('id'));
    track.appendChild(clone);
  });
})();

// === SCROLL: FEJLÉC ÁRNYÉK ===
window.addEventListener('scroll', () => {
  const header = document.getElementById('lto-header');
  if (header) {
    header.style.boxShadow = window.scrollY > 10
      ? '0 2px 16px rgba(0,0,0,0.14)'
      : '0 2px 8px rgba(0,0,0,0.08)';
  }
}, { passive: true });
