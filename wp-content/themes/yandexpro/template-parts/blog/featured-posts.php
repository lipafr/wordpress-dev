<?php
/**
 * Секция рекомендуемых статей (Featured Posts)
 * Показывается только на главной странице блога
 *
 * @package YandexPro_Enhanced
 */

// Получаем рекомендуемые посты
$featured_posts = yandexpro_get_featured_posts();

if ( empty( $featured_posts ) ) {
    return;
}
?>

<section class="featured-articles" role="region" aria-label="<?php esc_attr_e( 'Рекомендуемые статьи', 'yandexpro' ); ?>">
    <div class="container">
        <div class="featured-grid">
            
            <!-- Main Featured Article -->
            <?php if ( isset( $featured_posts['main'] ) ) : 
                $main_post = $featured_posts['main'];
                $post_id = $main_post->ID;
                $post_url = get_permalink( $post_id );
                $post_title = get_the_title( $post_id );
                $post_excerpt = get_the_excerpt( $post_id );
                $post_date = get_the_date( '', $post_id );
                $categories = get_the_category( $post_id );
                $primary_category = ! empty( $categories ) ? $categories[0] : null;
                $comments_count = get_comments_number( $post_id );
            ?>
                <article class="featured-main" itemscope itemtype="https://schema.org/BlogPosting">
                    <div class="featured-image">
                        <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                            <a href="<?php echo esc_url( $post_url ); ?>" tabindex="-1" aria-hidden="true">
                                <?php echo get_the_post_thumbnail( $post_id, 'yandexpro-featured-large', array(
                                    'loading'  => 'eager', // Первое изображение загружаем сразу
                                    'decoding' => 'async',
                                    'itemprop' => 'image',
                                ) ); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo esc_url( $post_url ); ?>" class="featured-image-placeholder" tabindex="-1" aria-hidden="true">
                                <div class="gradient-placeholder" style="background: linear-gradient(135deg, #ff6b6b, #4ecdc4);"></div>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="featured-content">
                        <div class="featured-meta">
                            <time class="featured-date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>" itemprop="datePublished">
                                <span aria-hidden="true">📅</span>
                                <?php echo esc_html( $post_date ); ?>
                            </time>
                            
                            <?php if ( $comments_count > 0 ) : ?>
                                <span class="featured-likes">
                                    <span aria-hidden="true">👍</span>
                                    <?php echo esc_html( number_format_i18n( $comments_count ) ); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <h2 class="featured-title" itemprop="headline">
                            <a href="<?php echo esc_url( $post_url ); ?>" itemprop="url">
                                <?php echo esc_html( $post_title ); ?>
                            </a>
                        </h2>
                        
                        <p class="featured-description" itemprop="description">
                            <?php 
                            if ( $post_excerpt ) {
                                echo esc_html( wp_trim_words( $post_excerpt, 30 ) );
                            } else {
                                $content = get_post_field( 'post_content', $post_id );
                                echo esc_html( wp_trim_words( wp_strip_all_tags( $content ), 30 ) );
                            }
                            ?>
                        </p>
                        
                        <?php if ( $categories ) : ?>
                            <div class="featured-tags" itemprop="about">
                                <?php foreach ( array_slice( $categories, 0, 3 ) as $category ) : ?>
                                    <span class="featured-tag" itemprop="keywords">
                                        <?php echo esc_html( $category->name ); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Скрытые структурированные данные -->
                        <div style="display: none;">
                            <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                                <span itemprop="name"><?php echo esc_html( get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) ) ); ?></span>
                            </span>
                            <span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                <span itemprop="name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                            </span>
                            <time itemprop="dateModified" datetime="<?php echo esc_attr( get_the_modified_date( 'c', $post_id ) ); ?>">
                                <?php echo esc_html( get_the_modified_date( '', $post_id ) ); ?>
                            </time>
                        </div>
                    </div>
                </article>
            <?php endif; ?>

            <!-- Sidebar Featured Articles -->
            <?php if ( isset( $featured_posts['sidebar'] ) && ! empty( $featured_posts['sidebar'] ) ) : ?>
                <div class="featured-sidebar">
                    <?php foreach ( $featured_posts['sidebar'] as $sidebar_post ) : 
                        $post_id = $sidebar_post->ID;
                        $post_url = get_permalink( $post_id );
                        $post_title = get_the_title( $post_id );
                        $post_date = get_the_date( '', $post_id );
                        $categories = get_the_category( $post_id );
                        $comments_count = get_comments_number( $post_id );
                    ?>
                        <article class="featured-small" itemscope itemtype="https://schema.org/BlogPosting">
                            <div class="featured-small-image">
                                <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                    <a href="<?php echo esc_url( $post_url ); ?>" tabindex="-1" aria-hidden="true">
                                        <?php echo get_the_post_thumbnail( $post_id, 'yandexpro-small-thumb', array(
                                            'loading'  => 'lazy',
                                            'decoding' => 'async',
                                            'itemprop' => 'image',
                                        ) ); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url( $post_url ); ?>" class="featured-small-placeholder" tabindex="-1" aria-hidden="true">
                                        <div class="gradient-placeholder" style="background: linear-gradient(135deg, <?php echo esc_attr( yandexpro_get_random_gradient() ); ?>);"></div>
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <div class="featured-small-content">
                                <div class="featured-small-meta">
                                    <time class="featured-small-date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>" itemprop="datePublished">
                                        <span aria-hidden="true">📅</span>
                                        <?php echo esc_html( $post_date ); ?>
                                    </time>
                                    
                                    <?php if ( $comments_count > 0 ) : ?>
                                        <span class="featured-small-likes">
                                            <span aria-hidden="true">👍</span>
                                            <?php echo esc_html( number_format_i18n( $comments_count ) ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="featured-small-title" itemprop="headline">
                                    <a href="<?php echo esc_url( $post_url ); ?>" itemprop="url">
                                        <?php echo esc_html( $post_title ); ?>
                                    </a>
                                </h3>
                                
                                <?php if ( $categories ) : ?>
                                    <div class="featured-small-tags" itemprop="about">
                                        <?php foreach ( array_slice( $categories, 0, 2 ) as $category ) : ?>
                                            <span class="featured-tag-small" itemprop="keywords">
                                                <?php echo esc_html( $category->name ); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Скрытые структурированные данные -->
                                <div style="display: none;">
                                    <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                                        <span itemprop="name"><?php echo esc_html( get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) ) ); ?></span>
                                    </span>
                                    <span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                        <span itemprop="name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                                    </span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        </div><!-- .featured-grid -->
    </div><!-- .container -->
