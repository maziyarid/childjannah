/**
 * Teznevisan FAQ System with Schema.org
 * Version: 2.0.0
 * Features: Accordion, Schema.org, Dark/Sepia Mode, RTL, Accessibility
 */

if (!defined('ABSPATH')) exit;

// =============================================
// 1. ENQUEUE FONT AWESOME (if not loaded)
// =============================================
add_action('wp_enqueue_scripts', 'tez_faq_enqueue_assets');
add_action('admin_enqueue_scripts', 'tez_faq_admin_assets');

function tez_faq_enqueue_assets() {
    if (!is_singular('post')) return;
    
    if (!wp_style_is('font-awesome', 'enqueued') && !wp_style_is('fontawesome', 'enqueued')) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    }
}

function tez_faq_admin_assets($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) return;
    
    if (!wp_style_is('font-awesome', 'enqueued')) {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    }
    
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-sortable');
}

// =============================================
// 2. ADD META BOX
// =============================================
add_action('add_meta_boxes', 'tez_faq_add_metabox');
function tez_faq_add_metabox() {
    add_meta_box(
        'tez_faq_box',
        '<i class="fas fa-circle-question" style="color:#2563eb;margin-left:8px;"></i> سوالات متداول / FAQ',
        'tez_faq_metabox_html',
        'post',
        'normal',
        'high'
    );
}

