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

- [x] Git branch setup
- [x] TODO file added and committed
- [ ] Staging environment + backup + cache clear (manual verification needed)

---

## Phase 1 – Header/Footer Architecture ✅ COMPLETE

- [x] `/header.php` + `/footer.php` overrides created
- [x] Removed hook-based header/footer output from `core-setup.php`
- [x] Fixed body class filter to preserve sidebar classes for posts/archives

**Commits:** `8dd7187`, `3baaeec`, `439854d`, `0d13f22`

---

## Phase 2 – Icons & Fonts ✅ COMPLETE

- [x] Safe Font Awesome dequeue (only CDN handles, preserve parent theme handles)
- [x] Removed duplicate FA loader in `typography.php`
- [x] Fixed `icon-mapping.php` fallback (preserve unknown icons)
- [x] Irancell @font-face stack complete (6 weights, woff2+woff+ttf)

**Commits:** `164839e`, `134b4a5`

---

## Phase 3 – CSS/JS Asset Loading ✅ COMPLETE

- [x] `TEZ_CHILD_VERSION` bumped to `3.1.0`
- [x] Fixed 404 page CSS loading (`page-templates.css` now loads on `is_404()`)
- [x] Enhanced `tezData` localization (9 keys: isRTL, siteDir, isPost, is404, etc.)
- [x] `post-elements.css`: added dark/sepia/high-contrast overrides (1.7KB → 6KB)
- [x] `scripts.js` v3.1.0: RTL-aware `scrollToForm()`, tighter FAQ/dropdown ARIA

**Commits:** `1b429f9`, `14ebbef`, `c78424e`

---

## Phase 4 – Page Templates & Hero System ✅ COMPLETE

### 4.1 Template registration

- [x] 7 templates registered in `inc/page-templates.php`:
  1. `templates/homepage.php` (9.6KB) — hero, stats, services, process, CTA, blog grid
  2. `templates/services.php` (26KB) — hero, inquiry form, service accordions, CTA
  3. `templates/inquiry.php` (10.7KB) — hero, lead form, sidebar
  4. `templates/about.php` (381B) — minimal wrapper, supports Page Builder
  5. `templates/contact.php` (240B) — minimal wrapper, supports Page Builder
  6. `templates/faq.php` (243B) — minimal wrapper, supports Page Builder
  7. `templates/tag-hub.php` (251B) — minimal wrapper, supports Page Builder
- [x] All templates load from child theme via `tez_load_page_template()` filter
- [x] All templates confirmed existing in `/templates` directory

**Commit:** `237780c` — docs(phase4): bump version + improve comments in page-templates.php

### 4.2 Refine existing templates

- [x] `templates/homepage.php`: Production-ready
  - Hero section with site title, description, CTA buttons (inquiry + phone)
  - Stats grid (4 cards: 450+ researchers, 10+ years, 1000+ projects, 98% satisfaction)
  - Services overview grid (6 cards: research, proposal, article, stats, simulation, business plan)
  - Process timeline (6 steps: order → consult → start → work → deliver → support)
  - CTA section
  - Latest blog posts (4 posts with thumbnails)
  - All sections use `.scroll-animate` class for IntersectionObserver
- [x] `templates/services.php`: Production-ready (hero, inquiry form, accordions, CTA)
- [x] `templates/inquiry.php`: Production-ready (hero, form, sidebar)
- [x] Minimal templates (about, contact, faq, tag-hub): Rely on Page Builder or `the_content()` — working as designed

### 4.3 Auto-hero for non-templated pages

- [x] Added `tez_auto_hero_on_pages()` filter on `the_content` (priority 1)
- [x] Runs only on `is_page()`, main query, in the loop, non-admin
- [x] Skips pages using `templates/*` (those build their own hero)
- [x] Builds hero section from:
  - Page title (H1 with class `.tez-page-hero-title`)
  - Excerpt (if set, wrapped in `.tez-page-hero-excerpt`)
  - Featured image (as background if available, adds `.tez-has-bg` class)
- [x] Hero HTML structure:
  ```html
  <div class="tez-page-hero [tez-has-bg]" style="background-image: url(...)">
    <div class="tez-page-hero-overlay"></div>
    <div class="tez-page-hero-content">
      <h1 class="tez-page-hero-title">Title</h1>
      <p class="tez-page-hero-excerpt">Excerpt</p>
    </div>
  </div>
  ```
