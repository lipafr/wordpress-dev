<?php
/**
 * Настройки WordPress Customizer для темы YandexPro Enhanced
 *
 * @package YandexPro_Enhanced
 */

// Блокируем прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация настроек Customizer
 */
function yandexpro_customize_register( $wp_customize ) {

    /*
     * === ПАНЕЛЬ НАСТРОЕК ТЕМЫ ===
     */
    $wp_customize->add_panel( 'yandexpro_theme_options', array(
        'title'       => esc_html__( 'Настройки темы YandexPro', 'yandexpro' ),
        'description' => esc_html__( 'Настройте внешний вид и функциональность вашего сайта.', 'yandexpro' ),
        'priority'    => 30,
    ) );

    /*
     * === ЦВЕТОВАЯ СХЕМА ===
     */
    $wp_customize->add_section( 'yandexpro_colors', array(
        'title'    => esc_html__( 'Цветовая схема', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 10,
    ) );

    // Выбор готовой цветовой схемы
    $wp_customize->add_setting( 'color_scheme', array(
        'default'           => 'blue',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'color_scheme', array(
        'label'   => esc_html__( 'Готовые цветовые схемы', 'yandexpro' ),
        'section' => 'yandexpro_colors',
        'type'    => 'select',
        'choices' => array(
            'blue'   => esc_html__( 'Синяя (по умолчанию)', 'yandexpro' ),
            'green'  => esc_html__( 'Зеленая', 'yandexpro' ),
            'purple' => esc_html__( 'Фиолетовая', 'yandexpro' ),
            'orange' => esc_html__( 'Оранжевая', 'yandexpro' ),
            'red'    => esc_html__( 'Красная', 'yandexpro' ),
            'custom' => esc_html__( 'Пользовательская', 'yandexpro' ),
        ),
    ) );

    // Основной цвет (показывается только при выборе "custom")
    $wp_customize->add_setting( 'primary_color', array(
        'default'           => '#7c3aed',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
        'label'           => esc_html__( 'Основной цвет', 'yandexpro' ),
        'section'         => 'yandexpro_colors',
        'active_callback' => 'yandexpro_is_custom_color_scheme',
    ) ) );

    // Акцентный цвет
    $wp_customize->add_setting( 'accent_color', array(
        'default'           => '#ec4899',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
        'label'           => esc_html__( 'Акцентный цвет', 'yandexpro' ),
        'section'         => 'yandexpro_colors',
        'active_callback' => 'yandexpro_is_custom_color_scheme',
    ) ) );

    // Переключатель темной темы
    $wp_customize->add_setting( 'dark_mode_toggle', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'dark_mode_toggle', array(
        'label'   => esc_html__( 'Показывать переключатель темной темы', 'yandexpro' ),
        'section' => 'yandexpro_colors',
        'type'    => 'checkbox',
    ) );

    /*
     * === ТИПОГРАФИКА ===
     */
    $wp_customize->add_section( 'yandexpro_typography', array(
        'title'    => esc_html__( 'Типографика', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 20,
    ) );

    // Включение Google Fonts
    $wp_customize->add_setting( 'enable_google_fonts', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'enable_google_fonts', array(
        'label'   => esc_html__( 'Использовать Google Fonts', 'yandexpro' ),
        'section' => 'yandexpro_typography',
        'type'    => 'checkbox',
    ) );

    // Основной шрифт
    $wp_customize->add_setting( 'primary_font', array(
        'default'           => 'Space Grotesk',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'primary_font', array(
        'label'           => esc_html__( 'Основной шрифт', 'yandexpro' ),
        'section'         => 'yandexpro_typography',
        'type'            => 'select',
        'choices'         => yandexpro_get_font_choices(),
        'active_callback' => 'yandexpro_is_google_fonts_enabled',
    ) );

    // Размер шрифта
    $wp_customize->add_setting( 'font_size', array(
        'default'           => 'medium',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'font_size', array(
        'label'   => esc_html__( 'Размер шрифта', 'yandexpro' ),
        'section' => 'yandexpro_typography',
        'type'    => 'select',
        'choices' => array(
            'small'  => esc_html__( 'Маленький', 'yandexpro' ),
            'medium' => esc_html__( 'Средний', 'yandexpro' ),
            'large'  => esc_html__( 'Большой', 'yandexpro' ),
        ),
    ) );

    /*
     * === МАКЕТ ===
     */
    $wp_customize->add_section( 'yandexpro_layout', array(
        'title'    => esc_html__( 'Макет и компоновка', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 30,
    ) );

    // Ширина контейнера
    $wp_customize->add_setting( 'container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'yandexpro_sanitize_number_range',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'container_width', array(
        'label'       => esc_html__( 'Ширина контейнера (px)', 'yandexpro' ),
        'section'     => 'yandexpro_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1600,
            'step' => 40,
        ),
    ) );

    // Показывать сайдбар
    $wp_customize->add_setting( 'show_sidebar', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'show_sidebar', array(
        'label'   => esc_html__( 'Показывать сайдбар', 'yandexpro' ),
        'section' => 'yandexpro_layout',
        'type'    => 'checkbox',
    ) );

    // Стиль шапки
    $wp_customize->add_setting( 'header_style', array(
        'default'           => 'default',
        'sanitize_callback' => 'yandexpro_sanitize_select',
    ) );

    $wp_customize->add_control( 'header_style', array(
        'label'   => esc_html__( 'Стиль шапки', 'yandexpro' ),
        'section' => 'yandexpro_layout',
        'type'    => 'select',
        'choices' => array(
            'default'     => esc_html__( 'По умолчанию', 'yandexpro' ),
            'minimal'     => esc_html__( 'Минималистичный', 'yandexpro' ),
            'centered'    => esc_html__( 'По центру', 'yandexpro' ),
        ),
    ) );

    /*
     * === НАСТРОЙКИ ШАПКИ ===
     */
    $wp_customize->add_section( 'yandexpro_header', array(
        'title'    => esc_html__( 'Настройки шапки', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 40,
    ) );

    // Поиск в шапке
    $wp_customize->add_setting( 'show_header_search', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'show_header_search', array(
        'label'   => esc_html__( 'Показывать поиск в шапке', 'yandexpro' ),
        'section' => 'yandexpro_header',
        'type'    => 'checkbox',
    ) );

    // Закрепленная шапка
    $wp_customize->add_setting( 'sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'sticky_header', array(
        'label'   => esc_html__( 'Закрепленная шапка', 'yandexpro' ),
        'section' => 'yandexpro_header',
        'type'    => 'checkbox',
    ) );

    /*
     * === ГЛАВНАЯ СЕКЦИЯ (HERO) ===
     */
    $wp_customize->add_section( 'yandexpro_hero', array(
        'title'    => esc_html__( 'Главная секция (Hero)', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 50,
    ) );

    // Заголовок Hero секции
    $wp_customize->add_setting( 'hero_title', array(
        'default'           => esc_html__( 'Блог о Яндекс Директ и интернет-маркетинге', 'yandexpro' ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'hero_title', array(
        'label'   => esc_html__( 'Заголовок Hero секции', 'yandexpro' ),
        'section' => 'yandexpro_hero',
        'type'    => 'textarea',
    ) );

    // Описание Hero секции
    $wp_customize->add_setting( 'hero_description', array(
        'default'           => esc_html__( 'Практические кейсы, инсайты и тренды из мира контекстной рекламы. Только проверенная информация от практикующего специалиста.', 'yandexpro' ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'hero_description', array(
        'label'   => esc_html__( 'Описание Hero секции', 'yandexpro' ),
        'section' => 'yandexpro_hero',
        'type'    => 'textarea',
    ) );

    // Текст кнопки
    $wp_customize->add_setting( 'hero_button_text', array(
        'default'           => esc_html__( 'Читать блог', 'yandexpro' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'hero_button_text', array(
        'label'   => esc_html__( 'Текст кнопки', 'yandexpro' ),
        'section' => 'yandexpro_hero',
        'type'    => 'text',
    ) );

    // Ссылка кнопки
    $wp_customize->add_setting( 'hero_button_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( 'hero_button_url', array(
        'label'   => esc_html__( 'Ссылка кнопки', 'yandexpro' ),
        'section' => 'yandexpro_hero',
        'type'    => 'url',
    ) );

    /*
     * === НАСТРОЙКИ ПОДВАЛА ===
     */
    $wp_customize->add_section( 'yandexpro_footer', array(
        'title'    => esc_html__( 'Настройки подвала', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 60,
    ) );

    // Пользовательский текст в подвале
    $wp_customize->add_setting( 'footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'footer_text', array(
        'label'   => esc_html__( 'Дополнительный текст в подвале', 'yandexpro' ),
        'section' => 'yandexpro_footer',
        'type'    => 'textarea',
    ) );

    // Показывать ссылку на тему
    $wp_customize->add_setting( 'show_theme_credit', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'show_theme_credit', array(
        'label'   => esc_html__( 'Показывать ссылку на тему', 'yandexpro' ),
        'section' => 'yandexpro_footer',
        'type'    => 'checkbox',
    ) );

    // Кнопка "Наверх"
    $wp_customize->add_setting( 'show_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'show_back_to_top', array(
        'label'   => esc_html__( 'Показывать кнопку "Наверх"', 'yandexpro' ),
        'section' => 'yandexpro_footer',
        'type'    => 'checkbox',
    ) );

    /*
     * === СОЦИАЛЬНЫЕ СЕТИ ===
     */
    $wp_customize->add_section( 'yandexpro_social', array(
        'title'    => esc_html__( 'Социальные сети', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 70,
    ) );

    // Включить социальные ссылки
    $wp_customize->add_setting( 'enable_social_links', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'enable_social_links', array(
        'label'   => esc_html__( 'Включить социальные ссылки', 'yandexpro' ),
        'section' => 'yandexpro_social',
        'type'    => 'checkbox',
    ) );

    // Социальные сети
    $social_networks = array(
        'vk'        => 'ВКонтакте',
        'telegram'  => 'Telegram',
        'youtube'   => 'YouTube',
        'twitter'   => 'Twitter',
        'facebook'  => 'Facebook',
        'instagram' => 'Instagram',
        'linkedin'  => 'LinkedIn',
    );

    foreach ( $social_networks as $network => $label ) {
        $wp_customize->add_setting( "social_{$network}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( "social_{$network}", array(
            'label'           => sprintf( esc_html__( 'Ссылка на %s', 'yandexpro' ), $label ),
            'section'         => 'yandexpro_social',
            'type'            => 'url',
            'active_callback' => 'yandexpro_is_social_enabled',
        ) );
    }

    /*
     * === НАСТРОЙКИ БЛОГА ===
     */
    $wp_customize->add_section( 'yandexpro_blog', array(
        'title'    => esc_html__( 'Настройки блога', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 80,
    ) );

    // Показывать хлебные крошки
    $wp_customize->add_setting( 'show_breadcrumbs', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'show_breadcrumbs', array(
        'label'   => esc_html__( 'Показывать хлебные крошки', 'yandexpro' ),
        'section' => 'yandexpro_blog',
        'type'    => 'checkbox',
    ) );

    // Длина анонса
    $wp_customize->add_setting( 'blog_excerpt_length', array(
        'default'           => 25,
        'sanitize_callback' => 'yandexpro_sanitize_number_range',
    ) );

    $wp_customize->add_control( 'blog_excerpt_length', array(
        'label'       => esc_html__( 'Длина анонса (слов)', 'yandexpro' ),
        'section'     => 'yandexpro_blog',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 5,
        ),
    ) );

    /*
     * === ПРОИЗВОДИТЕЛЬНОСТЬ ===
     */
    $wp_customize->add_section( 'yandexpro_performance', array(
        'title'    => esc_html__( 'Производительность', 'yandexpro' ),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 90,
    ) );

    // Отключить анимации
    $wp_customize->add_setting( 'disable_animations', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'disable_animations', array(
        'label'   => esc_html__( 'Отключить анимации', 'yandexpro' ),
        'section' => 'yandexpro_performance',
        'type'    => 'checkbox',
    ) );

    // Отключить emoji
    $wp_customize->add_setting( 'disable_emojis', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'disable_emojis', array(
        'label'   => esc_html__( 'Отключить emoji скрипты', 'yandexpro' ),
        'section' => 'yandexpro_performance',
        'type'    => 'checkbox',
    ) );
}
add_action( 'customize_register', 'yandexpro_customize_register' );

/**
 * Функции активных callbacks
 */
function yandexpro_is_custom_color_scheme() {
    return 'custom' === get_theme_mod( 'color_scheme', 'blue' );
}

function yandexpro_is_google_fonts_enabled() {
    return get_theme_mod( 'enable_google_fonts', true );
}

function yandexpro_is_social_enabled() {
    return get_theme_mod( 'enable_social_links', false );
}

/**
 * Получение списка доступных шрифтов
 */
function yandexpro_get_font_choices() {
    return array(
        'Space Grotesk'    => 'Space Grotesk',
        'Inter'            => 'Inter',
        'Roboto'           => 'Roboto',
        'Open Sans'        => 'Open Sans',
        'Lato'             => 'Lato',
        'Poppins'          => 'Poppins',
        'Montserrat'       => 'Montserrat',
        'Source Sans Pro'  => 'Source Sans Pro',
        'system'           => esc_html__( 'Системный шрифт', 'yandexpro' ),
    );
}

/**
 * Функции санитизации
 */
function yandexpro_sanitize_checkbox( $input ) {
    return ( isset( $input ) && true === $input ) ? true : false;
}

function yandexpro_sanitize_select( $input, $setting ) {
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ) ? $input : $setting->default;
}

function yandexpro_sanitize_number_range( $number, $setting ) {
    $number = absint( $number );
    
    $atts = $setting->manager->get_control( $setting->id )->input_attrs;
    $min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
    $max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
    $step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
    
    if ( $number > $max ) {
        return $max;
    } elseif ( $number < $min ) {
        return $min;
    } else {
        return floor( $number / $step ) * $step;
    }
}

/**
 * Live preview JavaScript для Customizer
 */
function yandexpro_customize_preview_js() {
    wp_enqueue_script(
        'yandexpro-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array( 'customize-preview' ),
        wp_get_theme()->get( 'Version' ),
        true
    );
}
add_action( 'customize_preview_init', 'yandexpro_customize_preview_js' );

/**
 * Вывод кастомных CSS переменных в head на основе настроек Customizer
 */
function yandexpro_customizer_css() {
    $color_scheme = get_theme_mod( 'color_scheme', 'blue' );
    $primary_color = get_theme_mod( 'primary_color', '#7c3aed' );
    $accent_color = get_theme_mod( 'accent_color', '#ec4899' );
    $container_width = get_theme_mod( 'container_width', 1200 );
    $font_size = get_theme_mod( 'font_size', 'medium' );

    $css = '<style type="text/css" id="yandexpro-customizer-css">';
    $css .= ':root {';

    // Цветовые схемы
    if ( 'custom' === $color_scheme ) {
        $css .= '--color-primary: ' . sanitize_hex_color( $primary_color ) . ';';
        $css .= '--color-accent: ' . sanitize_hex_color( $accent_color ) . ';';
    } else {
        $schemes = array(
            'blue'   => array( 'primary' => '#7c3aed', 'accent' => '#ec4899' ),
            'green'  => array( 'primary' => '#059669', 'accent' => '#10b981' ),
            'purple' => array( 'primary' => '#7c2d12', 'accent' => '#c2410c' ),
            'orange' => array( 'primary' => '#ea580c', 'accent' => '#f97316' ),
            'red'    => array( 'primary' => '#dc2626', 'accent' => '#ef4444' ),
        );
        
        if ( isset( $schemes[ $color_scheme ] ) ) {
            $css .= '--color-primary: ' . $schemes[ $color_scheme ]['primary'] . ';';
            $css .= '--color-accent: ' . $schemes[ $color_scheme ]['accent'] . ';';
        }
    }

    // Ширина контейнера
    $css .= '--container-max-width: ' . intval( $container_width ) . 'px;';

    // Размеры шрифтов
    $font_sizes = array(
        'small'  => '0.875rem',
        'medium' => '1rem',
        'large'  => '1.125rem',
    );
    
    if ( isset( $font_sizes[ $font_size ] ) ) {
        $css .= '--font-size-base: ' . $font_sizes[ $font_size ] . ';';
    }

    $css .= '}';
    $css .= '</style>';

    echo $css;
}
add_action( 'wp_head', 'yandexpro_customizer_css' );

/**
 * Настройки по умолчанию при первой активации темы
 */
function yandexpro_customizer_defaults() {
    $defaults = array(
        'color_scheme'        => 'blue',
        'enable_google_fonts' => true,
        'primary_font'        => 'Space Grotesk',
        'font_size'           => 'medium',
        'container_width'     => 1200,
        'show_sidebar'        => true,
        'header_style'        => 'default',
        'show_header_search'  => false,
        'sticky_header'       => true,
        'hero_title'          => esc_html__( 'Блог о Яндекс Директ и интернет-маркетинге', 'yandexpro' ),
        'hero_description'    => esc_html__( 'Практические кейсы, инсайты и тренды из мира контекстной рекламы.', 'yandexpro' ),
        'hero_button_text'    => esc_html__( 'Читать блог', 'yandexpro' ),
        'show_breadcrumbs'    => true,
        'blog_excerpt_length' => 25,
        'show_back_to_top'    => true,
        'show_theme_credit'   => true,
    );

    foreach ( $defaults as $setting => $value ) {
        if ( ! get_theme_mod( $setting ) ) {
            set_theme_mod( $setting, $value );
        }
    }
}
add_action( 'after_switch_theme', 'yandexpro_customizer_defaults' );