# Tanzania Sensational — WordPress Parity-to-Production Plan

**Prepared:** 2026-10-24  
**Source site:** `https://tanzaniasensational.com` (Laravel/React, currently production)  
**WordPress staging:** `https://test.tanzaniasensational.com`  
**Staging SSH alias:** `Tss_web`  
**Staging document root:** `/home/tanzhihb/test.tanzaniasensational.com`

## Objective and release rule

Replace the current custom Laravel public website with WordPress while preserving its distinctive frontend design, content, routes, SEO behavior, and customer workflows. WordPress must be the content platform; Elementor Pro must let the site team update ordinary page layouts and reusable presentation without editing PHP/CSS. Structured tour, destination, route, departure, and booking data must remain editable in WordPress/ACF or purpose-built admin screens, with business rules enforced server-side.

**Production stays on Laravel until every staging acceptance gate below passes and the owner explicitly approves a cutover window.** This plan does not authorize production writes or a DNS/document-root switch.

## Verified baseline and known blockers

As of 2026-10-24:

- Staging reports WordPress 7.1.3, Hello Elementor, Elementor Pro, ACF Pro, and active `tanzania-sensational-design` plus `tanzania-sensational-core` plugins.
- Staging has 13 published pages, 1 post, 3 published tours, 3 published destinations, and no published trekking-route posts. The staging sitemap index exposes 15 URLs.
- The production custom sitemap currently contains 56 URLs. A Laravel route listing shows 142 total routes, including non-public application/admin/API routes that must be classified rather than migrated as pages.
- The local Laravel SQLite snapshot contains 12 blog posts, 9 destinations, 3 safari packages, 112 trekking-route records, 132 itinerary days, 30 departures, 25 gear items, 144 pricing rules, 88 visual assets, and 12 editable page records. These are snapshot counts, not proof that every record is currently public or still matches production; reconcile against the live source before importing.
- The local departure snapshot spans 2026-06-14 through 2026-10-02, with zero departures on or after 2026-10-24. Treat those 30 rows as historical until operations confirms current inventory; never publish them as upcoming dates. Current departure inventory must be confirmed from the live business source.
- The original project workspace and its parent are not Git checkouts. A separate checkout is on branch `wp-migration/phase-0-baseline` with `origin` set to `joshualotha/Tanzania-Sensational`; whether that repository/branch is canonical or used by deployment remains unverified. The staging plugin snapshot was initially mirrored exactly (core 8/8 files; design 40/40 files by SHA-256), and the earlier incomplete snapshot was preserved outside the repository. Subsequent local-only departure-inventory work intentionally changes five plugin files and has not been deployed.
- Among sitemap paths, staging returns 404 for 12 blog posts, 6 destination paths (one of these is currently falling through to the archive), and 2 safari package paths. Fourteen trekking detail paths resolve to one generic Kilimanjaro page, rather than distinct route content. `/blog` resolves to Home. Some other URLs return 200 only after generic redirects, which is not content parity.
- HTTP checks for the production homepage, staging homepage, and staging departures page returned 200. These checks alone do not establish parity.
- Full visual comparison has not been performed. The browser profile was locked during the first attempt.

See `PARITY-AUDIT-2026-10-24.md` for the URL-level findings. Re-run all counts and URL checks at the start of execution because staging/source may have changed.

## Workstream 0 — Establish safe, reproducible delivery

### Tasks

1. Identify the authoritative local source for the custom website, WordPress design plugin, core plugin, database/content exports, and deployment files. Determine whether these are intentionally one workspace or separate repositories.
2. Confirm whether `wp-migration/phase-0-baseline` on `joshualotha/Tanzania-Sensational` is the canonical WordPress source, and trace the staging/production deployment source and ref. Do not push or deploy until this ownership is confirmed and the user authorizes it.
3. Preserve all existing local files and staging state. Exclude `.env`, database dumps with personal data, credentials, backups, `vendor`, `node_modules`, generated caches, and WordPress secrets as appropriate. Review ignore rules before adding files.
4. Produce a dated staging backup of database, custom plugins, Elementor templates/settings, and media. Test that the backup is readable/restorable in a non-production environment.
5. Record PHP/MySQL, WordPress, theme, plugins, Elementor/Pro, ACF, PHP extensions, cron, cache/CDN, SMTP, and current SEO configuration. Pin/document supported versions; avoid updating unrelated plugins during feature migration.
6. Create a protected route/content parity ledger, migration log, and staging release/rollback notes. Each change is tied to a commit/release identifier and a staging backup.

