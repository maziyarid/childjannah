# Jannah Child Theme Capabilities and Customization Plan

## 1. Baseline: Official Jannah child theme

### 1.1 Child theme structure

The official Jannah child theme ships as `jannah-child` with a minimal `style.css`, a `functions.php` that enqueues parent RTL and child CSS, and an optional `scripts.js` hook.[^1][^2]

Key points:
- `style.css` declares `Template: jannah` and is the place for all custom CSS that should survive updates.[^1]
- `functions.php` hooks into `wp_enqueue_scripts` and loads `rtl.css` from the parent if `is_rtl()` is true, plus the child stylesheet via `get_stylesheet_directory_uri().'/style.css'`.[^1]
- An optional `scripts.js` is wired but commented; if enabled, it is enqueued in the footer and wrapped in a safe `jQuery` IIFE.[^1]

Implication: the child theme is the canonical place to consolidate custom PHP, CSS, and JS instead of relying on WPCode snippets or extra UI plugins.[^1]


### 1.2 How Jannah expects you to customize

The official docs recommend copying any template you want to override into the child theme using the same relative path (e.g. `templates/footer.php`).[^1]

This allows you to:
- Override headers, footers, single layouts, archives, and page templates one by one without touching the parent.[^1]
- Keep all business‑specific logic out of the main theme so updates are safe.[^1]


## 2. Core Jannah capabilities relevant to a service provider site

### 2.1 Shortcodes (micro‑components)

Jannah ships a broad set of shortcodes via the required **Jannah Extensions** plugin.[^3]

Capabilities:
- **Boxes** – contextual info boxes (shadow, info, success, warning, error, download, note) with alignment, width, and custom classes.[^3]
- **Buttons** – styled CTA buttons with colors, sizes, icons (Font Awesome), and target/nofollow options.[^3]
- **Tabs & Toggles** – horizontal/vertical tab sets and accordion/toggles for FAQs or feature breakdowns.[^3]
- **Content Slideshow** – multi‑slide content slider where each slide is free‑form HTML/media.[^3]
- **Author Box, Share Buttons, Tags Cloud, Highlight, Dropcap, Lists, Columns, Padding, Divider Line** – a full micro‑UI toolkit that can be embedded in posts, pages, and Page Builder custom content blocks.[^3]
- **Media embeds** – Google Maps, video, audio, lightbox links.[^3]
- **Quote**, **Login Form**, **Fullwidth Image**, and the built‑in **Content Index (TOC)** shortcode for long articles.[^4][^3]

These shortcodes give you all the building blocks for service landing sections (benefit lists, CTAs, highlights, testimonials) without importing a third‑party page builder.[^5][^3]


### 2.2 Page Builder (macro layout)

TieLabs Page Builder lets you build complex layouts from sections and blocks.[^6]

Key features:
- Add unlimited sections; each can have its own width (boxed or 100%), sidebar layout (none/left/right), sticky sidebar, and custom class.[^6]
- Section styling: background color, image, or video (YouTube/Vimeo/local), with parallax and multiple parallax effect types.[^6]
- Dark skin: switch entire sections into dark mode to contrast against light sections.[^6]
- Within sections, add News Blocks, sliders, and **Custom Content Blocks** – the latter accepts arbitrary HTML/shortcodes.[^5][^6]

For a service provider site, the Page Builder can be used for:
- Homepage hero + services overview sections.
- Social proof blocks (testimonials, logos) using News Blocks filtered to a “Case Studies” category.
- Call‑to‑action strips using Custom Content Blocks with Jannah shortcodes.[^5][^6]


### 2.3 Custom Content Blocks

Custom Content Blocks are specifically designed as flexible containers.[^5]

They provide:
- A block title and optional URL (can act as section headings).[^5]
- A rich content area that can hold text, images, or **any shortcodes** (Jannah or your own).[^5]
- Advanced options: content‑only mode (no background/padding), block primary color, and dark skin mode.[^5]

This is the ideal hook to place your `.tez-*` service layouts (e.g. pricing cards, feature grids) inside the Page Builder without external builders.[^2][^5]


