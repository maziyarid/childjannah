# Jannah Child Theme – FINAL REVISION TODO (No Missings)

**Branch:** `New` (working branch)  
**Goal:** Stable, bug‑free Jannah child theme  
**Status:** 🟢 **~85% Complete** — Only Phase 8 QA + Phase 9 merge remain  
**Last Updated:** 2026-02-23 17:30

---

## ✅ Completed Pre-Phase Work

### Module Enhancements (v3.0.0)
- [x] **Poll System v3.0.0** — `3d97285`
- [x] **Key Takeaways v3.0.0** — `0494c93`
- [x] **FAQ Schema v3.0.0** — `d96197f`

---

## Phase 0 – Git & Prep 🟡

- [x] `TODO_CHILD_THEME_REWRITE.md` added (`55cffbd`)
- [ ] Staging environment with full backup **→ manual step**
- [ ] Activate child theme, deactivate WPCode/snippets **→ manual step**
- [ ] Clear all caches **→ manual step**

**Status:** Code done; environment prep needs manual action

---

## Phase 1 – Header/Footer Architecture ✅

- [x] `header.php` created — full HTML structure, Tez walkers, theme switcher, a11y toolbar, search overlay (`6f3b5fa`)
- [x] `footer.php` created — 4-column footer, Chaty (5 channels), scroll-top, `wp_footer()` (`f9f1fc5`)
- [x] `inc/core-setup.php` already clean (no hooked header output)
- [x] `inc/footer.php` already utilities-only (no hooked footer output)
- [x] `tez_filter_body_classes()` correct — strips sidebar only on `templates/*`, adds `tez-theme-active`

**Verification (staging):**
- [ ] Exactly one header, one footer
- [ ] DOM order correct
- [ ] No PHP errors

---

## Phase 2 – Icons & Fonts ✅

- [x] `tez_disable_external_fa()` commented out — Jannah icons preserved
- [x] Local FA7 via `tez_enqueue_fontawesome()` (priority 5)
- [x] `tez_preload_fa()` preloads woff2 in `<head>`
- [x] `tez_fa_fix_css()` adds FA families *without* removing Jannah icon families
- [x] `inc/icon-mapping.php` — safe: only 80+ known `tie-icon-*` replaced; unknown left unchanged
- [x] `inc/typography.php` — full Irancell `@font-face` (200–800), Google Fonts dequeued, CDN FA blocked via output buffer
- [x] `TEZ_FONT_URL` constant defined; Irancell preloads in `<head>`

**Verification (staging):**
- [ ] Theme icons (Jannah default) render
- [ ] Tez/FA7 icons render
- [ ] Irancell body font visible
- [ ] No missing squares anywhere

---

## Phase 3 – CSS/JS Asset Loading ✅

Verified in `functions.php` — `tez_enqueue_child_assets()`:

- [x] `rtl.css` — parent only, gated on `is_rtl()`
- [x] `style.css` — child base, always
- [x] `css/main.css` — always
- [x] `css/single-post.css` — `is_singular('post')` only
- [x] `css/page-templates.css` — `is_page() || is_404()`
- [x] `css/post-elements.css` — `is_singular()` only
- [x] `js/scripts.js` — globally, footer, deferred
- [x] `js/single-post.js` — `is_singular('post')` only
- [x] `tezData` localisation — ajaxUrl, nonce, homeUrl, isRTL, isPost, isPage, postId, version

**Verification (staging):**
- [ ] Network tab: CSS/JS loaded only on intended pages
- [ ] Light/dark/sepia modes visually consistent

---

## Phase 4 – Page Templates & Hero System ✅

