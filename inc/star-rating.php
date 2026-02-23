<?php
/**
 * Star Rating System (IP-based)
 * Font Awesome is loaded globally by core-setup.php - no need to load here.
 *
 * @package JannahChild
 * @version 4.0.0
 */

/**
 * Teznevisan IP-Based Star Rating System
 * Version: 4.0.0
 * Features: IP-Voting, Rating Distribution, Dark/Sepia Mode, RTL, Schema.org, Accessibility
 * NEW: Rating breakdown visualization with progress bars
 */

if (!defined('ABSPATH')) exit;

// =============================================
// 1. DATABASE SETUP
// =============================================
add_action('admin_init', 'tez_rating_check_db');
function tez_rating_check_db() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tez_ratings';
    $db_version = '2.0';
    $installed_ver = get_option('tez_rating_db_version');

    if ($installed_ver != $db_version) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            post_id mediumint(9) NOT NULL,
            user_ip varchar(100) NOT NULL,
            rating tinyint(1) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY post_id (post_id),
            KEY user_ip (user_ip),
            UNIQUE KEY post_ip (post_id, user_ip)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        update_option('tez_rating_db_version', $db_version);
    }
}

// =============================================
// 2. ENQUEUE ASSETS
// Font Awesome already loaded by core-setup.php
// =============================================
add_action('wp_enqueue_scripts', 'tez_rating_enqueue_assets');
add_action('admin_enqueue_scripts', 'tez_rating_admin_assets');

function tez_rating_enqueue_assets() {
    if (!is_singular('post')) return;
    
    wp_enqueue_script('jquery');
    
    // Localize script data
    wp_localize_script('jquery', 'tez_rating_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('tez_rating_nonce')
    ));
}

function tez_rating_admin_assets($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) return;
    // Font Awesome already loaded by core-setup.php
}

// =============================================
// 3. HELPER: GET USER IP (Enhanced)
// =============================================
function tez_rating_get_user_ip() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
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
// 4. NEW: GET RATING DISTRIBUTION
// =============================================
function tez_rating_get_distribution($post_id) {
    global $wpdb;
    $table = $wpdb->prefix . 'tez_ratings';
    
    $distribution = array(
        5 => 0,
        4 => 0,
        3 => 0,
        2 => 0,
        1 => 0
    );
    
    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT rating, COUNT(*) as count FROM $table WHERE post_id = %d GROUP BY rating",
        $post_id
    ));
    
    if ($results) {
        foreach ($results as $row) {
            $distribution[intval($row->rating)] = intval($row->count);
        }
    }
    
    return $distribution;
}

// =============================================
// 5. ADD META BOX
// =============================================
add_action('add_meta_boxes', 'tez_rating_add_metabox');
function tez_rating_add_metabox() {
    add_meta_box(
        'tez_rating_box',
        '<i class="fas fa-star" style="color:#f59e0b;margin-left:8px;"></i> امتیازدهی / Star Rating',
        'tez_rating_metabox_html',
        'post',
        'side',
        'default'
    );
}

