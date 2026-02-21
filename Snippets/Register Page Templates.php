/**
 * Teznevisan Custom Page Templates Registration
 * Version: 2.2.0
 * 
 * Registers: Homepage, Services, About, Contact
 * Fixed: Function existence checks to prevent undefined function errors
 */

if (!defined('ABSPATH')) exit;

// =============================================
// REGISTER PAGE TEMPLATES
// =============================================
class Tez_Page_Templates {
    
    private static $instance;
    protected $templates = [];
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // Only 4 templates: Homepage, Services, About, Contact
        $this->templates = [
            'tez-template-homepage.php' => 'تز نویسان - صفحه اصلی',
            'tez-template-services.php' => 'تز نویسان - صفحه خدمات',
            'tez-template-about.php'    => 'تز نویسان - درباره ما',
            'tez-template-contact.php'  => 'تز نویسان - تماس با ما',
        ];
        
        add_filter('theme_page_templates', [$this, 'add_templates']);
        add_filter('wp_insert_post_data', [$this, 'register_templates']);
        add_filter('template_include', [$this, 'load_template']);
        add_filter('manage_pages_columns', [$this, 'add_template_column']);
        add_action('manage_pages_custom_column', [$this, 'template_column_content'], 10, 2);
    }
    
    public function add_templates($templates) {
        return array_merge($templates, $this->templates);
    }
    
    public function register_templates($data) {
        $cache_key = 'page_templates-' . md5(get_theme_root() . '/' . get_stylesheet());
        
        $templates = wp_get_theme()->get_page_templates();
        if (empty($templates)) {
            $templates = [];
        }
        
        wp_cache_delete($cache_key, 'themes');
        $templates = array_merge($templates, $this->templates);
        wp_cache_add($cache_key, $templates, 'themes', 1800);
        
        return $data;
    }
    
    public function load_template($template) {
        global $post;
        
        if (!$post) return $template;
        
        $page_template = get_post_meta($post->ID, '_wp_page_template', true);
        
        if (!isset($this->templates[$page_template])) {
            return $template;
        }
        
        add_filter('the_content', [$this, 'inject_template_content'], 999);
        
        return $template;
    }
    
    public function inject_template_content($content) {
        global $post;
        
        if (!is_page() || !in_the_loop() || !is_main_query()) {
            return $content;
        }
        
        $page_template = get_post_meta($post->ID, '_wp_page_template', true);
        $template_content = $this->get_template_content($page_template, $content);
        
        if ($template_content !== false) {
            return $template_content;
        }
        
        return $content;
    }
    
    private function get_template_content($template, $content) {
        // Map templates to their render functions
        $render_functions = [
            'tez-template-homepage.php' => 'tez_render_homepage',
            'tez-template-services.php' => 'tez_render_services_page',
            'tez-template-about.php'    => 'tez_render_about_page',
            'tez-template-contact.php'  => 'tez_render_contact_page',
        ];
        
        // Check if template exists in our list
        if (!isset($render_functions[$template])) {
            return false;
        }
        
        $function_name = $render_functions[$template];
        
        // Check if render function exists before calling
        if (!function_exists($function_name)) {
            // Function not defined - return original content with a wrapper
            return '<div class="tez-page tez-template-' . sanitize_html_class(str_replace(['tez-template-', '.php'], '', $template)) . '">' . $content . '</div>';
        }
        
        // Function exists - call it
        ob_start();
        call_user_func($function_name, $content);
        return ob_get_clean();
    }
    
    public function add_template_column($columns) {
        $columns['tez_template'] = 'قالب';
        return $columns;
    }
    
    public function template_column_content($column, $post_id) {
        if ($column === 'tez_template') {
            $template = get_post_meta($post_id, '_wp_page_template', true);
            if (isset($this->templates[$template])) {
                echo '<span style="color:#1FA640;font-weight:600;">' . esc_html($this->templates[$template]) . '</span>';
            } else {
                echo '—';
            }
        }
    }
}

// Initialize on plugins_loaded
add_action('plugins_loaded', function() {
    Tez_Page_Templates::get_instance();
});
