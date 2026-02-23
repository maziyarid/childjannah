<?php
/**
 * Miscellaneous Tweaks
 * - Remove email field from comments
 * - Remove page titles & breadcrumbs on custom templates
 * - Auto-inject hero section on non-templated pages
 *
 * @package JannahChild
 * @version 3.1.0
 */

if ( ! defined('ABSPATH') ) exit;

// =============================================
// REMOVE EMAIL FIELD FROM COMMENTS
// =============================================
add_filter('comment_form_default_fields', 'tez_remove_comment_email');
function tez_remove_comment_email( $fields ) {
    if ( isset($fields['email']) ) {
        unset($fields['email']);
    }
    return $fields;
}

// =============================================
// REMOVE PAGE TITLES ON CUSTOM TEMPLATES
// Pages using templates/* handle their own hero/title markup.
// This prevents WordPress from rendering duplicate H1 above content.
// =============================================
add_filter('the_title', 'tez_hide_page_title_on_templates', 10, 2);
function tez_hide_page_title_on_templates( $title, $id = null ) {
    // Guard: ID must be provided and we must be in page context
    if ( $id === null || ! is_page($id) ) return $title;
    
    // Only hide in main query loop (not sidebars, widgets, menus)
    if ( ! in_the_loop() || is_admin() ) return $title;

    $template = get_page_template_slug($id);
    
    // If page uses a templates/* file, hide the default title
    if ( $template && strpos($template, 'templates/') === 0 ) {
        return '';
    }

    return $title;
}

// =============================================
// AUTO-INJECT HERO ON NON-TEMPLATED PAGES
// Pages WITHOUT templates/* get an automatic hero section built from:
// - Title (H1)
// - Excerpt (if set)
// - Featured image (as background if available)
// This ensures consistent hero design across all pages without needing
// to manually build hero markup via Page Builder.
// =============================================
add_filter('the_content', 'tez_auto_hero_on_pages', 1);
function tez_auto_hero_on_pages( $content ) {
    // Only run on pages (not posts, not admin, not archives)
    if ( ! is_page() || is_admin() || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    // Skip if page is using a templates/* file (those build their own hero)
    $template = get_page_template_slug();
    if ( $template && strpos($template, 'templates/') === 0 ) {
        return $content;
    }

    // Build hero
    $title       = get_the_title();
    $excerpt     = has_excerpt() ? get_the_excerpt() : '';
    $thumbnail   = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $has_image   = ! empty($thumbnail);

    // Inline style for background image
    $bg_style = '';
    if ( $has_image ) {
        $bg_style = ' style="background-image: url(' . esc_url($thumbnail) . ');"';
    }

    // Hero HTML
    $hero = '<div class="tez-page-hero' . ($has_image ? ' tez-has-bg' : '') . '"' . $bg_style . '>';
    $hero .= '<div class="tez-page-hero-overlay"></div>';
    $hero .= '<div class="tez-page-hero-content">';
    $hero .= '<h1 class="tez-page-hero-title">' . esc_html($title) . '</h1>';
    if ( ! empty($excerpt) ) {
        $hero .= '<p class="tez-page-hero-excerpt">' . esc_html($excerpt) . '</p>';
    }
    $hero .= '</div>';
    $hero .= '</div>';

    // Prepend hero before content
    return $hero . $content;
}
