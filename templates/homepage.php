<?php
/**
 * Template Name: Tez - Homepage
 * Description: Homepage with hero, stats, services overview, process, and CTA.
 *
 * @package JannahChild
 * @version 3.0.0
 */
get_header();
$phone = defined('TEZ_PHONE') ? TEZ_PHONE : '09331663849';
$phone_display = defined('TEZ_PHONE_DISPLAY') ? TEZ_PHONE_DISPLAY : $phone;
?>

<!-- Hero -->
<section class="tez-page-hero" style="padding:5rem 0">
    <div class="tez-hero-bg"><div class="tez-hero-pattern"></div></div>
    <div class="tez-hero-content tez-container" style="text-align:center">
        <h1 style="font-size:2.25rem;margin-bottom:1rem;color:#fff">
            <i class="fa-solid fa-graduation-cap" style="margin-left:.5rem"></i>
            موسسه تز نویسان
        </h1>
        <p style="font-size:1.25rem;opacity:.95;max-width:650px;margin:0 auto 2rem;line-height:1.8">انجام پروژه‌های دانشجویی در تمامی رشته‌ها و مقاطع تحصیلی با بالاترین کیفیت و تضمین رضایت</p>
        <div class="tez-cta-buttons">
            <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-white tez-btn-lg"><i class="fa-solid fa-pen-to-square"></i> ثبت سفارش</a>
            <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-btn tez-btn-outline-white tez-btn-lg"><i class="fa-solid fa-phone"></i> <?php echo esc_html($phone_display); ?></a>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="tez-section">
    <div class="tez-container">
        <div class="tez-about-stats scroll-animate" style="max-width:800px;margin:0 auto">
            <div class="tez-stat-card">
                <div class="tez-stat-number">۴۵۰+</div>
                <div class="tez-stat-label">محقق متخصص</div>
            </div>
            <div class="tez-stat-card">
                <div class="tez-stat-number">۱۰+</div>
                <div class="tez-stat-label">سال تجربه</div>
            </div>
            <div class="tez-stat-card">
                <div class="tez-stat-number">۱۰۰۰+</div>
                <div class="tez-stat-label">پروژه موفق</div>
            </div>
            <div class="tez-stat-card">
                <div class="tez-stat-number">۹۸%</div>
                <div class="tez-stat-label">رضایت مشتریان</div>
            </div>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="tez-section tez-section-alt">
    <div class="tez-container">
        <div class="tez-section-header scroll-animate">
            <h2>خدمات ما</h2>
            <p>مجموعه‌ای کامل از خدمات دانشگاهی و پژوهشی</p>
        </div>
        <div class="tez-advantages-grid">
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-file-lines"></i></div>
                <h4>انجام پروژه دانشجویی</h4>
                <p>پایان‌نامه، رساله، تحقیق و پروژه‌های درسی در تمامی رشته‌ها</p>
            </div>
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-lightbulb"></i></div>
                <h4>انجام پروپوزال</h4>
                <p>نگارش پروپوزال تحقیقاتی با تضمین تصویب استاد راهنما</p>
            </div>
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-newspaper"></i></div>
                <h4>انجام مقاله</h4>
                <p>مقالات ISI، Scopus، علمی-پژوهشی و همایشی</p>
            </div>
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-chart-bar"></i></div>
                <h4>تحلیل آماری</h4>
                <p>SPSS, AMOS, PLS, R, Eviews و تمامی نرم‌افزارهای تخصصی</p>
            </div>
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-laptop-code"></i></div>
                <h4>شبیه‌سازی نرم‌افزاری</h4>
                <p>MATLAB, ANSYS, ABAQUS, COMSOL و برنامه‌نویسی</p>
            </div>
            <div class="tez-advantage-card scroll-animate">
                <div class="tez-advantage-icon"><i class="fa-solid fa-briefcase"></i></div>
                <h4>بیزینس پلن</h4>
                <p>طرح توجیهی، بیزینس پلن و طرح کسب‌وکار</p>
            </div>
        </div>
        <div style="text-align:center;margin-top:2.5rem" class="scroll-animate">
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="tez-btn tez-btn-primary tez-btn-lg"><i class="fa-solid fa-arrow-left"></i> مشاهده همه خدمات</a>
        </div>
    </div>
