# Staging Runbook

## Target

- URL: `https://test.tanzaniasensational.com`
- SSH alias: `Tss_web`
- Document root: `/home/tanzhihb/test.tanzaniasensational.com`

## Safety rules

- Confirm the remote working directory before every write operation.
- Never run migration or replacement commands in
  `/home/tanzhihb/tanzaniasensational.com` or `/home/tanzhihb/public_html`.
- Back up the staging database and custom plugin before structural changes.
- Do not copy `.env`, Laravel credentials, WordPress salts, or database passwords
  into repository files.
- Do not expose staging to search engines.
- Avoid editing third-party plugin or theme files.

## Verification gates

After every deployment unit:

1. Run PHP syntax checks on changed PHP files.
2. Confirm WordPress core integrity.
3. In an authenticated staging session, verify the target Elementor editor in
   normal mode. Require visible panel content, a preview iframe whose document
   reaches `complete`, and no visible loading overlay; capture a screenshot.
   An editor shell alone is not a pass.
4. Confirm the homepage and one dynamic detail page return HTTP 200.
5. Confirm responsive behavior at phone, tablet, and desktop widths.
6. Confirm no changes occurred on the production Laravel site.

Keep editor diagnostics read-only unless the owner explicitly authorizes a
specific test. Do not toggle Safe Mode, persistent Elementor settings, or save
content as a diagnostic shortcut without that authorization. If loading fails,
capture console/network evidence and correlate it with current staging logs;
`ERR_ABORTED` without an HTTP status does not establish a server-side cause.

## Backups

Backups are stored outside the public web root. Each dated backup directory must
be mode `700`; Backup files—including `SHA256SUMS`—must be mode `600`. Include:

- `database.sql` — a non-empty, readable timestamped WordPress database export
- `custom-plugins.tgz` — a timestamped archive of the custom Tanzania Sensational plugin
- `plugin-inventory.txt` and `theme-inventory.txt` — active plugin/theme inventories
- `SHA256SUMS` — checksums for every required backup file

Run `sha256sum -c SHA256SUMS`, verify the database export is readable (restore
it to an isolated database when available), and check compressed archive
integrity with `gzip -t` and `tar -tzf`. Keep the verified backup unchanged for
the whole apply and recovery window; do not substitute a backup from another
migration.

Backup retention and deletion must follow the hosting account's available
storage and should be agreed before old backups are removed.

### Verified isolated restore rehearsal (2026-10-29)

Backup `/home/tanzhihb/ts-migration-backups/staging-20261029T090053Z-pre-restore-rehearsal`
was restored into an isolated MariaDB 11.4.13 container (`--network none`, no
published ports). The source reported `11.4.13-MariaDB-cll-lve`; the target
reported `11.4.13-MariaDB-ubu2404`. All four payload checksums matched the
manifest; 38 database tables and 120 WordPress post rows were restored;
`mariadb-check` passed. The plugin archive contained 67 files and all 50 PHP
files passed syntax checks. Database import took 6.34 seconds; total rehearsal
time was 63.73 seconds. The temporary container and scratch data were removed.

When automating this check with the official MariaDB image, wait until
`@@global.skip_networking` is `OFF` before importing. The image briefly runs a
local initialization server with networking skipped; a socket ping can pass
during that phase and then lose its connection when the final server starts.
This is an isolated database-restore verification, not a production rollback.

## Destination content import

The destination importer is staging-only and remains outside the public web root.
Copy `migration/destination-importer.php`, `migration/destination-import-cli.php`,
and `migration/destination-import-manifest.json` to
`/home/tanzhihb/ts-migration-releases/<release-id>/import/` after confirming the remote working
location. Keep the staging database and custom-plugin backup available.

Run the read-only preflight first:

```sh
wp --path=/home/tanzhihb/test.tanzaniasensational.com \
  --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/destination-import-cli.php \
  ts destinations import
```

The preflight must show only the approved six slugs and no writes. Stop if it
reports an unowned slug collision, invalid ownership state, missing ACF field,
or a staging host/visibility mismatch. Deploy and verify the matching ACF schema
and destination template before proceeding if a required field is not registered.

