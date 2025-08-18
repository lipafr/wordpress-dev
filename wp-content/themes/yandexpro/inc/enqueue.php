<?php
/**
 * Управление подключением стилей и скриптов
 * YandexPro Enhanced Theme
 *
 * @package YandexPro_Enhanced
 */

// Блокируем прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Подключение стилей и скриптов на фронтенде
 */
function yandexpro_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );
    $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    /*
     * === СТИЛИ ===
     */

    // Google Fonts
    $fonts_url = yandexpro_fonts_url();
    if ( $fonts_url ) {
        wp_enqueue_style(
            'yandexpro-fonts',
            $fonts_url,
            array(),
            null // Не версионируем внешние шрифты
        );
    }

    // Основной стиль темы
    wp_enqueue_style(
        'yandexpro-style',
        get_stylesheet_uri(),
        array( 'yandexpro-fonts' ),
        $theme_version
    );

    // Критические стили (если файл существует)
    $critical_css = get_template_directory() . '/assets/css/critical' . $min . '.css';
    if ( file_exists( $critical_css ) ) {
        wp_enqueue_style(
            'yandexpro-critical',
            get_template_directory_uri() . '/assets/css/critical' . $min . '.css',
            array(),
            $theme_version
        );
        
        // Приоритет для критических стилей
        wp_style_add_data( 'yandexpro-critical', 'priority', 'high' );
    }

    // Темная тема (если включена)
    if ( get_theme_mod( 'dark_mode_enabled', false ) ) {
        wp_enqueue_style(
            'yandexpro-dark-theme',
            get_template_directory_uri() . '/assets/css/modules/dark-theme' . $min . '.css',
            array( 'yandexpro-style' ),
            $theme_version
        );
    }

    // Условные стили для разных страниц
    yandexpro_conditional_styles( $min, $theme_version );

    /*
     * === СКРИПТЫ ===
     */

    // Основной JavaScript
    wp_enqueue_script(
        'yandexpro-script',
        get_template_directory_uri() . '/assets/js/script' . $min . '.js',
        array(), // Не используем jQuery
        $theme_version,
        true // В футере
    );

    // Навигация (мобильное меню)
    wp_enqueue_script(
        'yandexpro-navigation',
        get_template_directory_uri() . '/assets/js/navigation' . $min . '.js',
        array(),
        $theme_version,
        true
    );

    // Условные скрипты
    yandexpro_conditional_scripts( $min, $theme_version );

    // Локализация основного скрипта
    wp_localize_script( 'yandexpro-script', 'yandexpro_ajax', array(
        'ajax_url'       => admin_url( 'admin-ajax.php' ),
        'nonce'          => wp_create_nonce( 'yandexpro_nonce' ),
        'home_url'       => home_url( '/' ),
        'theme_url'      => get_template_directory_uri(),
        'is_customize'   => is_customize_preview(),
        'strings'        => array(
            'search_placeholder' => esc_html__( 'Поиск по сайту...', 'yandexpro' ),
            'no_results'        => esc_html__( 'Ничего не найдено', 'yandexpro' ),
            'loading'           => esc_html__( 'Загрузка...', 'yandexpro' ),
            'error'             => esc_html__( 'Произошла ошибка', 'yandexpro' ),
            'close'             => esc_html__( 'Закрыть', 'yandexpro' ),
            'menu_toggle'       => esc_html__( 'Открыть меню', 'yandexpro' ),
        ),
    ) );

    // Скрипт комментариев (только на страницах с комментариями)
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'yandexpro_scripts' );

/**
 * Условное подключение стилей в зависимости от типа страницы
 */
function yandexpro_conditional_styles( $min, $theme_version ) {
    // Стили для блога
    if ( is_home() || is_archive() || is_single() || is_search() ) {
        wp_enqueue_style(
            'yandexpro-blog',
            get_template_directory_uri() . '/assets/css/modules/blog' . $min . '.css',
            array( 'yandexpro-style' ),
            $theme_version
        );
    }

    // Стили для лендингов
    if ( is_page_template( array(
        'page-templates/page-landing.php',
        'page-templates/page-landing-alt.php'
    ) ) || is_front_page() ) {
        wp_enqueue_style(
            'yandexpro-landing',
            get_template_directory_uri() . '/assets/css/modules/landing' . $min . '.css',
            array( 'yandexpro-style' ),
            $theme_version
        );
    }

    // Стили для страницы контактов
    if ( is_page_template( 'page-templates/page-contact.php' ) ) {
        wp_enqueue_style(
            'yandexpro-contact',
            get_template_directory_uri() . '/assets/css/modules/contact' . $min . '.css',
            array( 'yandexpro-style' ),
            $theme_version
        );
    }

    // Стили для 404 страницы
    if ( is_404() ) {
        wp_enqueue_style(
            'yandexpro-404',
            get_template_directory_uri() . '/assets/css/modules/404' . $min . '.css',
            array( 'yandexpro-style' ),
            $theme_version
        );
    }

    // Print стили
    wp_enqueue_style(
        'yandexpro-print',
        get_template_directory_uri() . '/assets/css/print' . $min . '.css',
        array( 'yandexpro-style' ),
        $theme_version,
        'print'
    );
}

