Jannah Child Theme Full Revision & Fix Plan – Teznevisan3.com
Version: 1.0 – February 23, 2026
Status: Pre-Coding Documentation (Zero Missings)
Repository Structure to Create:
textteznevisan3-child-theme-fix/
├── README.md                  ← this entire plan (copy here)
├── docs/
│   ├── issues-audit.md
│   ├── jannah-builtins-used.md
│   └── verification-checklist.md
├── src/                       ← actual child theme folder (will become wp-content/themes/jannah-child)
│   ├── style.css
│   ├── functions.php
│   ├── js/scripts.js
│   ├── assets/css/tez-custom.css
│   ├── inc/                   ← moved modules only
│   └── templates/             ← minimal if needed
├── tasks/
│   ├── phase-0-prep.md
│   ├── phase-1-foundation.md
│   └── ... (one per phase)
└── verification/              ← screenshots + GSC exports after each phase
Success Criteria (Must All Be True Before Launch)

PageSpeed 100/100 mobile + desktop (tested on PageSpeed Insights + GTmetrix).
Core Web Vitals: LCP <1.8 s, CLS = 0, INP <100 ms (GSC + Web Vitals report).
Zero console errors (DevTools on all page types).
No double top menu (Jannah sticky + mega-menu only).
Every page has hero section via Jannah Page Builder (full-width section + background + Custom Content Block).
All service pages built inside Jannah Page Builder (no PHP bypass).
Blog uses Jannah single layouts only.
Dark/sepia modes fully functional.
Clean GSC (no 4xx/redirect chains, all legitimate pages indexed).
Child theme only — zero WP Code snippets active.


1. Complete Issue Audit (Every Single Detail, No Missings)
1.1 Performance & Render-Blocking (From All Code + Audits)

Inline <style> + <script> at priority 9999 (Typography, Single Post CSS/JS, Service Page, Star Rating, Remove Titles, Critical CSS).
Duplicated Font Awesome (local FA7 + CDN).
Service pages render 200+ KB inline HTML/CSS/JS outside theme hierarchy.
Multiple setTimeout + repeated DOMContentLoaded.
No defer/async on custom JS.
Reading progress + custom TOC + FAQ JS not optimised.

1.2 SEO & Indexing (From Ahrefs/GSC + Grok Reports)

Duplicate H1s (Jannah .entry-title + custom service/single-post code).
Overlapping schemas (RankMath/Yoast + manual Article/AggregateRating + Service schema).
Custom taxonomies (tez_service_*) not in Jannah sitemap.
Tracking-parameter URLs still leaking.
Noindex bleed on legitimate pages (history remnants).
404s: /assignments/, /isi-paper/, missing screenshots (/2024/10/Screenshot-*.png).
Redirect chains (archives, www/non-www).
Missing titles/descriptions (50+ pages), alt texts (70 %+ images).
Low word count + thin content on some service pages.

1.3 UI/UX & Theme Breakage

Double top menu (custom header conflicting with Jannah sticky/mega-menu).
.tez-* classes override Jannah responsive grid → broken mobile menu/layout.
Service pages bypass header/footer/mega-menu/sticky elements.
!important + hardcoded colors break dark/sepia modes.
Custom back-to-top, breadcrumbs, reading progress, FAQ accordion, star rating duplicate Jannah natives.

1.4 Maintainability & Security (From All Modules)

All logic in WP Code → no version control, update conflicts.
Service form AJAX: weak rate-limiting, open upload folder.
Hardcoded emails in PHP.
No caching headers on custom assets.

1.5 Redundancies (80 % to Delete)
25–40. All listed in previous Deepseek/Grok reports (star rating, basic TOC, buttons/boxes, etc.).
Spam Remnants (From Ahrefs + GSC)
41. 410 rules + robots.txt updates already done — confirm in child sitemap generation.
42. Disavow file uploaded — monitor in GSC.
Multilingual & AI (From Excel Sheet 2)
43–60. WPML/Polylang, hreflang, llms.txt, English pages — integrate via child + Jannah options (no new plugins beyond what’s already in history).

2. Jannah Built-in Features We Will Use Exclusively (Confirmed List)
Page Builder (for ALL pages – Hero Sections)

Sections: full-width, background image/video, parallax, dark skin, sticky sidebar.
Custom Content Blocks: arbitrary HTML + shortcodes + title + color + dark mode.

Shortcodes (Jannah Extensions – Required)

[button], [box], [columns], [tabs], [toggle], [content_index], [review], [quote], [list], [divider], [padding], [highlight], [author_box], etc.

Theme Options (Appearance Only)

