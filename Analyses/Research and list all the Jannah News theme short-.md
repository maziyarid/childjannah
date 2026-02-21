<img src="https://r2cdn.perplexity.ai/pplx-full-logo-primary-dark%402x.png" style="height:64px;margin-right:32px"/>

# Research and list all the Jannah News theme short-codes, customisations and considerations, fixing the bugs and everything that makes the theme a perfect theme and fully customisable and preparing it for a service provider business theme.

You can absolutely turn Jannah into a fully‑customizable, stable service‑provider theme by leveraging its built‑in shortcodes, page builder, and a disciplined customization/performance workflow.[^1_1][^1_2][^1_3][^1_4][^1_5]

Below is a practical, implementation‑oriented guide.

***

## Enable Jannah shortcodes

- All Jannah shortcodes are provided by the “Jannah Extensions” plugin, which must be installed and activated under Jannah → Install Plugins → Jannah Extensions.[^1_1]
- In Gutenberg you access them via a Classic Editor block; in the Classic Editor you get a TieLabs shortcode dropdown above the editor.[^1_1]

***

## All built‑in Jannah shortcodes

These come from the official “Shortcodes” documentation; names here match the UI labels.[^1_1]

- Boxes – Content boxes with styles (Shadow, Info, Success, Warning, Error, Download, Note), alignment, custom class, and width options.[^1_1]
- Buttons – Colored buttons with size (small/medium/big), link URL, text, Font Awesome icon, new‑tab and nofollow options.[^1_1]
- Tabs – Horizontal or vertical tab containers; you replace “Tab x Title” and “Tab x | Your Content” with your own headings and content.[^1_1]
- Toggle Boxes – Accordion‑style toggles with title, default state (open/closed), and rich content area.[^1_1]
- Content Slideshow – A slide‑by‑slide content slider using `[tie_slide] ... [/tie_slide]` blocks where each slide can contain text, images, or video.[^1_1]
- Author Box – Author bio box with title, author image URL, and bio content field.[^1_1]
- Flickr – Displays recent or random photos from a Flickr account by account ID and photo count.[^1_1]
- Display Feeds – Outputs items from an RSS/Atom feed URL with a chosen number of feed items.[^1_1]
- Tooltip – Wraps text with a tooltip bubble showing extra content; you can choose direction (top, bottom, left, right).[^1_1]
- Share Buttons – Inline social sharing/follow buttons, including a Twitter Follow button using a configured username.[^1_1]
- Dropcap – Styles the first letter/word as a drop‑cap (enabled via the Dropcap item in the shortcode menu).[^1_1]
- Tags Cloud – Inserts a tag cloud block at the cursor location.[^1_1]
- Highlight Text – Highlights text with a chosen background color and specified text string.[^1_1]
- Padding – Adds left/right padding around a content block with values in CSS units (px, %, etc.).[^1_1]
- Divider Line – Horizontal rule with style (solid, dashed, double, dotted, normal) and configurable top/bottom margins.[^1_1]
- Lists – Styled lists; you choose the list type from the Shortcodes → Lists menu and then put `<li>` items between the shortcode tags.[^1_6][^1_1]
- Restrict Content – Shows content only to registered users or only to guests, by wrapping selected content in a shortcode.[^1_1]
- Columns – Nine different column layouts; you select a layout and then replace “Add Content here” in each column with your own content.[^1_1]
- Google Maps – Embeds a Google Map using the map URL obtained from Google Maps.[^1_1]
- Video – Embeds a video by full URL with optional width and height parameters.[^1_1]
- Audio – Embeds audio using MP3, M4A, or OGG file URLs.[^1_1]
- Lightbox – Creates a link that opens an image or YouTube/Vimeo video in a lightbox, with title and link text.[^1_1]
- Quote – Styled quote block with content, alignment (left/right/center), author field, and style (dark/light/simple).[^1_1]
- Login Form – Inserts a front‑end login form via a shortcode.[^1_1]
- Fullwidth Image – Makes an image span full content width by wrapping it in `[tie_full_img] ... [/tie_full_img]`.[^1_1]
- Content Index – Table‑of‑contents style index for long articles; you mark each section and Jannah renders a responsive index list.[^1_7][^1_1]

