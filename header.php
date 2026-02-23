<?php
/**
 * Header Template - Jannah Child Theme: Teznevisan
 * Overrides parent theme header.php to provide single, clean header output.
 * Fixes double top menu bug by replacing hook-based header injection.
 *
 * @package JannahChild
 * @version 3.1.0
 */

if ( ! defined('ABSPATH') ) exit;

// Constants with safe fallbacks
$_logo          = defined('TEZ_LOGO')          ? home_url(TEZ_LOGO)         : home_url('/wp-content/uploads/logo/teznevisan.svg');
$_logo_alt      = get_bloginfo('name');
$_home          = home_url('/');
$_phone         = defined('TEZ_PHONE')         ? TEZ_PHONE                  : '09331663849';
$_phone_display = defined('TEZ_PHONE_DISPLAY') ? TEZ_PHONE_DISPLAY          : '۰۹۳۳۱۶۶۳۸۴۹';
$_inquiry       = home_url('/inquiry');
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#tez-main-content" class="tez-skip-link">رفتن به محتوای اصلی</a>

<div class="tez-theme-buttons" id="tez-theme-buttons" role="toolbar" aria-label="انتخاب حالت نمایش">
    <button type="button" class="tez-mode-btn active" data-theme="light" title="حالت روشن" aria-pressed="true"><i class="fa-solid fa-sun" aria-hidden="true"></i></button>
    <button type="button" class="tez-mode-btn" data-theme="dark" title="حالت تاریک" aria-pressed="false"><i class="fa-solid fa-moon" aria-hidden="true"></i></button>
    <button type="button" class="tez-mode-btn" data-theme="sepia" title="حالت کتاب" aria-pressed="false"><i class="fa-solid fa-book-open" aria-hidden="true"></i></button>
</div>

<div class="tez-a11y-toolbar" id="tez-a11y-toolbar" role="toolbar" aria-label="ابزارهای دسترسی‌پذیری">
    <button type="button" class="tez-a11y-btn" data-action="increase-font" aria-label="افزایش اندازه متن"><i class="fa-solid fa-plus" aria-hidden="true"></i></button>
    <button type="button" class="tez-a11y-btn" data-action="decrease-font" aria-label="کاهش اندازه متن"><i class="fa-solid fa-minus" aria-hidden="true"></i></button>
    <button type="button" class="tez-a11y-btn" data-action="high-contrast" aria-label="کنتراست بالا"><i class="fa-solid fa-circle-half-stroke" aria-hidden="true"></i></button>
    <button type="button" class="tez-a11y-btn" data-action="reset" aria-label="بازنشانی"><i class="fa-solid fa-rotate-right" aria-hidden="true"></i></button>
</div>

<header id="tez-masthead" class="tez-site-header" role="banner">
    <div class="tez-container">
        <div class="tez-header-inner">

            <div class="tez-site-branding">
                <a href="<?php echo esc_url($_home); ?>" class="tez-logo-link" rel="home" aria-label="<?php echo esc_attr($_logo_alt); ?>">
                    <img src="<?php echo esc_url($_logo); ?>"
                         alt="<?php echo esc_attr($_logo_alt); ?>"
                         class="tez-logo"
                         width="220" height="60"
                         loading="eager">
                </a>
            </div>

            <nav class="tez-main-nav" id="tez-main-nav" role="navigation" aria-label="منوی اصلی">
                <?php
                $walker_args = array(
                    'container'   => false,
                    'menu_class'  => 'tez-nav-menu',
                    'fallback_cb' => false,
                );
                if ( class_exists('Tez_Desktop_Nav_Walker') ) {
                    $walker_args['walker'] = new Tez_Desktop_Nav_Walker();
                }
                if ( has_nav_menu('tez_primary') ) {
                    wp_nav_menu( array_merge( $walker_args, array('theme_location' => 'tez_primary') ) );
                } elseif ( has_nav_menu('primary') ) {
                    wp_nav_menu( array_merge( $walker_args, array('theme_location' => 'primary') ) );
                } else {
                    echo '<ul class="tez-nav-menu"><li class="tez-menu-item"><a href="' . esc_url($_home) . '" class="tez-nav-link"><span>خانه</span></a></li></ul>';
                }
                ?>
            </nav>

            <div class="tez-header-actions">
                <a href="tel:<?php echo esc_attr($_phone); ?>"
                   class="tez-action-btn tez-phone-btn"
                   aria-label="تماس با ما: <?php echo esc_attr($_phone_display); ?>">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                </a>
                <button type="button"
                        class="tez-action-btn tez-search-btn"
                        id="tez-search-toggle"
                        aria-label="باز کردن جستجو"
                        aria-expanded="false"
                        aria-controls="tez-search-overlay">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                </button>
                <a href="<?php echo esc_url($_inquiry); ?>" class="tez-btn tez-btn-primary tez-cta-btn">
                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> ثبت سفارش
                </a>
            </div>

            <button type="button"
                    class="tez-mobile-toggle"
                    id="tez-mobile-toggle"
                    aria-label="باز کردن منو"
                    aria-expanded="false"
                    aria-controls="tez-mobile-menu">
                <span class="tez-hamburger" aria-hidden="true">
                    <span class="tez-hamburger-line"></span>
                    <span class="tez-hamburger-line"></span>
                    <span class="tez-hamburger-line"></span>
                </span>
            </button>

        </div>
    </div>
