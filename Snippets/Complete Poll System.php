/**
 * Teznevisan Advanced Poll System
 * Version: 2.0.0
 * Features: IP-Voting, Dark/Sepia Mode, RTL, Animations, Accessibility, Auto-Insert
 */

if (!defined('ABSPATH')) exit;

// =============================================
// 1. DATABASE SETUP
// =============================================
add_action('admin_init', 'tez_poll_check_db');
function tez_poll_check_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tez_polls';
    $db_version = '2.0';
    $installed_ver = get_option('tez_poll_db_version');

    if ($installed_ver != $db_version) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            post_id mediumint(9) NOT NULL,
            poll_id mediumint(9) NOT NULL,
            option_key varchar(50) NOT NULL,
            user_ip varchar(100) NOT NULL,
            time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id),
            KEY post_id (post_id),
            KEY user_ip (user_ip)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        update_option('tez_poll_db_version', $db_version);
    }
}

// =============================================
// 2. ENQUEUE ASSETS
// =============================================
add_action('wp_enqueue_scripts', 'tez_poll_assets');
add_action('admin_enqueue_scripts', 'tez_poll_admin_assets');

function tez_poll_assets() {
    if (!is_singular('post')) return;
    
    // Load FontAwesome if not present
    if (!wp_style_is('font-awesome', 'enqueued') && !wp_style_is('fontawesome', 'enqueued')) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    }

    // Frontend CSS
    wp_register_style('tez-poll-css', false);
    wp_enqueue_style('tez-poll-css');
    wp_add_inline_style('tez-poll-css', tez_poll_get_css());

    // Frontend JS
    wp_enqueue_script('jquery');
    wp_register_script('tez-poll-js', '', array('jquery'), '2.0', true);
    wp_enqueue_script('tez-poll-js');
    wp_add_inline_script('tez-poll-js', tez_poll_get_js());
    
    wp_localize_script('tez-poll-js', 'tez_poll_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('tez_poll_nonce')
    ));
}

function tez_poll_admin_assets($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) return;
    
    // Load FontAwesome
    if (!wp_style_is('font-awesome', 'enqueued')) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    }
    
    // Admin CSS & JS
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-sortable');
    
    wp_register_style('tez-poll-admin-css', false);
    wp_enqueue_style('tez-poll-admin-css');
    wp_add_inline_style('tez-poll-admin-css', tez_poll_get_admin_css());
    
    wp_register_script('tez-poll-admin-js', '', array('jquery', 'jquery-ui-sortable'), '2.0', true);
    wp_enqueue_script('tez-poll-admin-js');
    wp_add_inline_script('tez-poll-admin-js', tez_poll_get_admin_js());
}

// =============================================
// 3. HELPER: GET USER IP (Enhanced)
// =============================================
function tez_poll_get_user_ip() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Can contain multiple IPs, get the first one
        $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ip_list[0]);
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    return sanitize_text_field($ip);
}

// =============================================
// 4. ADMIN META BOX
// =============================================
add_action('add_meta_boxes', 'tez_poll_add_meta_box');
function tez_poll_add_meta_box() {
    add_meta_box(
        'tez_poll_box',
        '<i class="fas fa-poll" style="color:#2563eb;margin-left:8px;"></i> نظرسنجی / Poll Settings',
        'tez_poll_meta_box_html',
        'post',
        'normal',
        'high'
    );
}

