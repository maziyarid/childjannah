<?php
/**
 * Jannah Child Theme - Teznevisan
 * Version: 2.4.0
 *
 * Main functions file - acts as module loader.
 * All custom functionality is organized in the inc/ directory.
 */

if (!defined('ABSPATH')) exit;

// =============================================
// CHILD THEME CONSTANTS
// =============================================
define('TEZ_CHILD_DIR', get_stylesheet_directory());
define('TEZ_CHILD_URI', get_stylesheet_directory_uri());
define('TEZ_CHILD_VERSION', '2.4.0');

// =============================================
// LOAD MODULES (order matters)
// =============================================

// 1. Core setup: constants, Font Awesome, header, nav walkers, critical CSS
require_once TEZ_CHILD_DIR . '/inc/core-setup.php';

// 2. Footer & floating elements (chaty widget, scroll-to-top)
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

// 15. Typography & local fonts
require_once TEZ_CHILD_DIR . '/inc/typography.php';

// 16. Jannah to Font Awesome icon mapping
require_once TEZ_CHILD_DIR . '/inc/icon-mapping.php';

// 17. Misc: remove email from comments, remove page titles/breadcrumbs, disable Jannah header/footer
require_once TEZ_CHILD_DIR . '/inc/misc-tweaks.php';

// =============================================
// ENQUEUE STYLES & SCRIPTS
// =============================================
add_action('wp_enqueue_scripts', 'tez_enqueue_child_assets', 80);
function tez_enqueue_child_assets() {

    // Parent RTL stylesheet
    if (is_rtl()) {
        wp_enqueue_style('tie-theme-rtl-css', get_template_directory_uri() . '/rtl.css', array(), TEZ_CHILD_VERSION);
    }

    // Child theme base stylesheet (style.css header only)
    wp_enqueue_style('tie-theme-child-css', TEZ_CHILD_URI . '/style.css', array(), TEZ_CHILD_VERSION);

    // Main design system CSS
    wp_enqueue_style('tez-main-css', TEZ_CHILD_URI . '/css/main.css', array('tie-theme-child-css'), TEZ_CHILD_VERSION);

    // Single post styles (only on singular posts)
    if (is_singular('post')) {
        wp_enqueue_style('tez-single-css', TEZ_CHILD_URI . '/css/single-post.css', array('tez-main-css'), TEZ_CHILD_VERSION);
    }

    // Page template styles (only on pages)
    if (is_page()) {
        wp_enqueue_style('tez-pages-css', TEZ_CHILD_URI . '/css/page-templates.css', array('tez-main-css'), TEZ_CHILD_VERSION);
    }

    // Post content element styles (contain post elements)
    if (is_singular()) {
        wp_enqueue_style('tez-elements-css', TEZ_CHILD_URI . '/css/post-elements.css', array('tez-main-css'), TEZ_CHILD_VERSION);
    }

    // Main JavaScript
    wp_enqueue_script('tez-scripts', TEZ_CHILD_URI . '/js/scripts.js', array(), TEZ_CHILD_VERSION, true);

    // Single post enhancements JS
    if (is_singular('post')) {
        wp_enqueue_script('tez-single-js', TEZ_CHILD_URI . '/js/single-post.js', array('tez-scripts'), TEZ_CHILD_VERSION, true);
    }

    // Localize script with AJAX URL and nonce
    wp_localize_script('tez-scripts', 'tezData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('tez_nonce'),
        'homeUrl' => home_url('/'),
    ));
}