### 2.4 Styling settings (theme‑level design)

The Styling Settings panel exposes high‑level design controls.[^7]

Capabilities:
- Global dark skin toggle for the entire site.[^7]
- Primary color and predefined skins (15+ presets) that set colors across headers, footers, content, and mobile menus.[^7]
- Body‑level styling: links, hover colors, border colors, selection background, and options to disable boxed/framed layout shadows.[^7]
- Custom body classes for more granular styling.

These global controls can be aligned with your `--tez-*` CSS variables so that the whole system feels unified.[^2][^7]


### 2.5 Block settings (meta and heads)

Jannah includes a global Block Settings panel that controls how block heads and metas appear across News Blocks and widgets.[^8]

Features:
- Global block style (boxed vs unboxed) and block head style for all block titles.[^8]
- Global toggles for meta elements across blocks: author name, comments number, and views number.[^8]

For a service site, this lets you declutter blocks (e.g. case studies, blog posts) by turning off non‑essential meta, keeping the design cleaner and more “productized service” oriented.[^8]


## 3. Your custom capability stack inside the child theme

You already have a substantial library of custom modules designed to work in a theme context. These can all be consolidated into `jannah-child` rather than WPCode.

### 3.1 Global design system: Complete Page Templates CSS

`Complete-Page-Templates-CSS.css` defines a full design system and ready‑made layouts for service/business pages.[^2]

Highlights:
- **Design tokens**: primary, secondary, accent colors; neutrals; card backgrounds; border colors; typography (`Vazirmatn` + system UI); spacing, radii, shadows, transitions.[^2]
- **Theme modes**: dark and sepia variants via `data-theme="dark"` and `data-theme="sepia"` that override key variables like `--tez-bg`, `--tez-text`, `--tez-card-bg`.[^2]
- **Base utilities**: `.tez-container`, `.tez-section`, section headers, buttons (`.tez-btn-*`), scroll animations, responsive utilities, focus styles, print styles.[^2]

Business‑specific layouts:
- **Service detail**: `.tez-service-detail`, `.tez-service-icon`, `.tez-service-content`, `.tez-service-features`, `.tez-service-footer` to create rich service cards with pricing and value props.[^2]
- **Highlights / Advantages / Process**: `.tez-highlights-grid`, `.tez-advantages-grid`, `.tez-process-grid` for feature lists and step‑by‑step flows.[^2]
- **Contact / Inquiry**: `.tez-contact-grid`, `.tez-contact-card`, `.tez-address-box`, `.tez-form-card`, `.tez-inquiry-grid`, `.tez-quick-contact`, `.tez-sidebar-card` for high‑conversion lead capture sections.[^2]
- **About**: `.tez-about-grid`, stats cards, mission and values grids, team section, all tuned for an “agency” narrative.[^2]
- **FAQ**: `.tez-faq-layout`, `.tez-faq-sidebar`, `.tez-faq-category`, `.tez-faq-item` with accordion behavior driven purely by CSS+minimal JS.[^2]
- **Pricing**: `.tez-pricing-grid`, `.tez-pricing-card`, badges, feature lists, pricing note, and CTA footer.[^2]
- **CTA and Map**: `.tez-cta-section` and `.tez-map-wrapper` for closing CTAs and embedded location maps.[^2]

This file already gives you a full service‑site component library, just waiting to be applied inside Jannah page content or custom templates.[^2]


### 3.2 Advanced Table of Contents system

`Beautiful-Table-of-Contents-ToC.php` is a full ToC engine distinct from Jannah’s built‑in Content Index shortcode, with more control and automation.[^9]