Styling Settings → Primary color, skins, typography (local Irancell), disable Google Fonts.
Post Settings → single layout, reading progress bar, back-to-top, title/breadcrumb per page.
Layout Settings → header style, mega-menu, sticky elements.
Block Settings → meta control, block heads.

Template Overrides (Minimal)

404.php (use your Beautiful 404 Hub inside get_header()/get_footer()).
No full page-*.php bypass — use Page Builder on every page.

Other Natives

Local fonts upload, RTL support, schema via post settings/Rank Math.


3. What We Keep (Minimal Custom – Integrated into Child)

Complete Page Templates CSS (design tokens + .tez-* renamed to .tez- prefix only where needed; variables for dark/sepia).
Beautiful Table of Contents (meta box + auto-insert).
Complete Poll System (DB + shortcode).
Visual Sitemap, Tag Hub, 404 Hub (as content filters/shortcodes inside Jannah pages).
SEO URL Cleanup (hooks only).
Service Form Handler (shortcode only).

Everything else deleted/replaced.

4. Exact Child Theme Structure (Final – Copy to Repo)
(See repository structure above.)

5. Phase-by-Phase Execution Plan (7 Days Max – Verifiable Tasks)
Phase 0: Preparation (Day 1 – 30 min)

Create staging subdomain + full backup.
Deactivate all WP Code snippets.
Activate official jannah-child.
Install/activate: Jannah Extensions, WP Rocket, ShortPixel, Rank Math.
Clear all caches.
Verification: Site loads (may look broken — expected). Screenshot homepage.

Phase 1: Foundation & Double Top Menu Fix (Day 1)

Paste exact functions.php + style.css (I will provide in next message after you confirm Phase 0).
Enqueue parent + child + tez-custom.css (priority 30).
Fix double top menu: In Theme Options → Header → disable custom header overrides; use Jannah sticky + mega-menu only + child CSS for appearance.
Verification: Single clean top menu (sticky on scroll). No console errors.

Phase 2: CSS Consolidation & Design System (Day 2)

Merge all CSS into assets/css/tez-custom.css (variables only, no !important).
Align Jannah Theme Options (Primary #2563eb, local Irancell, dark skin enabled).
Remove all hardcoded colors/fonts.
Verification: Dark/sepia toggle works on homepage. Mobile grid perfect.

Phase 3: Hero Sections & Page Builder Standard (Day 3)

For every page (service, about, contact, etc.):


Edit → Template: Default (or Full-width).
Open TieLabs Page Builder.
First section: Full-width + background image + Custom Content Block (H1 + USP using Jannah [box] + [button]).


Blog pages: Keep Jannah single layout + child CSS only.
Verification: All pages have hero section. Screenshot 5 pages.

Phase 4: Replace Redundancies + Keep Modules (Day 4)

Delete Star Rating, Remove Titles, custom FAQ, basic TOC, reading progress, back-to-top from WP Code.
Use Jannah equivalents (listed in section 2).
Move kept modules to /inc/ + require in functions.php (order: seo-url-cleanup → toc → poll → sitemap/tag/404 → form).
Verification: No duplicate features. Poll/ToC work on test post.

Phase 5: Service Pages Rebuild (Day 5)

Delete old PHP service pages.
Rebuild each as draft with Page Builder + your CSS classes inside Custom Content Blocks (hero, features, pricing, FAQ via [toggle], form shortcode).
Verification: 5 service pages live, load <2 s, fully responsive.

Phase 6: Performance + QA Lockdown (Day 6)

WP Rocket full config (page cache, minify, combine, delay JS, critical CSS auto).
ShortPixel WebP + lazy.
Run full checklist: console, schema (Rich Results Test), mobile devices, GSC coverage.
Verification: 100/100 PageSpeed + perfect CWV screenshot.

Phase 7: Launch & Monitoring (Day 7)

Deploy to live → clear all caches.
Submit clean XML sitemap (Jannah + legitimate pages only).
Request indexing for all pages in GSC.
Update Excel remaining tasks (featured images, alts, excerpts — I will provide ready list).
Verification: GSC “Indexed” count rising, no new errors.


6. Repository Monitoring Checklist (Copy to tasks/ folder)

 Phase 0 complete – staging screenshot
 Phase 1 – double menu fixed
 Phase 2 – CSS variables working
 Phase 3 – hero on every page
 Phase 4 – modules moved, redundancies deleted
 Phase 5 – 5 service pages rebuilt
 Phase 6 – 100/100 + CWV
 Phase 7 – live + GSC indexing requested

Weekly Monitoring After Launch (From Excel)

GSC Coverage + Performance
PageSpeed weekly
Console errors
Dark/sepia test
Spam re-appearance check
