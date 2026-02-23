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

**Verification (Phase 0):**

- [ ] Staging loads with child theme
- [ ] Layout bugs expected (will be fixed in Phase 1)

---

## Phase 1 – Header/Footer Architecture & Double Menu Fix ✅ COMPLETE

### 1.1 Implement child `header.php` override

- [x] Create `/header.php` in child theme root
- [x] Output DOCTYPE + html/head/body structure
- [x] Call wp_head() and wp_body_open()
- [x] Copy Tez header markup (logo, nav, theme mode, a11y, mobile menu, search)
- [x] Use Tez_Desktop_Nav_Walker and Tez_Mobile_Nav_Walker
- [x] Menu fallback order: tez_primary → primary → hardcoded home link
- [x] Open `<main id="tez-main-content">` after header

**Commit:** `8dd7187` - feat(phase1): add header.php override to fix double menu bug

### 1.2 Implement child `footer.php` override

- [x] Create `/footer.php` in child theme root
- [x] Close `</main>` tag
- [x] Render 4-column footer (logo/description/social, services menu, useful links, contact info)
- [x] Render footer bottom (copyright + links)
- [x] Include Chaty floating widget (5 channels)
- [x] Include scroll-to-top button
- [x] Call wp_footer() and close body/html

**Commit:** `3baaeec` - feat(phase1): add footer.php override with Chaty and scroll-top

### 1.3 Remove header/footer hooked output

- [x] In `inc/core-setup.php`: Remove `tez_remove_theme_header()` and its hook
- [x] In `inc/core-setup.php`: Delete `tez_output_header_html()` function entirely
- [x] In `inc/core-setup.php`: Delete `tez_output_close_main()` and its hook
- [x] In `inc/footer.php`: Remove `add_action('wp_footer', 'tez_output_footer_html')`
- [x] In `inc/footer.php`: Keep only widget registration utilities

**Commit:** `439854d` - fix(phase1): remove hook-based header/footer output, fix body class filter
**Commit:** `0d13f22` - fix(phase1): remove footer HTML output from hook

### 1.4 Body classes & layout

- [x] Update `tez_filter_body_classes()` to only strip sidebar classes on pages with `templates/*` templates
- [x] Keep sidebar classes intact for posts/archives
- [x] Always add `tez-theme-active`

**Commit:** Included in `439854d`

**Verification (Phase 1):** ⚠️ NEEDS STAGING TEST

- [ ] Deploy to staging and test:
  - [ ] Homepage: exactly one header, one footer
  - [ ] Service page: exactly one header, one footer
  - [ ] Single post: exactly one header, one footer
  - [ ] Archive/blog: exactly one header, one footer
  - [ ] DOM structure: `<header>` → `<main>` → `<footer>` → wp_footer → `</body></html>`
- [ ] No PHP errors in debug log
- [ ] Screenshot all key pages

---

## Phase 2 – Icons & Fonts (Safe Font Awesome + Irancell)

### 2.1 Stop breaking Jannah icons

- [x] In `inc/core-setup.php`: Commented out `tez_disable_external_fa()` and its hooks
- [ ] Flush caches and reload
- [ ] Verify Jannah nav icons / UI icons still appear

**Commit:** Included in `439854d`

### 2.2 Keep local Font Awesome for Tez components

- [x] Keep `tez_enqueue_fontawesome()` loading local FA from TEZ_FA_URL
- [x] Keep `tez_preload_fa()` for webfonts
- [x] Keep `tez_fa_fix_css()` but ensure it doesn't override theme icon families globally
- [ ] Check for aggressive icon mapping in `inc/icon-mapping.php` if exists

### 2.3 Irancell fonts

- [ ] Confirm TEZ_FONT_URL points to correct path
- [ ] In `inc/typography.php`, ensure @font-face loads from TEZ_FONT_URL
- [ ] Set body font to Irancell/Vazirmatn stack
- [ ] In Jannah → Styling, disable Google Fonts

**Verification (Phase 2):**

- [ ] Theme icons (Jannah) render correctly
- [ ] Tez icons (FA) render correctly in header/footer/Chaty/ToC
- [ ] Irancell fonts apply to body text
- [ ] No missing icon squares

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

- [ ] Cross-check css/main.css, css/page-templates.css, css/single-post.css, css/post-elements.css exist
- [ ] Ensure :root variables define --tez-primary, dark/sepia variants
- [ ] Remove unused selectors from old snippets

**Verification (Phase 3):**

- [ ] Browser DevTools: CSS/JS only load on intended pages
- [ ] Visual check: header/hero/footer/single post look correct in light/dark/sepia

---

## Phase 4 – Page Templates & Hero System

### 4.1 Template registration & usage

- [ ] In `inc/page-templates.php`, confirm 7 templates registered
- [ ] Verify templates appear in Page Editor dropdown

### 4.2 Refine existing templates