function tez_poll_meta_box_html($post) {
    $data = get_post_meta($post->ID, '_tez_poll_data', true);
    
    // Defaults
    $enabled = isset($data['enabled']) ? $data['enabled'] : 'no';
    $question = isset($data['question']) ? $data['question'] : '';
    $type = isset($data['type']) ? $data['type'] : 'single';
    $position = isset($data['position']) ? $data['position'] : 'before_last';
    $style = isset($data['style']) ? $data['style'] : 'modern';
    $options = isset($data['options']) ? $data['options'] : array(
        array('text' => '', 'color' => '#2563eb'),
        array('text' => '', 'color' => '#1FA640')
    );
    
    wp_nonce_field('tez_poll_save_meta', 'tez_poll_meta_nonce');
    ?>
    
    <div class="tez-poll-admin-wrapper">
        <!-- Enable Switch -->
        <div class="poll-control-group">
            <label class="poll-switch">
                <input type="checkbox" name="tez_poll[enabled]" value="yes" <?php checked($enabled, 'yes'); ?>>
                <span class="poll-slider round"></span>
            </label>
            <span class="poll-switch-label">فعال‌سازی نظرسنجی برای این پست</span>
        </div>

        <div class="poll-body" style="display: <?php echo ($enabled === 'yes') ? 'block' : 'none'; ?>">
            <!-- Question -->
            <div class="poll-field">
                <label><i class="fas fa-question-circle"></i> سوال نظرسنجی / Question</label>
                <input type="text" name="tez_poll[question]" value="<?php echo esc_attr($question); ?>" placeholder="مثال: نظر شما درباره این مقاله چیست؟" class="poll-input">
            </div>

            <!-- Type, Position, Style -->
            <div class="poll-cols">
                <div class="poll-field">
                    <label><i class="fas fa-list-check"></i> نوع انتخاب / Type</label>
                    <select name="tez_poll[type]" class="poll-select">
                        <option value="single" <?php selected($type, 'single'); ?>>تک انتخابی (Single)</option>
                        <option value="multiple" <?php selected($type, 'multiple'); ?>>چند انتخابی (Multiple)</option>
                    </select>
                </div>
                
                <div class="poll-field">
                    <label><i class="fas fa-map-pin"></i> موقعیت / Position</label>
                    <select name="tez_poll[position]" class="poll-select">
                        <option value="before_last" <?php selected($position, 'before_last'); ?>>قبل از پاراگراف آخر</option>
                        <option value="after_content" <?php selected($position, 'after_content'); ?>>انتهای محتوا</option>
                        <option value="before_content" <?php selected($position, 'before_content'); ?>>ابتدای محتوا</option>
                        <option value="manual" <?php selected($position, 'manual'); ?>>دستی [tez_poll]</option>
                    </select>
                </div>
                
                <div class="poll-field">
                    <label><i class="fas fa-palette"></i> استایل / Style</label>
                    <select name="tez_poll[style]" class="poll-select">
                        <option value="modern" <?php selected($style, 'modern'); ?>>مدرن (Modern)</option>
                        <option value="minimal" <?php selected($style, 'minimal'); ?>>مینیمال (Minimal)</option>
                        <option value="gradient" <?php selected($style, 'gradient'); ?>>گرادیان (Gradient)</option>
                        <option value="glass" <?php selected($style, 'glass'); ?>>شیشه‌ای (Glass)</option>
                    </select>
                </div>
            </div>

            <!-- Options -->
            <div class="poll-field">
                <label><i class="fas fa-list-ul"></i> گزینه‌ها / Options</label>
                <div id="poll-options-container">
                    <?php foreach ($options as $key => $opt): ?>
                    <div class="poll-option-row">
                        <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>
                        <input type="text" name="tez_poll[options][<?php echo $key; ?>][text]" value="<?php echo esc_attr($opt['text']); ?>" placeholder="متن گزینه...">
                        <input type="color" name="tez_poll[options][<?php echo $key; ?>][color]" value="<?php echo esc_attr($opt['color']); ?>" title="رنگ گزینه">
                        <button type="button" class="button remove-row"><i class="fas fa-trash"></i></button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button" id="add-poll-option"><i class="fas fa-plus"></i> افزودن گزینه جدید</button>
            </div>
        </div>
    </div>
    <?php
}

