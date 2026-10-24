# Build Status

Last updated: 2026-10-24

## Completed

- Confirmed staging is isolated at `test.tanzaniasensational.com`
- Verified WordPress core integrity
- Captured a database, custom-plugin, plugin-list, and theme-list backup
- Disabled search-engine indexing on staging
- Inventoried pages, CPT content, ACF registration, and Elementor templates
- Confirmed existing header and dynamic templates are shortcode shells
- Confirmed the footer is a custom Elementor widget
- Confirmed the homepage uses editable hero and stats widgets plus a legacy
  shortcode for its remaining sections
- Registered and placed the editable `TS Safari Packages` widget on Home;
  verified one rendered section and six dynamic tour cards
- Built, registered, and placed the editable `TS Safari Destinations` widget;
  verified one rendered section and three dynamic destination cards
- Built, registered, and placed the editable `TS Experience` widget, including
  image controls, badge controls, headings, copy, and a repeater for value
  pillars; verified one section and three pillars
- Built, registered, and placed the editable `TS Group Departures` widget with
  heading, CTA, and repeatable route/date/capacity/price/link controls;
  verified one section and four departure cards
- Built, registered, and placed the editable `TS Testimonials` widget with a
  repeater for quote, guest, location, and portrait; verified one section and
  three testimonial cards
- Built and placed the editable `TS Signature Experiences` widget with
  repeatable image, title, description, label, and link controls
- Built and placed the editable `TS Journey CTA` widget with background,
  heading, and primary/secondary action controls
- Removed the final homepage shortcode shell after all nine homepage sections
  were converted; the Home Elementor tree now contains nine Tanzania
  Sensational widgets and zero shortcode widgets
- Fixed Elementor's nested section/container/column wrappers constraining the
  migrated homepage sections; Home now applies a page-scoped full-width reset
- Bumped the homepage stylesheet cache version to `1.1.0` so browsers receive
  the width correction immediately
- Corrected the Elementor homepage section order to match React exactly:
  Hero, Stats, Signature Experiences, Safari Packages, Destinations,
  Experience, Departures, Testimonials, CTA
- Normalized the Elementor header and footer Theme Builder wrappers, moved the
  hero content upward based on review feedback, and bumped layout assets to
  `1.1.1`
- Added the responsive header interaction layer: functional hamburger control,
  accessible expanded state, mobile navigation panel, accordion mega-menus,
  Escape/resize cleanup, link-close behavior, and page-scroll locking
- Added viewport reveal behavior and matching hero entrance motion, including
  a reduced-motion fallback, and deployed the combined frontend assets as
  version `1.2.0`
- Verified the deployed page serves `public-layout.css`, `homepage.css`, and
  `frontend.js` at version `1.2.0`; staging and production both return HTTP 200
- Removed vertical margin, padding, and row gaps from the homepage's generated
  Elementor wrappers and deployed the spacing correction as `1.2.1`; each
  custom section retains only its intentional internal spacing
- Converted the global header template from `[ts_header]` to the editable
  `TS Header` widget, including logo, contact, CTAs, navigation links, and both
  mega menus controls; the Theme Builder display condition remains unchanged
- Converted the Tour Archive template from `[ts_tour_archive]` to the editable
  `TS Tour Archive` widget with heading, introduction, CTA, count, featured
  filter, and empty-state controls; verified three ACF-backed tour cards at
  `/safaris/packages/`
- Converted the Single Tour template from `[ts_single_tour]` to the editable
  `TS Single Tour` widget; reusable section labels and CTA are controlled in
  Elementor while each tour's content remains managed through WordPress/ACF
- Verified all three published single-tour URLs return HTTP 200 with one
  dynamic tour body and no `[ts_single_tour]` shortcode marker
- Converted the Destination Archive from `[ts_destination_archive]` to the
  editable `TS Destination Archive` widget with title, emphasis, query, and
  empty-state controls; verified three dynamic destination cards and HTTP 200
- Converted the Single Destination template from `[ts_single_destination]` to
  the editable `TS Single Destination` widget; reusable section/vital labels
  and CTA are controlled in Elementor while destination content remains in ACF
- Verified Tarangire, Ngorongoro, and Serengeti each return HTTP 200 with one
  complete dynamic destination body and no shortcode marker
