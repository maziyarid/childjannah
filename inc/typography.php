<?php
/**
 * Typography & Local Fonts
 * Loads local Irancell/Vazirmatn fonts instead of Google Fonts.
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

// Source: Snippets/Typography & Icons - Local Fonts.php

if (!defined('TEZ_FONT_PATH')) define('TEZ_FONT_PATH', '/wp-content/uploads/fonts/Irancell/');
if (!defined('TEZ_FA_PATH'))   define('TEZ_FA_PATH',   '/wp-content/uploads/fonts/fontawesome/');

if (!function_exists('tez_get_font_url')) { function tez_get_font_url(){ return home_url(TEZ_FONT_PATH); } }
if (!function_exists('tez_get_fa_url'))   { function tez_get_fa_url(){ return home_url(TEZ_FA_PATH); } }

// Disable Google Fonts
if (!function_exists('tez_typo_disable_google')) {
    function tez_typo_disable_google() {
        $handles = array('google-fonts','googlefonts','google-font','wpb-google-fonts','flavor-google-fonts','flavor-fonts','flavor_google_font','jannah-google-fonts','jannah-fonts','tie-fonts','tie-google-fonts','flavor-typography','flavor_typography','flavor-fontface');
        foreach ($handles as $h) { wp_dequeue_style($h); wp_deregister_style($h); }
    }
    add_action('wp_enqueue_scripts','tez_typo_disable_google',1);
    add_action('wp_enqueue_scripts','tez_typo_disable_google',9999);
}

if (!function_exists('tez_typo_remove_hints')) {
    function tez_typo_remove_hints($urls,$relation_type){
        if ($relation_type === 'dns-prefetch' || $relation_type === 'preconnect') {
            $urls = array_filter($urls,function($url){
                $href = is_array($url) ? ($url['href'] ?? '') : $url;
                return strpos($href,'fonts.googleapis.com') === false && strpos($href,'fonts.gstatic.com') === false && strpos($href,'kit.fontawesome.com') === false;
            });
        }
        return $urls;
    }
    add_filter('wp_resource_hints','tez_typo_remove_hints',10,2);
}

add_filter('TieLabs/fonts_url','__return_false');
add_filter('tie_fonts_url','__return_false');
add_filter('flavor_fonts_url','__return_false');

// Disable external Font Awesome
if (!function_exists('tez_typo_disable_external_fa')) {
    function tez_typo_disable_external_fa() {
        $css = array('font-awesome','fontawesome','font-awesome-4','font-awesome-5','font-awesome-6','font-awesome-7','fontawesome-free','fontawesome-pro','tie-fontawesome','flavor-fontawesome','jannah-fontawesome','fa-css','fa-all','fa-solid','fa-regular','fa-light','fa-thin','fa-duotone','fa-brands','fa-sharp','fontawesome-all');
        $js = array('font-awesome','fontawesome','font-awesome-5','font-awesome-6','font-awesome-7','fontawesome-free','fontawesome-pro','tie-fontawesome','flavor-fontawesome','jannah-fontawesome');
        foreach ($css as $h){ wp_dequeue_style($h); wp_deregister_style($h); }
        foreach ($js as $h){ wp_dequeue_script($h); wp_deregister_script($h); }
    }
    add_action('wp_enqueue_scripts','tez_typo_disable_external_fa',1);
    add_action('wp_enqueue_scripts','tez_typo_disable_external_fa',9999);
}

// Enqueue FA7 Pro
if (!function_exists('tez_header_enqueue_fa')) {
    function tez_header_enqueue_fa() {
        $fa_url = home_url(TEZ_FA_PATH);
        wp_enqueue_style('tez-fontawesome-all', $fa_url . 'css/all.css', array(), '7.0.0');
        wp_enqueue_style('tez-fontawesome-brands', $fa_url . 'css/brands.css', array('tez-fontawesome-all'), '7.0.0');
        wp_enqueue_style('tez-fontawesome-duotone', $fa_url . 'css/duotone.css', array('tez-fontawesome-all'), '7.0.0');
    }
    add_action('wp_enqueue_scripts', 'tez_header_enqueue_fa', 1);
    add_action('admin_enqueue_scripts', 'tez_header_enqueue_fa', 1);
}

// Preload FA webfonts
if (!function_exists('tez_header_preload_fa')) {
    function tez_header_preload_fa() {
        $fa_url = home_url(TEZ_FA_PATH);
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-solid-900.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-regular-400.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-brands-400.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
    }
    add_action('wp_head', 'tez_header_preload_fa', 1);
}

// Preload critical Irancell font files (Regular + Bold used most)
if (!function_exists('tez_typo_preload_irancell')) {
    function tez_typo_preload_irancell() {
        $font = tez_get_font_url();
        echo '<link rel="preload" href="' . esc_url($font . 'Irancell_Regular.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($font . 'Irancell_Bold.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
    }
    add_action('wp_head', 'tez_typo_preload_irancell', 1);
}

// Typography styles with @font-face declarations
// Actual files on server: ExtraLight, Light, Regular, Medium, Bold, Extrabold
// Each available in .eot, .ttf, .woff, .woff2
if (!function_exists('tez_typo_main_styles')) {
    function tez_typo_main_styles() {
        $u = tez_get_font_url();
    ?>
<style id="tez-typography">
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo $u; ?>Irancell_ExtraLight.eot');
    src: url('<?php echo $u; ?>Irancell_ExtraLight.eot?#iefix') format('embedded-opentype'),
         url('<?php echo $u; ?>Irancell_ExtraLight.woff2') format('woff2'),
         url('<?php echo $u; ?>Irancell_ExtraLight.woff') format('woff'),
         url('<?php echo $u; ?>Irancell_ExtraLight.ttf') format('truetype');
    font-weight: 200;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo $u; ?>Irancell_Light.eot');
    src: url('<?php echo $u; ?>Irancell_Light.eot?#iefix') format('embedded-opentype'),
         url('<?php echo $u; ?>Irancell_Light.woff2') format('woff2'),
         url('<?php echo $u; ?>Irancell_Light.woff') format('woff'),
         url('<?php echo $u; ?>Irancell_Light.ttf') format('truetype');
    font-weight: 300;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo $u; ?>Irancell_Regular.eot');
    src: url('<?php echo $u; ?>Irancell_Regular.eot?#iefix') format('embedded-opentype'),
         url('<?php echo $u; ?>Irancell_Regular.woff2') format('woff2'),
         url('<?php echo $u; ?>Irancell_Regular.woff') format('woff'),
         url('<?php echo $u; ?>Irancell_Regular.ttf') format('truetype');
    font-weight: 400;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo $u; ?>Irancell_Medium.eot');
    src: url('<?php echo $u; ?>Irancell_Medium.eot?#iefix') format('embedded-opentype'),
         url('<?php echo $u; ?>Irancell_Medium.woff2') format('woff2'),
         url('<?php echo $u; ?>Irancell_Medium.woff') format('woff'),
         url('<?php echo $u; ?>Irancell_Medium.ttf') format('truetype');
    font-weight: 500;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo $u; ?>Irancell_Bold.eot');
    src: url('<?php echo $u; ?>Irancell_Bold.eot?#iefix') format('embedded-opentype'),
         url('<?php echo $u; ?>Irancell_Bold.woff2') format('woff2'),
         url('<?php echo $u; ?>Irancell_Bold.woff') format('woff'),
         url('<?php echo $u; ?>Irancell_Bold.ttf') format('truetype');
    font-weight: 700;
    font-style: normal;
    font-display: swap;
}
@font-face {
    font-family: 'Irancell';
    src: url('<?php echo $u; ?>Irancell_Extrabold.eot');
    src: url('<?php echo $u; ?>Irancell_Extrabold.eot?#iefix') format('embedded-opentype'),
         url('<?php echo $u; ?>Irancell_Extrabold.woff2') format('woff2'),
         url('<?php echo $u; ?>Irancell_Extrabold.woff') format('woff'),
         url('<?php echo $u; ?>Irancell_Extrabold.ttf') format('truetype');
    font-weight: 800;
    font-style: normal;
    font-display: swap;
}
:root{--tez-font:'Irancell','Tahoma','Arial',system-ui,sans-serif}
html,body,input,textarea,select,button{font-family:'Irancell','Tahoma','Arial',system-ui,sans-serif!important}
body{font-size:16px;line-height:1.8;font-weight:400;-webkit-font-smoothing:antialiased}
h1,h2,h3,h4,h5,h6,.post-title,.entry-title,.widget-title{font-weight:700;line-height:1.4}
</style>
<?php }
    add_action('wp_head','tez_typo_main_styles',9999);
}

// Clean external font output
if (!function_exists('tez_typo_clean_output')) {
    function tez_typo_clean_output($html){
        if (empty($html)) return $html;
        $html = preg_replace('/<link[^>]*fonts\.googleapis\.com[^>]*>/i','',$html);
        $html = preg_replace('/<link[^>]*fonts\.gstatic\.com[^>]*>/i','',$html);
        $html = preg_replace('/<script[^>]*kit\.fontawesome\.com[^>]*><\/script>/i','',$html);
        $html = preg_replace('/<link[^>]*kit\.fontawesome\.com[^>]*>/i','',$html);
        return $html;
    }
}
if (!function_exists('tez_typo_buffer_start')) {
    function tez_typo_buffer_start(){ if (is_admin()) return; ob_start('tez_typo_clean_output'); }
    add_action('template_redirect','tez_typo_buffer_start');
}
if (!function_exists('tez_typo_buffer_end')) {
    function tez_typo_buffer_end(){ if (is_admin()) return; if (ob_get_level()>0) ob_end_flush(); }
    add_action('shutdown','tez_typo_buffer_end',0);
}
