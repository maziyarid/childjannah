# Development Report — Teznevisan Child Theme v3.1.0

**Repository:** maziyarid/childjannah  
**Branch:** `New` (working) → merge to `master` when QA passes  
**WordPress:** 6.9.x compatible  
**Jannah:** 7.6.x compatible  
**Last Updated:** 2026-02-24  

---

## 1. Architecture Overview

This is a **Jannah child theme** with zero dependency on page builders. All layout is produced by:

1. PHP template files in `/templates/` (registered via `inc/page-templates.php`)
2. A PHP auto-hero system in `inc/misc-tweaks.php` for standard (non-templated) pages
3. CSS in `css/page-templates.css` (loaded conditionally on `is_page() || is_404()`)

Jannah's parent theme provides the base layout engine (grid, sidebar, nav, breadcrumbs). The child theme extends it by overriding `header.php` and `footer.php` and adding Tez-prefixed components that layer on top of Jannah's CSS without overriding core parent rules.

---

## 2. File Structure

```
childjannah/
├── style.css                  # Theme registration header only
├── functions.php              # Central loader — require() all inc/ files
├── header.php                 # Full override — nav, theme switcher, a11y toolbar
├── footer.php                 # Full override — 4-col footer, Chaty, scroll-top
├── 404.php                    # Rich 404 page with smart suggestions
├── css/
│   ├── main.css               # Global styles, design tokens, buttons, layout
│   ├── single-post.css        # Post-only: key takeaways, poll, FAQ schema, TOC
│   ├── page-templates.css     # Page-only: hero, sections, forms, all templates
│   └── post-elements.css      # Singular content: typography, media, tables
├── js/
│   ├── scripts.js             # Global: menu, theme switcher, search overlay, scroll-top
│   └── single-post.js         # Post-only: poll, accordion, copy-code, TOC scroll
├── inc/
│   ├── core-setup.php         # Theme supports, nav menus, image sizes
│   ├── typography.php         # Irancell @font-face, Google Fonts block, FA7 local
│   ├── icon-mapping.php       # Jannah tie-icon-* → FA7 class bridge
│   ├── misc-tweaks.php        # Comment email removal, auto-hero, legacy cleanup
│   ├── page-templates.php     # Register 7 templates, load from child theme dir
│   ├── seo-redirects.php      # Date/author 301 redirect, author enumeration block
│   ├── seo-url-cleanup.php    # Tracking param strip on canonical/schema
│   ├── visual-sitemap.php     # HTML sitemap shortcode + page
│   ├── feed-controller.php    # RSS/Atom feed gating
│   ├── 404-hub.php            # 404 content: search + recent posts
│   └── [17 blog modules]      # poll, key-takeaways, faq-schema, etc.
└── templates/
    ├── homepage.php
    ├── services.php
    ├── inquiry.php
    ├── about.php
    ├── contact.php
    ├── faq.php
    └── tag-hub.php
```

---

## 3. Hero System

Two paths produce a hero on any given page:

### Path A — Template hero (for pages with a Tez template)

Each template file in `/templates/` opens with a full hero block:

```php
<div class="tez-page-hero">
    <div class="tez-hero-bg"><div class="tez-hero-pattern"></div></div>
    <div class="tez-hero-content">
        <div class="tez-hero-container">
            <!-- breadcrumb, h1, excerpt, CTAs -->
        </div>
    </div>
</div>
```

The `tez_hide_page_title_on_templates()` filter blanks the default WordPress title for these pages so no duplicate H1 appears.

### Path B — Auto-hero (for standard pages without a template)

`tez_auto_hero_on_pages()` in `inc/misc-tweaks.php` hooks `the_content` at priority 1. It:

1. Bails if not `is_page()`, if in admin, or if a `templates/` slug is set
2. Reads `get_the_title()`, `get_the_excerpt()`, `get_the_post_thumbnail_url()`
3. Produces a `.tez-page-hero` div with `.tez-has-bg` class (when featured image exists)
4. Prepends it to the page content

The auto-hero runs AFTER `tez_strip_legacy_injected_blocks()` (priority 0), so the content is cleaned first, then the proper hero is added.

### Path C — Self-healing cleanup (one-time)

`tez_strip_legacy_injected_blocks()` in `inc/misc-tweaks.php` hooks `the_content` at priority 0. It uses `strpos()` guards for near-zero overhead and only runs the `preg_replace()` when the specific class markers are found in stored content.

---

## 4. CSS Loading Strategy

