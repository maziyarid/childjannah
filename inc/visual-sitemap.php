<?php
/**
 * Visual Sitemap Page
 * Auto-generates a beautiful sitemap on the /sitemap page.
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

// Source: Snippets/Beautiful Visual Sitemap Page.php

add_filter('the_content', 'jannah_visual_sitemap_content');
function jannah_visual_sitemap_content($content) {
    if (!is_page('sitemap')) return $content;
    ob_start();
    ?>
    <div class="jannah-sitemap-container">
        <div class="sitemap-header">
            <i class="fas fa-sitemap"></i>
            <h2>نقشه سایت</h2>
            <p>تمامی محتویات سایت در یک نگاه</p>
        </div>
        <div class="sitemap-search">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                <input type="search" placeholder="جستجو در سایت..." name="s" />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="sitemap-grid">
            <div class="sitemap-section">
                <div class="section-header" style="background:var(--tez-primary,#22BE49)"><i class="fas fa-file"></i><h3>صفحات</h3></div>
                <ul class="sitemap-list">
                    <?php $pages = get_pages(array('sort_column' => 'menu_order', 'number' => 20));
                    foreach($pages as $page) echo '<li><a href="' . get_page_link($page->ID) . '"><i class="fas fa-angle-left"></i> ' . $page->post_title . '</a></li>'; ?>
                </ul>
            </div>
            <div class="sitemap-section">
                <div class="section-header" style="background:#3498db"><i class="fas fa-newspaper"></i><h3>آخرین مطالب</h3></div>
                <ul class="sitemap-list">
                    <?php $recent_posts = wp_get_recent_posts(array('numberposts' => 15, 'post_status' => 'publish'));
                    foreach($recent_posts as $post) echo '<li><a href="' . get_permalink($post['ID']) . '"><i class="fas fa-angle-left"></i> ' . $post['post_title'] . '</a></li>'; ?>
                </ul>
            </div>
            <div class="sitemap-section">
                <div class="section-header" style="background:#e74c3c"><i class="fas fa-folder"></i><h3>دسته‌بندی‌ها</h3></div>
                <div class="category-grid">
                    <?php $categories = get_categories(array('orderby' => 'count', 'order' => 'DESC', 'number' => 20));
                    foreach($categories as $cat) echo '<a href="' . get_category_link($cat->term_id) . '" class="category-card"><i class="fas fa-folder-open"></i><span>' . $cat->name . '</span><small>' . $cat->count . ' مطلب</small></a>'; ?>
                </div>
            </div>
            <div class="sitemap-section">
                <div class="section-header" style="background:#9b59b6"><i class="fas fa-tags"></i><h3>برچسب‌ها</h3></div>
                <div class="tags-cloud">
                    <?php $tags = get_tags(array('number' => 30));
                    foreach($tags as $tag) echo '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>'; ?>
                </div>
            </div>
            <div class="sitemap-section">
                <div class="section-header" style="background:#f39c12"><i class="fas fa-calendar"></i><h3>آرشیو ماهانه</h3></div>
                <ul class="sitemap-list"><?php wp_get_archives(array('type' => 'monthly', 'limit' => 12)); ?></ul>
            </div>
        </div>
    </div>
    <style>
    .jannah-sitemap-container{max-width:1200px;margin:0 auto;padding:20px}
    .sitemap-header{text-align:center;padding:40px 20px;background:linear-gradient(135deg,var(--tez-primary,#22BE49) 0%,#1a9e3a 100%);color:#fff;border-radius:20px;margin-bottom:40px}
    .sitemap-header i{font-size:48px;margin-bottom:20px;display:block}
    .sitemap-header h2{font-size:32px;margin:0 0 10px}
    .sitemap-search{max-width:600px;margin:-20px auto 40px;position:relative}
    .sitemap-search form{display:flex;background:#fff;border-radius:50px;box-shadow:0 10px 40px rgba(0,0,0,.1);overflow:hidden}
    .sitemap-search input{flex:1;padding:15px 25px;border:none;font-size:16px}
    .sitemap-search button{background:var(--tez-primary,#22BE49);border:none;padding:0 30px;color:#fff;cursor:pointer}
    .sitemap-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(350px,1fr));gap:30px}
    .sitemap-section{background:#fff;border-radius:15px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,.08);transition:transform .3s}
    .sitemap-section:hover{transform:translateY(-5px)}
    .section-header{color:#fff;padding:15px 20px;display:flex;align-items:center;gap:10px}
    .section-header i{font-size:24px}.section-header h3{margin:0;font-size:18px}
    .sitemap-list{list-style:none;padding:20px;margin:0}
    .sitemap-list li{margin-bottom:10px}
    .sitemap-list a{color:#333;text-decoration:none;display:flex;align-items:center;gap:8px;transition:.3s;padding:5px}
    .sitemap-list a:hover{color:var(--tez-primary,#22BE49);padding-right:10px}
    .category-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;padding:20px}
    .category-card{display:flex;flex-direction:column;align-items:center;padding:15px;border:2px solid #eee;border-radius:10px;text-decoration:none;color:#333;transition:.3s}
    .category-card:hover{transform:scale(1.05);border-color:var(--tez-primary,#22BE49)}
    .category-card i{font-size:24px;color:var(--tez-primary,#22BE49);margin-bottom:5px}
    .tags-cloud{padding:20px;text-align:center}
    .tags-cloud a{display:inline-block;margin:5px;padding:5px 15px;background:var(--tez-primary,#22BE49);color:#fff;border-radius:20px;text-decoration:none;transition:.3s;font-size:14px}
    .tags-cloud a:hover{transform:scale(1.1);opacity:.9}
    @media(max-width:768px){.sitemap-grid{grid-template-columns:1fr}.category-grid{grid-template-columns:1fr}}
    [data-theme="dark"] .sitemap-section{background:var(--tez-bg-secondary,#1e293b)}
    [data-theme="dark"] .sitemap-list a,[data-theme="dark"] .category-card{color:var(--tez-text,#f1f5f9)}
    [data-theme="dark"] .sitemap-search form{background:var(--tez-bg-secondary,#1e293b)}
    [data-theme="dark"] .sitemap-search input{background:transparent;color:var(--tez-text,#f1f5f9)}
    </style>
    <?php
    return ob_get_clean();
}
