<?php
/**
 * Theme Setup Module
 * 
 * Базовая настройка темы и регистрация поддержки функций WordPress
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ========================================
 * ОСНОВНАЯ НАСТРОЙКА ТЕМЫ
 * ========================================
 */

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
        yandexpro_register_image_sizes();

        // Register navigation menus
        yandexpro_register_nav_menus();

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
        
        // Hook after theme setup
        do_action('yandexpro_after_setup_theme');
    }
}
add_action('after_setup_theme', 'yandexpro_setup');

/**
 * ========================================
 * РЕГИСТРАЦИЯ РАЗМЕРОВ ИЗОБРАЖЕНИЙ
 * ========================================
 */

if (!function_exists('yandexpro_register_image_sizes')) {
    function yandexpro_register_image_sizes() {
        
        $image_sizes = array(
            'yandexpro-large'  => array(1200, 675, true),
            'yandexpro-medium' => array(600, 400, true),
            'yandexpro-small'  => array(300, 200, true),
            'yandexpro-square' => array(400, 400, true),
            'yandexpro-hero'   => array(1920, 800, true),
            'yandexpro-card'   => array(380, 240, true),
        );
        
        // Позволяем модифицировать размеры через фильтр
        $image_sizes = apply_filters('yandexpro_image_sizes', $image_sizes);
        
        foreach ($image_sizes as $name => $size) {
            add_image_size($name, $size[0], $size[1], $size[2]);
        }
    }
}

/**
 * ========================================
 * РЕГИСТРАЦИЯ МЕНЮ
 * ========================================
 */

if (!function_exists('yandexpro_register_nav_menus')) {
    function yandexpro_register_nav_menus() {
        
        $nav_menus = array(
            'primary' => __('Primary Menu', 'yandexpro'),
            'footer'  => __('Footer Menu', 'yandexpro'),
            'mobile'  => __('Mobile Menu', 'yandexpro'),
        );
        
        // Позволяем добавлять/изменять меню через фильтр
        $nav_menus = apply_filters('yandexpro_nav_menus', $nav_menus);
        
        register_nav_menus($nav_menus);
    }
}

/**
 * ========================================
 * РЕГИСТРАЦИЯ ОБЛАСТЕЙ ВИДЖЕТОВ
 * ========================================
 */

if (!function_exists('yandexpro_widgets_init')) {
    function yandexpro_widgets_init() {
        
        // Primary Sidebar
        register_sidebar(array(
            'name'          => __('Primary Sidebar', 'yandexpro'),
            'id'            => 'sidebar-1',
            'description'   => __('Add widgets here to appear in your primary sidebar.', 'yandexpro'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));

        // Footer Widget Area
        register_sidebar(array(
            'name'          => __('Footer Widget Area', 'yandexpro'),
            'id'            => 'footer-1',
            'description'   => __('Add widgets here to appear in your footer.', 'yandexpro'),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ));
        
        // Blog Sidebar (для страниц блога)
        register_sidebar(array(
            'name'          => __('Blog Sidebar', 'yandexpro'),
            'id'            => 'blog-sidebar',
            'description'   => __('Widgets for blog pages only.', 'yandexpro'),
            'before_widget' => '<aside id="%1$s" class="blog-widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="blog-widget-title">',
            'after_title'   => '</h3>',
        ));
        
        // Позволяем добавлять кастомные области виджетов
        do_action('yandexpro_register_sidebars');
    }
}
add_action('widgets_init', 'yandexpro_widgets_init');

/**
 * ========================================
 * РЕГИСТРАЦИЯ ШАБЛОНОВ СТРАНИЦ
 * ========================================
 */

if (!function_exists('yandexpro_add_page_templates')) {
    function yandexpro_add_page_templates($templates) {
        
        $page_templates = array(
            'page-templates/page-landing.php'     => __('Landing Page', 'yandexpro'),
            'page-templates/page-blog-modern.php' => __('Modern Blog Page', 'yandexpro'),
            'page-templates/page-contact.php'    => __('Contact Page', 'yandexpro'),
        );
        
        // Позволяем добавлять/изменять шаблоны через фильтр
        $page_templates = apply_filters('yandexpro_page_templates', $page_templates);
        
        return array_merge($templates, $page_templates);
    }
}
add_filter('theme_page_templates', 'yandexpro_add_page_templates');

/**
 * ========================================
 * КЛАССЫ BODY
 * ========================================
 */

if (!function_exists('yandexpro_body_classes')) {
    function yandexpro_body_classes($classes) {
        
        // Add class for theme version
        $classes[] = 'yandexpro-theme';
        $classes[] = 'version-' . str_replace('.', '-', YANDEXPRO_VERSION);
        
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
        
        // Add page template class
        if (is_page_template()) {
            $template = basename(get_page_template_slug());
            $classes[] = 'template-' . str_replace('.php', '', $template);
        }
        
        // Add blog-related classes
        if (is_home() || is_category() || is_tag() || is_archive()) {
            $classes[] = 'blog-page';
        }
        
        // Позволяем добавлять кастомные классы
        $classes = apply_filters('yandexpro_body_classes', $classes);
        
        return $classes;
    }
}
add_filter('body_class', 'yandexpro_body_classes');

/**
 * ========================================
 * ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
 * ========================================
 */

/**
 * Проверка активности сайдбара
 */
if (!function_exists('yandexpro_has_sidebar')) {
    function yandexpro_has_sidebar($sidebar_id = 'sidebar-1') {
        return is_active_sidebar($sidebar_id);
    }
}

/**
 * Получение информации о теме
 */
if (!function_exists('yandexpro_get_theme_info')) {
    function yandexpro_get_theme_info($field = null) {
        $theme_info = array(
            'name'        => 'YandexPro Enhanced',
            'version'     => YANDEXPRO_VERSION,
            'author'      => 'YandexPro Team',
            'description' => 'Professional WordPress theme for blogs and business websites',
        );
        
        if ($field && isset($theme_info[$field])) {
            return $theme_info[$field];
        }
        
        return $theme_info;
    }
}

/**
 * ========================================
 * ХУКИ ДЛЯ РАСШИРЕНИЯ
 * ========================================
 */

// Хук после инициализации модуля
do_action('yandexpro_theme_setup_loaded');