Capabilities:
- **Per‑post meta box**: settings for enabled status, heading text, position (before content, after first or second paragraph, manual), style (modern, minimal, boxed, gradient, sidebar), minimum headings, collapsed state, numbering, and selected heading levels (H2–H4).[^9]
- **Shortcode**: `[teztoc]` style shortcode that generates a ToC and can be inserted manually.[^9]
- **Auto‑insert**: filter on `the_content` with priority 5, inserting the ToC at the configured position while also injecting IDs into selected heading tags.[^9]
- **Heading ID logic**: regex‑based heading scanning that assigns deterministic IDs (`toc-0-...`) and avoids overwriting existing IDs.[^9]
- **Frontend UI**: sticky/inline ToC container with title, collapse toggle, numbered items, and animated entries.[^9]
- **Accessibility & UX**: keyboard navigation, smooth scrolling, IntersectionObserver‑based active item highlighting, reduced‑motion support, and print‑optimized behavior.[^9]

Styling:
- Modern/minimal/boxed/gradient/sidebar variants, all using the same `--tez-*` variables for seamless integration with the page templates CSS and Jannah’s colors.[^9][^2]
- Dark and sepia theming keyed off `data-theme` attributes.[^9][^2]

This gives you a more powerful, design‑consistent ToC than the default Content Index shortcode, while still compatible with Jannah’s content pipeline.


### 3.3 Advanced Poll system

`Complete-Poll-System.php` is a full poll engine with frontend and backend UX, database storage, and analytics.[^10]

Core features:
- **Custom DB table**: `{$wpdb->prefix}tez_polls` storing `post_id`, `poll_id`, `option_key`, `user_ip`, and timestamp, with indexes for efficient querying.[^10]
- **Meta box per post**: enable/disable poll, question text, type (single/multiple), position (before content, after content, before last paragraph, manual), style (modern, minimal, gradient, glass), and colorized options.[^10]
- **Auto‑insert**: `the_content` filter at priority 15 (after ToC) that injects the poll based on position, with graceful handling when disabled or manual.[^10][^9]
- **Shortcode**: `[tezpoll]` style shortcode to render the poll wherever needed.[^10]

Frontend experience:
- Animated poll container with header, meta (total votes badge), options, and result bars.[^10]
- Single or multiple selection with custom option colors and accessible labels.[^10]
- AJAX submission via `admin-ajax.php` with nonce validation, IP‑based vote prevention, and live update of total votes and percentages.[^10]
- Auto‑switch to “results” view after voting, with bar animations and support for previously voted users.[^10]

Backend UX:
- Tailored admin CSS and JS for the meta box: toggle switch for enabling, sortable option rows with drag handles, color pickers, and dynamic field name updating.[^10]

The poll system is ideal for service‑site use cases like pre‑consultation quizzes, opinion polls in content, or micro‑surveys to qualify leads.


### 3.4 Visual sitemap page

`Beautiful-Visual-Sitemap-Page.php` implements a dynamic sitemap page for the slug `sitemap`.[^11]

Functionality:
- Hooks `the_content` and replaces output only when viewing the page with slug `sitemap`.[^11]
- Automatically outputs:
  - Pages list.[^11]
  - Recent posts.[^11]
  - Category cards with random but consistent accent colors using a CSS variable `--cat-color`.[^11]
  - Tag cloud with variable font sizes.[^11]
  - Monthly archives and author grid.[^11]
- Includes a search box that submits to the main search endpoint.[^11]

Design:
- Hero header with gradient background and icon.
- Card‑based sections (`.sitemap-section`) with hover lift, box shadows, and responsive grid layout.[^11]
- Fully responsive behavior down to single‑column grids.[^11]

This gives you a beautiful, auto‑maintaining site map suitable for both UX and SEO.


### 3.5 Tag hub page template

`Beautiful-Tag-Hub-Page.php` registers a new page template called “Tag Hub” and renders a rich tag directory.[^12]

Capabilities:
- Registers a `tag-hub-template` with `theme_page_templates` and swaps the actual page template via the `page_template` filter.[^12]
- Enqueues Font Awesome only when the Tag Hub template is used, to avoid global bloat.[^12]
- Overrides `the_content` at a very late priority (999) only for the Tag Hub template, leaving other templates intact.[^12]

