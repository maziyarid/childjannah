/**
 * Teznevisan Homepage Template
 * Version: 3.0.0
 * 
 * This code ONLY provides the homepage render function and meta boxes.
 * Does NOT redeclare the Tez_Page_Templates class.
 */

if (!defined('ABSPATH')) exit;

// =============================================
// REGISTER HOMEPAGE META FIELDS
// =============================================
add_action('init', function() {
    $fields = [
        '_tez_home_hero_title',
        '_tez_home_hero_subtitle',
        '_tez_home_hero_desc',
        '_tez_home_hero_cta_text',
        '_tez_home_hero_cta_link',
        '_tez_home_hero_cta2_text',
        '_tez_home_hero_cta2_link',
        '_tez_home_hero_image',
        '_tez_home_hero_badges',
        '_tez_home_stats',
        '_tez_home_services_title',
        '_tez_home_services',
        '_tez_home_why_title',
        '_tez_home_why_items',
        '_tez_home_process_title',
        '_tez_home_process_steps',
        '_tez_home_testimonials_title',
        '_tez_home_testimonials',
        '_tez_home_faq_title',
        '_tez_home_faq',
        '_tez_home_cta_title',
        '_tez_home_cta_text',
        '_tez_home_cta_link',
        '_tez_home_phone',
        '_tez_home_email',
        '_tez_home_social',
    ];
    
    foreach ($fields as $field) {
        register_post_meta('page', $field, [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'auth_callback' => function() { return current_user_can('edit_posts'); },
        ]);
    }
});

// =============================================
// ADD HOMEPAGE META BOXES
// =============================================
add_action('add_meta_boxes', function() {
    add_meta_box('tez_home_hero', 'هیرو صفحه اصلی', 'tez_home_hero_metabox', 'page', 'normal', 'high');
    add_meta_box('tez_home_stats', 'آمار و ارقام', 'tez_home_stats_metabox', 'page', 'normal', 'default');
    add_meta_box('tez_home_services', 'بخش خدمات', 'tez_home_services_metabox', 'page', 'normal', 'default');
    add_meta_box('tez_home_why', 'چرا ما', 'tez_home_why_metabox', 'page', 'normal', 'default');
    add_meta_box('tez_home_process', 'مراحل کار', 'tez_home_process_metabox', 'page', 'normal', 'default');
    add_meta_box('tez_home_testimonials', 'نظرات مشتریان', 'tez_home_testimonials_metabox', 'page', 'normal', 'default');
    add_meta_box('tez_home_faq', 'سوالات متداول', 'tez_home_faq_metabox', 'page', 'normal', 'default');
    add_meta_box('tez_home_cta', 'CTA و تماس', 'tez_home_cta_metabox', 'page', 'normal', 'default');
});

// =============================================
// META BOX CALLBACKS
// =============================================
function tez_home_hero_metabox($post) {
    wp_nonce_field('tez_home_save_meta', 'tez_home_nonce');
    $title = get_post_meta($post->ID, '_tez_home_hero_title', true);
    $subtitle = get_post_meta($post->ID, '_tez_home_hero_subtitle', true);
    $desc = get_post_meta($post->ID, '_tez_home_hero_desc', true);
    $cta_text = get_post_meta($post->ID, '_tez_home_hero_cta_text', true);
    $cta_link = get_post_meta($post->ID, '_tez_home_hero_cta_link', true);
    $cta2_text = get_post_meta($post->ID, '_tez_home_hero_cta2_text', true);
    $cta2_link = get_post_meta($post->ID, '_tez_home_hero_cta2_link', true);
    $image = get_post_meta($post->ID, '_tez_home_hero_image', true);
    $badges = get_post_meta($post->ID, '_tez_home_hero_badges', true);
    ?>
    <table class="form-table">
        <tr><th>عنوان اصلی</th><td><input type="text" name="_tez_home_hero_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="خدمات تخصصی پایان‌نامه"></td></tr>
        <tr><th>زیرعنوان برجسته</th><td><input type="text" name="_tez_home_hero_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="large-text" placeholder="با کیفیت بالا و تضمینی"></td></tr>
        <tr><th>توضیحات</th><td><textarea name="_tez_home_hero_desc" rows="3" class="large-text"><?php echo esc_textarea($desc); ?></textarea></td></tr>
        <tr><th>دکمه اصلی (متن)</th><td><input type="text" name="_tez_home_hero_cta_text" value="<?php echo esc_attr($cta_text); ?>" class="regular-text" placeholder="ثبت سفارش"></td></tr>
        <tr><th>دکمه اصلی (لینک)</th><td><input type="text" name="_tez_home_hero_cta_link" value="<?php echo esc_attr($cta_link); ?>" class="large-text" placeholder="#order"></td></tr>
        <tr><th>دکمه دوم (متن)</th><td><input type="text" name="_tez_home_hero_cta2_text" value="<?php echo esc_attr($cta2_text); ?>" class="regular-text" placeholder="نمونه کارها"></td></tr>
        <tr><th>دکمه دوم (لینک)</th><td><input type="text" name="_tez_home_hero_cta2_link" value="<?php echo esc_attr($cta2_link); ?>" class="large-text"></td></tr>
        <tr><th>تصویر هیرو</th><td><input type="text" name="_tez_home_hero_image" value="<?php echo esc_url($image); ?>" class="large-text" placeholder="URL تصویر"></td></tr>
        <tr><th>نشان‌های اعتماد</th><td>
            <textarea name="_tez_home_hero_badges" rows="3" class="large-text"><?php echo esc_textarea($badges); ?></textarea>
            <p class="description">هر خط: آیکون|متن (مثال: fa-solid fa-shield-check|تضمین کیفیت)</p>
        </td></tr>
    </table>
    <?php
}

