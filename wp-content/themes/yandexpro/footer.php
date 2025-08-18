<?php
/**
 * Подвал сайта для темы YandexPro Enhanced
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package YandexPro_Enhanced
 */

?>

            </main><!-- #main -->
        </div><!-- #content -->
    </div><!-- #page -->

    <!-- Before Footer Widgets Area -->
    <?php if ( is_active_sidebar( 'before-footer' ) ) : ?>
        <div class="before-footer-widgets" role="complementary" aria-label="<?php esc_attr_e( 'Виджеты перед футером', 'yandexpro' ); ?>">
            <div class="container">
                <?php dynamic_sidebar( 'before-footer' ); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Newsletter Section (если не отключена в настройках) -->
    <?php if ( ! get_theme_mod( 'disable_newsletter', false ) && is_front_page() ) : ?>
        <section class="newsletter" role="region" aria-label="<?php esc_attr_e( 'Подписка на рассылку', 'yandexpro' ); ?>">
            <div class="container">
                <div class="newsletter-content">
                    <h2 class="newsletter-title">
                        <?php echo esc_html( get_theme_mod( 'newsletter_title', __( 'Не пропустите новые статьи', 'yandexpro' ) ) ); ?>
                    </h2>
                    <p class="newsletter-description">
                        <?php echo esc_html( get_theme_mod( 'newsletter_description', __( 'Подпишитесь на рассылку и получайте лучшие материалы о контекстной рекламе', 'yandexpro' ) ) ); ?>
                    </p>
                    
                    <?php if ( get_theme_mod( 'newsletter_shortcode' ) ) : ?>
                        <!-- Форма из плагина (например, Mailchimp) -->
                        <?php echo do_shortcode( wp_kses_post( get_theme_mod( 'newsletter_shortcode' ) ) ); ?>
                    <?php else : ?>
                        <!-- Стандартная форма подписки -->
                        <form class="newsletter-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" id="newsletter-form">
                            <div class="newsletter-form-group">
                                <label for="newsletter-email" class="screen-reader-text">
                                    <?php esc_html_e( 'Ваш email адрес', 'yandexpro' ); ?>
                                </label>
                                <input 
                                    type="email" 
                                    id="newsletter-email"
                                    name="newsletter_email" 
                                    class="newsletter-input" 
                                    placeholder="<?php esc_attr_e( 'Ваш email', 'yandexpro' ); ?>"
                                    required
                                    aria-describedby="newsletter-privacy"
                                >
                                <button type="submit" class="newsletter-btn">
                                    <?php esc_html_e( 'Подписаться', 'yandexpro' ); ?>
                                </button>
                            </div>
                            <p id="newsletter-privacy" class="newsletter-privacy">
                                <?php
                                printf(
                                    /* translators: %s: Privacy policy link */
                                    esc_html__( 'Подписываясь, вы соглашаетесь с %s', 'yandexpro' ),
                                    '<a href="' . esc_url( get_privacy_policy_url() ) . '">' . esc_html__( 'политикой конфиденциальности', 'yandexpro' ) . '</a>'
                                );
                                ?>
                            </p>
                            <?php wp_nonce_field( 'newsletter_subscribe', 'newsletter_nonce' ); ?>
                            <input type="hidden" name="action" value="newsletter_subscribe">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Main Footer -->
    <footer class="footer" id="colophon" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                
                <!-- Footer Main Content -->
                <div class="footer-main">
                    <!-- Footer Branding -->
                    <div class="footer-brand">
                        <?php
                        // Логотип или название сайта
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        if ( $custom_logo_id ) {
                            $logo_image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
                            printf(
                                '<a href="%1$s" class="footer-logo" rel="home">
                                    <img src="%2$s" alt="%3$s" class="footer-logo-img" loading="lazy" decoding="async">
                                </a>',
                                esc_url( home_url( '/' ) ),
                                esc_url( $logo_image[0] ),
                                esc_attr( get_bloginfo( 'name' ) )
                            );
                        } else {
                            printf(
                                '<a href="%1$s" class="footer-logo-text" rel="home">%2$s</a>',
                                esc_url( home_url( '/' ) ),
                                esc_html( get_bloginfo( 'name' ) )
                            );
                        }
                        ?>

                        <!-- Footer Description -->
                        <?php 
                        $footer_description = get_theme_mod( 'footer_description', get_bloginfo( 'description' ) );
                        if ( $footer_description ) :
                        ?>
                            <p class="footer-description">
                                <?php echo wp_kses_post( $footer_description ); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Social Links -->
                        <?php if ( get_theme_mod( 'enable_social_links', false ) ) : ?>
                            <div class="footer-social" role="group" aria-label="<?php esc_attr_e( 'Социальные сети', 'yandexpro' ); ?>">
                                <?php yandexpro_social_links(); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Navigation/Widgets -->
                    <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                        <div class="footer-nav">
                            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                                <?php if ( is_active_sidebar( "footer-{$i}" ) ) : ?>
                                    <div class="footer-column footer-column-<?php echo esc_attr( $i ); ?>">
                                        <?php dynamic_sidebar( "footer-{$i}" ); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    <?php else : ?>
                        <!-- Fallback Navigation если виджеты не настроены -->
                        <div class="footer-nav">
                            <div class="footer-column">
                                <h3 class="footer-title"><?php esc_html_e( 'Услуги', 'yandexpro' ); ?></h3>
                                <ul class="footer-links">
                                    <li><a href="#"><?php esc_html_e( 'Яндекс Директ', 'yandexpro' ); ?></a></li>
                                    <li><a href="#"><?php esc_html_e( 'Google Ads', 'yandexpro' ); ?></a></li>
                                    <li><a href="#"><?php esc_html_e( 'Аналитика', 'yandexpro' ); ?></a></li>
                                    <li><a href="#"><?php esc_html_e( 'Консультации', 'yandexpro' ); ?></a></li>
                                </ul>
                            </div>

                            <div class="footer-column">
                                <h3 class="footer-title"><?php esc_html_e( 'Материалы', 'yandexpro' ); ?></h3>
                                <ul class="footer-links">
                                    <li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Блог', 'yandexpro' ); ?></a></li>
                                    <li><a href="#"><?php esc_html_e( 'Кейсы', 'yandexpro' ); ?></a></li>
                                    <li><a href="#"><?php esc_html_e( 'Инструменты', 'yandexpro' ); ?></a></li>
                                    <li><a href="#"><?php esc_html_e( 'Гайды', 'yandexpro' ); ?></a></li>
                                </ul>
                            </div>

                            <div class="footer-column">
                                <h3 class="footer-title"><?php esc_html_e( 'Контакты', 'yandexpro' ); ?></h3>
                                <div class="footer-contact">
                                    <?php if ( $email = get_theme_mod( 'contact_email' ) ) : ?>
                                        <div class="contact-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                            </svg>
                                            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( $phone = get_theme_mod( 'contact_phone' ) ) : ?>
                                        <div class="contact-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                            </svg>
                                            <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '-', '(', ')' ), '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( $address = get_theme_mod( 'contact_address' ) ) : ?>
                                        <div class="contact-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                            </svg>
                                            <span><?php echo esc_html( $address ); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer Bottom -->
                <div class="footer-bottom">
                    <div class="footer-copyright">
                        <p>
                            <?php
                            // Пользовательский текст копирайта или стандартный
                            $copyright_text = get_theme_mod( 'footer_text' );
                            if ( $copyright_text ) {
                                echo wp_kses_post( $copyright_text );
                            } else {
                                printf(
                                    /* translators: 1: Copyright symbol, 2: Current year, 3: Site name */
                                    esc_html__( '%1$s %2$s %3$s. Все права защищены.', 'yandexpro' ),
                                    '&copy;',
                                    esc_html( date_i18n( 'Y' ) ),
                                    esc_html( get_bloginfo( 'name' ) )
                                );
                            }
                            ?>
                        </p>
                    </div>

                    <div class="footer-legal">
                        <!-- Footer Menu -->
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                            'fallback_cb'    => 'yandexpro_footer_fallback_menu'
                        ) );
                        ?>

                        <!-- Theme Credit (если включен в настройках) -->
                        <?php if ( get_theme_mod( 'show_theme_credit', true ) ) : ?>
                            <p class="theme-credit">
                                <?php
                                printf(
                                    /* translators: %s: Theme name with link */
                                    esc_html__( 'Тема %s', 'yandexpro' ),
                                    '<a href="https://github.com/yandexpro/wordpress-theme" target="_blank" rel="noopener noreferrer">YandexPro Enhanced</a>'
                                );
                                ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

    <!-- Back to Top Button (если включена в настройках) -->
    <?php if ( get_theme_mod( 'show_back_to_top', true ) ) : ?>
        <button class="back-to-top" id="back-to-top" aria-label="<?php esc_attr_e( 'Вернуться наверх', 'yandexpro' ); ?>" style="display: none;">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M15 12.5L10 7.5L5 12.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="screen-reader-text"><?php esc_html_e( 'Вернуться наверх', 'yandexpro' ); ?></span>
        </button>
    <?php endif; ?>

    <?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * Fallback меню для футера
 */
