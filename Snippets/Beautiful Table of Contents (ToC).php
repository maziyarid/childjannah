/**
 * Teznevisan Table of Contents Generator
 * Version: 2.0.0
 * Features: Auto-generate from H2-H4, Dark/Sepia Mode, RTL, Accessibility, Per-Post Settings
 */

if (!defined('ABSPATH')) exit;

// =============================================
// 1. ENQUEUE FONT AWESOME
// =============================================
add_action('wp_enqueue_scripts', 'tez_toc_enqueue_assets');
add_action('admin_enqueue_scripts', 'tez_toc_admin_assets');

function tez_toc_enqueue_assets() {
    if (!is_singular('post')) return;
    
    if (!wp_style_is('font-awesome', 'enqueued') && !wp_style_is('fontawesome', 'enqueued')) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    }
}

function tez_toc_admin_assets($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) return;
    
    if (!wp_style_is('font-awesome', 'enqueued')) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    }
}

// =============================================
// 2. ADD META BOX
// =============================================
add_action('add_meta_boxes', 'tez_toc_add_metabox');
function tez_toc_add_metabox() {
    add_meta_box(
        'tez_toc_box',
        '<i class="fas fa-list-ol" style="color:#2563eb;margin-left:8px;"></i> فهرست مطالب / Table of Contents',
        'tez_toc_metabox_html',
        'post',
        'normal',
        'high'
    );
}

