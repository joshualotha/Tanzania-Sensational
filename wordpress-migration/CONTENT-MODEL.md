# Content Model

| Laravel model/content | WordPress target | Primary URL |
|---|---|---|
| `TrekkingRoute` | `ts_trek_route` CPT | `/trekking/kilimanjaro/{slug}` |
| `RouteItineraryDay` | ACF itinerary repeater | Parent route URL |
| `Departure` | `ts_departure` CPT or custom table-backed admin entity | `/group-departures/{slug}` |
| `SafariPackage` | `ts_tour` CPT | `/safaris/packages/{slug}` |
| `Destination` | `ts_destination` CPT | `/safaris/destinations/{slug}` |
| `BlogPost` | WordPress post | `/blog/{slug}` |
| `Page` | WordPress page | Existing page route |
| `GearItem` | `ts_gear_item` CPT | No required public single URL |
| `PricingRule` | Custom table or structured route fields | No public URL |
| `Booking` | Custom database table | Private admin only |
| `GearRentalRequest` | Custom database table | Private admin only |
| `ContactSubmission` | Form submission storage | Private admin only |
| `SiteSetting` | ACF options page | Global |
| `VisualAsset` | Media Library plus ACF image fields | Global/content scoped |

## Tour fields

- Subtitle, duration, country, category, base price, currency
- Hero image, gallery, overview, highlights
- Inclusions and exclusions
- Day-by-day itinerary
- Featured flag and display order
- SEO title, description, social image, and canonical override

## Trekking route fields

- Route family and duration variant
- Difficulty, distance, success rate, accommodation style
- Base price and pricing-rule relationship
- Hero/editorial images and gallery
- Overview, highlights, inclusions, exclusions
- Day-by-day itinerary with elevation, distance, habitat, meals, and camp
- Featured flag and display order

## Destination fields

- Country/region taxonomy, subtitle, label, coordinates
- Hero image, gallery, overview, short description
- Wildlife/highlights, best months, climate, access, and related tours
- Featured flag and display order

## Editorial rule

Repeated structured content belongs in ACF. Free-form campaign pages belong in
Elementor. Editors should not duplicate package layouts on individual pages.

