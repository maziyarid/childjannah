<?php
/**
 * Key Takeaways Box
 * Adds a key takeaways section to posts.
 * Font Awesome is loaded globally by core-setup.php - no need to load here.
 *
 * @package JannahChild
 * @version 3.0.0
 */

/**
 * Key Takeaways/Summary Section with Schema.org Support
 * Customized for Teznevisan Theme
 * Version: 3.0.0
 * NEW: Collapsible, Reading Time, Copy-to-Clipboard, Print Mode, Numbered Lists
 */

if (!defined('ABSPATH')) exit;

// =============================================
// ADD META BOX
// Font Awesome already loaded by core-setup.php
// =============================================
add_action('add_meta_boxes', 'tez_add_key_takeaways_metabox');
function tez_add_key_takeaways_metabox() {
    $post_types = array('post', 'page');
    
    foreach ($post_types as $post_type) {
        add_meta_box(
            'tez_key_takeaways',
            '<i class="fas fa-list-check" style="color:#2563eb;margin-left:8px;"></i> Key Takeaways / خلاصه مطلب',
            'tez_key_takeaways_callback',
            $post_type,
            'normal',
            'high'
        );
    }
}

// =============================================
// META BOX CALLBACK (Enhanced)
// =============================================
function tez_key_takeaways_callback($post) {
    wp_nonce_field('tez_key_takeaways_nonce', 'tez_key_takeaways_nonce');
    
    $takeaways = get_post_meta($post->ID, '_tez_key_takeaways', true);
    $heading = get_post_meta($post->ID, '_tez_takeaways_heading', true);
    $position = get_post_meta($post->ID, '_tez_takeaways_position', true);
    $style = get_post_meta($post->ID, '_tez_takeaways_style', true);
    $enable_schema = get_post_meta($post->ID, '_tez_takeaways_schema', true);
    $icon = get_post_meta($post->ID, '_tez_takeaways_icon', true);
    $collapsible = get_post_meta($post->ID, '_tez_takeaways_collapsible', true);
    $list_type = get_post_meta($post->ID, '_tez_takeaways_list_type', true);
    $show_reading_time = get_post_meta($post->ID, '_tez_takeaways_reading_time', true);
    $show_copy_btn = get_post_meta($post->ID, '_tez_takeaways_copy_btn', true);
    
    // Default values
    if (empty($heading)) $heading = 'در این مقاله خواهید خواند:';
    if (empty($position)) $position = 'after_title';
    if (empty($style)) $style = 'modern';
    if (empty($enable_schema)) $enable_schema = 'yes';
    if (empty($icon)) $icon = 'bookmark';
    if (empty($collapsible)) $collapsible = 'no';
    if (empty($list_type)) $list_type = 'bullet';
    if (empty($show_reading_time)) $show_reading_time = 'yes';
    if (empty($show_copy_btn)) $show_copy_btn = 'yes';
    ?>
    
    <style>
        .tez-takeaways-meta-box {
            padding: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            font-family: 'Vazirmatn', system-ui, -apple-system, sans-serif;
        }
        .tez-takeaways-section {
            margin-bottom: 20px;
        }
        .tez-takeaways-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1e293b;
            font-size: 14px;
        }
        .tez-takeaways-label i {
            margin-left: 6px;
            color: #2563eb;
        }
        .tez-takeaways-label .tez-new-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 12px;
            margin-right: 6px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .tez-takeaways-input,
        .tez-takeaways-select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #ffffff;
            color: #1e293b;
            transition: all 0.2s ease;
        }
        .tez-takeaways-input:focus,
        .tez-takeaways-select:focus,
        .tez-takeaways-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .tez-takeaways-textarea {
            width: 100%;
            min-height: 180px;
            padding: 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            line-height: 1.7;
            background: #ffffff;
            color: #1e293b;
            resize: vertical;
            transition: all 0.2s ease;
        }
        .tez-takeaways-help {
            color: #64748b;
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .tez-takeaways-help code {
            background: #e2e8f0;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #2563eb;
        }
        .tez-takeaways-preview {
            margin-top: 24px;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .tez-takeaways-preview-title {
            font-weight: 600;
            margin-bottom: 15px;
            color: #2563eb;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        .tez-takeaways-cols {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .tez-takeaways-cols-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .tez-takeaways-cols-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        @media (max-width: 782px) {
            .tez-takeaways-cols,
            .tez-takeaways-cols-3,
            .tez-takeaways-cols-4 {
                grid-template-columns: 1fr;
            }
        }
        
        /* Preview Styles */
        #tez-takeaways-live-preview .tez-key-takeaways {
            margin: 0;
            font-size: 14px;
        }
        #tez-takeaways-live-preview .tez-takeaways-heading {
            font-size: 15px;
            margin-bottom: 12px;
        }
        #tez-takeaways-live-preview .tez-takeaway-item {
            padding: 10px 36px 10px 0;
            margin-bottom: 8px;
            font-size: 13px;
        }
        #tez-takeaways-live-preview .tez-takeaway-item:before {
            width: 22px;
            height: 22px;
            font-size: 10px;
            top: 10px;
        }
    </style>
    
    <div class="tez-takeaways-meta-box">
        <!-- Row 1: Heading & Position -->
        <div class="tez-takeaways-cols">
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_heading">
                    <i class="fas fa-heading"></i> عنوان بخش / Heading Text
                </label>
                <input type="text" 
                       id="tez_takeaways_heading" 
                       name="tez_takeaways_heading" 
                       class="tez-takeaways-input"
                       value="<?php echo esc_attr($heading); ?>" 
                       placeholder="در این مقاله خواهید خواند:" />
            </div>
            
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_position">
                    <i class="fas fa-map-pin"></i> موقعیت نمایش / Position
                </label>
                <select id="tez_takeaways_position" name="tez_takeaways_position" class="tez-takeaways-select">
                    <option value="after_title" <?php selected($position, 'after_title'); ?>>بعد از عنوان (After Title)</option>
                    <option value="before_content" <?php selected($position, 'before_content'); ?>>قبل از محتوا (Before Content)</option>
                    <option value="after_content" <?php selected($position, 'after_content'); ?>>بعد از محتوا (After Content)</option>
                    <option value="manual" <?php selected($position, 'manual'); ?>>دستی - شورت‌کد (Manual Shortcode)</option>
                </select>
            </div>
        </div>
        
        <!-- Row 2: Style, Icon & Schema -->
        <div class="tez-takeaways-cols-3">
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_style">
                    <i class="fas fa-palette"></i> استایل / Style
                </label>
                <select id="tez_takeaways_style" name="tez_takeaways_style" class="tez-takeaways-select">
                    <option value="modern" <?php selected($style, 'modern'); ?>>مدرن (Modern Card)</option>
                    <option value="minimal" <?php selected($style, 'minimal'); ?>>مینیمال (Minimal)</option>
                    <option value="gradient" <?php selected($style, 'gradient'); ?>>گرادیان (Gradient)</option>
                    <option value="outline" <?php selected($style, 'outline'); ?>>خطی (Outline)</option>
                    <option value="glass" <?php selected($style, 'glass'); ?>>شیشه‌ای (Glass)</option>
                </select>
            </div>
            
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_icon">
                    <i class="fas fa-icons"></i> آیکون / Icon
                </label>
                <select id="tez_takeaways_icon" name="tez_takeaways_icon" class="tez-takeaways-select">
                    <option value="bookmark" <?php selected($icon, 'bookmark'); ?>>📑 نشان (Bookmark)</option>
                    <option value="lightbulb" <?php selected($icon, 'lightbulb'); ?>>💡 لامپ (Lightbulb)</option>
                    <option value="star" <?php selected($icon, 'star'); ?>>⭐ ستاره (Star)</option>
                    <option value="check-circle" <?php selected($icon, 'check-circle'); ?>>✅ تیک (Check)</option>
                    <option value="list" <?php selected($icon, 'list'); ?>>📋 لیست (List)</option>
                    <option value="clipboard" <?php selected($icon, 'clipboard'); ?>>📌 یادداشت (Clipboard)</option>
                </select>
            </div>
            
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_schema">
                    <i class="fas fa-code"></i> اسکیما / Schema
                </label>
                <select id="tez_takeaways_schema" name="tez_takeaways_schema" class="tez-takeaways-select">
                    <option value="yes" <?php selected($enable_schema, 'yes'); ?>>فعال (Enable Schema.org)</option>
                    <option value="no" <?php selected($enable_schema, 'no'); ?>>غیرفعال (Disable)</option>
                </select>
            </div>
        </div>
        
        <!-- Row 3: NEW Advanced Features -->
        <div class="tez-takeaways-cols-4">
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_collapsible">
                    <i class="fas fa-compress-arrows-alt"></i> <span class="tez-new-badge">NEW</span> جمع شدنی / Collapsible
                </label>
                <select id="tez_takeaways_collapsible" name="tez_takeaways_collapsible" class="tez-takeaways-select">
                    <option value="no" <?php selected($collapsible, 'no'); ?>>خیر (No)</option>
                    <option value="yes" <?php selected($collapsible, 'yes'); ?>>بله (Yes)</option>
                </select>
            </div>
            
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_list_type">
                    <i class="fas fa-list-ol"></i> <span class="tez-new-badge">NEW</span> نوع لیست / List Type
                </label>
                <select id="tez_takeaways_list_type" name="tez_takeaways_list_type" class="tez-takeaways-select">
                    <option value="bullet" <?php selected($list_type, 'bullet'); ?>>غیرشماره‌ای (Bullets)</option>
                    <option value="numbered" <?php selected($list_type, 'numbered'); ?>>شماره‌ای (Numbered)</option>
                </select>
            </div>
            
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_reading_time">
                    <i class="fas fa-clock"></i> <span class="tez-new-badge">NEW</span> زمان خواندن / Reading Time
                </label>
                <select id="tez_takeaways_reading_time" name="tez_takeaways_reading_time" class="tez-takeaways-select">
                    <option value="yes" <?php selected($show_reading_time, 'yes'); ?>>نمایش (Show)</option>
                    <option value="no" <?php selected($show_reading_time, 'no'); ?>>مخفی (Hide)</option>
                </select>
            </div>
            
            <div class="tez-takeaways-section">
                <label class="tez-takeaways-label" for="tez_takeaways_copy_btn">
                    <i class="fas fa-copy"></i> <span class="tez-new-badge">NEW</span> کپی متن / Copy Button
                </label>
                <select id="tez_takeaways_copy_btn" name="tez_takeaways_copy_btn" class="tez-takeaways-select">
                    <option value="yes" <?php selected($show_copy_btn, 'yes'); ?>>نمایش (Show)</option>
                    <option value="no" <?php selected($show_copy_btn, 'no'); ?>>مخفی (Hide)</option>
                </select>
            </div>
        </div>
        
        <!-- Takeaways Textarea -->
        <div class="tez-takeaways-section">
            <label class="tez-takeaways-label" for="tez_key_takeaways">
                <i class="fas fa-check-circle"></i> نکات کلیدی / Key Takeaways
            </label>
            <textarea id="tez_key_takeaways" 
                      name="tez_key_takeaways" 
                      class="tez-takeaways-textarea"
                      placeholder="هر نکته را در یک خط جدید وارد کنید...
