<?php
/**
 * Universal Page Content Injection
 * Auto-injects beautiful, responsive HTML layouts into pages via Classic Editor.
 * Detects template type and provides production-ready content without TieLabs.
 *
 * @package JannahChild
 * @version 3.1.0
 */

if ( ! defined('ABSPATH') ) exit;

/**
 * Inject default content into new pages based on template
 * Only injects if post_content is empty (respects existing content)
 */
add_filter( 'default_content', 'tez_inject_page_content', 10, 2 );
function tez_inject_page_content( $content, $post ) {
    // Only on pages, only if content is empty
    if ( $post->post_type !== 'page' || ! empty( $content ) ) {
        return $content;
    }

    // Get template (if set)
    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    
    // If no template yet, return empty (user hasn't selected template)
    if ( empty( $template ) || $template === 'default' ) {
        return $content;
    }

    // Route to appropriate injection function
    switch ( $template ) {
        case 'templates/about.php':
            return tez_get_about_content();
        case 'templates/contact.php':
            return tez_get_contact_content();
        case 'templates/services.php':
            return tez_get_services_content();
        case 'templates/faq.php':
            return tez_get_faq_content();
        case 'templates/inquiry.php':
            return tez_get_inquiry_content();
        default:
            return $content;
    }
}

/**
 * About Page Content
 */
function tez_get_about_content() {
    ob_start();
    ?>
<!-- About Content -->
<div class="tez-content-section">
    <div class="container">
        <div class="tez-about-grid">
            <div class="tez-about-content">
                <h2>درباره ما</h2>
                <p class="tez-lead">ما تیمی متخصص و با تجربه در ارائه خدمات حرفه‌ای هستیم.</p>
                <p>با بیش از 10 سال تجربه در صنعت، ما به ارائه بهترین خدمات و محصولات به مشتریان خود افتخار می‌کنیم. تیم ما متشکل از متخصصان باتجربه‌ای است که همواره در تلاش برای ارائه راهکارهای نوآورانه و کارآمد هستند.</p>
                <p>ماموریت ما ایجاد ارزش پایدار برای مشتریان و جامعه است. ما معتقدیم که موفقیت شما، موفقیت ماست و به همین دلیل تمام تلاش خود را برای رسیدن به بالاترین استانداردهای کیفی به کار می‌بریم.</p>
            </div>
            <div class="tez-about-stats">
                <div class="tez-stat-card">
                    <div class="tez-stat-number">+10</div>
                    <div class="tez-stat-label">سال تجربه</div>
                </div>
                <div class="tez-stat-card">
                    <div class="tez-stat-number">+500</div>
                    <div class="tez-stat-label">پروژه موفق</div>
                </div>
                <div class="tez-stat-card">
                    <div class="tez-stat-number">+300</div>
                    <div class="tez-stat-label">مشتری راضی</div>
                </div>
                <div class="tez-stat-card">
                    <div class="tez-stat-number">98%</div>
                    <div class="tez-stat-label">رضایتمندی</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mission & Vision -->
<div class="tez-content-section tez-section-alt">
    <div class="container">
        <div class="tez-section-header">
            <h2>ماموریت و چشم‌انداز ما</h2>
            <p>ارزش‌های بنیادین که ما را در مسیر موفقیت هدایت می‌کنند</p>
        </div>
        <div class="tez-mission-grid">
            <div class="tez-mission-card">
                <div class="tez-mission-icon">
                    <i class="fa-solid fa-bullseye" aria-hidden="true"></i>
                </div>
                <h3>ماموریت ما</h3>
                <p>ارائه بهترین خدمات با بالاترین کیفیت و ایجاد ارزش پایدار برای مشتریان</p>
            </div>
            <div class="tez-mission-card">
                <div class="tez-mission-icon">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                </div>
                <h3>چشم‌انداز ما</h3>
                <p>پیشرو بودن در صنعت و ایجاد تغییرات مثبت در جامعه</p>
            </div>
            <div class="tez-mission-card">
                <div class="tez-mission-icon">
                    <i class="fa-solid fa-heart" aria-hidden="true"></i>
                </div>
                <h3>ارزش‌های ما</h3>
                <p>صداقت، کیفیت، نوآوری و مشتری‌مداری در تمام فعالیت‌های ما</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="tez-content-section tez-cta-section">
    <div class="container">
        <div class="tez-cta-content">
            <h2>آماده همکاری هستید؟</h2>
            <p>با تیم تخصصی ما تماس بگیرید و پروژه خود را آغاز کنید.</p>
            <div class="tez-cta-buttons">
                <a href="/contact/" class="tez-btn tez-btn-light tez-btn-lg">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    تماس با ما
                </a>
                <a href="/inquiry/" class="tez-btn tez-btn-outline-light tez-btn-lg">
                    <i class="fa-solid fa-file-alt" aria-hidden="true"></i>
                    درخواست خدمت
                </a>
            </div>
        </div>
    </div>
</div>
    <?php
    return ob_get_clean();
}

