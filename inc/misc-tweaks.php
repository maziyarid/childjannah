<?php
/**
 * Miscellaneous Tweaks
 * - Remove email field from comments
 * - Remove page titles on custom templates
 * - Strip legacy injected hero blocks (self-healing)
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
    if ( $id === null || ! is_page($id) ) return $title;
    if ( ! in_the_loop() || is_admin() ) return $title;

    $template = get_page_template_slug($id);
    if ( $template && strpos($template, 'templates/') === 0 ) {
        return '';
    }

    return $title;
}

// =============================================
// STRIP LEGACY INJECTED HERO BLOCKS (SELF-HEALING)
// Runs at priority 0 — BEFORE auto-hero injection (priority 1).
//
// Background: a previous iteration manually pasted hero HTML blocks
// directly into page content via the editor. Those blocks used
// class="tez-page-hero--injected" and class="tez-page-content-wrap--injected".
// Some also contained raw PHP tags that rendered as visible text.
//
// This filter automatically removes those patterns from the stored
// post_content so editors don't have to manually clean each page.
// It is a no-op (instant bail) once all pages are clean.
// =============================================
add_filter('the_content', 'tez_strip_legacy_injected_blocks', 0);
function tez_strip_legacy_injected_blocks( $content ) {
    if ( ! is_page() || is_admin() || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    // Fast bail: only run regex if the specific markers are present
    $has_injected_hero    = strpos($content, 'tez-page-hero--injected') !== false;
    $has_injected_wrapper = strpos($content, 'tez-page-content-wrap--injected') !== false;

    if ( ! $has_injected_hero && ! $has_injected_wrapper ) {
        return $content;
    }

    // Strip the injected hero section (including all its contents)
    if ( $has_injected_hero ) {
        $content = preg_replace(
            '/<section[^>]*tez-page-hero--injected[^>]*>[\s\S]*?<\/section>\s*/i',
            '',
            $content
        );
    }

    // Strip the injected wrapper div but KEEP its inner content
    if ( $has_injected_wrapper ) {
        $content = preg_replace(
            '/<div[^>]*tez-page-content-wrap--injected[^>]*>([\s\S]*?)<\/div>\s*$/i',
            '$1',
            $content
        );
    }

    return $content;
}

// =============================================
// AUTO-INJECT HERO ON NON-TEMPLATED PAGES
// Pages WITHOUT a templates/* file get an automatic hero section
// built from:
//   - Title (H1)
//   - Excerpt (subtitle, if set in page editor)
//   - Featured image (as full-cover background, if set)
//
// This ensures consistent hero design across all standard pages
// without needing page-builder markup or manual HTML in the editor.
//
// Priority 1 — runs AFTER the cleanup filter (priority 0) so we
// never accidentally strip the hero we just added.
// =============================================
add_filter('the_content', 'tez_auto_hero_on_pages', 1);
function tez_auto_hero_on_pages( $content ) {
    if ( ! is_page() || is_admin() || ! in_the_loop() || ! is_main_query() ) {
        return $content;
    }

    // Skip pages using Tez templates (they build their own full hero)
    $template = get_page_template_slug();
    if ( $template && strpos($template, 'templates/') === 0 ) {
        return $content;
    }

    // Data
    $title     = get_the_title();
    $excerpt   = has_excerpt() ? get_the_excerpt() : '';
    $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    $has_image = ! empty( $thumb_url );

    // Build class list and optional inline bg
    $classes  = 'tez-page-hero';
    $bg_style = '';
    if ( $has_image ) {
        $classes  .= ' tez-has-bg';
        $bg_style  = ' style="background-image:url(' . esc_url($thumb_url) . ');"';
    }

    // Hero HTML — mirrors the structure used in template files
    $hero  = '<div class="' . esc_attr($classes) . '"' . $bg_style . '>';
    $hero .= '<div class="tez-page-hero-overlay"></div>';
    $hero .= '<div class="tez-page-hero-content">';
    $hero .= '<div class="tez-hero-container">';
    $hero .= '<h1 class="tez-page-hero-title">' . esc_html($title) . '</h1>';
    if ( ! empty($excerpt) ) {
        $hero .= '<p class="tez-page-hero-excerpt">' . esc_html($excerpt) . '</p>';
    }
    $hero .= '</div>';
    $hero .= '</div>';
    $hero .= '</div>';

    return $hero . $content;
}
