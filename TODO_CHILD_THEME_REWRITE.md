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

### 1.1 Implement child `header.php` override

- [x] Create `/header.php` in child theme root
- [x] Output DOCTYPE + html/head/body structure with wp_head(), wp_body_open()
- [x] Tez header markup: logo, nav, theme mode, a11y toolbar, mobile menu, search overlay
- [x] Walker fallback order: tez_primary → primary → hardcoded home link
- [x] Open `<main id="tez-main-content">` after header

**Commit:** `8dd7187` — feat(phase1): add header.php override to fix double menu bug

### 1.2 Implement child `footer.php` override

- [x] Create `/footer.php` with `</main>` close
- [x] 4-column footer grid (branding, services menu, useful links, contact info)
- [x] Footer bottom (copyright + links)
- [x] Chaty floating widget (5 channels: phone, SMS, WhatsApp, Telegram, email)
- [x] Scroll-to-top button
- [x] wp_footer() + close body/html

**Commit:** `3baaeec` — feat(phase1): add footer.php override with Chaty and scroll-top

### 1.3 Remove header/footer hooked output

- [x] Removed `tez_remove_theme_header()` + hook from `inc/core-setup.php`
- [x] Deleted `tez_output_header_html()` from `inc/core-setup.php`
- [x] Deleted `tez_output_close_main()` + hook from `inc/core-setup.php`
- [x] Stripped `inc/footer.php` to utility-only (no wp_footer hook)

**Commit:** `439854d` — fix(phase1): remove hook-based header/footer output, fix body class filter  
**Commit:** `0d13f22` — fix(phase1): remove footer HTML output from hook

### 1.4 Body classes & layout

- [x] `tez_filter_body_classes()`: only strip sidebar classes on `templates/*` pages
- [x] Sidebar classes preserved for posts/archives
- [x] Always add `tez-theme-active`

**Verification (Phase 1):** ⚠️ NEEDS STAGING TEST

- [ ] Homepage, service page, single post, archive: exactly one header + footer each
- [ ] DOM: `<header>` → `<main>` → `<footer>` → wp_footer → `</body></html>`
- [ ] No PHP errors in debug log

---

## Phase 2 – Icons & Fonts (Safe Font Awesome + Irancell) ✅ COMPLETE

### 2.1 Stop breaking Jannah icons

- [x] `inc/core-setup.php`: Commented out `tez_disable_external_fa()` entirely
- [x] `inc/typography.php`: Removed `tez_typo_disable_external_fa()` which listed `jannah-fontawesome`, `tie-fontawesome`, `flavor-fontawesome` — these are parent theme handles that must NOT be dequeued
- [x] Replaced with `tez_typo_disable_cdn_fa()` which ONLY targets truly external CDN handles (`fontawesome-cdn`, `fa-kit`, etc.)
- [x] Output buffer in `typography.php` still removes `kit.fontawesome.com` links from HTML as backup

**Commit:** `164839e` — fix(phase2): safe FA dequeue — preserve Jannah icons, remove duplicate FA loader

### 2.2 Keep local Font Awesome for Tez components

- [x] `tez_enqueue_fontawesome()` in `core-setup.php` loads local FA7 `all.css` (single stylesheet, no duplication)
- [x] Removed redundant `tez_header_enqueue_fa()` from `typography.php` which was loading all.css + brands.css + duotone.css (already covered by all.css)
- [x] Removed redundant `tez_header_preload_fa()` from `typography.php` (already in `core-setup.php`)
- [x] `tez_fa_fix_css()` in `core-setup.php` sets correct font-family stack for FA classes without touching Jannah's non-FA icon families
- [x] Fixed `inc/icon-mapping.php`: removed fallback that replaced unknown `tie-icon-*` with `fa-solid fa-circle`
- [x] Unknown `tie-icon-*` classes now left unchanged, preserving Jannah's own icon rendering

