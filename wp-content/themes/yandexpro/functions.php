<?php
/**
 * YandexPro Enhanced Theme Functions
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
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

        // Register navigation menus
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'yandexpro'),
            'footer' => __('Footer Menu', 'yandexpro'),
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
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        // Gutenberg support
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('editor-styles');
        add_editor_style('assets/css/editor-style.css');

        // Add support for responsive embedded content
        add_theme_support('responsive-embeds');

        // Custom starter content
        add_theme_support('starter-content', array(
            'widgets' => array(
                'sidebar-1' => array(
                    'search',
                    'recent-posts',
                    'archives',
                ),
            ),
            'posts' => array(
                'home',
                'about' => array(
                    'post_title' => __('О нас', 'yandexpro'),
                    'post_content' => __('Добро пожаловать на наш сайт о Яндекс.Директ и интернет-маркетинге.', 'yandexpro'),
                ),
                'contact' => array(
                    'post_title' => __('Контакты', 'yandexpro'),
                    'post_content' => __('Свяжитесь с нами для получения консультации.', 'yandexpro'),
                ),
                'blog' => array(
                    'post_title' => __('Блог', 'yandexpro'),
                    'post_content' => __('Последние статьи о контекстной рекламе и маркетинге.', 'yandexpro'),
                ),
            ),
            'nav_menus' => array(
                'primary' => array(
                    'name' => __('Основное меню', 'yandexpro'),
                    'items' => array(
                        'link_home',
                        'page_about',
                        'page_blog',
                        'page_contact',
                    ),
                ),
            ),
            'options' => array(
                'show_on_front' => 'page',
                'page_on_front' => '{{home}}',
                'page_for_posts' => '{{blog}}',
            ),
        ));
    }
}
add_action('after_setup_theme', 'yandexpro_setup');

/**
 * Set the content width in pixels
 */
function yandexpro_content_width() {
    $GLOBALS['content_width'] = apply_filters('yandexpro_content_width', 1200);
}
add_action('after_setup_theme', 'yandexpro_content_width', 0);

/**
 * Register widget areas
 */