- [x] 7 templates registered in `inc/page-templates.php`
- [x] `tez_load_page_template()` loads from child theme dir
- [x] `templates/homepage.php` — full (9.6 KB)
- [x] `templates/services.php` — full (26 KB)
- [x] `templates/inquiry.php` — full (10.7 KB)
- [x] `templates/about.php` — upgraded: hero + breadcrumb + mission content + stats row + CTA (`55b2fb5`)
- [x] `templates/contact.php` — upgraded: hero + breadcrumb + 4 contact cards + CF7 area + social links (`55b2fb5`)
- [x] `templates/faq.php` — upgraded: hero + search box + accordion content + CTA (`55b2fb5`)
- [x] `templates/tag-hub.php` — upgraded: hero + dynamic tag cloud (top 50) + per-tag post grids (`55b2fb5`)
- [x] `inc/misc-tweaks.php` — `tez_auto_hero_on_pages()` for non-templated pages (priority 1)
- [x] `inc/misc-tweaks.php` — `tez_hide_page_title_on_templates()` hardened (null guard, templates/* check)

**Verification (staging):**
- [ ] Each of 7 templates visible in Page Editor dropdown
- [ ] Templated pages: hero renders, no duplicate H1
- [ ] Standard pages: auto-hero from title + excerpt + featured image

---

## Phase 5 – Blog Enhancements ✅

- [x] All 17 modules load in correct order (verified in `functions.php`)
- [x] Poll, Key Takeaways, FAQ Schema at v3.0.0
- [x] `css/single-post.css` + `js/single-post.js` conditional

**Verification (staging):**
- [ ] Post with all features, few features, none—layout stable
- [ ] No JS console errors

---

## Phase 6 – Footer ✅

- [x] `footer.php` — 4 columns (logo+social, tez_footer_1, tez_footer_2, contact)
- [x] Fallback lists for unassigned menus
- [x] Chaty floating widget (phone, SMS, WhatsApp, Telegram, email)
- [x] Scroll-to-top button
- [ ] **Manual:** Assign menus to `tez_footer_1` / `tez_footer_2` in WP Admin → Menus

---

## Phase 7 – SEO, Redirects, Sitemap, Feeds ✅

**Verified — no code changes needed:**

- [x] `inc/seo-redirects.php` — date archives → 301 home; author archives → 404; author enumeration blocked; REST/sitemap exclusion; Yoast + RankMath compat
- [x] `inc/seo-url-cleanup.php` — tracking param cleanup on canonicals/schema
- [x] `inc/visual-sitemap.php` — HTML sitemap registered
- [x] `inc/feed-controller.php` — feed control in place
- [x] `inc/404-hub.php` — rich 404 layout

**Verification (staging):**
- [ ] `/2024/` → 301 redirect to homepage
- [ ] `/author/admin/` → 404
- [ ] `/sitemap/` → visual HTML sitemap renders
- [ ] RSS feed behaves as configured

---

## Phase 8 – QA: Performance, Accessibility, RTL 🔴

### 8.1 Performance
- [ ] Lighthouse on home, service, single post → score > 90
- [ ] No duplicate CSS/JS bundles (check Network tab)
- [ ] Fonts + FA not requested twice

### 8.2 Accessibility & RTL
- [ ] Skip link → jumps to `#tez-main-content`
- [ ] Theme switcher + a11y toolbar ARIA correct
- [ ] RTL layout correct on all components
- [ ] Keyboard navigation: menu, search overlay, mobile menu, Chaty

### 8.3 Error checks
- [ ] Enable `WP_DEBUG_LOG` — zero notices/warnings
- [ ] DevTools Console — zero JS errors on all page types
- [ ] PHP `error_log` clean after navigating 10+ pages

**Status:** 🔴 Not started — **requires staging deployment**

---

## Phase 9 – Git, Docs, and Merge 🟡

- [x] All phases committed with clear messages
- [x] TODO kept up to date
- [ ] Update `DEVELOPMENT_REPORT.md` with architectural changes
- [ ] Merge `New` → production when staging passes Phase 8
- [ ] Tag `v3.1.0-final-child` after deployment

---

## 📊 Progress Dashboard

```
✅ Phase 0:  75%  Git + docs done; env prep manual
✅ Phase 1: 100%  Header/footer architecture
✅ Phase 2: 100%  Icons & Irancell fonts
✅ Phase 3: 100%  Conditional CSS/JS loading
✅ Phase 4: 100%  7 page templates complete
✅ Phase 5: 100%  Blog modules v3.0.0
✅ Phase 6:  95%  Footer done; menu assign = manual
✅ Phase 7: 100%  SEO/redirects verified
🔴 Phase 8:   0%  QA — needs staging
🟡 Phase 9:  50%  Docs ongoing

 Total: ~85% complete
```

---

## 🎯 Immediate Next Steps

1. **Deploy `New` branch to staging**
2. **Phase 8 QA:** Lighthouse, console errors, RTL, a11y
3. **Manual:** Assign footer menus in WP Admin
4. **Fix any staging bugs** found in Phase 8
5. **Phase 9:** Merge, tag v3.1.0, deploy to production

---

## 🔎 Key Architectural Notes

| Area | How it works |
|---|---|
| Header | `header.php` template override — single source, no double menu |
| Footer | `footer.php` template override — single source |
| Icons | FA7 local + icon-mapping; Jannah icons untouched |
| Fonts | Irancell local via `@font-face`; Google Fonts + CDN blocked |
| Assets | Conditional loading per page type; `tezData` localised |
| Templates | 7 registered templates, all with Tez hero pattern |
| Auto-hero | `the_content` filter (priority 1) for non-templated pages |
| No dup H1 | `the_title` filter skips when template starts with `templates/` |
| SEO | Date/author archives removed; author links replaced |

---

## 📝 Commit Log

| SHA | Description | Phase |
|---|---|---|
| `3d97285` | Poll System v3.0.0 | Pre-phase |
| `0494c93` | Key Takeaways v3.0.0 | Pre-phase |
| `d96197f` | FAQ Schema v3.0.0 | Pre-phase |
| `55cffbd` | TODO file added | 0 |
| `6f3b5fa` | `header.php` template | 1.1 |
| `f9f1fc5` | `footer.php` template | 1.2 |
| `2934c44` | TODO Phase 1 update | docs |
| `55b2fb5` | 4 stub templates upgraded | 4.2 |
| `current` | TODO Phases 2-7 update | docs |