### Exit gate

A known canonical source and reproducible staging deployment path exist; the current site can be restored from a verified backup; no secrets or user data enter Git.

## Workstream 1 — Complete source-of-truth inventory

### Tasks

1. Export the production sitemap and crawl internal links from every public page. Also inventory Laravel route definitions, database records, public media, navigation, footer, forms, metadata, redirects, and important query/variant URLs. Separate public customer-facing pages from API, admin, auth, health, and internal endpoints.
2. For every public route, capture: canonical URL, page identity/title, content type, source record ID/slug, parent/variant, metadata/schema, status, internal links, primary action/form, hero and other media, and current HTTP/canonical/redirect behavior.
3. Reconcile sitemap coverage against the full public route list and content tables; do not assume the 56 sitemap URLs are the complete scope. Include unpublished but linked pages only after an owner confirms they should be public.
4. Create an explicit mapping: source URL → WordPress post type/page/template → target URL → migration state → verification result. Every source route must be classified as preserved, intentionally retired with an approved relevant redirect, or excluded with a written reason.
5. Capture reference screenshots and content snapshots from the source site for each unique page family and all exceptional page layouts. Record fixed viewport, browser, DPR, font readiness, and consent/cookie state.

### Exit gate

Owner reviews and accepts the complete public route/content inventory. No unexplained route, tour, destination, trekking package, blog post, editorial page, or media item remains out of scope.

## Workstream 2 — WordPress information architecture and data migration

### Content families to reconcile

- Standard editorial pages and homepage.
- Safari landing/hub pages, package archive, every safari tour detail, and all destination archive/detail pages.
- Kilimanjaro hub, every route and duration/package variant, Mt. Meru pages where public, route itineraries, and trekking-planning guides.
- Blog archive and every source article, including all 12 confirmed missing articles.
- Company pages, safari-guide child pages, FAQ, Zanzibar, training, gear checklist, add-ons, contact, and group departures.
- Departures/inventory, booking requests, rental requests, menus, global settings, media, redirects, and SEO fields.

### Tasks

1. Finalize CPTs/taxonomies and ACF groups/options for tours, destinations, trekking routes, itinerary repeaters, departures, and shared settings. Preserve established source slugs and exact route prefixes. Ensure each content type supports revisions, useful admin labels, and the right Elementor/ACF editing experience.
2. Decide which data is content and which is transactional. Do not copy live customer bookings or personal data into staging unless explicitly approved and safely anonymized. Migrate public editorial data and media with attribution/alt text and stable references.
3. Implement a repeatable, idempotent importer (or documented WP-CLI import) with dry-run, validation, stable source IDs, duplicate detection, image mapping, and a rollback/restore path. Do not hand-create a few examples and declare the corpus complete.
4. Import every approved source record. Reconcile record counts and compare key fields (titles, slugs, prices/currency, durations, itinerary day counts, inclusions/exclusions, destinations, article body, metadata, images, and relationships).
5. Build real archive/single templates and ensure every imported record has its own intended detail URL. Correct the existing generic redirects for routes that should become real WordPress pages.
6. Preserve old URLs where possible. Use exact 301 redirects only when a route truly changes or is retired; map to the closest equivalent page, never Home or a generic root just to avoid 404. Avoid redirect chains/loops and keep query behavior where required.
7. Regenerate and validate the WordPress sitemap after all public types are enabled for indexing on the eventual production site. Staging itself remains noindex/blocked and is not submitted to search engines.

### Exit gate

The approved migration ledger has no missing items; source and WordPress record/media counts reconcile; all slugs and relationships are validated; no source record is silently replaced by placeholder content.

## Workstream 3 — Preserve the custom frontend while making it editable

### Design reference

