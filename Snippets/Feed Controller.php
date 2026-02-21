/**
 * Selective Feed Control - Allow Main Feed, Block Spam Feeds
 * 
 * Features:
 * - ALLOW: /feed/ (main RSS feed - good for subscribers)
 * - BLOCK: /feed/comments (410 Gone - no SEO value)
 * - BLOCK: /feed/products (410 Gone - you don't have WooCommerce)
 * - BLOCK: Individual post/page feeds (410 Gone - unnecessary)
 * - Remove feed links from HTML head (cleaner)
 * 
 * Plugin Name: TEZ Selective Feed Control
 * Version: 2.0.0
 * Updated: Feb 14, 2026
 */

if (!defined('ABSPATH')) exit;

// =============================================
// CONFIGURATION - Feed Control Settings
// =============================================
function tez_feed_config() {
    return array(
        // Allow these feeds (TRUE = allowed)
        'main_feed'      => true,   // /feed/ - Main blog RSS (KEEP for subscribers)
        'rss2_feed'      => true,   // /feed/rss2/ - Alternative format
        'atom_feed'      => true,   // /feed/atom/ - Alternative format

        // Block these feeds (FALSE = blocked with 410)
        'comments_feed'  => false,  // /feed/comments - No SEO value, duplicate content
        'products_feed'  => false,  // /feed/products - Fake (no WooCommerce)
        'post_feeds'     => false,  // /post-name/feed/ - Individual post feeds
        'category_feeds' => false,  // /category/name/feed/ - Category feeds
        'tag_feeds'      => false,  // /tag/name/feed/ - Tag feeds
        'author_feeds'   => false,  // /author/name/feed/ - Author feeds
    );
}

// =============================================
// SELECTIVE FEED BLOCKING WITH 410 GONE
// =============================================
function tez_selective_feed_control() {
    if (!is_feed()) {
        return;
    }

    $config = tez_feed_config();

    // Check what type of feed this is
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

    // BLOCK: /feed/comments or /comments/feed/
    if (!$config['comments_feed'] && (
        strpos($request_uri, '/feed/comments') !== false ||
        strpos($request_uri, '/comments/feed') !== false ||
        is_comment_feed()
    )) {
        tez_return_410_feed('comments');
        return;
    }

    // BLOCK: /feed/products (fake WooCommerce feed)
    if (!$config['products_feed'] && strpos($request_uri, '/feed/products') !== false) {
        tez_return_410_feed('products');
        return;
    }

    // BLOCK: Individual post/page feeds (e.g., /post-name/feed/)
    if (!$config['post_feeds'] && (is_singular() && is_feed())) {
        tez_return_410_feed('post');
        return;
    }

    // BLOCK: Category feeds
    if (!$config['category_feeds'] && (is_category() && is_feed())) {
        tez_return_410_feed('category');
        return;
    }

    // BLOCK: Tag feeds
    if (!$config['tag_feeds'] && (is_tag() && is_feed())) {
        tez_return_410_feed('tag');
        return;
    }

    // BLOCK: Author feeds
    if (!$config['author_feeds'] && (is_author() && is_feed())) {
        tez_return_410_feed('author');
        return;
    }

    // ALLOW: Main feed (/feed/, /feed/rss2/, /feed/atom/)
    // These are explicitly allowed - do nothing, WordPress will serve them
}
add_action('template_redirect', 'tez_selective_feed_control', 1);