***

## Page builder, blocks, and where shortcodes fit

- Jannah’s TieLabs Page Builder lets you build pages from sections and blocks with options for background color/image/video, parallax, dark/light skins, sidebars, and sticky sidebars.[^1_3][^1_5]
- “Custom Content Blocks” allow you to drop arbitrary content (including any of the shortcodes above) into any section, with their own title, URL, colors, dark skin mode, and “content only” layout.[^1_2]
- News Blocks and sliders can be repurposed to show posts by category/tag, selective posts/pages, or WooCommerce products, while preserving Ajax filters, dark skin mode, and ad layouts.[^1_3]

***

## Adapting Jannah to a service‑provider layout

You can treat posts and blocks as “cards” for services, case studies, and resources:

- Use a hero section built with the Page Builder: full‑width section, background image/video, and a custom content block containing a big heading, service USP bullets (using Boxes/Lists), and a primary CTA Button shortcode.[^1_5][^1_2][^1_1]
- Use News Blocks to list “Services” or “Case Studies” categories with a clean grid layout; you can turn on dark skin or content‑only mode to get a more corporate feel instead of “bloggy” boxes.[^1_3]
- In service detail pages, combine Content Index for jump‑to sections, Columns for two‑column service specs vs. benefits, Quote for testimonials, and Google Maps for office location.[^1_7][^1_1]
- Build a “Plans \& Pricing” page with Columns + Boxes for plans, Button shortcodes for “Book a Call”/“Get Quote”, and Restrict Content/Login Form for client‑only resources.[^1_1]
- Use Custom Content Blocks in the homepage/footer to embed contact forms (from your form plugin), service guarantees, FAQs (using Toggle Boxes), and embedded explainer videos via the Video shortcode.[^1_2][^1_1]

Most of this is layout and IA work; you can keep the theme structurally intact and let content, colors, and typography shift the perception from “news” to “agency/service provider.”

***

## Customization best practices (so it stays maintainable)

- Avoid editing core theme files directly; use a child theme for PHP/template overrides and custom CSS so Jannah updates don’t overwrite your changes.[^1_4]
- Do not overload the site with extra plugins for things Jannah already does (tabs, buttons, tooltips, social share, sliders), as plugin bloat increases conflicts, slows the site, and complicates debugging.[^1_4][^1_1]
- Keep the mobile experience tight: avoid heavy blocks on mobile, watch padding/divider usage, and test that columns, boxes, and custom content blocks render cleanly on small screens.[^1_4][^1_3]
- Maintain a clean heading hierarchy and internal linking when restructuring layouts with Page Builder blocks, as poor structure and heavy assets can quietly hurt SEO over time.[^1_3][^1_4]

***

## Performance and SEO tuning for Jannah

- Jannah can be optimized heavily with performance plugins like Autoptimize by aggregating JavaScript, combining/minifying CSS, and then generating critical‑path CSS for the main layout.[^1_8]
- A recommended workflow from optimization tutorials is: enable JS/CSS optimization, find the main combined CSS file Autoptimize generates, feed it into a critical CSS generator, and paste the output into the theme/Autoptimize critical CSS field.[^1_8]
- Pair that with solid caching, image compression, and lazy loading; this keeps news‑style blocks, sliders, and shortcodes from tanking CWV when repurposed for a service homepage.[^1_8][^1_3]

***

## Bug fixing and stability considerations

- Always use a licensed, up‑to‑date copy of Jannah; nulled or cracked versions have been observed to inject takeover messages urging owners to buy a license, which is unacceptable on a client site.[^1_9][^1_10]
- The official troubleshooting docs highlight typical issues: PHP max input vars too low, ModSecurity blocking settings saves, insufficient PHP memory, cache issues, missing style.css on install, wrong‑sized images, and broken Font Awesome icons.[^1_11]
- Before going live: match your server to Jannah’s requirements, raise PHP memory and max input vars as needed, regenerate thumbnails, clear all caches after big layout changes, and verify icons and fonts across pages.[^1_11]
- When switching themes or doing big customizations, test admin access and dashboard stability on staging first, since users have reported dashboard access issues after switching to Jannah without proper preparation.[^1_12]

***

