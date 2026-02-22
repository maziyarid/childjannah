# Comprehensive SEO Recovery Master Plan

## Jannah Architecture
- **Overview of the Jannah Theme Architecture**: Describe the overall structure and components of Jannah, focusing on how it integrates with WordPress.
- **Key Components**: Detail the significant components such as templates, widgets, and settings that are crucial for implementation.
- **Customization Options**: Provide insights into how themes can be tailored to fit specific needs.

## Capabilities
- **Performance Features**: Discuss the features that enhance site performance, including caching, minimal scripts, and optimized images.
- **SEO Features**: Highlight built-in SEO functionalities like schema markup, meta tags, and social media integration.
- **User Experience Enhancements**: Describe user-centric capabilities like responsive design, accessibility, and navigation.

## SEO Recovery Checklist
1. **Technical SEO Checks**: Verify robots.txt, sitemap.xml, and URL structure.
2. **On-Page SEO Audit**: Ensure correct use of title tags, headers, and keyword placement.
3. **Content Evaluation**: Assess content quality, duplication, and relevance.
4. **Link Audit**: Examine internal and external link profiles for issues.
5. **Performance Assessment**: Test site speed and mobile responsiveness.

## Jannah Customization Roadmap
- **Phase 1: Initial Setup**: Installing the Jannah theme and plugins.
- **Phase 2: Basic Customization**: Adjusting visual elements and layout.
- **Phase 3: Advanced Features**: Implementing custom widgets and shortcuts.
- **Phase 4: Testing and Launch**: Comprehensive testing and finalizing before launch.

## Implementation Checklist
- [ ] Choose a hosting provider and set up the domain.
- [ ] Install WordPress and the Jannah theme.
- [ ] Configure essential plugins.
- [ ] Populate the site with initial content.
- [ ] Conduct a complete backup before launching.

## Action Plan
1. **Define SEO Objectives**: Set clear goals based on current metrics.
2. **Conduct Competitor Analysis**: Identify strengths and weaknesses.
3. **Create a Content Strategy**: Outline content creation and optimization plans.
4. **Monitor Analytics**: Track progress via Google Analytics and other tools.

## Issue Tracking
- **Bug & Issue Log**: Maintain a log that records all encountered issues with resolutions.
- **Status Updates**: Regular updates on progress and ongoing issues must be shared with the team.

## Resources
- **Useful Tools**: Link to resources like Google Search Console, SEMrush, etc.
- **Documentation**: Access to Jannah theme documentation and WordPress guidelines.
- **Community Forums**: Links to relevant forums for additional support.

## Deployment Instructions
- **Pre-launch Checklist**: Ensure all elements are functional before going live.
- **Live Deployment**: Detailed steps to transition from staging to live environments.
- **Post-launch Monitoring**: Immediate checks after launch for errors.

## Maintenance
- **Regular Updates**: Schedule for theme and plugin updates.
- **Backup Procedures**: Steps to ensure site backups are conducted regularly.
- **Performance Monitoring**: Tools and techniques to continuously monitor performance.

## Troubleshooting
- **Common Issues & Fixes**: List of typical problems encountered and solutions.
- **Support Channels**: Contact information for theme support and community help.

## Final Summary
- Recap key takeaways and action items.
- Importance of continual learning and adaptation to SEO best practices.
- Encourage feedback and collaboration within the team for ongoing improvements.


Based on my analysis of the `maziyarid/childjannah` repository, I can see that you have created a foundational structure with empty directories (`Analyses`, `Audit Data`, `Snippets`) alongside the base Jannah child theme files. Let me create a **comprehensive master document** that consolidates everything we've discussed—all issues, checklists, roadmap, and action plan with nothing missing.

```markdown name="COMPREHENSIVE_SEO_RECOVERY_MASTER_PLAN.md
# 🎯 Comprehensive SEO Recovery & Jannah Child Theme Customization Master Plan
## teznevisan3.com + maziyarid/childjannah

**Repository:** [maziyarid/childjannah](https://github.com/maziyarid/childjannah)  
**Current Date:** 2026-02-21  
**Current User:** maziyarid  
**Project Status:** Phase 1 - Planning & Architecture  

---

## 📋 EXECUTIVE SUMMARY

This document provides a **complete, zero-miss roadmap** for:

1. **SEO Recovery** of teznevisan3.com (spam cleanup, redirects, canonical tags, backlinks)
2. **Jannah Theme Customization** (service provider business transformation)
3. **Child Theme Architecture** (modular, maintainable, scalable)
4. **Advanced Features** (ToC, Polls, Visual Sitemap, Tag Hub, 404 Hub, URL Cleanup)
5. **Performance & Security** hardening
6. **Implementation Timeline** with clear phases and milestones

---

# PART 1: JANNAH CHILD THEME ARCHITECTURE & CAPABILITY MAPPING

## 1.1 Current Repository Structure

```
maziyarid/childjannah/
├── README.md                    # Base documentation
├── functions.php                # Child theme functions (needs expansion)
├── style.css                    # Child theme styles (needs custom CSS)
├── screenshot.jpg               # Theme screenshot
├── js/                          # JavaScript directory (empty)
├── Analyses/                    # [EMPTY - TO BE POPULATED]
├── Audit Data/                  # [EMPTY - TO BE POPULATED]
└── Snippets/                    # [EMPTY - TO BE POPULATED]
```

## 1.2 Target Architecture (Post-Implementation)

```
maziyarid/childjannah/
├── README.md
├── functions.php                # Enhanced with all modules
├── style.css                    # Theme header + imports
│
├── inc/                         # [NEW] Internal modules directory
│   ├── seo-spam-cleanup.php
│   ├── seo-technical-fixes.php
│   ├── seo-on-page.php
│   ├── seo-backlink-manager.php
│   ├── table-of-contents-toc.php
│   ├── poll-system.php
│   ├── visual-sitemap.php
│   ├── tag-hub-template.php
│   ├── 404-hub.php
│   ├── about-page-template.php
│   └── contact-page-template.php
│
├── css/                         # [NEW] Stylesheets
│   ├── style.css                # Main theme styles
│   ├── page-templates.css       # Service/business layouts
│   ├── toc-styles.css
│   ├── poll-styles.css
│   └── responsive.css
│
├── js/                          # JavaScript
│   ├── scripts.js               # Main theme script
│   ├── toc-logic.js
│   ├── poll-interaction.js
│   └── theme-utilities.js
│
├── templates/                   # [NEW] Template overrides
│   ├── 404.php                  # Custom 404 template
│   ├── page-about.php
│   ├── page-contact.php
│   ├── page-sitemap.php
│   └── page-services.php
│
├── assets/                      # [NEW] Images, icons, fonts
│   ├── images/
│   ├── icons/
│   └── fonts/
│
├── .htaccess                    # [NEW] Apache rewrite rules
├── robots.txt                   # [NEW] SEO robots configuration
│
├── Analyses/                    # Documentation & Analysis
│   ├── SEO-Audit-Report.md
│   ├── Backlink-Analysis.md
│   ├── Competitor-Analysis.md
│   ├── Keyword-Research.md
│   └── Technical-SEO-Audit.md
│
├── Audit Data/                  # Raw audit data
│   ├── backlinks-export.csv
│   ├── crawl-errors.json
│   ├── 404-urls.txt
│   ├── redirect-chains.txt
│   └── spam-urls-identified.txt
│
└── Snippets/                    # Code snippets & examples
    ├── htaccess-rules.txt
    ├── functions-examples.php
    ├── wpcli-commands.txt
    └── api-integration-examples.php