// =============================================
// RETURN 410 GONE FOR BLOCKED FEEDS
// =============================================
function tez_return_410_feed($feed_type = '') {
    status_header(410);
    nocache_headers();

    // Set proper headers
    @header('Content-Type: text/html; charset=utf-8');
    @header('X-Robots-Tag: noindex, nofollow');

    // Output message
    echo '<!DOCTYPE html>
<html>
<head>
    <title>410 Gone - Feed No Longer Available</title>
    <meta name="robots" content="noindex, nofollow">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
               max-width: 600px; margin: 100px auto; padding: 20px; text-align: center; }
        h1 { color: #d32f2f; font-size: 48px; margin: 0; }
        p { color: #666; font-size: 18px; line-height: 1.6; }
        a { color: #1976d2; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>410 Gone</h1>
    <p>This feed (' . esc_html($feed_type) . ') has been permanently removed and is no longer available.</p>
    <p>Please use our <a href="' . esc_url(home_url('/feed/')) . '">main RSS feed</a> instead.</p>
    <p><a href="' . esc_url(home_url('/')) . '">← Return to homepage</a></p>
</body>
</html>';

    exit;
}

// =============================================
// REMOVE FEED LINKS FROM HTML HEAD
// =============================================
function tez_remove_feed_links_from_head() {
    $config = tez_feed_config();

    // Remove ALL WordPress default feed links
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);

    // Manually add ONLY the main feed link if allowed
    if ($config['main_feed']) {
        add_action('wp_head', 'tez_add_main_feed_link', 2);
    }
}
add_action('init', 'tez_remove_feed_links_from_head');

function tez_add_main_feed_link() {
    $feed_url = get_feed_link();
    if ($feed_url) {
        echo '<link rel="alternate" type="application/rss+xml" title="' . 
             esc_attr(get_bloginfo('name')) . ' RSS Feed" href="' . 
             esc_url($feed_url) . '" />' . "\n";
    }
}

// =============================================
// REMOVE FEED DISCOVERY FROM REST API
// =============================================
function tez_remove_feed_from_rest_api($response, $server) {
    $config = tez_feed_config();

    if (isset($response->data['_links']['https://api.w.org/feedurl'])) {
        if (!$config['main_feed']) {
            unset($response->data['_links']['https://api.w.org/feedurl']);
        }
    }

    return $response;
}
add_filter('rest_index', 'tez_remove_feed_from_rest_api', 10, 2);

// =============================================
// DISABLE FEED QUERY VARS FOR BLOCKED FEEDS
// =============================================
function tez_disable_feed_query_vars($query_vars) {
    $config = tez_feed_config();

    if (!$config['comments_feed']) {
        // Remove comments feed query var
        $key = array_search('withcomments', $query_vars);
        if ($key !== false) {
            unset($query_vars[$key]);
        }
    }

    return $query_vars;
}
add_filter('query_vars', 'tez_disable_feed_query_vars');

// =============================================
// YOAST / RANKMATH COMPATIBILITY
// =============================================

// Disable comment feeds in Yoast SEO
add_filter('wpseo_comments_rss', '__return_false');

// Disable individual post feeds in RankMath
add_filter('rank_math/frontend/show_post_feed', function() {
    $config = tez_feed_config();
    return $config['post_feeds'];
});

// =============================================
// PREVENT FEED CRAWLING VIA ROBOTS META
// =============================================
function tez_add_noindex_to_blocked_feeds() {
    if (!is_feed()) {
        return;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

    // Add noindex to blocked feed types before 410 kicks in
    if (
        strpos($request_uri, '/feed/comments') !== false ||
        strpos($request_uri, '/feed/products') !== false ||
        strpos($request_uri, '/comments/feed') !== false
    ) {
        @header('X-Robots-Tag: noindex, nofollow');
    }
}
add_action('send_headers', 'tez_add_noindex_to_blocked_feeds');

// =============================================
// ADMIN NOTICE - Feed Configuration Status
// =============================================
function tez_feed_config_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'dashboard') {
        return;
    }

    $config = tez_feed_config();

    ?>
    <div class="notice notice-info">
        <p>
            <strong>🔔 TEZ Feed Control Active:</strong><br>
            Main RSS Feed (/feed/): <?php echo $config['main_feed'] ? '✅ Enabled' : '❌ Disabled'; ?><br>
            Comments Feed: <?php echo $config['comments_feed'] ? '✅ Enabled' : '❌ Blocked (410)'; ?><br>
            Products Feed: <?php echo $config['products_feed'] ? '✅ Enabled' : '❌ Blocked (410)'; ?><br>
            Individual Post Feeds: <?php echo $config['post_feeds'] ? '✅ Enabled' : '❌ Blocked (410)'; ?>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'tez_feed_config_notice');