// =============================================
// 5. SAVE META BOX
// =============================================
add_action('save_post', 'tez_poll_save_meta');
function tez_poll_save_meta($post_id) {
    if (!isset($_POST['tez_poll_meta_nonce']) || !wp_verify_nonce($_POST['tez_poll_meta_nonce'], 'tez_poll_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['tez_poll'])) {
        $clean_data = $_POST['tez_poll'];
        
        // Sanitize all fields
        $clean_data['enabled'] = isset($clean_data['enabled']) ? 'yes' : 'no';
        $clean_data['question'] = sanitize_text_field($clean_data['question']);
        $clean_data['type'] = sanitize_text_field($clean_data['type']);
        $clean_data['position'] = sanitize_text_field($clean_data['position']);
        $clean_data['style'] = sanitize_text_field($clean_data['style']);
        
        if (isset($clean_data['options'])) {
            $clean_data['options'] = array_values($clean_data['options']);
            foreach ($clean_data['options'] as &$opt) {
                $opt['text'] = sanitize_text_field($opt['text']);
                $opt['color'] = sanitize_hex_color($opt['color']);
            }
        }
        
        update_post_meta($post_id, '_tez_poll_data', $clean_data);
    } else {
        // If checkbox unchecked
        $existing = get_post_meta($post_id, '_tez_poll_data', true);
        if ($existing) {
            $existing['enabled'] = 'no';
            update_post_meta($post_id, '_tez_poll_data', $existing);
        }
    }
}

// =============================================
// 6. SHORTCODE
// =============================================
add_shortcode('tez_poll', 'tez_poll_shortcode');
function tez_poll_shortcode($atts) {
    global $post;
    if (!$post) return '';
    
    $data = get_post_meta($post->ID, '_tez_poll_data', true);
    if (!isset($data['enabled']) || $data['enabled'] !== 'yes') return '';
    
    return tez_poll_render_html($post->ID, $data);
}

// =============================================
// 7. AUTO INSERT INTO CONTENT
// =============================================
add_filter('the_content', 'tez_poll_inject_content', 15);
function tez_poll_inject_content($content) {
    if (!is_singular('post') || !in_the_loop() || !is_main_query()) return $content;

    global $post;
    $data = get_post_meta($post->ID, '_tez_poll_data', true);
    
    if (!isset($data['enabled']) || $data['enabled'] !== 'yes') return $content;
    
    $position = isset($data['position']) ? $data['position'] : 'before_last';
    
    if ($position === 'manual') return $content;

    $poll_html = tez_poll_render_html($post->ID, $data);

    switch ($position) {
        case 'before_content':
            return $poll_html . $content;
            
        case 'after_content':
            return $content . $poll_html;
            
        case 'before_last':
        default:
            // Find the last paragraph opening tag
            $last_p_pos = strrpos($content, '<p');
            if ($last_p_pos !== false) {
                return substr_replace($content, $poll_html, $last_p_pos, 0);
            }
            return $content . $poll_html;
    }
}

// =============================================
// 8. RENDER POLL HTML
// =============================================
function tez_poll_render_html($post_id, $data) {
    if (empty($data['question']) || empty($data['options'])) return '';
    
    // Check IP
    $user_ip = tez_poll_get_user_ip();
    global $wpdb;
    $table = $wpdb->prefix . 'tez_polls';
    
    $has_voted = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table WHERE post_id = %d AND user_ip = %s", 
        $post_id, $user_ip
    ));

    // Calculate Results - Count DISTINCT IPs for total votes
    $total_votes = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(DISTINCT user_ip) FROM $table WHERE post_id = %d", 
        $post_id
    ));
    
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT option_key, COUNT(*) as count FROM $table WHERE post_id = %d GROUP BY option_key", 
        $post_id
    ), OBJECT_K);

    $style = isset($data['style']) ? $data['style'] : 'modern';
    $type = isset($data['type']) ? $data['type'] : 'single';
    $input_type = ($type === 'multiple') ? 'checkbox' : 'radio';

    ob_start();
    ?>
    <div class="tez-poll-container tez-poll-<?php echo esc_attr($style); ?> <?php echo ($has_voted) ? 'show-results' : ''; ?>" 
         id="poll-<?php echo $post_id; ?>" 
         data-id="<?php echo $post_id; ?>" 
         data-type="<?php echo esc_attr($type); ?>"
         role="region"
         aria-label="<?php echo esc_attr($data['question']); ?>"
         dir="rtl">
        
        <div class="poll-header">
            <div class="poll-icon" aria-hidden="true"><i class="fas fa-chart-pie"></i></div>
            <h3 class="poll-question"><?php echo esc_html($data['question']); ?></h3>
            <div class="poll-meta">
                <span class="total-votes-badge">
                    <i class="fas fa-users" aria-hidden="true"></i> 
                    <span class="count"><?php echo $total_votes; ?></span> رای
                </span>
            </div>
        </div>

        <div class="poll-options-area" role="group" aria-label="گزینه‌های نظرسنجی">
            <?php foreach ($data['options'] as $key => $opt): 
                if (empty($opt['text'])) continue;
                $vote_count = isset($results[$key]) ? (int) $results[$key]->count : 0;
                $percent = ($total_votes > 0) ? round(($vote_count / $total_votes) * 100) : 0;
            ?>
            
            <div class="poll-option-item" data-key="<?php echo $key; ?>" style="--option-color: <?php echo esc_attr($opt['color']); ?>">
                <!-- Voting View -->
                <label class="poll-label">
                    <input type="<?php echo $input_type; ?>" 
                           name="poll_vote_<?php echo $post_id; ?>" 
                           value="<?php echo $key; ?>"
                           aria-label="<?php echo esc_attr($opt['text']); ?>">
                    <span class="check-circle" aria-hidden="true"><i class="fas fa-check"></i></span>
                    <span class="option-text"><?php echo esc_html($opt['text']); ?></span>
                </label>

                <!-- Result View -->
                <div class="poll-result-bar" aria-hidden="true">
                    <div class="result-info">
                        <span class="result-text"><?php echo esc_html($opt['text']); ?></span>
                        <span class="result-percent"><?php echo $percent; ?>%</span>
                    </div>
                    <div class="bar-bg">
                        <div class="bar-fill" style="width: <?php echo $percent; ?>%;"></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="poll-footer">
            <button type="button" class="poll-submit-btn" aria-label="ثبت رای">
                <span class="btn-text">ثبت رای</span>
                <span class="btn-icon" aria-hidden="true"><i class="fas fa-paper-plane"></i></span>
            </button>
            <div class="poll-msg" role="alert" aria-live="polite"></div>
        </div>

    </div>
    <?php
    return ob_get_clean();
}