Enter each takeaway on a new line..."><?php echo esc_textarea($takeaways); ?></textarea>
            <p class="tez-takeaways-help">
                <i class="fas fa-info-circle"></i>
                هر نکته در یک خط جدید | شورت‌کد: <code>[key_takeaways]</code>
            </p>
        </div>
        
        <!-- Live Preview -->
        <div class="tez-takeaways-preview">
            <div class="tez-takeaways-preview-title">
                <i class="fas fa-eye"></i> پیش‌نمایش / Preview
            </div>
            <div id="tez-takeaways-live-preview"></div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var iconMap = {
            'bookmark': 'fa-bookmark',
            'lightbulb': 'fa-lightbulb',
            'star': 'fa-star',
            'check-circle': 'fa-circle-check',
            'list': 'fa-list-ul',
            'clipboard': 'fa-clipboard-list'
        };
        
        function updatePreview() {
            var takeaways = $('#tez_key_takeaways').val();
            var heading = $('#tez_takeaways_heading').val() || 'در این مقاله خواهید خواند:';
            var style = $('#tez_takeaways_style').val();
            var icon = $('#tez_takeaways_icon').val();
            
            if (takeaways.trim() === '') {
                $('#tez-takeaways-live-preview').html('<em style="color:#94a3b8;font-size:13px;">هنوز نکته‌ای اضافه نشده است...</em>');
                return;
            }
            
            var lines = takeaways.split('\n').filter(function(line) {
                return line.trim() !== '';
            });
            
            var iconClass = iconMap[icon] || 'fa-bookmark';
            var html = '<div class="tez-key-takeaways tez-takeaways-' + style + '">';
            html += '<h3 class="tez-takeaways-heading"><i class="fas ' + iconClass + '"></i> ' + heading + '</h3>';
            html += '<ul class="tez-takeaways-list">';
            lines.forEach(function(line) {
                html += '<li class="tez-takeaway-item">' + line.trim() + '</li>';
            });
            html += '</ul></div>';
            
            $('#tez-takeaways-live-preview').html(html);
        }
        
        $('#tez_key_takeaways, #tez_takeaways_heading, #tez_takeaways_style, #tez_takeaways_icon').on('input change keyup', updatePreview);
        updatePreview();
    });
    </script>
    <?php
}