/**
 * Contact Page Content
 */
function tez_get_contact_content() {
    $phone = defined('TEZ_PHONE') ? TEZ_PHONE : '09123456789';
    $phone_display = defined('TEZ_PHONE_DISPLAY') ? TEZ_PHONE_DISPLAY : '0912 345 6789';
    $email = defined('TEZ_EMAIL') ? TEZ_EMAIL : 'info@example.com';
    $telegram = defined('TEZ_TELEGRAM') ? TEZ_TELEGRAM : 'yourusername';
    $whatsapp = defined('TEZ_WHATSAPP') ? TEZ_WHATSAPP : '989123456789';

    ob_start();
    ?>
<!-- Contact Cards -->
<div class="tez-content-section">
    <div class="container">
        <div class="tez-contact-cards">
            <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-contact-card">
                <div class="tez-contact-icon">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                </div>
                <div class="tez-contact-details">
                    <h4>تلفن تماس</h4>
                    <p><?php echo esc_html($phone_display); ?></p>
                </div>
            </a>
            <a href="mailto:<?php echo esc_attr($email); ?>" class="tez-contact-card">
                <div class="tez-contact-icon tez-email">
                    <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                </div>
                <div class="tez-contact-details">
                    <h4>ایمیل</h4>
                    <p><?php echo esc_html($email); ?></p>
                </div>
            </a>
            <a href="https://t.me/<?php echo esc_attr($telegram); ?>" target="_blank" rel="noopener" class="tez-contact-card">
                <div class="tez-contact-icon tez-telegram">
                    <i class="fa-brands fa-telegram" aria-hidden="true"></i>
                </div>
                <div class="tez-contact-details">
                    <h4>تلگرام</h4>
                    <p>@<?php echo esc_html($telegram); ?></p>
                </div>
            </a>
            <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank" rel="noopener" class="tez-contact-card">
                <div class="tez-contact-icon tez-whatsapp">
                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                </div>
                <div class="tez-contact-details">
                    <h4>واتساپ</h4>
                    <p>پیام بدهید</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Contact Info & Map -->
<div class="tez-content-section tez-section-alt">
    <div class="container">
        <div class="tez-contact-grid">
            <div class="tez-contact-info">
                <h2>اطلاعات تماس</h2>
                <p>ما همیشه آماده پاسخگویی به سوالات شما هستیم. از طریق یکی از راه‌های زیر با ما در تماس باشید.</p>
                
                <div class="tez-address-box">
                    <div class="tez-address-icon">
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                    </div>
                    <div class="tez-address-content">
                        <h4>آدرس دفتر مرکزی</h4>
                        <p>شیراز، فارس، ایران<br>خیابان اصلی، پلاک 123</p>
                    </div>
                </div>

                <div class="tez-social-box">
                    <h4>شبکه‌های اجتماعی</h4>
                    <div class="tez-social-links">
                        <a href="https://t.me/<?php echo esc_attr($telegram); ?>" target="_blank" rel="noopener" aria-label="Telegram">
                            <i class="fa-brands fa-telegram" aria-hidden="true"></i>
                        </a>
                        <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
                            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        </a>
                        <a href="https://instagram.com/yourusername" target="_blank" rel="noopener" aria-label="Instagram">
                            <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="tez-map-wrapper">
                <!-- Replace with your Google Maps embed -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3456.123!2d52.531!3d29.591!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjnCsDM1JzI3LjYiTiA1MsKwMzEnNTEuNiJF!5e0!3m2!1sen!2s!4v1234567890" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
    <?php
    return ob_get_clean();
}

/**
 * Services Page Content
 */