The existing visual system documented in the build status includes the brand colors (teal `#5B7B7A`, driftwood `#8C6D52`, deep water `#1F2926`, gold `#C9A84C`, warm linen `#F7F4EF`, muted text `#535C58`, bleached sand `#C9B99A`, white), Playfair Display, Cormorant Garamond, Source Serif 4, DM Sans, and 1400px content width. Verify these against the live rendered source rather than treating the notes as the sole authority.

### Tasks

1. Capture source references before restyling. Maintain the exact information hierarchy, typography, imagery, crops, colors, sizing, section order, card geometry, whitespace, borders, shadows, animations, hover/focus states, and responsive behavior.
2. Use Elementor Site Settings/Theme Builder for global typography/colors, header, mobile menu, footer, and reusable templates. Use native Elementor sections/containers, Loop Grid, dynamic tags, and ACF fields where they can express the design faithfully.
3. Retain custom Elementor widgets only for distinctive/repeated components that native Elementor cannot reproduce cleanly. Expose editor controls for all expected changes: copy, links, images, labels, CTA, section visibility, and repeaters/ordering. Avoid an opaque fixed renderer that technically appears in Elementor but cannot be meaningfully customized.
4. Use ACF for structured content (tour facts, itinerary, route details, inclusions, destination facts) and Elementor for page presentation/campaign edits. Do not duplicate business facts in Elementor defaults when they belong to the canonical content record.
5. Keep CSS scoped by widget/page/template, document it, and avoid brittle generated DOM selectors or third-party theme/plugin edits. Preserve semantic headings, labels, keyboard behavior, focus visibility, reduced-motion behavior, and mobile navigation.
6. Test real editing workflows with a non-admin editor: edit a heading/image/CTA, reorder/add a repeater item, hide/show a section, update a tour field, save, preview, and confirm frontend output without touching code.

### Visual parity gate

For every unique page template and exception, compare source and WordPress screenshots at the same viewport(s): desktop 1440×900, tablet 768×1024, and mobile 390×844 (or agreed standard devices). Compare top, middle, and bottom of long pages, plus menus, cards, forms, and interactive states. Fix layout/content differences and repeat screenshots. Record issues with before/after evidence. Pixel-diff can flag drift but human review must account for anti-aliasing/font-rendering noise. Require owner sign-off on visual exceptions; do not call “exactly the same” based only on similar branding or HTTP 200.

## Workstream 4 — Functional parity and operational workflows

1. Booking: validate fields server-side, pricing and availability server-side, honeypot/rate limiting, safe duplicate handling, accessible success/error states, customer/admin notifications, and no payment collection unless explicitly scoped.
2. Departures: provide a capability- and nonce-protected WordPress admin workflow for creating, editing, and closing departure inventory without SQL; prevent edits that put capacity below booked/held seats. Inventory and homepage/archive cards use the same database source; booking links select the correct departure; server-side booking rejects past/closed departures; capacity/seat holds are atomic under concurrent requests; confirm/cancel/status transitions reconcile inventory; expired holds release on a reliable scheduled job. Define behavior when WP-Cron does not run and configure/verify a real scheduler if required by the host.
3. Add repeatable automated tests for creation, invalid inputs, duplicate/rate limits, insufficient capacity, parallel booking contention, hold expiry, idempotent confirm/cancel, and seat reconciliation. Run tests on isolated test records and clean them up.
4. Test contact, newsletter, gear rental, and any other customer forms end-to-end with test data and intercepted/approved email targets. Verify SMTP sender identity, SPF/DKIM/DMARC alignment where available, delivery, bounce/error logging, and admin notification; never use real customer data for tests.
5. Verify menus, mobile drawer/accordion, search/filter interactions, galleries, accordions, phone/WhatsApp links, anchors, map embeds, date/time/currency display, and all CTAs.
6. Review authorization, nonce/CSRF, input validation, output escaping, REST permissions, data retention/export/deletion, spam abuse controls, admin roles, and secret handling. Do not expose private booking fields publicly.

### Exit gate

Automated and manual functional tests pass with captured results; business owner confirms operational emails and workflow; no known critical/high security, data integrity, or accessibility defect remains.

## Workstream 5 — SEO, accessibility, performance, and browser QA

