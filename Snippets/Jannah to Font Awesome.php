/**
 * Teznevisan: Replace Jannah Icons with Font Awesome
 * Version: 1.0.0
 * Converts tie-icon-* classes to Font Awesome icons
 */

if (!defined('ABSPATH')) exit;

// =============================================
// 1. ICON MAPPING ARRAY
// =============================================
function tez_get_icon_mapping() {
    return array(
        // Social & Brand Icons
        'tie-icon-facebook'         => 'fa-brands fa-facebook-f',
        'tie-icon-facebook-f'       => 'fa-brands fa-facebook-f',
        'tie-icon-twitter'          => 'fa-brands fa-x-twitter',
        'tie-icon-instagram'        => 'fa-brands fa-instagram',
        'tie-icon-youtube'          => 'fa-brands fa-youtube',
        'tie-icon-linkedin'         => 'fa-brands fa-linkedin-in',
        'tie-icon-pinterest'        => 'fa-brands fa-pinterest-p',
        'tie-icon-telegram'         => 'fa-brands fa-telegram',
        'tie-icon-whatsapp'         => 'fa-brands fa-whatsapp',
        'tie-icon-tiktok'           => 'fa-brands fa-tiktok',
        'tie-icon-snapchat'         => 'fa-brands fa-snapchat',
        'tie-icon-reddit'           => 'fa-brands fa-reddit-alien',
        'tie-icon-tumblr'           => 'fa-brands fa-tumblr',
        'tie-icon-flickr'           => 'fa-brands fa-flickr',
        'tie-icon-vimeo'            => 'fa-brands fa-vimeo-v',
        'tie-icon-dribbble'         => 'fa-brands fa-dribbble',
        'tie-icon-behance'          => 'fa-brands fa-behance',
        'tie-icon-github'           => 'fa-brands fa-github',
        'tie-icon-soundcloud'       => 'fa-brands fa-soundcloud',
        'tie-icon-spotify'          => 'fa-brands fa-spotify',
        'tie-icon-apple'            => 'fa-brands fa-apple',
        'tie-icon-android'          => 'fa-brands fa-android',
        'tie-icon-windows'          => 'fa-brands fa-windows',
        'tie-icon-skype'            => 'fa-brands fa-skype',
        'tie-icon-slack'            => 'fa-brands fa-slack',
        'tie-icon-discord'          => 'fa-brands fa-discord',
        'tie-icon-twitch'           => 'fa-brands fa-twitch',
        'tie-icon-medium'           => 'fa-brands fa-medium',
        'tie-icon-rss'              => 'fa-solid fa-rss',
        'tie-icon-rss-feed'         => 'fa-solid fa-rss',
        
        // UI Icons - Navigation & Actions
        'tie-icon-home'             => 'fa-solid fa-house',
        'tie-icon-search'           => 'fa-solid fa-magnifying-glass',
        'tie-icon-menu'             => 'fa-solid fa-bars',
        'tie-icon-close'            => 'fa-solid fa-xmark',
        'tie-icon-times'            => 'fa-solid fa-xmark',
        'tie-icon-check'            => 'fa-solid fa-check',
        'tie-icon-plus'             => 'fa-solid fa-plus',
        'tie-icon-minus'            => 'fa-solid fa-minus',
        'tie-icon-edit'             => 'fa-solid fa-pen',
        'tie-icon-trash'            => 'fa-solid fa-trash',
        'tie-icon-settings'         => 'fa-solid fa-gear',
        'tie-icon-cog'              => 'fa-solid fa-gear',
        'tie-icon-spinner'          => 'fa-solid fa-spinner',
        'tie-icon-refresh'          => 'fa-solid fa-rotate',
        'tie-icon-sync'             => 'fa-solid fa-arrows-rotate',
        'tie-icon-external-link'    => 'fa-solid fa-arrow-up-right-from-square',
        'tie-icon-link'             => 'fa-solid fa-link',
        'tie-icon-unlink'           => 'fa-solid fa-link-slash',
        'tie-icon-download'         => 'fa-solid fa-download',
        'tie-icon-upload'           => 'fa-solid fa-upload',
        'tie-icon-share'            => 'fa-solid fa-share-nodes',
        'tie-icon-share-alt'        => 'fa-solid fa-share-nodes',
        'tie-icon-print'            => 'fa-solid fa-print',
        'tie-icon-copy'             => 'fa-solid fa-copy',
        'tie-icon-paste'            => 'fa-solid fa-paste',
        'tie-icon-cut'              => 'fa-solid fa-scissors',
        'tie-icon-save'             => 'fa-solid fa-floppy-disk',
        'tie-icon-undo'             => 'fa-solid fa-rotate-left',
        'tie-icon-redo'             => 'fa-solid fa-rotate-right',
        'tie-icon-expand'           => 'fa-solid fa-expand',
        'tie-icon-compress'         => 'fa-solid fa-compress',
        'tie-icon-fullscreen'       => 'fa-solid fa-maximize',
        'tie-icon-filter'           => 'fa-solid fa-filter',
        'tie-icon-sort'             => 'fa-solid fa-sort',
        'tie-icon-list'             => 'fa-solid fa-list',
        'tie-icon-grid'             => 'fa-solid fa-grip',
        'tie-icon-th'               => 'fa-solid fa-table-cells',
        'tie-icon-th-large'         => 'fa-solid fa-table-cells-large',
        
        // Arrows & Chevrons
        'tie-icon-arrow-up'         => 'fa-solid fa-arrow-up',
        'tie-icon-arrow-down'       => 'fa-solid fa-arrow-down',
        'tie-icon-arrow-left'       => 'fa-solid fa-arrow-left',
        'tie-icon-arrow-right'      => 'fa-solid fa-arrow-right',
        'tie-icon-chevron-up'       => 'fa-solid fa-chevron-up',
        'tie-icon-chevron-down'     => 'fa-solid fa-chevron-down',
        'tie-icon-chevron-left'     => 'fa-solid fa-chevron-left',
        'tie-icon-chevron-right'    => 'fa-solid fa-chevron-right',
        'tie-icon-angle-up'         => 'fa-solid fa-angle-up',
        'tie-icon-angle-down'       => 'fa-solid fa-angle-down',
        'tie-icon-angle-left'       => 'fa-solid fa-angle-left',
        'tie-icon-angle-right'      => 'fa-solid fa-angle-right',
        'tie-icon-caret-up'         => 'fa-solid fa-caret-up',
        'tie-icon-caret-down'       => 'fa-solid fa-caret-down',
        'tie-icon-caret-left'       => 'fa-solid fa-caret-left',
        'tie-icon-caret-right'      => 'fa-solid fa-caret-right',
        'tie-icon-angles-left'      => 'fa-solid fa-angles-left',
        'tie-icon-angles-right'     => 'fa-solid fa-angles-right',
        
        // Content & Media Icons
        'tie-icon-fire'             => 'fa-solid fa-fire',
        'tie-icon-bolt'             => 'fa-solid fa-bolt',
        'tie-icon-trending'         => 'fa-solid fa-arrow-trend-up',
        'tie-icon-hot'              => 'fa-solid fa-fire-flame-curved',
        'tie-icon-star'             => 'fa-solid fa-star',
        'tie-icon-star-o'           => 'fa-regular fa-star',
        'tie-icon-star-half'        => 'fa-solid fa-star-half-stroke',
        'tie-icon-heart'            => 'fa-solid fa-heart',
        'tie-icon-heart-o'          => 'fa-regular fa-heart',
        'tie-icon-like'             => 'fa-solid fa-thumbs-up',
        'tie-icon-dislike'          => 'fa-solid fa-thumbs-down',
        'tie-icon-bookmark'         => 'fa-solid fa-bookmark',
        'tie-icon-bookmark-o'       => 'fa-regular fa-bookmark',
        'tie-icon-flag'             => 'fa-solid fa-flag',
        'tie-icon-flag-o'           => 'fa-regular fa-flag',
        'tie-icon-bell'             => 'fa-solid fa-bell',
        'tie-icon-bell-o'           => 'fa-regular fa-bell',
        'tie-icon-comment'          => 'fa-solid fa-comment',
        'tie-icon-comment-o'        => 'fa-regular fa-comment',
        'tie-icon-comments'         => 'fa-solid fa-comments',
        'tie-icon-comments-o'       => 'fa-regular fa-comments',
        'tie-icon-eye'              => 'fa-solid fa-eye',
        'tie-icon-eye-slash'        => 'fa-solid fa-eye-slash',
        'tie-icon-views'            => 'fa-solid fa-eye',
        'tie-icon-clock'            => 'fa-solid fa-clock',
        'tie-icon-clock-o'          => 'fa-regular fa-clock',
        'tie-icon-time'             => 'fa-solid fa-clock',
        'tie-icon-calendar'         => 'fa-solid fa-calendar',
        'tie-icon-calendar-o'       => 'fa-regular fa-calendar',
        'tie-icon-calendar-days'    => 'fa-solid fa-calendar-days',
        'tie-icon-image'            => 'fa-solid fa-image',
        'tie-icon-images'           => 'fa-solid fa-images',
        'tie-icon-photo'            => 'fa-solid fa-image',
        'tie-icon-gallery'          => 'fa-solid fa-images',
        'tie-icon-camera'           => 'fa-solid fa-camera',
        'tie-icon-video'            => 'fa-solid fa-video',
        'tie-icon-film'             => 'fa-solid fa-film',
        'tie-icon-play'             => 'fa-solid fa-play',
        'tie-icon-pause'            => 'fa-solid fa-pause',
        'tie-icon-stop'             => 'fa-solid fa-stop',
        'tie-icon-forward'          => 'fa-solid fa-forward',
        'tie-icon-backward'         => 'fa-solid fa-backward',
        'tie-icon-music'            => 'fa-solid fa-music',
        'tie-icon-headphones'       => 'fa-solid fa-headphones',
        'tie-icon-microphone'       => 'fa-solid fa-microphone',
        'tie-icon-volume-up'        => 'fa-solid fa-volume-high',
        'tie-icon-volume-down'      => 'fa-solid fa-volume-low',
        'tie-icon-volume-off'       => 'fa-solid fa-volume-xmark',
        'tie-icon-mute'             => 'fa-solid fa-volume-xmark',
        'tie-icon-podcast'          => 'fa-solid fa-podcast',
        
        // User & Profile Icons
        'tie-icon-user'             => 'fa-solid fa-user',
        'tie-icon-user-o'           => 'fa-regular fa-user',
        'tie-icon-users'            => 'fa-solid fa-users',
        'tie-icon-user-plus'        => 'fa-solid fa-user-plus',
        'tie-icon-user-minus'       => 'fa-solid fa-user-minus',
        'tie-icon-user-circle'      => 'fa-solid fa-circle-user',
        'tie-icon-author'           => 'fa-solid fa-user-pen',
        'tie-icon-login'            => 'fa-solid fa-right-to-bracket',
        'tie-icon-logout'           => 'fa-solid fa-right-from-bracket',
        'tie-icon-sign-in'          => 'fa-solid fa-right-to-bracket',
        'tie-icon-sign-out'         => 'fa-solid fa-right-from-bracket',
        'tie-icon-lock'             => 'fa-solid fa-lock',
        'tie-icon-unlock'           => 'fa-solid fa-unlock',
        'tie-icon-key'              => 'fa-solid fa-key',
        'tie-icon-shield'           => 'fa-solid fa-shield',
        
        // Communication Icons
        'tie-icon-envelope'         => 'fa-solid fa-envelope',
        'tie-icon-envelope-o'       => 'fa-regular fa-envelope',
        'tie-icon-email'            => 'fa-solid fa-envelope',
        'tie-icon-mail'             => 'fa-solid fa-envelope',
        'tie-icon-phone'            => 'fa-solid fa-phone',
        'tie-icon-mobile'           => 'fa-solid fa-mobile-screen',
        'tie-icon-fax'              => 'fa-solid fa-fax',
        'tie-icon-address'          => 'fa-solid fa-location-dot',
        'tie-icon-location'         => 'fa-solid fa-location-dot',
        'tie-icon-map-marker'       => 'fa-solid fa-location-dot',
        'tie-icon-map'              => 'fa-solid fa-map',
        'tie-icon-globe'            => 'fa-solid fa-globe',
        'tie-icon-world'            => 'fa-solid fa-earth-americas',
        
        // Document & File Icons
        'tie-icon-file'             => 'fa-solid fa-file',
        'tie-icon-file-o'           => 'fa-regular fa-file',
        'tie-icon-file-text'        => 'fa-solid fa-file-lines',
        'tie-icon-file-pdf'         => 'fa-solid fa-file-pdf',
        'tie-icon-file-word'        => 'fa-solid fa-file-word',
        'tie-icon-file-excel'       => 'fa-solid fa-file-excel',
        'tie-icon-file-image'       => 'fa-solid fa-file-image',
        'tie-icon-file-video'       => 'fa-solid fa-file-video',
        'tie-icon-file-audio'       => 'fa-solid fa-file-audio',
        'tie-icon-file-archive'     => 'fa-solid fa-file-zipper',
        'tie-icon-file-code'        => 'fa-solid fa-file-code',
        'tie-icon-folder'           => 'fa-solid fa-folder',
        'tie-icon-folder-o'         => 'fa-regular fa-folder',
        'tie-icon-folder-open'      => 'fa-solid fa-folder-open',
        'tie-icon-archive'          => 'fa-solid fa-box-archive',
        'tie-icon-clipboard'        => 'fa-solid fa-clipboard',
        'tie-icon-newspaper'        => 'fa-solid fa-newspaper',
        'tie-icon-book'             => 'fa-solid fa-book',
        'tie-icon-book-open'        => 'fa-solid fa-book-open',
        'tie-icon-quote'            => 'fa-solid fa-quote-right',
        'tie-icon-quote-left'       => 'fa-solid fa-quote-left',
        'tie-icon-quote-right'      => 'fa-solid fa-quote-right',
        
        // Shopping & E-commerce
        'tie-icon-cart'             => 'fa-solid fa-cart-shopping',
        'tie-icon-shopping-cart'    => 'fa-solid fa-cart-shopping',
        'tie-icon-bag'              => 'fa-solid fa-bag-shopping',
        'tie-icon-shopping-bag'     => 'fa-solid fa-bag-shopping',
        'tie-icon-store'            => 'fa-solid fa-store',
        'tie-icon-shop'             => 'fa-solid fa-shop',
        'tie-icon-credit-card'      => 'fa-solid fa-credit-card',
        'tie-icon-wallet'           => 'fa-solid fa-wallet',
        'tie-icon-money'            => 'fa-solid fa-money-bill',
        'tie-icon-dollar'           => 'fa-solid fa-dollar-sign',
        'tie-icon-euro'             => 'fa-solid fa-euro-sign',
        'tie-icon-tag'              => 'fa-solid fa-tag',
        'tie-icon-tags'             => 'fa-solid fa-tags',
        'tie-icon-gift'             => 'fa-solid fa-gift',
        'tie-icon-percent'          => 'fa-solid fa-percent',
        'tie-icon-barcode'          => 'fa-solid fa-barcode',
        'tie-icon-qrcode'           => 'fa-solid fa-qrcode',
        
        // Categories & Organization
        'tie-icon-category'         => 'fa-solid fa-folder',
        'tie-icon-categories'       => 'fa-solid fa-layer-group',
        'tie-icon-layers'           => 'fa-solid fa-layer-group',
        'tie-icon-sitemap'          => 'fa-solid fa-sitemap',
        'tie-icon-database'         => 'fa-solid fa-database',
        'tie-icon-server'           => 'fa-solid fa-server',
        'tie-icon-cloud'            => 'fa-solid fa-cloud',
        'tie-icon-cloud-upload'     => 'fa-solid fa-cloud-arrow-up',
        'tie-icon-cloud-download'   => 'fa-solid fa-cloud-arrow-down',
        
        // Status & Alerts
        'tie-icon-info'             => 'fa-solid fa-circle-info',
        'tie-icon-info-circle'      => 'fa-solid fa-circle-info',
        'tie-icon-question'         => 'fa-solid fa-circle-question',
        'tie-icon-question-circle'  => 'fa-solid fa-circle-question',
        'tie-icon-exclamation'      => 'fa-solid fa-circle-exclamation',
        'tie-icon-warning'          => 'fa-solid fa-triangle-exclamation',
        'tie-icon-alert'            => 'fa-solid fa-triangle-exclamation',
        'tie-icon-error'            => 'fa-solid fa-circle-xmark',
        'tie-icon-success'          => 'fa-solid fa-circle-check',
        'tie-icon-check-circle'     => 'fa-solid fa-circle-check',
        'tie-icon-ban'              => 'fa-solid fa-ban',
        'tie-icon-block'            => 'fa-solid fa-ban',
        
        // Weather & Nature
        'tie-icon-sun'              => 'fa-solid fa-sun',
        'tie-icon-moon'             => 'fa-solid fa-moon',
        'tie-icon-cloud-sun'        => 'fa-solid fa-cloud-sun',
        'tie-icon-rain'             => 'fa-solid fa-cloud-rain',
        'tie-icon-snow'             => 'fa-solid fa-snowflake',
        'tie-icon-wind'             => 'fa-solid fa-wind',
        'tie-icon-temperature'      => 'fa-solid fa-temperature-half',
        'tie-icon-leaf'             => 'fa-solid fa-leaf',
        'tie-icon-tree'             => 'fa-solid fa-tree',
        
        // Misc UI Icons
        'tie-icon-lightbulb'        => 'fa-solid fa-lightbulb',
        'tie-icon-idea'             => 'fa-solid fa-lightbulb',
        'tie-icon-magic'            => 'fa-solid fa-wand-magic-sparkles',
        'tie-icon-magic-wand'       => 'fa-solid fa-wand-magic-sparkles',
        'tie-icon-palette'          => 'fa-solid fa-palette',
        'tie-icon-paint'            => 'fa-solid fa-paintbrush',
        'tie-icon-brush'            => 'fa-solid fa-brush',
        'tie-icon-pen'              => 'fa-solid fa-pen',
        'tie-icon-pencil'           => 'fa-solid fa-pencil',
        'tie-icon-code'             => 'fa-solid fa-code',
        'tie-icon-terminal'         => 'fa-solid fa-terminal',
        'tie-icon-bug'              => 'fa-solid fa-bug',
        'tie-icon-wrench'           => 'fa-solid fa-wrench',
        'tie-icon-tools'            => 'fa-solid fa-screwdriver-wrench',
        'tie-icon-hammer'           => 'fa-solid fa-hammer',
        'tie-icon-trophy'           => 'fa-solid fa-trophy',
        'tie-icon-award'            => 'fa-solid fa-award',
        'tie-icon-medal'            => 'fa-solid fa-medal',
        'tie-icon-crown'            => 'fa-solid fa-crown',
        'tie-icon-rocket'           => 'fa-solid fa-rocket',
        'tie-icon-plane'            => 'fa-solid fa-plane',
        'tie-icon-car'              => 'fa-solid fa-car',
        'tie-icon-truck'            => 'fa-solid fa-truck',
        'tie-icon-shipping'         => 'fa-solid fa-truck-fast',
        'tie-icon-bicycle'          => 'fa-solid fa-bicycle',
        'tie-icon-building'         => 'fa-solid fa-building',
        'tie-icon-hospital'         => 'fa-solid fa-hospital',
        'tie-icon-graduation'       => 'fa-solid fa-graduation-cap',
        'tie-icon-university'       => 'fa-solid fa-building-columns',
        'tie-icon-briefcase'        => 'fa-solid fa-briefcase',
        'tie-icon-suitcase'         => 'fa-solid fa-suitcase',
        'tie-icon-coffee'           => 'fa-solid fa-mug-hot',
        'tie-icon-utensils'         => 'fa-solid fa-utensils',
        'tie-icon-cutlery'          => 'fa-solid fa-utensils',
        'tie-icon-glass'            => 'fa-solid fa-wine-glass',
        'tie-icon-beer'             => 'fa-solid fa-beer-mug-empty',
        'tie-icon-pills'            => 'fa-solid fa-pills',
        'tie-icon-heartbeat'        => 'fa-solid fa-heart-pulse',
        'tie-icon-stethoscope'      => 'fa-solid fa-stethoscope',
        'tie-icon-gamepad'          => 'fa-solid fa-gamepad',
        'tie-icon-puzzle'           => 'fa-solid fa-puzzle-piece',
        'tie-icon-cube'             => 'fa-solid fa-cube',
        'tie-icon-cubes'            => 'fa-solid fa-cubes',
        'tie-icon-box'              => 'fa-solid fa-box',
        'tie-icon-boxes'            => 'fa-solid fa-boxes-stacked',
        'tie-icon-infinite'         => 'fa-solid fa-infinity',
        'tie-icon-chart'            => 'fa-solid fa-chart-simple',
        'tie-icon-chart-bar'        => 'fa-solid fa-chart-bar',
        'tie-icon-chart-line'       => 'fa-solid fa-chart-line',
        'tie-icon-chart-pie'        => 'fa-solid fa-chart-pie',
        'tie-icon-stats'            => 'fa-solid fa-chart-column',
        'tie-icon-analytics'        => 'fa-solid fa-chart-line',
        
        // Dark/Light Mode
        'tie-icon-contrast'         => 'fa-solid fa-circle-half-stroke',
        'tie-icon-dark-mode'        => 'fa-solid fa-moon',
        'tie-icon-light-mode'       => 'fa-solid fa-sun',
        'tie-icon-adjust'           => 'fa-solid fa-circle-half-stroke',
        
        // Slider/Carousel Controls
        'tie-icon-prev'             => 'fa-solid fa-chevron-right',
        'tie-icon-next'             => 'fa-solid fa-chevron-left',
        'tie-icon-slider-prev'      => 'fa-solid fa-chevron-right',
        'tie-icon-slider-next'      => 'fa-solid fa-chevron-left',
    );
}