- Audited all six global/dynamic Theme Builder templates: header, footer,
  single/archive Tour, and single/archive Destination now each use their
  dedicated Tanzania Sensational Elementor widget with zero shortcode widgets
- Promoted the homepage wrapper correction into the global layout stylesheet:
  ordinary Elementor pages, Theme Builder archives, and Theme Builder single
  templates now use a full-viewport canvas with zero generated outer margin,
  padding, or row gap and horizontal overflow containment
  content spacing remains owned by each Tanzania Sensational section
- Deployed the global width fix as `public-layout.css` version `1.2.2` and
  verified Home, About, Contact, Zanzibar, Tour archive/single, and Destination
  archive/single endpoints all return HTTP 200
- Corrected the ordinary-page canvas selector from Elementor type `wp-page` to
  the actual rendered type `page`, and added the legacy shortcode wrapper to
  the full-width reset; deployed as `public-layout.css` version `1.2.3`
- Verified About, Contact, and Zanzibar each serve the `1.2.3` asset, expose an
  Elementor `page` canvas, retain their page-specific content root, and return
  HTTP 200
- Added a second ordinary-page reset for the Elementor shortcode component
  root and its direct full-bleed sections, while preserving each page's
  intentional inner content widths
- Deployed `public-layout.css` version `1.2.4`; verified About, Contact,
  Zanzibar, FAQ, Safari Guide, Kilimanjaro Pillar, Gear Checklist, Training
  Guide, and Safari Add-ons all serve that asset and return HTTP 200
- Replaced the About page shortcode element with the dedicated `TS About Page`
  Elementor widget, added content-source and major-section visibility controls,
  and corrected the About ACF group location from obsolete page ID 8 to the
  current `about-us` page ID resolved by slug
- Replaced the Zanzibar shortcode element with the dedicated `TS Zanzibar
  Page` widget; Elementor now controls hero copy, final CTA labels/links, and
  visibility for all seven major page sections
- Verified About and Zanzibar each render one complete page root, load the
  full-width 1.2.4 asset, contain zero shortcode widgets, and return HTTP 200
- Replaced the Contact shortcode element with the dedicated `TS Contact Page`
  Elementor widget; controls cover hero copy, phone/email/WhatsApp details,
  form heading/copy/button, and visibility of hero, inquiry, and map sections
- Verified Contact renders one complete root with hero, form, and map, loads
  the full-width 1.2.4 asset, contains zero shortcode widgets, and returns
  HTTP 200
- Replaced the FAQ shortcode element with the dedicated `TS FAQ Page`
  Elementor widget; controls cover hero/search copy, contact CTA, current phone
  details, and visibility of the hero, filters, questions, and CTA sections
- Preserved the four-category FAQ dataset and client-side search/filter logic;
  verified the complete FAQ root, four bento cards, search script, corrected
  phone link, full-width 1.2.4 asset, zero shortcode widgets, and HTTP 200
- Added dedicated Elementor widgets for Safari Guide, Kilimanjaro Pillar, Gear
  Checklist, Training Guide, and Safari Add-ons, with controls for major page
  section visibility while preserving their complete structured renderers
- Replaced the `/safaris` page's `[ts_tours_grid]` element with the existing
  tested `TS Tour Archive` widget and retained its full dynamic tour query/CTA
- Migrated pages 22 through 27 in one validated batch and regenerated all
  Elementor CSS/cache artifacts
- Completed a site-wide audit of pages 18 through 28: every production-intent
  page now uses dedicated Tanzania Sensational Elementor widgets and reports
  `shortcodes=0` in its Elementor data; production remains HTTP 200
- Completed the final staging integrity sweep: every PHP file in the custom
  design plugin passes `php -l`, all 24 expected custom Elementor widgets are
  registered, no Elementor document in the database contains a shortcode
  widget, and no WordPress `debug.log` exists
- Completed a responsive source audit for fixed widths, grid minimums, media,
  embeds, and overflow across all shared stylesheets
- Added cross-page responsive guardrails for every migrated page family:
  bounded component roots, consistent border-box sizing, shrinkable flex/grid
  descendants, responsive media/iframes, and a viewport-safe footer form
