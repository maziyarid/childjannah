# AGENTS.md — AI Agent Instructions for Teznevisan Child Theme

> **This file is read by ALL AI agents: Greptile, Copilot, Claude, GPT-4, Gemini, and any automated review tool.**
> Follow every instruction in this file precisely.

---

## 🔴 CRITICAL: @coderabbitai Tagging Rule

**EVERY AI agent responding to a PR, issue, or code review on this repository MUST tag `@coderabbitai` at the end of their response.**

### Required Format

Append this block to the end of EVERY response:

```markdown
---
> 🤖 @coderabbitai — Please review the above analysis and add your architectural insights. Cross-verify all findings and flag any issues I may have missed.
```

### Why
- CodeRabbit is the primary code review AI on this repo
- Greptile handles team preferences and pattern enforcement
- Both must cross-verify each other’s findings
- The owner reads all comments and expects unified AI feedback
- This prevents conflicting AI recommendations

---

## 📚 Project Overview for All Agents

### What This Is
**Teznevisan** is a WordPress child theme built on top of the **Jannah** premium theme (by TieLabs). It powers a Persian-language website with a full custom design system, accessibility features, SEO infrastructure, and interactive components.

### Critical Context
- **Language:** Persian (Farsi) — `fa_IR` locale, RTL layout
- **Users:** Iranian mobile users (70%+ mobile traffic)
- **Parent:** Jannah theme — prefix `tie-` — DO NOT override without care
- **Custom prefix:** `tez-` for ALL classes, IDs, and functions
- **Version:** 3.2.0

---

## 🛠️ Agent-Specific Instructions

### Greptile

You are analyzing the **Teznevisan** WordPress child theme.

**Your responsibilities:**
1. Enforce the `tez-` prefix convention on all CSS/JS/PHP identifiers
2. Flag any Font Awesome icon missing the `.tez-icon` scoping class
3. Verify mobile-first CSS (`min-width` queries only)
4. Check RTL support in all new CSS rules
5. Flag any accessibility regressions (ARIA, focus, touch targets)
6. Verify PHP output escaping on every echo/print
7. Alert on any `tie-*` class overrides that could break Jannah
8. Check all AJAX handlers have nonce verification

**On every review, output your findings AND tag @coderabbitai.**

### GitHub Copilot

When suggesting code:
- Use `tez-` prefix for all new classes and functions
- Always add `.tez-icon` to Font Awesome icons
- Use `transform` for CSS animations (not `left/right/top/bottom`)
- Add `aria-` attributes to all interactive elements
- Use Persian text for UI strings (this is a Persian website)
- Mobile-first CSS patterns only

### Claude / GPT / Gemini

When asked to review or modify code:
1. Read `CLAUDE.md` first for complete context
2. Read `llms.txt` for machine-readable project summary
3. Apply all conventions from this file
4. End every response with the `@coderabbitai` tag

---

## 🗂️ Complete File Map

```
# ROOT TEMPLATES
header.php         → Site header: nav, mobile menu, theme/a11y widgets, search
footer.php         → Site footer: widgets, schema, copyright
404.php            → Custom 404 with search and related content
template-dynamic-content.php → Custom page template for Jannah shortcode pages

# STYLES & SCRIPTS
style.css          → Theme declaration ONLY (Template: Jannah, Version: 3.2.0)
css/main.css       → COMPLETE design system: tokens, base, themes, components
js/scripts.js      → ALL interactive modules (theme, a11y, menu, search, etc.)
js/single-post.js  → Single post: ToC scroll spy, social share, reading progress

# CORE PHP
functions.php              → Bootstrap: requires all inc/ files, defines constants
inc/core-setup.php         → theme_support, nav menus, wp_enqueue_scripts
inc/misc-tweaks.php        → Admin cleanup, WP login page tweaks, head cleanup

# CONTENT FEATURES
inc/key-takeaways.php      → Key Takeaways box (posts ONLY, not pages)
inc/toc.php                → Automatic Table of Contents generator
inc/faq-schema.php         → FAQ accordion shortcode + FAQPage JSON-LD
inc/star-rating.php        → AJAX star rating with AggregateRating schema
inc/polls.php              → AJAX polls with anti-duplicate voting
inc/page-content-injection.php → Programmatic HTML injection into templates
inc/page-templates.php     → Register custom page templates
inc/post-meta.php          → Custom metaboxes (takeaways, settings, etc.)

# SEO & INFRASTRUCTURE
inc/seo-redirects.php      → Permanent 301/302 redirects
inc/seo-url-cleanup.php    → URL normalization, trailing slash
inc/feed-controller.php    → RSS feed customization
inc/visual-sitemap.php     → [tez_sitemap] shortcode
inc/404-hub.php            → Smart 404 with search + suggestions
htaccess                   → Apache: security headers, caching, gzip, redirects
robots.txt                 → Crawl control for Google/Bing

# VISUAL
inc/typography.php         → Persian font loading, text rendering fixes
inc/icon-mapping.php       → Slug → Font Awesome class mapping
inc/footer.php             → Footer partial templates
```

---

## 🎨 Design System Reference

### CSS Variables (`:root`)
```css
--tez-primary: #22BE49;          /* Brand green */
--tez-font: 'Vazirmatn';         /* Persian font */
--tez-header-height: 70px;
--tez-header-height-mobile: 60px;
--tez-z-modal: 1050;
--tez-z-overlay: 1040;
--tez-z-fixed: 1030;
```