</header>

<div class="tez-mobile-overlay" id="tez-mobile-overlay" aria-hidden="true"></div>

<nav class="tez-mobile-menu"
     id="tez-mobile-menu"
     role="dialog"
     aria-modal="true"
     aria-label="منوی موبایل"
     aria-hidden="true">
    <div class="tez-mobile-header">
        <a href="<?php echo esc_url($_home); ?>" class="tez-mobile-logo-link">
            <img src="<?php echo esc_url($_logo); ?>"
                 alt="<?php echo esc_attr($_logo_alt); ?>"
                 class="tez-logo" width="160" height="44" loading="lazy">
        </a>
        <button type="button" class="tez-mobile-close" id="tez-mobile-close" aria-label="بستن منو">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>
    <div class="tez-mobile-body">
        <ul class="tez-mobile-nav" role="list">
            <?php
            $m_args = array(
                'container'   => false,
                'items_wrap'  => '%3$s',
                'fallback_cb' => false,
            );
            if ( class_exists('Tez_Mobile_Nav_Walker') ) {
                $m_args['walker'] = new Tez_Mobile_Nav_Walker();
            }
            if ( has_nav_menu('tez_mobile') ) {
                wp_nav_menu( array_merge( $m_args, array('theme_location' => 'tez_mobile') ) );
            } elseif ( has_nav_menu('tez_primary') ) {
                wp_nav_menu( array_merge( $m_args, array('theme_location' => 'tez_primary') ) );
            } elseif ( has_nav_menu('primary') ) {
                wp_nav_menu( array_merge( $m_args, array('theme_location' => 'primary') ) );
            } else {
                echo '<li class="tez-mobile-menu-item"><a href="' . esc_url($_home) . '" class="tez-mobile-link">خانه</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="tez-mobile-footer">
        <a href="tel:<?php echo esc_attr($_phone); ?>" class="tez-mobile-phone">
            <i class="fa-solid fa-phone" aria-hidden="true"></i>
            <span><?php echo esc_html($_phone_display); ?></span>
        </a>
        <a href="<?php echo esc_url($_inquiry); ?>" class="tez-btn tez-btn-primary tez-btn-block">
            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> ثبت سفارش
        </a>
    </div>
</nav>

<div class="tez-search-overlay"
     id="tez-search-overlay"
     role="dialog"
     aria-modal="true"
     aria-label="جستجو"
     aria-hidden="true">
    <div class="tez-search-container">
        <button type="button" class="tez-search-close" id="tez-search-close" aria-label="بستن جستجو">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
        <form class="tez-search-form" role="search" method="get" action="<?php echo esc_url($_home); ?>">
            <div class="tez-search-input-wrap">
                <label for="tez-search-q" class="screen-reader-text">جستجو در سایت</label>
                <input type="search"
                       id="tez-search-q"
                       class="tez-search-input"
                       name="s"
                       placeholder="جستجو در سایت..."
                       autocomplete="off">
                <button type="submit" class="tez-search-submit" aria-label="جستجو">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<main id="tez-main-content" class="tez-main-content" tabindex="-1">