// =============================================
// SAVE META BOX DATA (Enhanced)
// =============================================
add_action('save_post', 'tez_save_key_takeaways');
function tez_save_key_takeaways($post_id) {
    if (!isset($_POST['tez_key_takeaways_nonce'])) return;
    if (!wp_verify_nonce($_POST['tez_key_takeaways_nonce'], 'tez_key_takeaways_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    $fields = array(
        'tez_key_takeaways' => 'sanitize_textarea_field',
        'tez_takeaways_heading' => 'sanitize_text_field',
        'tez_takeaways_position' => 'sanitize_text_field',
        'tez_takeaways_style' => 'sanitize_text_field',
        'tez_takeaways_schema' => 'sanitize_text_field',
        'tez_takeaways_icon' => 'sanitize_text_field',
        'tez_takeaways_collapsible' => 'sanitize_text_field',
        'tez_takeaways_list_type' => 'sanitize_text_field',
        'tez_takeaways_reading_time' => 'sanitize_text_field',
        'tez_takeaways_copy_btn' => 'sanitize_text_field'
    );
    
    foreach ($fields as $field => $sanitize_func) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, $sanitize_func($_POST[$field]));
        }
    }
}

// =============================================
// NEW: CALCULATE READING TIME
// =============================================
function tez_calculate_reading_time($lines) {
    $total_words = 0;
    foreach ($lines as $line) {
        $total_words += str_word_count(strip_tags($line));
    }
    // Average reading speed: 200 words per minute
    $minutes = ceil($total_words / 200);
    return max(1, $minutes); // Minimum 1 minute
}