Only after backup, staging `blog_public=0`, ACF field registration, and the
read-only plan are verified, apply as a staging administrator. Apply requires
InnoDB-backed `posts` and `postmeta` tables; it rechecks each existing record
under a row lock. Pause edits to the six target records for the duration of the
apply as an additional safeguard.

```sh
wp --path=/home/tanzhihb/test.tanzaniasensational.com \
  --user=<staging-admin-id> \
  --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/destination-import-cli.php \
  ts destinations import --apply --confirm-staging-write
```

The importer requires InnoDB storage and serializes each applied record in a
transaction with a row lock, then rechecks ownership and content before writing.
It verifies every post and ACF field while the record is still a draft and
persists the ownership snapshot/hash before publishing. A recoverable
`publishing` marker lets a later run finish publication or finalize ownership
metadata without rewriting verified content. If a post-publish verification fails,
the importer returns the record to draft and stops. Later updates are refused if
an editor changed the snapshot. Re-run the dry run after apply; it should report
the six imported records as unchanged. Then verify the exact routes, source media,
metadata, and staging noindex. For noindex staging pages, canonical absence is
intentional; do not add a staging self-canonical. Before any production cutover,
verify that the production pages are indexable and self-canonical on their final
production URLs.

## Trekking-route content and single-route template

The local importer is limited to the 16 live-verified route cards. It writes the
source-matched title, duration, difficulty, overview, hero URL/alt text, route
family, source URL, and SEO title. Price, success rate, itinerary, highlights,
inclusions, exclusions, and other unverified fields remain blank. Its Elementor
Theme Builder condition targets only the dedicated `ts_trek_route` post type;
it does not apply to standard posts or pages.

Before any staging apply:

1. Confirm the exact HTTPS staging origin
   `https://test.tanzaniasensational.com/`, `blog_public=0`, and staging document
   root. Production remains read-only.
2. Create a fresh dated, checksummed database/custom-plugin backup outside the
   public root using the backup requirements above. Verify the manifest,
   database readability, and archive integrity; keep the backup available for
   every recovery attempt.
3. Deploy only `migration/trekking-importer.php`,
   `migration/trekking-import-cli.php`, and
   `migration/trekking-import-manifest.json` into a bounded release directory.
   Confirm the ACF field names, types, and repeater sub-fields match the
   registered route schema. Confirm `wp_posts` is InnoDB and has the expected
   `post_name` index. Before apply, a staging operator must exercise the exact
   range-lock query against the live database using two separate WP-CLI
   processes/connections and a unique throwaway slug: connection A locks the
   missing slug range, inserts a draft, and holds its transaction; connection B
   runs the same `SELECT ... FOR UPDATE` and must block until A commits, then read
   A's row. Remove the test row and verify it is absent in a separate read-only
   query before importing. The in-memory test stub is not proof of live gap
   locking.
4. Run the read-only preflight first. It must report exactly 16 approved route
   actions and one template action, with no unowned slug, snapshot, ACF, origin,
   privacy, or backup problems:

   ```sh
   wp --path=/home/tanzhihb/test.tanzaniasensational.com \
     --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/trekking-import-cli.php \
     ts trek-routes import
   ```

5. Only after reviewing that plan, apply as a staging administrator with the
   exact verified pre-write backup:

   ```sh
   wp --path=/home/tanzhihb/test.tanzaniasensational.com \
     --user=<staging-admin-id> \
     --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/trekking-import-cli.php \
     ts trek-routes import --apply --confirm-staging-write \
     --backup-dir=/home/tanzhihb/ts-migration-backups/<backup-id>
   ```

