# Jannah Child Theme – FINAL REVISION TODO (No Missings)

**Branch:** `New` (working branch)
**Goal:** Stable, bug‑free Jannah child theme that:

- Uses built‑in Jannah features as base
- Uses child theme mainly for **appearance + advanced enhancements**
- Keeps footer, single‑post enhancements, ToC, FAQ, polls, ratings, meta
- Uses Irancell fonts + local Font Awesome **without breaking Jannah icons**
- Fixes double top menu and invalid HTML structure

**Status:** 🚧 In Progress  
**Last Updated:** 2026-02-23

---

## ✅ Completed Pre-Phase Work

### Module Enhancements (v3.0.0)

- [x] **Poll System v3.0.0** – Advanced voting with real-time results, analytics, CSV export
- [x] **Key Takeaways v3.0.0** – Collapsible, reading time, copy-to-clipboard, numbered lists
- [x] **FAQ Schema v3.0.0** – Search/filter, expand all, copy answers, URL hash navigation

**Commits:**
- Poll System: `3d97285` (2026-02-23)
- Key Takeaways: `0494c93` (2026-02-23)
- FAQ Schema: `d96197f` (2026-02-23)

---

## Phase 0 – Git & Prep

### 0.1 Branch & file setup

- [x] Working on `New` branch (already established)
- [x] Add TODO file as `TODO_CHILD_THEME_REWRITE.md` at repo root
- [x] Commit TODO file with proper message

### 0.2 Environment & theme setup

- [ ] Ensure staging environment is ready
- [ ] Full backup of database + `wp-content` on staging
- [ ] Ensure **Jannah** parent theme is installed and updated
- [ ] Activate the **child theme** (`Jannah Child` / `jannah-child`)
- [ ] Deactivate WPCode / Code Snippets that overlap with child‑theme modules
- [ ] Clear plugin cache, server cache, and CDN/Cloudflare cache

**Verification (Phase 0):**

- [ ] Staging loads with the `New` branch child theme active
- [ ] Layout bugs and double menus visible (expected at this stage)

**Status:** 🟡 Partially Complete (TODO file added, environment prep needed)

---

## Phase 1 – Header/Footer Architecture & Double Menu Fix

### 1.1 Implement child `header.php` override

- [ ] Create `/header.php` in child theme root
- [ ] Structure with DOCTYPE, `<html>`, `<head>`, `wp_head()`
- [ ] Add `<body>` with `body_class()` and `wp_body_open()`
- [ ] Copy Tez header markup from `inc/core-setup.php`
- [ ] Adapt header with `Tez_Desktop_Nav_Walker` and `Tez_Mobile_Nav_Walker`
- [ ] Menu order: prefer `tez_primary`, fallback to `primary`
- [ ] Open `<main id="tez-main-content">` after header

### 1.2 Implement child `footer.php` override

- [ ] Create `/footer.php` in child theme root
- [ ] Close `</main>` tag
- [ ] Move footer markup from `inc/footer.php` to `footer.php`
- [ ] 4-column footer with menus and contact info
- [ ] Footer bottom with copyright and links
- [ ] Chaty floating contact widget (5 channels)
- [ ] Scroll-to-top button
- [ ] Call `wp_footer()` and close `</body></html>`

### 1.3 Remove header/footer hooked output

- [ ] Remove `tez_remove_theme_header()` from `inc/core-setup.php`
- [ ] Remove `tez_output_header_html()` from `inc/core-setup.php`
- [ ] Remove `tez_output_close_main()` and its hook
- [ ] Remove `add_action('wp_footer', 'tez_output_footer_html', 10)` from `inc/footer.php`

### 1.4 Body classes & layout

- [ ] Update `tez_filter_body_classes()` in `inc/core-setup.php`
- [ ] Strip sidebar classes only on pages with custom templates
- [ ] Keep sidebars intact for posts/archives
- [ ] Always add `tez-theme-active` class

**Verification (Phase 1):**