// =============================================
// 2. OUTPUT BUFFER REPLACEMENT (Main Method)
// =============================================
add_action('template_redirect', 'tez_icon_start_buffer');
function tez_icon_start_buffer() {
    if (is_admin()) return;
    ob_start('tez_icon_replace_buffer');
}

add_action('shutdown', 'tez_icon_end_buffer', 0);
function tez_icon_end_buffer() {
    if (is_admin()) return;
    if (ob_get_level() > 0) {
        ob_end_flush();
    }
}

function tez_icon_replace_buffer($html) {
    if (empty($html)) return $html;
    
    $mapping = tez_get_icon_mapping();
    
    foreach ($mapping as $tie_icon => $fa_icon) {
        // Replace class="tie-icon-*" patterns
        $html = str_replace(
            'class="' . $tie_icon . '"',
            'class="' . $fa_icon . '"',
            $html
        );
        
        // Replace within class lists (e.g., class="icon tie-icon-fire")
        $html = str_replace(
            ' ' . $tie_icon . '"',
            ' ' . $fa_icon . '"',
            $html
        );
        $html = str_replace(
            ' ' . $tie_icon . ' ',
            ' ' . $fa_icon . ' ',
            $html
        );
        $html = str_replace(
            '"' . $tie_icon . ' ',
            '"' . $fa_icon . ' ',
            $html
        );
    }
    
    // Also handle any remaining tie-icon-* that weren't in our mapping
    // Convert them to a generic icon
    $html = preg_replace_callback(
        '/class="([^"]*)\btie-icon-([a-zA-Z0-9_-]+)\b([^"]*)"/',
        function($matches) {
            $mapping = tez_get_icon_mapping();
            $tie_class = 'tie-icon-' . $matches[2];
            
            // If already mapped, skip (shouldn't reach here, but safety check)
            if (isset($mapping[$tie_class])) {
                return $matches[0];
            }
            
            // Default fallback icon
            $fa_class = 'fa-solid fa-circle';
            return 'class="' . $matches[1] . $fa_class . $matches[3] . '"';
        },
        $html
    );
    
    return $html;
}

