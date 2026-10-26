# Staging Content-Parity Migration Plan

## Scope and safety

Implement only on staging `https://test.tanzaniasensational.com`; production remains read-only and cutover is not authorized. Preserve the existing dirty working-tree files. Keep staging `noindex,nofollow` throughout. Reuse source-matched content and exact currently displayed live media URLs; do not import unmatched/local demo records or invent claims.

## Approved content scope

- 12 blog articles and `/blog` index, with exact source slugs, source body/date/categories and current source media.
- Six sitemap-backed destination details: `kilimanjaro`, `lake-manyara`, `mahale`, `nyerere`, `ruaha`, `zanzibar`.
- Only two live safari package details, matched by exact source slug and current live data/media.
- Sixteen route-shaped trekking URLs only after exact path-to-record mapping is verified; exclude the other local snapshot route records.
- Company and Safari Guide routes use only copy already visible on the current public source; do not expand from longer local drafts.

## Ordered implementation gates

1. Reconcile repository/runtime instructions and route/content source records; keep unrelated dirty files untouched.
2. Make a dated, checksummed staging database and custom-plugin backup outside the public root before structural writes. Record its location and verify checksums.
3. Implement content changes in small, tested slices. Use exact source slugs and live media URLs; imports must be idempotent and refuse to overwrite unrelated/editor-authored records.
4. Verify imported counts, fields, canonical source routes and the staging noindex policy; compare rendered pages and media in a real browser at desktop/tablet/mobile sizes.
5. Complete restore rehearsal, functional/security/accessibility/SEO/performance checks, and staging editor workflow. Keep SMTP verification blocked until a configured transport and approved sink mailbox are available.
6. Commit/push only intended project files to the working branch after review; preserve unrelated local modifications. Do not deploy or cut over production without separate explicit approval.

## Current checkpoint

- Owner approved the five recommended content defaults.
- The 6 destination paths and 12 blog-article paths are listed in `SOURCE-URL-PARITY-LEDGER-2026-10-24.csv`.
- A fresh staging backup was created at `/home/tanzhihb/ts-migration-backups/staging-20261025T043650Z`; re-verified hashes: `database.sql` `317d8a59dfe89900adb8b74d654ceb0f296ef51836899572e147c5928bcbd805`, `custom-plugins.tgz` `90a9bbe967db1701664074fb9da4c4bcf765c5deb3290a5d9f1fd09faf42bf5c`.
- A current pre-write staging backup was created at `/home/tanzhihb/ts-migration-backups/staging-20261026T073649Z-pre-meta-media-fix`; it contains the database, both custom plugins, importer files, and active plugin/theme inventories. All files are mode 600 in a mode 700 directory; `SHA256SUMS` verified and both archives passed gzip integrity checks.
- Staging was re-verified at `https://test.tanzaniasensational.com`: WordPress 7.1.3, WP-CLI 2.6.0, `blog_public=0`; the destination CPT contains nine published records (the original Serengeti/Ngorongoro/Tarangire plus six approved imports). The new importer dry-run reports all six imported destinations as unchanged.
- Remote ACF group `group_ts_destination` now registers all required destination fields, including source hero/gallery URLs, SEO title/description, and both closing lines. Both `wp_posts` and `wp_postmeta` use InnoDB; the staging design plugin is active at version 1.2.18.
- Mahale's two source gallery URLs verified as HTTP 404 are retained in the media map's `excluded_gallery` audit list and omitted from the staging import. The four remaining gallery images load in the rendered page.
- Browser verification of the Mahale staging page shows one Rank Math description, `noindex, nofollow`, and no canonical tag. The Hello Elementor excerpt-description filter is disabled only for destination posts; the Rank Math canonical filter remains for future indexable production pages.
- `wp core verify-checksums` passes with only the extra-file warning for `wp-admin/error_log`; the file was not deleted or modified. It remains a 4,647-byte mode-0644 text log (mtime 2026-10-24 20:06:19 UTC, SHA-256 `9eb8f6fa4ce0037359b0b662d2322e7fe72632453c9dd87741d1b3b7350ccdcd`). The log summary contains one older PHP Fatal entry at `kses.php:1713` on 2026-09-17 23:43:29 UTC. A public request to that path returned a 745-byte HTML response, not the log text. The fatal/log destination source remains a separate follow-up; no cleanup was performed.
- Local destination importer and WP-CLI dry-run/apply wrapper are implemented and exercised in the PHP test suite; writes require both `--apply` and `--confirm-staging-write`, staging host/noindex checks, and an administrator capability. The independent review's race and post-publish-metadata findings are addressed: apply fails closed unless both content tables use InnoDB, locks each existing post row in a per-record transaction, and rechecks state under the lock; snapshot/hash are persisted before publish; `publishing` recovery resumes or finalizes without rewriting; failed post-publish verification returns the record to draft. Tests cover the post-preflight race, nontransactional-engine guard, metadata failures, and recovery.
