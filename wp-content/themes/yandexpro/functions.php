<?php
/**
 * YandexPRO Blog functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Theme setup
if ( ! function_exists( 'yandexpro_setup' ) ) {
    function yandexpro_setup() {
        // Make theme available for translation
        load_theme_textdomain( 'yandexpro-blog', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Let WordPress manage the document title
        add_theme_support( 'title-tag' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Enable support for responsive embedded content
        add_theme_support( 'responsive-embeds' );

        // Add support for editor styles
        add_theme_support( 'editor-styles' );

        // Enqueue editor styles
        add_editor_style( 'assets/css/main.css' );

        // Add support for wide alignment
        add_theme_support( 'align-wide' );

        // Add support for block styles
        add_theme_support( 'wp-block-styles' );

        // Add support for custom logo
        add_theme_support( 'custom-logo', array(
            'height'      => 100,
            'width'       => 300,
            'flex-height' => true,
            'flex-width'  => true,
        ) );

        // Add support for custom header
        add_theme_support( 'custom-header', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) );

        // Add support for custom background
        add_theme_support( 'custom-background', array(
            'default-color' => 'ffffff',
        ) );

        // Add support for HTML5 markup
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ) );

        // Add support for selective refresh for widgets
        add_theme_support( 'customize-selective-refresh-widgets' );

        // Add support for starter content
        add_theme_support( 'starter-content', array(
            'widgets' => array(
                'sidebar-1' => array(
                    'text_business_info',
                    'search',
                    'text_about',
                ),
            ),
            'posts' => array(
                'home',
                'about' => array(
                    'thumbnail' => '{{image-sandwich}}',
                ),
                'contact' => array(
                    'thumbnail' => '{{image-espresso}}',
                ),
                'blog' => array(
                    'thumbnail' => '{{image-coffee}}',
                ),
            ),
            'nav_menus' => array(
                'primary' => array(
                    'name' => __( 'Primary Menu', 'yandexpro-blog' ),
                    'items' => array(
                        'link_home',
                        'page_about',
                        'page_blog',
                        'page_contact',
                    ),
                ),
            ),
            'options' => array(
                'show_on_front' => 'page',
                'page_on_front' => '{{home}}',
                'page_for_posts' => '{{blog}}',
            ),
        ) );

        // Register navigation menus
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'yandexpro-blog' ),
            'footer'  => __( 'Footer Menu', 'yandexpro-blog' ),
        ) );

        // Add image sizes
        add_image_size( 'yandexpro-featured', 800, 450, true );
        add_image_size( 'yandexpro-card', 400, 250, true );
        add_image_size( 'yandexpro-hero', 1200, 600, true );
    }
}
add_action( 'after_setup_theme', 'yandexpro_setup' );

// Set content width
if ( ! function_exists( 'yandexpro_content_width' ) ) {
    function yandexpro_content_width() {
        $GLOBALS['content_width'] = apply_filters( 'yandexpro_content_width', 1200 );
    }
}
add_action( 'after_setup_theme', 'yandexpro_content_width', 0 );

// Register widget areas
if ( ! function_exists( 'yandexpro_widgets_init' ) ) {
    function yandexpro_widgets_init() {
        register_sidebar( array(
            'name'          => __( 'Sidebar', 'yandexpro-blog' ),
            'id'            => 'sidebar-1',
            'description'   => __( 'Add widgets here.', 'yandexpro-blog' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );

        register_sidebar( array(
            'name'          => __( 'Footer Widgets', 'yandexpro-blog' ),
            'id'            => 'footer-widgets',
            'description'   => __( 'Add widgets here to appear in your footer.', 'yandexpro-blog' ),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
}
add_action( 'widgets_init', 'yandexpro_widgets_init' );

// Enqueue scripts and styles
if ( ! function_exists( 'yandexpro_scripts' ) ) {
    function yandexpro_scripts() {
        $theme_version = wp_get_theme()->get( 'Version' );

        // Enqueue styles
        wp_enqueue_style( 'yandexpro-style', get_stylesheet_uri(), array(), $theme_version );
        wp_enqueue_style( 'yandexpro-main', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version );

        // Enqueue scripts
        wp_enqueue_script( 'yandexpro-script', get_template_directory_uri() . '/assets/js/script.js', array(), $theme_version, true );

        // Enqueue comment reply script
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        // Localize script
        wp_localize_script( 'yandexpro-script', 'yandexpro_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'yandexpro_nonce' ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'yandexpro_scripts' );

// Customizer settings
if ( ! function_exists( 'yandexpro_customize_register' ) ) {
    function yandexpro_customize_register( $wp_customize ) {
        // Colors section
        $wp_customize->add_section( 'yandexpro_colors', array(
            'title'    => __( 'Colors', 'yandexpro-blog' ),
            'priority' => 30,
        ) );

        // Primary color
        $wp_customize->add_setting( 'yandexpro_primary_color', array(
            'default'           => '#7c3aed',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'yandexpro_primary_color', array(
            'label'    => __( 'Primary Color', 'yandexpro-blog' ),
            'section'  => 'yandexpro_colors',
            'settings' => 'yandexpro_primary_color',
        ) ) );

        // Secondary color
        $wp_customize->add_setting( 'yandexpro_secondary_color', array(
            'default'           => '#ec4899',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'yandexpro_secondary_color', array(
            'label'    => __( 'Secondary Color', 'yandexpro-blog' ),
            'section'  => 'yandexpro_colors',
            'settings' => 'yandexpro_secondary_color',
        ) ) );

        // Typography section
        $wp_customize->add_section( 'yandexpro_typography', array(
            'title'    => __( 'Typography', 'yandexpro-blog' ),
            'priority' => 35,
        ) );

        // Font family
        $wp_customize->add_setting( 'yandexpro_font_family', array(
            'default'           => 'system',
            'sanitize_callback' => 'yandexpro_sanitize_select',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( 'yandexpro_font_family', array(
            'label'   => __( 'Font Family', 'yandexpro-blog' ),
            'section' => 'yandexpro_typography',
            'type'    => 'select',
            'choices' => array(
                'system'     => __( 'System Fonts', 'yandexpro-blog' ),
                'inter'      => 'Inter',
                'roboto'     => 'Roboto',
                'open-sans'  => 'Open Sans',
            ),
        ) );

        // Layout section
        $wp_customize->add_section( 'yandexpro_layout', array(
            'title'    => __( 'Layout', 'yandexpro-blog' ),
            'priority' => 40,
        ) );

        // Container width
        $wp_customize->add_setting( 'yandexpro_container_width', array(
            'default'           => '1200',
            'sanitize_callback' => 'absint',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( 'yandexpro_container_width', array(
            'label'       => __( 'Container Width (px)', 'yandexpro-blog' ),
            'section'     => 'yandexpro_layout',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 960,
                'max'  => 1600,
                'step' => 20,
            ),
        ) );

        // Blog layout
        $wp_customize->add_setting( 'yandexpro_blog_layout', array(
            'default'           => 'grid',
            'sanitize_callback' => 'yandexpro_sanitize_select',
        ) );

        $wp_customize->add_control( 'yandexpro_blog_layout', array(
            'label'   => __( 'Blog Layout', 'yandexpro-blog' ),
            'section' => 'yandexpro_layout',
            'type'    => 'select',
            'choices' => array(
                'grid' => __( 'Grid', 'yandexpro-blog' ),
                'list' => __( 'List', 'yandexpro-blog' ),
            ),
        ) );
    }
}
add_action( 'customize_register', 'yandexpro_customize_register' );

// Sanitization functions
if ( ! function_exists( 'yandexpro_sanitize_select' ) ) {
    function yandexpro_sanitize_select( $input, $setting ) {
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
}

// Custom excerpt length
if ( ! function_exists( 'yandexpro_excerpt_length' ) ) {
    function yandexpro_excerpt_length( $length ) {
        return 25;
    }
}
add_filter( 'excerpt_length', 'yandexpro_excerpt_length', 999 );

// Custom excerpt more
if ( ! function_exists( 'yandexpro_excerpt_more' ) ) {
    function yandexpro_excerpt_more( $more ) {
        return '...';
    }
}
add_filter( 'excerpt_more', 'yandexpro_excerpt_more' );

// Add custom body classes
if ( ! function_exists( 'yandexpro_body_classes' ) ) {
    function yandexpro_body_classes( $classes ) {
        // Add class of group-blog to blogs with more than 1 published author
        if ( is_multi_author() ) {
            $classes[] = 'group-blog';
        }

        // Add class of hfeed to non-singular pages
        if ( ! is_singular() ) {
            $classes[] = 'hfeed';
        }

        return $classes;
    }
}
add_filter( 'body_class', 'yandexpro_body_classes' );

// Schema.org markup
if ( ! function_exists( 'yandexpro_schema_markup' ) ) {
    function yandexpro_schema_markup() {
        if ( is_single() ) {
            $post = get_post();
            $schema = array(
                '@context' => 'https://schema.org',
                '@type'    => 'Article',
                'headline' => get_the_title(),
                'author'   => array(
                    '@type' => 'Person',
                    'name'  => get_the_author(),
                ),
                'datePublished' => get_the_date( 'c' ),
                'dateModified'  => get_the_modified_date( 'c' ),
                'description'   => wp_strip_all_tags( get_the_excerpt() ),
                'url'           => get_permalink(),
            );

            if ( has_post_thumbnail() ) {
                $schema['image'] = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
            }

            echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>';
        }
    }
}
add_action( 'wp_head', 'yandexpro_schema_markup' );

// Add skip link
if ( ! function_exists( 'yandexpro_skip_link' ) ) {
    function yandexpro_skip_link() {
        echo '<a class="skip-link screen-reader-text" href="#main">' . __( 'Skip to content', 'yandexpro-blog' ) . '</a>';
    }
}
add_action( 'wp_body_open', 'yandexpro_skip_link' );

// Pagination
if ( ! function_exists( 'yandexpro_pagination' ) ) {
    function yandexpro_pagination() {
        global $wp_query;

        if ( $wp_query->max_num_pages <= 1 ) {
            return;
        }

        $big = 999999999;

        $links = paginate_links( array(
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format'    => '?paged=%#%',
            'current'   => max( 1, get_query_var( 'paged' ) ),
            'total'     => $wp_query->max_num_pages,
            'prev_text' => __( '← Previous', 'yandexpro-blog' ),
            'next_text' => __( 'Next →', 'yandexpro-blog' ),
        ) );

        if ( $links ) {
            echo '<nav class="pagination" role="navigation" aria-label="' . esc_attr__( 'Posts navigation', 'yandexpro-blog' ) . '">';
            echo $links;
            echo '</nav>';
        }
    }
}

// Breadcrumbs
if ( ! function_exists( 'yandexpro_breadcrumbs' ) ) {
    function yandexpro_breadcrumbs() {
        if ( is_home() || is_front_page() ) {
            return;
        }

        $delimiter = ' → ';
        $home = __( 'Home', 'yandexpro-blog' );
        $before = '<span class="current">';
        $after = '</span>';

        echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'yandexpro-blog' ) . '">';
        echo '<a href="' . esc_url( home_url() ) . '">' . $home . '</a>' . $delimiter;

        if ( is_category() ) {
            $cat = get_category( get_query_var( 'cat' ), false );
            if ( $cat->parent != 0 ) {
                echo get_category_parents( $cat->parent, true, $delimiter );
            }
            echo $before . single_cat_title( '', false ) . $after;
        } elseif ( is_day() ) {
            echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $delimiter;
            echo '<a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'F' ) . '</a>' . $delimiter;
            echo $before . get_the_time( 'd' ) . $after;
        } elseif ( is_month() ) {
            echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $delimiter;
            echo $before . get_the_time( 'F' ) . $after;
        } elseif ( is_year() ) {
            echo $before . get_the_time( 'Y' ) . $after;
        } elseif ( is_single() && ! is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object( get_post_type() );
                echo '<a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '">' . $post_type->labels->singular_name . '</a>' . $delimiter;
                echo $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                if ( $cat ) {
                    $cat = $cat[0];
                    echo get_category_parents( $cat, true, $delimiter );
                }
                echo $before . get_the_title() . $after;
            }
        } elseif ( is_page() && ! is_front_page() ) {
            $parent_id = wp_get_post_parent_id( get_the_ID() );
            if ( $parent_id ) {
                $breadcrumbs = array();
                while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse( $breadcrumbs );
                foreach ( $breadcrumbs as $crumb ) {
                    echo $crumb . $delimiter;
                }
            }
            echo $before . get_the_title() . $after;
        } elseif ( is_search() ) {
            echo $before . __( 'Search results for "', 'yandexpro-blog' ) . get_search_query() . '"' . $after;
        } elseif ( is_tag() ) {
            echo $before . __( 'Tag "', 'yandexpro-blog' ) . single_tag_title( '', false ) . '"' . $after;
        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata( $author );
            echo $before . __( 'Articles posted by ', 'yandexpro-blog' ) . $userdata->display_name . $after;
        } elseif ( is_404() ) {
            echo $before . __( 'Error 404', 'yandexpro-blog' ) . $after;
        }

        echo '</nav>';
    }
}

// Add theme support for block patterns
if ( ! function_exists( 'yandexpro_register_block_patterns' ) ) {
    function yandexpro_register_block_patterns() {
        if ( function_exists( 'register_block_pattern_category' ) ) {
            register_block_pattern_category(
                'yandexpro',
                array( 'label' => __( 'YandexPRO', 'yandexpro-blog' ) )
            );
        }

        if ( function_exists( 'register_block_pattern' ) ) {
            // Hero pattern
            register_block_pattern(
                'yandexpro/hero',
                array(
                    'title'       => __( 'Hero Section', 'yandexpro-blog' ),
                    'categories'  => array( 'yandexpro' ),
                    'description' => __( 'Hero section with title, description and CTA button.', 'yandexpro-blog' ),
                    'content'     => '<!-- wp:group {"align":"full","backgroundColor":"light-gray","className":"hero-section"} -->
<div class="wp-block-group alignfull hero-section has-light-gray-background-color has-background"><!-- wp:heading {"textAlign":"center","level":1,"fontSize":"huge"} -->
<h1 class="has-text-align-center has-huge-font-size">Добро пожаловать в YandexPRO</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">Ваш источник экспертных знаний о Яндекс Директ и интернет-маркетинге</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"primary","textColor":"white"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-primary-background-color has-text-color has-background wp-element-button">Читать блог</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
                )
            );

            // Features pattern
            register_block_pattern(
                'yandexpro/features',
                array(
                    'title'       => __( 'Features Grid', 'yandexpro-blog' ),
                    'categories'  => array( 'yandexpro' ),
                    'description' => __( 'Grid of feature cards with icons and descriptions.', 'yandexpro-blog' ),
                    'content'     => '<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">📊 Аналитика</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Глубокий анализ метрик и KPI для максимальной эффективности кампаний</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">🎯 Таргетинг</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Точное попадание в целевую аудиторию с помощью современных инструментов</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="has-text-align-center">⚡ Оптимизация</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Постоянное улучшение показателей и снижение стоимости привлечения клиентов</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
                )
            );
        }
    }
}
add_action( 'init', 'yandexpro_register_block_patterns' );

// Добавим дополнительные функции в functions.php

// Reading time calculation
if ( ! function_exists( 'yandexpro_reading_time' ) ) {
    function yandexpro_reading_time( $post_id = null ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        
        $content = get_post_field( 'post_content', $post_id );
        $word_count = str_word_count( strip_tags( $content ) );
        $reading_time = ceil( $word_count / 200 ); // 200 words per minute
        
        return max( 1, $reading_time );
    }
}

// Post views tracking
if ( ! function_exists( 'yandexpro_get_post_views' ) ) {
    function yandexpro_get_post_views( $post_id = null ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        
        $count = get_post_meta( $post_id, 'post_views_count', true );
        return $count ? $count : '0';
    }
}

if ( ! function_exists( 'yandexpro_set_post_views' ) ) {
    function yandexpro_set_post_views( $post_id = null ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        
        $count = get_post_meta( $post_id, 'post_views_count', true );
        $count = $count ? $count : 0;
        $count++;
        
        update_post_meta( $post_id, 'post_views_count', $count );
    }
}

// Track post views on single posts
add_action( 'wp_head', function() {
    if ( is_single() ) {
        yandexpro_set_post_views();
    }
});

// Related posts function
if ( ! function_exists( 'yandexpro_get_related_posts' ) ) {
    function yandexpro_get_related_posts( $posts_per_page = 3 ) {
        global $post;
        
        $categories = get_the_category( $post->ID );
        $category_ids = array();
        
        if ( $categories ) {
            foreach ( $categories as $category ) {
                $category_ids[] = $category->term_id;
            }
        }
        
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $posts_per_page,
            'post__not_in'   => array( $post->ID ),
            'orderby'        => 'rand',
            'meta_query'     => array(
                array(
                    'key'     => '_thumbnail_id',
                    'compare' => 'EXISTS'
                ),
            ),
        );
        
        if ( ! empty( $category_ids ) ) {
            $args['category__in'] = $category_ids;
        }
        
        return new WP_Query( $args );
    }
}

// AJAX handlers
add_action( 'wp_ajax_newsletter_subscribe', 'yandexpro_newsletter_subscribe' );
add_action( 'wp_ajax_nopriv_newsletter_subscribe', 'yandexpro_newsletter_subscribe' );

function yandexpro_newsletter_subscribe() {
    check_ajax_referer( 'yandexpro_nonce', 'nonce' );
    
    $email = sanitize_email( $_POST['email'] );
    
    if ( ! is_email( $email ) ) {
        wp_die( json_encode( array( 'success' => false, 'message' => 'Invalid email' ) ) );
    }
    
    // Here you would integrate with your email service provider
    // For now, we'll just store in WordPress options
    $subscribers = get_option( 'yandexpro_subscribers', array() );
    
    if ( ! in_array( $email, $subscribers ) ) {
        $subscribers[] = $email;
        update_option( 'yandexpro_subscribers', $subscribers );
        
        // Send confirmation email
        $subject = __( 'Subscription Confirmation - YandexPRO Blog', 'yandexpro-blog' );
        $message = sprintf(
            __( 'Thank you for subscribing to YandexPRO Blog! You will receive updates about Yandex Direct and internet marketing.', 'yandexpro-blog' )
        );
        
        wp_mail( $email, $subject, $message );
    }
    
    wp_die( json_encode( array( 'success' => true ) ) );
}

// Contact form handler
add_action( 'admin_post_contact_form_submit', 'yandexpro_handle_contact_form' );
add_action( 'admin_post_nopriv_contact_form_submit', 'yandexpro_handle_contact_form' );

function yandexpro_handle_contact_form() {
    if ( ! wp_verify_nonce( $_POST['contact_nonce'], 'contact_form' ) ) {
        wp_die( __( 'Security check failed', 'yandexpro-blog' ) );
    }
    
    $name = sanitize_text_field( $_POST['name'] );
    $email = sanitize_email( $_POST['email'] );
    $subject = sanitize_text_field( $_POST['subject'] );
    $message = sanitize_textarea_field( $_POST['message'] );
    
    if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
        wp_redirect( add_query_arg( 'contact', 'error', wp_get_referer() ) );
        exit;
    }
    
    // Send email to admin
    $admin_email = get_option( 'admin_email' );
    $email_subject = sprintf( __( 'New contact form submission: %s', 'yandexpro-blog' ), $subject );
    $email_message = sprintf(
        __( "Name: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s", 'yandexpro-blog' ),
        $name,
        $email,
        $subject,
        $message
    );
    
    $headers = array( 'Reply-To: ' . $email );
    
    if ( wp_mail( $admin_email, $email_subject, $email_message, $headers ) ) {
        wp_redirect( add_query_arg( 'contact', 'success', wp_get_referer() ) );
    } else {
        wp_redirect( add_query_arg( 'contact', 'error', wp_get_referer() ) );
    }
    
    exit;
}

// Custom post meta for featured posts
add_action( 'add_meta_boxes', 'yandexpro_add_meta_boxes' );

function yandexpro_add_meta_boxes() {
    add_meta_box(
        'yandexpro_featured_post',
        __( 'Featured Post', 'yandexpro-blog' ),
        'yandexpro_featured_post_callback',
        'post',
        'side'
    );
}

function yandexpro_featured_post_callback( $post ) {
    wp_nonce_field( 'yandexpro_save_meta', 'yandexpro_meta_nonce' );
    
    $value = get_post_meta( $post->ID, '_featured_post', true );
    
    echo '<label for="featured_post">';
    echo '<input type="checkbox" id="featured_post" name="featured_post" value="1" ' . checked( $value, '1', false ) . ' />';
    echo __( 'Mark as featured post', 'yandexpro-blog' );
    echo '</label>';
}

add_action( 'save_post', 'yandexpro_save_meta' );

function yandexpro_save_meta( $post_id ) {
    if ( ! isset( $_POST['yandexpro_meta_nonce'] ) || ! wp_verify_nonce( $_POST['yandexpro_meta_nonce'], 'yandexpro_save_meta' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    $featured = isset( $_POST['featured_post'] ) ? '1' : '0';
    update_post_meta( $post_id, '_featured_post', $featured );
}

// Customizer live preview
add_action( 'customize_preview_init', 'yandexpro_customize_preview_js' );

function yandexpro_customize_preview_js() {
    wp_enqueue_script(
        'yandexpro-customize-preview',
        get_template_directory_uri() . '/assets/js/customize-preview.js',
        array( 'customize-preview' ),
        wp_get_theme()->get( 'Version' ),
        true
    );
}

// Add body class for blog layout
add_filter( 'body_class', 'yandexpro_blog_layout_class' );

function yandexpro_blog_layout_class( $classes ) {
    $blog_layout = get_theme_mod( 'yandexpro_blog_layout', 'grid' );
    $classes[] = 'blog-layout-' . $blog_layout;
    
    return $classes;
}

// Add custom CSS for customizer settings
add_action( 'wp_head', 'yandexpro_customizer_css' );

function yandexpro_customizer_css() {
    $primary_color = get_theme_mod( 'yandexpro_primary_color', '#7c3aed' );
    $secondary_color = get_theme_mod( 'yandexpro_secondary_color', '#ec4899' );
    $container_width = get_theme_mod( 'yandexpro_container_width', '1200' );
    $font_family = get_theme_mod( 'yandexpro_font_family', 'system' );
    
    $font_stack = 'system';
    switch ( $font_family ) {
        case 'inter':
            $font_stack = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";
            break;
        case 'roboto':
            $font_stack = "'Roboto', -apple-system, BlinkMacSystemFont, sans-serif";
            break;
        case 'open-sans':
            $font_stack = "'Open Sans', -apple-system, BlinkMacSystemFont, sans-serif";
            break;
        default:
            $font_stack = "'Space Grotesk', -apple-system, BlinkMacSystemFont, sans-serif";
            break;
    }
    
    ?>
    <style type="text/css">
        :root {
            --color-primary: <?php echo esc_html( $primary_color ); ?>;
            --color-secondary: <?php echo esc_html( $secondary_color ); ?>;
            --container-width: <?php echo esc_html( $container_width ); ?>px;
            --font-family: <?php echo $font_stack; ?>;
        }
        
        <?php if ( $font_family !== 'system' ) : ?>
        body {
            font-family: var(--font-family);
        }
        <?php endif; ?>
    </style>
    <?php
}

// Enqueue Google Fonts if needed
add_action( 'wp_enqueue_scripts', 'yandexpro_google_fonts' );

function yandexpro_google_fonts() {
    $font_family = get_theme_mod( 'yandexpro_font_family', 'system' );
    
    if ( $font_family !== 'system' ) {
        $font_url = '';
        
        switch ( $font_family ) {
            case 'inter':
                $font_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap';
                break;
            case 'roboto':
                $font_url = 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap';
                break;
            case 'open-sans':
                $font_url = 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap';
                break;
        }
        
        if ( $font_url ) {
            wp_enqueue_style( 'yandexpro-google-fonts', $font_url, array(), null );
        }
    }
}