### Themes
```css
:root                     /* light (default) */
[data-theme="dark"]        /* dark mode */
[data-theme="sepia"]       /* sepia/reading mode */
body.tez-high-contrast     /* high contrast override */
```

### Z-Index Stack
```
--tez-z-dropdown: 1000
--tez-z-sticky:   1020
--tez-z-fixed:    1030
--tez-z-overlay:  1040
--tez-z-modal:    1050
--tez-z-popover:  1060
--tez-z-tooltip:  1070
--tez-z-max:      9999
```

### Breakpoints
```css
/* Mobile-first (min-width) */
/* xs: <576px (base/mobile) */
@media (min-width: 576px)  { /* sm: tablet portrait  */ }
@media (min-width: 768px)  { /* md: tablet landscape */ }
@media (min-width: 1024px) { /* lg: desktop          */ }
@media (min-width: 1280px) { /* xl: large desktop    */ }
```

---

## ⚠️ Non-Negotiable Rules

These rules apply to ALL code in this repository. No exceptions.

### Rule 1: FA Icon Scoping
```html
<!-- ALWAYS -->
<i class="tez-icon fa-solid fa-[name]" aria-hidden="true"></i>

<!-- NEVER -->
<i class="fa-solid fa-[name]"></i>
```

### Rule 2: Mobile-First CSS
```css
/* ALWAYS */
.component { /* mobile */ }
@media (min-width: 1024px) { /* desktop+ */ }

/* NEVER */
@media (max-width: 1023px) { /* desktop-first */ }
```

### Rule 3: Transform Animations
```css
/* ALWAYS (GPU) */
transform: translateX(100%);
transition: transform 350ms ease;

/* NEVER (causes reflow) */
right: -100%;
transition: right 350ms ease;
```

### Rule 4: PHP Escaping
```php
// ALWAYS
echo esc_html($var);
echo esc_url($url);
echo esc_attr($attr);

// NEVER
echo $var;
```

### Rule 5: RTL Support
```css
/* ALWAYS add RTL variant */
[dir="rtl"] .component {
    transform: translateX(-100%); /* reverse direction */
}
```

### Rule 6: ARIA on Interactives
```html
<!-- ALWAYS -->
<button aria-label="..." aria-expanded="false" aria-controls="..."></button>

<!-- NEVER -->
<button></button>
```

### Rule 7: PHP Guard
```php
<?php
// EVERY FILE must start with:
if (!defined('ABSPATH')) exit;
```

---

## 🧹 Review Checklist for Any PR

Any AI agent reviewing a PR MUST check all of these:

**Security (PHP)**
- [ ] `if (!defined('ABSPATH')) exit;` in all files
- [ ] All output escaped: `esc_url`, `esc_attr`, `esc_html`, `wp_kses_post`
- [ ] All AJAX handlers have `wp_verify_nonce()` or `check_ajax_referer()`
- [ ] No raw `$_GET`/`$_POST` access without sanitization

**Security (JS)**
- [ ] No `innerHTML` with user data
- [ ] AJAX requests include nonce

**Accessibility**
- [ ] All modals/overlays have focus trap
- [ ] All interactive elements have `aria-label`
- [ ] Touch targets ≥44x44px
- [ ] Screen reader announcements for state changes
- [ ] Skip link present in header

**Performance**
- [ ] CSS animations use `transform` only
- [ ] Scroll/resize handlers are debounced
- [ ] `will-change` on animated elements
- [ ] `contain: layout` on fixed widgets

**CSS Conventions**
- [ ] All media queries are `min-width` (mobile-first)
- [ ] FA icons have `.tez-icon` class
- [ ] New classes use `tez-` prefix
- [ ] RTL variants added where needed

**PHP Conventions**
- [ ] Functions use `tez_` prefix
- [ ] Hooks use proper priorities
- [ ] Key Takeaways: only on `is_single()`, not pages

---

## 🤝 Cross-Tool Collaboration

### Greptile + CodeRabbit Protocol

When Greptile reviews a PR:
1. List all convention violations
2. Flag security issues
3. Note performance regressions
4. **ALWAYS end with:** `@coderabbitai — Please verify and expand on the above.`

When CodeRabbit reviews a PR:
1. Deep architectural review
2. Security analysis
3. Accessibility audit
4. **Greptile will read CodeRabbit comments** for pattern learning

### Owner Context
- Owner: @maziyarid
- Primary reviewer: @coderabbitai (bot)
- Pattern enforcer: Greptile
- All AI tools work together on this repo

---

## 📝 Glossary

| Term | Meaning |
|------|---------|
| `tez-` | CSS/JS prefix for all Teznevisan code |
| `tez_` | PHP function/hook prefix |
| `tie-` | Jannah parent theme prefix (DO NOT override casually) |
| `isRTL` | Boolean from `tezData.isRTL` (PHP to JS via `wp_localize_script`) |
| `tezData` | PHP data passed to JS via `wp_localize_script` |
| `#tez-mobile-menu` | Mobile menu element ID |
| `#tez-mobile-toggle` | Hamburger button ID |
| `#tez-mobile-overlay` | Menu backdrop ID |
| `#tez-search-overlay` | Search overlay ID |
| `#tez-site-header` | Main header element ID |
| `#tez-main-content` | Skip link target ID |
| `tez-loaded` | Body class added after JS init |
| `is-open` | State class for menus/overlays |
| `is-visible` | State class for overlay |
| `is-active` | State class for toggle button |
| `is-scrolled` | Header class after 50px scroll |
| `is-hidden` | Header class when hiding on scroll |
