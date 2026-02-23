<?php
/**
 * Template Name: Tez - Contact Page
 * Description: Contact page with Tez hero, contact cards, map slot, and CF7/GForms area.
 *
 * @package JannahChild
 * @version 3.1.0
 */

get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php
$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$has_image     = ! empty( $thumbnail_url );
$bg_style      = $has_image ? ' style="background-image:url(' . esc_url( $thumbnail_url ) . ');"' : '';
?>

<!-- Page Hero -->
<section class="tez-page-hero<?php echo $has_image ? ' tez-has-bg' : ''; ?>"<?php echo $bg_style; ?>>
    <div class="tez-page-hero-overlay"></div>
    <div class="tez-hero-container">

        <!-- Breadcrumb -->
        <nav class="tez-breadcrumb" aria-label="مسیر">
            <a href="<?php echo esc_url( home_url('/') ); ?>">خانه</a>
            <span class="tez-breadcrumb-sep" aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="tez-breadcrumb-current" aria-current="page"><?php the_title(); ?></span>
        </nav>

        <h1 class="tez-page-hero-title"><?php the_title(); ?></h1>

        <?php if ( has_excerpt() ) : ?>
        <p class="tez-page-hero-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
        <?php endif; ?>

    </div>
</section>

<!-- Contact Content -->
<div class="tez-page-content-wrap">

    <!-- Contact Cards -->
    <section class="tez-content-section tez-contact-cards">
        <div class="tez-section-container">
            <div class="tez-contact-cards-grid">

                <?php if ( defined('TEZ_PHONE') && defined('TEZ_PHONE_DISPLAY') ) : ?>
                <div class="tez-contact-card">
                    <div class="tez-contact-card-icon">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    </div>
                    <h3>تلفن</h3>
                    <a href="tel:<?php echo esc_attr( TEZ_PHONE ); ?>"><?php echo esc_html( TEZ_PHONE_DISPLAY ); ?></a>
                </div>
                <?php endif; ?>

                <?php if ( defined('TEZ_EMAIL') ) : ?>
                <div class="tez-contact-card">
                    <div class="tez-contact-card-icon">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                    </div>
                    <h3>ایمیل</h3>
                    <a href="mailto:<?php echo esc_attr( TEZ_EMAIL ); ?>"><?php echo esc_html( TEZ_EMAIL ); ?></a>
                </div>
                <?php endif; ?>

                <div class="tez-contact-card">
                    <div class="tez-contact-card-icon">
                        <i class="fa-solid fa-map-marker-alt" aria-hidden="true"></i>
                    </div>
                    <h3>آدرس</h3>
                    <p>شیراز، فارس، ایران</p>
                </div>

                <div class="tez-contact-card">
                    <div class="tez-contact-card-icon">
                        <i class="fa-solid fa-clock" aria-hidden="true"></i>
                    </div>
                    <h3>ساعات کاری</h3>
                    <p>شنبه تا پنج‌شنبه ۹-۱۷</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Page Content (CF7 form or Gutenberg blocks) -->
    <section class="tez-content-section tez-contact-form-section">
        <div class="tez-section-container">
            <div class="tez-contact-form-wrap">
                <?php the_content(); ?>
            </div>
        </div>
    </section>

    <!-- Social Links -->
    <section class="tez-content-section tez-contact-social tez-bg-light">
        <div class="tez-section-container tez-text-center">
            <h2 class="tez-section-title">ما را دنبال کنید</h2>
            <div class="tez-social-links">
                <?php if ( defined('TEZ_TELEGRAM') ) : ?>
                <a href="https://t.me/<?php echo esc_attr( TEZ_TELEGRAM ); ?>" target="_blank" rel="noopener" class="tez-social-btn tez-social-telegram" aria-label="Telegram">
                    <i class="fa-brands fa-telegram" aria-hidden="true"></i>
                    <span>Telegram</span>
                </a>
                <?php endif; ?>
                <?php if ( defined('TEZ_WHATSAPP') ) : ?>
                <a href="https://wa.me/<?php echo esc_attr( TEZ_WHATSAPP ); ?>" target="_blank" rel="noopener" class="tez-social-btn tez-social-whatsapp" aria-label="WhatsApp">
                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                    <span>WhatsApp</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

</div><!-- .tez-page-content-wrap -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
