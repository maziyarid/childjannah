<?php
/**
 * Core Setup - Constants, Font Awesome, Header, Nav Walkers, Critical CSS
 * Extracted from Snippets/Core PHP Functions & Setup.php
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

// =============================================
// CONSTANTS
// =============================================
if (!defined('TEZ_VERSION'))       define('TEZ_VERSION', '3.0.0');
if (!defined('TEZ_PHONE'))         define('TEZ_PHONE', '09331663849');
if (!defined('TEZ_PHONE_DISPLAY')) define('TEZ_PHONE_DISPLAY', '۰۹۳۳۱۶۶۳۸۴۹');
if (!defined('TEZ_WHATSAPP'))      define('TEZ_WHATSAPP', '09331663849');
if (!defined('TEZ_TELEGRAM'))      define('TEZ_TELEGRAM', 'Thesissupport');
if (!defined('TEZ_EMAIL'))         define('TEZ_EMAIL', 'teznevisancompany@gmail.com');
if (!defined('TEZ_SITE_URL'))      define('TEZ_SITE_URL', 'https://teznevisan3.com');
if (!defined('TEZ_LOGO'))          define('TEZ_LOGO', '/wp-content/uploads/logo/teznevisan.svg');
if (!defined('TEZ_FAVICON'))       define('TEZ_FAVICON', '/wp-content/uploads/logo/favicon.svg');
if (!defined('TEZ_FA_URL'))        define('TEZ_FA_URL', '/wp-content/uploads/fonts/fontawesome/');
if (!defined('TEZ_FONT_URL'))      define('TEZ_FONT_URL', '/wp-content/uploads/fonts/Irancell/');
if (!defined('TEZ_PRIMARY'))       define('TEZ_PRIMARY', '#22BE49');
if (!defined('TEZ_PRIMARY_DARK'))  define('TEZ_PRIMARY_DARK', '#1a9e3b');

// =============================================
// ENQUEUE FONT AWESOME 7 PRO
// =============================================
if (!function_exists('tez_enqueue_fontawesome')) {
    function tez_enqueue_fontawesome() {
        $fa_url = home_url(TEZ_FA_URL);
        wp_enqueue_style('tez-fontawesome', $fa_url . 'css/all.css', array(), '7.0.0');
    }
    add_action('wp_enqueue_scripts', 'tez_enqueue_fontawesome', 5);
    add_action('admin_enqueue_scripts', 'tez_enqueue_fontawesome', 5);
}

// =============================================
// DISABLE EXTERNAL FONT AWESOME (prevent conflicts)
// =============================================
if (!function_exists('tez_disable_external_fa')) {
    function tez_disable_external_fa() {
        $handles = array(
            'font-awesome','fontawesome','font-awesome-4','font-awesome-5','font-awesome-6','font-awesome-7',
            'fontawesome-free','fontawesome-pro','tie-fontawesome','flavor-fontawesome','jannah-fontawesome',
            'fa-css','fa-all','fa-brands','fa-solid','fa-regular','fa-light','fa-thin','fa-duotone','fa-sharp','fontawesome-all',
        );
        foreach ($handles as $handle) {
            wp_dequeue_style($handle);
            wp_deregister_style($handle);
        }
    }
    add_action('wp_enqueue_scripts', 'tez_disable_external_fa', 1);
    add_action('wp_enqueue_scripts', 'tez_disable_external_fa', 100);
}

// =============================================
// PREVENT DUPLICATE HEADER
// =============================================
if (!function_exists('tez_remove_theme_header')) {
    function tez_remove_theme_header() {
        remove_all_actions('wp_body_open');
        add_action('wp_body_open', 'tez_output_header_html', 5);
    }
    add_action('after_setup_theme', 'tez_remove_theme_header', 999);
}

// =============================================
// REGISTER NAV MENUS
// =============================================
if (!function_exists('tez_register_menus_init')) {
    function tez_register_menus_init() {
        register_nav_menus(array(
            'tez_primary'  => 'منوی اصلی تزنویسان',
            'tez_mobile'   => 'منوی موبایل',
            'tez_footer_1' => 'خدمات فوتر',
            'tez_footer_2' => 'لینک‌های مفید فوتر',
        ));
    }
    add_action('after_setup_theme', 'tez_register_menus_init', 20);
}

// =============================================
// DESKTOP NAV WALKER
// =============================================
if (!class_exists('Tez_Desktop_Nav_Walker')) {
    class Tez_Desktop_Nav_Walker extends Walker_Nav_Menu {
        public function start_lvl(&$output, $depth = 0, $args = null) { $output .= '<ul class="tez-dropdown-menu">'; }
        public function end_lvl(&$output, $depth = 0, $args = null)   { $output .= '</ul>'; }
        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $has_children = in_array('menu-item-has-children', $classes);
            $is_current = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);
            $li_class = 'tez-menu-item';
            if ($has_children && $depth === 0) $li_class .= ' tez-has-dropdown';
            if ($is_current) $li_class .= ' current';
            $output .= '<li class="' . esc_attr($li_class) . '">';
            $icon = get_post_meta($item->ID, '_menu_item_icon', true);
            $link_class = 'tez-nav-link';
            if ($is_current) $link_class .= ' active';
            $output .= '<a href="' . esc_url($item->url) . '" class="' . esc_attr($link_class) . '">';
            if ($icon && $depth > 0) { $output .= '<i class="' . esc_attr($icon) . '"></i>'; }
            $output .= '<span>' . esc_html($item->title) . '</span>';
            if ($has_children && $depth === 0) { $output .= ' <i class="fa-solid fa-chevron-down tez-dropdown-arrow"></i>'; }
            $output .= '</a>';
        }
        public function end_el(&$output, $item, $depth = 0, $args = null) { $output .= '</li>'; }
    }
}

// =============================================
// MOBILE NAV WALKER
// =============================================
if (!class_exists('Tez_Mobile_Nav_Walker')) {
    class Tez_Mobile_Nav_Walker extends Walker_Nav_Menu {
        public function start_lvl(&$output, $depth = 0, $args = null) { $output .= '<ul class="tez-mobile-submenu">'; }
        public function end_lvl(&$output, $depth = 0, $args = null)   { $output .= '</ul>'; }
        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $has_children = in_array('menu-item-has-children', $classes);
            $is_current = in_array('current-menu-item', $classes);
            $li_class = 'tez-mobile-menu-item';
            if ($has_children && $depth === 0) $li_class .= ' tez-has-submenu';
            if ($is_current) $li_class .= ' current';
            $output .= '<li class="' . esc_attr($li_class) . '">';
            if ($has_children && $depth === 0) {
                $output .= '<button type="button" class="tez-submenu-toggle" aria-expanded="false">';
                $output .= '<span>' . esc_html($item->title) . '</span>';
                $output .= '<i class="fa-solid fa-chevron-down"></i>';
                $output .= '</button>';
            } else {
                $active_class = $is_current ? ' active' : '';
                $output .= '<a href="' . esc_url($item->url) . '" class="tez-mobile-link' . $active_class . '">';
                $output .= esc_html($item->title);
                $output .= '</a>';
            }
        }
        public function end_el(&$output, $item, $depth = 0, $args = null) { $output .= '</li>'; }
    }
}

// =============================================
// MENU ICON FIELD (Font Awesome icon per menu item)
// =============================================
if (!function_exists('tez_add_menu_icon_field')) {
    function tez_add_menu_icon_field($item_id, $item, $depth, $args) {
        $icon = get_post_meta($item_id, '_menu_item_icon', true);
        echo '<p class="field-icon description description-wide">';
        echo '<label for="edit-menu-item-icon-' . esc_attr($item_id) . '">';
        echo 'آیکون Font Awesome<br>';
        echo '<input type="text" id="edit-menu-item-icon-' . esc_attr($item_id) . '" class="widefat code" name="menu-item-icon[' . esc_attr($item_id) . ']" value="' . esc_attr($icon) . '" placeholder="fa-solid fa-graduation-cap">';
        echo '</label></p>';
    }
    add_filter('wp_nav_menu_item_custom_fields', 'tez_add_menu_icon_field', 10, 4);
}

if (!function_exists('tez_save_menu_icon_field')) {
    function tez_save_menu_icon_field($menu_id, $menu_item_db_id) {
        if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
            $icon = sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, '_menu_item_icon', $icon);
        }
    }
    add_action('wp_update_nav_menu_item', 'tez_save_menu_icon_field', 10, 2);
}

// =============================================
// FAVICON
// =============================================
if (!function_exists('tez_output_favicon')) {
    function tez_output_favicon() {
        $favicon = home_url(TEZ_FAVICON);
        echo '<link rel="icon" href="' . esc_url($favicon) . '" type="image/svg+xml">';
        echo '<link rel="apple-touch-icon" href="' . esc_url($favicon) . '">';
        echo '<meta name="theme-color" content="#22BE49">';
    }
    add_action('wp_head', 'tez_output_favicon', 1);
    add_action('admin_head', 'tez_output_favicon', 1);
}

// =============================================
// PRELOAD FONT AWESOME WEBFONTS
// =============================================
if (!function_exists('tez_preload_fa')) {
    function tez_preload_fa() {
        $fa_url = home_url(TEZ_FA_URL);
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-solid-900.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-regular-400.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
        echo '<link rel="preload" href="' . esc_url($fa_url . 'webfonts/fa-brands-400.woff2') . '" as="font" type="font/woff2" crossorigin="anonymous">' . "\n";
    }
    add_action('wp_head', 'tez_preload_fa', 1);
}

// =============================================
// CRITICAL CSS (inline in <head>)
// =============================================
if (!function_exists('tez_output_critical_css')) {
    function tez_output_critical_css() {
        echo '<style id="tez-critical-css">
:root{--tez-primary:#22BE49;--tez-primary-dark:#1a9e3b;--tez-primary-rgb:34,190,73;--tez-secondary:#1a73e8;--tez-bg:#fff;--tez-text:#111827;--tez-border:#e5e7eb;--tez-font:"Vazirmatn","IRANSans","Tahoma",system-ui,sans-serif}
[data-theme="dark"]{--tez-primary:#34d45c;--tez-bg:#0f172a;--tez-text:#f1f5f9;--tez-border:#334155}
[data-theme="sepia"]{--tez-primary:#5d8a3c;--tez-bg:#faf6f1;--tez-text:#44403c;--tez-border:#d6cfc4}
html{font-size:16px}
body{font-family:var(--tez-font)!important;background:var(--tez-bg);color:var(--tez-text);direction:rtl;margin:0}
.tez-site-header{position:sticky;top:0;z-index:9999;background:var(--tez-bg);min-height:70px}
</style>';
        echo '<script>(function(){var t=localStorage.getItem("tez-theme");if(t)document.documentElement.setAttribute("data-theme",t);document.documentElement.classList.add("js-enabled")})();</script>';
    }
    add_action('wp_head', 'tez_output_critical_css', 3);
}

// =============================================
// FONT AWESOME FIX CSS
// =============================================
if (!function_exists('tez_fa_fix_css')) {
    function tez_fa_fix_css() {
        echo '<style id="tez-fa-fix">
.fa,.fas,.far,.fal,.fat,.fad,.fab,.fass,.fasr,.fasl,.fast,.fasd,
.fa-solid,.fa-regular,.fa-light,.fa-thin,.fa-duotone,.fa-brands,
.fa-sharp-solid,.fa-sharp-regular,.fa-sharp-light,.fa-sharp-thin,.fa-sharp-duotone,
[class*="fa-"]{font-family:"Font Awesome 7 Pro","Font Awesome 7 Free","Font Awesome 6 Pro","Font Awesome 6 Free","FontAwesome";-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;font-style:normal;font-variant:normal;text-rendering:auto;line-height:1;display:inline-block}
.fa-solid,.fas{font-weight:900}.fa-regular,.far{font-weight:400}.fa-light,.fal{font-weight:300}.fa-thin,.fat{font-weight:100}
.fa-brands,.fab{font-family:"Font Awesome 7 Pro Brands","Font Awesome 7 Brands","Font Awesome 6 Pro Brands","Font Awesome 6 Brands","Font Awesome 5 Brands","FontAwesome"!important;font-weight:400}
.fa-duotone,.fad{font-family:"Font Awesome 7 Pro Duotone","Font Awesome 6 Pro Duotone","Font Awesome 6 Duotone"!important;font-weight:900}
.fa-xs{font-size:.75em}.fa-sm{font-size:.875em}.fa-lg{font-size:1.25em}.fa-xl{font-size:1.5em}.fa-2x{font-size:2em}.fa-3x{font-size:3em}.fa-fw{text-align:center;width:1.25em}
.fa-spin{animation:fa-spin 2s infinite linear}@keyframes fa-spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
.btn i,.button i,a i,.tez-btn i{margin-left:.375em}
</style>';
    }
    add_action('wp_head', 'tez_fa_fix_css', 4);
}

// =============================================
// LOGO STYLES
// =============================================
if (!function_exists('tez_output_logo_styles')) {
    function tez_output_logo_styles() {
        echo '<style id="tez-logo-styles">
.tez-logo-link{display:inline-flex;align-items:center;text-decoration:none}
.tez-logo{display:block;width:220px;height:60px;max-width:100%;object-fit:contain}
@media(max-width:991px){.tez-logo{width:180px;height:50px}}
@media(max-width:767px){.tez-logo{width:150px;height:42px}}
@media(max-width:480px){.tez-logo{width:130px;height:36px}}
.tez-mobile-logo-link .tez-logo{width:160px;height:44px}
</style>';
    }
    add_action('wp_head', 'tez_output_logo_styles', 2);
}

// =============================================
// BODY CLASSES
// =============================================
if (!function_exists('tez_filter_body_classes')) {
    function tez_filter_body_classes($classes) {
        $remove = array('sidebar-right', 'sidebar-left', 'has-sidebar', 'boxed-layout', 'has-sticky-header');
        $classes = array_diff($classes, $remove);
        $classes[] = 'tez-theme-active';
        $classes[] = 'tez-full-width';
        $classes[] = 'tez-no-sidebar';
        return $classes;
    }
    add_filter('body_class', 'tez_filter_body_classes', 999);
}

// =============================================
// HEADER OUTPUT
// =============================================
if (!function_exists('tez_output_header_html')) {
    function tez_output_header_html() {
        static $header_output = false;
        if ($header_output) return;
        $header_output = true;

        $logo = home_url(TEZ_LOGO);
        $name = get_bloginfo('name');
        $home = home_url('/');
        $phone = TEZ_PHONE;
        $phone_display = TEZ_PHONE_DISPLAY;
        $inquiry = home_url('/inquiry');
        ?>
<a href="#tez-main-content" class="tez-skip-link">رفتن به محتوای اصلی</a>

<div class="tez-theme-buttons" id="tez-theme-buttons" role="toolbar">
    <button type="button" class="tez-mode-btn active" data-theme="light" title="حالت روشن" aria-pressed="true"><i class="fa-solid fa-sun"></i></button>
    <button type="button" class="tez-mode-btn" data-theme="dark" title="حالت تاریک" aria-pressed="false"><i class="fa-solid fa-moon"></i></button>
    <button type="button" class="tez-mode-btn" data-theme="sepia" title="حالت کتاب" aria-pressed="false"><i class="fa-solid fa-book-open"></i></button>
</div>

<div class="tez-a11y-toolbar" id="tez-a11y-toolbar" role="toolbar">
    <button type="button" class="tez-a11y-btn" data-action="increase-font" title="افزایش متن"><i class="fa-solid fa-plus"></i></button>
    <button type="button" class="tez-a11y-btn" data-action="decrease-font" title="کاهش متن"><i class="fa-solid fa-minus"></i></button>
    <button type="button" class="tez-a11y-btn" data-action="high-contrast" title="کنتراست"><i class="fa-solid fa-circle-half-stroke"></i></button>
    <button type="button" class="tez-a11y-btn" data-action="reset" title="بازنشانی"><i class="fa-solid fa-rotate-right"></i></button>
</div>

<header id="tez-masthead" class="tez-site-header">
    <div class="tez-container">
        <div class="tez-header-inner">
            <div class="tez-site-branding">
                <a href="<?php echo esc_url($home); ?>" class="tez-logo-link" rel="home">
                    <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($name); ?>" class="tez-logo" width="220" height="60">
                </a>
            </div>

            <nav class="tez-main-nav" id="tez-main-nav" role="navigation">
                <?php
                if (has_nav_menu('tez_primary')) {
                    wp_nav_menu(array('theme_location' => 'tez_primary', 'container' => false, 'menu_class' => 'tez-nav-menu', 'fallback_cb' => false, 'walker' => new Tez_Desktop_Nav_Walker()));
                } elseif (has_nav_menu('primary')) {
                    wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'tez-nav-menu', 'fallback_cb' => false, 'walker' => new Tez_Desktop_Nav_Walker()));
                } else {
                    echo '<ul class="tez-nav-menu"><li class="tez-menu-item"><a href="' . esc_url($home) . '" class="tez-nav-link"><span>خانه</span></a></li></ul>';
                }
                ?>
            </nav>

            <div class="tez-header-actions">
                <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-action-btn tez-phone-btn" title="تماس"><i class="fa-solid fa-phone"></i></a>
                <button type="button" class="tez-action-btn tez-search-btn" id="tez-search-toggle" title="جستجو"><i class="fa-solid fa-magnifying-glass"></i></button>
                <a href="<?php echo esc_url($inquiry); ?>" class="tez-btn tez-btn-primary tez-cta-btn">ثبت سفارش</a>
            </div>

            <button type="button" class="tez-mobile-toggle" id="tez-mobile-toggle" aria-label="منو">
                <span class="tez-hamburger"><span class="tez-hamburger-line"></span><span class="tez-hamburger-line"></span><span class="tez-hamburger-line"></span></span>
            </button>
        </div>
    </div>
</header>

<div class="tez-mobile-overlay" id="tez-mobile-overlay"></div>

<nav class="tez-mobile-menu" id="tez-mobile-menu" role="dialog" aria-hidden="true">
    <div class="tez-mobile-header">
        <a href="<?php echo esc_url($home); ?>" class="tez-mobile-logo-link">
            <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($name); ?>" class="tez-logo" width="160" height="44">
        </a>
        <button type="button" class="tez-mobile-close" id="tez-mobile-close" aria-label="بستن"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="tez-mobile-body">
        <ul class="tez-mobile-nav">
            <?php
            if (has_nav_menu('tez_mobile')) {
                wp_nav_menu(array('theme_location' => 'tez_mobile', 'container' => false, 'items_wrap' => '%3$s', 'fallback_cb' => false, 'walker' => new Tez_Mobile_Nav_Walker()));
            } elseif (has_nav_menu('tez_primary')) {
                wp_nav_menu(array('theme_location' => 'tez_primary', 'container' => false, 'items_wrap' => '%3$s', 'fallback_cb' => false, 'walker' => new Tez_Mobile_Nav_Walker()));
            } elseif (has_nav_menu('primary')) {
                wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'items_wrap' => '%3$s', 'fallback_cb' => false, 'walker' => new Tez_Mobile_Nav_Walker()));
            } else {
                echo '<li class="tez-mobile-menu-item"><a href="' . esc_url($home) . '" class="tez-mobile-link">خانه</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="tez-mobile-footer">
        <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-mobile-phone"><i class="fa-solid fa-phone"></i><span><?php echo esc_html($phone_display); ?></span></a>
        <a href="<?php echo esc_url($inquiry); ?>" class="tez-btn tez-btn-primary tez-btn-block"><i class="fa-solid fa-pen-to-square"></i> ثبت سفارش</a>
    </div>
</nav>

<div class="tez-search-overlay" id="tez-search-overlay" role="dialog" aria-hidden="true">
    <div class="tez-search-container">
        <button type="button" class="tez-search-close" id="tez-search-close" aria-label="بستن"><i class="fa-solid fa-xmark"></i></button>
        <form class="tez-search-form" role="search" method="get" action="<?php echo esc_url($home); ?>">
            <div class="tez-search-input-wrap">
                <input type="search" class="tez-search-input" name="s" placeholder="جستجو در سایت...">
                <button type="submit" class="tez-search-submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>
</div>

<main id="tez-main-content" class="tez-main-content">
<?php
    }
}

// =============================================
// CLOSE MAIN TAG
// =============================================
if (!function_exists('tez_output_close_main')) {
    function tez_output_close_main() {
        static $closed = false;
        if ($closed) return;
        $closed = true;
        echo '</main>';
    }
    add_action('wp_footer', 'tez_output_close_main', 5);
}