// =============================================
// 9. AJAX HANDLER
// =============================================
add_action('wp_ajax_tez_poll_submit', 'tez_poll_ajax_handler');
add_action('wp_ajax_nopriv_tez_poll_submit', 'tez_poll_ajax_handler');

function tez_poll_ajax_handler() {
    check_ajax_referer('tez_poll_nonce', 'nonce');
    
    $post_id = intval($_POST['post_id']);
    $votes = isset($_POST['votes']) ? array_map('sanitize_text_field', $_POST['votes']) : array();
    $user_ip = tez_poll_get_user_ip();
    
    global $wpdb;
    $table = $wpdb->prefix . 'tez_polls';

    // Check if already voted
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM $table WHERE post_id = %d AND user_ip = %s", 
        $post_id, $user_ip
    ));

    if ($exists) {
        wp_send_json_error(array('msg' => 'شما قبلاً در این نظرسنجی شرکت کرده‌اید.'));
    }

    if (empty($votes)) {
        wp_send_json_error(array('msg' => 'لطفاً حداقل یک گزینه را انتخاب کنید.'));
    }

    // Insert Votes
    foreach ($votes as $option_key) {
        $wpdb->insert($table, array(
            'post_id' => $post_id,
            'poll_id' => $post_id,
            'option_key' => $option_key,
            'user_ip' => $user_ip,
            'time' => current_time('mysql')
        ));
    }

    // Get New Stats - Count DISTINCT IPs
    $total_votes = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(DISTINCT user_ip) FROM $table WHERE post_id = %d", 
        $post_id
    ));
    
    $raw_results = $wpdb->get_results($wpdb->prepare(
        "SELECT option_key, COUNT(*) as count FROM $table WHERE post_id = %d GROUP BY option_key", 
        $post_id
    ));

    $stats = array();
    foreach ($raw_results as $row) {
        $stats[$row->option_key] = array(
            'count' => (int) $row->count,
            'percent' => ($total_votes > 0) ? round(($row->count / $total_votes) * 100) : 0
        );
    }

    wp_send_json_success(array(
        'msg' => 'رای شما با موفقیت ثبت شد!',
        'total' => $total_votes,
        'stats' => $stats
    ));
}

