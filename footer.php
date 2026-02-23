<?php
/**
 * Footer Template - Jannah Child Theme: Teznevisan
 * Overrides parent theme footer.php to provide proper structure.
 * Closes main, renders custom footer, floating widgets, and wp_footer().
 *
 * @package JannahChild
 * @version 3.1.0
 */

if ( ! defined('ABSPATH') ) exit;

$_phone         = defined('TEZ_PHONE')         ? TEZ_PHONE         : '09331663849';
$_phone_display = defined('TEZ_PHONE_DISPLAY') ? TEZ_PHONE_DISPLAY : '۰۹۳۳۱۶۶۳۸۴۹';
$_email         = defined('TEZ_EMAIL')         ? TEZ_EMAIL         : 'teznevisancompany@gmail.com';
$_whatsapp      = defined('TEZ_WHATSAPP')      ? TEZ_WHATSAPP      : $_phone;
$_telegram      = defined('TEZ_TELEGRAM')      ? TEZ_TELEGRAM      : 'Thesissupport';
$_logo          = defined('TEZ_LOGO')          ? home_url(TEZ_LOGO) : home_url('/wp-content/uploads/logo/teznevisan.svg');
$_site_name     = get_bloginfo('name');
$_home          = home_url('/');
$_year          = date_i18n('Y');
?>

</main><!-- /#tez-main-content -->

<footer id="tez-site-footer" class="tez-site-footer" role="contentinfo">
    <div class="tez-footer-main">
        <div class="tez-container">
            <div class="tez-footer-grid">

                <!-- Column 1: Branding + Description + Social -->
                <div class="tez-footer-col tez-footer-about">
                    <?php if ( $_logo ) : ?>
                    <div class="tez-footer-logo">
                        <a href="<?php echo esc_url($_home); ?>" class="tez-footer-logo-link" aria-label="<?php echo esc_attr($_site_name); ?>">
                            <img src="<?php echo esc_url($_logo); ?>"
                                 alt="<?php echo esc_attr($_site_name); ?>"
                                 class="tez-footer-logo-img"
                                 width="180" height="50"
                                 loading="lazy">
                        </a>
                    </div>
                    <?php endif; ?>
                    <p class="tez-footer-desc">موسسه تز نویسان با بیش از یک دهه تجربه و ۴۵۰+ محقق متخصص، آماده ارائه خدمات تخصصی انجام پروژه‌های دانشجویی در تمامی رشته‌هاست.</p>
                    <div class="tez-footer-social" aria-label="شبکه‌های اجتماعی">
                        <a href="https://t.me/<?php echo esc_attr($_telegram); ?>" class="tez-social-btn" target="_blank" rel="noopener noreferrer" aria-label="تلگرام"><i class="fa-brands fa-telegram" aria-hidden="true"></i></a>
                        <a href="https://wa.me/<?php echo esc_attr($_whatsapp); ?>" class="tez-social-btn" target="_blank" rel="noopener noreferrer" aria-label="واتساپ"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                        <a href="#" class="tez-social-btn" aria-label="اینستاگرام"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                        <a href="#" class="tez-social-btn" aria-label="لینکدین"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
                    </div>
                </div>

                <!-- Column 2: Services Menu -->
                <div class="tez-footer-col">
                    <h3 class="tez-footer-title">خدمات ما</h3>
                    <?php
                    if ( has_nav_menu('tez_footer_1') ) {
                        wp_nav_menu(array(
                            'theme_location' => 'tez_footer_1',
                            'container'      => false,
                            'menu_class'     => 'tez-footer-menu',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ));
                    } else {
                        echo '<ul class="tez-footer-menu">';
                        echo '<li><a href="' . esc_url(home_url('/services')) . '">خدمات</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/inquiry')) . '">ثبت سفارش</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/blog')) . '">وبلاگ</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </div>

                <!-- Column 3: Useful Links Menu -->
                <div class="tez-footer-col">
                    <h3 class="tez-footer-title">لینک‌های مفید</h3>
                    <?php
                    if ( has_nav_menu('tez_footer_2') ) {
                        wp_nav_menu(array(
                            'theme_location' => 'tez_footer_2',
                            'container'      => false,
                            'menu_class'     => 'tez-footer-menu',
                            'fallback_cb'    => false,
                            'depth'          => 1,
                        ));
                    } else {
                        echo '<ul class="tez-footer-menu">';
                        echo '<li><a href="' . esc_url(home_url('/about')) . '">درباره ما</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/contact')) . '">تماس با ما</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/faq')) . '">سوالات متداول</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/sitemap')) . '">نقشه سایت</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </div>

                <!-- Column 4: Contact Info -->
                <div class="tez-footer-col">
                    <h3 class="tez-footer-title">اطلاعات تماس</h3>
                    <ul class="tez-contact-list">
                        <li><i class="fa-solid fa-phone" aria-hidden="true"></i><a href="tel:<?php echo esc_attr($_phone); ?>"><?php echo esc_html($_phone_display); ?></a></li>
                        <li><i class="fa-solid fa-envelope" aria-hidden="true"></i><a href="mailto:<?php echo esc_attr($_email); ?>"><?php echo esc_html($_email); ?></a></li>
                        <li><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>تهران، خیابان جمالزاده شمالی</span></li>
                        <li><i class="fa-solid fa-clock" aria-hidden="true"></i><span>پاسخگویی: ۹ صبح تا ۶ عصر</span></li>
                    </ul>
                </div>

            </div><!-- /.tez-footer-grid -->
        </div><!-- /.tez-container -->
    </div><!-- /.tez-footer-main -->

    <div class="tez-footer-bottom">
        <div class="tez-container">
            <div class="tez-footer-bottom-inner">
                <p class="tez-copyright">&copy; <?php echo esc_html($_year); ?> <?php echo esc_html($_site_name); ?> &#8211; تمامی حقوق محفوظ است.</p>
                <div class="tez-footer-bottom-links">
                    <a href="#">شرایط استفاده</a>
                    <span aria-hidden="true">|</span>
                    <a href="#">حریم خصوصی</a>
                    <span aria-hidden="true">|</span>
                    <a href="<?php echo esc_url(home_url('/sitemap')); ?>">نقشه سایت</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Chaty Floating Contact Widget -->
