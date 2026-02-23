<?php
/**
 * Miscellaneous Tweaks
 * - Remove email field from comments
 * - Remove page titles & breadcrumbs on custom templates
 * - Disable Jannah header/footer on full-width templates
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

// =============================================
// REMOVE EMAIL FIELD FROM COMMENTS
// =============================================
add_filter('comment_form_default_fields', 'tez_remove_comment_email');
function tez_remove_comment_email($fields) {
    if (isset($fields['email'])) {
        unset($fields['email']);
    }
    return $fields;
}

// =============================================
// REMOVE PAGE TITLES ON CUSTOM TEMPLATES
// =============================================
add_filter('the_title', 'tez_hide_page_title_on_templates', 10, 2);
function tez_hide_page_title_on_templates($title, $id = null) {
    if (!is_admin() && is_page() && in_the_loop()) {
        $template = get_page_template_slug($id);
        if ($template && strpos($template, 'templates/') === 0) {
            return ''; // Hide title, the template handles its own header
        }
    }
    return $title;
}
