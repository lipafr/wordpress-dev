<?php
/**
 * Enqueue scripts and styles - МОДУЛЬНАЯ ВЕРСИЯ
 *
 * @package YandexPro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue theme assets
 */
function yandexpro_enqueue_assets() {
    
    // Google Fonts
    wp_enqueue_style(
        'yandexpro-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800&display=swap',
        [],
        null
    );
    
    // Основные стили темы
    wp_enqueue_style(
        'yandexpro-style',
        get_stylesheet_uri(),
        ['yandexpro-fonts'],
        YANDEXPRO_VERSION
    );
    
    // === CSS МОДУЛИ (условное подключение) ===
    
    // Header модуль (всегда)
    wp_enqueue_style(
        'yandexpro-header',
        YANDEXPRO_URL . '/assets/css/modules/header.css',
        ['yandexpro-style'],
        YANDEXPRO_VERSION
    );
    
    // Navigation модуль (всегда)
    wp_enqueue_style(
        'yandexpro-navigation',
        YANDEXPRO_URL . '/assets/css/modules/navigation.css',
        ['yandexpro-header'],
        YANDEXPRO_VERSION
    );
    
    // Mobile Menu модуль (всегда)
    wp_enqueue_style(
        'yandexpro-mobile-menu',
        YANDEXPRO_URL . '/assets/css/modules/mobile-menu.css',
        ['yandexpro-navigation'],
        YANDEXPRO_VERSION
    );
    
    // Hero модуль (только на главной)
    if (is_home() || is_front_page()) {
        wp_enqueue_style(
            'yandexpro-hero',
            YANDEXPRO_URL . '/assets/css/modules/hero.css',
            ['yandexpro-header'],
            YANDEXPRO_VERSION
        );
    }
    
    // Categories модуль (только на главной)
    if (is_home() || is_front_page()) {
        wp_enqueue_style(
            'yandexpro-categories',
            YANDEXPRO_URL . '/assets/css/modules/categories.css',
            ['yandexpro-style'],
            YANDEXPRO_VERSION
        );
    }
    
    // Blog модуль (только на страницах блога)
    if (is_home() || is_single() || is_category() || is_tag() || is_archive()) {
        wp_enqueue_style(
            'yandexpro-blog',
            YANDEXPRO_URL . '/assets/css/modules/blog.css',
            ['yandexpro-style'],
            YANDEXPRO_VERSION
        );
    }
    
    // === JAVASCRIPT МОДУЛИ ===
    
    // Mobile Menu модуль (всегда для мобильных)
    wp_enqueue_script(
        'yandexpro-mobile-menu',
        YANDEXPRO_URL . '/assets/js/modules/mobile-menu.js',
        [],
        YANDEXPRO_VERSION,
        true
    );
    
    // Categories модуль (только на главной)
    if (is_home() || is_front_page()) {
        wp_enqueue_script(
            'yandexpro-categories',
            YANDEXPRO_URL . '/assets/js/modules/categories.js',
            [],
            YANDEXPRO_VERSION,
            true
        );
    }
    
    // Header Scroll эффекты (всегда)
    wp_enqueue_script(
        'yandexpro-header-scroll',
        YANDEXPRO_URL . '/assets/js/modules/header-scroll.js',
        [],
        YANDEXPRO_VERSION,
        true
    );
    
    // Search модуль (только на главной)
    if (is_home() || is_front_page()) {
        wp_enqueue_script(
            'yandexpro-search',
            YANDEXPRO_URL . '/assets/js/modules/search.js',
            [],
            YANDEXPRO_VERSION,
            true
        );
        
        // Локализация для поиска
        wp_localize_script('yandexpro-search', 'yandexproSearch', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('yandexpro_search_nonce'),
            'strings' => [
                'no_results' => __('Ничего не найдено', 'yandexpro'),
                'search_placeholder' => __('Введите запрос...', 'yandexpro')
            ]
        ]);
    }
    
    // Основной скрипт темы (если есть дополнительная логика)
    if (file_exists(YANDEXPRO_DIR . '/assets/js/script.js')) {
        wp_enqueue_script(
            'yandexpro-script',
            YANDEXPRO_URL . '/assets/js/script.js',
            ['yandexpro-mobile-menu'],
            YANDEXPRO_VERSION,
            true
        );
        
        // Локализация для основного скрипта
        wp_localize_script('yandexpro-script', 'yandexproData', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('yandexpro_nonce'),
            'home_url' => home_url('/'),
            'is_admin' => current_user_can('administrator')
        ]);
    }
}
add_action('wp_enqueue_scripts', 'yandexpro_enqueue_assets');

/**
 * Добавляем критические inline стили для производительности
 */
function yandexpro_critical_css() {
    // Критические стили только для header (чтобы избежать FOUC)
    echo '<style id="yandexpro-critical">
    .site-header{position:fixed;top:0;left:0;right:0;z-index:99999;background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);border-bottom:1px solid rgba(17,24,39,0.08);}
    .admin-bar .site-header{top:32px;}
    body{padding-top:80px;}
    .admin-bar body{padding-top:112px;}
    @media (max-width:768px){body{padding-top:70px;}.admin-bar body{padding-top:116px;}.admin-bar .site-header{top:46px;}}
    </style>';
}
add_action('wp_head', 'yandexpro_critical_css', 1);

/**
 * Добавляем module type для современных браузеров
 */
function yandexpro_add_module_type($tag, $handle, $src) {
    // Список скриптов которые должны быть модулями
    $module_scripts = [
        'yandexpro-mobile-menu',
        'yandexpro-categories',
        'yandexpro-search'
    ];
    
    if (in_array($handle, $module_scripts)) {
        $tag = str_replace('<script ', '<script type="module" ', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'yandexpro_add_module_type', 10, 3);

/**
 * Preload важных ресурсов
 */
function yandexpro_preload_resources() {
    // Preload Google Fonts
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800&display=swap" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
    echo '<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800&display=swap"></noscript>';
    
    // Preload критических CSS модулей
    if (file_exists(YANDEXPRO_DIR . '/assets/css/modules/header.css')) {
        echo '<link rel="preload" href="' . YANDEXPRO_URL . '/assets/css/modules/header.css" as="style">';
    }
}
add_action('wp_head', 'yandexpro_preload_resources', 1);