1. Crawl every mapped staging URL and assert intended final status, final URL, canonical, title, meta description, H1, page identity, indexability, and internal-link destination. Check each source link and asset; fail the gate for missing images, empty content, unrelated redirects, duplicate canonical, or unexpected 404/5xx.
2. Confirm structured data and Rank Math output do not contradict page content. Validate sitemap includes all public intended pages and excludes staging/admin/private records. Preserve analytics/tag behavior only from confirmed production configuration; do not invent IDs.
3. Run accessibility checks and manual keyboard/screen-reader spot checks for navigation, focus, form labels/errors, contrast, heading order, image alt text, and reduced motion.
4. Test desktop/tablet/mobile in current major browsers; inspect console/network failures, layout overflow, font loading, broken third-party embeds, and form error states.
5. Measure representative pages before/after for image sizes, lazy loading, cache behavior, Core Web Vitals, and server response. Optimize without changing crop/art direction or hiding content.
6. Re-test after cache/CDN purge and from a clean browser session. Ensure editor preview and public output both match.

## Workstream 6 — Staging acceptance and release candidate

### Required release-candidate evidence

- Signed URL/content migration ledger and source-to-WP counts.
- All public source routes resolve to the intended WordPress page or an approved relevant redirect; full crawl has no unexplained 404, 5xx, loop, chain, or generic catch-all.
- All source tours, destinations, trek routes/variants, articles, and editorial pages are present and individually verified.
- Screenshot set and visual issue log show accepted parity at desktop, tablet, and mobile across every page family and exception.
- Functional, security, accessibility, email, responsive, and performance checks pass; test commands and outputs are recorded.
- Editor acceptance confirms normal content/layout tasks can be completed in WordPress/Elementor without code.
- Staging robots/noindex remains enabled; production settings and data remain untouched.
- Backup restore and rollback rehearsal completed; release commit/tag and exact file/database changes are known.

Any failed gate returns the release to the relevant workstream; no cutover on partial completion.

## Workstream 7 — Production cutover (separate explicit approval)

### Pre-cutover

1. Confirm production hosting can support the exact tested WordPress stack, PHP/database versions, memory/storage, cron, SSL, mail delivery, cache/CDN, and security controls. Confirm backups, access, and rollback authority.
2. Select a low-traffic maintenance window and communicate the freeze. Confirm whether production WordPress will replace Laravel at the same document root, use another deployment mechanism, or be switched by hosting configuration; validate the actual cPanel/host procedure rather than assuming.
3. Freeze source content changes, take fresh production database/files and staging backups, and run the final idempotent content/media sync. Do not migrate private transactions unless separately specified and protected.
4. Preflight production URLs, environment configuration, salts, database credentials, mail settings, canonical domain, HTTPS, redirects, robots, analytics, backups, and caching. Keep secrets out of Git and command output.
5. Agree an explicit go/no-go with the owner. If any required acceptance item, backup, rollback, or operational contact is missing, postpone.

### Cutover and immediate verification

1. Deploy the exact accepted release artifact/commit to production using a tested, reversible procedure. Do not improvise destructive cleanup or overwrite the only Laravel copy.
2. Switch routing/document root only after the WordPress release is ready. Retain the Laravel release and database for rollback until the agreed observation period ends.
3. Verify SSL/HTTPS, canonical host, home, representative page from every content family, all critical legacy routes/redirects, sitemap/robots, assets/fonts, forms, booking/departure workflows, email delivery, scheduled jobs, admin/editor access, analytics, cache, and server logs.
4. Crawl the complete production URL ledger and verify final response and page identity; compare production screenshots for representative templates against accepted staging. Check noindex is removed only on the production site and staging remains blocked.
5. Monitor error logs, uptime, form/booking records, email, cron, and Search Console/analytics for the agreed soak period. Keep known-good Laravel rollback available.
6. If a critical issue appears, stop content changes and use the rehearsed rollback, then validate Laravel URLs and forms. Do not patch production ad hoc without recording the release and recovery path.

### Final completion definition

The migration is complete only after production verification and the agreed soak period pass, all required public pages/content and workflows are present, design review is accepted, search/redirect checks are clean, the editor handoff is complete, and the owner confirms production acceptance. Record the final release ID, backup locations, rollback steps, remaining non-blocking issues, and post-launch owner.
