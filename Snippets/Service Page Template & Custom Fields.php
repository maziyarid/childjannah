/**
 * Plugin Name: TEZ Service Pro
 * Description: Advanced Service Page Template with E-E-A-T, Breadcrumb, Categories, Tags & Labels
 * Version: 3.0.0
 * Author: TEZ Team
 * Text Domain: tez-service
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

// =============================================
// CONSTANTS
// =============================================
define('TEZ_SVC_VERSION', '3.0.0');
define('TEZ_SVC_MAX_FILE_SIZE', 10 * 1024 * 1024);
define('TEZ_SVC_RATE_LIMIT', 3);
define('TEZ_SVC_RATE_TIMEOUT', 15 * MINUTE_IN_SECONDS);

// =============================================
// REGISTER TAXONOMIES FOR PAGES
// =============================================
if (!function_exists('tez_svc_register_taxonomies')) {
    function tez_svc_register_taxonomies() {
        // Service Categories
        register_taxonomy('tez_service_cat', 'page', array(
            'labels' => array(
                'name'              => 'دسته‌بندی خدمات',
                'singular_name'     => 'دسته‌بندی',
                'search_items'      => 'جستجوی دسته‌بندی',
                'all_items'         => 'همه دسته‌بندی‌ها',
                'parent_item'       => 'دسته‌بندی والد',
                'parent_item_colon' => 'دسته‌بندی والد:',
                'edit_item'         => 'ویرایش دسته‌بندی',
                'update_item'       => 'بروزرسانی دسته‌بندی',
                'add_new_item'      => 'افزودن دسته‌بندی جدید',
                'new_item_name'     => 'نام دسته‌بندی جدید',
                'menu_name'         => 'دسته‌بندی خدمات',
            ),
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'service-category'),
            'show_in_rest'      => true,
        ));

        // Service Tags
        register_taxonomy('tez_service_tag', 'page', array(
            'labels' => array(
                'name'                       => 'برچسب خدمات',
                'singular_name'              => 'برچسب',
                'search_items'               => 'جستجوی برچسب',
                'popular_items'              => 'برچسب‌های محبوب',
                'all_items'                  => 'همه برچسب‌ها',
                'edit_item'                  => 'ویرایش برچسب',
                'update_item'                => 'بروزرسانی برچسب',
                'add_new_item'               => 'افزودن برچسب جدید',
                'new_item_name'              => 'نام برچسب جدید',
                'separate_items_with_commas' => 'برچسب‌ها را با کاما جدا کنید',
                'add_or_remove_items'        => 'افزودن یا حذف برچسب',
                'choose_from_most_used'      => 'انتخاب از پرکاربردترین',
                'menu_name'                  => 'برچسب خدمات',
            ),
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'service-tag'),
            'show_in_rest'      => true,
        ));

        // Service Labels (ارزان، کارشناسی ارشد، دکتری، تهران, etc.)
        register_taxonomy('tez_service_label', 'page', array(
            'labels' => array(
                'name'          => 'لیبل‌های خدمات',
                'singular_name' => 'لیبل',
                'search_items'  => 'جستجوی لیبل',
                'all_items'     => 'همه لیبل‌ها',
                'edit_item'     => 'ویرایش لیبل',
                'update_item'   => 'بروزرسانی لیبل',
                'add_new_item'  => 'افزودن لیبل جدید',
                'new_item_name' => 'نام لیبل جدید',
                'menu_name'     => 'لیبل‌ها',
            ),
            'hierarchical'      => false,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'service-label'),
            'show_in_rest'      => true,
        ));

        // Add default labels
        tez_svc_add_default_labels();
    }
    add_action('init', 'tez_svc_register_taxonomies');
}

// =============================================
// ADD DEFAULT LABELS
// =============================================
if (!function_exists('tez_svc_add_default_labels')) {
    function tez_svc_add_default_labels() {
        $default_labels = array(
            'ارزان'           => array('slug' => 'cheap', 'color' => '#10b981', 'icon' => 'fa-solid fa-tag'),
            'کارشناسی'        => array('slug' => 'bachelor', 'color' => '#3b82f6', 'icon' => 'fa-solid fa-graduation-cap'),
            'کارشناسی ارشد'   => array('slug' => 'master', 'color' => '#8b5cf6', 'icon' => 'fa-solid fa-user-graduate'),
            'دکتری'           => array('slug' => 'phd', 'color' => '#ef4444', 'icon' => 'fa-solid fa-award'),
            'تهران'           => array('slug' => 'tehran', 'color' => '#f59e0b', 'icon' => 'fa-solid fa-location-dot'),
            'فوری'            => array('slug' => 'urgent', 'color' => '#ec4899', 'icon' => 'fa-solid fa-bolt'),
            'تضمینی'          => array('slug' => 'guaranteed', 'color' => '#06b6d4', 'icon' => 'fa-solid fa-shield-check'),
            'پرفروش'          => array('slug' => 'bestseller', 'color' => '#f97316', 'icon' => 'fa-solid fa-fire'),
            'جدید'            => array('slug' => 'new', 'color' => '#22c55e', 'icon' => 'fa-solid fa-sparkles'),
            'ویژه'            => array('slug' => 'special', 'color' => '#a855f7', 'icon' => 'fa-solid fa-star'),
        );

        foreach ($default_labels as $name => $data) {
            if (!term_exists($name, 'tez_service_label')) {
                $term = wp_insert_term($name, 'tez_service_label', array('slug' => $data['slug']));
                if (!is_wp_error($term)) {
                    update_term_meta($term['term_id'], '_label_color', $data['color']);
                    update_term_meta($term['term_id'], '_label_icon', $data['icon']);
                }
            }
        }
    }
}

// =============================================
// LABEL TERM META FIELDS
// =============================================
if (!function_exists('tez_svc_label_fields')) {
    function tez_svc_label_add_fields() {
        ?>
        <div class="form-field">
            <label for="label_color">رنگ لیبل</label>
            <input type="color" name="label_color" id="label_color" value="#3b82f6">
            <p class="description">رنگ پس‌زمینه لیبل را انتخاب کنید</p>
        </div>
        <div class="form-field">
            <label for="label_icon">آیکون لیبل</label>
            <input type="text" name="label_icon" id="label_icon" value="fa-solid fa-tag">
            <p class="description">کلاس آیکون FontAwesome (مثال: fa-solid fa-star)</p>
        </div>
        <?php
    }
    add_action('tez_service_label_add_form_fields', 'tez_svc_label_add_fields');

    function tez_svc_label_edit_fields($term) {
        $color = get_term_meta($term->term_id, '_label_color', true) ?: '#3b82f6';
        $icon = get_term_meta($term->term_id, '_label_icon', true) ?: 'fa-solid fa-tag';
        ?>
        <tr class="form-field">
            <th scope="row"><label for="label_color">رنگ لیبل</label></th>
            <td>
                <input type="color" name="label_color" id="label_color" value="<?php echo esc_attr($color); ?>">
                <p class="description">رنگ پس‌زمینه لیبل را انتخاب کنید</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><label for="label_icon">آیکون لیبل</label></th>
            <td>
                <input type="text" name="label_icon" id="label_icon" value="<?php echo esc_attr($icon); ?>" class="regular-text">
                <p class="description">کلاس آیکون FontAwesome (مثال: fa-solid fa-star)</p>
            </td>
        </tr>
        <?php
    }
    add_action('tez_service_label_edit_form_fields', 'tez_svc_label_edit_fields');

    function tez_svc_save_label_meta($term_id) {
        if (isset($_POST['label_color'])) {
            update_term_meta($term_id, '_label_color', sanitize_hex_color($_POST['label_color']));
        }
        if (isset($_POST['label_icon'])) {
            update_term_meta($term_id, '_label_icon', sanitize_text_field($_POST['label_icon']));
        }
    }
    add_action('created_tez_service_label', 'tez_svc_save_label_meta');
    add_action('edited_tez_service_label', 'tez_svc_save_label_meta');
}

// =============================================
// REGISTER POST META
// =============================================
if (!function_exists('tez_svc_register_meta')) {
    function tez_svc_register_meta() {
        $fields = array(
            // Basic Fields
            '_tez_page_template',
            '_tez_hero_subtitle',
            '_tez_hero_bg_image',
            '_tez_hero_icon',
            '_tez_features',
            '_tez_process_steps',
            '_tez_price_from',
            '_tez_price_note',
            '_tez_testimonials',
            '_tez_faq',
            '_tez_cta_title',
            '_tez_cta_text',
            '_tez_rating_value',
            '_tez_rating_count',
            '_tez_trust_badges',
            // E-E-A-T Fields
            '_tez_author_name',
            '_tez_author_title',
            '_tez_author_bio',
            '_tez_author_image',
            '_tez_author_social',
            '_tez_experience_years',
            '_tez_credentials',
            '_tez_certifications',
            '_tez_published_date',
            '_tez_updated_date',
            '_tez_reviewer_name',
            '_tez_reviewer_title',
            '_tez_sources',
            '_tez_methodology',
            // Helpful Content Fields
            '_tez_reading_time',
            '_tez_difficulty_level',
            '_tez_target_audience',
            '_tez_key_takeaways',
            '_tez_table_of_contents',
            // Hero Enhancement Fields
            '_tez_hero_video',
            '_tez_hero_stats',
            '_tez_hero_cta_secondary',
            '_tez_quick_contact_phone',
            '_tez_completion_count',
            '_tez_satisfaction_rate',
        );

        foreach ($fields as $field) {
            register_post_meta('page', $field, array(
                'show_in_rest'  => true,
                'single'        => true,
                'type'          => 'string',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                },
            ));
        }
    }
    add_action('init', 'tez_svc_register_meta');
}

// =============================================
// ADD META BOXES
// =============================================
if (!function_exists('tez_svc_add_meta_boxes')) {
    function tez_svc_add_meta_boxes() {
        $meta_boxes = array(
            'tez_svc_template'     => array('قالب صفحه خدمات', 'tez_svc_template_cb', 'side', 'high'),
            'tez_svc_hero'         => array('بخش هیرو', 'tez_svc_hero_cb', 'normal', 'high'),
            'tez_svc_eeat'         => array('E-E-A-T (تخصص و اعتبار)', 'tez_svc_eeat_cb', 'normal', 'high'),
            'tez_svc_helpful'      => array('محتوای مفید', 'tez_svc_helpful_cb', 'normal', 'high'),
            'tez_svc_rating'       => array('امتیاز و اعتماد', 'tez_svc_rating_cb', 'normal', 'high'),
            'tez_svc_features'     => array('ویژگی‌ها', 'tez_svc_features_cb', 'normal', 'default'),
            'tez_svc_process'      => array('مراحل کار', 'tez_svc_process_cb', 'normal', 'default'),
            'tez_svc_pricing'      => array('قیمت', 'tez_svc_pricing_cb', 'normal', 'default'),
            'tez_svc_testimonials' => array('نظرات', 'tez_svc_testimonials_cb', 'normal', 'default'),
            'tez_svc_faq'          => array('سوالات متداول', 'tez_svc_faq_cb', 'normal', 'default'),
            'tez_svc_cta'          => array('دکمه CTA', 'tez_svc_cta_cb', 'normal', 'default'),
        );

        foreach ($meta_boxes as $id => $args) {
            add_meta_box($id, $args[0], $args[1], 'page', $args[2], $args[3]);
        }
    }
    add_action('add_meta_boxes', 'tez_svc_add_meta_boxes');
}

// =============================================
// META BOX CALLBACKS
// =============================================
function tez_svc_template_cb($post) {
    wp_nonce_field('tez_svc_save', 'tez_svc_nonce');
    $val = get_post_meta($post->ID, '_tez_page_template', true);
    echo '<label><input type="checkbox" name="_tez_page_template" value="service" ' . checked($val, 'service', false) . '> فعال کردن قالب خدمات</label>';
    echo '<p class="description" style="margin-top:10px;">با فعال کردن این گزینه، قالب خدمات حرفه‌ای برای این صفحه اعمال می‌شود.</p>';
}

function tez_svc_hero_cb($post) {
    $subtitle = get_post_meta($post->ID, '_tez_hero_subtitle', true);
    $icon = get_post_meta($post->ID, '_tez_hero_icon', true);
    $bg = get_post_meta($post->ID, '_tez_hero_bg_image', true);
    $video = get_post_meta($post->ID, '_tez_hero_video', true);
    $stats = get_post_meta($post->ID, '_tez_hero_stats', true);
    $cta_secondary = get_post_meta($post->ID, '_tez_hero_cta_secondary', true);
    $phone = get_post_meta($post->ID, '_tez_quick_contact_phone', true);
    $completion = get_post_meta($post->ID, '_tez_completion_count', true);
    $satisfaction = get_post_meta($post->ID, '_tez_satisfaction_rate', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="_tez_hero_subtitle">زیرعنوان</label></th>
            <td><input type="text" name="_tez_hero_subtitle" id="_tez_hero_subtitle" value="<?php echo esc_attr($subtitle); ?>" class="large-text"></td>
        </tr>
        <tr>
            <th><label for="_tez_hero_icon">آیکون</label></th>
            <td>
                <input type="text" name="_tez_hero_icon" id="_tez_hero_icon" value="<?php echo esc_attr($icon); ?>" class="regular-text">
                <p class="description">مثال: fa-solid fa-graduation-cap</p>
            </td>
        </tr>
        <tr>
            <th><label for="_tez_hero_bg_image">تصویر پس‌زمینه</label></th>
            <td>
                <input type="url" name="_tez_hero_bg_image" id="_tez_hero_bg_image" value="<?php echo esc_url($bg); ?>" class="large-text">
                <button type="button" class="button tez-upload-btn" data-target="#_tez_hero_bg_image">انتخاب تصویر</button>
            </td>
        </tr>
        <tr>
            <th><label for="_tez_hero_video">ویدیو پس‌زمینه (اختیاری)</label></th>
            <td>
                <input type="url" name="_tez_hero_video" id="_tez_hero_video" value="<?php echo esc_url($video); ?>" class="large-text">
                <p class="description">URL فایل MP4</p>
            </td>
        </tr>
        <tr>
            <th><label for="_tez_quick_contact_phone">شماره تماس سریع</label></th>
            <td><input type="text" name="_tez_quick_contact_phone" id="_tez_quick_contact_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" placeholder="09123456789" dir="ltr"></td>
        </tr>
        <tr>
            <th><label for="_tez_hero_cta_secondary">متن دکمه ثانویه</label></th>
            <td><input type="text" name="_tez_hero_cta_secondary" id="_tez_hero_cta_secondary" value="<?php echo esc_attr($cta_secondary); ?>" class="regular-text" placeholder="مشاهده نمونه کارها"></td>
        </tr>
        <tr>
            <th><label for="_tez_completion_count">تعداد پروژه‌های انجام شده</label></th>
            <td><input type="number" name="_tez_completion_count" id="_tez_completion_count" value="<?php echo esc_attr($completion); ?>" class="small-text" placeholder="2500"></td>
        </tr>
        <tr>
            <th><label for="_tez_satisfaction_rate">درصد رضایت</label></th>
            <td><input type="number" name="_tez_satisfaction_rate" id="_tez_satisfaction_rate" value="<?php echo esc_attr($satisfaction); ?>" class="small-text" placeholder="98" min="0" max="100">%</td>
        </tr>
        <tr>
            <th><label for="_tez_hero_stats">آمار هیرو</label></th>
            <td>
                <textarea name="_tez_hero_stats" id="_tez_hero_stats" rows="4" class="large-text" placeholder="آیکون|عدد|عنوان"><?php echo esc_textarea($stats); ?></textarea>
                <p class="description">هر خط: آیکون|عدد|عنوان<br>مثال: fa-solid fa-users|1800|مشتری راضی</p>
            </td>
        </tr>
    </table>
    <?php
}

function tez_svc_eeat_cb($post) {
    $author_name = get_post_meta($post->ID, '_tez_author_name', true);
    $author_title = get_post_meta($post->ID, '_tez_author_title', true);
    $author_bio = get_post_meta($post->ID, '_tez_author_bio', true);
    $author_image = get_post_meta($post->ID, '_tez_author_image', true);
    $author_social = get_post_meta($post->ID, '_tez_author_social', true);
    $experience = get_post_meta($post->ID, '_tez_experience_years', true);
    $credentials = get_post_meta($post->ID, '_tez_credentials', true);
    $certifications = get_post_meta($post->ID, '_tez_certifications', true);
    $published = get_post_meta($post->ID, '_tez_published_date', true);
    $updated = get_post_meta($post->ID, '_tez_updated_date', true);
    $reviewer_name = get_post_meta($post->ID, '_tez_reviewer_name', true);
    $reviewer_title = get_post_meta($post->ID, '_tez_reviewer_title', true);
    $sources = get_post_meta($post->ID, '_tez_sources', true);
    $methodology = get_post_meta($post->ID, '_tez_methodology', true);
    ?>
    <div style="background:#f0f7ff;padding:15px;border-radius:8px;margin-bottom:20px;">
        <strong>🔒 E-E-A-T چیست؟</strong>
        <p style="margin:8px 0 0;">Experience (تجربه)، Expertise (تخصص)، Authoritativeness (اعتبار)، Trustworthiness (اعتماد) - معیارهای گوگل برای ارزیابی کیفیت محتوا</p>
    </div>
    
    <h4 style="border-bottom:1px solid #ddd;padding-bottom:10px;">👤 اطلاعات نویسنده/متخصص</h4>
    <table class="form-table">
        <tr>
            <th><label for="_tez_author_name">نام نویسنده</label></th>
            <td><input type="text" name="_tez_author_name" id="_tez_author_name" value="<?php echo esc_attr($author_name); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="_tez_author_title">عنوان شغلی</label></th>
            <td><input type="text" name="_tez_author_title" id="_tez_author_title" value="<?php echo esc_attr($author_title); ?>" class="regular-text" placeholder="مثال: دکتری مدیریت - مشاور پایان‌نامه"></td>
        </tr>
        <tr>
            <th><label for="_tez_author_image">تصویر نویسنده</label></th>
            <td>
                <input type="url" name="_tez_author_image" id="_tez_author_image" value="<?php echo esc_url($author_image); ?>" class="large-text">
                <button type="button" class="button tez-upload-btn" data-target="#_tez_author_image">انتخاب تصویر</button>
            </td>
        </tr>
        <tr>
            <th><label for="_tez_author_bio">بیوگرافی کوتاه</label></th>
            <td><textarea name="_tez_author_bio" id="_tez_author_bio" rows="3" class="large-text"><?php echo esc_textarea($author_bio); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="_tez_author_social">شبکه‌های اجتماعی</label></th>
            <td>
                <textarea name="_tez_author_social" id="_tez_author_social" rows="3" class="large-text" placeholder="نوع|لینک"><?php echo esc_textarea($author_social); ?></textarea>
                <p class="description">هر خط: نوع|لینک (مثال: linkedin|https://linkedin.com/in/username)</p>
            </td>
        </tr>
    </table>
    
    <h4 style="border-bottom:1px solid #ddd;padding-bottom:10px;margin-top:30px;">🎓 مدارک و تجربه</h4>
    <table class="form-table">
        <tr>
            <th><label for="_tez_experience_years">سال‌های تجربه</label></th>
            <td><input type="number" name="_tez_experience_years" id="_tez_experience_years" value="<?php echo esc_attr($experience); ?>" class="small-text" min="0"> سال</td>
        </tr>
        <tr>
            <th><label for="_tez_credentials">مدارک تحصیلی</label></th>
            <td>
                <textarea name="_tez_credentials" id="_tez_credentials" rows="3" class="large-text" placeholder="مثال: دکتری مدیریت بازرگانی - دانشگاه تهران"><?php echo esc_textarea($credentials); ?></textarea>
                <p class="description">هر مدرک در یک خط</p>
            </td>
        </tr>
        <tr>
            <th><label for="_tez_certifications">گواهی‌نامه‌ها</label></th>
            <td>
                <textarea name="_tez_certifications" id="_tez_certifications" rows="3" class="large-text" placeholder="عنوان|صادرکننده|سال"><?php echo esc_textarea($certifications); ?></textarea>
                <p class="description">هر خط: عنوان|صادرکننده|سال</p>
            </td>
        </tr>
    </table>
    
    <h4 style="border-bottom:1px solid #ddd;padding-bottom:10px;margin-top:30px;">📅 تاریخ و بازبینی</h4>
    <table class="form-table">
        <tr>
            <th><label for="_tez_published_date">تاریخ انتشار</label></th>
            <td><input type="date" name="_tez_published_date" id="_tez_published_date" value="<?php echo esc_attr($published); ?>"></td>
        </tr>
        <tr>
            <th><label for="_tez_updated_date">آخرین بروزرسانی</label></th>
            <td><input type="date" name="_tez_updated_date" id="_tez_updated_date" value="<?php echo esc_attr($updated); ?>"></td>
        </tr>
        <tr>
            <th><label for="_tez_reviewer_name">بازبین محتوا</label></th>
            <td><input type="text" name="_tez_reviewer_name" id="_tez_reviewer_name" value="<?php echo esc_attr($reviewer_name); ?>" class="regular-text" placeholder="نام شخصی که محتوا را بررسی کرده"></td>
        </tr>
        <tr>
            <th><label for="_tez_reviewer_title">سمت بازبین</label></th>
            <td><input type="text" name="_tez_reviewer_title" id="_tez_reviewer_title" value="<?php echo esc_attr($reviewer_title); ?>" class="regular-text"></td>
        </tr>
    </table>
    
    <h4 style="border-bottom:1px solid #ddd;padding-bottom:10px;margin-top:30px;">📚 منابع و روش‌شناسی</h4>
    <table class="form-table">
        <tr>
            <th><label for="_tez_sources">منابع و مراجع</label></th>
            <td>
                <textarea name="_tez_sources" id="_tez_sources" rows="4" class="large-text" placeholder="عنوان|لینک"><?php echo esc_textarea($sources); ?></textarea>
                <p class="description">هر خط: عنوان|لینک (اختیاری)</p>
            </td>
        </tr>
        <tr>
            <th><label for="_tez_methodology">روش‌شناسی</label></th>
            <td>
                <textarea name="_tez_methodology" id="_tez_methodology" rows="3" class="large-text" placeholder="توضیح کوتاه درباره نحوه تهیه و بررسی محتوا"><?php echo esc_textarea($methodology); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

function tez_svc_helpful_cb($post) {
    $reading_time = get_post_meta($post->ID, '_tez_reading_time', true);
    $difficulty = get_post_meta($post->ID, '_tez_difficulty_level', true);
    $audience = get_post_meta($post->ID, '_tez_target_audience', true);
    $takeaways = get_post_meta($post->ID, '_tez_key_takeaways', true);
    $toc = get_post_meta($post->ID, '_tez_table_of_contents', true);
    ?>
    <div style="background:#f0fff4;padding:15px;border-radius:8px;margin-bottom:20px;">
        <strong>📖 محتوای مفید (Helpful Content)</strong>
        <p style="margin:8px 0 0;">این فیلدها به بهبود تجربه کاربری و رعایت اصول Helpful Content Update گوگل کمک می‌کنند.</p>
    </div>
    
    <table class="form-table">
        <tr>
            <th><label for="_tez_reading_time">زمان مطالعه</label></th>
            <td><input type="number" name="_tez_reading_time" id="_tez_reading_time" value="<?php echo esc_attr($reading_time); ?>" class="small-text" min="1"> دقیقه</td>
        </tr>
        <tr>
            <th><label for="_tez_difficulty_level">سطح دشواری</label></th>
            <td>
                <select name="_tez_difficulty_level" id="_tez_difficulty_level">
                    <option value="">انتخاب کنید...</option>
                    <option value="beginner" <?php selected($difficulty, 'beginner'); ?>>مبتدی</option>
                    <option value="intermediate" <?php selected($difficulty, 'intermediate'); ?>>متوسط</option>
                    <option value="advanced" <?php selected($difficulty, 'advanced'); ?>>پیشرفته</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="_tez_target_audience">مخاطب هدف</label></th>
            <td>
                <input type="text" name="_tez_target_audience" id="_tez_target_audience" value="<?php echo esc_attr($audience); ?>" class="large-text" placeholder="مثال: دانشجویان کارشناسی ارشد رشته مدیریت">
            </td>
        </tr>
        <tr>
            <th><label for="_tez_key_takeaways">نکات کلیدی</label></th>
            <td>
                <textarea name="_tez_key_takeaways" id="_tez_key_takeaways" rows="4" class="large-text" placeholder="هر نکته در یک خط"><?php echo esc_textarea($takeaways); ?></textarea>
                <p class="description">نکات مهمی که کاربر از این صفحه یاد می‌گیرد (هر خط یک نکته)</p>
            </td>
        </tr>
        <tr>
            <th><label for="_tez_table_of_contents">فهرست مطالب</label></th>
            <td>
                <textarea name="_tez_table_of_contents" id="_tez_table_of_contents" rows="5" class="large-text" placeholder="عنوان|آیدی-بخش"><?php echo esc_textarea($toc); ?></textarea>
                <p class="description">هر خط: عنوان|آیدی-بخش (مثال: ویژگی‌ها|features)</p>
            </td>
        </tr>
    </table>
    <?php
}

function tez_svc_rating_cb($post) {
    $rating = get_post_meta($post->ID, '_tez_rating_value', true) ?: '4.8';
    $count = get_post_meta($post->ID, '_tez_rating_count', true) ?: '127';
    $badges = get_post_meta($post->ID, '_tez_trust_badges', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="_tez_rating_value">امتیاز (1-5)</label></th>
            <td><input type="number" name="_tez_rating_value" id="_tez_rating_value" value="<?php echo esc_attr($rating); ?>" class="small-text" step="0.1" min="1" max="5"></td>
        </tr>
        <tr>
            <th><label for="_tez_rating_count">تعداد نظرات</label></th>
            <td><input type="number" name="_tez_rating_count" id="_tez_rating_count" value="<?php echo esc_attr($count); ?>" class="small-text" min="0"></td>
        </tr>
        <tr>
            <th><label for="_tez_trust_badges">نشان‌های اعتماد</label></th>
            <td>
                <textarea name="_tez_trust_badges" id="_tez_trust_badges" rows="4" class="large-text" placeholder="آیکون|متن"><?php echo esc_textarea($badges); ?></textarea>
                <p class="description">هر خط: آیکون|متن<br>مثال: fa-solid fa-shield-check|تضمین کیفیت</p>
            </td>
        </tr>
    </table>
    <?php
}

function tez_svc_features_cb($post) {
    $val = get_post_meta($post->ID, '_tez_features', true);
    ?>
    <p class="description">هر خط: آیکون|عنوان|توضیح<br>مثال: fa-solid fa-check|کیفیت بالا|تضمین کیفیت کار</p>
    <textarea name="_tez_features" rows="8" class="large-text"><?php echo esc_textarea($val); ?></textarea>
    <?php
}

function tez_svc_process_cb($post) {
    $val = get_post_meta($post->ID, '_tez_process_steps', true);
    ?>
    <p class="description">هر خط: آیکون|عنوان|توضیح</p>
    <textarea name="_tez_process_steps" rows="6" class="large-text"><?php echo esc_textarea($val); ?></textarea>
    <?php
}

function tez_svc_pricing_cb($post) {
    $price = get_post_meta($post->ID, '_tez_price_from', true);
    $note = get_post_meta($post->ID, '_tez_price_note', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="_tez_price_from">قیمت شروع از</label></th>
            <td><input type="text" name="_tez_price_from" id="_tez_price_from" value="<?php echo esc_attr($price); ?>" class="regular-text" placeholder="۵۰۰,۰۰۰ تومان"></td>
        </tr>
        <tr>
            <th><label for="_tez_price_note">توضیح قیمت</label></th>
            <td><input type="text" name="_tez_price_note" id="_tez_price_note" value="<?php echo esc_attr($note); ?>" class="large-text"></td>
        </tr>
    </table>
    <?php
}

function tez_svc_testimonials_cb($post) {
    $val = get_post_meta($post->ID, '_tez_testimonials', true);
    ?>
    <p class="description">هر خط: نام|رشته|متن|امتیاز(1-5)|تاریخ<br>مثال: علی احمدی|مدیریت ارشد|کار عالی بود|5|1402/09/15</p>
    <textarea name="_tez_testimonials" rows="6" class="large-text"><?php echo esc_textarea($val); ?></textarea>
    <?php
}

function tez_svc_faq_cb($post) {
    $val = get_post_meta($post->ID, '_tez_faq', true);
    ?>
    <p class="description">هر خط: سوال|پاسخ</p>
    <textarea name="_tez_faq" rows="8" class="large-text"><?php echo esc_textarea($val); ?></textarea>
    <?php
}

function tez_svc_cta_cb($post) {
    $title = get_post_meta($post->ID, '_tez_cta_title', true);
    $text = get_post_meta($post->ID, '_tez_cta_text', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="_tez_cta_title">عنوان CTA</label></th>
            <td><input type="text" name="_tez_cta_title" id="_tez_cta_title" value="<?php echo esc_attr($title); ?>" class="large-text"></td>
        </tr>
        <tr>
            <th><label for="_tez_cta_text">متن دکمه</label></th>
            <td><input type="text" name="_tez_cta_text" id="_tez_cta_text" value="<?php echo esc_attr($text); ?>" class="regular-text"></td>
        </tr>
    </table>
    <?php
}

// =============================================
// SAVE META
// =============================================
if (!function_exists('tez_svc_save_meta')) {
    function tez_svc_save_meta($post_id) {
        if (!isset($_POST['tez_svc_nonce']) || !wp_verify_nonce($_POST['tez_svc_nonce'], 'tez_svc_save')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        if (get_post_type($post_id) !== 'page') {
            return;
        }

        $fields = array(
            '_tez_page_template', '_tez_hero_subtitle', '_tez_hero_bg_image', '_tez_hero_icon',
            '_tez_features', '_tez_process_steps', '_tez_price_from', '_tez_price_note',
            '_tez_testimonials', '_tez_faq', '_tez_cta_title', '_tez_cta_text',
            '_tez_rating_value', '_tez_rating_count', '_tez_trust_badges',
            '_tez_author_name', '_tez_author_title', '_tez_author_bio', '_tez_author_image',
            '_tez_author_social', '_tez_experience_years', '_tez_credentials', '_tez_certifications',
            '_tez_published_date', '_tez_updated_date', '_tez_reviewer_name', '_tez_reviewer_title',
            '_tez_sources', '_tez_methodology', '_tez_reading_time', '_tez_difficulty_level',
            '_tez_target_audience', '_tez_key_takeaways', '_tez_table_of_contents',
            '_tez_hero_video', '_tez_hero_stats', '_tez_hero_cta_secondary',
            '_tez_quick_contact_phone', '_tez_completion_count', '_tez_satisfaction_rate',
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $value = $_POST[$field];
                if (strpos($field, '_image') !== false || strpos($field, '_video') !== false || strpos($field, '_bg') !== false) {
                    $value = esc_url_raw($value);
                } else {
                    $value = sanitize_textarea_field($value);
                }
                update_post_meta($post_id, $field, $value);
            } else {
                delete_post_meta($post_id, $field);
            }
        }
    }
    add_action('save_post', 'tez_svc_save_meta');
}

// =============================================
// ADMIN MEDIA UPLOADER SCRIPT
// =============================================
if (!function_exists('tez_svc_admin_scripts')) {
    function tez_svc_admin_scripts($hook) {
        if ($hook !== 'post.php' && $hook !== 'post-new.php') {
            return;
        }
        wp_enqueue_media();
        ?>
        <script>
        jQuery(document).ready(function($) {
            $('.tez-upload-btn').on('click', function(e) {
                e.preventDefault();
                var targetInput = $($(this).data('target'));
                var frame = wp.media({
                    title: 'انتخاب تصویر',
                    button: { text: 'استفاده از این تصویر' },
                    multiple: false
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    targetInput.val(attachment.url);
                });
                frame.open();
            });
        });
        </script>
        <?php
    }
    add_action('admin_enqueue_scripts', 'tez_svc_admin_scripts');
}

// =============================================
// INQUIRY POST TYPE
// =============================================
if (!function_exists('tez_svc_register_inquiry')) {
    function tez_svc_register_inquiry() {
        register_post_type('tez_inquiry', array(
            'labels' => array(
                'name'          => 'درخواست‌ها',
                'singular_name' => 'درخواست',
                'menu_name'     => 'درخواست‌ها',
                'all_items'     => 'همه درخواست‌ها',
                'view_item'     => 'مشاهده درخواست',
                'edit_item'     => 'ویرایش درخواست',
                'search_items'  => 'جستجوی درخواست‌ها',
                'not_found'     => 'درخواستی یافت نشد',
            ),
            'public'       => false,
            'show_ui'      => true,
            'menu_icon'    => 'dashicons-clipboard',
            'supports'     => array('title'),
            'capabilities' => array('create_posts' => false),
            'map_meta_cap' => true,
        ));
    }
    add_action('init', 'tez_svc_register_inquiry');
}

// =============================================
// INQUIRY META BOX
// =============================================
if (!function_exists('tez_svc_inquiry_box')) {
    function tez_svc_inquiry_box() {
        add_meta_box('tez_inq_info', 'جزئیات درخواست', 'tez_svc_inquiry_box_cb', 'tez_inquiry', 'normal', 'high');
    }
    add_action('add_meta_boxes', 'tez_svc_inquiry_box');
}

function tez_svc_inquiry_box_cb($post) {
    $m = get_post_meta($post->ID);
    $file = $m['_inq_file'][0] ?? '';
    ?>
    <table class="form-table">
        <tr><th>نام:</th><td><?php echo esc_html($m['_inq_name'][0] ?? ''); ?></td></tr>
        <tr><th>تلفن:</th><td dir="ltr"><?php echo esc_html($m['_inq_phone'][0] ?? ''); ?></td></tr>
        <tr><th>رشته:</th><td><?php echo esc_html($m['_inq_major'][0] ?? ''); ?></td></tr>
        <tr><th>نوع:</th><td><?php echo esc_html($m['_inq_type'][0] ?? ''); ?></td></tr>
        <tr><th>توضیحات:</th><td><?php echo nl2br(esc_html($m['_inq_desc'][0] ?? '')); ?></td></tr>
        <tr><th>فایل:</th><td><?php echo $file ? '<a href="' . esc_url($file) . '" target="_blank" rel="noopener">دانلود فایل</a>' : '-'; ?></td></tr>
        <tr><th>صفحه مبدا:</th><td><?php echo esc_html(get_the_title($m['_inq_source'][0] ?? 0)); ?></td></tr>
        <tr><th>IP:</th><td dir="ltr"><?php echo esc_html($m['_inq_ip'][0] ?? ''); ?></td></tr>
        <tr><th>تاریخ:</th><td><?php echo esc_html(get_the_date('Y/m/d H:i', $post->ID)); ?></td></tr>
    </table>
    <?php
}

// =============================================
// SECURE UPLOAD
// =============================================
if (!function_exists('tez_svc_upload')) {
    function tez_svc_upload($file) {
        $allowed = array(
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png',
            'gif' => 'image/gif', 'webp' => 'image/webp', 'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'zip' => 'application/zip', 'rar' => 'application/x-rar-compressed', 'txt' => 'text/plain',
        );

        if (empty($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return array('error' => 'خطا در آپلود فایل');
        }
        if ($file['size'] > TEZ_SVC_MAX_FILE_SIZE) {
            return array('error' => 'حداکثر حجم فایل ۱۰MB است');
        }

        $ext = strtolower(pathinfo(sanitize_file_name($file['name']), PATHINFO_EXTENSION));
        if (!isset($allowed[$ext])) {
            return array('error' => 'فرمت فایل مجاز نیست');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowed, true)) {
            return array('error' => 'نوع فایل مجاز نیست');
        }

        $content = file_get_contents($file['tmp_name']);
        if (preg_match('/<\?(php)?|<%|<script|javascript:/i', $content)) {
            return array('error' => 'فایل حاوی کد مخرب است');
        }

        $upload = wp_upload_dir();
        $dir = $upload['basedir'] . '/tez-inquiries/' . date('Y/m');
        if (!file_exists($dir)) {
            wp_mkdir_p($dir);
            file_put_contents($dir . '/.htaccess', "Options -Indexes\n<FilesMatch '\.(php|phtml|php3|php4|php5|php7|phps|phar)$'>\nDeny from all\n</FilesMatch>");
            file_put_contents($dir . '/index.php', '<?php // Silence is golden');
        }

        $name = wp_generate_uuid4() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
            return array('url' => $upload['baseurl'] . '/tez-inquiries/' . date('Y/m') . '/' . $name);
        }
        return array('error' => 'خطا در ذخیره فایل');
    }
}

// =============================================
// GET CLIENT IP
// =============================================
if (!function_exists('tez_svc_get_ip')) {
    function tez_svc_get_ip() {
        $keys = array('HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR');
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        return '0.0.0.0';
    }
}

// =============================================
// AJAX HANDLER
// =============================================
if (!function_exists('tez_svc_ajax')) {
    function tez_svc_ajax() {
        if (!isset($_POST['_nonce']) || !wp_verify_nonce($_POST['_nonce'], 'tez_svc_form')) {
            wp_send_json_error(array('message' => 'خطای امنیتی. لطفاً صفحه را رفرش کنید.'));
        }

        $ip = tez_svc_get_ip();
        $rate_key = 'tez_rate_' . md5($ip);
        $count = get_transient($rate_key);

        if ($count && $count >= TEZ_SVC_RATE_LIMIT) {
            wp_send_json_error(array('message' => 'تعداد درخواست‌های شما زیاد است. لطفاً ۱۵ دقیقه صبر کنید.'));
        }

        $name = sanitize_text_field($_POST['name'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $major = sanitize_text_field($_POST['major'] ?? '');
        $type = sanitize_text_field($_POST['type'] ?? '');
        $desc = sanitize_textarea_field($_POST['desc'] ?? '');
        $source = absint($_POST['source'] ?? 0);

        if (mb_strlen($name) < 3) {
            wp_send_json_error(array('message' => 'نام باید حداقل ۳ حرف باشد'));
        }
        if (!preg_match('/^09[0-9]{9}$/', $phone)) {
            wp_send_json_error(array('message' => 'شماره موبایل نامعتبر است'));
        }
        if (empty($major)) {
            wp_send_json_error(array('message' => 'رشته تحصیلی الزامی است'));
        }
        if (empty($type)) {
            wp_send_json_error(array('message' => 'نوع پروژه الزامی است'));
        }
        if (mb_strlen($desc) < 20) {
            wp_send_json_error(array('message' => 'توضیحات باید حداقل ۲۰ حرف باشد'));
        }

        $file_url = '';
        if (!empty($_FILES['file']['name'])) {
            $upload = tez_svc_upload($_FILES['file']);
            if (isset($upload['error'])) {
                wp_send_json_error(array('message' => $upload['error']));
            }
            $file_url = $upload['url'];
        }

        $post_id = wp_insert_post(array(
            'post_type'   => 'tez_inquiry',
            'post_title'  => sprintf('%s - %s - %s', $name, $type, current_time('Y/m/d H:i')),
            'post_status' => 'publish',
        ));

        if (is_wp_error($post_id)) {
            wp_send_json_error(array('message' => 'خطا در ثبت درخواست. لطفاً دوباره تلاش کنید.'));
        }

        update_post_meta($post_id, '_inq_name', $name);
        update_post_meta($post_id, '_inq_phone', $phone);
        update_post_meta($post_id, '_inq_major', $major);
        update_post_meta($post_id, '_inq_type', $type);
        update_post_meta($post_id, '_inq_desc', $desc);
        update_post_meta($post_id, '_inq_file', $file_url);
        update_post_meta($post_id, '_inq_source', $source);
        update_post_meta($post_id, '_inq_ip', $ip);

        set_transient($rate_key, ($count ? $count + 1 : 1), TEZ_SVC_RATE_TIMEOUT);

        $admin_email = get_option('admin_email');
        wp_mail(
            $admin_email,
            sprintf('درخواست جدید: %s', $name),
            sprintf("نام: %s\nتلفن: %s\nرشته: %s\nنوع: %s\n\nتوضیحات:\n%s\n\nمشاهده:\n%s",
                $name, $phone, $major, $type, $desc,
                admin_url('post.php?post=' . $post_id . '&action=edit')
            )
        );

        wp_send_json_success(array('message' => 'درخواست شما با موفقیت ثبت شد. کارشناسان ما به زودی با شما تماس خواهند گرفت.'));
    }
    add_action('wp_ajax_tez_svc_submit', 'tez_svc_ajax');
    add_action('wp_ajax_nopriv_tez_svc_submit', 'tez_svc_ajax');
}

// =============================================
// HELPER FUNCTIONS
// =============================================
if (!function_exists('tez_svc_render_stars')) {
    function tez_svc_render_stars($rating, $max = 5) {
        $output = '';
        $rating = floatval($rating);
        for ($i = 1; $i <= $max; $i++) {
            if ($i <= floor($rating)) {
                $output .= '<i class="fa-solid fa-star"></i>';
            } elseif ($i - 0.5 <= $rating) {
                $output .= '<i class="fa-solid fa-star-half-stroke"></i>';
            } else {
                $output .= '<i class="fa-regular fa-star"></i>';
            }
        }
        return $output;
    }
}

if (!function_exists('tez_svc_parse_lines')) {
    function tez_svc_parse_lines($data, $min_parts = 2) {
        $items = array();
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

if (!function_exists('tez_svc_to_persian')) {
    function tez_svc_to_persian($num) {
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($english, $persian, $num);
    }
}

// =============================================
// BREADCRUMB FUNCTION
// =============================================
if (!function_exists('tez_svc_breadcrumb')) {
    function tez_svc_breadcrumb($post_id) {
        $breadcrumbs = array();
        $breadcrumbs[] = array(
            'name' => 'خانه',
            'url'  => home_url('/'),
            'icon' => 'fa-solid fa-home',
        );

        // Get service category
        $categories = get_the_terms($post_id, 'tez_service_cat');
        if ($categories && !is_wp_error($categories)) {
            $cat = $categories[0];
            // Parent category
            if ($cat->parent) {
                $parent = get_term($cat->parent, 'tez_service_cat');
                if ($parent && !is_wp_error($parent)) {
                    $breadcrumbs[] = array(
                        'name' => $parent->name,
                        'url'  => get_term_link($parent),
                    );
                }
            }
            $breadcrumbs[] = array(
                'name' => $cat->name,
                'url'  => get_term_link($cat),
            );
        }

        // Current page
        $breadcrumbs[] = array(
            'name'    => get_the_title($post_id),
            'url'     => '',
            'current' => true,
        );

        return $breadcrumbs;
    }
}

// =============================================
// GET RELATED SERVICES
// =============================================
if (!function_exists('tez_svc_get_related')) {
    function tez_svc_get_related($post_id, $limit = 4) {
        $related = array();

        // Get categories and tags
        $categories = wp_get_post_terms($post_id, 'tez_service_cat', array('fields' => 'ids'));
        $tags = wp_get_post_terms($post_id, 'tez_service_tag', array('fields' => 'ids'));

        // Build tax_query
        $tax_query = array('relation' => 'OR');
        if (!empty($categories)) {
            $tax_query[] = array(
                'taxonomy' => 'tez_service_cat',
                'field'    => 'term_id',
                'terms'    => $categories,
            );
        }
        if (!empty($tags)) {
            $tax_query[] = array(
                'taxonomy' => 'tez_service_tag',
                'field'    => 'term_id',
                'terms'    => $tags,
            );
        }

        if (count($tax_query) > 1) {
            $query = new WP_Query(array(
                'post_type'      => 'page',
                'posts_per_page' => $limit,
                'post__not_in'   => array($post_id),
                'meta_key'       => '_tez_page_template',
                'meta_value'     => 'service',
                'tax_query'      => $tax_query,
                'orderby'        => 'rand',
            ));

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $related[] = array(
                        'id'       => get_the_ID(),
                        'title'    => get_the_title(),
                        'url'      => get_permalink(),
                        'icon'     => get_post_meta(get_the_ID(), '_tez_hero_icon', true) ?: 'fa-solid fa-star',
                        'subtitle' => get_post_meta(get_the_ID(), '_tez_hero_subtitle', true),
                        'price'    => get_post_meta(get_the_ID(), '_tez_price_from', true),
                        'rating'   => get_post_meta(get_the_ID(), '_tez_rating_value', true) ?: '4.8',
                        'labels'   => wp_get_post_terms(get_the_ID(), 'tez_service_label'),
                    );
                }
                wp_reset_postdata();
            }
        }

        return $related;
    }
}

// =============================================
// GET PAGE LABELS
// =============================================
if (!function_exists('tez_svc_get_labels')) {
    function tez_svc_get_labels($post_id) {
        $labels = wp_get_post_terms($post_id, 'tez_service_label');
        $formatted = array();

        if ($labels && !is_wp_error($labels)) {
            foreach ($labels as $label) {
                $formatted[] = array(
                    'name'  => $label->name,
                    'slug'  => $label->slug,
                    'color' => get_term_meta($label->term_id, '_label_color', true) ?: '#3b82f6',
                    'icon'  => get_term_meta($label->term_id, '_label_icon', true) ?: 'fa-solid fa-tag',
                    'url'   => get_term_link($label),
                );
            }
        }

        return $formatted;
    }
}

// =============================================
// CONTENT FILTER - MAIN TEMPLATE
// =============================================
if (!function_exists('tez_svc_content')) {
    function tez_svc_content($content) {
        if (!is_page() || !is_main_query()) {
            return $content;
        }

        $id = get_the_ID();

        if (get_post_meta($id, '_tez_page_template', true) !== 'service') {
            return $content;
        }

        // Get all meta
        $meta = array(
            'subtitle'        => get_post_meta($id, '_tez_hero_subtitle', true),
            'icon'            => get_post_meta($id, '_tez_hero_icon', true) ?: 'fa-solid fa-star',
            'bg'              => get_post_meta($id, '_tez_hero_bg_image', true),
            'video'           => get_post_meta($id, '_tez_hero_video', true),
            'features'        => get_post_meta($id, '_tez_features', true),
            'steps'           => get_post_meta($id, '_tez_process_steps', true),
            'price'           => get_post_meta($id, '_tez_price_from', true),
            'price_note'      => get_post_meta($id, '_tez_price_note', true),
            'testimonials'    => get_post_meta($id, '_tez_testimonials', true),
            'faq'             => get_post_meta($id, '_tez_faq', true),
            'cta_title'       => get_post_meta($id, '_tez_cta_title', true) ?: 'همین الان سفارش دهید',
            'cta_text'        => get_post_meta($id, '_tez_cta_text', true) ?: 'ثبت سفارش',
            'cta_secondary'   => get_post_meta($id, '_tez_hero_cta_secondary', true),
            'rating'          => get_post_meta($id, '_tez_rating_value', true) ?: '4.8',
            'rating_count'    => get_post_meta($id, '_tez_rating_count', true) ?: '127',
            'badges'          => get_post_meta($id, '_tez_trust_badges', true),
            'phone'           => get_post_meta($id, '_tez_quick_contact_phone', true),
            'completion'      => get_post_meta($id, '_tez_completion_count', true) ?: '2500',
            'satisfaction'    => get_post_meta($id, '_tez_satisfaction_rate', true) ?: '98',
            'stats'           => get_post_meta($id, '_tez_hero_stats', true),
            // E-E-A-T
            'author_name'     => get_post_meta($id, '_tez_author_name', true),
            'author_title'    => get_post_meta($id, '_tez_author_title', true),
            'author_bio'      => get_post_meta($id, '_tez_author_bio', true),
            'author_image'    => get_post_meta($id, '_tez_author_image', true),
            'author_social'   => get_post_meta($id, '_tez_author_social', true),
            'experience'      => get_post_meta($id, '_tez_experience_years', true),
            'credentials'     => get_post_meta($id, '_tez_credentials', true),
            'certifications'  => get_post_meta($id, '_tez_certifications', true),
            'published'       => get_post_meta($id, '_tez_published_date', true),
            'updated'         => get_post_meta($id, '_tez_updated_date', true),
            'reviewer_name'   => get_post_meta($id, '_tez_reviewer_name', true),
            'reviewer_title'  => get_post_meta($id, '_tez_reviewer_title', true),
            'sources'         => get_post_meta($id, '_tez_sources', true),
            'methodology'     => get_post_meta($id, '_tez_methodology', true),
            // Helpful Content
            'reading_time'    => get_post_meta($id, '_tez_reading_time', true),
            'difficulty'      => get_post_meta($id, '_tez_difficulty_level', true),
            'audience'        => get_post_meta($id, '_tez_target_audience', true),
            'takeaways'       => get_post_meta($id, '_tez_key_takeaways', true),
            'toc'             => get_post_meta($id, '_tez_table_of_contents', true),
        );

        $title = get_the_title();
        $url = get_permalink();
        $ajax = admin_url('admin-ajax.php');
        $nonce = wp_create_nonce('tez_svc_form');
        $breadcrumbs = tez_svc_breadcrumb($id);
        $labels = tez_svc_get_labels($id);
        $related = tez_svc_get_related($id, 4);

        ob_start();

        // Schema.org
        echo tez_svc_schema($id, $meta, $title, $url);

        // Styles
        echo tez_svc_styles($meta['bg']);

        // HTML
        echo tez_svc_html($meta, $title, $content, $ajax, $nonce, $id, $breadcrumbs, $labels, $related);

        // Scripts
        echo tez_svc_scripts($ajax);

        return ob_get_clean();
    }
    add_filter('the_content', 'tez_svc_content', 999);
}

// =============================================
// SCHEMA.ORG STRUCTURED DATA
// =============================================
if (!function_exists('tez_svc_schema')) {
    function tez_svc_schema($id, $meta, $title, $url) {
        // Build FAQ schema
        $faq_schema = array();
        if ($meta['faq']) {
            foreach (tez_svc_parse_lines($meta['faq'], 2) as $item) {
                $faq_schema[] = array(
                    '@type'          => 'Question',
                    'name'           => $item[0],
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text'  => $item[1],
                    ),
                );
            }
        }

        // Build reviews schema
        $reviews_schema = array();
        if ($meta['testimonials']) {
            foreach (tez_svc_parse_lines($meta['testimonials'], 4) as $item) {
                $reviews_schema[] = array(
                    '@type'        => 'Review',
                    'author'       => array('@type' => 'Person', 'name' => $item[0]),
                    'reviewRating' => array('@type' => 'Rating', 'ratingValue' => intval($item[3]), 'bestRating' => 5),
                    'reviewBody'   => $item[2],
                    'datePublished' => isset($item[4]) ? $item[4] : date('Y-m-d'),
                );
            }
        }

        // Service schema
        $service_schema = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => $title,
            'description' => $meta['subtitle'],
            'url'         => $url,
            'provider'    => array(
                '@type' => 'Organization',
                'name'  => get_bloginfo('name'),
                'url'   => home_url(),
            ),
            'aggregateRating' => array(
                '@type'       => 'AggregateRating',
                'ratingValue' => $meta['rating'],
                'reviewCount' => $meta['rating_count'],
                'bestRating'  => '5',
                'worstRating' => '1',
            ),
        );

        if ($meta['price']) {
            $service_schema['offers'] = array(
                '@type'           => 'Offer',
                'priceCurrency'   => 'IRR',
                'price'           => preg_replace('/[^0-9]/', '', $meta['price']),
                'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
            );
        }

        if (!empty($reviews_schema)) {
            $service_schema['review'] = $reviews_schema;
        }

        $output = '<script type="application/ld+json">' . wp_json_encode($service_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';

        // FAQ schema
        if (!empty($faq_schema)) {
            $faq_page = array(
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => $faq_schema,
            );
            $output .= '<script type="application/ld+json">' . wp_json_encode($faq_page, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
        }

        // Breadcrumb schema
        $breadcrumbs = tez_svc_breadcrumb($id);
        $bc_items = array();
        foreach ($breadcrumbs as $i => $bc) {
            $bc_items[] = array(
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $bc['name'],
                'item'     => $bc['url'] ?: $url,
            );
        }
        $bc_schema = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $bc_items,
        );
        $output .= '<script type="application/ld+json">' . wp_json_encode($bc_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';

        // Article/Author schema for E-E-A-T
        if ($meta['author_name']) {
            $article_schema = array(
                '@context'      => 'https://schema.org',
                '@type'         => 'Article',
                'headline'      => $title,
                'description'   => $meta['subtitle'],
                'author'        => array(
                    '@type'       => 'Person',
                    'name'        => $meta['author_name'],
                    'jobTitle'    => $meta['author_title'],
                    'description' => $meta['author_bio'],
                ),
                'publisher'     => array(
                    '@type' => 'Organization',
                    'name'  => get_bloginfo('name'),
                    'url'   => home_url(),
                ),
                'datePublished' => $meta['published'] ?: get_the_date('Y-m-d', $id),
                'dateModified'  => $meta['updated'] ?: get_the_modified_date('Y-m-d', $id),
            );

            if ($meta['reviewer_name']) {
                $article_schema['reviewedBy'] = array(
                    '@type'    => 'Person',
                    'name'     => $meta['reviewer_name'],
                    'jobTitle' => $meta['reviewer_title'],
                );
            }

            $output .= '<script type="application/ld+json">' . wp_json_encode($article_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
        }

        return $output;
    }
}

// =============================================
// STYLES
// =============================================
if (!function_exists('tez_svc_styles')) {
    function tez_svc_styles($bg_image) {
        ob_start();
        ?>
<style id="tez-svc-pro-styles">
/* =============================================
   CSS VARIABLES
   ============================================= */
