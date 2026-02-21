/**
 * Teznevisan - Disable Page Elements on Pages Only
 * Version: 2.2.0
 * 
 * Removes: Page title, breadcrumbs, back-to-top on PAGES only
 * Keeps: All Jannah defaults on POSTS and ARCHIVES
 */

if (!defined('ABSPATH')) exit;

// =============================================
// CSS METHOD - MOST RELIABLE
// =============================================
add_action('wp_head', function() {
    // Only on pages (not posts, not archives, not front page with blog)
    if (!is_page()) return;
    if (is_front_page() && is_home()) return; // Blog page
    ?>
    <style id="tez-hide-page-elements">
    /*
     * Hide Page Title, Breadcrumbs, Back-to-Top on Pages
     * Using !important to override Jannah styles
     */
    
    /* Page Title / Header */
    body.page #page-head,
    body.page .page-head,
    body.page .page-header,
    body.page .entry-header,
    body.page .post-title-wrapper,
    body.page #post-title,
    body.page .single-post-header,
    body.page .mag-box-title,
    body.page #tie-wrapper .page-title,
    body.page #tie-container .page-title,
    body.page .container-wrapper > .page-title,
    body.page #content > .page-title,
    body.page .content > .page-title,
    body.page article.page > header,
    body.page article.page > .entry-header,
    body.page .entry-content > h1:first-child,
    body.page #the-post > header {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        max-height: 0 !important;
        min-height: 0 !important;
        overflow: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        line-height: 0 !important;
        font-size: 0 !important;
    }
    
    /* Breadcrumbs */
    body.page #breadcrumb,
    body.page .breadcrumb,
    body.page .breadcrumbs,
    body.page .tie-breadcrumbs,
    body.page #tie-breadcrumbs,
    body.page .yoast-breadcrumb,
    body.page .wpseo-breadcrumbs,
    body.page .rank-math-breadcrumb,
    body.page nav.breadcrumb,
    body.page .breadcrumb-trail,
    body.page #crumbs,
    body.page .crumbs {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        max-height: 0 !important;
        overflow: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    /* Jannah's Back to Top (not our custom one) */
    body.page #go-to-top,
    body.page #back-to-top:not(#tez-scroll-top),
    body.page .go-to-top:not(.tez-scroll-top),
    body.page .back-to-top:not(.tez-scroll-top),
    body.page a.go-to-top:not(.tez-scroll-top),
    body.page a#go-to-top {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
    
    /* Remove extra spacing from hidden elements */
    body.page .container-wrapper {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    
    body.page #content,
    body.page .content,
    body.page #main-content,
    body.page .main-content {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    
    body.page #tie-container {
        padding-top: 0 !important;
    }
    
    body.page article.page {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    
    body.page .entry-content {
        margin-top: 0 !important;
    }
    
    /* Ensure content flows properly */
    body.page .tez-main-content > *:first-child {
        margin-top: 0;
    }
    </style>
    <?php
}, 9999); // Very high priority to load last

// =============================================
// PHP FILTERS - BACKUP METHOD
// =============================================

/**
 * Disable via Jannah filters (if CSS doesn't catch everything)
 */
add_action('wp', function() {
    if (!is_page()) return;
    if (is_front_page() && is_home()) return;
    
    // Page header/title
    add_filter('tie_page_title', '__return_false', 9999);
    add_filter('TieLabs/page_title', '__return_false', 9999);
    add_filter('tie_disable_page_header', '__return_true', 9999);
    add_filter('TieLabs/disable_page_header', '__return_true', 9999);
    add_filter('tie_show_page_title', '__return_false', 9999);
    
    // Breadcrumbs
    add_filter('tie_disable_breadcrumbs', '__return_true', 9999);
    add_filter('TieLabs/disable_breadcrumbs', '__return_true', 9999);
    add_filter('tie_breadcrumbs', '__return_false', 9999);
    add_filter('tie_show_breadcrumbs', '__return_false', 9999);
    
    // Back to top
    add_filter('tie_disable_back_to_top', '__return_true', 9999);
    add_filter('TieLabs/disable_back_to_top', '__return_true', 9999);
    add_filter('tie_go_to_top', '__return_false', 9999);
});

/**
 * Remove breadcrumb actions on pages
 */
add_action('template_redirect', function() {
    if (!is_page()) return;
    
    // Try to remove breadcrumb output
    remove_all_actions('tie_before_post_head');
    remove_all_actions('TieLabs/before_post_head');
    remove_all_actions('tie_after_post_title');
    
    // Yoast breadcrumbs
    remove_action('wpseo_breadcrumb', 'wpseo_breadcrumb_output');
}, 999);

/**
 * Filter the_title on pages to return empty for page header
 */
add_filter('the_title', function($title, $id = null) {
    if (!is_page()) return $title;
    if (in_the_loop() && is_main_query()) {
        // Only hide in the header area, not everywhere
        global $wp_query;
        if ($wp_query->current_post === 0 && !did_action('the_content')) {
            // This is the page title in header - we'll handle via CSS
        }
    }
    return $title;
}, 10, 2);

// =============================================
// JAVASCRIPT FALLBACK - REMOVES ON DOM READY
// =============================================

add_action('wp_footer', function() {
    if (!is_page()) return;
    if (is_front_page() && is_home()) return;
    ?>
    <script id="tez-page-cleanup-js">
    (function() {
        // Elements to remove on pages
        var selectors = [
            '#page-head',
            '.page-head', 
            '.page-header',
            '.page-title',
            '#breadcrumb',
            '.breadcrumb',
            '.breadcrumbs',
            '.tie-breadcrumbs',
            '#go-to-top:not(#tez-scroll-top)',
            '.go-to-top:not(.tez-scroll-top)',
            '#back-to-top:not(#tez-scroll-top)',
            'article.page > header',
            'article.page > .entry-header'
        ];
        
        function removeElements() {
            selectors.forEach(function(selector) {
                var elements = document.querySelectorAll(selector);
                elements.forEach(function(el) {
                    if (el && el.parentNode) {
                        el.style.display = 'none';
                        el.style.visibility = 'hidden';
                        el.style.height = '0';
                        el.style.overflow = 'hidden';
                        el.setAttribute('aria-hidden', 'true');
                    }
                });
            });
        }
        
        // Run immediately
        removeElements();
        
        // Run on DOMContentLoaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', removeElements);
        }
        
        // Run after a small delay (catch late-loaded elements)
        setTimeout(removeElements, 100);
        setTimeout(removeElements, 500);
    })();
    </script>
    <?php
}, 9999);

// =============================================
// BODY CLASS FOR TARGETING
// =============================================

add_filter('body_class', function($classes) {
    if (is_page() && !(is_front_page() && is_home())) {
        $classes[] = 'tez-page-no-header';
        $classes[] = 'tez-page-no-breadcrumb';
        $classes[] = 'tez-page-no-backtotop';
    }
    return $classes;
}, 999);
