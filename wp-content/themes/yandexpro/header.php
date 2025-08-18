<?php
/**
 * Шапка сайта для темы YandexPro Enhanced
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package YandexPro_Enhanced
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Skip link для доступности -->
    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Перейти к содержимому', 'yandexpro' ); ?></a>

    <!-- Header -->
    <header class="header" id="masthead" role="banner">
        <nav class="container" role="navigation" aria-label="<?php esc_attr_e( 'Основное меню', 'yandexpro' ); ?>">
            <div class="nav">
                <!-- Logo / Site Branding -->
                <div class="site-branding">
                    <?php
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    
                    if ( $custom_logo_id ) {
                        $logo_image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
                        printf(
                            '<a href="%1$s" class="logo custom-logo-link" rel="home" aria-current="page">
                                <img src="%2$s" alt="%3$s" class="custom-logo" loading="eager" decoding="async">
                            </a>',
                            esc_url( home_url( '/' ) ),
                            esc_url( $logo_image[0] ),
                            esc_attr( get_bloginfo( 'name' ) )
                        );
                    } else {
                        printf(
                            '<a href="%1$s" class="logo" rel="home" aria-current="page">%2$s</a>',
                            esc_url( home_url( '/' ) ),
                            esc_html( get_bloginfo( 'name' ) )
                        );
                    }
                    ?>
                </div>

                <!-- Desktop Navigation Menu -->
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'depth'          => 2,
                    'fallback_cb'    => 'yandexpro_fallback_menu'
                ) );
                ?>

                <!-- Header Search (если включен в Customizer) -->
                <?php if ( get_theme_mod( 'show_header_search', false ) ) : ?>
                    <div class="header-search">
                        <button class="search-toggle" aria-label="<?php esc_attr_e( 'Открыть поиск', 'yandexpro' ); ?>">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.5 17.5L12.5 12.5M14.1667 8.33333C14.1667 11.555 11.555 14.1667 8.33333 14.1667C5.11167 14.1667 2.5 11.555 2.5 8.33333C2.5 5.11167 5.11167 2.5 8.33333 2.5C11.555 2.5 14.1667 5.11167 14.1667 8.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="header-search-form">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mobile menu toggle -->
                <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Открыть меню', 'yandexpro' ); ?>" aria-expanded="false" aria-controls="mobile-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <!-- Mobile Navigation Menu -->
            <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'mobile-primary-menu',
                    'menu_class'     => 'mobile-menu-list',
                    'container'      => false,
                    'depth'          => 2,
                    'fallback_cb'    => 'yandexpro_mobile_fallback_menu'
                ) );
                ?>
                
                <!-- Mobile Search -->
                <div class="mobile-search">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </nav>
    </header><!-- #masthead -->

    <!-- Main Content Area -->
    <div id="page" class="site">
        <div id="content" class="site-content">
            <main id="main" class="site-main" role="main"><?php
/**
 * Fallback меню для десктопа если меню не назначено
 */
function yandexpro_fallback_menu() {
    echo '<ul class="nav-menu">';
    
    // Главная
    printf(
        '<li><a href="%s"%s>%s</a></li>',
        esc_url( home_url( '/' ) ),
        ( is_front_page() ? ' class="active"' : '' ),
        esc_html__( 'Главная', 'yandexpro' )
    );
    
    // Блог
    $blog_page_id = get_option( 'page_for_posts' );
    if ( $blog_page_id ) {
        printf(
            '<li><a href="%s"%s>%s</a></li>',
            esc_url( get_permalink( $blog_page_id ) ),
            ( is_home() || is_category() || is_tag() || is_single() ? ' class="active"' : '' ),
            esc_html__( 'Блог', 'yandexpro' )
        );
    }
    
    // Страницы
    $pages = get_pages( array( 'sort_column' => 'menu_order' ) );
    foreach ( $pages as $page ) {
        if ( $page->ID !== $blog_page_id && $page->ID !== get_option( 'page_on_front' ) ) {
            printf(
                '<li><a href="%s"%s>%s</a></li>',
                esc_url( get_permalink( $page->ID ) ),
                ( is_page( $page->ID ) ? ' class="active"' : '' ),
                esc_html( $page->post_title )
            );
        }
    }
    
    echo '</ul>';
}

/**
 * Fallback меню для мобильной версии
 */
function yandexpro_mobile_fallback_menu() {
    echo '<ul class="mobile-menu-list">';
    
    // Главная
    printf(
        '<li><a href="%s"%s>%s</a></li>',
        esc_url( home_url( '/' ) ),
        ( is_front_page() ? ' class="active"' : '' ),
        esc_html__( 'Главная', 'yandexpro' )
    );
    
    // Блог
    $blog_page_id = get_option( 'page_for_posts' );
    if ( $blog_page_id ) {
        printf(
            '<li><a href="%s"%s>%s</a></li>',
            esc_url( get_permalink( $blog_page_id ) ),
            ( is_home() || is_category() || is_tag() || is_single() ? ' class="active"' : '' ),
            esc_html__( 'Блог', 'yandexpro' )
        );
    }
    
    // Страницы
    $pages = get_pages( array( 'sort_column' => 'menu_order' ) );
    foreach ( $pages as $page ) {
        if ( $page->ID !== $blog_page_id && $page->ID !== get_option( 'page_on_front' ) ) {
            printf(
                '<li><a href="%s"%s>%s</a></li>',
                esc_url( get_permalink( $page->ID ) ),
                ( is_page( $page->ID ) ? ' class="active"' : '' ),
                esc_html( $page->post_title )
            );
        }
    }
    
    echo '</ul>';
}
?>