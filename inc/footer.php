<?php
/**
 * Custom Footer & Floating Elements
 * Footer, Chaty widget, Scroll-to-top button
 *
 * @package JannahChild
 * @version 3.0.0
 */
if (!defined('ABSPATH')) exit;

add_action('wp_footer', 'tez_output_footer_html', 10);
function tez_output_footer_html() {
    $phone         = defined('TEZ_PHONE') ? TEZ_PHONE : '09331663849';
    $phone_display = defined('TEZ_PHONE_DISPLAY') ? TEZ_PHONE_DISPLAY : '\u06f0\u06f9\u06f3\u06f3\u06f1\u06f6\u06f6\u06f3\u06f8\u06f4\u06f9';
    $whatsapp      = defined('TEZ_WHATSAPP') ? TEZ_WHATSAPP : '09331663849';
    $telegram      = defined('TEZ_TELEGRAM') ? TEZ_TELEGRAM : 'Thesissupport';
    $email         = defined('TEZ_EMAIL') ? TEZ_EMAIL : 'teznevisancompany@gmail.com';
    $logo_white    = home_url('/wp-content/uploads/logo/white.svg');
    $home          = home_url('/');
    $sitename      = get_bloginfo('name');
    $year          = date_i18n('Y');

    echo '<footer class="tez-site-footer" role="contentinfo">';
    echo '<div class="tez-container">';
    echo '<div class="tez-footer-grid">';

    // Column 1: Logo + description + social
    echo '<div class="tez-footer-col">';
    echo '<div class="tez-footer-logo"><img src="' . esc_url($logo_white) . '" alt="' . esc_attr($sitename) . '" class="tez-footer-logo-img" loading="lazy"></div>';
    echo '<p class="tez-footer-desc">';
    echo esc_html__('\u0645\u0648\u0633\u0633\u0647 \u062a\u0632 \u0646\u0648\u06cc\u0633\u0627\u0646 \u0628\u0627 \u0628\u06cc\u0634 \u0627\u0632 \u06cc\u06a9 \u062f\u0647\u0647 \u062a\u062c\u0631\u0628\u0647 \u0648 \u06f4\u06f5\u06f0+ \u0645\u062d\u0642\u0642 \u0645\u062a\u062e\u0635\u0635\u060c \u0622\u0645\u0627\u062f\u0647 \u0627\u0631\u0627\u0626\u0647 \u062e\u062f\u0645\u0627\u062a \u062a\u062e\u0635\u0635\u06cc \u0627\u0646\u062c\u0627\u0645 \u067e\u0631\u0648\u0698\u0647\u200c\u0647\u0627\u06cc \u062f\u0627\u0646\u0634\u062c\u0648\u06cc\u06cc \u062f\u0631 \u062a\u0645\u0627\u0645\u06cc \u0631\u0634\u062a\u0647\u200c\u0647\u0627 \u0627\u0633\u062a.', 'jannah-child');
    echo '</p>';
    echo '<div class="tez-footer-social">';
    echo '<a href="https://t.me/' . esc_attr($telegram) . '" target="_blank" rel="noopener noreferrer" aria-label="\u062a\u0644\u06af\u0631\u0627\u0645"><i class="fa-brands fa-telegram"></i></a>';
    echo '<a href="https://wa.me/' . esc_attr($whatsapp) . '" target="_blank" rel="noopener noreferrer" aria-label="\u0648\u0627\u062a\u0633\u0627\u067e"><i class="fa-brands fa-whatsapp"></i></a>';
    echo '<a href="#" aria-label="\u0627\u06cc\u0646\u0633\u062a\u0627\u06af\u0631\u0627\u0645"><i class="fa-brands fa-instagram"></i></a>';
    echo '<a href="#" aria-label="\u0644\u06cc\u0646\u06a9\u062f\u06cc\u0646"><i class="fa-brands fa-linkedin-in"></i></a>';
    echo '</div>';
    echo '</div>';

    // Column 2: Services menu
    echo '<div class="tez-footer-col">';
    echo '<h3 class="tez-footer-title">\u062e\u062f\u0645\u0627\u062a \u0645\u0627</h3>';
    if (has_nav_menu('tez_footer_1')) {
        wp_nav_menu(array('theme_location' => 'tez_footer_1', 'container' => false, 'menu_class' => 'tez-footer-menu', 'fallback_cb' => false));
    } else {
        echo '<ul class="tez-footer-menu">';
        echo '<li><a href="#">\u0627\u0646\u062c\u0627\u0645 \u067e\u0627\u06cc\u0627\u0646\u200c\u0646\u0627\u0645\u0647</a></li>';
        echo '<li><a href="#">\u0646\u0648\u0634\u062a\u0646 \u067e\u0631\u0648\u067e\u0648\u0632\u0627\u0644</a></li>';
        echo '<li><a href="#">\u0646\u06af\u0627\u0631\u0634 \u0645\u0642\u0627\u0644\u0647 \u0639\u0644\u0645\u06cc</a></li>';
        echo '<li><a href="#">\u062a\u062d\u0644\u06cc\u0644 \u0622\u0645\u0627\u0631\u06cc</a></li>';
        echo '<li><a href="#">\u0634\u0628\u06cc\u0647\u200c\u0633\u0627\u0632\u06cc \u0646\u0631\u0645\u200c\u0627\u0641\u0632\u0627\u0631\u06cc</a></li>';
        echo '<li><a href="#">\u0628\u06cc\u0632\u06cc\u0646\u0633 \u067e\u0644\u0646</a></li>';
        echo '</ul>';
    }
    echo '</div>';

    // Column 3: Useful links
    echo '<div class="tez-footer-col">';
    echo '<h3 class="tez-footer-title">\u0644\u06cc\u0646\u06a9\u200c\u0647\u0627\u06cc \u0645\u0641\u06cc\u062f</h3>';
    if (has_nav_menu('tez_footer_2')) {
        wp_nav_menu(array('theme_location' => 'tez_footer_2', 'container' => false, 'menu_class' => 'tez-footer-menu', 'fallback_cb' => false));
    } else {
        echo '<ul class="tez-footer-menu">';
        echo '<li><a href="#">\u062f\u0631\u0628\u0627\u0631\u0647 \u0645\u0627</a></li>';
        echo '<li><a href="#">\u0648\u0628\u0644\u0627\u06af</a></li>';
        echo '<li><a href="#">\u062a\u0639\u0631\u0641\u0647 \u062e\u062f\u0645\u0627\u062a</a></li>';
        echo '<li><a href="#">\u0646\u0645\u0648\u0646\u0647 \u06a9\u0627\u0631\u0647\u0627</a></li>';
        echo '<li><a href="#">\u0633\u0648\u0627\u0644\u0627\u062a \u0645\u062a\u062f\u0627\u0648\u0644</a></li>';
        echo '<li><a href="#">\u062a\u0645\u0627\u0633 \u0628\u0627 \u0645\u0627</a></li>';
        echo '</ul>';
    }
    echo '</div>';

    // Column 4: Contact info
    echo '<div class="tez-footer-col">';
    echo '<h3 class="tez-footer-title">\u0627\u0637\u0644\u0627\u0639\u0627\u062a \u062a\u0645\u0627\u0633</h3>';
    echo '<ul class="tez-contact-list">';
    echo '<li><i class="fa-solid fa-phone"></i><a href="tel:' . esc_attr($phone) . '">' . esc_html($phone_display) . '</a></li>';
    echo '<li><i class="fa-solid fa-envelope"></i><a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></li>';
    echo '<li><i class="fa-solid fa-location-dot"></i><span>\u062a\u0647\u0631\u0627\u0646\u060c \u062e\u06cc\u0627\u0628\u0627\u0646 \u062c\u0645\u0627\u0644\u0632\u0627\u062f\u0647 \u0634\u0645\u0627\u0644\u06cc</span></li>';
    echo '<li><i class="fa-solid fa-clock"></i><span>\u067e\u0627\u0633\u062e\u06af\u0648\u06cc\u06cc: \u06f9 \u0635\u0628\u062d \u062a\u0627 \u06f6 \u0639\u0635\u0631</span></li>';
    echo '</ul>';
    echo '</div>';

    echo '</div>'; // .tez-footer-grid

    // Footer bottom
    echo '<div class="tez-footer-bottom">';
    echo '<p class="tez-copyright">&copy; ' . esc_html($year) . ' \u0645\u0648\u0633\u0633\u0647 \u062a\u0632 \u0646\u0648\u06cc\u0633\u0627\u0646. \u062a\u0645\u0627\u0645\u06cc \u062d\u0642\u0648\u0642 \u0645\u062d\u0641\u0648\u0638 \u0627\u0633\u062a.</p>';
    echo '<div class="tez-footer-links">';
    echo '<a href="#">\u0634\u0631\u0627\u06cc\u0637 \u0627\u0633\u062a\u0641\u0627\u062f\u0647</a><span>|</span>';
    echo '<a href="#">\u062d\u0631\u06cc\u0645 \u062e\u0635\u0648\u0635\u06cc</a><span>|</span>';
    echo '<a href="' . esc_url(home_url('/sitemap')) . '">\u0646\u0642\u0634\u0647 \u0633\u0627\u06cc\u062a</a>';
    echo '</div>';
    echo '</div>';

    echo '</div>'; // .tez-container
    echo '</footer>';

    // Chaty Widget
    echo '<div class="tez-chaty" id="tez-chaty">';
    echo '<button type="button" class="tez-chaty-toggle" id="tez-chaty-toggle" aria-label="\u0646\u0645\u0627\u06cc\u0634 \u0631\u0627\u0647\u200c\u0647\u0627\u06cc \u062a\u0645\u0627\u0633" aria-expanded="false" aria-controls="tez-chaty-channels">';
    echo '<span class="tez-chaty-icon"><i class="fa-solid fa-comments"></i></span>';
    echo '<span class="tez-chaty-close"><i class="fa-solid fa-xmark"></i></span>';
    echo '</button>';
    echo '<div class="tez-chaty-channels" id="tez-chaty-channels" aria-hidden="true">';
    echo '<a href="tel:' . esc_attr($phone) . '" class="tez-chaty-item tez-chaty-phone" aria-label="\u062a\u0645\u0627\u0633"><i class="fa-solid fa-phone"></i><span class="tez-chaty-tooltip">\u062a\u0645\u0627\u0633 \u0645\u0633\u062a\u0642\u06cc\u0645</span></a>';
    echo '<a href="sms:' . esc_attr($phone) . '" class="tez-chaty-item tez-chaty-sms" aria-label="\u067e\u06cc\u0627\u0645\u06a9"><i class="fa-solid fa-message"></i><span class="tez-chaty-tooltip">\u067e\u06cc\u0627\u0645\u06a9</span></a>';
    echo '<a href="https://wa.me/' . esc_attr($whatsapp) . '" class="tez-chaty-item tez-chaty-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="\u0648\u0627\u062a\u0633\u0627\u067e"><i class="fa-brands fa-whatsapp"></i><span class="tez-chaty-tooltip">\u0648\u0627\u062a\u0633\u0627\u067e</span></a>';
    echo '<a href="https://t.me/' . esc_attr($telegram) . '" class="tez-chaty-item tez-chaty-telegram" target="_blank" rel="noopener noreferrer" aria-label="\u062a\u0644\u06af\u0631\u0627\u0645"><i class="fa-brands fa-telegram"></i><span class="tez-chaty-tooltip">\u062a\u0644\u06af\u0631\u0627\u0645</span></a>';
    echo '<a href="mailto:' . esc_attr($email) . '" class="tez-chaty-item tez-chaty-email" aria-label="\u0627\u06cc\u0645\u06cc\u0644"><i class="fa-solid fa-envelope"></i><span class="tez-chaty-tooltip">\u0627\u06cc\u0645\u06cc\u0644</span></a>';
    echo '</div>';
    echo '</div>';

    // Scroll to top
    echo '<button type="button" class="tez-scroll-top" id="tez-scroll-top" aria-label="\u0628\u0627\u0632\u06af\u0634\u062a \u0628\u0647 \u0628\u0627\u0644\u0627"><i class="fa-solid fa-chevron-up"></i></button>';
}