- Deployed the responsive guardrails as `public-layout.css` version `1.2.5`;
  verified About, Zanzibar, Safari Guide, Kilimanjaro Pillar, Gear Checklist,
  Tour Archive, and Single Destination all load 1.2.5 and return HTTP 200
- Audited 65 distinct internal paths exposed by migrated page markup and found
  legacy Laravel routes without corresponding WordPress content
- Corrected the editable Header widget's default booking CTA from the missing
  `/booking` route to `/contact`
- Added exact-path 302 fallbacks that run only after WordPress resolves a 404,
  covering missing company/blog/departure aliases, Safari Guide child paths,
  safari country/style paths, the obsolete Ngorongoro Crater slug, and Trekking
  detail/guide paths; future real WordPress pages automatically take precedence
- Re-crawled representative former 404 paths and verified each reaches an
  existing relevant WordPress page with final HTTP 200; production remains 200
- Replaced the About page's `[ts_about_page]` shortcode element with the
  dedicated `TS About Page` Elementor widget, including content-source and
  major-section visibility controls
- Corrected the About ACF field-group assignment from obsolete page ID 8 to a
  slug-resolved About page ID (currently 18), so its structured content fields
  appear on the correct WordPress edit screen
- Verified About renders one widget, one full page root, all five designed
  sections, zero shortcode widgets, layout asset 1.2.4, and HTTP 200
- Removed Elementor's residual vertical margin, padding, minimum height, and
  row gap from every outer homepage widget wrapper; the component sections
  retain their own intentional internal spacing (`homepage.css` 1.2.1)
- Built and deployed the editable `TS Header` Elementor widget with controls
  for branding, contact details, both calls to action, standard navigation,
  and Safari/Trekking mega-menu content
- Replaced the active Theme Builder header's `[ts_header]` shortcode widget
  with `elementor-widget-ts_header`, preserving the global display condition
- Updated the legacy homepage renderer so migrated sections can be skipped
  individually without duplicating content
- Configured Elementor Global Styles to match the Laravel design system:
  - Sea-washed teal `#5B7B7A`
  - Driftwood `#8C6D52`
  - Deep Water `#1F2926`
  - Brand Gold `#C9A84C`
  - Warm Linen `#F7F4EF`
  - Muted Text `#535C58`
  - Bleached Sand `#C9B99A`
  - White `#FFFFFF`
- Configured Elementor global typography:
  - Headings: Playfair Display 600
  - Editorial: Cormorant Garamond 500
  - Body: Source Serif 4 400
  - Labels/UI: DM Sans 600
- Set the Elementor content width to 1400px and regenerated Elementor CSS
- Verified staging and production homepages still return HTTP 200
- Registered the dormant `TS Safari Packages` Elementor widget
- Replaced the homepage's hard-coded Safari Packages block with that editable
  Elementor widget while retaining the remaining legacy sections
- Verified the homepage contains exactly one packages section, rendered by
  `elementor-widget-ts_packages`, with six dynamic tour cards

## Current build unit

- Started the separate `tanzania-sensational-core` application plugin so
  booking operations no longer need to be added to the presentation plugin
- Added versioned WordPress database installation for departure inventory and
  private booking records, including references, contact details, pricing,
  status, held seats, and indexed hold-expiry timestamps
- Added an hourly WordPress cron event for releasing expired 36-hour holds
- Ported transactional booking status reconciliation with row locks,
  idempotent confirm/cancel behavior, departure availability states, and an
  explicit one-way status-transition map
- Captured a fresh pre-deployment staging database and design-plugin backup at
  `/home/tanzhihb/ts-migration-backups/20260910-033747`
- Deployed and activated `tanzania-sensational-core` 0.1.0 on WordPress staging
- Verified both custom tables were installed, the hourly hold-release event is
  scheduled, a manual cron execution succeeds, and no WordPress `debug.log`
  was created
- Deployed `tanzania-sensational-core` 0.2.0 with validated public REST
  submission routes for safari and departure requests, one-minute duplicate
  throttling, a honeypot check, and server-side sanitization
- Added protected booking list/status REST routes restricted to WordPress
  administrators and a nonce-protected Bookings screen in wp-admin
- Added plain-text customer acknowledgment and administrator notification
  emails after successful booking persistence