// =============================================
// 10. FRONTEND CSS
// =============================================
function tez_poll_get_css() {
    return '
    /* ============================================
       TEZ POLL - BASE STYLES
       ============================================ */
    
    .tez-poll-container {
        --poll-primary: var(--tez-primary, #2563eb);
        --poll-primary-dark: var(--tez-primary-dark, #1e40af);
        --poll-primary-light: var(--tez-primary-light, #3b82f6);
        --poll-primary-rgb: var(--tez-primary-rgb, 37, 99, 235);
        --poll-bg: var(--tez-bg, #ffffff);
        --poll-bg-secondary: var(--tez-bg-secondary, #f9fafb);
        --poll-bg-tertiary: var(--tez-bg-tertiary, #f3f4f6);
        --poll-text: var(--tez-text, #111827);
        --poll-text-secondary: var(--tez-text-secondary, #374151);
        --poll-text-muted: var(--tez-text-muted, #6b7280);
        --poll-border: var(--tez-border, #e5e7eb);
        --poll-shadow: var(--tez-shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
        --poll-radius: var(--tez-radius-xl, 1rem);
        --poll-transition: var(--tez-transition, 250ms cubic-bezier(0.4, 0, 0.2, 1));
        
        background: var(--poll-bg);
        border-radius: var(--poll-radius);
        box-shadow: var(--poll-shadow);
        margin: 2.5rem 0;
        overflow: hidden;
        font-family: var(--tez-font, "Vazirmatn", system-ui, sans-serif);
        border: 1px solid var(--poll-border);
        direction: rtl;
        position: relative;
    }
    
    /* Poll Header */
    .poll-header {
        background: linear-gradient(135deg, var(--poll-primary) 0%, var(--poll-primary-dark) 100%);
        padding: 1.75rem;
        color: #fff;
        text-align: center;
        position: relative;
    }
    
    .poll-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
        opacity: 0.9;
    }
    
    .poll-question {
        margin: 0;
        color: #fff;
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.5;
        font-family: inherit;
    }
    
    .poll-meta {
        margin-top: 0.75rem;
    }
    
    .total-votes-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.375rem 0.875rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    /* Poll Options */
    .poll-options-area {
        padding: 1.5rem;
    }
    
    .poll-option-item {
        margin-bottom: 0.875rem;
        position: relative;
    }
    
    .poll-option-item:last-child {
        margin-bottom: 0;
    }
    
    /* Voting State */
    .poll-label {
        display: flex;
        align-items: center;
        padding: 1rem 1.25rem;
        border: 2px solid var(--poll-border);
        border-radius: var(--tez-radius-lg, 0.75rem);
        cursor: pointer;
        transition: all var(--poll-transition);
        background: var(--poll-bg);
    }
    
    .poll-label:hover {
        border-color: var(--option-color, var(--poll-primary));
        background: var(--poll-bg-secondary);
        transform: translateX(-4px);
    }
    
    .poll-label:focus-within {
        outline: none;
        border-color: var(--option-color, var(--poll-primary));
        box-shadow: 0 0 0 3px rgba(var(--poll-primary-rgb), 0.2);
    }
    
    .poll-label input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .check-circle {
        width: 1.625rem;
        height: 1.625rem;
        min-width: 1.625rem;
        border: 2px solid var(--poll-border);
        border-radius: 50%;
        margin-left: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        transition: all var(--poll-transition);
        background: var(--poll-bg);
    }
    
    .poll-label input:checked + .check-circle {
        background: var(--option-color, var(--poll-primary));
        border-color: var(--option-color, var(--poll-primary));
    }
    
    .check-circle i {
        font-size: 0.6875rem;
        transform: scale(0);
        transition: transform 0.2s ease;
    }
    
    .poll-label input:checked + .check-circle i {
        transform: scale(1);
    }
    
    .option-text {
        font-weight: 600;
        color: var(--poll-text);
        font-size: 1rem;
        line-height: 1.5;
    }
    
    /* Results State */
    .poll-result-bar {
        display: none;
        padding: 0.75rem 0;
    }
    
    .result-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .result-text {
        color: var(--poll-text);
    }
    
    .result-percent {
        color: var(--option-color, var(--poll-primary));
        font-weight: 700;
    }
    
    .bar-bg {
        height: 0.75rem;
        background: var(--poll-bg-tertiary);
        border-radius: 9999px;
        overflow: hidden;
    }
    
    .bar-fill {
        height: 100%;
        background: var(--option-color, var(--poll-primary));
        width: 0;
        border-radius: 9999px;
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Show Results State */
    .tez-poll-container.show-results .poll-label {
        display: none;
    }
    
    .tez-poll-container.show-results .poll-result-bar {
        display: block;
    }
    
    .tez-poll-container.show-results .poll-submit-btn {
        display: none;
    }
    
    /* Poll Footer */
    .poll-footer {
        padding: 0 1.5rem 1.5rem;
        text-align: center;
    }
    
    .poll-submit-btn {
        background: linear-gradient(135deg, var(--poll-primary) 0%, var(--poll-primary-dark) 100%);
        color: #fff;
        border: none;
        padding: 0.875rem 2.5rem;
        border-radius: 9999px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--poll-transition);
        display: inline-flex;
        align-items: center;
        gap: 0.625rem;
        font-family: inherit;
        min-height: 48px;
    }
    
    .poll-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(var(--poll-primary-rgb), 0.35);
    }
    
    .poll-submit-btn:focus-visible {
        outline: none;
        box-shadow: 0 0 0 3px rgba(var(--poll-primary-rgb), 0.4), 0 8px 20px rgba(var(--poll-primary-rgb), 0.35);
    }
    
    .poll-submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .poll-msg {
        margin-top: 1rem;
        font-weight: 600;
        font-size: 0.9375rem;
        min-height: 1.5rem;
    }
    
    .poll-msg.error {
        color: #ef4444;
    }
    
    .poll-msg.success {
        color: #10b981;
    }
    
    /* ============================================
       STYLE: MODERN (Default)
       ============================================ */
    .tez-poll-modern {
        /* Default styles above */
    }
    
    /* ============================================
       STYLE: MINIMAL
       ============================================ */
    .tez-poll-minimal {
        border: none;
        box-shadow: none;
        background: transparent;
    }
    
    .tez-poll-minimal .poll-header {
        background: transparent;
        color: var(--poll-text);
        padding: 0 0 1.25rem 0;
        border-bottom: 2px solid var(--poll-primary);
    }
    
    .tez-poll-minimal .poll-question {
        color: var(--poll-text);
    }
    
    .tez-poll-minimal .total-votes-badge {
        background: var(--poll-bg-tertiary);
        color: var(--poll-text-muted);
    }
    
    .tez-poll-minimal .poll-options-area {
        padding: 1.25rem 0;
    }
    
    .tez-poll-minimal .poll-footer {
        padding: 0;
    }
    
    /* ============================================
       STYLE: GRADIENT
       ============================================ */
    .tez-poll-gradient {
        background: linear-gradient(135deg, var(--poll-primary) 0%, var(--poll-primary-dark) 100%);
        border: none;
    }
    
    .tez-poll-gradient .poll-header {
        background: transparent;
    }
    
    .tez-poll-gradient .poll-options-area {
        background: transparent;
    }
    
    .tez-poll-gradient .poll-label {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(8px);
    }
    
    .tez-poll-gradient .poll-label:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
    }
    
    .tez-poll-gradient .option-text,
    .tez-poll-gradient .result-text {
        color: #fff;
    }
    
    .tez-poll-gradient .check-circle {
        border-color: rgba(255, 255, 255, 0.5);
        background: transparent;
    }
    
    .tez-poll-gradient .poll-label input:checked + .check-circle {
        background: #fff;
        border-color: #fff;
        color: var(--poll-primary);
    }
    
    .tez-poll-gradient .result-percent {
        color: #fff;
    }
    
    .tez-poll-gradient .bar-bg {
        background: rgba(255, 255, 255, 0.2);
    }
    
    .tez-poll-gradient .bar-fill {
        background: #fff;
    }
    
    .tez-poll-gradient .poll-submit-btn {
        background: #fff;
        color: var(--poll-primary);
    }
    
    .tez-poll-gradient .poll-msg.success {
        color: #a7f3d0;
    }
    
    .tez-poll-gradient .poll-msg.error {
        color: #fecaca;
    }
    
    /* ============================================
       STYLE: GLASS
       ============================================ */
    .tez-poll-glass {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    .tez-poll-glass .poll-header {
        background: rgba(var(--poll-primary-rgb), 0.9);
    }
    
    .tez-poll-glass .poll-label {
        background: rgba(255, 255, 255, 0.5);
        border-color: rgba(255, 255, 255, 0.8);
    }
    
    .tez-poll-glass .poll-label:hover {
        background: rgba(255, 255, 255, 0.8);
    }
    
    /* ============================================
       DARK MODE
       ============================================ */
    [data-theme="dark"] .tez-poll-container {
        --poll-primary: var(--tez-primary, #3b82f6);
        --poll-primary-dark: var(--tez-primary-dark, #60a5fa);
        --poll-primary-light: var(--tez-primary-light, #2563eb);
        --poll-primary-rgb: 59, 130, 246;
        --poll-bg: var(--tez-bg, #0f172a);
        --poll-bg-secondary: var(--tez-bg-secondary, #1e293b);
        --poll-bg-tertiary: var(--tez-bg-tertiary, #334155);
        --poll-text: var(--tez-text, #f1f5f9);
        --poll-text-secondary: var(--tez-text-secondary, #e2e8f0);
        --poll-text-muted: var(--tez-text-muted, #94a3b8);
        --poll-border: var(--tez-border, #334155);
    }
    
    [data-theme="dark"] .tez-poll-minimal .poll-header {
        color: var(--poll-text);
    }
    
    [data-theme="dark"] .tez-poll-minimal .total-votes-badge {
        background: var(--poll-bg-tertiary);
        color: var(--poll-text-muted);
    }
    
    [data-theme="dark"] .tez-poll-glass {
        background: rgba(30, 41, 59, 0.8);
        border-color: rgba(71, 85, 105, 0.5);
    }
    
    [data-theme="dark"] .tez-poll-glass .poll-label {
        background: rgba(51, 65, 85, 0.5);
        border-color: rgba(71, 85, 105, 0.8);
    }
    
    [data-theme="dark"] .tez-poll-glass .poll-label:hover {
        background: rgba(51, 65, 85, 0.8);
    }
    
    /* ============================================
       SEPIA MODE
       ============================================ */
    [data-theme="sepia"] .tez-poll-container {
        --poll-primary: var(--tez-primary, #b45309);
        --poll-primary-dark: var(--tez-primary-dark, #92400e);
        --poll-primary-light: var(--tez-primary-light, #d97706);
        --poll-primary-rgb: 180, 83, 9;
        --poll-bg: var(--tez-bg, #faf6f1);
        --poll-bg-secondary: var(--tez-bg-secondary, #f5efe6);
        --poll-bg-tertiary: var(--tez-bg-tertiary, #ebe4d8);
        --poll-text: var(--tez-text, #44403c);
        --poll-text-secondary: var(--tez-text-secondary, #57534e);
        --poll-text-muted: var(--tez-text-muted, #78716c);
        --poll-border: var(--tez-border, #d6cfc4);
    }
    
    [data-theme="sepia"] .tez-poll-glass {
        background: rgba(250, 246, 241, 0.8);
        border-color: rgba(214, 207, 196, 0.5);
    }
    
    /* ============================================
       ANIMATIONS
       ============================================ */
    @keyframes tezPollFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .tez-poll-container {
        animation: tezPollFadeIn 0.5s ease-out;
    }
    
    .poll-option-item {
        animation: tezPollFadeIn 0.4s ease-out backwards;
    }
    
    .poll-option-item:nth-child(1) { animation-delay: 0.1s; }
    .poll-option-item:nth-child(2) { animation-delay: 0.15s; }
    .poll-option-item:nth-child(3) { animation-delay: 0.2s; }
    .poll-option-item:nth-child(4) { animation-delay: 0.25s; }
    .poll-option-item:nth-child(5) { animation-delay: 0.3s; }
    .poll-option-item:nth-child(6) { animation-delay: 0.35s; }
    
    /* ============================================
       REDUCED MOTION
       ============================================ */
    @media (prefers-reduced-motion: reduce) {
        .tez-poll-container,
        .poll-option-item {
            animation: none;
        }
        
        .poll-label,
        .poll-submit-btn,
        .check-circle,
        .bar-fill {
            transition: none;
        }
    }
    
    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 767px) {
        .tez-poll-container {
            margin: 1.5rem 0;
            border-radius: var(--tez-radius-lg, 0.75rem);
        }
        
        .poll-header {
            padding: 1.25rem;
        }
        
        .poll-icon {
            font-size: 1.5rem;
        }
        
        .poll-question {
            font-size: 1.125rem;
        }
        
        .poll-options-area {
            padding: 1rem;
        }
        
        .poll-label {
            padding: 0.875rem 1rem;
        }
        
        .option-text {
            font-size: 0.9375rem;
        }
        
        .poll-footer {
            padding: 0 1rem 1rem;
        }
        
        .poll-submit-btn {
            padding: 0.75rem 2rem;
            font-size: 0.9375rem;
        }
    }
    
    @media (max-width: 479px) {
        .poll-header {
            padding: 1rem;
        }
        
        .poll-question {
            font-size: 1rem;
        }
        
        .poll-label {
            padding: 0.75rem;
        }
        
        .check-circle {
            width: 1.375rem;
            height: 1.375rem;
            min-width: 1.375rem;
            margin-left: 0.75rem;
        }
        
        .option-text {
            font-size: 0.875rem;
        }
    }
    
    /* ============================================
       PRINT STYLES
       ============================================ */
    @media print {
        .tez-poll-container {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
        .poll-header {
            background: #f8f9fa !important;
            color: #111 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .poll-question {
            color: #111 !important;
        }
        
        .poll-submit-btn {
            display: none !important;
        }
    }
    ';
}

// =============================================
// 11. FRONTEND JS
// =============================================
function tez_poll_get_js() {
    return '
    jQuery(document).ready(function($) {
        
        $(".poll-submit-btn").on("click", function(e) {
            e.preventDefault();
            
            var container = $(this).closest(".tez-poll-container");
            var post_id = container.data("id");
            var type = container.data("type");
            var msg = container.find(".poll-msg");
            var btn = $(this);
            
            // Clear previous messages
            msg.removeClass("error success").text("");
            
            // Get selected votes
            var votes = [];
            container.find("input:checked").each(function() {
                votes.push($(this).val());
            });

            if (votes.length === 0) {
                msg.addClass("error").text("لطفاً یک گزینه را انتخاب کنید.");
                return;
            }

            // UI Loading
            btn.prop("disabled", true);
            btn.find(".btn-text").text("در حال ارسال...");

            $.ajax({
                url: tez_poll_vars.ajax_url,
                type: "POST",
                data: {
                    action: "tez_poll_submit",
                    nonce: tez_poll_vars.nonce,
                    post_id: post_id,
                    votes: votes
                },
                success: function(res) {
                    if (res.success) {
                        msg.removeClass("error").addClass("success").text(res.data.msg);
                        
                        // Update Stats
                        var stats = res.data.stats;
                        $.each(stats, function(key, val) {
                            var item = container.find(".poll-option-item[data-key=\"" + key + "\"]");
                            item.find(".result-percent").text(val.percent + "%");
                            // Trigger animation
                            setTimeout(function() {
                                item.find(".bar-fill").css("width", val.percent + "%");
                            }, 100);
                        });
                        
                        // Update for options with 0 votes
                        container.find(".poll-option-item").each(function() {
                            var key = $(this).data("key");
                            if (!stats[key]) {
                                $(this).find(".result-percent").text("0%");
                                $(this).find(".bar-fill").css("width", "0%");
                            }
                        });
                        
                        container.find(".total-votes-badge .count").text(res.data.total);

                        // Switch View
                        setTimeout(function() {
                            container.addClass("show-results");
                        }, 300);
                        
                    } else {
                        msg.addClass("error").text(res.data.msg);
                        btn.prop("disabled", false);
                        btn.find(".btn-text").text("ثبت رای");
                    }
                },
                error: function() {
                    msg.addClass("error").text("خطای ارتباط با سرور. لطفاً دوباره تلاش کنید.");
                    btn.prop("disabled", false);
                    btn.find(".btn-text").text("ثبت رای");
                }
            });
        });

        // Animate bars on page load if already voted
        $(".tez-poll-container.show-results").each(function() {
            var container = $(this);
            setTimeout(function() {
                container.find(".bar-fill").each(function() {
                    var width = $(this).attr("style");
                    $(this).css("width", "0");
                    setTimeout(function() {
                        $(this).attr("style", width);
                    }.bind(this), 50);
                });
            }, 200);
        });
        
        // Keyboard accessibility
        $(".poll-label").on("keypress", function(e) {
            if (e.which === 13 || e.which === 32) {
                e.preventDefault();
                $(this).find("input").click();
            }
        });
    });
    ';
}

// =============================================
// 12. ADMIN CSS
// =============================================
function tez_poll_get_admin_css() {
    return '
    .tez-poll-admin-wrapper {
        padding: 20px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 12px;
        font-family: "Vazirmatn", system-ui, -apple-system, sans-serif;
    }
    .poll-control-group {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
    }
    .poll-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
        margin-left: 12px;
    }
    .poll-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .poll-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s;
        border-radius: 34px;
    }
    .poll-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    input:checked + .poll-slider {
        background-color: #2563eb;
    }
    input:checked + .poll-slider:before {
        transform: translateX(24px);
    }
    .poll-switch-label {
        font-weight: 600;
        color: #1e293b;
    }
    .poll-body {
        margin-top: 20px;
    }
    .poll-field {
        margin-bottom: 20px;
    }
    .poll-field > label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1e293b;
        font-size: 14px;
    }
    .poll-field > label i {
        color: #2563eb;
        margin-left: 6px;
    }
    .poll-input {
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
    .poll-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .poll-cols {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    @media (max-width: 782px) {
        .poll-cols {
            grid-template-columns: 1fr;
        }
    }
    .poll-select {
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
    .poll-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .poll-option-row {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
        align-items: center;
        background: #ffffff;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }
    .poll-option-row:hover {
        border-color: #2563eb;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.1);
    }
    .poll-option-row input[type="text"] {
        flex-grow: 1;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-family: inherit;
    }
    .poll-option-row input[type="text"]:focus {
        outline: none;
        border-color: #2563eb;
    }
    .poll-option-row input[type="color"] {
        width: 44px;
        height: 38px;
        padding: 2px;
        cursor: pointer;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background: #fff;
    }
    .drag-handle {
        cursor: move;
        color: #94a3b8;
        padding: 0 8px;
        font-size: 16px;
    }
    .drag-handle:hover {
        color: #2563eb;
    }
    .remove-row {
        color: #ef4444 !important;
        border-color: #fecaca !important;
        background: #fef2f2 !important;
    }
    .remove-row:hover {
        background: #fee2e2 !important;
    }
    #add-poll-option {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #fff !important;
        padding: 8px 16px !important;
        border-radius: 8px !important;
        font-family: inherit !important;
        transition: all 0.2s ease !important;
    }
    #add-poll-option:hover {
        background: #1e40af !important;
        border-color: #1e40af !important;
    }
    #add-poll-option i {
        margin-left: 6px;
    }
    ';
}

// =============================================
// 13. ADMIN JS
// =============================================
function tez_poll_get_admin_js() {
    return '
    jQuery(document).ready(function($) {
        // Toggle Switch
        $("input[name=\"tez_poll[enabled]\"]").change(function() {
            if ($(this).is(":checked")) {
                $(".poll-body").slideDown(300);
            } else {
                $(".poll-body").slideUp(300);
            }
        });

        // Add Option
        $("#add-poll-option").click(function() {
            var count = $(".poll-option-row").length;
            var colors = ["#2563eb", "#1FA640", "#f59e0b", "#ef4444", "#8b5cf6", "#ec4899"];
            var randomColor = colors[Math.floor(Math.random() * colors.length)];
            
            var html = \'<div class="poll-option-row">\' +
                \'<span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>\' +
                \'<input type="text" name="tez_poll[options][\' + count + \'][text]" placeholder="متن گزینه..." />\' +
                \'<input type="color" name="tez_poll[options][\' + count + \'][color]" value="\' + randomColor + \'" />\' +
                \'<button type="button" class="button remove-row"><i class="fas fa-trash"></i></button>\' +
                \'</div>\';
            $("#poll-options-container").append(html);
        });

        // Remove Option
        $(document).on("click", ".remove-row", function() {
            if ($(".poll-option-row").length > 2) {
                $(this).closest(".poll-option-row").fadeOut(200, function() {
                    $(this).remove();
                });
            } else {
                alert("حداقل دو گزینه لازم است.");
            }
        });

        // Sortable
        if ($.fn.sortable) {
            $("#poll-options-container").sortable({
                handle: ".drag-handle",
                placeholder: "poll-option-placeholder",
                opacity: 0.7,
                update: function() {
                    $(".poll-option-row").each(function(index) {
                        $(this).find("input[type=\"text\"]").attr("name", "tez_poll[options][" + index + "][text]");
                        $(this).find("input[type=\"color\"]").attr("name", "tez_poll[options][" + index + "][color]");
                    });
                }
            });
        }
    });
    ';
}