function tez_get_services_content() {
    ob_start();
    ?>
<!-- Services Grid -->
<div class="tez-content-section">
    <div class="container">
        <div class="tez-services-list">
            <!-- Service 1 -->
            <div class="tez-service-accordion">
                <button class="tez-service-accordion-header" type="button">
                    <div class="tez-service-accordion-icon">
                        <i class="fa-solid fa-laptop-code" aria-hidden="true"></i>
                    </div>
                    <div class="tez-service-accordion-title">
                        <h3>طراحی و توسعه وب</h3>
                        <p>ساخت وبسایت‌های حرفه‌ای و کاربرپسند</p>
                    </div>
                    <div class="tez-service-accordion-arrow">
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>ما وبسایت‌های مدرن، سریع و بهینه شده برای موتورهای جستجو می‌سازیم. تیم ما با استفاده از آخرین تکنولوژی‌ها، وبسایتی را برای شما طراحی می‌کند که نه تنها زیبا است، بلکه عملکردی عالی دارد.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span>طراحی ریسپانسیو و موبایل فرندلی</span>
                            </div>
                            <div class="tez-service-feature-item">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span>بهینه‌سازی SEO و سرعت بارگذاری</span>
                            </div>
                            <div class="tez-service-feature-item">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span>پشتیبانی و نگهداری مستمر</span>
                            </div>
                            <div class="tez-service-feature-item">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span>امنیت و بکاپ گیری منظم</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="tez-service-accordion">
                <button class="tez-service-accordion-header" type="button">
                    <div class="tez-service-accordion-icon">
                        <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                    </div>
                    <div class="tez-service-accordion-title">
                        <h3>توسعه اپلیکیشن موبایل</h3>
                        <p>اپلیکیشن‌های iOS و Android</p>
                    </div>
                    <div class="tez-service-accordion-arrow">
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>تیم ما اپلیکیشن‌های موبایل حرفه‌ای و کاربرپسند برای پلتفرم‌های iOS و Android توسعه می‌دهد. ما تجربه کاربری عالی را با عملکرد بی‌نقص ترکیب می‌کنیم.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span>توسعه Native و Cross-platform</span>
                            </div>
                            <div class="tez-service-feature-item">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span>UI/UX طراحی شده با دقت</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="tez-service-accordion">
                <button class="tez-service-accordion-header" type="button">
                    <div class="tez-service-accordion-icon">
                        <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                    </div>
                    <div class="tez-service-accordion-title">
                        <h3>دیجیتال مارکتینگ</h3>
                        <p>افزایش فروش و رشد کسب‌وکار</p>
                    </div>
                    <div class="tez-service-accordion-arrow">
                        <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                    </div>
                </button>
                <div class="tez-service-accordion-body">
                    <div class="tez-service-accordion-content">
                        <p>استراتژی‌های بازاریابی دیجیتال ما به شما کمک می‌کند تا حضور آنلاین خود را تقویت کنید و به مخاطبان هدف دست پیدا کنید.</p>
                        <div class="tez-service-features-grid">
                            <div class="tez-service-feature-item">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span>SEO و بهینه‌سازی محتوا</span>
                            </div>
                            <div class="tez-service-feature-item">
                                <i class="fa-solid fa-check" aria-hidden="true"></i>
                                <span>تبلیغات Google و شبکه‌های اجتماعی</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- CTA -->
<div class="tez-content-section tez-cta-section">
    <div class="container">
        <div class="tez-cta-content">
            <h2>پروژه خود را با ما شروع کنید</h2>
            <p>مشاوره رایگان و بررسی نیازهای شما</p>
            <div class="tez-cta-buttons">
                <a href="/inquiry/" class="tez-btn tez-btn-light tez-btn-lg">
                    <i class="fa-solid fa-file-alt" aria-hidden="true"></i>
                    درخواست خدمت
                </a>
                <a href="/contact/" class="tez-btn tez-btn-outline-light tez-btn-lg">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    تماس با ما
                </a>
            </div>
        </div>
    </div>
</div>
    <?php
    return ob_get_clean();
}

/**
 * FAQ Page Content
 */
