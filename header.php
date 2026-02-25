<?php
/**
 * Header Template - Phase 3.0 Fixes Applied
 *
 * Changes in Phase 3.0 (PR #6, 2026-02-25):
 * - Fixed menu location: 'primary' → 'tez_primary' (was silently not rendering)
 * - Added Tez_Desktop_Nav_Walker and Tez_Mobile_Nav_Walker to wp_nav_menu() calls
 *
 * @package JannahChild
 * @version 3.3.0
 * @since Phase 3.0 - Navigation + FA7 + Responsive fixes
 */
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="format-detection" content="telephone=no">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip Link for Accessibility -->
<a href="#tez-main-content" class="tez-skip-link">پرش به محتوا</a>

<!-- Header -->
<header class="tez-site-header" id="tez-site-header" role="banner">
    <div class="tez-container">
        <div class="tez-header-inner">

            <!-- Logo -->
            <div class="tez-header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>"
                   class="tez-logo-link"
                   rel="home"
                   aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
                    <?php if (defined('TEZ_LOGO')): ?>
                        <img src="<?php echo esc_url(home_url(TEZ_LOGO)); ?>"
                             alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                             class="tez-logo"
                             width="160" height="48">
                    <?php else: ?>
                        <span class="tez-site-name"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Desktop Navigation
                 FIX (PR #6): theme_location changed from 'primary' to 'tez_primary'
                 FIX (PR #6): Added Tez_Desktop_Nav_Walker for proper dropdown HTML -->
            <nav class="tez-header-nav" id="tez-header-nav" role="navigation" aria-label="منوی اصلی">
                <?php
                $menu_args = array(
                    'theme_location' => has_nav_menu('tez_primary') ? 'tez_primary' : '',
                    'container'      => false,
                    'menu_class'     => 'tez-nav-menu',
                    'fallback_cb'    => false,
                    'depth'          => 2,
                    'walker'         => new Tez_Desktop_Nav_Walker(),
                );

                if (has_nav_menu('tez_primary')) {
                    wp_nav_menu($menu_args);
                }
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="tez-header-actions">

                <!-- Search Button -->
                <button type="button"
                        id="tez-search-toggle"
                        class="tez-action-btn tez-search-btn"
                        aria-label="جستجو"
                        aria-expanded="false"
                        aria-controls="tez-search-overlay">
                    <i class="tez-icon fa-solid fa-search" aria-hidden="true"></i>
                </button>

                <!-- Mobile Menu Toggle -->
                <button type="button"
                        id="tez-mobile-toggle"
                        class="tez-mobile-toggle"
                        aria-label="منوی موبایل"
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
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="tez-mobile-menu-overlay" id="tez-mobile-overlay" aria-hidden="true"></div>

<!-- Mobile Menu
     FIX (PR #6): theme_location changed from 'primary' to 'tez_primary'
     FIX (PR #6): Added Tez_Mobile_Nav_Walker for accordion submenus -->
<div class="tez-mobile-menu" id="tez-mobile-menu" role="dialog" aria-label="منوی موبایل" aria-hidden="true">
    <div class="tez-mobile-header">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="tez-mobile-logo-link" rel="home">
            <?php if (defined('TEZ_LOGO')): ?>
                <img src="<?php echo esc_url(home_url(TEZ_LOGO)); ?>"
                     alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                     class="tez-logo"
                     width="120" height="36">
            <?php else: ?>
                <span class="tez-site-name"><?php bloginfo('name'); ?></span>
            <?php endif; ?>
        </a>
        <button type="button"
                id="tez-mobile-close"
                class="tez-mobile-close"
                aria-label="بستن منو">
            <i class="tez-icon fa-solid fa-times" aria-hidden="true"></i>
        </button>
    </div>

    <div class="tez-mobile-body">
        <nav class="tez-mobile-nav" role="navigation" aria-label="منوی موبایل">
            <?php
            $mobile_menu_args = array(
                'theme_location' => 'tez_primary',
                'container'      => false,
                'menu_class'     => 'tez-mobile-menu-list',
                'fallback_cb'    => false,
                'depth'          => 2,
                'walker'         => new Tez_Mobile_Nav_Walker(),
            );

            if (has_nav_menu('tez_primary')) {
                wp_nav_menu($mobile_menu_args);
            }
            ?>
        </nav>
    </div>

    <?php if (defined('TEZ_PHONE') && defined('TEZ_PHONE_DISPLAY')): ?>
    <div class="tez-mobile-footer">
        <a href="tel:<?php echo esc_attr(TEZ_PHONE); ?>" class="tez-mobile-phone">
            <i class="tez-icon fa-solid fa-phone" aria-hidden="true"></i>
            <span><?php echo esc_html(TEZ_PHONE_DISPLAY); ?></span>
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- Search Overlay -->
<div class="tez-search-overlay" id="tez-search-overlay" role="dialog" aria-label="جستجو" aria-hidden="true">
    <div class="tez-search-container">
        <button type="button"
                id="tez-search-close"
                class="tez-search-close"
                aria-label="بستن جستجو">
            <i class="tez-icon fa-solid fa-times" aria-hidden="true"></i>
        </button>
        <div class="tez-search-input-wrap">
            <form role="search" method="get" class="tez-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <label for="tez-search-input" class="screen-reader-text">جستجو</label>
                <input type="search"
                       id="tez-search-input"
                       class="tez-search-input"
                       placeholder="چه چیزی می‌خواهید پیدا کنید؟"
                       value="<?php echo esc_attr(get_search_query()); ?>"
                       name="s"
                       autocomplete="off"
                       required>
                <button type="submit" class="tez-search-submit" aria-label="جستجو">
                    <i class="tez-icon fa-solid fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Floating Theme Switcher -->
<div class="tez-theme-buttons" role="group" aria-label="تغییر حالت ظاهری">
    <button type="button" class="tez-mode-btn" data-theme="light" aria-label="حالت روشن" title="حالت روشن">
        <i class="tez-icon fa-solid fa-sun" aria-hidden="true"></i>
    </button>
    <button type="button" class="tez-mode-btn" data-theme="dark" aria-label="حالت تاریک" title="حالت تاریک">
        <i class="tez-icon fa-solid fa-moon" aria-hidden="true"></i>
    </button>
    <button type="button" class="tez-mode-btn" data-theme="sepia" aria-label="حالت سپیا" title="حالت سپیا">
        <i class="tez-icon fa-solid fa-book" aria-hidden="true"></i>
    </button>
</div>

<!-- Floating Accessibility Toolbar -->
<div class="tez-a11y-toolbar" role="group" aria-label="ابزارهای دسترسی">
    <button type="button" class="tez-a11y-btn" data-action="font-size-increase" aria-label="افزایش اندازه فونت" title="افزایش اندازه فونت">
        <i class="tez-icon fa-solid fa-plus" aria-hidden="true"></i>
    </button>
    <button type="button" class="tez-a11y-btn" data-action="font-size-decrease" aria-label="کاهش اندازه فونت" title="کاهش اندازه فونت">
        <i class="tez-icon fa-solid fa-minus" aria-hidden="true"></i>
    </button>
    <button type="button" class="tez-a11y-btn" data-action="contrast-toggle" aria-label="تغییر کنتراست" title="تغییر کنتراست">
        <i class="tez-icon fa-solid fa-circle-half-stroke" aria-hidden="true"></i>
    </button>
</div>

<!-- Main Content Area -->
<main id="tez-main-content" class="tez-main-content" role="main">
