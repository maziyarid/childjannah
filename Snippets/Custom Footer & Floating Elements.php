/**
 * Teznevisan Custom Footer - Fixed Version
 * Version: 2.1.5
 */
if (!defined('ABSPATH')) exit;

add_action('wp_footer', function() {
    // Local overrides (do not depend on existing constants)
    $footer_phone          = '09331663849';
    $footer_phone_display  = '09331663849'; // change to Persian digits if desired
    $footer_whatsapp       = '09331663849';
    $footer_telegram       = defined('TEZ_TELEGRAM') ? TEZ_TELEGRAM : 'Thesissupport';
    $footer_email          = defined('TEZ_EMAIL') ? TEZ_EMAIL : 'teznevisancompany@gmail.com';
    $footer_logo_white     = home_url('/wp-content/uploads/logo/white.svg');
    ?>
    <!-- Enforce correct FA7 Brands family -->
    <style id="tez-fa-brands-fix-footer">
        :root { --fa-family-brands: "Font Awesome 7 Brands"; }
        .fa-brands, .fab {
            font-family: "Font Awesome 7 Brands" !important;
            font-weight: 400;
        }
    </style>

    </main><!-- #tez-main-content -->

    <!-- Custom Footer -->
    <footer class="tez-site-footer" role="contentinfo">
        <div class="tez-container">
            <div class="tez-footer-grid">
                
                <!-- About Column (title removed; logo + text + socials stay) -->
                <div class="tez-footer-col tez-footer-about">
                    <div class="tez-footer-logo">
                        <img src="<?php echo esc_url($footer_logo_white); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="tez-footer-logo-img" loading="lazy">
                    </div>
                    <p class="tez-footer-desc">
                        موسسه تز نویسان با بیش از یک دهه تجربه و ۴۵۰+ محقق متخصص، 
                        آماده ارائه خدمات تخصصی انجام پروژه‌های دانشجویی در تمامی رشته‌ها است.
                    </p>
                    <div class="tez-footer-social">
                        <a href="https://t.me/<?php echo esc_attr($footer_telegram); ?>" target="_blank" rel="noopener noreferrer" aria-label="تلگرام">
                            <i class="fa-brands fa-telegram" aria-hidden="true"></i>
                        </a>
                        <a href="https://wa.me/<?php echo esc_attr($footer_whatsapp); ?>" target="_blank" rel="noopener noreferrer" aria-label="واتساپ">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener noreferrer" aria-label="اینستاگرام">
                            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a href="#" target="_blank" rel="noopener noreferrer" aria-label="لینکدین">
                            <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <!-- Services Column (title kept) -->
                <div class="tez-footer-col">
                    <h3 class="tez-footer-title">خدمات ما</h3>
                    <?php
                    if (has_nav_menu('tez_footer_1')) {
                        wp_nav_menu([
                            'theme_location' => 'tez_footer_1',
                            'container'      => false,
                            'menu_class'     => 'tez-footer-menu',
                            'fallback_cb'    => false,
                        ]);
                    } else {
                        ?>
                        <ul class="tez-footer-menu">
                            <li><a href="#">انجام پایان‌نامه</a></li>
                            <li><a href="#">نوشتن پروپوزال</a></li>
                            <li><a href="#">نگارش مقاله علمی</a></li>
                            <li><a href="#">تحلیل آماری</a></li>
                            <li><a href="#">پروژه‌های برنامه‌نویسی</a></li>
                            <li><a href="#">ترجمه تخصصی</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>

                <!-- Links Column (title kept) -->
                <div class="tez-footer-col">
                    <h3 class="tez-footer-title">لینک‌های مفید</h3>
                    <?php
                    if (has_nav_menu('tez_footer_2')) {
                        wp_nav_menu([
                            'theme_location' => 'tez_footer_2',
                            'container'      => false,
                            'menu_class'     => 'tez-footer-menu',
                            'fallback_cb'    => false,
                        ]);
                    } else {
                        ?>
                        <ul class="tez-footer-menu">
                            <li><a href="#">درباره ما</a></li>
                            <li><a href="#">وبلاگ</a></li>
                            <li><a href="#">تعرفه خدمات</a></li>
                            <li><a href="#">نمونه کارها</a></li>
                            <li><a href="#">سوالات متداول</a></li>
                            <li><a href="#">تماس با ما</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>

                <!-- Contact Column (title kept) -->
                <div class="tez-footer-col tez-footer-contact">
                    <h3 class="tez-footer-title">اطلاعات تماس</h3>
                    <ul class="tez-contact-list">
                        <li>
                            <i class="fa-solid fa-phone" aria-hidden="true"></i>
                            <a href="tel:<?php echo esc_attr($footer_phone); ?>"><?php echo esc_html($footer_phone_display); ?></a>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                            <a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a>
                        </li>
                        <li>
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            <span>تهران، خیابان جمالزاده شمالی، نرسیده به بلوار کشاورز</span>
                        </li>
                        <li>
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                            <span>پاسخگویی: ۹ صبح تا ۶ عصر</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="tez-footer-bottom">
                <p class="tezopyright">&copy; <?php echo date('Y'); ?> موسسه تز نویسان. تمامی حقوق محفوظ است.</p>
                <div class="tez-footer-links">
                    <a href="#">شرایط استفاده</a>
                    <span>|</span>
                    <a href="#">حریم خصوصی</a>
                    <span>|</span>
                    <a href="#">نقشه سایت</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Chaty Widget -->
    <div class="tez-chaty" id="tez-chaty" role="complementary" aria-label="راه‌های تماس">
        <button type="button" class="tez-chaty-toggle" id="tez-chaty-toggle" aria-label="نمایش راه‌های تماس" aria-expanded="false" aria-controls="tez-chaty-channels">
            <span class="tez-chaty-icon"><i class="fa-solid fa-comments" aria-hidden="true"></i></span>
            <span class="tez-chaty-close"><i class="fa-solid fa-xmark" aria-hidden="true"></i></span>
        </button>
        <div class="tez-chaty-channels" id="tez-chaty-channels" aria-hidden="true">
            <a href="tel:<?php echo esc_attr($footer_phone); ?>" class="tez-chaty-item tez-chaty-phone" aria-label="تماس تلفنی">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                <span class="tez-chaty-tooltip">تماس مستقیم</span>
            </a>
            <a href="sms:<?php echo esc_attr($footer_phone); ?>" class="tez-chaty-item tez-chaty-sms" aria-label="پیامک">
                <i class="fa-solid fa-comment-sms" aria-hidden="true"></i>
                <span class="tez-chaty-tooltip">پیامک</span>
            </a>
            <a href="https://wa.me/<?php echo esc_attr($footer_whatsapp); ?>" class="tez-chaty-item tez-chaty-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="واتساپ">
                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                <span class="tez-chaty-tooltip">واتساپ</span>
            </a>
            <a href="https://t.me/<?php echo esc_attr($footer_telegram); ?>" class="tez-chaty-item tez-chaty-telegram" target="_blank" rel="noopener noreferrer" aria-label="تلگرام">
                <i class="fa-brands fa-telegram" aria-hidden="true"></i>
                <span class="tez-chaty-tooltip">تلگرام</span>
            </a>
            <a href="mailto:<?php echo esc_attr($footer_email); ?>" class="tez-chaty-item tez-chaty-email" aria-label="ایمیل">
                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                <span class="tez-chaty-tooltip">ایمیل</span>
            </a>
        </div>
    </div>

    <!-- Scroll to Top -->
    <button type="button" class="tez-scroll-top" id="tez-scroll-top" aria-label="بازگشت به بالا">
        <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
    </button>
    <?php
}, 90);