// =============================================
// 3. META BOX HTML
// =============================================
function tez_toc_metabox_html($post) {
    $data = get_post_meta($post->ID, '_tez_toc_data', true);
    
    // Defaults
    $enabled = isset($data['enabled']) ? $data['enabled'] : 'auto';
    $style = isset($data['style']) ? $data['style'] : 'modern';
    $position = isset($data['position']) ? $data['position'] : 'after_first_p';
    $heading = isset($data['heading']) ? $data['heading'] : 'فهرست مطالب';
    $min_headings = isset($data['min_headings']) ? $data['min_headings'] : '2';
    $levels = isset($data['levels']) ? $data['levels'] : array('h2', 'h3');
    $collapsed = isset($data['collapsed']) ? $data['collapsed'] : 'no';
    $numbering = isset($data['numbering']) ? $data['numbering'] : 'yes';
    
    wp_nonce_field('tez_toc_save', 'tez_toc_nonce');
    ?>
    
    <style>
        .tez-toc-admin-wrapper {
            padding: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            font-family: 'Vazirmatn', system-ui, -apple-system, sans-serif;
        }
        .toc-control-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .toc-field {
            margin-bottom: 20px;
        }
        .toc-field > label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1e293b;
            font-size: 14px;
        }
        .toc-field > label i {
            color: #2563eb;
            margin-left: 6px;
        }
        .toc-input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #ffffff;
            color: #1e293b;
            transition: all 0.2s ease;
        }
        .toc-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .toc-cols {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .toc-cols-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        @media (max-width: 782px) {
            .toc-cols,
            .toc-cols-2 {
                grid-template-columns: 1fr;
            }
        }
        .toc-select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #ffffff;
            color: #1e293b;
            cursor: pointer;
        }
        .toc-select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .toc-checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .toc-checkbox-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            cursor: pointer;
            padding: 8px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: #fff;
        }
        .toc-checkbox-group label:hover {
            border-color: #2563eb;
            background: #f8fafc;
        }
        .toc-checkbox-group input[type="checkbox"]:checked + span {
            color: #2563eb;
            font-weight: 600;
        }
        .toc-radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .toc-radio-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            cursor: pointer;
            padding: 10px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: #fff;
        }
        .toc-radio-group label:hover {
            border-color: #2563eb;
        }
        .toc-radio-group input[type="radio"] {
            display: none;
        }
        .toc-radio-group input[type="radio"]:checked + span {
            color: #2563eb;
            font-weight: 700;
        }
        .toc-radio-group label:has(input:checked) {
            border-color: #2563eb;
            background: #eff6ff;
        }
        .toc-info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: #1e40af;
        }
        .toc-info-box i {
            margin-top: 2px;
        }
    </style>
    
    <div class="tez-toc-admin-wrapper">
        <!-- Enable Mode -->
        <div class="toc-field">
            <label><i class="fas fa-toggle-on"></i> وضعیت / Status</label>
            <div class="toc-radio-group">
                <label>
                    <input type="radio" name="tez_toc[enabled]" value="auto" <?php checked($enabled, 'auto'); ?>>
                    <span>🤖 خودکار (Auto)</span>
                </label>
                <label>
                    <input type="radio" name="tez_toc[enabled]" value="yes" <?php checked($enabled, 'yes'); ?>>
                    <span>✅ فعال (Force On)</span>
                </label>
                <label>
                    <input type="radio" name="tez_toc[enabled]" value="no" <?php checked($enabled, 'no'); ?>>
                    <span>❌ غیرفعال (Disable)</span>
                </label>
            </div>
        </div>

        <!-- Row 1: Heading, Position, Style -->
        <div class="toc-cols">
            <div class="toc-field">
                <label><i class="fas fa-heading"></i> عنوان / Heading</label>
                <input type="text" name="tez_toc[heading]" value="<?php echo esc_attr($heading); ?>" placeholder="فهرست مطالب" class="toc-input">
            </div>
            
            <div class="toc-field">
                <label><i class="fas fa-map-pin"></i> موقعیت / Position</label>
                <select name="tez_toc[position]" class="toc-select">
                    <option value="after_first_p" <?php selected($position, 'after_first_p'); ?>>بعد از پاراگراف اول</option>
                    <option value="before_content" <?php selected($position, 'before_content'); ?>>ابتدای محتوا</option>
                    <option value="after_second_p" <?php selected($position, 'after_second_p'); ?>>بعد از پاراگراف دوم</option>
                    <option value="manual" <?php selected($position, 'manual'); ?>>دستی [tez_toc]</option>
                </select>
            </div>
            
            <div class="toc-field">
                <label><i class="fas fa-palette"></i> استایل / Style</label>
                <select name="tez_toc[style]" class="toc-select">
                    <option value="modern" <?php selected($style, 'modern'); ?>>مدرن (Modern)</option>
                    <option value="minimal" <?php selected($style, 'minimal'); ?>>مینیمال (Minimal)</option>
                    <option value="boxed" <?php selected($style, 'boxed'); ?>>باکسی (Boxed)</option>
                    <option value="gradient" <?php selected($style, 'gradient'); ?>>گرادیان (Gradient)</option>
                    <option value="sidebar" <?php selected($style, 'sidebar'); ?>>کناری (Sidebar)</option>
                </select>
            </div>
        </div>

        <!-- Row 2: Min Headings, Collapsed, Numbering -->
        <div class="toc-cols">
            <div class="toc-field">
                <label><i class="fas fa-hashtag"></i> حداقل عناوین / Min Headings</label>
                <select name="tez_toc[min_headings]" class="toc-select">
                    <option value="2" <?php selected($min_headings, '2'); ?>>2 عنوان</option>
                    <option value="3" <?php selected($min_headings, '3'); ?>>3 عنوان</option>
                    <option value="4" <?php selected($min_headings, '4'); ?>>4 عنوان</option>
                    <option value="5" <?php selected($min_headings, '5'); ?>>5 عنوان</option>
                </select>
            </div>
            
            <div class="toc-field">
                <label><i class="fas fa-compress-alt"></i> حالت اولیه / Default State</label>
                <select name="tez_toc[collapsed]" class="toc-select">
                    <option value="no" <?php selected($collapsed, 'no'); ?>>باز (Expanded)</option>
                    <option value="yes" <?php selected($collapsed, 'yes'); ?>>بسته (Collapsed)</option>
                </select>
            </div>
            
            <div class="toc-field">
                <label><i class="fas fa-list-ol"></i> شماره‌گذاری / Numbering</label>
                <select name="tez_toc[numbering]" class="toc-select">
                    <option value="yes" <?php selected($numbering, 'yes'); ?>>فعال (Enabled)</option>
                    <option value="no" <?php selected($numbering, 'no'); ?>>غیرفعال (Disabled)</option>
                </select>
            </div>
        </div>

        <!-- Heading Levels -->
        <div class="toc-field">
            <label><i class="fas fa-layer-group"></i> سطوح عناوین / Heading Levels</label>
            <div class="toc-checkbox-group">
                <label>
                    <input type="checkbox" name="tez_toc[levels][]" value="h2" <?php checked(in_array('h2', $levels)); ?>>
                    <span>H2 (عنوان اصلی)</span>
                </label>
                <label>
                    <input type="checkbox" name="tez_toc[levels][]" value="h3" <?php checked(in_array('h3', $levels)); ?>>
                    <span>H3 (زیرعنوان)</span>
                </label>
                <label>
                    <input type="checkbox" name="tez_toc[levels][]" value="h4" <?php checked(in_array('h4', $levels)); ?>>
                    <span>H4 (زیرعنوان سطح ۲)</span>
                </label>
            </div>
        </div>
        
        <div class="toc-info-box">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>راهنما:</strong> در حالت "خودکار"، فهرست مطالب فقط در صورتی نمایش داده می‌شود که تعداد عناوین از حداقل تعیین شده بیشتر باشد.
                <br>شورت‌کد: <code>[tez_toc]</code>
            </div>
        </div>
    </div>
    <?php
}