function tez_home_stats_metabox($post) {
    $stats = get_post_meta($post->ID, '_tez_home_stats', true);
    ?>
    <p class="description">هر خط: آیکون|عدد|پسوند|عنوان<br>مثال: fa-solid fa-users|2500|+|مشتری راضی</p>
    <textarea name="_tez_home_stats" rows="5" class="large-text"><?php echo esc_textarea($stats); ?></textarea>
    <?php
}

function tez_home_services_metabox($post) {
    $title = get_post_meta($post->ID, '_tez_home_services_title', true);
    $services = get_post_meta($post->ID, '_tez_home_services', true);
    ?>
    <table class="form-table">
        <tr><th>عنوان بخش</th><td><input type="text" name="_tez_home_services_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="خدمات ما"></td></tr>
        <tr><th>خدمات</th><td>
            <textarea name="_tez_home_services" rows="8" class="large-text"><?php echo esc_textarea($services); ?></textarea>
            <p class="description">هر خط: آیکون|عنوان|توضیح|لینک|قیمت<br>مثال: fa-solid fa-graduation-cap|پایان‌نامه|انجام پایان‌نامه|/thesis|از ۵۰۰ هزار</p>
        </td></tr>
    </table>
    <?php
}

function tez_home_why_metabox($post) {
    $title = get_post_meta($post->ID, '_tez_home_why_title', true);
    $items = get_post_meta($post->ID, '_tez_home_why_items', true);
    ?>
    <table class="form-table">
        <tr><th>عنوان</th><td><input type="text" name="_tez_home_why_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="چرا ما را انتخاب کنید؟"></td></tr>
        <tr><th>دلایل</th><td>
            <textarea name="_tez_home_why_items" rows="6" class="large-text"><?php echo esc_textarea($items); ?></textarea>
            <p class="description">هر خط: آیکون|عنوان|توضیح</p>
        </td></tr>
    </table>
    <?php
}

function tez_home_process_metabox($post) {
    $title = get_post_meta($post->ID, '_tez_home_process_title', true);
    $steps = get_post_meta($post->ID, '_tez_home_process_steps', true);
    ?>
    <table class="form-table">
        <tr><th>عنوان</th><td><input type="text" name="_tez_home_process_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="مراحل همکاری"></td></tr>
        <tr><th>مراحل</th><td>
            <textarea name="_tez_home_process_steps" rows="5" class="large-text"><?php echo esc_textarea($steps); ?></textarea>
            <p class="description">هر خط: آیکون|عنوان|توضیح</p>
        </td></tr>
    </table>
    <?php
}

function tez_home_testimonials_metabox($post) {
    $title = get_post_meta($post->ID, '_tez_home_testimonials_title', true);
    $testimonials = get_post_meta($post->ID, '_tez_home_testimonials', true);
    ?>
    <table class="form-table">
        <tr><th>عنوان</th><td><input type="text" name="_tez_home_testimonials_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="نظرات مشتریان"></td></tr>
        <tr><th>نظرات</th><td>
            <textarea name="_tez_home_testimonials" rows="6" class="large-text"><?php echo esc_textarea($testimonials); ?></textarea>
            <p class="description">هر خط: نام|سمت|متن|امتیاز(1-5)</p>
        </td></tr>
    </table>
    <?php
}

function tez_home_faq_metabox($post) {
    $title = get_post_meta($post->ID, '_tez_home_faq_title', true);
    $faq = get_post_meta($post->ID, '_tez_home_faq', true);
    ?>
    <table class="form-table">
        <tr><th>عنوان</th><td><input type="text" name="_tez_home_faq_title" value="<?php echo esc_attr($title); ?>" class="large-text" placeholder="سوالات متداول"></td></tr>
        <tr><th>سوالات</th><td>
            <textarea name="_tez_home_faq" rows="8" class="large-text"><?php echo esc_textarea($faq); ?></textarea>
            <p class="description">هر خط: سوال|پاسخ</p>
        </td></tr>
    </table>
    <?php
}