```

---

# PART 2: JANNAH NATIVE CAPABILITIES INVENTORY

## 2.1 Built-In Shortcodes (Jannah Extensions Required)

| Shortcode | Purpose | Use Case | Child Theme Integration |
|-----------|---------|----------|------------------------|
| `[tie_box]` | Content boxes (shadow, info, success, warning, error, note) | Feature highlights, alerts | Service pages, FAQ |
| `[tie_button]` | CTA buttons (size, color, icon, target) | Call-to-action | Landing pages, contact |
| `[tie_tabs]` | Horizontal/vertical tabs | Service details, features | Pricing, packages |
| `[tie_toggle]` | Accordion toggles | FAQ, collapsible content | FAQ page, resources |
| `[tie_slide]` | Content slideshow | Portfolio, testimonials | Case studies |
| `[tie_author]` | Author bio box | Team bios | About page |
| `[tie_flickr]` | Flickr photo gallery | Portfolio display | Services, case studies |
| `[tie_rss]` | RSS feed display | Blog integration | Knowledge hub |
| `[tie_tooltip]` | Hover tooltips | Term definitions | Service details |
| `[tie_share]` | Social sharing buttons | Content sharing | Blog posts, resources |
| `[tie_dropcap]` | Drop-cap styling | Article styling | Long-form content |
| `[tie_tags]` | Tag cloud | Navigation | Sidebar, footer |
| `[tie_highlight]` | Text highlighting | Emphasis | Key points |
| `[tie_padding]` | Content padding | Spacing | Layout control |
| `[tie_divider]` | Horizontal divider | Visual separation | Section breaks |
| `[tie_list]` | Styled lists | Feature lists | Benefits, steps |
| `[tie_restricted]` | Restrict content | Member-only | Login walls |
| `[tie_columns]` | Multi-column layout | Two/three column | Service specs |
| `[tie_gmaps]` | Google Maps embed | Location display | Contact page |
| `[tie_video]` | Video embed | Media content | Service explainers |
| `[tie_audio]` | Audio embed | Podcasts, audio | Media library |
| `[tie_lightbox]` | Image/video lightbox | Gallery lightbox | Portfolio |
| `[tie_quote]` | Styled quotes | Testimonials | Social proof |
| `[tie_login]` | Front-end login form | User authentication | Member area |
| `[tie_fullimg]` | Full-width image | Hero images | Landing pages |
| `[tie_content_index]` | Table of Contents | Article navigation | Long-form content |

## 2.2 Page Builder Features

| Feature | Capability | Service Provider Adaptation |
|---------|-----------|----------------------------|
| Sections | Unlimited full-width/boxed sections | Service sections, features, pricing |
| Backgrounds | Color, image, video (with parallax) | Hero sections, CTAs |
| Overlays | Dark/light overlays, gradients | Text contrast over images |
| Dark Skin | Toggle dark mode per section | Brand consistency |
| Sidebars | None/left/right, sticky options | Sidebar for testimonials/CTAs |
| Custom Blocks | HTML + shortcode container | Service cards, pricing cards |
| News Blocks | Post/category/tag/product display | Case studies, services, testimonials |
| Sliders | News blocks as sliders | Feature carousel |
| Responsive Grid | Mobile/tablet/desktop layouts | Adaptive design |

## 2.3 Styling & Design Settings

| Setting | Control | Integration |
|---------|---------|-------------|
| Primary Color | Theme-wide color scheme | Align with brand colors |
| Skin Presets | 15+ predefined color skins | Choose corporate look |
| Body Styling | Links, hover, selection, borders | Consistency |
| Dark Mode | Global dark skin toggle | Accessibility, branding |
| Typography | Font family, size, weight | Brand typography |
| Custom Classes | Body-level CSS classes | Advanced styling |

---

# PART 3: CUSTOM MODULE CAPABILITIES

## 3.1 Table of Contents (ToC) Module

**Purpose:** Advanced article navigation with auto-generated heading anchors

**Features:**
- ✅ Per-post meta box (enable/disable, position, style, heading levels)
- ✅ Automatic heading ID generation (regex-safe, deterministic)
- ✅ 5 display styles: modern, minimal, boxed, gradient, sidebar
- ✅ Sticky or inline positioning
- ✅ Collapsed by default option
- ✅ Numbered/unnumbered options
- ✅ Active heading highlight (IntersectionObserver)
- ✅ Smooth scrolling with keyboard navigation
- ✅ RTL support
- ✅ Dark/sepia theme support
- ✅ Accessibility: ARIA labels, focus states, reduced motion

**Use Cases:**
- Long-form service guides
- Case study breakdowns
- Knowledge base articles
- Resource documentation

**Child Theme Integration:**
- File: `inc/table-of-contents-toc.php`
- Styles: `css/toc-styles.css`
- JS: `js/toc-logic.js`

---

## 3.2 Poll System Module

**Purpose:** Interactive polling with vote tracking and analytics

**Features:**
- ✅ Custom database table for vote storage
- ✅ Per-post meta box (enable/disable, question, type, position, style)
- ✅ Poll types: single-choice, multiple-choice
- ✅ 4 display styles: modern, minimal, gradient, glass
- ✅ AJAX voting with IP-based spam prevention
- ✅ Real-time vote count updates
- ✅ Auto-switch to results view after voting
- ✅ Colorized options with custom colors per option
- ✅ Vote analytics dashboard (optional)
- ✅ Dark/sepia theme support
- ✅ RTL support
- ✅ Accessibility: keyboard navigation, screen reader support

**Use Cases:**
- Pre-consultation qualification quizzes
- Opinion polls in blog content
- Customer preference surveys
- Lead qualification micro-surveys
- Market research

**Child Theme Integration:**
- File: `inc/poll-system.php`
- Styles: `css/poll-styles.css`
- JS: `js/poll-interaction.js`
- Database: `wp_tez_polls` custom table

---

## 3.3 Visual Sitemap Page

**Purpose:** Dynamic, user-friendly sitemap page replacing XML-only approach

**Features:**
- ✅ Auto-generated at `/sitemap/` page slug
- ✅ Pages list section
- ✅ Recent posts section
- ✅ Category cards with accent colors
- ✅ Tag cloud with responsive sizing
- ✅ Monthly archives
- ✅ Author grid
- ✅ Integrated search box
- ✅ Hero section with icon and stats
- ✅ Responsive card grid layout
- ✅ Hover animations and transitions
- ✅ Dark/sepia theme support
- ✅ Print-optimized styles

**Use Cases:**
- UX-focused site navigation
- SEO-beneficial sitemap replacement
- Internal link recirculation
- User discovery of all content

**Child Theme Integration:**
- File: `inc/visual-sitemap.php`
- Styles: `css/page-templates.css` (included)

---

## 3.4 Tag Hub Page Template

**Purpose:** Rich, interactive tag directory page

**Features:**
- ✅ Custom page template: "Tag Hub"
- ✅ Hero section with tag icon and stats
- ✅ Live client-side tag filtering
- ✅ Tag cards sorted by usage count
- ✅ Color-coded tag cards (cycled palette)
- ✅ Recent posts preview per tag (up to 5)
- ✅ Quick "view all posts" link per tag
- ✅ Tag archive button per card
- ✅ Responsive grid layout
- ✅ Conditional Font Awesome loading
- ✅ Dark/sepia theme support
- ✅ RTL support

**Use Cases:**
- Knowledge hub for SEO agencies
- SaaS documentation portal
- Topic-based service directories
- Content discovery

**Child Theme Integration:**
- File: `inc/tag-hub-template.php`
- Template: `templates/page-tag-hub.php`
- Styles: `css/page-templates.css`

---

## 3.5 Custom 404 Content Hub

**Purpose:** Transform 404 errors into content discovery opportunity

**Features:**
- ✅ Custom 404 template override
- ✅ Animated "404" hero section
- ✅ Integrated search form
- ✅ Popular posts section (by views)
- ✅ Latest posts fallback section
- ✅ Top categories cloud
- ✅ Tag cloud
- ✅ Quick navigation links (home, sitemap, contact, about)
- ✅ Inline CSS animations
- ✅ Responsive grid layout
- ✅ Dark/sepia theme support
- ✅ Jannah header/footer preserved

**Use Cases:**
- Error recovery and recirculation
- Content discovery on failed URLs
- Lead capture alternative
- Site navigation backup

**Child Theme Integration:**
- File: `inc/404-hub.php`
- Template: `templates/404.php`
- Styles: Inline CSS + `css/page-templates.css`

---

## 3.6 SEO URL Cleanup Module

**Purpose:** Comprehensive tracking parameter removal and URL canonicalization

**Features:**
- ✅ Centralized tracking parameter blocklist (GA, Meta, Bing, email, affiliate, spam)
- ✅ Canonical URL filtering for Yoast, RankMath, AIOSEO
- ✅ Internal link cleaning (all taxonomy/author/date archives)
- ✅ REST API URL cleaning
- ✅ Sitemap URL cleaning (core, Yoast, RankMath)
- ✅ Redirect destination cleaning (301/302)
- ✅ Noindex meta tag for parameterized URLs
- ✅ Recursive JSON-LD schema cleaning
- ✅ Whitelist option for safe parameters
- ✅ Debug logging for troubleshooting

**Use Cases:**
- Campaign tracking cleanup
- Duplicate URL prevention
- SEO plugin compatibility
- Schema.org data hygiene

**Child Theme Integration:**
- File: `inc/seo-url-cleanup.php`
- No CSS/JS required
- Database-agnostic (filters only)

---

## 3.7 About Page Template

**Purpose:** Agency/service provider about page

**Features:**
- ✅ Custom page template option
- ✅ Mission statement section
- ✅ Values grid
- ✅ Team member cards
- ✅ Company stats/achievements
- ✅ Timeline or history section
- ✅ Call-to-action section
- ✅ Responsive layout
- ✅ Dark/sepia theme support

**Child Theme Integration:**
- File: `inc/about-page-template.php`
- Template: `templates/page-about.php`
- Styles: `css/page-templates.css`

---

## 3.8 Contact Page Template

**Purpose:** High-conversion contact/inquiry page

**Features:**
- ✅ Contact information section (address, phone, email, hours)
- ✅ Contact form integration area
- ✅ Multiple contact methods (phone, email, form, social)
- ✅ Map integration section
- ✅ Quick contact cards
- ✅ Sidebar testimonials/trust signals
- ✅ CTA footer
- ✅ Responsive two-column layout
- ✅ Dark/sepia theme support

**Child Theme Integration:**
- File: `inc/contact-page-template.php`
- Template: `templates/page-contact.php`
- Styles: `css/page-templates.css`

---

# PART 4: SEO RECOVERY CHECKLIST

## 4.1 Phase 1: Immediate Actions (Week 1)

### Spam URL Cleanup
- [ ] **Identify all spam files on server**
  - [ ] Scan for `shop.php`, `article.php`, other PHP files with suspicious names
  - [ ] List files in `.htaccess` blocked patterns
  - [ ] Check `/wp-admin/` access logs for injected files
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Delete spam files physically**
  - [ ] SSH access to server and remove files
  - [ ] Verify deletion with `file_exists()` checks
  - [ ] Back up deleted file names for audit trail
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Implement .htaccess blocking rules**
  - [ ] Add 410 Gone responses for known spam patterns
  - [ ] Test with `curl -I` for each pattern
  - [ ] Verify no legitimate URLs blocked
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

### Technical Foundation
- [ ] **Create `.htaccess` file**
  - [ ] Copy template from `Snippets/.htaccess`
  - [ ] Customize domain, paths, redirects
  - [ ] Test all rules on staging
  - [ ] Deploy to production with backup
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Create `robots.txt`**
  - [ ] Allow CSS/JS/media files for rendering
  - [ ] Block spam patterns
  - [ ] Add sitemap URL
  - [ ] Test with Google Search Console
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Fix 404 handling**
  - [ ] Deploy custom 404 hub via child theme
  - [ ] Test all 404 URLs redirect properly
  - [ ] Verify internal links work
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

## 4.2 Phase 2: URL Hygiene (Week 2)

### Canonical Tags & Redirects
- [ ] **Implement canonical tag function**
  - [ ] Add to `inc/seo-technical-fixes.php`
  - [ ] Test on posts, pages, archives, home
  - [ ] Verify no duplicate canonical tags
  - [ ] Check via page source on 10+ pages
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Fix 301 redirect chains**
  - [ ] Audit all redirects with [httpstatus.io](https://httpstatus.io)
  - [ ] Consolidate multi-hop redirects
  - [ ] Update `.htaccess` with one-step rules
  - [ ] Test 50+ URLs for proper response codes
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Clean URLs of tracking parameters**
  - [ ] Deploy `inc/seo-url-cleanup.php`
  - [ ] Configure tracking param blocklist
  - [ ] Test canonical stripping (GA params, etc.)
  - [ ] Verify internal links are clean
  - [ ] Check sitemap URLs
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

## 4.3 Phase 3: On-Page SEO (Week 3)

### Content Enhancement
- [ ] **Auto-add missing featured images**
  - [ ] Deploy `inc/seo-on-page.php`
  - [ ] Run bulk featured image assignment for old posts
  - [ ] Verify all posts have thumbnail
  - [ ] Check media library for duplicates
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Ensure all images have alt text**
  - [ ] Deploy alt text filter in `functions.php`
  - [ ] Audit 50+ pages for missing alt
  - [ ] Manually add alt text to critical images
  - [ ] Verify via accessibility checker
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Optimize meta descriptions & titles**
  - [ ] Deploy fallback meta functions
  - [ ] Audit meta descriptions on 30+ pages
  - [ ] Update missing/thin meta descriptions
  - [ ] Ensure no duplicate titles
  - [ ] Check SERP preview in GSC
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

## 4.4 Phase 4: Backlink Management (Week 4)

### Backlink Audit & Cleanup
- [ ] **Conduct backlink audit**
  - [ ] Export backlinks from Ahrefs/Moz/SEMrush
  - [ ] Filter by spam score > 60
  - [ ] Identify unrelated/harmful anchor text
  - [ ] Document in `Audit Data/backlinks-export.csv`
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Create disavow file**
  - [ ] Generate `disavow.txt` from bad domains
  - [ ] Format: `domain:spammydomain.com` per line
  - [ ] Review before submission
  - [ ] Upload via Google Search Console
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Deploy backlink monitoring**
  - [ ] Set up API integration in `inc/seo-backlink-manager.php`
  - [ ] Create weekly backlink check script
  - [ ] Alert on new high-spam links
  - [ ] Maintain disavow.txt updates
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

# PART 5: JANNAH CUSTOMIZATION ROADMAP

## 5.1 Phase A: Foundation & Architecture (Week 1-2)

### Child Theme Setup
- [ ] **Organize child theme directory structure**
  - [ ] Create `inc/` directory for modules
  - [ ] Create `css/` directory for stylesheets
  - [ ] Create `js/` directory for scripts
  - [ ] Create `templates/` for page overrides
  - [ ] Create `assets/` for images/fonts
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Enhance functions.php**
  - [ ] Add module loader pattern
  - [ ] Add require_once calls for all modules
  - [ ] Add CSS/JS enqueue hooks
  - [ ] Add action/filter priorities documentation
  - [ ] Verify no PHP errors with WP-CLI check
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Create main style.css**
  - [ ] Move all imports to main `style.css`
  - [ ] Add custom CSS variables
  - [ ] Align with Jannah color scheme
  - [ ] Implement dark/light theme support
  - [ ] Test in browser DevTools
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

## 5.2 Phase B: Core Modules (Week 2-3)

### Module Implementation
- [ ] **Deploy ToC Module**
  - [ ] Copy `inc/table-of-contents-toc.php`
  - [ ] Add CSS: `css/toc-styles.css`
  - [ ] Add JS: `js/toc-logic.js`
  - [ ] Test meta box on sample posts
  - [ ] Test all 5 styles
  - [ ] Test RTL rendering
  - [ ] Test dark mode
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Deploy Poll Module**
  - [ ] Copy `inc/poll-system.php`
  - [ ] Create custom DB table: `wp_tez_polls`
  - [ ] Add CSS: `css/poll-styles.css`
  - [ ] Add JS: `js/poll-interaction.js`
  - [ ] Test AJAX voting with nonce
  - [ ] Test IP-based spam prevention
  - [ ] Test all 4 poll styles
  - [ ] Verify database indexes
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Deploy Visual Sitemap**
  - [ ] Copy `inc/visual-sitemap.php`
  - [ ] Create page with slug "sitemap"
  - [ ] Test auto-generation of sections
  - [ ] Test search box functionality
  - [ ] Test responsive layout
  - [ ] Verify dark mode
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Deploy Tag Hub Template**
  - [ ] Copy `inc/tag-hub-template.php`
  - [ ] Create `templates/page-tag-hub.php`
  - [ ] Create page and select "Tag Hub" template
  - [ ] Test live filtering
  - [ ] Test responsive layout
  - [ ] Verify Font Awesome conditional load
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Deploy 404 Hub**
  - [ ] Copy `inc/404-hub.php`
  - [ ] Create `templates/404.php`
  - [ ] Test 404 page rendering
  - [ ] Verify header/footer preserved
  - [ ] Test search functionality
  - [ ] Test quick links
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

## 5.3 Phase C: Page Templates (Week 3-4)

### Service Provider Pages
- [ ] **Create About Page Template**
  - [ ] Deploy `inc/about-page-template.php`
  - [ ] Create `templates/page-about.php`
  - [ ] Create page and assign template
  - [ ] Add company mission/values content
  - [ ] Add team member cards
  - [ ] Add achievements stats
  - [ ] Test responsive layout
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Create Contact Page Template**
  - [ ] Deploy `inc/contact-page-template.php`
  - [ ] Create `templates/page-contact.php`
  - [ ] Integrate contact form plugin
  - [ ] Add office location/hours
  - [ ] Add multiple contact methods
  - [ ] Add Google Map embed
  - [ ] Test form submission
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Create Service Pages (using .tez-* classes)**
  - [ ] Create page for each core service
  - [ ] Use `.tez-service-detail` wrapper
  - [ ] Add `.tez-service-icon`, `.tez-service-features`
  - [ ] Use Jannah shortcodes (buttons, lists, boxes)
  - [ ] Add ToC for long service guides
  - [ ] Add CTAs with clear hierarchy
  - [ ] Test mobile layout
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Create Pricing Page**
  - [ ] Create page with pricing layout
  - [ ] Use `.tez-pricing-grid`, `.tez-pricing-card`
  - [ ] Add feature comparison rows
  - [ ] Add "Get Quote"/"Book Call" buttons
  - [ ] Add toggle for billing periods (optional)
  - [ ] Add CTA footer
  - [ ] Test on mobile
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Create Homepage with Page Builder**
  - [ ] Use Jannah Page Builder sections
  - [ ] Hero section: background image/video, headline, CTA
  - [ ] Services overview: News Blocks showing services
  - [ ] Social proof: testimonials, logos, case studies
  - [ ] FAQ section using Toggle Boxes
  - [ ] Contact CTA section
  - [ ] Test all sections responsive
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

## 5.4 Phase D: Styling & UX Polish (Week 4)

### Design System
- [ ] **Implement CSS design system**
  - [ ] Define color palette matching Jannah primary
  - [ ] Set typography scales
  - [ ] Define spacing system
  - [ ] Create shadow/border utilities
  - [ ] Document in `css/design-tokens.css`
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Align Jannah theme colors**
  - [ ] Set Jannah primary color to match `--tez-primary`
  - [ ] Configure Jannah skin if needed
  - [ ] Test dark mode across all modules
  - [ ] Verify sepia mode compatibility
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Test accessibility**
  - [ ] Run axe DevTools scan on 10+ pages
  - [ ] Fix WCAG 2.1 AA issues
  - [ ] Test keyboard navigation
  - [ ] Test screen reader with NVDA/JAWS
  - [ ] Test focus indicators
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Mobile responsiveness audit**
  - [ ] Test all pages on iOS Safari (iPhone 12)
  - [ ] Test on Android Chrome (Pixel 5)
  - [ ] Fix layout issues
  - [ ] Verify touch targets > 44px
  - [ ] Test orientation changes
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

## 5.5 Phase E: Performance & Security (Week 4-5)

### Optimization
- [ ] **Performance optimization**
  - [ ] Install Autoptimize plugin
  - [ ] Enable JS/CSS minification
  - [ ] Generate critical CSS
  - [ ] Enable lazy loading for images
  - [ ] Verify Core Web Vitals < 100ms LCP, < 250ms CLS
  - [ ] Test with PageSpeed Insights
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Security hardening**
  - [ ] Disable unused plugins
  - [ ] Update all plugins/theme
  - [ ] Enable HTTPS with HSTS
  - [ ] Implement security headers (CSP, X-Frame-Options)
  - [ ] Set up web application firewall
  - [ ] Run security audit with WPScan
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

- [ ] **Caching implementation**
  - [ ] Install caching plugin (WP Super Cache, LiteSpeed)
  - [ ] Configure page cache
  - [ ] Set up browser cache headers
  - [ ] Test cache purge on post updates
  - Task Owner: _____
  - Deadline: _____
  - Status: ⬜ Not Started

---

# PART 6: IMPLEMENTATION CHECKLIST BY MODULE

## 6.1 SEO Recovery Modules

### seo-spam-cleanup.php
```php
// Location: inc/seo-spam-cleanup.php
// Purpose: Spam file detection and cleanup