// =============================================
// 6. META BOX HTML (Enhanced with Distribution)
// =============================================
function tez_rating_metabox_html($post) {
    $data = get_post_meta($post->ID, '_tez_rating_data', true);
    
    // Defaults
    $enabled = isset($data['enabled']) ? $data['enabled'] : 'yes';
    $style = isset($data['style']) ? $data['style'] : 'modern';
    $show_distribution = isset($data['show_distribution']) ? $data['show_distribution'] : 'yes';
    $heading_before = isset($data['heading_before']) ? $data['heading_before'] : 'به این مطلب امتیاز دهید:';
    $heading_after = isset($data['heading_after']) ? $data['heading_after'] : 'امتیاز شما ثبت شد!';
    
    // Get current stats
    global $wpdb;
    $table = $wpdb->prefix . 'tez_ratings';
    $stats = $wpdb->get_row($wpdb->prepare(
        "SELECT AVG(rating) as avg, COUNT(*) as count FROM $table WHERE post_id = %d",
        $post->ID
    ));
    $avg = $stats && $stats->avg ? round($stats->avg, 1) : 0;
    $count = $stats && $stats->count ? intval($stats->count) : 0;
    
    // Get distribution
    $distribution = tez_rating_get_distribution($post->ID);
    
    wp_nonce_field('tez_rating_save', 'tez_rating_nonce');
    ?>
    
    <style>
        .tez-rating-meta {
            font-family: 'Vazirmatn', system-ui, sans-serif;
        }
        .tez-rating-meta .field {
            margin-bottom: 12px;
        }
        .tez-rating-meta label {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 12px;
            color: #1e293b;
        }
        .tez-rating-meta select,
        .tez-rating-meta input[type="text"] {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 13px;
            font-family: inherit;
        }
        .tez-rating-meta select:focus,
        .tez-rating-meta input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
        }
        .tez-rating-stats {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            text-align: center;
        }
        .tez-rating-stats .stars {
            color: #f59e0b;
            font-size: 18px;
            margin-bottom: 4px;
        }
        .tez-rating-stats .info {
            font-size: 12px;
            color: #92400e;
        }
        .tez-rating-stats .avg {
            font-size: 24px;
            font-weight: 700;
            color: #b45309;
        }
        .tez-dist-preview {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .tez-dist-title {
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .tez-dist-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
            font-size: 11px;
        }
        .tez-dist-row:last-child {
            margin-bottom: 0;
        }
        .tez-dist-label {
            color: #f59e0b;
            min-width: 12px;
        }
        .tez-dist-bar {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }
        .tez-dist-fill {
            height: 100%;
            background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        .tez-dist-count {
            color: #64748b;
            min-width: 20px;
            text-align: left;
            font-weight: 600;
        }
    </style>
    
    <div class="tez-rating-meta">
        <!-- Current Stats -->
        <div class="tez-rating-stats">
            <div class="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star" style="color: <?php echo ($i <= round($avg)) ? '#f59e0b' : '#fde68a'; ?>"></i>
                <?php endfor; ?>
            </div>
            <div class="avg"><?php echo $avg; ?></div>
            <div class="info"><?php echo $count; ?> رای</div>
        </div>
        
        <!-- Distribution Preview -->
        <?php if ($count > 0): ?>
        <div class="tez-dist-preview">
            <div class="tez-dist-title">توزیع امتیازها</div>
            <?php for ($i = 5; $i >= 1; $i--): 
                $star_count = $distribution[$i];
                $percentage = $count > 0 ? round(($star_count / $count) * 100) : 0;
            ?>
            <div class="tez-dist-row">
                <div class="tez-dist-label"><?php echo $i; ?>★</div>
                <div class="tez-dist-bar">
                    <div class="tez-dist-fill" style="width: <?php echo $percentage; ?>%"></div>
                </div>
                <div class="tez-dist-count"><?php echo $star_count; ?></div>
            </div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        
        <!-- Enable/Disable -->
        <div class="field">
            <label>وضعیت / Status</label>
            <select name="tez_rating[enabled]">
                <option value="yes" <?php selected($enabled, 'yes'); ?>>✅ فعال (Enabled)</option>
                <option value="no" <?php selected($enabled, 'no'); ?>>❌ غیرفعال (Disabled)</option>
            </select>
        </div>
        
        <!-- Style -->
        <div class="field">
            <label>استایل / Style</label>
            <select name="tez_rating[style]">
                <option value="modern" <?php selected($style, 'modern'); ?>>مدرن (Modern)</option>
                <option value="minimal" <?php selected($style, 'minimal'); ?>>مینیمال (Minimal)</option>
                <option value="boxed" <?php selected($style, 'boxed'); ?>>باکسی (Boxed)</option>
                <option value="gradient" <?php selected($style, 'gradient'); ?>>گرادیان (Gradient)</option>
                <option value="detailed" <?php selected($style, 'detailed'); ?>>🆕 جزئیات کامل (Detailed)</option>
            </select>
        </div>
        
        <!-- Show Distribution -->
        <div class="field">
            <label>نمایش توزیع / Show Distribution</label>
            <select name="tez_rating[show_distribution]">
                <option value="yes" <?php selected($show_distribution, 'yes'); ?>>✅ نمایش (Show)</option>
                <option value="no" <?php selected($show_distribution, 'no'); ?>>❌ مخفی (Hide)</option>
            </select>
        </div>
        
        <!-- Heading Before -->
        <div class="field">
            <label>متن قبل از رای / Before Text</label>
            <input type="text" name="tez_rating[heading_before]" value="<?php echo esc_attr($heading_before); ?>">
        </div>
        
        <!-- Heading After -->
        <div class="field">
            <label>متن بعد از رای / After Text</label>
            <input type="text" name="tez_rating[heading_after]" value="<?php echo esc_attr($heading_after); ?>">
        </div>
    </div>
    <?php
}

// =============================================
// 7. SAVE META BOX (Enhanced)
// =============================================
add_action('save_post', 'tez_rating_save_meta');
function tez_rating_save_meta($post_id) {
    if (!isset($_POST['tez_rating_nonce']) || !wp_verify_nonce($_POST['tez_rating_nonce'], 'tez_rating_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['tez_rating'])) {
        $clean_data = array();
        $clean_data['enabled'] = sanitize_text_field($_POST['tez_rating']['enabled']);
        $clean_data['style'] = sanitize_text_field($_POST['tez_rating']['style']);
        $clean_data['show_distribution'] = sanitize_text_field($_POST['tez_rating']['show_distribution']);
        $clean_data['heading_before'] = sanitize_text_field($_POST['tez_rating']['heading_before']);
        $clean_data['heading_after'] = sanitize_text_field($_POST['tez_rating']['heading_after']);
        
        update_post_meta($post_id, '_tez_rating_data', $clean_data);
    }
}

// =============================================
// 8. SHORTCODE
// =============================================
add_shortcode('tez_rating', 'tez_rating_shortcode');
function tez_rating_shortcode($atts) {
    global $post;
    if (!$post) return '';
    
    $data = get_post_meta($post->ID, '_tez_rating_data', true);
    $enabled = isset($data['enabled']) ? $data['enabled'] : 'yes';
    
    if ($enabled === 'no') return '';
    
    return tez_rating_render_html($post->ID, $data);
}

// =============================================
// 9. AUTO INSERT INTO CONTENT
// Priority 30 - After FAQ (25)
// =============================================
add_filter('the_content', 'tez_rating_inject_content', 30);
function tez_rating_inject_content($content) {
    if (!is_singular('post') || !in_the_loop() || !is_main_query()) {
        return $content;
    }

    global $post;
    $data = get_post_meta($post->ID, '_tez_rating_data', true);
    $enabled = isset($data['enabled']) ? $data['enabled'] : 'yes';
    
    if ($enabled === 'no') {
        return $content;
    }
    
    $rating_html = tez_rating_render_html($post->ID, $data);
    
    return $content . $rating_html;
}

// =============================================
// 10. RENDER RATING HTML (Enhanced with Distribution)
// =============================================
function tez_rating_render_html($post_id, $data = null) {
    if (!$data) {
        $data = get_post_meta($post_id, '_tez_rating_data', true);
    }
    
    // Settings
    $style = isset($data['style']) ? $data['style'] : 'modern';
    $show_distribution = isset($data['show_distribution']) ? $data['show_distribution'] : 'yes';
    $heading_before = isset($data['heading_before']) ? $data['heading_before'] : 'به این مطلب امتیاز دهید:';
    $heading_after = isset($data['heading_after']) ? $data['heading_after'] : 'امتیاز شما ثبت شد!';
    
    // Check IP
    $user_ip = tez_rating_get_user_ip();
    global $wpdb;
    $table = $wpdb->prefix . 'tez_ratings';
    
    $user_vote = $wpdb->get_var($wpdb->prepare(
        "SELECT rating FROM $table WHERE post_id = %d AND user_ip = %s",
        $post_id, $user_ip
    ));
    
    // Get Stats
    $stats = $wpdb->get_row($wpdb->prepare(
        "SELECT AVG(rating) as avg, COUNT(*) as count FROM $table WHERE post_id = %d",
        $post_id
    ));
    $avg = $stats && $stats->avg ? round($stats->avg, 1) : 0;
    $count = $stats && $stats->count ? intval($stats->count) : 0;
    
    // Get Distribution
    $distribution = tez_rating_get_distribution($post_id);
    
    $has_voted = !empty($user_vote);
    $voted_class = $has_voted ? ' has-voted' : '';
    $current_heading = $has_voted ? $heading_after : $heading_before;
    
    ob_start();
    ?>
    <div class="tez-rating-container tez-rating-<?php echo esc_attr($style); ?><?php echo $voted_class; ?>" 
         id="tez-rating-<?php echo $post_id; ?>" 
         data-id="<?php echo $post_id; ?>"
         data-heading-before="<?php echo esc_attr($heading_before); ?>"
         data-heading-after="<?php echo esc_attr($heading_after); ?>"
         role="region"
         aria-label="امتیازدهی به مطلب"
         dir="rtl"
         itemscope 
         itemtype="https://schema.org/AggregateRating">
        
        <meta itemprop="worstRating" content="1">
        <meta itemprop="bestRating" content="5">
        <meta itemprop="ratingValue" content="<?php echo $avg; ?>">
        <meta itemprop="ratingCount" content="<?php echo $count; ?>">
        <meta itemprop="reviewCount" content="<?php echo $count; ?>">
        
        <div class="tez-rating-header">
            <div class="tez-rating-icon" aria-hidden="true">
                <i class="fas fa-star"></i>
            </div>
            <h4 class="tez-rating-title"><?php echo esc_html($current_heading); ?></h4>
        </div>
        
        <div class="tez-rating-stars-wrapper" role="radiogroup" aria-label="انتخاب امتیاز از 1 تا 5 ستاره">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <button type="button" 
                        class="tez-star-btn <?php echo ($has_voted && $user_vote >= $i) ? 'is-active' : ''; ?>" 
                        data-value="<?php echo $i; ?>"
                        aria-label="<?php echo $i; ?> ستاره"
                        <?php echo $has_voted ? 'disabled' : ''; ?>>
                    <i class="fas fa-star" aria-hidden="true"></i>
                </button>
            <?php endfor; ?>
        </div>
        
        <div class="tez-rating-meta">
            <span class="tez-rating-avg">
                <i class="fas fa-chart-line" aria-hidden="true"></i>
                میانگین: <strong class="avg-value"><?php echo $avg; ?></strong>
            </span>
            <span class="tez-rating-divider">|</span>
            <span class="tez-rating-count">
                <i class="fas fa-users" aria-hidden="true"></i>
                <strong class="count-value"><?php echo $count; ?></strong> رای
            </span>
        </div>
        
        <?php if ($show_distribution === 'yes' && $count > 0): ?>
        <div class="tez-rating-distribution" role="group" aria-label="توزیع امتیازها">
            <?php for ($i = 5; $i >= 1; $i--): 
                $star_count = $distribution[$i];
                $percentage = $count > 0 ? round(($star_count / $count) * 100) : 0;
            ?>
            <div class="tez-dist-item">
                <div class="tez-dist-star-label" aria-label="<?php echo $i; ?> ستاره">
                    <?php echo $i; ?> <i class="fas fa-star" aria-hidden="true"></i>
                </div>
                <div class="tez-dist-bar-wrapper" role="progressbar" 
                     aria-valuenow="<?php echo $percentage; ?>" 
                     aria-valuemin="0" 
                     aria-valuemax="100"
                     aria-label="<?php echo $percentage; ?> درصد">
                    <div class="tez-dist-bar-fill" style="width: <?php echo $percentage; ?>%" data-percentage="<?php echo $percentage; ?>"></div>
                </div>
                <div class="tez-dist-percentage"><?php echo $percentage; ?>%</div>
                <div class="tez-dist-count-value">(<?php echo $star_count; ?>)</div>
            </div>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        
        <div class="tez-rating-message" role="alert" aria-live="polite"></div>
        
    </div>
    <?php
    return ob_get_clean();
}

// =============================================
// 11. AJAX HANDLER (Enhanced Response)
// =============================================
add_action('wp_ajax_tez_submit_rating', 'tez_rating_ajax_handler');
add_action('wp_ajax_nopriv_tez_submit_rating', 'tez_rating_ajax_handler');

function tez_rating_ajax_handler() {
    check_ajax_referer('tez_rating_nonce', 'nonce');
    
    $post_id = intval($_POST['post_id']);
    $rating = intval($_POST['rating']);
    $user_ip = tez_rating_get_user_ip();
    
    // Validate rating
    if ($rating < 1 || $rating > 5) {
        wp_send_json_error(array('msg' => 'امتیاز نامعتبر است.'));
    }
    
    global $wpdb;
    $table = $wpdb->prefix . 'tez_ratings';

    // Check if already voted
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM $table WHERE post_id = %d AND user_ip = %s",
        $post_id, $user_ip
    ));

    if ($exists) {
        wp_send_json_error(array('msg' => 'شما قبلاً به این مطلب امتیاز داده‌اید.'));
    }

    // Insert rating
    $inserted = $wpdb->insert($table, array(
        'post_id' => $post_id,
        'user_ip' => $user_ip,
        'rating' => $rating,
        'created_at' => current_time('mysql')
    ), array('%d', '%s', '%d', '%s'));

    if (!$inserted) {
        wp_send_json_error(array('msg' => 'خطا در ثبت امتیاز. لطفاً دوباره تلاش کنید.'));
    }

    // Get updated stats
    $stats = $wpdb->get_row($wpdb->prepare(
        "SELECT AVG(rating) as avg, COUNT(*) as count FROM $table WHERE post_id = %d",
        $post_id
    ));
    
    // Get updated distribution
    $distribution = tez_rating_get_distribution($post_id);
    $dist_html = array();
    foreach ($distribution as $star => $star_count) {
        $percentage = $stats->count > 0 ? round(($star_count / $stats->count) * 100) : 0;
        $dist_html[$star] = array(
            'count' => $star_count,
            'percentage' => $percentage
        );
    }

    wp_send_json_success(array(
        'msg' => 'ممنون از امتیاز شما!',
        'avg' => round($stats->avg, 1),
        'count' => intval($stats->count),
        'user_rating' => $rating,
        'distribution' => $dist_html
    ));
}

