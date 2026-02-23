<?php
/**
 * 404 Content Hub
 * Rich 404 page with search, popular posts, categories, and quick links.
 *
 * @package JannahChild
 * @version 3.0.0
 */
get_header();
$phone = defined('TEZ_PHONE') ? TEZ_PHONE : '09331663849';
?>

<section class="tez-page-hero" style="padding:3rem 0">
    <div class="tez-hero-bg"><div class="tez-hero-pattern"></div></div>
    <div class="tez-hero-content tez-container" style="text-align:center">
        <div style="font-size:5rem;font-weight:900;line-height:1;margin-bottom:1rem;opacity:.9">۴۰۴</div>
        <h1 style="font-size:1.75rem;margin-bottom:.75rem;color:#fff">صفحه مورد نظر یافت نشد</h1>
        <p style="opacity:.9;margin-bottom:2rem">متاسفانه صفحه‌ای که به دنبال آن هستید وجود ندارد یا منتقل شده است.</p>
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="max-width:500px;margin:0 auto">
            <div style="display:flex;gap:.5rem">
                <input type="search" name="s" placeholder="جستجو در سایت..." style="flex:1;padding:.875rem 1rem;border:none;border-radius:var(--tez-radius-md);font-family:var(--tez-font);font-size:1rem;background:rgba(255,255,255,.95);color:#111">
                <button type="submit" class="tez-btn tez-btn-white">جستجو</button>
            </div>
        </form>
    </div>
</section>

<div class="tez-container" style="padding-top:3rem;padding-bottom:3rem">

    <?php
    // Popular / Latest posts
    $args = array('posts_per_page' => 6, 'meta_key' => 'post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'no_found_rows' => true);
    $posts_query = new WP_Query($args);
    if (!$posts_query->have_posts()) {
        $posts_query = new WP_Query(array('posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC', 'no_found_rows' => true));
    }
    if ($posts_query->have_posts()) : ?>
    <section style="margin-bottom:3rem" class="scroll-animate">
        <h2 style="text-align:center;margin-bottom:2rem;font-size:1.5rem;font-weight:700;color:var(--tez-gray-900)">
            <i class="fa-solid fa-fire" style="color:var(--tez-primary);margin-left:.5rem"></i>مطالب پیشنهادی
        </h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem">
            <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
            <article style="background:var(--tez-card-bg);border:1px solid var(--tez-card-border);border-radius:var(--tez-radius-lg);overflow:hidden;transition:all .25s ease">
                <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" style="display:block;aspect-ratio:16/10;overflow:hidden">
                    <?php the_post_thumbnail('medium', array('style' => 'width:100%;height:100%;object-fit:cover;transition:transform .3s ease')); ?>
                </a>
                <?php endif; ?>
                <div style="padding:1rem">
                    <h3 style="font-size:1rem;font-weight:600;margin-bottom:.5rem;line-height:1.5">
                        <a href="<?php the_permalink(); ?>" style="color:var(--tez-text);text-decoration:none"><?php the_title(); ?></a>
                    </h3>
                    <p style="font-size:.875rem;color:var(--tez-text-muted);margin:0;line-height:1.6"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php endif; wp_reset_postdata(); ?>

    <!-- Categories -->
    <?php $cats = get_categories(array('orderby' => 'count', 'order' => 'DESC', 'number' => 8, 'hide_empty' => true));
    if (!empty($cats)) : ?>
    <section style="margin-bottom:3rem" class="scroll-animate">
        <h2 style="text-align:center;margin-bottom:2rem;font-size:1.5rem;font-weight:700;color:var(--tez-gray-900)">
            <i class="fa-solid fa-folder" style="color:var(--tez-primary);margin-left:.5rem"></i>دسته‌بندی‌ها
        </h2>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:.75rem">
            <?php foreach ($cats as $cat) : ?>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" style="display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.25rem;background:var(--tez-card-bg);border:1px solid var(--tez-border);border-radius:var(--tez-radius-full);color:var(--tez-text);text-decoration:none;font-weight:500;font-size:.9375rem;transition:all .2s ease">
                <?php echo esc_html($cat->name); ?>
                <span style="background:var(--tez-primary);color:#fff;padding:.125rem .5rem;border-radius:var(--tez-radius-full);font-size:.75rem;font-weight:700"><?php echo esc_html($cat->count); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Quick Links -->
    <section class="scroll-animate" style="margin-bottom:2rem">
        <h2 style="text-align:center;margin-bottom:2rem;font-size:1.5rem;font-weight:700;color:var(--tez-gray-900)">
            <i class="fa-solid fa-link" style="color:var(--tez-primary);margin-left:.5rem"></i>لینک‌های مفید
        </h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;max-width:800px;margin:0 auto">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="tez-btn tez-btn-primary tez-btn-block"><i class="fa-solid fa-home"></i> صفحه اصلی</a>
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="tez-btn tez-btn-secondary tez-btn-block"><i class="fa-solid fa-briefcase"></i> خدمات</a>
            <a href="<?php echo esc_url(home_url('/inquiry')); ?>" class="tez-btn tez-btn-secondary tez-btn-block"><i class="fa-solid fa-pen-to-square"></i> ثبت سفارش</a>
            <a href="tel:<?php echo esc_attr($phone); ?>" class="tez-btn tez-btn-secondary tez-btn-block"><i class="fa-solid fa-phone"></i> تماس</a>
        </div>
    </section>

</div>

<?php get_footer(); ?>