// =============================================
// 3. META BOX HTML
// =============================================
function tez_faq_metabox_html($post) {
    $faqs = get_post_meta($post->ID, '_tez_faqs', true) ?: array();
    $enabled = get_post_meta($post->ID, '_tez_faq_enable', true);
    $style = get_post_meta($post->ID, '_tez_faq_style', true) ?: 'modern';
    $position = get_post_meta($post->ID, '_tez_faq_position', true) ?: 'after_content';
    $heading = get_post_meta($post->ID, '_tez_faq_heading', true) ?: 'سوالات متداول';
    
    wp_nonce_field('tez_faq_save', 'tez_faq_nonce');
    ?>
    
    <style>
        .tez-faq-admin-wrapper {
            padding: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            font-family: 'Vazirmatn', system-ui, -apple-system, sans-serif;
        }
        .faq-control-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .faq-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
            margin-left: 12px;
        }
        .faq-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .faq-slider {
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
        .faq-slider:before {
            position: absolute;
            content: '';
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.3s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        input:checked + .faq-slider {
            background-color: #2563eb;
        }
        input:checked + .faq-slider:before {
            transform: translateX(24px);
        }
        .faq-switch-label {
            font-weight: 600;
            color: #1e293b;
        }
        .faq-body {
            margin-top: 20px;
        }
        .faq-field {
            margin-bottom: 20px;
        }
        .faq-field > label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1e293b;
            font-size: 14px;
        }
        .faq-field > label i {
            color: #2563eb;
            margin-left: 6px;
        }
        .faq-input {
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
        .faq-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .faq-cols {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        @media (max-width: 782px) {
            .faq-cols {
                grid-template-columns: 1fr;
            }
        }
        .faq-select {
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
        .faq-select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .faq-item-row {
            background: #ffffff;
            padding: 16px;
            margin-bottom: 12px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }
        .faq-item-row:hover {
            border-color: #2563eb;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.1);
        }
        .faq-item-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .faq-drag-handle {
            cursor: move;
            color: #94a3b8;
            padding: 0 8px;
            font-size: 16px;
        }
        .faq-drag-handle:hover {
            color: #2563eb;
        }
        .faq-item-number {
            background: #2563eb;
            color: #fff;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }
        .faq-item-row input[type="text"],
        .faq-item-row textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .faq-item-row input[type="text"]:focus,
        .faq-item-row textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .faq-item-row textarea {
            min-height: 80px;
            resize: vertical;
        }
        .faq-item-row .faq-field-label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #475569;
            font-size: 13px;
        }
        .faq-item-row .faq-field-label i {
            margin-left: 4px;
            color: #2563eb;
        }
        .faq-item-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }
        .faq-remove-btn {
            color: #ef4444 !important;
            border-color: #fecaca !important;
            background: #fef2f2 !important;
            padding: 6px 12px !important;
            border-radius: 6px !important;
            font-family: inherit !important;
            transition: all 0.2s ease !important;
        }
        .faq-remove-btn:hover {
            background: #fee2e2 !important;
            border-color: #f87171 !important;
        }
        .faq-remove-btn i {
            margin-left: 4px;
        }
        #tez-add-faq {
            background: #2563eb !important;
            border-color: #2563eb !important;
            color: #fff !important;
            padding: 10px 20px !important;
            border-radius: 8px !important;
            font-family: inherit !important;
            font-size: 14px !important;
            transition: all 0.2s ease !important;
        }
        #tez-add-faq:hover {
            background: #1e40af !important;
            border-color: #1e40af !important;
        }
        #tez-add-faq i {
            margin-left: 6px;
        }
        .faq-items-container {
            margin-bottom: 15px;
        }
        .faq-empty-state {
            text-align: center;
            padding: 40px 20px;
            background: #f8fafc;
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            color: #94a3b8;
        }
        .faq-empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }
        .faq-empty-state p {
            margin: 0;
            font-size: 14px;
        }
        .ui-sortable-placeholder {
            background: #eff6ff !important;
            border: 2px dashed #2563eb !important;
            visibility: visible !important;
            min-height: 100px;
            border-radius: 10px;
        }
    </style>
    
    <div class="tez-faq-admin-wrapper">
        <!-- Enable Switch -->
        <div class="faq-control-group">
            <label class="faq-switch">
                <input type="checkbox" name="tez_faq_enable" value="yes" <?php checked($enabled, 'yes'); ?>>
                <span class="faq-slider round"></span>
            </label>
            <span class="faq-switch-label">فعال‌سازی بخش سوالات متداول</span>
        </div>

        <div class="faq-body" style="display: <?php echo ($enabled === 'yes') ? 'block' : 'none'; ?>">
            <!-- Settings Row -->
            <div class="faq-cols">
                <div class="faq-field">
                    <label><i class="fas fa-heading"></i> عنوان بخش / Heading</label>
                    <input type="text" name="tez_faq_heading" value="<?php echo esc_attr($heading); ?>" placeholder="سوالات متداول" class="faq-input">
                </div>
                
                <div class="faq-field">
                    <label><i class="fas fa-map-pin"></i> موقعیت / Position</label>
                    <select name="tez_faq_position" class="faq-select">
                        <option value="after_content" <?php selected($position, 'after_content'); ?>>انتهای محتوا (After Content)</option>
                        <option value="before_content" <?php selected($position, 'before_content'); ?>>ابتدای محتوا (Before Content)</option>
                        <option value="manual" <?php selected($position, 'manual'); ?>>دستی - شورت‌کد [tez_faq]</option>
                    </select>
                </div>
                
                <div class="faq-field">
                    <label><i class="fas fa-palette"></i> استایل / Style</label>
                    <select name="tez_faq_style" class="faq-select">
                        <option value="modern" <?php selected($style, 'modern'); ?>>مدرن (Modern)</option>
                        <option value="minimal" <?php selected($style, 'minimal'); ?>>مینیمال (Minimal)</option>
                        <option value="boxed" <?php selected($style, 'boxed'); ?>>باکسی (Boxed)</option>
                        <option value="gradient" <?php selected($style, 'gradient'); ?>>گرادیان (Gradient)</option>
                    </select>
                </div>
            </div>

            <!-- FAQ Items -->
            <div class="faq-field">
                <label><i class="fas fa-list-ul"></i> سوالات و پاسخ‌ها / Questions & Answers</label>
                <div id="tez-faq-items" class="faq-items-container">
                    <?php if (empty($faqs)): ?>
                    <div class="faq-empty-state" id="faq-empty-state">
                        <i class="fas fa-comments"></i>
                        <p>هنوز سوالی اضافه نشده است. روی دکمه زیر کلیک کنید.</p>
                    </div>
                    <?php else: ?>
                        <?php foreach ($faqs as $i => $faq): ?>
                        <div class="faq-item-row">
                            <div class="faq-item-header">
                                <span class="faq-drag-handle"><i class="fas fa-grip-vertical"></i></span>
                                <span class="faq-item-number"><?php echo $i + 1; ?></span>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label class="faq-field-label"><i class="fas fa-question"></i> سوال:</label>
                                <input type="text" name="tez_faqs[<?php echo $i; ?>][q]" value="<?php echo esc_attr($faq['q']); ?>" placeholder="سوال را وارد کنید...">
                            </div>
                            <div>
                                <label class="faq-field-label"><i class="fas fa-comment-dots"></i> پاسخ:</label>
                                <textarea name="tez_faqs[<?php echo $i; ?>][a]" placeholder="پاسخ را وارد کنید..."><?php echo esc_textarea($faq['a']); ?></textarea>
                            </div>
                            <div class="faq-item-actions">
                                <button type="button" class="button faq-remove-btn"><i class="fas fa-trash"></i> حذف</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="button" id="tez-add-faq"><i class="fas fa-plus"></i> افزودن سوال جدید</button>
            </div>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        // Toggle Switch
        $('input[name="tez_faq_enable"]').change(function() {
            if ($(this).is(':checked')) {
                $('.faq-body').slideDown(300);
            } else {
                $('.faq-body').slideUp(300);
            }
        });

        // Add FAQ Item
        $('#tez-add-faq').click(function() {
            $('#faq-empty-state').remove();
            var count = $('.faq-item-row').length;
            
            var html = '<div class="faq-item-row">' +
                '<div class="faq-item-header">' +
                    '<span class="faq-drag-handle"><i class="fas fa-grip-vertical"></i></span>' +
                    '<span class="faq-item-number">' + (count + 1) + '</span>' +
                '</div>' +
                '<div style="margin-bottom: 10px;">' +
                    '<label class="faq-field-label"><i class="fas fa-question"></i> سوال:</label>' +
                    '<input type="text" name="tez_faqs[' + count + '][q]" placeholder="سوال را وارد کنید...">' +
                '</div>' +
                '<div>' +
                    '<label class="faq-field-label"><i class="fas fa-comment-dots"></i> پاسخ:</label>' +
                    '<textarea name="tez_faqs[' + count + '][a]" placeholder="پاسخ را وارد کنید..."></textarea>' +
                '</div>' +
                '<div class="faq-item-actions">' +
                    '<button type="button" class="button faq-remove-btn"><i class="fas fa-trash"></i> حذف</button>' +
                '</div>' +
            '</div>';
            
            $('#tez-faq-items').append(html);
            updateNumbers();
        });

        // Remove FAQ Item
        $(document).on('click', '.faq-remove-btn', function() {
            $(this).closest('.faq-item-row').fadeOut(200, function() {
                $(this).remove();
                updateNumbers();
                reindexFaqs();
                
                if ($('.faq-item-row').length === 0) {
                    var empty = '<div class="faq-empty-state" id="faq-empty-state">' +
                        '<i class="fas fa-comments"></i>' +
                        '<p>هنوز سوالی اضافه نشده است. روی دکمه زیر کلیک کنید.</p>' +
                    '</div>';
                    $('#tez-faq-items').html(empty);
                }
            });
        });

        // Update Numbers
        function updateNumbers() {
            $('.faq-item-row').each(function(index) {
                $(this).find('.faq-item-number').text(index + 1);
            });
        }

        // Reindex FAQs
        function reindexFaqs() {
            $('.faq-item-row').each(function(index) {
                $(this).find('input[type="text"]').attr('name', 'tez_faqs[' + index + '][q]');
                $(this).find('textarea').attr('name', 'tez_faqs[' + index + '][a]');
            });
        }

        // Sortable
        if ($.fn.sortable) {
            $('#tez-faq-items').sortable({
                handle: '.faq-drag-handle',
                placeholder: 'ui-sortable-placeholder',
                opacity: 0.7,
                update: function() {
                    updateNumbers();
                    reindexFaqs();
                }
            });
        }
    });
    </script>
    <?php
}

