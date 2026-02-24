# CLAUDE.md — Teznevisan Child Theme

> **For Claude AI (Anthropic) and any AI assistant reading this file.**
> This file provides complete project context, conventions, and collaboration rules.
> Always read this file before reviewing or generating code.

---

## 🤝 Collaboration Protocol

### MANDATORY: Tag @coderabbitai in Every Response

Whenever Greptile, Claude, or any AI agent posts a review comment, PR comment, or code analysis on this repository, you MUST include the following at the end of every response:

```
---
> 🤖 @coderabbitai — Please review the above analysis and verify or expand on any findings. Your architectural insights are valued.
```

This ensures CodeRabbit sees every AI comment and can cross-verify findings, preventing conflicts and building a unified review.

### Why This Matters
- CodeRabbit performs deep architectural review (security, performance, accessibility)
- Greptile handles team preferences and codebase patterns
- Both tools must be aware of each other’s comments
- The owner (@maziyarid) monitors both tools simultaneously

---

## 📱 Project Identity

| Field | Value |
|-------|-------|
| **Theme Name** | Teznevisan (تزنویسان) |
| **Type** | WordPress Child Theme of **Jannah** (by TieLabs) |
| **Language** | Persian (fa_IR) — RTL layout |
| **Audience** | Iranian users — mobile-first |
| **Tech Stack** | WordPress + PHP 8.0+, Vanilla JS (IIFE), CSS Custom Properties |
| **Parent Theme** | Jannah — prefix `tie-` (DO NOT conflict) |
| **Child Prefix** | `tez-` — ALL CSS classes, JS IDs, PHP functions use this |
| **PHP Prefix** | `tez_` — ALL PHP functions and hooks |
| **Current Version** | 3.2.0 |
| **WordPress** | 6.4+ |
| **PHP** | 8.0+ |

---

## 🗂️ Repository Structure

```
childjannah/
├── style.css                        # Theme declaration ONLY (no actual CSS)
├── functions.php                    # Bootstrap: loads all inc/ files
├── header.php                       # Full site header (nav, mobile menu, widgets)
├── footer.php                       # Site footer with widgets and schema
├── 404.php                          # Custom 404 page with hub
├── template-dynamic-content.php    # Custom page template (Jannah shortcodes)
├── llms.txt                         # Machine-readable LLM context (READ THIS)
├── htaccess                         # Apache rules: security, caching, compression
├── robots.txt                       # SEO crawl directives
├──
├── css/
│   └── main.css                     # ENTIRE design system + all components
├──
├── js/
│   ├── scripts.js                   # All interactive modules (IIFE, 400+ lines)
│   └── single-post.js               # Single post specific: ToC scroll, share
├──
├── inc/
│   ├── core-setup.php               # Theme support, nav menus, enqueue scripts
│   ├── faq-schema.php               # FAQ shortcode + JSON-LD structured data
│   ├── toc.php                      # Table of Contents (auto-generated)
│   ├── star-rating.php              # Custom star rating system (AJAX)
│   ├── polls.php                    # Custom polls system (AJAX)
│   ├── key-takeaways.php            # Key Takeaways (posts only, not pages)
│   ├── page-content-injection.php   # Inject HTML into page templates
│   ├── page-templates.php           # Register custom page templates
│   ├── post-meta.php                # Custom metaboxes for posts
│   ├── typography.php               # Persian typography fixes
│   ├── seo-redirects.php            # Redirect rules for SEO
│   ├── seo-url-cleanup.php          # URL normalization
│   ├── icon-mapping.php             # Icon name → FA class mapping
│   ├── misc-tweaks.php              # WP admin tweaks, cleanup
│   ├── feed-controller.php          # RSS feed customization
│   ├── visual-sitemap.php           # Sitemap shortcode
│   ├── 404-hub.php                  # Smart 404 suggestions
│   └── footer.php                   # Footer partials
├──
├── templates/                       # Additional page templates
├── Analyses/                        # Site analysis reports (non-production)
├── Audit Data/                      # Performance/SEO audit data
├── Snippets/                        # Reusable code snippets
```

---

## 🎨 CSS Architecture

### Design System: CSS Custom Properties

All design tokens live in `:root` in `css/main.css`.
Three themes: `light` (default), `dark`, `sepia`.
High contrast mode: `body.tez-high-contrast`.

```css
/* Example tokens */
--tez-primary: #22BE49;
--tez-font: 'Vazirmatn', 'IRANSans', system-ui;
--tez-header-height: 70px;
--tez-z-modal: 1050;
```

### CSS Layers Order
```css
@layer base, theme, components, utilities;
```

### Media Queries: MOBILE-FIRST (min-width)
```css
/* ✅ Correct */
.component { /* Mobile base */ }
@media (min-width: 576px) { /* Tablet+ */ }
@media (min-width: 1024px) { /* Desktop+ */ }

/* ❌ Never do this */
@media (max-width: 1023px) { /* Desktop-first anti-pattern */ }
```