- [x] Prepended before `$content`, no Page Builder required

**Commit:** `f0014b0` — feat(phase4): add auto-hero for non-templated pages

### 4.4 Duplicate title prevention

- [x] Hardened `tez_hide_page_title_on_templates()` filter:
  - Added null guard: `if ($id === null || !is_page($id)) return $title;`
  - Only hides when `in_the_loop()` and NOT `is_admin()`
  - Checks if page template starts with `templates/`
  - Returns empty string to suppress default WordPress title output
- [x] Prevents H1 duplication on pages with custom templates

**Commit:** Included in `f0014b0`

**Verification (Phase 4):** ⚠️ NEEDS STAGING TEST

- [ ] Page Editor: all 7 templates appear in dropdown
- [ ] Homepage: hero + stats + services + process + CTA + blog posts render correctly
- [ ] Service page: hero + inquiry form + accordions + CTA render correctly
- [ ] Inquiry page: hero + form + sidebar render correctly
- [ ] About/Contact/FAQ/Tag Hub: minimal templates work with Page Builder content
- [ ] Standard page (no template assigned): auto-hero appears with title + excerpt + featured image background
- [ ] Standard page (no featured image): auto-hero appears without background
- [ ] No duplicate H1 titles on any page type
- [ ] Visual: `.scroll-animate` elements fade in on scroll

---

## Phase 5 – Blog Enhancements & Single Post Features

### 5.1 Module integrity

- [ ] Confirm `functions.php` requires all 17 modules in correct order
- [ ] No fatal errors or duplicate function names on staging

### 5.2 Single post UX

- [ ] css/single-post.css: reading progress, ToC, anchors, share, author box, related
- [ ] js/single-post.js: reading progress bar, ToC active, share, copy link, external links
- [ ] ToC, key takeaways, FAQ schema, polls, star rating, meta each appear once per post

---

## Phase 6 – Footer Preservation & Improvements

- [x] 4-column footer grid in `/footer.php`
- [x] Chaty floating widget + scroll-top button
- [ ] Assign menus: services → `tez_footer_1`, useful links → `tez_footer_2`
- [ ] Verify no duplicate Chaty/scroll-top instances

---

## Phase 7 – SEO, Redirects, Sitemap, Feeds

- [ ] Review `inc/seo-url-cleanup.php`
- [ ] Review `inc/seo-redirects.php`
- [ ] Verify `inc/visual-sitemap.php`
- [ ] Confirm `404.php` + `inc/404-hub.php`
- [ ] Check `inc/feed-controller.php`

---

## Phase 8 – QA: Performance, Accessibility, RTL

- [ ] Lighthouse audit (home, service, post)
- [ ] No duplicate CSS/JS/font requests
- [ ] Skip link works
- [ ] a11y toolbar: aria-* + keyboard
- [ ] RTL validated everywhere
- [ ] Zero PHP errors in `WP_DEBUG_LOG`
- [ ] Zero JS errors in console

---

## Phase 9 – Git, Docs, and Merge

- [x] Commit after each phase
- [ ] Update DEVELOPMENT_REPORT.md
- [ ] Tag release `v3.1.0-final-child`

---

## Full Commit Log

| Commit | Phase | Description |
|--------|-------|-------------|
| `8dd7187` | 1 | feat: header.php override |
| `3baaeec` | 1 | feat: footer.php override |
| `439854d` | 1 | fix: remove hooked output, body classes |
| `0d13f22` | 1 | fix: footer HTML from inc/footer.php |
| `164839e` | 2 | fix: safe FA dequeue, duplicate loader |
| `134b4a5` | 2 | fix: preserve unknown tie-icon classes |
| `1b429f9` | 3 | feat: v3.1.0, 404 CSS, tezData |
| `14ebbef` | 3 | feat: dark/sepia/contrast post-elements |
| `c78424e` | 3 | feat: scripts.js 3.1.0, RTL context |
| `237780c` | 4 | docs: page-templates.php v3.1.0 |
| `f0014b0` | 4 | feat: auto-hero, harden title filter |
