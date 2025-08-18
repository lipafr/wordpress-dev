<?php
/**
 * Template Name: Лендинг
 * 
 * Полноширинный шаблон лендинговой страницы
 * Основан на дизайне из макета YandexPro
 *
 * @package YandexPro_Enhanced
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero landing-hero" role="banner">
    <div class="container">
        <div class="hero-content">
            <?php while ( have_posts() ) : the_post(); ?>
                
                <!-- Custom Hero или контент страницы -->
                <?php
                $custom_hero_title = get_post_meta( get_the_ID(), '_yandexpro_hero_title', true );
                $custom_hero_subtitle = get_post_meta( get_the_ID(), '_yandexpro_hero_subtitle', true );
                $custom_hero_button_text = get_post_meta( get_the_ID(), '_yandexpro_hero_button_text', true );
                $custom_hero_button_url = get_post_meta( get_the_ID(), '_yandexpro_hero_button_url', true );
                ?>
                
                <h1 class="hero-title">
                    <?php if ( $custom_hero_title ) : ?>
                        <?php echo wp_kses_post( $custom_hero_title ); ?>
                    <?php else : ?>
                        <?php echo wp_kses_post( get_theme_mod( 'hero_title', get_the_title() ) ); ?>
                    <?php endif; ?>
                </h1>
                
                <?php if ( $custom_hero_subtitle || get_theme_mod( 'hero_description' ) ) : ?>
                    <p class="hero-description">
                        <?php if ( $custom_hero_subtitle ) : ?>
                            <?php echo wp_kses_post( $custom_hero_subtitle ); ?>
                        <?php else : ?>
                            <?php echo wp_kses_post( get_theme_mod( 'hero_description', __( 'Практические кейсы, инсайты и тренды из мира контекстной рекламы.', 'yandexpro' ) ) ); ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
                
                <!-- Hero Buttons -->
                <div class="hero-buttons">
                    <?php if ( $custom_hero_button_text && $custom_hero_button_url ) : ?>
                        <a href="<?php echo esc_url( $custom_hero_button_url ); ?>" class="button button-primary hero-button">
                            <?php echo esc_html( $custom_hero_button_text ); ?>
                        </a>
                    <?php elseif ( get_theme_mod( 'hero_button_text' ) && get_theme_mod( 'hero_button_url' ) ) : ?>
                        <a href="<?php echo esc_url( get_theme_mod( 'hero_button_url', '#' ) ); ?>" class="button button-primary hero-button">
                            <?php echo esc_html( get_theme_mod( 'hero_button_text', __( 'Читать блог', 'yandexpro' ) ) ); ?>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Secondary Button -->
                    <?php
                    $secondary_button_text = get_post_meta( get_the_ID(), '_yandexpro_hero_secondary_text', true );
                    $secondary_button_url = get_post_meta( get_the_ID(), '_yandexpro_hero_secondary_url', true );
                    
                    if ( $secondary_button_text && $secondary_button_url ) :
                    ?>
                        <a href="<?php echo esc_url( $secondary_button_url ); ?>" class="button button-secondary hero-button-secondary">
                            <?php echo esc_html( $secondary_button_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
                
            <?php endwhile; ?>
        </div>
    </div>
    
    <!-- Hero Background Pattern -->
    <div class="hero-pattern" aria-hidden="true"></div>
</section>

<!-- Main Content -->
<div class="landing-content">
    
    <?php while ( have_posts() ) : the_post(); ?>
        
        <!-- Page Content (если есть контент в редакторе) -->
        <?php if ( get_the_content() ) : ?>
            <section class="landing-page-content">
                <div class="container">
                    <div class="page-content-wrapper">
                        <?php
                        the_content();
                        
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'yandexpro' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        
    <?php endwhile; ?>
    
    <!-- Features Section -->
    <?php if ( get_post_meta( get_the_ID(), '_yandexpro_show_features', true ) ) : ?>
        <section class="features-section" role="region" aria-label="<?php esc_attr_e( 'Наши преимущества', 'yandexpro' ); ?>">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_features_title', true ) ?: __( 'Почему выбирают нас', 'yandexpro' ) ); ?>
                    </h2>
                    <?php 
                    $features_subtitle = get_post_meta( get_the_ID(), '_yandexpro_features_subtitle', true );
                    if ( $features_subtitle ) :
                    ?>
                        <p class="section-subtitle">
                            <?php echo esc_html( $features_subtitle ); ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="features-grid">
                    <?php
                    for ( $i = 1; $i <= 6; $i++ ) {
                        $feature_title = get_post_meta( get_the_ID(), "_yandexpro_feature_{$i}_title", true );
                        $feature_description = get_post_meta( get_the_ID(), "_yandexpro_feature_{$i}_description", true );
                        $feature_icon = get_post_meta( get_the_ID(), "_yandexpro_feature_{$i}_icon", true );
                        
                        if ( $feature_title ) :
                    ?>
                        <div class="feature-card">
                            <?php if ( $feature_icon ) : ?>
                                <div class="feature-icon">
                                    <?php if ( filter_var( $feature_icon, FILTER_VALIDATE_URL ) ) : ?>
                                        <img src="<?php echo esc_url( $feature_icon ); ?>" alt="" loading="lazy" decoding="async">
                                    <?php else : ?>
                                        <span class="feature-emoji" aria-hidden="true"><?php echo esc_html( $feature_icon ); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <h3 class="feature-title">
                                <?php echo esc_html( $feature_title ); ?>
                            </h3>
                            
                            <?php if ( $feature_description ) : ?>
                                <p class="feature-description">
                                    <?php echo esc_html( $feature_description ); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php 
                        endif;
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Services Section -->
    <?php if ( get_post_meta( get_the_ID(), '_yandexpro_show_services', true ) ) : ?>
        <section class="services-section" role="region" aria-label="<?php esc_attr_e( 'Наши услуги', 'yandexpro' ); ?>">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_services_title', true ) ?: __( 'Наши услуги', 'yandexpro' ) ); ?>
                    </h2>
                    <?php 
                    $services_subtitle = get_post_meta( get_the_ID(), '_yandexpro_services_subtitle', true );
                    if ( $services_subtitle ) :
                    ?>
                        <p class="section-subtitle">
                            <?php echo esc_html( $services_subtitle ); ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="services-grid">
                    <?php
                    for ( $i = 1; $i <= 4; $i++ ) {
                        $service_title = get_post_meta( get_the_ID(), "_yandexpro_service_{$i}_title", true );
                        $service_description = get_post_meta( get_the_ID(), "_yandexpro_service_{$i}_description", true );
                        $service_price = get_post_meta( get_the_ID(), "_yandexpro_service_{$i}_price", true );
                        $service_features = get_post_meta( get_the_ID(), "_yandexpro_service_{$i}_features", true );
                        
                        if ( $service_title ) :
                    ?>
                        <div class="service-card">
                            <div class="service-header">
                                <h3 class="service-title">
                                    <?php echo esc_html( $service_title ); ?>
                                </h3>
                                
                                <?php if ( $service_price ) : ?>
                                    <div class="service-price">
                                        <?php echo esc_html( $service_price ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ( $service_description ) : ?>
                                <p class="service-description">
                                    <?php echo esc_html( $service_description ); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ( $service_features ) : ?>
                                <ul class="service-features">
                                    <?php
                                    $features = array_filter( array_map( 'trim', explode( "\n", $service_features ) ) );
                                    foreach ( $features as $feature ) :
                                    ?>
                                        <li class="service-feature">
                                            <span class="feature-check" aria-hidden="true">✓</span>
                                            <?php echo esc_html( $feature ); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            
                            <div class="service-footer">
                                <a href="<?php echo esc_url( get_post_meta( get_the_ID(), "_yandexpro_service_{$i}_link", true ) ?: '#contact' ); ?>" class="button button-primary service-button">
                                    <?php esc_html_e( 'Узнать больше', 'yandexpro' ); ?>
                                </a>
                            </div>
                        </div>
                    <?php 
                        endif;
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Testimonials Section -->
    <?php if ( get_post_meta( get_the_ID(), '_yandexpro_show_testimonials', true ) ) : ?>
        <section class="testimonials-section" role="region" aria-label="<?php esc_attr_e( 'Отзывы клиентов', 'yandexpro' ); ?>">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_testimonials_title', true ) ?: __( 'Что говорят клиенты', 'yandexpro' ) ); ?>
                    </h2>
                </div>
                
                <div class="testimonials-grid">
                    <?php
                    for ( $i = 1; $i <= 3; $i++ ) {
                        $testimonial_text = get_post_meta( get_the_ID(), "_yandexpro_testimonial_{$i}_text", true );
                        $testimonial_author = get_post_meta( get_the_ID(), "_yandexpro_testimonial_{$i}_author", true );
                        $testimonial_company = get_post_meta( get_the_ID(), "_yandexpro_testimonial_{$i}_company", true );
                        $testimonial_avatar = get_post_meta( get_the_ID(), "_yandexpro_testimonial_{$i}_avatar", true );
                        
                        if ( $testimonial_text && $testimonial_author ) :
                    ?>
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <blockquote class="testimonial-text">
                                    "<?php echo esc_html( $testimonial_text ); ?>"
                                </blockquote>
                            </div>
                            
                            <div class="testimonial-author">
                                <?php if ( $testimonial_avatar ) : ?>
                                    <div class="testimonial-avatar">
                                        <img src="<?php echo esc_url( $testimonial_avatar ); ?>" alt="<?php echo esc_attr( $testimonial_author ); ?>" loading="lazy" decoding="async">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="testimonial-info">
                                    <cite class="testimonial-name">
                                        <?php echo esc_html( $testimonial_author ); ?>
                                    </cite>
                                    
                                    <?php if ( $testimonial_company ) : ?>
                                        <span class="testimonial-company">
                                            <?php echo esc_html( $testimonial_company ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endif;
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Statistics Section -->
    <?php if ( get_post_meta( get_the_ID(), '_yandexpro_show_stats', true ) ) : ?>
        <section class="stats-section" role="region" aria-label="<?php esc_attr_e( 'Наши достижения', 'yandexpro' ); ?>">
            <div class="container">
                <div class="stats-grid">
                    <?php
                    for ( $i = 1; $i <= 4; $i++ ) {
                        $stat_number = get_post_meta( get_the_ID(), "_yandexpro_stat_{$i}_number", true );
                        $stat_label = get_post_meta( get_the_ID(), "_yandexpro_stat_{$i}_label", true );
                        $stat_suffix = get_post_meta( get_the_ID(), "_yandexpro_stat_{$i}_suffix", true );
                        
                        if ( $stat_number && $stat_label ) :
                    ?>
                        <div class="stat-card">
                            <div class="stat-number">
                                <?php echo esc_html( $stat_number ); ?>
                                <?php if ( $stat_suffix ) : ?>
                                    <span class="stat-suffix"><?php echo esc_html( $stat_suffix ); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="stat-label">
                                <?php echo esc_html( $stat_label ); ?>
                            </div>
                        </div>
                    <?php 
                        endif;
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Latest Blog Posts -->
    <?php if ( get_post_meta( get_the_ID(), '_yandexpro_show_blog', true ) ) : ?>
        <section class="landing-blog-section" role="region" aria-label="<?php esc_attr_e( 'Последние статьи блога', 'yandexpro' ); ?>">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_blog_title', true ) ?: __( 'Полезные статьи', 'yandexpro' ) ); ?>
                    </h2>
                    <p class="section-subtitle">
                        <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_blog_subtitle', true ) ?: __( 'Последние материалы из нашего блога', 'yandexpro' ) ); ?>
                    </p>
                </div>
                
                <?php
                $blog_posts = get_posts( array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'no_found_rows'  => true,
                ) );
                
                if ( $blog_posts ) :
                ?>
                    <div class="landing-blog-grid">
                        <?php foreach ( $blog_posts as $blog_post ) : 
                            $post_id = $blog_post->ID;
                            $post_url = get_permalink( $post_id );
                            $post_title = get_the_title( $post_id );
                            $post_date = get_the_date( '', $post_id );
                            $post_excerpt = get_the_excerpt( $post_id );
                            $categories = get_the_category( $post_id );
                            $primary_category = ! empty( $categories ) ? $categories[0] : null;
                        ?>
                            <article class="landing-blog-card">
                                <div class="blog-card-image">
                                    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                        <a href="<?php echo esc_url( $post_url ); ?>" tabindex="-1" aria-hidden="true">
                                            <?php echo get_the_post_thumbnail( $post_id, 'yandexpro-blog-thumb', array(
                                                'loading'  => 'lazy',
                                                'decoding' => 'async',
                                            ) ); ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url( $post_url ); ?>" class="blog-card-placeholder" tabindex="-1" aria-hidden="true">
                                            <div class="gradient-placeholder" style="background: linear-gradient(135deg, <?php echo esc_attr( yandexpro_get_random_gradient() ); ?>);"></div>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ( $primary_category ) : ?>
                                        <span class="blog-card-category">
                                            <?php echo esc_html( $primary_category->name ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="blog-card-content">
                                    <div class="blog-card-meta">
                                        <time datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>">
                                            <?php echo esc_html( $post_date ); ?>
                                        </time>
                                    </div>
                                    
                                    <h3 class="blog-card-title">
                                        <a href="<?php echo esc_url( $post_url ); ?>">
                                            <?php echo esc_html( $post_title ); ?>
                                        </a>
                                    </h3>
                                    
                                    <?php if ( $post_excerpt ) : ?>
                                        <p class="blog-card-excerpt">
                                            <?php echo esc_html( wp_trim_words( $post_excerpt, 15 ) ); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo esc_url( $post_url ); ?>" class="blog-card-link">
                                        <?php esc_html_e( 'Читать далее', 'yandexpro' ); ?>
                                        <span class="link-arrow" aria-hidden="true">→</span>
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="landing-blog-footer">
                        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="button button-secondary view-all-button">
                            <?php esc_html_e( 'Посмотреть все статьи', 'yandexpro' ); ?>
                        </a>
                    </div>
                    
                <?php endif; wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Contact CTA Section -->
    <?php if ( get_post_meta( get_the_ID(), '_yandexpro_show_contact_cta', true ) ) : ?>
        <section class="contact-cta-section" role="region" aria-label="<?php esc_attr_e( 'Связаться с нами', 'yandexpro' ); ?>">
            <div class="container">
                <div class="cta-content">
                    <h2 class="cta-title">
                        <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_cta_title', true ) ?: __( 'Готовы увеличить продажи?', 'yandexpro' ) ); ?>
                    </h2>
                    
                    <?php 
                    $cta_description = get_post_meta( get_the_ID(), '_yandexpro_cta_description', true );
                    if ( $cta_description ) :
                    ?>
                        <p class="cta-description">
                            <?php echo esc_html( $cta_description ); ?>
                        </p>
                    <?php endif; ?>
                    
                    <div class="cta-buttons">
                        <a href="<?php echo esc_url( get_post_meta( get_the_ID(), '_yandexpro_cta_button_url', true ) ?: '#contact' ); ?>" class="button button-primary cta-button">
                            <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_cta_button_text', true ) ?: __( 'Получить консультацию', 'yandexpro' ) ); ?>
                        </a>
                        
                        <?php 
                        $cta_phone = get_post_meta( get_the_ID(), '_yandexpro_cta_phone', true );
                        if ( $cta_phone ) :
                        ?>
                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $cta_phone ) ); ?>" class="button button-secondary cta-phone">
                                <span class="phone-icon" aria-hidden="true">📞</span>
                                <?php echo esc_html( $cta_phone ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
</div><!-- .landing-content -->

<?php
get_footer();

/**
 * Получение случайного градиента (если функция еще не определена)
 */
if ( ! function_exists( 'yandexpro_get_random_gradient' ) ) {
    function yandexpro_get_random_gradient() {
        $gradients = array(
            '#667eea, #764ba2',
            '#f093fb, #f5576c', 
            '#4facfe, #00f2fe',
            '#43e97b, #38f9d7',
            '#fa709a, #fee140',
        );
        
        return $gradients[ array_rand( $gradients ) ];
    }
}
?>