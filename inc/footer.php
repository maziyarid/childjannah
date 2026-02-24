<?php
/**
 * Footer Module - Utilities Only
 * Actual footer HTML lives in /footer.php template override.
 *
 * @package JannahChild
 * @version 3.1.0
 */
if ( ! defined('ABSPATH') ) exit;

// =============================================
// FOOTER WIDGET AREAS (optional future use)
// =============================================
if ( ! function_exists('tez_register_footer_widgets') ) {
    function tez_register_footer_widgets() {
        register_sidebar(array(
            'name'          => 'فوتر – ستون ۱',
            'id'            => 'tez-footer-1',
            'before_widget' => '<div class="tez-footer-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="tez-footer-title">',
            'after_title'   => '</h3>',
        ));
        register_sidebar(array(
            'name'          => 'فوتر – ستون ۲',
            'id'            => 'tez-footer-2',
            'before_widget' => '<div class="tez-footer-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="tez-footer-title">',
            'after_title'   => '</h3>',
        ));
    }
    // add_action('widgets_init', 'tez_register_footer_widgets');
    // Commented out — not currently used; footer uses nav menus instead
}
