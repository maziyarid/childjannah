<?php
/**
 * Footer Template Override
 * Completes HTML structure started in header.php
 * 
 * @package JannahChild
 * @version 3.3.0
 * @since Phase 1.2
 */
if (!defined('ABSPATH')) exit;
?>

</main><!-- #tez-main-content -->

<!-- Footer -->
<footer class="tez-site-footer" id="tez-site-footer" role="contentinfo">
    
    <!-- Footer Main -->
    <div class="tez-footer-main">
        <div class="tez-footer-container">
            <div class="tez-footer-grid">
                
                <!-- Column 1: Logo & Description & Social -->
                <div class="tez-footer-col tez-footer-about">
                    <div class="tez-footer-logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php if (defined('TEZ_LOGO')): ?>
                                <img src="<?php echo esc_url(home_url(TEZ_LOGO)); ?>" alt="<?php bloginfo('name'); ?>" class="tez-logo">
                            <?php else: ?>
                                <span class="tez-site-name"><?php bloginfo('name'); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    
                    <div class="tez-footer-description">
                        <p>تزنویسان با بیش از ۱۰ سال تجربه در زمینه تحلیل‌های آماری، نگارش مقالات علمی و پایان‌نامه، آماده ارائه خدمات تخصصی به دانشجویان و پژوهشگران عزیز است.</p>
                    </div>
                    
                    <div class="tez-footer-social">
                        <?php if (defined('TEZ_TELEGRAM')): ?>
                        <a href="https://t.me/<?php echo esc_attr(TEZ_TELEGRAM); ?>" target="_blank" rel="noopener noreferrer" class="tez-social-link" aria-label="Telegram">
                            <i class="fa-brands fa-telegram" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (defined('TEZ_WHATSAPP')): ?>
                        <a href="https://wa.me/<?php echo esc_attr(TEZ_WHATSAPP); ?>" target="_blank" rel="noopener noreferrer" class="tez-social-link" aria-label="WhatsApp">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (defined('TEZ_EMAIL')): ?>
                        <a href="mailto:<?php echo esc_attr(TEZ_EMAIL); ?>" class="tez-social-link" aria-label="Email">
                            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (defined('TEZ_PHONE')): ?>
                        <a href="tel:<?php echo esc_attr(TEZ_PHONE); ?>" class="tez-social-link" aria-label="تلفن">
                            <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Column 2: Services Menu -->
                <div class="tez-footer-col tez-footer-menu-col">
                    <h3 class="tez-footer-title">
                        <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                        خدمات ما
                    </h3>
                    <?php
                    if (has_nav_menu('tez_footer_1')) {
                        wp_nav_menu(array(
                            'theme_location'  => 'tez_footer_1',
                            'container'       => false,
                            'menu_class'      => 'tez-footer-menu',
                            'depth'           => 1,
                            'fallback_cb'     => false,
                        ));
                    } else {
                        // Fallback list
                        echo '<ul class="tez-footer-menu">';
                        echo '<li><a href="' . esc_url(home_url('/services/statistical-analysis/')) . '">تحلیل آماری</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/services/thesis-writing/')) . '">نگارش پایان‌نامه</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/services/article-writing/')) . '">نگارش مقاله</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/services/translation/')) . '">ترجمه تخصصی</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/services/consulting/')) . '">مشاوره تخصصی</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </div>
                
                <!-- Column 3: Useful Links Menu -->
                <div class="tez-footer-col tez-footer-menu-col">
                    <h3 class="tez-footer-title">
                        <i class="fa-solid fa-link" aria-hidden="true"></i>
                        لینک‌های مفید
                    </h3>
                    <?php
                    if (has_nav_menu('tez_footer_2')) {
                        wp_nav_menu(array(
                            'theme_location'  => 'tez_footer_2',
                            'container'       => false,
                            'menu_class'      => 'tez-footer-menu',
                            'depth'           => 1,
                            'fallback_cb'     => false,
                        ));
                    } else {
                        // Fallback list
                        echo '<ul class="tez-footer-menu">';
                        echo '<li><a href="' . esc_url(home_url('/about/')) . '">درباره ما</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/faq/')) . '">سوالات متداول</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/blog/')) . '">وبلاگ</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/contact/')) . '">تماس با ما</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/inquiry/')) . '">درخواست سریع</a></li>';
                        echo '</ul>';
                    }
                    ?>
                </div>
                
                <!-- Column 4: Contact Info -->
                <div class="tez-footer-col tez-footer-contact">
                    <h3 class="tez-footer-title">
                        <i class="fa-solid fa-address-book" aria-hidden="true"></i>
                        تماس با ما
                    </h3>
                    
                    <ul class="tez-contact-list">
                        <?php if (defined('TEZ_PHONE') && defined('TEZ_PHONE_DISPLAY')): ?>
                        <li class="tez-contact-item">
                            <i class="fa-solid fa-phone" aria-hidden="true"></i>
                            <div class="tez-contact-content">
                                <span class="tez-contact-label">تلفن:</span>
                                <a href="tel:<?php echo esc_attr(TEZ_PHONE); ?>" class="tez-contact-link">
                                    <?php echo esc_html(TEZ_PHONE_DISPLAY); ?>
                                </a>
                            </div>
                        </li>
                        <?php endif; ?>
                        
                        <?php if (defined('TEZ_EMAIL')): ?>
                        <li class="tez-contact-item">
                            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                            <div class="tez-contact-content">
                                <span class="tez-contact-label">ایمیل:</span>
                                <a href="mailto:<?php echo esc_attr(TEZ_EMAIL); ?>" class="tez-contact-link">
                                    <?php echo esc_html(TEZ_EMAIL); ?>
                                </a>
                            </div>
                        </li>
                        <?php endif; ?>
                        
                        <li class="tez-contact-item">
                            <i class="fa-solid fa-map-marker-alt" aria-hidden="true"></i>
                            <div class="tez-contact-content">
                                <span class="tez-contact-label">آدرس:</span>
                                <span>شیراز، فارس، ایران</span>
                            </div>
                        </li>
                        
                        <li class="tez-contact-item">
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                            <div class="tez-contact-content">
                                <span class="tez-contact-label">ساعات کاری:</span>
                                <span>شنبه تا پنج‌شنبه ۹-۱۷</span>
                            </div>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="tez-footer-bottom">
        <div class="tez-footer-container">
            <div class="tez-footer-bottom-inner">
                <div class="tez-footer-copyright">
                    <p>
                        &copy; <?php echo date('Y'); ?> 
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>. 
                        تمامی حقوق محفوظ است.
                    </p>
                </div>
                
                <div class="tez-footer-links">
                    <ul class="tez-footer-links-list">
                        <li><a href="<?php echo esc_url(home_url('/terms/')); ?>">قوانین و مقررات</a></li>
                        <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">حریم خصوصی</a></li>
                        <li><a href="<?php echo esc_url(home_url('/sitemap/')); ?>">نقشه سایت</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</footer>

