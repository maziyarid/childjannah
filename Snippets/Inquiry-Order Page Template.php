/**
 * Teznevisan Inquiry Page Template - UPDATED
 * Version: 3.1.0
 * 
 * Updated: Multi-recipient email support
 * Sender: info@teznevisan3.com
 * Recipients: Multiple admin emails
 */

// ... (Keep all the previous code the same until the AJAX handler)

// =============================================
// AJAX HANDLER FOR INQUIRY FORM (UPDATED)
// =============================================
add_action('wp_ajax_tez_submit_inquiry', 'tez_handle_inquiry_submit');
add_action('wp_ajax_nopriv_tez_submit_inquiry', 'tez_handle_inquiry_submit');

function tez_handle_inquiry_submit() {
    // Verify nonce
    if (!isset($_POST['_nonce']) || !wp_verify_nonce($_POST['_nonce'], 'tez_inquiry_form')) {
        wp_send_json_error(['message' => 'خطای امنیتی. لطفاً صفحه را رفرش کنید.']);
    }
    
    // Rate limiting
    $ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    if (strpos($ip, ',') !== false) $ip = trim(explode(',', $ip)[0]);
    
    $rate_key = 'tez_inq_rate_' . md5($ip);
    $count = get_transient($rate_key);
    if ($count && $count >= 5) {
        wp_send_json_error(['message' => 'تعداد درخواست‌های شما زیاد است. لطفاً ۱۵ دقیقه بعد تلاش کنید.']);
    }
    
    // Sanitize inputs
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $project_type = sanitize_text_field($_POST['project_type'] ?? '');
    $education_level = sanitize_text_field($_POST['education_level'] ?? '');
    $major = sanitize_text_field($_POST['major'] ?? '');
    $university = sanitize_text_field($_POST['university'] ?? '');
    $urgency = sanitize_text_field($_POST['urgency'] ?? '');
    $deadline = sanitize_text_field($_POST['deadline'] ?? '');
    $budget = sanitize_text_field($_POST['budget'] ?? '');
    $description = sanitize_textarea_field($_POST['description'] ?? '');
    $source = absint($_POST['source'] ?? 0);
    
    // Validation
    if (mb_strlen($name) < 3) {
        wp_send_json_error(['message' => 'نام و نام خانوادگی باید حداقل ۳ حرف باشد.', 'field' => 'name']);
    }
    if (!preg_match('/^09[0-9]{9}$/', $phone)) {
        wp_send_json_error(['message' => 'شماره موبایل نامعتبر است. مثال: 09123456789', 'field' => 'phone']);
    }
    if (!empty($email) && !is_email($email)) {
        wp_send_json_error(['message' => 'آدرس ایمیل نامعتبر است.', 'field' => 'email']);
    }
    if (empty($project_type)) {
        wp_send_json_error(['message' => 'لطفاً نوع پروژه را انتخاب کنید.', 'field' => 'project_type']);
    }
    if (empty($education_level)) {
        wp_send_json_error(['message' => 'لطفاً مقطع تحصیلی را انتخاب کنید.', 'field' => 'education_level']);
    }
    if (empty($major)) {
        wp_send_json_error(['message' => 'لطفاً رشته تحصیلی را وارد کنید.', 'field' => 'major']);
    }
    if (mb_strlen($description) < 20) {
        wp_send_json_error(['message' => 'توضیحات پروژه باید حداقل ۲۰ کاراکتر باشد.', 'field' => 'description']);
    }
    
    // Handle file upload
    $file_url = '';
    if (!empty($_FILES['file']['name'])) {
        $allowed = [
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png',
            'gif' => 'image/gif', 'webp' => 'image/webp', 'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'zip' => 'application/zip', 'rar' => 'application/x-rar-compressed',
        ];
        
        $file = $_FILES['file'];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            wp_send_json_error(['message' => 'خطا در آپلود فایل.']);
        }
        if ($file['size'] > 10 * 1024 * 1024) {
            wp_send_json_error(['message' => 'حجم فایل نباید بیشتر از ۱۰MB باشد.']);
        }
        
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!isset($allowed[$ext])) {
            wp_send_json_error(['message' => 'فرمت فایل مجاز نیست.']);
        }
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowed)) {
            wp_send_json_error(['message' => 'نوع فایل مجاز نیست.']);
        }
        
        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['basedir'] . '/tez-inquiries/' . date('Y/m');
        if (!file_exists($target_dir)) {
            wp_mkdir_p($target_dir);
            file_put_contents($target_dir . '/.htaccess', "Options -Indexes\n<FilesMatch '\.(php|phtml|php3|php4|php5|php7|phps|phar)$'>\nDeny from all\n</FilesMatch>");
        }
        
        $new_name = wp_generate_uuid4() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $target_dir . '/' . $new_name)) {
            $file_url = $upload_dir['baseurl'] . '/tez-inquiries/' . date('Y/m') . '/' . $new_name;
        }
    }
    
    // Create inquiry post
    $post_id = wp_insert_post([
        'post_type' => 'tez_inquiry',
        'post_title' => $name . ' - ' . $project_type . ' - ' . date('Y/m/d H:i'),
        'post_status' => 'publish',
    ]);
    
    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => 'خطا در ثبت درخواست. لطفاً دوباره تلاش کنید.']);
    }
    
    // Save meta
    update_post_meta($post_id, '_inq_name', $name);
    update_post_meta($post_id, '_inq_phone', $phone);
    update_post_meta($post_id, '_inq_email', $email);
    update_post_meta($post_id, '_inq_project_type', $project_type);
    update_post_meta($post_id, '_inq_education_level', $education_level);
    update_post_meta($post_id, '_inq_major', $major);
    update_post_meta($post_id, '_inq_university', $university);
    update_post_meta($post_id, '_inq_urgency', $urgency);
    update_post_meta($post_id, '_inq_deadline', $deadline);
    update_post_meta($post_id, '_inq_budget', $budget);
    update_post_meta($post_id, '_inq_description', $description);
    update_post_meta($post_id, '_inq_file', $file_url);
    update_post_meta($post_id, '_inq_source', $source);
    update_post_meta($post_id, '_inq_ip', $ip);
    update_post_meta($post_id, '_inq_status', 'new');
    
    // Update rate limit
    set_transient($rate_key, ($count ? $count + 1 : 1), 15 * MINUTE_IN_SECONDS);
    
    // =============================================
    // SEND EMAIL TO MULTIPLE RECIPIENTS
    // =============================================
    
    // All recipient emails
    $recipients = [
        'shoja.kord@yahoo.com',
        'teznevisan@gmail.com',
        'maziyarid@gmail.com',
        'teznevisancompany@gmail.com',
    ];
    
    // Email subject
    $subject = '🆕 درخواست جدید: ' . $name . ' - ' . $project_type;
    
    // Build HTML email message
    $message = tez_build_inquiry_email($name, $phone, $email, $project_type, $education_level, $major, $university, $urgency, $deadline, $budget, $description, $file_url, $post_id);
    
    // Set custom From email and name
    add_filter('wp_mail_from', function() {
        return 'info@teznevisan3.com';
    });
    
    add_filter('wp_mail_from_name', function() {
        return 'تز نویسان';
    });
    
    // Set HTML content type
    add_filter('wp_mail_content_type', function() {
        return 'text/html';
    });
    
    // Send email to all recipients
    $email_sent = wp_mail($recipients, $subject, $message);
    
    // Remove filters to avoid affecting other emails
    remove_filter('wp_mail_content_type', function() { return 'text/html'; });
    
    // Log if email failed (optional)
    if (!$email_sent) {
        update_post_meta($post_id, '_inq_email_status', 'failed');
    } else {
        update_post_meta($post_id, '_inq_email_status', 'sent');
        update_post_meta($post_id, '_inq_email_sent_to', implode(', ', $recipients));
    }
    
    // Send confirmation email to user (if email provided)
    if (!empty($email) && is_email($email)) {
        $user_subject = 'تأیید دریافت درخواست - تز نویسان';
        $user_message = tez_build_user_confirmation_email($name, $project_type, $post_id);
        wp_mail($email, $user_subject, $user_message);
    }
    
    wp_send_json_success([
        'message' => 'درخواست شما با موفقیت ثبت شد! کارشناسان ما در اسرع وقت با شما تماس خواهند گرفت.',
        'inquiry_id' => $post_id,
    ]);
}