Each route is created as a draft in its own InnoDB transaction. The importer
sets `REPEATABLE READ`, locks and rechecks the indexed slug range, writes ACF
values, reads them back without display formatting, stores ownership/snapshot
metadata, then publishes and verifies the post before commit. The template is
created only after all route records are complete. Its conditions are written
and read back before commit; after commit, the importer calls the installed
Elementor manager API again and verifies that the exact target appears in the
persisted single-template conditions cache before marking the template ready.
Metadata readback alone does not prove that Elementor's runtime cache contains
the new template. An apply rerun on an owned template repeats this refresh and
cache check. If post-commit refresh/cache verification fails on either first
creation or an idempotent rerun, the importer attempts to move the owned
template to draft, clear targeting through the manager API, and verify that it
is absent from the runtime conditions cache; otherwise stop for manual
recovery. The 16 routes plus template are **not** one batch-atomic transaction.
A failure rolls back the in-flight record, while earlier committed records
remain. If a rollback fails or the new post remains after rollback, the importer
attempts to quarantine it as a draft; for a template it also clears targeting
conditions and refreshes the location cache. It reports manual recovery as
required if quarantine cannot be verified. Do not retry or delete a surviving
draft until its state is inspected and the backup/recovery path is chosen. Hooks
that write to external systems or non-transactional stores are not undone by a
database rollback.

If apply is interrupted during the route loop, keep the original backup and run
the dry-run before doing anything else. Because the template is created only
after every route has committed, a safe resume shows completed routes as
`unchanged`, only missing routes as `create`, and the template as `create`. The
importer refuses to repair a missing route when the owned template already
exists; treat that combination as an unexpected deletion or database-state
problem and investigate rather than deleting or recreating records. After
apply, rerun the dry-run and require all 16 routes and the template to be
`unchanged`. Read back the exact route fields, ownership metadata, published
status, Elementor widget tree/conditions, and the runtime conditions-cache
entry; then verify the rendered route and noindex behavior in a real browser.
The local test suite uses WordPress/DB stubs and does not prove live database
locking or replace browser verification.

The initial staging import was applied on 2026-10-28. The 2026-10-29 idempotent
cache-refresh apply and live lock probe are recorded in `BUILD-STATUS.md`; the
verified release and backup paths are preserved there. Production remains
read-only.

## Source-backed safari package additions

The importer creates only the two source-verified tour records:
`ultimate-fly-in-northern-circuit` (SIGNATURE, 4 Days, Serengeti • Ngorongoro •
Tarangire, `From $2,400` per person) then `expected-wildlife-serengeti`
(CLASSIC, 4 Days, Manyara • Serengeti • Ngorongoro, `From $2,200` per person).
Starting-price labels remain strings; do not coerce them to numeric values or
copy the broken source links `/safaris/packages/1`, `/2`, or `/3`. The malformed
source exclusion `Optional hot air balloon safari ( pp)` is retained only as
`Optional hot air balloon safari`; the source amount is missing and no price is
to be inferred.

The source `/safaris/packages` body currently renders exactly those two cards.
The separate staging acceptance is owner-preserving: keep published tour posts
12–14 byte-for-byte unchanged and have the existing `/safaris/packages` CPT
archive display all five cards, with the two new source cards first. This
five-card staging target is not a claim that the current source body shows five.
The source `/safaris` landing body has no package-card row or package CTA; its
“Featured Packages” link is global navigation and must not be added to the page
body. Preserve the source counters, nine destination cards, testimonial,
“Experience That Speaks.” section, two benefit cards, and contact CTA.

Package hero media is restricted to the exact per-slug URL allowlist in the
importer. It uses WordPress's safe HTTP client with redirects disabled and an
8 MB response cap, verifies `image/jpeg` plus the decoded JPEG format and
bounded dimensions, then sideloads through WordPress's media APIs. The image
field stores the resulting attachment ID (not the source URL); attachment
ownership metadata records the source URL, package slug, and SHA-256 content
hash. A resumed import reuses only a matching owned file and verifies the hash.
On package failure the importer removes the new attachment and its generated
files; if cleanup cannot be verified, it leaves a private draft reservation and
stops for manual recovery.

Run a read-only staging preflight first:

```sh
wp --path=/home/tanzhihb/test.tanzaniasensational.com \
  --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/safari-package-import-cli.php \
  ts safari-packages import
```