function tez_get_faq_content() {
    ob_start();
    ?>
<div class="tez-content-section">
    <div class="container">
        <div class="tez-faq-layout">
            <!-- FAQ Categories (Sidebar) -->
            <div class="tez-faq-sidebar">
                <div class="tez-faq-nav">
                    <h3>دسته‌بندی‌ها</h3>
                    <ul class="tez-faq-categories">
                        <li><a href="#general" class="active"><i class="fa-solid fa-circle-question" aria-hidden="true"></i> عمومی</a></li>
                        <li><a href="#services"><i class="fa-solid fa-briefcase" aria-hidden="true"></i> خدمات</a></li>
                        <li><a href="#pricing"><i class="fa-solid fa-dollar-sign" aria-hidden="true"></i> قیمت‌گذاری</a></li>
                        <li><a href="#support"><i class="fa-solid fa-headset" aria-hidden="true"></i> پشتیبانی</a></li>
                    </ul>
                </div>
                <div class="tez-faq-contact">
                    <h4>سوالی دارید؟</h4>
                    <p>با ما تماس بگیرید</p>
                    <a href="/contact/" class="tez-faq-phone">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        تماس با ما
                    </a>
                </div>
            </div>

            <!-- FAQ Content -->
            <div class="tez-faq-content">
                <!-- General Category -->
                <div class="tez-faq-category" id="general">
                    <h2><i class="fa-solid fa-circle-question" aria-hidden="true"></i> سوالات عمومی</h2>
                    
                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>چگونه می‌توانم با شما تماس بگیرم؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>می‌توانید از طریق صفحه تماس با ما، تلفن، ایمیل یا شبکه‌های اجتماعی با ما در ارتباط باشید.</p>
                        </div>
                    </div>

                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>ساعات کاری شما چگونه است؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>ما از شنبه تا پنج‌شنبه، ساعت 9 صبح تا 17 عصر آماده پاسخگویی به شما هستیم.</p>
                        </div>
                    </div>

                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>آیا مشاوره رایگان ارائه می‌دهید؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>بله، جلسه مشاوره اولیه برای بررسی نیازهای شما کاملاً رایگان است.</p>
                        </div>
                    </div>
                </div>

                <!-- Services Category -->
                <div class="tez-faq-category" id="services">
                    <h2><i class="fa-solid fa-briefcase" aria-hidden="true"></i> خدمات</h2>
                    
                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>چه خدماتی ارائه می‌دهید؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>ما خدمات طراحی وب، توسعه اپلیکیشن، دیجیتال مارکتینگ و سئو ارائه می‌دهیم.</p>
                        </div>
                    </div>

                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>مدت زمان تحویل پروژه چقدر است؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>مدت زمان بستگی به نوع و حجم پروژه دارد. معمولاً بین 2 تا 8 هفته طول می‌کشد.</p>
                        </div>
                    </div>
                </div>

                <!-- Pricing Category -->
                <div class="tez-faq-category" id="pricing">
                    <h2><i class="fa-solid fa-dollar-sign" aria-hidden="true"></i> قیمت‌گذاری</h2>
                    
                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>هزینه خدمات چقدر است؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>قیمت‌ها بسته به نوع خدمت و نیازهای شما متغیر است. برای دریافت پیشنهاد قیمت با ما تماس بگیرید.</p>
                        </div>
                    </div>

                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>آیا امکان پرداخت اقساطی وجود دارد؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>بله، برای پروژه‌های بلندمدت امکان پرداخت به صورت اقساطی فراهم است.</p>
                        </div>
                    </div>
                </div>

                <!-- Support Category -->
                <div class="tez-faq-category" id="support">
                    <h2><i class="fa-solid fa-headset" aria-hidden="true"></i> پشتیبانی</h2>
                    
                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>آیا پشتیبانی پس از تحویل ارائه می‌دهید؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>بله، ما 6 ماه پشتیبانی رایگان و بعد از آن پشتیبانی با هزینه ارائه می‌دهیم.</p>
                        </div>
                    </div>

                    <div class="tez-faq-item">
                        <button class="tez-faq-question" type="button">
                            <span>چگونه می‌توانم تیکت پشتیبانی ثبت کنم؟</span>
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="tez-faq-answer">
                            <p>از طریق صفحه تماس با ما یا ایمیل می‌توانید درخواست پشتیبانی ارسال کنید.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
    <?php
    return ob_get_clean();
}

/**
 * Inquiry Page Content
 */
