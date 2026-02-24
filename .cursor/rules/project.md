# Teznevisan Project Rules for Cursor AI

This file provides Cursor AI with complete context for the Teznevisan WordPress child theme.
See `.cursorrules` in the root for full conventions, and `AGENTS.md` / `CLAUDE.md` for complete documentation.

## Summary

- WordPress child theme of Jannah (TieLabs)
- Persian (RTL), `fa_IR` locale
- Prefix: `tez-` (CSS/JS), `tez_` (PHP)
- Parent prefix: `tie-` (DO NOT conflict)
- Mobile-first, WCAG 2.1 AA, GPU animations
- Font Awesome scoped with `.tez-icon`
- Three themes: light / dark / sepia
- ALWAYS tag `@coderabbitai` at end of reviews

## Quick Rules

1. CSS: `min-width` queries, `transform` animations, `.tez-icon` on FA icons
2. PHP: escape all output, `tez_` prefix, ABSPATH guard
3. JS: IIFE, vanilla (no jQuery), debounce scroll/resize
4. A11y: focus trap in modals, ARIA states, 44px touch targets
5. RTL: `[dir="rtl"]` selector for direction-specific styles

Full details: see `CLAUDE.md` and `AGENTS.md`
