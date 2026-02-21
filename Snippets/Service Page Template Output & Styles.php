if (!defined('ABSPATH')) exit;

/**
 * =============================================
 * TEZ SERVICE PAGE TEMPLATE
 * =============================================
 * 
 * TESTIMONIALS FORMAT:
 * Each line: Name|Major|Review Text|Rating (1-5)
 * Example: سارا محمدی|دانشجوی دکتری مدیریت|تحلیل عالی بود|5
 * 
 * FAQ FORMAT:
 * Each line: Question|Answer
 * Example: چطور سفارش دهم؟|از فرم زیر اقدام کنید
 * 
 * REQUIRED META FIELDS:
 * _tez_page_template = 'service'
 * _tez_hero_subtitle
 * _tez_features
 * _tez_testimonials
 * _tez_faq
 * _tez_price_from
 * 
 * OPTIONAL META FIELDS FOR SCHEMA:
 * _tez_author_name (default: دکتر رامین نامجو)
 * _tez_author_job (default: مدیر علمی)
 * _tez_author_desc
 * _tez_author_url
 * _tez_reviewer_name
 * _tez_reviewer_job
 */

// =============================================
// SERVICE PAGE TEMPLATE FILTER
// =============================================
if (!function_exists('tez_service_disable_third_party_schema')) {
    function tez_service_disable_third_party_schema() {
        // Rank Math
        add_filter('rank_math/json_ld', '__return_empty_array', 99);

        // Yoast SEO
        add_filter('wpseo_json_ld_output', '__return_false', 99);
        add_filter('wpseo_schema_graph', '__return_empty_array', 99);
        add_filter('wpseo_schema_graph_pieces', '__return_empty_array', 99);

        // All in One SEO (best-effort)
        add_filter('aioseo_schema_disable', '__return_true', 99);
        add_filter('aioseo_disable_schema', '__return_true', 99);

        // SEOPress (best-effort)
        add_filter('seopress_json_ld_disable', '__return_true', 99);
    }
}

if (!function_exists('tez_service_template_filter')) {
    function tez_service_template_filter($template) {
        if (is_page()) {
            $post_id = get_the_ID();
            $page_template = get_post_meta($post_id, '_tez_page_template', true);
            
            if ($page_template === 'service') {
                // Prevent duplicate/invalid schema from SEO plugins on service pages
                tez_service_disable_third_party_schema();

                // Create a temporary template file path
                $custom_template = plugin_dir_path(__FILE__) . 'templates/service-page-template.php';
                
                // If custom template file doesn't exist, create inline template
                if (!file_exists($custom_template)) {
                    // Use inline template rendering
                    add_action('template_redirect', 'tez_service_render_full_page');
                    return $template;
                }
                
                return $custom_template;
            }
        }
        return $template;
    }
    add_filter('template_include', 'tez_service_template_filter');
}

// =============================================
// FULL PAGE RENDER (Bypass Theme Template)
// =============================================
if (!function_exists('tez_service_render_full_page')) {
    function tez_service_render_full_page() {
        if (!is_page()) return;
        
        $post_id = get_the_ID();
        $page_template = get_post_meta($post_id, '_tez_page_template', true);
        
        if ($page_template !== 'service') return;
        
        // Start output buffering
        ob_start();
        
        // Get the service page content
        get_header();
        
        // Remove default page title/breadcrumb actions from theme
        remove_all_actions('woocommerce_before_main_content');
        remove_all_actions('ocean_page_header');
        remove_all_actions('generate_before_content');
        
        echo '<div class="tez-svc-page">';
        echo tez_service_render_page('');
        echo '</div>';
        
        get_footer();
        
        // Output and exit
        echo ob_get_clean();
        exit;
    }
}

// =============================================
// AJAX HANDLER FOR FORM SUBMISSION
// =============================================
if (!function_exists('tez_service_form_submit_handler')) {
    function tez_service_form_submit_handler() {
        // Verify nonce
        if (!isset($_POST['tez_inquiry_nonce']) || !wp_verify_nonce($_POST['tez_inquiry_nonce'], 'tez_inquiry_submit')) {
            wp_send_json_error(array('message' => 'خطای امنیتی. لطفا صفحه را رفرش کنید.'));
            return;
        }
        
        // Sanitize inputs
        $name = isset($_POST['tez_name']) ? sanitize_text_field($_POST['tez_name']) : '';
        $phone = isset($_POST['tez_phone']) ? sanitize_text_field($_POST['tez_phone']) : '';
        $major = isset($_POST['tez_major']) ? sanitize_text_field($_POST['tez_major']) : '';
        $project_type = isset($_POST['tez_project_type']) ? sanitize_text_field($_POST['tez_project_type']) : '';
        $description = isset($_POST['tez_description']) ? sanitize_textarea_field($_POST['tez_description']) : '';
        $source_page = isset($_POST['tez_source_page']) ? intval($_POST['tez_source_page']) : 0;
        
        // Validate required fields
        if (empty($name) || empty($phone) || empty($major) || empty($project_type) || empty($description)) {
            wp_send_json_error(array('message' => 'لطفا تمام فیلدهای ضروری را پر کنید.'));
            return;
        }
        
        // Validate phone number
        if (!preg_match('/^09[0-9]{9}$/', $phone)) {
            wp_send_json_error(array('message' => 'شماره موبایل باید ۱۱ رقم و با ۰۹ شروع شود.'));
            return;
        }
        
        // Get page title
        $page_title = $source_page ? get_the_title($source_page) : 'نامشخص';
        $page_url = $source_page ? get_permalink($source_page) : '';
        
        // Handle file upload
        $attachment_path = '';
        $attachment_name = '';
        if (!empty($_FILES['tez_file']['name'])) {
            $allowed_types = array(
                'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                'application/pdf',
                'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'text/plain', 'application/rtf',
                'application/zip', 'application/x-rar-compressed'
            );
            
            $file_type = wp_check_filetype($_FILES['tez_file']['name']);
            $file_mime = $_FILES['tez_file']['type'];
            
            if (!in_array($file_mime, $allowed_types)) {
                wp_send_json_error(array('message' => 'نوع فایل مجاز نیست.'));
                return;
            }
            
            // Check file size (10MB max)
            if ($_FILES['tez_file']['size'] > 10 * 1024 * 1024) {
                wp_send_json_error(array('message' => 'حجم فایل نباید بیشتر از ۱۰ مگابایت باشد.'));
                return;
            }
            
            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['basedir'] . '/tez-inquiries/';
            
            if (!file_exists($upload_path)) {
                wp_mkdir_p($upload_path);
            }
            
            $filename = time() . '_' . sanitize_file_name($_FILES['tez_file']['name']);
            $target_path = $upload_path . $filename;
            
            if (move_uploaded_file($_FILES['tez_file']['tmp_name'], $target_path)) {
                $attachment_path = $target_path;
                $attachment_name = $_FILES['tez_file']['name'];
            }
        }
        
        // Email configuration
        $sender_email = 'sales@teznevisan3.com';
        $receiver_emails = array(
            'teznevisancompany@gmail.com',
            'Raminnamjoo@yahoo.com',
            'maziyarid@gmail.com'
        );
        
        // Current date in Persian format
        $current_date = date('Y/m/d - H:i');
        
        // Build RTL HTML email template
        $email_subject = 'درخواست جدید از صفحه: ' . $page_title . ' - ' . $name;
        
        $email_body = '
<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درخواست جدید</title>
</head>
<body style="margin: 0; padding: 0; font-family: Tahoma, Arial, sans-serif; background-color: #f4f7fa; direction: rtl;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f7fa; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width: 600px; width: 100%;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); padding: 35px 30px; border-radius: 16px 16px 0 0; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">
                                📩 درخواست جدید دریافت شد
                            </h1>
                            <p style="color: rgba(255,255,255,0.9); margin: 12px 0 0 0; font-size: 14px;">
                                ' . esc_html($current_date) . '
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Source Page Banner -->
                    <tr>
                        <td style="background-color: #eff6ff; padding: 20px 30px; border-bottom: 1px solid #dbeafe;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="text-align: right;">
                                        <span style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                            📄 صفحه درخواست
                                        </span>
                                        <p style="margin: 10px 0 0 0; font-size: 16px; font-weight: 700; color: #1e40af;">
                                            ' . esc_html($page_title) . '
                                        </p>
                                        ' . ($page_url ? '<a href="' . esc_url($page_url) . '" style="color: #3b82f6; font-size: 13px; text-decoration: none;">مشاهده صفحه ←</a>' : '') . '
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Main Content -->
                    <tr>
                        <td style="background-color: #ffffff; padding: 35px 30px;">
                            
                            <!-- Customer Info Section -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 25px;">
                                <tr>
                                    <td style="padding-bottom: 15px; border-bottom: 2px solid #f1f5f9;">
                                        <h2 style="color: #0f172a; margin: 0; font-size: 16px; font-weight: 700;">
                                            👤 اطلاعات مشتری
                                        </h2>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Info Cards -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 30px;">
                                <!-- Name -->
                                <tr>
                                    <td style="padding: 14px 18px; background-color: #f8fafc; border-radius: 10px; margin-bottom: 10px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="130" style="color: #64748b; font-size: 13px; font-weight: 600;">
                                                    نام و نام خانوادگی:
                                                </td>
                                                <td style="color: #0f172a; font-size: 15px; font-weight: 700;">
                                                    ' . esc_html($name) . '
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td style="height: 10px;"></td></tr>
                                
                                <!-- Phone -->
                                <tr>
                                    <td style="padding: 14px 18px; background-color: #f8fafc; border-radius: 10px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="130" style="color: #64748b; font-size: 13px; font-weight: 600;">
                                                    شماره موبایل:
                                                </td>
                                                <td style="color: #0f172a; font-size: 15px; font-weight: 700;" dir="ltr">
                                                    <a href="tel:' . esc_attr($phone) . '" style="color: #2563eb; text-decoration: none;">' . esc_html($phone) . '</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td style="height: 10px;"></td></tr>
                                
                                <!-- Major -->
                                <tr>
                                    <td style="padding: 14px 18px; background-color: #f8fafc; border-radius: 10px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="130" style="color: #64748b; font-size: 13px; font-weight: 600;">
                                                    رشته تحصیلی:
                                                </td>
                                                <td style="color: #0f172a; font-size: 15px; font-weight: 700;">
                                                    ' . esc_html($major) . '
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td style="height: 10px;"></td></tr>
                                
                                <!-- Project Type -->
                                <tr>
                                    <td style="padding: 14px 18px; background-color: #f8fafc; border-radius: 10px;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="130" style="color: #64748b; font-size: 13px; font-weight: 600;">
                                                    نوع پروژه:
                                                </td>
                                                <td>
                                                    <span style="display: inline-block; background-color: #dbeafe; color: #1e40af; padding: 5px 12px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                                                        ' . esc_html($project_type) . '
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Description Section -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 20px;">
                                <tr>
                                    <td style="padding-bottom: 15px; border-bottom: 2px solid #f1f5f9;">
                                        <h2 style="color: #0f172a; margin: 0; font-size: 16px; font-weight: 700;">
                                            📝 توضیحات پروژه
                                        </h2>
                                    </td>
                                </tr>
                            </table>
                            
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 20px; background-color: #fefce8; border-radius: 12px; border-right: 4px solid #facc15;">
                                        <p style="margin: 0; color: #1e293b; font-size: 14px; line-height: 1.9; white-space: pre-wrap;">' . esc_html($description) . '</p>
                                    </td>
                                </tr>
                            </table>
                            
                            ' . ($attachment_name ? '
                            <!-- Attachment Section -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding: 16px 20px; background-color: #f0fdf4; border-radius: 10px; border: 1px solid #bbf7d0;">
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td>
                                                    <span style="color: #16a34a; font-size: 14px; font-weight: 600;">
                                                        📎 فایل پیوست:
                                                    </span>
                                                    <span style="color: #15803d; font-size: 14px; margin-right: 8px;">
                                                        ' . esc_html($attachment_name) . '
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            ' : '') . '
                            
                        </td>
                    </tr>
                    
                    <!-- Call to Action -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 25px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <a href="tel:' . esc_attr($phone) . '" style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 14px 35px; border-radius: 10px; text-decoration: none; font-size: 15px; font-weight: 700;">
                                📞 تماس با مشتری
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1e293b; padding: 25px 30px; border-radius: 0 0 16px 16px; text-align: center;">
                            <p style="color: #94a3b8; margin: 0; font-size: 12px;">
                                این ایمیل به صورت خودکار از طریق وب‌سایت ارسال شده است.
                            </p>
                            <p style="color: #64748b; margin: 10px 0 0 0; font-size: 11px;">
                                © ' . date('Y') . ' تزنویسان - تمامی حقوق محفوظ است.
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
        
        // Email headers
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: تزنویسان <' . $sender_email . '>',
            'Reply-To: ' . $sender_email
        );
        
        // Prepare attachments
        $attachments = array();
        if (!empty($attachment_path) && file_exists($attachment_path)) {
            $attachments[] = $attachment_path;
        }
        
        // Send emails to all receivers
        $email_sent = false;
        foreach ($receiver_emails as $receiver) {
            $sent = wp_mail($receiver, $email_subject, $email_body, $headers, $attachments);
            if ($sent) {
                $email_sent = true;
            }
        }
        
        if ($email_sent) {
            // Optionally save to database here
            wp_send_json_success(array('message' => 'درخواست شما با موفقیت ثبت شد. کارشناسان ما به زودی با شما تماس خواهند گرفت.'));
        } else {
            wp_send_json_error(array('message' => 'خطا در ارسال درخواست. لطفا دوباره تلاش کنید یا با پشتیبانی تماس بگیرید.'));
        }
    }
    add_action('wp_ajax_tez_service_form_submit', 'tez_service_form_submit_handler');
    add_action('wp_ajax_nopriv_tez_service_form_submit', 'tez_service_form_submit_handler');
}

