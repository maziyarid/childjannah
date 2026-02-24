***

# Jannah Child Theme – FINAL REVISION TODO (No Missings)

**Branch:** `fix/final-child-theme-rewrite`
**Goal:** Stable, bug‑free Jannah child theme that:

- Uses built‑in Jannah features as base
- Uses child theme mainly for **appearance + advanced enhancements**
- Keeps footer, single‑post enhancements, ToC, FAQ, polls, ratings, meta
- Uses Irancell fonts + local Font Awesome **without breaking Jannah icons**
- Fixes double top menu and invalid HTML structure

***

## Phase 0 – Git \& Prep

### 0.1 Branch \& file setup

- [ ] Create branch from `New`:
    - `git checkout New`
    - `git pull`
    - `git checkout -b fix/final-child-theme-rewrite`
- [ ] Add this file as `TODO_CHILD_THEME_REWRITE.md` at repo root and commit:
    - `git add TODO_CHILD_THEME_REWRITE.md`
    - `git commit -m "docs: add final child theme TODO"`


### 0.2 Environment \& theme setup

- [ ] Ensure a separate **staging** environment (subdomain or local) that runs the same code as live.
- [ ] Full backup of database + `wp-content` on staging.
- [ ] Ensure **Jannah** parent theme is installed and updated.
- [ ] Activate the **child theme** (`Jannah Child` / `jannah-child`).
- [ ] Deactivate WPCode / Code Snippets that overlap with child‑theme modules (ToC, redirects, FAQ, polls, ratings, etc.).
- [ ] Clear plugin cache (e.g. WP Rocket), server cache, and CDN/Cloudflare cache.

**Verification (Phase 0):**

- [ ] Staging loads with the `New` branch child theme active.
- [ ] Some layout bugs and double menus are still visible (expected at this stage).

***

## Phase 1 – Header/Footer Architecture \& Double Menu Fix

### 1.1 Implement child `header.php` override

- [ ] Create `/header.php` in child theme root.
- [ ] Structure:
    - DOCTYPE + `<html <?php language_attributes(); ?>>`
    - `<head>` with `wp_head()`.
    - `<body <?php body_class(); ?>>` then `wp_body_open()`.
- [ ] Copy the Tez header markup (logo, nav, theme mode switcher, a11y toolbar, mobile menu, search overlay) from `tez_output_header_html()` in `inc/core-setup.php` and adapt it into `header.php`.
- [ ] Keep:
    - Desktop nav using `Tez_Desktop_Nav_Walker` when available.
    - Mobile nav using `Tez_Mobile_Nav_Walker`.
    - Menu order: prefer `tez_primary`, fall back to `primary` if needed.
- [ ] Leave header builder / header options in Jannah mostly untouched; child header should *be* the effective header via this template override.[^1]
- [ ] Open `<main id="tez-main-content" class="tez-main-content">` after the header and skip‑link.


### 1.2 Implement child `footer.php` override

- [ ] Create `/footer.php` in child theme root.
- [ ] Close `</main>` (which was opened in `header.php`).
- [ ] Move the footer markup you liked from `inc/footer.php` into `footer.php`:
    - 4‑column footer:
        - Col 1: logo + description + social icons.
        - Col 2: “خدمات ما” menu (`tez_footer_1`) with fallback list if empty.
        - Col 3: “لینک‌های مفید” menu (`tez_footer_2`) with fallback links.
        - Col 4: contact info (phone, email, address, hours).
    - Footer bottom: copyright, footer links (Terms, Privacy, Sitemap).
- [ ] After footer, render:
    - Chaty floating contact widget with 5 channels (phone, SMS, WhatsApp, Telegram, email).
    - Scroll‑to‑top button.

```
- [ ] Call `wp_footer()` and close `</body></html>`.  
```


### 1.3 Remove header/footer hooked output

- [ ] In `inc/core-setup.php`:
    - [ ] Remove the entire `tez_remove_theme_header()` function and its `add_action('after_setup_theme', 'tez_remove_theme_header', 999);` line.
    - [ ] Remove the entire `tez_output_header_html()` function (now handled by `header.php`).
- [ ] In `inc/core-setup.php`:
    - [ ] Remove `tez_output_close_main()` and its hook `add_action('wp_footer', 'tez_output_close_main', 5);` (closing `</main>` is now in `footer.php`).
- [ ] In `inc/footer.php`:
    - [ ] Remove `add_action('wp_footer', 'tez_output_footer_html', 10);`.
    - [ ] Optionally keep a minimal file with just widget registration or future utilities; it should not output markup directly.


### 1.4 Body classes \& layout

- [ ] In `inc/core-setup.php`, update `tez_filter_body_classes()` to:
    - Only strip sidebar / boxed layout classes on **pages with custom templates** (from `templates/*`).
    - Keep sidebars intact for posts/archives.
    - Always add `tez-theme-active` for targeting.

**Verification (Phase 1):**

- [ ] On staging, inspect several pages (home, services, about, single post, archives):
    - Exactly **one** header (no double top menu).
    - Exactly **one** footer.

```
- DOM order: `<header>` → `<main>` → `<footer>` → `wp_footer()` → `</body></html>`.  
```