function tez_get_inquiry_content() {
    ob_start();
    ?>
<div class="tez-content-section">
    <div class="container">
        <div class="tez-inquiry-intro">
            <h2>درخواست خدمت</h2>
            <p>فرم زیر را با دقت تکمیل کنید تا تیم ما در اسرع وقت با شما تماس بگیرد.</p>
            <div class="tez-intro-features">
                <span class="tez-intro-feature">
                    <i class="fa-solid fa-check-circle" aria-hidden="true"></i>
                    پاسخ در کمتر از 24 ساعت
                </span>
                <span class="tez-intro-feature">
                    <i class="fa-solid fa-shield-check" aria-hidden="true"></i>
                    اطلاعات شما محفوظ است
                </span>
                <span class="tez-intro-feature">
                    <i class="fa-solid fa-user-tie" aria-hidden="true"></i>
                    مشاوره رایگان
                </span>
            </div>
        </div>

        <div class="tez-inquiry-grid">
            <div class="tez-form-card">
                <form class="tez-inquiry-form" method="post" action="">
                    <!-- Personal Info -->
                    <div class="tez-form-section">
                        <h3 class="tez-form-section-title">
                            <i class="fa-solid fa-user" aria-hidden="true"></i>
                            اطلاعات شخصی
                        </h3>
                        <div class="tez-form-row">
                            <div class="tez-form-group">
                                <label for="name">
                                    <i class="fa-solid fa-user" aria-hidden="true"></i>
                                    نام و نام خانوادگی
                                    <span class="tez-required">*</span>
                                </label>
                                <input type="text" id="name" name="name" class="tez-form-control" placeholder="نام کامل خود را وارد کنید" required>
                            </div>
                            <div class="tez-form-group">
                                <label for="phone">
                                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                    شماره تماس
                                    <span class="tez-required">*</span>
                                </label>
                                <input type="tel" id="phone" name="phone" class="tez-form-control" placeholder="09123456789" required>
                            </div>
                        </div>
                        <div class="tez-form-group">
                            <label for="email">
                                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                                ایمیل
                            </label>
                            <input type="email" id="email" name="email" class="tez-form-control" placeholder="your@email.com">
                        </div>
                    </div>

                    <!-- Project Info -->
                    <div class="tez-form-section">
                        <h3 class="tez-form-section-title">
                            <i class="fa-solid fa-briefcase" aria-hidden="true"></i>
                            اطلاعات پروژه
                        </h3>
                        <div class="tez-form-row">
                            <div class="tez-form-group">
                                <label for="service">
                                    <i class="fa-solid fa-list" aria-hidden="true"></i>
                                    نوع خدمت
                                    <span class="tez-required">*</span>
                                </label>
                                <select id="service" name="service" class="tez-form-control" required>
                                    <option value="">انتخاب کنید</option>
                                    <option value="web-design">طراحی وب</option>
                                    <option value="app-dev">توسعه اپلیکیشن</option>
                                    <option value="seo">سئو و بازاریابی</option>
                                    <option value="other">سایر</option>
                                </select>
                            </div>
                            <div class="tez-form-group">
                                <label for="budget">
                                    <i class="fa-solid fa-dollar-sign" aria-hidden="true"></i>
                                    بودجه (تومان)
                                </label>
                                <select id="budget" name="budget" class="tez-form-control">
                                    <option value="">انتخاب کنید</option>
                                    <option value="under-10m">کمتر از 10 میلیون</option>
                                    <option value="10m-30m">10 تا 30 میلیون</option>
                                    <option value="30m-50m">30 تا 50 میلیون</option>
                                    <option value="above-50m">بیش از 50 میلیون</option>
                                </select>
                            </div>
                        </div>
                        <div class="tez-form-group">
                            <label for="description">
                                <i class="fa-solid fa-align-right" aria-hidden="true"></i>
                                توضیحات پروژه
                                <span class="tez-required">*</span>
                            </label>
                            <textarea id="description" name="description" class="tez-form-control" rows="5" placeholder="جزئیات پروژه خود را شرح دهید..." required></textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="tez-form-footer">
                        <div class="tez-privacy-notice">
                            <i class="fa-solid fa-shield-check" aria-hidden="true"></i>
                            <span>اطلاعات شما محرمانه است و هرگز به اشتراک گذاشته نمی‌شود.</span>
                        </div>
                        <button type="submit" class="tez-btn tez-btn-primary tez-btn-lg tez-btn-block tez-btn-submit">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                            ارسال درخواست
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="tez-inquiry-sidebar">
                <div class="tez-sidebar-card tez-quick-contact">
                    <h4>تماس سریع</h4>
                    <a href="tel:09123456789" class="tez-sidebar-contact">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <span>0912 345 6789</span>
                    </a>
                    <a href="https://t.me/yourusername" class="tez-sidebar-contact">
                        <i class="fa-brands fa-telegram" aria-hidden="true"></i>
                        <span>تلگرام</span>
                    </a>
                    <a href="https://wa.me/989123456789" class="tez-sidebar-contact">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        <span>واتساپ</span>
                    </a>
                </div>

                <div class="tez-sidebar-card">
                    <h4>مراحل همکاری</h4>
                    <ul class="tez-sidebar-steps">
                        <li>
                            <span class="tez-step-num">1</span>
                            <span>ارسال فرم درخواست</span>
                        </li>
                        <li>
                            <span class="tez-step-num">2</span>
                            <span>جلسه مشاوره رایگان</span>
                        </li>
                        <li>
                            <span class="tez-step-num">3</span>
                            <span>دریافت پیشنهاد قیمت</span>
                        </li>
                        <li>
                            <span class="tez-step-num">4</span>
                            <span>شروع پروژه</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
    return ob_get_clean();
}
