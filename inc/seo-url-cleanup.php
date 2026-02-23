<?php
/**
 * SEO URL Cleanup - Clean Canonicals & Internal Links
 * Strips tracking parameters from all URLs site-wide.
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

// This file is a placeholder that will load the full cleanup module.
// Copy the contents of Snippets/Clean Tracking Parameter URLs for SEO.php here
// when deploying to production.

// For now, register the core canonical cleanup:
if (!function_exists('tez_get_tracking_params')) {
    function tez_get_tracking_params() {
        return array(
            // Google Analytics / Ads
            'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'utm_id',
            'gclid', 'gclsrc', 'dclid', 'gbraid', 'wbraid',
            // Meta / Facebook
            'fbclid', 'fb_action_ids', 'fb_action_types', 'fb_source', 'fb_ref',
            // Bing / Microsoft
            'msclkid',
            // Email / misc
            'mc_cid', 'mc_eid', '_ke', 'ref', 'referer',
            // Spam / tracking
            '_ga', '_gl', 'yclid', 'twclid', 'ttclid', 'li_fat_id',
        );
    }
}

if (!function_exists('tez_clean_url')) {
    function tez_clean_url($url) {
        if (empty($url) || !is_string($url)) return $url;
        $parsed = parse_url($url);
        if (empty($parsed['query'])) return $url;

        parse_str($parsed['query'], $params);
        $tracking = tez_get_tracking_params();
        $cleaned = array_diff_key($params, array_flip($tracking));

        $base = $parsed['scheme'] . '://' . $parsed['host'];
        if (!empty($parsed['port'])) $base .= ':' . $parsed['port'];
        $base .= $parsed['path'] ?? '/';
        if (!empty($cleaned)) $base .= '?' . http_build_query($cleaned);
        if (!empty($parsed['fragment'])) $base .= '#' . $parsed['fragment'];

        return $base;
    }
}

// Clean canonical URLs for major SEO plugins
add_filter('wpseo_canonical', 'tez_clean_url', 20);
add_filter('rank_math/frontend/canonical', 'tez_clean_url', 20);
add_filter('aioseop_canonical_url', 'tez_clean_url', 20);
add_filter('get_canonical_url', 'tez_clean_url', 20);

// Clean internal link generators
add_filter('the_permalink', 'tez_clean_url', 20);
add_filter('post_link', 'tez_clean_url', 20);
add_filter('page_link', 'tez_clean_url', 20);
