<?php
/**
 * YandexPro WordPress Theme Functions
 * ПОЛНАЯ РАБОЧАЯ ВЕРСИЯ
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

/**
 * Настройка темы после активации
 */
function yandexpro_setup() {
    // Поддержка переводов
    load_theme_textdomain('yandexpro', YANDEXPRO_DIR . '/languages');
    
    // Автоматические RSS фиды
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
    
    // Размеры изображений
    add_image_size('yandexpro-featured', 400, 240, true);
    add_image_size('yandexpro-small', 80, 80, true);
    add_image_size('yandexpro-card', 300, 180, true);
    
    // Регистрация меню
    register_nav_menus([
        'primary' => __('Основное меню', 'yandexpro'),
        'footer'  => __('Меню в футере', 'yandexpro'),
    ]);
}
add_action('after_setup_theme', 'yandexpro_setup');

/**
 * Подключение стилей и скриптов
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
    
    // Основной скрипт
    wp_enqueue_script(
        'yandexpro-script',
        YANDEXPRO_URL . '/assets/js/script.js',
        [],
        YANDEXPRO_VERSION,
        true
    );
    
    // Локализация для AJAX
    wp_localize_script('yandexpro-script', 'yandexpro_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('yandexpro_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'yandexpro_enqueue_assets');

/**
 * Регистрация областей виджетов
 */
function yandexpro_widgets_init() {
    // Сайдбар
    register_sidebar([
        'name'          => __('Сайдбар', 'yandexpro'),
        'id'            => 'sidebar-1',
        'description'   => __('Основной сайдбар', 'yandexpro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    
    // Футер виджеты
    for ($i = 1; $i <= 3; $i++) {
        register_sidebar([
            'name'          => sprintf(__('Футер %d', 'yandexpro'), $i),
            'id'            => 'footer-' . $i,
            'before_widget' => '<div class="footer-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="footer-title">',
            'after_title'   => '</h3>',
        ]);
    }
}
add_action('widgets_init', 'yandexpro_widgets_init');

/**
 * Обработка формы подписки на newsletter
 */
function yandexpro_newsletter_handler() {
    // Проверка nonce
    if (!isset($_POST['newsletter_nonce']) || 
        !wp_verify_nonce($_POST['newsletter_nonce'], 'yandexpro_newsletter')) {
        wp_die('Ошибка безопасности');
    }
    
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_redirect(add_query_arg('newsletter', 'error', wp_get_referer()));
        exit;
    }
    
    // Сохраняем email (простая реализация)
    $subscribers = get_option('yandexpro_subscribers', []);
    if (!in_array($email, $subscribers)) {
        $subscribers[] = $email;
        update_option('yandexpro_subscribers', $subscribers);
    }
    
    wp_redirect(add_query_arg('newsletter', 'success', wp_get_referer()));
    exit;
}
add_action('admin_post_yandexpro_newsletter', 'yandexpro_newsletter_handler');
add_action('admin_post_nopriv_yandexpro_newsletter', 'yandexpro_newsletter_handler');

/**
 * Показ сообщений newsletter
 */
function yandexpro_newsletter_messages() {
    if (!isset($_GET['newsletter'])) return;
    
    $message = '';
    switch ($_GET['newsletter']) {
        case 'success':
            $message = 'Спасибо за подписку!';
            break;
        case 'error':
            $message = 'Ошибка при подписке';
            break;
    }
    
    if ($message) {
        echo '<div class="newsletter-message">' . esc_html($message) . '</div>';
    }
}
add_action('wp_footer', 'yandexpro_newsletter_messages');

/**
 * ОТКЛЮЧЕНИЕ КЕША ДЛЯ РАЗРАБОТКИ
 */
function yandexpro_disable_cache() {
    // Отключаем WordPress кеш
    wp_cache_flush();
    
    // Добавляем timestamp к файлам
    add_filter('style_loader_src', function($src) {
        return add_query_arg('ver', time(), remove_query_arg('ver', $src));
    });
    
    add_filter('script_loader_src', function($src) {
        return add_query_arg('ver', time(), remove_query_arg('ver', $src));
    });
}
add_action('init', 'yandexpro_disable_cache');

/**
 * Очистка всех кешей при активации темы
 */
function yandexpro_flush_cache() {
    wp_cache_flush();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'yandexpro_flush_cache');

/**
 * Максимальная ширина контента
 */
if (!isset($content_width)) {
    $content_width = 1200;
}

/**
 * Дебаг информация для разработки
 */
function yandexpro_debug_info() {
    if (current_user_can('administrator')) {
        echo '<script>console.log("YandexPro Theme: Loaded successfully!");</script>';
        echo '<script>console.log("Template: ' . basename(get_page_template()) . '");</script>';
    }
}
add_action('wp_footer', 'yandexpro_debug_info');

/**
 * Добавляем favicon
 */
function yandexpro_favicon() {
    echo '<link rel="icon" href="data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><text y=\'0.9em\' font-size=\'90\'>📊</text></svg>">';
}
add_action('wp_head', 'yandexpro_favicon');

/**
 * Безопасность - убираем версию WordPress
 */
remove_action('wp_head', 'wp_generator');

/**
 * Отключаем emoji для производительности
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');