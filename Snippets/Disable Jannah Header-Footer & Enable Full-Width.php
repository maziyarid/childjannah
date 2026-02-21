/**
 * Disable Jannah Header/Footer (Contained Layout)
 * Version: 2.3.0
 */

if (!defined('ABSPATH')) exit;

// =============================================
// DISABLE JANNAH HEADER
// =============================================
add_filter('tie_disable_header', '__return_true');
add_filter('TieLabs/disable_header', '__return_true');

// =============================================
// DISABLE JANNAH FOOTER
// =============================================
add_filter('tie_disable_footer', '__return_true');
add_filter('TieLabs/disable_footer', '__return_true');

// =============================================
// DISABLE JANNAH COMPONENTS
// =============================================
add_filter('tie_disable_mobile_menu', '__return_true');
add_filter('tie_disable_sticky_header', '__return_true');
add_filter('tie_disable_back_to_top', '__return_true');
add_filter('tie_disable_breaking_news', '__return_true');
add_filter('tie_disable_top_nav', '__return_true');

// =============================================
// DISABLE SIDEBAR ONLY (NO FULL-WIDTH FORCING)
// =============================================
add_filter('tie_disable_sidebar', '__return_true');

// =============================================
// CSS TO HIDE JANNAH ELEMENTS
// =============================================
add_action('wp_head', function() {
    ?>
    <style id="tez-hide-jannah">
    /* Hide Jannah Header */
    #theme-header,
    #tie-wrapper > header:not(.tez-site-header),
    .header-layout-wrapper,
    .main-nav-wrapper,
    .logo-wrapper,
    .sticky-nav,
    #mobile-menu-icon,
    .mobile-menu-icon,
    #tie-mobile-menu,
    .tie-mobile-menu,
    .mobile_menu_bar,
    #slide-out-open,
    #top-nav,
    .top-nav,
    .top-bar-wrapper,
    .breaking-news-wrap {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        overflow: hidden !important;
    }
    
    /* Hide Jannah Footer */
    #footer:not(.tez-site-footer),
    #tie-wrapper > footer:not(.tez-site-footer),
    .footer-wrapper,
    .footer-widgets-area,
    #footer-widgets-area,
    .footer-bottom:not(.tez-footer-bottom),
    #back-to-top:not(.tez-scroll-top),
    .go-to-top:not(.tez-scroll-top) {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        overflow: hidden !important;
    }
    
    /* Remove top spacing from wrapper */
    #tie-wrapper {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
    
    /* Hide sidebar */
    #sidebar,
    .sidebar,
    #secondary,
    .tie-sidebar,
    aside.sidebar {
        display: none !important;
        width: 0 !important;
    }
    
    /* ============================================= */
    /* CONTAINED LAYOUT FOR POST CONTENT & COMPONENTS */
    /* ============================================= */
    
    /* Main content takes sidebar space but stays contained */
    #content,
    #primary,
    .main-content {
        width: 100% !important;
        float: none !important;
    }
    
    /* Keep container centered with proper max-width */
    .container,
    #tie-container,
    .tie-container {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 15px;
        padding-right: 15px;
        box-sizing: border-box;
    }
    
    /* Ensure post content and all components stay contained */
    .entry-content,
    .entry-header,
    .entry-footer,
    .post-components,
    .author-box,
    .tie-authors-box,
    .single-post-share,
    .share-buttons,
    .post-share,
    .post-bottom-meta,
    .post-meta,
    .related-posts,
    .tie-related-posts,
    .post-navigation,
    .comments-area,
    .cat-box {
        max-width: 100%;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        box-sizing: border-box;
    }
    
    /* Fix boxed layout if enabled */
    .boxed-layout #tie-wrapper {
        box-shadow: none !important;
    }
    </style>
    <?php
}, 99);
