<?php
/**
 * Typography & Local Fonts
 * Loads local Irancell fonts instead of Google Fonts.
 * Font Awesome is loaded by core-setup.php (tez_enqueue_fontawesome).
 * This file ONLY removes truly external/CDN FA sources, NOT parent theme handles.
 *
 * @package JannahChild
 * @version 3.1.0
 */

if ( ! defined('ABSPATH') ) exit;

// =============================================
// CONSTANTS (fallback if core-setup.php not loaded yet)
// =============================================
if ( ! defined('TEZ_FONT_PATH') ) define('TEZ_FONT_PATH', '/wp-content/uploads/fonts/Irancell/');
if ( ! defined('TEZ_FA_PATH') )   define('TEZ_FA_PATH',   '/wp-content/uploads/fonts/fontawesome/');

if ( ! function_exists('tez_get_font_url') ) { function tez_get_font_url() { return home_url(TEZ_FONT_PATH); } }
if ( ! function_exists('tez_get_fa_url') )   { function tez_get_fa_url()   { return home_url(TEZ_FA_PATH); } }

// =============================================
// DISABLE GOOGLE FONTS HANDLES
// =============================================
if ( ! function_exists('tez_typo_disable_google') ) {
    function tez_typo_disable_google() {
        $handles = array(
            'google-fonts', 'googlefonts', 'google-font',
            'wpb-google-fonts', 'flavor-google-fonts', 'flavor-fonts',
            'flavor_google_font', 'jannah-google-fonts', 'jannah-fonts',
            'tie-fonts', 'tie-google-fonts',
            'flavor-typography', 'flavor_typography', 'flavor-fontface',
        );
        foreach ( $handles as $h ) {
            wp_dequeue_style( $h );
            wp_deregister_style( $h );
        }
    }
    add_action('wp_enqueue_scripts', 'tez_typo_disable_google', 1);
    add_action('wp_enqueue_scripts', 'tez_typo_disable_google', 9999);
}

// =============================================
// DISABLE GOOGLE FONTS DNS HINTS
// =============================================
if ( ! function_exists('tez_typo_remove_hints') ) {
    function tez_typo_remove_hints( $urls, $relation_type ) {
        if ( $relation_type === 'dns-prefetch' || $relation_type === 'preconnect' ) {
            $urls = array_filter( $urls, function( $url ) {
                $href = is_array($url) ? ( $url['href'] ?? '' ) : $url;
                return strpos($href, 'fonts.googleapis.com')  === false
                    && strpos($href, 'fonts.gstatic.com')     === false
                    && strpos($href, 'kit.fontawesome.com')   === false;
            });
        }
        return $urls;
    }
    add_filter('wp_resource_hints', 'tez_typo_remove_hints', 10, 2);
}

// Disable Jannah/TieLabs Google Fonts filter hooks
add_filter('TieLabs/fonts_url', '__return_false');
add_filter('tie_fonts_url',     '__return_false');
add_filter('flavor_fonts_url',  '__return_false');

// =============================================
// DISABLE EXTERNAL CDN FONT AWESOME ONLY
// NOTE: We do NOT dequeue parent theme handles (jannah-fontawesome,
//       tie-fontawesome, flavor-fontawesome) because Jannah uses them
//       for its own UI icons. Our local FA7 (loaded by core-setup.php)
//       covers all Tez components via tez_fa_fix_css() font-family override.
// =============================================
if ( ! function_exists('tez_typo_disable_cdn_fa') ) {
    function tez_typo_disable_cdn_fa() {
        // Only CDN/external handles — NOT parent theme local handles
        $cdn_handles = array(
            'fontawesome-cdn',
            'font-awesome-cdn',
            'fa-kit',
            'fontawesome-kit',
        );
        foreach ( $cdn_handles as $h ) {
            wp_dequeue_style( $h );
            wp_deregister_style( $h );
            wp_dequeue_script( $h );
            wp_deregister_script( $h );
        }
    }
    add_action('wp_enqueue_scripts', 'tez_typo_disable_cdn_fa', 9999);
}