/**
 * Условное подключение скриптов
 */
function yandexpro_conditional_scripts( $min, $theme_version ) {
    // Lazy loading изображений (если не поддерживается браузером)
    wp_enqueue_script(
        'yandexpro-lazy-loading',
        get_template_directory_uri() . '/assets/js/modules/lazy-loading' . $min . '.js',
        array(),
        $theme_version,
        true
    );

    // Переключатель темной темы
    if ( get_theme_mod( 'dark_mode_toggle', false ) ) {
        wp_enqueue_script(
            'yandexpro-dark-mode',
            get_template_directory_uri() . '/assets/js/modules/dark-mode' . $min . '.js',
            array(),
            $theme_version,
            true
        );
    }

    // Скрипт форм (только на страницах с формами)
    if ( is_page_template( 'page-templates/page-contact.php' ) || 
         has_shortcode( get_post()->post_content ?? '', 'contact-form-7' ) ) {
        wp_enqueue_script(
            'yandexpro-forms',
            get_template_directory_uri() . '/assets/js/modules/forms' . $min . '.js',
            array(),
            $theme_version,
            true
        );
    }

    // Анимации при скролле (только если не отключены в настройках)
    if ( ! get_theme_mod( 'disable_animations', false ) ) {
        wp_enqueue_script(
            'yandexpro-animations',
            get_template_directory_uri() . '/assets/js/modules/animations' . $min . '.js',
            array(),
            $theme_version,
            true
        );
    }

    // Поиск (только если включен в настройках)
    if ( get_theme_mod( 'enable_ajax_search', false ) ) {
        wp_enqueue_script(
            'yandexpro-search',
            get_template_directory_uri() . '/assets/js/modules/search' . $min . '.js',
            array( 'yandexpro-script' ),
            $theme_version,
            true
        );
    }
}

/**
 * Подключение стилей для Gutenberg редактора
 */
function yandexpro_editor_scripts() {
    $theme_version = wp_get_theme()->get( 'Version' );
    $min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Google Fonts для редактора
    $fonts_url = yandexpro_fonts_url();
    if ( $fonts_url ) {
        wp_enqueue_style(
            'yandexpro-editor-fonts',
            $fonts_url,
            array(),
            null
        );
    }

    // Стили редактора
    wp_enqueue_style(
        'yandexpro-editor-style',
        get_template_directory_uri() . '/assets/css/editor' . $min . '.css',
        array( 'yandexpro-editor-fonts' ),
        $theme_version
    );

    // Скрипты редактора (если нужны)
    if ( file_exists( get_template_directory() . '/assets/js/editor' . $min . '.js' ) ) {
        wp_enqueue_script(
            'yandexpro-editor-script',
            get_template_directory_uri() . '/assets/js/editor' . $min . '.js',
            array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
            $theme_version,
            true
        );
    }
}
add_action( 'enqueue_block_editor_assets', 'yandexpro_editor_scripts' );

/**
 * Стили для админки
 */
function yandexpro_admin_scripts( $hook ) {
    // Только на страницах темы в админке
    if ( ! in_array( $hook, array( 'appearance_page_theme-options', 'customize.php' ) ) ) {
        return;
    }

    $theme_version = wp_get_theme()->get( 'Version' );
    
    wp_enqueue_style(
        'yandexpro-admin',
        get_template_directory_uri() . '/assets/css/admin.css',
        array(),
        $theme_version
    );

    wp_enqueue_script(
        'yandexpro-admin',
        get_template_directory_uri() . '/assets/js/admin.js',
        array( 'jquery' ),
        $theme_version,
        true
    );
}
add_action( 'admin_enqueue_scripts', 'yandexpro_admin_scripts' );

/**
 * Оптимизация загрузки стилей
 */