:root {
    --svc-bg: #ffffff;
    --svc-bg-alt: #f8fafc;
    --svc-bg-card: #ffffff;
    --svc-text: #0f172a;
    --svc-text-muted: #64748b;
    --svc-text-light: #94a3b8;
    --svc-border: #e2e8f0;
    --svc-border-light: #f1f5f9;
    --svc-primary: #2563eb;
    --svc-primary-hover: #1d4ed8;
    --svc-primary-light: rgba(37, 99, 235, 0.1);
    --svc-secondary: #f97316;
    --svc-success: #10b981;
    --svc-warning: #f59e0b;
    --svc-error: #ef4444;
    --svc-gradient: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 50%, #fefce8 100%);
    --svc-gradient-accent: linear-gradient(135deg, #2563eb 0%, #7c3aed 50%, #f97316 100%);
    --svc-gradient-dark: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    --svc-shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
    --svc-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
    --svc-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --svc-shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --svc-shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --svc-shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    --svc-shadow-glow: 0 0 40px rgba(37, 99, 235, 0.15);
    --svc-radius-sm: 8px;
    --svc-radius: 12px;
    --svc-radius-lg: 16px;
    --svc-radius-xl: 24px;
    --svc-radius-full: 9999px;
    --svc-transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    --svc-transition-slow: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --svc-font: 'IRANSans', 'Tahoma', system-ui, sans-serif;
    --svc-container: 1280px;
    --svc-spacing: clamp(16px, 4vw, 32px);
}

/* Dark Mode */
[data-theme="dark"] {
    --svc-bg: #0f172a;
    --svc-bg-alt: #1e293b;
    --svc-bg-card: #1e293b;
    --svc-text: #f1f5f9;
    --svc-text-muted: #94a3b8;
    --svc-text-light: #64748b;
    --svc-border: #334155;
    --svc-border-light: #1e293b;
    --svc-primary-light: rgba(37, 99, 235, 0.2);
    --svc-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
    --svc-shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
}

/* =============================================
   BASE & RESET
   ============================================= */
.tez-svc-pro {
    direction: rtl;
    font-family: var(--svc-font);
    color: var(--svc-text);
    line-height: 1.7;
    font-size: 16px;
    background: var(--svc-bg);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.tez-svc-pro *,
.tez-svc-pro *::before,
.tez-svc-pro *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.tez-svc-pro img {
    max-width: 100%;
    height: auto;
    display: block;
}

.tez-svc-pro a {
    color: inherit;
    text-decoration: none;
    transition: var(--svc-transition);
}

.tez-svc-container {
    width: 100%;
    max-width: var(--svc-container);
    margin: 0 auto;
    padding: 0 var(--svc-spacing);
}

.tez-svc-bleed {
    width: 100vw;
    position: relative;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
}

/* =============================================
   BREADCRUMB
   ============================================= */
.tez-svc-breadcrumb {
    background: var(--svc-bg-alt);
    padding: 16px 0;
    border-bottom: 1px solid var(--svc-border-light);
}

.tez-svc-breadcrumb-list {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    list-style: none;
    font-size: 0.875rem;
}

.tez-svc-breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.tez-svc-breadcrumb-item a {
    color: var(--svc-text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
}

.tez-svc-breadcrumb-item a:hover {
    color: var(--svc-primary);
}

.tez-svc-breadcrumb-item.current {
    color: var(--svc-text);
    font-weight: 600;
}

.tez-svc-breadcrumb-separator {
    color: var(--svc-text-light);
    font-size: 0.75rem;
}

/* =============================================
   LABELS / TAGS
   ============================================= */
.tez-svc-labels {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}

.tez-svc-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: var(--svc-radius-full);
    font-size: 0.75rem;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    transition: var(--svc-transition);
}

.tez-svc-label:hover {
    transform: translateY(-2px);
    box-shadow: var(--svc-shadow);
    color: #fff;
}

.tez-svc-label i {
    font-size: 0.7rem;
}

/* =============================================
   HERO SECTION - ENHANCED
   ============================================= */
.tez-svc-hero {
    position: relative;
    min-height: 90vh;
    display: flex;
    align-items: center;
    background: var(--svc-gradient);
    overflow: hidden;
}

.tez-svc-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url('<?php echo esc_url($bg_image); ?>') center/cover no-repeat;
    opacity: 0.08;
    mix-blend-mode: multiply;
}

.tez-svc-hero-bg-effects {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
}

.tez-svc-hero-glow {
    position: absolute;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    filter: blur(100px);
    opacity: 0.5;
}

.tez-svc-hero-glow-1 {
    top: -200px;
    right: -100px;
    background: rgba(37, 99, 235, 0.3);
    animation: glowFloat 8s ease-in-out infinite;
}

.tez-svc-hero-glow-2 {
    bottom: -200px;
    left: -100px;
    background: rgba(249, 115, 22, 0.2);
    animation: glowFloat 10s ease-in-out infinite reverse;
}

@keyframes glowFloat {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(30px, -30px) scale(1.1); }
}