if (!function_exists('yandexpro_widgets_init')) {
    function yandexpro_widgets_init() {
        register_sidebar(array(
            'name'          => __('Основной сайдбар', 'yandexpro'),
            'id'            => 'sidebar-1',
            'description'   => __('Добавьте виджеты для отображения в основном сайдбаре.', 'yandexpro'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));

        register_sidebar(array(
            'name'          => __('Область виджетов в футере', 'yandexpro'),
            'id'            => 'footer-widgets',
            'description'   => __('Добавьте виджеты для отображения в футере.', 'yandexpro'),
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
        $theme_version = wp_get_theme()->get('Version');

        // Enqueue main stylesheet
        wp_enqueue_style('yandexpro-style', get_stylesheet_uri(), array(), $theme_version);
        
        // Enqueue main CSS file
        wp_enqueue_style('yandexpro-main', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version);

        // Enqueue main JavaScript file
        wp_enqueue_script('yandexpro-script', get_template_directory_uri() . '/assets/js/script.js', array(), $theme_version, true);

        // Localize script for AJAX and translations
        wp_localize_script('yandexpro-script', 'yandexpro_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('yandexpro_nonce'),
            'menu_toggle' => __('Переключить навигацию', 'yandexpro'),
            'menu_close' => __('Закрыть навигацию', 'yandexpro'),
        ));

        // Conditional loading for comment-reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        // Google Fonts (with display=swap)
        $google_fonts_url = yandexpro_google_fonts_url();
        if ($google_fonts_url) {
            wp_enqueue_style('yandexpro-fonts', $google_fonts_url, array(), null);
        }
    }
}
add_action('wp_enqueue_scripts', 'yandexpro_scripts');

/**
 * Get Google Fonts URL
 */
if (!function_exists('yandexpro_google_fonts_url')) {
    function yandexpro_google_fonts_url() {
        $fonts_url = '';
        $font_families = array();

        // Check if custom fonts are enabled in Customizer
        if (get_theme_mod('yandexpro_enable_google_fonts', false)) {
            $primary_font = get_theme_mod('yandexpro_primary_font', 'Inter');
            $secondary_font = get_theme_mod('yandexpro_secondary_font', 'Inter');

            if ($primary_font && $primary_font !== 'system') {
                $font_families[] = $primary_font . ':400,600,700';
            }

            if ($secondary_font && $secondary_font !== 'system' && $secondary_font !== $primary_font) {
                $font_families[] = $secondary_font . ':400,600';
            }

            if (!empty($font_families)) {
                $query_args = array(
                    'family' => implode('|', $font_families),
                    'subset' => 'latin,latin-ext,cyrillic',
                    'display' => 'swap',
                );

                $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
            }
        }

        return esc_url_raw($fonts_url);
    }
}

/**
 * Custom excerpt length
 */
if (!function_exists('yandexpro_excerpt_length')) {
    function yandexpro_excerpt_length($length) {
        return is_admin() ? $length : 25;
    }
}
add_filter('excerpt_length', 'yandexpro_excerpt_length', 999);

/**
 * Custom excerpt more text
 */
if (!function_exists('yandexpro_excerpt_more')) {
    function yandexpro_excerpt_more($more) {
        if (is_admin()) {
            return $more;
        }
        return '... <a class="read-more" href="' . get_permalink() . '">' . __('Читать далее', 'yandexpro') . '</a>';
    }
}
add_filter('excerpt_more', 'yandexpro_excerpt_more');

/**
 * Add structured data for SEO
 */
if (!function_exists('yandexpro_structured_data')) {
    function yandexpro_structured_data() {
        if (is_singular('post')) {
            $post_id = get_the_ID();
            $schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => get_the_title(),
                'datePublished' => get_the_date('c'),
                'dateModified' => get_the_modified_date('c'),
                'author' => array(
                    '@type' => 'Person',
                    'name' => get_the_author(),
                ),
                'publisher' => array(
                    '@type' => 'Organization',
                    'name' => get_bloginfo('name'),
                ),
                'mainEntityOfPage' => array(
                    '@type' => 'WebPage',
                    '@id' => get_permalink(),
                ),
            );

            if (has_post_thumbnail()) {
                $schema['image'] = array(
                    '@type' => 'ImageObject',
                    'url' => get_the_post_thumbnail_url($post_id, 'large'),
                );
            }

            echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>' . "\n";
        }
    }
}
add_action('wp_head', 'yandexpro_structured_data');

/**
 * Optimize images
 */
function yandexpro_add_responsive_image_attributes($attr, $attachment, $size) {
    $attr['loading'] = 'lazy';
    $attr['decoding'] = 'async';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'yandexpro_add_responsive_image_attributes', 10, 3);

/**
 * Security enhancements
 */
function yandexpro_security_headers() {
    if (!is_admin()) {
        // Remove WordPress version from head
        remove_action('wp_head', 'wp_generator');
        
        // Remove RSD link
        remove_action('wp_head', 'rsd_link');
        
        // Remove wlwmanifest.xml
        remove_action('wp_head', 'wlwmanifest_link');
        
        // Remove shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head');
    }
}
add_action('init', 'yandexpro_security_headers');

/**
 * Page Templates Registration
 */
function yandexpro_add_page_templates($templates) {
    $templates['page-templates/page-landing.php'] = __('Лендинг', 'yandexpro');
    $templates['page-templates/page-blog.php'] = __('Страница блога', 'yandexpro');
    $templates['page-templates/page-contact.php'] = __('Страница контактов', 'yandexpro');
    return $templates;
}
add_filter('theme_page_templates', 'yandexpro_add_page_templates');

// Include additional files
$inc_files = array(
    'inc/customizer.php',
    'inc/template-tags.php',
    'inc/template-functions.php',
    'inc/block-patterns.php',
);

foreach ($inc_files as $file) {
    $filepath = get_template_directory() . '/' . $file;
    if (file_exists($filepath)) {
        require $filepath;
    }
}
?>