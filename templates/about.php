<?php
/**
 * Template Name: Tez - About Page
 * Description: Custom about page template with team, mission, and stats sections.
 *
 * @package JannahChild
 */

get_header();
// Template content will be injected via the_content filter
// or built using .tez-about-grid, .tez-stats-card, etc. CSS classes
while (have_posts()) : the_post();
    the_content();
endwhile;
get_footer();