.tez-svc-hero-grid {
    position: absolute;
    inset: 0;
    background-image: 
        linear-gradient(rgba(37, 99, 235, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(37, 99, 235, 0.03) 1px, transparent 1px);
    background-size: 50px 50px;
    mask-image: radial-gradient(ellipse at center, black 0%, transparent 70%);
}

.tez-svc-hero-content {
    position: relative;
    z-index: 10;
    width: 100%;
    padding: 80px 0;
}

.tez-svc-hero-wrapper {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 60px;
    align-items: center;
}

.tez-svc-hero-main {
    max-width: 700px;
}

/* Hero Eyebrow */
.tez-svc-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    padding: 8px 16px 8px 12px;
    border-radius: var(--svc-radius-full);
    margin-bottom: 24px;
    border: 1px solid var(--svc-border-light);
    box-shadow: var(--svc-shadow-sm);
}

.tez-svc-hero-eyebrow-icon {
    width: 32px;
    height: 32px;
    background: var(--svc-gradient-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.875rem;
}

.tez-svc-hero-eyebrow-text {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--svc-text);
}

.tez-svc-hero-eyebrow-badge {
    background: var(--svc-success);
    color: #fff;
    font-size: 0.625rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: var(--svc-radius-full);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Hero Title */
.tez-svc-hero h1 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 900;
    line-height: 1.15;
    color: var(--svc-text);
    margin-bottom: 20px;
    letter-spacing: -0.02em;
}

