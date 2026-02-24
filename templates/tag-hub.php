<?php
/**
 * Template Name: Tez - Tag Hub
 * Description: Tag hub page: hero, tag cloud, and per-tag post grids.
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

<!-- Tag Hub Content -->
<div class="tez-page-content-wrap">

    <!-- Optional: the_content() for intro text (added via editor) -->
    <?php
    $post_content = get_the_content();
    if ( ! empty( trim( $post_content ) ) ) :
    ?>
    <section class="tez-content-section tez-tag-hub-intro">
        <div class="tez-section-container">
            <?php the_content(); ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Tag Cloud -->
    <section class="tez-content-section tez-tag-cloud-section">
        <div class="tez-section-container">
            <h2 class="tez-section-title">
                <i class="fa-solid fa-tags" aria-hidden="true"></i>
                موضوعات
            </h2>
            <div class="tez-tag-cloud">
                <?php
                $tags = get_tags( array(
                    'orderby' => 'count',
                    'order'   => 'DESC',
                    'number'  => 50,
                    'hide_empty' => true,
                ) );

                if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) :
                    foreach ( $tags as $tag ) :
                        $font_size = max( 12, min( 24, 12 + intval( $tag->count ) ) );
                ?>
                <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
                   class="tez-tag-cloud-item"
                   style="font-size: <?php echo esc_attr( $font_size ); ?>px;"
                   title="<?php echo esc_attr( $tag->count . ' مطلب' ); ?>">
                    <i class="fa-solid fa-hashtag" aria-hidden="true"></i>
                    <?php echo esc_html( $tag->name ); ?>
                    <span class="tez-tag-count">(<?php echo esc_html( $tag->count ); ?>)</span>
                </a>
                <?php endforeach; else : ?>
                <p class="tez-no-tags">هنوز برچسبی موجود نیست.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Per-Tag Post Grids (top 6 most-used tags) -->
    <?php
    $hub_tags = get_tags( array(
        'orderby'    => 'count',
        'order'      => 'DESC',
        'number'     => 6,
        'hide_empty' => true,
    ) );

    if ( ! empty( $hub_tags ) && ! is_wp_error( $hub_tags ) ) :
        foreach ( $hub_tags as $hub_tag ) :

            $tag_posts = new WP_Query( array(
                'tag_id'         => $hub_tag->term_id,
                'posts_per_page' => 4,
                'no_found_rows'  => true,
                'post_status'    => 'publish',
            ) );

            if ( $tag_posts->have_posts() ) :
    ?>

    <section class="tez-content-section tez-tag-section">
        <div class="tez-section-container">
            <div class="tez-section-header">
                <h2 class="tez-section-title">
                    <i class="fa-solid fa-hashtag" aria-hidden="true"></i>
                    <?php echo esc_html( $hub_tag->name ); ?>
                </h2>
                <a href="<?php echo esc_url( get_tag_link( $hub_tag->term_id ) ); ?>" class="tez-see-all">
                    همه مطالب
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                </a>
            </div>

            <div class="tez-posts-grid tez-posts-grid-4">
                <?php while ( $tag_posts->have_posts() ) : $tag_posts->the_post(); ?>
                <article class="tez-post-card">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="tez-post-card-thumb">
                        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                            <?php the_post_thumbnail( 'medium', array( 'alt' => esc_attr( get_the_title() ), 'loading' => 'lazy' ) ); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    <div class="tez-post-card-body">
                        <h3 class="tez-post-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="tez-post-card-meta">
                            <span><i class="fa-regular fa-calendar" aria-hidden="true"></i> <?php echo get_the_date(); ?></span>
                        </div>
                        <?php if ( has_excerpt() ) : ?>
                        <p class="tez-post-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="tez-post-card-link">ادامه بخوانید <i class="fa-solid fa-arrow-left" aria-hidden="true"></i></a>
                    </div>
                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

        </div>
    </section>

    <?php
            endif; // tag_posts has posts
        endforeach; // hub_tags loop
    endif; // hub_tags not empty
    ?>

</div><!-- .tez-page-content-wrap -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