function tez_home_cta_metabox($post) {
    $cta_title = get_post_meta($post->ID, '_tez_home_cta_title', true);
    $cta_text = get_post_meta($post->ID, '_tez_home_cta_text', true);
    $cta_link = get_post_meta($post->ID, '_tez_home_cta_link', true);
    $phone = get_post_meta($post->ID, '_tez_home_phone', true);
    $email = get_post_meta($post->ID, '_tez_home_email', true);
    $social = get_post_meta($post->ID, '_tez_home_social', true);
    ?>
    <table class="form-table">
        <tr><th>عنوان CTA</th><td><input type="text" name="_tez_home_cta_title" value="<?php echo esc_attr($cta_title); ?>" class="large-text" placeholder="آماده شروع هستید؟"></td></tr>
        <tr><th>متن دکمه</th><td><input type="text" name="_tez_home_cta_text" value="<?php echo esc_attr($cta_text); ?>" class="regular-text" placeholder="شروع کنید"></td></tr>
        <tr><th>لینک دکمه</th><td><input type="text" name="_tez_home_cta_link" value="<?php echo esc_attr($cta_link); ?>" class="large-text" placeholder="#contact"></td></tr>
        <tr><th>تلفن</th><td><input type="text" name="_tez_home_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" dir="ltr" placeholder="09123456789"></td></tr>
        <tr><th>ایمیل</th><td><input type="email" name="_tez_home_email" value="<?php echo esc_attr($email); ?>" class="regular-text" dir="ltr"></td></tr>
        <tr><th>شبکه‌های اجتماعی</th><td>
            <textarea name="_tez_home_social" rows="3" class="large-text"><?php echo esc_textarea($social); ?></textarea>
            <p class="description">هر خط: نوع|لینک (مثال: instagram|https://instagram.com/...)</p>
        </td></tr>
    </table>
    <?php
}

// =============================================
// SAVE META DATA
// =============================================
add_action('save_post', function($post_id) {
    if (!isset($_POST['tez_home_nonce']) || !wp_verify_nonce($_POST['tez_home_nonce'], 'tez_home_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    $fields = [
        '_tez_home_hero_title', '_tez_home_hero_subtitle', '_tez_home_hero_desc',
        '_tez_home_hero_cta_text', '_tez_home_hero_cta_link', '_tez_home_hero_cta2_text',
        '_tez_home_hero_cta2_link', '_tez_home_hero_image', '_tez_home_hero_badges',
        '_tez_home_stats', '_tez_home_services_title', '_tez_home_services',
        '_tez_home_why_title', '_tez_home_why_items', '_tez_home_process_title',
        '_tez_home_process_steps', '_tez_home_testimonials_title', '_tez_home_testimonials',
        '_tez_home_faq_title', '_tez_home_faq', '_tez_home_cta_title', '_tez_home_cta_text',
        '_tez_home_cta_link', '_tez_home_phone', '_tez_home_email', '_tez_home_social',
    ];
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            if (strpos($field, '_image') !== false || strpos($field, '_link') !== false) {
                $value = esc_url_raw($value);
            } elseif ($field === '_tez_home_email') {
                $value = sanitize_email($value);
            } else {
                $value = sanitize_textarea_field($value);
            }
            update_post_meta($post_id, $field, $value);
        } else {
            delete_post_meta($post_id, $field);
        }
    }
});

// =============================================
// HELPER FUNCTIONS (Only if not already defined)
// =============================================
if (!function_exists('tez_home_parse_lines')) {
    function tez_home_parse_lines($data, $min_parts = 2) {
        $items = [];
        if (empty($data)) return $items;
        foreach (explode("\n", trim($data)) as $line) {
            $parts = explode('|', trim($line));
            if (count($parts) >= $min_parts) {
                $items[] = array_map('trim', $parts);
            }
        }
        return $items;
    }
}

if (!function_exists('tez_home_render_stars')) {
    function tez_home_render_stars($rating) {
        $output = '';
        $rating = floatval($rating);
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= floor($rating)) $output .= '<i class="fa-solid fa-star"></i>';
            elseif ($i - 0.5 <= $rating) $output .= '<i class="fa-solid fa-star-half-stroke"></i>';
            else $output .= '<i class="fa-regular fa-star"></i>';
        }
        return $output;
    }
}

if (!function_exists('tez_home_to_persian')) {
    function tez_home_to_persian($num) {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        return str_replace($english, $persian, $num);
    }
}

