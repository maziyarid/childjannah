<?php
/**
 * Template Name: Tez - Tag Hub
 * Description: Tag directory page with search, filtering, and recent posts per tag.
 *
 * @package JannahChild
 */

get_header();
while (have_posts()) : the_post();
    the_content();
endwhile;
get_footer();
