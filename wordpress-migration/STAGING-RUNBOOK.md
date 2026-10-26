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