UI & UX:
- Hero section with tag icon, animated headline, and stats of total tags and cumulative post counts.[^12]
- Live filter input that filters tags client‑side using `data-tag-name` attributes; includes a clear button and “no results” message.[^12]
- Tag cards grid sorted by usage count, each with:
  - Color accent (cycled from a predefined palette).
  - Header showing tag name and post count, with a quick “view all posts” link.[^12]
  - List of up to 5 recent posts for each tag.[^12]
  - Footer button linking to the tag archive.

This is very useful for a knowledge‑heavy service site (SEO agency, SaaS, etc.) where tags correspond to topics or service verticals.


### 3.6 Custom 404 content hub

`Beautiful-404-Page-Hub.php` replaces the default Jannah 404 page with a rich “content hub” experience.[^13]

Behavior:
- Uses the `404_template` filter to override the template and output a custom layout while still calling `get_header()` and `get_footer()` so the theme chrome is preserved.[^13]
- Displays a hero with animated “404” digits and search form, followed by a multi‑section content hub.[^13]

Sections:
- Popular posts – `WP_Query` sorted by a `post_views_count` meta key (or fallback query) displayed in a responsive grid.[^13]
- Latest posts – alternate query if no popular posts are found.[^13]
- Top categories – category cloud with counts.[^13]
- Tag cloud – tags list.[^13]
- Quick links – home, sitemap, contact, and about page shortcuts.[^13]

Styling:
- Gradients, animations, and responsive grids built with pure CSS appended via inline `<style>` when the 404 page is used.[^13]

This turns 404 into a discovery point rather than a dead‑end.


### 3.7 SEO URL cleanup

`Clean-Tracking-Parameter-URLs-for-SEO.php` is a comprehensive tracking parameter cleanup engine.[^14]

Key capabilities:
- Maintains a centralized list of tracking params (GA/GAds, Meta, Bing, email tools, affiliates, misc and spam query parameters).[^14]
- Filters canonical URLs for major SEO plugins (Yoast, RankMath, AIOSEO) and core via `wpseo_canonical`, `rank_math/frontend/canonical`, and `aioseop_canonical_url`, stripping tracking parameters.[^14]
- Cleans all internal link generators: `the_permalink`, `post_link`, `page_link`, taxonomy links, attachment links, author links, and date archives.[^14]
- Cleans REST API URLs and multiple sitemap providers’ entries (core, Yoast, RankMath) via dedicated filters.[^14]
- Filters `wp_redirect` destinations to strip tracking params for same‑host redirects.[^14]
- Adds a meta robots `noindex,nofollow` when the request contains any known tracking params, to avoid indexed variant URLs.[^14]
- Recursively cleans URLs in structured data graphs for Yoast and RankMath schemas.[^14]

This creates a theme‑agnostic but Jannah‑compatible layer to ensure canonical, internal links, sitemaps, and schema all point to clean URLs.


## 4. How these pieces align with Jannah’s native capabilities

### 4.1 Layout model

- Jannah uses templates + Page Builder sections + blocks.[^6]
- Your stack uses:
  - Theme‑level templates (404, Tag Hub, Sitemap, custom About/Contact templates in other files).
  - Content filters (`the_content` for ToC, polls, sitemap).
  - Utility CSS classes for service layouts.

These are compatible because they either:
- Override templates through official filters (`404_template`, `page_template`).[^12][^13]
- Attach before/after content without changing the loop.[^9][^11][^10]


### 4.2 Design & theming

- Jannah’s Styling Settings panel drives primary colors, dark skins, and body/link styles.[^7]
- Your CSS defines `--tez-primary`, `--tez-bg`, `--tez-text`, and others; dark/sepia modes override these variables.[^2]

By aligning Jannah’s primary color to `#2563eb` (or your chosen `--tez-primary`) and keeping global typography consistent (Vazirmatn/system UI), both systems feel like one design language.[^7][^2]


### 4.3 Micro components (shortcodes vs modules)

- Jannah shortcodes are ideal for simple components (buttons, columns, boxes, quotes, content index).[^3]
- Your modules cover advanced patterns (interactive ToC, polls, visual sitemap, tag hub, 404 hub) which are not easily expressed as shortcodes alone.[^13][^12][^11][^10][^9]

