# Execution Plan

## Phase 0 — Safety and inventory

- Capture a database and `wp-content` backup of staging
- Record WordPress, PHP, theme, and plugin versions
- Inventory existing content, Elementor templates, ACF groups, menus, and media
- Remove no existing work until its replacement is verified

## Phase 1 — Foundation

- Normalize the custom plugin architecture
- Remove final dependencies on Oxygen-specific code
- Establish Elementor global colors, fonts, widths, spacing, and buttons
- Create the global header, navigation, footer, and mobile menu
- Configure staging privacy and search-engine blocking

## Phase 2 — Structured content

- Finalize CPTs and taxonomies
- Finalize ACF Pro groups and options pages
- Create Elementor single and archive templates
- Build reusable Loop Grid cards
- Preserve existing Laravel URL structures

## Phase 3 — Public pages

- Homepage
- Safaris hub and package listing variants
- Safari package and destination detail templates
- Kilimanjaro hub, routes, and package variants
- Zanzibar, About, Contact, and Blog
- Planning and safari-guide editorial pages
- 404 and search pages

## Phase 4 — Business workflows

- Booking forms and server-side validation
- Departure capacity and temporary holds
- Status transitions and expired-hold scheduler
- Private trek pricing calculator
- Gear rental requests
- Email templates and SMTP verification
- Restricted WordPress admin views for operations staff

## Phase 5 — Migration and quality assurance

- Import Laravel database content and media
- Validate internal links, slugs, metadata, schema, and sitemap
- Compare desktop, tablet, and mobile layouts against Laravel pages
- Test accessibility, forms, email delivery, caching, and performance
- Run a full booking concurrency and status-transition test suite

## Phase 6 — Cutover (separate approval required)

- Freeze content updates for the final data sync
- Take production and staging backups
- Run final import and URL comparison
- Change the production document root or deploy the accepted WordPress build
- Verify SSL, caching, forms, cron, email, analytics, and Search Console
- Retain a tested rollback path

## Initial definition of done

The foundation is complete when staging has a consistent Elementor global
design system, editable global header/footer, normalized content types and ACF
fields, a working archive/single template pair, and no production impact.