The read-only preflight must show only the two approved package creates (or
verified unchanged records), a `replace` or verified `unchanged` landing action,
nine exact published destination mappings, and a landing snapshot SHA-256.
It gates on the exact HTTPS staging origin, `blog_public=0`, exact post type /
slug / published status for each destination, all ACF field and repeater
subfield schemas, unique ownership, snapshot integrity, and editor-drift checks.
An unowned slug, ambiguous destination, changed snapshot, or unexpected package
state is a hard stop. Confirm the output and use its `landing.snapshot_hash` in
the apply command; the apply recomputes the full post/meta snapshot before any
write and refuses if it differs.

Before apply, create a fresh dated backup outside the public root, within the
last 24 hours, with `database.sql`, `custom-plugins.tgz`, plugin/theme
inventories, and `SHA256SUMS`. Require directory/file modes 700/600, readable
SQL, valid archive integrity, and matching hashes. Apply requires administrator
capability, `--apply --confirm-staging-write`, that backup, and InnoDB `posts`
and `postmeta` tables. Do not change production. After the backup is verified, deploy
only the reviewed staging plugin files `staging-plugin/tanzania-sensational-design.php`
and `staging-plugin/safari-landing.css` into the existing
`/home/tanzhihb/test.tanzaniasensational.com/wp-content/plugins/tanzania-sensational-design/`
plugin directory, following the bounded release/hash-check procedure above.
Copy `safari-package-importer.php`, `safari-package-import-cli.php`,
`safari-package-import-manifest.json`, and `safari-landing-manifest.json` into
`/home/tanzhihb/ts-migration-releases/<release-id>/import/`. Run PHP lint,
`wp core verify-checksums`, and the read-only preflight after code deployment;
if the released importer or stylesheet differs from the reviewed files, stop.

```sh
wp --path=/home/tanzhihb/test.tanzaniasensational.com \
  --user=<verified-staging-admin-id> \
  --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/safari-package-import-cli.php \
  ts safari-packages import --apply --confirm-staging-write \
  --backup-dir=/home/tanzhihb/ts-migration-backups/<backup-id> \
  --landing-snapshot-hash=<sha256-from-preflight>
```

WP-CLI defaults to user ID 0. Supply the independently verified staging
administrator ID on every apply and rollback command so the importer can verify
`current_user_can('manage_options')` before a write.

If an approved restore is required after apply, create and verify a fresh staging
backup, then restore page 27 from the retained private draft clone:

```sh
wp --path=/home/tanzhihb/test.tanzaniasensational.com \
  --user=<verified-staging-admin-id> \
  --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/safari-package-import-cli.php \
  ts safari-packages rollback-landing --apply --confirm-staging-write \
  --backup-dir=/home/tanzhihb/ts-migration-backups/<fresh-backup-id> \
  --backup-id=<private-draft-clone-post-id> \
  --snapshot-hash=<original-page-snapshot-sha256>
```

Rollback checks the fresh backup, administrator capability, transactional InnoDB
tables, exact HTTPS staging origin, noindex state, full managed page/meta hash,
and locked in-transaction state before restoring. It refuses on any editor drift;
retain the clone and investigate rather than overwriting newer edits.

The CLI creates/reads back each package transactionally first; only after both
records plan `unchanged` does it clone page 27's full post and all meta (including
the Elementor tree) into a private draft, verify that clone, then replace page
27 within a transaction and remove Elementor rendering metadata from the live
page. If rollback cannot be proved by a full read-back, the page is quarantined
as a draft and the run stops for manual recovery. Packages are per-record, not
batch-atomic: after interruption, completed packages must plan `unchanged`,
only remaining records may plan `create`, and landing must still plan `replace`.
The landing is applied last; a package-loop failure must leave the landing
untouched. WordPress hooks can have external side effects that DB rollback does
not reverse; stop and inspect those separately if an apply fails.

Post-apply read-back requires both package records unchanged, landing page 27
owned and unchanged with a verified private backup, exactly five published
archive cards in source-first/legacy-preserving order, and legacy IDs 12–14
hash-identical. The local tests exercise exact prepared slug collisions,
rollback/quarantine, drift, and resume logic with stubs; they do not establish
real database gap-lock behavior. Do not mark route parity verified until the
staging apply, exact route read-back, and real-browser checks pass.