## Hardening it for a service business

- Implement a child theme + custom plugin combo: keep business‑specific functions (CPTs for “Services”, hooks, schema) in a small plugin so you can re‑theme in the future without losing business logic.[^1_4]
- Avoid tying mission‑critical functionality (bookings, CRM, payments) to theme‑only features; let Jannah handle presentation (layouts, blocks, shortcodes) while stable, well‑maintained plugins handle business workflows.[^1_3][^1_4]
- Keep a staging copy of the site, test theme and plugin updates there, and only deploy changes after regression‑testing templates, Page Builder layouts, and shortcode‑heavy pages.[^1_11][^1_4]

If you share your current Jannah setup (demo import vs blank, key plugins, and whether you’re already using a child theme), a more concrete step‑by‑step migration plan from “news” to “service provider” can be outlined around that stack.
<span style="display:none">[^1_13][^1_14][^1_15]</span>

<div align="center">⁂</div>

[^1_1]: https://jannah.helpscoutdocs.com/article/128-shortcodes

[^1_2]: https://jannah.helpscoutdocs.com/article/127-custom-content-blocks

[^1_3]: https://jannah.helpscoutdocs.com/article/122-news-blocks

[^1_4]: https://ewebworld.in/common-wordpress-theme-customization-mistakes-to-avoid/

[^1_5]: https://jannah.helpscoutdocs.com/article/62-page-builder

[^1_6]: https://themeforest.net/item/sahifa-responsive-wordpress-news-magazine-newspaper-theme/2819356/faqs/11509

[^1_7]: https://jannah.helpscoutdocs.com/article/151-content-index-shortcode

[^1_8]: https://www.youtube.com/watch?v=jcMBm6LQYuw

[^1_9]: https://www.reddit.com/r/Wordpress/comments/j0we5k/sites_with_nulled_jannah_theme_are_getting_taken/

[^1_10]: https://themeforest.net/item/jannah-wordpress-news-magazine-theme/19659555/support

[^1_11]: https://jannah.helpscoutdocs.com/category/10-troubleshooting

[^1_12]: https://www.facebook.com/groups/1287749391397388/posts/2325487184290265/

[^1_13]: https://www.youtube.com/watch?v=FW0yWwbLZVc

[^1_14]: https://tielabs.com/knowledgebase/how-to-use-page-builder/

[^1_15]: https://www.youtube.com/watch?v=lRlmQpNS_SE


---

# Wait for the next files

Understood; will wait for the next files before suggesting how to integrate everything into Jannah and adapt it for the service‑provider setup.
<span style="display:none">[^2_1][^2_10][^2_11][^2_2][^2_3][^2_4][^2_5][^2_6][^2_7][^2_8][^2_9]</span>

<div align="center">⁂</div>

[^2_1]: Beautiful-404-Page-Hub.php

[^2_2]: About-Page-Template.php

[^2_3]: Beautiful-Table-of-Contents-ToC.php

[^2_4]: Beautiful-Tag-Hub-Page.php

[^2_5]: Clean-Tracking-Parameter-URLs-for-SEO.php

[^2_6]: Beautiful-Visual-Sitemap-Page.php

[^2_7]: Complete-Poll-System.php

[^2_8]: Contact-Page-Template.php

[^2_9]: Complete-Page-Templates-CSS.css

[^2_10]: Contain-Post-Elements.css

[^2_11]: Core-PHP-Functions-Setup.php


---

# Style.css:

/*
Theme Name:   Jannah Child
Theme URI:    [http://jannah.tielabs.com/](http://jannah.tielabs.com/)
Description:  Jannh Child Theme
Author:       TieLabs
Author URI:   [https://tielabs.com](https://tielabs.com)
Template:     jannah
Version:      1.0.2
License:      license purchased
License URI:  [http://themeforest.net/licenses/regular_extended](http://themeforest.net/licenses/regular_extended)
Tags:         Tags: two-columns, buddypress, left-sidebar, right-sidebar, custom-menu, editor-style, featured-images, full-width-template, microformats, rtl-language-support, sticky-post, threaded-comments, translation-ready
Text Domain:  jannah-child
*/

/* write custom css after this line */

Functions.php
<?php

