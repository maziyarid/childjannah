<?php
/**
 * Feed Controller
 * Controls RSS feed output and behavior.
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

// Source: Snippets/Feed Controller.php

function tez_feed_config() {
    return array(
        'main_feed'      => true,
        'rss2_feed'      => true,
        'atom_feed'      => true,
        'comments_feed'  => false,
        'products_feed'  => false,
        'post_feeds'     => false,
        'category_feeds' => false,
        'tag_feeds'      => false,
        'author_feeds'   => false,
    );
}

function tez_selective_feed_control() {
    if (!is_feed()) return;
    $config = tez_feed_config();
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

    if (!$config['comments_feed'] && (strpos($request_uri, '/feed/comments') !== false || strpos($request_uri, '/comments/feed') !== false || is_comment_feed())) {
        tez_return_410_feed('comments'); return;
    }
    if (!$config['products_feed'] && strpos($request_uri, '/feed/products') !== false) {
        tez_return_410_feed('products'); return;
    }
    if (!$config['post_feeds'] && (is_singular() && is_feed())) {
        tez_return_410_feed('post'); return;
    }
    if (!$config['category_feeds'] && (is_category() && is_feed())) {
        tez_return_410_feed('category'); return;
    }
    if (!$config['tag_feeds'] && (is_tag() && is_feed())) {
        tez_return_410_feed('tag'); return;
    }
    if (!$config['author_feeds'] && (is_author() && is_feed())) {
        tez_return_410_feed('author'); return;
    }
}
add_action('template_redirect', 'tez_selective_feed_control', 1);

function tez_return_410_feed($feed_type = '') {
    status_header(410);
    nocache_headers();
    @header('Content-Type: text/html; charset=utf-8');
    @header('X-Robots-Tag: noindex, nofollow');
    echo '<!DOCTYPE html><html><head><title>410 Gone</title><meta name="robots" content="noindex, nofollow"></head><body style="font-family:system-ui;max-width:600px;margin:100px auto;text-align:center;"><h1 style="color:#d32f2f">410 Gone</h1><p>This feed (' . esc_html($feed_type) . ') has been permanently removed.</p><p><a href="' . esc_url(home_url('/feed/')) . '">Main RSS feed</a> | <a href="' . esc_url(home_url('/')) . '">Homepage</a></p></body></html>';
    exit;
}

function tez_remove_feed_links_from_head() {
    $config = tez_feed_config();
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    if ($config['main_feed']) {
        add_action('wp_head', 'tez_add_main_feed_link', 2);
    }
}
add_action('init', 'tez_remove_feed_links_from_head');

function tez_add_main_feed_link() {
    $feed_url = get_feed_link();
    if ($feed_url) {
        echo '<link rel="alternate" type="application/rss+xml" title="' . esc_attr(get_bloginfo('name')) . ' RSS Feed" href="' . esc_url($feed_url) . '" />' . "\n";
    }
}

add_filter('wpseo_comments_rss', '__return_false');
add_filter('rank_math/frontend/show_post_feed', function() { $c = tez_feed_config(); return $c['post_feeds']; });

function tez_add_noindex_to_blocked_feeds() {
    if (!is_feed()) return;
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    if (strpos($request_uri, '/feed/comments') !== false || strpos($request_uri, '/feed/products') !== false || strpos($request_uri, '/comments/feed') !== false) {
        @header('X-Robots-Tag: noindex, nofollow');
    }
}
add_action('send_headers', 'tez_add_noindex_to_blocked_feeds');
