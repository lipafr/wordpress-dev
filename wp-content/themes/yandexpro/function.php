<?php
/**
 * YandexPro Enhanced Theme Functions
 * Модульная WordPress тема для блога о Яндекс Директ
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Запретить прямой доступ
if (!defined('ABSPATH')) {
    exit;
}

// Константы темы
define('YANDEXPRO_VERSION', '1.0.0');
define('YANDEXPRO_DIR', get_template_directory());
define('YANDEXPRO_URL', get_template_directory_uri());
define('YANDEXPRO_INC_DIR', YANDEXPRO_DIR . '/inc');

/**
 * Модульная система загрузки
 * Начинаем с критически важных модулей
 */
function yandexpro_load_modules() {
    $modules = [
        'setup',             // Базовые настройки темы (первый!)
        'enqueue',           // Подключение CSS/JS (второй!)
        'template-functions', // Вспомогательные функции
        'newsletter'         // Newsletter функциональность
    ];
    
    foreach ($modules as $module) {
        $file = YANDEXPRO_INC_DIR . '/' . $module . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

// Загружаем модули
yandexpro_load_modules();

/**
 * После активации темы
 */
function yandexpro_after_setup_theme() {
    // Включаем поддержку переводов
    load_theme_textdomain('yandexpro', YANDEXPRO_DIR . '/languages');
    
    // Автоматические фиды
    add_theme_support('automatic-feed-links');
    
    // Title tag поддержка
    add_theme_support('title-tag');
    
    // Миниатюры постов
    add_theme_support('post-thumbnails');
    
    // HTML5 разметка
    add_theme_support('html5', [
        'search-form',
        'comment-form', 
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    
    // Размеры изображений для блога
    add_image_size('yandexpro-featured', 400, 240, true);      // Главная статья
    add_image_size('yandexpro-small', 80, 80, true);           // Боковые статьи
    add_image_size('yandexpro-card', 300, 180, true);          // Карточки статей
}
add_action('after_setup_theme', 'yandexpro_after_setup_theme');

/**
 * Максимальная ширина контента (из макета)
 */
if (!isset($content_width)) {
    $content_width = 1200;
}

<?php
// ДОБАВИТЬ В КОНЕЦ functions.php ДЛЯ ОТКЛЮЧЕНИЯ КЕША

/**
 * Отключение кеша для разработки
 */
function yandexpro_disable_cache_dev() {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return; // Работает только при включенном WP_DEBUG
    }
    
    // Отключаем WordPress кеш
    if (!defined('WP_CACHE')) {
        define('WP_CACHE', false);
    }
    
    // Принудительная перезагрузка файлов
    add_filter('style_loader_src', 'yandexpro_remove_cache_version', 10, 2);
    add_filter('script_loader_src', 'yandexpro_remove_cache_version', 10, 2);
}
add_action('init', 'yandexpro_disable_cache_dev', 1);

/**
 * Добавляет timestamp к CSS/JS для принудительной перезагрузки
 */
function yandexpro_remove_cache_version($src, $handle) {
    if (strpos($src, '?ver=') !== false) {
        $src = remove_query_arg('ver', $src);
    }
    
    // Добавляем текущее время для принудительного обновления
    $src = add_query_arg('bust', time(), $src);
    
    return $src;
}

/**
 * Очистка всех кешей WordPress
 */
function yandexpro_flush_all_cache() {
    // Очищаем объектный кеш
    wp_cache_flush();
    
    // Очищаем кеш базы данных
    if (function_exists('wp_cache_delete_group')) {
        wp_cache_delete_group('posts');
        wp_cache_delete_group('options');
        wp_cache_delete_group('themes');
    }
    
    // Очищаем кеш ревизий
    wp_suspend_cache_addition(true);
    wp_suspend_cache_invalidation(true);
}

// Очищаем кеш при каждом обновлении темы
add_action('switch_theme', 'yandexpro_flush_all_cache');
add_action('after_switch_theme', 'yandexpro_flush_all_cache');

/**
 * ЭКСТРЕННАЯ ФУНКЦИЯ - принудительная загрузка нового index.php
 */
function yandexpro_force_template_refresh() {
    // Убираем из кеша все шаблоны
    wp_cache_delete('get_template_directory', 'options');
    wp_cache_delete('stylesheet_directory', 'options');
    
    // Принудительно обновляем файлы темы
    if (function_exists('wp_cache_delete')) {
        wp_cache_delete('theme_roots', 'options');
        wp_cache_delete('theme_files', 'options');
    }
}
add_action('wp_loaded', 'yandexpro_force_template_refresh');

// ДЕБАГ информация - показывает какой файл загружается
function yandexpro_debug_template() {
    if (current_user_can('administrator')) {
        global $template;
        echo '<script>console.log("Template loaded: ' . basename($template) . '");</script>';
        echo '<script>console.log("Theme path: ' . get_template_directory() . '");</script>';
    }
}
add_action('wp_footer', 'yandexpro_debug_template');