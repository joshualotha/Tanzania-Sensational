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
3. Confirm Elementor editor loads.
4. Confirm the homepage and one dynamic detail page return HTTP 200.
5. Confirm responsive behavior at phone, tablet, and desktop widths.
6. Confirm no changes occurred on the production Laravel site.

## Backups

Backups are stored outside the public web root and include:

- A timestamped WordPress database export
- A timestamped archive of the custom Tanzania Sensational plugin
- An inventory of active plugins and themes

Backup retention and deletion must follow the hosting account's available
storage and should be agreed before old backups are removed.

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