// =============================================
// MAIN RENDER FUNCTION
// =============================================
if (!function_exists('tez_render_homepage')) {
    function tez_render_homepage($content = '') {
        $id = get_the_ID();
        
        // Get all meta
        $meta = [
            'hero_title' => get_post_meta($id, '_tez_home_hero_title', true) ?: get_the_title(),
            'hero_subtitle' => get_post_meta($id, '_tez_home_hero_subtitle', true),
            'hero_desc' => get_post_meta($id, '_tez_home_hero_desc', true),
            'hero_cta_text' => get_post_meta($id, '_tez_home_hero_cta_text', true) ?: 'ثبت سفارش',
            'hero_cta_link' => get_post_meta($id, '_tez_home_hero_cta_link', true) ?: '#contact',
            'hero_cta2_text' => get_post_meta($id, '_tez_home_hero_cta2_text', true),
            'hero_cta2_link' => get_post_meta($id, '_tez_home_hero_cta2_link', true),
            'hero_image' => get_post_meta($id, '_tez_home_hero_image', true),
            'hero_badges' => get_post_meta($id, '_tez_home_hero_badges', true),
            'stats' => get_post_meta($id, '_tez_home_stats', true),
            'services_title' => get_post_meta($id, '_tez_home_services_title', true) ?: 'خدمات ما',
            'services' => get_post_meta($id, '_tez_home_services', true),
            'why_title' => get_post_meta($id, '_tez_home_why_title', true) ?: 'چرا ما را انتخاب کنید؟',
            'why_items' => get_post_meta($id, '_tez_home_why_items', true),
            'process_title' => get_post_meta($id, '_tez_home_process_title', true) ?: 'مراحل همکاری',
            'process_steps' => get_post_meta($id, '_tez_home_process_steps', true),
            'testimonials_title' => get_post_meta($id, '_tez_home_testimonials_title', true) ?: 'نظرات مشتریان',
            'testimonials' => get_post_meta($id, '_tez_home_testimonials', true),
            'faq_title' => get_post_meta($id, '_tez_home_faq_title', true) ?: 'سوالات متداول',
            'faq' => get_post_meta($id, '_tez_home_faq', true),
            'cta_title' => get_post_meta($id, '_tez_home_cta_title', true) ?: 'آماده شروع هستید؟',
            'cta_text' => get_post_meta($id, '_tez_home_cta_text', true) ?: 'شروع کنید',
            'cta_link' => get_post_meta($id, '_tez_home_cta_link', true) ?: '#contact',
            'phone' => get_post_meta($id, '_tez_home_phone', true),
            'email' => get_post_meta($id, '_tez_home_email', true),
            'social' => get_post_meta($id, '_tez_home_social', true),
        ];
        
        // Output styles
        echo tez_home_get_styles();
        ?>
        
        <div class="tez-home">
            <!-- Hero Section -->
            <section class="th-hero" id="hero">
                <div class="th-hero-bg">
                    <div class="th-hero-glow th-hero-glow-1"></div>
                    <div class="th-hero-glow th-hero-glow-2"></div>
                    <div class="th-hero-grid"></div>
                </div>
                <div class="th-hero-content">
                    <div class="th-container">
                        <div class="th-hero-wrapper">
                            <div class="th-hero-text">
                                <div class="th-hero-badge">
                                    <span class="th-hero-badge-icon"><i class="fa-solid fa-star"></i></span>
                                    <span class="th-hero-badge-text">خدمات تخصصی دانشگاهی</span>
                                    <span class="th-hero-badge-tag">جدید</span>
                                </div>
                                <h1 class="th-hero-title">
                                    <?php echo esc_html($meta['hero_title']); ?>
                                    <?php if ($meta['hero_subtitle']) : ?>
                                    <br><span class="th-hero-title-highlight"><?php echo esc_html($meta['hero_subtitle']); ?></span>
                                    <?php endif; ?>
                                </h1>
                                <?php if ($meta['hero_desc']) : ?>
                                <p class="th-hero-subtitle"><?php echo esc_html($meta['hero_desc']); ?></p>
                                <?php endif; ?>
                                <div class="th-hero-cta">
                                    <a href="<?php echo esc_url($meta['hero_cta_link']); ?>" class="th-btn th-btn-primary th-btn-lg">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        <?php echo esc_html($meta['hero_cta_text']); ?>
                                    </a>
                                    <?php if ($meta['hero_cta2_text']) : ?>
                                    <a href="<?php echo esc_url($meta['hero_cta2_link']); ?>" class="th-btn th-btn-secondary th-btn-lg">
                                        <i class="fa-solid fa-play-circle"></i>
                                        <?php echo esc_html($meta['hero_cta2_text']); ?>
                                    </a>
                                    <?php endif; ?>
                                </div>
                                <?php $badges = tez_home_parse_lines($meta['hero_badges'], 2); if (!empty($badges)) : ?>
                                <div class="th-hero-badges">
                                    <?php foreach ($badges as $b) : ?>
                                    <div class="th-hero-badge-item">
                                        <i class="<?php echo esc_attr($b[0]); ?>"></i>
                                        <span><?php echo esc_html($b[1]); ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if ($meta['hero_image']) : ?>
                            <div class="th-hero-visual">
                                <img src="<?php echo esc_url($meta['hero_image']); ?>" alt="<?php echo esc_attr($meta['hero_title']); ?>" class="th-hero-image">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats Section -->
            <?php $stats = tez_home_parse_lines($meta['stats'], 4); if (!empty($stats)) : ?>
            <section class="th-stats">
                <div class="th-container">
                    <div class="th-stats-grid">
                        <?php foreach ($stats as $s) : ?>
                        <div class="th-stat-item">
                            <div class="th-stat-icon"><i class="<?php echo esc_attr($s[0]); ?>"></i></div>
                            <div class="th-stat-value"><?php echo esc_html(tez_home_to_persian($s[1]) . ($s[2] ?? '')); ?></div>
                            <div class="th-stat-label"><?php echo esc_html($s[3]); ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Services Section -->
            <?php $services = tez_home_parse_lines($meta['services'], 3); if (!empty($services)) : ?>
            <section class="th-section" id="services">
                <div class="th-container">
                    <div class="th-section-header">
                        <span class="th-section-badge"><i class="fa-solid fa-briefcase"></i> خدمات</span>
                        <h2 class="th-section-title"><?php echo esc_html($meta['services_title']); ?></h2>
                    </div>
                    <div class="th-grid">
                        <?php foreach ($services as $s) : ?>
                        <a href="<?php echo esc_url($s[3] ?? '#'); ?>" class="th-card">
                            <div class="th-card-icon"><i class="<?php echo esc_attr($s[0]); ?>"></i></div>
                            <h3 class="th-card-title"><?php echo esc_html($s[1]); ?></h3>
                            <p class="th-card-desc"><?php echo esc_html($s[2]); ?></p>
                            <?php if (!empty($s[4])) : ?>
                            <p class="th-card-price">از <strong><?php echo esc_html($s[4]); ?></strong></p>
                            <?php endif; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Why Us Section -->
            <?php $why = tez_home_parse_lines($meta['why_items'], 3); if (!empty($why)) : ?>
            <section class="th-section th-section-alt" id="why">
                <div class="th-container">
                    <div class="th-section-header">
                        <span class="th-section-badge"><i class="fa-solid fa-gem"></i> مزایا</span>
                        <h2 class="th-section-title"><?php echo esc_html($meta['why_title']); ?></h2>
                    </div>
                    <div class="th-grid">
                        <?php foreach ($why as $w) : ?>
                        <div class="th-card th-card-center">
                            <div class="th-card-icon th-card-icon-round"><i class="<?php echo esc_attr($w[0]); ?>"></i></div>
                            <h3 class="th-card-title"><?php echo esc_html($w[1]); ?></h3>
                            <p class="th-card-desc"><?php echo esc_html($w[2]); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Process Section -->
            <?php $steps = tez_home_parse_lines($meta['process_steps'], 3); if (!empty($steps)) : ?>
            <section class="th-section" id="process">
                <div class="th-container">
                    <div class="th-section-header">
                        <span class="th-section-badge"><i class="fa-solid fa-route"></i> مراحل</span>
                        <h2 class="th-section-title"><?php echo esc_html($meta['process_title']); ?></h2>
                    </div>
                    <div class="th-steps">
                        <?php foreach ($steps as $s) : ?>
                        <div class="th-step">
                            <div class="th-step-icon"><i class="<?php echo esc_attr($s[0]); ?>"></i></div>
                            <h3 class="th-step-title"><?php echo esc_html($s[1]); ?></h3>
                            <p class="th-step-desc"><?php echo esc_html($s[2]); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- Testimonials Section -->
            <?php $testimonials = tez_home_parse_lines($meta['testimonials'], 4); if (!empty($testimonials)) : ?>
            <section class="th-section th-section-alt" id="testimonials">
                <div class="th-container">
                    <div class="th-section-header">
                        <span class="th-section-badge"><i class="fa-solid fa-comments"></i> نظرات</span>
                        <h2 class="th-section-title"><?php echo esc_html($meta['testimonials_title']); ?></h2>
                    </div>
                    <div class="th-grid">
                        <?php foreach ($testimonials as $t) : ?>
                        <div class="th-testimonial">
                            <div class="th-testimonial-stars"><?php echo tez_home_render_stars(intval($t[3])); ?></div>
                            <p class="th-testimonial-text">"<?php echo esc_html($t[2]); ?>"</p>
                            <div class="th-testimonial-author">
                                <div class="th-testimonial-avatar"><?php echo mb_substr($t[0], 0, 1); ?></div>
                                <div>
                                    <div class="th-testimonial-name"><?php echo esc_html($t[0]); ?></div>
                                    <div class="th-testimonial-role"><?php echo esc_html($t[1]); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- FAQ Section -->
            <?php $faq = tez_home_parse_lines($meta['faq'], 2); if (!empty($faq)) : ?>
            <section class="th-section" id="faq">
                <div class="th-container">
                    <div class="th-section-header">
                        <span class="th-section-badge"><i class="fa-solid fa-circle-question"></i> سوالات</span>
                        <h2 class="th-section-title"><?php echo esc_html($meta['faq_title']); ?></h2>
                    </div>
                    <div class="th-faq-list">
                        <?php foreach ($faq as $f) : ?>
                        <div class="th-faq-item">
                            <button class="th-faq-q" type="button">
                                <span><?php echo esc_html($f[0]); ?></span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="th-faq-a"><p><?php echo esc_html($f[1]); ?></p></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <!-- CTA Section -->
            <section class="th-cta" id="contact">
                <div class="th-container">
                    <div class="th-cta-content">
                        <h2 class="th-cta-title"><?php echo esc_html($meta['cta_title']); ?></h2>
                        <p class="th-cta-subtitle">مشاوره رایگان و بدون تعهد</p>
                        <div class="th-cta-buttons">
                            <a href="<?php echo esc_url($meta['cta_link']); ?>" class="th-btn th-btn-primary th-btn-lg">
                                <i class="fa-solid fa-rocket"></i>
                                <?php echo esc_html($meta['cta_text']); ?>
                            </a>
                            <?php if ($meta['phone']) : ?>
                            <a href="tel:<?php echo esc_attr($meta['phone']); ?>" class="th-btn th-btn-outline th-btn-lg">
                                <i class="fa-solid fa-phone"></i>
                                تماس تلفنی
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php if ($meta['phone'] || $meta['email']) : ?>
                        <div class="th-cta-contact">
                            <?php if ($meta['phone']) : ?>
                            <div class="th-cta-contact-item">
                                <i class="fa-solid fa-phone"></i>
                                <a href="tel:<?php echo esc_attr($meta['phone']); ?>" dir="ltr"><?php echo esc_html($meta['phone']); ?></a>
                            </div>
                            <?php endif; ?>
                            <?php if ($meta['email']) : ?>
                            <div class="th-cta-contact-item">
                                <i class="fa-solid fa-envelope"></i>
                                <a href="mailto:<?php echo esc_attr($meta['email']); ?>" dir="ltr"><?php echo esc_html($meta['email']); ?></a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
        
        <?php
        // Output scripts
        echo tez_home_get_scripts();
    }
}