// =============================================
// SHORTCODE WITH SCHEMA.ORG SUPPORT (Enhanced)
// =============================================
add_shortcode('key_takeaways', 'tez_key_takeaways_shortcode');
function tez_key_takeaways_shortcode($atts) {
    global $post;
    
    if (!$post) return '';
    
    $atts = shortcode_atts(array(
        'heading' => '',
        'style' => '',
        'schema' => '',
        'icon' => '',
        'collapsible' => '',
        'list_type' => '',
        'reading_time' => '',
        'copy_btn' => ''
    ), $atts);
    
    $takeaways = get_post_meta($post->ID, '_tez_key_takeaways', true);
    $saved_heading = get_post_meta($post->ID, '_tez_takeaways_heading', true);
    $saved_style = get_post_meta($post->ID, '_tez_takeaways_style', true);
    $saved_schema = get_post_meta($post->ID, '_tez_takeaways_schema', true);
    $saved_icon = get_post_meta($post->ID, '_tez_takeaways_icon', true);
    $saved_collapsible = get_post_meta($post->ID, '_tez_takeaways_collapsible', true);
    $saved_list_type = get_post_meta($post->ID, '_tez_takeaways_list_type', true);
    $saved_reading_time = get_post_meta($post->ID, '_tez_takeaways_reading_time', true);
    $saved_copy_btn = get_post_meta($post->ID, '_tez_takeaways_copy_btn', true);
    
    // Use shortcode attributes if provided, otherwise use saved values
    $heading = !empty($atts['heading']) ? $atts['heading'] : (!empty($saved_heading) ? $saved_heading : 'در این مقاله خواهید خواند:');
    $style = !empty($atts['style']) ? $atts['style'] : (!empty($saved_style) ? $saved_style : 'modern');
    $enable_schema = !empty($atts['schema']) ? $atts['schema'] : (!empty($saved_schema) ? $saved_schema : 'yes');
    $icon = !empty($atts['icon']) ? $atts['icon'] : (!empty($saved_icon) ? $saved_icon : 'bookmark');
    $collapsible = !empty($atts['collapsible']) ? $atts['collapsible'] : (!empty($saved_collapsible) ? $saved_collapsible : 'no');
    $list_type = !empty($atts['list_type']) ? $atts['list_type'] : (!empty($saved_list_type) ? $saved_list_type : 'bullet');
    $show_reading_time = !empty($atts['reading_time']) ? $atts['reading_time'] : (!empty($saved_reading_time) ? $saved_reading_time : 'yes');
    $show_copy_btn = !empty($atts['copy_btn']) ? $atts['copy_btn'] : (!empty($saved_copy_btn) ? $saved_copy_btn : 'yes');
    
    if (empty($takeaways)) return '';
    
    $lines = array_filter(explode("\n", $takeaways), 'trim');
    if (empty($lines)) return '';
    
    // Calculate reading time
    $reading_minutes = tez_calculate_reading_time($lines);
    
    // Icon mapping
    $icon_map = array(
        'bookmark' => 'fa-bookmark',
        'lightbulb' => 'fa-lightbulb',
        'star' => 'fa-star',
        'check-circle' => 'fa-circle-check',
        'list' => 'fa-list-ul',
        'clipboard' => 'fa-clipboard-list'
    );
    $icon_class = isset($icon_map[$icon]) ? $icon_map[$icon] : 'fa-bookmark';
    
    // Generate unique ID
    $unique_id = 'tez-takeaways-' . $post->ID;
    
    // Build output
    $output = '<div class="tez-key-takeaways tez-takeaways-' . esc_attr($style) . ' tez-list-' . esc_attr($list_type) . ($collapsible === 'yes' ? ' tez-collapsible' : '') . '" dir="rtl" id="' . $unique_id . '"';
    
    if ($enable_schema === 'yes') {
        $output .= ' itemscope itemtype="https://schema.org/ItemList"';
    }
    $output .= ' role="region" aria-label="' . esc_attr($heading) . '">';
    
    // Header with controls
    $output .= '<div class="tez-takeaways-header">';
    $output .= '<h3 class="tez-takeaways-heading"';
    if ($enable_schema === 'yes') {
        $output .= ' itemprop="name"';
    }
    $output .= '><i class="fas ' . esc_attr($icon_class) . '" aria-hidden="true"></i> ' . esc_html($heading) . '</h3>';
    
    // Controls
    if ($collapsible === 'yes' || $show_copy_btn === 'yes' || $show_reading_time === 'yes') {
        $output .= '<div class="tez-takeaways-controls">';
        
        if ($show_reading_time === 'yes') {
            $output .= '<span class="tez-reading-time"><i class="fas fa-clock" aria-hidden="true"></i> ' . sprintf("%d دقیقه", $reading_minutes) . '</span>';
        }
        
        if ($show_copy_btn === 'yes') {
            $output .= '<button type="button" class="tez-copy-btn" aria-label="کپی متن" title="کپی همه نکات"><i class="fas fa-copy"></i> <span class="tez-copy-text">کپی</span></button>';
        }
        
        if ($collapsible === 'yes') {
            $output .= '<button type="button" class="tez-toggle-btn" aria-expanded="true" aria-controls="' . $unique_id . '-content" aria-label="جمع/باز کردن"><i class="fas fa-chevron-up"></i></button>';
        }
        
        $output .= '</div>';
    }
    
    $output .= '</div>'; // Close header
    
    // Content (collapsible)
    $output .= '<div class="tez-takeaways-content" id="' . $unique_id . '-content">';
    
    $list_tag = $list_type === 'numbered' ? 'ol' : 'ul';
    $output .= '<' . $list_tag . ' class="tez-takeaways-list">';
    
    $position = 1;
    foreach ($lines as $line) {
        $line_text = trim($line);
        $output .= '<li class="tez-takeaway-item"';
        
        if ($enable_schema === 'yes') {
            $output .= ' itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"';
        }
        $output .= '>';
        
        if ($enable_schema === 'yes') {
            $output .= '<span itemprop="name">' . esc_html($line_text) . '</span>';
            $output .= '<meta itemprop="position" content="' . $position . '" />';
        } else {
            $output .= esc_html($line_text);
        }
        
        $output .= '</li>';
        $position++;
    }
    
    $output .= '</' . $list_tag . '>';
    $output .= '</div>'; // Close content
    
    if ($enable_schema === 'yes') {
        $output .= '<meta itemprop="description" content="' . esc_attr__('Key takeaways and summary points from this article', 'flavor') . '" />';
        $output .= '<meta itemprop="numberOfItems" content="' . count($lines) . '" />';
    }
    
    $output .= '</div>';
    
    return $output;
}

