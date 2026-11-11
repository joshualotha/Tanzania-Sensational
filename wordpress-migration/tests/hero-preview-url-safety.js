'use strict';

import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath, URL } from 'node:url';
import vm from 'node:vm';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const widgetPath = path.join(
  __dirname,
  '../staging-plugin/elementor/widgets/class-ts-hero-widget.php'
);
const source = readFileSync(widgetPath, 'utf8');
const helper = source.match(
  /var tsSafeHeroUrl\s*=\s*function\s*\(raw\)\s*\{[\s\S]*?^\s*\};/m
);

assert.ok(helper, 'Hero editor template must define its URL-scheme validator.');

const context = vm.createContext({
  URL,
  window: { location: { href: 'https://test.tanzaniasensational.com/' } },
});
vm.runInContext(helper[0], context);

const safeUrl = context.tsSafeHeroUrl;
assert.equal(safeUrl('/safaris'), '/safaris');
assert.equal(safeUrl('https://example.com/tours'), 'https://example.com/tours');
assert.equal(safeUrl('mailto:contact@example.com'), 'mailto:contact@example.com');
assert.equal(safeUrl('tel:+255743262822'), 'tel:+255743262822');
assert.equal(safeUrl('#packages'), '#packages');

for (const unsafeUrl of [
  'javascript:alert(1)',
  '  JaVaScRiPt:alert(1)  ',
  'data:text/html,<script>alert(1)</script>',
  'vbscript:msgbox(1)',
  'ftp://example.com/file',
]) {
  assert.equal(safeUrl(unsafeUrl), '#', `Unsafe URL should be rejected: ${unsafeUrl}`);
}

assert.equal(safeUrl(''), '#');
assert.equal(safeUrl(null), '#');

console.log('PASS: Elementor hero preview allows safe links and rejects unsafe URL schemes.');
