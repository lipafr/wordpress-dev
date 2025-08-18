<?php
/**
 * YandexPro Enhanced functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package YandexPro_Enhanced
 * @version 1.0.0
 */

// Блокируем прямой доступ к файлу
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Версия темы для кеширования ассетов
 */
define( 'YANDEXPRO_VERSION', '1.0.0' );

/**
 * Минимальные требования
 */
define( 'YANDEXPRO_MIN_WP_VERSION', '6.0' );
define( 'YANDEXPRO_MIN_PHP_VERSION', '8.0' );

/**
 * Проверка совместимости
 */
function yandexpro_check_requirements() {
    global $wp_version;
    
    // Проверка версии WordPress
    if ( version_compare( $wp_version, YANDEXPRO_MIN_WP_VERSION, '<' ) ) {
        add_action( 'admin_notices', function() {
            printf(
                '<div class="notice notice-error"><p>%s</p></div>',
                sprintf(
                    /* translators: %1$s: required WP version, %2$s: current WP version */
                    esc_html__( 'Тема YandexPro Enhanced требует WordPress %1$s или выше. У вас установлена версия %2$s.', 'yandexpro' ),
                    YANDEXPRO_MIN_WP_VERSION,
                    $GLOBALS['wp_version']
                )
            );
        });
        return false;
    }
    
    // Проверка версии PHP
    if ( version_compare( PHP_VERSION, YANDEXPRO_MIN_PHP_VERSION, '<' ) ) {
        add_action( 'admin_notices', function() {
            printf(
                '<div class="notice notice-error"><p>%s</p></div>',
                sprintf(
                    /* translators: %1$s: required PHP version, %2$s: current PHP version */
                    esc_html__( 'Тема YandexPro Enhanced требует PHP %1$s или выше. У вас установлена версия %2$s.', 'yandexpro' ),
                    YANDEXPRO_MIN_PHP_VERSION,
                    PHP_VERSION
                )
            );
        });
        return false;
    }
    
    return true;
}

// Проверяем совместимость при загрузке темы
add_action( 'after_switch_theme', 'yandexpro_check_requirements' );

/**
 * Модульная система загрузки
 * Загружает файлы из папки /inc/
 */
function yandexpro_load_modules() {
    $modules = array(
        'setup',              // Базовая настройка темы
        'enqueue',           // Подключение стилей и скриптов
        'customizer',        // WordPress Customizer
        'template-functions', // Хелперы для шаблонов
        'security',          // Безопасность
        'performance',       // Оптимизация производительности
        'seo',              // SEO функции
        'block-patterns',    // Gutenberg паттерны
        'block-styles',      // Кастомные стили блоков
        'starter-content',   // Демо контент
        'custom-query'       // Оптимизированные запросы
    );
    
    foreach ( $modules as $module ) {
        $file = get_template_directory() . '/inc/' . $module . '.php';
        if ( file_exists( $file ) ) {
            require_once $file;
        } else {
            // В режиме разработки показываем ошибку
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( sprintf( 'YandexPro: Module %s not found at %s', $module, $file ) );
            }
        }
    }
}

/**
 * Условная загрузка модулей совместимости с плагинами
 */
function yandexpro_load_plugin_compatibility() {
    $compatibility_modules = array();
    
    // WooCommerce
    if ( class_exists( 'WooCommerce' ) ) {
        $compatibility_modules[] = 'compat/woocommerce';
    }
    
    // Yoast SEO
    if ( defined( 'WPSEO_VERSION' ) ) {
        $compatibility_modules[] = 'compat/yoast';
    }
    
    // Contact Form 7
    if ( defined( 'WPCF7_VERSION' ) ) {
        $compatibility_modules[] = 'compat/contact-form-7';
    }
    
    // WPML
    if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
        $compatibility_modules[] = 'compat/wpml';
    }
    
    // Jetpack
    if ( defined( 'JETPACK__VERSION' ) ) {
        $compatibility_modules[] = 'compat/jetpack';
    }
    
    foreach ( $compatibility_modules as $module ) {
        $file = get_template_directory() . '/inc/' . $module . '.php';
        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
}