.tez-svc-hero-subtitle {
    font-size: clamp(1rem, 2vw, 1.25rem);
    color: var(--svc-text-muted);
    line-height: 1.8;
    margin-bottom: 28px;
    max-width: 600px;
}

/* Hero Meta Info */
.tez-svc-hero-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
    margin-bottom: 32px;
}

.tez-svc-hero-rating {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    padding: 10px 16px;
    border-radius: var(--svc-radius);
    border: 1px solid var(--svc-border-light);
    box-shadow: var(--svc-shadow-sm);
}

.tez-svc-hero-stars {
    display: flex;
    gap: 2px;
    color: var(--svc-warning);
    font-size: 0.875rem;
}

.tez-svc-hero-rating-text {
    font-size: 0.875rem;
    color: var(--svc-text-muted);
}

.tez-svc-hero-rating-value {
    font-weight: 700;
    color: var(--svc-text);
}

/* Hero Avatars */
.tez-svc-hero-avatars {
    display: flex;
    align-items: center;
    gap: 12px;
}

.tez-svc-avatar-stack {
    display: flex;
    flex-direction: row-reverse;
}

.tez-svc-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--svc-gradient-accent);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #fff;
    margin-right: -10px;
    box-shadow: var(--svc-shadow-sm);
}

.tez-svc-avatar:nth-child(2) { background: linear-gradient(135deg, #10b981, #059669); }
.tez-svc-avatar:nth-child(3) { background: linear-gradient(135deg, #f59e0b, #d97706); }
.tez-svc-avatar:nth-child(4) { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.tez-svc-avatar-more { 
    background: var(--svc-bg-alt) !important; 
    color: var(--svc-text) !important;
    font-size: 0.625rem;
}

.tez-svc-avatars-text {
    font-size: 0.8125rem;
    color: var(--svc-text-muted);
}

/* Hero CTA Buttons */
.tez-svc-hero-cta-group {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 32px;
}

.tez-svc-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 16px 32px;
    border-radius: var(--svc-radius);
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    transition: var(--svc-transition);
    cursor: pointer;
    border: none;
    font-family: inherit;
}

.tez-svc-btn-primary {
    background: var(--svc-text);
    color: #fff;
    box-shadow: var(--svc-shadow-md);
}

.tez-svc-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--svc-shadow-lg);
    color: #fff;
}

.tez-svc-btn-secondary {
    background: #fff;
    color: var(--svc-text);
    border: 2px solid var(--svc-border);
}

.tez-svc-btn-secondary:hover {
    border-color: var(--svc-primary);
    color: var(--svc-primary);
    transform: translateY(-2px);
}

.tez-svc-btn i {
    font-size: 0.875rem;
}

/* Hero Trust Strip */
.tez-svc-hero-trust {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
}

.tez-svc-trust-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.875rem;
    color: var(--svc-text-muted);
}

.tez-svc-trust-item i {
    color: var(--svc-success);
}

/* Hero Sidebar Stats */
.tez-svc-hero-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.tez-svc-stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: var(--svc-radius-xl);
    padding: 28px 24px;
    border: 1px solid rgba(255, 255, 255, 0.8);
    box-shadow: var(--svc-shadow-lg);
}

.tez-svc-stat-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 12px 0;
}

.tez-svc-stat-icon {
    width: 48px;
    height: 48px;
    background: var(--svc-primary-light);
    border-radius: var(--svc-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--svc-primary);
    font-size: 1.25rem;
    flex-shrink: 0;
}

.tez-svc-stat-content {
    flex: 1;
}

.tez-svc-stat-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--svc-text);
    line-height: 1.2;
}

.tez-svc-stat-label {
    font-size: 0.8125rem;
    color: var(--svc-text-muted);
}

.tez-svc-stat-divider {
    height: 1px;
    background: var(--svc-border-light);
    margin: 4px 0;
}

/* Quick Contact Card */
.tez-svc-quick-contact {
    background: var(--svc-gradient-dark);
    border-radius: var(--svc-radius-xl);
    padding: 24px;
    color: #fff;
    text-align: center;
}

.tez-svc-quick-contact-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-weight: 700;
    margin-bottom: 16px;
}

.tez-svc-quick-contact-title i {
    color: var(--svc-warning);
}