- [ ] No PHP errors in debug log after refresh.

***

## Phase 2 – Icons \& Fonts (Safe Font Awesome + Irancell)

### 2.1 Stop breaking Jannah icons

- [ ] In `inc/core-setup.php`:
    - [ ] Comment out or delete `tez_disable_external_fa()` and its `add_action('wp_enqueue_scripts', 'tez_disable_external_fa', ...)`.
- [ ] Flush caches and reload: check that Jannah’s own nav icons / UI icons still appear.


### 2.2 Keep local Font Awesome for Tez components

- [ ] Keep `tez_enqueue_fontawesome()` so it enqueues local FA from `TEZ_FA_URL` for Tez header/footer/Chaty/ToC icons.
- [ ] Keep `tez_preload_fa()` but confirm the `font-family` stack in `tez_fa_fix_css()` **adds** FA families, not removes Jannah’s icon family:
    - E.g. ensure selectors like `.fa, .fas, ...` don’t override theme‑specific icon families where not needed.
- [ ] Check for any “icon mapping” that replaces Jannah/Tie “tie-icon” classes globally; if `inc/icon-mapping.php` is too aggressive, adjust it to only act where you explicitly opt in.


### 2.3 Irancell fonts

- [ ] Confirm `TEZ_FONT_URL` is correct and Irancell font files exist at that path.
- [ ] In `inc/typography.php`, ensure:
    - `@font-face` definitions load fonts from `TEZ_FONT_URL`.
    - The body font family uses Irancell/Vazirmatn stack plus system fonts.
- [ ] In Jannah → Styling, disable Google Fonts if not already done.[^2]

**Verification (Phase 2):**

- [ ] Theme icons (Jannah default) and Tez icons both render.
- [ ] Irancell fonts apply to body text.
- [ ] No missing icon squares anywhere.

***

## Phase 3 – CSS/JS Asset Loading \& Design System

### 3.1 Asset loading in `functions.php`

- [ ] Verify `tez_enqueue_child_assets()` does:
    - Enqueue `rtl.css` from parent only when `is_rtl()`.
    - Enqueue child `style.css` (header only).
    - Enqueue `css/main.css` always.
    - Conditionally enqueue `css/single-post.css` on `is_singular('post')`.
    - Conditionally enqueue `css/page-templates.css` on `is_page()`.
    - Conditionally enqueue `css/post-elements.css` on `is_singular()`.
    - Enqueue `js/scripts.js` globally.
    - Conditionally enqueue `js/single-post.js` on `is_singular('post')`.


### 3.2 Design system sanity

- [ ] Open `DEVELOPMENT_REPORT.md` and cross‑check `css/main.css`, `css/page-templates.css`, `css/single-post.css`, `css/post-elements.css` exist and roughly match the described line counts.
- [ ] Ensure `:root` variables define: `--tez-primary`, `--tez-primary-dark`, `--tez-bg`, `--tez-text`, etc., and that dark/sepia variants are defined.
- [ ] Remove any old selectors left from earlier snippet copies that are no longer used by templates (keep CSS slim).

**Verification (Phase 3):**

- [ ] Use browser dev tools to check network: CSS/JS only load on intended pages.
- [ ] Visual regression check: header, hero, footer, single post look correct across light/dark/sepia.

***

## Phase 4 – Page Templates \& Hero System

### 4.1 Template registration \& usage

- [ ] In `inc/page-templates.php`, confirm all 7 page templates are registered: about, contact, FAQ, service, homepage, inquiry, tag hub.
- [ ] On staging, verify each template appears in the Page Editor (Template dropdown).


### 4.2 Refine existing templates

- [ ] `templates/homepage.php`: ensure hero, stats, services overview, process, CTA, and blog posts sections render correctly and use current CSS classes.
- [ ] `templates/services.php`: confirm hero, quick inquiry area, service accordions, and CTA layout follow design system.
- [ ] `templates/inquiry.php`: confirm hero + full form + sidebar content render correctly.
- [ ] `templates/about.php`, `contact.php`, `faq.php`, `tag-hub.php`: ensure they at least output the content area in a Tez hero + content wrapper; extend later if needed.


### 4.3 Auto hero for non‑templated pages

- [ ] In `inc/misc-tweaks.php` (or a new `inc/page-hero.php`):
    - [ ] Add a `the_content` filter with priority 1 that:
        - Runs only on `is_page()`, `!is_admin()`, main query.
        - Skips pages using templates under `templates/`.
        - Builds hero section from: title, excerpt (subtitle), and featured image.
        - Outputs hero markup before original `$content` using the same Tez hero classes.


### 4.4 Avoid duplicate titles

- [ ] Harden `tez_hide_page_title_on_templates()` (in `inc/misc-tweaks.php`):
    - Guard for `$id === null`.
    - Only hide when `is_page()`, `in_the_loop()`, and the template slug starts with `templates/`.

**Verification (Phase 4):**

- [ ] Pages with Tez templates display their designed hero.
- [ ] Standard pages (no template) get an auto hero without any Page Builder use.
- [ ] No duplicated H1 titles on pages.