// =============================================
// 4. SAVE META BOX
// =============================================
add_action('save_post', 'tez_toc_save_meta');
function tez_toc_save_meta($post_id) {
    if (!isset($_POST['tez_toc_nonce']) || !wp_verify_nonce($_POST['tez_toc_nonce'], 'tez_toc_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['tez_toc'])) {
        $clean_data = array();
        $clean_data['enabled'] = sanitize_text_field($_POST['tez_toc']['enabled']);
        $clean_data['heading'] = sanitize_text_field($_POST['tez_toc']['heading']);
        $clean_data['position'] = sanitize_text_field($_POST['tez_toc']['position']);
        $clean_data['style'] = sanitize_text_field($_POST['tez_toc']['style']);
        $clean_data['min_headings'] = sanitize_text_field($_POST['tez_toc']['min_headings']);
        $clean_data['collapsed'] = sanitize_text_field($_POST['tez_toc']['collapsed']);
        $clean_data['numbering'] = sanitize_text_field($_POST['tez_toc']['numbering']);
        
        // Levels array
        $clean_data['levels'] = array();
        if (isset($_POST['tez_toc']['levels']) && is_array($_POST['tez_toc']['levels'])) {
            foreach ($_POST['tez_toc']['levels'] as $level) {
                $clean_data['levels'][] = sanitize_text_field($level);
            }
        }
        if (empty($clean_data['levels'])) {
            $clean_data['levels'] = array('h2', 'h3');
        }
        
        update_post_meta($post_id, '_tez_toc_data', $clean_data);
    }
}

// =============================================
// 5. SHORTCODE
// =============================================
add_shortcode('tez_toc', 'tez_toc_shortcode');
function tez_toc_shortcode($atts) {
    global $post;
    if (!$post) return '';
    
    return tez_toc_generate($post->ID, get_the_content(), true);
}

// =============================================
// 6. AUTO INSERT INTO CONTENT
// Priority 5 - Before Poll (15) and FAQ (25)
// =============================================
add_filter('the_content', 'tez_toc_inject_content', 5);
function tez_toc_inject_content($content) {
    if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    global $post;
    $data = get_post_meta($post->ID, '_tez_toc_data', true);
    
    // Get settings
    $enabled = isset($data['enabled']) ? $data['enabled'] : 'auto';
    $position = isset($data['position']) ? $data['position'] : 'after_first_p';
    
    // Check if disabled
    if ($enabled === 'no') {
        return $content;
    }
    
    // Check if manual
    if ($position === 'manual') {
        // Only add IDs to headings, don't insert TOC
        return tez_toc_add_heading_ids($content, $data);
    }
    
    // Generate TOC
    $result = tez_toc_generate($post->ID, $content, false, $data);
    
    if (empty($result['toc'])) {
        return $content;
    }
    
    $content = $result['content'];
    $toc_html = $result['toc'];
    
    // Insert based on position
    switch ($position) {
        case 'before_content':
            return $toc_html . $content;
            
        case 'after_second_p':
            return tez_toc_insert_after_paragraph($content, $toc_html, 2);
            
        case 'after_first_p':
        default:
            return tez_toc_insert_after_paragraph($content, $toc_html, 1);
    }
}

// =============================================
// 7. HELPER: INSERT AFTER PARAGRAPH
// =============================================
function tez_toc_insert_after_paragraph($content, $insert, $paragraph_num) {
    $paragraphs = explode('</p>', $content);
    $count = count($paragraphs);
    
    if ($count < $paragraph_num) {
        return $insert . $content;
    }
    
    $output = '';
    for ($i = 0; $i < $count; $i++) {
        $output .= $paragraphs[$i];
        if ($i < $count - 1) {
            $output .= '</p>';
        }
        if ($i + 1 === $paragraph_num) {
            $output .= $insert;
        }
    }
    
    return $output;
}

// =============================================
// 8. HELPER: ADD HEADING IDS
// =============================================
function tez_toc_add_heading_ids($content, $data = array()) {
    $levels = isset($data['levels']) ? $data['levels'] : array('h2', 'h3');
    $pattern = '/<(' . implode('|', $levels) . ')([^>]*)>(.*?)<\/\1>/i';
    
    $counter = 0;
    $content = preg_replace_callback($pattern, function($matches) use (&$counter) {
        $tag = $matches[1];
        $attrs = $matches[2];
        $text = $matches[3];
        $counter++;
        
        // Check if already has ID
        if (preg_match('/id=["\']([^"\']+)["\']/', $attrs, $id_match)) {
            return $matches[0];
        }
        
        $id = 'toc-' . $counter . '-' . sanitize_title(strip_tags($text));
        return '<' . $tag . $attrs . ' id="' . $id . '">' . $text . '</' . $tag . '>';
    }, $content);
    
    return $content;
}

// =============================================
// 9. GENERATE TOC
// =============================================
function tez_toc_generate($post_id, $content, $shortcode = false, $data = null) {
    if (!$data) {
        $data = get_post_meta($post_id, '_tez_toc_data', true);
    }
    
    // Settings
    $enabled = isset($data['enabled']) ? $data['enabled'] : 'auto';
    $style = isset($data['style']) ? $data['style'] : 'modern';
    $heading = isset($data['heading']) ? $data['heading'] : 'فهرست مطالب';
    $min_headings = isset($data['min_headings']) ? intval($data['min_headings']) : 2;
    $levels = isset($data['levels']) ? $data['levels'] : array('h2', 'h3');
    $collapsed = isset($data['collapsed']) ? $data['collapsed'] : 'no';
    $numbering = isset($data['numbering']) ? $data['numbering'] : 'yes';
    
    if (empty($levels)) {
        $levels = array('h2', 'h3');
    }
    
    // Build regex pattern for selected heading levels
    $pattern = '/<(' . implode('|', $levels) . ')([^>]*)>(.*?)<\/\1>/i';
    
    // Find all headings
    preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);
    
    // Check minimum headings
    if (count($matches) < $min_headings) {
        if ($enabled === 'auto') {
            return $shortcode ? '' : array('toc' => '', 'content' => $content);
        }
    }
    
    if (empty($matches)) {
        return $shortcode ? '' : array('toc' => '', 'content' => $content);
    }
    
    // Add IDs to headings in content
    $counter = 0;
    $toc_items = array();
    
    $content = preg_replace_callback($pattern, function($m) use (&$counter, &$toc_items) {
        $counter++;
        $tag = strtolower($m[1]);
        $attrs = $m[2];
        $text = $m[3];
        $plain_text = strip_tags($text);
        
        // Check if already has ID
        if (preg_match('/id=["\']([^"\']+)["\']/', $attrs, $id_match)) {
            $id = $id_match[1];
        } else {
            $id = 'toc-' . $counter . '-' . sanitize_title($plain_text);
            $attrs .= ' id="' . $id . '"';
        }
        
        // Store for TOC
        $toc_items[] = array(
            'level' => intval(substr($tag, 1)),
            'id' => $id,
            'text' => $plain_text
        );
        
        return '<' . $m[1] . $attrs . '>' . $text . '</' . $m[1] . '>';
    }, $content);
    
    // Build TOC HTML
    $collapsed_class = ($collapsed === 'yes') ? ' is-collapsed' : '';
    $aria_expanded = ($collapsed === 'yes') ? 'false' : 'true';
    $numbering_class = ($numbering === 'yes') ? ' has-numbering' : '';
    
    $toc_html = '<nav class="tez-toc-container tez-toc-' . esc_attr($style) . $collapsed_class . $numbering_class . '" ';
    $toc_html .= 'id="tez-toc-' . $post_id . '" ';
    $toc_html .= 'role="navigation" ';
    $toc_html .= 'aria-label="' . esc_attr($heading) . '" ';
    $toc_html .= 'dir="rtl">';
    
    $toc_html .= '<div class="tez-toc-header">';
    $toc_html .= '<span class="tez-toc-title">';
    $toc_html .= '<i class="fas fa-list-ol" aria-hidden="true"></i> ';
    $toc_html .= esc_html($heading);
    $toc_html .= '</span>';
    $toc_html .= '<button type="button" class="tez-toc-toggle" ';
    $toc_html .= 'aria-expanded="' . $aria_expanded . '" ';
    $toc_html .= 'aria-controls="tez-toc-list-' . $post_id . '" ';
    $toc_html .= 'aria-label="باز/بسته کردن فهرست">';
    $toc_html .= '<i class="fas fa-chevron-up" aria-hidden="true"></i>';
    $toc_html .= '</button>';
    $toc_html .= '</div>';
    
    $toc_html .= '<ul class="tez-toc-list" id="tez-toc-list-' . $post_id . '">';
    
    $item_counter = 0;
    foreach ($toc_items as $item) {
        $item_counter++;
        $level_class = 'tez-toc-level-' . $item['level'];
        
        $toc_html .= '<li class="tez-toc-item ' . $level_class . '">';
        $toc_html .= '<a href="#' . esc_attr($item['id']) . '" class="tez-toc-link" data-index="' . $item_counter . '">';
        if ($numbering === 'yes') {
            $toc_html .= '<span class="tez-toc-number">' . $item_counter . '</span>';
        }
        $toc_html .= '<span class="tez-toc-text">' . esc_html($item['text']) . '</span>';
        $toc_html .= '<i class="fas fa-angle-left tez-toc-arrow" aria-hidden="true"></i>';
        $toc_html .= '</a>';
        $toc_html .= '</li>';
    }
    
    $toc_html .= '</ul>';
    $toc_html .= '</nav>';
    
    if ($shortcode) {
        return $toc_html;
    }
    
    return array('toc' => $toc_html, 'content' => $content);
}

