if (!defined('ABSPATH')) exit;

// =============================================
// FONT PATHS
// =============================================
if (!defined('TEZ_FONT_PATH')) define('TEZ_FONT_PATH', '/wp-content/uploads/fonts/Irancell/');
if (!defined('TEZ_FA_PATH'))   define('TEZ_FA_PATH',   '/wp-content/uploads/fonts/fontawesome/');

// Helpers
if (!function_exists('tez_get_font_url')) { function tez_get_font_url(){ return home_url(TEZ_FONT_PATH); } }
if (!function_exists('tez_get_fa_url'))   { function tez_get_fa_url(){ return home_url(TEZ_FA_PATH); } }

// =============================================
// DISABLE GOOGLE FONTS
// =============================================
if (!function_exists('tez_typo_disable_google')) {
    function tez_typo_disable_google() {
        $handles = array(
            'google-fonts','googlefonts','google-font','wpb-google-fonts',
            'flavor-google-fonts','flavor-fonts','flavor_google_font',
            'jannah-google-fonts','jannah-fonts','tie-fonts','tie-google-fonts',
            'flavor-typography','flavor_typography','flavor-fontface',
        );
        foreach ($handles as $h) { wp_dequeue_style($h); wp_deregister_style($h); }
    }
    add_action('wp_enqueue_scripts','tez_typo_disable_google',1);
    add_action('wp_enqueue_scripts','tez_typo_disable_google',9999);
}

// Remove DNS prefetch/preconnect to Google/FA CDN
if (!function_exists('tez_typo_remove_hints')) {
    function tez_typo_remove_hints($urls,$relation_type){
        if ($relation_type === 'dns-prefetch' || $relation_type === 'preconnect') {
            $urls = array_filter($urls,function($url){
                $href = is_array($url) ? ($url['href'] ?? '') : $url;
                return strpos($href,'fonts.googleapis.com') === false
                    && strpos($href,'fonts.gstatic.com') === false
                    && strpos($href,'kit.fontawesome.com') === false;
            });
        }
        return $urls;
    }
    add_filter('wp_resource_hints','tez_typo_remove_hints',10,2);
}

// Block theme font filters
add_filter('TieLabs/fonts_url','__return_false');
add_filter('tie_fonts_url','__return_false');
add_filter('flavor_fonts_url','__return_false');

// =============================================
// DISABLE ALL EXTERNAL FONT AWESOME
// =============================================
if (!function_exists('tez_typo_disable_external_fa')) {
    function tez_typo_disable_external_fa() {
        $css = array(
            'font-awesome','fontawesome','font-awesome-4','font-awesome-5','font-awesome-6','font-awesome-7',
            'fontawesome-free','fontawesome-pro','tie-fontawesome','flavor-fontawesome','jannah-fontawesome',
            'fa-css','fa-all','fa-solid','fa-regular','fa-light','fa-thin','fa-duotone','fa-brands','fa-sharp','fontawesome-all',
        );
        $js = array(
            'font-awesome','fontawesome','font-awesome-5','font-awesome-6','font-awesome-7',
            'fontawesome-free','fontawesome-pro','tie-fontawesome','flavor-fontawesome','jannah-fontawesome',
        );
        foreach ($css as $h){ wp_dequeue_style($h); wp_deregister_style($h); }
        foreach ($js as $h){ wp_dequeue_script($h); wp_deregister_script($h); }
    }
    add_action('wp_enqueue_scripts','tez_typo_disable_external_fa',1);
    add_action('wp_enqueue_scripts','tez_typo_disable_external_fa',9999);
}

// =============================================
// ENQUEUE FONT AWESOME 7 PRO (all + explicit brands)
// =============================================
if (!function_exists('tez_header_enqueue_fa')) {
    function tez_header_enqueue_fa() {
        $fa_url = home_url(TEZ_FA_PATH);
        wp_enqueue_style('tez-fontawesome-all',    $fa_url . 'css/all.css',    array(), '7.0.0');
		wp_enqueue_style('tez-fontawesome-brands', $fa_url . 'css/brands.css', array('tez-fontawesome-all'), '7.0.0');
		wp_enqueue_style('tez-fontawesome-duotone', $fa_url . 'css/duotone.css', array('tez-fontawesome-all'), '7.0.0');

    }
    add_action('wp_enqueue_scripts', 'tez_header_enqueue_fa', 1);
    add_action('admin_enqueue_scripts', 'tez_header_enqueue_fa', 1);
}

