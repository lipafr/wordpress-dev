<?php
/**
 * YandexPro Theme Customizer
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer
 */
function yandexpro_customize_register($wp_customize) {
    
    // Add postMessage support for default sections
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    // Remove default colors section (we'll create our own)
    $wp_customize->remove_section('colors');

    /**
     * Theme Settings Panel
     */
    $wp_customize->add_panel('yandexpro_theme_settings', array(
        'title'       => __('YandexPro Theme Settings', 'yandexpro'),
        'description' => __('Customize your theme settings', 'yandexpro'),
        'priority'    => 30,
    ));

    /**
     * 1. COLOR SCHEME SECTION
     */
    $wp_customize->add_section('yandexpro_colors', array(
        'title'    => __('Color Scheme', 'yandexpro'),
        'panel'    => 'yandexpro_theme_settings',
        'priority' => 10,
    ));

    // Color scheme preset
    $wp_customize->add_setting('color_scheme', array(
        'default'           => 'blue',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('color_scheme', array(
        'label'    => __('Color Scheme', 'yandexpro'),
        'section'  => 'yandexpro_colors',
        'type'     => 'select',
        'choices'  => array(
            'blue'   => __('Blue (Default)', 'yandexpro'),
            'green'  => __('Green', 'yandexpro'),
            'purple' => __('Purple', 'yandexpro'),
            'orange' => __('Orange', 'yandexpro'),
            'red'    => __('Red', 'yandexpro'),
            'custom' => __('Custom Colors', 'yandexpro'),
        ),
    ));

    // Primary color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#2c3e50',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'           => __('Primary Color', 'yandexpro'),
        'section'         => 'yandexpro_colors',
        'active_callback' => 'yandexpro_is_custom_color_scheme',
    )));

    // Accent color
    $wp_customize->add_setting('accent_color', array(
        'default'           => '#3498db',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'           => __('Accent Color', 'yandexpro'),
        'section'         => 'yandexpro_colors',
        'active_callback' => 'yandexpro_is_custom_color_scheme',
    )));

    // Dark theme toggle
    $wp_customize->add_setting('enable_dark_theme_toggle', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('enable_dark_theme_toggle', array(
        'label'   => __('Enable Dark Theme Toggle', 'yandexpro'),
        'section' => 'yandexpro_colors',
        'type'    => 'checkbox',
    ));

    /**
     * 2. TYPOGRAPHY SECTION
     */
    $wp_customize->add_section('yandexpro_typography', array(
        'title'    => __('Typography', 'yandexpro'),
        'panel'    => 'yandexpro_theme_settings',
        'priority' => 20,
    ));

    // Enable Google Fonts
    $wp_customize->add_setting('enable_google_fonts', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('enable_google_fonts', array(
        'label'   => __('Enable Google Fonts', 'yandexpro'),
        'section' => 'yandexpro_typography',
        'type'    => 'checkbox',
    ));

    // Primary font
    $wp_customize->add_setting('primary_font', array(
        'default'           => 'system',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('primary_font', array(
        'label'           => __('Primary Font', 'yandexpro'),
        'section'         => 'yandexpro_typography',
        'type'            => 'select',
        'choices'         => yandexpro_get_font_choices(),
        'active_callback' => 'yandexpro_is_google_fonts_enabled',
    ));

    // Font size
    $wp_customize->add_setting('font_size', array(
        'default'           => 'medium',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('font_size', array(
        'label'   => __('Font Size', 'yandexpro'),
        'section' => 'yandexpro_typography',
        'type'    => 'select',
        'choices' => array(
            'small'  => __('Small', 'yandexpro'),
            'medium' => __('Medium (Default)', 'yandexpro'),
            'large'  => __('Large', 'yandexpro'),
        ),
    ));

    /**
     * 3. LAYOUT SECTION
     */
    $wp_customize->add_section('yandexpro_layout', array(
        'title'    => __('Layout', 'yandexpro'),
        'panel'    => 'yandexpro_theme_settings',
        'priority' => 30,
    ));

    // Container width
    $wp_customize->add_setting('container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('container_width', array(
        'label'       => __('Container Width (px)', 'yandexpro'),
        'section'     => 'yandexpro_layout',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1600,
            'step' => 20,
        ),
    ));

    // Show sidebar
    $wp_customize->add_setting('show_sidebar', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_sidebar', array(
        'label'   => __('Show Sidebar', 'yandexpro'),
        'section' => 'yandexpro_layout',
        'type'    => 'checkbox',
    ));

    // Header style
    $wp_customize->add_setting('header_style', array(
        'default'           => 'default',
        'sanitize_callback' => 'yandexpro_sanitize_select',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('header_style', array(
        'label'   => __('Header Style', 'yandexpro'),
        'section' => 'yandexpro_layout',
        'type'    => 'select',
        'choices' => array(
            'default'    => __('Default', 'yandexpro'),
            'minimal'    => __('Minimal', 'yandexpro'),
            'centered'   => __('Centered', 'yandexpro'),
        ),
    ));

    /**
     * 4. HEADER SETTINGS SECTION
     */
    $wp_customize->add_section('yandexpro_header', array(
        'title'    => __('Header Settings', 'yandexpro'),
        'panel'    => 'yandexpro_theme_settings',
        'priority' => 40,
    ));

    // Show search in header
    $wp_customize->add_setting('show_search_in_header', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_search_in_header', array(
        'label'   => __('Show Search in Header', 'yandexpro'),
        'section' => 'yandexpro_header',
        'type'    => 'checkbox',
    ));

    // Sticky header
    $wp_customize->add_setting('sticky_header', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('sticky_header', array(
        'label'   => __('Sticky Header', 'yandexpro'),
        'section' => 'yandexpro_header',
        'type'    => 'checkbox',
    ));

    // Show logo
    $wp_customize->add_setting('show_logo', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_logo', array(
        'label'   => __('Show Logo', 'yandexpro'),
        'section' => 'yandexpro_header',
        'type'    => 'checkbox',
    ));

    /**
     * 5. HERO SECTION (for homepage)
     */
    $wp_customize->add_section('yandexpro_hero', array(
        'title'    => __('Hero Section', 'yandexpro'),
        'panel'    => 'yandexpro_theme_settings',
        'priority' => 50,
    ));

    // Hero title
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('Welcome to YandexPro', 'yandexpro'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'yandexpro'),
        'section' => 'yandexpro_hero',
        'type'    => 'text',
    ));

    // Hero description
    $wp_customize->add_setting('hero_description', array(
        'default'           => __('Your trusted source for marketing insights and advertising tips.', 'yandexpro'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_description', array(
        'label'   => __('Hero Description', 'yandexpro'),
        'section' => 'yandexpro_hero',
        'type'    => 'textarea',
    ));

    // Hero button text
    $wp_customize->add_setting('hero_button_text', array(
        'default'           => __('Read Blog', 'yandexpro'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('hero_button_text', array(
        'label'   => __('Hero Button Text', 'yandexpro'),
        'section' => 'yandexpro_hero',
        'type'    => 'text',
    ));

    // Hero button link
    $wp_customize->add_setting('hero_button_link', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('hero_button_link', array(
        'label'   => __('Hero Button Link', 'yandexpro'),
        'section' => 'yandexpro_hero',
        'type'    => 'url',
    ));

    /**
     * 6. FOOTER SETTINGS SECTION
     */
    $wp_customize->add_section('yandexpro_footer', array(
        'title'    => __('Footer Settings', 'yandexpro'),
        'panel'    => 'yandexpro_theme_settings',
        'priority' => 60,
    ));

    // Footer description
    $wp_customize->add_setting('footer_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_description', array(
        'label'   => __('Footer Description', 'yandexpro'),
        'section' => 'yandexpro_footer',
        'type'    => 'text',
    ));

    // Custom copyright text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'label'   => __('Custom Copyright Text', 'yandexpro'),
        'section' => 'yandexpro_footer',
        'type'    => 'textarea',
    ));

    // Show theme credit
    $wp_customize->add_setting('show_theme_credit', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('show_theme_credit', array(
        'label'   => __('Show Theme Credit', 'yandexpro'),
        'section' => 'yandexpro_footer',
        'type'    => 'checkbox',
    ));

    // Back to top button
    $wp_customize->add_setting('show_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_back_to_top', array(
        'label'   => __('Show Back to Top Button', 'yandexpro'),
        'section' => 'yandexpro_footer',
        'type'    => 'checkbox',
    ));

    /**
     * 7. SOCIAL LINKS SECTION
     */
    $wp_customize->add_section('yandexpro_social', array(
        'title'    => __('Social Links', 'yandexpro'),
        'panel'    => 'yandexpro_theme_settings',
        'priority' => 70,
    ));

    // Enable social links
    $wp_customize->add_setting('enable_social_links', array(
        'default'           => false,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('enable_social_links', array(
        'label'   => __('Enable Social Links', 'yandexpro'),
        'section' => 'yandexpro_social',
        'type'    => 'checkbox',
    ));

    // Social platforms
    $social_platforms = array(
        'vk'        => __('VKontakte', 'yandexpro'),
        'telegram'  => __('Telegram', 'yandexpro'),
        'youtube'   => __('YouTube', 'yandexpro'),
        'twitter'   => __('Twitter', 'yandexpro'),
        'facebook'  => __('Facebook', 'yandexpro'),
        'instagram' => __('Instagram', 'yandexpro'),
        'linkedin'  => __('LinkedIn', 'yandexpro'),
    );

    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting('social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control('social_' . $platform, array(
            'label'           => $label . ' ' . __('URL', 'yandexpro'),
            'section'         => 'yandexpro_social',
            'type'            => 'url',
            'active_callback' => 'yandexpro_is_social_links_enabled',
        ));
    }

    /**
     * 8. BLOG SETTINGS SECTION
     */
    $wp_customize->add_section('yandexpro_blog', array(
        'title'    => __('Blog Settings', 'yandexpro'),
        'panel'    => 'yandexpro_theme_settings',
        'priority' => 80,
    ));

    // Show breadcrumbs
    $wp_customize->add_setting('show_breadcrumbs', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_breadcrumbs', array(
        'label'   => __('Show Breadcrumbs', 'yandexpro'),
        'section' => 'yandexpro_blog',
        'type'    => 'checkbox',
    ));

    // Excerpt length
    $wp_customize->add_setting('excerpt_length', array(
        'default'           => 30,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('excerpt_length', array(
        'label'       => __('Excerpt Length (words)', 'yandexpro'),
        'section'     => 'yandexpro_blog',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 5,
        ),
    ));

    // Blog description
    $wp_customize->add_setting('blog_description', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('blog_description', array(
        'label'   => __('Blog Description', 'yandexpro'),
        'section' => 'yandexpro_blog',
        'type'    => 'text',
    ));

    // Show share buttons
    $wp_customize->add_setting('show_share_buttons', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_share_buttons', array(
        'label'   => __('Show Share Buttons', 'yandexpro'),
        'section' => 'yandexpro_blog',
        'type'    => 'checkbox',
    ));

    // Show author bio
    $wp_customize->add_setting('show_author_bio', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_author_bio', array(
        'label'   => __('Show Author Bio', 'yandexpro'),
        'section' => 'yandexpro_blog',
        'type'    => 'checkbox',
    ));

    // Show related posts
    $wp_customize->add_setting('show_related_posts', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_related_posts', array(
        'label'   => __('Show Related Posts', 'yandexpro'),
        'section' => 'yandexpro_blog',
        'type'    => 'checkbox',
    ));

    // Show post navigation
    $wp_customize->add_setting('show_post_navigation', array(
        'default'           => true,
        'sanitize_callback' => 'yandexpro_sanitize_checkbox',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('show_post_navigation', array(
        'label'   => __('Show Post Navigation', 'yandexpro'),
        'section' => 'yandexpro_blog',
        'type'    => 'checkbox',
    ));
}
add_action('customize_register', 'yandexpro_customize_register');

/**
 * Sanitization functions
 */
function yandexpro_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

function yandexpro_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Active callback functions
 */
function yandexpro_is_custom_color_scheme() {
    return get_theme_mod('color_scheme', 'blue') === 'custom';
}

function yandexpro_is_google_fonts_enabled() {
    return get_theme_mod('enable_google_fonts', false);
}

function yandexpro_is_social_links_enabled() {
    return get_theme_mod('enable_social_links', false);
}

/**
 * Get font choices
 */
function yandexpro_get_font_choices() {
    $fonts = array(
        'system' => __('System Fonts', 'yandexpro'),
    );
    
    if (get_theme_mod('enable_google_fonts', false)) {
        $fonts = array_merge($fonts, array(
            'roboto'     => 'Roboto',
            'open-sans'  => 'Open Sans',
            'lato'       => 'Lato',
            'montserrat' => 'Montserrat',
            'poppins'    => 'Poppins',
            'nunito'     => 'Nunito',
            'inter'      => 'Inter',
        ));
    }
    
    return $fonts;
}

/**
 * Bind JS handlers to Customizer controls
 */
function yandexpro_customize_preview_js() {
    wp_enqueue_script('yandexpro-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), YANDEXPRO_VERSION, true);
}
add_action('customize_preview_init', 'yandexpro_customize_preview_js');

/**
 * CSS output for customizer settings
 */
function yandexpro_customizer_css() {
    $css = '';
    
    // Color scheme
    $color_scheme = get_theme_mod('color_scheme', 'blue');
    if ($color_scheme !== 'blue') {
        $colors = yandexpro_get_color_scheme_colors($color_scheme);
        if ($colors) {
            $css .= ":root {\n";
            foreach ($colors as $property => $color) {
                $css .= "    --color-{$property}: {$color};\n";
            }
            $css .= "}\n";
        }
    }
    
    // Custom colors
    if ($color_scheme === 'custom') {
        $primary_color = get_theme_mod('primary_color', '#2c3e50');
        $accent_color = get_theme_mod('accent_color', '#3498db');
        
        $css .= ":root {\n";
        $css .= "    --color-primary: {$primary_color};\n";
        $css .= "    --color-accent: {$accent_color};\n";
        $css .= "}\n";
    }
    
    // Container width
    $container_width = get_theme_mod('container_width', 1200);
    if ($container_width !== 1200) {
        $css .= ":root {\n";
        $css .= "    --container-main: {$container_width}px;\n";
        $css .= "}\n";
    }
    
    // Font size
    $font_size = get_theme_mod('font_size', 'medium');
    if ($font_size !== 'medium') {
        $font_sizes = array(
            'small' => '14px',
            'large' => '18px',
        );
        
        if (isset($font_sizes[$font_size])) {
            $css .= ":root {\n";
            $css .= "    --font-size-base: {$font_sizes[$font_size]};\n";
            $css .= "}\n";
        }
    }
    
    // Google Fonts
    if (get_theme_mod('enable_google_fonts', false)) {
        $primary_font = get_theme_mod('primary_font', 'system');
        if ($primary_font !== 'system') {
            $font_families = array(
                'roboto'     => "'Roboto', sans-serif",
                'open-sans'  => "'Open Sans', sans-serif",
                'lato'       => "'Lato', sans-serif",
                'montserrat' => "'Montserrat', sans-serif",
                'poppins'    => "'Poppins', sans-serif",
                'nunito'     => "'Nunito', sans-serif",
                'inter'      => "'Inter', sans-serif",
            );
            
            if (isset($font_families[$primary_font])) {
                $css .= ":root {\n";
                $css .= "    --font-family: {$font_families[$primary_font]};\n";
                $css .= "}\n";
            }
        }
    }
    
    // Sticky header
    if (get_theme_mod('sticky_header', false)) {
        $css .= "body { --header-position: sticky; }\n";
        $css .= ".site-header { position: sticky; top: 0; z-index: var(--z-sticky); }\n";
    }
    
    if ($css) {
        echo "<style type=\"text/css\">\n{$css}\n</style>\n";
    }
}
add_action('wp_head', 'yandexpro_customizer_css');

/**
 * Get color scheme colors
 */
function yandexpro_get_color_scheme_colors($scheme) {
    $color_schemes = array(
        'green' => array(
            'primary' => '#2d5a2d',
            'accent'  => '#27ae60',
        ),
        'purple' => array(
            'primary' => '#5a2d5a',
            'accent'  => '#9b59b6',
        ),
        'orange' => array(
            'primary' => '#5a2d2d',
            'accent'  => '#e67e22',
        ),
        'red' => array(
            'primary' => '#5a2d2d',
            'accent'  => '#e74c3c',
        ),
    );
    
    return isset($color_schemes[$scheme]) ? $color_schemes[$scheme] : false;
}

/**
 * Enqueue Google Fonts
 */
function yandexpro_google_fonts() {
    if (!get_theme_mod('enable_google_fonts', false)) {
        return;
    }
    
    $primary_font = get_theme_mod('primary_font', 'system');
    if ($primary_font === 'system') {
        return;
    }
    
    $google_fonts = array(
        'roboto'     => 'Roboto:300,400,500,600,700',
        'open-sans'  => 'Open+Sans:300,400,500,600,700',
        'lato'       => 'Lato:300,400,700',
        'montserrat' => 'Montserrat:300,400,500,600,700',
        'poppins'    => 'Poppins:300,400,500,600,700',
        'nunito'     => 'Nunito:300,400,600,700',
        'inter'      => 'Inter:300,400,500,600,700',
    );
    
    if (isset($google_fonts[$primary_font])) {
        wp_enqueue_style(
            'yandexpro-google-fonts',
            'https://fonts.googleapis.com/css2?family=' . $google_fonts[$primary_font] . '&display=swap',
            array(),
            null
        );
    }
}
add_action('wp_enqueue_scripts', 'yandexpro_google_fonts');

/**
 * Add body classes based on customizer settings
 */
function yandexpro_customizer_body_classes($classes) {
    // Color scheme
    $color_scheme = get_theme_mod('color_scheme', 'blue');
    $classes[] = 'color-scheme-' . $color_scheme;
    
    // Header style
    $header_style = get_theme_mod('header_style', 'default');
    $classes[] = 'header-style-' . $header_style;
    
    // Font size
    $font_size = get_theme_mod('font_size', 'medium');
    $classes[] = 'font-size-' . $font_size;
    
    // Sticky header
    if (get_theme_mod('sticky_header', false)) {
        $classes[] = 'sticky-header';
    }
    
    // Sidebar
    if (!get_theme_mod('show_sidebar', true)) {
        $classes[] = 'no-sidebar';
    }
    
    return $classes;
}
add_filter('body_class', 'yandexpro_customizer_body_classes');

/**
 * Add customizer styles for better preview
 */
function yandexpro_customizer_styles() {
    if (!is_customize_preview()) {
        return;
    }
    ?>
    <style type="text/css">
        /* Customizer preview styles */
        .customize-partial-edit-shortcut {
            position: relative !important;
        }
        
        .customize-partial-edit-shortcut button {
            background: var(--color-accent) !important;
            border-color: var(--color-accent) !important;
        }
        
        /* Live preview animations */
        .customize-partial-refreshing {
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }
        
        /* Hero section preview */
        .hero-section {
            border: 2px dashed transparent;
            transition: border-color 0.3s ease;
        }
        
        .customize-preview .hero-section:hover {
            border-color: var(--color-accent);
        }
    </style>
    <?php
}
add_action('wp_head', 'yandexpro_customizer_styles');

/**
 * Customizer selective refresh
 */
function yandexpro_customize_selective_refresh($wp_customize) {
    // Site title
    $wp_customize->selective_refresh->add_partial('blogname', array(
        'selector'        => '.site-title a',
        'render_callback' => function() {
            return get_bloginfo('name');
        },
    ));
    
    // Site description
    $wp_customize->selective_refresh->add_partial('blogdescription', array(
        'selector'        => '.site-description',
        'render_callback' => function() {
            return get_bloginfo('description');
        },
    ));
    
    // Hero title
    $wp_customize->selective_refresh->add_partial('hero_title', array(
        'selector'        => '.hero-title',
        'render_callback' => function() {
            return get_theme_mod('hero_title', __('Welcome to YandexPro', 'yandexpro'));
        },
    ));
    
    // Hero description
    $wp_customize->selective_refresh->add_partial('hero_description', array(
        'selector'        => '.hero-description',
        'render_callback' => function() {
            return get_theme_mod('hero_description', __('Your trusted source for marketing insights and advertising tips.', 'yandexpro'));
        },
    ));
    
    // Footer copyright
    $wp_customize->selective_refresh->add_partial('footer_copyright', array(
        'selector'        => '.footer-copyright',
        'render_callback' => 'yandexpro_render_footer_copyright',
    ));
}
add_action('customize_register', 'yandexpro_customize_selective_refresh', 20);

/**
 * Render footer copyright for selective refresh
 */
function yandexpro_render_footer_copyright() {
    $custom_copyright = get_theme_mod('footer_copyright', '');
    if ($custom_copyright) {
        return wp_kses_post($custom_copyright);
    } else {
        return '<p>&copy; ' . date('Y') . ' <a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a>. ' . __('All rights reserved.', 'yandexpro') . '</p>';
    }
}

/**
 * Customizer controls scripts
 */
function yandexpro_customize_controls_scripts() {
    wp_enqueue_script(
        'yandexpro-customizer-controls',
        get_template_directory_uri() . '/assets/js/customizer-controls.js',
        array('customize-controls'),
        YANDEXPRO_VERSION,
        true
    );
    
    // Localize script
    wp_localize_script('yandexpro-customizer-controls', 'yandexproCustomizer', array(
        'presets' => array(
            'blue' => array(
                'primary' => '#2c3e50',
                'accent'  => '#3498db',
            ),
            'green' => array(
                'primary' => '#2d5a2d',
                'accent'  => '#27ae60',
            ),
            'purple' => array(
                'primary' => '#5a2d5a',
                'accent'  => '#9b59b6',
            ),
            'orange' => array(
                'primary' => '#5a2d2d',
                'accent'  => '#e67e22',
            ),
            'red' => array(
                'primary' => '#5a2d2d',
                'accent'  => '#e74c3c',
            ),
        ),
    ));
}
add_action('customize_controls_enqueue_scripts', 'yandexpro_customize_controls_scripts');

/**
 * Add reset button to customizer
 */
function yandexpro_customizer_reset_button($wp_customize) {
    $wp_customize->add_section('yandexpro_reset', array(
        'title'    => __('Reset Settings', 'yandexpro'),
        'priority' => 200,
    ));
    
    $wp_customize->add_setting('reset_theme_settings', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('reset_theme_settings', array(
        'label'       => __('Reset all theme settings to defaults', 'yandexpro'),
        'description' => __('Warning: This will reset all customizations. This action cannot be undone.', 'yandexpro'),
        'section'     => 'yandexpro_reset',
        'type'        => 'button',
        'input_attrs' => array(
            'value' => __('Reset Settings', 'yandexpro'),
            'class' => 'button button-secondary yandexpro-reset-button',
        ),
    ));
}
add_action('customize_register', 'yandexpro_customizer_reset_button', 30);

/**
 * Handle settings reset
 */
function yandexpro_handle_customizer_reset() {
    if (!current_user_can('customize')) {
        wp_die(__('You do not have permission to reset theme settings.', 'yandexpro'));
    }
    
    if (!wp_verify_nonce($_POST['_wpnonce'], 'yandexpro_reset_settings')) {
        wp_die(__('Security check failed.', 'yandexpro'));
    }
    
    // Get all theme mods
    $theme_mods = get_theme_mods();
    
    // Remove all YandexPro theme mods
    $yandexpro_settings = array(
        'color_scheme', 'primary_color', 'accent_color', 'enable_dark_theme_toggle',
        'enable_google_fonts', 'primary_font', 'font_size',
        'container_width', 'show_sidebar', 'header_style',
        'show_search_in_header', 'sticky_header', 'show_logo',
        'hero_title', 'hero_description', 'hero_button_text', 'hero_button_link',
        'footer_description', 'footer_copyright', 'show_theme_credit', 'show_back_to_top',
        'enable_social_links', 'social_vk', 'social_telegram', 'social_youtube',
        'social_twitter', 'social_facebook', 'social_instagram', 'social_linkedin',
        'show_breadcrumbs', 'excerpt_length', 'blog_description', 'show_share_buttons',
        'show_author_bio', 'show_related_posts', 'show_post_navigation'
    );
    
    foreach ($yandexpro_settings as $setting) {
        remove_theme_mod($setting);
    }
    
    wp_redirect(admin_url('customize.php?reset=success'));
    exit;
}
add_action('wp_ajax_yandexpro_reset_settings', 'yandexpro_handle_customizer_reset');

/**
 * Export/Import settings
 */
function yandexpro_customizer_export_import($wp_customize) {
    $wp_customize->add_section('yandexpro_export_import', array(
        'title'    => __('Export/Import Settings', 'yandexpro'),
        'priority' => 190,
    ));
    
    // Export settings
    $wp_customize->add_setting('export_settings', array(
        'default' => '',
    ));
    
    $wp_customize->add_control('export_settings', array(
        'label'       => __('Export Settings', 'yandexpro'),
        'description' => __('Click to download your current theme settings.', 'yandexpro'),
        'section'     => 'yandexpro_export_import',
        'type'        => 'button',
        'input_attrs' => array(
            'value' => __('Export Settings', 'yandexpro'),
            'class' => 'button button-primary yandexpro-export-button',
        ),
    ));
    
    // Import settings
    $wp_customize->add_setting('import_settings', array(
        'default' => '',
    ));
    
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'import_settings', array(
        'label'       => __('Import Settings', 'yandexpro'),
        'description' => __('Upload a settings file to restore your customizations.', 'yandexpro'),
        'section'     => 'yandexpro_export_import',
    )));
}
add_action('customize_register', 'yandexpro_customizer_export_import', 25);

/**
 * Get all customizer settings for export
 */
function yandexpro_get_customizer_settings() {
    $settings = array();
    $theme_mods = get_theme_mods();
    
    $yandexpro_settings = array(
        'color_scheme', 'primary_color', 'accent_color', 'enable_dark_theme_toggle',
        'enable_google_fonts', 'primary_font', 'font_size',
        'container_width', 'show_sidebar', 'header_style',
        'show_search_in_header', 'sticky_header', 'show_logo',
        'hero_title', 'hero_description', 'hero_button_text', 'hero_button_link',
        'footer_description', 'footer_copyright', 'show_theme_credit', 'show_back_to_top',
        'enable_social_links', 'social_vk', 'social_telegram', 'social_youtube',
        'social_twitter', 'social_facebook', 'social_instagram', 'social_linkedin',
        'show_breadcrumbs', 'excerpt_length', 'blog_description', 'show_share_buttons',
        'show_author_bio', 'show_related_posts', 'show_post_navigation'
    );
    
    foreach ($yandexpro_settings as $setting) {
        if (isset($theme_mods[$setting])) {
            $settings[$setting] = $theme_mods[$setting];
        }
    }
    
    return $settings;
}

/**
 * Admin notice for successful operations
 */
function yandexpro_customizer_admin_notices() {
    if (isset($_GET['reset']) && $_GET['reset'] === 'success') {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p>' . __('Theme settings have been reset to defaults.', 'yandexpro') . '</p>';
        echo '</div>';
    }
    
    if (isset($_GET['import']) && $_GET['import'] === 'success') {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p>' . __('Theme settings have been imported successfully.', 'yandexpro') . '</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'yandexpro_customizer_admin_notices');