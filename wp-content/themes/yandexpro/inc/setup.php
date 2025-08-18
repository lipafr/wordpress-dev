<?php
/**
 * Расширенная настройка темы YandexPro Enhanced
 *
 * @package YandexPro_Enhanced
 */

// Блокируем прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Основная настройка темы
 */
function yandexpro_setup() {
    /*
     * Поддержка переводов
     * Ищет переводы в /languages/
     */
    load_theme_textdomain( 'yandexpro', get_template_directory() . '/languages' );

    /*
     * Поддержка автоматических RSS ссылок в <head>
     */
    add_theme_support( 'automatic-feed-links' );

    /*
     * Поддержка динамических title тегов
     * WordPress будет управлять тегом <title>
     */
    add_theme_support( 'title-tag' );

    /*
     * Поддержка миниатюр постов
     */
    add_theme_support( 'post-thumbnails' );

    /*
     * Кастомные размеры изображений
     */
    // Большое изображение для featured статей
    add_image_size( 'yandexpro-featured-large', 800, 400, true );
    
    // Стандартная миниатюра для блога
    add_image_size( 'yandexpro-blog-thumb', 400, 250, true );
    
    // Маленькая миниатюра для сайдбара
    add_image_size( 'yandexpro-small-thumb', 100, 100, true );
    
    // Квадратная миниатюра для карточек
    add_image_size( 'yandexpro-card-thumb', 300, 300, true );
    
    // Hero изображения
    add_image_size( 'yandexpro-hero', 1200, 600, true );

    /*
     * Регистрация навигационных меню
     */
    register_nav_menus( array(
        'primary' => esc_html__( 'Основное меню', 'yandexpro' ),
        'footer'  => esc_html__( 'Меню в подвале', 'yandexpro' ),
        'social'  => esc_html__( 'Социальные ссылки', 'yandexpro' ),
    ) );

    /*
     * Поддержка HTML5 разметки
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ) );

    /*
     * Поддержка кастомного логотипа
     */
    add_theme_support( 'custom-logo', array(
        'height'               => 250,
        'width'                => 250,
        'flex-width'           => true,
        'flex-height'          => true,
        'header-text'          => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => false,
    ) );

    /*
     * Поддержка кастомного фона
     */
    add_theme_support( 'custom-background', array(
        'default-color'      => 'ffffff',
        'default-image'      => '',
        'default-preset'     => 'default',
        'default-position-x' => 'left',
        'default-position-y' => 'top',
        'default-size'       => 'auto',
        'default-repeat'     => 'repeat',
        'default-attachment' => 'scroll',
    ) );

    /*
     * Поддержка выборочного обновления в Customizer
     */
    add_theme_support( 'customize-selective-refresh-widgets' );

    /*
     * === GUTENBERG ПОДДЕРЖКА ===
     */
    
    /*
     * Поддержка стилей блоков
     */
    add_theme_support( 'wp-block-styles' );

    /*
     * Поддержка широкого выравнивания блоков
     */
    add_theme_support( 'align-wide' );

    /*
     * Поддержка стилей редактора
     */
    add_theme_support( 'editor-styles' );

    /*
     * Адаптивные встраивания
     */
    add_theme_support( 'responsive-embeds' );

    /*
     * Поддержка темной темы в редакторе
     */
    add_theme_support( 'dark-editor-style' );

    /*
     * Цветовая палитра для Gutenberg
     */
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => esc_html__( 'Основной синий', 'yandexpro' ),
            'slug'  => 'primary',
            'color' => '#7c3aed',
        ),
        array(
            'name'  => esc_html__( 'Вторичный серый', 'yandexpro' ),
            'slug'  => 'secondary',
            'color' => '#64748b',
        ),
        array(
            'name'  => esc_html__( 'Акцентный розовый', 'yandexpro' ),
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
        array(
            'name'  => esc_html__( 'Белый', 'yandexpro' ),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
        array(
            'name'  => esc_html__( 'Черный', 'yandexpro' ),
            'slug'  => 'black',
            'color' => '#000000',
        ),
        array(
            'name'  => esc_html__( 'Успех', 'yandexpro' ),
            'slug'  => 'success',
            'color' => '#10b981',
        ),
        array(
            'name'  => esc_html__( 'Предупреждение', 'yandexpro' ),
            'slug'  => 'warning',
            'color' => '#f59e0b',
        ),
        array(
            'name'  => esc_html__( 'Ошибка', 'yandexpro' ),
            'slug'  => 'error',
            'color' => '#ef4444',
        ),
    ) );

    /*
     * Размеры шрифтов для Gutenberg
     */
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => esc_html__( 'Очень маленький', 'yandexpro' ),
            'size' => 12,
            'slug' => 'very-small'
        ),
        array(
            'name' => esc_html__( 'Маленький', 'yandexpro' ),
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => esc_html__( 'Средний', 'yandexpro' ),
            'size' => 16,
            'slug' => 'medium'
        ),
        array(
            'name' => esc_html__( 'Большой', 'yandexpro' ),
            'size' => 18,
            'slug' => 'large'
        ),
        array(
            'name' => esc_html__( 'Очень большой', 'yandexpro' ),
            'size' => 24,
            'slug' => 'very-large'
        ),
        array(
            'name' => esc_html__( 'Огромный', 'yandexpro' ),
            'size' => 32,
            'slug' => 'huge'
        ),
        array(
            'name' => esc_html__( 'Гигантский', 'yandexpro' ),
            'size' => 48,
            'slug' => 'gigantic'
        ),
    ) );

    /*
     * Отключение кастомных цветов (пользователи могут использовать только палитру)
     */
    add_theme_support( 'disable-custom-colors' );

    /*
     * Отключение кастомных размеров шрифтов
     */
    add_theme_support( 'disable-custom-font-sizes' );

    /*
     * Поддержка экспериментальных возможностей
     */
    add_theme_support( 'experimental-link-color' );

    /*
     * Ширина контента для Gutenberg
     */
    $GLOBALS['content_width'] = apply_filters( 'yandexpro_content_width', 768 );
}
add_action( 'after_setup_theme', 'yandexpro_setup' );