Strategy:
- Use Jannah shortcodes inside your `.tez-*` layouts where appropriate (e.g. Jannah buttons in `.tez-cta-buttons`).[^3][^2]
- Keep complex interactive systems as dedicated modules that hook into `the_content` or templates.


## 5. End‑to‑end implementation plan

### 5.1 Consolidation and architecture

1. **Create an `/inc` directory in `jannah-child`** and move each module file there: ToC, Polls, 404 Hub, Tag Hub, Visual Sitemap, URL Cleanup, About Page Template, Contact Page Template, Core Functions, etc.[^14][^12][^13][^11][^10][^9]
2. **In `functions.php` of the child theme**, require the modules in a deterministic order:
   - Core setup utilities.
   - SEO URL cleanup.
   - Page templates (404, sitemap, tag hub, about, contact, etc.).
   - Content filters (ToC, polls).
3. **Disable equivalent WPCode snippets** to avoid duplicate hooks and DB operations.
4. **Enqueue CSS**:
   - Keep `style.css` minimal; from it, import `Complete-Page-Templates-CSS.css` with `@import` or better, enqueue a second stylesheet handle from `functions.php` (`wp_enqueue_style( 'tez-pages', get_stylesheet_directory_uri() . '/Complete-Page-Templates-CSS.css', [], '2.1.0' );`).[^2]


### 5.2 Page templates and routing

1. **404 Content Hub**:
   - Confirm `Beautiful-404-Page-Hub.php` is hooked via `add_filter( '404_template', 'jannah_custom_404_template' );` inside the child theme’s load sequence.[^13]
   - Test 404 URLs to ensure the hub uses Jannah’s header/footer and that search and quick links work.

2. **Visual Sitemap**:
   - Create a `sitemap` page in WordPress; the module already checks `is_page( 'sitemap' )` and injects the custom sitemap layout via `the_content` filter.[^11]
   - Optionally add a link to this page in Jannah’s menus and 404 quick links.

3. **Tag Hub Template**:
   - Ensure `Beautiful-Tag-Hub-Page.php` is loaded so the `theme_page_templates` and `page_template` filters register the “Tag Hub” template.[^12]
   - Create a page, select “Tag Hub” as its template, and publish.
   - Hook this into navigation and/or footer for “Topics” or “Knowledge Hub”.

4. **About, Contact, and Other Custom Templates**:
   - Use the same pattern as Tag Hub: register templates via `theme_page_templates` and `page_template`, then override `the_content` or load separate template files under `jannah-child/templates/` as needed.[^15][^16]
   - Map these to URLs you already referenced (e.g. `/about`, `/contact`) to align with 404 quick links and CTAs.[^13]


### 5.3 Service‑oriented layouts using existing CSS

1. **Service Detail Pages**:
   - For each core service, create a standard page and use Jannah’s full‑width template.
   - In the content editor, compose the structure using HTML + Gutenberg blocks that apply your classes:
     - Wrap the main area in `.tez-service-detail` with `.tez-service-icon`, `.tez-service-content`, `.tez-service-desc`, `.tez-service-features`, and `.tez-service-footer`.[^2]
   - Optionally include Jannah shortcodes for lists, buttons, and boxes inside these sections.

2. **Pricing Page**:
   - Create a “Pricing” page.
   - Use `.tez-intro-box` + `.tez-pricing-grid` and `.tez-pricing-card` to lay out packages; within each card, use Jannah button shortcode for “Get Quote” or “Book Call”.[^3][^2]

3. **Contact / Inquiry Pages**:
   - Create a “Contact” page that uses `.tez-contact-grid`, `.tez-contact-card`, `.tez-address-box`, and `.tez-social-links` for contact info; embed your form plugin shortcode inside `.tez-form-card` for the contact form.[^2]
   - Create an “Inquiry” or “Start a Project” page that uses `.tez-inquiry-intro`, `.tez-inquiry-grid`, and `.tez-sidebar-card` for sales messaging and fast contact channels.[^2]