**Commit:** `134b4a5` — fix(phase2): preserve unknown tie-icon classes, prevent icon blanking

### 2.3 Irancell fonts

- [x] `TEZ_FONT_URL` constant defined in `core-setup.php`: `/wp-content/uploads/fonts/Irancell/`
- [x] `inc/typography.php` has complete @font-face stack for all 6 weights (200–800)
- [x] Font files: woff2 + woff + ttf format sources (no .eot legacy)
- [x] Body font-family set globally to `'Irancell', 'Tahoma', 'Arial', system-ui, sans-serif`
- [x] Irancell Regular + Bold preloaded via `tez_typo_preload_irancell()`
- [x] All Google Fonts handles and TieLabs font hooks disabled
- [ ] Manual: In Jannah → Styling, confirm Google Fonts is set to None/Disabled

**Verification (Phase 2):** ⚠️ NEEDS STAGING TEST

- [ ] Jannah nav icons + UI icons render correctly (not blank squares)
- [ ] Tez header/footer/Chaty/ToC icons render correctly (FA7)
- [ ] Body text uses Irancell (confirm in DevTools → Computed → font-family)
- [ ] Network tab: no requests to fonts.googleapis.com or kit.fontawesome.com
- [ ] No duplicate FA stylesheet requests

---

## Phase 3 – CSS/JS Asset Loading & Design System

### 3.1 Asset loading in `functions.php`

- [ ] Verify `tez_enqueue_child_assets()` conditional loading:
  - [ ] rtl.css only when is_rtl()
  - [ ] style.css (header only)
  - [ ] css/main.css always
  - [ ] css/single-post.css on is_singular('post')
  - [ ] css/page-templates.css on is_page()
  - [ ] css/post-elements.css on is_singular()
  - [ ] js/scripts.js globally
  - [ ] js/single-post.js on is_singular('post')

### 3.2 Design system sanity

- [ ] Confirm css files exist: main.css, page-templates.css, single-post.css, post-elements.css
- [ ] Ensure :root defines --tez-primary, dark/sepia variants
- [ ] Remove unused selectors from old snippets

**Verification (Phase 3):**

- [ ] DevTools Network: CSS/JS only load on intended pages
- [ ] Visual check: header/hero/footer/single post in light/dark/sepia

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

### 6.1 Footer content & menus

- [x] Footer uses same structure from previous inc/footer.php
- [ ] Assign: services → tez_footer_1, useful links → tez_footer_2
- [x] Fallback lists for unassigned menus

### 6.2 Floating widget & scroll-top

- [x] Chaty 5-channel widget with tooltips + ARIA in footer.php
- [x] Scroll-to-top button
- [ ] Verify no duplicate instances on staging

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
- [ ] Skip link → #tez-main-content works
- [ ] a11y toolbar has proper aria-* + keyboard support
- [ ] RTL validated across header, hero, content, footer, Chaty, forms
- [ ] WP_DEBUG_LOG: no PHP errors
- [ ] Console: zero JS errors

---

## Phase 9 – Git, Docs, and Merge

- [x] Commit after each phase with clear messages
- [ ] Update DEVELOPMENT_REPORT.md with architectural changes
- [ ] Tag release `v3.1.0-final-child` after live deployment

---

## Commit Log Summary

| Commit | Phase | Description |
|--------|-------|-------------|
| `8dd7187` | 1.1 | feat: add header.php override |
| `3baaeec` | 1.2 | feat: add footer.php override with Chaty |
| `439854d` | 1.3/1.4 | fix: remove hook-based header/footer, fix body classes |
| `0d13f22` | 1.3 | fix: remove footer HTML from inc/footer.php |
| `e7f87c9` | docs | TODO Phase 1 marked complete |
| `164839e` | 2.1/2.2/2.3 | fix: safe FA dequeue, remove duplicate FA loader |
| `134b4a5` | 2.2 | fix: preserve unknown tie-icon classes |
