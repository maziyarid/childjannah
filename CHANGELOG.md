# Changelog — Teznevisan Child Theme

All notable changes are documented here.

## [3.1.0] — 2026-02-24

### Added
- `inc/misc-tweaks.php`: `tez_strip_legacy_injected_blocks()` — self-healing filter (priority 0) that
  automatically strips previously hand-pasted hero blocks containing broken PHP output from
  stored page content. Fast bail-out guard ensures ~0ms overhead on clean pages.
- `css/page-templates.css`: Auto-hero variant styles — `.tez-has-bg`, `.tez-page-hero-overlay`,
  `.tez-page-hero-content`, `.tez-page-hero-title`, `.tez-page-hero-excerpt`. These were missing
  and caused layout breakage when `tez_auto_hero_on_pages()` rendered on standard pages.
- `css/page-templates.css`: Global static block classes — `.tez-hero-container`, `.tez-hero-usps`,
  `.tez-features-grid`, `.tez-process-steps`, `.tez-mini-faq-grid`, `.tez-see-all`, utility
  classes `.tez-text-center`, `.tez-bg-light`.

### Changed
- `inc/misc-tweaks.php`: `tez_auto_hero_on_pages()` output now uses `.tez-hero-container` wrapper
  to stay consistent with the hero markup in all 7 template files. Adds `.tez-has-bg` class when
  featured image is available, enabling the overlay+bg-cover CSS variant.
- `css/page-templates.css`: Version bump 3.0.0 → 3.1.0; comment headers updated throughout.

### Fixed
- Pages where manual hero HTML with PHP code was pasted in the editor now self-heal on next
  page load without needing manual database edits.
- `.tez-page-hero-overlay` was missing from CSS; the overlay div rendered but had no appearance
  rules, making background-image pages unreadable.

---

## [3.0.0] — 2026-02-10

### Added
- Full theme rewrite on `New` branch.
- Header/footer PHP templates with Tez walkers, theme switcher, a11y toolbar, Chaty widget.
- Local Irancell font stack via `@font-face` (weights 200–800).
- FA7 local icon set with icon-mapping bridge for Jannah `tie-icon-*` classes.
- Conditional CSS/JS loading per page type.
- 7 fully coded page templates: homepage, services, inquiry, about, contact, faq, tag-hub.
- Auto-hero system for non-templated pages.
- SEO redirects, author archive removal, date archive 301 redirect.
- Visual HTML sitemap, feed control, rich 404 page.
- Poll System v3.0.0, Key Takeaways v3.0.0, FAQ Schema v3.0.0.

---

## [2.x] — Legacy

Previous iterations using WPCode snippets and manually pasted HTML in page content.
Replaced entirely by the v3.0.0 rewrite.