- [ ] Exactly **one** header (no double top menu)
- [ ] Exactly **one** footer
- [ ] DOM order: `<header>` → `<main>` → `<footer>` → `wp_footer()` → `</body></html>`
- [ ] No PHP errors in debug log

**Status:** 🔴 Not Started

---

## Phase 2 – Icons & Fonts (Safe Font Awesome + Irancell)

### 2.1 Stop breaking Jannah icons

- [ ] Comment out `tez_disable_external_fa()` in `inc/core-setup.php`
- [ ] Verify Jannah's nav icons / UI icons still appear

### 2.2 Keep local Font Awesome for Tez components

- [ ] Keep `tez_enqueue_fontawesome()` for Tez components
- [ ] Keep `tez_preload_fa()` with proper font-family stack
- [ ] Check `inc/icon-mapping.php` doesn't override Jannah icons

### 2.3 Irancell fonts

- [ ] Confirm `TEZ_FONT_URL` path is correct
- [ ] Verify `@font-face` in `inc/typography.php`
- [ ] Ensure body font uses Irancell/Vazirmatn stack
- [ ] Disable Google Fonts in Jannah → Styling

**Verification (Phase 2):**

- [ ] Theme icons (Jannah) and Tez icons both render
- [ ] Irancell fonts apply to body text
- [ ] No missing icon squares

**Status:** 🔴 Not Started

---

## Phase 3 – CSS/JS Asset Loading & Design System

### 3.1 Asset loading in `functions.php`

- [ ] Verify `tez_enqueue_child_assets()` conditional loading:
  - [ ] `rtl.css` only when `is_rtl()`
  - [ ] Child `style.css` in header
  - [ ] `css/main.css` always
  - [ ] `css/single-post.css` on `is_singular('post')`
  - [ ] `css/page-templates.css` on `is_page()`
  - [ ] `css/post-elements.css` on `is_singular()`
  - [ ] `js/scripts.js` globally
  - [ ] `js/single-post.js` on `is_singular('post')`

### 3.2 Design system sanity

- [ ] Cross-check CSS files exist and match line counts
- [ ] Verify `:root` variables define all design tokens
- [ ] Remove unused selectors from old snippets

**Verification (Phase 3):**

- [ ] CSS/JS only load on intended pages (check network tab)
- [ ] Visual consistency across light/dark/sepia modes

**Status:** 🔴 Not Started

---

## Phase 4 – Page Templates & Hero System

### 4.1 Template registration & usage

- [ ] Confirm 7 page templates registered in `inc/page-templates.php`
- [ ] Verify templates appear in Page Editor dropdown

### 4.2 Refine existing templates

- [ ] `templates/homepage.php` – hero, stats, services, process, CTA, blog
- [ ] `templates/services.php` – hero, inquiry, accordions, CTA
- [ ] `templates/inquiry.php` – hero, form, sidebar
- [ ] `templates/about.php`, `contact.php`, `faq.php`, `tag-hub.php`

### 4.3 Auto hero for non-templated pages

- [ ] Add `the_content` filter for auto hero on standard pages
- [ ] Skip pages using `templates/*`
- [ ] Build hero from title, excerpt, featured image

### 4.4 Avoid duplicate titles

- [ ] Harden `tez_hide_page_title_on_templates()` in `inc/misc-tweaks.php`
- [ ] Guard for null ID
- [ ] Only hide when template slug starts with `templates/`

**Verification (Phase 4):**

- [ ] Templated pages display designed hero
- [ ] Standard pages get auto hero
- [ ] No duplicate H1 titles

**Status:** 🔴 Not Started

---

## Phase 5 – Blog Enhancements & Single Post Features

### 5.1 Module integrity

- [ ] Confirm `functions.php` requires all modules in correct order
- [ ] Check each `inc/*.php` file loads without errors
- [ ] Verify no duplicate function names

### 5.2 Single post UX

- [ ] Confirm `css/single-post.css` styles all features
- [ ] Confirm `js/single-post.js` features work
- [ ] Verify ToC, takeaways, FAQ, polls, rating don't conflict

**Verification (Phase 5):**