// =============================================
// 4. SAVE META BOX
// =============================================
add_action('save_post', 'tez_faq_save_meta');
function tez_faq_save_meta($post_id) {
    if (!isset($_POST['tez_faq_nonce']) || !wp_verify_nonce($_POST['tez_faq_nonce'], 'tez_faq_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    // Save enable state
    update_post_meta($post_id, '_tez_faq_enable', isset($_POST['tez_faq_enable']) ? 'yes' : 'no');
    
    // Save settings
    if (isset($_POST['tez_faq_heading'])) {
        update_post_meta($post_id, '_tez_faq_heading', sanitize_text_field($_POST['tez_faq_heading']));
    }
    if (isset($_POST['tez_faq_position'])) {
        update_post_meta($post_id, '_tez_faq_position', sanitize_text_field($_POST['tez_faq_position']));
    }
    if (isset($_POST['tez_faq_style'])) {
        update_post_meta($post_id, '_tez_faq_style', sanitize_text_field($_POST['tez_faq_style']));
    }
    
    // Save FAQs
    if (isset($_POST['tez_faqs']) && is_array($_POST['tez_faqs'])) {
        $clean_faqs = array();
        foreach ($_POST['tez_faqs'] as $faq) {
            if (!empty($faq['q']) || !empty($faq['a'])) {
                $clean_faqs[] = array(
                    'q' => sanitize_text_field($faq['q']),
                    'a' => wp_kses_post($faq['a'])
                );
            }
        }
        update_post_meta($post_id, '_tez_faqs', $clean_faqs);
    } else {
        update_post_meta($post_id, '_tez_faqs', array());
    }
}

// =============================================
// 5. SHORTCODE
// =============================================
add_shortcode('tez_faq', 'tez_faq_shortcode');
function tez_faq_shortcode($atts) {
    global $post;
    if (!$post) return '';
    
    if (get_post_meta($post->ID, '_tez_faq_enable', true) !== 'yes') return '';
    
    return tez_faq_render_html($post->ID);
}

// =============================================
// 6. AUTO INSERT INTO CONTENT
// Priority 25 - AFTER Poll (priority 15) to prevent Poll from being inserted inside FAQ
// =============================================
add_filter('the_content', 'tez_faq_inject_content', 25);
function tez_faq_inject_content($content) {
    if (!is_singular('post') || !in_the_loop() || !is_main_query()) return $content;

    global $post;
    
    if (get_post_meta($post->ID, '_tez_faq_enable', true) !== 'yes') return $content;
    
    $position = get_post_meta($post->ID, '_tez_faq_position', true) ?: 'after_content';
    
    if ($position === 'manual') return $content;

    $faq_html = tez_faq_render_html($post->ID);

    switch ($position) {
        case 'before_content':
            return $faq_html . $content;
        case 'after_content':
        default:
            return $content . $faq_html;
    }
}

// =============================================
// 7. RENDER FAQ HTML
// =============================================
function tez_faq_render_html($post_id) {
    $faqs = get_post_meta($post_id, '_tez_faqs', true);
    if (empty($faqs)) return '';
    
    $style = get_post_meta($post_id, '_tez_faq_style', true) ?: 'modern';
    $heading = get_post_meta($post_id, '_tez_faq_heading', true) ?: 'سوالات متداول';
    
    // Add Schema to footer
    add_action('wp_footer', function() use ($faqs) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array()
        );
        foreach ($faqs as $faq) {
            if (!empty($faq['q']) && !empty($faq['a'])) {
                $schema['mainEntity'][] = array(
                    '@type' => 'Question',
                    'name' => $faq['q'],
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => strip_tags($faq['a'])
                    )
                );
            }
        }
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }, 99);

    ob_start();
    ?>
    <div class="tez-faq-container tez-faq-<?php echo esc_attr($style); ?>" 
         id="tez-faq-<?php echo $post_id; ?>"
         role="region"
         aria-label="<?php echo esc_attr($heading); ?>"
         dir="rtl"
         itemscope 
         itemtype="https://schema.org/FAQPage">
        
        <h3 class="tez-faq-heading">
            <i class="fas fa-circle-question" aria-hidden="true"></i>
            <?php echo esc_html($heading); ?>
        </h3>
        
        <div class="tez-faq-list">
            <?php foreach ($faqs as $index => $faq): 
                if (empty($faq['q'])) continue;
            ?>
            <div class="tez-faq-item" 
                 itemscope 
                 itemprop="mainEntity" 
                 itemtype="https://schema.org/Question"
                 data-index="<?php echo $index; ?>">
                
                <button class="tez-faq-question" 
                        type="button"
                        aria-expanded="false"
                        aria-controls="faq-answer-<?php echo $post_id; ?>-<?php echo $index; ?>"
                        id="faq-question-<?php echo $post_id; ?>-<?php echo $index; ?>">
                    <span itemprop="name"><?php echo esc_html($faq['q']); ?></span>
                    <span class="tez-faq-icon" aria-hidden="true">
                        <i class="fas fa-plus"></i>
                    </span>
                </button>
                
                <div class="tez-faq-answer" 
                     id="faq-answer-<?php echo $post_id; ?>-<?php echo $index; ?>"
                     role="region"
                     aria-labelledby="faq-question-<?php echo $post_id; ?>-<?php echo $index; ?>"
                     itemscope 
                     itemprop="acceptedAnswer" 
                     itemtype="https://schema.org/Answer"
                     hidden>
                    <div itemprop="text">
                        <?php echo wpautop($faq['a']); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// =============================================