The existing `ts_tour` archive rewrite and single-tour Elementor template remain
unchanged. The importer performs the guarded page-27 write through its CLI; it
does not claim route parity until staging and browser verification finish.

## Blog posts, archive, and Elementor template

The reviewed importer creates exactly twelve approved standard posts, the `/blog`
archive page, and a single-post Theme Builder template scoped only to those twelve
post IDs. It is staging-only; the default `hello-world` post must remain unchanged
and must not be included in the archive, related-story queries, or template.

The importer applies each post or layout-resource create in its own InnoDB transaction.
It sets `REPEATABLE READ` for that transaction and takes a `FOR UPDATE` range lock on
the indexed WordPress `post_name` before inserting, so a post-preflight slug
collision is rejected before a write. The full twelve-post-and-layout batch is not
one all-or-nothing transaction. If an apply is interrupted, keep the original
pre-write backup and run the read-only preflight before doing anything else. A safe
resume must show completed importer-owned records as `unchanged` and only unfinished
approved posts/resources as `create`; stop if any record is edited, unowned,
incomplete, or otherwise differs from that recovery plan. Use the same verified
pre-write backup for a resume. Restore from it only if the recovery plan is unsafe
or post-apply verification fails.

Before any remote blog plugin, template, or content write:

1. Confirm the remote working directory, the exact HTTPS origin
   `https://test.tanzaniasensational.com/`, and `blog_public=0`. Never run these
   steps in the production document root.
2. Create a fresh dated backup outside the public root under
   `/home/tanzhihb/ts-migration-backups/<backup-id>/`. Include `database.sql`,
   `custom-plugins.tgz`, `plugin-inventory.txt`, `theme-inventory.txt`, and
   `SHA256SUMS`; keep the directory mode `700` and files mode `600`. Verify the
   checksum manifest, confirm `database.sql` is readable, and run `gzip -t` on
   `custom-plugins.tgz` (and any compressed database archive, if used).
3. Copy `migration/blog-importer.php`, `migration/blog-import-runtime.php`,
   `migration/blog-import-cli.php`, and `migration/blog-import-manifest.json` to
   `/home/tanzhihb/ts-migration-releases/<release-id>/import/`. Deploy only the
   reviewed custom-plugin files to staging. Run PHP lint and
   `wp core verify-checksums`; then check the homepage and a dynamic route.
4. Run the read-only preflight. It must list only the twelve approved article
   creates plus the `/blog` page and single-template actions, with no unowned slug
   collisions, changed snapshots, or missing ACF fields:

   ```sh
   wp --path=/home/tanzhihb/test.tanzaniasensational.com \
     --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/blog-import-cli.php \
     ts blog import
   ```

5. Stop if the host, noindex, backup, transactional table, ACF, slug, or Elementor
   targeting checks fail. Apply only as a staging administrator, with the exact
   verified backup path:

   ```sh
   wp --path=/home/tanzhihb/test.tanzaniasensational.com \
     --user=<staging-admin-id> \
     --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/blog-import-cli.php \
     ts blog import --apply --confirm-staging-write \
     --backup-dir=/home/tanzhihb/ts-migration-backups/<backup-id>
   ```

6. Read back all twelve posts, their source-managed fields and hashes, the `/blog`
   page and Elementor data, and the template conditions. The importer re-saves the
   single-template conditions after publication, invalidates Elementor Pro's
   location cache, and reads the conditions back; verify they contain exactly the
   imported post IDs. Re-run the dry-run; all posts and both resources must report
   unchanged. Verify `hello-world` status, slug, modified date, content, and template
   exclusion remain unchanged.
7. In a real browser, verify `/blog` and all twelve article routes, and confirm each
   article actually renders the imported single-post template (not a fallback),
   internal links, image behavior (the known broken hero remains omitted), staging
   `noindex`, and clean console/network state at phone, tablet, and desktop widths.
   Do not add a staging self-canonical. Production remains read-only; a production
   cutover requires separate approval.