***

## Phase 5 – Blog Enhancements \& Single Post Features

### 5.1 Module integrity

- [ ] Confirm `functions.php` still requires all modules in correct order: core, footer, SEO, redirects, page templates, 404 hub, visual sitemap, ToC, polls, star rating, key takeaways, FAQ schema, post meta, feed controller, typography, icon mapping, misc tweaks.
- [ ] Check each `inc/*.php` file loads without fatal errors and does not declare duplicate function names.


### 5.2 Single post UX

- [ ] Confirm `css/single-post.css` styles: reading progress, ToC, heading anchors, sidebar share, author box, related posts, navigation, FAQ and dark mode.
- [ ] Confirm `js/single-post.js` features: reading progress bar, ToC active state, share popups, copy link, external link markers.
- [ ] Confirm ToC, key takeaways, FAQ schema, polls, star rating, and enhanced meta appear once per post and do not conflict with Jannah’s native options.

**Verification (Phase 5):**

- [ ] Test a post with all features, a post with few features, and a post with none; layout remains stable.
- [ ] No console errors arising from single‑post scripts.

***

## Phase 6 – Footer Preservation \& Improvements

### 6.1 Footer content \& menus

- [ ] Ensure `footer.php` uses the same text and structure from `inc/footer.php` that you liked.
- [ ] In Appearance → Menus, assign:
    - Services menu to `tez_footer_1`.
    - Useful links to `tez_footer_2`.
- [ ] Ensure fallback lists in footer show reasonable links when menus are not assigned.


### 6.2 Floating widget \& scroll‑top

- [ ] Confirm Chaty widget markup is present in `footer.php` and matches the original behavior:
    - 5 fixed channels with tooltips and ARIA.
- [ ] Confirm scroll‑to‑top button exists and is controlled by `scripts.js`.
- [ ] Ensure no duplicate instances of these widgets get created.

**Verification (Phase 6):**

- [ ] Footer visually matches expectations on multiple pages.
- [ ] Chaty + scroll‑top work in all viewports, dark/sepia included.

***

## Phase 7 – SEO, Redirects, Sitemap, Feeds

### 7.1 URL cleanup \& redirects

- [ ] Review `inc/seo-url-cleanup.php` to ensure tracking parameter cleanup targets only relevant URLs (canonical, schema, etc.), and does not break necessary query strings.
- [ ] Review `inc/seo-redirects.php` to confirm:
    - Date archives redirect appropriately or are disabled.
    - Author archives are removed/redirected as intended.
    - No redirect loops or unintended 404s.


### 7.2 Visual sitemap \& 404 hub

- [ ] Verify `inc/visual-sitemap.php` outputs an HTML sitemap page (check URL or shortcode as implemented).
- [ ] Confirm `404.php` + `inc/404-hub.php` show the rich 404 layout with search, popular posts, categories, quick links.


### 7.3 Feeds

- [ ] Check `inc/feed-controller.php` for any 410 responses or feed disabling; confirm these align with your SEO strategy.

**Verification (Phase 7):**

- [ ] Manually test a date archive URL, an author archive URL, and `/sitemap`.
- [ ] Check logs or browser for redirect behavior and status codes.

***

## Phase 8 – QA: Performance, Accessibility, RTL

### 8.1 Performance

- [ ] Run Lighthouse (DevTools) on home, a service page, and a single post (desktop + mobile).
- [ ] Confirm CSS/JS bundles are not duplicated and that conditional loading decisions from Phase 3 still hold.
- [ ] Check that fonts and FA assets are not requested multiple times.


### 8.2 Accessibility \& RTL

- [ ] Confirm skip link jumps to `#tez-main-content` and is visible on focus.
- [ ] Confirm theme mode and a11y toolbar buttons have proper `aria-*` attributes and keyboard accessibility.
- [ ] Validate RTL layout across header, hero, content, footer, Chaty, and forms.


### 8.3 Error checks

- [ ] Enable `WP_DEBUG_LOG` on staging and browse all major page types; confirm no new PHP notices/warnings.
- [ ] Open DevTools console on key pages; ensure **zero** JS errors.

***

## Phase 9 – Git, Docs, and Merge

### 9.1 Commits and documentation

- [ ] Commit after each phase with clear messages (`feat: add header.php override`, `fix: remove FA dequeue`, etc.).
- [ ] Keep `DEVELOPMENT_REPORT.md` updated with any architectural changes (header/footer overrides, hero system behavior changes).
- [ ] At the end, update this TODO with checkmarks and optionally notes/links to test screenshots.


### 9.2 Merge \& release

- [ ] When staging passes all checks, merge `fix/final-child-theme-rewrite` into `New`.
- [ ] Optionally tag a release `v3.1.0-final-child` after deployment and smoke tests on live.

***
![CodeRabbit Pull Request Reviews](https://img.shields.io/coderabbit/prs/github/maziyarid/childjannah?utm_source=oss&utm_medium=github&utm_campaign=maziyarid%2Fchildjannah&labelColor=171717&color=FF570A&link=https%3A%2F%2Fcoderabbit.ai&label=CodeRabbit+Reviews)