function yandexpro_footer_fallback_menu() {
    echo '<ul class="footer-menu">';
    
    // Политика конфиденциальности
    if ( get_privacy_policy_url() ) {
        printf(
            '<li><a href="%s">%s</a></li>',
            esc_url( get_privacy_policy_url() ),
            esc_html__( 'Политика конфиденциальности', 'yandexpro' )
        );
    }
    
    // Пользовательское соглашение (если есть)
    $terms_page = get_theme_mod( 'terms_page' );
    if ( $terms_page ) {
        printf(
            '<li><a href="%s">%s</a></li>',
            esc_url( get_permalink( $terms_page ) ),
            esc_html__( 'Пользовательское соглашение', 'yandexpro' )
        );
    }
    
    echo '</ul>';
}

/**
 * Вывод социальных ссылок
 */
function yandexpro_social_links() {
    $social_networks = array(
        'vk' => array(
            'label' => 'ВКонтакте',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zm3.692 17.123h-1.744c-.66 0-.864-.525-2.05-1.727-1.033-1.01-1.49-.834-1.49.18v1.57c0 .394-.127.506-.807.506-1.677 0-3.54-1.028-4.856-2.944C6.695 11.008 6.25 7.5 6.25 7.5s-.102-.31.36-.31h1.868c.5 0 .69.22.885.737.9 2.4 2.4 4.5 3.024 3.065.188-.434.274-1.41-.01-2.17-.24-.673-.634-.71-.634-1.436 0-.31.188-.6.49-.6h2.95c.414 0 .56.216.56.558v2.99c0 .414.188 1.23.862 1.23.688 0 1.23-.414 2.482-1.678 1.2-1.2 2.07-3.066 2.07-3.066s.188-.414.482-.438h1.744c.966 0 .12.482-.188 1.09-.36.726-1.644 2.538-1.644 2.538-.414.6-.345.867 0 1.4.258.398 1.102 1.102 1.67 1.782.66.78.12 1.2-.24 1.2z"/></svg>',
        ),
        'telegram' => array(
            'label' => 'Telegram',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.13-.31-1.09-.66.03-.18.14-.37.33-.56 1.31-1.15 2.73-2.17 4.25-3.06 2.34-1.09 4.99-2.04 7.94-2.85.71-.2 1.36-.02 1.79.6z"/></svg>',
        ),
        'youtube' => array(
            'label' => 'YouTube',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
        ),
        'twitter' => array(
            'label' => 'Twitter',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
        ),
        'facebook' => array(
            'label' => 'Facebook',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        ),
        'instagram' => array(
            'label' => 'Instagram',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        ),
        'linkedin' => array(
            'label' => 'LinkedIn',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
        ),
    );

    foreach ( $social_networks as $network => $data ) {
        $url = get_theme_mod( "social_{$network}" );
        if ( $url ) {
            printf(
                '<a href="%1$s" class="social-link social-link-%2$s" target="_blank" rel="noopener noreferrer" aria-label="%3$s">
                    %4$s
                </a>',
                esc_url( $url ),
                esc_attr( $network ),
                esc_attr( sprintf( __( 'Мы в %s', 'yandexpro' ), $data['label'] ) ),
                $data['icon']
            );
        }
    }
}
?>