/**
 * Инициализация темы
 */
function yandexpro_init() {
    // Проверяем требования
    if ( ! yandexpro_check_requirements() ) {
        return;
    }
    
    // Загружаем основные модули
    yandexpro_load_modules();
    
    // Загружаем модули совместимости с плагинами
    yandexpro_load_plugin_compatibility();
}

// Инициализируем после загрузки темы
add_action( 'after_setup_theme', 'yandexpro_init', 0 );

/**
 * Базовая настройка темы (если модуль setup.php недоступен)
 */
if ( ! function_exists( 'yandexpro_setup' ) ) {
    function yandexpro_setup() {
        // Поддержка переводов
        load_theme_textdomain( 'yandexpro', get_template_directory() . '/languages' );
        
        // Поддержка RSS ссылок в head
        add_theme_support( 'automatic-feed-links' );
        
        // Поддержка динамических title тегов
        add_theme_support( 'title-tag' );
        
        // Поддержка миниатюр постов
        add_theme_support( 'post-thumbnails' );
        
        // Поддержка HTML5
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ) );
        
        // Поддержка кастомного логотипа
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );
        
        // Поддержка кастомного фона
        add_theme_support( 'custom-background', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) );
        
        // Поддержка выборочного обновления для Customizer
        add_theme_support( 'customize-selective-refresh-widgets' );
        
        // Поддержка Gutenberg
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'editor-styles' );
        add_theme_support( 'responsive-embeds' );
        
        // Цветовая палитра для Gutenberg
        add_theme_support( 'editor-color-palette', array(
            array(
                'name'  => esc_html__( 'Основной', 'yandexpro' ),
                'slug'  => 'primary',
                'color' => '#7c3aed',
            ),
            array(
                'name'  => esc_html__( 'Вторичный', 'yandexpro' ),
                'slug'  => 'secondary',
                'color' => '#64748b',
            ),
            array(
                'name'  => esc_html__( 'Акцентный', 'yandexpro' ),
                'slug'  => 'accent',
                'color' => '#ec4899',
            ),
            array(
                'name'  => esc_html__( 'Темный', 'yandexpro' ),
                'slug'  => 'dark',
                'color' => '#111827',
            ),
            array(
                'name'  => esc_html__( 'Светлый', 'yandexpro' ),
                'slug'  => 'light',
                'color' => '#f8fafc',
            ),
        ) );
        
        // Регистрация меню
        register_nav_menus( array(
            'primary' => esc_html__( 'Основное меню', 'yandexpro' ),
            'footer'  => esc_html__( 'Меню в футере', 'yandexpro' ),
        ) );
        
        // Размеры изображений
        add_image_size( 'yandexpro-featured', 800, 400, true );
        add_image_size( 'yandexpro-blog-thumb', 400, 250, true );
        add_image_size( 'yandexpro-small-thumb', 100, 100, true );
    }
    
    add_action( 'after_setup_theme', 'yandexpro_setup' );
}

/**
 * Регистрация областей виджетов
 */
