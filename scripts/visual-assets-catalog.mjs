import { visualsData } from '../resources/js/data/visualsData.js';

function normalizeUrl(url) {
  if (!url) return '';
  return String(url).trim();
}

function normalizeKey(value) {
  return String(value || '')
    .trim()
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '_')
    .replace(/^_+|_+$/g, '');
}

function inferFilename(url) {
  const u = String(url || '');
  if (!u) return '';
  const clean = u.split('?')[0].split('#')[0];
  const parts = clean.split('/');
  return parts[parts.length - 1] || '';
}

function humanizeAlt(section) {
  return String(section || '')
    .split('.')
    .filter(Boolean)
    .map((seg) => seg.replace(/([a-z])([A-Z])/g, '$1 $2').replace(/[_-]+/g, ' '))
    .join(' / ')
    .trim();
}

function walk(obj, prefix = '', out = []) {
  if (!obj || typeof obj !== 'object') return out;

  for (const [k, v] of Object.entries(obj)) {
    const section = prefix ? `${prefix}.${k}` : k;
    if (typeof v === 'string') {
      const url = normalizeUrl(v);
      if (!url) continue;
      out.push({ section, url, kind: 'single' });
    } else if (Array.isArray(v)) {
      const urls = v.map(normalizeUrl).filter(Boolean);
      if (!urls.length) continue;
      for (let i = 0; i < urls.length; i++) {
        out.push({ section, url: urls[i], kind: 'list', index: i });
      }
    } else if (v && typeof v === 'object') {
      walk(v, section, out);
    }
  }

  return out;
}

const raw = walk(visualsData);
const usedKeys = new Set();

const records = raw.map((r) => {
  const base = normalizeKey(r.section);
  const filename = normalizeKey(inferFilename(r.url).replace(/\.[^.]+$/, ''));
  let key = filename ? `${base}_${filename}` : base;

  // Ensure deterministic uniqueness without hashes.
  if (usedKeys.has(key)) {
    let n = 2;
    while (usedKeys.has(`${key}_${n}`)) n++;
    key = `${key}_${n}`;
  }
  usedKeys.add(key);

  return {
    section: r.section,
    key,
    url: r.url,
    type: 'image',
    metadata: {
      alt: humanizeAlt(r.section),
    },
  };
});

process.stdout.write(JSON.stringify(records, null, 2));

