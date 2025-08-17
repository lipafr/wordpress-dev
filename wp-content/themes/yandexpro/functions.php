<?php
/**
 * YandexPro Personal Theme Functions
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme version
 */
define('YANDEXPRO_VERSION', '1.0.0');

/**
 * Set up theme defaults and register support for various WordPress features
 */
if (!function_exists('yandexpro_setup')) {
    function yandexpro_setup() {
        
        // Make theme available for translation
        load_theme_textdomain('yandexpro', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');
        
        // Set default thumbnail size
        set_post_thumbnail_size(800, 450, true);
        
        // Add additional image sizes
        add_image_size('yandexpro-large', 1200, 675, true);
        add_image_size('yandexpro-medium', 600, 400, true);
        add_image_size('yandexpro-small', 300, 200, true);
        add_image_size('yandexpro-square', 400, 400, true);

        // Register navigation menus
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'yandexpro'),
            'footer'  => __('Footer Menu', 'yandexpro'),
        ));

        // Switch default core markup to output valid HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Set up the WordPress core custom background feature
        add_theme_support('custom-background', apply_filters('yandexpro_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for core custom logo
        add_theme_support('custom-logo', array(
            'height'      => 100,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        // Add support for responsive embedded content
        add_theme_support('responsive-embeds');

        // Content width
        if (!isset($content_width)) {
            $content_width = 800;
        }
    }
}
add_action('after_setup_theme', 'yandexpro_setup');

/**
 * Register widget areas
 */
if (!function_exists('yandexpro_widgets_init')) {
    function yandexpro_widgets_init() {
        register_sidebar(array(
            'name'          => __('Primary Sidebar', 'yandexpro'),
            'id'            => 'sidebar-1',
            'description'   => __('Add widgets here to appear in your primary sidebar.', 'yandexpro'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));

        register_sidebar(array(
            'name'          => __('Footer Widget Area', 'yandexpro'),
            'id'            => 'footer-1',
            'description'   => __('Add widgets here to appear in your footer.', 'yandexpro'),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ));
    }
}
add_action('widgets_init', 'yandexpro_widgets_init');

/**
 * Enqueue scripts and styles
 */
if (!function_exists('yandexpro_scripts')) {
    function yandexpro_scripts() {
        // Theme stylesheet
        wp_enqueue_style('yandexpro-style', get_stylesheet_uri(), array(), YANDEXPRO_VERSION);
        
        // Main JavaScript file
        wp_enqueue_script(
            'yandexpro-script',
            get_template_directory_uri() . '/assets/js/script.js',
            array(),
            YANDEXPRO_VERSION,
            true
        );

        // Navigation script
        wp_enqueue_script(
            'yandexpro-navigation',
            get_template_directory_uri() . '/assets/js/navigation.js',
            array(),
            YANDEXPRO_VERSION,
            true
        );

        // Localize script for AJAX and translations
        wp_localize_script('yandexpro-script', 'yandexpro_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('yandexpro_nonce'),
            'strings'  => array(
                'menu_toggle' => __('Toggle navigation', 'yandexpro'),
                'menu_close'  => __('Close navigation', 'yandexpro'),
                'search'      => __('Search', 'yandexpro'),
            ),
        ));

        // Comment reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action('wp_enqueue_scripts', 'yandexpro_scripts');

/**
 * Custom excerpt length
 */
if (!function_exists('yandexpro_excerpt_length')) {
    function yandexpro_excerpt_length($length) {
        if (is_admin()) {
            return $length;
        }
        return 30; // Default excerpt length
    }
}
add_filter('excerpt_length', 'yandexpro_excerpt_length', 999);

/**
 * Custom excerpt more string
 */
if (!function_exists('yandexpro_excerpt_more')) {
    function yandexpro_excerpt_more($more) {
        if (is_admin()) {
            return $more;
        }
        return '...';
    }
}
add_filter('excerpt_more', 'yandexpro_excerpt_more');

/**
 * Custom "Continue reading" link
 */
if (!function_exists('yandexpro_continue_reading_link')) {
    function yandexpro_continue_reading_link() {
        if (!is_admin()) {
            return sprintf(
                '<a href="%s" class="btn btn-primary continue-reading">%s</a>',
                esc_url(get_permalink()),
                __('Continue reading', 'yandexpro')
            );
        }
    }
}

/**
 * Calculate reading time
 */
if (!function_exists('yandexpro_reading_time')) {
    function yandexpro_reading_time($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        $content = get_post_field('post_content', $post_id);
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
        
        return $reading_time;
    }
}

/**
 * Add security headers
 */
if (!function_exists('yandexpro_security_headers')) {
    function yandexpro_security_headers() {
        if (!is_admin()) {
            // Remove WordPress version from head and feeds
            remove_action('wp_head', 'wp_generator');
            
            // Remove RSD link
            remove_action('wp_head', 'rsd_link');
            
            // Remove wlwmanifest.xml
            remove_action('wp_head', 'wlwmanifest_link');
            
            // Remove shortlink
            remove_action('wp_head', 'wp_shortlink_wp_head');
            
            // Remove adjacent posts links
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
        }
    }
}
add_action('init', 'yandexpro_security_headers');

/**
 * Optimize images - add loading="lazy" and decoding="async"
 */
if (!function_exists('yandexpro_add_image_attributes')) {
    function yandexpro_add_image_attributes($attr, $attachment, $size) {
        $attr['loading'] = 'lazy';
        $attr['decoding'] = 'async';
        return $attr;
    }
}
add_filter('wp_get_attachment_image_attributes', 'yandexpro_add_image_attributes', 10, 3);

/**
 * Add theme support for starter content
 */
if (!function_exists('yandexpro_starter_content')) {
    function yandexpro_starter_content() {
        add_theme_support('starter-content', array(
            'widgets' => array(
                'sidebar-1' => array(
                    'search',
                    'recent-posts',
                    'archives',
                ),
                'footer-1' => array(
                    'text_about',
                ),
            ),
            'posts' => array(
                'home' => array(
                    'post_title' => __('Welcome to YandexPro', 'yandexpro'),
                    'post_content' => __('This is your homepage. You can customize it from the WordPress admin panel.', 'yandexpro'),
                ),
                'about' => array(
                    'post_title' => __('About Us', 'yandexpro'),
                    'post_content' => __('Tell your visitors about yourself and your website.', 'yandexpro'),
                ),
                'contact' => array(
                    'post_title' => __('Contact', 'yandexpro'),
                    'post_content' => __('Get in touch with us.', 'yandexpro'),
                ),
                'blog' => array(
                    'post_title' => __('Blog', 'yandexpro'),
                    'post_content' => __('This is your blog page.', 'yandexpro'),
                ),
            ),
            'nav_menus' => array(
                'primary' => array(
                    'name' => __('Primary Menu', 'yandexpro'),
                    'items' => array(
                        'page_home',
                        'page_about',
                        'page_blog',
                        'page_contact',
                    ),
                ),
            ),
            'options' => array(
                'show_on_front'  => 'page',
                'page_on_front'  => '{{home}}',
                'page_for_posts' => '{{blog}}',
            ),
        ));
    }
}
add_action('after_setup_theme', 'yandexpro_starter_content');

/**
 * Include additional files
 */
$inc_files = array(
    'inc/customizer.php',
    'inc/template-tags.php',
    'inc/template-functions.php',
);

foreach ($inc_files as $file) {
    $filepath = get_template_directory() . '/' . $file;
    if (file_exists($filepath)) {
        require $filepath;
    }
}

/**
 * Page templates registration
 */
if (!function_exists('yandexpro_add_page_templates')) {
    function yandexpro_add_page_templates($templates) {
        $templates['page-templates/page-landing.php'] = __('Landing Page', 'yandexpro');
        $templates['page-templates/page-blog.php'] = __('Blog Page', 'yandexpro');
        $templates['page-templates/page-contact.php'] = __('Contact Page', 'yandexpro');
        return $templates;
    }
}
add_filter('theme_page_templates', 'yandexpro_add_page_templates');

/**
 * Disable emoji scripts (performance optimization)
 */
if (!function_exists('yandexpro_disable_emojis')) {
    function yandexpro_disable_emojis() {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }
}
add_action('init', 'yandexpro_disable_emojis');

/**
 * Theme customization options (basic)
 */
if (!function_exists('yandexpro_get_theme_option')) {
    function yandexpro_get_theme_option($option, $default = '') {
        return get_theme_mod($option, $default);
    }
}

/**
 * Add body classes
 */
if (!function_exists('yandexpro_body_classes')) {
    function yandexpro_body_classes($classes) {
        // Add class for theme version
        $classes[] = 'yandexpro-theme';
        
        // Add class if sidebar is active
        if (is_active_sidebar('sidebar-1')) {
            $classes[] = 'has-sidebar';
        } else {
            $classes[] = 'no-sidebar';
        }
        
        // Add class for dark theme if enabled
        if (yandexpro_get_theme_option('enable_dark_theme', false)) {
            $classes[] = 'has-dark-theme-option';
        }
        
        return $classes;
    }
}
add_filter('body_class', 'yandexpro_body_classes');