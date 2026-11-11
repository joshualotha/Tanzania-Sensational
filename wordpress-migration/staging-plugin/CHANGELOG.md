# Tanzania Sensational Design System Changelog

## 1.3.5 — 2026-10-29

### Fixed
- Reject unsafe URL schemes in the editable hero widget's Elementor preview while retaining safe web, email, and telephone links.
- Match the Kilimanjaro pillar hero to the live source and keep structured-page hero images filling their containers under Elementor's global image sizing.
- Add an exact fallback from the legacy `/trekking/kilimanjaro/` route to the source-matched Kilimanjaro pillar.
- Derive the structured-page stylesheet cache version from its file modification time.

## 1.3.4 — 2026-10-29

### Fixed
- Keep the tablet blog featured hero at the intended 70vh height instead of inheriting the desktop 90vh minimum.

## 1.3.3 — 2026-10-29

### Fixed
- Make featured/archive and article hero images fill their containers despite Elementor’s global image reset, and clip the article background to its hero.
- Route the legacy `/trekking/kilimanjaro/` URL to the Kilimanjaro pillar page whose H1 matches the live source, avoiding WordPress’s same-slug destination guess.

## 1.3.2 — 2026-10-29

### Fixed
- Keep the homepage hero photo full-bleed at tablet and mobile sizes despite Elementor's global image sizing, and derive its stylesheet cache version from the file modification time.

## 1.3.1 — 2026-10-29

### Fixed
- Restore the homepage hero's two-line gold emphasis while escaping editor-entered title, subtitle, and CTA text in the frontend and Elementor preview.
- Bundle the source homepage hero image as a 1600×1067 WebP (197,770 bytes), instead of relying on the external Unsplash default.

## 1.3.0 — 2026-10-27

### Added
- Add an editable single-route trekking renderer and Elementor widget, with responsive layout, contextual inclusion headings, safe empty-preview behavior, and configurable section labels.
- Register source-path-preserving trekking route records and route-specific ACF editorial fields.

## 1.2.18 — 2026-10-26

### Fixed
- Use the saved Rank Math description on destination pages without a duplicate excerpt description from Hello Elementor.

## 1.2.17 — 2026-10-25

### Added
- Add live-source destination ledgers, ordered gallery URLs with alt text, and per-destination Rank Math title/description values.

### Changed
- Match destination hero headings, labels, lead copy, metadata and media to the approved live-source records.

### Fixed
- Align the mobile top bar with the source: keep the booking CTA visible and prevent contact details from pushing it off-screen.
- Keep the navigation toggle hidden on desktop and correctly sized on mobile despite Elementor's global button reset.
- Bump the public-layout stylesheet cache version with the fix.
