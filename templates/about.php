<?php
/**
 * Template Name: Tez - About Page
 * Description: About page with Tez hero, team section, mission/values, and stats.
 *
 * @package JannahChild
 * @version 3.1.0
 */

get_header();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php
// Hero background from featured image
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

        <!-- Hero Title -->
        <h1 class="tez-page-hero-title"><?php the_title(); ?></h1>

        <?php if ( has_excerpt() ) : ?>
        <p class="tez-page-hero-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
        <?php endif; ?>

    </div>
</section>

<!-- About Content -->
<div class="tez-page-content-wrap">

    <!-- Mission & Vision Section -->
    <section class="tez-content-section tez-about-mission">
        <div class="tez-section-container">
            <div class="tez-about-grid">
                <div class="tez-about-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Row (populated via Page Builder / shortcodes in content) -->
    <section class="tez-content-section tez-about-stats tez-bg-light">
        <div class="tez-section-container">
            <div class="tez-stats-row">
                <div class="tez-stats-card">
                    <span class="tez-stats-number">+10</span>
                    <span class="tez-stats-label">سال تجربه</span>
                </div>
                <div class="tez-stats-card">
                    <span class="tez-stats-number">+500</span>
                    <span class="tez-stats-label">پروژه موفق</span>
                </div>
                <div class="tez-stats-card">
                    <span class="tez-stats-number">+300</span>
                    <span class="tez-stats-label">مشتری راضی</span>
                </div>
                <div class="tez-stats-card">
                    <span class="tez-stats-number">98%</span>
                    <span class="tez-stats-label">رضایتمندی</span>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="tez-content-section tez-about-cta">
        <div class="tez-section-container tez-text-center">
            <h2 class="tez-section-title">آماده همکاری هستید؟</h2>
            <p class="tez-section-subtitle">با تیم تخصصی ما تماس بگیرید.</p>
            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="tez-btn tez-btn-primary">
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                تماس با ما
            </a>
        </div>
    </section>

</div><!-- .tez-page-content-wrap -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
