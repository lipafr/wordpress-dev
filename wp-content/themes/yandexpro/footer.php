<?php
/**
 * Footer template
 *
 * @package YandexPro
 * @since 1.0.0
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        
        <!-- Footer widgets area -->
        <?php if (is_active_sidebar('footer-1')) : ?>
            <div class="footer-widgets">
                <div class="container">
                    <div class="footer-widgets-grid">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Main footer content -->
        <div class="footer-main">
            <div class="container">
                <div class="footer-content">
                    
                    <!-- Footer info -->
                    <div class="footer-info">
                        
                        <!-- Site branding in footer -->
                        <div class="footer-branding">
                            <?php if (has_custom_logo()) : ?>
                                <div class="footer-logo">
                                    <?php the_custom_logo(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="footer-text">
                                <h3 class="footer-site-title">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                </h3>
                                
                                <?php
                                $footer_description = yandexpro_get_theme_option('footer_description', get_bloginfo('description'));
                                if ($footer_description) :
                                ?>
                                    <p class="footer-description"><?php echo esc_html($footer_description); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Social links -->
                        <?php if (yandexpro_get_theme_option('enable_social_links', false)) : ?>
                            <div class="footer-social">
                                <h4 class="footer-social-title"><?php esc_html_e('Follow us', 'yandexpro'); ?></h4>
                                <div class="social-links">
                                    <?php
                                    $social_links = array(
                                        'vk'        => yandexpro_get_theme_option('social_vk', ''),
                                        'telegram'  => yandexpro_get_theme_option('social_telegram', ''),
                                        'youtube'   => yandexpro_get_theme_option('social_youtube', ''),
                                        'twitter'   => yandexpro_get_theme_option('social_twitter', ''),
                                        'facebook'  => yandexpro_get_theme_option('social_facebook', ''),
                                        'instagram' => yandexpro_get_theme_option('social_instagram', ''),
                                        'linkedin'  => yandexpro_get_theme_option('social_linkedin', ''),
                                    );
                                    
                                    foreach ($social_links as $platform => $url) :
                                        if (!empty($url)) :
                                    ?>
                                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="social-link social-<?php echo esc_attr($platform); ?>" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>">
                                            <?php echo yandexpro_get_social_icon($platform); ?>
                                        </a>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    </div><!-- .footer-info -->
                    
                    <!-- Footer navigation -->
                    <?php if (has_nav_menu('footer')) : ?>
                        <nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e('Footer menu', 'yandexpro'); ?>">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'menu_id'        => 'footer-menu',
                                'menu_class'     => 'footer-nav-menu',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            ));
                            ?>
                        </nav>
                    <?php endif; ?>
                    
                </div><!-- .footer-content -->
            </div><!-- .container -->
        </div><!-- .footer-main -->
        
        <!-- Footer bottom bar -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    
                    <!-- Copyright -->
                    <div class="footer-copyright">
                        <?php
                        $custom_copyright = yandexpro_get_theme_option('footer_copyright', '');
                        if ($custom_copyright) :
                            echo wp_kses_post($custom_copyright);
                        else :
                        ?>
                            <p>&copy; <?php echo date('Y'); ?> 
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <?php bloginfo('name'); ?>
                                </a>. 
                                <?php esc_html_e('All rights reserved.', 'yandexpro'); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Theme credit -->
                    <?php if (yandexpro_get_theme_option('show_theme_credit', true)) : ?>
                        <div class="footer-credit">
                            <p>
                                <?php
                                printf(
                                    esc_html__('Theme %1$s by %2$s', 'yandexpro'),
                                    '<a href="https://example.com/yandexpro-theme" target="_blank" rel="noopener">YandexPro</a>',
                                    '<a href="https://yandexpro.com" target="_blank" rel="noopener">YandexPro Team</a>'
                                );
                                ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    
                </div><!-- .footer-bottom-content -->
            </div><!-- .container -->
        </div><!-- .footer-bottom -->
        
        <!-- Back to top button -->
        <?php if (yandexpro_get_theme_option('show_back_to_top', true)) : ?>
            <button class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'yandexpro'); ?>" style="display: none;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 19V5M5 12L12 5L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        <?php endif; ?>
        
    </footer><!-- #colophon -->
    
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

<?php
/**
 * Get social media icon SVG
 */
if (!function_exists('yandexpro_get_social_icon')) {
    function yandexpro_get_social_icon($platform) {
        $icons = array(
            'vk' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zm3.692 17.123h-1.744c-.66 0-.864-.525-2.05-1.727-1.033-1.01-1.49-.856-1.49.239v1.727c0 .464-.15.748-1.38.748-2.05 0-4.32-1.24-5.928-3.54C5.196 10.308 4.592 6.76 6.86 6.76c.628 0 .864.338 1.155 1.008.393.9.844 1.774 1.387 2.611.39.6.615.748.848.748.233 0 .465-.15.465-.988V8.1c-.078-1.395-.915-1.513-.915-2.006 0-.262.21-.525.554-.525h2.744c.554 0 .758.3.758.974v3.3c0 .555.247.758.405.758.233 0 .465-.203.93-.668 1.17-1.163 2.006-2.97 2.006-2.97.157-.338.448-.645.916-.645h1.744c1.19 0 1.133.615.758 1.455-.75 1.673-3.396 4.643-3.396 4.643-.3.405-.233.615 0 1.02.165.285 1.042 1.027 1.577 1.652.9 1.073 1.577 1.97.525 1.97z"/></svg>',
            
            'telegram' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.374 0 0 5.373 0 12s5.374 12 12 12 12-5.373 12-12S18.626 0 12 0zm5.568 8.16c-.18 1.896-.962 6.502-1.359 8.627-.168.9-.499 1.201-.82 1.23-.697.064-1.226-.461-1.901-.903-1.056-.692-1.653-1.123-2.678-1.799-1.185-.781-.417-1.21.258-1.911.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
            
            'youtube' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
            
            'twitter' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
            
            'facebook' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            
            'instagram' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
            
            'linkedin' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
        );
        
        return isset($icons[$platform]) ? $icons[$platform] : '';
    }
}