// =============================================
// 3. CSS FALLBACK (For any missed icons)
// =============================================
add_action('wp_head', 'tez_icon_fallback_css', 100);
function tez_icon_fallback_css() {
    $mapping = tez_get_icon_mapping();
    ?>
    <style id="tez-icon-replacement-css">
    /* ============================================
       Icon Replacement: Hide original tie-icon font
       ============================================ */
    
    /* Hide original icon font */
    [class*="tie-icon-"]:before {
        content: none !important;
    }
    
    /* Common base styles for replacement icons */
    [class*="tie-icon-"] {
        font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", sans-serif !important;
        font-weight: 900;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }
    
    /* ============================================
       Individual Icon Replacements via CSS
       (Backup for any icons not caught by PHP)
       ============================================ */
    
    <?php foreach ($mapping as $tie_icon => $fa_icon): 
        // Get the FA content code
        $fa_content = tez_get_fa_content_code($fa_icon);
        if ($fa_content):
    ?>
    .<?php echo $tie_icon; ?>:before {
        content: "<?php echo $fa_content; ?>" !important;
        font-family: "<?php echo tez_get_fa_font_family($fa_icon); ?>" !important;
        font-weight: <?php echo tez_get_fa_font_weight($fa_icon); ?> !important;
    }
    <?php endif; endforeach; ?>
    
    /* ============================================
       Theme Integration - Ensure proper sizing
       ============================================ */
    
    /* Social buttons */
    .social-icons [class*="fa-"],
    .social-icons-item [class*="fa-"] {
        font-size: inherit;
    }
    
    /* Breaking news ticker */
    .breaking-news-icon [class*="fa-"] {
        font-size: 1em;
    }
    
    /* Post meta icons */
    .post-meta [class*="fa-"],
    .tie-post-meta [class*="fa-"] {
        margin-left: 0.25em;
    }
    
    /* Navigation icons */
    .menu-item [class*="fa-"] {
        margin-left: 0.5em;
    }
    
    /* Button icons */
    .tie-btn [class*="fa-"],
    .button [class*="fa-"] {
        margin-left: 0.375em;
    }
    
    /* RTL adjustments */
    [dir="rtl"] .post-meta [class*="fa-"],
    [dir="rtl"] .tie-post-meta [class*="fa-"] {
        margin-left: 0;
        margin-right: 0.25em;
    }
    
    [dir="rtl"] .menu-item [class*="fa-"] {
        margin-left: 0;
        margin-right: 0.5em;
    }
    
    [dir="rtl"] .tie-btn [class*="fa-"],
    [dir="rtl"] .button [class*="fa-"] {
        margin-left: 0;
        margin-right: 0.375em;
    }
    </style>
    <?php
}