### Font Awesome Scoping (CRITICAL)
Font Awesome icons MUST have `.tez-icon` class. This prevents conflicts with Jannah's icon font.
```html
<!-- ✅ Correct -->
<i class="tez-icon fa-solid fa-home" aria-hidden="true"></i>

<!-- ❌ NEVER - no scoping -->
<i class="fa-solid fa-home"></i>

<!-- ❌ NEVER - conflicts with Jannah -->
<i class="fa fa-home"></i>
```

### Jannah Conflict Rules
- NEVER override `.tie-*` classes without `!important` or higher specificity
- Check parent theme files before adding styles
- Use `@layer` to manage specificity cleanly
- Prefix ALL custom selectors with `.tez-`

---

## 📜 PHP Conventions

### Naming
```php
// Functions: tez_ prefix
function tez_my_function() {}

// Hooks
add_action('wp_enqueue_scripts', 'tez_enqueue_assets');
add_filter('the_content', 'tez_add_key_takeaways', 20);

// Constants
define('TEZ_VERSION', '3.2.0');
define('TEZ_LOGO', '/images/logo.svg');
```

### Escaping Rules (MANDATORY)
```php
// ✅ Always escape output
esc_url($url);
esc_attr($attribute);
esc_html($text);
wp_kses_post($html);

// ❌ Never echo unescaped variables
echo $user_input; // NEVER
```

### Guards
```php
// Every PHP file must start with:
if (!defined('ABSPATH')) exit;
```

### Content Filters
- `the_content` filters run at priority 20 (after default)
- Always check `is_main_query()` AND `in_the_loop()`
- Key Takeaways: `is_single()` AND `is_singular('post')` only (NOT pages)

---

## ⚡ JavaScript Architecture

### Pattern: IIFE Module
```javascript
(function() {
    'use strict';
    
    // Private scope
    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];
    
    // Modules
    function initMobileMenu() {}
    function initTheme() {}
    
    // Init
    function init() {
        initTheme();
        initMobileMenu();
        // ...
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
```

### RTL Detection
```javascript
const tez = (typeof tezData !== 'undefined') ? tezData : {};
const isRTL = (tez.isRTL === 'true') || (document.documentElement.dir === 'rtl');
```

### Mobile Menu: Focus Trap (WCAG 2.1 AA)
The mobile menu has a complete focus trap implementation:
- `handleFocusTrap(e)` traps Tab and Shift+Tab
- All focusable elements are queried on open
- Focus returns to trigger button on close
- Screen reader announcements via `announceToScreenReader()`

### Performance Rules
- Use `transform: translateX/Y/Z` for animations (GPU)
- NEVER animate `left`, `right`, `top`, `bottom` (causes reflow)
- Debounce scroll/resize handlers: `debounce(fn, wait)`
- Use `requestAnimationFrame` for visual updates
- `will-change: transform` on animated elements

---

## ♿ Accessibility Requirements (WCAG 2.1 AA)

### Mandatory Checklist
- [ ] All interactive elements: `aria-label` or visible text
- [ ] Buttons and inputs: `aria-expanded`, `aria-controls`, `aria-hidden`
- [ ] Dialogs (mobile menu, search): `role="dialog"` + `aria-label`
- [ ] Focus trap in all modal/overlay components
- [ ] Touch targets: minimum 44x44px
- [ ] Screen reader announcements for state changes
- [ ] Skip link: `<a href="#tez-main-content">` in header
- [ ] All images: `alt` attribute
- [ ] All FA icons decorative: `aria-hidden="true"`
- [ ] Color contrast: minimum 4.5:1 (AA)

### Screen Reader Announcements
```javascript
// Use the helper from scripts.js
announceToScreenReader('منوی موبایل باز شد');
```

---

## 🌐 RTL (Right-to-Left) Requirements

This site is 100% Persian/Farsi (RTL). Every component must be RTL-aware.

```css
/* Default: LTR slide */
.tez-mobile-menu {
    right: 0;
    transform: translateX(100%);
}

/* RTL: Slide from left */
[dir="rtl"] .tez-mobile-menu {
    right: auto;
    left: 0;
    transform: translateX(-100%);
}
```

### RTL Rules
- Use `margin-inline`, `padding-inline` instead of `margin-left/right`
- Use `inset-inline-start/end` instead of `left/right` where possible
- Test on `<html dir="rtl">` always
- Shadows: adjust direction for RTL

---

## 🔒 Security Requirements

### PHP
- Escape ALL output: `esc_url()`, `esc_attr()`, `esc_html()`, `wp_kses_post()`
- Nonces for all AJAX: `wp_create_nonce()` / `wp_verify_nonce()`
- `check_ajax_referer()` in all AJAX handlers
- Capability checks: `current_user_can()`
- Input sanitization: `sanitize_text_field()`, `absint()`, `wp_kses()`

