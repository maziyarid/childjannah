/**
 * SEO URL Cleanup - Clean Canonicals & Internal Links
 * 
 * Features:
 * - Clean canonical tags (removes tracking params)
 * - Clean internal links automatically
 * - Clean REST API responses
 * - Clean sitemaps
 * - Works WITH .htaccess 410 redirects (no conflict)
 * 
 * Plugin Name: TEZ SEO URL Cleanup v2
 * Version: 2.0.0
 * Updated: Feb 14, 2026
 */

if (!defined('ABSPATH')) exit;

// =============================================
// CONFIGURATION - Tracking Parameters to Clean
// =============================================
function tez_get_tracking_params() {
    return array(
        // Google Analytics / Google Ads
        '_gl', '_ga', '_gac', '_gcl_au', '_gcl_aw', '_gcl_dc', 
        '_gclid', 'gclid', 'gclsrc', '_gid', 'dclid', 'wbraid', 'gbraid',

        // Facebook / Meta
        'fbclid', 'fb_action_ids', 'fb_action_types', 'fb_source', 'fb_ref',

        // Microsoft / Bing
        'msclkid',

        // Custom tracking
        '_bdsid', '_bd_prev_page', 'oklmdl', 'af676169',

        // Email Marketing
        'mc_cid', 'mc_eid',

        // HubSpot
        '_hsenc', '_hsmi', '__hstc', '__hsfp', 'hsCtaTracking',

        // Marketo
        'mkt_tok',

        // Affiliate / Other
        'zanpid', 'irclickid', 'clickid', '_ke',
        'trk_contact', 'trk_msg', 'trk_module', 'trk_sid',

        // Session tracking
        'sessionid', 'phpsessid',

        // Misc
        'ref', 'ref_', 'affiliate_id', 'partner_id',

        // Spam parameters from your GSC data
        'e', 'channel', 'from', 'route', 'h', 'mod', 'uri', 'MA',
        'NA', 'ND', 'NB', 'NC', 'CA',
    );
}

// =============================================
// CANONICAL TAG - Clean & Proper
// =============================================
function tez_setup_clean_canonical() {
    if (is_admin()) {
        return;
    }

    // Priority handling - run early to override SEO plugins
    add_filter('wpseo_canonical', 'tez_filter_canonical_url', 999);
    add_filter('rank_math/frontend/canonical', 'tez_filter_canonical_url', 999);
    add_filter('aioseop_canonical_url', 'tez_filter_canonical_url', 999);
}
add_action('wp', 'tez_setup_clean_canonical');

function tez_filter_canonical_url($url) {
    if (empty($url)) {
        return $url;
    }
    return remove_query_arg(tez_get_tracking_params(), $url);
}

// =============================================
// CLEAN INTERNAL LINKS AUTOMATICALLY
// =============================================
function tez_clean_internal_links($url) {
    if (empty($url)) {
        return $url;
    }

    // Only process internal links
    $site_host = parse_url(home_url(), PHP_URL_HOST);
    $url_host = parse_url($url, PHP_URL_HOST);

    if ($url_host && $url_host !== $site_host) {
        return $url;
    }

    return remove_query_arg(tez_get_tracking_params(), $url);
}

// Apply to all link types
$link_filters = array(
    'the_permalink', 'post_link', 'page_link', 'term_link',
    'post_type_link', 'attachment_link', 'year_link', 'month_link',
    'day_link', 'category_link', 'tag_link', 'author_link'
);

foreach ($link_filters as $filter) {
    add_filter($filter, 'tez_clean_internal_links', 999);
}

// =============================================
// HTTP LINK HEADER FOR CANONICAL
// =============================================
function tez_add_canonical_http_header() {
    if (is_admin() || headers_sent() || wp_doing_ajax()) {
        return;
    }

    $canonical = '';

    if (function_exists('rank_math_get_canonical')) {
        $canonical = rank_math_get_canonical();
    } elseif (class_exists('WPSEO_Frontend')) {
        $canonical = WPSEO_Frontend::get_instance()->canonical(false);
    } else {
        $canonical = wp_get_canonical_url();
    }

    if ($canonical && !is_wp_error($canonical)) {
        $canonical = remove_query_arg(tez_get_tracking_params(), $canonical);
        @header('Link: <' . esc_url($canonical) . '>; rel="canonical"', false);
    }
}
add_action('send_headers', 'tez_add_canonical_http_header', 999);

// =============================================
// CLEAN REST API LINKS
// =============================================
function tez_clean_rest_url($url) {
    return remove_query_arg(tez_get_tracking_params(), $url);
}
add_filter('rest_url', 'tez_clean_rest_url', 999);

// =============================================
// CLEAN SITEMAPS
// =============================================
function tez_clean_sitemap_url($url) {
    return remove_query_arg(tez_get_tracking_params(), $url);
}

// WordPress core sitemaps
add_filter('wp_sitemaps_posts_entry', function($entry) {
    if (isset($entry['loc'])) {
        $entry['loc'] = tez_clean_sitemap_url($entry['loc']);
    }
    return $entry;
}, 999);

add_filter('wp_sitemaps_taxonomies_entry', function($entry) {
    if (isset($entry['loc'])) {
        $entry['loc'] = tez_clean_sitemap_url($entry['loc']);
    }
    return $entry;
}, 999);

// Yoast SEO sitemaps
add_filter('wpseo_sitemap_entry', function($entry) {
    if (isset($entry['loc'])) {
        $entry['loc'] = tez_clean_sitemap_url($entry['loc']);
    }
    return $entry;
}, 999);

// RankMath sitemaps
add_filter('rank_math/sitemap/entry', function($entry) {
    if (isset($entry['loc'])) {
        $entry['loc'] = tez_clean_sitemap_url($entry['loc']);
    }
    return $entry;
}, 999);

// =============================================
// CLEAN REDIRECT URLs (Internal Only)
// =============================================
function tez_clean_redirect_url($location) {
    $site_host = parse_url(home_url(), PHP_URL_HOST);
    $redirect_host = parse_url($location, PHP_URL_HOST);

    if (!$redirect_host || $redirect_host === $site_host) {
        return remove_query_arg(tez_get_tracking_params(), $location);
    }

    return $location;
}
add_filter('wp_redirect', 'tez_clean_redirect_url', 999);

// =============================================
// PREVENT TRACKING PARAM INDEXING VIA META TAG
// =============================================
function tez_add_noindex_for_tracking_params() {
    if (is_admin()) {
        return;
    }

    $tracking_params = tez_get_tracking_params();
    $has_tracking = false;

    foreach ($tracking_params as $param) {
        if (isset($_GET[$param]) && !empty($_GET[$param])) {
            $has_tracking = true;
            break;
        }
    }

    if ($has_tracking) {
        echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    }
}
add_action('wp_head', 'tez_add_noindex_for_tracking_params', 1);

// =============================================
// CLEAN SCHEMA/STRUCTURED DATA
// =============================================
function tez_clean_schema_urls($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
                $data[$key] = remove_query_arg(tez_get_tracking_params(), $value);
            } elseif (is_array($value)) {
                $data[$key] = tez_clean_schema_urls($value);
            }
        }
    }
    return $data;
}

// RankMath schema
add_filter('rank_math/json_ld', 'tez_clean_schema_urls', 999);

// Yoast schema
add_filter('wpseo_schema_graph', 'tez_clean_schema_urls', 999);

