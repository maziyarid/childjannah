<?php
/**
 * Header Template Override
 * Fixes double-menu issue by providing complete HTML structure
 * 
 * @package JannahChild
 * @version 3.1.0
 * @since Phase 1.1
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
    <div class="tez-header-container">
        <div class="tez-header-inner">
            
            <!-- Logo -->
            <div class="tez-header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="tez-logo-link" rel="home" aria-label="<?php esc_attr(get_bloginfo('name')); ?>">
                    <?php if (defined('TEZ_LOGO')): ?>
                        <img src="<?php echo esc_url(home_url(TEZ_LOGO)); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="tez-logo">
                    <?php else: ?>
                        <span class="tez-site-name"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="tez-header-nav" id="tez-header-nav" role="navigation" aria-label="منوی اصلی">
                <?php
                // Try tez_primary menu first, fallback to primary
                $menu_args = array(
                    'theme_location'  => has_nav_menu('tez_primary') ? 'tez_primary' : 'primary',
                    'container'       => false,
                    'menu_class'      => 'tez-nav-menu',
                    'fallback_cb'     => false,
                    'depth'           => 2,
                    'walker'          => class_exists('Tez_Desktop_Nav_Walker') ? new Tez_Desktop_Nav_Walker() : null,
                );
                
                if (has_nav_menu('tez_primary') || has_nav_menu('primary')) {
                    wp_nav_menu($menu_args);
                } else {
                    // Fallback menu if no menu assigned
                    echo '<ul class="tez-nav-menu">';
                    echo '<li class="tez-menu-item"><a href="' . esc_url(home_url('/')) . '" class="tez-nav-link">خانه</a></li>';
                    echo '<li class="tez-menu-item"><a href="' . esc_url(home_url('/services/')) . '" class="tez-nav-link">خدمات</a></li>';
                    echo '<li class="tez-menu-item"><a href="' . esc_url(home_url('/about/')) . '" class="tez-nav-link">درباره ما</a></li>';
                    echo '<li class="tez-menu-item"><a href="' . esc_url(home_url('/contact/')) . '" class="tez-nav-link">تماس</a></li>';
                    echo '</ul>';
                }
                ?>
            </nav>
            
            <!-- Header Actions -->
            <div class="tez-header-actions">
                
                <!-- Search Button -->
                <button type="button" id="tez-search-toggle" class="tez-header-btn tez-search-btn" aria-label="جستجو" aria-expanded="false" aria-controls="tez-search-overlay">
                    <i class="fa-solid fa-search" aria-hidden="true"></i>
                </button>
                
                <!-- Theme Mode Switcher -->
                <div class="tez-theme-switcher" role="group" aria-label="تغییر حالت ظاهری">
                    <button type="button" class="tez-theme-btn tez-mode-btn" data-theme="light" aria-label="حالت روشن" title="حالت روشن">
                        <i class="fa-solid fa-sun" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="tez-theme-btn tez-mode-btn" data-theme="dark" aria-label="حالت تاریک" title="حالت تاریک">
                        <i class="fa-solid fa-moon" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="tez-theme-btn tez-mode-btn" data-theme="sepia" aria-label="حالت سپیا" title="حالت سپیا">
                        <i class="fa-solid fa-book" aria-hidden="true"></i>
                    </button>
                </div>
                
                <!-- Accessibility Toolbar -->
                <div class="tez-a11y-toolbar" role="group" aria-label="ابزارهای دسترسی">
                    <button type="button" class="tez-a11y-btn" data-action="font-size-increase" aria-label="افزایش اندازه فونت" title="افزایش اندازه فونت">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="tez-a11y-btn" data-action="font-size-decrease" aria-label="کاهش اندازه فونت" title="کاهش اندازه فونت">
                        <i class="fa-solid fa-minus" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="tez-a11y-btn" data-action="contrast-toggle" aria-label="تغییر کنتراست" title="تغییر کنتراست">
                        <i class="fa-solid fa-circle-half-stroke" aria-hidden="true"></i>
                    </button>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button type="button" id="tez-mobile-toggle" class="tez-mobile-toggle" aria-label="منوی موبایل" aria-expanded="false" aria-controls="tez-mobile-menu">
                    <span class="tez-hamburger">
                        <span class="tez-hamburger-line"></span>
                        <span class="tez-hamburger-line"></span>
                        <span class="tez-hamburger-line"></span>
                    </span>
                    <span class="tez-mobile-toggle-text">منو</span>
                </button>
                
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="tez-mobile-menu-overlay" id="tez-mobile-overlay" aria-hidden="true"></div>
<div class="tez-mobile-menu-inner" id="tez-mobile-menu" role="dialog" aria-label="منوی موبایل" aria-hidden="true">
    <div class="tez-mobile-menu-header">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="tez-mobile-logo-link" rel="home">
            <?php if (defined('TEZ_LOGO')): ?>
                <img src="<?php echo esc_url(home_url(TEZ_LOGO)); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="tez-logo">
            <?php else: ?>
                <span class="tez-site-name"><?php bloginfo('name'); ?></span>
            <?php endif; ?>
        </a>
        <button type="button" id="tez-mobile-close" class="tez-mobile-close" aria-label="بستن منو">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </button>
    </div>
    
    <nav class="tez-mobile-menu-content" role="navigation" aria-label="منوی موبایل">
        <?php
        // Try tez_mobile first, fallback to tez_primary, then primary
        $mobile_menu_location = 'primary';
        if (has_nav_menu('tez_mobile')) {
            $mobile_menu_location = 'tez_mobile';
        } elseif (has_nav_menu('tez_primary')) {
            $mobile_menu_location = 'tez_primary';
        }
        
        $mobile_menu_args = array(
            'theme_location'  => $mobile_menu_location,
            'container'       => false,
            'menu_class'      => 'tez-mobile-menu-list',
            'fallback_cb'     => false,
            'depth'           => 2,
            'walker'          => class_exists('Tez_Mobile_Nav_Walker') ? new Tez_Mobile_Nav_Walker() : null,
        );
        
        if (has_nav_menu('tez_mobile') || has_nav_menu('tez_primary') || has_nav_menu('primary')) {
            wp_nav_menu($mobile_menu_args);
        } else {
            // Fallback menu
            echo '<ul class="tez-mobile-menu-list">';
            echo '<li class="tez-mobile-menu-item"><a href="' . esc_url(home_url('/')) . '" class="tez-mobile-link">خانه</a></li>';
            echo '<li class="tez-mobile-menu-item"><a href="' . esc_url(home_url('/services/')) . '" class="tez-mobile-link">خدمات</a></li>';
            echo '<li class="tez-mobile-menu-item"><a href="' . esc_url(home_url('/about/')) . '" class="tez-mobile-link">درباره ما</a></li>';
            echo '<li class="tez-mobile-menu-item"><a href="' . esc_url(home_url('/contact/')) . '" class="tez-mobile-link">تماس</a></li>';
            echo '</ul>';
        }
        ?>
    </nav>
    
    <?php if (defined('TEZ_PHONE') && defined('TEZ_PHONE_DISPLAY')): ?>
    <div class="tez-mobile-menu-contact">
        <a href="tel:<?php echo esc_attr(TEZ_PHONE); ?>" class="tez-mobile-contact-link">
            <i class="fa-solid fa-phone" aria-hidden="true"></i>
            <span><?php echo esc_html(TEZ_PHONE_DISPLAY); ?></span>
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- Search Overlay -->
<div class="tez-search-overlay" id="tez-search-overlay" role="dialog" aria-label="جستجو" aria-hidden="true">
    <div class="tez-search-overlay-inner">
        <button type="button" id="tez-search-close" class="tez-search-close" aria-label="بستن جستجو">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </button>
        
        <div class="tez-search-form-wrapper">
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
                    <i class="fa-solid fa-search" aria-hidden="true"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Main Content Area (opened, will be closed in footer.php) -->
<main id="tez-main-content" class="tez-main-content" role="main">
