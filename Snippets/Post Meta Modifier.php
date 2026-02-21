/**
 * Teznevisan: Compact Enhanced Jannah Post Meta
 * Version: 2.1.0
 * Compact layout with proper alignment, smaller elements, minimum height
 */

if (!defined('ABSPATH')) exit;

// =============================================
// 1. DEFINE FONT AWESOME 7 PRO PATHS
// =============================================
if (!defined('TEZ_FA7_WEBFONTS_PATH')) {
    define('TEZ_FA7_WEBFONTS_PATH', content_url('/uploads/fonts/fontawesome/webfonts/'));
}
if (!defined('TEZ_FA7_CSS_PATH')) {
    define('TEZ_FA7_CSS_PATH', content_url('/uploads/fonts/fontawesome/css/all.css'));
}

// =============================================
// 2. ENQUEUE FONT AWESOME 7 PRO CSS
// =============================================
add_action('wp_enqueue_scripts', 'tez_meta_enqueue_fa7_pro', 5);
function tez_meta_enqueue_fa7_pro() {
    wp_enqueue_style('tez-fontawesome-7-pro', TEZ_FA7_CSS_PATH, array(), '7.0.0');
}

// =============================================
// 3. FONT AWESOME 7 PRO WEBFONT DECLARATIONS
// =============================================
add_action('wp_head', 'tez_meta_fa7_webfonts', 2);
function tez_meta_fa7_webfonts() {
    $path = TEZ_FA7_WEBFONTS_PATH;
    ?>
    <style id="tez-fa7-webfonts">
    @font-face {
        font-family: 'Font Awesome 6 Free';
        font-style: normal;
        font-weight: 900;
        font-display: block;
        src: url('<?php echo $path; ?>fa-solid-900.woff2') format('woff2'),
             url('<?php echo $path; ?>fa-solid-900.ttf') format('truetype');
    }
    @font-face {
        font-family: 'Font Awesome 6 Free';
        font-style: normal;
        font-weight: 400;
        font-display: block;
        src: url('<?php echo $path; ?>fa-regular-400.woff2') format('woff2'),
             url('<?php echo $path; ?>fa-regular-400.ttf') format('truetype');
    }
    @font-face {
        font-family: 'Font Awesome 6 Brands';
        font-style: normal;
        font-weight: 400;
        font-display: block;
        src: url('<?php echo $path; ?>fa-brands-400.woff2') format('woff2'),
             url('<?php echo $path; ?>fa-brands-400.ttf') format('truetype');
    }
    .fa, .fas, .fa-solid, .far, .fa-regular, .fab, .fa-brands {
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        line-height: 1;
        text-rendering: auto;
    }
    .fa-solid, .fas { font-family: 'Font Awesome 6 Free'; font-weight: 900; }
    .fa-regular, .far { font-family: 'Font Awesome 6 Free'; font-weight: 400; }
    .fa-brands, .fab { font-family: 'Font Awesome 6 Brands'; font-weight: 400; }
    </style>
    <?php
}