.tez-svc-quick-contact-phone {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.1);
    padding: 14px 20px;
    border-radius: var(--svc-radius);
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 12px;
    transition: var(--svc-transition);
}

.tez-svc-quick-contact-phone:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
}

.tez-svc-quick-contact-status {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.75rem;
    opacity: 0.9;
}

.tez-svc-status-dot {
    width: 8px;
    height: 8px;
    background: var(--svc-success);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

/* Hero Scroll Indicator */
.tez-svc-scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

.tez-svc-scroll-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: var(--svc-text-muted);
    font-size: 0.75rem;
}

.tez-svc-scroll-icon {
    width: 30px;
    height: 50px;
    border: 2px solid currentColor;
    border-radius: 15px;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding-top: 8px;
}

.tez-svc-scroll-icon::before {
    content: '';
    width: 4px;
    height: 8px;
    background: currentColor;
    border-radius: 2px;
    animation: scrollDown 1.5s ease-in-out infinite;
}

@keyframes scrollDown {
    0%, 100% { transform: translateY(0); opacity: 1; }
    50% { transform: translateY(10px); opacity: 0; }
}

/* =============================================
   E-E-A-T AUTHOR BOX
   ============================================= */
.tez-svc-eeat-section {
    background: var(--svc-bg-alt);
    padding: 60px 0;
    border-top: 1px solid var(--svc-border-light);
    border-bottom: 1px solid var(--svc-border-light);
}

.tez-svc-eeat-card {
    background: var(--svc-bg-card);
    border-radius: var(--svc-radius-xl);
    padding: 32px;
    box-shadow: var(--svc-shadow);
    border: 1px solid var(--svc-border-light);
}

.tez-svc-eeat-header {
    display: flex;
    align-items: flex-start;
    gap: 24px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.tez-svc-eeat-avatar {
    width: 100px;
    height: 100px;
    border-radius: var(--svc-radius-lg);
    object-fit: cover;
    border: 3px solid var(--svc-border-light);
    flex-shrink: 0;
}

.tez-svc-eeat-avatar-placeholder {
    width: 100px;
    height: 100px;
    border-radius: var(--svc-radius-lg);
    background: var(--svc-gradient-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 2.5rem;
    font-weight: 700;
    flex-shrink: 0;
}

.tez-svc-eeat-info {
    flex: 1;
    min-width: 200px;
}

.tez-svc-eeat-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--svc-primary-light);
    color: var(--svc-primary);
    padding: 4px 12px;
    border-radius: var(--svc-radius-full);
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.tez-svc-eeat-name {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--svc-text);
    margin-bottom: 4px;
}

.tez-svc-eeat-title {
    color: var(--svc-text-muted);
    font-size: 0.9375rem;
    margin-bottom: 12px;
}

.tez-svc-eeat-credentials {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 16px;
}

.tez-svc-eeat-credential {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.8125rem;
    color: var(--svc-text-muted);
}

.tez-svc-eeat-credential i {
    color: var(--svc-success);
}

.tez-svc-eeat-social {
    display: flex;
    gap: 10px;
}

.tez-svc-eeat-social a {
    width: 36px;
    height: 36px;
    background: var(--svc-bg-alt);
    border-radius: var(--svc-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--svc-text-muted);
    transition: var(--svc-transition);
}

.tez-svc-eeat-social a:hover {
    background: var(--svc-primary);
    color: #fff;
}

.tez-svc-eeat-bio {
    color: var(--svc-text-muted);
    line-height: 1.8;
    margin-bottom: 24px;
    padding-top: 16px;
    border-top: 1px solid var(--svc-border-light);
}

.tez-svc-eeat-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--svc-border-light);
}

.tez-svc-eeat-meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.tez-svc-eeat-meta-icon {
    width: 40px;
    height: 40px;
    background: var(--svc-bg-alt);
    border-radius: var(--svc-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--svc-primary);
    font-size: 1rem;
    flex-shrink: 0;
}

.tez-svc-eeat-meta-content {
    font-size: 0.8125rem;
}

.tez-svc-eeat-meta-label {
    color: var(--svc-text-light);
    display: block;
}

.tez-svc-eeat-meta-value {
    color: var(--svc-text);
    font-weight: 600;
}

/* =============================================
   HELPFUL CONTENT - KEY TAKEAWAYS
   ============================================= */
.tez-svc-takeaways {
    background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
    border-radius: var(--svc-radius-xl);
    padding: 32px;
    margin: 40px 0;
    border: 1px solid var(--svc-border-light);
}

.tez-svc-takeaways-title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--svc-text);
    margin-bottom: 20px;
}

.tez-svc-takeaways-title i {
    color: var(--svc-success);
}

.tez-svc-takeaways-list {
    list-style: none;
    display: grid;
    gap: 12px;
}

.tez-svc-takeaways-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 16px;
    background: #fff;
    border-radius: var(--svc-radius);
    box-shadow: var(--svc-shadow-xs);
}

.tez-svc-takeaways-item i {
    color: var(--svc-success);
    margin-top: 4px;
    flex-shrink: 0;
}

.tez-svc-takeaways-item span {
    color: var(--svc-text);
    line-height: 1.6;
}

/* =============================================
   TABLE OF CONTENTS
   ============================================= */
.tez-svc-toc {
    background: var(--svc-bg-card);
    border-radius: var(--svc-radius-lg);
    padding: 24px;
    margin: 40px 0;
    border: 1px solid var(--svc-border);
    box-shadow: var(--svc-shadow-sm);
}

.tez-svc-toc-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    font-weight: 700;
    color: var(--svc-text);
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--svc-border-light);
}

.tez-svc-toc-title i {
    color: var(--svc-primary);
}

.tez-svc-toc-list {
    list-style: none;
    display: grid;
    gap: 8px;
}

.tez-svc-toc-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.tez-svc-toc-item a {
    color: var(--svc-text-muted);
    font-size: 0.9375rem;
    padding: 8px 12px;
    border-radius: var(--svc-radius-sm);
    flex: 1;
    transition: var(--svc-transition);
}

.tez-svc-toc-item a:hover {
    background: var(--svc-primary-light);
    color: var(--svc-primary);
}

.tez-svc-toc-number {
    width: 24px;
    height: 24px;
    background: var(--svc-bg-alt);
    border-radius: var(--svc-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--svc-text-muted);
    flex-shrink: 0;
}

/* =============================================
   CONTENT META BAR
   ============================================= */
.tez-svc-content-meta {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
    padding: 16px 0;
    margin: 24px 0;
    border-top: 1px solid var(--svc-border-light);
    border-bottom: 1px solid var(--svc-border-light);
}

.tez-svc-content-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.8125rem;
    color: var(--svc-text-muted);
}

.tez-svc-content-meta-item i {
    color: var(--svc-primary);
}

.tez-svc-difficulty-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: var(--svc-radius-full);
    font-size: 0.75rem;
    font-weight: 600;
}

.tez-svc-difficulty-beginner { background: #dcfce7; color: #166534; }
.tez-svc-difficulty-intermediate { background: #fef3c7; color: #92400e; }
.tez-svc-difficulty-advanced { background: #fee2e2; color: #991b1b; }

/* =============================================
   SECTIONS
   ============================================= */
.tez-svc-section {
    padding: 80px 0;
}

.tez-svc-section-alt {
    background: var(--svc-bg-alt);
}

.tez-svc-section-title {
    text-align: center;
    margin-bottom: 48px;
}

.tez-svc-section-title h2 {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 800;
    color: var(--svc-text);
    margin-bottom: 12px;
    display: inline-flex;
    align-items: center;
    gap: 12px;
}

.tez-svc-section-title h2 i {
    color: var(--svc-primary);
}

.tez-svc-section-title p {
    color: var(--svc-text-muted);
    font-size: 1.0625rem;
    max-width: 600px;
    margin: 0 auto;
}

/* =============================================
   FORM SECTION
   ============================================= */
.tez-svc-form-section {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(249, 115, 22, 0.05) 100%);
    padding: 80px 0;
}

.tez-svc-form-card {
    background: var(--svc-bg-card);
    border-radius: var(--svc-radius-xl);
    padding: 40px;
    max-width: 800px;
    margin: 0 auto;
    box-shadow: var(--svc-shadow-lg);
    border: 1px solid var(--svc-border-light);
}

.tez-svc-form-header {
    text-align: center;
    margin-bottom: 32px;
}

.tez-svc-form-header h3 {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--svc-text);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.tez-svc-form-header h3 i {
    color: var(--svc-primary);
}

.tez-svc-form-header p {
    color: var(--svc-text-muted);
}

.tez-svc-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.tez-svc-form-field {
    margin-bottom: 0;
}

.tez-svc-form-field.full-width {
    grid-column: 1 / -1;
}

.tez-svc-form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    font-size: 0.9375rem;
    color: var(--svc-text);
    margin-bottom: 8px;
}

.tez-svc-form-label i {
    color: var(--svc-primary);
    font-size: 0.875rem;
}

.tez-svc-form-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid var(--svc-border);
    border-radius: var(--svc-radius);
    font-size: 1rem;
    font-family: inherit;
    color: var(--svc-text);
    background: var(--svc-bg);
    transition: var(--svc-transition);
}

.tez-svc-form-input:focus {
    outline: none;
    border-color: var(--svc-primary);
    box-shadow: 0 0 0 4px var(--svc-primary-light);
}

.tez-svc-form-input::placeholder {
    color: var(--svc-text-light);
}

textarea.tez-svc-form-input {
    min-height: 120px;
    resize: vertical;
}

select.tez-svc-form-input {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%2364748b' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: left 12px center;
    background-size: 20px;
    padding-left: 40px;
}

/* File Upload */
.tez-svc-file-upload {
    border: 2px dashed var(--svc-border);
    border-radius: var(--svc-radius);
    padding: 32px;
    text-align: center;
    cursor: pointer;
    transition: var(--svc-transition);
    background: var(--svc-bg);
}

.tez-svc-file-upload:hover {
    border-color: var(--svc-primary);
    background: var(--svc-primary-light);
}

.tez-svc-file-upload.dragover {
    border-color: var(--svc-primary);
    background: var(--svc-primary-light);
}

.tez-svc-file-upload-icon {
    font-size: 2rem;
    color: var(--svc-text-muted);
    margin-bottom: 12px;
}

.tez-svc-file-upload-text {
    color: var(--svc-text-muted);
    margin-bottom: 4px;
}

.tez-svc-file-upload-hint {
    font-size: 0.8125rem;
    color: var(--svc-text-light);
}

.tez-svc-file-upload input {
    display: none;
}

.tez-svc-file-name {
    margin-top: 12px;
    color: var(--svc-primary);
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

/* Submit Button */
.tez-svc-form-submit {
    width: 100%;
    margin-top: 24px;
    padding: 18px 32px;
    font-size: 1.0625rem;
}

/* Message */
.tez-svc-form-message {
    padding: 16px 20px;
    border-radius: var(--svc-radius);
    margin-top: 20px;
    display: none;
    align-items: center;
    gap: 12px;
    font-weight: 500;
}

.tez-svc-form-message.success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
    display: flex;
}

.tez-svc-form-message.error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
    display: flex;
}

/* =============================================
   FEATURES GRID
   ============================================= */
.tez-svc-features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}

.tez-svc-feature-card {
    background: var(--svc-bg-card);
    border-radius: var(--svc-radius-lg);
    padding: 32px;
    border: 1px solid var(--svc-border-light);
    transition: var(--svc-transition-slow);
    position: relative;
    overflow: hidden;
}

.tez-svc-feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--svc-gradient-accent);
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s ease;
}

.tez-svc-feature-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--svc-shadow-lg);
    border-color: transparent;
}

.tez-svc-feature-card:hover::before {
    transform: scaleX(1);
    transform-origin: left;
}

.tez-svc-feature-icon {
    width: 56px;
    height: 56px;
    background: var(--svc-primary-light);
    border-radius: var(--svc-radius);
    display: flex;
	    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--svc-primary);
    margin-bottom: 20px;
    transition: var(--svc-transition);
}

.tez-svc-feature-card:hover .tez-svc-feature-icon {
    background: var(--svc-gradient-accent);
    color: #fff;
    transform: scale(1.1) rotate(-5deg);
}

.tez-svc-feature-card h4 {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--svc-text);
    margin-bottom: 10px;
}

.tez-svc-feature-card p {
    color: var(--svc-text-muted);
    font-size: 0.9375rem;
    line-height: 1.7;
}

/* =============================================
   PROCESS STEPS
   ============================================= */
.tez-svc-steps {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 40px;
    counter-reset: step;
}

.tez-svc-step {
    flex: 1;
    min-width: 200px;
    max-width: 280px;
    text-align: center;
}

.tez-svc-step-icon {
    width: 80px;
    height: 80px;
    background: var(--svc-gradient-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #fff;
    margin: 0 auto 20px;
    position: relative;
    box-shadow: var(--svc-shadow-md);
    transition: var(--svc-transition);
}

.tez-svc-step:hover .tez-svc-step-icon {
    transform: scale(1.1);
    box-shadow: var(--svc-shadow-lg);
}

.tez-svc-step-icon::before {
    counter-increment: step;
    content: counter(step);
    position: absolute;
    top: -8px;
    right: -8px;
    width: 28px;
    height: 28px;
    background: var(--svc-warning);
    border-radius: 50%;
    font-size: 0.8125rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1e293b;
    border: 3px solid var(--svc-bg);
}

.tez-svc-step h4 {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--svc-text);
    margin-bottom: 8px;
}

.tez-svc-step p {
    color: var(--svc-text-muted);
    font-size: 0.875rem;
    line-height: 1.6;
}

/* =============================================
   PRICING CARD
   ============================================= */
.tez-svc-pricing-card {
    background: linear-gradient(135deg, #eff6ff 0%, #fff 50%, #fef3c7 100%);
    border-radius: var(--svc-radius-xl);
    padding: 48px 40px;
    text-align: center;
    max-width: 500px;
    margin: 0 auto;
    box-shadow: var(--svc-shadow-lg);
    position: relative;
    overflow: hidden;
}

.tez-svc-pricing-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    animation: pricingGlow 6s ease-in-out infinite;
}

@keyframes pricingGlow {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.tez-svc-pricing-card > * {
    position: relative;
    z-index: 2;
}

.tez-svc-pricing-label {
    font-size: 0.9375rem;
    color: var(--svc-text-muted);
    margin-bottom: 8px;
}

.tez-svc-pricing-value {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 900;
    color: var(--svc-text);
    margin-bottom: 8px;
}

.tez-svc-pricing-note {
    color: var(--svc-text-muted);
    font-size: 0.875rem;
    margin-bottom: 28px;
}

.tez-svc-pricing-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--svc-text);
    color: #fff;
    padding: 16px 36px;
    border-radius: var(--svc-radius);
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: var(--svc-transition);
    box-shadow: var(--svc-shadow-md);
}

.tez-svc-pricing-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--svc-shadow-lg);
    color: #fff;
}

/* =============================================
   TESTIMONIALS
   ============================================= */
.tez-svc-testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}

.tez-svc-testimonial {
    background: var(--svc-bg-card);
    border-radius: var(--svc-radius-lg);
    padding: 28px;
    border: 1px solid var(--svc-border-light);
    transition: var(--svc-transition);
    position: relative;
}

.tez-svc-testimonial::before {
    content: '"';
    position: absolute;
    top: 16px;
    right: 20px;
    font-size: 3rem;
    color: var(--svc-primary);
    opacity: 0.1;
    font-family: Georgia, serif;
    line-height: 1;
}

.tez-svc-testimonial:hover {
    transform: translateY(-4px);
    box-shadow: var(--svc-shadow-md);
    border-color: var(--svc-primary);
}

.tez-svc-testimonial-stars {
    display: flex;
    gap: 3px;
    color: var(--svc-warning);
    font-size: 0.875rem;
    margin-bottom: 16px;
}

.tez-svc-testimonial-text {
    color: var(--svc-text);
    line-height: 1.8;
    margin-bottom: 20px;
    font-size: 0.9375rem;
}