- [ ] `templates/homepage.php`: hero, stats, services, process, CTA, blog posts
- [ ] `templates/services.php`: hero, quick inquiry, accordions, CTA
- [ ] `templates/inquiry.php`: hero + form + sidebar
- [ ] `templates/about.php`, `contact.php`, `faq.php`, `tag-hub.php`: hero + content

### 4.3 Auto hero for non-templated pages

- [ ] In `inc/misc-tweaks.php` or new `inc/page-hero.php`:
  - [ ] Add the_content filter (priority 1)
  - [ ] Run only on is_page(), !is_admin(), main query
  - [ ] Skip pages using templates/*
  - [ ] Build hero from title, excerpt, featured image
  - [ ] Output hero before $content

### 4.4 Avoid duplicate titles

- [ ] Harden `tez_hide_page_title_on_templates()`:
  - [ ] Guard for $id === null
  - [ ] Only hide when is_page(), in_the_loop(), template starts with templates/

**Verification (Phase 4):**

- [ ] Pages with Tez templates display designed hero
- [ ] Standard pages get auto hero without Page Builder
- [ ] No duplicated H1 titles

---

## Phase 5 – Blog Enhancements & Single Post Features

### 5.1 Module integrity

- [ ] Confirm `functions.php` requires all modules in correct order
- [ ] Check each inc/*.php loads without fatal errors

### 5.2 Single post UX

- [ ] Confirm css/single-post.css styles all features
- [ ] Confirm js/single-post.js: reading progress, ToC, share, copy link, external links
- [ ] Confirm ToC, key takeaways, FAQ schema, polls, star rating, meta appear once per post

**Verification (Phase 5):**

- [ ] Test posts with all features, few features, no features
- [ ] Layout stable, no console errors

---

## Phase 6 – Footer Preservation & Improvements

### 6.1 Footer content & menus

- [x] Footer uses same structure as previous inc/footer.php
- [ ] In Appearance → Menus, assign services to tez_footer_1, links to tez_footer_2
- [x] Fallback lists show reasonable links when menus not assigned

### 6.2 Floating widget & scroll-top

- [x] Chaty widget in footer.php with 5 channels, tooltips, ARIA
- [x] Scroll-to-top button controlled by scripts.js
- [ ] Verify no duplicate instances

**Verification (Phase 6):**

- [ ] Footer visually matches expectations on multiple pages
- [ ] Chaty + scroll-top work in all viewports, dark/sepia included

---

## Phase 7 – SEO, Redirects, Sitemap, Feeds

### 7.1 URL cleanup & redirects

- [ ] Review inc/seo-url-cleanup.php
- [ ] Review inc/seo-redirects.php for redirect loops/404s

### 7.2 Visual sitemap & 404 hub

- [ ] Verify inc/visual-sitemap.php outputs HTML sitemap
- [ ] Confirm 404.php + inc/404-hub.php show rich 404

### 7.3 Feeds

- [ ] Check inc/feed-controller.php for 410s, align with SEO strategy

**Verification (Phase 7):**

- [ ] Test date archive, author archive, /sitemap URLs
- [ ] Check logs for redirect behavior

---

## Phase 8 – QA: Performance, Accessibility, RTL

### 8.1 Performance

- [ ] Run Lighthouse on home, service page, single post (desktop + mobile)
- [ ] Confirm CSS/JS bundles not duplicated
- [ ] Check fonts and FA assets not requested multiple times

### 8.2 Accessibility & RTL

- [ ] Skip link jumps to #tez-main-content
- [ ] Theme mode and a11y toolbar have proper aria-*
- [ ] Validate RTL across header, hero, content, footer, Chaty, forms

### 8.3 Error checks

- [ ] Enable WP_DEBUG_LOG, browse all page types
- [ ] DevTools console: zero JS errors on key pages

---

## Phase 9 – Git, Docs, and Merge

### 9.1 Commits and documentation

- [x] Commit after each phase with clear messages
- [ ] Update DEVELOPMENT_REPORT.md with architectural changes
- [x] Update this TODO with checkmarks

### 9.2 Merge & release

- [ ] When staging passes, optionally merge to main or keep on New
- [ ] Tag release v3.1.0-final-child after deployment

---

## Summary of Phase 1 Changes

**Files Created:**
- `/header.php` - Complete header override with Tez design
- `/footer.php` - Complete footer override with 4 columns + Chaty + scroll-top

**Files Modified:**
- `/inc/core-setup.php` - Removed 3 buggy functions, commented out FA dequeue, fixed body class filter
- `/inc/footer.php` - Stripped to utility-only (widget registration)

**Bug Fixed:**
- Double top menu eliminated (parent header.php no longer renders)
- Invalid HTML structure fixed (main opens/closes correctly)
- Footer no longer duplicates or appears in wrong DOM location

**Next Steps:**
- Deploy to staging
- Run Phase 1 verification checklist
- Move to Phase 2 (icons & fonts safety)