// =============================================
// 4. COMPACT POST META STYLES
// =============================================
add_action('wp_head', 'tez_compact_meta_css', 99);
function tez_compact_meta_css() {
    ?>
    <style id="tez-compact-meta-css">
    /* ============================================
       COMPACT POST META - VARIABLES
       ============================================ */
    
    .single-post-meta.post-meta,
    .jannah-enhanced-meta {
        --meta-primary: var(--tez-primary, #2563eb);
        --meta-primary-rgb: var(--tez-primary-rgb, 37, 99, 235);
        --meta-bg: var(--tez-bg, #ffffff);
        --meta-bg-secondary: var(--tez-bg-secondary, #f8fafc);
        --meta-bg-tertiary: var(--tez-bg-tertiary, #f1f5f9);
        --meta-text: var(--tez-text, #1e293b);
        --meta-text-muted: var(--tez-text-muted, #64748b);
        --meta-border: var(--tez-border, #e2e8f0);
        --meta-radius: 10px;
        --meta-transition: 200ms ease;
    }
    
    /* ============================================
       MAIN CONTAINER - COMPACT SINGLE ROW
       ============================================ */
    
    .single-post-meta.post-meta,
    .jannah-enhanced-meta {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        gap: 0.5rem !important;
        padding: 0.625rem 0.875rem !important;
        margin: 0 0 1.25rem 0 !important;
        min-height: 48px !important;
        max-width: 100% !important;
        background: var(--meta-bg-secondary) !important;
        border: 1px solid var(--meta-border) !important;
        border-radius: var(--meta-radius) !important;
        font-family: var(--tez-font, 'Irancell', system-ui, sans-serif) !important;
        font-size: 0.75rem !important;
        line-height: 1.4 !important;
        position: relative !important;
        box-sizing: border-box !important;
    }
    
    /* Gradient top border */
    .single-post-meta.post-meta::before,
    .jannah-enhanced-meta::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 2px;
        background: linear-gradient(90deg, #2563eb, #7c3aed, #db2777, #f59e0b, #10b981, #2563eb);
        background-size: 200% 100%;
        animation: tezGradient 3s linear infinite;
        border-radius: var(--meta-radius) var(--meta-radius) 0 0;
    }
    
    @keyframes tezGradient {
        0% { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }
    
    /* Reset clearfix float issues */
    .single-post-meta.post-meta.clearfix::after,
    .jannah-enhanced-meta.clearfix::after {
        content: none !important;
        display: none !important;
    }
    
    /* ============================================
       AUTHOR SECTION - COMPACT
       ============================================ */
    
    .single-post-meta .author-meta,
    .jannah-enhanced-meta .author-meta {
        display: flex !important;
        align-items: center !important;
        gap: 0.375rem !important;
        flex-shrink: 0 !important;
    }
    
    .single-post-meta .meta-author-wrapper,
    .jannah-enhanced-meta .meta-author-wrapper {
        display: flex !important;
        align-items: center !important;
        gap: 0.375rem !important;
    }
    
    /* Avatar - Small */
    .single-post-meta .meta-author-avatar,
    .jannah-enhanced-meta .meta-author-avatar {
        position: relative;
        flex-shrink: 0;
        line-height: 0;
    }
    
    .single-post-meta .meta-author-avatar a,
    .jannah-enhanced-meta .meta-author-avatar a {
        display: block;
        line-height: 0;
    }
    
    .single-post-meta .meta-author-avatar img,
    .jannah-enhanced-meta .meta-author-avatar img {
        width: 28px !important;
        height: 28px !important;
        min-width: 28px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        border: 2px solid var(--meta-bg) !important;
        box-shadow: 0 0 0 1px var(--meta-primary), 0 2px 4px rgba(0,0,0,0.1) !important;
        transition: transform var(--meta-transition), box-shadow var(--meta-transition) !important;
    }
    
    .single-post-meta .meta-author-avatar:hover img,
    .jannah-enhanced-meta .meta-author-avatar:hover img {
        transform: scale(1.08);
        box-shadow: 0 0 0 2px var(--meta-primary), 0 3px 8px rgba(var(--meta-primary-rgb), 0.3) !important;
    }
    
    /* Online indicator */
    .single-post-meta .meta-author-avatar::after,
    .jannah-enhanced-meta .meta-author-avatar::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 8px;
        height: 8px;
        background: #22c55e;
        border: 1.5px solid var(--meta-bg);
        border-radius: 50%;
        z-index: 2;
    }
    
    /* Verified badge */
    .single-post-meta .meta-author-avatar::before,
    .jannah-enhanced-meta .meta-author-avatar::before {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        top: -3px;
        left: -3px;
        width: 14px;
        height: 14px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 6px;
        border: 1.5px solid var(--meta-bg);
        z-index: 2;
    }
    
    /* Author Name */
    .single-post-meta .meta-author,
    .jannah-enhanced-meta .meta-author {
        display: flex !important;
        align-items: center !important;
        gap: 0.25rem !important;
    }
    
    .single-post-meta .meta-author .author-name,
    .jannah-enhanced-meta .meta-author .author-name {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        color: var(--meta-text) !important;
        text-decoration: none !important;
        white-space: nowrap !important;
        transition: color var(--meta-transition) !important;
    }
    
    .single-post-meta .meta-author .author-name:hover,
    .jannah-enhanced-meta .meta-author .author-name:hover {
        color: var(--meta-primary) !important;
    }
    
    /* Remove default ::after content */
    .single-post-meta .meta-author .author-name::after,
    .jannah-enhanced-meta .meta-author .author-name::after {
        content: none !important;
        display: none !important;
    }
    
    /* Email Link - Compact */
    .single-post-meta .author-email-link,
    .jannah-enhanced-meta .author-email-link {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 22px !important;
        height: 22px !important;
        min-width: 22px !important;
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        border-radius: 50% !important;
        color: #fff !important;
        text-decoration: none !important;
        transition: transform var(--meta-transition), box-shadow var(--meta-transition) !important;
        flex-shrink: 0 !important;
    }
    
    .single-post-meta .author-email-link:hover,
    .jannah-enhanced-meta .author-email-link:hover {
        transform: scale(1.1) rotate(-5deg) !important;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4) !important;
    }
    
    .single-post-meta .author-email-link .tie-icon-envelope,
    .jannah-enhanced-meta .author-email-link .tie-icon-envelope {
        font-size: 0.625rem !important;
    }
    
    /* ============================================
       DATE & UPDATED - COMPACT PILLS
       ============================================ */
    
    .single-post-meta .date.meta-item,
    .jannah-enhanced-meta .date.meta-item {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.25rem !important;
        padding: 0.25rem 0.5rem !important;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(79, 70, 229, 0.18)) !important;
        color: #4f46e5 !important;
        border-radius: 9999px !important;
        font-size: 0.6875rem !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
        border: 1px solid rgba(99, 102, 241, 0.2) !important;
        transition: all var(--meta-transition) !important;
        flex-shrink: 0 !important;
    }
    
    .single-post-meta .date.meta-item:hover,
    .jannah-enhanced-meta .date.meta-item:hover {
        background: linear-gradient(135deg, #6366f1, #4f46e5) !important;
        color: #fff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3) !important;
    }
    
    /* Last Updated - Compact Badge */
    .single-post-meta .last-updated,
    .jannah-enhanced-meta .last-updated {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.25rem !important;
        padding: 0.2rem 0.5rem !important;
        background: linear-gradient(135deg, #22c55e, #16a34a) !important;
        color: #fff !important;
        border-radius: 9999px !important;
        font-size: 0.625rem !important;
        font-weight: 700 !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
    }
    
    .single-post-meta .last-updated::before,
    .jannah-enhanced-meta .last-updated::before {
        content: '\f021';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 0.5rem;
        animation: tezSpin 2s linear infinite;
    }
    
    @keyframes tezSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* ============================================
       STATS ROW - COMPACT INLINE
       ============================================ */
    
    .single-post-meta .tie-alignright,
    .jannah-enhanced-meta .tie-alignright {
        display: flex !important;
        align-items: center !important;
        gap: 0.375rem !important;
        margin-right: auto !important;
        flex-wrap: nowrap !important;
    }
    
    /* Stat Items Base */
    .single-post-meta .tie-alignright .meta-item,
    .jannah-enhanced-meta .tie-alignright .meta-item {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.25rem !important;
        padding: 0.25rem 0.5rem !important;
        border-radius: 6px !important;
        font-size: 0.6875rem !important;
        font-weight: 700 !important;
        white-space: nowrap !important;
        transition: all var(--meta-transition) !important;
        flex-shrink: 0 !important;
    }
    
    /* Comments - Blue */
    .single-post-meta .meta-comment,
    .jannah-enhanced-meta .meta-comment {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.2)) !important;
        color: #2563eb !important;
        border: 1px solid rgba(59, 130, 246, 0.25) !important;
    }
    
    .single-post-meta .meta-comment:hover,
    .jannah-enhanced-meta .meta-comment:hover {
        background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
        color: #fff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.35) !important;
    }
    
    /* Views - Orange */
    .single-post-meta .meta-views,
    .jannah-enhanced-meta .meta-views {
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.15), rgba(234, 88, 12, 0.2)) !important;
        color: #ea580c !important;
        border: 1px solid rgba(249, 115, 22, 0.25) !important;
    }
    
    .single-post-meta .meta-views:hover,
    .jannah-enhanced-meta .meta-views:hover {
        background: linear-gradient(135deg, #f97316, #ea580c) !important;
        color: #fff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(249, 115, 22, 0.35) !important;
    }
    
    .single-post-meta .meta-views .tie-icon-fire,
    .jannah-enhanced-meta .meta-views .tie-icon-fire {
        animation: tezFlicker 1.5s ease-in-out infinite;
    }
    
    @keyframes tezFlicker {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    /* Reading Time - Green */
    .single-post-meta .meta-reading-time,
    .jannah-enhanced-meta .meta-reading-time {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(22, 163, 74, 0.2)) !important;
        color: #16a34a !important;
        border: 1px solid rgba(34, 197, 94, 0.25) !important;
    }
    
    .single-post-meta .meta-reading-time:hover,
    .jannah-enhanced-meta .meta-reading-time:hover {
        background: linear-gradient(135deg, #22c55e, #16a34a) !important;
        color: #fff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.35) !important;
    }
    
    /* ============================================
       BADGES GROUP - INLINE COMPACT
       ============================================ */
    
    .single-post-meta .meta-badges-group,
    .jannah-enhanced-meta .meta-badges-group {
        display: flex !important;
        align-items: center !important;
        gap: 0.375rem !important;
        flex-wrap: nowrap !important;
        margin-right: 0 !important;
        padding: 0 !important;
        border: none !important;
        width: auto !important;
    }
    
    .single-post-meta .meta-badges-group .meta-item,
    .jannah-enhanced-meta .meta-badges-group .meta-item {
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.25rem !important;
        padding: 0.25rem 0.5rem !important;
        border-radius: 9999px !important;
        font-size: 0.625rem !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
        background: var(--badge-bg, rgba(37, 99, 235, 0.12)) !important;
        color: var(--badge-color, #2563eb) !important;
        border: 1px solid color-mix(in srgb, var(--badge-color, #2563eb) 20%, transparent) !important;
        transition: all var(--meta-transition) !important;
        flex-shrink: 0 !important;
    }
    
    .single-post-meta .meta-badges-group .meta-item:hover,
    .jannah-enhanced-meta .meta-badges-group .meta-item:hover {
        transform: translateY(-1px) scale(1.02) !important;
        box-shadow: 0 2px 8px color-mix(in srgb, var(--badge-color, #2563eb) 30%, transparent) !important;
    }
    
    .single-post-meta .meta-badges-group .meta-item i,
    .jannah-enhanced-meta .meta-badges-group .meta-item i {
        font-size: 0.625rem !important;
    }
    
    .single-post-meta .meta-badges-group .meta-text,
    .jannah-enhanced-meta .meta-badges-group .meta-text {
        font-size: inherit !important;
    }
    
    /* ============================================
       TIE-ICON REPLACEMENTS
       ============================================ */
    
    .tie-icon,
    [class*="tie-icon-"] {
        font-family: 'Font Awesome 6 Free' !important;
        font-weight: 900 !important;
        font-style: normal !important;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    .date.meta-item.tie-icon::before {
        content: '\f073' !important;
        font-family: 'Font Awesome 6 Free' !important;
        font-weight: 900 !important;
        font-size: 0.625rem !important;
        margin-left: 0.25em !important;
    }
    
    .meta-comment.tie-icon::before,
    .meta-comment.fa-before::before {
        content: '\f086' !important;
        font-family: 'Font Awesome 6 Free' !important;
        font-weight: 900 !important;
        font-size: 0.625rem !important;
        margin-left: 0.2em !important;
    }
    
    .tie-icon-fire::before {
        content: '\f7e4' !important;
        font-family: 'Font Awesome 6 Free' !important;
        font-weight: 900 !important;
        font-size: 0.625rem !important;
    }
    
    .tie-icon-bookmark::before {
        content: '\f518' !important;
        font-family: 'Font Awesome 6 Free' !important;
        font-weight: 900 !important;
        font-size: 0.625rem !important;
    }
    
    .tie-icon-envelope::before {
        content: '\f0e0' !important;
        font-family: 'Font Awesome 6 Free' !important;
        font-weight: 900 !important;
    }
    
    .meta-author .tie-icon::before {
        content: none !important;
        display: none !important;
    }
    
    /* Additional icons */
    .tie-icon-clock::before { content: '\f017' !important; }
    .tie-icon-user::before { content: '\f007' !important; }
    .tie-icon-eye::before { content: '\f06e' !important; }
    .tie-icon-heart::before { content: '\f004' !important; }
    .tie-icon-star::before { content: '\f005' !important; }
    .tie-icon-comment::before { content: '\f075' !important; }
    .tie-icon-share::before { content: '\f1e0' !important; }
    .tie-icon-tag::before { content: '\f02b' !important; }
    .tie-icon-folder::before { content: '\f07b' !important; }
    .tie-icon-bolt::before { content: '\f0e7' !important; }
    
    /* FA icons in meta */
    .single-post-meta [class*="fa-"],
    .jannah-enhanced-meta [class*="fa-"] {
        font-family: 'Font Awesome 6 Free' !important;
        font-style: normal !important;
    }
    
    .single-post-meta .fab,
    .single-post-meta .fa-brands,
    .jannah-enhanced-meta .fab,
    .jannah-enhanced-meta .fa-brands {
        font-family: 'Font Awesome 6 Brands' !important;
        font-weight: 400 !important;
    }
    
    /* FA content codes */
    .fa-graduation-cap::before { content: '\f19d'; }
    .fa-seedling::before { content: '\f4d8'; }
    .fa-fire::before { content: '\f06d'; }
    .fa-fire-flame-curved::before { content: '\f7e4'; }
    .fa-bookmark::before { content: '\f02e'; }
    .fa-book-open::before { content: '\f518'; }
    .fa-envelope::before { content: '\f0e0'; }
    .fa-calendar-days::before { content: '\f073'; }
    .fa-comments::before { content: '\f086'; }
    .fa-circle-check::before { content: '\f058'; }
    .fa-arrows-rotate::before { content: '\f021'; }
    
    /* ============================================
       DARK MODE
       ============================================ */
    
    [data-theme="dark"] .single-post-meta.post-meta,
    [data-theme="dark"] .jannah-enhanced-meta {
        --meta-bg: #0f172a;
        --meta-bg-secondary: #1e293b;
        --meta-bg-tertiary: #334155;
        --meta-text: #f1f5f9;
        --meta-text-muted: #94a3b8;
        --meta-border: #334155;
        --meta-primary: #3b82f6;
        --meta-primary-rgb: 59, 130, 246;
        background: var(--meta-bg-secondary) !important;
        border-color: var(--meta-border) !important;
    }
    
    [data-theme="dark"] .single-post-meta .meta-author-avatar img,
    [data-theme="dark"] .jannah-enhanced-meta .meta-author-avatar img {
        border-color: var(--meta-bg-secondary) !important;
    }
    
    [data-theme="dark"] .single-post-meta .meta-author-avatar::after,
    [data-theme="dark"] .single-post-meta .meta-author-avatar::before,
    [data-theme="dark"] .jannah-enhanced-meta .meta-author-avatar::after,
    [data-theme="dark"] .jannah-enhanced-meta .meta-author-avatar::before {
        border-color: var(--meta-bg-secondary) !important;
    }
    
    [data-theme="dark"] .single-post-meta .date.meta-item,
    [data-theme="dark"] .jannah-enhanced-meta .date.meta-item {
        color: #818cf8 !important;
        background: rgba(99, 102, 241, 0.2) !important;
        border-color: rgba(99, 102, 241, 0.3) !important;
    }
    
    [data-theme="dark"] .single-post-meta .meta-comment,
    [data-theme="dark"] .jannah-enhanced-meta .meta-comment {
        color: #60a5fa !important;
        background: rgba(59, 130, 246, 0.2) !important;
    }
    
    [data-theme="dark"] .single-post-meta .meta-views,
    [data-theme="dark"] .jannah-enhanced-meta .meta-views {
        color: #fb923c !important;
        background: rgba(249, 115, 22, 0.2) !important;
    }
    
    [data-theme="dark"] .single-post-meta .meta-reading-time,
    [data-theme="dark"] .jannah-enhanced-meta .meta-reading-time {
        color: #4ade80 !important;
        background: rgba(34, 197, 94, 0.2) !important;
    }
    
    /* ============================================
       SEPIA MODE
       ============================================ */
    
    [data-theme="sepia"] .single-post-meta.post-meta,
    [data-theme="sepia"] .jannah-enhanced-meta {
        --meta-bg: #faf6f1;
        --meta-bg-secondary: #f5efe6;
        --meta-bg-tertiary: #ebe4d8;
        --meta-text: #44403c;
        --meta-text-muted: #78716c;
        --meta-border: #d6cfc4;
        --meta-primary: #b45309;
        --meta-primary-rgb: 180, 83, 9;
        background: var(--meta-bg-secondary) !important;
        border-color: var(--meta-border) !important;
    }
    
    [data-theme="sepia"] .single-post-meta.post-meta::before,
    [data-theme="sepia"] .jannah-enhanced-meta::before {
        background: linear-gradient(90deg, #b45309, #d97706, #ca8a04, #b45309);
    }
    
    [data-theme="sepia"] .single-post-meta .date.meta-item,
    [data-theme="sepia"] .jannah-enhanced-meta .date.meta-item {
        color: #92400e !important;
        background: rgba(180, 83, 9, 0.12) !important;
        border-color: rgba(180, 83, 9, 0.2) !important;
    }
    
    [data-theme="sepia"] .single-post-meta .meta-comment,
    [data-theme="sepia"] .jannah-enhanced-meta .meta-comment {
        color: #92400e !important;
        background: rgba(180, 83, 9, 0.12) !important;
    }
    
    [data-theme="sepia"] .single-post-meta .meta-views,
    [data-theme="sepia"] .jannah-enhanced-meta .meta-views {
        color: #b45309 !important;
        background: rgba(217, 119, 6, 0.12) !important;
    }
    
    [data-theme="sepia"] .single-post-meta .meta-reading-time,
    [data-theme="sepia"] .jannah-enhanced-meta .meta-reading-time {
        color: #4d7c0f !important;
        background: rgba(101, 163, 13, 0.12) !important;
    }
    
    /* ============================================
       RESPONSIVE - MAINTAIN COMPACT
       ============================================ */
    
    @media (max-width: 991px) {
        .single-post-meta.post-meta,
        .jannah-enhanced-meta {
            gap: 0.375rem !important;
            padding: 0.5rem 0.75rem !important;
        }
    }
    
    @media (max-width: 767px) {
        .single-post-meta.post-meta,
        .jannah-enhanced-meta {
            flex-wrap: wrap !important;
            gap: 0.375rem !important;
            padding: 0.5rem !important;
        }
        
        .single-post-meta .author-meta,
        .jannah-enhanced-meta .author-meta {
            flex: 1 1 auto !important;
            min-width: 120px !important;
        }
        
        .single-post-meta .tie-alignright,
        .jannah-enhanced-meta .tie-alignright {
            flex-wrap: wrap !important;
            gap: 0.25rem !important;
            margin-right: 0 !important;
        }
        
        .single-post-meta .meta-badges-group,
        .jannah-enhanced-meta .meta-badges-group {
            flex-wrap: wrap !important;
            width: 100% !important;
            margin-top: 0.25rem !important;
            padding-top: 0.375rem !important;
            border-top: 1px dashed var(--meta-border) !important;
        }
        
        .single-post-meta .meta-author-avatar img,
        .jannah-enhanced-meta .meta-author-avatar img {
            width: 24px !important;
            height: 24px !important;
            min-width: 24px !important;
        }
        
        .single-post-meta .meta-author-avatar::before,
        .jannah-enhanced-meta .meta-author-avatar::before {
            width: 12px !important;
            height: 12px !important;
            font-size: 5px !important;
        }
        
        .single-post-meta .meta-author-avatar::after,
        .jannah-enhanced-meta .meta-author-avatar::after {
            width: 6px !important;
            height: 6px !important;
        }
        
        .single-post-meta .author-email-link,
        .jannah-enhanced-meta .author-email-link {
            width: 20px !important;
            height: 20px !important;
            min-width: 20px !important;
        }
        
        .single-post-meta .last-updated,
        .jannah-enhanced-meta .last-updated {
            font-size: 0.5625rem !important;
            padding: 0.15rem 0.375rem !important;
        }
    }
    
    @media (max-width: 479px) {
        .single-post-meta.post-meta,
        .jannah-enhanced-meta {
            padding: 0.375rem !important;
            gap: 0.25rem !important;
            font-size: 0.6875rem !important;
        }
        
        .single-post-meta .date.meta-item,
        .single-post-meta .tie-alignright .meta-item,
        .single-post-meta .meta-badges-group .meta-item,
        .jannah-enhanced-meta .date.meta-item,
        .jannah-enhanced-meta .tie-alignright .meta-item,
        .jannah-enhanced-meta .meta-badges-group .meta-item {
            padding: 0.2rem 0.375rem !important;
            font-size: 0.5625rem !important;
        }
        
        .single-post-meta .meta-author .author-name,
        .jannah-enhanced-meta .meta-author .author-name {
            font-size: 0.6875rem !important;
        }
    }
    
    /* ============================================
       REDUCED MOTION
       ============================================ */
    
    @media (prefers-reduced-motion: reduce) {
        .single-post-meta.post-meta::before,
        .jannah-enhanced-meta::before,
        .single-post-meta .last-updated::before,
        .jannah-enhanced-meta .last-updated::before,
        .single-post-meta .meta-views .tie-icon-fire,
        .jannah-enhanced-meta .meta-views .tie-icon-fire {
            animation: none !important;
        }
        
        .single-post-meta *,
        .jannah-enhanced-meta * {
            transition: none !important;
        }
    }
    
    /* ============================================
       PRINT
       ============================================ */
    
    @media print {
        .single-post-meta.post-meta,
        .jannah-enhanced-meta {
            background: #f5f5f5 !important;
            border: 1px solid #ddd !important;
            padding: 0.5rem !important;
        }
        
        .single-post-meta.post-meta::before,
        .single-post-meta .meta-author-avatar::before,
        .single-post-meta .meta-author-avatar::after,
        .single-post-meta .author-email-link,
        .jannah-enhanced-meta::before,
        .jannah-enhanced-meta .meta-author-avatar::before,
        .jannah-enhanced-meta .meta-author-avatar::after,
        .jannah-enhanced-meta .author-email-link {
            display: none !important;
        }
    }
    
    /* ============================================
       FOCUS STYLES
       ============================================ */
    
    .single-post-meta a:focus-visible,
    .jannah-enhanced-meta a:focus-visible {
        outline: 2px solid var(--meta-primary) !important;
        outline-offset: 2px !important;
        border-radius: 4px !important;
    }
    
    /* Screen reader text */
    .single-post-meta .screen-reader-text,
    .jannah-enhanced-meta .screen-reader-text {
        position: absolute !important;
        width: 1px !important;
        height: 1px !important;
        padding: 0 !important;
        margin: -1px !important;
        overflow: hidden !important;
        clip: rect(0, 0, 0, 0) !important;
        white-space: nowrap !important;
        border: 0 !important;
    }
    </style>
    <?php
}

// =============================================
// 5. TRANSLATIONS
// =============================================
add_filter('gettext', 'tez_meta_translations', 20, 3);
function tez_meta_translations($translated, $text, $domain) {
    $translations = array(
        'minutes read' => 'دقیقه مطالعه',
        'minute read'  => 'دقیقه مطالعه',
        'min read'     => 'دقیقه',
        'views'        => 'بازدید',
        'comments'     => 'دیدگاه',
        'comment'      => 'دیدگاه',
    );
    
    $lower = strtolower($text);
    return isset($translations[$lower]) ? $translations[$lower] : $translated;
}

// =============================================
// 6. PRELOAD FONTS
// =============================================
add_action('wp_head', 'tez_meta_preload', 3);
function tez_meta_preload() {
    $path = TEZ_FA7_WEBFONTS_PATH;
    ?>
    <link rel="preload" href="<?php echo $path; ?>fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
    <?php
}