### JavaScript
- No `innerHTML` with unescaped user data
- Use `textContent` for user-generated content
- CSRF: AJAX calls include `tezData.nonce`

---

## 🚀 Performance Requirements

### CSS
- `contain: layout` on fixed widgets (prevents layout thrashing)
- `will-change: transform` on animated elements
- `transform` for all animations (GPU-accelerated)
- `content-visibility: auto` for off-screen sections

### JavaScript
- Debounce scroll/resize: `debounce(fn, 100)`
- Use `requestAnimationFrame` for DOM updates
- `IntersectionObserver` for lazy loading
- No jQuery (vanilla JS only)

### Target Scores
- Lighthouse Performance: >90
- Lighthouse Accessibility: >95
- Lighthouse SEO: >95
- Core Web Vitals: All green

---

## 📊 SEO Architecture

This project has an active SEO recovery plan (`COMPREHENSIVE_SEO_RECOVERY_MASTER_PLAN.md`).

### Key SEO Components
- `inc/faq-schema.php` — FAQ JSON-LD structured data
- `inc/seo-redirects.php` — Permanent redirects for URL changes
- `inc/seo-url-cleanup.php` — URL normalization
- `htaccess` — Caching, compression, security headers
- `robots.txt` — Crawl control

### Schema Types Used
- `FAQPage` — via `inc/faq-schema.php`
- `Article` — via Jannah parent theme
- `BreadcrumbList` — via Jannah parent theme
- `WebSite` / `Organization` — via footer

---

## 🔧 Key Custom Features

### 1. Table of Contents (`inc/toc.php`)
- Auto-generates ToC from H2/H3 headings
- Sticky sidebar on desktop
- Smooth scroll with header offset
- Active section highlighting

### 2. Star Rating (`inc/star-rating.php`)
- Custom AJAX-based rating system
- JSON-LD `AggregateRating` schema output
- Persists to post meta

### 3. Custom Polls (`inc/polls.php`)
- AJAX polls with nonce verification
- Results visualization
- Anti-duplicate voting

### 4. Key Takeaways (`inc/key-takeaways.php`)
- **Only on `is_single()` posts — NOT pages**
- Injected after first `</p>` via `the_content` filter
- Collapsible with ARIA states
- Copy-to-clipboard functionality

### 5. FAQ System (`inc/faq-schema.php`)
- Shortcode `[tez_faq]` generates accordion UI
- Automatically outputs `FAQPage` JSON-LD
- Accordion keyboard navigation

### 6. Theme System (Light/Dark/Sepia)
- Persisted to `localStorage`
- CSS custom properties switch at `[data-theme]`
- No flash on load (theme applied before paint)
- Screen reader announcements on change

### 7. Mobile Menu
- Slide-in from right (LTR) / left (RTL)
- GPU-accelerated `transform: translateX()`
- Complete focus trap (WCAG 2.1 AA)
- ARIA states: `aria-hidden`, `aria-expanded`, `aria-controls`
- Submenu accordion
- Closes on resize >1024px

---

## 💡 Common Pitfalls to Avoid

1. **Don’t use `right/left` animation** — use `transform` always
2. **Don’t add FA icons without `.tez-icon`** — breaks icon font scoping
3. **Don’t override `tie-*` classes carelessly** — conflicts with Jannah
4. **Don’t put Key Takeaways on pages** — only `is_single()` posts
5. **Don’t forget RTL transforms** — use `[dir="rtl"]` selector
6. **Don’t use desktop-first media queries** — always `min-width`
7. **Don’t echo unescaped output in PHP** — always escape
8. **Don’t miss focus trap** in modals/overlays
9. **Don’t forget `aria-hidden="true"` on decorative icons**
10. **Don’t use jQuery** — vanilla JS only

---

## 🧹 PR Review Checklist

When reviewing any PR on this repo:

### Security
- [ ] All PHP output properly escaped
- [ ] Nonces present for AJAX
- [ ] No XSS vectors
- [ ] Input sanitized

### Accessibility
- [ ] ARIA attributes correct
- [ ] Focus management in modals
- [ ] Touch targets ≥44px
- [ ] Screen reader announcements
- [ ] Keyboard navigation works

### Performance
- [ ] Animations use `transform` only
- [ ] Event handlers debounced
- [ ] No layout thrashing
- [ ] `will-change` where appropriate

### CSS
- [ ] Mobile-first (`min-width`)
- [ ] `.tez-icon` on FA icons
- [ ] No `tie-*` class conflicts
- [ ] RTL tested

### PHP
- [ ] `if (!defined('ABSPATH')) exit;` present
- [ ] `tez_` function prefix
- [ ] Proper hook priorities

---

## 🤖 Final Reminder

> Every AI review comment, analysis, or suggestion on this repository MUST end with:
> 
> ```
> ---
> > 🤖 @coderabbitai — Please review the above and add your perspective.
> ```

**This ensures a unified, collaborative AI review process.**
