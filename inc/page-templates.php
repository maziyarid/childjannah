<?php
/**
 * Page Templates Registration
 * Registers 7 custom page templates and loads them from child theme.
 *
 * Templates:
 * 1. templates/homepage.php   - Full homepage (hero, stats, services, process, CTA, blog)
 * 2. templates/services.php   - Service page (hero, inquiry form, accordions, CTA)
 * 3. templates/inquiry.php    - Inquiry page (hero, form, sidebar)
 * 4. templates/about.php      - About page (hero + content, supports Page Builder)
 * 5. templates/contact.php    - Contact page (hero + content, supports Page Builder)
 * 6. templates/faq.php        - FAQ page (hero + content, supports Page Builder)
 * 7. templates/tag-hub.php    - Tag hub (hero + content, supports Page Builder)
 *
 * Note: Actual hero/content is built via the_content or Page Builder.
 * Title hiding is handled by inc/misc-tweaks.php (tez_hide_page_title_on_templates).
 *
 * @package JannahChild
 * @version 3.1.0
 */

if ( ! defined('ABSPATH') ) exit;

// =============================================
// REGISTER TEMPLATES WITH WORDPRESS
// =============================================
add_filter('theme_page_templates', 'tez_register_page_templates');
function tez_register_page_templates( $templates ) {
    $templates['templates/homepage.php']  = __('Tez - Homepage', 'jannah');
    $templates['templates/services.php']  = __('Tez - Service Page', 'jannah');
    $templates['templates/inquiry.php']   = __('Tez - Inquiry Page', 'jannah');
    $templates['templates/about.php']     = __('Tez - About Page', 'jannah');
    $templates['templates/contact.php']   = __('Tez - Contact Page', 'jannah');
    $templates['templates/faq.php']       = __('Tez - FAQ Page', 'jannah');
    $templates['templates/tag-hub.php']   = __('Tez - Tag Hub', 'jannah');
    return $templates;
}

// =============================================
// LOAD TEMPLATE FILE FROM CHILD THEME
// =============================================
add_filter('page_template', 'tez_load_page_template');
function tez_load_page_template( $template ) {
    $page_template = get_page_template_slug();
    if ( empty($page_template) ) return $template;

    $file = TEZ_CHILD_DIR . '/' . $page_template;
    if ( file_exists($file) ) {
        return $file;
    }

    return $template;
}