All CSS is loaded via `tez_enqueue_child_assets()` in `functions.php`. Nothing is output inline in PHP templates (except Jannah's own critical CSS). The loading conditions are:

| File | Condition | Purpose |
|---|---|---|
| `style.css` | Always | Child theme registration |
| `css/main.css` | Always | Design tokens, global layout |
| `css/page-templates.css` | `is_page() \|\| is_404()` | All page/template layouts |
| `css/single-post.css` | `is_singular('post')` | Post-specific modules |
| `css/post-elements.css` | `is_singular()` | Singular content typography |

This keeps total CSS on archive pages to ~2 files and on posts to ~3 files.

---

## 5. Icon System

The child theme ships Font Awesome 7 Pro locally (woff2 preloaded in `<head>`). Jannah uses its own `tie-icon-*` icon font. The bridge in `inc/icon-mapping.php` maps known Jannah icon class names to FA7 equivalents so both systems coexist.

Jannah's icon enqueue is NOT dequeued — this ensures backward compatibility with any Jannah widget or shortcode that depends on it. FA7 is loaded in ADDITION (priority 5) via `tez_enqueue_fontawesome()`.

---

## 6. Font System

- **Irancell** is served locally via `@font-face` in `inc/typography.php` (weights 200–800, woff2 only)
- Google Fonts API calls are intercepted and dequeued on `wp_enqueue_scripts`
- External FA CDN requests are blocked via output buffer in `inc/typography.php`
- Irancell woff2 files are preloaded in `<head>` for LCP performance

---

## 7. Page Templates

All 7 templates are registered in `inc/page-templates.php` and loaded from the child theme directory. Templates are self-contained PHP files that call standard WP functions but output all HTML directly (no shortcodes, no page-builder blocks).

| Template | File | Key Feature |
|---|---|---|
| Homepage | `templates/homepage.php` | Stats counter, service grid, testimonials |
| Services | `templates/services.php` | Accordion service list, quick inquiry form |
| Inquiry | `templates/inquiry.php` | Multi-section form with sidebar |
| About | `templates/about.php` | Mission, values, team stats |
| Contact | `templates/contact.php` | Contact cards, CF7 embed, map |
| FAQ | `templates/faq.php` | Category nav, accordion FAQ |
| Tag Hub | `templates/tag-hub.php` | Dynamic tag cloud + per-tag post grids |

---

## 8. SEO Architecture

- Date archives (`/2024/`) → 301 → homepage (via `inc/seo-redirects.php`)
- Author archives → 404 (prevents author enumeration)
- REST API author route blocked
- Sitemap exclusions via RankMath/Yoast compat filters
- Visual HTML sitemap via `inc/visual-sitemap.php`
- Feed gating via `inc/feed-controller.php`
- Tracking param cleanup on canonical/schema via `inc/seo-url-cleanup.php`

---

## 9. WordPress & Jannah Compatibility

Compatibility is maintained by:

1. **Never dequeuing** Jannah's core CSS handles (`tie-main-css`, `tie-base-css`, etc.)
2. **Never removing** Jannah's `body_class` filters
3. **Using child theme priority** (everything hooks at 20+ so Jannah's 10-priority hooks win first)
4. **CSS specificity**: All Tez classes use `.tez-` prefix and never override `.tie-` or `.post-` selectors
5. **Template override pattern**: `header.php` and `footer.php` follow the standard WordPress child theme override — they replace the parent file entirely but call `wp_head()`, `wp_footer()`, and all required hooks

---

## 10. Known Issues & Diagnosis Backlog

| Issue | Status | Fix |
|---|---|---|
| Pages with legacy injected hero blocks show PHP as text | Auto-fixed by `tez_strip_legacy_injected_blocks()` | Deploy and clear cache |
| Duplicate hero on some pages | Caused by both manual block + auto-hero running | Resolved: cleanup filter (priority 0) runs first |
| CSS for `.tez-page-hero-overlay` missing | Fixed in v3.1.0 | Included in page-templates.css |
| Footer menus empty | Not a code issue — menus need assigning in WP Admin | Manual step in Appearance > Menus |

---

## 11. Deployment Checklist

```
Pre-deploy:
[ ] Full database + files backup
[ ] Staging deploy of New branch
[ ] Clear all caches (WordPress, OPcache, CDN, browser)

Visual verification:
[ ] Homepage: single hero, correct title, green gradient or featured image
[ ] Services: accordion opens/closes, quick inquiry form renders
[ ] Inquiry: form sections display, sidebar shows contact info
[ ] About: stats, mission cards, team section
[ ] Contact: contact cards, CF7 form area
[ ] FAQ: category nav, accordion items
[ ] Standard page (e.g. Privacy): auto-hero from title + excerpt
[ ] 404 page: search box, recent posts
[ ] Single post: all blog modules (poll, key takeaways, FAQ schema)
[ ] Mobile: hamburger menu, responsive hero text, footer columns stack
[ ] Dark mode: all sections switch correctly

Technical verification:
[ ] DevTools Console: zero JS errors
[ ] DevTools Network: CSS/JS loaded only on intended pages
[ ] PHP debug log: zero notices or warnings
[ ] Lighthouse home + service + post > 90 performance
[ ] Footer menus assigned in WP Admin > Appearance > Menus
```

---

## 12. Merge & Release

When all checklist items pass:

```bash
git checkout master
git merge New --no-ff -m "release: v3.1.0 Teznevisan Child Theme"
git tag -a v3.1.0 -m "v3.1.0 — Full rewrite with self-healing hero system"
git push origin master --tags
```
