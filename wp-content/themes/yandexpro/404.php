<?php
/**
 * 404 Error Page Template
 * 
 * Кастомная страница ошибки 404 с полезной навигацией
 * и предложениями для пользователя
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package YandexPro_Enhanced
 */

get_header();
?>

<!-- 404 Error Page -->
<div class="error-404-page">
    <div class="container">
        <div class="error-404-content">
            
            <!-- Error Hero Section -->
            <div class="error-404-hero">
                <div class="error-404-graphic" aria-hidden="true">
                    <!-- SVG 404 Illustration -->
                    <svg width="300" height="200" viewBox="0 0 300 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- 404 Text -->
                        <text x="150" y="100" font-family="Space Grotesk, sans-serif" font-size="48" font-weight="800" text-anchor="middle" fill="#7c3aed" opacity="0.1">404</text>
                        
                        <!-- Magnifying Glass -->
                        <circle cx="120" cy="80" r="25" stroke="#7c3aed" stroke-width="3" fill="none"/>
                        <line x1="140" y1="100" x2="155" y2="115" stroke="#7c3aed" stroke-width="3" stroke-linecap="round"/>
                        
                        <!-- Question Mark -->
                        <circle cx="180" cy="70" r="3" fill="#ec4899"/>
                        <path d="M180 80 C180 75, 175 70, 170 70 C165 70, 160 75, 160 80" stroke="#ec4899" stroke-width="2" fill="none" stroke-linecap="round"/>
                        
                        <!-- Floating Elements -->
                        <circle cx="80" cy="50" r="4" fill="#7c3aed" opacity="0.3"/>
                        <circle cx="220" cy="130" r="6" fill="#ec4899" opacity="0.3"/>
                        <circle cx="250" cy="60" r="3" fill="#7c3aed" opacity="0.2"/>
                    </svg>
                </div>
                
                <h1 class="error-404-title">
                    <?php esc_html_e( 'Страница не найдена', 'yandexpro' ); ?>
                </h1>
                
                <p class="error-404-description">
                    <?php esc_html_e( 'К сожалению, запрашиваемая страница не существует или была перемещена. Но не расстраивайтесь — мы поможем вам найти то, что вы ищете!', 'yandexpro' ); ?>
                </p>

                <!-- Search Form -->
                <div class="error-404-search">
                    <h2 class="search-title"><?php esc_html_e( 'Попробуйте поиск:', 'yandexpro' ); ?></h2>
                    <form role="search" method="get" class="search-form-404" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <label for="search-404" class="screen-reader-text">
                            <?php esc_html_e( 'Поиск по сайту', 'yandexpro' ); ?>
                        </label>
                        <div class="search-wrapper-404">
                            <input 
                                type="search" 
                                id="search-404"
                                class="search-input-404" 
                                placeholder="<?php esc_attr_e( 'Что вы ищете?', 'yandexpro' ); ?>"
                                value="<?php echo get_search_query(); ?>" 
                                name="s"
                                autocomplete="off"
                            >
                            <button type="submit" class="search-submit-404">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M17.5 17.5L12.5 12.5M14.1667 8.33333C14.1667 11.555 11.555 14.1667 8.33333 14.1667C5.11167 14.1667 2.5 11.555 2.5 8.33333C2.5 5.11167 5.11167 2.5 8.33333 2.5C11.555 2.5 14.1667 5.11167 14.1667 8.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="screen-reader-text"><?php esc_html_e( 'Найти', 'yandexpro' ); ?></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="error-404-actions">
                <h2 class="actions-title"><?php esc_html_e( 'Или выберите один из вариантов:', 'yandexpro' ); ?></h2>
                
                <div class="actions-grid">
                    <!-- Home Button -->
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="action-card action-card-primary">
                        <div class="action-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" stroke="currentColor" stroke-width="2" fill="none"/>
                                <polyline points="9,22 9,12 15,12 15,22" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                        <h3 class="action-title"><?php esc_html_e( 'Главная страница', 'yandexpro' ); ?></h3>
                        <p class="action-description"><?php esc_html_e( 'Вернуться на главную', 'yandexpro' ); ?></p>
                    </a>

                    <!-- Blog Button -->
                    <?php if ( get_option( 'page_for_posts' ) ) : ?>
                        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="action-card">
                            <div class="action-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <polyline points="14,2 14,8 20,8" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <line x1="16" y1="13" x2="8" y2="13" stroke="currentColor" stroke-width="2"/>
                                    <line x1="16" y1="17" x2="8" y2="17" stroke="currentColor" stroke-width="2"/>
                                    <polyline points="10,9 9,9 8,9" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </div>
                            <h3 class="action-title"><?php esc_html_e( 'Блог', 'yandexpro' ); ?></h3>
                            <p class="action-description"><?php esc_html_e( 'Читать статьи', 'yandexpro' ); ?></p>
                        </a>
                    <?php endif; ?>

                    <!-- Contact Button -->
                    <?php
                    $contact_page = get_pages( array(
                        'meta_key' => '_wp_page_template',
                        'meta_value' => 'page-templates/page-contact.php'
                    ) );
                    
                    if ( ! empty( $contact_page ) ) :
                        $contact_url = get_permalink( $contact_page[0]->ID );
                    else :
                        // Fallback - ищем страницу с названием "Контакты"
                        $contact_page = get_page_by_title( 'Контакты' );
                        $contact_url = $contact_page ? get_permalink( $contact_page->ID ) : '#contact';
                    endif;
                    ?>
                    <a href="<?php echo esc_url( $contact_url ); ?>" class="action-card">
                        <div class="action-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                        <h3 class="action-title"><?php esc_html_e( 'Связаться с нами', 'yandexpro' ); ?></h3>
                        <p class="action-description"><?php esc_html_e( 'Задать вопрос', 'yandexpro' ); ?></p>
                    </a>

                    <!-- Back Button -->
                    <a href="javascript:history.back()" class="action-card">
                        <div class="action-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="action-title"><?php esc_html_e( 'Назад', 'yandexpro' ); ?></h3>
                        <p class="action-description"><?php esc_html_e( 'Вернуться на предыдущую страницу', 'yandexpro' ); ?></p>
                    </a>
                </div>
            </div>

            <!-- Popular Content -->
            <div class="error-404-popular">
                <h2 class="popular-title"><?php esc_html_e( 'Популярные статьи', 'yandexpro' ); ?></h2>
                
                <?php
                // Получаем популярные посты
                $popular_posts = get_posts( array(
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
                    'post_status'    => 'publish',
                    'orderby'        => 'comment_count',
                    'order'          => 'DESC',
                    'date_query'     => array(
                        array(
                            'after' => '6 months ago'
                        )
                    ),
                    'no_found_rows'  => true,
                ) );

                // Если нет популярных постов, берем последние
                if ( empty( $popular_posts ) ) {
                    $popular_posts = get_posts( array(
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'no_found_rows'  => true,
                    ) );
                }

                if ( $popular_posts ) :
                ?>
                    <div class="popular-posts-grid">
                        <?php foreach ( $popular_posts as $popular_post ) : 
                            $post_id = $popular_post->ID;
                            $post_url = get_permalink( $post_id );
                            $post_title = get_the_title( $post_id );
                            $post_date = get_the_date( '', $post_id );
                            $categories = get_the_category( $post_id );
                            $primary_category = ! empty( $categories ) ? $categories[0] : null;
                        ?>
                            <article class="popular-post-card">
                                <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                    <div class="popular-post-image">
                                        <a href="<?php echo esc_url( $post_url ); ?>" tabindex="-1" aria-hidden="true">
                                            <?php echo get_the_post_thumbnail( $post_id, 'yandexpro-small-thumb', array(
                                                'loading'  => 'lazy',
                                                'decoding' => 'async',
                                            ) ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="popular-post-content">
                                    <?php if ( $primary_category ) : ?>
                                        <span class="popular-post-category">
                                            <?php echo esc_html( $primary_category->name ); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <h3 class="popular-post-title">
                                        <a href="<?php echo esc_url( $post_url ); ?>">
                                            <?php echo esc_html( $post_title ); ?>
                                        </a>
                                    </h3>
                                    
                                    <time class="popular-post-date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
                                        <?php echo esc_html( $post_date ); ?>
                                    </time>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="popular-posts-footer">
                        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="button button-secondary">
                            <?php esc_html_e( 'Все статьи', 'yandexpro' ); ?>
                        </a>
                    </div>

                <?php else : ?>
                    <p class="no-popular-posts">
                        <?php esc_html_e( 'В данный момент нет опубликованных статей.', 'yandexpro' ); ?>
                    </p>
                <?php endif; wp_reset_postdata(); ?>
            </div>

            <!-- Categories -->
            <?php
            $categories = get_categories( array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => 8,
                'hide_empty' => true,
            ) );
            
            if ( $categories ) :
            ?>
                <div class="error-404-categories">
                    <h2 class="categories-title"><?php esc_html_e( 'Популярные темы', 'yandexpro' ); ?></h2>
                    <div class="categories-list-404">
                        <?php foreach ( $categories as $category ) : ?>
                            <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-link-404">
                                <?php echo esc_html( $category->name ); ?>
                                <span class="category-count" aria-label="<?php echo esc_attr( sprintf( _n( '%d статья', '%d статей', $category->count, 'yandexpro' ), $category->count ) ); ?>">
                                    <?php echo esc_html( $category->count ); ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Help Section -->
            <div class="error-404-help">
                <h2 class="help-title"><?php esc_html_e( 'Нужна помощь?', 'yandexpro' ); ?></h2>
                <div class="help-content">
                    <div class="help-text">
                        <p><?php esc_html_e( 'Если вы считаете, что это ошибка, или у вас есть вопросы, свяжитесь с нами. Мы будем рады помочь!', 'yandexpro' ); ?></p>
                        
                        <!-- Contact Info -->
                        <div class="help-contact">
                            <?php 
                            $contact_email = get_theme_mod( 'contact_email' );
                            $contact_phone = get_theme_mod( 'contact_phone' );
                            
                            if ( $contact_email || $contact_phone ) :
                            ?>
                                <div class="help-contact-info">
                                    <?php if ( $contact_email ) : ?>
                                        <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" class="help-contact-link">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/>
                                            </svg>
                                            <?php echo esc_html( $contact_email ); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ( $contact_phone ) : ?>
                                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>" class="help-contact-link">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" fill="currentColor"/>
                                            </svg>
                                            <?php echo esc_html( $contact_phone ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Report Link -->
                    <div class="help-report">
                        <a href="<?php echo esc_url( $contact_url ?? '#contact' ); ?>" class="button button-primary">
                            <?php esc_html_e( 'Сообщить о проблеме', 'yandexpro' ); ?>
                        </a>
                    </div>
                </div>
            </div>

        </div><!-- .error-404-content -->
    </div><!-- .container -->
</div><!-- .error-404-page -->

<!-- Schema.org markup for 404 page -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "<?php esc_html_e( '404 - Страница не найдена', 'yandexpro' ); ?>",
    "description": "<?php esc_html_e( 'Запрашиваемая страница не найдена. Воспользуйтесь поиском или навигацией по сайту.', 'yandexpro' ); ?>",
    "url": "<?php echo esc_url( home_url( $_SERVER['REQUEST_URI'] ) ); ?>",
    "mainEntity": {
        "@type": "Thing",
        "name": "<?php esc_html_e( 'Ошибка 404', 'yandexpro' ); ?>"
    },
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "<?php esc_html_e( 'Главная', 'yandexpro' ); ?>",
                "item": "<?php echo esc_url( home_url( '/' ) ); ?>"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "<?php esc_html_e( '404 - Страница не найдена', 'yandexpro' ); ?>"
            }
        ]
    }
}
</script>

<?php
get_footer();

/**
 * Логирование 404 ошибок (опционально)
 */
function yandexpro_log_404_error() {
    if ( is_404() && ! is_admin() ) {
        $log_data = array(
            'url'        => $_SERVER['REQUEST_URI'] ?? '',
            'referer'    => $_SERVER['HTTP_REFERER'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? '',
            'timestamp'  => current_time( 'mysql' ),
        );
        
        // Можно логировать в файл или базу данных
        error_log( '404 Error: ' . print_r( $log_data, true ) );
        
        // Или сохранить в опции WordPress для анализа
        $existing_404s = get_option( 'yandexpro_404_log', array() );
        $existing_404s[] = $log_data;
        
        // Ограничиваем лог до 100 последних записей
        if ( count( $existing_404s ) > 100 ) {
            $existing_404s = array_slice( $existing_404s, -100 );
        }
        
        update_option( 'yandexpro_404_log', $existing_404s );
    }
}
add_action( 'wp', 'yandexpro_log_404_error' );
?>