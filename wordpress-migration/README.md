# Tanzania Sensational WordPress Migration

This directory is the working specification for rebuilding the Laravel/Inertia
website as an editable WordPress and Elementor Pro site.

## Environments

| Environment | URL | Purpose | Change policy |
|---|---|---|---|
| Production | `https://tanzaniasensational.com` | Existing Laravel website | Do not modify during the migration |
| Staging | `https://test.tanzaniasensational.com` | WordPress replacement | All WordPress development and review happens here |

The WordPress document root is:

`/home/tanzhihb/test.tanzaniasensational.com`

## Confirmed staging stack

Last verified from staging with WP-CLI on 2026-10-27:

- WordPress 7.1.3
- Hello Elementor 3.5.1
- Elementor 4.3.5
- Elementor Pro 4.3.2 (active)
- Advanced Custom Fields Pro 6.8.9
- Rank Math SEO and Rank Math SEO Pro
- WP Mail SMTP
- Imagify and Lazy Load
- `tanzania-sensational-design` 1.2.19 (active)
- `tanzania-sensational-core` 0.5.0 (active)

## Implementation principles

1. Elementor owns presentation: headers, footers, marketing pages, archives,
   single templates, responsive layouts, and global styles.
2. ACF owns structured editorial data such as duration, price, itinerary,
   inclusions, gallery, destination facts, and departure dates.
3. A custom plugin owns business rules such as bookings, capacity, seat holds,
   pricing calculations, notifications, and scheduled cleanup.
4. Editors should not need to edit PHP, CSS, JSON, or shortcodes for normal
   content updates.
5. Existing public URLs must be preserved wherever possible.
6. The Laravel production site remains untouched until staging acceptance and
   a separately approved cutover.

## Documentation

- [Architecture](ARCHITECTURE.md)
- [Content model](CONTENT-MODEL.md)
- [Execution plan](EXECUTION-PLAN.md)
- [Staging runbook](STAGING-RUNBOOK.md)