// =============================================
// PRELOAD FONT AWESOME WEBFONTS (add brands woff fallback)
// =============================================
if (!function_exists('tez_header_preload_fa')) {
    function tez_header_preload_fa() {
        $fa_url = home_url(TEZ_FA_PATH);
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-solid-900.woff2')   . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-regular-400.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-brands-400.woff2')  . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-duotone-regular-400.woff2')   . '" as="font" type="font/woff2"  crossorigin="anonymous">' . "\n";
		
    }
    add_action('wp_head', 'tez_header_preload_fa', 1);
}

// =============================================
// CRITICAL CSS + FONT AWESOME FIX (add explicit Brands fallback list)
// =============================================
if (!function_exists('tez_header_critical_css')) {
    function tez_header_critical_css() {
        echo '<style id="tez-critical-css">
:root{--tez-primary:#2563eb;--tez-secondary:#1FA640;--tez-bg:#fff;--tez-text:#111827;--tez-border:#e5e7eb}
[data-theme="dark"]{--tez-bg:#0f172a;--tez-text:#f1f5f9;--tez-border:#334155}
[data-theme="sepia"]{--tez-bg:#f4f1ea;--tez-text:#5c4a33;--tez-border:#d4c5ab}
body{background:var(--tez-bg);color:var(--tez-text)}
.tez-site-header{position:sticky;top:0;z-index:9999;background:var(--tez-bg);min-height:70px}

/* Font Awesome Icon Styles with FA7 + fallbacks */
.fa,.fas,.far,.fal,.fat,.fad,.fab,.fass,.fasr,.fasl,.fast,.fasd,
.fa-solid,.fa-regular,.fa-light,.fa-thin,.fa-duotone,.fa-brands,
.fa-sharp-solid,.fa-sharp-regular,.fa-sharp-light,.fa-sharp-thin,.fa-sharp-duotone,
[class*="fa-"]{
    font-family:
        "Font Awesome 7 Pro",
        "Font Awesome 7 Free",
        "Font Awesome 6 Pro",
        "Font Awesome 6 Free",
        "FontAwesome";
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    font-style:normal;
    font-variant:normal;
    text-rendering:auto;
    line-height:1;
    display:inline-block;
}
/* Explicit brands fallback list */
.fa-brands,.fab{
    font-family:
        "Font Awesome 7 Pro Brands",
        "Font Awesome 7 Brands",
        "Font Awesome 6 Pro Brands",
        "Font Awesome 6 Brands",
        "Font Awesome 5 Brands",
        "FontAwesome" !important;
    font-weight:400;
}
.fa-duotone,.fad{
    font-family:
        "Font Awesome 7 Pro Duotone",
        "Font Awesome 6 Pro Duotone",
        "Font Awesome 6 Duotone" !important;
    font-weight:900;
}
.fa-solid,.fas{font-weight:900}
.fa-regular,.far{font-weight:400}
.fa-light,.fal{font-weight:300}
.fa-thin,.fat{font-weight:100}
.fa-xs{font-size:.75em}
.fa-sm{font-size:.875em}
.fa-lg{font-size:1.25em}
.fa-xl{font-size:1.5em}
.fa-2x{font-size:2em}
.fa-3x{font-size:3em}
.fa-fw{text-align:center;width:1.25em}
.fa-spin{animation:fa-spin 2s infinite linear}
@keyframes fa-spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}
.btn i,.button i,.tez-btn i,a i{margin-left:.375em}
</style>' . "\n";
        echo '<script>(function(){var t=localStorage.getItem("tez-theme");if(t)document.documentElement.setAttribute("data-theme",t);document.documentElement.classList.add("js-enabled")})();</script>' . "\n";
    }
    add_action('wp_head', 'tez_header_critical_css', 3);
}

// =============================================
// PRELOAD FONTS (includes Brands)
// =============================================
if (!function_exists('tez_typo_preload')) {
    function tez_typo_preload() {
        $font = tez_get_font_url();
        $fa   = tez_get_fa_url();
        echo '<link rel="preload" href="'.esc_url($font.'Irancell_Regular.woff2').'" as="font" type="font/woff2" crossorigin="anonymous">'."\n";
        echo '<link rel="preload" href="'.esc_url($font.'Irancell_Bold.woff2').'" as="font" type="font/woff2" crossorigin="anonymous">'."\n";
        echo '<link rel="preload" href="'.esc_url($fa.'webfonts/fa-solid-900.woff2').'" as="font" type="font/woff2" crossorigin="anonymous">'."\n";
        echo '<link rel="preload" href="'.esc_url($fa.'webfonts/fa-brands-400.woff2').'" as="font" type="font/woff2" crossorigin="anonymous">'."\n";
    }
    add_action('wp_head','tez_typo_preload',1);
}

// =============================================
// FONT AWESOME FIX CSS (FA7 family names, includes Brands)
// =============================================
if (!function_exists('tez_typo_fa_fix')) {
    function tez_typo_fa_fix() { ?>
<style id="tez-fa-fix">
.fa,.fas,.fa-solid{font-family:'Font Awesome 7 Pro'!important;font-weight:900}
.far,.fa-regular{font-family:'Font Awesome 7 Pro'!important;font-weight:400}
.fal,.fa-light{font-family:'Font Awesome 7 Pro'!important;font-weight:300}
.fat,.fa-thin{font-family:'Font Awesome 7 Pro'!important;font-weight:100}
.fad,.fa-duotone{font-family:'Font Awesome 7 Pro Duotone'!important;font-weight:900}
.fab,.fa-brands{font-family:'Font Awesome 7 Pro Brands'!important;font-weight:400}
.fass,.fa-sharp-solid{font-family:'Font Awesome 7 Pro Sharp'!important;font-weight:900}
.fasr,.fa-sharp-regular{font-family:'Font Awesome 7 Pro Sharp'!important;font-weight:400}
.fasl,.fa-sharp-light{font-family:'Font Awesome 7 Pro Sharp'!important;font-weight:300}
.fast,.fa-sharp-thin{font-family:'Font Awesome 7 Pro Sharp'!important;font-weight:100}
.fasd,.fa-sharp-duotone{font-family:'Font Awesome 7 Pro Sharp Duotone'!important;font-weight:900}

.fa,.fas,.far,.fal,.fat,.fad,.fab,.fass,.fasr,.fasl,.fast,.fasd,
.fa-solid,.fa-regular,.fa-light,.fa-thin,.fa-duotone,.fa-brands,
.fa-sharp-solid,.fa-sharp-regular,.fa-sharp-light,.fa-sharp-thin,.fa-sharp-duotone,
[class*="fa-"]{
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    font-style:normal;
    font-variant:normal;
    text-rendering:auto;
    line-height:1;
    display:inline-block;
}
.fa-xs{font-size:.75em}
.fa-sm{font-size:.875em}
.fa-lg{font-size:1.25em}
.fa-xl{font-size:1.5em}
.fa-2x{font-size:2em}
.fa-3x{font-size:3em}
.fa-4x{font-size:4em}
.fa-5x{font-size:5em}
.fa-fw{text-align:center;width:1.25em}
.fa-spin{animation:fa-spin 2s infinite linear}
@keyframes fa-spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}
.fa-rotate-90{transform:rotate(90deg)}
.fa-rotate-180{transform:rotate(180deg)}
.fa-rotate-270{transform:rotate(270deg)}
.fa-flip-horizontal{transform:scaleX(-1)}
.fa-flip-vertical{transform:scaleY(-1)}
.btn i,.button i,.tez-btn i,a i{margin-left:.375em}
</style>
<?php }
    add_action('wp_head','tez_typo_fa_fix',5);
}

// =============================================
// TYPOGRAPHY STYLES (keeps FA fonts intact)
// =============================================
if (!function_exists('tez_typo_main_styles')) {
    function tez_typo_main_styles() { ?>
<style id="tez-typography">
:root{--tez-font:'Irancell','Tahoma','Arial',system-ui,sans-serif}
html,body,input,textarea,select,button{
    font-family:'Irancell','Tahoma','Arial',system-ui,sans-serif!important;
}
body{
    font-size:16px; line-height:1.8; font-weight:400; -webkit-font-smoothing:antialiased;
}
h1,h2,h3,h4,h5,h6,.post-title,.entry-title,.widget-title{font-weight:700;line-height:1.4;}
/* (rest of your typography as needed) */
</style>
<?php }
    add_action('wp_head','tez_typo_main_styles',9999);
}

// =============================================
// CLEAN EXTERNAL FONT OUTPUT
// =============================================
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