// =============================================
// PRELOAD IRANCELL FONT FILES
// Regular + Bold are the most used weights
// =============================================
if ( ! function_exists('tez_typo_preload_irancell') ) {
    function tez_typo_preload_irancell() {
        $font = tez_get_font_url();
        echo '<link rel="preload" href="' . esc_url($font . 'Irancell_Regular.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($font . 'Irancell_Bold.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
    }
    add_action('wp_head', 'tez_typo_preload_irancell', 1);
}

// =============================================
// @FONT-FACE DECLARATIONS + BODY TYPOGRAPHY
// Weights available: ExtraLight(200), Light(300), Regular(400),
//                   Medium(500), Bold(700), Extrabold(800)
// =============================================
if ( ! function_exists('tez_typo_main_styles') ) {
    function tez_typo_main_styles() {
        $u = tez_get_font_url();
    ?>
<style id="tez-typography">
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo esc_url($u); ?>Irancell_ExtraLight.woff2') format('woff2'),
         url('<?php echo esc_url($u); ?>Irancell_ExtraLight.woff') format('woff'),
         url('<?php echo esc_url($u); ?>Irancell_ExtraLight.ttf') format('truetype');
    font-weight: 200;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo esc_url($u); ?>Irancell_Light.woff2') format('woff2'),
         url('<?php echo esc_url($u); ?>Irancell_Light.woff') format('woff'),
         url('<?php echo esc_url($u); ?>Irancell_Light.ttf') format('truetype');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo esc_url($u); ?>Irancell_Regular.woff2') format('woff2'),
         url('<?php echo esc_url($u); ?>Irancell_Regular.woff') format('woff'),
         url('<?php echo esc_url($u); ?>Irancell_Regular.ttf') format('truetype');
    font-weight: 400;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo esc_url($u); ?>Irancell_Medium.woff2') format('woff2'),
         url('<?php echo esc_url($u); ?>Irancell_Medium.woff') format('woff'),
         url('<?php echo esc_url($u); ?>Irancell_Medium.ttf') format('truetype');
    font-weight: 500;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo esc_url($u); ?>Irancell_Bold.woff2') format('woff2'),
         url('<?php echo esc_url($u); ?>Irancell_Bold.woff') format('woff'),
         url('<?php echo esc_url($u); ?>Irancell_Bold.ttf') format('truetype');
    font-weight: 700;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo esc_url($u); ?>Irancell_Extrabold.woff2') format('woff2'),
         url('<?php echo esc_url($u); ?>Irancell_Extrabold.woff') format('woff'),
         url('<?php echo esc_url($u); ?>Irancell_Extrabold.ttf') format('truetype');
    font-weight: 800;
    font-style: normal;
    font-display: swap;
}

/* Apply Irancell globally — override Jannah/parent defaults */
:root { --tez-font: 'Irancell', 'Tahoma', 'Arial', system-ui, sans-serif; }
html, body, input, textarea, select, button {
    font-family: 'Irancell', 'Tahoma', 'Arial', system-ui, sans-serif !important;
}
body {
    font-size: 16px;
    line-height: 1.8;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
h1, h2, h3, h4, h5, h6,
.post-title, .entry-title, .widget-title {
    font-weight: 700;
    line-height: 1.4;
    font-family: 'Irancell', 'Tahoma', 'Arial', system-ui, sans-serif !important;
}
</style>
<?php
    }
    // Priority 9999 ensures we override parent theme typography styles
    add_action('wp_head', 'tez_typo_main_styles', 9999);
}

// =============================================
// OUTPUT BUFFER: Clean external CDN font links
// Removes any Google Fonts or FA Kit CDN URLs
// that slip through enqueue filtering
// =============================================
if ( ! function_exists('tez_typo_clean_output') ) {
    function tez_typo_clean_output( $html ) {
        if ( empty($html) ) return $html;
        $html = preg_replace('/<link[^>]*fonts\.googleapis\.com[^>]*>/i', '', $html);
        $html = preg_replace('/<link[^>]*fonts\.gstatic\.com[^>]*>/i',   '', $html);
        $html = preg_replace('/<script[^>]*kit\.fontawesome\.com[^>]*><\/script>/i', '', $html);
        $html = preg_replace('/<link[^>]*kit\.fontawesome\.com[^>]*>/i', '', $html);
        return $html;
    }
}
if ( ! function_exists('tez_typo_buffer_start') ) {
    function tez_typo_buffer_start() {
        if ( is_admin() ) return;
        ob_start('tez_typo_clean_output');
    }
    add_action('template_redirect', 'tez_typo_buffer_start');
}
if ( ! function_exists('tez_typo_buffer_end') ) {
    function tez_typo_buffer_end() {
        if ( is_admin() ) return;
        if ( ob_get_level() > 0 ) ob_end_flush();
    }
    add_action('shutdown', 'tez_typo_buffer_end', 0);
}