4. **About / FAQ / Resources**:
   - Use `.tez-about-grid`, mission and values grids, and team sections to build a narrative about the business.[^2]
   - Build a FAQ page using `.tez-faq-layout` and `.tez-faq-item` markup; your CSS already defines the accordion behavior.[^2]


### 5.4 Enhancing content with ToC and polls

1. **ToC Defaults**:
   - Decide global defaults: e.g. ToC enabled `auto`, position `afterfirstp`, style `sidebar` for long guides.[^9]
   - For cornerstone posts, override settings in the meta box for `manual` position when you want a sticky sidebar ToC only, or change style to `gradient` for hero‑like ToCs.[^9]

2. **Polls as Micro‑Surveys**:
   - For select posts or pages, enable the poll meta box and configure simple questions like “What’s your biggest SEO challenge?” with multiple choice.[^10]
   - Choose style `minimal` when embedding in dense content, or `gradient`/`glass` for standalone survey blocks on landing pages.[^10]
   - Use auto‑insert positions (before last paragraph) to keep polls from derailing the main reading flow.[^10]

3. **Performance & Conflicts**:
   - Ensure fonts (Font Awesome) are not over‑enqueued: ToC, Polls, Tag Hub, and Sitemap all conditionally enqueue FA only on singulars or template pages; verify handles don’t conflict.[^12][^11][^9][^10]


### 5.5 SEO and URL hygiene

1. **Activate the URL Cleanup module early** in the child theme load order, so it has priority in filters compared with SEO plugins.[^14]
2. **Verify canonical tags**:
   - Check pages with UTM parameters to ensure canonicals and redirects strip parameters and show clean URLs.[^14]
3. **Check sitemaps and schema** from Yoast/RankMath (if used) to confirm URLs are de‑parameterized.[^14]
4. **Monitor Search Console** to ensure parameter‑driven duplicate URLs drop out over time.


### 5.6 Jannah theme options alignment

1. **Styling Settings**:
   - Set primary color ≈ your `--tez-primary` and adjust body/link colors to harmonize with `--tez-text` and `--tez-text-muted`.[^7][^2]
   - Optionally enable dark skin at the theme level if you want a predominantly dark UI and align your `data-theme="dark"` CSS to match.[^7][^2]

2. **Blocks Settings**:
   - Choose an appropriate block head style that complements `.tez-section-header` appearances.[^8][^2]
   - Globally disable author/comments/views meta where blocks are used for case studies or services rather than blog posts.[^8]

3. **Page Builder Usage**:
   - For the homepage, use Page Builder sections + Custom Content Blocks; inside those blocks place `.tez-*` structures and Jannah shortcodes.[^6][^5][^2]
   - Avoid using Page Builder for every single page; for simple service pages, regular templates with your CSS are faster and simpler.


### 5.7 Performance and maintainability

1. **Keep JS lean**:
   - Let modules output their own inline JS; only add cross‑cutting behavior (e.g. scroll animations toggling `.scroll-animate`) into `scripts.js` if necessary.[^9][^10][^2]
2. **Avoid duplicate features**:
   - Do not install separate ToC or poll plugins; your modules already cover these with better design integration.
3. **Use a staging environment**:
   - Test Jannah updates against the child theme, especially pages using custom templates (404, sitemap, Tag Hub) and heavy `the_content` filters.[^17][^12][^11][^13][^10][^9]


## 6. What you can now build without external builders

With Jannah + your child theme, you can build:
- A fully branded **service provider homepage** using Page Builder sections, Custom Content Blocks, `.tez-*` hero/services/pricing/CTA components, and Jannah shortcodes.[^6][^5][^2]
- Deep **service pages** with advanced ToCs and inline polls for audience research.[^10][^9][^2]
- A rich **knowledge hub**: Tag Hub template + visual sitemap + category/tag hubs powered by Jannah blocks and your layouts.[^18][^12][^11]
- A polished **404 experience** that recirculates visitors into popular content and key landing pages.[^13]
- SEO‑clean URLs and metadata across Jannah’s entire front‑end, independent of SEO plugin quirks.[^14]

All while keeping everything inside the Jannah ecosystem (theme + official child) and your own child‑theme code, with no dependency on Elementor, WPBakery, or generic snippet managers.

