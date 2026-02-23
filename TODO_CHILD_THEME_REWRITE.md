# Jannah Child Theme – FINAL REVISION TODO (No Missings)

**Branch:** `New` (implementing directly)
**Goal:** Stable, bug‑free Jannah child theme that:  
- Uses built‑in Jannah features as base  
- Uses child theme mainly for **appearance + advanced enhancements**  
- Keeps footer, single‑post enhancements, ToC, FAQ, polls, ratings, meta  
- Uses Irancell fonts + local Font Awesome **without breaking Jannah icons**  
- Fixes double top menu and invalid HTML structure  

---

## Phase 0 – Git & Prep

### 0.1 Branch & file setup

- [x] Create branch from `New` (using existing `New` branch directly)
- [x] Add this file as `TODO_CHILD_THEME_REWRITE.md`
- [x] Commit TODO file

### 0.2 Environment & theme setup

- [ ] Ensure staging environment ready
- [ ] Full backup of database + wp-content
- [ ] Jannah parent theme installed and updated
- [ ] Child theme activated
- [ ] Deactivate overlapping WPCode snippets
- [ ] Clear all caches

---

## Phase 1 – Header/Footer Architecture & Double Menu Fix ✅ COMPLETE

- [x] `/header.php` override: full HTML structure, nav walkers, `<main>` open
- [x] `/footer.php` override: 4-column grid, Chaty, scroll-top, `wp_footer()`
- [x] `inc/core-setup.php`: removed 3 hook-based output functions
- [x] `inc/footer.php`: stripped to utility-only
- [x] `tez_filter_body_classes()`: sidebar classes preserved for posts/archives

**Commits:** `8dd7187`, `3baaeec`, `439854d`, `0d13f22`

**Verification (Phase 1):** ⚠️ NEEDS STAGING TEST

- [ ] Homepage/service/post/archive: exactly one header + one footer each
- [ ] DOM: `<header>` → `<main>` → `<footer>` → `wp_footer()` → `</body></html>`
- [ ] No PHP errors in debug log

---

## Phase 2 – Icons & Fonts (Safe Font Awesome + Irancell) ✅ COMPLETE

- [x] Removed `jannah-fontawesome`/`tie-fontawesome` from FA dequeue list
- [x] Replaced with `tez_typo_disable_cdn_fa()` targeting only CDN handles
- [x] Removed duplicate FA loader in `typography.php` (covered by `core-setup.php`)
- [x] `icon-mapping.php`: removed `fa-solid fa-circle` fallback for unknown icons
- [x] Irancell @font-face: 6 weights, woff2+woff+ttf, `font-display: swap`
- [x] Google Fonts handles + TieLabs font hooks disabled

**Commits:** `164839e`, `134b4a5`

**Verification (Phase 2):** ⚠️ NEEDS STAGING TEST

- [ ] Jannah nav/UI icons render (not blank)
- [ ] Tez FA7 icons render in header/footer/Chaty/ToC
- [ ] DevTools: body font-family is Irancell
- [ ] Network: no fonts.googleapis.com or kit.fontawesome.com requests

---

## Phase 3 – CSS/JS Asset Loading & Design System ✅ COMPLETE

### 3.1 Asset loading in `functions.php`

- [x] `TEZ_CHILD_VERSION` bumped to `3.1.0` across all files
- [x] rtl.css: only when `is_rtl()` ✔
- [x] style.css: always (child theme base) ✔
- [x] css/main.css: always ✔
- [x] css/single-post.css: only on `is_singular('post')` ✔
- [x] css/page-templates.css: on `is_page() || is_404()` — **fixed: 404 page now loads this stylesheet**
- [x] css/post-elements.css: on `is_singular()` ✔
- [x] js/scripts.js: globally in footer ✔
- [x] js/single-post.js: only on `is_singular('post')` ✔
- [x] `tezData` localization enhanced: `isRTL`, `siteDir`, `themeUri`, `isSingular`, `isPost`, `isPage`, `is404`, `postId`, `version`
- [x] Added `tez_child_theme_setup()`: textdomain, post-thumbnails, custom-header support

**Commit:** `1b429f9` — feat(phase3): bump version, fix 404 CSS, enhance tezData

### 3.2 Design system sanity

- [x] All 4 CSS files confirmed existing: main.css (44KB), page-templates.css (30KB), single-post.css (15KB), post-elements.css
- [x] Both JS files confirmed existing: scripts.js (19KB), single-post.js (7KB)
- [x] `:root` CSS variables defined via `core-setup.php` inline critical CSS (light/dark/sepia variants)
- [x] `css/post-elements.css` expanded from 1.7KB → 6KB:
  - Added `[data-theme="dark"]` overrides for images, tables, blockquotes, code blocks
  - Added `[data-theme="sepia"]` overrides for images, tables, blockquotes, code blocks
  - Added `body.tez-high-contrast` overrides for tables, blockquotes, images
  - Added blockquote RTL styling (border-right)
  - Added `[dir="ltr"]` override for LTR sites
  - Added `<pre><code>` containment with dark/sepia styles
