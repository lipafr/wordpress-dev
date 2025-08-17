<?php
/**
 * Header template
 *
 * @package YandexPro
 * @since 1.0.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip link for accessibility -->
<a class="sr-only" href="#main"><?php esc_html_e('Skip to content', 'yandexpro'); ?></a>

<div id="page" class="site">
    
    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="header-content">
                
                <!-- Site branding -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (display_header_text()) : ?>
                        <div class="site-text">
                            <?php if (is_front_page() && is_home()) : ?>
                                <h1 class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </h1>
                            <?php else : ?>
                                <p class="site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            
                            <?php
                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()) :
                            ?>
                                <p class="site-description"><?php echo $description; ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .site-branding -->
                
                <!-- Primary navigation -->
                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'yandexpro'); ?>">
                    
                    <!-- Mobile menu button -->
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="menu-toggle-text sr-only"><?php esc_html_e('Menu', 'yandexpro'); ?></span>
                        <span class="menu-icon">
                            <span class="menu-line"></span>
                            <span class="menu-line"></span>
                            <span class="menu-line"></span>
                        </span>
                    </button>
                    
                    <!-- Desktop menu -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => 'div',
                        'container_class' => 'menu-primary-container',
                        'fallback_cb'    => 'yandexpro_default_menu',
                    ));
                    ?>
                    
                </nav><!-- #site-navigation -->
                
                <!-- Header actions -->
                <div class="header-actions">
                    
                    <!-- Search toggle -->
                    <?php if (yandexpro_get_theme_option('show_search_in_header', true)) : ?>
                        <button class="search-toggle" aria-controls="search-form" aria-expanded="false">
                            <span class="sr-only"><?php esc_html_e('Search', 'yandexpro'); ?></span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M21 21L16.514 16.506M19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                    
                    <!-- Dark theme toggle -->
                    <?php if (yandexpro_get_theme_option('enable_dark_theme_toggle', false)) : ?>
                        <button class="theme-toggle" aria-label="<?php esc_attr_e('Toggle theme', 'yandexpro'); ?>">
                            <svg class="theme-icon theme-icon-light" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 3V4M12 20V21M4 12H3M6.31412 6.31412L5.5 5.5M17.6859 6.31412L18.5 5.5M6.31412 17.69L5.5 18.5M17.6859 17.69L18.5 18.5M21 12H20M16 12C16 14.2091 14.2091 16 12 16C9.79086 16 8 14.2091 8 12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <svg class="theme-icon theme-icon-dark" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27042C13.0754 1.81116 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6445 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1888 10.9246 21.7296 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z" fill="currentColor"/>
                            </svg>
                        </button>
                    <?php endif; ?>
                    
                </div><!-- .header-actions -->
                
            </div><!-- .header-content -->
            
            <!-- Search form (hidden by default) -->
            <?php if (yandexpro_get_theme_option('show_search_in_header', true)) : ?>
                <div class="header-search" id="header-search" aria-hidden="true">
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
            
        </div><!-- .container -->
    </header><!-- #masthead -->
    
    <!-- Breadcrumbs -->
    <?php if (yandexpro_get_theme_option('show_breadcrumbs', true) && !is_front_page()) : ?>
        <div class="breadcrumbs-wrapper">
            <div class="container">
                <?php yandexpro_breadcrumbs(); ?>
            </div>
        </div>
    <?php endif; ?>

    <div id="content" class="site-content">

<?php
/**
 * Fallback menu when no menu is assigned
 */
if (!function_exists('yandexpro_default_menu')) {
    function yandexpro_default_menu() {
        echo '<div class="menu-primary-container">';
        echo '<ul id="primary-menu" class="nav-menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'yandexpro') . '</a></li>';
        if (get_option('page_for_posts')) {
            echo '<li><a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">' . esc_html__('Blog', 'yandexpro') . '</a></li>';
        }
        wp_list_pages(array(
            'title_li' => '',
            'depth'    => 1,
        ));
        echo '</ul>';
        echo '</div>';
    }
}
?>