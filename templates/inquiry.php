<?php
/**
 * Template Name: Tez - Inquiry Page
 * Description: Order/inquiry page with full form and sidebar contact options.
 *
 * @package JannahChild
 * @version 3.0.0
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
        <h1><i class="fa-solid fa-pen-to-square"></i> ثبت سفارش</h1>
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
                        <div class="tez-form-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                        <h3>فرم ثبت سفارش</h3>
                        <p>لطفاً اطلاعات زیر را تکمیل کنید</p>
                    </div>

                    <form id="tez-inquiry-form" method="post">
                        <?php wp_nonce_field('tez_inquiry_submit', 'tez_inquiry_nonce'); ?>

                        <div class="tez-form-section">
                            <h4 class="tez-form-section-title"><i class="fa-solid fa-user"></i> اطلاعات شخصی</h4>
                            <div class="tez-form-row">
                                <div class="tez-form-group">
                                    <label><i class="fa-solid fa-user"></i> نام و نام خانوادگی <span class="tez-required">*</span></label>
                                    <input type="text" name="fullname" class="tez-form-control" required placeholder="نام کامل">
                                </div>
                                <div class="tez-form-group">
                                    <label><i class="fa-solid fa-phone"></i> شماره موبایل <span class="tez-required">*</span></label>
                                    <input type="tel" name="phone" class="tez-form-control" required placeholder="09xxxxxxxxx" pattern="[0-9]{11}" dir="ltr">
                                </div>
                            </div>
                            <div class="tez-form-row">
                                <div class="tez-form-group">
                                    <label><i class="fa-solid fa-envelope"></i> ایمیل</label>
                                    <input type="email" name="email" class="tez-form-control" placeholder="email@example.com" dir="ltr">
                                </div>
                                <div class="tez-form-group">
                                    <label><i class="fa-solid fa-graduation-cap"></i> رشته تحصیلی <span class="tez-required">*</span></label>
                                    <input type="text" name="major" class="tez-form-control" required placeholder="مثلاً: مدیریت بازرگانی">
                                </div>
                            </div>
                        </div>

                        <div class="tez-form-section">
                            <h4 class="tez-form-section-title"><i class="fa-solid fa-file-lines"></i> اطلاعات پروژه</h4>
                            <div class="tez-form-row">
                                <div class="tez-form-group">
                                    <label><i class="fa-solid fa-list"></i> نوع خدمت <span class="tez-required">*</span></label>
                                    <select name="service_type" class="tez-form-control" required>
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
                                    <label><i class="fa-solid fa-layer-group"></i> مقطع تحصیلی</label>
                                    <select name="degree" class="tez-form-control">
                                        <option value="">انتخاب کنید...</option>
                                        <option value="bachelor">کارشناسی</option>
                                        <option value="master">کارشناسی ارشد</option>
                                        <option value="phd">دکتری</option>
                                        <option value="other">سایر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tez-form-group">
                                <label><i class="fa-solid fa-align-right"></i> توضیحات پروژه <span class="tez-required">*</span></label>
                                <textarea name="description" class="tez-form-control" rows="5" required placeholder="لطفاً توضیحات پروژه خود را بنویسید..."></textarea>
                            </div>
                        </div>

                        <div class="tez-form-footer">
                            <div class="tez-privacy-notice">
                                <i class="fa-solid fa-shield-check"></i>
                                اطلاعات شما کاملاً محرمانه است و فقط برای پیگیری سفارش استفاده می‌شود.
                            </div>
                            <button type="submit" class="tez-btn tez-btn-primary tez-btn-block tez-btn-lg tez-btn-submit">
                                <i class="fa-solid fa-paper-plane"></i> ارسال درخواست
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="tez-inquiry-sidebar">
                <div class="tez-sidebar-card tez-quick-contact scroll-animate">
                    <h4><i class="fa-solid fa-headset" style="margin-left:.5rem"></i> تماس سریع</h4>
                    <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-sidebar-contact"><i class="fa-solid fa-phone"></i><span><?php echo esc_html($phone_display); ?></span></a>
                    <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" class="tez-sidebar-contact" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i><span>واتساپ</span></a>
                    <a href="https://t.me/<?php echo esc_attr($telegram); ?>" class="tez-sidebar-contact" target="_blank" rel="noopener"><i class="fa-brands fa-telegram"></i><span>تلگرام</span></a>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="tez-sidebar-contact"><i class="fa-solid fa-envelope"></i><span>ایمیل</span></a>
                </div>

                <div class="tez-sidebar-card scroll-animate">
                    <h4><i class="fa-solid fa-list-ol" style="color:var(--tez-primary);margin-left:.5rem"></i> مراحل کار</h4>
                    <ol class="tez-sidebar-steps">
                        <li><span class="tez-step-num">۱</span> ثبت درخواست</li>
                        <li><span class="tez-step-num">۲</span> مشاوره رایگان</li>
                        <li><span class="tez-step-num">۳</span> توافق و شروع کار</li>
                        <li><span class="tez-step-num">۴</span> انجام و تحویل</li>
                        <li><span class="tez-step-num">۵</span> پشتیبانی نامحدود</li>
                    </ol>
                </div>

                <div class="tez-sidebar-card scroll-animate">
                    <h4><i class="fa-solid fa-check-double" style="color:var(--tez-primary);margin-left:.5rem"></i> چرا تز نویسان؟</h4>
                    <ul class="tez-sidebar-list">
                        <li><i class="fa-solid fa-check"></i> ۴۵۰+ محقق متخصص</li>
                        <li><i class="fa-solid fa-check"></i> تضمین کیفیت</li>
                        <li><i class="fa-solid fa-check"></i> تحویل به‌موقع</li>
                        <li><i class="fa-solid fa-check"></i> اصلاحات نامحدود</li>
                        <li><i class="fa-solid fa-check"></i> محرمانه و امن</li>
                        <li><i class="fa-solid fa-check"></i> پشتیبانی ۲۴ ساعته</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function(){
    var form=document.getElementById('tez-inquiry-form');
    if(!form)return;
    form.addEventListener('submit',function(e){
        e.preventDefault();
        var btn=form.querySelector('.tez-btn-submit');
        btn.classList.add('loading');
        setTimeout(function(){
            btn.classList.remove('loading');
            btn.innerHTML='<i class="fa-solid fa-check-circle"></i> درخواست شما ثبت شد!';
            btn.style.background='var(--tez-primary)';
            form.reset();
            setTimeout(function(){
                btn.innerHTML='<i class="fa-solid fa-paper-plane"></i> ارسال درخواست';
            },4000);
        },1500);
    });
})();
</script>

<?php get_footer(); ?>
