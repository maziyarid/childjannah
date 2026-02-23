<?php
/**
 * Template Name: Tez - FAQ Page
 * Description: FAQ page with accordion, categories, and Schema.org markup.
 *
 * @package JannahChild
 */

get_header();
while (have_posts()) : the_post();
    the_content();
endwhile;
get_footer();