- Ran an isolated live staging lifecycle test covering safari creation,
  departure hold, contacted, confirmed, cancelled, and balanced seat release;
  all temporary bookings and departures were removed after the test
- Verified invalid public requests return HTTP 400, unauthenticated operations
  requests return HTTP 401, the Bookings admin menu is registered, and the
  staging homepage remains HTTP 200
- Deployed the first public booking integration on all single Safari Package
  pages: the CTA now scrolls to a responsive booking form connected to the
  safari REST route, with accessible success/error feedback and no online
  payment collection
- Verified the rendered Grand Canvas page contains one booking form, the live
  REST endpoint, and versioned booking CSS/JavaScript; an intercepted-mail REST
  test created and removed a real staging booking successfully
- Upgraded `tanzania-sensational-core` to 0.3.0 and its schema to version 2,
  adding route labels and links to database-backed departure inventory
- Created and published WordPress page 50 at `/group-departures/`, using the
  full-width header/footer template and a responsive departure booking surface
- Imported the four October/November 2026 routes previously advertised through
  Elementor defaults as real inventory with USD pricing and seat availability
- Verified `/group-departures/` returns HTTP 200 with four cards, one booking
  form, the correct REST endpoint, and versioned core assets
- Ran an intercepted-mail departure REST test that created a hold, reconciled
  the held seat on cancellation, and removed the temporary booking; staging
  retains four departures and zero test bookings

- Matched the WordPress header dropdown structure to the React Navbar: Safari
  now renders three equal mega-menu columns and Trekking retains five columns
- Replaced Safari country fallback links with the three real WordPress
  destination pages and corrected Safari Guide Overview plus the Trekking
  top-level routes anchor
- Added the React-style mobile navigation drawer with blurred backdrop,
  right-side sliding panel, expandable Safari/Trekking groups, simple links,
  journey CTA, and WhatsApp action
- Updated the mobile JavaScript for drawer open/close, backdrop, Escape,
  accordion, link-close, ARIA, and body-scroll behavior
- Deployed plugin/layout version 1.2.15 and frontend script 1.2.1; corrected
  Elementor JSON newline escaping and verified live 3/5-column menus, both
  mobile groups, real destination links, and no non-200 navbar link
- Added independent Elementor visibility switches for all seven Safari Guide
  chapters and all seven Kilimanjaro chapters, allowing editors to suppress a
  complete content section without deleting its text or cards
- Added scoped nth-section CSS for those 14 switches without affecting either
  hero, final CTA, inner editorial spacing, or other page types
- Deployed plugin/layout asset version 1.2.14, regenerated Elementor CSS, and
  verified both guides retain seven visible chapters, their CTA, full-width
  layout, and HTTP 200 with default settings
- Added 20 Elementor controls for all seven Kilimanjaro guide chapters: each
  eyebrow and heading is editable, along with all six chapter introductions
- Preserved the original heading accents, including the special mid-heading
  emphasis in “What to Expect During Your Climb”
- Deployed plugin asset version 1.2.13, regenerated Elementor CSS, and verified
  seven chapters, seven titles, 24 route/resource cards, the CTA, and HTTP 200
  on staging; production remains untouched
- Added 20 Elementor controls for all seven Safari Guide chapters: each
  eyebrow and heading is editable, along with all six chapter introductions
- Preserved the original final-word italic treatment automatically for every
  editable chapter heading
- Deployed plugin asset version 1.2.12, regenerated Elementor CSS, and verified
  seven chapters, seven titles, 24 existing content cards, and the full-width
  layout asset on staging; production was not modified
- Converted the Gear Checklist's five hard-coded categories into an Elementor
  repeater with newline-editable checklist items; editors can now add, remove,
  reorder, or rename categories and individual gear entries
- Preserved the interactive checkbox, rental-quantity, local progress tracking,
  and rental form markup while generating collision-safe item IDs
- Deployed plugin asset version 1.2.11, regenerated Elementor CSS, and verified
  five default categories, 35 rendered gear checkboxes, the rental form, full-width
  layout asset, and HTTP 200 on staging; production remains untouched
- Corrected an editability-related visual regression in the Kilimanjaro widget:
  editable hero and CTA headings now retain the original italic emphasis on
  their final word
