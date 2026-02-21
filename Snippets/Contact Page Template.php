/**
 * Teznevisan Contact Page Template
 * Version: 2.1.0
 */

if (!defined('ABSPATH')) exit;

function tez_render_contact_page() {
    ?>
    <!-- Page Hero -->
    <section class="tez-page-hero">
        <div class="tez-hero-bg">
            <div class="tez-hero-pattern"></div>
        </div>
        <div class="tez-container">
            <div class="tez-hero-content">
                <h1>تماس با ما</h1>
                <p>ما مشتاقانه منتظر شنیدن صدای شما هستیم</p>
                <nav class="tez-breadcrumb" aria-label="مسیر">
                    <a href="<?php echo home_url('/'); ?>">خانه</a>
                    <span>/</span>
                    <span>تماس با ما</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="tez-section tez-contact-section">
        <div class="tez-container">
            <div class="tez-contact-grid">
                <!-- Contact Info -->
                <div class="tez-contact-info">
                    <h2>راه‌های ارتباطی</h2>
                    <p>برای دریافت مشاوره رایگان و ثبت سفارش، از طریق یکی از روش‌های زیر با ما در ارتباط باشید</p>
                    
                    <div class="tez-contact-cards">
                        <a href="tel:<?php echo TEZ_PHONE; ?>" class="tez-contact-card">
                            <div class="tez-contact-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="tez-contact-details">
                                <h4>تماس تلفنی</h4>
                                <p><?php echo TEZ_PHONE_DISPLAY; ?></p>
                                <span>شنبه تا پنجشنبه، ۹ صبح تا ۶ عصر</span>
                            </div>
                        </a>
                        
                        <a href="https://wa.me/<?php echo TEZ_WHATSAPP; ?>" class="tez-contact-card" target="_blank" rel="noopener">
                            <div class="tez-contact-icon tez-whatsapp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div class="tez-contact-details">
                                <h4>واتساپ</h4>
                                <p><?php echo TEZ_PHONE_DISPLAY; ?></p>
                                <span>پاسخگویی سریع</span>
                            </div>
                        </a>
                        
                        <a href="https://t.me/<?php echo TEZ_TELEGRAM; ?>" class="tez-contact-card" target="_blank" rel="noopener">
                            <div class="tez-contact-icon tez-telegram">
                                <i class="fa-brands fa-telegram"></i>
                            </div>
                            <div class="tez-contact-details">
                                <h4>تلگرام</h4>
                                <p>@<?php echo TEZ_TELEGRAM; ?></p>
                                <span>پشتیبانی آنلاین</span>
                            </div>
                        </a>
                        
                        <a href="mailto:<?php echo TEZ_EMAIL; ?>" class="tez-contact-card">
                            <div class="tez-contact-icon tez-email">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="tez-contact-details">
                                <h4>ایمیل</h4>
                                <p><?php echo TEZ_EMAIL; ?></p>
                                <span>پاسخ طی ۲۴ ساعت</span>
                            </div>
                        </a>
                    </div>
                    
                    <div class="tez-address-box">
                        <div class="tez-address-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="tez-address-content">
                            <h4>آدرس دفتر</h4>
                            <p>تهران، خیابان جمالزاده شمالی، نرسیده به بلوار کشاورز، ابتدای کوچه نیلوفر، ساختمان تزنویسان، واحد پژوهش</p>
                        </div>
                    </div>
                    
                    <div class="tez-social-box">
                        <h4>ما را در شبکه‌های اجتماعی دنبال کنید</h4>
                        <div class="tez-social-links">
                            <a href="https://t.me/<?php echo TEZ_TELEGRAM; ?>" target="_blank" rel="noopener" aria-label="تلگرام">
                                <i class="fa-brands fa-telegram"></i>
                            </a>
                            <a href="https://wa.me/<?php echo TEZ_WHATSAPP; ?>" target="_blank" rel="noopener" aria-label="واتساپ">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <a href="#" target="_blank" rel="noopener" aria-label="اینستاگرام">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a href="#" target="_blank" rel="noopener" aria-label="لینکدین">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="tez-contact-form-wrapper">
                    <div class="tez-form-card">
                        <div class="tez-form-header">
                            <div class="tez-form-icon">
                                <i class="fa-solid fa-envelope-open-text"></i>
                            </div>
                            <h3>ارسال پیام</h3>
                            <p>فرم زیر را پر کنید تا در اسرع وقت با شما تماس بگیریم</p>
                        </div>
                        
                        <form class="tez-contact-form" id="tez-contact-form" method="post">
                            <?php wp_nonce_field('tez_contact_form', 'tez_contact_nonce'); ?>
                            <input type="hidden" name="form_type" value="contact">
                            
                            <div class="tez-form-row">
                                <div class="tez-form-group">
                                    <label for="contact-name">
                                        <i class="fa-solid fa-user"></i>
                                        نام و نام خانوادگی <span class="tez-required">*</span>
                                    </label>
                                    <input type="text" id="contact-name" name="name" class="tez-form-control" required placeholder="نام کامل شما">
                                </div>
                                <div class="tez-form-group">
                                    <label for="contact-phone">
                                        <i class="fa-solid fa-phone"></i>
                                        شماره تماس <span class="tez-required">*</span>
                                    </label>
                                    <input type="tel" id="contact-phone" name="phone" class="tez-form-control" required placeholder="۰۹۱۲۳۴۵۶۷۸۹">
                                </div>
                            </div>
                            
                            <div class="tez-form-row">
                                <div class="tez-form-group">
                                    <label for="contact-email">
                                        <i class="fa-solid fa-envelope"></i>
                                        ایمیل (اختیاری)
                                    </label>
                                    <input type="email" id="contact-email" name="email" class="tez-form-control" placeholder="email@example.com">
                                </div>
                                <div class="tez-form-group">
                                    <label for="contact-service">
                                        <i class="fa-solid fa-list"></i>
                                        نوع خدمت
                                    </label>
                                    <select id="contact-service" name="service" class="tez-form-control">
                                        <option value="">انتخاب کنید</option>
                                        <option value="thesis">انجام پایان‌نامه</option>
                                        <option value="proposal">نوشتن پروپوزال</option>
                                        <option value="article">نگارش مقاله</option>
                                        <option value="analysis">تحلیل آماری</option>
                                        <option value="programming">پروژه برنامه‌نویسی</option>
                                        <option value="translation">ترجمه تخصصی</option>
                                        <option value="other">سایر موارد</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="tez-form-group">
                                <label for="contact-subject">
                                    <i class="fa-solid fa-heading"></i>
                                    موضوع پیام <span class="tez-required">*</span>
                                </label>
                                <input type="text" id="contact-subject" name="subject" class="tez-form-control" required placeholder="موضوع پیام شما">
                            </div>
                            
                            <div class="tez-form-group">
                                <label for="contact-message">
                                    <i class="fa-solid fa-comment-dots"></i>
                                    متن پیام <span class="tez-required">*</span>
                                </label>
                                <textarea id="contact-message" name="message" class="tez-form-control" rows="5" required placeholder="لطفاً پیام خود را بنویسید..."></textarea>
                            </div>
                            
                            <div class="tez-form-footer">
                                <div class="tez-privacy-notice">
                                    <i class="fa-solid fa-lock"></i>
                                    <span>اطلاعات شما کاملاً محرمانه است</span>
                                </div>
                                <button type="submit" class="tez-btn tez-btn-primary tez-btn-block tez-btn-submit">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    ارسال پیام
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="tez-section tez-section-alt tez-map-section">
        <div class="tez-container">
            <div class="tez-section-header">
                <h2>موقعیت ما روی نقشه</h2>
                <p>می‌توانید برای مشاوره حضوری به دفتر ما مراجعه کنید</p>
            </div>
            <div class="tez-map-wrapper">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3239.9676!2d51.40!3d35.71!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzXCsDQyJzM2LjAiTiA1McKwMjQnMDAuMCJF!5e0!3m2!1sen!2s!4v1234567890"
                    width="100%" 
                    height="450" 
                    style="border:0;border-radius:var(--tez-radius-xl);" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="نقشه دفتر تز نویسان">
                </iframe>
            </div>
        </div>
    </section>

    <!-- FAQ Mini Section -->
    <section class="tez-section tez-contact-faq">
        <div class="tez-container">
            <div class="tez-section-header">
                <h2>سوالات متداول</h2>
                <p>پاسخ سریع به سوالات رایج شما</p>
            </div>
            <div class="tez-faq-grid">
                <div class="tez-faq-item scroll-animate">
                    <h4><i class="fa-solid fa-circle-question"></i> ساعات کاری شما چگونه است؟</h4>
                    <p>ما شنبه تا پنجشنبه از ساعت ۹ صبح تا ۶ عصر پاسخگوی شما هستیم. همچنین از طریق واتساپ و تلگرام تا ساعت ۱۱ شب نیز در خدمتیم.</p>
                </div>
                <div class="tez-faq-item scroll-animate">
                    <h4><i class="fa-solid fa-circle-question"></i> چقدر طول می‌کشد تا پاسخ بگیرم؟</h4>
                    <p>معمولاً در کمتر از ۲ ساعت به پیام‌های شما پاسخ می‌دهیم. در ساعات غیرکاری، پاسخ شما در اولین ساعت کاری بعدی ارسال می‌شود.</p>
                </div>
                <div class="tez-faq-item scroll-animate">
                    <h4><i class="fa-solid fa-circle-question"></i> آیا مشاوره رایگان ارائه می‌دهید؟</h4>
                    <p>بله، مشاوره اولیه برای بررسی پروژه شما کاملاً رایگان است. با ما تماس بگیرید تا نیازهای شما را بررسی کنیم.</p>
                </div>
                <div class="tez-faq-item scroll-animate">
                    <h4><i class="fa-solid fa-circle-question"></i> چگونه می‌توانم پیشرفت پروژه را پیگیری کنم؟</h4>
                    <p>پس از ثبت سفارش، یک شماره پیگیری دریافت می‌کنید و می‌توانید از طریق واتساپ یا تلگرام با محقق پروژه خود در ارتباط باشید.</p>
                </div>
            </div>
            <div class="tez-faq-more">
                <a href="<?php echo home_url('/faq'); ?>" class="tez-btn tez-btn-outline">
                    مشاهده همه سوالات <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </section>
    <?php
}