Checklist:
- [ ] Function: scan_for_spam_files()
- [ ] Function: delete_spam_files()
- [ ] Function: log_cleanup_actions()
- [ ] Security: Admin-only access check
- [ ] Security: Nonce verification
- [ ] Testing: Verify files actually deleted
- [ ] Logging: Record all deletions
- [ ] Rollback: Maintain deletion log
```

### seo-technical-fixes.php
```php
// Location: inc/seo-technical-fixes.php
// Purpose: Canonical tags, redirects, robots

Checklist:
- [ ] Function: add_canonical_tags()
- [ ] Function: fix_redirect_chains()
- [ ] Function: clean_robots_txt()
- [ ] Hook: wp_head for canonical (priority 1)
- [ ] Testing: 20+ URLs for canonical presence
- [ ] Testing: 20+ URLs for proper redirect codes
- [ ] Compatibility: Check SEO plugin conflicts
- [ ] Documentation: Comment all rules
```

### seo-on-page.php
```php
// Location: inc/seo-on-page.php
// Purpose: Featured images, meta, alt text

Checklist:
- [ ] Function: assign_featured_images_bulk()
- [ ] Function: auto_add_alt_text()
- [ ] Function: generate_meta_descriptions()
- [ ] Hook: save_post for featured image
- [ ] Hook: the_content for alt text
- [ ] Hook: wp_head for meta fallback
- [ ] Testing: Verify 50+ posts have images
- [ ] Testing: Verify 50+ images have alt
- [ ] WP-CLI: Create command for bulk operations
- [ ] Safety: Add dry-run mode
```

### seo-backlink-manager.php
```php
// Location: inc/seo-backlink-manager.php
// Purpose: Backlink monitoring, disavow generation