add_action( 'wp_enqueue_scripts', 'tie_theme_child_styles_scripts', 80 );
function tie_theme_child_styles_scripts() {

    /* Load the RTL.css file of the parent theme */
    if ( is_rtl() ) {
    	wp_enqueue_style( 'tie-theme-rtl-css', get_template_directory_uri().'/rtl.css', '' );
    }
    
    /* THIS WILL ALLOW ADDING CUSTOM CSS TO THE style.css */
    wp_enqueue_style( 'tie-theme-child-css', get_stylesheet_directory_uri().'/style.css', '' );
    
    /* Uncomment this line if you want to add custom javascript */
    //wp_enqueue_script( 'jannah-child-js', get_stylesheet_directory_uri() .'/js/scripts.js', '', false, true );
    }

scripts.js
(function (\$) {

    $(window).load(function () {
    
    	// YOUR CONTENT HERE
    
    });
    })(jQuery);

This is my childtheme which is available in the jannah news official theme and I think it is best if we work on this. Given all things you have, as well as my code snippets that are currently in WP Code, research and plan how we can customise the jannah news without needing to external stuff and using the same theme capabilities

You already have an ideal base: an official Jannah child theme wired for custom CSS and optional JS, plus a whole library of PHP modules (ToC, polls, tag hub, SEO URL cleanup, page templates CSS, etc.) that can all live inside the same child theme instead of WPCode.[^3_1][^3_2][^3_3][^3_4][^3_5]

Here is the high‑level plan to customize Jannah using only its own capabilities plus your child theme.

***

## 1. Consolidate everything into the child theme

Goal: move all WPCode snippets into `jannah-child` so Jannah is the only theme dependency.

- Put all PHP feature modules into `jannah-child/functions.php` via `require_once` calls instead of running them from WPCode; e.g. `require_once get_stylesheet_directory() . '/inc/Beautiful-Table-of-Contents-ToC.php';`.[^3_2][^3_3]
- Keep the child `style.css` as the single CSS entry point and import your full page‑templates CSS there: `@import url('Complete-Page-Templates-CSS.css');` or enqueue it from `functions.php` as a separate stylesheet for cleaner cache‑busting.[^3_4]

***

## 2. Integrate your custom systems with Jannah’s structure

All your modules are already “theme‑style” features; they just need to follow Jannah’s conventions.

- Table of Contents: the ToC module already hooks into `the_content` with position logic (before content, after first/second paragraph, manual, etc.) and uses its own shortcode; this is fully compatible with Jannah’s loop and page templates.[^3_2]
- Poll System: the poll module registers its own table, meta box, auto‑insert into content, and shortcode, all based on post IDs; Jannah’s single templates will render it automatically where you hook into `the_content` (priority 15, after ToC).[^3_3]
- Tag Hub Page: the tag hub template uses `theme_page_templates` and `page_template` filters to expose a “Tag Hub” template in the Page editor, and then replaces the_content when that template is selected; this plays nicely with Jannah’s page layout while letting your template render a fully custom hero + tag grid.[^3_5]
- Complete Page Templates CSS: this file already defines service, pricing, inquiry, FAQ, contact, about, sitemap, etc. layouts using `.tez-*` classes; you just need to use those classes inside normal Jannah pages (via Gutenberg/Classic content, or a small custom page template) to get the “service provider” look.[^3_4]

***

## 3. Use Jannah page templates + your CSS instead of external builders

To stay inside the Jannah ecosystem:

- For service pages: create a basic page (Jannah full‑width template if needed), and in the content use simple HTML blocks with the `.tez-service-detail`, `.tez-highlights-grid`, `.tez-advantages-grid`, etc. classes so the “Complete Page Templates CSS” handles layout and visual design.[^3_4]
- For pricing: same idea, use `.tez-intro-box`, `.tez-pricing-grid`, `.tez-pricing-card`, `.tez-cta-section` in the page content and let Jannah’s page options (sidebar off, full width, background, etc.) handle the outer shell.[^3_4]
- For contact/inquiry: reuse `.tez-contact-grid`, `.tez-form-card`, `.tez-inquiry-grid`, `.tez-sidebar-card`, etc., and drop your existing form shortcode inside `.tez-form-card` instead of bringing in another layout system.[^3_4]