// =============================================
// RENDER SERVICE PAGE
// =============================================
if (!function_exists('tez_service_strip_jsonld_scripts')) {
    function tez_service_strip_jsonld_scripts($html) {
        if (!is_string($html) || $html === '') {
            return $html;
        }

        // Remove any JSON-LD scripts that may be pasted into page content (common source of schema errors)
        return preg_replace('#<script[^>]*type=[\"\"]application/ld\+json[\"\"][^>]*>.*?</script>#is', '', $html);
    }
}

if (!function_exists('tez_service_render_page')) {
    function tez_service_render_page($content) {
        if (!is_page()) return $content;
        
        $post_id = get_the_ID();
        $page_template = get_post_meta($post_id, '_tez_page_template', true);
        
        if ($page_template !== 'service') return $content;
        
        // Get meta data
        $hero_subtitle = get_post_meta($post_id, '_tez_hero_subtitle', true);
        $hero_bg = get_post_meta($post_id, '_tez_hero_bg_image', true);
        $hero_icon = get_post_meta($post_id, '_tez_hero_icon', true) ?: 'fa-solid fa-star';
        $features = get_post_meta($post_id, '_tez_features', true);
        $process_steps = get_post_meta($post_id, '_tez_process_steps', true);
        $price_from = get_post_meta($post_id, '_tez_price_from', true);
        $price_note = get_post_meta($post_id, '_tez_price_note', true);
        $testimonials = get_post_meta($post_id, '_tez_testimonials', true);
        $faq = get_post_meta($post_id, '_tez_faq', true);
        $cta_title = get_post_meta($post_id, '_tez_cta_title', true) ?: 'همین الان سفارش خود را ثبت کنید';
        $cta_text = get_post_meta($post_id, '_tez_cta_text', true) ?: 'ثبت سفارش رایگان';
        
        // Author and Reviewer meta for schema
        $author_name = get_post_meta($post_id, '_tez_author_name', true) ?: 'دکتر رامین نامجو';
        $author_job = get_post_meta($post_id, '_tez_author_job', true) ?: 'مدیر علمی و متخصص تحلیل آماری';
        $author_desc = get_post_meta($post_id, '_tez_author_desc', true) ?: '';
        $author_url = get_post_meta($post_id, '_tez_author_url', true) ?: home_url('/about-us/');
        $reviewer_name = get_post_meta($post_id, '_tez_reviewer_name', true) ?: '';
        $reviewer_job = get_post_meta($post_id, '_tez_reviewer_job', true) ?: '';
        
        ob_start();
        ?>
        
        <!-- Service Page Container -->
        <div class="tez-svc-page">
        
        <!-- Service Page Styles -->
        <style id="tez-service-styles">
            /* =============================================
               CSS CUSTOM PROPERTIES (Design Tokens)
            ============================================= */
            :root {
                /* Primary Colors */
                --tez-primary: #2563eb;
                --tez-primary-hover: #1d4ed8;
                --tez-primary-dark: #1e40af;
                --tez-primary-light: #3b82f6;
                --tez-primary-glow: rgba(37, 99, 235, 0.15);
                
                /* Accent Colors */
                --tez-accent: #f59e0b;
                --tez-accent-dark: #d97706;
                --tez-secondary: #7c3aed;
                
                /* Light Mode - Background Colors */
                --tez-bg-primary: #ffffff;
                --tez-bg-secondary: #f8fafc;
                --tez-bg-tertiary: #f1f5f9;
                --tez-bg-hero: #eff6ff;
                --tez-bg-cta: #2563eb;
                
                /* Light Mode - Border Colors */
                --tez-border: #e2e8f0;
                --tez-border-light: #f1f5f9;
                
                /* Light Mode - Text Colors */
                --tez-text-primary: #0f172a;
                --tez-text-secondary: #334155;
                --tez-text-muted: #64748b;
                --tez-text-light: #94a3b8;
                
                /* Feedback Colors */
                --tez-success: #10b981;
                --tez-success-bg: #d1fae5;
                --tez-success-text: #065f46;
                --tez-error: #ef4444;
                --tez-error-bg: #fee2e2;
                --tez-error-text: #991b1b;
                
                /* Shadows */
                --tez-shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
                --tez-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --tez-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                --tez-shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                --tez-shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
                
                /* Border Radius */
                --tez-radius-sm: 8px;
                --tez-radius-md: 12px;
                --tez-radius-lg: 16px;
                --tez-radius-xl: 24px;
                --tez-radius-full: 9999px;
                
                /* Transitions */
                --tez-transition-fast: 0.15s ease;
                --tez-transition-normal: 0.3s ease;
                --tez-transition-slow: 0.5s ease;
                
                /* Spacing */
                --tez-section-padding: 80px;
            }
            
            /* =============================================
               DARK MODE VARIABLES
            ============================================= */
            [data-theme="dark"],
            .dark-mode,
            body.dark {
                --tez-bg-primary: #0f172a;
                --tez-bg-secondary: #1e293b;
                --tez-bg-tertiary: #334155;
                --tez-bg-hero: #1e293b;
                --tez-bg-cta: #1e40af;
                
                --tez-border: #334155;
                --tez-border-light: #475569;
                
                --tez-text-primary: #f8fafc;
                --tez-text-secondary: #e2e8f0;
                --tez-text-muted: #94a3b8;
                --tez-text-light: #64748b;
                
                --tez-primary-glow: rgba(59, 130, 246, 0.25);
                
                --tez-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
                --tez-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
                --tez-shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            }
            
            /* =============================================
               BASE STYLES
            ============================================= */
            .tez-svc-page {
                direction: rtl;
                font-family: inherit;
                line-height: 1.6;
                color: var(--tez-text-primary);
                background-color: var(--tez-bg-primary);
            }
            
            .tez-svc-page *,
            .tez-svc-page *::before,
            .tez-svc-page *::after {
                box-sizing: border-box;
            }
            
            /* Force full-width container */
            .tez-svc-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 24px;
                width: 100%;
            }
            
            /* Full-width bleed sections */
            .tez-svc-bleed {
                width: 100vw;
                position: relative;
                left: 50%;
                right: 50%;
                margin-left: -50vw;
                margin-right: -50vw;
            }
            
            /* =============================================
               HERO SECTION - Light Background
            ============================================= */
            .tez-svc-hero {
                background-color: var(--tez-bg-hero);
                background-image: url('<?php echo esc_url($hero_bg); ?>');
                background-size: cover;
                background-position: center;
                background-blend-mode: overlay;
                color: var(--tez-text-primary);
                padding: var(--tez-section-padding) 0;
                position: relative;
                overflow: hidden;
            }
            
            .tez-svc-hero::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(239, 246, 255, 0.92);
                pointer-events: none;
            }
            
            [data-theme="dark"] .tez-svc-hero::before,
            .dark-mode .tez-svc-hero::before {
                background: rgba(15, 23, 42, 0.92);
            }
            
            .tez-svc-hero::after {
                content: '';
                position: absolute;
                top: -50%;
                right: -20%;
                width: 60%;
                height: 200%;
                background: radial-gradient(ellipse, rgba(37, 99, 235, 0.08) 0%, transparent 70%);
                pointer-events: none;
            }
            
            .tez-svc-hero-content {
                position: relative;
                z-index: 2;
                max-width: 800px;
                margin: 0 auto;
                text-align: center;
                padding: 0 24px;
            }
            
            .tez-svc-hero-icon {
                width: 88px;
                height: 88px;
                background: var(--tez-bg-primary);
                border: 2px solid var(--tez-border);
                border-radius: var(--tez-radius-xl);
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 28px;
                font-size: 40px;
                color: var(--tez-primary);
                box-shadow: var(--tez-shadow-lg);
                animation: tez-float 3s ease-in-out infinite;
            }
            
            @keyframes tez-float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }
            
            .tez-svc-hero h1 {
                font-size: clamp(2rem, 5vw, 3.25rem);
                font-weight: 800;
                margin-bottom: 18px;
                color: var(--tez-text-primary) !important;
                line-height: 1.2;
                letter-spacing: -0.02em;
            }
            
            .tez-svc-hero-subtitle {
                font-size: 1.25rem;
                color: var(--tez-text-secondary);
                margin-bottom: 36px;
                line-height: 1.7;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
            }
            
            .tez-svc-hero-cta {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: var(--tez-primary);
                color: #ffffff !important;
                padding: 18px 36px;
                border-radius: var(--tez-radius-md);
                font-weight: 700;
                font-size: 1.125rem;
                text-decoration: none;
                transition: all var(--tez-transition-normal);
                box-shadow: 0 4px 14px var(--tez-primary-glow);
            }
            
            .tez-svc-hero-cta:hover {
                background: var(--tez-primary-hover);
                transform: translateY(-3px);
                box-shadow: 0 12px 28px var(--tez-primary-glow);
                color: #ffffff !important;
            }
            
            .tez-svc-hero-cta:focus {
                outline: 3px solid var(--tez-primary);
                outline-offset: 3px;
            }
            
            .tez-svc-hero-cta i {
                transition: transform var(--tez-transition-normal);
                color: #ffffff !important;
            }
            
            .tez-svc-hero-cta:hover i {
                transform: translateX(-4px);
                color: #ffffff !important;
            }
            
            /* =============================================
               SECTION COMMON STYLES
            ============================================= */
            .tez-svc-section {
                padding: var(--tez-section-padding) 0;
                background: var(--tez-bg-primary);
            }
            
            .tez-svc-section-alt {
                background: var(--tez-bg-secondary);
            }
            
            .tez-svc-section-title {
                text-align: center;
                margin-bottom: 56px;
            }
            
            .tez-svc-section-title h2 {
                font-size: clamp(1.5rem, 3vw, 2.25rem);
                font-weight: 800;
                margin-bottom: 14px;
                color: var(--tez-text-primary);
                display: inline-flex;
                align-items: center;
                gap: 12px;
            }
            
            .tez-svc-section-title h2 i {
                color: var(--tez-primary);
                font-size: 0.85em;
            }
            
            .tez-svc-section-title p {
                color: var(--tez-text-muted);
                font-size: 1.125rem;
                max-width: 500px;
                margin: 0 auto;
            }
            
            /* =============================================
               INQUIRY FORM SECTION
            ============================================= */
            .tez-svc-inquiry-section {
                background: var(--tez-bg-tertiary);
                padding: 70px 0;
                position: relative;
            }
            
            .tez-svc-inquiry-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--tez-primary), var(--tez-secondary), var(--tez-primary));
            }
            
            .tez-svc-inquiry-card {
                background: var(--tez-bg-primary);
                border-radius: var(--tez-radius-xl);
                box-shadow: var(--tez-shadow-2xl);
                padding: 48px;
                max-width: 800px;
                margin: 0 auto;
                border: 1px solid var(--tez-border-light);
                position: relative;
                overflow: hidden;
            }
            
            .tez-svc-inquiry-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--tez-primary), var(--tez-secondary));
            }
            
            .tez-svc-inquiry-card h3 {
                text-align: center;
                font-size: 1.625rem;
                font-weight: 800;
                margin-bottom: 10px;
                color: var(--tez-text-primary);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }
            
            .tez-svc-inquiry-card h3 i {
                color: var(--tez-primary);
            }
            
            .tez-svc-inquiry-card .tez-svc-form-subtitle {
                text-align: center;
                color: var(--tez-text-muted);
                margin-bottom: 36px;
                font-size: 1.05rem;
            }
            
            .tez-svc-form-row {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
                margin-bottom: 4px;
                align-items: start;
            }
            
            @media (max-width: 640px) {
                .tez-svc-form-row {
                    grid-template-columns: 1fr;
                    gap: 4px;
                }
                
                .tez-svc-inquiry-card {
                    padding: 32px 24px;
                    margin: 0 16px;
                }
            }
            
            .tez-svc-form-group {
                margin-bottom: 24px;
            }
            
            .tez-svc-form-group label {
                display: flex;
                align-items: center;
                gap: 8px;
                font-weight: 600;
                margin-bottom: 10px;
                color: var(--tez-text-primary);
                font-size: 0.95rem;
            }
            
            .tez-svc-form-group label i {
                color: var(--tez-primary);
                font-size: 0.9em;
                width: 18px;
                text-align: center;
            }
            
            .tez-svc-form-group label .tez-svc-required {
                color: var(--tez-error);
                margin-right: auto;
                margin-left: 0;
            }
            
            .tez-svc-form-control {
                width: 100%;
                padding: 16px 18px;
                border: 2px solid var(--tez-border);
                border-radius: var(--tez-radius-md);
                font-size: 1rem;
                transition: all var(--tez-transition-normal);
                background: var(--tez-bg-primary);
                color: var(--tez-text-primary);
            }
            
            .tez-svc-form-control:hover {
                border-color: var(--tez-text-light);
            }
            
            .tez-svc-form-control:focus {
                outline: none;
                border-color: var(--tez-primary);
                box-shadow: 0 0 0 4px var(--tez-primary-glow);
            }
            
            .tez-svc-form-control::placeholder {
                color: var(--tez-text-light);
            }
            
            textarea.tez-svc-form-control {
                min-height: 140px;
                resize: vertical;
                line-height: 1.7;
            }
            
            select.tez-svc-form-control {
                cursor: pointer;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: left 16px center;
                padding-left: 40px;
            }
            
            /* File Upload */
            .tez-svc-file-upload {
                border: 2px dashed var(--tez-border);
                border-radius: var(--tez-radius-md);
                padding: 36px 24px;
                text-align: center;
                cursor: pointer;
                transition: all var(--tez-transition-normal);
                background: var(--tez-bg-secondary);
                position: relative;
            }
            
            .tez-svc-file-upload:hover {
                border-color: var(--tez-primary);
                background: var(--tez-bg-tertiary);
            }
            
            .tez-svc-file-upload.dragging {
                border-color: var(--tez-primary);
                background: var(--tez-bg-tertiary);
                transform: scale(1.01);
            }
            
            .tez-svc-file-upload i {
                font-size: 2.75rem;
                color: var(--tez-text-light);
                margin-bottom: 14px;
                display: block;
                transition: all var(--tez-transition-normal);
            }
            
            .tez-svc-file-upload:hover i {
                color: var(--tez-primary);
                transform: translateY(-4px);
            }
            
            .tez-svc-file-upload p {
                margin: 0;
                color: var(--tez-text-secondary);
                font-weight: 500;
            }
            
            .tez-svc-file-upload .tez-svc-file-types {
                font-size: 0.85rem;
                color: var(--tez-text-light);
                margin-top: 10px;
                font-weight: 400;
            }
            
            .tez-svc-file-input {
                display: none;
            }
            
            .tez-svc-file-name {
                margin-top: 14px;
                color: var(--tez-primary);
                font-weight: 600;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }
            
            .tez-svc-file-name.has-file::before {
                content: '\f15b';
                font-family: 'Font Awesome 6 Free';
                font-weight: 900;
            }
            
            .tez-svc-file-name.error {
                color: var(--tez-error);
            }
            
            /* Submit Button */
            .tez-svc-submit-btn {
                width: 100%;
                background: var(--tez-primary);
                color: #ffffff;
                border: none;
                padding: 20px 36px;
                border-radius: var(--tez-radius-md);
                font-size: 1.125rem;
                font-weight: 700;
                cursor: pointer;
                transition: all var(--tez-transition-normal);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                box-shadow: 0 4px 14px var(--tez-primary-glow);
                margin-top: 8px;
            }
            
            .tez-svc-submit-btn:hover:not(:disabled) {
                background: var(--tez-primary-hover);
                transform: translateY(-3px);
                box-shadow: 0 12px 35px var(--tez-primary-glow);
            }
            
            .tez-svc-submit-btn:focus {
                outline: 3px solid var(--tez-primary);
                outline-offset: 3px;
            }
            
            .tez-svc-submit-btn:disabled {
                opacity: 0.7;
                cursor: not-allowed;
                transform: none !important;
            }
            
            .tez-svc-submit-btn i {
                transition: transform var(--tez-transition-normal);
            }
            
            .tez-svc-submit-btn:hover:not(:disabled) i {
                transform: translateX(-4px);
            }
            
            .tez-svc-submit-btn i {
                color: #ffffff !important;
            }
            
            /* Form Messages */
            .tez-svc-form-message {
                padding: 18px 20px;
                border-radius: var(--tez-radius-md);
                margin-top: 24px;
                display: none;
                font-weight: 500;
                align-items: center;
                gap: 10px;
            }
            
            .tez-svc-form-message.success {
                background: var(--tez-success-bg);
                color: var(--tez-success-text);
                display: flex;
                border: 1px solid var(--tez-success);
            }
            
            .tez-svc-form-message.error {
                background: var(--tez-error-bg);
                color: var(--tez-error-text);
                display: flex;
                border: 1px solid var(--tez-error);
            }
            
            /* =============================================
               FEATURES SECTION
            ============================================= */
            .tez-svc-features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 28px;
            }
            
            .tez-svc-feature-card {
                background: var(--tez-bg-primary);
                border-radius: var(--tez-radius-lg);
                padding: 36px;
                box-shadow: var(--tez-shadow-md);
                transition: all var(--tez-transition-normal);
                border: 1px solid var(--tez-border-light);
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
                background: linear-gradient(90deg, var(--tez-primary), var(--tez-secondary));
                opacity: 0;
                transition: opacity var(--tez-transition-normal);
            }
            
            .tez-svc-feature-card:hover {
                transform: translateY(-6px);
                box-shadow: var(--tez-shadow-xl);
            }
            
            .tez-svc-feature-card:hover::before {
                opacity: 1;
            }
            
            .tez-svc-feature-icon {
                width: 64px;
                height: 64px;
                background: var(--tez-bg-tertiary);
                border-radius: var(--tez-radius-lg);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 26px;
                color: var(--tez-primary);
                margin-bottom: 22px;
                transition: all var(--tez-transition-normal);
            }
            
            .tez-svc-feature-card:hover .tez-svc-feature-icon {
                transform: scale(1.1) rotate(-5deg);
            }
            
            .tez-svc-feature-card h4 {
                font-size: 1.2rem;
                font-weight: 700;
                margin-bottom: 10px;
                color: var(--tez-text-primary);
            }
            
            .tez-svc-feature-card p {
                color: var(--tez-text-muted);
                margin: 0;
                line-height: 1.75;
            }
            
            /* =============================================
               PROCESS SECTION
            ============================================= */
            .tez-svc-process-steps {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 48px;
                counter-reset: step;
            }
            
            .tez-svc-process-step {
                flex: 1;
                min-width: 220px;
                max-width: 300px;
                text-align: center;
                position: relative;
            }
            
            .tez-svc-step-icon {
                width: 88px;
                height: 88px;
                background: var(--tez-primary);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 34px;
                color: #ffffff;
                margin: 0 auto 24px;
                position: relative;
                box-shadow: 0 8px 24px var(--tez-primary-glow);
                transition: all var(--tez-transition-normal);
            }
            
            .tez-svc-process-step:hover .tez-svc-step-icon {
                transform: scale(1.08);
                box-shadow: 0 12px 32px var(--tez-primary-glow);
            }
            
            .tez-svc-step-icon::before {
                counter-increment: step;
                content: counter(step);
                position: absolute;
                top: -6px;
                right: -6px;
                width: 32px;
                height: 32px;
                background: var(--tez-accent);
                border-radius: 50%;
                font-size: 15px;
                font-weight: 800;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #1e293b;
                box-shadow: 0 2px 8px rgba(251, 191, 36, 0.4);
            }
            
            .tez-svc-process-step h4 {
                font-size: 1.2rem;
                font-weight: 700;
                margin-bottom: 10px;
                color: var(--tez-text-primary);
            }
            
            .tez-svc-process-step p {
                color: var(--tez-text-muted);
                margin: 0;
                line-height: 1.7;
            }
            
            /* =============================================
               PRICING SECTION - Light Background
            ============================================= */
            .tez-svc-pricing-card {
                background: var(--tez-bg-tertiary);
                border-radius: var(--tez-radius-xl);
                padding: 56px;
                text-align: center;
                color: var(--tez-text-primary);
                max-width: 520px;
                margin: 0 auto;
                position: relative;
                overflow: hidden;
                box-shadow: var(--tez-shadow-xl);
                border: 1px solid var(--tez-border);
            }
            
            .tez-svc-pricing-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--tez-primary), var(--tez-accent));
            }
            
            .tez-svc-pricing-label {
                font-size: 1.05rem;
                color: var(--tez-text-muted);
                margin-bottom: 10px;
            }
            
            .tez-svc-pricing-value {
                font-size: clamp(2.75rem, 6vw, 4rem);
                font-weight: 800;
                margin-bottom: 18px;
                color: var(--tez-primary);
            }
            
            .tez-svc-pricing-note {
                color: var(--tez-text-muted);
                margin-bottom: 36px;
                font-size: 1.05rem;
            }
            
            .tez-svc-pricing-btn {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: var(--tez-primary);
                color: #ffffff !important;
                padding: 18px 44px;
                border-radius: var(--tez-radius-md);
                font-weight: 700;
                font-size: 1.125rem;
                text-decoration: none;
                transition: all var(--tez-transition-normal);
            }
            
            .tez-svc-pricing-btn:hover {
                background: var(--tez-primary-hover);
                transform: translateY(-3px);
                box-shadow: 0 12px 32px var(--tez-primary-glow);
                color: #ffffff !important;
            }
            
            .tez-svc-pricing-btn i {
                color: #ffffff !important;
            }
            
            /* =============================================
               TESTIMONIALS SECTION
            ============================================= */
            .tez-svc-testimonials-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                gap: 28px;
            }
            
            .tez-svc-testimonial-card {
                background: var(--tez-bg-primary);
                border-radius: var(--tez-radius-lg);
                padding: 36px;
                box-shadow: var(--tez-shadow-md);
                border: 1px solid var(--tez-border-light);
                transition: all var(--tez-transition-normal);
            }
            
            .tez-svc-testimonial-card:hover {
                transform: translateY(-4px);
                box-shadow: var(--tez-shadow-lg);
            }
            
            .tez-svc-testimonial-stars {
                color: var(--tez-accent);
                margin-bottom: 18px;
                font-size: 1.1rem;
                letter-spacing: 2px;
            }
            
            .tez-svc-testimonial-text {
                color: var(--tez-text-secondary);
                line-height: 1.85;
                margin-bottom: 24px;
                font-size: 1.05rem;
                position: relative;
                padding-right: 20px;
            }
            
            .tez-svc-testimonial-text::before {
                content: '"';
                position: absolute;
                right: 0;
                top: -5px;
                font-size: 2rem;
                color: var(--tez-primary);
                opacity: 0.3;
                font-family: serif;
            }
            
            .tez-svc-testimonial-author {
                display: flex;
                align-items: center;
                gap: 14px;
            }
            
            .tez-svc-testimonial-avatar {
                width: 52px;
                height: 52px;
                background: var(--tez-primary);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ffffff;
                font-weight: 700;
                font-size: 1.25rem;
                flex-shrink: 0;
            }
            
            .tez-svc-testimonial-name {
                font-weight: 700;
                color: var(--tez-text-primary);
                margin-bottom: 2px;
            }
            
            .tez-svc-testimonial-major {
                font-size: 0.9rem;
                color: var(--tez-text-muted);
            }
            
            /* =============================================
               FAQ SECTION
            ============================================= */
            .tez-svc-faq-list {
                max-width: 840px;
                margin: 0 auto;
            }
            
            .tez-svc-faq-item {
                background: var(--tez-bg-primary);
                border-radius: var(--tez-radius-md);
                margin-bottom: 14px;
                border: 1px solid var(--tez-border);
                overflow: hidden;
                transition: all var(--tez-transition-normal);
            }
            
            .tez-svc-faq-item:hover {
                border-color: var(--tez-primary);
            }
            
            .tez-svc-faq-item.active {
                box-shadow: var(--tez-shadow-md);
                border-color: var(--tez-primary);
            }
            
            .tez-svc-faq-question {
                width: 100%;
                padding: 22px 26px;
                background: transparent;
                border: none;
                text-align: right;
                font-size: 1.05rem;
                font-weight: 600;
                color: var(--tez-text-primary);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                transition: all var(--tez-transition-normal);
                font-family: inherit;
            }
            
            .tez-svc-faq-question:hover {
                color: var(--tez-primary);
            }
            
            .tez-svc-faq-question:focus {
                outline: 2px solid var(--tez-primary);
                outline-offset: -2px;
            }
            
            .tez-svc-faq-question i {
                transition: transform var(--tez-transition-normal);
                color: var(--tez-primary);
                font-size: 0.9em;
                flex-shrink: 0;
            }
            
            .tez-svc-faq-item.active .tez-svc-faq-question i {
                transform: rotate(180deg);
            }
            
            .tez-svc-faq-answer {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.4s ease-out, padding 0.4s ease-out;
            }
            
            .tez-svc-faq-item.active .tez-svc-faq-answer {
                max-height: 600px;
            }
            
            .tez-svc-faq-answer-inner {
                padding: 0 26px 24px;
            }
            
            .tez-svc-faq-answer p {
                margin: 0;
                color: var(--tez-text-muted);
                line-height: 1.85;
            }
            
            /* =============================================
               CTA SECTION - Primary Background
            ============================================= */
            .tez-svc-cta-section {
                background: var(--tez-bg-cta);
                padding: var(--tez-section-padding) 0;
                text-align: center;
                color: #ffffff;
                position: relative;
                overflow: hidden;
            }
            
            .tez-svc-cta-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                pointer-events: none;
            }
            
            .tez-svc-cta-section h2 {
                font-size: clamp(1.5rem, 4vw, 2.5rem);
                font-weight: 800;
                margin-bottom: 28px;
                color: #ffffff !important;
                position: relative;
            }
            
            .tez-svc-cta-btn {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                background: #ffffff;
                color: var(--tez-primary) !important;
                padding: 20px 44px;
                border-radius: var(--tez-radius-md);
                font-weight: 700;
                font-size: 1.15rem;
                text-decoration: none;
                transition: all var(--tez-transition-normal);
                position: relative;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            }
            
            .tez-svc-cta-btn:hover {
                transform: translateY(-4px);
                box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
                color: var(--tez-primary-hover) !important;
            }
            
            .tez-svc-cta-btn:focus {
                outline: 3px solid #ffffff;
                outline-offset: 3px;
            }
            
            .tez-svc-cta-btn i {
                transition: transform var(--tez-transition-normal);
            }
            
            .tez-svc-cta-btn:hover i {
                transform: translateX(-4px) rotate(-15deg);
            }
            
            .tez-svc-cta-btn i {
                color: #ffffff !important;
            }
            
            /* =============================================
               MAIN CONTENT SECTION
            ============================================= */
            .tez-svc-main-content {
                padding: 70px 0;
            }
            
            .tez-svc-main-content-inner {
                max-width: 840px;
                margin: 0 auto;
            }
            
            .tez-svc-main-content-inner h2 {
                color: var(--tez-text-primary);
            }
            
            .tez-svc-main-content-inner p {
                color: var(--tez-text-secondary);
                line-height: 1.85;
            }
            
            /* =============================================
               RESPONSIVE ADJUSTMENTS
            ============================================= */
            @media (max-width: 768px) {
                :root {
                    --tez-section-padding: 60px;
                }
                
                .tez-svc-hero-icon {
                    width: 72px;
                    height: 72px;
                    font-size: 32px;
                }
                
                .tez-svc-features-grid {
                    grid-template-columns: 1fr;
                }
                
                .tez-svc-process-steps {
                    gap: 32px;
                }
                
                .tez-svc-process-step {
                    max-width: 100%;
                }
                
                .tez-svc-testimonials-grid {
                    grid-template-columns: 1fr;
                }
                
                .tez-svc-pricing-card {
                    padding: 40px 28px;
                }
                
                .tez-svc-bleed {
                    padding-left: 16px;
                    padding-right: 16px;
                }
            }
            
            /* =============================================
               ANIMATIONS
            ============================================= */
            @keyframes tez-fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .tez-svc-animate-in {
                animation: tez-fadeInUp 0.6s ease forwards;
            }
            
            /* Loading spinner animation */
            @keyframes tez-spin {
                to { transform: rotate(360deg); }
            }
            
            .fa-spin {
                animation: tez-spin 1s linear infinite;
            }
            
            /* Skip link for accessibility */
            .tez-svc-skip-link {
                position: absolute;
                top: -40px;
                left: 0;
                background: var(--tez-primary);
                color: #ffffff;
                padding: 8px 16px;
                z-index: 100;
                transition: top var(--tez-transition-fast);
                border-radius: 0 0 var(--tez-radius-sm) 0;
            }
            
            .tez-svc-skip-link:focus {
                top: 0;
            }
            
            /* Screen reader only */
            .sr-only {
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
            
            /* =============================================
               GLOBAL FIXES
            ============================================= */
            
            /* Ensure white text on dark backgrounds */
            [style*="background-color: #0f172a"],
            [style*="background-color: #1e293b"],
            [style*="background: #0f172a"],
            [style*="background: #1e293b"] {
                color: #ffffff !important;
            }
            
            /* Takeaways list icon spacing */
            .tez-takeaways-list li,
            .tez-takeaways-list > * {
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }
            
            .tez-takeaways-list li i,
            .tez-takeaways-list li svg,
            .tez-takeaways-list li .icon,
            .tez-takeaways-list li::before {
                flex-shrink: 0;
                margin-left: 10px;
            }
            
            /* If icons are inline with text */
            .tez-takeaways-list i + span,
            .tez-takeaways-list svg + span,
            .tez-takeaways-list .icon + span {
                margin-right: 8px;
            }
            
            /* RTL specific spacing */
            [dir="rtl"] .tez-takeaways-list li i,
            [dir="rtl"] .tez-takeaways-list li svg,
            [dir="rtl"] .tez-takeaways-list li .icon {
                margin-left: 10px;
                margin-right: 0;
            }

            /* Force white text on dark buttons */
            .tez-svc-hero-cta,
            .tez-svc-pricing-btn,
            .tez-svc-cta-btn,
            .tez-svc-submit-btn,
            .tez-svc-hero-cta *,
            .tez-svc-pricing-btn *,
            .tez-svc-cta-btn *,
            .tez-svc-submit-btn * {
                color: #ffffff !important;
            }

            /* Dark-mode: ensure any theme/WP buttons render with white text */
            [data-theme="dark"] .tez-svc-page .button,
            [data-theme="dark"] .tez-svc-page button,
            [data-theme="dark"] .tez-svc-page input[type="submit"],
            [data-theme="dark"] .tez-svc-page input[type="button"],
            [data-theme="dark"] .tez-svc-page .wp-element-button,
            [data-theme="dark"] .tez-svc-page .wp-block-button__link,
            .dark-mode .tez-svc-page .button,
            .dark-mode .tez-svc-page button,
            .dark-mode .tez-svc-page input[type="submit"],
            .dark-mode .tez-svc-page input[type="button"],
            .dark-mode .tez-svc-page .wp-element-button,
            .dark-mode .tez-svc-page .wp-block-button__link,
            body.dark .tez-svc-page .button,
            body.dark .tez-svc-page button,
            body.dark .tez-svc-page input[type="submit"],
            body.dark .tez-svc-page input[type="button"],
            body.dark .tez-svc-page .wp-element-button,
            body.dark .tez-svc-page .wp-block-button__link {
                color: #ffffff !important;
            }
        </style>
                   
            <!-- Hero Section - Full Width Bleed -->
            <section class="tez-svc-hero tez-svc-bleed" role="banner">
                <div class="tez-svc-hero-content">
                    <div class="tez-svc-hero-icon" aria-hidden="true">
                        <i class="<?php echo esc_attr($hero_icon); ?>"></i>
                    </div>
                    <h1><?php the_title(); ?></h1>
                    <?php if ($hero_subtitle) : ?>
                        <p class="tez-svc-hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                    <?php endif; ?>
                    <a href="#tez-svc-inquiry-form" class="tez-svc-hero-cta">
                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                        ثبت درخواست رایگان
                    </a>
                </div>
            </section>
            
            <!-- Inquiry Form Section -->
            <section class="tez-svc-inquiry-section tez-svc-bleed" id="tez-svc-inquiry-form" aria-labelledby="inquiry-form-title">
                <div class="tez-svc-container">
                    <div class="tez-svc-inquiry-card">
                        <h3 id="inquiry-form-title">
                            <i class="fa-solid fa-file-pen" aria-hidden="true"></i>
                            فرم درخواست خدمات
                        </h3>
                        <p class="tez-svc-form-subtitle">اطلاعات پروژه خود را وارد کنید تا کارشناسان ما با شما تماس بگیرند</p>
                        
                        <form id="tez-svc-inquiry-form-el" enctype="multipart/form-data" novalidate>
                            <?php wp_nonce_field('tez_inquiry_submit', 'tez_inquiry_nonce'); ?>
                            <input type="hidden" name="action" value="tez_service_form_submit">
                            <input type="hidden" name="tez_source_page" value="<?php echo esc_attr($post_id); ?>">
                            
                            <div class="tez-svc-form-row">
                                <div class="tez-svc-form-group">
                                    <label for="tez_name">
                                        <i class="fa-solid fa-user" aria-hidden="true"></i>
                                        نام و نام خانوادگی
                                        <span class="tez-svc-required" aria-hidden="true">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="tez_name" 
                                        name="tez_name" 
                                        class="tez-svc-form-control" 
                                        placeholder="مثال: علی احمدی" 
                                        required
                                        autocomplete="name"
                                        aria-required="true"
                                    >
                                </div>
                                <div class="tez-svc-form-group">
                                    <label for="tez_phone">
                                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                        شماره موبایل
                                        <span class="tez-svc-required" aria-hidden="true">*</span>
                                    </label>
                                    <input 
                                        type="tel" 
                                        id="tez_phone" 
                                        name="tez_phone" 
                                        class="tez-svc-form-control" 
                                        placeholder="09123456789" 
                                        dir="ltr" 
                                        required
                                        autocomplete="tel"
                                        pattern="09[0-9]{9}"
                                        inputmode="numeric"
                                        maxlength="11"
                                        aria-required="true"
                                        aria-describedby="phone-hint"
                                    >
                                    <small id="phone-hint" class="sr-only">شماره موبایل باید ۱۱ رقم و با ۰۹ شروع شود</small>
                                </div>
                            </div>
                            
                            <div class="tez-svc-form-row">
                                <div class="tez-svc-form-group">
                                    <label for="tez_major">
                                        <i class="fa-solid fa-graduation-cap" aria-hidden="true"></i>
                                        رشته تحصیلی
                                        <span class="tez-svc-required" aria-hidden="true">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="tez_major" 
                                        name="tez_major" 
                                        class="tez-svc-form-control" 
                                        placeholder="مثال: مدیریت بازرگانی" 
                                        required
                                        aria-required="true"
                                    >
                                </div>
                                <div class="tez-svc-form-group">
                                    <label for="tez_project_type">
                                        <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                                        نوع پروژه
                                        <span class="tez-svc-required" aria-hidden="true">*</span>
                                    </label>
                                    <select 
                                        id="tez_project_type" 
                                        name="tez_project_type" 
                                        class="tez-svc-form-control" 
                                        required
                                        aria-required="true"
                                    >
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
                            </div>
                            
                            <div class="tez-svc-form-group">
                                <label for="tez_description">
                                    <i class="fa-solid fa-align-left" aria-hidden="true"></i>
                                    توضیحات پروژه
                                    <span class="tez-svc-required" aria-hidden="true">*</span>
                                </label>
                                <textarea 
                                    id="tez_description" 
                                    name="tez_description" 
                                    class="tez-svc-form-control" 
                                    placeholder="لطفا جزئیات پروژه خود را شرح دهید..." 
                                    required
                                    aria-required="true"
                                ></textarea>
                            </div>
                            
                            <div class="tez-svc-form-group">
                                <label for="tez_file">
                                    <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                                    فایل پیوست (اختیاری)
                                </label>
                                <div class="tez-svc-file-upload" id="tez-svc-file-drop" role="button" tabindex="0" aria-describedby="file-types">
                                    <i class="fa-solid fa-file-arrow-up" aria-hidden="true"></i>
                                    <p>برای انتخاب فایل کلیک کنید یا فایل را اینجا رها کنید</p>
                                    <p class="tez-svc-file-types" id="file-types">فرمت‌های مجاز: تصاویر، PDF، Word، Excel، ZIP (حداکثر ۱۰MB)</p>
                                    <input 
                                        type="file" 
                                        name="tez_file" 
                                        id="tez_file" 
                                        class="tez-svc-file-input" 
                                        accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.rtf,.zip,.rar"
                                        aria-describedby="file-types"
                                    >
                                    <p class="tez-svc-file-name" id="tez-svc-file-name" aria-live="polite"></p>
                                </div>
                            </div>
                            
                            <button type="submit" class="tez-svc-submit-btn" id="tez-svc-submit-btn">
                                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                                <span>ارسال درخواست</span>
                            </button>
                            
                            <div class="tez-svc-form-message" id="tez-svc-form-message" role="alert" aria-live="assertive"></div>
                        </form>
                    </div>
                </div>
            </section>
            
            <!-- Main Content (from Classic Editor) -->
            <?php if (trim($content)) : ?>
            <section class="tez-svc-section tez-svc-main-content">
                <div class="tez-svc-container">
                    <div class="tez-svc-main-content-inner">
                        <?php echo tez_service_strip_jsonld_scripts($content); ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Features Section -->
            <?php if ($features) : ?>
            <section class="tez-svc-section tez-svc-section-alt tez-svc-bleed" aria-labelledby="features-title">
                <div class="tez-svc-container">
                    <div class="tez-svc-section-title">
                        <h2 id="features-title">
                            <i class="fa-solid fa-star" aria-hidden="true"></i>
                            چرا ما را انتخاب کنید؟
                        </h2>
                        <p>ویژگی‌ها و مزایای خدمات ما</p>
                    </div>
                    <div class="tez-svc-features-grid" role="list">
                        <?php
                        $features_arr = explode("\n", trim($features));
                        foreach ($features_arr as $feature) {
                            $parts = explode('|', trim($feature));
                            if (count($parts) >= 3) {
                                $f_icon = trim($parts[0]);
                                $f_title = trim($parts[1]);
                                $f_desc = trim($parts[2]);
                                ?>
                                <article class="tez-svc-feature-card" role="listitem">
                                    <div class="tez-svc-feature-icon" aria-hidden="true">
                                        <i class="<?php echo esc_attr($f_icon); ?>"></i>
                                    </div>
                                    <h4><?php echo esc_html($f_title); ?></h4>
                                    <p><?php echo esc_html($f_desc); ?></p>
                                </article>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Process Section -->
            <?php if ($process_steps) : ?>
            <section class="tez-svc-section tez-svc-bleed" aria-labelledby="process-title">
                <div class="tez-svc-container">
                    <div class="tez-svc-section-title">
                        <h2 id="process-title">
                            <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                            مراحل انجام کار
                        </h2>
                        <p>فرآیند ساده و شفاف همکاری با ما</p>
                    </div>
                    <div class="tez-svc-process-steps" role="list">
                        <?php
                        $steps_arr = explode("\n", trim($process_steps));
                        foreach ($steps_arr as $step) {
                            $parts = explode('|', trim($step));
                            if (count($parts) >= 3) {
                                $s_icon = trim($parts[0]);
                                $s_title = trim($parts[1]);
                                $s_desc = trim($parts[2]);
                                ?>
                                <div class="tez-svc-process-step" role="listitem">
                                    <div class="tez-svc-step-icon" aria-hidden="true">
                                        <i class="<?php echo esc_attr($s_icon); ?>"></i>
                                    </div>
                                    <h4><?php echo esc_html($s_title); ?></h4>
                                    <p><?php echo esc_html($s_desc); ?></p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Pricing Section -->
            <?php if ($price_from) : ?>
            <section class="tez-svc-section tez-svc-section-alt tez-svc-bleed" aria-labelledby="pricing-title">
                <div class="tez-svc-container">
                    <div class="tez-svc-section-title">
                        <h2 id="pricing-title">
                            <i class="fa-solid fa-tags" aria-hidden="true"></i>
                            تعرفه خدمات
                        </h2>
                    </div>
                    <div class="tez-svc-pricing-card">
                        <p class="tez-svc-pricing-label">شروع قیمت از</p>
                        <p class="tez-svc-pricing-value"><?php echo esc_html($price_from); ?></p>
                        <?php if ($price_note) : ?>
                            <p class="tez-svc-pricing-note"><?php echo esc_html($price_note); ?></p>
                        <?php endif; ?>
                        <a href="#tez-svc-inquiry-form" class="tez-svc-pricing-btn">
                            <i class="fa-solid fa-calculator" aria-hidden="true"></i>
                            دریافت قیمت دقیق
                        </a>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- Testimonials Section -->
            <?php if ($testimonials) : ?>
            <section class="tez-svc-section tez-svc-bleed" aria-labelledby="testimonials-title">
                <div class="tez-svc-container">
                    <div class="tez-svc-section-title">
                        <h2 id="testimonials-title">
                            <i class="fa-solid fa-comments" aria-hidden="true"></i>
                            نظرات مشتریان
                        </h2>
                        <p>تجربه همکاری دانشجویان با ما</p>
                    </div>
                    <div class="tez-svc-testimonials-grid" role="list">
                        <?php
                        $testimonials_arr = explode("\n", trim($testimonials));
                        foreach ($testimonials_arr as $testimonial) {
                            $parts = explode('|', trim($testimonial));
                            if (count($parts) >= 4) {
                                $t_name = trim($parts[0]);
                                $t_major = trim($parts[1]);
                                $t_text = trim($parts[2]);
                                $t_rating = intval(trim($parts[3]));
                                $t_initial = mb_substr($t_name, 0, 1);
                                ?>
                                <article class="tez-svc-testimonial-card" role="listitem">
                                    <div class="tez-svc-testimonial-stars" role="img" aria-label="امتیاز: <?php echo $t_rating; ?> از ۵ ستاره">
                                        <?php for ($i = 0; $i < $t_rating; $i++) : ?>
                                            <i class="fa-solid fa-star" aria-hidden="true"></i>
                                        <?php endfor; ?>
                                        <?php for ($i = $t_rating; $i < 5; $i++) : ?>
                                            <i class="fa-regular fa-star" aria-hidden="true"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <blockquote class="tez-svc-testimonial-text"><?php echo esc_html($t_text); ?></blockquote>
                                    <footer class="tez-svc-testimonial-author">
                                        <div class="tez-svc-testimonial-avatar" aria-hidden="true"><?php echo esc_html($t_initial); ?></div>
                                        <div>
                                            <cite class="tez-svc-testimonial-name"><?php echo esc_html($t_name); ?></cite>
                                            <div class="tez-svc-testimonial-major"><?php echo esc_html($t_major); ?></div>
                                        </div>
                                    </footer>
                                </article>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- FAQ Section -->
            <?php if ($faq) : ?>
            <section class="tez-svc-section tez-svc-section-alt tez-svc-bleed" aria-labelledby="faq-title">
                <div class="tez-svc-container">
                    <div class="tez-svc-section-title">
                        <h2 id="faq-title">
                            <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                            سوالات متداول
                        </h2>
                    </div>
                    <div class="tez-svc-faq-list" role="list">
                        <?php
                        $faq_arr = explode("\n", trim($faq));
                        $faq_index = 0;
                        foreach ($faq_arr as $faq_item) {
                            $parts = explode('|', trim($faq_item));
                            if (count($parts) >= 2) {
                                $q = trim($parts[0]);
                                $a = trim($parts[1]);
                                $faq_index++;
                                ?>
                                <div class="tez-svc-faq-item" role="listitem" data-faq-item>
                                    <button 
                                        class="tez-svc-faq-question" 
                                        type="button"
                                        aria-expanded="false"
                                        aria-controls="faq-answer-<?php echo $faq_index; ?>"
                                        id="faq-question-<?php echo $faq_index; ?>"
                                        data-faq-trigger
                                    >
                                        <span><?php echo esc_html($q); ?></span>
                                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                                    </button>
                                    <div 
                                        class="tez-svc-faq-answer" 
                                        id="faq-answer-<?php echo $faq_index; ?>"
                                        role="region"
                                        aria-labelledby="faq-question-<?php echo $faq_index; ?>"
                                        data-faq-content
                                    >
                                        <div class="tez-svc-faq-answer-inner">
                                            <p><?php echo esc_html($a); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>
            
            <!-- CTA Section -->
            <section class="tez-svc-cta-section tez-svc-bleed" role="complementary">
                <div class="tez-svc-container">
                    <h2><?php echo esc_html($cta_title); ?></h2>
                    <a href="#tez-svc-inquiry-form" class="tez-svc-cta-btn">
                        <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                        <?php echo esc_html($cta_text); ?>
                    </a>
                </div>
            </section>
            
            <?php
            // =============================================
            // STRUCTURED DATA (Schema.org JSON-LD)
            // =============================================
            $schema_data = tez_generate_service_schema($post_id, $testimonials, $faq, $price_from, $hero_subtitle, $hero_bg, $author_name, $author_job, $author_desc, $author_url, $reviewer_name, $reviewer_job);
            if ($schema_data) {
                echo '<script type="application/ld+json">' . wp_json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
            }
            ?>
            
        </div>
        
        <!-- Form JavaScript -->
        <script>
        (function() {
            'use strict';
            
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initTezServicePage);
            } else {
                initTezServicePage();
            }
            
            function initTezServicePage() {
                initFileUpload();
                initFormSubmission();
                initFaqAccordion();
                initSmoothScroll();
                initAnimations();
            }
            
            // =============================================
            // FILE UPLOAD HANDLING
            // =============================================
            function initFileUpload() {
                var fileInput = document.getElementById('tez_file');
                var fileDrop = document.getElementById('tez-svc-file-drop');
                var fileName = document.getElementById('tez-svc-file-name');
                
                if (!fileDrop || !fileInput || !fileName) return;
                
                // Click to upload
                fileDrop.addEventListener('click', function(e) {
                    if (e.target !== fileInput) {
                        fileInput.click();
                    }
                });
                
                // Keyboard accessibility
                fileDrop.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        fileInput.click();
                    }
                });
                
                // File selection
                fileInput.addEventListener('change', function() {
                    updateFileName(this.files);
                });
                
                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(function(eventName) {
                    fileDrop.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });
                
                // Highlight on drag
                ['dragenter', 'dragover'].forEach(function(eventName) {
                    fileDrop.addEventListener(eventName, function() {
                        this.classList.add('dragging');
                    });
                });
                
                // Remove highlight on leave/drop
                ['dragleave', 'drop'].forEach(function(eventName) {
                    fileDrop.addEventListener(eventName, function() {
                        this.classList.remove('dragging');
                    });
                });
                
                // Handle dropped files
                fileDrop.addEventListener('drop', function(e) {
                    var dt = e.dataTransfer;
                    if (dt && dt.files && dt.files.length > 0) {
                        fileInput.files = dt.files;
                        updateFileName(dt.files);
                    }
                });
                
                function updateFileName(files) {
                    if (files && files.length > 0) {
                        var file = files[0];
                        var maxSize = 10 * 1024 * 1024; // 10MB
                        
                        if (file.size > maxSize) {
                            fileName.textContent = 'خطا: حجم فایل بیشتر از ۱۰MB است';
                            fileName.classList.add('error');
                            fileName.classList.remove('has-file');
                            fileInput.value = '';
                            return;
                        }
                        
                        fileName.textContent = file.name;
                        fileName.classList.remove('error');
                        fileName.classList.add('has-file');
                    } else {
                        fileName.textContent = '';
                        fileName.classList.remove('has-file', 'error');
                    }
                }
            }
            
            // =============================================
            // FORM SUBMISSION
            // =============================================
            function initFormSubmission() {
                var form = document.getElementById('tez-svc-inquiry-form-el');
                var submitBtn = document.getElementById('tez-svc-submit-btn');
                var messageDiv = document.getElementById('tez-svc-form-message');
                var phoneInput = document.getElementById('tez_phone');
                var fileName = document.getElementById('tez-svc-file-name');
                
                if (!form || !submitBtn || !messageDiv) return;
                
                // Phone number validation and formatting
                if (phoneInput) {
                    phoneInput.addEventListener('input', function() {
                        // Remove non-numeric characters
                        var value = this.value.replace(/\D/g, '');
                        
                        // Limit to 11 digits
                        if (value.length > 11) {
                            value = value.slice(0, 11);
                        }
                        
                        this.value = value;
                    });
                    
                    phoneInput.addEventListener('blur', function() {
                        var value = this.value;
                        if (value && !value.match(/^09[0-9]{9}$/)) {
                            this.setCustomValidity('شماره موبایل باید ۱۱ رقم و با ۰۹ شروع شود');
                        } else {
                            this.setCustomValidity('');
                        }
                    });
                }
                
                // Form submission
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Validate phone
                    if (phoneInput) {
                        var phone = phoneInput.value;
                        if (!phone.match(/^09[0-9]{9}$/)) {
                            showMessage('error', 'شماره موبایل باید ۱۱ رقم و با ۰۹ شروع شود');
                            phoneInput.focus();
                            return;
                        }
                    }
                    
                    // Disable button and show loading
                    submitBtn.disabled = true;
                    var originalBtnText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i> در حال ارسال...';
                    submitBtn.setAttribute('aria-busy', 'true');
                    
                    // Create FormData
                    var formData = new FormData(form);
                    
                    // Send AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
                    
                    xhr.onload = function() {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.setAttribute('aria-busy', 'false');
                        
                        try {
                            var response = JSON.parse(xhr.responseText);
                            
                            if (response.success) {
                                showMessage('success', response.data.message);
                                form.reset();
                                if (fileName) {
                                    fileName.textContent = '';
                                    fileName.classList.remove('has-file', 'error');
                                }
                            } else {
                                showMessage('error', response.data.message || 'خطایی رخ داده است');
                            }
                        } catch (err) {
                            showMessage('error', 'خطا در ارتباط با سرور. لطفا دوباره تلاش کنید.');
                        }
                    };
                    
                    xhr.onerror = function() {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                        submitBtn.setAttribute('aria-busy', 'false');
                        showMessage('error', 'خطا در ارتباط با سرور.');
                    };
                    
                    xhr.send(formData);
                });
                
                function showMessage(type, message) {
                    var icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                    messageDiv.className = 'tez-svc-form-message ' + type;
                    messageDiv.innerHTML = '<i class="fa-solid ' + icon + '" aria-hidden="true"></i> ' + message;
                    
                    // Scroll to message
                    setTimeout(function() {
                        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                }
            }
            
            // =============================================
            // FAQ ACCORDION - Fixed Version
            // =============================================
            function initFaqAccordion() {
                var faqItems = document.querySelectorAll('[data-faq-item]');
                
                if (!faqItems.length) return;
                
                faqItems.forEach(function(item) {
                    var trigger = item.querySelector('[data-faq-trigger]');
                    
                    if (!trigger) return;
                    
                    trigger.addEventListener('click', function(e) {
                        e.preventDefault();
                        toggleFaq(item, trigger);
                    });
                    
                    trigger.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            toggleFaq(item, trigger);
                        }
                    });
                });
                
                function toggleFaq(item, trigger) {
                    var isActive = item.classList.contains('active');
                    var expanded = trigger.getAttribute('aria-expanded') === 'true';
                    
                    // Close all other items
                    faqItems.forEach(function(otherItem) {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            var otherTrigger = otherItem.querySelector('[data-faq-trigger]');
                            if (otherTrigger) {
                                otherTrigger.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });
                    
                    // Toggle current item
                    if (isActive) {
                        item.classList.remove('active');
                        trigger.setAttribute('aria-expanded', 'false');
                    } else {
                        item.classList.add('active');
                        trigger.setAttribute('aria-expanded', 'true');
                    }
                }
            }
            
            // =============================================
            // SMOOTH SCROLL
            // =============================================
            function initSmoothScroll() {
                var anchors = document.querySelectorAll('.tez-svc-page a[href^="#"]');
                
                anchors.forEach(function(anchor) {
                    anchor.addEventListener('click', function(e) {
                        var targetId = this.getAttribute('href');
                        
                        if (targetId === '#') return;
                        
                        var target = document.querySelector(targetId);
                        
                        if (target) {
                            e.preventDefault();
                            
                            var headerOffset = 80;
                            var elementPosition = target.getBoundingClientRect().top;
                            var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                            
                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                            
                            // Update URL hash without jumping
                            if (history.pushState) {
                                history.pushState(null, null, targetId);
                            }
                            
                            // Focus management for accessibility
                            target.setAttribute('tabindex', '-1');
                            target.focus({ preventScroll: true });
                        }
                    });
                });
            }
            
            // =============================================
            // ANIMATIONS ON SCROLL
            // =============================================
            function initAnimations() {
                if (!('IntersectionObserver' in window)) return;
                
                var animateElements = document.querySelectorAll('.tez-svc-feature-card, .tez-svc-process-step, .tez-svc-testimonial-card, .tez-svc-faq-item');
                
                if (!animateElements.length) return;
                
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry, index) {
                        if (entry.isIntersecting) {
                            setTimeout(function() {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                                entry.target.classList.add('tez-svc-animate-in');
                            }, index * 80);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });
                
                animateElements.forEach(function(el) {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';
                    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    observer.observe(el);
                });
            }
            
        })();
        </script>
        
        </div><!-- /.tez-svc-page -->
        
        <?php
        return ob_get_clean();
    }
}

