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