</section><!-- .featured-articles -->

<?php
/**
 * Получение рекомендуемых постов
 */
function yandexpro_get_featured_posts() {
    // Пытаемся получить посты с мета-полем 'featured'
    $featured_query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'featured_post',
                'value'   => '1',
                'compare' => '='
            )
        ),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ) );

    // Если нет постов с меткой featured, берем последние популярные
    if ( ! $featured_query->have_posts() ) {
        $featured_query = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'orderby'        => 'comment_count',
            'order'          => 'DESC',
            'date_query'     => array(
                array(
                    'after' => '30 days ago'
                )
            ),
            'no_found_rows'  => true,
        ) );
    }

    // Если все еще нет постов, берем просто последние
    if ( ! $featured_query->have_posts() ) {
        $featured_query = new WP_Query( array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
        ) );
    }

    $featured_posts = array();

    if ( $featured_query->have_posts() ) {
        $posts = $featured_query->posts;
        
        // Главный пост (первый)
        if ( isset( $posts[0] ) ) {
            $featured_posts['main'] = $posts[0];
        }
        
        // Боковые посты (остальные)
        if ( count( $posts ) > 1 ) {
            $featured_posts['sidebar'] = array_slice( $posts, 1 );
        }
    }

    wp_reset_postdata();
    
    return $featured_posts;
}

/**
 * Функция для получения случайного градиента (если еще не определена)
 */
if ( ! function_exists( 'yandexpro_get_random_gradient' ) ) {
    function yandexpro_get_random_gradient() {
        $gradients = array(
            '#4facfe, #00f2fe',
            '#f093fb, #f5576c', 
            '#43e97b, #38f9d7',
            '#fa709a, #fee140',
            '#a8edea, #fed6e3',
        );
        
        return $gradients[ array_rand( $gradients ) ];
    }
}
?>