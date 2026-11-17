import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import test from 'node:test';

const repoRoot = resolve(dirname(fileURLToPath(import.meta.url)), '..');
const footerSource = readFileSync(
  resolve(repoRoot, 'resources/js/components/layout/Footer.jsx'),
  'utf8',
);

function getSafariDestinationLinks() {
  const labelIndex = footerSource.indexOf('Safaris & Destinations');
  assert.notEqual(labelIndex, -1, 'footer has a Safaris & Destinations column');

  const listStart = footerSource.indexOf('<ul className="footer-links">', labelIndex);
  assert.notEqual(listStart, -1, 'Safaris & Destinations column has a link list');

  const listEnd = footerSource.indexOf('</ul>', listStart);
  assert.notEqual(listEnd, -1, 'Safaris & Destinations link list closes');

  return footerSource.slice(listStart, listEnd);
}

test('SafariGo appears as an external link in the Safaris & Destinations footer column', () => {
  const links = getSafariDestinationLinks();
  const safariGuideIndex = links.indexOf('<Link href="/safaris/guide">Safari Guide</Link>');
  const safariGoIndex = links.indexOf('<a href="https://www.safarigo.com">SafariGo</a>');

  assert.ok(safariGuideIndex !== -1, 'existing Safari Guide link remains in this column');
  assert.ok(safariGoIndex !== -1, 'SafariGo uses the exact external URL and visible label');
  assert.ok(safariGoIndex > safariGuideIndex, 'SafariGo follows the Safari Guide link');
  assert.equal((links.match(/https:\/\/www\.safarigo\.com/g) ?? []).length, 1, 'one SafariGo target is present');
});