.tez-svc-testimonial-author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.tez-svc-testimonial-avatar {
    width: 48px;
    height: 48px;
    background: var(--svc-gradient-accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 1.125rem;
    flex-shrink: 0;
}

.tez-svc-testimonial-info {
    flex: 1;
}

.tez-svc-testimonial-name {
    font-weight: 700;
    color: var(--svc-text);
    font-size: 0.9375rem;
    margin-bottom: 2px;
}

.tez-svc-testimonial-major {
    font-size: 0.8125rem;
    color: var(--svc-text-muted);
}

/* =============================================
   FAQ ACCORDION
   ============================================= */
.tez-svc-faq-list {
    max-width: 800px;
    margin: 0 auto;
}

.tez-svc-faq-item {
    background: var(--svc-bg-card);
    border-radius: var(--svc-radius);
    margin-bottom: 12px;
    border: 1px solid var(--svc-border-light);
    overflow: hidden;
    transition: var(--svc-transition);
}

.tez-svc-faq-item:hover {
    border-color: var(--svc-primary);
}

.tez-svc-faq-item.active {
    border-color: var(--svc-primary);
    box-shadow: var(--svc-shadow);
}

.tez-svc-faq-q {
    width: 100%;
    padding: 20px 24px;
    background: none;
    border: none;
    text-align: right;
    font-size: 1rem;
    font-weight: 600;
    color: var(--svc-text);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    font-family: inherit;
    transition: var(--svc-transition);
}

.tez-svc-faq-q:hover {
    color: var(--svc-primary);
}

.tez-svc-faq-q i {
    color: var(--svc-primary);
    transition: var(--svc-transition);
    flex-shrink: 0;
}

.tez-svc-faq-item.active .tez-svc-faq-q i {
    transform: rotate(180deg);
}

.tez-svc-faq-a {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
}

.tez-svc-faq-item.active .tez-svc-faq-a {
    max-height: 500px;
    padding: 0 24px 20px;
}

.tez-svc-faq-a p {
    color: var(--svc-text-muted);
    line-height: 1.8;
}

/* =============================================
   CTA SECTION
   ============================================= */
.tez-svc-cta {
    background: var(--svc-gradient);
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.tez-svc-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23000000' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.tez-svc-cta > * {
    position: relative;
    z-index: 2;
}

.tez-svc-cta h2 {
    font-size: clamp(1.5rem, 4vw, 2.25rem);
    font-weight: 800;
    color: var(--svc-text);
    margin-bottom: 12px;
}

.tez-svc-cta p {
    color: var(--svc-text-muted);
    font-size: 1.0625rem;
    margin-bottom: 28px;
}

.tez-svc-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: var(--svc-text);
    color: #fff;
    padding: 18px 40px;
    border-radius: var(--svc-radius);
    font-weight: 700;
    font-size: 1.0625rem;
    text-decoration: none;
    transition: var(--svc-transition);
    box-shadow: var(--svc-shadow-md);
}

.tez-svc-cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--svc-shadow-lg);
    color: #fff;
}

/* =============================================
   RELATED SERVICES
   ============================================= */
.tez-svc-related {
    padding: 80px 0;
    background: var(--svc-bg-alt);
}

.tez-svc-related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}

.tez-svc-related-card {
    background: var(--svc-bg-card);
    border-radius: var(--svc-radius-lg);
    padding: 24px;
    border: 1px solid var(--svc-border-light);
    text-decoration: none;
    transition: var(--svc-transition);
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.tez-svc-related-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--svc-shadow-lg);
    border-color: var(--svc-primary);
}

.tez-svc-related-card-labels {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 16px;
}

.tez-svc-related-card-label {
    font-size: 0.6875rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: var(--svc-radius-full);
    color: #fff;
}

.tez-svc-related-card-icon {
    width: 52px;
    height: 52px;
    background: var(--svc-primary-light);
    border-radius: var(--svc-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--svc-primary);
    margin-bottom: 16px;
    transition: var(--svc-transition);
}

.tez-svc-related-card:hover .tez-svc-related-card-icon {
    background: var(--svc-gradient-accent);
    color: #fff;
}

.tez-svc-related-card-title {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--svc-text);
    margin-bottom: 8px;
    transition: var(--svc-transition);
}

.tez-svc-related-card:hover .tez-svc-related-card-title {
    color: var(--svc-primary);
}

.tez-svc-related-card-subtitle {
    font-size: 0.875rem;
    color: var(--svc-text-muted);
    line-height: 1.6;
    margin-bottom: 16px;
    flex: 1;
}

.tez-svc-related-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 16px;
    border-top: 1px solid var(--svc-border-light);
}

.tez-svc-related-card-price {
    font-size: 0.875rem;
    color: var(--svc-text-muted);
}

.tez-svc-related-card-price strong {
    color: var(--svc-primary);
    font-weight: 700;
}

.tez-svc-related-card-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.8125rem;
    color: var(--svc-text-muted);
}

.tez-svc-related-card-rating i {
    color: var(--svc-warning);
}

/* =============================================
   SOURCES SECTION (E-E-A-T)
   ============================================= */
.tez-svc-sources {
    background: var(--svc-bg-alt);
    border-radius: var(--svc-radius-lg);
    padding: 24px;
    margin: 40px 0;
    border: 1px solid var(--svc-border-light);
}

.tez-svc-sources-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    font-weight: 700;
    color: var(--svc-text);
    margin-bottom: 16px;
}

.tez-svc-sources-title i {
    color: var(--svc-primary);
}

.tez-svc-sources-list {
    list-style: none;
    display: grid;
    gap: 10px;
}

.tez-svc-sources-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 0.875rem;
    color: var(--svc-text-muted);
}

.tez-svc-sources-item::before {
    content: '';
    width: 6px;
    height: 6px;
    background: var(--svc-primary);
    border-radius: 50%;
    margin-top: 8px;
    flex-shrink: 0;
}

.tez-svc-sources-item a {
    color: var(--svc-primary);
    text-decoration: underline;
}

.tez-svc-sources-item a:hover {
    color: var(--svc-primary-hover);
}

/* =============================================
   METHODOLOGY SECTION (E-E-A-T)
   ============================================= */
.tez-svc-methodology {
    background: linear-gradient(135deg, #fef3c7 0%, #fff 100%);
    border-radius: var(--svc-radius-lg);
    padding: 24px;
    margin: 40px 0;
    border: 1px solid #fde68a;
}

.tez-svc-methodology-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    font-weight: 700;
    color: var(--svc-text);
    margin-bottom: 12px;
}

.tez-svc-methodology-title i {
    color: var(--svc-warning);
}

.tez-svc-methodology-text {
    color: var(--svc-text-muted);
    line-height: 1.8;
    font-size: 0.9375rem;
}

/* =============================================
   CONTENT SECTION
   ============================================= */
.tez-svc-content-section {
    padding: 60px 0;
    background: var(--svc-bg);
}

.tez-svc-content-inner {
    max-width: 800px;
    margin: 0 auto;
}

.tez-svc-content-inner h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--svc-text);
    margin: 32px 0 16px;
}

.tez-svc-content-inner h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--svc-text);
    margin: 24px 0 12px;
}

.tez-svc-content-inner p {
    color: var(--svc-text);
    line-height: 1.9;
    margin-bottom: 16px;
}

.tez-svc-content-inner ul,
.tez-svc-content-inner ol {
    margin: 16px 0;
    padding-right: 24px;
}

.tez-svc-content-inner li {
    color: var(--svc-text);
    line-height: 1.8;
    margin-bottom: 8px;
}

/* =============================================
   MOBILE RESPONSIVE - ENHANCED
   ============================================= */