// =============================================
// 10. FRONTEND CSS
// =============================================
add_action('wp_head', 'tez_toc_frontend_css', 99);
function tez_toc_frontend_css() {
    if (!is_singular('post')) return;
    ?>
    <style id="tez-toc-css">
    /* ============================================
       TEZ TOC - BASE STYLES
       ============================================ */
    
    .tez-toc-container {
        --toc-primary: var(--tez-primary, #2563eb);
        --toc-primary-dark: var(--tez-primary-dark, #1e40af);
        --toc-primary-light: var(--tez-primary-light, #3b82f6);
        --toc-primary-rgb: var(--tez-primary-rgb, 37, 99, 235);
        --toc-bg: var(--tez-bg, #ffffff);
        --toc-bg-secondary: var(--tez-bg-secondary, #f9fafb);
        --toc-bg-tertiary: var(--tez-bg-tertiary, #f3f4f6);
        --toc-text: var(--tez-text, #111827);
        --toc-text-secondary: var(--tez-text-secondary, #374151);
        --toc-text-muted: var(--tez-text-muted, #6b7280);
        --toc-border: var(--tez-border, #e5e7eb);
        --toc-shadow: var(--tez-shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
        --toc-radius: var(--tez-radius-xl, 1rem);
        --toc-transition: var(--tez-transition, 250ms cubic-bezier(0.4, 0, 0.2, 1));
        
        margin: 2rem 0;
        border-radius: var(--toc-radius);
        font-family: var(--tez-font, 'Vazirmatn', system-ui, sans-serif);
        direction: rtl;
        overflow: hidden;
        position: relative;
    }
    
    /* Header */
    .tez-toc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        background: var(--toc-bg);
        border-bottom: 1px solid var(--toc-border);
    }
    
    .tez-toc-title {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--toc-text);
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
    
    .tez-toc-title i {
        color: var(--toc-primary);
        font-size: 1rem;
    }
    
    /* Toggle Button */
    .tez-toc-toggle {
        width: 2rem;
        height: 2rem;
        min-width: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--toc-bg-tertiary);
        border: none;
        border-radius: 50%;
        color: var(--toc-text-muted);
        cursor: pointer;
        transition: all var(--toc-transition);
    }
    
    .tez-toc-toggle:hover {
        background: var(--toc-primary);
        color: #fff;
    }
    
    .tez-toc-toggle:focus-visible {
        outline: none;
        box-shadow: 0 0 0 3px rgba(var(--toc-primary-rgb), 0.3);
    }
    
    .tez-toc-toggle i {
        font-size: 0.75rem;
        transition: transform var(--toc-transition);
    }
    
    .tez-toc-container.is-collapsed .tez-toc-toggle i {
        transform: rotate(180deg);
    }
    
    /* List */
    .tez-toc-list {
        list-style: none !important;
        margin: 0 !important;
        padding: 1rem 1.25rem !important;
        background: var(--toc-bg-secondary);
        max-height: 500px;
        overflow-y: auto;
        transition: all 0.35s ease;
    }
    
    .tez-toc-container.is-collapsed .tez-toc-list {
        max-height: 0;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        overflow: hidden;
    }
    
    /* Items */
    .tez-toc-item {
        margin-bottom: 0.5rem !important;
        padding: 0 !important;
    }
    
    .tez-toc-item:last-child {
        margin-bottom: 0 !important;
    }
    
    /* Links */
    .tez-toc-link {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 0.625rem 0.875rem;
        color: var(--toc-text-secondary);
        text-decoration: none;
        font-size: 0.9375rem;
        font-weight: 500;
        border-radius: var(--tez-radius-md, 0.5rem);
        transition: all var(--toc-transition);
        background: transparent;
    }
    
    .tez-toc-link:hover {
        background: var(--toc-bg);
        color: var(--toc-primary);
        transform: translateX(-4px);
    }
    
    .tez-toc-link:focus-visible {
        outline: none;
        box-shadow: 0 0 0 2px var(--toc-primary);
    }
    
    .tez-toc-link.is-active {
        background: var(--toc-primary);
        color: #fff;
    }
    
    .tez-toc-link.is-active .tez-toc-number {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    
    .tez-toc-link.is-active .tez-toc-arrow {
        opacity: 1;
        color: #fff;
    }
    
    /* Number Badge */
    .tez-toc-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 1.5rem;
        height: 1.5rem;
        padding: 0 0.375rem;
        background: var(--toc-bg-tertiary);
        color: var(--toc-text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: var(--tez-radius-sm, 0.25rem);
        transition: all var(--toc-transition);
    }
    
    .tez-toc-link:hover .tez-toc-number {
        background: var(--toc-primary);
        color: #fff;
    }
    
    /* Text */
    .tez-toc-text {
        flex: 1;
        line-height: 1.5;
    }
    
    /* Arrow */
    .tez-toc-arrow {
        font-size: 0.6875rem;
        opacity: 0.3;
        transition: all var(--toc-transition);
    }
    
    .tez-toc-link:hover .tez-toc-arrow {
        opacity: 1;
        color: var(--toc-primary);
        transform: translateX(-4px);
    }
    
    /* Level Indentation */
    .tez-toc-level-3 {
        padding-right: 1.25rem !important;
    }
    
    .tez-toc-level-3 .tez-toc-link {
        font-size: 0.875rem;
    }
    
    .tez-toc-level-4 {
        padding-right: 2.5rem !important;
    }
    
    .tez-toc-level-4 .tez-toc-link {
        font-size: 0.8125rem;
    }
    
    /* No numbering */
    .tez-toc-container:not(.has-numbering) .tez-toc-number {
        display: none;
    }
    
    /* ============================================
       STYLE: MODERN (Default)
       ============================================ */
    .tez-toc-modern {
        background: var(--toc-bg-secondary);
        border: 1px solid var(--toc-border);
        box-shadow: var(--toc-shadow);
    }
    
    .tez-toc-modern:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--toc-primary) 0%, var(--toc-primary-dark) 100%);
        border-radius: 0 var(--toc-radius) var(--toc-radius) 0;
    }
    
    /* ============================================
       STYLE: MINIMAL
       ============================================ */
    .tez-toc-minimal {
        background: transparent;
        border: none;
        box-shadow: none;
        border-right: 3px solid var(--toc-primary);
        border-radius: 0;
    }
    
    .tez-toc-minimal .tez-toc-header {
        background: transparent;
        border-bottom: none;
        padding: 0 0 0.75rem 0;
    }
    
    .tez-toc-minimal .tez-toc-list {
        background: transparent;
        padding: 0 !important;
    }
    
    .tez-toc-minimal .tez-toc-link {
        padding: 0.5rem 0;
    }
    
    .tez-toc-minimal .tez-toc-link:hover {
        background: transparent;
        padding-right: 0.5rem;
    }
    
    /* ============================================
       STYLE: BOXED
       ============================================ */
    .tez-toc-boxed {
        background: var(--toc-bg);
        border: 2px solid var(--toc-primary);
    }
    
    .tez-toc-boxed .tez-toc-header {
        background: var(--toc-primary);
    }
    
    .tez-toc-boxed .tez-toc-title {
        color: #fff;
    }
    
    .tez-toc-boxed .tez-toc-title i {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .tez-toc-boxed .tez-toc-toggle {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    
    .tez-toc-boxed .tez-toc-toggle:hover {
        background: #fff;
        color: var(--toc-primary);
    }
    
    .tez-toc-boxed .tez-toc-list {
        background: var(--toc-bg);
    }
    
    /* ============================================
       STYLE: GRADIENT
       ============================================ */
    .tez-toc-gradient {
        background: linear-gradient(135deg, var(--toc-primary) 0%, var(--toc-primary-dark) 100%);
        border: none;
    }
    
    .tez-toc-gradient .tez-toc-header {
        background: transparent;
        border-color: rgba(255, 255, 255, 0.2);
    }
    
    .tez-toc-gradient .tez-toc-title {
        color: #fff;
    }
    
    .tez-toc-gradient .tez-toc-title i {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .tez-toc-gradient .tez-toc-toggle {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
    }
    
    .tez-toc-gradient .tez-toc-toggle:hover {
        background: #fff;
        color: var(--toc-primary);
    }
    
    .tez-toc-gradient .tez-toc-list {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
    }
    
    .tez-toc-gradient .tez-toc-link {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .tez-toc-gradient .tez-toc-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
    }
    
    .tez-toc-gradient .tez-toc-link.is-active {
        background: #fff;
        color: var(--toc-primary);
    }
    
    .tez-toc-gradient .tez-toc-number {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    
    .tez-toc-gradient .tez-toc-link:hover .tez-toc-number {
        background: #fff;
        color: var(--toc-primary);
    }
    
    .tez-toc-gradient .tez-toc-arrow {
        color: rgba(255, 255, 255, 0.5);
    }
    
    .tez-toc-gradient .tez-toc-link:hover .tez-toc-arrow {
        color: #fff;
    }
    
    /* ============================================
       STYLE: SIDEBAR (Floating)
       ============================================ */
    .tez-toc-sidebar {
        background: var(--toc-bg);
        border: 1px solid var(--toc-border);
        box-shadow: var(--toc-shadow);
    }
    
    @media (min-width: 1200px) {
        .tez-toc-sidebar {
            position: sticky;
            top: calc(var(--tez-header-height, 70px) + 20px);
            max-width: 280px;
            float: left;
            margin-left: -320px;
            margin-right: 20px;
            z-index: 100;
        }
        
        .tez-toc-sidebar .tez-toc-list {
            max-height: calc(100vh - 200px);
        }
    }
    
    @media (max-width: 1199px) {
        .tez-toc-sidebar {
            float: none;
            margin: 2rem 0;
            max-width: 100%;
        }
    }
    
    /* ============================================
       DARK MODE
       ============================================ */
    [data-theme="dark"] .tez-toc-container {
        --toc-primary: var(--tez-primary, #3b82f6);
        --toc-primary-dark: var(--tez-primary-dark, #60a5fa);
        --toc-primary-light: var(--tez-primary-light, #2563eb);
        --toc-primary-rgb: 59, 130, 246;
        --toc-bg: var(--tez-bg, #0f172a);
        --toc-bg-secondary: var(--tez-bg-secondary, #1e293b);
        --toc-bg-tertiary: var(--tez-bg-tertiary, #334155);
        --toc-text: var(--tez-text, #f1f5f9);
        --toc-text-secondary: var(--tez-text-secondary, #e2e8f0);
        --toc-text-muted: var(--tez-text-muted, #94a3b8);
        --toc-border: var(--tez-border, #334155);
    }
    
    [data-theme="dark"] .tez-toc-modern {
        background: var(--toc-bg-secondary);
    }
    
    [data-theme="dark"] .tez-toc-boxed .tez-toc-list {
        background: var(--toc-bg);
    }
    
    /* ============================================
       SEPIA MODE
       ============================================ */
    [data-theme="sepia"] .tez-toc-container {
        --toc-primary: var(--tez-primary, #b45309);
        --toc-primary-dark: var(--tez-primary-dark, #92400e);
        --toc-primary-light: var(--tez-primary-light, #d97706);
        --toc-primary-rgb: 180, 83, 9;
        --toc-bg: var(--tez-bg, #faf6f1);
        --toc-bg-secondary: var(--tez-bg-secondary, #f5efe6);
        --toc-bg-tertiary: var(--tez-bg-tertiary, #ebe4d8);
        --toc-text: var(--tez-text, #44403c);
        --toc-text-secondary: var(--tez-text-secondary, #57534e);
        --toc-text-muted: var(--tez-text-muted, #78716c);
        --toc-border: var(--tez-border, #d6cfc4);
    }
    
    [data-theme="sepia"] .tez-toc-gradient {
        background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
    }
    
    /* ============================================
       ANIMATIONS
       ============================================ */
    @keyframes tezTocFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .tez-toc-container {
        animation: tezTocFadeIn 0.4s ease-out;
    }
    
    .tez-toc-item {
        animation: tezTocFadeIn 0.3s ease-out backwards;
    }
    
    .tez-toc-item:nth-child(1) { animation-delay: 0.05s; }
    .tez-toc-item:nth-child(2) { animation-delay: 0.1s; }
    .tez-toc-item:nth-child(3) { animation-delay: 0.15s; }
    .tez-toc-item:nth-child(4) { animation-delay: 0.2s; }
    .tez-toc-item:nth-child(5) { animation-delay: 0.25s; }
    .tez-toc-item:nth-child(6) { animation-delay: 0.3s; }
    .tez-toc-item:nth-child(7) { animation-delay: 0.35s; }
    .tez-toc-item:nth-child(8) { animation-delay: 0.4s; }
    .tez-toc-item:nth-child(9) { animation-delay: 0.45s; }
    .tez-toc-item:nth-child(10) { animation-delay: 0.5s; }
    
    /* ============================================
       REDUCED MOTION
       ============================================ */
    @media (prefers-reduced-motion: reduce) {
        .tez-toc-container,
        .tez-toc-item {
            animation: none;
        }
        
        .tez-toc-list,
        .tez-toc-link,
        .tez-toc-toggle,
        .tez-toc-toggle i,
        .tez-toc-arrow {
            transition: none;
        }
        
        html {
            scroll-behavior: auto;
        }
    }
    
    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 767px) {
        .tez-toc-container {
            margin: 1.5rem 0;
            border-radius: var(--tez-radius-lg, 0.75rem);
        }
        
        .tez-toc-header {
            padding: 0.875rem 1rem;
        }
        
        .tez-toc-title {
            font-size: 1rem;
            gap: 0.5rem;
        }
        
        .tez-toc-list {
            padding: 0.875rem 1rem !important;
        }
        
        .tez-toc-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .tez-toc-level-3 {
            padding-right: 1rem !important;
        }
        
        .tez-toc-level-4 {
            padding-right: 2rem !important;
        }
    }
    
    @media (max-width: 479px) {
        .tez-toc-header {
            padding: 0.75rem;
        }
        
        .tez-toc-title {
            font-size: 0.9375rem;
        }
        
        .tez-toc-link {
            padding: 0.5rem;
            font-size: 0.8125rem;
        }
        
        .tez-toc-number {
            min-width: 1.25rem;
            height: 1.25rem;
            font-size: 0.6875rem;
        }
    }
    
    /* ============================================
       PRINT STYLES
       ============================================ */
    @media print {
        .tez-toc-container {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
        .tez-toc-toggle {
            display: none !important;
        }
        
        .tez-toc-list {
            max-height: none !important;
            display: block !important;
        }
        
        .tez-toc-gradient {
            background: #f8f9fa !important;
        }
        
        .tez-toc-gradient .tez-toc-title,
        .tez-toc-gradient .tez-toc-link {
            color: #111 !important;
        }
    }
    
    /* ============================================
       SCROLL MARGIN FOR HEADINGS
       ============================================ */
    h2[id], h3[id], h4[id] {
        scroll-margin-top: calc(var(--tez-header-height, 70px) + 20px);
    }
    
    @media (max-width: 767px) {
        h2[id], h3[id], h4[id] {
            scroll-margin-top: calc(var(--tez-header-height-mobile, 60px) + 15px);
        }
    }
    </style>
    <?php
}

// =============================================
// 11. FRONTEND JS
// =============================================
add_action('wp_footer', 'tez_toc_frontend_js', 99);
function tez_toc_frontend_js() {
    if (!is_singular('post')) return;
    ?>
    <script id="tez-toc-js">
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle functionality
            var toggleBtns = document.querySelectorAll('.tez-toc-toggle');
            
            toggleBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var container = this.closest('.tez-toc-container');
                    var isCollapsed = container.classList.contains('is-collapsed');
                    
                    container.classList.toggle('is-collapsed');
                    this.setAttribute('aria-expanded', isCollapsed ? 'true' : 'false');
                });
            });
            
            // Smooth scroll
            var tocLinks = document.querySelectorAll('.tez-toc-link');
            
            tocLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var targetId = this.getAttribute('href').substring(1);
                    var target = document.getElementById(targetId);
                    
                    if (target) {
                        // Remove active from all
                        tocLinks.forEach(function(l) {
                            l.classList.remove('is-active');
                        });
                        // Add active to clicked
                        this.classList.add('is-active');
                        
                        // Smooth scroll
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        
                        // Update URL hash without jumping
                        history.pushState(null, null, '#' + targetId);
                    }
                });
            });
            
            // Highlight current section on scroll (Intersection Observer)
            if ('IntersectionObserver' in window) {
                var headings = document.querySelectorAll('h2[id], h3[id], h4[id]');
                
                if (headings.length > 0) {
                    var observer = new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                var id = entry.target.getAttribute('id');
                                
                                tocLinks.forEach(function(link) {
                                    link.classList.remove('is-active');
                                    if (link.getAttribute('href') === '#' + id) {
                                        link.classList.add('is-active');
                                    }
                                });
                            }
                        });
                    }, {
                        rootMargin: '-100px 0px -80% 0px',
                        threshold: 0
                    });
                    
                    headings.forEach(function(heading) {
                        observer.observe(heading);
                    });
                }
            }
            
            // Keyboard navigation
            tocLinks.forEach(function(link, index) {
                link.addEventListener('keydown', function(e) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        var nextLink = tocLinks[index + 1];
                        if (nextLink) nextLink.focus();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        var prevLink = tocLinks[index - 1];
                        if (prevLink) prevLink.focus();
                    }
                });
            });
        });
    })();
    </script>
    <?php
}