// =============================================
// 12. FRONTEND CSS (Enhanced with Distribution Styles)
// =============================================
add_action('wp_head', 'tez_rating_frontend_css', 99);
function tez_rating_frontend_css() {
    if (!is_singular('post')) return;
    ?>
    <style id="tez-rating-css">
    /* ============================================
       TEZ RATING - BASE STYLES
       ============================================ */
    
    .tez-rating-container {
        --rating-primary: var(--tez-primary, #2563eb);
        --rating-primary-dark: var(--tez-primary-dark, #1e40af);
        --rating-primary-rgb: var(--tez-primary-rgb, 37, 99, 235);
        --rating-star: #f59e0b;
        --rating-star-hover: #fbbf24;
        --rating-star-inactive: #e5e7eb;
        --rating-bg: var(--tez-bg, #ffffff);
        --rating-bg-secondary: var(--tez-bg-secondary, #f9fafb);
        --rating-bg-tertiary: var(--tez-bg-tertiary, #f3f4f6);
        --rating-text: var(--tez-text, #111827);
        --rating-text-secondary: var(--tez-text-secondary, #374151);
        --rating-text-muted: var(--tez-text-muted, #6b7280);
        --rating-border: var(--tez-border, #e5e7eb);
        --rating-shadow: var(--tez-shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
        --rating-radius: var(--tez-radius-xl, 1rem);
        --rating-transition: var(--tez-transition, 250ms cubic-bezier(0.4, 0, 0.2, 1));
        
        margin: 2.5rem 0;
        padding: 2rem;
        border-radius: var(--rating-radius);
        font-family: var(--tez-font, 'Vazirmatn', system-ui, sans-serif);
        direction: rtl;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    /* Header */
    .tez-rating-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }
    
    .tez-rating-icon {
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 50%;
        color: var(--rating-star);
        font-size: 1.5rem;
    }
    
    .tez-rating-title {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--rating-text);
        font-family: inherit;
    }
    
    /* Stars Wrapper */
    .tez-rating-stars-wrapper {
        display: inline-flex;
        flex-direction: row-reverse;
        gap: 0.375rem;
        margin-bottom: 1.25rem;
    }
    
    /* Star Button */
    .tez-star-btn {
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        cursor: pointer;
        color: var(--rating-star-inactive);
        font-size: 1.75rem;
        transition: all var(--rating-transition);
        border-radius: 50%;
        padding: 0;
        -webkit-tap-highlight-color: transparent;
    }
    
    .tez-star-btn:focus-visible {
        outline: none;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.4);
    }
    
    /* Hover Effects - RTL friendly (row-reverse) */
    .tez-rating-container:not(.has-voted) .tez-star-btn:hover,
    .tez-rating-container:not(.has-voted) .tez-star-btn:hover ~ .tez-star-btn {
        color: var(--rating-star-hover);
        transform: scale(1.15);
    }
    
    .tez-rating-container:not(.has-voted) .tez-star-btn:hover {
        animation: tezStarPulse 0.4s ease;
    }
    
    /* Active State */
    .tez-star-btn.is-active {
        color: var(--rating-star);
    }
    
    /* Disabled State */
    .tez-star-btn:disabled {
        cursor: default;
    }
    
    .tez-rating-container.has-voted .tez-star-btn:not(.is-active) {
        color: var(--rating-star-inactive);
        opacity: 0.5;
    }
    
    .tez-rating-container.has-voted .tez-star-btn.is-active {
        color: var(--rating-star);
        opacity: 1;
    }
    
    /* Meta Info */
    .tez-rating-meta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        color: var(--rating-text-muted);
        margin-bottom: 0.5rem;
    }
    
    .tez-rating-meta i {
        margin-left: 0.375rem;
        font-size: 0.75rem;
    }
    
    .tez-rating-meta strong {
        color: var(--rating-text);
        font-weight: 700;
    }
    
    .tez-rating-divider {
        color: var(--rating-border);
    }
    
    /* ============================================
       NEW: DISTRIBUTION STYLES
       ============================================ */
    .tez-rating-distribution {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--rating-border);
    }
    
    .tez-dist-item {
        display: grid;
        grid-template-columns: 50px 1fr 60px 50px;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
    }
    
    .tez-dist-item:last-child {
        margin-bottom: 0;
    }
    
    .tez-dist-star-label {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.375rem;
        color: var(--rating-text);
        font-weight: 600;
    }
    
    .tez-dist-star-label i {
        color: var(--rating-star);
        font-size: 0.75rem;
    }
    
    .tez-dist-bar-wrapper {
        height: 10px;
        background: var(--rating-bg-tertiary);
        border-radius: 5px;
        overflow: hidden;
        position: relative;
    }
    
    .tez-dist-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--rating-star) 0%, #fbbf24 100%);
        border-radius: 5px;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .tez-dist-bar-fill:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%);
        animation: tezDistShine 2s infinite;
    }
    
    .tez-dist-percentage {
        text-align: center;
        color: var(--rating-text-secondary);
        font-weight: 600;
    }
    
    .tez-dist-count-value {
        text-align: left;
        color: var(--rating-text-muted);
        font-size: 0.8125rem;
    }
    
    /* Message */
    .tez-rating-message {
        font-size: 0.9375rem;
        font-weight: 600;
        min-height: 1.5rem;
        margin-top: 0.5rem;
    }
    
    .tez-rating-message.success {
        color: #10b981;
    }
    
    .tez-rating-message.error {
        color: #ef4444;
    }
    
    /* ============================================
       STYLE: MODERN (Default)
       ============================================ */
    .tez-rating-modern {
        background: linear-gradient(135deg, var(--rating-bg-secondary) 0%, var(--rating-bg-tertiary) 100%);
        border: 1px solid var(--rating-border);
        box-shadow: var(--rating-shadow);
    }
    
    .tez-rating-modern:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--rating-star) 0%, #fbbf24 50%, #fcd34d 100%);
    }
    
    /* ============================================
       STYLE: MINIMAL
       ============================================ */
    .tez-rating-minimal {
        background: transparent;
        border: none;
        box-shadow: none;
        padding: 1.5rem 0;
        border-top: 1px solid var(--rating-border);
        border-bottom: 1px solid var(--rating-border);
        border-radius: 0;
    }
    
    .tez-rating-minimal .tez-rating-icon {
        display: none;
    }
    
    .tez-rating-minimal .tez-rating-header {
        margin-bottom: 1rem;
    }
    
    /* ============================================
       STYLE: BOXED
       ============================================ */
    .tez-rating-boxed {
        background: var(--rating-bg);
        border: 2px solid var(--rating-star);
    }
    
    .tez-rating-boxed .tez-rating-icon {
        background: var(--rating-star);
        color: #fff;
    }
    
    /* ============================================
       STYLE: GRADIENT
       ============================================ */
    .tez-rating-gradient {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #fcd34d 100%);
        border: none;
    }
    
    .tez-rating-gradient .tez-rating-icon {
        background: #fff;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    .tez-rating-gradient .tez-rating-title {
        color: #92400e;
    }
    
    .tez-rating-gradient .tez-rating-meta {
        color: #b45309;
    }
    
    .tez-rating-gradient .tez-rating-meta strong {
        color: #92400e;
    }
    
    .tez-rating-gradient .tez-rating-divider {
        color: #d97706;
    }
    
    .tez-rating-gradient .tez-star-btn {
        color: #fcd34d;
    }
    
    .tez-rating-gradient .tez-star-btn.is-active,
    .tez-rating-gradient:not(.has-voted) .tez-star-btn:hover,
    .tez-rating-gradient:not(.has-voted) .tez-star-btn:hover ~ .tez-star-btn {
        color: #b45309;
    }
    
    /* ============================================
       NEW STYLE: DETAILED
       ============================================ */
    .tez-rating-detailed {
        background: var(--rating-bg);
        border: 2px solid var(--rating-border);
        box-shadow: var(--rating-shadow);
        padding: 2.5rem;
    }
    
    .tez-rating-detailed .tez-rating-icon {
        width: 4rem;
        height: 4rem;
        font-size: 1.75rem;
    }
    
    .tez-rating-detailed .tez-rating-distribution {
        background: var(--rating-bg-secondary);
        padding: 1.5rem;
        border-radius: var(--tez-radius-lg, 0.75rem);
        margin-top: 1.5rem;
        border: none;
    }
    
    /* ============================================
       DARK MODE
       ============================================ */
    [data-theme="dark"] .tez-rating-container {
        --rating-primary: var(--tez-primary, #3b82f6);
        --rating-primary-dark: var(--tez-primary-dark, #60a5fa);
        --rating-primary-rgb: 59, 130, 246;
        --rating-star-inactive: #475569;
        --rating-bg: var(--tez-bg, #0f172a);
        --rating-bg-secondary: var(--tez-bg-secondary, #1e293b);
        --rating-bg-tertiary: var(--tez-bg-tertiary, #334155);
        --rating-text: var(--tez-text, #f1f5f9);
        --rating-text-secondary: var(--tez-text-secondary, #e2e8f0);
        --rating-text-muted: var(--tez-text-muted, #94a3b8);
        --rating-border: var(--tez-border, #334155);
    }
    
    [data-theme="dark"] .tez-rating-modern {
        background: linear-gradient(135deg, var(--rating-bg-secondary) 0%, var(--rating-bg-tertiary) 100%);
    }
    
    [data-theme="dark"] .tez-rating-boxed {
        background: var(--rating-bg);
    }
    
    [data-theme="dark"] .tez-rating-gradient {
        background: linear-gradient(135deg, #78350f 0%, #92400e 50%, #b45309 100%);
    }
    
    [data-theme="dark"] .tez-rating-gradient .tez-rating-icon {
        background: rgba(255, 255, 255, 0.1);
        color: #fbbf24;
    }
    
    [data-theme="dark"] .tez-rating-gradient .tez-rating-title,
    [data-theme="dark"] .tez-rating-gradient .tez-rating-meta,
    [data-theme="dark"] .tez-rating-gradient .tez-rating-meta strong {
        color: #fef3c7;
    }
    
    [data-theme="dark"] .tez-rating-gradient .tez-star-btn {
        color: #b45309;
    }
    
    [data-theme="dark"] .tez-rating-gradient .tez-star-btn.is-active,
    [data-theme="dark"] .tez-rating-gradient:not(.has-voted) .tez-star-btn:hover,
    [data-theme="dark"] .tez-rating-gradient:not(.has-voted) .tez-star-btn:hover ~ .tez-star-btn {
        color: #fbbf24;
    }
    
    /* ============================================
       SEPIA MODE
       ============================================ */
    [data-theme="sepia"] .tez-rating-container {
        --rating-primary: var(--tez-primary, #b45309);
        --rating-primary-dark: var(--tez-primary-dark, #92400e);
        --rating-primary-rgb: 180, 83, 9;
        --rating-star-inactive: #d6cfc4;
        --rating-bg: var(--tez-bg, #faf6f1);
        --rating-bg-secondary: var(--tez-bg-secondary, #f5efe6);
        --rating-bg-tertiary: var(--tez-bg-tertiary, #ebe4d8);
        --rating-text: var(--tez-text, #44403c);
        --rating-text-secondary: var(--tez-text-secondary, #57534e);
        --rating-text-muted: var(--tez-text-muted, #78716c);
        --rating-border: var(--tez-border, #d6cfc4);
    }
    
    [data-theme="sepia"] .tez-rating-modern {
        background: linear-gradient(135deg, var(--rating-bg-secondary) 0%, var(--rating-bg-tertiary) 100%);
    }
    
    [data-theme="sepia"] .tez-rating-gradient {
        background: linear-gradient(135deg, #fef3c7 0%, #f5efe6 100%);
    }
    
    /* ============================================
       ANIMATIONS
       ============================================ */
    @keyframes tezStarPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1.15); }
    }
    
    @keyframes tezRatingFadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes tezStarBounce {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.2); }
        50% { transform: scale(0.9); }
        75% { transform: scale(1.1); }
    }
    
    @keyframes tezDistShine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }
    
    @keyframes tezDistBarGrow {
        from { width: 0; }
    }
    
    .tez-rating-container {
        animation: tezRatingFadeIn 0.5s ease-out;
    }
    
    .tez-dist-item {
        animation: tezRatingFadeIn 0.4s ease-out backwards;
    }
    
    .tez-dist-item:nth-child(1) { animation-delay: 0.1s; }
    .tez-dist-item:nth-child(2) { animation-delay: 0.15s; }
    .tez-dist-item:nth-child(3) { animation-delay: 0.2s; }
    .tez-dist-item:nth-child(4) { animation-delay: 0.25s; }
    .tez-dist-item:nth-child(5) { animation-delay: 0.3s; }
    
    .tez-dist-bar-fill {
        animation: tezDistBarGrow 0.8s ease-out;
    }
    
    /* Success animation for voted stars */
    .tez-rating-container.just-voted .tez-star-btn.is-active {
        animation: tezStarBounce 0.5s ease;
    }
    
    /* ============================================
       REDUCED MOTION
       ============================================ */
    @media (prefers-reduced-motion: reduce) {
        .tez-rating-container,
        .tez-dist-item {
            animation: none;
        }
        
        .tez-star-btn,
        .tez-dist-bar-fill,
        .tez-rating-container.just-voted .tez-star-btn.is-active {
            animation: none;
            transition: none;
        }
        
        .tez-rating-container:not(.has-voted) .tez-star-btn:hover {
            transform: none;
        }
    }
    
    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 767px) {
        .tez-rating-container {
            margin: 1.5rem 0;
            padding: 1.5rem;
            border-radius: var(--tez-radius-lg, 0.75rem);
        }
        
        .tez-rating-icon {
            width: 3rem;
            height: 3rem;
            font-size: 1.25rem;
        }
        
        .tez-rating-title {
            font-size: 1rem;
        }
        
        .tez-star-btn {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1.5rem;
        }
        
        .tez-rating-meta {
            font-size: 0.8125rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        
        .tez-dist-item {
            grid-template-columns: 45px 1fr 50px;
            gap: 0.5rem;
            font-size: 0.8125rem;
        }
        
        .tez-dist-count-value {
            display: none;
        }
    }
    
    @media (max-width: 479px) {
        .tez-rating-container {
            padding: 1.25rem;
        }
        
        .tez-rating-stars-wrapper {
            gap: 0.25rem;
        }
        
        .tez-star-btn {
            width: 2.25rem;
            height: 2.25rem;
            font-size: 1.25rem;
        }
        
        .tez-rating-title {
            font-size: 0.9375rem;
        }
        
        .tez-dist-item {
            grid-template-columns: 40px 1fr;
            gap: 0.5rem;
        }
        
        .tez-dist-percentage {
            display: none;
        }
    }
    
    /* ============================================
       PRINT STYLES
       ============================================ */
    @media print {
        .tez-rating-container {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
        .tez-star-btn {
            color: #f59e0b !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .tez-star-btn:not(.is-active) {
            color: #ddd !important;
        }
        
        .tez-dist-bar-fill:after {
            display: none;
        }
    }
    </style>
    <?php
}

// =============================================
// 13. FRONTEND JS (Enhanced with Distribution Update)
// =============================================
add_action('wp_footer', 'tez_rating_frontend_js', 99);
function tez_rating_frontend_js() {
    if (!is_singular('post')) return;
    ?>
    <script id="tez-rating-js">
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            var ratingContainers = document.querySelectorAll('.tez-rating-container:not(.has-voted)');
            
            ratingContainers.forEach(function(container) {
                var starBtns = container.querySelectorAll('.tez-star-btn');
                var messageEl = container.querySelector('.tez-rating-message');
                var titleEl = container.querySelector('.tez-rating-title');
                var avgEl = container.querySelector('.avg-value');
                var countEl = container.querySelector('.count-value');
                var distributionEl = container.querySelector('.tez-rating-distribution');
                var postId = container.dataset.id;
                var headingAfter = container.dataset.headingAfter;
                
                starBtns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        if (container.classList.contains('has-voted')) return;
                        
                        var value = parseInt(this.dataset.value);
                        
                        // Disable all buttons immediately
                        starBtns.forEach(function(b) {
                            b.disabled = true;
                        });
                        
                        // Visual update
                        starBtns.forEach(function(b) {
                            var btnValue = parseInt(b.dataset.value);
                            if (btnValue <= value) {
                                b.classList.add('is-active');
                            } else {
                                b.classList.remove('is-active');
                            }
                        });
                        
                        // AJAX request
                        var formData = new FormData();
                        formData.append('action', 'tez_submit_rating');
                        formData.append('nonce', tez_rating_vars.nonce);
                        formData.append('post_id', postId);
                        formData.append('rating', value);
                        
                        fetch(tez_rating_vars.ajax_url, {
                            method: 'POST',
                            body: formData,
                            credentials: 'same-origin'
                        })
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(data) {
                            if (data.success) {
                                container.classList.add('has-voted', 'just-voted');
                                messageEl.textContent = data.data.msg;
                                messageEl.classList.add('success');
                                titleEl.textContent = headingAfter;
                                avgEl.textContent = data.data.avg;
                                countEl.textContent = data.data.count;
                                
                                // Update distribution if exists
                                if (distributionEl && data.data.distribution) {
                                    for (var star = 5; star >= 1; star--) {
                                        var distData = data.data.distribution[star];
                                        if (distData) {
                                            var distItem = distributionEl.querySelector('.tez-dist-item:nth-child(' + (6 - star) + ')');
                                            if (distItem) {
                                                var barFill = distItem.querySelector('.tez-dist-bar-fill');
                                                var percentage = distItem.querySelector('.tez-dist-percentage');
                                                var countValue = distItem.querySelector('.tez-dist-count-value');
                                                
                                                if (barFill) {
                                                    barFill.style.width = distData.percentage + '%';
                                                    barFill.setAttribute('data-percentage', distData.percentage);
                                                }
                                                if (percentage) percentage.textContent = distData.percentage + '%';
                                                if (countValue) countValue.textContent = '(' + distData.count + ')';
                                            }
                                        }
                                    }
                                }
                                
                                // Remove animation class after animation completes
                                setTimeout(function() {
                                    container.classList.remove('just-voted');
                                }, 600);
                            } else {
                                messageEl.textContent = data.data.msg;
                                messageEl.classList.add('error');
                                container.classList.add('has-voted');
                            }
                        })
                        .catch(function(error) {
                            messageEl.textContent = 'خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید.';
                            messageEl.classList.add('error');
                            
                            // Re-enable buttons on error
                            starBtns.forEach(function(b) {
                                b.disabled = false;
                            });
                        });
                    });
                    
                    // Keyboard support
                    btn.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.click();
                        }
                    });
                });
            });
        });
    })();
    </script>
    <?php
}

// =============================================
// 14. ADD SCHEMA.ORG TO HEAD (Enhanced)
// =============================================
add_action('wp_head', 'tez_rating_schema_head', 5);
function tez_rating_schema_head() {
    if (!is_singular('post')) return;
    
    global $post, $wpdb;
    $table = $wpdb->prefix . 'tez_ratings';
    
    $data = get_post_meta($post->ID, '_tez_rating_data', true);
    $enabled = isset($data['enabled']) ? $data['enabled'] : 'yes';
    
    if ($enabled === 'no') return;
    
    $stats = $wpdb->get_row($wpdb->prepare(
        "SELECT AVG(rating) as avg, COUNT(*) as count FROM $table WHERE post_id = %d",
        $post->ID
    ));
    
    if (!$stats || !$stats->count) return;
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'name' => get_the_title($post->ID),
        'aggregateRating' => array(
            '@type' => 'AggregateRating',
            'ratingValue' => round($stats->avg, 1),
            'bestRating' => '5',
            'worstRating' => '1',
            'ratingCount' => intval($stats->count),
            'reviewCount' => intval($stats->count)
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}