// =============================================
// STYLES
// =============================================
if (!function_exists('tez_home_get_styles')) {
    function tez_home_get_styles() {
        return <<<CSS
<style id="tez-home-styles">
:root {
    --th-bg: #ffffff;
    --th-bg-alt: #f8fafc;
    --th-bg-dark: #0f172a;
    --th-text: #1e293b;
    --th-text-muted: #64748b;
    --th-text-light: #94a3b8;
    --th-border: #e2e8f0;
    --th-border-light: #f1f5f9;
    --th-primary: #2563eb;
    --th-primary-hover: #1d4ed8;
    --th-primary-light: rgba(37,99,235,0.1);
    --th-secondary: #7c3aed;
    --th-accent: #f97316;
    --th-success: #10b981;
    --th-warning: #f59e0b;
    --th-error: #ef4444;
    --th-gradient: linear-gradient(135deg,#2563eb 0%,#7c3aed 100%);
    --th-gradient-light: linear-gradient(135deg,#eff6ff 0%,#f5f3ff 50%,#fef3c7 100%);
    --th-shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
    --th-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    --th-shadow-md: 0 10px 15px -3px rgba(0,0,0,0.1);
    --th-shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.1);
    --th-shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.25);
    --th-radius-sm: 8px;
    --th-radius: 12px;
    --th-radius-lg: 16px;
    --th-radius-xl: 24px;
    --th-radius-full: 9999px;
    --th-transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
    --th-font: 'IRANSans','Tahoma',system-ui,sans-serif;
    --th-container: 1280px;
}

.tez-home {
    direction: rtl;
    font-family: var(--th-font);
    color: var(--th-text);
    line-height: 1.7;
    font-size: 16px;
    background: var(--th-bg);
    -webkit-font-smoothing: antialiased;
}

.tez-home *, .tez-home *::before, .tez-home *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.tez-home img { max-width: 100%; height: auto; display: block; }
.tez-home a { color: inherit; text-decoration: none; transition: var(--th-transition); }

.th-container {
    width: 100%;
    max-width: var(--th-container);
    margin: 0 auto;
    padding: 0 clamp(16px,4vw,32px);
}

.th-section { padding: 80px 0; position: relative; }
.th-section-alt { background: var(--th-bg-alt); }

.th-section-header {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 50px;
}

.th-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--th-primary-light);
    color: var(--th-primary);
    padding: 8px 16px;
    border-radius: var(--th-radius-full);
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 16px;
}