// =============================================
// 4. HELPER: GET FA CONTENT CODE
// =============================================
function tez_get_fa_content_code($fa_class) {
    // Map FA class names to unicode content codes
    $codes = array(
        // Brand icons (fa-brands)
        'fa-facebook-f'             => '\f39e',
        'fa-x-twitter'              => '\e61b',
        'fa-instagram'              => '\f16d',
        'fa-youtube'                => '\f167',
        'fa-linkedin-in'            => '\f0e1',
        'fa-pinterest-p'            => '\f231',
        'fa-telegram'               => '\f2c6',
        'fa-whatsapp'               => '\f232',
        'fa-tiktok'                 => '\e07b',
        'fa-snapchat'               => '\f2ab',
        'fa-reddit-alien'           => '\f281',
        'fa-tumblr'                 => '\f173',
        'fa-flickr'                 => '\f16e',
        'fa-vimeo-v'                => '\f27d',
        'fa-dribbble'               => '\f17d',
        'fa-behance'                => '\f1b4',
        'fa-github'                 => '\f09b',
        'fa-soundcloud'             => '\f1be',
        'fa-spotify'                => '\f1bc',
        'fa-apple'                  => '\f179',
        'fa-android'                => '\f17b',
        'fa-windows'                => '\f17a',
        'fa-skype'                  => '\f17e',
        'fa-slack'                  => '\f198',
        'fa-discord'                => '\f392',
        'fa-twitch'                 => '\f1e8',
        'fa-medium'                 => '\f23a',
        
        // Solid icons (fa-solid)
        'fa-rss'                    => '\f09e',
        'fa-house'                  => '\f015',
        'fa-magnifying-glass'       => '\f002',
        'fa-bars'                   => '\f0c9',
        'fa-xmark'                  => '\f00d',
        'fa-check'                  => '\f00c',
        'fa-plus'                   => '\f067',
        'fa-minus'                  => '\f068',
        'fa-pen'                    => '\f304',
        'fa-trash'                  => '\f1f8',
        'fa-gear'                   => '\f013',
        'fa-spinner'                => '\f110',
        'fa-rotate'                 => '\f2f1',
        'fa-arrows-rotate'          => '\f021',
        'fa-arrow-up-right-from-square' => '\f08e',
        'fa-link'                   => '\f0c1',
        'fa-link-slash'             => '\f127',
        'fa-download'               => '\f019',
        'fa-upload'                 => '\f093',
        'fa-share-nodes'            => '\f1e0',
        'fa-print'                  => '\f02f',
        'fa-copy'                   => '\f0c5',
        'fa-paste'                  => '\f0ea',
        'fa-scissors'               => '\f0c4',
        'fa-floppy-disk'            => '\f0c7',
        'fa-rotate-left'            => '\f2ea',
        'fa-rotate-right'           => '\f2f9',
        'fa-expand'                 => '\f065',
        'fa-compress'               => '\f066',
        'fa-maximize'               => '\f31e',
        'fa-filter'                 => '\f0b0',
        'fa-sort'                   => '\f0dc',
        'fa-list'                   => '\f03a',
        'fa-grip'                   => '\f58d',
        'fa-table-cells'            => '\f00a',
        'fa-table-cells-large'      => '\f009',
        
        // Arrows
        'fa-arrow-up'               => '\f062',
        'fa-arrow-down'             => '\f063',
        'fa-arrow-left'             => '\f060',
        'fa-arrow-right'            => '\f061',
        'fa-chevron-up'             => '\f077',
        'fa-chevron-down'           => '\f078',
        'fa-chevron-left'           => '\f053',
        'fa-chevron-right'          => '\f054',
        'fa-angle-up'               => '\f106',
        'fa-angle-down'             => '\f107',
        'fa-angle-left'             => '\f104',
        'fa-angle-right'            => '\f105',
        'fa-caret-up'               => '\f0d8',
        'fa-caret-down'             => '\f0d7',
        'fa-caret-left'             => '\f0d9',
        'fa-caret-right'            => '\f0da',
        'fa-angles-left'            => '\f100',
        'fa-angles-right'           => '\f101',
        
        // Content
        'fa-fire'                   => '\f06d',
        'fa-bolt'                   => '\f0e7',
        'fa-arrow-trend-up'         => '\e098',
        'fa-fire-flame-curved'      => '\f7e4',
        'fa-star'                   => '\f005',
        'fa-star-half-stroke'       => '\f5c0',
        'fa-heart'                  => '\f004',
        'fa-thumbs-up'              => '\f164',
        'fa-thumbs-down'            => '\f165',
        'fa-bookmark'               => '\f02e',
        'fa-flag'                   => '\f024',
        'fa-bell'                   => '\f0f3',
        'fa-comment'                => '\f075',
        'fa-comments'               => '\f086',
        'fa-eye'                    => '\f06e',
        'fa-eye-slash'              => '\f070',
        'fa-clock'                  => '\f017',
        'fa-calendar'               => '\f133',
        'fa-calendar-days'          => '\f073',
        'fa-image'                  => '\f03e',
        'fa-images'                 => '\f302',
        'fa-camera'                 => '\f030',
        'fa-video'                  => '\f03d',
        'fa-film'                   => '\f008',
        'fa-play'                   => '\f04b',
        'fa-pause'                  => '\f04c',
        'fa-stop'                   => '\f04d',
        'fa-forward'                => '\f04e',
        'fa-backward'               => '\f04a',
        'fa-music'                  => '\f001',
        'fa-headphones'             => '\f025',
        'fa-microphone'             => '\f130',
        'fa-volume-high'            => '\f028',
        'fa-volume-low'             => '\f027',
        'fa-volume-xmark'           => '\f6a9',
        'fa-podcast'                => '\f2ce',
        
        // Users
        'fa-user'                   => '\f007',
        'fa-users'                  => '\f0c0',
        'fa-user-plus'              => '\f234',
        'fa-user-minus'             => '\f503',
        'fa-circle-user'            => '\f2bd',
        'fa-user-pen'               => '\f4ff',
        'fa-right-to-bracket'       => '\f2f6',
        'fa-right-from-bracket'     => '\f2f5',
        'fa-lock'                   => '\f023',
        'fa-unlock'                 => '\f09c',
        'fa-key'                    => '\f084',
        'fa-shield'                 => '\f132',
        
        // Communication
        'fa-envelope'               => '\f0e0',
        'fa-phone'                  => '\f095',
        'fa-mobile-screen'          => '\f3cf',
        'fa-fax'                    => '\f1ac',
        'fa-location-dot'           => '\f3c5',
        'fa-map'                    => '\f279',
        'fa-globe'                  => '\f0ac',
        'fa-earth-americas'         => '\f57d',
        
        // Files
        'fa-file'                   => '\f15b',
        'fa-file-lines'             => '\f15c',
        'fa-file-pdf'               => '\f1c1',
        'fa-file-word'              => '\f1c2',
        'fa-file-excel'             => '\f1c3',
        'fa-file-image'             => '\f1c5',
        'fa-file-video'             => '\f1c8',
        'fa-file-audio'             => '\f1c7',
        'fa-file-zipper'            => '\f1c6',
        'fa-file-code'              => '\f1c9',
        'fa-folder'                 => '\f07b',
        'fa-folder-open'            => '\f07c',
        'fa-box-archive'            => '\f187',
        'fa-clipboard'              => '\f328',
        'fa-newspaper'              => '\f1ea',
        'fa-book'                   => '\f02d',
        'fa-book-open'              => '\f518',
        'fa-quote-right'            => '\f10e',
        'fa-quote-left'             => '\f10d',
        
        // Shopping
        'fa-cart-shopping'          => '\f07a',
        'fa-bag-shopping'           => '\f290',
        'fa-store'                  => '\f54e',
        'fa-shop'                   => '\f54f',
        'fa-credit-card'            => '\f09d',
        'fa-wallet'                 => '\f555',
        'fa-money-bill'             => '\f0d6',
        'fa-dollar-sign'            => '\f155',
        'fa-euro-sign'              => '\f153',
        'fa-tag'                    => '\f02b',
        'fa-tags'                   => '\f02c',
        'fa-gift'                   => '\f06b',
        'fa-percent'                => '\f295',
        'fa-barcode'                => '\f02a',
        'fa-qrcode'                 => '\f029',
        
        // Organization
        'fa-layer-group'            => '\f5fd',
        'fa-sitemap'                => '\f0e8',
        'fa-database'               => '\f1c0',
        'fa-server'                 => '\f233',
        'fa-cloud'                  => '\f0c2',
        'fa-cloud-arrow-up'         => '\f0ee',
        'fa-cloud-arrow-down'       => '\f0ed',
        
        // Status
        'fa-circle-info'            => '\f05a',
        'fa-circle-question'        => '\f059',
        'fa-circle-exclamation'     => '\f06a',
        'fa-triangle-exclamation'   => '\f071',
        'fa-circle-xmark'           => '\f057',
        'fa-circle-check'           => '\f058',
        'fa-ban'                    => '\f05e',
        
        // Weather
        'fa-sun'                    => '\f185',
        'fa-moon'                   => '\f186',
        'fa-cloud-sun'              => '\f6c4',
        'fa-cloud-rain'             => '\f73d',
        'fa-snowflake'              => '\f2dc',
        'fa-wind'                   => '\f72e',
        'fa-temperature-half'       => '\f2c9',
        'fa-leaf'                   => '\f06c',
        'fa-tree'                   => '\f1bb',
        
        // Misc
        'fa-lightbulb'              => '\f0eb',
        'fa-wand-magic-sparkles'    => '\e2ca',
        'fa-palette'                => '\f53f',
        'fa-paintbrush'             => '\f1fc',
        'fa-brush'                  => '\f55d',
        'fa-pencil'                 => '\f303',
        'fa-code'                   => '\f121',
        'fa-terminal'               => '\f120',
        'fa-bug'                    => '\f188',
        'fa-wrench'                 => '\f0ad',
        'fa-screwdriver-wrench'     => '\f7d9',
        'fa-hammer'                 => '\f6e3',
        'fa-trophy'                 => '\f091',
        'fa-award'                  => '\f559',
        'fa-medal'                  => '\f5a2',
        'fa-crown'                  => '\f521',
        'fa-rocket'                 => '\f135',
        'fa-plane'                  => '\f072',
        'fa-car'                    => '\f1b9',
        'fa-truck'                  => '\f0d1',
        'fa-truck-fast'             => '\f48b',
        'fa-bicycle'                => '\f206',
        'fa-building'               => '\f1ad',
        'fa-hospital'               => '\f0f8',
        'fa-graduation-cap'         => '\f19d',
        'fa-building-columns'       => '\f19c',
        'fa-briefcase'              => '\f0b1',
        'fa-suitcase'               => '\f0f2',
        'fa-mug-hot'                => '\f7b6',
        'fa-utensils'               => '\f2e7',
        'fa-wine-glass'             => '\f4e3',
        'fa-beer-mug-empty'         => '\f0fc',
        'fa-pills'                  => '\f484',
        'fa-heart-pulse'            => '\f21e',
        'fa-stethoscope'            => '\f0f1',
        'fa-gamepad'                => '\f11b',
        'fa-puzzle-piece'           => '\f12e',
        'fa-cube'                   => '\f1b2',
        'fa-cubes'                  => '\f1b3',
        'fa-box'                    => '\f466',
        'fa-boxes-stacked'          => '\f468',
        'fa-infinity'               => '\f534',
        'fa-chart-simple'           => '\e473',
        'fa-chart-bar'              => '\f080',
        'fa-chart-line'             => '\f201',
        'fa-chart-pie'              => '\f200',
        'fa-chart-column'           => '\e0e3',
        'fa-circle-half-stroke'     => '\f042',
        'fa-circle'                 => '\f111',
    );
    
    // Extract just the icon name from the full class
    preg_match('/fa-([a-z0-9-]+)/', $fa_class, $matches);
    if (isset($matches[0]) && isset($codes[$matches[0]])) {
        return $codes[$matches[0]];
    }
    
    return '\f111'; // Default circle icon
}