Checklist:
- [ ] Function: fetch_backlinks_from_api()
- [ ] Function: flag_spam_backlinks()
- [ ] Function: generate_disavow_file()
- [ ] API: Ahrefs integration (if available)
- [ ] API: Moz integration (if available)
- [ ] Database: Store backlink history
- [ ] Cron: Set up weekly backlink check
- [ ] Alert: Email on new spam links
- [ ] Security: Secure API keys in wp-config
- [ ] Documentation: API setup guide
```

---

## 6.2 Custom Module Checklist

### table-of-contents-toc.php
```
Checklist:
- [ ] Meta box registration and display
- [ ] Heading level selection (H1-H6)
- [ ] Position options: before, after-1st-p, after-2nd-p, manual
- [ ] Style options: modern, minimal, boxed, gradient, sidebar
- [ ] Collapsed by default toggle
- [ ] Numbering toggle
- [ ] Minimum headings threshold
- [ ] Auto-inject on the_content (priority 5)
- [ ] Heading ID generation and injection
- [ ] Frontend rendering and styling
- [ ] JavaScript: scroll tracking, active highlighting
- [ ] JavaScript: smooth scroll on click
- [ ] Keyboard navigation: arrow keys, enter
- [ ] RTL support testing
- [ ] Dark mode CSS variables
- [ ] Sepia mode CSS variables
- [ ] Responsive breakpoints (mobile, tablet, desktop)
- [ ] Print styles
- [ ] Accessibility: ARIA labels, focus states
- [ ] Reduced motion media query
- [ ] Test with 20+ posts
```

### poll-system.php
```
Checklist:
- [ ] Database table creation: wp_tez_polls
- [ ] Database indexes for performance
- [ ] Meta box: question, type, options, position, style
- [ ] Option colors picker
- [ ] Drag-to-sort options
- [ ] AJAX vote submission
- [ ] Nonce verification
- [ ] IP-based vote deduplication
- [ ] Results calculation and display
- [ ] Vote count badge
- [ ] Result percentages and bars
- [ ] Auto-results view after voting
- [ ] 4 display styles: modern, minimal, gradient, glass
- [ ] Previously voted indication
- [ ] Multiple-choice support
- [ ] Frontend rendering
- [ ] RTL support
- [ ] Dark/sepia theme support
- [ ] Responsive design
- [ ] Analytics: view vote breakdown
- [ ] Admin: Clear votes option
- [ ] Test AJAX on multiple browsers
```

### visual-sitemap.php
```
Checklist:
- [ ] Page detection: is_page('sitemap')
- [ ] the_content filter override
- [ ] Hero section with stats
- [ ] Pages list section
- [ ] Recent posts section
- [ ] Categories grid with accent colors
- [ ] Tag cloud with variable sizing
- [ ] Monthly archives list
- [ ] Author grid
- [ ] Search box integration
- [ ] Responsive grid layout
- [ ] Hover animations
- [ ] Dark mode support
- [ ] Sepia mode support
- [ ] RTL support
- [ ] Print styles
- [ ] Performance: query optimization
- [ ] Test with 50+ posts, 20+ categories
```

### tag-hub-template.php
```
Checklist:
- [ ] Page template registration
- [ ] page_template filter override
- [ ] Hero section: tag icon, title, stats
- [ ] Live filter input (client-side)
- [ ] Filter clear button
- [ ] No results message
- [ ] Tag cards grid
- [ ] Sort by post count
- [ ] Color cycle for tag cards
- [ ] Tag name and post count header
- [ ] Tag archive link
- [ ] 5 recent posts preview
- [ ] Footer: view all link
- [ ] Responsive grid
- [ ] Dark mode support
- [ ] RTL support
- [ ] Font Awesome conditional load
- [ ] Test with 30+ tags
```

### 404-hub.php
```
Checklist:
- [ ] 404_template filter hook
- [ ] Header/footer preservation
- [ ] Hero: 404 animation
- [ ] Hero: search form
- [ ] Popular posts section
- [ ] Latest posts fallback
- [ ] Top categories
- [ ] Tag cloud
- [ ] Quick links: home, sitemap, contact, about
- [ ] Responsive layout
- [ ] Inline animations
- [ ] Dark mode support
- [ ] Test with fake URLs
- [ ] Verify header/footer rendering
```

### about-page-template.php
```
Checklist:
- [ ] Page template registration
- [ ] Hero section with company name/tagline
- [ ] Mission statement section
- [ ] Values grid
- [ ] Team member cards with photos/titles
- [ ] Company achievements/stats
- [ ] Timeline or history section
- [ ] CTA section
- [ ] Responsive layout
- [ ] Dark mode support
- [ ] Test with content
```

### contact-page-template.php
```
Checklist:
- [ ] Page template registration
- [ ] Contact info section
- [ ] Address, phone, email, hours
- [ ] Form embed area
- [ ] Multiple contact methods
- [ ] Google Map embed
- [ ] Quick contact cards
- [ ] Testimonials sidebar
- [ ] Trust signals
- [ ] CTA footer
- [ ] Responsive two-column layout
- [ ] Form validation
- [ ] Dark mode support
- [ ] Mobile optimization
```

---

# PART 7: FILE CREATION & DEPLOYMENT CHECKLIST

## 7.1 PHP Files to Create

| File Path | Purpose | Status | Priority |
|-----------|---------|--------|----------|
| `inc/seo-spam-cleanup.php` | Spam cleanup automation | ⬜ | Critical |
| `inc/seo-technical-fixes.php` | Canonical, redirects, robots | ⬜ | Critical |
| `inc/seo-on-page.php` | Featured images, meta, alt | ⬜ | Critical |
| `inc/seo-backlink-manager.php` | Backlink monitoring | ⬜ | High |
| `inc/table-of-contents-toc.php` | ToC module | ⬜ | High |
| `inc/poll-system.php` | Poll module | ⬜ | High |
| `inc/visual-sitemap.php` | Visual sitemap | ⬜ | Medium |
| `inc/tag-hub-template.php` | Tag hub template | ⬜ | Medium |
| `inc/404-hub.php` | 404 content hub | ⬜ | Medium |
| `inc/about-page-template.php` | About page template | ⬜ | Low |
| `inc/contact-page-template.php` | Contact page template | ⬜ | Low |
| `templates/page-tag-hub.php` | Tag hub template file | ⬜ | Medium |
| `templates/404.php` | 404 template file | ⬜ | Medium |
| `templates/page-about.php` | About template file | ⬜ | Low |
| `templates/page-contact.php` | Contact template file | ⬜ | Low |

## 7.2 CSS Files to Create

| File Path | Purpose | Status | Priority |
|-----------|---------|--------|----------|
| `css/style.css` | Main theme styles | ⬜ | Critical |
| `css/page-templates.css` | Service/business layouts | ⬜ | High |
| `css/toc-styles.css` | ToC styling | ⬜ | High |
| `css/poll-styles.css` | Poll styling | ⬜ | High |
| `css/responsive.css` | Mobile/responsive styles | ⬜ | High |
| `css/design-tokens.css` | CSS variables | ⬜ | Medium |
| `css/accessibility.css` | A11y enhancements | ⬜ | Medium |
| `css/dark-mode.css` | Dark theme overrides | ⬜ | Medium |

## 7.3 JavaScript Files to Create

| File Path | Purpose | Status | Priority |
|-----------|---------|--------|----------|
| `js/scripts.js` | Main theme script | ⬜ | Medium |
| `js/toc-logic.js` | ToC interactions | ⬜ | High |
| `js/poll-interaction.js` | Poll AJAX/interactions | ⬜ | High |
| `js/theme-utilities.js` | Cross-theme utilities | ⬜ | Medium |
| `js/accessibility.js` | A11y enhancements | ⬜ | Low |

## 7.4 Configuration Files to Create

| File Path | Purpose | Status | Priority |
|-----------|---------|--------|----------|
| `.htaccess` | Apache rewrites/redirects | ⬜ | Critical |
| `robots.txt` | SEO robots configuration | ⬜ | Critical |
| `functions.php` (updated) | Module loader | ⬜ | Critical |
| `style.css` (updated) | CSS imports | ⬜ | Critical |

## 7.5 Documentation to Create

| File Path | Purpose | Status | Priority |
|-----------|---------|--------|----------|
| `README.md` (updated) | Setup & usage guide | ⬜ | High |
| `MODULES.md` | Module documentation | ⬜ | High |
| `CUSTOMIZATION.md` | Customization guide | ⬜ | Medium |
| `PERFORMANCE.md` | Performance tuning guide | ⬜ | Medium |
| `TROUBLESHOOTING.md` | Common issues & fixes | ⬜ | Medium |
| `CHANGELOG.md` | Version history | ⬜ | Low |

---

# PART 8: DETAILED ACTION PLAN BY PRIORITY

## 🔴 CRITICAL PATH (Must Complete First)

### Week 1: Foundation & Cleanup

**Monday-Tuesday:**
- [ ] **Meeting: Project kickoff**
  - Review scope, timeline, stakeholders
  - Assign task owners
  - Set up communication channels

- [ ] **Task: Spam file audit**
  - List all suspicious files on server
  - Document findings in `Audit Data/spam-urls-identified.txt`
  - Owner: _____ | Deadline: Tuesday EOD

- [ ] **Task: Delete spam files**
  - SSH to server, remove identified files
  - Run `rm` commands with verification
  - Backup file list for records
  - Owner: _____ | Deadline: Tuesday EOD

**Wednesday-Thursday:**
- [ ] **Task: Create .htaccess**
  - Copy template, customize for domain
  - Add 410 rules, redirect rules
  - Test on staging with `curl`
  - Deploy to production with backup
  - Owner: _____ | Deadline: Thursday AM

- [ ] **Task: Create robots.txt**
  - Allow/disallow rules
  - Add sitemaps section
  - Test with GSC
  - Owner: _____ | Deadline: Thursday PM

**Friday:**
- [ ] **Task: Initial SEO module structure**
  - Create `inc/` directory
  - Create CSS/JS directories
  - Create templates directory
  - Commit to GitHub
  - Owner: _____ | Deadline: Friday EOD

- [ ] **Review & QA Week 1**
  - 404 responses tested ✅
  - Redirects tested ✅
  - No legitimate content blocked ✅
  - GitHub push completed ✅

---

### Week 2: Core SEO Functions

**Monday-Tuesday:**
- [ ] **Deploy seo-technical-fixes.php**
  - Canonical tag function
  - Add to functions.php loader
  - Test on 20+ pages
  - Verify no duplicate tags
  - Owner: _____ | Deadline: Tuesday

- [ ] **Deploy seo-spam-cleanup.php**
  - Cleanup functions
  - Logging functionality
  - Admin-only access
  - Owner: _____ | Deadline: Tuesday

**Wednesday-Thursday:**
- [ ] **Deploy seo-on-page.php**
  - Featured image function
  - Alt text filter
  - Meta description fallback
  - Test on 50+ posts
  - Owner: _____ | Deadline: Thursday

**Friday:**
- [ ] **URL cleanup testing**
  - Test canonical tags
  - Test alt text injection
  - Test featured images
  - Verify no errors in logs
  - Owner: _____ | Deadline: Friday

- [ ] **Google Search Console**
  - Upload cleaned robots.txt
  - Request re-crawl
  - Monitor crawl stats
  - Owner: _____ | Deadline: Friday

---

## 🟠 HIGH PRIORITY (Complete Weeks 2-3)

### Week 2-3: Custom Modules

**ToC Module Deployment:**
- [ ] Copy `inc/table-of-contents-toc.php`
- [ ] Add CSS: `css/toc-styles.css`
- [ ] Add JS: `js/toc-logic.js`
- [ ] Test meta box on posts
- [ ] Test all 5 styles
- [ ] Test RTL/dark mode
- [ ] Owner: _____ | Deadline: End of Week 2

**Poll Module Deployment:**
- [ ] Copy `inc/poll-system.php`
- [ ] Create DB table migration
- [ ] Add CSS/JS
- [ ] Test AJAX voting
- [ ] Test all 4 styles
- [ ] Owner: _____ | Deadline: End of Week 3

**Backlink Module Deployment:**
- [ ] Copy `inc/seo-backlink-manager.php`
- [ ] Set up API keys (Ahrefs/Moz)
- [ ] Create disavow file generator
- [ ] Test API integration
- [ ] Set up cron job
- [ ] Owner: _____ | Deadline: Mid-Week 3

---

## 🟡 MEDIUM PRIORITY (Weeks 3-4)

### Week 3-4: Page Templates & Styling

**Page Templates:**
- [ ] Visual Sitemap deployment
- [ ] Tag Hub template deployment
- [ ] 404 Hub deployment
- [ ] About page template (optional)
- [ ] Contact page template (optional)

**Styling & Design:**
- [ ] CSS design system setup
- [ ] Jannah color alignment
- [ ] Dark mode testing
- [ ] Responsive design audit
- [ ] Accessibility testing (WCAG AA)

---

## 🟢 LOW PRIORITY (Week 4+)

### Week 4+: Polish & Optimization

**Performance:**
- [ ] Autoptimize configuration
- [ ] Critical CSS generation
- [ ] Image lazy loading
- [ ] Caching setup

**Security:**
- [ ] Plugin/theme updates
- [ ] Security headers
- [ ] WAF setup
- [ ] WPScan audit

**Documentation:**
- [ ] Module guides
- [ ] Customization guides
- [ ] Troubleshooting docs
- [ ] API integration docs

---

# PART 9: ISSUE TRACKING & METRICS

## 9.1 Critical Issues Log

| ID | Issue | Severity | Status | Owner | Deadline | Notes |
|----|-------|----------|--------|-------|----------|-------|
| SEO-001 | Spam URLs blocking | 🔴 CRITICAL | ⬜ | | | |
| SEO-002 | 410 responses not working | 🔴 CRITICAL | ⬜ | | | |
| SEO-003 | Redirect chains still present | 🟠 HIGH | ⬜ | | | |
| JANNAH-001 | .htaccess conflicts | 🔴 CRITICAL | ⬜ | | | |
| JANNAH-002 | Plugin loading errors | 🔴 CRITICAL | ⬜ | | | |
| CUSTOM-001 | ToC heading ID conflicts | 🟠 HIGH | ⬜ | | | |
| CUSTOM-002 | Poll AJAX timeout | 🟠 HIGH | ⬜ | | | |
| PERF-001 | Slow page load (>3s) | 🟠 HIGH | ⬜ | | | |

## 9.2 Success Metrics

### SEO Recovery Metrics
- [ ] Spam URLs blocked: 100% (0 accessible)
- [ ] 404s returning proper status code: 100%
- [ ] Canonical tags present: 100% of posts/pages
- [ ] Featured images assigned: 95%+ of posts
- [ ] Alt text on images: 95%+ of images
- [ ] Meta descriptions present: 90%+ of posts
- [ ] Zero redirect chains (all 1-hop): 100%
- [ ] Disavow file submitted to GSC: ✅
- [ ] Backlink spam score average < 40: Target

### Theme Customization Metrics
- [ ] All modules loading without errors: ✅
- [ ] ToC auto-generating on posts: ✅
- [ ] Polls AJAX submitting votes: ✅
- [ ] Visual Sitemap rendering: ✅
- [ ] Tag Hub filtering working: ✅
- [ ] 404 Hub displaying content: ✅
- [ ] Page templates appearing in selector: ✅
- [ ] Responsive design tested on 5+ devices: ✅

### Performance Metrics
- [ ] Largest Contentful Paint (LCP): < 2.5s
- [ ] First Input Delay (FID): < 100ms
- [ ] Cumulative Layout Shift (CLS): < 0.1
- [ ] Overall PageSpeed score: > 75
- [ ] Mobile PageSpeed score: > 65

### Accessibility Metrics
- [ ] WCAG 2.1 AA compliance: 100%
- [ ] Keyboard navigation tested: ✅
- [ ] Screen reader compatible: ✅
- [ ] Color contrast ratio > 4.5:1: ✅
- [ ] Focus indicators visible: ✅

---

# PART 10: RESOURCES & REFERENCES

## 10.1 Jannah Documentation Links

- [Jannah Shortcodes](https://jannah.helpscoutdocs.com/article/128-shortcodes)
- [Page Builder](https://jannah.helpscoutdocs.com/article/62-page-builder)
- [Custom Content Blocks](https://jannah.helpscoutdocs.com/article/127-custom-content-blocks)
- [Content Index (ToC)](https://jannah.helpscoutdocs.com/article/151-content-index-shortcode)
- [Styling Settings](https://jannah.helpscoutdocs.com/article/77-styling-settings)
- [Block Settings](https://jannah.helpscoutdocs.com/article/179-blocks-settings)
- [News Blocks](https://jannah.helpscoutdocs.com/article/122-news-blocks)
- [Troubleshooting](https://jannah.helpscoutdocs.com/category/10-troubleshooting)
- [Child Theme Setup](https://jannah.helpscoutdocs.com/article/196-jannah-child-theme)

## 10.2 SEO Tools & Resources

| Tool | Purpose | Link |
|------|---------|------|
| Google Search Console | Index monitoring, crawl errors | https://search.google.com/search-console |
| Ahrefs | Backlink analysis | https://ahrefs.com/api |
| Moz | Spam score, backlinks | https://moz.com/products/api |
| SEMrush | Competitor analysis | https://www.semrush.com/api |
| PageSpeed Insights | Performance metrics | https://pagespeed.web.dev |
| GTmetrix | Waterfall analysis | https://gtmetrix.com |
| Lighthouse | Accessibility audit | Built in Chrome DevTools |
| axe DevTools | WCAG testing | https://www.deque.com/axe/devtools |
| httpstatus.io | HTTP status checker | https://httpstatus.io |
| WPScan | WordPress security audit | https://wpscan.com |

## 10.3 WordPress & PHP Resources

| Resource | Purpose | Link |
|----------|---------|------|
| WordPress Hooks | Hook documentation | https://developer.wordpress.org/apis/hooks |
| WordPress Actions | action hook reference | https://developer.wordpress.org/plugins/hooks/actions |
| WordPress Filters | filter hook reference | https://developer.wordpress.org/plugins/hooks/filters |
| WP-CLI | Command line tool | https://wp-cli.org |
| WPDB Class | Database queries | https://developer.wordpress.org/reference/classes/wpdb |
| Theme Handbook | Theme development | https://developer.wordpress.org/themes |

---

# PART 11: DEPLOYMENT INSTRUCTIONS

## 11.1 Pre-Deployment Checklist

**Server Setup:**
- [ ] SSH access verified
- [ ] SFTP/Git access verified
- [ ] Database backups enabled
- [ ] Staging environment available
- [ ] Staging mirrors production

**Code Quality:**
- [ ] All PHP files pass WP-CLI check
- [ ] No syntax errors in CSS
- [ ] JavaScript console clean (no errors)
- [ ] All files follow WordPress coding standards
- [ ] Code commented and documented

**Testing:**
- [ ] All functions tested locally
- [ ] 10+ URLs tested for each feature
- [ ] Mobile testing completed
- [ ] Browser compatibility tested (Chrome, Firefox, Safari, Edge)
- [ ] No console errors or warnings

**Backup:**
- [ ] Full database backup taken
- [ ] Theme files backed up
- [ ] .htaccess backed up
- [ ] Backup location documented

---

## 11.2 Staged Deployment Plan

### Stage 1: Configuration Files (30 minutes)
```bash
1. Update .htaccess (with backup)
2. Update robots.txt
3. Test with curl for 410/301 responses
4. Verify no legitimate URLs blocked
```

### Stage 2: PHP Modules (1 hour)
```bash
1. Create inc/ directory structure
2. Upload seo-*.php modules
3. Update functions.php with loaders
4. Verify no PHP errors with wp-cli
5. Check WordPress admin loads without errors
```

### Stage 3: CSS/JS (30 minutes)
```bash
1. Create css/ and js/ directories
2. Upload all CSS files
3. Upload all JS files
4. Verify enqueuing in wp_head/wp_footer
5. Test styles applied correctly
```

### Stage 4: Page Templates (1 hour)
```bash
1. Create templates/ directory
2. Upload all template files
3. Create pages for templates
4. Verify templates appear in selector
5. Test each template renders correctly
```

### Stage 5: Verification (2 hours)
```bash
1. Run Google GSC crawl on staging
2. Check Search Console for errors
3. Test mobile rendering
4. Verify all CTAs/links work
5. Check performance metrics
6. Run accessibility audit
```

---

## 11.3 Rollback Procedure

If issues occur:

```bash
1. Restore .htaccess from backup
2. Restore robots.txt from backup
3. Restore functions.php from backup
4. Remove inc/ directory
5. Clear all caches (object, page, browser)
6. Verify site loads
7. Notify team
8. Review error logs
```

---

# PART 12: ONGOING MAINTENANCE

## 12.1 Weekly Tasks

- [ ] Monitor GSC for errors
- [ ] Check backlink spam alerts
- [ ] Review 404 logs
- [ ] Spot-check canonical tags on new posts
- [ ] Monitor Core Web Vitals

## 12.2 Monthly Tasks

- [ ] Full backlink audit (if using Ahrefs/Moz)
- [ ] Content audit (verify meta descriptions)
- [ ] Run PageSpeed audit
- [ ] WCAG accessibility scan
- [ ] Update disavow.txt if needed
- [ ] Review module error logs

## 12.3 Quarterly Tasks

- [ ] Comprehensive SEO audit
- [ ] Competitive analysis
- [ ] Keyword ranking review
- [ ] Backlink profile review
- [ ] Theme/plugin update check
- [ ] Security audit (WPScan)

## 12.4 Annual Tasks

- [ ] Full site audit
- [ ] Architecture review
- [ ] Performance optimization review
- [ ] Accessibility compliance audit
- [ ] Security hardening review
- [ ] Documentation update

---

# PART 13: FREQUENTLY ASKED QUESTIONS & TROUBLESHOOTING

## Q1: Canonical tags not appearing

**A:** Check `wp_head` hook priority. Our function runs at priority 1 (very early). If another plugin is outputting canonicals, you may have duplicates. Solution:
```php
// In functions.php, add:
remove_action('wp_head', 'other_plugin_canonical_function', 10);
```

## Q2: .htaccess changes not taking effect

**A:** 
1. Verify RewriteEngine is enabled
2. Check Apache mod_rewrite is loaded
3. Verify .htaccess permissions (644)
4. Test with: `curl -I https://yourdomain.com/spam.php`
5. Check hosting support (some shared hosts disable .htaccess)

