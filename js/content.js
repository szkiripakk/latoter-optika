// ============================================================
// LÁTÓTÉR OPTIKA – SZERKESZTHETŐ TARTALOM
// ============================================================
// Ezt a fájlt szerkeszd az adatok frissítéséhez.
// Nincs szükség HTML-hez nyúlni a tartalom módosításához.
// ============================================================

const CONTENT = {

  // --- ELÉRHETŐSÉG ---
  contact: {
    phone: '+36 XX XXX XXXX',        // ← Valódi telefonszámra cserélni
    phoneDisplay: '+36 XX XXX XXXX', // ← Megjelenített formátum
    email: 'info@latotéroptika.hu',  // ← Valódi e-mailre cserélni
    address: '8600 Siófok, Sió utca 6. Fsz. 1.',
  },

  // --- NYITVATARTÁS ---
  openingHours: [
    { day: 'Hétfő',     hours: '9:00 – 18:00' },
    { day: 'Kedd',      hours: '9:00 – 18:00' },
    { day: 'Szerda',    hours: '9:00 – 18:00' },
    { day: 'Csütörtök', hours: '9:00 – 18:00' },
    { day: 'Péntek',    hours: '9:00 – 17:00' },
    { day: 'Szombat',   hours: '10:00 – 14:00' },
    { day: 'Vasárnap',  hours: 'Zárva' },
  ],

  // --- FORGALMAZOTT MÁRKÁK ---
  // Ha rendelkezésre állnak a logóképek, add meg a fájl útvonalát: logo: 'images/brands/marka.png'
  // Ha még nincs kép, hagyd üresen (logo: ''), a márkanév szövegként jelenik meg
  brands: [
    { name: 'Márka 1', logo: '' },
    { name: 'Márka 2', logo: '' },
    { name: 'Márka 3', logo: '' },
    { name: 'Márka 4', logo: '' },
    { name: 'Márka 5', logo: '' },
    { name: 'Márka 6', logo: '' },
    // ← Ide add hozzá a valódi márkákat
    // Példa: { name: 'Ray-Ban', logo: 'images/brands/ray-ban.png' },
  ],

  // --- AKTUÁLIS AKCIÓK ---
  // Negyedévente frissítendő!
  promotions: [
    {
      title: '2. szemüveg 50% kedvezménnyel',
      description: 'Vásároljon két szemüveget, és a másodikért csak a felét fizeti! Akció érvényes 2026. szeptember 30-ig.',
      badge: 'Nyári ajánlat',
      cta: 'Érdeklődöm az akcióról',
    },
    {
      title: 'Ingyenes látásvizsgálat',
      description: 'Foglaljon időpontot látásvizsgálatra – az első vizsgálat díjmentes! Korlátozott időre szóló ajánlat.',
      badge: 'Ingyenes',
      cta: 'Időpontot foglalok',
    },
  ],

};
