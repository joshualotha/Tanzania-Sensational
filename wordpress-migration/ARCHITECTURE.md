# WordPress Architecture

## Presentation layer

Elementor Pro Theme Builder will provide:

- Global header, navigation, announcement bar, footer, and WhatsApp action
- Single templates for tours, trekking routes, destinations, and blog posts
- Archive and loop templates for packages, routes, destinations, departures,
  and blog posts
- Fully editable marketing pages
- Global colors, typography, buttons, spacing, and responsive breakpoints

Custom Elementor widgets are justified only for interactive or repeated UI
that native Elementor widgets and dynamic tags cannot express cleanly.

## Content layer

WordPress posts and custom post types store content. ACF Pro field groups store
structured fields and repeaters. Shared settings live in an ACF options page,
not in an artificial `ts_site_setting` post.

## Application layer

The `tanzania-sensational-core` plugin will eventually own:

- Custom post types and taxonomies
- ACF field registration exported to PHP or local JSON
- Booking records and booking-reference generation
- Departure capacity and 36-hour seat holds
- Booking status transitions and seat reconciliation
- Seasonal/group pricing rules
- Customer and administrator email notifications
- Scheduled release of expired holds
- Purpose-built Elementor widgets where necessary

Business operations must be validated server-side. Elementor forms provide the
interface but are not the source of truth for pricing or availability.

## URL compatibility

The WordPress rewrite structure must preserve these route families:

- `/safaris/packages/{slug}`
- `/safaris/destinations/{slug}`
- `/trekking/kilimanjaro/{slug}`
- `/trekking/kilimanjaro/{route}/{package}` where still required
- `/blog/{slug}`
- `/company/{slug}`
- `/safari-guide/{slug}`
- `/group-departures/{id-or-slug}`

Redirects are introduced only where an exact route cannot be maintained.

## Existing staging plugin disposition

The active `tanzania-sensational-design` plugin contains useful design work,
but currently mixes:

- Custom post type registration
- ACF field definitions
- PHP-rendered page sections and shortcodes
- Elementor widgets
- Legacy Oxygen template-generation code
- One-time seeding and color scripts

It must be backed up before refactoring. Reusable Elementor widgets and valid
content definitions can be retained. Oxygen-specific and one-time scripts
should not remain in the final production plugin.