- Deployed plugin asset version 1.2.10, regenerated Elementor CSS, and verified
  the exact emphasized hero and CTA heading markup on the live staging page
- Regression-checked Safari Guide, Gear Checklist, and Training Guide at
  version 1.2.10; each retains its component root and HTTP 200
- Expanded Gear Checklist with editable rental-request heading, instructions,
  submit label, and form destination while preserving all 35 interactive items
- Converted the Training Guide's three hard-coded cards into an Elementor
  repeater; editors can add, remove, reorder, and edit each numbered step and
  its newline-separated checklist without changing the grid markup
- Deployed plugin asset version 1.2.9, regenerated Elementor CSS, cleared the
  staging cache, and verified both pages and all new controls at HTTP 200
- Expanded the Kilimanjaro Pillar Elementor widget with editable final CTA
  heading, description, primary/contact button labels, and both button links
- Expanded Safari Add-ons with editable images, headings, descriptions, button
  labels, and links for both the Safari and Zanzibar cards
- Deployed plugin asset version 1.2.8, regenerated Elementor CSS, flushed the
  staging cache, and verified all 16 new controls are registered
- Verified both updated pages retain their original default content, images,
  buttons, full-width layout asset, and HTTP 200 response; production remains
  untouched and HTTP 200
- Completed a rendered-source crawl of every published standard page, all
  tour/destination archive and single templates, plus the sample page: all
  return HTTP 200, load the shared full-width layout asset, render the global
  header/footer, and contain no legacy Elementor shortcode widgets
- Audited outer Elementor document settings across pages and Theme Builder
  templates; all production-intent documents use full-width/no-gap sections
  with zero outer margin and padding
- Extracted and checked all internal content routes exposed by the rendered
  pages; no non-200 route was found (two large responses reached the transfer
  timeout only after returning content)
- Added editable Elementor Media controls for the hero background on Safari
  Guide, Kilimanjaro Pillar, Gear Checklist, Training Guide, and Safari Add-ons
- Deployed plugin asset version 1.2.7, regenerated Elementor CSS, flushed the
  staging cache, and verified all five pages render their hero and return 200
- Deployed `public-layout.css` 1.2.6 with working first/final-section visibility
  classes for structured Elementor pages
- Restored the previously missing visibility controls on Safari Guide,
  Kilimanjaro Pillar, Gear Checklist, Training Guide, and Safari Add-ons
- Added editable hero eyebrow, heading, and introduction controls to all five
  structured guide widgets while retaining their original page markup
- Verified the updated widget PHP on staging, regenerated Elementor CSS, flushed
  WordPress caches, and confirmed all five widget types expose every new control
- Verified Safari Guide, Kilimanjaro Pillar, Gear Checklist, Training Guide, and
  Safari Add-ons return HTTP 200 and load `public-layout.css` 1.2.6

## Current local-only continuation (2026-10-24)

- Added a shared future/available-departure query to the core plugin and reused
  it for the public departures page.
- Replaced the homepage widget's stale date/price/seat repeater defaults with
  live database inventory, an editor-controlled card limit and empty state, and
  links that identify the selected departure on the booking page.
- Added query-string auto-selection to the group-departures form, so a homepage
  card opens the form for that exact departure.
- Added a server-side guard so direct/stale requests cannot book a past or
  closed departure. A protected WordPress UI for operations staff to create,
  edit, and close inventory is still missing; records are not yet manageable
  through a normal admin workflow.
- Bumped the core plugin to 0.4.0 for cache invalidation. Added isolated PHP
  query/render/booking-guard tests and a Node test for browser selection.
- Verification: all four modified PHP files pass `php -l`; all three PHP tests
  and the Node test pass. These changes are local only and have not been deployed.

## Remaining release blockers

1. Build the protected WordPress departure-inventory management screen.
2. Add repeatable automated concurrency and expiry-reconciliation tests.
3. Verify SMTP delivery for customer and administrator messages.
4. Resolve the missing/misrouted public routes and content recorded in
   `PARITY-AUDIT-2026-10-24.md`.
5. Complete source-to-staging visual comparisons and final breakpoint tuning.

## Constraint

Screenshot-level visual comparison is pending because no controllable browser
was available in the current session. Server-side implementation and HTTP
verification can continue, but responsive visual acceptance requires a browser
session.
