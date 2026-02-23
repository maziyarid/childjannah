<?php
/**
 * Enhanced Post Meta & Difficulty Level
 *
 * @package JannahChild
 * @version 2.4.0
 */

if (!defined('ABSPATH')) exit;

// Source: Snippets/Enhanced post meta + Difficulty Lvl.php
// + Snippets/Post Meta Modifier.php

// =====================================================
// INITIALIZATION
// =====================================================
add_action('init', 'jannah_enhanced_meta_init', 20);
function jannah_enhanced_meta_init() {
    add_action('wp_enqueue_scripts', 'jannah_enhanced_meta_assets');
    add_action('admin_enqueue_scripts', 'jannah_badges_admin_assets');
}

function jannah_enhanced_meta_assets() {
    if (!wp_style_is('font-awesome', 'enqueued')) {
        wp_enqueue_style('jannah-fa-badges', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    }
}

function jannah_badges_admin_assets($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) return;
    wp_enqueue_style('jannah-fa-admin-badges', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
}

// =====================================================
// CONTENT TYPES & DIFFICULTY LEVELS
// =====================================================
function jannah_get_content_types() {
    return array(
        'tutorial' => array('label' => 'آموزش', 'icon' => 'fa-graduation-cap', 'color' => '#00bfa5', 'bg_color' => 'rgba(0,191,165,0.12)'),
        'opinion' => array('label' => 'دیدگاه', 'icon' => 'fa-comment-dots', 'color' => '#ff6b6b', 'bg_color' => 'rgba(255,107,107,0.12)'),
        'news' => array('label' => 'خبر', 'icon' => 'fa-newspaper', 'color' => '#4ecdc4', 'bg_color' => 'rgba(78,205,196,0.12)'),
        'case_study' => array('label' => 'مطالعه موردی', 'icon' => 'fa-microscope', 'color' => '#8e44ad', 'bg_color' => 'rgba(142,68,173,0.12)'),
        'review' => array('label' => 'بررسی و نقد', 'icon' => 'fa-star-half-stroke', 'color' => '#f39c12', 'bg_color' => 'rgba(243,156,18,0.12)'),
        'guide' => array('label' => 'راهنما', 'icon' => 'fa-map-signs', 'color' => '#3498db', 'bg_color' => 'rgba(52,152,219,0.12)'),
        'analysis' => array('label' => 'تحلیل', 'icon' => 'fa-chart-line', 'color' => '#e74c3c', 'bg_color' => 'rgba(231,76,60,0.12)'),
        'interview' => array('label' => 'مصاحبه', 'icon' => 'fa-microphone', 'color' => '#9b59b6', 'bg_color' => 'rgba(155,89,182,0.12)'),
    );
}

function jannah_get_difficulty_levels() {
    return array(
        'beginner' => array('label' => 'مبتدی', 'icon' => 'fa-seedling', 'color' => '#2ecc71', 'bg_color' => 'rgba(46,204,113,0.12)'),
        'elementary' => array('label' => 'ابتدایی', 'icon' => 'fa-user-graduate', 'color' => '#3498db', 'bg_color' => 'rgba(52,152,219,0.12)'),
        'intermediate' => array('label' => 'متوسط', 'icon' => 'fa-fire', 'color' => '#f39c12', 'bg_color' => 'rgba(243,156,18,0.12)'),
        'advanced' => array('label' => 'پیشرفته', 'icon' => 'fa-rocket', 'color' => '#e74c3c', 'bg_color' => 'rgba(231,76,60,0.12)'),
        'expert' => array('label' => 'حرفه‌ای', 'icon' => 'fa-crown', 'color' => '#9b59b6', 'bg_color' => 'rgba(155,89,182,0.12)'),
        'master' => array('label' => 'استادی', 'icon' => 'fa-gem', 'color' => '#34495e', 'bg_color' => 'rgba(52,73,94,0.12)'),
    );
}

// =====================================================
// ADMIN META BOXES
// =====================================================
add_action('add_meta_boxes', 'jannah_add_badges_metaboxes');
function jannah_add_badges_metaboxes() {
    add_meta_box('jannah_content_type', 'نوع محتوا - Content Type', 'jannah_content_type_metabox_html', 'post', 'side', 'high');
    add_meta_box('jannah_difficulty_level', 'سطح دشواری - Difficulty Level', 'jannah_difficulty_metabox_html', 'post', 'side', 'high');
}

function jannah_content_type_metabox_html($post) {
    wp_nonce_field('jannah_content_type_save', 'jannah_content_type_nonce');
    $selected = get_post_meta($post->ID, '_jannah_content_type', true);
    $types = jannah_get_content_types();
    echo '<div class="content-type-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px">';
    foreach ($types as $key => $type) {
        $checked = checked($selected, $key, false);
        echo '<div style="position:relative"><input type="radio" id="ct_'.$key.'" name="jannah_content_type" value="'.$key.'" '.$checked.' style="display:none"><label for="ct_'.$key.'" style="display:block;padding:8px;border:2px solid '.($selected===$key?$type['color']:'#ddd').';border-radius:6px;cursor:pointer;text-align:center;font-size:12px;background:'.($selected===$key?$type['bg_color']:'transparent').'"><i class="fas '.$type['icon'].'" style="display:block;margin-bottom:4px;font-size:18px;color:'.$type['color'].'"></i>'.$type['label'].'</label></div>';
    }
    echo '</div>';
}

function jannah_difficulty_metabox_html($post) {
    wp_nonce_field('jannah_difficulty_save', 'jannah_difficulty_nonce');
    $selected = get_post_meta($post->ID, '_jannah_difficulty_level', true);
    $levels = jannah_get_difficulty_levels();
    echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px">';
    foreach ($levels as $key => $level) {
        $checked = checked($selected, $key, false);
        echo '<div style="position:relative"><input type="radio" id="diff_'.$key.'" name="jannah_difficulty_level" value="'.$key.'" '.$checked.' style="display:none"><label for="diff_'.$key.'" style="display:block;padding:8px;border:2px solid '.($selected===$key?$level['color']:'#ddd').';border-radius:6px;cursor:pointer;text-align:center;font-size:12px;background:'.($selected===$key?$level['bg_color']:'transparent').'"><i class="fas '.$level['icon'].'" style="display:block;margin-bottom:4px;font-size:18px;color:'.$level['color'].'"></i>'.$level['label'].'</label></div>';
    }
    echo '</div>';
}

add_action('save_post', 'jannah_save_badges_meta');
function jannah_save_badges_meta($post_id) {
    if (isset($_POST['jannah_content_type_nonce']) && wp_verify_nonce($_POST['jannah_content_type_nonce'], 'jannah_content_type_save')) {
        if (!defined('DOING_AUTOSAVE') || !DOING_AUTOSAVE) {
            if (current_user_can('edit_post', $post_id) && isset($_POST['jannah_content_type'])) {
                update_post_meta($post_id, '_jannah_content_type', sanitize_text_field($_POST['jannah_content_type']));
            }
        }
    }
    if (isset($_POST['jannah_difficulty_nonce']) && wp_verify_nonce($_POST['jannah_difficulty_nonce'], 'jannah_difficulty_save')) {
        if (!defined('DOING_AUTOSAVE') || !DOING_AUTOSAVE) {
            if (current_user_can('edit_post', $post_id) && isset($_POST['jannah_difficulty_level'])) {
                update_post_meta($post_id, '_jannah_difficulty_level', sanitize_text_field($_POST['jannah_difficulty_level']));
            }
        }
    }
}

// =====================================================
// FRONTEND: INJECT BADGES INTO POST-META
// =====================================================
add_action('wp_footer', 'jannah_inject_badges_into_meta', 999);
function jannah_inject_badges_into_meta() {
    if (!is_singular('post')) return;
    global $post;
    if (!$post) return;

    $type_key = get_post_meta($post->ID, '_jannah_content_type', true);
    $content_type_html = '';
    if ($type_key) {
        $types = jannah_get_content_types();
        if (isset($types[$type_key])) {
            $type = $types[$type_key];
            $content_type_html = sprintf('<span class="meta-item meta-content-type" style="--badge-color:%s;--badge-bg:%s"><i class="fas %s"></i><span class="meta-text">%s</span></span>', esc_attr($type['color']), esc_attr($type['bg_color']), esc_attr($type['icon']), esc_html($type['label']));
        }
    }

    $diff_key = get_post_meta($post->ID, '_jannah_difficulty_level', true);
    $difficulty_html = '';
    if ($diff_key) {
        $levels = jannah_get_difficulty_levels();
        if (isset($levels[$diff_key])) {
            $level = $levels[$diff_key];
            $difficulty_html = sprintf('<span class="meta-item meta-difficulty" style="--badge-color:%s;--badge-bg:%s"><i class="fas %s"></i><span class="meta-text">سطح: %s</span></span>', esc_attr($level['color']), esc_attr($level['bg_color']), esc_attr($level['icon']), esc_html($level['label']));
        }
    }

    if (!$content_type_html && !$difficulty_html) return;
    $ct_js = addslashes($content_type_html);
    $df_js = addslashes($difficulty_html);
    ?>
    <script>
    (function(){
        document.addEventListener('DOMContentLoaded',function(){
            var ct='<?php echo $ct_js; ?>',df='<?php echo $df_js; ?>';
            if(!ct&&!df)return;
            var sel=['.single-post-meta.post-meta.clearfix','.single-post-meta.post-meta','.single-post-meta','.post-meta.clearfix','.post-meta'],mc=null;
            for(var i=0;i<sel.length;i++){mc=document.querySelector(sel[i]);if(mc)break;}
            if(mc){var w=document.createElement('span');w.className='meta-badges-group';w.innerHTML=ct+df;mc.appendChild(w);}
        });
    })();
    </script>
    <?php
}

add_action('wp_head', 'jannah_enhanced_meta_styles', 999);
function jannah_enhanced_meta_styles() {
    ?>
    <style>
    .meta-badges-group{display:inline-flex;align-items:center;gap:8px;margin-right:auto;flex-wrap:nowrap}
    .rtl .meta-badges-group{margin-right:0;margin-left:auto}
    .meta-content-type,.meta-difficulty{display:inline-flex!important;align-items:center;gap:6px;padding:5px 14px!important;border-radius:20px;font-size:13px!important;font-weight:600;background:var(--badge-bg)!important;color:var(--badge-color)!important;border:1px solid transparent;transition:all .3s;white-space:nowrap}
    .meta-content-type:hover,.meta-difficulty:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,.12);border-color:var(--badge-color)}
    .meta-content-type i,.meta-difficulty i{font-size:13px!important;color:var(--badge-color)!important;opacity:1!important}
    @media(max-width:768px){.meta-badges-group{width:100%;margin-top:8px;justify-content:center;flex-wrap:wrap}.meta-content-type,.meta-difficulty{font-size:12px!important;padding:4px 10px!important}}
    </style>
    <?php
}