// =============================================
// 5. HELPER: GET FA FONT FAMILY
// =============================================
function tez_get_fa_font_family($fa_class) {
    if (strpos($fa_class, 'fa-brands') !== false) {
        return 'Font Awesome 6 Brands';
    }
    if (strpos($fa_class, 'fa-regular') !== false) {
        return 'Font Awesome 6 Free';
    }
    return 'Font Awesome 6 Free';
}

// =============================================
// 6. HELPER: GET FA FONT WEIGHT
// =============================================
function tez_get_fa_font_weight($fa_class) {
    if (strpos($fa_class, 'fa-brands') !== false) {
        return '400';
    }
    if (strpos($fa_class, 'fa-regular') !== false) {
        return '400';
    }
    return '900'; // Solid
}

// =============================================
// 7. ENSURE FONT AWESOME IS LOADED
// =============================================
add_action('wp_enqueue_scripts', 'tez_ensure_fontawesome_loaded', 5);
function tez_ensure_fontawesome_loaded() {
    // Check if Font Awesome is already enqueued
    if (!wp_style_is('font-awesome', 'enqueued') && 
        !wp_style_is('fontawesome', 'enqueued') &&
        !wp_style_is('font-awesome-6', 'enqueued')) {
        wp_enqueue_style(
            'font-awesome-6',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
            array(),
            '6.5.1'
        );
    }
}

// =============================================
// 8. ADMIN NOTICE IF FONTAWESOME NOT DETECTED
// =============================================
add_action('admin_notices', 'tez_icon_admin_notice');
function tez_icon_admin_notice() {
    global $pagenow;
    if ($pagenow !== 'themes.php') return;
    
    ?>
    <div class="notice notice-info is-dismissible">
        <p>
            <strong>Teznevisan Icons:</strong> 
            آیکون‌های Jannah به Font Awesome 6 تبدیل شدند. اگر برخی آیکون‌ها نمایش داده نمی‌شوند، مطمئن شوید که Font Awesome به درستی بارگذاری شده است.
        </p>
    </div>
    <?php
}
