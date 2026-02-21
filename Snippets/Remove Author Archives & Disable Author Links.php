/**
 * Remove Author Archives & Disable Author Links
 * Version: 1.0.0
 * Compatible with: Jannah Theme & General WordPress
 */

if (!defined('ABSPATH')) exit;

// =============================================
// 1. DISABLE AUTHOR ARCHIVE PAGES (404)
// =============================================

/**
 * Return 404 for author archive pages
 * This completely removes author archives from your site [[9]]
 */
add_action('template_redirect', 'tez_disable_author_archives', 1);
function tez_disable_author_archives() {
    if (is_author()) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        
        // Load 404 template if exists
        $template = get_404_template();
        if ($template) {
            include($template);
            exit;
        }
    }
}

/**
 * Alternative: Redirect author pages to homepage (uncomment if you prefer redirect)
 * Uses 301 permanent redirect [[5]]
 */
/*
add_action('template_redirect', 'tez_redirect_author_archives', 1);
function tez_redirect_author_archives() {
    if (is_author()) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}
*/

// =============================================
// 2. REMOVE AUTHOR LINKS FROM POSTS
// =============================================

/**
 * Remove link from author name - returns plain text
 * Filters the_author_posts_link to return just the name [[10]]
 */
add_filter('the_author_posts_link', 'tez_remove_author_link');
function tez_remove_author_link($link) {
    // Extract author name from the link and return as plain text
    $author_name = get_the_author();
    return '<span class="author-name">' . esc_html($author_name) . '</span>';
}

/**
 * Filter author link URL to return empty/current page
 */
add_filter('author_link', 'tez_disable_author_link_url', 10, 3);
function tez_disable_author_link_url($link, $author_id, $author_nicename) {
    return 'javascript:void(0);';
}

/**
 * Remove author from post meta by making links non-clickable
 */
add_filter('get_the_author_link', 'tez_remove_author_link_filter');
function tez_remove_author_link_filter($link) {
    $author_name = get_the_author();
    return '<span class="author-name">' . esc_html($author_name) . '</span>';
}

// =============================================
// 3. JANNAH THEME SPECIFIC OVERRIDES
// =============================================

/**
 * Override Jannah theme author link output
 */
add_filter('tie_get_author_link', 'tez_jannah_remove_author_link');
add_filter('TieLabs/author_link', 'tez_jannah_remove_author_link');
function tez_jannah_remove_author_link($link) {
    $author_name = get_the_author();
    return '<span class="author-name">' . esc_html($author_name) . '</span>';
}

/**
 * Filter post meta to remove author links in Jannah
 */
add_filter('tie_post_meta', 'tez_jannah_filter_post_meta', 20);
add_filter('TieLabs/post_meta', 'tez_jannah_filter_post_meta', 20);
function tez_jannah_filter_post_meta($meta) {
    if (is_array($meta) && isset($meta['author'])) {
        // Keep author but ensure no link
        $meta['author_link'] = false;
    }
    return $meta;
}

// =============================================
// 4. REMOVE AUTHOR LINKS VIA OUTPUT BUFFER
// =============================================

/**
 * Fallback: Remove author links from rendered HTML
 * This catches any author links that slip through filters
 */
add_action('wp_loaded', 'tez_start_author_link_buffer');
function tez_start_author_link_buffer() {
    if (!is_admin()) {
        ob_start('tez_remove_author_links_from_html');
    }
}

function tez_remove_author_links_from_html($html) {
    // Pattern to match author archive links
    $patterns = array(
        // Match links to /author/username/
        '/<a\s+[^>]*href=["\'][^"\']*\/author\/[^"\']*["\'][^>]*>(.*?)<\/a>/is',
        // Match links with rel="author"
        '/<a\s+[^>]*rel=["\']author["\'][^>]*>(.*?)<\/a>/is',
    );
    
    foreach ($patterns as $pattern) {
        $html = preg_replace_callback($pattern, function($matches) {
            // Return just the text content wrapped in a span
            return '<span class="author-name">' . strip_tags($matches[1]) . '</span>';
        }, $html);
    }
    
    return $html;
}

// =============================================
// 5. REMOVE AUTHOR FROM REST API & FEEDS
// =============================================

/**
 * Remove author information from REST API responses
 */