// 8. FRONTEND CSS
// =============================================
add_action('wp_head', 'tez_faq_frontend_css', 99);
function tez_faq_frontend_css() {
    if (!is_singular('post')) return;
    ?>
    <style id="tez-faq-css">
    /* ============================================
       TEZ FAQ - BASE STYLES
       ============================================ */
    
    .tez-faq-container {
        --faq-primary: var(--tez-primary, #2563eb);
        --faq-primary-dark: var(--tez-primary-dark, #1e40af);
        --faq-primary-light: var(--tez-primary-light, #3b82f6);
        --faq-primary-rgb: var(--tez-primary-rgb, 37, 99, 235);
        --faq-bg: var(--tez-bg, #ffffff);
        --faq-bg-secondary: var(--tez-bg-secondary, #f9fafb);
        --faq-bg-tertiary: var(--tez-bg-tertiary, #f3f4f6);
        --faq-text: var(--tez-text, #111827);
        --faq-text-secondary: var(--tez-text-secondary, #374151);
        --faq-text-muted: var(--tez-text-muted, #6b7280);
        --faq-border: var(--tez-border, #e5e7eb);
        --faq-shadow: var(--tez-shadow-lg, 0 10px 15px -3px rgba(0, 0, 0, 0.1));
        --faq-radius: var(--tez-radius-xl, 1rem);
        --faq-transition: var(--tez-transition, 250ms cubic-bezier(0.4, 0, 0.2, 1));
        
        margin: 3rem 0;
        padding: 2rem;
        border-radius: var(--faq-radius);
        font-family: var(--tez-font, 'Vazirmatn', system-ui, sans-serif);
        direction: rtl;
        position: relative;
    }
    
    /* Heading */
    .tez-faq-heading {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0 0 1.5rem 0;
        padding-bottom: 1rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--faq-text);
        font-family: inherit;
        border-bottom: 2px solid var(--faq-primary);
    }
    
    .tez-faq-heading i {
        color: var(--faq-primary);
        font-size: 1.375rem;
    }
    
    /* List */
    .tez-faq-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    /* Item */
    .tez-faq-item {
        border: 1px solid var(--faq-border);
        border-radius: var(--tez-radius-lg, 0.75rem);
        overflow: hidden;
        transition: all var(--faq-transition);
    }
    
    .tez-faq-item:hover {
        border-color: var(--faq-primary);
        box-shadow: 0 4px 12px rgba(var(--faq-primary-rgb), 0.1);
    }
    
    /* Question Button */
    .tez-faq-question {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.125rem 1.25rem;
        background: var(--faq-bg);
        border: none;
        cursor: pointer;
        font-family: inherit;
        font-size: 1rem;
        font-weight: 700;
        color: var(--faq-text);
        text-align: right;
        transition: all var(--faq-transition);
    }
    
    .tez-faq-question:hover {
        background: var(--faq-bg-secondary);
        color: var(--faq-primary);
    }
    
    .tez-faq-question:focus-visible {
        outline: none;
        box-shadow: inset 0 0 0 2px var(--faq-primary);
    }
    
    .tez-faq-question span:first-child {
        flex: 1;
        line-height: 1.5;
    }
    
    /* Icon */
    .tez-faq-icon {
        width: 2rem;
        height: 2rem;
        min-width: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--faq-bg-tertiary);
        border-radius: 50%;
        color: var(--faq-text-muted);
        transition: all var(--faq-transition);
        margin-right: 1rem;
    }
    
    .tez-faq-icon i {
        font-size: 0.75rem;
        transition: transform var(--faq-transition);
    }
    
    .tez-faq-question[aria-expanded="true"] .tez-faq-icon {
        background: var(--faq-primary);
        color: #fff;
    }
    
    .tez-faq-question[aria-expanded="true"] .tez-faq-icon i {
        transform: rotate(45deg);
    }
    
    /* Answer */
    .tez-faq-answer {
        padding: 0 1.25rem;
        max-height: 0;
        overflow: hidden;
        background: var(--faq-bg-secondary);
        border-top: 1px solid var(--faq-border);
        transition: all 0.35s ease;
    }
    
    .tez-faq-answer:not([hidden]) {
        padding: 1.25rem;
        max-height: 1000px;
    }
    
    .tez-faq-answer[hidden] {
        display: block;
        border-top: none;
    }
    
    .tez-faq-answer div {
        color: var(--faq-text-secondary);
        line-height: 1.8;
        font-size: 0.9375rem;
    }
    
    .tez-faq-answer p {
        margin: 0 0 1rem 0;
        color: inherit;
    }
    
    .tez-faq-answer p:last-child {
        margin-bottom: 0;
    }
    
    /* ============================================
       STYLE: MODERN (Default)
       ============================================ */
    .tez-faq-modern {
        background: linear-gradient(135deg, var(--faq-bg-secondary) 0%, var(--faq-bg-tertiary) 100%);
        border: 1px solid var(--faq-border);
        box-shadow: var(--faq-shadow);
    }
    
    .tez-faq-modern:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--faq-primary) 0%, var(--faq-primary-dark) 100%);
        border-radius: 0 var(--faq-radius) var(--faq-radius) 0;
    }
    
    /* ============================================
       STYLE: MINIMAL
       ============================================ */
    .tez-faq-minimal {
        background: transparent;
        padding: 0;
        border: none;
        box-shadow: none;
    }
    
    .tez-faq-minimal .tez-faq-heading {
        padding-bottom: 0.75rem;
    }
    
    .tez-faq-minimal .tez-faq-item {
        border: none;
        border-bottom: 1px solid var(--faq-border);
        border-radius: 0;
    }
    
    .tez-faq-minimal .tez-faq-item:last-child {
        border-bottom: none;
    }
    
    .tez-faq-minimal .tez-faq-question {
        padding: 1rem 0;
        background: transparent;
    }
    
    .tez-faq-minimal .tez-faq-question:hover {
        background: transparent;
    }
    
    .tez-faq-minimal .tez-faq-answer {
        background: transparent;
        border-top: none;
        padding: 0 0 1rem 0;
    }
    
    .tez-faq-minimal .tez-faq-answer:not([hidden]) {
        padding: 0 0 1rem 2rem;
    }
    
    /* ============================================
       STYLE: BOXED
       ============================================ */
    .tez-faq-boxed {
        background: var(--faq-bg);
        border: 2px solid var(--faq-primary);
    }
    
    .tez-faq-boxed .tez-faq-heading {
        background: var(--faq-primary);
        color: #fff;
        margin: -2rem -2rem 1.5rem -2rem;
        padding: 1.25rem 2rem;
        border-bottom: none;
    }
    
    .tez-faq-boxed .tez-faq-heading i {
        color: #fff;
    }
    
    .tez-faq-boxed .tez-faq-item {
        border: 2px solid var(--faq-border);
    }
    
    .tez-faq-boxed .tez-faq-item:hover {
        border-color: var(--faq-primary);
    }
    
    /* ============================================
       STYLE: GRADIENT
       ============================================ */
    .tez-faq-gradient {
        background: linear-gradient(135deg, var(--faq-primary) 0%, var(--faq-primary-dark) 100%);
        border: none;
        color: #fff;
    }
    
    .tez-faq-gradient .tez-faq-heading {
        color: #fff;
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    .tez-faq-gradient .tez-faq-heading i {
        color: rgba(255, 255, 255, 0.9);
    }
    
    .tez-faq-gradient .tez-faq-item {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
    }
    
    .tez-faq-gradient .tez-faq-item:hover {
        border-color: rgba(255, 255, 255, 0.4);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .tez-faq-gradient .tez-faq-question {
        background: transparent;
        color: #fff;
    }
    
    .tez-faq-gradient .tez-faq-question:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    
    .tez-faq-gradient .tez-faq-icon {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    
    .tez-faq-gradient .tez-faq-question[aria-expanded="true"] .tez-faq-icon {
        background: #fff;
        color: var(--faq-primary);
    }
    
    .tez-faq-gradient .tez-faq-answer {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
    }
    
    .tez-faq-gradient .tez-faq-answer div,
    .tez-faq-gradient .tez-faq-answer p {
        color: rgba(255, 255, 255, 0.9);
    }
    
    /* ============================================
       DARK MODE
       ============================================ */
    [data-theme="dark"] .tez-faq-container {
        --faq-primary: var(--tez-primary, #3b82f6);
        --faq-primary-dark: var(--tez-primary-dark, #60a5fa);
        --faq-primary-light: var(--tez-primary-light, #2563eb);
        --faq-primary-rgb: 59, 130, 246;
        --faq-bg: var(--tez-bg, #0f172a);
        --faq-bg-secondary: var(--tez-bg-secondary, #1e293b);
        --faq-bg-tertiary: var(--tez-bg-tertiary, #334155);
        --faq-text: var(--tez-text, #f1f5f9);
        --faq-text-secondary: var(--tez-text-secondary, #e2e8f0);
        --faq-text-muted: var(--tez-text-muted, #94a3b8);
        --faq-border: var(--tez-border, #334155);
    }
    
    [data-theme="dark"] .tez-faq-modern {
        background: linear-gradient(135deg, var(--faq-bg-secondary) 0%, var(--faq-bg-tertiary) 100%);
    }
    
    [data-theme="dark"] .tez-faq-boxed .tez-faq-heading {
        background: var(--faq-primary);
    }
    
    /* ============================================
       SEPIA MODE
       ============================================ */
    [data-theme="sepia"] .tez-faq-container {
        --faq-primary: var(--tez-primary, #b45309);
        --faq-primary-dark: var(--tez-primary-dark, #92400e);
        --faq-primary-light: var(--tez-primary-light, #d97706);
        --faq-primary-rgb: 180, 83, 9;
        --faq-bg: var(--tez-bg, #faf6f1);
        --faq-bg-secondary: var(--tez-bg-secondary, #f5efe6);
        --faq-bg-tertiary: var(--tez-bg-tertiary, #ebe4d8);
        --faq-text: var(--tez-text, #44403c);
        --faq-text-secondary: var(--tez-text-secondary, #57534e);
        --faq-text-muted: var(--tez-text-muted, #78716c);
        --faq-border: var(--tez-border, #d6cfc4);
    }
    
    [data-theme="sepia"] .tez-faq-modern {
        background: linear-gradient(135deg, var(--faq-bg-secondary) 0%, var(--faq-bg-tertiary) 100%);
    }
    
    [data-theme="sepia"] .tez-faq-gradient {
        background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
    }
    
    /* ============================================
       ANIMATIONS
       ============================================ */
    @keyframes tezFaqFadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .tez-faq-container {
        animation: tezFaqFadeIn 0.5s ease-out;
    }
    
    .tez-faq-item {
        animation: tezFaqFadeIn 0.4s ease-out backwards;
    }
    
    .tez-faq-item:nth-child(1) { animation-delay: 0.1s; }
    .tez-faq-item:nth-child(2) { animation-delay: 0.15s; }
    .tez-faq-item:nth-child(3) { animation-delay: 0.2s; }
    .tez-faq-item:nth-child(4) { animation-delay: 0.25s; }
    .tez-faq-item:nth-child(5) { animation-delay: 0.3s; }
    .tez-faq-item:nth-child(6) { animation-delay: 0.35s; }
    .tez-faq-item:nth-child(7) { animation-delay: 0.4s; }
    .tez-faq-item:nth-child(8) { animation-delay: 0.45s; }
    
    /* ============================================
       REDUCED MOTION
       ============================================ */
    @media (prefers-reduced-motion: reduce) {
        .tez-faq-container,
        .tez-faq-item {
            animation: none;
        }
        
        .tez-faq-answer,
        .tez-faq-question,
        .tez-faq-icon,
        .tez-faq-icon i {
            transition: none;
        }
    }
    
    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 767px) {
        .tez-faq-container {
            margin: 2rem 0;
            padding: 1.25rem;
            border-radius: var(--tez-radius-lg, 0.75rem);
        }
        
        .tez-faq-heading {
            font-size: 1.25rem;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
        }
        
        .tez-faq-heading i {
            font-size: 1.125rem;
        }
        
        .tez-faq-question {
            padding: 1rem;
            font-size: 0.9375rem;
        }
        
        .tez-faq-icon {
            width: 1.75rem;
            height: 1.75rem;
            min-width: 1.75rem;
            margin-right: 0.75rem;
        }
        
        .tez-faq-answer:not([hidden]) {
            padding: 1rem;
        }
        
        .tez-faq-answer div {
            font-size: 0.875rem;
        }
        
        .tez-faq-boxed .tez-faq-heading {
            margin: -1.25rem -1.25rem 1.25rem -1.25rem;
            padding: 1rem 1.25rem;
        }
    }
    
    @media (max-width: 479px) {
        .tez-faq-container {
            padding: 1rem;
        }
        
        .tez-faq-heading {
            font-size: 1.125rem;
        }
        
        .tez-faq-question {
            padding: 0.875rem;
            font-size: 0.875rem;
        }
        
        .tez-faq-icon {
            width: 1.5rem;
            height: 1.5rem;
            min-width: 1.5rem;
            margin-right: 0.625rem;
        }
        
        .tez-faq-icon i {
            font-size: 0.625rem;
        }
    }
    
    /* ============================================
       PRINT STYLES
       ============================================ */
    @media print {
        .tez-faq-container {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
        .tez-faq-answer {
            display: block !important;
            max-height: none !important;
            padding: 1rem !important;
        }
        
        .tez-faq-answer[hidden] {
            display: block !important;
        }
        
        .tez-faq-icon {
            display: none !important;
        }
        
        .tez-faq-gradient {
            background: #f8f9fa !important;
            color: #111 !important;
        }
        
        .tez-faq-gradient .tez-faq-heading,
        .tez-faq-gradient .tez-faq-question,
        .tez-faq-gradient .tez-faq-answer div {
            color: #111 !important;
        }
    }
    
    /* ============================================
       FOCUS STYLES
       ============================================ */
    .tez-faq-question:focus {
        outline: none;
    }
    
    .tez-faq-question:focus-visible {
        outline: none;
        box-shadow: inset 0 0 0 2px var(--faq-primary);
        border-radius: var(--tez-radius-lg, 0.75rem) var(--tez-radius-lg, 0.75rem) 0 0;
    }
    </style>
    <?php
}

// =============================================
// 9. FRONTEND JS
// =============================================
add_action('wp_footer', 'tez_faq_frontend_js', 99);
function tez_faq_frontend_js() {
    if (!is_singular('post')) return;
    ?>
    <script id="tez-faq-js">
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Get all FAQ questions
            var questions = document.querySelectorAll('.tez-faq-question');
            
            questions.forEach(function(question) {
                question.addEventListener('click', function() {
                    var answer = this.nextElementSibling;
                    var isExpanded = this.getAttribute('aria-expanded') === 'true';
                    
                    // Toggle current
                    this.setAttribute('aria-expanded', !isExpanded);
                    
                    if (isExpanded) {
                        answer.setAttribute('hidden', '');
                    } else {
                        answer.removeAttribute('hidden');
                    }
                });
                
                // Keyboard navigation
                question.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
        });
    })();
    </script>
    <?php
}
