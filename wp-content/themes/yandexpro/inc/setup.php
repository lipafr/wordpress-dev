<?php
/**
 * Базовые настройки темы YandexPro
 * Регистрация меню, виджетов, настройки WordPress
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Запретить прямой доступ
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Регистрация меню навигации
 */
function yandexpro_register_nav_menus() {
    register_nav_menus([
        'primary' => esc_html__('Основное меню', 'yandexpro'),
        'mobile'  => esc_html__('Мобильное меню', 'yandexpro'),
        'footer'  => esc_html__('Меню в футере', 'yandexpro'),
    ]);
}
add_action('init', 'yandexpro_register_nav_menus');

/**
 * Регистрация областей виджетов
 */
function yandexpro_widgets_init() {
    // Сайдбар блога
    register_sidebar([
        'name'          => esc_html__('Сайдбар блога', 'yandexpro'),
        'id'            => 'blog-sidebar',
        'description'   => esc_html__('Виджеты для боковой панели блога', 'yandexpro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    // Футер - 3 колонки (как в макете)
    for ($i = 1; $i <= 3; $i++) {
        register_sidebar([
            'name'          => sprintf(esc_html__('Футер - Колонка %d', 'yandexpro'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(esc_html__('Виджеты для %d колонки футера', 'yandexpro'), $i),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
add_action('widgets_init', 'yandexpro_widgets_init');

/**
 * Настройки контента и excerpts
 */
function yandexpro_content_setup() {
    // Длина excerpt для карточек постов
    function yandexpro_excerpt_length($length) {
        return 25; // Оптимально для карточек
    }
    add_filter('excerpt_length', 'yandexpro_excerpt_length');

    // Окончание excerpt
    function yandexpro_excerpt_more($more) {
        return '...';
    }
    add_filter('excerpt_more', 'yandexpro_excerpt_more');
}
add_action('init', 'yandexpro_content_setup');

/**
 * Поддержка кастомных размеров изображений для редактора
 */
function yandexpro_custom_image_sizes() {
    add_filter('image_size_names_choose', function($sizes) {
        return array_merge($sizes, [
            'yandexpro-featured' => esc_html__('Главная статья (400x240)', 'yandexpro'),
            'yandexpro-small'    => esc_html__('Боковая статья (80x80)', 'yandexpro'),
            'yandexpro-card'     => esc_html__('Карточка поста (300x180)', 'yandexpro'),
        ]);
    });
}
add_action('init', 'yandexpro_custom_image_sizes');

/**
 * Кастомные настройки для блога
 */
function yandexpro_blog_setup() {
    // Поддержка форматов постов (если понадобится)
    add_theme_support('post-formats', [
        'aside',
        'gallery',
        'quote',
        'video',
        'audio'
    ]);

    // Кастомный логотип
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
        'header-text' => ['site-title', 'site-description'],
    ]);

    // Кастомный фон
    add_theme_support('custom-background', [
        'default-color' => 'ffffff',
    ]);

    // Селективное обновление Customizer
    add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'yandexpro_blog_setup');

/**
 * Оптимизация WordPress для блога
 */
function yandexpro_wordpress_optimizations() {
    // Удаляем ненужные meta теги
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    
    // Убираем emoji scripts (экономим HTTP запросы)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    
    // Отключаем XML-RPC (безопасность)
    add_filter('xmlrpc_enabled', '__return_false');
    
    // Скрываем версию WordPress
    function yandexpro_remove_version_strings($src) {
        global $wp_version;
        parse_str(parse_url($src, PHP_URL_QUERY), $query);
        if (isset($query['ver']) && $query['ver'] === $wp_version) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
    add_filter('script_loader_src', 'yandexpro_remove_version_strings');
    add_filter('style_loader_src', 'yandexpro_remove_version_strings');
}
add_action('init', 'yandexpro_wordpress_optimizations');

/**
 * Безопасность и SEO
 */
function yandexpro_security_seo() {
    // Убираем автора из REST API (безопасность)
    add_filter('rest_prepare_user', function($response, $user, $request) {
        if (!current_user_can('list_users')) {
            $response->data = [];
        }
        return $response;
    }, 10, 3);
    
    // Добавляем мета теги для лучшего SEO
    function yandexpro_add_meta_tags() {
        if (is_single() || is_page()) {
            global $post;
            if (has_excerpt($post->ID)) {
                echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags(get_the_excerpt($post->ID))) . '">' . "\n";
            }
        }
    }
    add_action('wp_head', 'yandexpro_add_meta_tags');
}
add_action('init', 'yandexpro_security_seo');

/**
 * Поддержка редактора блоков (Gutenberg)
 */
function yandexpro_gutenberg_setup() {
    // Поддержка широких и полноширинных блоков
    add_theme_support('align-wide');
    
    // Кастомные цвета редактора (из дизайн-системы)
    add_theme_support('editor-color-palette', [
        [
            'name'  => esc_html__('Основной фиолетовый', 'yandexpro'),
            'slug'  => 'primary',
            'color' => '#7c3aed',
        ],
        [
            'name'  => esc_html__('Акцентный розовый', 'yandexpro'),
            'slug'  => 'accent', 
            'color' => '#ec4899',
        ],
        [
            'name'  => esc_html__('Светло-серый', 'yandexpro'),
            'slug'  => 'light',
            'color' => '#f8fafc',
        ],
        [
            'name'  => esc_html__('Темно-серый', 'yandexpro'),
            'slug'  => 'dark',
            'color' => '#1e293b',
        ],
    ]);

    // Размеры шрифтов редактора
    add_theme_support('editor-font-sizes', [
        [
            'name' => esc_html__('Маленький', 'yandexpro'),
            'size' => 14,
            'slug' => 'small'
        ],
        [
            'name' => esc_html__('Обычный', 'yandexpro'),
            'size' => 16,
            'slug' => 'normal'
        ],
        [
            'name' => esc_html__('Большой', 'yandexpro'),
            'size' => 20,
            'slug' => 'large'
        ],
        [
            'name' => esc_html__('Очень большой', 'yandexpro'),
            'size' => 24,
            'slug' => 'huge'
        ]
    ]);
}
add_action('after_setup_theme', 'yandexpro_gutenberg_setup');