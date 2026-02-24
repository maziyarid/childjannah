<?php
/**
 * 404 Hub - Beautiful Error Page
 * Shows recent posts, popular posts, categories, search on 404 errors.
 *
 * @package JannahChild
 * @version 3.1.0
 */

if (!defined('ABSPATH')) exit;

add_filter('404_template', 'tez_custom_404_template');
function tez_custom_404_template($template) {
    $custom_404 = locate_template('404.php');
    return $custom_404 ? $custom_404 : $template;
}

add_action('tie_404_after_header', 'tez_404_hub_content');
function tez_404_hub_content() {
    ?>
    <div class="tez-404-hub">
        <div class="hub-header">
            <div class="error-code">404</div>
            <h1>صفحه یافت نشد</h1>
            <p>متأسفانه، صفحه موردنظر شما حذف شده یا منتقل گردیده است.</p>
        </div>

        <div class="hub-search">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" placeholder="جستجو در سایت..." name="s" required />
                <button type="submit"><i class="fas fa-search"></i> جستجو</button>
            </form>
        </div>

        <div class="hub-grid">
            <div class="hub-section">
                <h3><i class="fas fa-newspaper"></i> آخرین مطالب</h3>
                <ul class="hub-list">
                    <?php
                    $recent = new WP_Query(array(
                        'posts_per_page' => 5,
                        'post_status' => 'publish',
                        'no_found_rows' => true,
                        'update_post_meta_cache' => false,
                        'update_post_term_cache' => false
                    ));
                    if ($recent->have_posts()) {
                        while ($recent->have_posts()) {
                            $recent->the_post();
                            echo '<li><a href="' . esc_url(get_permalink()) . '"><i class="fas fa-angle-left"></i> ' . esc_html(get_the_title()) . '</a></li>';
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>

            <div class="hub-section">
                <h3><i class="fas fa-fire"></i> محبوب‌ترین مطالب</h3>
                <ul class="hub-list">
                    <?php
                    $popular = new WP_Query(array(
                        'posts_per_page' => 5,
                        'meta_key' => 'tie_views',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'no_found_rows' => true,
                        'update_post_meta_cache' => false,
                        'update_post_term_cache' => false
                    ));
                    if ($popular->have_posts()) {
                        while ($popular->have_posts()) {
                            $popular->the_post();
                            echo '<li><a href="' . esc_url(get_permalink()) . '"><i class="fas fa-angle-left"></i> ' . esc_html(get_the_title()) . '</a></li>';
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>

            <div class="hub-section">
                <h3><i class="fas fa-folder"></i> دسته‌بندی‌ها</h3>
                <div class="category-list">
                    <?php
                    $categories = get_categories(array('number' => 8, 'orderby' => 'count', 'order' => 'DESC'));
                    foreach($categories as $cat) {
                        echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '" class="cat-badge"><i class="fas fa-folder-open"></i> ' . esc_html($cat->name) . ' <span>(' . esc_html($cat->count) . ')</span></a>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="hub-actions">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-home"><i class="fas fa-home"></i> بازگشت به صفحه اصلی</a>
            <a href="<?php echo esc_url(home_url('/sitemap')); ?>" class="btn-sitemap"><i class="fas fa-sitemap"></i> نقشه سایت</a>
        </div>
    </div>

    <style>
    .tez-404-hub{max-width:1200px;margin:60px auto;padding:20px;font-family:var(--tez-font,"Vazirmatn",system-ui,sans-serif)}
    .hub-header{text-align:center;margin-bottom:50px}
    .error-code{font-size:120px;font-weight:900;background:linear-gradient(135deg,var(--tez-primary,#22BE49) 0%,#1a9e3a 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;margin-bottom:20px}
    .hub-header h1{font-size:36px;color:var(--tez-text,#111827);margin:0 0 15px}
    .hub-header p{font-size:18px;color:var(--tez-text-muted,#6b7280)}
    .hub-search{max-width:600px;margin:0 auto 50px}
    .hub-search form{display:flex;gap:10px;background:var(--tez-bg,#fff);border:2px solid var(--tez-border,#e5e7eb);border-radius:50px;padding:8px;box-shadow:0 10px 40px rgba(0,0,0,.05)}
    .hub-search input{flex:1;border:none;padding:12px 20px;font-size:16px;background:transparent;color:var(--tez-text,#111827)}
    .hub-search input:focus{outline:none}
    .hub-search button{background:var(--tez-primary,#22BE49);border:none;color:#fff;padding:12px 30px;border-radius:50px;font-weight:600;cursor:pointer;transition:.3s}
    .hub-search button:hover{transform:scale(1.05);opacity:.9}
    .hub-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:30px;margin-bottom:40px}
    .hub-section{background:var(--tez-bg,#fff);border:1px solid var(--tez-border,#e5e7eb);border-radius:15px;padding:25px;transition:.3s}
    .hub-section:hover{box-shadow:0 8px 30px rgba(0,0,0,.08)}
    .hub-section h3{color:var(--tez-text,#111827);font-size:20px;margin:0 0 20px;display:flex;align-items:center;gap:10px}
    .hub-section h3 i{color:var(--tez-primary,#22BE49);font-size:22px}
    .hub-list{list-style:none;padding:0;margin:0}
    .hub-list li{margin-bottom:12px}
    .hub-list a{color:var(--tez-text-secondary,#374151);text-decoration:none;display:flex;align-items:center;gap:10px;padding:8px;border-radius:8px;transition:.3s}
    .hub-list a:hover{background:var(--tez-bg-secondary,#f9fafb);color:var(--tez-primary,#22BE49);padding-right:15px}
    .hub-list i{color:var(--tez-primary,#22BE49);font-size:14px}
    .category-list{display:flex;flex-wrap:wrap;gap:10px}
    .cat-badge{display:inline-flex;align-items:center;gap:6px;background:var(--tez-bg-secondary,#f9fafb);color:var(--tez-text-secondary,#374151);padding:8px 15px;border-radius:20px;text-decoration:none;font-size:14px;transition:.3s}
    .cat-badge:hover{background:var(--tez-primary,#22BE49);color:#fff}
    .cat-badge i{font-size:12px}
    .cat-badge span{opacity:.7}
    .hub-actions{text-align:center;margin-top:40px;display:flex;gap:15px;justify-content:center;flex-wrap:wrap}
    .hub-actions a{display:inline-flex;align-items:center;gap:10px;padding:14px 30px;border-radius:50px;text-decoration:none;font-weight:600;font-size:16px;transition:.3s}
    .btn-home{background:var(--tez-primary,#22BE49);color:#fff}
    .btn-home:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(34,190,73,.3)}
    .btn-sitemap{background:var(--tez-bg-secondary,#f9fafb);color:var(--tez-text,#111827);border:2px solid var(--tez-border,#e5e7eb)}
    .btn-sitemap:hover{border-color:var(--tez-primary,#22BE49);color:var(--tez-primary,#22BE49)}
    @media(max-width:768px){.error-code{font-size:80px}.hub-header h1{font-size:28px}.hub-header p{font-size:16px}.hub-grid{grid-template-columns:1fr}.hub-actions{flex-direction:column}.hub-actions a{width:100%;justify-content:center}}
    [data-theme="dark"] .hub-section{background:var(--tez-bg-secondary,#1e293b);border-color:var(--tez-border,#334155)}
    [data-theme="dark"] .hub-search form{background:var(--tez-bg-secondary,#1e293b);border-color:var(--tez-border,#334155)}
    [data-theme="dark"] .hub-list a:hover{background:var(--tez-bg-tertiary,#334155)}
    [data-theme="dark"] .cat-badge{background:var(--tez-bg-tertiary,#334155)}
    [data-theme="dark"] .btn-sitemap{background:var(--tez-bg-tertiary,#334155);border-color:var(--tez-border,#334155)}
    </style>
    <?php
}