// =============================================
// BUILD HTML EMAIL FOR ADMINS
// =============================================
function tez_build_inquiry_email($name, $phone, $email, $project_type, $education_level, $major, $university, $urgency, $deadline, $budget, $description, $file_url, $post_id) {
    $admin_url = admin_url('post.php?post=' . $post_id . '&action=edit');
    $urgency_labels = [
        'normal' => 'عادی',
        'medium' => 'نیمه فوری',
        'urgent' => 'فوری',
        'very_urgent' => 'خیلی فوری',
    ];
    $urgency_display = $urgency_labels[$urgency] ?? $urgency;
    
    $html = '
    <!DOCTYPE html>
    <html dir="rtl" lang="fa">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin:0;padding:0;font-family:Tahoma,Arial,sans-serif;background-color:#f4f7fa;direction:rtl;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;padding:30px 0;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);">
                        <!-- Header -->
                        <tr>
                            <td style="background:linear-gradient(135deg,#2563eb 0%,#7c3aed 100%);padding:30px;text-align:center;">
                                <h1 style="color:#ffffff;margin:0;font-size:24px;">🆕 درخواست جدید</h1>
                                <p style="color:rgba(255,255,255,0.9);margin:10px 0 0;font-size:14px;">یک درخواست جدید از طریق سایت ثبت شد</p>
                            </td>
                        </tr>
                        
                        <!-- Content -->
                        <tr>
                            <td style="padding:30px;">
                                <!-- Alert Box -->
                                <table width="100%" style="background-color:#fef3c7;border-radius:10px;margin-bottom:25px;">
                                    <tr>
                                        <td style="padding:15px 20px;">
                                            <strong style="color:#92400e;">⚡ فوریت: ' . esc_html($urgency_display) . '</strong>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Personal Info -->
                                <h2 style="color:#1e293b;font-size:18px;margin:0 0 15px;padding-bottom:10px;border-bottom:2px solid #e2e8f0;">👤 اطلاعات شخصی</h2>
                                <table width="100%" style="margin-bottom:25px;">
                                    <tr>
                                        <td width="120" style="padding:10px 0;color:#64748b;font-size:14px;">نام:</td>
                                        <td style="padding:10px 0;color:#1e293b;font-size:14px;font-weight:bold;">' . esc_html($name) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;color:#64748b;font-size:14px;">تلفن:</td>
                                        <td style="padding:10px 0;color:#1e293b;font-size:14px;font-weight:bold;" dir="ltr">' . esc_html($phone) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;color:#64748b;font-size:14px;">ایمیل:</td>
                                        <td style="padding:10px 0;color:#1e293b;font-size:14px;" dir="ltr">' . (esc_html($email) ?: '—') . '</td>
                                    </tr>
                                </table>
                                
                                <!-- Project Info -->
                                <h2 style="color:#1e293b;font-size:18px;margin:0 0 15px;padding-bottom:10px;border-bottom:2px solid #e2e8f0;">🎓 اطلاعات پروژه</h2>
                                <table width="100%" style="margin-bottom:25px;">
                                    <tr>
                                        <td width="120" style="padding:10px 0;color:#64748b;font-size:14px;">نوع پروژه:</td>
                                        <td style="padding:10px 0;color:#2563eb;font-size:14px;font-weight:bold;">' . esc_html($project_type) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;color:#64748b;font-size:14px;">مقطع:</td>
                                        <td style="padding:10px 0;color:#1e293b;font-size:14px;">' . esc_html($education_level) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;color:#64748b;font-size:14px;">رشته:</td>
                                        <td style="padding:10px 0;color:#1e293b;font-size:14px;">' . esc_html($major) . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;color:#64748b;font-size:14px;">دانشگاه:</td>
                                        <td style="padding:10px 0;color:#1e293b;font-size:14px;">' . (esc_html($university) ?: '—') . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;color:#64748b;font-size:14px;">مهلت تحویل:</td>
                                        <td style="padding:10px 0;color:#1e293b;font-size:14px;">' . (esc_html($deadline) ?: '—') . '</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;color:#64748b;font-size:14px;">بودجه:</td>
                                        <td style="padding:10px 0;color:#1e293b;font-size:14px;">' . (esc_html($budget) ?: '—') . '</td>
                                    </tr>
                                </table>
                                
                                <!-- Description -->
                                <h2 style="color:#1e293b;font-size:18px;margin:0 0 15px;padding-bottom:10px;border-bottom:2px solid #e2e8f0;">📝 توضیحات</h2>
                                <div style="background-color:#f8fafc;padding:20px;border-radius:10px;margin-bottom:25px;line-height:1.8;color:#334155;font-size:14px;">
                                    ' . nl2br(esc_html($description)) . '
                                </div>';
    
    // Add file link if exists
    if (!empty($file_url)) {
        $html .= '
                                <!-- File -->
                                <h2 style="color:#1e293b;font-size:18px;margin:0 0 15px;padding-bottom:10px;border-bottom:2px solid #e2e8f0;">📎 فایل پیوست</h2>
                                <p style="margin-bottom:25px;">
                                    <a href="' . esc_url($file_url) . '" style="display:inline-block;background-color:#10b981;color:#ffffff;padding:12px 24px;border-radius:8px;text-decoration:none;font-size:14px;">⬇️ دانلود فایل</a>
                                </p>';
    }
    
    $html .= '
                                <!-- CTA Button -->
                                <table width="100%" style="margin-top:20px;">
                                    <tr>
                                        <td align="center">
                                            <a href="' . esc_url($admin_url) . '" style="display:inline-block;background:linear-gradient(135deg,#2563eb 0%,#7c3aed 100%);color:#ffffff;padding:15px 40px;border-radius:10px;text-decoration:none;font-size:16px;font-weight:bold;">مشاهده در پیشخوان</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="background-color:#f8fafc;padding:20px;text-align:center;border-top:1px solid #e2e8f0;">
                                <p style="margin:0;color:#64748b;font-size:12px;">این ایمیل به صورت خودکار از طریق سایت تز نویسان ارسال شده است.</p>
                                <p style="margin:10px 0 0;color:#94a3b8;font-size:11px;">تاریخ: ' . date('Y/m/d H:i:s') . ' | IP: ' . esc_html($GLOBALS['tez_inquiry_ip'] ?? 'N/A') . '</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';
    
    return $html;
}