function yandexpro_style_loader_tag( $html, $handle ) {
    // Критические стили загружаем синхронно
    if ( 'yandexpro-critical' === $handle ) {
        return $html;
    }

    // Некритические стили загружаем асинхронно
    $async_styles = array(
        'yandexpro-blog',
        'yandexpro-landing',
        'yandexpro-contact',
        'yandexpro-dark-theme'
    );

    if ( in_array( $handle, $async_styles ) ) {
        $html = str_replace( "rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $html );
        $html .= '<noscript>' . str_replace( "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", "rel='stylesheet'", $html ) . '</noscript>';
    }

    return $html;
}
add_filter( 'style_loader_tag', 'yandexpro_style_loader_tag', 10, 2 );

/**
 * Добавление атрибутов defer для неблокирующих скриптов
 */
function yandexpro_script_loader_tag( $tag, $handle ) {
    // Скрипты, которые можно загружать с defer
    $defer_scripts = array(
        'yandexpro-animations',
        'yandexpro-dark-mode',
        'yandexpro-lazy-loading'
    );

    if ( in_array( $handle, $defer_scripts ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'yandexpro_script_loader_tag', 10, 2 );

/**
 * Preload критических ресурсов
 */
function yandexpro_resource_hints( $urls, $relation_type ) {
    if ( 'preload' === $relation_type ) {
        // Preload главного CSS
        $urls[] = array(
            'href' => get_stylesheet_uri(),
            'as'   => 'style',
        );

        // Preload Google Fonts
        $fonts_url = yandexpro_fonts_url();
        if ( $fonts_url ) {
            $urls[] = array(
                'href'        => $fonts_url,
                'as'          => 'style',
                'crossorigin' => 'anonymous',
            );
        }

        // Preload логотипа
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        if ( $custom_logo_id ) {
            $logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
            if ( $logo_url ) {
                $urls[] = array(
                    'href' => $logo_url,
                    'as'   => 'image',
                );
            }
        }
    }

    if ( 'dns-prefetch' === $relation_type ) {
        // DNS prefetch для внешних доменов
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = 'https://fonts.gstatic.com';
    }

    return $urls;
}
add_filter( 'wp_resource_hints', 'yandexpro_resource_hints', 10, 2 );

/**
 * Встраивание критического CSS в head (для самых важных стилей)
 */
function yandexpro_inline_critical_css() {
    // Только на главной странице
    if ( ! is_front_page() ) {
        return;
    }

    $critical_css_file = get_template_directory() . '/assets/css/critical-inline.css';
    
    if ( file_exists( $critical_css_file ) ) {
        $critical_css = file_get_contents( $critical_css_file );
        if ( $critical_css ) {
            echo '<style id="yandexpro-critical-css">' . $critical_css . '</style>';
        }
    }
}
add_action( 'wp_head', 'yandexpro_inline_critical_css', 1 );

/**
 * Удаление ненужных стилей и скриптов WordPress
 */
function yandexpro_remove_default_scripts() {
    // Удаляем emoji скрипты (если отключены в настройках)
    if ( get_theme_mod( 'disable_emojis', false ) ) {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
    }

    // Удаляем WP embed скрипт (если не нужен)
    if ( get_theme_mod( 'disable_wp_embed', false ) ) {
        wp_deregister_script( 'wp-embed' );
    }

    // Удаляем блочные стили (если есть кастомные)
    if ( get_theme_mod( 'disable_block_styles', false ) ) {
        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
    }
}
add_action( 'wp_enqueue_scripts', 'yandexpro_remove_default_scripts', 100 );

/**
 * Добавляем версию темы как параметр к стилям для cache busting
 */
function yandexpro_add_version_to_assets( $src, $handle ) {
    // Только для наших стилей
    if ( strpos( $handle, 'yandexpro-' ) === 0 ) {
        $theme_version = wp_get_theme()->get( 'Version' );
        return add_query_arg( 'ver', $theme_version, $src );
    }
    
    return $src;
}
add_filter( 'style_loader_src', 'yandexpro_add_version_to_assets', 10, 2 );
add_filter( 'script_loader_src', 'yandexpro_add_version_to_assets', 10, 2 );

/**
 * Оптимизация для Customizer preview
 */
function yandexpro_customize_preview_scripts() {
    wp_enqueue_script(
        'yandexpro-customizer',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array( 'customize-preview' ),
        wp_get_theme()->get( 'Version' ),
        true
    );
}
add_action( 'customize_preview_init', 'yandexpro_customize_preview_scripts' );

/**
 * Подключение Service Worker (если включен в настройках)
 */
function yandexpro_service_worker() {
    if ( get_theme_mod( 'enable_service_worker', false ) && file_exists( get_template_directory() . '/sw.js' ) ) {
        echo "<script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('" . get_template_directory_uri() . "/sw.js');
            }
        </script>";
    }
}
add_action( 'wp_footer', 'yandexpro_service_worker' );