# Teznevisan — Jannah Child Theme

[![CodeRabbit Pull Request Reviews](https://img.shields.io/coderabbit/prs/github/maziyarid/childjannah?utm_source=oss&utm_medium=github&utm_campaign=maziyarid%2Fchildjannah&labelColor=171717&color=FF570A&link=https%3A%2F%2Fcoderabbit.ai&label=CodeRabbit+Reviews)](https://coderabbit.ai)

> **Persian RTL · Jannah Parent Theme · WordPress 6.x · PHP 8.x**  
> Primary brand: `#22BE49` (green) · Fonts: Vazirmatn / IRANSans · Direction: RTL-first

---

## 📌 Current Status — February 2026

| Area | Status | Notes |
|---|---|---|
| CSS Design System (`css/main.css`) | ✅ Restored + Phase 4 additions | PR #8 open |
| Mobile hamburger menu | ⚠️ CSS present, JS binding needs verification | See Issue #1 below |
| Responsive header / footer | ✅ CSS complete | Template integration needed |
| Dark / Sepia / High Contrast modes | ✅ All three CSS-complete | PR #8 |
| OS-level dark mode (`prefers-color-scheme`) | ✅ Added Phase 4 | PR #8 |
| Logo responsive sizing | ✅ Added Phase 4 | PR #8 |
| WCAG focus-visible (all elements) | ✅ Completed Phase 4 | PR #8 |
| Sepia element overrides (code/table/blockquote) | ✅ Fixed Phase 4 | PR #8 |
| `Snippets/` directory audit | ✅ Complete — 6 pieces ported | PR #8 |
| Page templates hero section | ❌ Broken — class mismatch suspected | Phase 5 |
| `functions.php` duplicate-function audit | ⚠️ Not yet performed | Phase 5 |
| `inc/core-setup.php` hook audit | ⚠️ Double header risk present | Phase 5 |
| Font Awesome conflict (`tez_disable_external_fa`) | ⚠️ May still be hooked | Phase 5 |
| Single post features | 🔄 CSS exists, module integrity unchecked | Phase 6 |
| Full accessibility (WCAG AA) | 🔄 Focus rings done, full audit pending | Phase 7 |
| Performance (Lighthouse 90+) | 🔄 Not yet measured | Phase 7 |

---

## 🚨 Known Issues — Diagnosed

### 🔴 Critical

**Issue 1 — Mobile hamburger menu not visible / not working**  
`.tez-mobile-toggle` CSS is fully defined in `css/main.css` (44×44px button, 3-line SVG, X-animation on open). The problem is one of:
- `header.php` (or the hooked header function) is not emitting the `.tez-mobile-toggle` button in the HTML output
- `js/scripts.js` click handler is not binding to `.tez-mobile-toggle` — check that `document.querySelector('.tez-mobile-toggle')` returns a non-null element before `addEventListener` is called
- `aria-expanded` toggling on the button, `.is-open` on `.tez-mobile-menu`, `.is-visible` on `.tez-mobile-overlay`, and `tez-menu-open` on `body` must all fire together

**Issue 2 — Pages have no / broken styling**  
History: `css/main.css` was truncated to 449 lines (missing all nav, hamburger, Chaty, responsive CSS). Restored in PR #6. If pages are still unstyled after PR #6/#8 merge, root cause is the enqueue priority — Jannah parent styles may be loading *after* the child, overriding everything. Fix: ensure `tez_enqueue_child_assets` uses `add_action('wp_enqueue_scripts', ..., 20)` (priority 20, after Jannah’s priority 10).

**Issue 3 — Hero section broken on page templates**  
The CSS in `css/page-templates.css` defines `.tez-hero-*` classes. The PHP templates in `templates/*.php` must output exactly those class names. If the template was written against an older CSS version, class names may have drifted. Inspect element on the homepage or a service page and compare rendered classes vs CSS definitions.

**Issue 4 — Double top menu (historical)**  
If `inc/core-setup.php` still has `add_action('wp_body_open', 'tez_output_header_html')` (or similar) AND `header.php` exists in the child theme root, two full headers render. **Fix:** Remove the hook from `core-setup.php` — `header.php` should be the single source of header output.

### 🟡 Moderate

**Issue 5 — Font Awesome conflict**  
If `tez_disable_external_fa()` is still registered in `core-setup.php`, it dequeues Jannah’s FA bundle, breaking all native Jannah icons (navigation arrows, breadcrumb separators, widget icons). Fix: comment out or delete `tez_disable_external_fa()` and its `add_action` registration.

**Issue 6 — Responsiveness on template pages**  
Page templates may not wrap content in `.tez-container`, causing full-bleed or overflow on mobile. Every section inside a template should use `<div class="tez-container">` to apply the responsive `max-width: 1200px; padding-inline: 1rem` rules.

**Issue 7 — RTL physical properties**  
All CSS must use RTL-aware values. Check for `padding-left` / `margin-left` / `text-align: left` in templates and scripts — these should be `padding-inline-start` / `margin-inline-start` / `text-align: start` in an RTL context.

### 🟢 Minor

**Issue 8 — Footer class name mismatch**  
`Snippets/CSS Styles.css` used `.tez-footer-column`; active `css/main.css` uses `.tez-footer-col`. Any template using `.tez-footer-column` will get no styles. Use `.tez-footer-col`.

---

## 📂 Repository Structure

```
childjannah/
│
├── css/
│   ├── main.css              # Design system: CSS tokens, header, nav, mobile menu,
│   │                         #   Chaty, footer, dark/sepia/HC themes, animations,
│   │                         #   scroll-to-top, Jannah post overrides
│   │                         #   + Phase 4: logo sizing, OS dark mode, WCAG fixes
│   ├── single-post.css       # Reading progress bar, ToC, heading anchors,
│   │                         #   sidebar share, author box, related posts
│   ├── page-templates.css    # Hero sections, stats, services grid,
│   │                         #   process steps, CTA blocks, inquiry form
│   └── post-elements.css     # Star ratings, polls, key takeaways,
│                             #   FAQ blocks, info boxes, post enhancements
│
├── js/
│   ├── scripts.js            # Mobile menu toggle, search overlay,
│   │                         #   Chaty widget, scroll-to-top, theme mode,
│   │                         #   a11y toolbar, scroll-animate observer
│   └── single-post.js        # Reading progress, ToC active-state,
│                             #   share popup, copy-link, external link markers
│
├── inc/
│   ├── core-setup.php        # Theme setup, nav walkers, header/footer hooks
│   │                         #   ⚠️ CHECK: tez_output_header_html still hooked?
│   │                         #   ⚠️ CHECK: tez_disable_external_fa still hooked?
│   ├── footer.php            # Footer markup functions
│   ├── page-templates.php    # 7 page template registrations
│   ├── seo-url-cleanup.php   # Canonical / tracking param cleanup
│   ├── seo-redirects.php     # Date archive / author archive redirects
│   ├── typography.php        # @font-face: Vazirmatn, IRANSans
│   ├── icon-mapping.php      # FontAwesome class aliases
│   ├── misc-tweaks.php       # Body classes, page title hide, hero auto-inject
│   ├── toc.php               # Table of Contents module
│   ├── polls.php             # Post polls
│   ├── star-rating.php       # Star ratings
│   ├── key-takeaways.php     # Key takeaways box
│   ├── faq-schema.php        # FAQ JSON-LD schema
│   ├── post-meta.php         # Enhanced post meta
│   ├── feed-controller.php   # Feed 410 / disable control
│   ├── visual-sitemap.php    # HTML sitemap page
│   └── 404-hub.php           # Rich 404 page with search + popular posts
│
├── templates/
│   ├── homepage.php          # Hero, stats, services overview, process, CTA, blog
│   ├── services.php          # Hero, quick inquiry, service accordions, CTA
│   ├── contact.php           # Contact page
│   ├── about.php             # About page
│   ├── faq.php               # FAQ page
│   ├── inquiry.php           # Inquiry form + sidebar
│   └── tag-hub.php           # Tag / taxonomy hub page
│
├── Snippets/                 # 📋 REFERENCE FILES — not active, review only
│   └── CSS Styles.css        # v3.0.0 reference CSS (generic blue #2563eb theme)
│                             # STATUS: FULLY AUDITED in Phase 4 (PR #8)
│                             # RESULT: 6 missing pieces extracted → added to css/main.css
│                             # REMAINING VALUE: none — safe to archive after PR #8 merge
│
├── header.php                # Child theme header override (verify exists)
├── footer.php                # Child theme footer override (verify exists)
├── functions.php             # Asset enqueue, module requires, constants
├── style.css                 # Theme declaration header only
└── README.md                 # This file
```

---

## 🎨 CSS Design System

### Color Tokens

| Token | Light | Dark | Sepia |
|---|---|---|---|
| `--tez-primary` | `#22BE49` | `#34d45c` | `#5d8a3c` |
| `--tez-primary-dark` | `#1a9e3b` | `#4ae070` | `#4a7030` |
| `--tez-bg` | `#ffffff` | `#0f172a` | `#faf6f1` |
| `--tez-text` | `#111827` | `#f1f5f9` | `#44403c` |
| `--tez-border` | `#e5e7eb` | `#334155` | `#d6cfc4` |
| `--tez-card-bg` | `#ffffff` | `#1e293b` | `#fffcf7` |

> ℹ️ `Snippets/CSS Styles.css` uses `--tez-primary: #2563eb` (blue). This is a generic template color and was **intentionally not adopted**. All active files use the Teznevisan green `#22BE49`.

### Component Classes

| Class | Description |
|---|---|
| `.tez-container` | Responsive max-width wrapper (1200px, auto padding) |
| `.tez-site-header` | Sticky header, hides on scroll-down, restores on scroll-up |
| `.tez-main-nav` | Desktop nav (hidden below 1024px) |
| `.tez-mobile-toggle` | Hamburger button — 44×44px tap target, 3-line SVG animates to × |
| `.tez-mobile-menu` | RTL slide-in drawer from right |
| `.tez-mobile-overlay` | Backdrop blur overlay behind drawer |
| `.tez-search-overlay` | Full-screen search overlay |
| `.tez-chaty` | Floating contact widget (bottom-right, WhatsApp-green toggle) |
| `.tez-scroll-top` | Scroll-to-top FAB (bottom-left) |
| `.tez-theme-buttons` | Fixed right-side dark/sepia/light toggle panel |
| `.tez-a11y-toolbar` | Fixed left-side font-size accessibility toolbar |
| `.tez-btn` | Base button — variants: `-primary` `-secondary` `-lg` `-white` `-outline-white` |
| `.tez-skip-link` | Skip-to-main-content link (visible on keyboard focus) |
| `.scroll-animate` | Intersection observer hook (fades in on scroll) |
| `.tez-logo-img` | Header logo `<img>` — scales 100→154px across breakpoints *(Phase 4)* |

### Breakpoints

| Breakpoint | Purpose |
|---|---|
| `375px` | Small phones (logo min-size) |
| `640px` | Container padding increase |
| `768px` | Footer 2-col, header full height, search input larger |
| `1024px` | Desktop nav shows, hamburger hides, logo full size |
| `1200px` | Nav item font size increase |
| `1400px` | Nav gap increase *(added Phase 4)* |

---

## 🤖 Bot Review Instructions

### For @coderabbitai

Please review **PR #8** (`feature/phase4-css-additions`) and diagnose the following:

1. **`css/main.css` — Phase 4 additions block** (bottom of file, marked `PHASE 4: SNIPPETS AUDIT`)
   - Confirm no selector conflicts with the existing rules above
   - Confirm `.tez-logo-img` sizing doesn’t conflict with `.tez-footer-logo-img` (different class, same `img` element on different elements — should be fine)
   - Confirm `@media(prefers-color-scheme:dark){:root:not([data-theme]){...}}` only activates when no manual theme is set

2. **`js/scripts.js`** — Verify the mobile hamburger flow:
   - `.tez-mobile-toggle` click → sets `aria-expanded`, adds `.is-active` to toggle
   - `.tez-mobile-menu` receives `.is-open`
   - `.tez-mobile-overlay` receives `.is-visible`
   - `document.body` receives `.tez-menu-open`
   - Close button (`.tez-mobile-close`) and overlay click both reverse these
   - `Escape` key closes the menu

3. **`inc/core-setup.php`** — Flag if any of these are still hooked:
   - `tez_output_header_html()` — causes double header if `header.php` exists
   - `tez_disable_external_fa()` — breaks Jannah native icons
   - `tez_output_close_main()` — causes double `</main>` if `footer.php` exists

4. **`functions.php`** — Confirm:
   - `add_action('wp_enqueue_scripts', 'tez_enqueue_child_assets', 20)` — priority 20 is critical
   - `wp_enqueue_style('tez-main', ..., ['jannah-style', 'tie-style'], ...)` — dependency array includes parent
   - No duplicate `function` declarations across `functions.php` and `inc/*.php` files

5. **`templates/*.php`** — Confirm all sections use `.tez-container` wrapper and hero classes match `css/page-templates.css`.

6. **`Snippets/CSS Styles.css`** — Confirm the Phase 4 audit was complete. Any CSS patterns in Snippets not present in `css/main.css` should be flagged.

### For GitHub Copilot

Please perform a code review on PR #8. Specifically check:
- CSS specificity issues in the Phase 4 additions
- Any RTL breakages (use of physical `left`/`right` instead of logical properties)
- Missing vendor prefixes (particularly `-webkit-` for `backdrop-filter`)
- Potential `@layer` ordering issues (base/theme/components/utilities are declared at the top)

---

## 🗓️ Phase Roadmap

### ✅ Completed
- **Phase 3** (PR #6) — CSS/JS restored from 449-line truncation incident; full nav, hamburger, Chaty, responsive footer added
- **Phase 4** (PR #8) — Snippets audit: 6 missing pieces ported; OS dark mode; WCAG focus-visible completed; sepia fixed

### 🔄 In Progress
- **Phase 4.5** — Verify `js/scripts.js` hamburger logic; fix if not binding (Issue #1)
- **Phase 5** — `inc/core-setup.php` hook audit; fix double header; fix FA conflict
- **Phase 6** — Page template hero class audit; fix broken hero sections
- **Phase 7** — Single post module integrity; ToC, reading progress, share bar
- **Phase 8** — Full QA: Lighthouse, WCAG AA, RTL validation, PHP debug log

### ⏳ Future
- **Phase 9** — Fluid typography (`clamp()` for heading sizes)
- **Phase 10** — Release tag `v3.1.0` after full staging pass

---

## 🛠️ Development Notes

### Enqueue Priority
Child theme must load **after** Jannah parent (priority 10 default). Use priority 20:

```php
// functions.php
add_action( 'wp_enqueue_scripts', 'tez_enqueue_child_assets', 20 );

function tez_enqueue_child_assets() {
    wp_enqueue_style(
        'tez-main',
        get_stylesheet_directory_uri() . '/css/main.css',
        [ 'jannah-style' ],  // dependency: Jannah parent style
        TEZ_VERSION
    );
    wp_enqueue_script(
        'tez-scripts',
        get_stylesheet_directory_uri() . '/js/scripts.js',
        [ 'jquery' ],
        TEZ_VERSION,
        true  // in footer
    );
}
```

### RTL Rules
- `direction: rtl` is set on `body` in `css/main.css`
- Mobile menu slides in from the **right** edge (`right: -100%` → `right: 0`)
- Chaty widget is anchored `right: 1.5rem` (near right edge)
- Scroll-to-top is anchored `left: 1.5rem` (near left edge, opposite Chaty)
- Theme mode buttons: `right: 1rem` on desktop, move to `left: 1rem` below 991px
- A11y toolbar: `left: 1rem` on desktop, hidden below 575px

### Font Stack
```css
font-family: 'Vazirmatn', 'IRANSans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
```
Do **not** enqueue Google Fonts. Vazirmatn must be served locally via `@font-face` in `inc/typography.php`.

### Admin Bar Offset
When WP admin bar is visible, the sticky header needs a top offset:
```css
body.admin-bar .tez-site-header { top: 32px; }
@media (max-width: 782px) { body.admin-bar .tez-site-header { top: 46px; } }
```
This is already present in `css/main.css`.

---

*Last updated: 2026-02-25 · Phase 4 complete · PR #8 pending review*