// =============================================
// BUILD CONFIRMATION EMAIL FOR USER
// =============================================
function tez_build_user_confirmation_email($name, $project_type, $post_id) {
    $html = '
    <!DOCTYPE html>
    <html dir="rtl" lang="fa">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin:0;padding:0;font-family:Tahoma,Arial,sans-serif;background-color:#f4f7fa;direction:rtl;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;padding:30px 0;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.1);">
                        <!-- Header -->
                        <tr>
                            <td style="background:linear-gradient(135deg,#10b981 0%,#059669 100%);padding:30px;text-align:center;">
                                <h1 style="color:#ffffff;margin:0;font-size:24px;">✅ درخواست شما ثبت شد</h1>
                            </td>
                        </tr>
                        
                        <!-- Content -->
                        <tr>
                            <td style="padding:30px;">
                                <p style="color:#1e293b;font-size:16px;line-height:1.8;margin:0 0 20px;">
                                    <strong>' . esc_html($name) . '</strong> عزیز،
                                </p>
                                <p style="color:#64748b;font-size:14px;line-height:1.8;margin:0 0 20px;">
                                    درخواست شما برای <strong style="color:#2563eb;">' . esc_html($project_type) . '</strong> با موفقیت ثبت شد.
                                </p>
                                
                                <div style="background-color:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:20px;margin:20px 0;">
                                    <p style="margin:0;color:#166534;font-size:14px;">
                                        <strong>کد پیگیری:</strong> TEZ-' . str_pad($post_id, 6, '0', STR_PAD_LEFT) . '
                                    </p>
                                </div>
                                
                                <p style="color:#64748b;font-size:14px;line-height:1.8;margin:0 0 20px;">
                                    کارشناسان ما در اسرع وقت (معمولاً کمتر از ۳۰ دقیقه) با شما تماس خواهند گرفت.
                                </p>
                                
                                <hr style="border:none;border-top:1px solid #e2e8f0;margin:25px 0;">
                                
                                <p style="color:#64748b;font-size:13px;line-height:1.8;margin:0;">
                                    در صورت نیاز به پیگیری، می‌توانید با شماره زیر تماس بگیرید:
                                </p>
                                <p style="margin:10px 0 0;text-align:center;">
                                    <a href="tel:09123456789" style="display:inline-block;background-color:#2563eb;color:#ffffff;padding:12px 30px;border-radius:8px;text-decoration:none;font-size:14px;">📞 تماس با پشتیبانی</a>
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="background-color:#f8fafc;padding:20px;text-align:center;border-top:1px solid #e2e8f0;">
                                <p style="margin:0;color:#64748b;font-size:12px;">با تشکر از اعتماد شما</p>
                                <p style="margin:10px 0 0;color:#2563eb;font-size:14px;font-weight:bold;">تز نویسان</p>
                                <p style="margin:10px 0 0;color:#94a3b8;font-size:11px;">www.teznevisan3.com</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';
    
    return $html;
}

// =============================================
// CONFIGURE SMTP (RECOMMENDED FOR RELIABLE DELIVERY)
// =============================================
// Add this to ensure emails are sent properly
add_action('phpmailer_init', function($phpmailer) {
    // Only apply for inquiry emails
    if (strpos($phpmailer->Subject, 'درخواست جدید') !== false || strpos($phpmailer->Subject, 'تأیید دریافت') !== false) {
        $phpmailer->From = 'info@teznevisan3.com';
        $phpmailer->FromName = 'تز نویسان';
        
        // Optional: Add Reply-To header
        $phpmailer->addReplyTo('info@teznevisan3.com', 'تز نویسان');
        
        // If you have SMTP configured, uncomment these:
        // $phpmailer->isSMTP();
        // $phpmailer->Host = 'your-smtp-host.com';
        // $phpmailer->SMTPAuth = true;
        // $phpmailer->Username = 'info@teznevisan3.com';
        // $phpmailer->Password = 'your-email-password';
        // $phpmailer->SMTPSecure = 'tls';
        // $phpmailer->Port = 587;
    }
});