---

## References

1. [Jannah Child Theme](https://jannah.helpscoutdocs.com/article/196-jannah-child-theme) - Once the file has been uploaded, to activate Jannah Child theme go to WordPress Dashboard > Appearan...

2. [Complete-Page-Templates-CSS.css](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/4ff21d88-55ed-4c48-829f-ef4573efad4a/Complete-Page-Templates-CSS.css?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=%2FGM5uQlBopDoUfcHf%2FgoEDCOE9I%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670) - Teznevisan Page Templates CSS Version 2.1.0 Complete styling for all custom page templates

3. [Shortcodes - Jannah Docs](https://jannah.helpscoutdocs.com/article/128-shortcodes) - Enable Jannah shortcodes. To let the shortcodes to be in action, you should install Jannah Extension...

4. [Jump to post content (Content Index Shortcode) - Jannah Docs](https://jannah.helpscoutdocs.com/article/151-content-index-shortcode) - The content index list has its responsive view, so it's suitable for all screens sizes. The Content ...

5. [Custom Content Blocks - Jannah Docs](https://jannah.helpscoutdocs.com/article/127-custom-content-blocks) - We offer a two custom content blocks to do what you imagine. Most of our News blocks are predefined ...

6. [Page Builder - Jannah Docs](https://jannah.helpscoutdocs.com/article/62-page-builder) - Click on the Add Block button, the block window with appear as the following: You can choose your bl...

7. [Styling Settings - Jannah Docs](https://jannah.helpscoutdocs.com/article/77-styling-settings) - 1. Styling Settings 2. Custom Body Classes Add a custom class or more (by separating theme with spac...

8. [Blocks Settings - Jannah Docs](https://jannah.helpscoutdocs.com/article/179-blocks-settings) - You can control the blocks head for all theme blocks from here. It's one of the most amazing incredi...

9. [Beautiful-Table-of-Contents-ToC.php](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/d0b9dec2-8c1a-4dc3-8319-5c77ffa0a156/Beautiful-Table-of-Contents-ToC.php?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=Spf0yrZps2UrTT3i0UMPLu%2B81ig%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670) - Teznevisan Table of Contents Generator Version 2.0.0 Features Auto-generate from H2-H4, DarkSepia Mo...

10. [Complete-Poll-System.php](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/6bf8ef95-2d38-4d28-912d-34043c2800f0/Complete-Poll-System.php?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=sR2qi3NRMdJO7agAidQriAo7Frw%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670) - Teznevisan Advanced Poll System Version 2.0.0 Features IP-Voting, DarkSepia Mode, RTL, Animations, A...

11. [Beautiful-Visual-Sitemap-Page.php](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/e9c73add-97e7-4ba5-abf4-bb177187844e/Beautiful-Visual-Sitemap-Page.php?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=2RSKuEgCuNIy0GnTUxS%2FSMJrYeg%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670)

12. [Beautiful-Tag-Hub-Page.php](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/8b2b9fc9-1ccf-475e-995d-bbb33b16179d/Beautiful-Tag-Hub-Page.php?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=%2FhtvUK3k0%2BLvyGiEUm0eOKZRi9I%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670) - Tag Hub Page Template Creates a custom page template for displaying all tags Select Tag Hub from pag...

13. [Beautiful-404-Page-Hub.php](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/f528c810-3fb0-4552-a794-8b7294d9bbbc/Beautiful-404-Page-Hub.php?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=e1QhiwkO4dxV4hW1T4nEYbdX9WI%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670)

14. [Clean-Tracking-Parameter-URLs-for-SEO.php](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/2923e2fb-7a66-456a-8cf4-4f35bb9ec6d0/Clean-Tracking-Parameter-URLs-for-SEO.php?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=Afkag44a5U4fHML0ubknVa3Ec4o%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670) - SEO URL Cleanup - Clean Canonicals Internal Links Features - Clean canonical tags removes tracking p...

15. [About-Page-Template.php](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/0325a189-014f-4129-9bc1-43ded0cdaa7d/About-Page-Template.php?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=aYafbOYVlznoKmW9Nw4B%2BQOu3U8%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670)

16. [Contact-Page-Template.php](https://ppl-ai-file-upload.s3.amazonaws.com/web/direct-files/attachments/101575983/83e4b9c8-7e3f-4b9a-9620-06114fc5051d/Contact-Page-Template.php?AWSAccessKeyId=ASIA2F3EMEYEZL2AVNIX&Signature=J6Bv3XILWGDQK10lHNemVpoVYr8%3D&x-amz-security-token=IQoJb3JpZ2luX2VjEOX%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEaCXVzLWVhc3QtMSJGMEQCIBcfzk231ekuMmGpvB%2BEC8jq6Qjv%2B6%2Fr%2Ba0yJ1A4%2BveHAiA5qnoC7QiaBdYNIVRUW45TyHvxSzCNFl2yapX1s%2Fr6Rir8BAit%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F8BEAEaDDY5OTc1MzMwOTcwNSIM50L1Dd83Hsh9fu4GKtAEskZJgU9wkDcSHhI9VsyrYKZVGBnly2S4IY1Gy7ETTOhtrKf4vVP60icqdsB5wbyh4QEdLjWk0M2YprxiTkHKFPhJDlq2jUNACDGE6XxZ9nlbZ0WUa7yn4By55Y3jovVdVPmlHEIkX4qlU3oztcNt%2FQDpqXFTWCieSKBWLd%2Fm4XAn1jo8a7QeTYe7C1PDdO323qrPejZonk066CP76EDMN9xyFZh%2FoNTy84%2BlvN47VlBkyB1SEiIanbh0Yy0MADuWLMSI1%2BjD2qWAw2YSeHA37GiiY6MJM7DuJL9vzinFaNyVsUIswEcpQ5nlGMtLk9EQXvI6apu%2FiczpGNzq%2BG%2FlKzZ2Xhk5dIsfzZK9YN4ju1KCibWV3cSKWuMw4VNPyS%2FVKmyyNQXw0m1lYmvxPqsDJQGSChkX8cnkrMhKUrV4BE9QEmmy%2FVXroK9Hxwit%2B4bESRa%2By3%2FF5oA7NyAcbf7QsGZHV7DZoLTqKyVSubcqUUFKaox4j1QWpMdPK3%2FJjk3DFcFCBSussCbgvSU9RAM9D5%2B1Qc6LY6Hl8NsG9n8%2ByxAFAnf04C7MJRB24VEWa9oV3QSUr3cWDQPgcyyBIN6Ql6wpLIvPrNH7nFq7fH9A6zP8abTdv218mv6zgYC6Tgig7VPP5crcgD1IAlKyDZpicdqib1M4oGYxN%2FgAsbdwfZVQ7dFgD4M61sP2l7TStTrBwTpZNXGsyuo5CIZeDjKU3D%2BAAUx7JyE2qUffiWE5qXbyG80xwkmVbQkUh2heHbAinWwVeis0ZKd9w9d3yI8uwTC1v%2BbMBjqZAXS88DPuaIZYEKwheAdL%2FZcVCCPCr8CP0YMVMtQcGbH9zKIZVsPxuBTtmajy8jCznOkLXitSnqOiLnn6d6Lb%2FrnG%2Fk%2FuX4vkMyQx%2F2gkt2WlumLbkW2DpvB7mRSXt%2FmXH9x7quwsZtE7nvdioNwsOMphebMyYC0GM5omEYBdqDWJ68PWVvcax6V5ImaUlNG4yhuOxhh7vBagqw%3D%3D&Expires=1771680670)

17. [Troubleshooting - Jannah Docs](https://jannah.helpscoutdocs.com/category/10-troubleshooting) - Frequently asked questions and support documentation for Jannah Theme. ... Theme is missing the styl...

18. [News Blocks - Jannah Docs](https://jannah.helpscoutdocs.com/article/122-news-blocks) - Jannah comes with a big variety of news blocks and sliders, our User Experience designers focus on t...