This keeps layouts in content + CSS, while Jannah handles header, footer, breadcrumbs, and news blocks where you still want them.

***

## 4. Respect and extend Jannah’s shortcodes instead of duplicating

- Keep using Jannah’s built‑in shortcodes (buttons, boxes, columns, tabs, quote, etc.) for micro‑UI; your CSS file already uses consistent variables (`--tez-primary`, `--tez-radius-*`) that match nicely with Jannah’s visual language.[^3_2][^3_4]
- Where you need more advanced UI (poll cards, animated ToC, tag hub hero), rely on your modules’ HTML/CSS and keep them namespaced with `.tez-*` classes so they do not collide with Jannah core styles.[^3_3][^3_5][^3_2]

***

## 5. Wire the SEO URL cleanup into the theme layer

- The “SEO URL Cleanup” module already hooks into canonical filters (Yoast, RankMath, AIOSEO), REST URLs, sitemaps, redirects, and schema JSON‑LD to strip tracking parameters, and adds a `<meta name="robots" content="noindex, nofollow">` for URLs containing known tracking params.[^3_1]
- By placing this into the child theme (or a small mu‑plugin) you get canonical and internal link cleanup across Jannah’s posts, archives, and custom templates without extra SEO plugins, and it will respect Jannah’s main query and permalink structure.[^3_1]

***

## 6. Theme‑level UX and visual consistency

- The CSS file defines design tokens (colors, radii, shadows, transitions) plus dark and sepia modes via `data-theme`; align Jannah’s color options in the theme panel with these tokens so the site feels coherent (e.g. set Jannah primary color ≈ `#2563eb`).[^3_4]
- Ensure RTL and accessibility: your ToC and Polls modules, and the page templates CSS, are already RTL‑friendly and use `Vazirmatn` + system fonts; Jannah’s RTL stylesheet is loaded automatically via `is_rtl()` in `functions.php`, so both systems will overlay correctly.[^3_3][^3_2][^3_4]

***

## 7. Minimal JS strategy inside `scripts.js`

You probably do not need much theme‑level JS beyond what your modules output:

- Let the ToC and Poll modules inject their own inline JS (they already do that via `wp_add_inline_script`/`wp_footer` hooks) so `scripts.js` remains small and only contains cross‑page behavior (e.g. scroll‑animation toggler for `.scroll-animate`, or theme‑wide a11y tweaks).[^3_2][^3_3][^3_4]
- If you enable `scripts.js`, keep it namespaced and only target your `.tez-*` components so you do not fight Jannah’s own scripts (megamenu, sliders, etc.).

***

## 8. Migration steps from WPCode to “pure Jannah + child”

A concrete sequence that keeps things safe:

1. Create `/inc/` under `jannah-child` and drop each module file there: ToC, Polls, Tag Hub, 404 hub, Visual Sitemap, Contact template, About template, Canonical cleanup, Core setup, etc.[^3_6][^3_7][^3_8][^3_9][^3_10]
2. In `functions.php` of the child theme, include them in a controlled order (core setup first, then URL cleanup, then content features like ToC and Polls, then page templates).[^3_10][^3_5][^3_1][^3_3][^3_2]
3. Disable the corresponding snippets in WPCode so there is no duplicate hook registration or double DB table creation.
4. Map each custom page template (About, Contact, Sitemap, Tag Hub, 404 hub) to a Jannah page template registration pattern like the Tag Hub file uses (`theme_page_templates` filter), so they appear in the Page Template dropdown and coexist with Jannah’s own templates.[^3_7][^3_8][^3_9][^3_5][^3_6]
5. On staging, open a few heavy pages (service page with ToC + Poll, pricing page, FAQ) and verify `the_content` priorities (ToC priority 5, Poll priority 15, any FAQ module priority 25) produce the desired order and do not conflict with Jannah’s content filters.[^3_3][^3_2]

***

Would you rather wire these modules as pure theme features (in `/inc/` as above), or do you prefer to keep some of them as small, dedicated plugins (e.g. Polls + URL cleanup) for re‑use across future non‑Jannah projects?

<div align="center">⁂</div>

[^3_1]: Clean-Tracking-Parameter-URLs-for-SEO.php