<div id="tez-chaty" class="tez-chaty" aria-label="تماس سریع">
    <button type="button"
            class="tez-chaty-toggle"
            id="tez-chaty-toggle"
            aria-label="نمایش راه‌های تماس"
            aria-expanded="false"
            aria-controls="tez-chaty-channels">
        <span class="tez-chaty-icon"><i class="fa-solid fa-comments" aria-hidden="true"></i></span>
        <span class="tez-chaty-close"><i class="fa-solid fa-xmark" aria-hidden="true"></i></span>
    </button>
    <div class="tez-chaty-channels" id="tez-chaty-channels" aria-hidden="true">
        <a href="tel:<?php echo esc_attr($_phone); ?>" class="tez-chaty-item tez-chaty-phone" aria-label="تماس مستقیم">
            <i class="fa-solid fa-phone" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">تماس مستقیم</span>
        </a>
        <a href="sms:<?php echo esc_attr($_phone); ?>" class="tez-chaty-item tez-chaty-sms" aria-label="پیامک">
            <i class="fa-solid fa-message" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">پیامک</span>
        </a>
        <a href="https://wa.me/<?php echo esc_attr($_whatsapp); ?>" class="tez-chaty-item tez-chaty-whatsapp" target="_blank" rel="noopener noreferrer" aria-label="واتساپ">
            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">واتساپ</span>
        </a>
        <a href="https://t.me/<?php echo esc_attr($_telegram); ?>" class="tez-chaty-item tez-chaty-telegram" target="_blank" rel="noopener noreferrer" aria-label="تلگرام">
            <i class="fa-brands fa-telegram" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">تلگرام</span>
        </a>
        <a href="mailto:<?php echo esc_attr($_email); ?>" class="tez-chaty-item tez-chaty-email" aria-label="ایمیل">
            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">ایمیل</span>
        </a>
    </div>
</div>

<!-- Scroll to Top -->
<button type="button"
        id="tez-scroll-top"
        class="tez-scroll-top"
        aria-label="بازگشت به بالا">
    <i class="fa-solid fa-chevron-up" aria-hidden="true"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>
