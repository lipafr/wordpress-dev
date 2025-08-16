<?php
/**
 * YandexPro Theme Customizer
 *
 * @package YandexPro
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function yandexpro_customize_register($wp_customize) {
    
    // Add postMessage support for existing controls
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    // Remove sections we don't need
    $wp_customize->remove_section('colors');
    
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'yandexpro_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'yandexpro_customize_partial_blogdescription',
        ));
    }

    // Theme Options Panel
    $wp_customize->add_panel('yandexpro_theme_options', array(
        'title'       => __('Настройки темы YandexPro', 'yandexpro'),
        'description' => __('Настройте внешний вид и функциональность вашей темы', 'yandexpro'),
        'priority'    => 30,
    ));

    /**
     * Color Scheme Section
     */
    $wp_customize->add_section('yandexpro_color_scheme', array(
        'title'    => __('Цветовая схема', 'yandexpro'),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 10,
    ));

    // Color Scheme Choice
    $wp_customize->add_setting('yandexpro_color_scheme', array(
        'default'           => 'default',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_color_scheme', array(
        'type'        => 'select',
        'section'     => 'yandexpro_color_scheme',
        'label'       => __('Выберите цветовую схему', 'yandexpro'),
        'description' => __('Цветовая схема определяет основные цвета сайта', 'yandexpro'),
        'choices'     => array(
            'default' => __('По умолчанию (синий)', 'yandexpro'),
            'green'   => __('Зеленая', 'yandexpro'),
            'purple'  => __('Фиолетовая', 'yandexpro'),
            'orange'  => __('Оранжевая', 'yandexpro'),
            'red'     => __('Красная', 'yandexpro'),
        ),
    ));

    // Primary Color
    $wp_customize->add_setting('yandexpro_primary_color', array(
        'default'           => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'yandexpro_primary_color', array(
        'label'       => __('Основной цвет', 'yandexpro'),
        'description' => __('Используется для заголовков и основных элементов', 'yandexpro'),
        'section'     => 'yandexpro_color_scheme',
    )));

    // Accent Color
    $wp_customize->add_setting('yandexpro_accent_color', array(
        'default'           => '#3498db',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'yandexpro_accent_color', array(
        'label'       => __('Акцентный цвет', 'yandexpro'),
        'description' => __('Используется для ссылок и кнопок', 'yandexpro'),
        'section'     => 'yandexpro_color_scheme',
    )));

    // Dark Mode Toggle
    $wp_customize->add_setting('yandexpro_enable_dark_mode', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_enable_dark_mode', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_color_scheme',
        'label'       => __('Включить переключатель темной темы', 'yandexpro'),
        'description' => __('Добавляет кнопку переключения между светлой и темной темой', 'yandexpro'),
    ));

    /**
     * Typography Section
     */
    $wp_customize->add_section('yandexpro_typography', array(
        'title'    => __('Типографика', 'yandexpro'),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 20,
    ));

    // Enable Google Fonts
    $wp_customize->add_setting('yandexpro_enable_google_fonts', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_enable_google_fonts', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_typography',
        'label'       => __('Использовать Google Fonts', 'yandexpro'),
        'description' => __('Подключает дополнительные шрифты Google', 'yandexpro'),
    ));

    // Primary Font
    $wp_customize->add_setting('yandexpro_primary_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_primary_font', array(
        'type'        => 'select',
        'section'     => 'yandexpro_typography',
        'label'       => __('Основной шрифт', 'yandexpro'),
        'description' => __('Шрифт для заголовков и основного текста', 'yandexpro'),
        'choices'     => yandexpro_get_font_choices(),
        'active_callback' => 'yandexpro_is_google_fonts_enabled',
    ));

    // Font Size
    $wp_customize->add_setting('yandexpro_font_size', array(
        'default'           => 'medium',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('yandexpro_font_size', array(
        'type'    => 'select',
        'section' => 'yandexpro_typography',
        'label'   => __('Размер шрифта', 'yandexpro'),
        'choices' => array(
            'small'  => __('Маленький', 'yandexpro'),
            'medium' => __('Средний', 'yandexpro'),
            'large'  => __('Большой', 'yandexpro'),
        ),
    ));

    /**
     * Layout Section
     */
    $wp_customize->add_section('yandexpro_layout', array(
        'title'    => __('Макет', 'yandexpro'),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 30,
    ));

    // Container Width
    $wp_customize->add_setting('yandexpro_container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('yandexpro_container_width', array(
        'type'        => 'range',
        'section'     => 'yandexpro_layout',
        'label'       => __('Ширина контейнера (px)', 'yandexpro'),
        'description' => __('Максимальная ширина основного контента', 'yandexpro'),
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1600,
            'step' => 20,
        ),
    ));

    // Show Sidebar
    $wp_customize->add_setting('yandexpro_show_sidebar', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_show_sidebar', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_layout',
        'label'       => __('Показывать сайдбар', 'yandexpro'),
        'description' => __('Включить/выключить боковую панель на страницах блога', 'yandexpro'),
    ));

    /**
     * Header Section
     */
    $wp_customize->add_section('yandexpro_header', array(
        'title'    => __('Настройки шапки', 'yandexpro'),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 40,
    ));

    // Header Style
    $wp_customize->add_setting('yandexpro_header_style', array(
        'default'           => 'default',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_header_style', array(
        'type'    => 'select',
        'section' => 'yandexpro_header',
        'label'   => __('Стиль шапки', 'yandexpro'),
        'choices' => array(
            'default' => __('По умолчанию', 'yandexpro'),
            'minimal' => __('Минималистичный', 'yandexpro'),
            'center'  => __('По центру', 'yandexpro'),
        ),
    ));

    // Show Search in Header
    $wp_customize->add_setting('yandexpro_show_header_search', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_show_header_search', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_header',
        'label'       => __('Показать поиск в шапке', 'yandexpro'),
        'description' => __('Добавляет кнопку поиска в шапку сайта', 'yandexpro'),
    ));

    // Sticky Header
    $wp_customize->add_setting('yandexpro_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_sticky_header', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_header',
        'label'       => __('Закрепленная шапка', 'yandexpro'),
        'description' => __('Шапка остается видимой при прокрутке', 'yandexpro'),
    ));

    /**
     * Hero Section
     */
    $wp_customize->add_section('yandexpro_hero', array(
        'title'    => __('Главная секция (Hero)', 'yandexpro'),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 50,
    ));

    // Hero Title
    $wp_customize->add_setting('yandexpro_hero_title', array(
        'default'           => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('yandexpro_hero_title', array(
        'type'        => 'text',
        'section'     => 'yandexpro_hero',
        'label'       => __('Заголовок Hero секции', 'yandexpro'),
        'description' => __('Основной заголовок на главной странице', 'yandexpro'),
    ));

    // Hero Description
    $wp_customize->add_setting('yandexpro_hero_description', array(
        'default'           => get_bloginfo('description'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('yandexpro_hero_description', array(
        'type'        => 'textarea',
        'section'     => 'yandexpro_hero',
        'label'       => __('Описание Hero секции', 'yandexpro'),
        'description' => __('Краткое описание под заголовком', 'yandexpro'),
    ));

    // Hero Button Text
    $wp_customize->add_setting('yandexpro_hero_button_text', array(
        'default'           => __('Читать блог', 'yandexpro'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('yandexpro_hero_button_text', array(
        'type'        => 'text',
        'section'     => 'yandexpro_hero',
        'label'       => __('Текст кнопки', 'yandexpro'),
        'description' => __('Текст на кнопке в Hero секции', 'yandexpro'),
    ));

    // Hero Button URL
    $wp_customize->add_setting('yandexpro_hero_button_url', array(
        'default'           => '#latest-posts',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('yandexpro_hero_button_url', array(
        'type'        => 'url',
        'section'     => 'yandexpro_hero',
        'label'       => __('Ссылка кнопки', 'yandexpro'),
        'description' => __('URL для кнопки в Hero секции', 'yandexpro'),
    ));

    /**
     * Footer Section
     */
    $wp_customize->add_section('yandexpro_footer', array(
        'title'    => __('Настройки подвала', 'yandexpro'),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 60,
    ));

    // Footer Text
    $wp_customize->add_setting('yandexpro_footer_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('yandexpro_footer_text', array(
        'type'        => 'textarea',
        'section'     => 'yandexpro_footer',
        'label'       => __('Пользовательский текст в подвале', 'yandexpro'),
        'description' => __('Замените стандартный copyright на свой текст. Поддерживается HTML.', 'yandexpro'),
    ));

    // Show Theme Credit
    $wp_customize->add_setting('yandexpro_show_theme_credit', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('yandexpro_show_theme_credit', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_footer',
        'label'       => __('Показать ссылку на тему', 'yandexpro'),
        'description' => __('Поддержите разработчиков темы', 'yandexpro'),
    ));

    // Back to Top Button
    $wp_customize->add_setting('yandexpro_show_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_show_back_to_top', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_footer',
        'label'       => __('Показать кнопку "Наверх"', 'yandexpro'),
        'description' => __('Добавляет кнопку быстрого перехода в начало страницы', 'yandexpro'),
    ));

    /**
     * Social Media Section
     */
    $wp_customize->add_section('yandexpro_social', array(
        'title'    => __('Социальные сети', 'yandexpro'),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 70,
    ));

    // Show Social Links
    $wp_customize->add_setting('yandexpro_show_social_links', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_show_social_links', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_social',
        'label'       => __('Показать ссылки на социальные сети', 'yandexpro'),
        'description' => __('Добавляет иконки социальных сетей в подвал', 'yandexpro'),
    ));

    // Social Media URLs
    $social_networks = array(
        'facebook'  => __('Facebook', 'yandexpro'),
        'twitter'   => __('Twitter', 'yandexpro'),
        'instagram' => __('Instagram', 'yandexpro'),
        'linkedin'  => __('LinkedIn', 'yandexpro'),
        'youtube'   => __('YouTube', 'yandexpro'),
        'telegram'  => __('Telegram', 'yandexpro'),
        'vk'        => __('ВКонтакте', 'yandexpro'),
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("yandexpro_{$network}_url", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        ));

        $wp_customize->add_control("yandexpro_{$network}_url", array(
            'type'            => 'url',
            'section'         => 'yandexpro_social',
            'label'           => sprintf(__('Ссылка на %s', 'yandexpro'), $label),
            'active_callback' => 'yandexpro_is_social_links_enabled',
        ));
    }

    /**
     * Blog Section
     */
    $wp_customize->add_section('yandexpro_blog', array(
        'title'    => __('Настройки блога', 'yandexpro'),
        'panel'    => 'yandexpro_theme_options',
        'priority' => 80,
    ));

    // Show Breadcrumbs
    $wp_customize->add_setting('yandexpro_show_breadcrumbs', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_show_breadcrumbs', array(
        'type'        => 'checkbox',
        'section'     => 'yandexpro_blog',
        'label'       => __('Показать хлебные крошки', 'yandexpro'),
        'description' => __('Навигационная цепочка на страницах постов', 'yandexpro'),
    ));

    // Excerpt Length
    $wp_customize->add_setting('yandexpro_excerpt_length', array(
        'default'           => 25,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('yandexpro_excerpt_length', array(
        'type'        => 'number',
        'section'     => 'yandexpro_blog',
        'label'       => __('Длина анонса (слов)', 'yandexpro'),
        'description' => __('Количество слов в анонсе поста', 'yandexpro'),
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 5,
        ),
    ));
}
add_action('customize_register', 'yandexpro_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function yandexpro_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function yandexpro_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Sanitization Functions
 */

// Sanitize checkbox
function yandexpro_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

// Sanitize select
function yandexpro_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

// Sanitize number range
function yandexpro_sanitize_number_range($number, $setting) {
    $number = absint($number);
    $atts = $setting->manager->get_control($setting->id)->input_attrs;
    $min = (isset($atts['min']) ? $atts['min'] : $number);
    $max = (isset($atts['max']) ? $atts['max'] : $number);
    $step = (isset($atts['step']) ? $atts['step'] : 1);
    return ($min <= $number && $number <= $max && is_int($number / $step) ? $number : $setting->default);
}

/**
 * Active Callbacks
 */

// Check if Google Fonts are enabled
function yandexpro_is_google_fonts_enabled() {
    return get_theme_mod('yandexpro_enable_google_fonts', false);
}

// Check if social links are enabled
function yandexpro_is_social_links_enabled() {
    return get_theme_mod('yandexpro_show_social_links', false);
}

/**
 * Get Font Choices
 */
function yandexpro_get_font_choices() {
    return array(
        'system'        => __('Системный шрифт', 'yandexpro'),
        'Inter'         => 'Inter',
        'Roboto'        => 'Roboto',
        'Open Sans'     => 'Open Sans',
        'Lato'          => 'Lato',
        'Montserrat'    => 'Montserrat',
        'Source Sans Pro' => 'Source Sans Pro',
        'Raleway'       => 'Raleway',
        'Ubuntu'        => 'Ubuntu',
        'PT Sans'       => 'PT Sans',
        'Nunito'        => 'Nunito',
    );
}

/**
 * Output Custom CSS
 */
function yandexpro_customizer_css() {
    $primary_color = get_theme_mod('yandexpro_primary_color', '#2c3e50');
    $accent_color = get_theme_mod('yandexpro_accent_color', '#3498db');
    $container_width = get_theme_mod('yandexpro_container_width', 1200);
    $font_size = get_theme_mod('yandexpro_font_size', 'medium');
    
    $css = '';
    
    // Color customizations
    if ($primary_color !== '#2c3e50') {
        $css .= "
        :root {
            --yandexpro-primary: {$primary_color};
        }";
    }
    
    if ($accent_color !== '#3498db') {
        $css .= "
        :root {
            --yandexpro-accent: {$accent_color};
        }";
    }
    
    // Layout customizations
    if ($container_width !== 1200) {
        $css .= "
        :root {
            --yandexpro-container-width: {$container_width}px;
        }";
    }
    
    // Typography customizations
    $font_sizes = array(
        'small'  => '14px',
        'medium' => '16px',
        'large'  => '18px',
    );
    
    if (isset($font_sizes[$font_size]) && $font_size !== 'medium') {
        $css .= "
        html {
            font-size: {$font_sizes[$font_size]};
        }";
    }
    
    // Color scheme variations
    $color_scheme = get_theme_mod('yandexpro_color_scheme', 'default');
    if ($color_scheme !== 'default') {
        $schemes = array(
            'green'  => array('primary' => '#27ae60', 'accent' => '#2ecc71'),
            'purple' => array('primary' => '#8e44ad', 'accent' => '#9b59b6'),
            'orange' => array('primary' => '#e67e22', 'accent' => '#f39c12'),
            'red'    => array('primary' => '#c0392b', 'accent' => '#e74c3c'),
        );
        
        if (isset($schemes[$color_scheme])) {
            $css .= "
            :root {
                --yandexpro-primary: {$schemes[$color_scheme]['primary']};
                --yandexpro-accent: {$schemes[$color_scheme]['accent']};
            }";
        }
    }
    
    if (!empty($css)) {
        echo "<style type='text/css' id='yandexpro-customizer-css'>{$css}</style>";
    }
}
add_action('wp_head', 'yandexpro_customizer_css');

/**
 * Enqueue Customizer Preview JS
 */
function yandexpro_customize_preview_js() {
    wp_enqueue_script(
        'yandexpro-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('customize_preview_init', 'yandexpro_customize_preview_js');
?>