function yandexpro_widgets_init() {
    // Основной сайдбар
    register_sidebar( array(
        'name'          => esc_html__( 'Основной сайдбар', 'yandexpro' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Добавьте виджеты в основной сайдбар.', 'yandexpro' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    // Футер виджеты
    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Футер %d', 'yandexpro' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'Добавьте виджеты в %d колонку футера.', 'yandexpro' ), $i ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }
}
add_action( 'widgets_init', 'yandexpro_widgets_init' );

/**
 * Базовое подключение стилей и скриптов (если модуль enqueue.php недоступен)
 */
if ( ! function_exists( 'yandexpro_scripts' ) ) {
    function yandexpro_scripts() {
        $theme_version = wp_get_theme()->get( 'Version' );
        
        // Основные стили
        wp_enqueue_style( 'yandexpro-style', get_stylesheet_uri(), array(), $theme_version );
        
        // Основной JavaScript
        wp_enqueue_script( 'yandexpro-script', get_template_directory_uri() . '/assets/js/script.js', array(), $theme_version, true );
        
        // Локализация скриптов
        wp_localize_script( 'yandexpro-script', 'yandexpro_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'yandexpro_nonce' ),
        ) );
        
        // Комментарии
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
    
    add_action( 'wp_enqueue_scripts', 'yandexpro_scripts' );
}

/**
 * Хелперы для дочерних тем
 */

if ( ! function_exists( 'yandexpro_get_theme_mod' ) ) {
    /**
     * Получение настроек темы с fallback
     *
     * @param string $setting Название настройки
     * @param mixed  $default Значение по умолчанию
     * @return mixed
     */
    function yandexpro_get_theme_mod( $setting, $default = false ) {
        return get_theme_mod( $setting, $default );
    }
}

if ( ! function_exists( 'yandexpro_is_blog' ) ) {
    /**
     * Проверка, находимся ли мы на странице блога
     *
     * @return bool
     */
    function yandexpro_is_blog() {
        return ( is_home() || is_archive() || is_category() || is_tag() || is_single() );
    }
}

if ( ! function_exists( 'yandexpro_get_reading_time' ) ) {
    /**
     * Расчет времени чтения статьи
     *
     * @param int $post_id ID поста
     * @return string
     */
    function yandexpro_get_reading_time( $post_id = null ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        
        $content = get_post_field( 'post_content', $post_id );
        $word_count = str_word_count( wp_strip_all_tags( $content ) );
        $reading_time = ceil( $word_count / 200 ); // 200 слов в минуту
        
        return sprintf(
            /* translators: %d: reading time in minutes */
            _n( '%d мин', '%d мин', $reading_time, 'yandexpro' ),
            $reading_time
        );
    }
}

/**
 * Отладочная информация (только в режиме разработки)
 */
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    function yandexpro_debug_info() {
        if ( current_user_can( 'manage_options' ) ) {
            $theme = wp_get_theme();
            printf(
                '<!-- YandexPro Enhanced v%s | WordPress %s | PHP %s -->',
                esc_html( $theme->get( 'Version' ) ),
                esc_html( get_bloginfo( 'version' ) ),
                esc_html( PHP_VERSION )
            );
        }
    }
    add_action( 'wp_head', 'yandexpro_debug_info', 999 );
}

/**
 * Активация темы
 */
function yandexpro_theme_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Устанавливаем значения по умолчанию для Customizer
    $defaults = array(
        'color_scheme'     => 'blue',
        'container_width'  => 1200,
        'show_sidebar'     => true,
        'header_style'     => 'default',
    );
    
    foreach ( $defaults as $setting => $value ) {
        if ( ! get_theme_mod( $setting ) ) {
            set_theme_mod( $setting, $value );
        }
    }
}
add_action( 'after_switch_theme', 'yandexpro_theme_activation' );

/**
 * Деактивация темы
 */
function yandexpro_theme_deactivation() {
    // Очищаем кеш
    if ( function_exists( 'wp_cache_flush' ) ) {
        wp_cache_flush();
    }
}
add_action( 'switch_theme', 'yandexpro_theme_deactivation' );

/**
 * Сообщение об успешной активации темы
 */
function yandexpro_admin_notice_activation() {
    if ( get_transient( 'yandexpro_activated' ) ) {
        printf(
            '<div class="notice notice-success is-dismissible">
                <p>%s <a href="%s">%s</a></p>
            </div>',
            esc_html__( 'Тема YandexPro Enhanced успешно активирована!', 'yandexpro' ),
            esc_url( admin_url( 'customize.php' ) ),
            esc_html__( 'Настроить тему', 'yandexpro' )
        );
        delete_transient( 'yandexpro_activated' );
    }
}
add_action( 'admin_notices', 'yandexpro_admin_notice_activation' );

// Устанавливаем транзиент при активации
add_action( 'after_switch_theme', function() {
    set_transient( 'yandexpro_activated', true, 30 );
} );