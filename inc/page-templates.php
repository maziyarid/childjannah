<?php
/**
 * Page Templates Registration
 * Registers custom page templates: About, Contact, FAQ, Service, Homepage, Inquiry, Tag Hub
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

/**
 * Register custom page templates with WordPress
 */
add_filter('theme_page_templates', 'tez_register_page_templates');
function tez_register_page_templates($templates) {
    $templates['templates/about.php']    = 'Tez - About Page';
    $templates['templates/contact.php']  = 'Tez - Contact Page';
    $templates['templates/faq.php']      = 'Tez - FAQ Page';
    $templates['templates/services.php'] = 'Tez - Service Page';
    $templates['templates/homepage.php'] = 'Tez - Homepage';
    $templates['templates/inquiry.php']  = 'Tez - Inquiry Page';
    $templates['templates/tag-hub.php']  = 'Tez - Tag Hub';
    return $templates;
}

/**
 * Load the actual template file from child theme
 */
add_filter('page_template', 'tez_load_page_template');
function tez_load_page_template($template) {
    $page_template = get_page_template_slug();
    if (!$page_template) return $template;

    $file = TEZ_CHILD_DIR . '/' . $page_template;
    if (file_exists($file)) {
        return $file;
    }

    return $template;
}