<!-- Chaty Floating Contact Widget -->
<div class="tez-chaty-widget" id="tez-chaty" role="complementary" aria-label="ویجت تماس">
    <button type="button" 
            id="tez-chaty-toggle"
            class="tez-chaty-toggle" 
            aria-label="باز کردن منوی تماس" 
            aria-expanded="false" 
            aria-controls="tez-chaty-channels">
        <span class="tez-chaty-icon">
            <i class="fa-solid fa-comment-dots" aria-hidden="true"></i>
        </span>
        <span class="tez-chaty-close" style="display:none;">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </span>
    </button>
    
    <div class="tez-chaty-channels" 
         id="tez-chaty-channels"
         role="menu" 
         aria-hidden="true"
         hidden>
        <?php 
        $phone_display = defined('TEZ_PHONE_DISPLAY') ? TEZ_PHONE_DISPLAY : (defined('TEZ_PHONE') ? TEZ_PHONE : '');
        ?>
        
        <?php if (defined('TEZ_PHONE')): ?>
        <a href="tel:<?php echo esc_attr(TEZ_PHONE); ?>" 
           class="tez-chaty-channel tez-chaty-phone tez-chaty-item" 
           role="menuitem" 
           aria-label="تماس تلفنی با شماره <?php echo esc_html($phone_display); ?>">
            <i class="fa-solid fa-phone" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">تماس: <?php echo esc_html($phone_display); ?></span>
        </a>
        <?php endif; ?>
        
        <?php if (defined('TEZ_PHONE')): ?>
        <a href="sms:<?php echo esc_attr(TEZ_PHONE); ?>" 
           class="tez-chaty-channel tez-chaty-sms tez-chaty-item" 
           role="menuitem" 
           aria-label="ارسال پیام کوتاه به <?php echo esc_html($phone_display); ?>">
            <i class="fa-solid fa-comment-sms" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">پیام: <?php echo esc_html($phone_display); ?></span>
        </a>
        <?php endif; ?>
        
        <?php if (defined('TEZ_WHATSAPP')): ?>
        <a href="https://wa.me/<?php echo esc_attr(TEZ_WHATSAPP); ?>" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="tez-chaty-channel tez-chaty-whatsapp tez-chaty-item" 
           role="menuitem" 
           aria-label="ارتباط از طریق واتساپ">
            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">WhatsApp</span>
        </a>
        <?php endif; ?>
        
        <?php if (defined('TEZ_TELEGRAM')): ?>
        <a href="https://t.me/<?php echo esc_attr(TEZ_TELEGRAM); ?>" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="tez-chaty-channel tez-chaty-telegram tez-chaty-item" 
           role="menuitem" 
           aria-label="ارتباط از طریق تلگرام">
            <i class="fa-brands fa-telegram" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">Telegram</span>
        </a>
        <?php endif; ?>
        
        <?php if (defined('TEZ_EMAIL')): ?>
        <a href="mailto:<?php echo esc_attr(TEZ_EMAIL); ?>" 
           class="tez-chaty-channel tez-chaty-email tez-chaty-item" 
           role="menuitem" 
           aria-label="ارسال ایمیل">
            <i class="fa-solid fa-envelope" aria-hidden="true"></i>
            <span class="tez-chaty-tooltip">ایمیل</span>
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Scroll to Top Button -->
<button type="button" 
        class="tez-scroll-top" 
        id="tez-scroll-top" 
        aria-label="بازگشت به بالا" 
        title="بازگشت به بالا">
    <i class="fa-solid fa-chevron-up" aria-hidden="true"></i>
</button>

<?php wp_footer(); ?>

</body>
</html>
