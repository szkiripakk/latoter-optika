import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import sharp from 'sharp';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const OUT_DIR = path.resolve(__dirname, '../../images/brands');
const TARGET_HEIGHT = 400;               // rendered PNG height (px), width auto -> aspect preserved
const UA = 'latoter-optika-logo-fetch/1.0 (contact: tomikatakacs7@gmail.com)';

const brands = JSON.parse(await fs.readFile(path.join(__dirname, 'brands.json'), 'utf8'));

const argFilter = process.argv.slice(2); // optional: only process these file slugs

const BAD_WORDS = ['sponsor', 'kit', 'stadium', 'award', 'map', 'building', 'store',
  'jersey', 'shirt', 'cap', 'flag', 'signature', 'stamp', 'poster', 'cover', 'video',
  'screenshot', 'icon', 'favicon', 'app'];

function norm(s) {
  return s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '')
    .replace(/&/g, ' and ').replace(/[^a-z0-9]+/g, ' ').trim();
}

async function api(url) {
  const r = await fetch(url, { headers: { 'User-Agent': UA } });
  if (!r.ok) throw new Error(`HTTP ${r.status} for ${url}`);
  return r.json();
}

async function fetchExact(file, site) {
  const host = site === 'en' ? 'en.wikipedia.org' : 'commons.wikimedia.org';
  const url = `https://${host}/w/api.php?format=json&action=query&prop=imageinfo`
    + '&iiprop=url|mime|size&titles=' + encodeURIComponent('File:' + file);
  const data = await api(url);
  const p = data?.query?.pages ? Object.values(data.query.pages)[0] : null;
  const info = p?.imageinfo?.[0];
  return info ? [{ title: 'File:' + file, info }] : [];
}

async function searchCommons(query) {
  const url = 'https://commons.wikimedia.org/w/api.php?format=json&action=query'
    + '&generator=search&gsrnamespace=6&gsrlimit=20'
    + '&gsrsearch=' + encodeURIComponent(query + ' filetype:bitmap|drawing')
    + '&prop=imageinfo&iiprop=url|mime|size';
  const data = await api(url);
  const pages = data?.query?.pages ? Object.values(data.query.pages) : [];
  return pages.map(p => ({
    title: p.title || '',
    info: (p.imageinfo && p.imageinfo[0]) || null,
  })).filter(p => p.info);
}

function score(cand, brand) {
  const nb = norm(brand.name);
  const words = nb.split(' ').filter(Boolean);
  const nt = norm(cand.title.replace(/^file:/i, '').replace(/\.[a-z0-9]+$/i, ''));
  let s = 0;
  const mime = cand.info.mime || '';
  if (mime.includes('svg')) s += 100;                 // strongly prefer vector
  else if (mime.includes('png')) s += 40;
  else if (mime.includes('jpeg')) s += 5;             // jpeg rarely transparent
  const matched = words.filter(w => nt.includes(w)).length;
  s += matched * 30;
  if (words.length && matched === 0) s -= 200;         // brand name absent -> reject
  if (/\blogo\b/.test(nt) || /\bwordmark\b/.test(nt)) s += 25;
  if (BAD_WORDS.some(b => nt.includes(b))) s -= 60;
  // prefer reasonable landscape-ish logos; huge raster bonus for resolution
  if (mime.includes('png') || mime.includes('jpeg')) {
    if (cand.info.width >= 400) s += 10;
    if (cand.info.width < 120) s -= 20;
  }
  s -= nt.length * 0.1;                                 // slight preference for concise titles
  return s;
}

async function download(url) {
  const r = await fetch(url, { headers: { 'User-Agent': UA } });
  if (!r.ok) throw new Error(`HTTP ${r.status} downloading ${url}`);
  return Buffer.from(await r.arrayBuffer());
}

async function toPng(buf, isSvg) {
  const input = isSvg ? sharp(buf, { density: 400 }) : sharp(buf);
  return input
    .resize({ height: TARGET_HEIGHT, fit: 'inside', withoutEnlargement: !isSvg })
    .png({ compressionLevel: 9, palette: true, quality: 90, effort: 10 })
    .toBuffer();
}

const results = [];
for (const brand of brands) {
  if (argFilter.length && !argFilter.includes(brand.file)) continue;
  if (!brand.exact && !brand.query) { results.push({ brand: brand.name, status: 'skip (no source)' }); continue; }
  try {
    let best;
    if (brand.exact) {
      const cands = await fetchExact(brand.exact, brand.site);
      if (!cands.length) { results.push({ brand: brand.name, status: 'exact missing: ' + brand.exact }); continue; }
      best = { c: cands[0] };
    } else {
      const cands = await searchCommons(brand.query);
      if (!cands.length) { results.push({ brand: brand.name, status: 'no results' }); continue; }
      const ranked = cands.map(c => ({ c, s: score(c, brand) })).sort((a, b) => b.s - a.s);
      best = ranked[0];
      if (best.s < 0) { results.push({ brand: brand.name, status: 'no good match' }); continue; }
    }
    const info = best.c.info;
    const isSvg = (info.mime || '').includes('svg');
    const raw = await download(info.url);
    const png = await toPng(raw, isSvg);
    const meta = await sharp(png).metadata();
    const outPath = path.join(OUT_DIR, brand.file + '.png');
    await fs.writeFile(outPath, png);
    results.push({
      brand: brand.name, status: 'OK',
      type: isSvg ? 'svg' : (info.mime || '').split('/')[1],
      src: best.c.title.replace(/^File:/, ''),
      dim: `${meta.width}x${meta.height}`, kb: (png.length / 1024).toFixed(1),
    });
  } catch (e) {
    results.push({ brand: brand.name, status: 'ERROR: ' + e.message });
  }
  await new Promise(r => setTimeout(r, 250)); // be polite to the API
}

console.log('\n==== RESULTS ====');
for (const r of results) {
  if (r.status === 'OK') {
    console.log(`✓ ${r.brand.padEnd(26)} ${r.type.padEnd(5)} ${r.dim.padEnd(11)} ${r.kb}KB  <- ${r.src}`);
  } else {
    console.log(`✗ ${r.brand.padEnd(26)} ${r.status}`);
  }
}
const ok = results.filter(r => r.status === 'OK').length;
console.log(`\n${ok}/${results.length} downloaded.`);
