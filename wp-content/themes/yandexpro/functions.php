<?php
/**
 * YandexPro Enhanced WordPress Theme Functions
 * 
 * ИСПРАВЛЕННАЯ ВЕРСИЯ - Модульная архитектура
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
 * КОНСТАНТЫ - КРИТИЧНО ВАЖНО! (ПЕРВЫМ ДЕЛОМ)
 * ========================================
 */

// Theme version
if (!defined('YANDEXPRO_VERSION')) {
    define('YANDEXPRO_VERSION', '1.0.0');
}

// Theme paths
if (!defined('YANDEXPRO_THEME_DIR')) {
    define('YANDEXPRO_THEME_DIR', get_template_directory());
}
if (!defined('YANDEXPRO_THEME_URL')) {
    define('YANDEXPRO_THEME_URL', get_template_directory_uri());
}
if (!defined('YANDEXPRO_INC_DIR')) {
    define('YANDEXPRO_INC_DIR', YANDEXPRO_THEME_DIR . '/inc');
}

/**
 * ========================================
 * БАЗОВЫЕ ФУНКЦИИ (ДО ЗАГРУЗКИ МОДУЛЕЙ)
 * ========================================
 */

/**
 * Получение настроек темы из Customizer
 * КРИТИЧНО ВАЖНАЯ ФУНКЦИЯ - используется везде!
 */
if (!function_exists('yandexpro_get_theme_option')) {
    function yandexpro_get_theme_option($option_name, $default = '') {
        return get_theme_mod($option_name, $default);
    }
}

/**
 * Безопасное подключение модуля
 * ОСНОВА МОДУЛЬНОЙ АРХИТЕКТУРЫ
 */
if (!function_exists('yandexpro_require_module')) {
    function yandexpro_require_module($module_name, $required = false) {
        $file_path = YANDEXPRO_INC_DIR . '/' . $module_name . '.php';
        
        if (file_exists($file_path)) {
            require_once $file_path;
            
            // Debug информация при успешной загрузке
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log("YandexPro: Module '{$module_name}' loaded successfully");
            }
            
            return true;
        } elseif ($required) {
            // Для критичных модулей показываем ошибку только админам
            if (current_user_can('manage_options')) {
                add_action('admin_notices', function() use ($module_name) {
                    echo '<div class="notice notice-error"><p>';
                    echo sprintf('YandexPro Theme: Required module "%s" not found. Please check file: /inc/%s.php', 
                        esc_html($module_name), 
                        esc_html($module_name)
                    );
                    echo '</p></div>';
                });
            }
            
            // Логируем критическую ошибку
            error_log("YandexPro CRITICAL: Required module '{$module_name}' not found at: {$file_path}");
            return false;
        }
        
        // Для необязательных модулей просто логируем
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log("YandexPro: Optional module '{$module_name}' not found, using fallback");
        }
        
        return false;
    }
}

/**
 * ========================================
 * ЗАГРУЗКА МОДУЛЕЙ (ПРАВИЛЬНЫЙ ПОРЯДОК!)
 * ========================================
 */

// КРИТИЧНО ВАЖНЫЕ модули (без них тема не работает)
yandexpro_require_module('theme-setup', true);       // ПЕРВЫЙ! Базовая настройка
yandexpro_require_module('enqueue-scripts', true);   // ВТОРОЙ! Подключение ресурсов

// ФУНКЦИОНАЛЬНЫЕ модули (важные, но необязательные)
yandexpro_require_module('customizer', false);       // Настройки Customizer
yandexpro_require_module('template-tags', false);    // Теги шаблонов
yandexpro_require_module('template-functions', false); // Функции шаблонов
yandexpro_require_module('blog-categories', false);  // Управление категориями

// ДОПОЛНИТЕЛЬНЫЕ модули (улучшения)
yandexpro_require_module('security', false);         // Безопасность
yandexpro_require_module('performance', false);      // Производительность
yandexpro_require_module('starter-content', false);  // Стартовый контент

/**
 * ========================================
 * FALLBACK СИСТЕМА (если модули не загрузились)
 * ========================================
 */

/**
 * Базовая настройка темы (fallback)
 * Загружается если модуль theme-setup не найден
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

        // Gutenberg support
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('editor-styles');
        
        // Content width
        if (!isset($content_width)) {
            $content_width = 800;
        }
    }
}
add_action('after_setup_theme', 'yandexpro_setup');

/**
 * Register widget areas (fallback)
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
 * Enqueue scripts and styles (fallback)
 */