## Q3: Poll votes not saving

**A:**
1. Verify `wp_tez_polls` table exists: `SHOW TABLES LIKE 'wp_tez_polls';`
2. Check nonce verification in AJAX
3. Verify IP storage (check database)
4. Check browser console for AJAX errors
5. Verify admin-ajax.php is accessible

## Q4: ToC not appearing on posts

**A:**
1. Verify module is loaded in functions.php
2. Check post type is 'post'
3. Verify meta box is enabled for this post
4. Check `the_content` priority (should be 5)
5. Verify post has H2-H4 headings
6. Check browser console for JS errors

## Q5: Dark mode not working

**A:**
1. Verify CSS variables are defined
2. Check `data-theme="dark"` attribute on body
3. Verify `@media (prefers-color-scheme: dark)` rules exist
4. Clear browser cache
5. Check for conflicting CSS

---

# PART 14: GITHUB REPOSITORY STRUCTURE FINAL

After complete implementation, your repository will look like:

```
maziyarid/childjannah/
├── .gitignore
├── README.md                    # Complete setup guide
├── MODULES.md                   # Module reference
├── CUSTOMIZATION.md
├── TROUBLESHOOTING.md
├── CHANGELOG.md
│
├── functions.php                # Module loader
├── style.css                    # CSS imports
│
├── .htaccess                    # Apache rewrite rules
├── robots.txt                   # SEO robots config
│
├── inc/                         # PHP modules
│   ├── seo-spam-cleanup.php
│   ├── seo-technical-fixes.php
│   ├── seo-on-page.php
│   ├── seo-backlink-manager.php
│   ├── table-of-contents-toc.php
│   ├── poll-system.php
│   ├── visual-sitemap.php
│   ├── tag-hub-template.php
│   ├── 404-hub.php
│   ├── about-page-template.php
│   └── contact-page-template.php
│
├── css/
│   ├── style.css
│   ├── page-templates.css
│   ├── toc-styles.css
│   ├── poll-styles.css
│   ├── responsive.css
│   ├── design-tokens.css
│   ├── accessibility.css
│   └── dark-mode.css
│
├── js/
│   ├── scripts.js
│   ├── toc-logic.js
│   ├── poll-interaction.js
│   ├── theme-utilities.js
│   └── accessibility.js
│
├── templates/
│   ├── 404.php
│   ├── page-about.php
│   ├── page-contact.php
│   ├── page-tag-hub.php
│   └── page-services.php
│
├── assets/
│   ├── images/
│   │   └── logo.svg
│   ├── icons/
│   │   └── (font awesome or custom)
│   └── fonts/
│       └── (if custom fonts)
│
├── Analyses/
│   ├── SEO-Audit-Report.md
│   ├── Backlink-Analysis.md
│   ├── Competitor-Analysis.md
│   ├── Keyword-Research.md
│   └── Technical-SEO-Audit.md
│
├── Audit Data/
│   ├── backlinks-export.csv
│   ├── crawl-errors.json
│   ├── 404-urls.txt
│   ├── redirect-chains.txt
│   └── spam-urls-identified.txt
│
└── Snippets/
    ├── htaccess-rules.txt
    ├── functions-examples.php
    ├── wpcli-commands.txt
    └── api-integration-examples.php
```

