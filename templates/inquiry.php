<?php
/**
 * Template Name: Tez - Inquiry Page
 * Description: Order/inquiry page with full form and sidebar contact options.
 *
 * @package JannahChild
 * @version 3.3.0
 */
get_header();
$phone = defined('TEZ_PHONE') ? TEZ_PHONE : '09331663849';
$phone_display = defined('TEZ_PHONE_DISPLAY') ? TEZ_PHONE_DISPLAY : $phone;
$whatsapp = defined('TEZ_WHATSAPP') ? TEZ_WHATSAPP : '09331663849';
$telegram = defined('TEZ_TELEGRAM') ? TEZ_TELEGRAM : 'Thesissupport';
$email = defined('TEZ_EMAIL') ? TEZ_EMAIL : 'teznevisancompany@gmail.com';
?>

<section class="tez-page-hero">
    <div class="tez-hero-bg"><div class="tez-hero-pattern"></div></div>
    <div class="tez-hero-content tez-container">
        <h1><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i> ثبت سفارش</h1>
        <p>اطلاعات پروژه خود را وارد کنید، کارشناسان ما در اسرع وقت با شما تماس می‌گیرند</p>
    </div>
</section>

<section class="tez-section">
    <div class="tez-container">
        <div class="tez-inquiry-grid">

            <!-- Main Form -->
            <div>
                <div class="tez-form-card scroll-animate">
                    <div class="tez-form-header">
                        <div class="tez-form-icon"><i class="fa-solid fa-pen-to-square" aria-hidden="true"></i></div>
                        <h3>فرم ثبت سفارش</h3>
                        <p>لطفاً اطلاعات زیر را تکمیل کنید</p>
                    </div>

                    <form id="tez-inquiry-form" method="post" novalidate>
                        <?php wp_nonce_field('tez_inquiry_submit', 'tez_inquiry_nonce'); ?>

                        <div class="tez-form-section">
                            <h4 class="tez-form-section-title"><i class="fa-solid fa-user" aria-hidden="true"></i> اطلاعات شخصی</h4>
                            <div class="tez-form-row">
                                <div class="tez-form-group">
                                    <label for="tez-fullname"><i class="fa-solid fa-user" aria-hidden="true"></i> نام و نام خانوادگی <span class="tez-required" aria-label="اجباری">*</span></label>
                                    <input 
                                        type="text" 
                                        id="tez-fullname"
                                        name="fullname" 
                                        class="tez-form-control" 
                                        required 
                                        aria-required="true"
                                        autocomplete="name"
                                        placeholder="نام کامل">
                                </div>
                                <div class="tez-form-group">
                                    <label for="tez-phone"><i class="fa-solid fa-phone" aria-hidden="true"></i> شماره موبایل <span class="tez-required" aria-label="اجباری">*</span></label>
                                    <input 
                                        type="tel" 
                                        id="tez-phone"
                                        name="phone" 
                                        class="tez-form-control" 
                                        required 
                                        aria-required="true"
                                        autocomplete="tel"
                                        placeholder="09xxxxxxxxx" 
                                        pattern="[0-9]{11}" 
                                        dir="ltr"
                                        inputmode="numeric">
                                </div>
                            </div>
                            <div class="tez-form-row">
                                <div class="tez-form-group">
                                    <label for="tez-email"><i class="fa-solid fa-envelope" aria-hidden="true"></i> ایمیل</label>
                                    <input 
                                        type="email" 
                                        id="tez-email"
                                        name="email" 
                                        class="tez-form-control" 
                                        autocomplete="email"
                                        placeholder="email@example.com" 
                                        dir="ltr"
                                        inputmode="email">
                                </div>
                                <div class="tez-form-group">
                                    <label for="tez-major"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i> رشته تحصیلی <span class="tez-required" aria-label="اجباری">*</span></label>
                                    <input 
                                        type="text" 
                                        id="tez-major"
                                        name="major" 
                                        class="tez-form-control" 
                                        required 
                                        aria-required="true"
                                        autocomplete="off"
                                        placeholder="مثلاً: مدیریت بازرگانی">
                                </div>
                            </div>
                        </div>

                        <div class="tez-form-section">
                            <h4 class="tez-form-section-title"><i class="fa-solid fa-file-lines" aria-hidden="true"></i> اطلاعات پروژه</h4>
                            <div class="tez-form-row">
                                <div class="tez-form-group">
                                    <label for="tez-service-type"><i class="fa-solid fa-list" aria-hidden="true"></i> نوع خدمت <span class="tez-required" aria-label="اجباری">*</span></label>
                                    <select 
                                        id="tez-service-type"
                                        name="service_type" 
                                        class="tez-form-control" 
                                        required
                                        aria-required="true">
                                        <option value="">انتخاب کنید...</option>
                                        <option value="thesis">پایان‌نامه / رساله</option>
                                        <option value="proposal">پروپوزال</option>
                                        <option value="article">مقاله علمی</option>
                                        <option value="statistics">تحلیل آماری</option>
                                        <option value="simulation">شبیه‌سازی نرم‌افزاری</option>
                                        <option value="business">بیزینس پلن</option>
                                        <option value="programming">برنامه‌نویسی</option>
                                        <option value="translation">ترجمه تخصصی</option>
                                        <option value="other">سایر</option>
                                    </select>
                                </div>
                                <div class="tez-form-group">
                                    <label for="tez-degree"><i class="fa-solid fa-layer-group" aria-hidden="true"></i> مقطع تحصیلی</label>
                                    <select 
                                        id="tez-degree"
                                        name="degree" 
                                        class="tez-form-control">
                                        <option value="">انتخاب کنید...</option>
                                        <option value="bachelor">کارشناسی</option>
                                        <option value="master">کارشناسی ارشد</option>
                                        <option value="phd">دکتری</option>
                                        <option value="other">سایر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tez-form-group">
                                <label for="tez-description"><i class="fa-solid fa-align-right" aria-hidden="true"></i> توضیحات پروژه <span class="tez-required" aria-label="اجباری">*</span></label>
                                <textarea 
                                    id="tez-description"
                                    name="description" 
                                    class="tez-form-control" 
                                    rows="5" 
                                    required 
                                    aria-required="true"
                                    placeholder="لطفاً توضیحات پروژه خود را بنویسید..."></textarea>
                            </div>
                        </div>

                        <!-- Form Status Messages Area -->
                        <div id="tez-form-status" class="tez-form-status" role="status" aria-live="polite" aria-atomic="true" hidden></div>

                        <div class="tez-form-footer">
                            <div class="tez-privacy-notice">
                                <i class="fa-solid fa-shield-check" aria-hidden="true"></i>
                                اطلاعات شما کاملاً محرمانه است و فقط برای پیگیری سفارش استفاده می‌شود.
                            </div>
                            <button type="submit" class="tez-btn tez-btn-primary tez-btn-block tez-btn-lg tez-btn-submit">
                                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i> ارسال درخواست
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="tez-inquiry-sidebar">
                <div class="tez-sidebar-card tez-quick-contact scroll-animate">
                    <h4><i class="fa-solid fa-headset" aria-hidden="true" style="margin-left:.5rem"></i> تماس سریع</h4>
                    <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-sidebar-contact" aria-label="تماس تلفنی با شماره <?php echo esc_html($phone_display); ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i><span><?php echo esc_html($phone_display); ?></span></a>
                    <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" class="tez-sidebar-contact" target="_blank" rel="noopener noreferrer" aria-label="ارتباط از طریق واتساپ"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i><span>واتساپ</span></a>
                    <a href="https://t.me/<?php echo esc_attr($telegram); ?>" class="tez-sidebar-contact" target="_blank" rel="noopener noreferrer" aria-label="ارتباط از طریق تلگرام"><i class="fa-brands fa-telegram" aria-hidden="true"></i><span>تلگرام</span></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="tez-sidebar-contact" aria-label="ارسال ایمیل به <?php echo esc_html($email); ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i><span>ایمیل</span></a>
                </div>

                <div class="tez-sidebar-card scroll-animate">
                    <h4><i class="fa-solid fa-list-ol" aria-hidden="true" style="color:var(--tez-primary);margin-left:.5rem"></i> مراحل کار</h4>
                    <ol class="tez-sidebar-steps">
                        <li><span class="tez-step-num" aria-hidden="true">۱</span> ثبت درخواست</li>
                        <li><span class="tez-step-num" aria-hidden="true">۲</span> مشاوره رایگان</li>
                        <li><span class="tez-step-num" aria-hidden="true">۳</span> توافق و شروع کار</li>
                        <li><span class="tez-step-num" aria-hidden="true">۴</span> انجام و تحویل</li>
                        <li><span class="tez-step-num" aria-hidden="true">۵</span> پشتیبانی نامحدود</li>
                    </ol>
                </div>

                <div class="tez-sidebar-card scroll-animate">
                    <h4><i class="fa-solid fa-check-double" aria-hidden="true" style="color:var(--tez-primary);margin-left:.5rem"></i> چرا تز نویسان؟</h4>
                    <ul class="tez-sidebar-list">
                        <li><i class="fa-solid fa-check" aria-hidden="true"></i> ۴۵۰+ محقق متخصص</li>
                        <li><i class="fa-solid fa-check" aria-hidden="true"></i> تضمین کیفیت</li>
                        <li><i class="fa-solid fa-check" aria-hidden="true"></i> تحویل به‌موقع</li>
                        <li><i class="fa-solid fa-check" aria-hidden="true"></i> اصلاحات نامحدود</li>
                        <li><i class="fa-solid fa-check" aria-hidden="true"></i> محرمانه و امن</li>
                        <li><i class="fa-solid fa-check" aria-hidden="true"></i> پشتیبانی ۲۴ ساعته</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function(){
    'use strict';
    
    var form = document.getElementById('tez-inquiry-form');
    var statusEl = document.getElementById('tez-form-status');
    
    if (!form) return;
    
    // Status message helper
    function showStatus(message, type) {
        if (!statusEl) return;
        
        statusEl.textContent = message;
        statusEl.className = 'tez-form-status tez-status-' + type;
        statusEl.removeAttribute('hidden');
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(function() {
                statusEl.setAttribute('hidden', '');
            }, 5000);
        }
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        if (!form.checkValidity()) {
            form.reportValidity();
            showStatus('لطفاً تمامی فیلدهای الزامی را تکمیل کنید.', 'error');
            return;
        }
        
        var btn = form.querySelector('.tez-btn-submit');
        var originalHTML = btn.innerHTML;
        
        btn.disabled = true;
        btn.classList.add('loading');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i> در حال ارسال...';
        
        // Simulate form submission (replace with actual AJAX later)
        setTimeout(function() {
            btn.classList.remove('loading');
            btn.innerHTML = '<i class="fa-solid fa-check-circle" aria-hidden="true"></i> درخواست شما ثبت شد!';
            btn.style.background = 'var(--tez-success, #22BE49)';
            
            showStatus('درخواست شما با موفقیت ثبت شد. کارشناسان ما به زودی با شما تماس می‌گیرند.', 'success');
            
            form.reset();
            
            setTimeout(function() {
                btn.disabled = false;
                btn.innerHTML = originalHTML;
                btn.style.background = '';
            }, 4000);
        }, 1500);
    });
    
    // Real-time validation feedback (optional enhancement)
    var requiredInputs = form.querySelectorAll('[required]');
    requiredInputs.forEach(function(input) {
        input.addEventListener('invalid', function() {
            this.setAttribute('aria-invalid', 'true');
        });
        
        input.addEventListener('input', function() {
            if (this.validity.valid) {
                this.removeAttribute('aria-invalid');
            }
        });
    });
})();
</script>

<?php get_footer(); ?>
