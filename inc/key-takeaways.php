<?php
/**
 * Key Takeaways Component
 * Only displays on single posts (NOT pages)
 * 
 * @package JannahChild
 * @version 3.2.0
 * @since Phase 2.0 - CodeRabbit FA scoping fix applied
 */

if (!defined('ABSPATH')) exit;

/**
 * Add Key Takeaways to post content
 * Only runs on is_single() posts
 */
function tez_add_key_takeaways($content) {
    // CRITICAL: Only run on single posts, NOT pages or other post types
    if (!is_single() || !is_singular('post')) {
        return $content;
    }
    
    // Skip if not in main query or not in the loop
    if (!in_the_loop() || !is_main_query()) {
        return $content;
    }
    
    $post_id = get_the_ID();
    $takeaways = get_post_meta($post_id, 'tez_key_takeaways', true);
    
    // If no takeaways set, return content unchanged
    if (empty($takeaways) || !is_array($takeaways)) {
        return $content;
    }
    
    // Build the takeaways HTML
    $style = get_post_meta($post_id, 'tez_takeaways_style', true) ?: 'modern';
    $list_type = get_post_meta($post_id, 'tez_takeaways_list_type', true) ?: 'bullet';
    $is_collapsible = get_post_meta($post_id, 'tez_takeaways_collapsible', true);
    $collapsed_default = get_post_meta($post_id, 'tez_takeaways_collapsed', true);
    
    $collapsible_class = $is_collapsible ? 'tez-collapsible' : '';
    $collapsed_class = ($is_collapsible && $collapsed_default) ? 'collapsed' : '';
    
    $reading_time = tez_calculate_reading_time(implode(' ', $takeaways));
    
    ob_start();
    ?>
    <div class="tez-key-takeaways tez-takeaways-<?php echo esc_attr($style); ?> tez-list-<?php echo esc_attr($list_type); ?> <?php echo esc_attr($collapsible_class . ' ' . $collapsed_class); ?>" role="region" aria-label="نکات کلیدی">
        
        <div class="tez-takeaways-header">
            <h2 class="tez-takeaways-heading">
                <i class="tez-icon fa-solid fa-lightbulb" aria-hidden="true"></i>
                <span>نکات کلیدی</span>
            </h2>
            
            <div class="tez-takeaways-controls">
                <span class="tez-reading-time" aria-label="زمان مطالعه">
                    <i class="tez-icon fa-solid fa-clock" aria-hidden="true"></i>
                    <span><?php echo esc_html($reading_time); ?> دقیقه</span>
                </span>
                
                <button type="button" class="tez-copy-btn" aria-label="کپی نکات کلیدی">
                    <i class="tez-icon fa-solid fa-copy" aria-hidden="true"></i>
                    <span class="tez-copy-text">کپی</span>
                </button>
                
                <?php if ($is_collapsible): ?>
                <button type="button" class="tez-toggle-btn" aria-label="نمایش/مخفی کردن نکات" aria-expanded="<?php echo $collapsed_default ? 'false' : 'true'; ?>">
                    <i class="tez-icon fa-solid fa-chevron-up" aria-hidden="true"></i>
                </button>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="tez-takeaways-content">
            <ul class="tez-takeaways-list">
                <?php foreach ($takeaways as $takeaway): ?>
                    <li class="tez-takeaway-item"><?php echo esc_html($takeaway); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        
    </div>
    <?php
    $takeaways_html = ob_get_clean();
    
    // Insert after first paragraph
    $paragraphs = explode('</p>', $content);
    if (count($paragraphs) > 1) {
        $paragraphs[0] .= '</p>' . $takeaways_html;
        $content = implode('</p>', $paragraphs);
    } else {
        $content = $takeaways_html . $content;
    }
    
    return $content;
}
add_filter('the_content', 'tez_add_key_takeaways', 20);

/**
 * Calculate reading time
 */
function tez_calculate_reading_time($text) {
    $word_count = str_word_count(strip_tags($text));
    $reading_time = ceil($word_count / 200);
    return max(1, $reading_time);
}