.th-section-title {
    font-size: clamp(1.75rem,4vw,2.5rem);
    font-weight: 800;
    color: var(--th-text);
    margin-bottom: 16px;
    line-height: 1.3;
}

/* Buttons */
.th-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 32px;
    border-radius: var(--th-radius);
    font-size: 1rem;
    font-weight: 700;
    font-family: inherit;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: var(--th-transition);
}

.th-btn-primary {
    background: var(--th-gradient);
    color: #fff;
    box-shadow: var(--th-shadow-md),0 4px 20px rgba(37,99,235,0.3);
}

.th-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--th-shadow-lg),0 8px 30px rgba(37,99,235,0.4);
    color: #fff;
}

.th-btn-secondary {
    background: var(--th-bg);
    color: var(--th-text);
    border: 2px solid var(--th-border);
}

.th-btn-secondary:hover {
    border-color: var(--th-primary);
    color: var(--th-primary);
    transform: translateY(-2px);
}

.th-btn-outline {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255,255,255,0.3);
}

.th-btn-outline:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.5);
    color: #fff;
}

.th-btn-lg { padding: 18px 40px; font-size: 1.0625rem; }

/* Hero */
.th-hero {
    position: relative;
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    align-items: center;
    background: var(--th-gradient-light);
    overflow: hidden;
}

.th-hero-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.th-hero-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.5;
}

.th-hero-glow-1 {
    width: 500px; height: 500px;
    background: rgba(37,99,235,0.25);
    top: -150px; right: -100px;
    animation: glowFloat 10s ease-in-out infinite;
}

.th-hero-glow-2 {
    width: 400px; height: 400px;
    background: rgba(124,58,237,0.2);
    bottom: -100px; left: -100px;
    animation: glowFloat 12s ease-in-out infinite reverse;
}

@keyframes glowFloat {
    0%,100% { transform: scale(1) translate(0,0); }
    50% { transform: scale(1.1) translate(20px,-20px); }
}

.th-hero-grid {
    position: absolute;
    inset: 0;
    background-image: linear-gradient(rgba(37,99,235,0.03) 1px,transparent 1px),
                      linear-gradient(90deg,rgba(37,99,235,0.03) 1px,transparent 1px);
    background-size: 60px 60px;
    mask-image: radial-gradient(ellipse at center,black 20%,transparent 70%);
}

.th-hero-content {
    position: relative;
    z-index: 10;
    width: 100%;
    padding: 100px 0 80px;
}

.th-hero-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.th-hero-text { max-width: 600px; }

.th-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    padding: 10px 20px 10px 14px;
    border-radius: var(--th-radius-full);
    margin-bottom: 24px;
    border: 1px solid var(--th-border-light);
    box-shadow: var(--th-shadow);
}