[^3_2]: Beautiful-Table-of-Contents-ToC.php

[^3_3]: Complete-Poll-System.php

[^3_4]: Complete-Page-Templates-CSS.css

[^3_5]: Beautiful-Tag-Hub-Page.php

[^3_6]: Beautiful-Visual-Sitemap-Page.php

[^3_7]: Beautiful-404-Page-Hub.php

[^3_8]: About-Page-Template.php

[^3_9]: Contact-Page-Template.php

[^3_10]: Core-PHP-Functions-Setup.php


---

# Research about all capabilities and provide report in markdown format include all things we should do as a plan, please include all search results and details

Here’s a detailed markdown report on everything the Jannah child theme plus your custom modules can do, and a step‑by‑step plan to turn it into a full service‑provider framework. Open the report for the full capability map, architecture, and implementation checklist.
<span style="display:none">[^4_1][^4_10][^4_11][^4_12][^4_13][^4_14][^4_15][^4_16][^4_17][^4_18][^4_19][^4_2][^4_20][^4_21][^4_22][^4_23][^4_24][^4_25][^4_26][^4_27][^4_28][^4_29][^4_3][^4_30][^4_31][^4_32][^4_33][^4_34][^4_4][^4_5][^4_6][^4_7][^4_8][^4_9]</span>

<div align="center">⁂</div>

[^4_1]: https://jannah.helpscoutdocs.com/article/196-jannah-child-theme

[^4_2]: Complete-Page-Templates-CSS.css

[^4_3]: https://jannah.helpscoutdocs.com/article/128-shortcodes

[^4_4]: https://jannah.helpscoutdocs.com/article/151-content-index-shortcode

[^4_5]: https://jannah.helpscoutdocs.com/article/127-custom-content-blocks

[^4_6]: https://jannah.helpscoutdocs.com/article/62-page-builder

[^4_7]: https://jannah.helpscoutdocs.com/article/77-styling-settings

[^4_8]: https://jannah.helpscoutdocs.com/article/179-blocks-settings

[^4_9]: Beautiful-Table-of-Contents-ToC.php

[^4_10]: Complete-Poll-System.php

[^4_11]: Beautiful-Visual-Sitemap-Page.php

[^4_12]: Beautiful-Tag-Hub-Page.php

[^4_13]: Beautiful-404-Page-Hub.php

[^4_14]: Clean-Tracking-Parameter-URLs-for-SEO.php

[^4_15]: About-Page-Template.php

[^4_16]: Contact-Page-Template.php

[^4_17]: https://jannah.helpscoutdocs.com/category/10-troubleshooting

[^4_18]: https://jannah.helpscoutdocs.com/article/122-news-blocks

[^4_19]: https://www.youtube.com/watch?v=zpm-xFwJewo

[^4_20]: https://themeforest.net/item/sahifa-responsive-wordpress-news-magazine-newspaper-theme/2819356/faqs/11509

[^4_21]: https://www.youtube.com/watch?v=aATOiJaP5dc

[^4_22]: https://jannah.tielabs.com/demo/shortcodes/

[^4_23]: https://www.youtube.com/watch?v=lRlmQpNS_SE

[^4_24]: https://www.youtube.com/watch?v=FW0yWwbLZVc

[^4_25]: https://www.dr-wp.com/en/the-best-template-for-blogs-review-of-the-jannah-template/

[^4_26]: https://support.jegtheme.com/theme/jnews/

[^4_27]: https://www.reddit.com/r/Wordpress/comments/j0we5k/sites_with_nulled_jannah_theme_are_getting_taken/

[^4_28]: https://www.youtube.com/watch?v=jcMBm6LQYuw

[^4_29]: https://ewebworld.in/common-wordpress-theme-customization-mistakes-to-avoid/

[^4_30]: https://tielabs.com/knowledgebase/how-to-use-page-builder/

[^4_31]: https://www.facebook.com/groups/1287749391397388/posts/2325487184290265/

[^4_32]: https://themeforest.net/item/jannah-wordpress-news-magazine-theme/19659555/support

[^4_33]: Contain-Post-Elements.css

[^4_34]: Core-PHP-Functions-Setup.php