// =============================================
// GENERATE SERVICE SCHEMA DATA
// =============================================
if (!function_exists('tez_generate_service_schema')) {
    function tez_generate_service_schema($post_id, $testimonials, $faq, $price_from, $hero_subtitle = '', $hero_image = '', $author_name = '', $author_job = '', $author_desc = '', $author_url = '', $reviewer_name = '', $reviewer_job = '') {
        $page_title = get_the_title($post_id);
        $page_url = get_permalink($post_id);
        $page_description = $hero_subtitle ?: get_the_excerpt($post_id);
        
        // Get featured image or hero bg
        if (empty($hero_image)) {
            $hero_image = get_post_meta($post_id, '_tez_hero_bg_image', true);
        }
        if (empty($hero_image) && has_post_thumbnail($post_id)) {
            $hero_image = get_the_post_thumbnail_url($post_id, 'full');
        }
        
        // Get site info
        $site_name = get_bloginfo('name');
        $site_url = home_url('/');
        $site_logo = get_site_icon_url() ?: $site_url . 'wp-content/uploads/logo.png';
        
        // Get proper ISO 8601 dates (fallback to current time if missing)
        $date_published = get_post_time('c', true, $post_id) ?: current_time('c');
        $date_modified = get_post_modified_time('c', true, $post_id) ?: $date_published;
        
        // Build Organization schema
        $organization_schema = array(
            '@type' => 'Organization',
            '@id' => $site_url . '#organization',
            'name' => $site_name,
            'url' => $site_url,
            'logo' => array(
                '@type' => 'ImageObject',
                '@id' => $site_url . '#logo',
                'url' => $site_logo,
                'contentUrl' => $site_logo,
                'width' => 512,
                'height' => 512,
                'caption' => $site_name
            ),
            'contactPoint' => array(
                '@type' => 'ContactPoint',
                'contactType' => 'Customer Service',
                'availableLanguage' => array('Persian', 'fa')
            )
        );
        
        // Build Author schema
        $author_schema = null;
        if ($author_name) {
            $author_schema = array(
                '@type' => 'Person',
                '@id' => $site_url . '#author',
                'name' => $author_name,
                'url' => $author_url ?: $site_url . 'about-us/'
            );
            if ($author_job) {
                $author_schema['jobTitle'] = $author_job;
            }
            if ($author_desc) {
                $author_schema['description'] = $author_desc;
            }
        }
        
        // Build Reviewer schema
        $reviewer_schema = null;
        if ($reviewer_name) {
            $reviewer_schema = array(
                '@type' => 'Person',
                '@id' => $site_url . '#reviewer',
                'name' => $reviewer_name
            );
            if ($reviewer_job) {
                $reviewer_schema['jobTitle'] = $reviewer_job;
            }
        }
        
        // Build Image schema
        $image_schema = null;
        if ($hero_image) {
            $image_schema = array(
                '@type' => 'ImageObject',
                '@id' => $page_url . '#primaryimage',
                'url' => $hero_image,
                'contentUrl' => $hero_image,
                'width' => 1200,
                'height' => 630,
                'caption' => $page_title
            );
        }
        
        // Build Service schema
        $service_schema = array(
            '@type' => 'Service',
            '@id' => $page_url . '#service',
            'name' => $page_title,
            'description' => $page_description,
            'url' => $page_url,
            'provider' => array(
                '@type' => 'Organization',
                '@id' => $site_url . '#organization',
                'name' => $site_name,
                'url' => $site_url
            ),
            'serviceType' => $page_title,
            'areaServed' => array(
                '@type' => 'Country',
                'name' => 'Iran'
            )
        );
        
        // Add image to service (use URL form for best compatibility)
        if ($hero_image) {
            $service_schema['image'] = $hero_image;
        } elseif ($site_logo) {
            $service_schema['image'] = $site_logo;
        }
        
        // Add price if available
        if ($price_from) {
            $price_numeric = preg_replace('/[^0-9]/', '', $price_from);
            if ($price_numeric) {
                // Offer expires in one year by default
                $price_valid_until = gmdate('Y-m-d', strtotime('+1 year'));
                $service_schema['offers'] = array(
                    '@type' => 'Offer',
                    'priceCurrency' => 'IRR',
                    'price' => (float) $price_numeric,
                    'priceSpecification' => array(
                        '@type' => 'PriceSpecification',
                        'price' => (float) $price_numeric,
                        'priceCurrency' => 'IRR'
                    ),
                    'availability' => 'https://schema.org/InStock',
                    'priceValidUntil' => $price_valid_until,
                    'url' => $page_url
                );
            }
        }
        
        // Parse and add reviews with proper itemReviewed
        $reviews = array();
        $total_rating = 0;
        $rating_count = 0;
        
        if ($testimonials) {
            $testimonials_arr = explode("\n", trim($testimonials));
            foreach ($testimonials_arr as $index => $testimonial) {
                $parts = explode('|', trim($testimonial));
                if (count($parts) >= 4) {
                    $t_name = trim($parts[0]);
                    $t_major = trim($parts[1]);
                    $t_text = trim($parts[2]);
                    $t_rating = intval(trim($parts[3]));
                    
                    if ($t_name && $t_text && $t_rating > 0) {
                        $total_rating += $t_rating;
                        $rating_count++;
                        
                        // Always use post date in proper ISO 8601 format - ignore any date in testimonial data
                        $review = array(
                            '@type' => 'Review',
                            '@id' => $page_url . '#review-' . ($index + 1),
                            'itemReviewed' => array(
                                '@type' => 'Service',
                                '@id' => $page_url . '#service',
                                'name' => $page_title,
                                'image' => $hero_image ?: $site_logo,
                                'url' => $page_url
                            ),
                            'reviewRating' => array(
                                '@type' => 'Rating',
                                'ratingValue' => (float) $t_rating,
                                'bestRating' => 5,
                                'worstRating' => 1
                            ),
                            'author' => array(
                                '@type' => 'Person',
                                'name' => $t_name
                            ),
                            'reviewBody' => $t_text,
                            'datePublished' => $date_published,
                            'publisher' => array(
                                '@id' => $site_url . '#organization'
                            )
                        );
                        
                        $reviews[] = $review;
                    }
                }
            }
        }
        
        // Add aggregateRating if reviews exist
        if ($rating_count > 0) {
            $avg_rating = round($total_rating / $rating_count, 1);
            $service_schema['aggregateRating'] = array(
                '@type' => 'AggregateRating',
                'ratingValue' => (float) $avg_rating,
                'reviewCount' => (int) $rating_count,
                'bestRating' => 5,
                'worstRating' => 1
            );
        }
        
        // Add reviews to service schema
        if (!empty($reviews)) {
            $service_schema['review'] = $reviews;
        }
        
        // Build Article schema (for better rich results)
        $article_schema = array(
            '@type' => 'Article',
            '@id' => $page_url . '#article',
            'headline' => $page_title,
            'description' => $page_description,
            'url' => $page_url,
            'datePublished' => $date_published,
            'dateModified' => $date_modified,
            'mainEntityOfPage' => array(
                '@id' => $page_url . '#webpage'
            ),
            'publisher' => array(
                '@id' => $site_url . '#organization'
            ),
            'inLanguage' => 'fa-IR'
        );
        
        // Add image to article
        if ($image_schema) {
            $article_schema['image'] = array(
                '@type' => 'ImageObject',
                'url' => $hero_image ?: $site_logo,
                'width' => 1200,
                'height' => 630
            );
        } else {
            // Fallback image to avoid missing image warning
            $article_schema['image'] = array(
                '@type' => 'ImageObject',
                'url' => $site_logo,
                'width' => 512,
                'height' => 512
            );
        }
        
        // Add author to article
        if ($author_schema) {
            $article_schema['author'] = array(
                '@type' => 'Person',
                'name' => $author_name,
                'url' => $author_url ?: $site_url . 'about-us/'
            );
            if ($author_job) {
                $article_schema['author']['jobTitle'] = $author_job;
            }
            if ($author_desc) {
                $article_schema['author']['description'] = $author_desc;
            }
            // Add author image fallback
            $article_schema['author']['image'] = array(
                '@type' => 'ImageObject',
                'url' => $site_logo,
                'width' => 512,
                'height' => 512
            );
        }
        
        // Add reviewer to article
        if ($reviewer_schema) {
            $article_schema['reviewedBy'] = array(
                '@type' => 'Person',
                'name' => $reviewer_name
            );
            if ($reviewer_job) {
                $article_schema['reviewedBy']['jobTitle'] = $reviewer_job;
            }
        }
        
        // Build FAQPage schema if FAQ exists
        $faq_schema = null;
        if ($faq) {
            $faq_entities = array();
            $faq_arr = explode("\n", trim($faq));
            
            foreach ($faq_arr as $faq_item) {
                $parts = explode('|', trim($faq_item));
                if (count($parts) >= 2) {
                    $q = trim($parts[0]);
                    $a = trim($parts[1]);
                    
                    if ($q && $a) {
                        $faq_entities[] = array(
                            '@type' => 'Question',
                            'name' => $q,
                            'acceptedAnswer' => array(
                                '@type' => 'Answer',
                                'text' => $a
                            )
                        );
                    }
                }
            }
            
            if (!empty($faq_entities)) {
                $faq_schema = array(
                    '@type' => 'FAQPage',
                    '@id' => $page_url . '#faq',
                    'mainEntity' => $faq_entities
                );
            }
        }
        
        // Build WebPage schema
        $webpage_schema = array(
            '@type' => 'WebPage',
            '@id' => $page_url . '#webpage',
            'url' => $page_url,
            'name' => $page_title,
            'description' => $page_description,
            'inLanguage' => 'fa-IR',
            'isPartOf' => array(
                '@id' => $site_url . '#website'
            ),
            'about' => array(
                '@id' => $page_url . '#service'
            ),
            'datePublished' => $date_published,
            'dateModified' => $date_modified
        );
        
        // Add primary image to webpage
        if ($image_schema) {
            $webpage_schema['primaryImageOfPage'] = array(
                '@id' => $page_url . '#primaryimage'
            );
        }
        
        // Build WebSite schema
        $website_schema = array(
            '@type' => 'WebSite',
            '@id' => $site_url . '#website',
            'url' => $site_url,
            'name' => $site_name,
            'publisher' => array(
                '@id' => $site_url . '#organization'
            ),
            'inLanguage' => 'fa-IR'
        );
        
        // Add breadcrumb schema
        $breadcrumb_schema = array(
            '@type' => 'BreadcrumbList',
            '@id' => $page_url . '#breadcrumb',
            'itemListElement' => array(
                array(
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'خانه',
                    'item' => $site_url
                ),
                array(
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => $page_title,
                    'item' => $page_url
                )
            )
        );
        
        // Combine all schemas into a graph
        $graph = array(
            '@context' => 'https://schema.org',
            '@graph' => array(
                $organization_schema,
                $website_schema,
                $webpage_schema,
                $breadcrumb_schema,
                $service_schema,
                $article_schema
            )
        );
        
        // Add image schema to graph if available
        if ($image_schema) {
            $graph['@graph'][] = $image_schema;
        }
        
        // Add FAQ schema to graph if available
        if ($faq_schema) {
            $graph['@graph'][] = $faq_schema;
        }
        
        return $graph;
    }
}
