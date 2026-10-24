const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const test = require('node:test');

const source = fs.readFileSync(
  path.join(__dirname, '../core-plugin/assets/departures.js'),
  'utf8'
);

test('query-string departure opens and selects that departure in the request form', () => {
  let ready;
  let selectedLabel = '';
  let scrolled = false;
  const panel = {
    hidden: true,
    querySelector: () => ({
      set textContent(value) {
        selectedLabel = value;
      },
    }),
    scrollIntoView: () => {
      scrolled = true;
    },
  };
  const form = {
    elements: { departure_id: { value: '' } },
    addEventListener() {},
  };
  const departureButton = {
    dataset: { departureId: '42', departureLabel: 'Lemosho Route — Nov 5, 2026' },
    addEventListener(event, handler) {
      if (event === 'click') this.onClick = handler;
    },
    click() {
      this.onClick();
    },
  };
  const document = {
    addEventListener(event, handler) {
      if (event === 'DOMContentLoaded') ready = handler;
    },
    getElementById: () => panel,
    querySelector: () => form,
    querySelectorAll: () => [departureButton],
  };

  vm.runInNewContext(source, {
    document,
    window: { location: { search: '?departure_id=42' } },
    URLSearchParams,
    FormData,
    fetch,
    console,
  });
  ready();

  assert.equal(form.elements.departure_id.value, '42');
  assert.equal(selectedLabel, 'Lemosho Route — Nov 5, 2026');
  assert.equal(panel.hidden, false);
  assert.equal(scrolled, true);
});