@media (max-width: 1024px) {
    .tez-svc-hero-wrapper {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }
    
    .tez-svc-hero-main {
        max-width: 100%;
    }
    
    .tez-svc-hero-subtitle {
        margin-left: auto;
        margin-right: auto;
    }
    
    .tez-svc-hero-meta {
        justify-content: center;
    }
    
    .tez-svc-hero-cta-group {
        justify-content: center;
    }
    
    .tez-svc-hero-trust {
        justify-content: center;
    }
    
    .tez-svc-hero-sidebar {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .tez-svc-stats-card,
    .tez-svc-quick-contact {
        flex: 1;
        min-width: 280px;
        max-width: 400px;
    }
    
    .tez-svc-scroll-indicator {
        display: none;
    }
    
    .tez-svc-eeat-header {
        flex-direction: column;
        text-align: center;
    }
    
    .tez-svc-eeat-credentials {
        justify-content: center;
    }
    
    .tez-svc-eeat-social {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    :root {
        --svc-spacing: 16px;
    }
    
    .tez-svc-hero {
        min-height: auto;
        padding: 100px 0 60px;
    }
    
    .tez-svc-hero-content {
        padding: 60px 0;
    }
    
    .tez-svc-hero-eyebrow {
        padding: 6px 12px 6px 8px;
    }
    
    .tez-svc-hero-eyebrow-icon {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }
    
    .tez-svc-hero-eyebrow-text {
        font-size: 0.8125rem;
    }
    
    .tez-svc-hero h1 {
        font-size: clamp(1.5rem, 6vw, 2rem);
    }
    
    .tez-svc-hero-subtitle {
        font-size: 0.9375rem;
    }
    
    .tez-svc-hero-meta {
        flex-direction: column;
        gap: 12px;
    }
    
    .tez-svc-hero-cta-group {
        flex-direction: column;
        width: 100%;
    }
    
    .tez-svc-btn {
        width: 100%;
        justify-content: center;
        padding: 14px 24px;
    }
    
    .tez-svc-hero-trust {
        flex-direction: column;
        gap: 8px;
    }
    
    .tez-svc-hero-sidebar {
        flex-direction: column;
    }
    
    .tez-svc-stats-card,
    .tez-svc-quick-contact {
        max-width: 100%;
    }
    
    .tez-svc-stat-item {
        padding: 10px 0;
    }
    
    .tez-svc-stat-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .tez-svc-stat-number {
        font-size: 1.25rem;
    }
    
    .tez-svc-section {
        padding: 60px 0;
    }
    
    .tez-svc-section-title {
        margin-bottom: 32px;
    }
    
    .tez-svc-section-title h2 {
        font-size: 1.25rem;
        flex-direction: column;
        gap: 8px;
    }
    
    .tez-svc-form-card {
        padding: 24px 16px;
    }
    
    .tez-svc-form-grid {
        grid-template-columns: 1fr;
    }
    
    .tez-svc-form-header h3 {
        font-size: 1.25rem;
    }
    
    .tez-svc-form-input {
        padding: 12px 14px;
    }
    
    .tez-svc-file-upload {
        padding: 24px 16px;
    }
    
    .tez-svc-file-upload-icon {
        font-size: 1.5rem;
    }
    
    .tez-svc-features-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .tez-svc-feature-card {
        padding: 24px;
    }
    
    .tez-svc-feature-icon {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
    }
    
    .tez-svc-steps {
        flex-direction: column;
        gap: 24px;
    }
    
    .tez-svc-step {
        max-width: 100%;
    }
    
    .tez-svc-step-icon {
        width: 64px;
        height: 64px;
        font-size: 1.5rem;
    }
    
    .tez-svc-step-icon::before {
        width: 24px;
        height: 24px;
        font-size: 0.6875rem;
    }
    
    .tez-svc-pricing-card {
        padding: 32px 24px;
    }
    
    .tez-svc-testimonials-grid {
        grid-template-columns: 1fr;
    }
    
    .tez-svc-testimonial {
        padding: 24px;
    }
    
    .tez-svc-faq-q {
        padding: 16px 20px;
        font-size: 0.9375rem;
    }
    
    .tez-svc-faq-item.active .tez-svc-faq-a {
        padding: 0 20px 16px;
    }
    
    .tez-svc-cta {
        padding: 60px 0;
    }
    
    .tez-svc-cta-btn {
        width: 100%;
        justify-content: center;
        padding: 16px 32px;
    }
    
    .tez-svc-related-grid {
        grid-template-columns: 1fr;
    }
    
    .tez-svc-eeat-card {
        padding: 24px;
    }
    
    .tez-svc-eeat-avatar,
    .tez-svc-eeat-avatar-placeholder {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .tez-svc-eeat-name {
        font-size: 1.25rem;
    }
    
    .tez-svc-eeat-meta {
        grid-template-columns: 1fr;
    }
    
    .tez-svc-takeaways {
        padding: 24px;
    }
    
    .tez-svc-takeaways-item {
        padding: 10px 12px;
    }
    
    .tez-svc-toc {
        padding: 20px;
    }
    
    .tez-svc-content-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .tez-svc-breadcrumb-list {
        font-size: 0.8125rem;
    }
}

@media (max-width: 480px) {
    .tez-svc-hero h1 {
        font-size: 1.375rem;
    }
    
    .tez-svc-labels {
        gap: 6px;
    }
    
    .tez-svc-label {
        padding: 4px 10px;
        font-size: 0.6875rem;
    }
    
    .tez-svc-hero-rating {
        width: 100%;
        justify-content: center;
    }
    
    .tez-svc-avatar-stack {
        transform: scale(0.9);
    }
    
    .tez-svc-avatars-text {
        font-size: 0.75rem;
    }
    
    .tez-svc-pricing-value {
        font-size: 1.75rem;
    }
    
    .tez-svc-testimonial-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .tez-svc-related-card {
        padding: 20px;
    }
    
    .tez-svc-related-card-icon {
        width: 44px;
        height: 44px;
        font-size: 1rem;
    }
}

/* =============================================
   PRINT STYLES
   ============================================= */
@media print {
    .tez-svc-hero-cta-group,
    .tez-svc-form-section,
    .tez-svc-cta,
    .tez-svc-quick-contact,
    .tez-svc-scroll-indicator {
        display: none !important;
    }
    
    .tez-svc-hero {
        min-height: auto;
        padding: 40px 0;
        background: #f5f5f5 !important;
        color: #000 !important;
    }
    
    .tez-svc-section {
        padding: 30px 0;
    }
}

/* =============================================
   ACCESSIBILITY
   ============================================= */
.tez-svc-pro *:focus-visible {
    outline: 2px solid var(--svc-primary);
    outline-offset: 2px;
}

.tez-svc-sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

@media (prefers-reduced-motion: reduce) {
    .tez-svc-pro *,
    .tez-svc-pro *::before,
    .tez-svc-pro *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    :root {
        --svc-border: #000;
        --svc-text-muted: #333;
    }
    
    .tez-svc-btn-primary,
    .tez-svc-cta-btn {
        border: 2px solid #000;
    }
}
</style>
        <?php
        return ob_get_clean();
    }
}

// =============================================
// HTML TEMPLATE
// =============================================
if (!function_exists('tez_svc_html')) {
    function tez_svc_html($meta, $title, $content, $ajax, $nonce, $id, $breadcrumbs, $labels, $related) {
        ob_start();
        ?>
<div class="tez-svc-pro">
    <!-- Breadcrumb -->
    <nav class="tez-svc-breadcrumb tez-svc-bleed" aria-label="مسیر صفحه">
        <div class="tez-svc-container">
            <ol class="tez-svc-breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <?php foreach ($breadcrumbs as $i => $bc) : ?>
                <li class="tez-svc-breadcrumb-item <?php echo !empty($bc['current']) ? 'current' : ''; ?>" 
                    itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <?php if ($i > 0) : ?>
                    <span class="tez-svc-breadcrumb-separator"><i class="fa-solid fa-chevron-left"></i></span>
                    <?php endif; ?>
                    <?php if (!empty($bc['current'])) : ?>
                    <span itemprop="name"><?php echo esc_html($bc['name']); ?></span>
                    <?php else : ?>
                    <a href="<?php echo esc_url($bc['url']); ?>" itemprop="item">
                        <?php if (!empty($bc['icon'])) : ?>
                        <i class="<?php echo esc_attr($bc['icon']); ?>"></i>
                        <?php endif; ?>
                        <span itemprop="name"><?php echo esc_html($bc['name']); ?></span>
                    </a>
                    <?php endif; ?>
                    <meta itemprop="position" content="<?php echo $i + 1; ?>">
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </nav>

    <!-- Hero Section - Enhanced -->
    <section class="tez-svc-hero tez-svc-bleed" id="tez-hero">
        <div class="tez-svc-hero-bg-effects">
            <div class="tez-svc-hero-glow tez-svc-hero-glow-1"></div>
            <div class="tez-svc-hero-glow tez-svc-hero-glow-2"></div>
            <div class="tez-svc-hero-grid"></div>
        </div>
        
        <?php if ($meta['video']) : ?>
        <div class="tez-svc-hero-video">
            <video autoplay muted loop playsinline poster="<?php echo esc_url($meta['bg']); ?>">
                <source src="<?php echo esc_url($meta['video']); ?>" type="video/mp4">
            </video>
        </div>
        <?php endif; ?>
        
        <div class="tez-svc-hero-content">
            <div class="tez-svc-container">
                <div class="tez-svc-hero-wrapper">
                    <!-- Main Content -->
                    <div class="tez-svc-hero-main">
                        <!-- Labels -->
                        <?php if (!empty($labels)) : ?>
                        <div class="tez-svc-labels">
                            <?php foreach ($labels as $label) : ?>
                            <a href="<?php echo esc_url($label['url']); ?>" 
                               class="tez-svc-label" 
                               style="background-color: <?php echo esc_attr($label['color']); ?>">
                                <i class="<?php echo esc_attr($label['icon']); ?>"></i>
                                <?php echo esc_html($label['name']); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Eyebrow -->
                        <div class="tez-svc-hero-eyebrow">
                            <span class="tez-svc-hero-eyebrow-icon">
                                <i class="<?php echo esc_attr($meta['icon']); ?>"></i>
                            </span>
                            <span class="tez-svc-hero-eyebrow-text">خدمات تخصصی دانشگاهی</span>
                            <span class="tez-svc-hero-eyebrow-badge">جدید</span>
                        </div>
                        
                        <!-- Title -->
                        <h1><?php echo esc_html($title); ?></h1>
                        
                        <!-- Subtitle -->
                        <?php if ($meta['subtitle']) : ?>
                        <p class="tez-svc-hero-subtitle"><?php echo esc_html($meta['subtitle']); ?></p>
                        <?php endif; ?>
                        
                        <!-- Meta Info -->
                        <div class="tez-svc-hero-meta">
                            <!-- Rating -->
                            <div class="tez-svc-hero-rating" itemscope itemtype="https://schema.org/AggregateRating">
                                <div class="tez-svc-hero-stars">
                                    <?php echo tez_svc_render_stars($meta['rating']); ?>
                                </div>
                                <div class="tez-svc-hero-rating-text">
                                    <span class="tez-svc-hero-rating-value" itemprop="ratingValue"><?php echo esc_html($meta['rating']); ?></span>
                                    / ۵
                                    (<span itemprop="reviewCount"><?php echo esc_html($meta['rating_count']); ?></span> نظر)
                                </div>
                            </div>
                            
                            <!-- Avatars -->
                            <div class="tez-svc-hero-avatars">
                                <div class="tez-svc-avatar-stack">
                                    <span class="tez-svc-avatar">ع</span>
                                    <span class="tez-svc-avatar">م</span>
                                    <span class="tez-svc-avatar">س</span>
                                    <span class="tez-svc-avatar">ف</span>
                                    <span class="tez-svc-avatar tez-svc-avatar-more">+۵۰</span>
                                </div>
                                <span class="tez-svc-avatars-text">دانشجویان راضی</span>
                            </div>
                        </div>
                        
                        <!-- CTA Buttons -->
                        <div class="tez-svc-hero-cta-group">
                            <a href="#tez-svc-form" class="tez-svc-btn tez-svc-btn-primary">
                                <i class="fa-solid fa-paper-plane"></i>
                                ثبت درخواست رایگان
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                            <?php if ($meta['cta_secondary']) : ?>
                            <a href="#tez-features" class="tez-svc-btn tez-svc-btn-secondary">
                                <i class="fa-solid fa-play-circle"></i>
                                <?php echo esc_html($meta['cta_secondary']); ?>
                            </a>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Trust Items -->
                        <?php 
                        $badges = tez_svc_parse_lines($meta['badges'], 2);
                        if (!empty($badges)) : 
                        ?>
                        <div class="tez-svc-hero-trust">
                            <?php foreach ($badges as $badge) : ?>
                            <div class="tez-svc-trust-item">
                                <i class="<?php echo esc_attr($badge[0]); ?>"></i>
                                <span><?php echo esc_html($badge[1]); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Sidebar Stats -->
                    <div class="tez-svc-hero-sidebar">
                        <div class="tez-svc-stats-card">
                            <div class="tez-svc-stat-item">
                                <div class="tez-svc-stat-icon"><i class="fa-solid fa-file-check"></i></div>
                                <div class="tez-svc-stat-content">
                                    <span class="tez-svc-stat-number" data-count="<?php echo esc_attr($meta['completion']); ?>">۰</span>
                                    <span class="tez-svc-stat-label">پروژه موفق</span>
                                </div>
                            </div>
                            <div class="tez-svc-stat-divider"></div>
                            <div class="tez-svc-stat-item">
                                <div class="tez-svc-stat-icon"><i class="fa-solid fa-face-smile"></i></div>
                                <div class="tez-svc-stat-content">
                                    <span class="tez-svc-stat-number"><?php echo esc_html(tez_svc_to_persian($meta['satisfaction'])); ?>%</span>
                                    <span class="tez-svc-stat-label">رضایت مشتریان</span>
                                </div>
                            </div>
                            <div class="tez-svc-stat-divider"></div>
                            <div class="tez-svc-stat-item">
                                <div class="tez-svc-stat-icon"><i class="fa-solid fa-award"></i></div>
                                <div class="tez-svc-stat-content">
                                    <span class="tez-svc-stat-number"><?php echo esc_html(tez_svc_to_persian($meta['experience'] ?: '12')); ?></span>
                                    <span class="tez-svc-stat-label">سال تجربه</span>
                                </div>
                            </div>
                            <div class="tez-svc-stat-divider"></div>
                            <div class="tez-svc-stat-item">
                                <div class="tez-svc-stat-icon"><i class="fa-solid fa-headset"></i></div>
                                <div class="tez-svc-stat-content">
                                    <span class="tez-svc-stat-number">۲۴/۷</span>
                                    <span class="tez-svc-stat-label">پشتیبانی</span>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($meta['phone']) : ?>
                        <div class="tez-svc-quick-contact">
                            <div class="tez-svc-quick-contact-title">
                                <i class="fa-solid fa-bolt"></i>
                                مشاوره فوری
                            </div>
                            <a href="tel:<?php echo esc_attr($meta['phone']); ?>" class="tez-svc-quick-contact-phone">
                                <i class="fa-solid fa-phone-volume"></i>
                                <span dir="ltr"><?php echo esc_html($meta['phone']); ?></span>
                            </a>
                            <div class="tez-svc-quick-contact-status">
                                <span class="tez-svc-status-dot"></span>
                                آنلاین - پاسخگویی در ۵ دقیقه
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="tez-svc-scroll-indicator">
            <a href="#tez-svc-form" class="tez-svc-scroll-link" aria-label="اسکرول به پایین">
                <span>ادامه</span>
                <span class="tez-svc-scroll-icon"></span>
            </a>
        </div>
    </section>

    <!-- E-E-A-T Author Section -->
    <?php if ($meta['author_name']) : ?>
    <section class="tez-svc-eeat-section">
        <div class="tez-svc-container">
            <div class="tez-svc-eeat-card">
                <div class="tez-svc-eeat-header">
                    <?php if ($meta['author_image']) : ?>
                    <img src="<?php echo esc_url($meta['author_image']); ?>" alt="<?php echo esc_attr($meta['author_name']); ?>" class="tez-svc-eeat-avatar">
                    <?php else : ?>
                    <div class="tez-svc-eeat-avatar-placeholder">
                        <?php echo mb_substr($meta['author_name'], 0, 1); ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="tez-svc-eeat-info">
                        <span class="tez-svc-eeat-badge">
                            <i class="fa-solid fa-user-check"></i>
                            نویسنده تأیید شده
                        </span>
                        <h3 class="tez-svc-eeat-name"><?php echo esc_html($meta['author_name']); ?></h3>
                        <?php if ($meta['author_title']) : ?>
                        <p class="tez-svc-eeat-title"><?php echo esc_html($meta['author_title']); ?></p>
                        <?php endif; ?>
                        
                        <div class="tez-svc-eeat-credentials">
                            <?php if ($meta['experience']) : ?>
                            <span class="tez-svc-eeat-credential">
                                <i class="fa-solid fa-briefcase"></i>
                                <?php echo esc_html(tez_svc_to_persian($meta['experience'])); ?> سال تجربه
                            </span>
                            <?php endif; ?>
                            <?php 
                            $creds = explode("\n", trim($meta['credentials']));
                            if (!empty($creds[0])) :
                                foreach (array_slice($creds, 0, 2) as $cred) : ?>
                            <span class="tez-svc-eeat-credential">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <?php echo esc_html($cred); ?>
                            </span>
                            <?php endforeach; endif; ?>
                        </div>
                        
                        <?php 
                        $socials = tez_svc_parse_lines($meta['author_social'], 2);
                        if (!empty($socials)) : 
                        ?>
                        <div class="tez-svc-eeat-social">
                            <?php foreach ($socials as $social) : 
                                $icon_map = array(
                                    'linkedin' => 'fa-brands fa-linkedin-in',
                                    'twitter' => 'fa-brands fa-x-twitter',
                                    'instagram' => 'fa-brands fa-instagram',
                                    'telegram' => 'fa-brands fa-telegram',
                                    'website' => 'fa-solid fa-globe',
                                );
                                $icon = $icon_map[strtolower($social[0])] ?? 'fa-solid fa-link';
                            ?>
                            <a href="<?php echo esc_url($social[1]); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($social[0]); ?>">
                                <i class="<?php echo esc_attr($icon); ?>"></i>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($meta['author_bio']) : ?>
                <p class="tez-svc-eeat-bio"><?php echo esc_html($meta['author_bio']); ?></p>
                <?php endif; ?>
                
                <div class="tez-svc-eeat-meta">
                    <?php if ($meta['published']) : ?>
                    <div class="tez-svc-eeat-meta-item">
                        <div class="tez-svc-eeat-meta-icon"><i class="fa-solid fa-calendar-plus"></i></div>
                        <div class="tez-svc-eeat-meta-content">
                            <span class="tez-svc-eeat-meta-label">تاریخ انتشار</span>
                            <span class="tez-svc-eeat-meta-value"><?php echo esc_html($meta['published']); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($meta['updated']) : ?>
                    <div class="tez-svc-eeat-meta-item">
                        <div class="tez-svc-eeat-meta-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                        <div class="tez-svc-eeat-meta-content">
                            <span class="tez-svc-eeat-meta-label">آخرین بروزرسانی</span>
                            <span class="tez-svc-eeat-meta-value"><?php echo esc_html($meta['updated']); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($meta['reviewer_name']) : ?>
                    <div class="tez-svc-eeat-meta-item">
                        <div class="tez-svc-eeat-meta-icon"><i class="fa-solid fa-user-check"></i></div>
                        <div class="tez-svc-eeat-meta-content">
                            <span class="tez-svc-eeat-meta-label">بازبین</span>
                            <span class="tez-svc-eeat-meta-value"><?php echo esc_html($meta['reviewer_name']); ?><?php echo $meta['reviewer_title'] ? ' - ' . esc_html($meta['reviewer_title']) : ''; ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Content Meta Bar -->
    <?php if ($meta['reading_time'] || $meta['difficulty'] || $meta['audience']) : ?>
    <div class="tez-svc-container">
        <div class="tez-svc-content-meta">
            <?php if ($meta['reading_time']) : ?>
            <div class="tez-svc-content-meta-item">
                <i class="fa-solid fa-clock"></i>
                زمان مطالعه: <?php echo esc_html(tez_svc_to_persian($meta['reading_time'])); ?> دقیقه
            </div>
            <?php endif; ?>
            
            <?php if ($meta['difficulty']) : 
                $diff_labels = array(
                    'beginner' => 'مبتدی',
                    'intermediate' => 'متوسط',
                    'advanced' => 'پیشرفته',
                );
            ?>
            <div class="tez-svc-content-meta-item">
                <i class="fa-solid fa-signal"></i>
                سطح: 
                <span class="tez-svc-difficulty-badge tez-svc-difficulty-<?php echo esc_attr($meta['difficulty']); ?>">
                    <?php echo esc_html($diff_labels[$meta['difficulty']] ?? $meta['difficulty']); ?>
                </span>
            </div>
            <?php endif; ?>
            
            <?php if ($meta['audience']) : ?>
            <div class="tez-svc-content-meta-item">
                <i class="fa-solid fa-users"></i>
                مخاطب: <?php echo esc_html($meta['audience']); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Key Takeaways -->
    <?php 
    $takeaways = array_filter(explode("\n", trim($meta['takeaways'])));
    if (!empty($takeaways)) : 
    ?>
    <div class="tez-svc-container">
        <div class="tez-svc-takeaways">
            <h3 class="tez-svc-takeaways-title">
                <i class="fa-solid fa-lightbulb"></i>
                نکات کلیدی این صفحه
            </h3>
            <ul class="tez-svc-takeaways-list">
                <?php foreach ($takeaways as $takeaway) : ?>
                <li class="tez-svc-takeaways-item">
                    <i class="fa-solid fa-check-circle"></i>
                    <span><?php echo esc_html(trim($takeaway)); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <!-- Table of Contents -->
    <?php 
    $toc_items = tez_svc_parse_lines($meta['toc'], 2);
    if (!empty($toc_items)) : 
    ?>
    <div class="tez-svc-container">
        <nav class="tez-svc-toc" aria-label="فهرست مطالب">
            <h3 class="tez-svc-toc-title">
                <i class="fa-solid fa-list"></i>
                فهرست مطالب
            </h3>
            <ol class="tez-svc-toc-list">
                <?php foreach ($toc_items as $i => $item) : ?>
                <li class="tez-svc-toc-item">
                    <span class="tez-svc-toc-number"><?php echo tez_svc_to_persian($i + 1); ?></span>
                    <a href="#<?php echo esc_attr($item[1]); ?>"><?php echo esc_html($item[0]); ?></a>
                </li>
                <?php endforeach; ?>
            </ol>
        </nav>
    </div>
    <?php endif; ?>

    <!-- Form Section -->
    <section class="tez-svc-form-section tez-svc-bleed" id="tez-svc-form">
        <div class="tez-svc-container">
            <div class="tez-svc-form-card">
                <div class="tez-svc-form-header">
                    <h3><i class="fa-solid fa-file-pen"></i> فرم درخواست خدمات</h3>
                    <p>اطلاعات پروژه را وارد کنید تا کارشناسان با شما تماس بگیرند</p>
                </div>
                
                <form id="tez-svc-form-el" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="action" value="tez_svc_submit">
                    <input type="hidden" name="_nonce" value="<?php echo esc_attr($nonce); ?>">
                    <input type="hidden" name="source" value="<?php echo esc_attr($id); ?>">
                    
                    <div class="tez-svc-form-grid">
                        <div class="tez-svc-form-field">
                            <label class="tez-svc-form-label" for="tez-name">
                                <i class="fa-solid fa-user"></i>
                                نام و نام خانوادگی
                            </label>
                            <input type="text" name="name" id="tez-name" class="tez-svc-form-input" placeholder="علی احمدی" required minlength="3">
                        </div>
                        
                        <div class="tez-svc-form-field">
                            <label class="tez-svc-form-label" for="tez-phone">
                                <i class="fa-solid fa-phone"></i>
                                شماره موبایل
                            </label>
                            <input type="tel" name="phone" id="tez-phone" class="tez-svc-form-input" placeholder="09123456789" dir="ltr" required pattern="09[0-9]{9}">
                        </div>
                        
                        <div class="tez-svc-form-field">
                            <label class="tez-svc-form-label" for="tez-major">
                                <i class="fa-solid fa-graduation-cap"></i>
                                رشته تحصیلی
                            </label>
                            <input type="text" name="major" id="tez-major" class="tez-svc-form-input" placeholder="مدیریت بازرگانی" required>
                        </div>
                        
                        <div class="tez-svc-form-field">
                            <label class="tez-svc-form-label" for="tez-type">
                                <i class="fa-solid fa-folder-open"></i>
                                نوع پروژه
                            </label>
                            <select name="type" id="tez-type" class="tez-svc-form-input" required>
                                <option value="">انتخاب کنید...</option>
                                <option value="پایان‌نامه کارشناسی">پایان‌نامه کارشناسی</option>
                                <option value="پایان‌نامه ارشد">پایان‌نامه ارشد</option>
                                <option value="رساله دکتری">رساله دکتری</option>
                                <option value="پروپوزال">پروپوزال</option>
                                <option value="مقاله علمی">مقاله علمی</option>
                                <option value="تحلیل آماری">تحلیل آماری</option>
                                <option value="ترجمه">ترجمه</option>
                                <option value="سایر">سایر</option>
                            </select>
                        </div>
                        
                        <div class="tez-svc-form-field full-width">
                            <label class="tez-svc-form-label" for="tez-desc">
                                <i class="fa-solid fa-align-left"></i>
                                توضیحات پروژه
                            </label>
                            <textarea name="desc" id="tez-desc" class="tez-svc-form-input" placeholder="جزئیات و نیازمندی‌های پروژه خود را شرح دهید..." required minlength="20"></textarea>
                        </div>
                        
                        <div class="tez-svc-form-field full-width">
                            <label class="tez-svc-form-label">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                فایل پیوست (اختیاری)
                            </label>
                            <div class="tez-svc-file-upload" id="tez-file-drop" role="button" tabindex="0">
                                <i class="fa-solid fa-file-arrow-up tez-svc-file-upload-icon"></i>
                                <p class="tez-svc-file-upload-text">کلیک کنید یا فایل را بکشید</p>
                                <p class="tez-svc-file-upload-hint">PDF, Word, Excel, تصاویر (حداکثر ۱۰MB)</p>
                                <input type="file" name="file" id="tez-file-input" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt">
                                <p class="tez-svc-file-name" id="tez-file-name"></p>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="tez-svc-btn tez-svc-btn-primary tez-svc-form-submit" id="tez-submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        ارسال درخواست
                    </button>
                    
                    <div class="tez-svc-form-message" id="tez-msg" role="alert"></div>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <?php if (trim($content)) : ?>
    <section class="tez-svc-content-section">
        <div class="tez-svc-container">
            <div class="tez-svc-content-inner">
                <?php echo $content; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Features Section -->
    <?php 
    $features = tez_svc_parse_lines($meta['features'], 3);
    if (!empty($features)) : 
    ?>
    <section class="tez-svc-section tez-svc-section-alt" id="tez-features">
        <div class="tez-svc-container">
            <div class="tez-svc-section-title">
                <h2><i class="fa-solid fa-gem"></i> چرا ما را انتخاب کنید؟</h2>
                <p>ویژگی‌ها و مزایای خدمات ما</p>
            </div>
            <div class="tez-svc-features-grid">
                <?php foreach ($features as $feature) : ?>
                <div class="tez-svc-feature-card">
                    <div class="tez-svc-feature-icon">
                        <i class="<?php echo esc_attr($feature[0]); ?>"></i>
                    </div>
                    <h4><?php echo esc_html($feature[1]); ?></h4>
                    <p><?php echo esc_html($feature[2]); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Process Steps -->
    <?php 
    $steps = tez_svc_parse_lines($meta['steps'], 3);
    if (!empty($steps)) : 
    ?>
    <section class="tez-svc-section" id="process">
        <div class="tez-svc-container">
            <div class="tez-svc-section-title">
                <h2><i class="fa-solid fa-route"></i> مراحل انجام کار</h2>
                <p>فرآیند ساده و شفاف همکاری</p>
            </div>
            <div class="tez-svc-steps">
                <?php foreach ($steps as $step) : ?>
                <div class="tez-svc-step">
                    <div class="tez-svc-step-icon">
                        <i class="<?php echo esc_attr($step[0]); ?>"></i>
                    </div>
                    <h4><?php echo esc_html($step[1]); ?></h4>
                    <p><?php echo esc_html($step[2]); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Pricing -->
    <?php if ($meta['price']) : ?>
    <section class="tez-svc-section tez-svc-section-alt" id="pricing">
        <div class="tez-svc-container">
            <div class="tez-svc-pricing-card">
                <p class="tez-svc-pricing-label">شروع قیمت از</p>
                <p class="tez-svc-pricing-value"><?php echo esc_html($meta['price']); ?></p>
                <?php if ($meta['price_note']) : ?>
                <p class="tez-svc-pricing-note"><?php echo esc_html($meta['price_note']); ?></p>
                <?php endif; ?>
                <a href="#tez-svc-form" class="tez-svc-pricing-btn">
                    <i class="fa-solid fa-calculator"></i>
                    دریافت قیمت دقیق
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Testimonials -->
    <?php 
    $testimonials = tez_svc_parse_lines($meta['testimonials'], 4);
    if (!empty($testimonials)) : 
    ?>
    <section class="tez-svc-section" id="testimonials">
        <div class="tez-svc-container">
            <div class="tez-svc-section-title">
                <h2><i class="fa-solid fa-comments"></i> نظرات مشتریان</h2>
                <p>تجربه همکاری دانشجویان با ما</p>
            </div>
            <div class="tez-svc-testimonials-grid">
                <?php foreach ($testimonials as $t) : ?>
                <div class="tez-svc-testimonial" itemscope itemtype="https://schema.org/Review">
                    <div class="tez-svc-testimonial-stars">
                        <?php echo tez_svc_render_stars(intval($t[3])); ?>
                    </div>
                    <p class="tez-svc-testimonial-text" itemprop="reviewBody">"<?php echo esc_html($t[2]); ?>"</p>
                    <div class="tez-svc-testimonial-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <div class="tez-svc-testimonial-avatar"><?php echo mb_substr($t[0], 0, 1); ?></div>
                        <div class="tez-svc-testimonial-info">
                            <div class="tez-svc-testimonial-name" itemprop="name"><?php echo esc_html($t[0]); ?></div>
                            <div class="tez-svc-testimonial-major"><?php echo esc_html($t[1]); ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- FAQ -->
    <?php 
    $faqs = tez_svc_parse_lines($meta['faq'], 2);
    if (!empty($faqs)) : 
    ?>
    <section class="tez-svc-section tez-svc-section-alt" id="faq">
        <div class="tez-svc-container">
            <div class="tez-svc-section-title">
                <h2><i class="fa-solid fa-circle-question"></i> سوالات متداول</h2>
            </div>
            <div class="tez-svc-faq-list">
                <?php foreach ($faqs as $faq) : ?>
                <div class="tez-svc-faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <button class="tez-svc-faq-q" type="button" aria-expanded="false">
                        <span itemprop="name"><?php echo esc_html($faq[0]); ?></span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="tez-svc-faq-a" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p itemprop="text"><?php echo esc_html($faq[1]); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Sources (E-E-A-T) -->
    <?php 
    $sources = tez_svc_parse_lines($meta['sources'], 1);
    if (!empty($sources)) : 
    ?>
    <div class="tez-svc-container">
        <div class="tez-svc-sources">
            <h3 class="tez-svc-sources-title">
                <i class="fa-solid fa-book-open"></i>
                منابع و مراجع
            </h3>
            <ul class="tez-svc-sources-list">
                <?php foreach ($sources as $source) : ?>
                <li class="tez-svc-sources-item">
                    <?php if (!empty($source[1])) : ?>
                    <a href="<?php echo esc_url($source[1]); ?>" target="_blank" rel="noopener"><?php echo esc_html($source[0]); ?></a>
                    <?php else : ?>
                    <?php echo esc_html($source[0]); ?>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <!-- Methodology (E-E-A-T) -->
    <?php if ($meta['methodology']) : ?>
    <div class="tez-svc-container">
        <div class="tez-svc-methodology">
            <h3 class="tez-svc-methodology-title">
                <i class="fa-solid fa-flask"></i>
                روش‌شناسی
            </h3>
            <p class="tez-svc-methodology-text"><?php echo esc_html($meta['methodology']); ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Related Services -->
    <?php if (!empty($related)) : ?>
    <section class="tez-svc-related">
        <div class="tez-svc-container">
            <div class="tez-svc-section-title">
                <h2><i class="fa-solid fa-layer-group"></i> خدمات مرتبط</h2>
                <p>سایر خدماتی که ممکن است به آن نیاز داشته باشید</p>
            </div>
            <div class="tez-svc-related-grid">
                <?php foreach ($related as $r) : ?>
                <a href="<?php echo esc_url($r['url']); ?>" class="tez-svc-related-card">
                    <?php if (!empty($r['labels'])) : ?>
                    <div class="tez-svc-related-card-labels">
                        <?php foreach (array_slice($r['labels'], 0, 2) as $label) : 
                            $color = get_term_meta($label->term_id, '_label_color', true) ?: '#3b82f6';
                        ?>
                        <span class="tez-svc-related-card-label" style="background-color: <?php echo esc_attr($color); ?>">
                            <?php echo esc_html($label->name); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="tez-svc-related-card-icon">
                        <i class="<?php echo esc_attr($r['icon']); ?>"></i>
                    </div>
                    <h4 class="tez-svc-related-card-title"><?php echo esc_html($r['title']); ?></h4>
                    <?php if ($r['subtitle']) : ?>
                    <p class="tez-svc-related-card-subtitle"><?php echo esc_html(wp_trim_words($r['subtitle'], 15)); ?></p>
                    <?php endif; ?>
                    <div class="tez-svc-related-card-footer">
                        <?php if ($r['price']) : ?>
                        <span class="tez-svc-related-card-price">از <strong><?php echo esc_html($r['price']); ?></strong></span>
                        <?php endif; ?>
                        <span class="tez-svc-related-card-rating">
                            <i class="fa-solid fa-star"></i>
                            <?php echo esc_html($r['rating']); ?>
                        </span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CTA Section -->
    <section class="tez-svc-cta tez-svc-bleed">
        <div class="tez-svc-container">
            <h2><?php echo esc_html($meta['cta_title']); ?></h2>
            <p>مشاوره رایگان و بدون تعهد</p>
            <a href="#tez-svc-form" class="tez-svc-cta-btn">
                <i class="fa-solid fa-rocket"></i>
                <?php echo esc_html($meta['cta_text']); ?>
            </a>
        </div>
    </section>
</div>
        <?php
        return ob_get_clean();
    }
}

// =============================================
// SCRIPTS
// =============================================
if (!function_exists('tez_svc_scripts')) {
    function tez_svc_scripts($ajax_url) {
        ob_start();
        ?>
<script>
(function() {
    'use strict';

    // =============================================
    // FILE UPLOAD
    // =============================================
    var drop = document.getElementById('tez-file-drop');
    var input = document.getElementById('tez-file-input');
    var fname = document.getElementById('tez-file-name');

    if (drop && input) {
        function handleFile(file) {
            if (!file) { fname.innerHTML = ''; return; }
            if (file.size > 10 * 1024 * 1024) {
                fname.innerHTML = '<i class="fa-solid fa-exclamation-triangle"></i> فایل بزرگتر از ۱۰MB';
                fname.style.color = '#ef4444';
                input.value = '';
                return;
            }
            fname.innerHTML = '<i class="fa-solid fa-file-check"></i> ' + file.name;
            fname.style.color = '';
        }

        drop.onclick = function() { input.click(); };
        drop.onkeypress = function(e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); } };
        input.onchange = function() { handleFile(this.files[0]); };

        drop.ondragover = function(e) { e.preventDefault(); this.classList.add('dragover'); };
        drop.ondragleave = function() { this.classList.remove('dragover'); };
        drop.ondrop = function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            if (e.dataTransfer.files[0]) {
                var dt = new DataTransfer();
                dt.items.add(e.dataTransfer.files[0]);
                input.files = dt.files;
                handleFile(e.dataTransfer.files[0]);
            }
        };
    }

    // =============================================
    // FORM SUBMISSION
    // =============================================
    var form = document.getElementById('tez-svc-form-el');
    var btn = document.getElementById('tez-submit');
    var msg = document.getElementById('tez-msg');

    if (form) {
        form.onsubmit = function(e) {
            e.preventDefault();
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> در حال ارسال...';
            msg.className = 'tez-svc-form-message';
            msg.style.display = 'none';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo esc_js($ajax_url); ?>');
            xhr.onload = function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> ارسال درخواست';

                try {
                    var r = JSON.parse(xhr.responseText);
                    msg.className = 'tez-svc-form-message ' + (r.success ? 'success' : 'error');
                    msg.innerHTML = '<i class="fa-solid fa-' + (r.success ? 'check' : 'exclamation') + '-circle"></i> ' + r.data.message;
                    msg.style.display = 'flex';

                    if (r.success) {
                        form.reset();
                        fname.innerHTML = '';
                    }
                } catch (err) {
                    msg.className = 'tez-svc-form-message error';
                    msg.innerHTML = '<i class="fa-solid fa-exclamation-circle"></i> خطا در پردازش';
                    msg.style.display = 'flex';
                }

                msg.scrollIntoView({ behavior: 'smooth', block: 'center' });
            };
            xhr.onerror = function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> ارسال درخواست';
                msg.className = 'tez-svc-form-message error';
                msg.innerHTML = '<i class="fa-solid fa-exclamation-circle"></i> خطا در ارتباط';
                msg.style.display = 'flex';
            };
            xhr.send(new FormData(form));
        };
    }

    // =============================================
    // FAQ ACCORDION
    // =============================================
    document.querySelectorAll('.tez-svc-faq-q').forEach(function(q) {
        q.onclick = function() {
            var item = this.parentElement;
            var isActive = item.classList.contains('active');

            document.querySelectorAll('.tez-svc-faq-item').forEach(function(i) {
                i.classList.remove('active');
                var b = i.querySelector('.tez-svc-faq-q');
                if (b) b.setAttribute('aria-expanded', 'false');
            });

            if (!isActive) {
                item.classList.add('active');
                this.setAttribute('aria-expanded', 'true');
            }
        };
    });

    // =============================================
    // SMOOTH SCROLL
    // =============================================
    document.querySelectorAll('a[href^="#"]').forEach(function(a) {
        a.onclick = function(e) {
            var t = document.querySelector(this.getAttribute('href'));
            if (t) {
                e.preventDefault();
                t.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };
    });

    // =============================================
    // ANIMATED COUNTERS
    // =============================================
    function animateCounter(el) {
        var target = parseInt(el.dataset.count) || 0;
        var duration = 2000;
        var start = performance.now();
        var persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];

        function toPersian(n) {
            return String(n).replace(/\d/g, function(d) { return persian[d]; });
        }

        function update(now) {
            var elapsed = now - start;
            var progress = Math.min(elapsed / duration, 1);
            var ease = 1 - Math.pow(1 - progress, 4);
            var current = Math.floor(ease * target);
            el.textContent = toPersian(current);
            if (progress < 1) requestAnimationFrame(update);
        }

        requestAnimationFrame(update);
    }

    // =============================================
    // INTERSECTION OBSERVER
    // =============================================
    if ('IntersectionObserver' in window) {
        // Counter animation
        var counterObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.tez-svc-stat-number[data-count]').forEach(function(el) {
            counterObserver.observe(el);
        });

        // Reveal animations
        var revealObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.tez-svc-feature-card, .tez-svc-step, .tez-svc-testimonial, .tez-svc-faq-item, .tez-svc-related-card').forEach(function(el, i) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.5s ease ' + (i % 4 * 0.1) + 's, transform 0.5s ease ' + (i % 4 * 0.1) + 's';
            revealObserver.observe(el);
        });
    }

    // =============================================
    // PARALLAX EFFECT (Optional)
    // =============================================
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        var hero = document.querySelector('.tez-svc-hero');
        if (hero) {
            window.addEventListener('scroll', function() {
                var scroll = window.pageYOffset;
                var glows = hero.querySelectorAll('.tez-svc-hero-glow');
                glows.forEach(function(glow, i) {
                    glow.style.transform = 'translateY(' + (scroll * 0.1 * (i + 1)) + 'px)';
                });
            }, { passive: true });
        }
    }

})();
</script>
        <?php
        return ob_get_clean();
    }
}