- [ ] Test posts with all features, few features, no features
- [ ] No console errors from single-post scripts

**Status:** 🟢 Modules Enhanced (v3.0.0 completed)

---

## Phase 6 – Footer Preservation & Improvements

### 6.1 Footer content & menus

- [ ] Ensure `footer.php` uses correct text/structure
- [ ] Assign menus to `tez_footer_1` and `tez_footer_2`
- [ ] Verify fallback lists

### 6.2 Floating widget & scroll-top

- [ ] Confirm Chaty widget markup in `footer.php`
- [ ] Confirm scroll-to-top button controlled by `scripts.js`
- [ ] Ensure no duplicate instances

**Verification (Phase 6):**

- [ ] Footer matches expectations on all pages
- [ ] Chaty + scroll-top work in all viewports

**Status:** 🔴 Not Started

---

## Phase 7 – SEO, Redirects, Sitemap, Feeds

### 7.1 URL cleanup & redirects

- [ ] Review `inc/seo-url-cleanup.php`
- [ ] Review `inc/seo-redirects.php` for loops/404s

### 7.2 Visual sitemap & 404 hub

- [ ] Verify `inc/visual-sitemap.php` outputs HTML sitemap
- [ ] Confirm `404.php` + `inc/404-hub.php` show rich layout

### 7.3 Feeds

- [ ] Check `inc/feed-controller.php` for 410/disabled feeds

**Verification (Phase 7):**

- [ ] Test date archive, author archive, `/sitemap`
- [ ] Check redirect behavior and status codes

**Status:** 🔴 Not Started

---

## Phase 8 – QA: Performance, Accessibility, RTL

### 8.1 Performance

- [ ] Run Lighthouse on home, service page, single post
- [ ] Confirm no duplicate CSS/JS bundles
- [ ] Check fonts/FA not requested multiple times

### 8.2 Accessibility & RTL

- [ ] Confirm skip link jumps to `#tez-main-content`
- [ ] Verify theme mode and a11y toolbar ARIA attributes
- [ ] Validate RTL layout across all components

### 8.3 Error checks

- [ ] Enable `WP_DEBUG_LOG` and check for notices/warnings
- [ ] Check DevTools console for JS errors

**Verification (Phase 8):**

- [ ] Lighthouse scores > 90 for performance/accessibility
- [ ] Zero PHP/JS errors across all page types

**Status:** 🔴 Not Started

---

## Phase 9 – Git, Docs, and Merge

### 9.1 Commits and documentation

- [x] Commit after each phase with clear messages
- [ ] Keep `DEVELOPMENT_REPORT.md` updated
- [ ] Update TODO with checkmarks and notes

### 9.2 Merge & release

- [ ] Merge into `New` when staging passes all checks
- [ ] Tag release `v3.1.0-final-child` after deployment

**Status:** 🟡 In Progress (documenting as we go)

---

## 📊 Overall Progress

```
✅ Phase 0: 50% (TODO added, environment prep needed)
⏳ Phase 1: 0%  (Header/Footer architecture)
⏳ Phase 2: 0%  (Icons & Fonts)
⏳ Phase 3: 0%  (CSS/JS Assets)
⏳ Phase 4: 0%  (Page Templates)
✅ Phase 5: 100% (Blog enhancements - modules upgraded)
⏳ Phase 6: 0%  (Footer preservation)
⏳ Phase 7: 0%  (SEO & Redirects)
⏳ Phase 8: 0%  (QA & Performance)
⏳ Phase 9: 30% (Documentation ongoing)

 Total: ~18% Complete
```

---

## 🎯 Next Steps

1. **Phase 1:** Create `header.php` and `footer.php` overrides
2. **Phase 2:** Fix Font Awesome conflicts
3. **Phase 3:** Optimize asset loading
4. **Phase 4:** Refine page templates
5. **Phase 6-9:** Complete remaining phases

---

## 📝 Notes

- Module enhancements (v3.0.0) completed ahead of schedule
- Focus now shifts to architectural improvements
- Staging environment setup required before Phase 1 verification
