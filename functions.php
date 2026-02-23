<?php
/**
 * Jannah Child Theme - Teznevisan
 * Version: 3.1.0
 *
 * Main functions file - acts as module loader.
 * All custom functionality is organized in the inc/ directory.
 *
 * Load order matters:
 * 1. Core setup (constants, FA, nav walkers, critical CSS)
 * 2. Footer utilities
 * 3. SEO modules
 * 4. Page templates & hub pages
 * 5. Post enhancements (ToC, polls, rating, takeaways, FAQ, meta)
 * 6. Feed, typography, icons, misc
 */

if ( ! defined('ABSPATH') ) exit;

// =============================================
// CHILD THEME CONSTANTS
// =============================================
define('TEZ_CHILD_DIR',     get_stylesheet_directory());
define('TEZ_CHILD_URI',     get_stylesheet_directory_uri());
define('TEZ_CHILD_VERSION', '3.1.0');

// =============================================
// LOAD MODULES (order matters)
// =============================================

// 1. Core: constants, FA, nav walkers, critical CSS, favicon, body classes
require_once TEZ_CHILD_DIR . '/inc/core-setup.php';

// 2. Footer utilities (widget area registration)
require_once TEZ_CHILD_DIR . '/inc/footer.php';

// 3. SEO: URL cleanup for canonicals, sitemaps, schema
require_once TEZ_CHILD_DIR . '/inc/seo-url-cleanup.php';

// 4. SEO: Remove/redirect date archives, author archives
require_once TEZ_CHILD_DIR . '/inc/seo-redirects.php';

// 5. Page templates: register About, Contact, FAQ, Service, Homepage, Inquiry, Tag Hub
require_once TEZ_CHILD_DIR . '/inc/page-templates.php';

// 6. Custom 404 content hub
require_once TEZ_CHILD_DIR . '/inc/404-hub.php';

// 7. Visual sitemap page
require_once TEZ_CHILD_DIR . '/inc/visual-sitemap.php';

// 8. Table of Contents (auto-insert on posts)
require_once TEZ_CHILD_DIR . '/inc/toc.php';

// 9. Poll system
require_once TEZ_CHILD_DIR . '/inc/polls.php';

// 10. Star rating system
require_once TEZ_CHILD_DIR . '/inc/star-rating.php';

// 11. Key takeaways box
require_once TEZ_CHILD_DIR . '/inc/key-takeaways.php';

// 12. FAQ schema system
require_once TEZ_CHILD_DIR . '/inc/faq-schema.php';

// 13. Enhanced post meta & difficulty level
require_once TEZ_CHILD_DIR . '/inc/post-meta.php';

// 14. Feed controller
require_once TEZ_CHILD_DIR . '/inc/feed-controller.php';

// 15. Typography & local Irancell fonts
require_once TEZ_CHILD_DIR . '/inc/typography.php';

// 16. Jannah to Font Awesome 7 icon mapping
require_once TEZ_CHILD_DIR . '/inc/icon-mapping.php';

// 17. Misc: comment tweaks, title overrides, page hero
require_once TEZ_CHILD_DIR . '/inc/misc-tweaks.php';

// =============================================
// ENQUEUE STYLES & SCRIPTS
// =============================================
add_action('wp_enqueue_scripts', 'tez_enqueue_child_assets', 80);
function tez_enqueue_child_assets() {

    // ----- STYLES -----

    // Parent RTL stylesheet (only when RTL language active)
    if ( is_rtl() ) {
        wp_enqueue_style(
            'tie-theme-rtl-css',
            get_template_directory_uri() . '/rtl.css',
            array(),
            TEZ_CHILD_VERSION
        );
    }

    // Child theme base stylesheet (style.css - required for child theme detection)
    wp_enqueue_style(
        'tie-theme-child-css',
        TEZ_CHILD_URI . '/style.css',
        array(),
        TEZ_CHILD_VERSION
    );

    // Main design system (layout, header, footer, nav, Chaty, utilities)
    // Loads on ALL pages
    wp_enqueue_style(
        'tez-main-css',
        TEZ_CHILD_URI . '/css/main.css',
        array('tie-theme-child-css'),
        TEZ_CHILD_VERSION
    );

    // Single post styles (reading progress, ToC, author box, share, related)
    // Only on singular post pages
    if ( is_singular('post') ) {
        wp_enqueue_style(
            'tez-single-css',
            TEZ_CHILD_URI . '/css/single-post.css',
            array('tez-main-css'),
            TEZ_CHILD_VERSION
        );
    }

    // Page template styles (hero sections, service page, homepage, inquiry form)
    // On pages and 404 (404-hub has structural hero layout)
    if ( is_page() || is_404() ) {
        wp_enqueue_style(
            'tez-pages-css',
            TEZ_CHILD_URI . '/css/page-templates.css',
            array('tez-main-css'),
            TEZ_CHILD_VERSION
        );
    }

    // Post content element containment (sidebar fix, table overflow, image overflow)
    // On any singular content (posts, pages, custom post types)
    if ( is_singular() ) {
        wp_enqueue_style(
            'tez-elements-css',
            TEZ_CHILD_URI . '/css/post-elements.css',
            array('tez-main-css'),
            TEZ_CHILD_VERSION
        );
    }

    // ----- SCRIPTS -----

    // Main JavaScript (theme switcher, mobile menu, search, Chaty, scroll-top,
    //                  dropdowns, smooth scroll, FAQ accordion, animations, forms)
    // Loads on ALL pages, deferred in footer
    wp_enqueue_script(
        'tez-scripts',
        TEZ_CHILD_URI . '/js/scripts.js',
        array(),
        TEZ_CHILD_VERSION,
        true  // in footer
    );

    // Single post enhancements (reading progress bar, ToC active state,
    //                           share popups, copy link, external link markers)
    if ( is_singular('post') ) {
        wp_enqueue_script(
            'tez-single-js',
            TEZ_CHILD_URI . '/js/single-post.js',
            array('tez-scripts'),
            TEZ_CHILD_VERSION,
            true
        );
    }

    // ----- LOCALIZATION -----

    // Pass PHP context to JS — used by scripts.js and single-post.js
    wp_localize_script('tez-scripts', 'tezData', array(
        'ajaxUrl'    => admin_url('admin-ajax.php'),
        'nonce'      => wp_create_nonce('tez_nonce'),
        'homeUrl'    => home_url('/'),
        'themeUri'   => TEZ_CHILD_URI,
        'isRTL'      => is_rtl() ? 'true' : 'false',
        'siteDir'    => is_rtl() ? 'rtl' : 'ltr',
        'isSingular' => is_singular() ? 'true' : 'false',
        'isPost'     => is_singular('post') ? 'true' : 'false',
        'isPage'     => is_page() ? 'true' : 'false',
        'is404'      => is_404() ? 'true' : 'false',
        'postId'     => get_the_ID() ? (string) get_the_ID() : '0',
        'version'    => TEZ_CHILD_VERSION,
    ));
}

// =============================================
// THEME SETUP
// =============================================
if ( ! function_exists('tez_child_theme_setup') ) {
    function tez_child_theme_setup() {
        // Inherit parent theme translations
        load_child_theme_textdomain('jannah', get_stylesheet_directory() . '/languages');

        // Add support for post thumbnails (inherited from parent but explicit is safer)
        add_theme_support('post-thumbnails');

        // Declare this child theme as having a custom header template
        // (prevents Jannah from trying to inject its header via hooks)
        add_theme_support('custom-header', array(
            'default-text-color' => '111827',
        ));
    }
    add_action('after_setup_theme', 'tez_child_theme_setup', 11);
}
