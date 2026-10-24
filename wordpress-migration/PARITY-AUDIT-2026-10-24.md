# WordPress Migration Parity Audit

Audit date: 2026-10-24
Source: `https://tanzaniasensational.com` (custom Laravel website)
Target: `https://test.tanzaniasensational.com` (WordPress staging)

## Verified environment

- Staging runs WordPress 7.1.3 with `tanzania-sensational-design` and `tanzania-sensational-core` active; the active theme is Hello Elementor.
- Published staging content: 13 pages, 1 post, 3 `ts_tour`, 3 `ts_destination`; 0 published `ts_trek_route`. The custom sitemap index exposes 15 URLs.
- The local Laravel SQLite snapshot has 12 pages, 12 blog posts, 3 safari packages, 9 destinations, 112 trekking routes, 132 itinerary days, 30 departures, 25 gear items, 144 pricing rules, and 88 visual assets. It is a source snapshot; reconcile it with the live site before importing.
- The local departure snapshot's latest date is 2026-10-02, so none of those 30 dates should be treated as upcoming on the audit date (2026-10-24). Fresh departure data requires operations confirmation.
- Fresh staging backup created at `/home/tanzhihb/ts-migration-backups/20261024T093932Z-pre-migration-work` (database export, custom plugin archive, plugin/theme inventories, version, SHA-256 manifest). The WordPress database check passed; backup checksums and plugin archive integrity passed. A restore drill remains pending.
- The original project workspace and its parent are not Git checkouts. A separate checkout is on branch `wp-migration/phase-0-baseline` with `origin` set to `joshualotha/Tanzania-Sensational`; whether it is canonical or used for deployment remains unverified. The staging plugin snapshot was initially mirrored exactly (core 8/8 files; design 40/40 files by SHA-256), with the earlier incomplete design-plugin snapshot preserved outside the repository. Five plugin files now differ intentionally because of local departure-inventory work; these changes have not been deployed.
- HTTP checks: source homepage 200, staging homepage 200, staging group departures 200.
- Production was not modified during this discovery/backup work.

## Confirmed URL/content gaps

### Missing blog articles (12 source URLs return 404 on staging)

- `/blog/kilimanjaro-packing-list-what-actually-matters`
- `/blog/lemosho-vs-machame-choosing-your-route`
- `/blog/altitude-acclimatization-a-practical-guide`
- `/blog/what-a-kilimanjaro-day-looks-like-on-the-mountain`
- `/blog/safari-after-the-summit-best-pairings`
- `/blog/zanzibar-the-perfect-recovery-itinerary`
- `/blog/training-for-kilimanjaro-8-weeks-no-guesswork`
- `/blog/how-to-tip-on-kilimanjaro-simple-breakdown`
- `/blog/the-5-ecological-zones-of-kilimanjaro`
- `/blog/why-group-departures-work-and-when-they-dont`
- `/blog/moshi-arrival-hotels-and-what-to-expect`
- `/blog/common-mistakes-first-time-trekkers-make`

### Missing destination pages (6 source URLs return 404)

- `/safaris/destinations/kilimanjaro`
- `/safaris/destinations/lake-manyara`
- `/safaris/destinations/zanzibar`
- `/safaris/destinations/nyerere`
- `/safaris/destinations/mahale`
- `/safaris/destinations/ruaha` resolves to the destination archive, not the Ruaha detail page.

Three other destination routes resolve to WordPress detail pages: Serengeti, Ngorongoro, and Tarangire.

### Missing safari package detail pages (2 source URLs return 404)

- `/safaris/packages/ultimate-fly-in-northern-circuit`
- `/safaris/packages/expected-wildlife-serengeti`

WordPress currently has three different published tour slugs (`great-migration-edition`, `pioneers-route`, `grand-canvas`), so content/slug parity remains unverified and requires reconciliation against source content.

### Missing trekking route content

- All 14 source trekking detail URLs currently redirect to the generic `/kilimanjaro-pillar/` page rather than distinct route/package details.
- WordPress has no published `ts_trek_route` entries.

### Existing URLs that resolve only by generic redirect

- `/blog` resolves to the homepage, not a blog archive.
- `/company/our-guides` and `/company/safety-protocols` both resolve to About Us.
- Safari guide child routes resolve to the Safari Guide root or Gear Checklist, not matching article pages.
- `/safaris/destinations/ruaha` resolves to the destination archive.

These HTTP 200 responses are not content parity; each needs a matching page or a deliberately equivalent destination.

## Visual acceptance

Not verified. A screenshot comparison could not start because the browser profile was locked by the running Chrome session. Exact visual parity must be checked at desktop, tablet, and mobile widths across all migrated page families, followed by CSS/layout corrections and re-checks.

## Remaining acceptance gates

1. Inventory every source sitemap URL and all internal routes/content types (including pages omitted from the sitemap).
2. Import/create the missing blog, destination, tour, trekking, company, safari-guide, and other editorial content while preserving slugs and media.
3. Replace generic redirects with matching WordPress content; retain redirects only for intentionally retired/renamed URLs.
4. Compare rendered content, forms, navigation, metadata, and desktop/tablet/mobile screenshots against the custom source.
5. Crawl all source URLs against staging and require intended final routes to return 200 with matching page identity/content.
6. Keep production untouched until staging parity is accepted and a separate cutover is approved.