.th-hero-badge-icon {
    width: 36px; height: 36px;
    background: var(--th-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.9rem;
}

.th-hero-badge-text { font-size: 0.9rem; font-weight: 600; }

.th-hero-badge-tag {
    background: var(--th-success);
    color: #fff;
    font-size: 0.625rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: var(--th-radius-full);
}

.th-hero-title {
    font-size: clamp(2rem,5vw,3.25rem);
    font-weight: 900;
    line-height: 1.2;
    color: var(--th-text);
    margin-bottom: 16px;
}

.th-hero-title-highlight {
    background: var(--th-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.th-hero-subtitle {
    font-size: 1.125rem;
    color: var(--th-text-muted);
    line-height: 1.8;
    margin-bottom: 32px;
}

.th-hero-cta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 32px;
}

.th-hero-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.th-hero-badge-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: var(--th-text-muted);
}

.th-hero-badge-item i { color: var(--th-success); }

.th-hero-visual { position: relative; }

.th-hero-image {
    border-radius: var(--th-radius-xl);
    box-shadow: var(--th-shadow-xl);
}

/* Stats */
.th-stats {
    background: var(--th-bg-dark);
    padding: 50px 0;
    position: relative;
}

.th-stats::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--th-gradient);
    opacity: 0.1;
}

.th-stats-grid {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 40px;
    position: relative;
    z-index: 2;
}

.th-stat-item { text-align: center; color: #fff; }

.th-stat-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.1);
    border-radius: var(--th-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin: 0 auto 12px;
    color: var(--th-accent);
}

.th-stat-value {
    font-size: 2rem;
    font-weight: 900;
    margin-bottom: 4px;
}

.th-stat-label { font-size: 0.875rem; opacity: 0.8; }

/* Grid & Cards */
.th-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
    gap: 24px;
}

.th-card {
    background: var(--th-bg);
    border-radius: var(--th-radius-lg);
    padding: 32px;
    border: 1px solid var(--th-border-light);
    transition: var(--th-transition);
    display: block;
}

.th-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--th-shadow-lg);
    border-color: transparent;
}

.th-card-center { text-align: center; }

.th-card-icon {
    width: 56px; height: 56px;
    background: var(--th-primary-light);
    border-radius: var(--th-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--th-primary);
    margin-bottom: 20px;
    transition: var(--th-transition);
}

.th-card-icon-round {
    width: 70px; height: 70px;
    border-radius: 50%;
    background: var(--th-gradient);
    color: #fff;
    margin: 0 auto 20px;
    box-shadow: 0 10px 30px rgba(37,99,235,0.3);
}

.th-card:hover .th-card-icon:not(.th-card-icon-round) {
    background: var(--th-gradient);
    color: #fff;
    transform: scale(1.1) rotate(-5deg);
}

.th-card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--th-text);
    margin-bottom: 10px;
}

.th-card-desc {
    font-size: 0.9375rem;
    color: var(--th-text-muted);
    line-height: 1.7;
}

.th-card-price {
    margin-top: 16px;
    color: var(--th-primary);
    font-size: 0.9rem;
}

.th-card-price strong { font-weight: 700; }

/* Steps */
.th-steps {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 40px;
    counter-reset: step;
}

.th-step {
    flex: 1;
    min-width: 200px;
    max-width: 260px;
    text-align: center;
}

.th-step-icon {
    width: 80px; height: 80px;
    background: var(--th-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: #fff;
    margin: 0 auto 20px;
    position: relative;
    box-shadow: 0 10px 30px rgba(37,99,235,0.3);
    transition: var(--th-transition);
}

.th-step:hover .th-step-icon { transform: scale(1.1); }

.th-step-icon::before {
    counter-increment: step;
    content: counter(step);
    position: absolute;
    top: -8px; right: -8px;
    width: 28px; height: 28px;
    background: var(--th-warning);
    border-radius: 50%;
    font-size: 0.8rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1e293b;
    border: 3px solid var(--th-bg);
}

.th-step-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--th-text);
    margin-bottom: 8px;
}

.th-step-desc { font-size: 0.875rem; color: var(--th-text-muted); }

/* Testimonials */
.th-testimonial {
    background: var(--th-bg);
    border-radius: var(--th-radius-lg);
    padding: 28px;
    border: 1px solid var(--th-border-light);
    position: relative;
    transition: var(--th-transition);
}

.th-testimonial::before {
    content: '"';
    position: absolute;
    top: 16px; right: 20px;
    font-size: 4rem;
    color: var(--th-primary);
    opacity: 0.1;
    font-family: Georgia,serif;
}

.th-testimonial:hover {
    transform: translateY(-4px);
    box-shadow: var(--th-shadow-md);
    border-color: var(--th-primary);
}

.th-testimonial-stars {
    display: flex;
    gap: 3px;
    color: var(--th-warning);
    font-size: 0.875rem;
    margin-bottom: 16px;
}

.th-testimonial-text {
    font-size: 0.9375rem;
    color: var(--th-text);
    line-height: 1.8;
    margin-bottom: 20px;
    font-style: italic;
}