---

# PART 15: FINAL SUMMARY & NEXT STEPS

## 🎯 Project Goals Recap

✅ **SEO Recovery:**
- Eliminate spam URLs from the site
- Fix redirect chains
- Implement canonical tags
- Optimize on-page SEO (meta, images, alt text)
- Clean up backlink profile
- Monitor and maintain URL hygiene

✅ **Jannah Customization:**
- Transform news theme into service provider theme
- Build advanced modules (ToC, Polls, etc.)
- Create service/pricing/about/contact pages
- Implement Page Builder sections
- Integrate custom CSS design system
- Ensure accessibility and performance

✅ **Code Quality:**
- Modular, reusable architecture
- Full documentation
- No external plugin bloat
- RTL and dark mode support
- WCAG 2.1 AA compliance
- Core Web Vitals optimized

## 📅 Timeline

- **Week 1:** Foundations & Cleanup
- **Week 2:** SEO Core Functions & Modules
- **Week 3:** Advanced Modules & Styling
- **Week 4:** Page Templates, Polish, Testing
- **Week 5:** Optimization, Documentation, Launch

## 🚀 Next Immediate Steps

1. **TODAY:** Review this master document with team
2. **TOMORROW:** Assign task owners and deadlines
3. **THIS WEEK:** Start Phase 1 (Week 1 tasks)
4. **NEXT WEEK:** Complete Phase 1 and begin Phase 2

