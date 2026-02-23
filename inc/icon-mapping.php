<?php
/**
 * Jannah to Font Awesome Icon Mapping
 * Maps Jannah's built-in icons to Font Awesome 7 equivalents.
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

// Source: Snippets/Jannah to Font Awesome.php
// Full icon mapping and output buffer replacement

function tez_get_icon_mapping() {
    return array(
        'tie-icon-facebook' => 'fa-brands fa-facebook-f', 'tie-icon-facebook-f' => 'fa-brands fa-facebook-f',
        'tie-icon-twitter' => 'fa-brands fa-x-twitter', 'tie-icon-instagram' => 'fa-brands fa-instagram',
        'tie-icon-youtube' => 'fa-brands fa-youtube', 'tie-icon-linkedin' => 'fa-brands fa-linkedin-in',
        'tie-icon-pinterest' => 'fa-brands fa-pinterest-p', 'tie-icon-telegram' => 'fa-brands fa-telegram',
        'tie-icon-whatsapp' => 'fa-brands fa-whatsapp', 'tie-icon-tiktok' => 'fa-brands fa-tiktok',
        'tie-icon-reddit' => 'fa-brands fa-reddit-alien', 'tie-icon-github' => 'fa-brands fa-github',
        'tie-icon-rss' => 'fa-solid fa-rss', 'tie-icon-home' => 'fa-solid fa-house',
        'tie-icon-search' => 'fa-solid fa-magnifying-glass', 'tie-icon-menu' => 'fa-solid fa-bars',
        'tie-icon-close' => 'fa-solid fa-xmark', 'tie-icon-times' => 'fa-solid fa-xmark',
        'tie-icon-check' => 'fa-solid fa-check', 'tie-icon-plus' => 'fa-solid fa-plus',
        'tie-icon-minus' => 'fa-solid fa-minus', 'tie-icon-edit' => 'fa-solid fa-pen',
        'tie-icon-settings' => 'fa-solid fa-gear', 'tie-icon-cog' => 'fa-solid fa-gear',
        'tie-icon-share' => 'fa-solid fa-share-nodes', 'tie-icon-share-alt' => 'fa-solid fa-share-nodes',
        'tie-icon-download' => 'fa-solid fa-download', 'tie-icon-upload' => 'fa-solid fa-upload',
        'tie-icon-print' => 'fa-solid fa-print', 'tie-icon-link' => 'fa-solid fa-link',
        'tie-icon-external-link' => 'fa-solid fa-arrow-up-right-from-square',
        'tie-icon-arrow-up' => 'fa-solid fa-arrow-up', 'tie-icon-arrow-down' => 'fa-solid fa-arrow-down',
        'tie-icon-arrow-left' => 'fa-solid fa-arrow-left', 'tie-icon-arrow-right' => 'fa-solid fa-arrow-right',
        'tie-icon-chevron-up' => 'fa-solid fa-chevron-up', 'tie-icon-chevron-down' => 'fa-solid fa-chevron-down',
        'tie-icon-chevron-left' => 'fa-solid fa-chevron-left', 'tie-icon-chevron-right' => 'fa-solid fa-chevron-right',
        'tie-icon-angle-up' => 'fa-solid fa-angle-up', 'tie-icon-angle-down' => 'fa-solid fa-angle-down',
        'tie-icon-fire' => 'fa-solid fa-fire', 'tie-icon-bolt' => 'fa-solid fa-bolt',
        'tie-icon-star' => 'fa-solid fa-star', 'tie-icon-star-o' => 'fa-regular fa-star',
        'tie-icon-heart' => 'fa-solid fa-heart', 'tie-icon-heart-o' => 'fa-regular fa-heart',
        'tie-icon-bookmark' => 'fa-solid fa-bookmark', 'tie-icon-bookmark-o' => 'fa-regular fa-bookmark',
        'tie-icon-comment' => 'fa-solid fa-comment', 'tie-icon-comments' => 'fa-solid fa-comments',
        'tie-icon-eye' => 'fa-solid fa-eye', 'tie-icon-clock' => 'fa-solid fa-clock',
        'tie-icon-calendar' => 'fa-solid fa-calendar', 'tie-icon-image' => 'fa-solid fa-image',
        'tie-icon-video' => 'fa-solid fa-video', 'tie-icon-play' => 'fa-solid fa-play',
        'tie-icon-music' => 'fa-solid fa-music', 'tie-icon-user' => 'fa-solid fa-user',
        'tie-icon-users' => 'fa-solid fa-users', 'tie-icon-lock' => 'fa-solid fa-lock',
        'tie-icon-envelope' => 'fa-solid fa-envelope', 'tie-icon-email' => 'fa-solid fa-envelope',
        'tie-icon-phone' => 'fa-solid fa-phone', 'tie-icon-location' => 'fa-solid fa-location-dot',
        'tie-icon-map-marker' => 'fa-solid fa-location-dot', 'tie-icon-globe' => 'fa-solid fa-globe',
        'tie-icon-file' => 'fa-solid fa-file', 'tie-icon-folder' => 'fa-solid fa-folder',
        'tie-icon-newspaper' => 'fa-solid fa-newspaper', 'tie-icon-book' => 'fa-solid fa-book',
        'tie-icon-tag' => 'fa-solid fa-tag', 'tie-icon-tags' => 'fa-solid fa-tags',
        'tie-icon-cart' => 'fa-solid fa-cart-shopping', 'tie-icon-store' => 'fa-solid fa-store',
        'tie-icon-category' => 'fa-solid fa-folder', 'tie-icon-sitemap' => 'fa-solid fa-sitemap',
        'tie-icon-info' => 'fa-solid fa-circle-info', 'tie-icon-question' => 'fa-solid fa-circle-question',
        'tie-icon-warning' => 'fa-solid fa-triangle-exclamation',
        'tie-icon-sun' => 'fa-solid fa-sun', 'tie-icon-moon' => 'fa-solid fa-moon',
        'tie-icon-lightbulb' => 'fa-solid fa-lightbulb', 'tie-icon-code' => 'fa-solid fa-code',
        'tie-icon-trophy' => 'fa-solid fa-trophy', 'tie-icon-rocket' => 'fa-solid fa-rocket',
        'tie-icon-graduation' => 'fa-solid fa-graduation-cap', 'tie-icon-briefcase' => 'fa-solid fa-briefcase',
        'tie-icon-contrast' => 'fa-solid fa-circle-half-stroke', 'tie-icon-dark-mode' => 'fa-solid fa-moon',
        'tie-icon-light-mode' => 'fa-solid fa-sun',
        'tie-icon-prev' => 'fa-solid fa-chevron-right', 'tie-icon-next' => 'fa-solid fa-chevron-left',
    );
}

add_action('template_redirect', 'tez_icon_start_buffer');
function tez_icon_start_buffer() {
    if (is_admin()) return;
    ob_start('tez_icon_replace_buffer');
}

add_action('shutdown', 'tez_icon_end_buffer', 0);
function tez_icon_end_buffer() {
    if (is_admin()) return;
    if (ob_get_level() > 0) ob_end_flush();
}

function tez_icon_replace_buffer($html) {
    if (empty($html)) return $html;
    $mapping = tez_get_icon_mapping();
    foreach ($mapping as $tie_icon => $fa_icon) {
        $html = str_replace('class="' . $tie_icon . '"', 'class="' . $fa_icon . '"', $html);
        $html = str_replace(' ' . $tie_icon . '"', ' ' . $fa_icon . '"', $html);
        $html = str_replace(' ' . $tie_icon . ' ', ' ' . $fa_icon . ' ', $html);
        $html = str_replace('"' . $tie_icon . ' ', '"' . $fa_icon . ' ', $html);
    }
    $html = preg_replace_callback('/class="([^"]*)\btie-icon-([a-zA-Z0-9_-]+)\b([^"]*)"/', function($matches) {
        $mapping = tez_get_icon_mapping();
        $tie_class = 'tie-icon-' . $matches[2];
        if (isset($mapping[$tie_class])) return $matches[0];
        return 'class="' . $matches[1] . 'fa-solid fa-circle' . $matches[3] . '"';
    }, $html);
    return $html;
}