</section>

<!-- Process -->
<section class="tez-section">
    <div class="tez-container">
        <div class="tez-section-header scroll-animate">
            <h2>مراحل انجام سفارش</h2>
            <p>فرآیند ساده و شفاف برای ثبت و پیگیری سفارش</p>
        </div>
        <div class="tez-process-grid">
            <div class="tez-process-item scroll-animate">
                <div class="tez-process-num">۱</div>
                <div class="tez-process-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                <h4>ثبت درخواست</h4>
                <p>فرم سفارش را پر کنید یا تماس بگیرید</p>
            </div>
            <div class="tez-process-item scroll-animate">
                <div class="tez-process-num">۲</div>
                <div class="tez-process-icon"><i class="fa-solid fa-comments"></i></div>
                <h4>مشاوره رایگان</h4>
                <p>کارشناسان ما با شما تماس می‌گیرند</p>
            </div>
            <div class="tez-process-item scroll-animate">
                <div class="tez-process-num">۳</div>
                <div class="tez-process-icon"><i class="fa-solid fa-file-contract"></i></div>
                <h4>توافق و شروع</h4>
                <p>پس از توافق، کار آغاز می‌شود</p>
            </div>
            <div class="tez-process-item scroll-animate">
                <div class="tez-process-num">۴</div>
                <div class="tez-process-icon"><i class="fa-solid fa-spinner"></i></div>
                <h4>انجام پروژه</h4>
                <p>انجام توسط متخصص مربوطه</p>
            </div>
            <div class="tez-process-item scroll-animate">
                <div class="tez-process-num">۵</div>
                <div class="tez-process-icon"><i class="fa-solid fa-check-double"></i></div>
                <h4>بازبینی و تحویل</h4>
                <p>کنترل کیفیت و تحویل نهایی</p>
            </div>
            <div class="tez-process-item scroll-animate">
                <div class="tez-process-num">۶</div>
                <div class="tez-process-icon"><i class="fa-solid fa-headset"></i></div>
                <h4>پشتیبانی</h4>
                <p>اصلاحات نامحدود تا تایید نهایی</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="tez-section tez-cta-section">
    <div class="tez-container">
        <div class="tez-cta-content scroll-animate">
            <h2>همین الان سفارش خود را ثبت کنید</h2>
            <p>مشاوره رایگان و بدون تعهد برای تمامی خدمات</p>
            <div class="tez-cta-buttons">
                <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-white tez-btn-lg"><i class="fa-solid fa-pen-to-square"></i> ثبت سفارش</a>
                <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-btn tez-btn-outline-white tez-btn-lg"><i class="fa-solid fa-phone"></i> <?php echo esc_html($phone_display); ?></a>
            </div>
        </div>
    </div>
</section>

<?php
// Display latest blog posts if any
$latest = new WP_Query(array('posts_per_page' => 4, 'no_found_rows' => true));
if ($latest->have_posts()) : ?>
<section class="tez-section">
    <div class="tez-container">
        <div class="tez-section-header scroll-animate">
            <h2>آخرین مطالب</h2>
            <p>جدیدترین مقالات و راهنماهای آموزشی</p>
        </div>
        <div class="tez-related-grid">
            <?php while ($latest->have_posts()) : $latest->the_post(); ?>
            <article class="tez-related-item scroll-animate">
                <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="tez-related-thumb">
                    <?php the_post_thumbnail('medium'); ?>
                </a>
                <?php endif; ?>
                <div class="tez-related-content">
                    <h3 class="tez-related-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="tez-related-meta"><span class="tez-related-date"><i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?></span></div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; wp_reset_postdata(); ?>

<?php get_footer(); ?>