/**
 * Настройка ширины контента
 */
function yandexpro_content_width() {
    $content_width = $GLOBALS['content_width'];

    // Более широкий контент для полноширинных шаблонов
    if ( is_page_template( array(
        'page-templates/page-landing.php',
        'page-templates/page-fullwidth.php'
    ) ) ) {
        $content_width = 1200;
    }

    // Узкий контент для сайдбара
    if ( is_active_sidebar( 'sidebar-1' ) && ! is_page_template( array(
        'page-templates/page-landing.php',
        'page-templates/page-fullwidth.php'
    ) ) ) {
        $content_width = 640;
    }

    $GLOBALS['content_width'] = apply_filters( 'yandexpro_content_width', $content_width );
}
add_action( 'template_redirect', 'yandexpro_content_width', 0 );

/**
 * Добавляем стили редактора
 */
function yandexpro_add_editor_styles() {
    add_editor_style( array(
        'assets/css/editor.css',
        yandexpro_fonts_url(),
    ) );
}
add_action( 'after_setup_theme', 'yandexpro_add_editor_styles' );

/**
 * Регистрация областей виджетов
 */
function yandexpro_widgets_init() {
    // Основной сайдбар
    register_sidebar( array(
        'name'          => esc_html__( 'Основной сайдбар', 'yandexpro' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Основная область виджетов, отображается справа от контента.', 'yandexpro' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    // Футер виджеты - 3 колонки
    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Футер %d', 'yandexpro' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'Виджеты для %d колонки в подвале сайта.', 'yandexpro' ), $i ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }

    // Область виджетов на главной странице
    register_sidebar( array(
        'name'          => esc_html__( 'Главная страница', 'yandexpro' ),
        'id'            => 'homepage-widgets',
        'description'   => esc_html__( 'Виджеты для главной страницы.', 'yandexpro' ),
        'before_widget' => '<section id="%1$s" class="widget homepage-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Область виджетов перед футером
    register_sidebar( array(
        'name'          => esc_html__( 'Перед футером', 'yandexpro' ),
        'id'            => 'before-footer',
        'description'   => esc_html__( 'Полноширинная область виджетов перед футером.', 'yandexpro' ),
        'before_widget' => '<section id="%1$s" class="widget before-footer-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'yandexpro_widgets_init' );

/**
 * Получение URL Google Fonts
 */
function yandexpro_fonts_url() {
    $fonts_url = '';

    // Проверяем, включены ли Google Fonts в настройках
    if ( ! get_theme_mod( 'disable_google_fonts', false ) ) {
        $font_families = array();

        // Основной шрифт
        $primary_font = get_theme_mod( 'primary_font', 'Space Grotesk' );
        if ( 'Space Grotesk' === $primary_font ) {
            $font_families[] = 'Space Grotesk:300,400,500,600,700';
        } else {
            // Если выбран другой шрифт, добавляем его
            $font_families[] = str_replace( ' ', '+', $primary_font ) . ':300,400,500,600,700';
        }

        // Дополнительный шрифт для заголовков
        $heading_font = get_theme_mod( 'heading_font', 'Space Grotesk' );
        if ( $heading_font !== $primary_font ) {
            $font_families[] = str_replace( ' ', '+', $heading_font ) . ':300,400,500,600,700,800';
        }

        if ( $font_families ) {
            $query_args = array(
                'family'  => implode( '|', $font_families ),
                'subset'  => 'latin,cyrillic',
                'display' => 'swap',
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }
    }

    return esc_url_raw( $fonts_url );
}

/**
 * Добавляем класс body для темной темы
 */
function yandexpro_body_classes( $classes ) {
    // Темная тема
    if ( get_theme_mod( 'dark_mode_enabled', false ) ) {
        $classes[] = 'dark-mode';
    }

    // Цветовая схема
    $color_scheme = get_theme_mod( 'color_scheme', 'blue' );
    $classes[] = 'color-scheme-' . sanitize_html_class( $color_scheme );

    // Стиль хедера
    $header_style = get_theme_mod( 'header_style', 'default' );
    $classes[] = 'header-style-' . sanitize_html_class( $header_style );

    // Ширина контейнера
    $container_width = get_theme_mod( 'container_width', 1200 );
    if ( $container_width !== 1200 ) {
        $classes[] = 'container-width-' . intval( $container_width );
    }

    // Полноширинная страница
    if ( is_page_template( array(
        'page-templates/page-landing.php',
        'page-templates/page-fullwidth.php'
    ) ) ) {
        $classes[] = 'full-width-page';
    }

    // Страница блога
    if ( is_home() || is_archive() || is_category() || is_tag() ) {
        $classes[] = 'blog-page';
    }

    // Без сайдбара
    if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( array(
        'page-templates/page-landing.php',
        'page-templates/page-fullwidth.php'
    ) ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'yandexpro_body_classes' );

/**
 * Добавляем поддержку Gutenberg для кастомных размеров изображений
 */
function yandexpro_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'yandexpro-featured-large' => esc_html__( 'Большая Featured', 'yandexpro' ),
        'yandexpro-blog-thumb'     => esc_html__( 'Миниатюра блога', 'yandexpro' ),
        'yandexpro-card-thumb'     => esc_html__( 'Квадратная карточка', 'yandexpro' ),
        'yandexpro-hero'           => esc_html__( 'Hero изображение', 'yandexpro' ),
    ) );
}
add_filter( 'image_size_names_choose', 'yandexpro_custom_image_sizes' );

/**
 * Отключаем стандартные блочные паттерны WordPress (будем использовать свои)
 */
function yandexpro_remove_core_patterns() {
    remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'yandexpro_remove_core_patterns' );

/**
 * Фильтруем excerpt длину для блога
 */
function yandexpro_excerpt_length( $length ) {
    if ( is_admin() ) {
        return $length;
    }

    // Настраиваемая длина через Customizer
    $excerpt_length = get_theme_mod( 'blog_excerpt_length', 25 );
    
    return absint( $excerpt_length );
}
add_filter( 'excerpt_length', 'yandexpro_excerpt_length', 999 );

/**
 * Кастомный "читать далее" для excerpt
 */
function yandexpro_excerpt_more( $link ) {
    if ( is_admin() ) {
        return $link;
    }

    $link = sprintf(
        '<p class="read-more-link"><a href="%1$s" class="more-link">%2$s</a></p>',
        esc_url( get_permalink( get_the_ID() ) ),
        /* translators: %s: Post title */
        sprintf( wp_kses( __( 'Читать далее <span class="screen-reader-text">"%s"</span>', 'yandexpro' ), array( 'span' => array( 'class' => array() ) ) ), esc_html( get_the_title( get_the_ID() ) ) )
    );
    return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'yandexpro_excerpt_more' );