if (!function_exists('yandexpro_scripts')) {
    function yandexpro_scripts() {
        // Theme stylesheet (всегда подключаем)
        wp_enqueue_style('yandexpro-style', get_stylesheet_uri(), array(), YANDEXPRO_VERSION);
        
        // Проверяем существование JavaScript файлов перед подключением
        $script_path = get_template_directory() . '/assets/js/script.js';
        if (file_exists($script_path)) {
            wp_enqueue_script(
                'yandexpro-script',
                get_template_directory_uri() . '/assets/js/script.js',
                array(),
                YANDEXPRO_VERSION,
                true
            );
            
            // Локализация скриптов
            wp_localize_script('yandexpro-script', 'yandexpro_vars', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('yandexpro_nonce'),
                'strings'  => array(
                    'menu_toggle' => __('Toggle navigation', 'yandexpro'),
                    'menu_close'  => __('Close navigation', 'yandexpro'),
                    'search'      => __('Search', 'yandexpro'),
                ),
            ));
        } else {
            // Предупреждение для админов
            if (current_user_can('manage_options') && defined('WP_DEBUG') && WP_DEBUG) {
                error_log('YandexPro: script.js not found at: ' . $script_path);
            }
        }

        // Navigation script
        $nav_script_path = get_template_directory() . '/assets/js/navigation.js';
        if (file_exists($nav_script_path)) {
            wp_enqueue_script(
                'yandexpro-navigation',
                get_template_directory_uri() . '/assets/js/navigation.js',
                array(),
                YANDEXPRO_VERSION,
                true
            );
        } else {
            // Предупреждение для админов
            if (current_user_can('manage_options') && defined('WP_DEBUG') && WP_DEBUG) {
                error_log('YandexPro: navigation.js not found at: ' . $nav_script_path);
            }
        }

        // Comment reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action('wp_enqueue_scripts', 'yandexpro_scripts');

/**
 * ========================================
 * FALLBACK ФУНКЦИИ ДЛЯ МОДУЛЕЙ
 * ========================================
 */

/**
 * Получение избранных категорий (fallback для blog-categories модуля)
 */
if (!function_exists('yandexpro_get_featured_categories')) {
    function yandexpro_get_featured_categories($max_categories = 6) {
        $selected_categories = array();
        
        // Автоматический выбор топ категорий
        $auto_categories = get_categories(array(
            'orderby'    => 'count',
            'order'      => 'DESC',
            'number'     => $max_categories,
            'hide_empty' => true,
            'exclude'    => array(1), // Исключаем "Без рубрики"
        ));
        
        foreach ($auto_categories as $category) {
            $selected_categories[] = $category->term_id;
        }
        
        return $selected_categories;
    }
}

/**
 * Проверяем, активна ли категория (fallback)
 */
if (!function_exists('yandexpro_is_category_active')) {
    function yandexpro_is_category_active($category_id) {
        return is_category($category_id);
    }
}

/**
 * Получение информации о категории (fallback)
 */
if (!function_exists('yandexpro_get_category_info')) {
    function yandexpro_get_category_info($category_id) {
        $category = get_category($category_id);
        
        if (!$category || is_wp_error($category)) {
            return false;
        }
        
        return array(
            'id'          => $category->term_id,
            'name'        => $category->name,
            'slug'        => $category->slug,
            'description' => $category->description,
            'count'       => $category->count,
            'link'        => get_category_link($category_id),
            'is_active'   => yandexpro_is_category_active($category_id),
        );
    }
}

/**
 * ========================================
 * ДОПОЛНИТЕЛЬНЫЕ СИСТЕМЫ
 * ========================================
 */

/**
 * Page templates registration
 */
if (!function_exists('yandexpro_add_page_templates')) {
    function yandexpro_add_page_templates($templates) {
        $page_templates = array(
            'page-templates/page-landing.php'     => __('Landing Page', 'yandexpro'),
            'page-templates/page-blog-modern.php' => __('Modern Blog Page', 'yandexpro'),
            'page-templates/contact.php'          => __('Contact Page', 'yandexpro'),
            'page-templates/landing.php'          => __('Simple Landing', 'yandexpro'),
        );
        
        return array_merge($templates, $page_templates);
    }
}
add_filter('theme_page_templates', 'yandexpro_add_page_templates');

/**
 * ========================================
 * ОТЛАДКА И МОНИТОРИНГ
 * ========================================
 */

// Информация для отладки (только в DEBUG режиме)
if (defined('WP_DEBUG') && WP_DEBUG) {
    add_action('wp_footer', function() {
        if (current_user_can('manage_options')) {
            echo "<!-- YandexPro Enhanced Debug Info:\n";
            echo "Version: " . YANDEXPRO_VERSION . "\n";
            echo "Modules directory: " . (is_dir(YANDEXPRO_INC_DIR) ? 'exists' : 'MISSING') . "\n";
            echo "Theme setup function: " . (function_exists('yandexpro_setup') ? 'loaded' : 'missing') . "\n";
            echo "Customizer function: " . (function_exists('yandexpro_customize_register') ? 'loaded' : 'fallback') . "\n";
            echo "Template tags: " . (function_exists('yandexpro_posted_on') ? 'loaded' : 'fallback') . "\n";
            echo "Blog categories: " . (function_exists('yandexpro_get_featured_categories') ? 'loaded' : 'fallback') . "\n";
            echo "-->\n";
        }
    });
    
    // Проверка критических файлов
    add_action('wp_head', function() {
        if (current_user_can('manage_options')) {
            $critical_files = array(
                '/assets/js/script.js',
                '/assets/js/navigation.js',
                '/inc/theme-setup.php',
                '/inc/enqueue-scripts.php',
            );
            
            foreach ($critical_files as $file) {
                $file_path = get_template_directory() . $file;
                if (!file_exists($file_path)) {
                    echo "<!-- YandexPro WARNING: Missing critical file {$file} -->\n";
                }
            }
        }
    });
}

/**
 * ========================================
 * ХУКИ ДЛЯ РАСШИРЕНИЯ
 * ========================================
 */

// Позволяем другим модулям/плагинам добавлять свои хуки
do_action('yandexpro_after_setup');

// Финальная проверка готовности темы
add_action('wp_loaded', function() {
    if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('manage_options')) {
        $theme_ready = true;
        $missing_functions = array();
        
        // Проверяем критические функции
        $critical_functions = array(
            'yandexpro_setup',
            'yandexpro_scripts',
            'yandexpro_get_theme_option',
        );
        
        foreach ($critical_functions as $func) {
            if (!function_exists($func)) {
                $theme_ready = false;
                $missing_functions[] = $func;
            }
        }
        
        if (!$theme_ready) {
            error_log('YandexPro: Theme not fully ready. Missing functions: ' . implode(', ', $missing_functions));
        } else {
            error_log('YandexPro: Theme successfully initialized with modular architecture');
        }
    }
});