.th-testimonial-author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.th-testimonial-avatar {
    width: 48px; height: 48px;
    background: var(--th-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 1.125rem;
}

.th-testimonial-name {
    font-weight: 700;
    color: var(--th-text);
    font-size: 0.9rem;
}

.th-testimonial-role {
    font-size: 0.8rem;
    color: var(--th-text-muted);
}

/* FAQ */
.th-faq-list {
    max-width: 800px;
    margin: 0 auto;
}

.th-faq-item {
    background: var(--th-bg);
    border-radius: var(--th-radius);
    margin-bottom: 12px;
    border: 1px solid var(--th-border-light);
    overflow: hidden;
    transition: var(--th-transition);
}

.th-faq-item:hover { border-color: var(--th-primary); }
.th-faq-item.active { border-color: var(--th-primary); box-shadow: var(--th-shadow); }

.th-faq-q {
    width: 100%;
    padding: 20px 24px;
    background: none;
    border: none;
    text-align: right;
    font-size: 1rem;
    font-weight: 600;
    color: var(--th-text);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    font-family: inherit;
    transition: var(--th-transition);
}

.th-faq-q:hover { color: var(--th-primary); }
.th-faq-q i { color: var(--th-primary); transition: var(--th-transition); }
.th-faq-item.active .th-faq-q i { transform: rotate(180deg); }

.th-faq-a {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease,padding 0.3s ease;
}

.th-faq-item.active .th-faq-a {
    max-height: 500px;
    padding: 0 24px 20px;
}

.th-faq-a p { color: var(--th-text-muted); line-height: 1.8; }

/* CTA */
.th-cta {
    background: var(--th-bg-dark);
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.th-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--th-gradient);
    opacity: 0.15;
}

.th-cta-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 700px;
    margin: 0 auto;
}

.th-cta-title {
    font-size: clamp(1.5rem,3vw,2.25rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 16px;
}

.th-cta-subtitle {
    font-size: 1rem;
    color: rgba(255,255,255,0.8);
    margin-bottom: 32px;
}

.th-cta-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 16px;
}

.th-cta-contact {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 24px;
    margin-top: 40px;
    padding-top: 32px;
    border-top: 1px solid rgba(255,255,255,0.1);
}

.th-cta-contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255,255,255,0.8);
}

.th-cta-contact-item i {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.1);
    border-radius: var(--th-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--th-accent);
}

.th-cta-contact-item a { color: #fff; font-weight: 600; }
.th-cta-contact-item a:hover { color: var(--th-accent); }

/* Responsive */
@media (max-width: 1024px) {
    .th-hero-wrapper { grid-template-columns: 1fr; text-align: center; }
    .th-hero-text { max-width: 100%; order: 2; }
    .th-hero-visual { order: 1; max-width: 500px; margin: 0 auto; }
    .th-hero-cta { justify-content: center; }
    .th-hero-badges { justify-content: center; }
    .th-stats-grid { grid-template-columns: repeat(2,1fr); }
}

@media (max-width: 768px) {
    .th-section { padding: 60px 0; }
    .th-hero { min-height: auto; }
    .th-hero-content { padding: 80px 0 60px; }
    .th-hero-title { font-size: clamp(1.5rem,5vw,2rem); }
    .th-hero-cta { flex-direction: column; width: 100%; }
    .th-btn { width: 100%; justify-content: center; }
    .th-hero-badges { flex-direction: column; align-items: center; gap: 10px; }
    .th-stats-grid { grid-template-columns: repeat(2,1fr); gap: 20px; }
    .th-stat-value { font-size: 1.5rem; }
    .th-steps { flex-direction: column; gap: 28px; }
    .th-step { max-width: 100%; }
    .th-cta { padding: 60px 0; }
    .th-cta-buttons { flex-direction: column; }
    .th-cta-contact { flex-direction: column; gap: 16px; align-items: center; }
}

@media (max-width: 480px) {
    .th-hero-badge-text { font-size: 0.8rem; }
    .th-hero-badge-tag { display: none; }
    .th-section-title { font-size: 1.5rem; }
    .th-stat-icon { width: 44px; height: 44px; font-size: 1rem; }
    .th-card { padding: 24px; }
    .th-card-icon { width: 48px; height: 48px; font-size: 1.25rem; }
}

.tez-home *:focus-visible { outline: 2px solid var(--th-primary); outline-offset: 2px; }

@media (prefers-reduced-motion: reduce) {
    .tez-home *, .tez-home *::before, .tez-home *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}
</style>
CSS;
    }
}

// =============================================
// SCRIPTS
// =============================================
if (!function_exists('tez_home_get_scripts')) {
    function tez_home_get_scripts() {
        return <<<JS
<script>
(function(){
    'use strict';
    
    // FAQ Accordion
    document.querySelectorAll('.th-faq-q').forEach(function(btn){
        btn.addEventListener('click',function(){
            var item = this.parentElement;
            var isActive = item.classList.contains('active');
            document.querySelectorAll('.th-faq-item').forEach(function(faq){
                faq.classList.remove('active');
            });
            if(!isActive) item.classList.add('active');
        });
    });
    
    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor){
        anchor.addEventListener('click',function(e){
            var target = document.querySelector(this.getAttribute('href'));
            if(target){
                e.preventDefault();
                var offset = 80;
                var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({top:top,behavior:'smooth'});
            }
        });
    });
    
    // Animations on scroll
    if('IntersectionObserver' in window){
        var observer = new IntersectionObserver(function(entries){
            entries.forEach(function(entry){
                if(entry.isIntersecting){
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        },{threshold:0.1});
        
        document.querySelectorAll('.th-card,.th-step,.th-testimonial,.th-faq-item').forEach(function(el,i){
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease '+(i%4*0.1)+'s,transform 0.5s ease '+(i%4*0.1)+'s';
            observer.observe(el);
        });
    }
})();
</script>
JS;
    }
}
