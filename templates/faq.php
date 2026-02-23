<?php
/**
 * Template Name: Tez - FAQ Page
 * Description: FAQ page with Tez hero, search slot, and accordion content area.
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

        <!-- FAQ Search Box -->
        <div class="tez-faq-search-wrap">
            <div class="tez-faq-search" role="search">
                <i class="fa-solid fa-search" aria-hidden="true"></i>
                <input type="search"
                       id="tez-faq-search-input"
                       class="tez-faq-search-input"
                       placeholder="جستجو در سوالات..."
                       aria-label="جستجو در سوالات متداول">
            </div>
        </div>

    </div>
</section>

<!-- FAQ Content -->
<div class="tez-page-content-wrap">

    <!-- FAQ Accordion via the_content -->
    <section class="tez-content-section tez-faq-section">
        <div class="tez-section-container tez-faq-container">
            <?php the_content(); ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="tez-content-section tez-faq-cta tez-bg-light">
        <div class="tez-section-container tez-text-center">
            <h2 class="tez-section-title">سوالتان بی پاسخ ماند؟</h2>
            <p class="tez-section-subtitle">با ما تماس بگیرید تا بهترین مشاوره را دریافت کنید.</p>
            <div class="tez-cta-buttons">
                <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="tez-btn tez-btn-primary">
                    <i class="fa-solid fa-comment-dots" aria-hidden="true"></i>
                    تماس با ما
                </a>
                <a href="<?php echo esc_url( home_url('/inquiry/') ); ?>" class="tez-btn tez-btn-secondary">
                    <i class="fa-solid fa-file-alt" aria-hidden="true"></i>
                    درخواست خدمت
                </a>
            </div>
        </div>
    </section>

</div><!-- .tez-page-content-wrap -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
