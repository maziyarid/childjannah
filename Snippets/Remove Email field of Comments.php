/**
 * Remove email field from WordPress comment form
 * Compatible with Jannah theme
 */
function remove_comment_email_field($fields) {
    // Remove the email field
    if (isset($fields['email'])) {
        unset($fields['email']);
    }
    return $fields;
}
add_filter('comment_form_default_fields', 'remove_comment_email_field');

/**
 * Make email field not required
 * This ensures WordPress doesn't validate email as required
 */
function disable_email_requirement($fields) {
    // Also ensure email is not required at the core level
    add_filter('pre_option_require_name_email', '__return_zero');
    return $fields;
}
add_filter('comment_form_default_fields', 'disable_email_requirement', 5);

/**
 * Additional filter for themes with custom comment implementations
 */
function remove_email_from_comment_form_fields($fields) {
    unset($fields['email']);
    return $fields;
}
add_filter('comment_form_fields', 'remove_email_from_comment_form_fields', 20);