- [x] `js/scripts.js` updated to v3.1.0:
  - Reads `tezData.isRTL` from PHP context
  - `scrollToForm()` now RTL-aware (prefers `#order-form` in RTL, `#contact-form` in LTR)
  - `initFAQ()` closes aria-expanded on closed siblings
  - `initDropdowns()` fixes boolean to string coercion on aria-expanded
  - `window.scrollTo()` wrapped with `Math.max(0, ...)` to prevent negative scroll

**Commit:** `14ebbbf` — feat(phase3): dark/sepia/high-contrast in post-elements.css  
**Commit:** `c78424e` — feat(phase3): bump to 3.1.0, consume tezData context

**Verification (Phase 3):** ⚠️ NEEDS STAGING TEST

- [ ] DevTools Network: verify CSS loads only on correct page types
- [ ] DevTools Network: js/scripts.js loads everywhere, single-post.js only on posts
- [ ] DevTools Network: page-templates.css loads on pages AND 404
- [ ] Visual: table in post has horizontal scroll on mobile
- [ ] Visual: dark mode — tables readable, images slightly dimmed, blockquotes styled
- [ ] Visual: sepia mode — warm tone on tables/blockquotes
- [ ] Visual: high contrast — tables have yellow headers + black borders

---

## Phase 4 – Page Templates & Hero System

### 4.1 Template registration

- [ ] In `inc/page-templates.php`, confirm 7 templates registered
- [ ] Verify templates appear in Page Editor dropdown

### 4.2 Refine existing templates

- [ ] `templates/homepage.php`: hero, stats, services, process, CTA, blog posts
- [ ] `templates/services.php`: hero, quick inquiry, accordions, CTA
- [ ] `templates/inquiry.php`: hero + form + sidebar
- [ ] `templates/about.php`, `contact.php`, `faq.php`, `tag-hub.php`: hero + content

### 4.3 Auto hero for non-templated pages

- [ ] Add the_content filter (priority 1) in `inc/misc-tweaks.php`
- [ ] Skip pages using `templates/*`
- [ ] Build hero from title, excerpt, featured image

### 4.4 Duplicate title prevention

- [ ] Guard `tez_hide_page_title_on_templates()` for null ID + correct conditions

---

## Phase 5 – Blog Enhancements & Single Post Features

### 5.1 Module integrity

- [ ] Confirm `functions.php` requires all modules in correct order
- [ ] No fatal errors or duplicate function names

### 5.2 Single post UX

- [ ] css/single-post.css: reading progress, ToC, anchors, share, author box, related
- [ ] js/single-post.js: reading progress bar, ToC active, share, copy link, external links
- [ ] ToC, key takeaways, FAQ schema, polls, star rating, meta each appear once

---

## Phase 6 – Footer Preservation & Improvements

- [x] 4-column footer grid in `/footer.php`
- [x] Chaty floating widget + scroll-top button
- [ ] Assign menus: services → `tez_footer_1`, useful links → `tez_footer_2`
- [ ] Verify no duplicate Chaty/scroll-top instances on staging

---

## Phase 7 – SEO, Redirects, Sitemap, Feeds

- [ ] Review `inc/seo-url-cleanup.php` for canonical/query safety
- [ ] Review `inc/seo-redirects.php` for loops/404s
- [ ] Verify `inc/visual-sitemap.php` outputs HTML sitemap
- [ ] Confirm `404.php` + `inc/404-hub.php` render rich 404
- [ ] Check `inc/feed-controller.php` for 410s

---

## Phase 8 – QA: Performance, Accessibility, RTL

- [ ] Lighthouse on home, service, single post (desktop + mobile)
- [ ] No duplicate CSS/JS or font requests
- [ ] Skip link → `#tez-main-content` works
- [ ] a11y toolbar: aria-* + keyboard support
- [ ] RTL across header, hero, content, footer, Chaty, forms
- [ ] `WP_DEBUG_LOG`: no PHP errors
- [ ] Console: zero JS errors

---

## Phase 9 – Git, Docs, and Merge

- [x] Commit after each phase with clear messages
- [ ] Update DEVELOPMENT_REPORT.md with architectural changes
- [ ] Tag release `v3.1.0-final-child` after live deployment

---

## Full Commit Log

| Commit | Phase | Description |
|--------|-------|-------------|
| `8dd7187` | 1.1 | feat: add header.php override |
| `3baaeec` | 1.2 | feat: add footer.php override with Chaty |
| `439854d` | 1.3/1.4 | fix: remove hook-based output, fix body classes |
| `0d13f22` | 1.3 | fix: remove footer HTML from inc/footer.php |
| `164839e` | 2.1/2.2 | fix: safe FA dequeue, remove duplicate FA loader |
| `134b4a5` | 2.2 | fix: preserve unknown tie-icon classes |
| `1b429f9` | 3.1 | feat: version 3.1.0, fix 404 CSS, enhance tezData |
| `14ebbef` | 3.2 | feat: dark/sepia/contrast in post-elements.css |
| `c78424e` | 3.2 | feat: scripts.js 3.1.0, consume tezData RTL context |
