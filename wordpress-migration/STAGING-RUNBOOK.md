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
The installed WordPress 7.1.4 normalizes `draft` attachment status to `inherit`, so
unassigned reservations are created as `private` and become `inherit` only when
bound to a published package. On package failure the importer removes the new
attachment and its generated files; if cleanup cannot be verified, it leaves a
private reservation and stops for manual recovery. WordPress `private` status hides
the attachment post from public queries but does not secure the upload URL; treat
its file bytes as publicly reachable until manual removal or access restriction is
verified.

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
subfield schemas, unique ownership, snapshot integrity, editor-drift checks, and absence of reserved importer backup keys in page metadata.
An unowned slug, ambiguous destination, changed snapshot, or unexpected package
state is a hard stop. Confirm the output and use its `landing.snapshot_hash` in
the apply command; the apply recomputes the full post/meta snapshot before any
write and refuses if it differs. After both packages are read back as unchanged,
verify the actual archive's exact five-slug set and source-first order, and confirm
legacy post snapshots are unchanged, before replacing page 27. Repeat the archive
readback after the landing commit. If the pre-replacement check fails, page 27
remains untouched; committed packages remain owned and resumable.

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
`safari-package-import-manifest.json`, `safari-landing-manifest.json`,
`safari-image-seed-importer.php`, and `safari-image-seed-manifest.json` into
`/home/tanzhihb/ts-migration-releases/<release-id>/import/`. The package
landing planner shares the image-seed helper/manifest to recognize the exact
owned local-media state, so deploy these companion files atomically with the
package importer. Run PHP lint,
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
records plan `unchanged` does it create a private draft clone of page 27's full
post and metadata. The clone copies raw `wp_postmeta` rows in row order so ACF,
Elementor, serialized values, and duplicate keys are preserved exactly; it then
verifies the complete post, normalized metadata, raw metadata rows, and source
snapshot before commit. The live page replacement is a separate transaction:
it locks and re-reads page 27 plus its metadata immediately before mutation,
refuses drift, replaces the public Elementor document, and verifies the committed
state. The explicit `rollback-landing` command is separately gated and
transactional; it restores post fields and raw metadata from the verified clone
and reads back both the restored page and retained clone. Elementor rendering
metadata is removed from the live page during replacement. If rollback cannot
be proved by a full read-back, the page is quarantined as a draft and the run
stops for manual recovery. Packages are per-record, not batch-atomic: after
interruption, completed packages must plan `unchanged`, only remaining records
may plan `create`, and landing must still plan `replace`. The landing is applied
last; a package-loop failure must leave the landing untouched. WordPress hooks
can have external side effects that DB rollback does not reverse; stop and
inspect those separately if an apply fails.

Post-apply read-back requires both package records unchanged, landing page 27
owned and unchanged with a verified private backup, exactly five published
archive cards in source-first/legacy-preserving order, and legacy IDs 12–14
hash-identical. The local tests exercise exact prepared slug collisions,
rollback/quarantine, drift, and resume logic with stubs; they do not prove live
locking. A separate staging probe on 2026-11-12 verified the package lookup path:
MariaDB `11.4.13-MariaDB-cll-lve`; `wpjn_posts` is InnoDB with a BTREE
`post_name` index (191-character prefix). Connection A ran the following under
`REPEATABLE READ`, inserted a transient draft, and held the transaction:

```sql
SELECT ID FROM wpjn_posts FORCE INDEX (post_name)
WHERE post_name='<unique-probe-slug>' AND post_type='ts_tour'
LIMIT 1 FOR UPDATE;
```

Independent connection B ran the same locked lookup; it waited 12.39 seconds,
then read the committed draft (`ID 134`) after A committed. The exact probe row
was removed, a separate query confirmed no matching slug remained, and the
`wpjn_posts` count was 120 afterward. This verifies the second-lookup/readback
path for an inserted slug, not two simultaneous full importer runs or the
complete package apply. Do not mark route parity verified until the staging
apply, exact route read-back, and real-browser checks pass.

The existing `ts_tour` archive rewrite and single-tour Elementor template remain
unchanged. The importer performs the guarded page-27 write through its CLI; it
does not claim route parity until staging and browser verification finish.

## Source-exact safari image seed

The separate `ts safari-images seed` command imports only the eleven JPEGs
present on the verified `/safaris` source page: its hero and difference images,
plus the nine exact destination-card images. It stores owned attachment IDs on
the nine existing destination records, clears only their exact matching source
URL overrides in the same transaction, and rewrites the landing markup to the
verified local media URLs while preserving the source alt text. Legacy tour
posts 12–14 are out of scope. The apply requires the existing published landing
to be owned and unchanged, records raw `postmeta` rows plus full post state for
the landing and all destination targets in a private draft clone. It verifies
all reads before commit. A per-site MySQL advisory writer lock serializes media
preparation, apply, and rollback so two operators cannot race to create duplicate
seed attachments; page and destination post/meta rows are also locked under
`REPEATABLE READ`. The clone hash is returned as
`image_seed_backup_hash`; the post-apply managed hash is returned as
`managed_hash`.

On 2026-11-12, two independent WP-CLI connections on the exact staging site
exercised this image-seed advisory lock: the holder acquired it, held six seconds,
and released it; the contender blocked for 3.219 seconds, then acquired and
released it. This validates the named advisory-writer-lock path only.

The same day, separate WP-CLI connections validated the two row-lock query paths
used by the image seed. On temporary draft page 176, both set
`REPEATABLE READ`; the holder held each lock for nine seconds while the contender
blocked and read back the row:

- `wpjn_posts.PRIMARY`: `SELECT ID FROM wpjn_posts WHERE ID=176 FOR UPDATE` —
  contender waited 6.228 seconds and returned ID 176.
