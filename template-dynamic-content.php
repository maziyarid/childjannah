<?php
/**
 * Template Name: Dynamic Content (Classic Editor)
 * 
 * Use this template for pages where content is fully managed via Classic Editor.
 * Perfect for service pages, landing pages, about pages, etc.
 * 
 * HOW TO USE:
 * 1. Create a new page in WordPress
 * 2. Select "Dynamic Content (Classic Editor)" from Page Attributes > Template
 * 3. Use Classic Editor to add content with Jannah shortcodes
 * 4. Recommended shortcodes: [tie_slider], [tie_list], [column], [toggle], etc.
 * 
 * EXAMPLE CONTENT STRUCTURE:
 * 
 * [tie_full_width][/tie_full_width]
 * [column size="one_half"]
 *   Your content here
 * [/column]
 * [column size="one_half_last"]
 *   Your content here
 * [/column]
 * 
 * @package JannahChild
 * @version 3.2.0
 * @since Phase 2.0
 */

if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="tez-dynamic-page-wrapper">
    <?php
    while (have_posts()) :
        the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('tez-dynamic-content'); ?>>
            
            <?php if (has_post_thumbnail()): ?>
            <div class="tez-page-featured-image">
                <?php the_post_thumbnail('full'); ?>
            </div>
            <?php endif; ?>
            
            <div class="tez-page-content">
                <?php
                // Output the page title if not hidden
                if (!get_post_meta(get_the_ID(), 'tie_hide_title', true)):
                ?>
                <header class="entry-header tez-page-header">
                    <h1 class="entry-title tez-page-title"><?php the_title(); ?></h1>
                </header>
                <?php endif; ?>
                
                <div class="entry-content tez-editor-content">
                    <?php
                    // This is where your Classic Editor content renders
                    // All shortcodes, images, text, etc. you add in editor
                    the_content();
                    
                    wp_link_pages(array(
                        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__('صفحات:', 'jannah-child') . '</span>',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                        'pagelink'    => '<span class="screen-reader-text">' . esc_html__('صفحه', 'jannah-child') . ' </span>%',
                        'separator'   => '<span class="screen-reader-text">, </span>',
                    ));
                    ?>
                </div>
                
            </div>
        </article>
        
        <?php
        // If comments are open or there's at least one comment
        if (comments_open() || get_comments_number()):
            comments_template();
        endif;
        ?>
    <?php
    endwhile;
    ?>
</div>

<?php
get_footer();
