<?php
/**
 * Template Name: Tez - Contact Page
 * Description: Contact page with form, map, and contact info cards.
 *
 * @package JannahChild
 */

get_header();
while (have_posts()) : the_post();
    the_content();
endwhile;
get_footer();