add_filter('rest_prepare_post', 'tez_remove_author_from_rest', 10, 3);
function tez_remove_author_from_rest($response, $post, $request) {
    // Remove author link from REST API
    if (isset($response->data['_links']['author'])) {
        unset($response->data['_links']['author']);
    }
    return $response;
}

/**
 * Remove author archives from XML sitemap
 */
add_filter('wp_sitemaps_add_provider', 'tez_remove_author_sitemap', 10, 2);
function tez_remove_author_sitemap($provider, $name) {
    if ($name === 'users') {
        return false;
    }
    return $provider;
}

/**
 * Remove author from RSS feeds
 */
add_filter('the_author', 'tez_anonymize_feed_author');
function tez_anonymize_feed_author($author) {
    if (is_feed()) {
        return get_bloginfo('name'); // Replace with site name in feeds
    }
    return $author;
}

// =============================================
// 6. REMOVE AUTHOR LINK FROM HEAD
// =============================================

/**
 * Remove author link from document head
 */
remove_action('wp_head', 'wp_author_link_head');

/**
 * Remove author meta tags
 */
add_action('wp_head', 'tez_remove_author_meta', 1);
function tez_remove_author_meta() {
    // Remove via output buffer for head section
    ob_start(function($output) {
        // Remove author meta tags
        $output = preg_replace('/<link[^>]*rel=["\']author["\'][^>]*>/i', '', $output);
        $output = preg_replace('/<meta[^>]*name=["\']author["\'][^>]*>/i', '', $output);
        return $output;
    });
}

add_action('wp_head', function() {
    ob_end_flush();
}, 999);

// =============================================
// 7. CSS TO ENSURE NO AUTHOR LINKS ARE CLICKABLE
// =============================================

add_action('wp_head', 'tez_author_link_css', 99);
function tez_author_link_css() {
    ?>
    <style id="tez-disable-author-links">
    /* Make any remaining author links non-clickable */
    a[href*="/author/"],
    a[rel="author"],
    .post-meta a[href*="/author/"],
    .entry-meta a[href*="/author/"],
    .tie-post-meta a[href*="/author/"],
    .author-box a[href*="/author/"],
    .meta-info a[href*="/author/"] {
        pointer-events: none !important;
        cursor: default !important;
        color: inherit !important;
        text-decoration: none !important;
    }
    
    /* Style the author name span */
    .author-name {
        font-weight: inherit;
        color: inherit;
    }
    
    /* Keep author box visible but remove link styling */
    .author-box,
    .tie-author-box,
    .single-post-meta .author,
    .post-author {
        display: block;
    }
    
    .author-box a[href*="/author/"],
    .tie-author-box a[href*="/author/"] {
        pointer-events: none !important;
        text-decoration: none !important;
    }
    </style>
    <?php
}

// =============================================
// 8. BLOCK AUTHOR ENUMERATION (SECURITY)
// =============================================

/**
 * Prevent author enumeration via ?author=1 queries
 * Security measure to prevent user discovery
 */
add_action('template_redirect', 'tez_block_author_enumeration');
function tez_block_author_enumeration() {
    if (isset($_GET['author']) && !is_admin()) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}

/**
 * Remove author query var
 */
add_filter('query_vars', 'tez_remove_author_query_var');
function tez_remove_author_query_var($vars) {
    if (!is_admin()) {
        $key = array_search('author', $vars);
        if ($key !== false) {
            unset($vars[$key]);
        }
        $key = array_search('author_name', $vars);
        if ($key !== false) {
            unset($vars[$key]);
        }
    }
    return $vars;
}

// =============================================
// 9. YOAST SEO / RANK MATH COMPATIBILITY
// =============================================

/**
 * Disable author archives in Yoast SEO
 */
add_filter('wpseo_author_archive', '__return_false');

/**
 * Disable author archives in Rank Math
 */
add_filter('rank_math/sitemap/exclude_author', '__return_true');

/**
 * Remove author from Yoast schema
 */
add_filter('wpseo_schema_graph_pieces', 'tez_remove_author_schema', 10, 2);
function tez_remove_author_schema($pieces, $context) {
    return array_filter($pieces, function($piece) {
        return !($piece instanceof \Yoast\WP\SEO\Generators\Schema\Author);
    });
}