- `wpjn_postmeta.post_id`: `SELECT meta_id FROM wpjn_postmeta WHERE post_id=176 ORDER BY meta_id FOR UPDATE` —
  contender waited 6.089 seconds and read two metadata rows.

The temporary draft and its metadata rows were deleted; absence was verified.
This proves blocking for these exact row queries, not concurrent full importer
apply/rollback behavior.

After code review and a fresh private staging backup, copy
`safari-image-seed-importer.php`, `safari-image-seed-import-cli.php`,
`safari-image-seed-manifest.json`, `safari-package-importer.php`,
`safari-landing-manifest.json`, and the required shared package runtime files
into the release `import/` directory. Run the read-only plan first:

```sh
wp --path=/home/tanzhihb/test.tanzaniasensational.com \
  --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/safari-image-seed-import-cli.php \
  ts safari-images seed
```

It must report the exact eleven source assets, nine destination targets, and a
`managed_hash`; stop on any changed ownership hash, editor drift, source URL
mismatch, non-owned media collision, or unexpected destination identity. The
apply is a separately authorized staging write and must use the latest hash from
that dry-run, a verified fresh backup, and the verified admin ID:

```sh
wp --path=/home/tanzhihb/test.tanzaniasensational.com \
  --user=<verified-staging-admin-id> \
  --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/safari-image-seed-import-cli.php \
  ts safari-images seed --apply --confirm-staging-write \
  --backup-dir=/home/tanzhihb/ts-migration-backups/<backup-id> \
  --managed-hash=<sha256-from-image-seed-dry-run>
```

After apply, require all eleven owned attachments to match the exact source URL,
content hash, and alt; all nine ACF image fields to resolve to the owned
attachment IDs; all nine competing source URL overrides to be empty; the
landing markup to use only local media; and both image-seed and landing plans to
read back `unchanged`. Then perform the rendered staging/browser checks before
claiming image parity. No production write is authorized by this procedure.

### Staging image-seed apply evidence — 2026-11-12

- Target: `https://test.tanzaniasensational.com/safaris/`; `blog_public=0`,
  browser robots `noindex, nofollow`, staging administrator ID 1 had
  `manage_options`, and `wp_posts`/`wp_postmeta` were InnoDB.
- Private release: `/home/tanzhihb/ts-migration-releases/staging-20261112T181102Z-safari-image-seed-v3/`.
  The five deployed import files matched local SHA-256 values; all three PHP
  files passed `php -l`.
- Fresh pre-write backup:
  `/home/tanzhihb/ts-migration-backups/staging-20261112T181102Z-pre-safari-image-seed-v3`.
  Directory/files were mode 700/600; all four payload hashes verified; SQL was
  readable (2,714,882 bytes, 39 `CREATE TABLE`, 18 `INSERT`, standard dump
  trailer); gzip/tar integrity passed (71 entries across both custom plugins).
  Isolated restore rehearsal was not performed; owner approval to proceed without
  it is recorded in the project ledger.
- Dry-run hash before apply:
  `72756126114db4e0c98eff7be8d8f581f6bb51f85081bd18e53667708cea6655`.
  It found the eleven already-owned attachments (IDs 164–174) unchanged, nine
  destination image fields to seed, landing page 27 to seed, and no legacy-tour
  changes.
- Apply returned `seeded`: 11 assets, 9 destination fields, landing page 27.
  Preservation clone ID 177 has hash
  `de6981177070fa5e86b15d4bfba038f61969821865eac1490debfa6629d1c246`; final
  managed hash is
  `fd29e9a677b1fd2568f48ce13303efdaeec04ab7db2b66a6acb22238460faf4e`.
  Importer readback and route readback both reported `unchanged`. A fresh dry-run
  confirmed all 11 assets, all nine destinations, and page 27 as `unchanged`.
- Browser verification at desktop 1280×900, tablet 768×1024, and phone 390×844
  found no horizontal overflow. All eleven exact-manifest alt texts rendered
  from local `/wp-content/uploads/2026/11/` images; every image completed with
  `naturalWidth > 0`. Hero and difference images used `object-fit: cover`.
  Staging remained noindex. Production was not accessed for writes.
- `wp core verify-checksums` passed but warned of an existing extra
  `wp-admin/error_log` (mode 644, 706 bytes). Its public path returned `200
  text/html` with a 745-byte body, not the file's 706-byte length; direct file
  exposure was not established. It was left untouched for separate review.

The operator rollback is separate and requires the returned seed-clone ID/hash
and the post-apply managed hash, plus a fresh verified backup, administrator,
explicit confirmation, exact staging origin, noindex, and InnoDB tables:

```sh
wp --path=/home/tanzhihb/test.tanzaniasensational.com \
  --user=<verified-staging-admin-id> \
  --require=/home/tanzhihb/ts-migration-releases/<release-id>/import/safari-image-seed-import-cli.php \
  ts safari-images rollback --confirm-staging-write \
  --backup-dir=/home/tanzhihb/ts-migration-backups/<fresh-backup-id> \
  --backup-id=<image-seed-private-clone-id> \
  --backup-hash=<image-seed-backup-hash-from-apply> \
  --managed-hash=<post-apply-managed-hash>
```

Rollback locks and verifies the live landing plus all nine destination records,
restores their exact post fields/raw metadata and ACF image fields from the
verified clone, and checks both the restored records and retained clone before
commit. It deliberately retains verified image attachments for safe re-apply;
it does not delete upload files. Any drift or incomplete read-back stops the
operation; if transactional recovery cannot be proven, the landing is
quarantined as a draft. Unit tests with the WordPress stubs do not prove live
database lock blocking or replace the staging backup and browser checks.

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