// =============================================
// AUTO INSERT BASED ON POSITION
// =============================================
add_filter('the_content', 'tez_auto_insert_takeaways', 5);
function tez_auto_insert_takeaways($content) {
    if (!is_singular(array('post', 'page')) || !in_the_loop() || !is_main_query()) {
        return $content;
    }
    
    global $post;
    $position = get_post_meta($post->ID, '_tez_takeaways_position', true);
    $takeaways = get_post_meta($post->ID, '_tez_key_takeaways', true);
    
    if (empty($takeaways) || $position === 'manual') {
        return $content;
    }
    
    $takeaways_html = do_shortcode('[key_takeaways]');
    
    switch ($position) {
        case 'after_title':
        case 'before_content':
            return $takeaways_html . $content;
        case 'after_content':
            return $content . $takeaways_html;
        default:
            return $content;
    }
}

// =============================================
// FRONTEND STYLES - THEME MATCHED (Enhanced)
// =============================================
add_action('wp_head', 'tez_key_takeaways_styles', 99);
function tez_key_takeaways_styles() {
    ?>
    <style id="tez-key-takeaways-css">
    /* ============================================
       KEY TAKEAWAYS - BASE STYLES
       Uses theme CSS variables for consistency
       ============================================ */
    
    .tez-key-takeaways {
        --kt-primary: var(--tez-primary, #2563eb);
        --kt-primary-dark: var(--tez-primary-dark, #1e40af);
        --kt-primary-light: var(--tez-primary-light, #3b82f6);
        --kt-primary-rgb: var(--tez-primary-rgb, 37, 99, 235);
        --kt-bg: var(--tez-bg, #ffffff);
        --kt-bg-secondary: var(--tez-bg-secondary, #f9fafb);
        --kt-bg-tertiary: var(--tez-bg-tertiary, #f3f4f6);
        --kt-text: var(--tez-text, #111827);
        --kt-text-secondary: var(--tez-text-secondary, #374151);
        --kt-text-muted: var(--tez-text-muted, #6b7280);
        --kt-border: var(--tez-border, #e5e7eb);
        --kt-shadow: var(--tez-shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
        --kt-radius: var(--tez-radius-xl, 1rem);
        --kt-transition: var(--tez-transition, 250ms cubic-bezier(0.4, 0, 0.2, 1));
        
        margin: 2rem auto;
        padding: 1.75rem;
        border-radius: var(--kt-radius);
        font-family: var(--tez-font, 'Vazirmatn', system-ui, sans-serif);
        direction: rtl;
        text-align: right;
        position: relative;
        overflow: hidden;
    }
    
    /* NEW: Header with controls */
    .tez-takeaways-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }
    
    /* Heading */
    .tez-takeaways-heading {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--kt-text);
        font-family: inherit;
        display: flex;
        align-items: center;
        gap: 0.625rem;
        line-height: 1.4;
        flex: 1 1 auto;
    }
    
    .tez-takeaways-heading i {
        color: var(--kt-primary);
        font-size: 1.125rem;
        flex-shrink: 0;
    }
    
    /* NEW: Controls */
    .tez-takeaways-controls {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        flex-shrink: 0;
    }
    
    .tez-reading-time {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
        color: var(--kt-text-muted);
        padding: 0.375rem 0.75rem;
        background: var(--kt-bg-tertiary);
        border-radius: var(--tez-radius-md, 0.5rem);
    }
    
    .tez-reading-time i {
        font-size: 0.75rem;
    }
    
    .tez-copy-btn,
    .tez-toggle-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        background: var(--kt-primary);
        color: white;
        border: none;
        border-radius: var(--tez-radius-md, 0.5rem);
        font-size: 0.8125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--kt-transition);
        font-family: inherit;
    }
    
    .tez-toggle-btn {
        padding: 0.5rem;
        background: var(--kt-bg-tertiary);
        color: var(--kt-text);
    }
    
    .tez-copy-btn:hover {
        background: var(--kt-primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(var(--kt-primary-rgb), 0.3);
    }
    
    .tez-toggle-btn:hover {
        background: var(--kt-border);
    }
    
    .tez-copy-btn:active,
    .tez-toggle-btn:active {
        transform: translateY(0);
    }
    
    .tez-copy-btn.copied {
        background: #10b981;
    }
    
    .tez-toggle-btn i {
        transition: transform var(--kt-transition);
    }
    
    .tez-collapsible.collapsed .tez-toggle-btn i {
        transform: rotate(180deg);
    }
    
    /* NEW: Collapsible content */
    .tez-takeaways-content {
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
    }
    
    .tez-collapsible.collapsed .tez-takeaways-content {
        max-height: 0 !important;
        opacity: 0;
    }
    
    /* List */
    .tez-takeaways-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    /* Numbered lists */
    .tez-list-numbered .tez-takeaways-list {
        counter-reset: tez-counter;
    }
    
    /* List Items */
    .tez-takeaway-item {
        position: relative;
        padding: 0.875rem 2.75rem 0.875rem 0;
        margin-bottom: 0.5rem;
        line-height: 1.7;
        color: var(--kt-text-secondary);
        font-size: 1rem;
        font-family: inherit;
        transition: all var(--kt-transition);
        border-radius: var(--tez-radius-md, 0.5rem);
    }
    
    .tez-takeaway-item:last-child {
        margin-bottom: 0;
    }
    
    /* Checkmark Icon (Bullet lists) */
    .tez-list-bullet .tez-takeaway-item:before {
        content: "\f00c";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        right: 0;
        top: 0.875rem;
        width: 1.625rem;
        height: 1.625rem;
        background: var(--kt-primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6875rem;
        transition: all var(--kt-transition);
    }
    
    /* Numbered Icon (Numbered lists) */
    .tez-list-numbered .tez-takeaway-item:before {
        counter-increment: tez-counter;
        content: counter(tez-counter);
        position: absolute;
        right: 0;
        top: 0.875rem;
        width: 1.625rem;
        height: 1.625rem;
        background: var(--kt-primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
        font-family: inherit;
        transition: all var(--kt-transition);
    }
    
    .tez-takeaway-item:hover {
        background: rgba(var(--kt-primary-rgb), 0.05);
        padding-right: 2.75rem;
        padding-left: 0.75rem;
    }
    
    .tez-takeaway-item:hover:before {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(var(--kt-primary-rgb), 0.3);
    }
    
    /* ============================================
       STYLE: MODERN (Default)
       ============================================ */
    .tez-takeaways-modern {
        background: linear-gradient(135deg, var(--kt-bg-secondary) 0%, var(--kt-bg-tertiary) 100%);
        border: 1px solid var(--kt-border);
        box-shadow: var(--kt-shadow);
    }
    
    .tez-takeaways-modern:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--kt-primary) 0%, var(--kt-primary-dark) 100%);
        border-radius: 0 var(--kt-radius) var(--kt-radius) 0;
    }
    
    /* ============================================
       STYLE: MINIMAL
       ============================================ */
    .tez-takeaways-minimal {
        background: var(--kt-bg);
        border-right: 4px solid var(--kt-primary);
        border-radius: 0;
        padding: 1.5rem 1.75rem;
        box-shadow: none;
    }
    
    .tez-takeaways-minimal .tez-takeaway-item:before {
        background: transparent;
        color: var(--kt-primary);
        border: 2px solid var(--kt-primary);
    }
    
    /* ============================================
       STYLE: GRADIENT
       ============================================ */
    .tez-takeaways-gradient {
        background: linear-gradient(135deg, var(--kt-primary) 0%, var(--kt-primary-dark) 100%);
        border: none;
        box-shadow: 0 10px 40px rgba(var(--kt-primary-rgb), 0.3);
    }
    
    .tez-takeaways-gradient .tez-takeaways-heading,
    .tez-takeaways-gradient .tez-takeaway-item {
        color: white;
    }
    
    .tez-takeaways-gradient .tez-takeaways-heading i {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .tez-takeaways-gradient .tez-takeaway-item:before {
        background: white;
        color: var(--kt-primary);
    }
    
    .tez-takeaways-gradient .tez-takeaway-item:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    
    .tez-takeaways-gradient .tez-reading-time {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .tez-takeaways-gradient .tez-toggle-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .tez-takeaways-gradient .tez-toggle-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .tez-takeaways-gradient .tez-copy-btn {
        background: white;
        color: var(--kt-primary);
    }
    
    .tez-takeaways-gradient .tez-copy-btn:hover {
        background: rgba(255, 255, 255, 0.9);
    }
    
    /* ============================================
       STYLE: OUTLINE
       ============================================ */
    .tez-takeaways-outline {
        background: transparent;
        border: 2px solid var(--kt-primary);
        box-shadow: none;
    }
    
    .tez-takeaways-outline .tez-takeaway-item:before {
        background: transparent;
        color: var(--kt-primary);
        border: 2px solid var(--kt-primary);
    }
    
    .tez-takeaways-outline .tez-takeaway-item:hover {
        background: rgba(var(--kt-primary-rgb), 0.05);
    }
    
    /* ============================================
       STYLE: GLASS (Glassmorphism)
       ============================================ */
    .tez-takeaways-glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .tez-takeaways-glass .tez-takeaway-item:before {
        background: linear-gradient(135deg, var(--kt-primary) 0%, var(--kt-primary-light) 100%);
    }
    
    /* ============================================
       DARK MODE SUPPORT
       ============================================ */
    [data-theme="dark"] .tez-key-takeaways {
        --kt-primary: var(--tez-primary, #3b82f6);
        --kt-primary-dark: var(--tez-primary-dark, #60a5fa);
        --kt-primary-light: var(--tez-primary-light, #2563eb);
        --kt-primary-rgb: 59, 130, 246;
        --kt-bg: var(--tez-bg, #0f172a);
        --kt-bg-secondary: var(--tez-bg-secondary, #1e293b);
        --kt-bg-tertiary: var(--tez-bg-tertiary, #334155);
        --kt-text: var(--tez-text, #f1f5f9);
        --kt-text-secondary: var(--tez-text-secondary, #e2e8f0);
        --kt-text-muted: var(--tez-text-muted, #94a3b8);
        --kt-border: var(--tez-border, #334155);
    }
    
    [data-theme="dark"] .tez-takeaways-modern {
        background: linear-gradient(135deg, var(--kt-bg-secondary) 0%, var(--kt-bg-tertiary) 100%);
    }
    
    [data-theme="dark"] .tez-takeaways-minimal {
        background: var(--kt-bg-secondary);
    }
    
    [data-theme="dark"] .tez-takeaways-outline {
        background: transparent;
        border-color: var(--kt-primary);
    }
    
    [data-theme="dark"] .tez-takeaways-glass {
        background: rgba(30, 41, 59, 0.8);
        border-color: rgba(71, 85, 105, 0.5);
    }
    
    /* ============================================
       SEPIA MODE SUPPORT
       ============================================ */
    [data-theme="sepia"] .tez-key-takeaways {
        --kt-primary: var(--tez-primary, #b45309);
        --kt-primary-dark: var(--tez-primary-dark, #92400e);
        --kt-primary-light: var(--tez-primary-light, #d97706);
        --kt-primary-rgb: 180, 83, 9;
        --kt-bg: var(--tez-bg, #faf6f1);
        --kt-bg-secondary: var(--tez-bg-secondary, #f5efe6);
        --kt-bg-tertiary: var(--tez-bg-tertiary, #ebe4d8);
        --kt-text: var(--tez-text, #44403c);
        --kt-text-secondary: var(--tez-text-secondary, #57534e);
        --kt-text-muted: var(--tez-text-muted, #78716c);
        --kt-border: var(--tez-border, #d6cfc4);
    }
    
    [data-theme="sepia"] .tez-takeaways-modern {
        background: linear-gradient(135deg, var(--kt-bg-secondary) 0%, var(--kt-bg-tertiary) 100%);
    }
    
    [data-theme="sepia"] .tez-takeaways-glass {
        background: rgba(250, 246, 241, 0.8);
        border-color: rgba(214, 207, 196, 0.5);
    }
    
    [data-theme="sepia"] .tez-takeaways-gradient {
        background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
        box-shadow: 0 10px 40px rgba(180, 83, 9, 0.25);
    }
    
    /* ============================================
       ANIMATIONS
       ============================================ */
    @keyframes tezTakeawaysFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .tez-key-takeaways {
        animation: tezTakeawaysFadeIn 0.5s ease-out;
    }
    
    .tez-takeaway-item {
        animation: tezTakeawaysFadeIn 0.5s ease-out backwards;
    }
    
    .tez-takeaway-item:nth-child(1) { animation-delay: 0.1s; }
    .tez-takeaway-item:nth-child(2) { animation-delay: 0.15s; }
    .tez-takeaway-item:nth-child(3) { animation-delay: 0.2s; }
    .tez-takeaway-item:nth-child(4) { animation-delay: 0.25s; }
    .tez-takeaway-item:nth-child(5) { animation-delay: 0.3s; }
    .tez-takeaway-item:nth-child(6) { animation-delay: 0.35s; }
    .tez-takeaway-item:nth-child(7) { animation-delay: 0.4s; }
    .tez-takeaway-item:nth-child(8) { animation-delay: 0.45s; }
    .tez-takeaway-item:nth-child(9) { animation-delay: 0.5s; }
    .tez-takeaway-item:nth-child(10) { animation-delay: 0.55s; }
    
    /* ============================================
       REDUCED MOTION
       ============================================ */
    @media (prefers-reduced-motion: reduce) {
        .tez-key-takeaways,
        .tez-takeaway-item {
            animation: none;
        }
        
        .tez-takeaway-item,
        .tez-takeaway-item:before,
        .tez-takeaways-content,
        .tez-toggle-btn i {
            transition: none;
        }
    }
    
    /* ============================================
       FOCUS STYLES - ACCESSIBILITY
       ============================================ */
    .tez-key-takeaways:focus-within {
        outline: none;
        box-shadow: var(--kt-shadow), 0 0 0 3px rgba(var(--kt-primary-rgb), 0.3);
    }
    
    .tez-takeaway-item:focus-visible {
        outline: none;
        background: rgba(var(--kt-primary-rgb), 0.1);
        box-shadow: 0 0 0 2px rgba(var(--kt-primary-rgb), 0.4);
    }
    
    .tez-copy-btn:focus-visible,
    .tez-toggle-btn:focus-visible {
        outline: none;
        box-shadow: 0 0 0 3px rgba(var(--kt-primary-rgb), 0.4);
    }
    
    /* ============================================
       RESPONSIVE STYLES
       ============================================ */
    @media (max-width: 767px) {
        .tez-key-takeaways {
            margin: 1.5rem 0;
            padding: 1.25rem;
            border-radius: var(--tez-radius-lg, 0.75rem);
        }
        
        .tez-takeaways-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .tez-takeaways-controls {
            width: 100%;
            justify-content: space-between;
        }
        
        .tez-takeaways-heading {
            font-size: 1.125rem;
            gap: 0.5rem;
        }
        
        .tez-takeaways-heading i {
            font-size: 1rem;
        }
        
        .tez-takeaway-item {
            padding: 0.75rem 2.5rem 0.75rem 0;
            font-size: 0.9375rem;
        }
        
        .tez-takeaway-item:before {
            width: 1.5rem;
            height: 1.5rem;
            font-size: 0.625rem;
            top: 0.75rem;
        }
        
        .tez-list-numbered .tez-takeaway-item:before {
            font-size: 0.6875rem;
        }
    }
    
    @media (max-width: 479px) {
        .tez-key-takeaways {
            padding: 1rem;
        }
        
        .tez-takeaways-heading {
            font-size: 1rem;
            flex-wrap: wrap;
        }
        
        .tez-takeaway-item {
            padding: 0.625rem 2.25rem 0.625rem 0;
            font-size: 0.875rem;
        }
        
        .tez-takeaway-item:before {
            width: 1.375rem;
            height: 1.375rem;
            font-size: 0.5625rem;
            top: 0.625rem;
        }
        
        .tez-list-numbered .tez-takeaway-item:before {
            font-size: 0.625rem;
        }
        
        .tez-copy-btn .tez-copy-text {
            display: none;
        }
        
        .tez-copy-btn {
            padding: 0.5rem;
        }
    }
    
    /* ============================================
       PRINT STYLES
       ============================================ */
    @media print {
        .tez-key-takeaways {
            background: #f8f9fa !important;
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
        .tez-takeaways-gradient {
            background: #f8f9fa !important;
            color: #111 !important;
        }
        
        .tez-takeaways-gradient .tez-takeaways-heading,
        .tez-takeaways-gradient .tez-takeaway-item {
            color: #111 !important;
        }
        
        .tez-takeaway-item:before {
            background: #333 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .tez-copy-btn,
        .tez-toggle-btn {
            display: none !important;
        }
        
        .tez-collapsible .tez-takeaways-content {
            max-height: none !important;
            opacity: 1 !important;
        }
    }
    
    /* ============================================
       HIGH CONTRAST MODE
       ============================================ */
    @media (prefers-contrast: high) {
        .tez-key-takeaways {
            border: 2px solid currentColor !important;
        }
        
        .tez-takeaway-item:before {
            border: 2px solid currentColor;
        }
    }
    </style>
    <?php
}

// =============================================
// NEW: FRONTEND JAVASCRIPT
// =============================================
add_action('wp_footer', 'tez_key_takeaways_js', 99);
function tez_key_takeaways_js() {
    if (!is_singular(array('post', 'page'))) return;
    ?>
    <script id="tez-key-takeaways-js">
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all takeaways boxes
            var takeawaysBoxes = document.querySelectorAll('.tez-key-takeaways');
            
            takeawaysBoxes.forEach(function(box) {
                var content = box.querySelector('.tez-takeaways-content');
                var toggleBtn = box.querySelector('.tez-toggle-btn');
                var copyBtn = box.querySelector('.tez-copy-btn');
                
                // Set initial max-height for collapsible
                if (content && box.classList.contains('tez-collapsible')) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
                
                // Toggle functionality
                if (toggleBtn && content) {
                    toggleBtn.addEventListener('click', function() {
                        if (box.classList.contains('collapsed')) {
                            box.classList.remove('collapsed');
                            toggleBtn.setAttribute('aria-expanded', 'true');
                            content.style.maxHeight = content.scrollHeight + 'px';
                        } else {
                            box.classList.add('collapsed');
                            toggleBtn.setAttribute('aria-expanded', 'false');
                            content.style.maxHeight = '0';
                        }
                    });
                }
                
                // Copy functionality
                if (copyBtn) {
                    copyBtn.addEventListener('click', function() {
                        var items = box.querySelectorAll('.tez-takeaway-item');
                        var text = Array.from(items).map(function(item) {
                            return item.textContent.trim();
                        }).join('\n');
                        
                        // Modern Clipboard API
                        if (navigator.clipboard && window.isSecureContext) {
                            navigator.clipboard.writeText(text).then(function() {
                                showCopySuccess(copyBtn);
                            }).catch(function() {
                                fallbackCopy(text, copyBtn);
                            });
                        } else {
                            fallbackCopy(text, copyBtn);
                        }
                    });
                }
            });
            
            function showCopySuccess(btn) {
                var originalText = btn.querySelector('.tez-copy-text');
                var originalHtml = btn.innerHTML;
                
                btn.classList.add('copied');
                btn.innerHTML = '<i class="fas fa-check"></i> ' + (originalText ? '<span class="tez-copy-text">کپی شد!</span>' : '');
                
                setTimeout(function() {
                    btn.classList.remove('copied');
                    btn.innerHTML = originalHtml;
                }, 2000);
            }
            
            function fallbackCopy(text, btn) {
                var textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                
                try {
                    document.execCommand('copy');
                    showCopySuccess(btn);
                } catch (err) {
                    console.error('خطا در کپی متن:', err);
                }
                
                document.body.removeChild(textarea);
            }
        });
    })();
    </script>
    <?php
}

// =============================================
// ADMIN PREVIEW STYLES
// =============================================
add_action('admin_head', 'tez_key_takeaways_admin_styles');
function tez_key_takeaways_admin_styles() {
    // Include base styles for admin preview
    tez_key_takeaways_styles();
}
