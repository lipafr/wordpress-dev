<?php
/**
 * Футер сайта YandexPro
 * HTML структура точно по макету updated_blog_homepage_fixed (6).html
 *
 * @package YandexPro
 * @since 1.0.0
 */
?>

    </div><!-- #content -->

    <!-- Newsletter секция перед футером (как в макете) -->
    <?php if (is_front_page() || is_home()) : ?>
        <section class="newsletter">
            <div class="container">
                <h2><?php esc_html_e('Не пропустите новые статьи', 'yandexpro'); ?></h2>
                <p><?php esc_html_e('Подпишитесь на рассылку и получайте лучшие материалы о контекстной рекламе', 'yandexpro'); ?></p>
                
                <form class="newsletter-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('yandexpro_newsletter', 'newsletter_nonce'); ?>
                    <input type="hidden" name="action" value="yandexpro_newsletter_signup">
                    
                    <input type="email" 
                           class="newsletter-input" 
                           name="newsletter_email"
                           placeholder="<?php esc_attr_e('Ваш email', 'yandexpro'); ?>"
                           required>
                    
                    <button type="submit" class="newsletter-btn">
                        <?php esc_html_e('Подписаться', 'yandexpro'); ?>
                    </button>
                </form>
            </div>
        </section>
    <?php endif; ?>

    <!-- Footer точно как в макете -->
    <footer id="colophon" class="site-footer footer">
        <div class="container">
            <div class="footer-content">
                
                <!-- Основной контент футера -->
                <div class="footer-main">
                    
                    <!-- Левая колонка - брендинг -->
                    <div class="footer-brand">
                        <?php if (has_custom_logo()) : ?>
                            <div class="footer-logo-wrapper">
                                <?php the_custom_logo(); ?>
                            </div>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo">
                                <?php 
                                $site_name = get_bloginfo('name');
                                echo $site_name ? esc_html($site_name) : 'YandexPRO';
                                ?>
                            </a>
                        <?php endif; ?>
                        
                        <p class="footer-description">
                            <?php 
                            $description = get_bloginfo('description');
                            if ($description) {
                                echo esc_html($description);
                            } else {
                                esc_html_e('Экспертиза в контекстной рекламе и интернет-маркетинге. Помогаем бизнесу расти с помощью эффективных рекламных кампаний.', 'yandexpro');
                            }
                            ?>
                        </p>
                        
                        <!-- Социальные сети -->
                        <div class="footer-social">
                            <a href="#" class="social-link" aria-label="<?php esc_attr_e('Telegram', 'yandexpro'); ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.13-.31-1.09-.66.03-.18.14-.37.33-.56 1.31-1.15 2.73-2.17 4.25-3.06 2.34-1.09 4.99-2.04 7.94-2.85.71-.2 1.36-.02 1.79.6z"/>
                                </svg>
                            </a>
                            
                            <a href="#" class="social-link" aria-label="<?php esc_attr_e('YouTube', 'yandexpro'); ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            
                            <a href="#" class="social-link" aria-label="<?php esc_attr_e('LinkedIn', 'yandexpro'); ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            
                            <a href="#" class="social-link" aria-label="<?php esc_attr_e('VK', 'yandexpro'); ?>">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zm3.692 17.123h-1.744c-.66 0-.864-.525-2.05-1.727-1.033-1.01-1.49-.834-1.49.18v1.57c0 .394-.127.506-.807.506-1.677 0-3.54-1.028-4.856-2.944C6.695 11.008 6.25 7.5 6.25 7.5s-.102-.31.36-.31h1.868c.5 0 .69.22.885.737.9 2.4 2.4 4.5 3.024 3.065.188-.434.274-1.41-.01-2.17-.24-.673-.634-.71-.634-1.436 0-.31.188-.6.49-.6h2.95c.414 0 .56.216.56.558v2.99c0 .414.188 1.23.862 1.23.688 0 1.23-.414 2.482-1.678 1.2-1.2 2.07-3.066 2.07-3.066s.188-.414.482-.438h1.744c.966 0 .12.482-.188 1.09-.36.726-1.644 2.538-1.644 2.538-.414.6-.345.867 0 1.4.258.398 1.102 1.102 1.67 1.782.66.78.12 1.2-.24 1.2z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Правая колонка - меню навигации -->
                    <div class="footer-nav">
                        
                        <!-- Услуги -->
                        <div class="footer-column">
                            <h3 class="footer-title"><?php esc_html_e('Услуги', 'yandexpro'); ?></h3>
                            <?php if (is_active_sidebar('footer-1')) : ?>
                                <?php dynamic_sidebar('footer-1'); ?>
                            <?php else : ?>
                                <ul class="footer-links">
                                    <li><a href="#"><?php esc_html_e('Яндекс Директ', 'yandexpro'); ?></a></li>
                                    <li><a href="#"><?php esc_html_e('Google Ads', 'yandexpro'); ?></a></li>
                                    <li><a href="#"><?php esc_html_e('Аналитика', 'yandexpro'); ?></a></li>
                                    <li><a href="#"><?php esc_html_e('Аудит рекламы', 'yandexpro'); ?></a></li>
                                    <li><a href="#"><?php esc_html_e('Консультации', 'yandexpro'); ?></a></li>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Материалы -->
                        <div class="footer-column">
                            <h3 class="footer-title"><?php esc_html_e('Материалы', 'yandexpro'); ?></h3>
                            <?php if (is_active_sidebar('footer-2')) : ?>
                                <?php dynamic_sidebar('footer-2'); ?>
                            <?php else : ?>
                                <ul class="footer-links">
                                    <li><a href="<?php echo esc_url(home_url('/category/cases')); ?>"><?php esc_html_e('Кейсы', 'yandexpro'); ?></a></li>
                                    <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Блог', 'yandexpro'); ?></a></li>
                                    <li><a href="#"><?php esc_html_e('Инструменты', 'yandexpro'); ?></a></li>
                                    <li><a href="#"><?php esc_html_e('Гайды', 'yandexpro'); ?></a></li>
                                    <li><a href="#"><?php esc_html_e('Чек-листы', 'yandexpro'); ?></a></li>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- Контакты -->
                        <div class="footer-column">
                            <h3 class="footer-title"><?php esc_html_e('Контакты', 'yandexpro'); ?></h3>
                            <?php if (is_active_sidebar('footer-3')) : ?>
                                <?php dynamic_sidebar('footer-3'); ?>
                            <?php else : ?>
                                <div class="footer-contact">
                                    <div class="contact-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                        </svg>
                                        <a href="mailto:hello@yandexpro.ru">hello@yandexpro.ru</a>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                        </svg>
                                        <a href="tel:+74951234567">+7 (495) 123-45-67</a>
                                    </div>
                                    
                                    <div class="contact-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                        </svg>
                                        <span><?php esc_html_e('Москва, Россия', 'yandexpro'); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                    </div>
                </div>

                <!-- Нижняя часть футера -->
                <div class="footer-bottom">
                    <div class="footer-copyright">
                        <p>
                            <?php
                            printf(
                                esc_html__('© %1$s %2$s. %3$s', 'yandexpro'),
                                date('Y'),
                                get_bloginfo('name') ?: 'YandexPRO',
                                esc_html__('Все права защищены.', 'yandexpro')
                            );
                            ?>
                        </p>
                    </div>
                    
                    <div class="footer-legal">
                        <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">
                            <?php esc_html_e('Политика конфиденциальности', 'yandexpro'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/terms')); ?>">
                            <?php esc_html_e('Пользовательское соглашение', 'yandexpro'); ?>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </footer>

</div><!-- #page -->

<!-- Back to Top кнопка (из макета) -->
<div class="back-to-top" id="back-to-top">
    <button class="back-to-top-button" aria-label="<?php esc_attr_e('Наверх', 'yandexpro'); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
    </button>
</div>

<?php wp_footer(); ?>

</body>
</html>