## 📞 Contact & Support

For questions or issues:
- Review TROUBLESHOOTING.md
- Check GitHub Issues
- Email: [me@maziyar.link]
- Slack: [teznevisan3.com]

---

**Document Version:** 1.0  
**Last Updated:** 2026-02-21  
**Status:** ✅ Complete Master Plan Ready for Implementation  
**Total Checklist Items:** 200+  
**Estimated Completion Time:** 4-5 weeks  
**Team Size Recommended:** 2-3 developers

---

**END OF COMPREHENSIVE MASTER PLAN**
```

This **comprehensive master document** includes:

✅ **Executive Summary** - Quick overview of all deliverables  
✅ **Jannah Architecture** - Both current and target structure  
✅ **All Capabilities** - Built-in & custom features documented  
✅ **Complete Checklists** - 200+ actionable items across all phases  
✅ **Roadmap** - Detailed 4-week implementation timeline  
✅ **Action Plan** - Priority-based tasks with deadlines/owners  
✅ **SEO Recovery** - All spam, technical, on-page, backlink items  
✅ **Module Specs** - Every custom module with detailed requirements  
✅ **File Matrix** - All files to create with priorities  
✅ **Metrics** - Success criteria for every component  
✅ **Troubleshooting** - FAQ and issue resolution  
✅ **GitHub Structure** - Final repository layout  
✅ **Maintenance** - Weekly/monthly/quarterly/annual tasks  
✅ **Deployment** - Step-by-step deployment procedure  
✅ **Nothing Missing** - Every aspect covered with zero gaps
