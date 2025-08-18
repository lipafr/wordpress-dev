<?php
/**
 * Секция похожих статей
 * Показывается на странице отдельного поста
 *
 * @package YandexPro_Enhanced
 */

// Получаем похожие посты
$related_posts = yandexpro_get_related_posts();

// Если нет похожих постов, не показываем секцию
if ( empty( $related_posts ) ) {
    return;
}
?>

<section class="related-posts" role="region" aria-label="<?php esc_attr_e( 'Похожие статьи', 'yandexpro' ); ?>">
    <div class="related-posts-header">
        <h2 class="related-posts-title">
            <?php esc_html_e( 'Читайте также', 'yandexpro' ); ?>
        </h2>
        <p class="related-posts-subtitle">
            <?php esc_html_e( 'Другие статьи на похожие темы', 'yandexpro' ); ?>
        </p>
    </div>

    <div class="related-posts-grid">
        <?php foreach ( $related_posts as $related_post ) : 
            $post_id = $related_post->ID;
            $post_url = get_permalink( $post_id );
            $post_title = get_the_title( $post_id );
            $post_date = get_the_date( '', $post_id );
            $post_excerpt = get_the_excerpt( $post_id );
            $reading_time = yandexpro_get_reading_time( $post_id );
            $categories = get_the_category( $post_id );
            $primary_category = ! empty( $categories ) ? $categories[0] : null;
            $comments_count = get_comments_number( $post_id );
        ?>
            <article class="related-post-card" itemscope itemtype="https://schema.org/BlogPosting">
                
                <!-- Post Image -->
                <div class="related-post-image">
                    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                        <a href="<?php echo esc_url( $post_url ); ?>" tabindex="-1" aria-hidden="true">
                            <?php echo get_the_post_thumbnail( $post_id, 'yandexpro-blog-thumb', array(
                                'class'    => 'related-post-img',
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                                'itemprop' => 'image',
                            ) ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( $post_url ); ?>" class="related-post-placeholder" tabindex="-1" aria-hidden="true">
                            <div class="gradient-placeholder" style="background: linear-gradient(135deg, <?php echo esc_attr( yandexpro_get_random_gradient() ); ?>);"></div>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Category Badge -->
                    <?php if ( $primary_category ) : ?>
                        <span class="related-post-category" itemprop="articleSection">
                            <?php echo esc_html( $primary_category->name ); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Post Content -->
                <div class="related-post-content">
                    
                    <!-- Meta Information -->
                    <div class="related-post-meta">
                        <time class="related-post-date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>" itemprop="datePublished">
                            <span aria-hidden="true">📅</span>
                            <?php echo esc_html( $post_date ); ?>
                        </time>
                        
                        <span class="related-post-reading-time">
                            <span aria-hidden="true">🕐</span>
                            <?php echo esc_html( $reading_time ); ?>
                        </span>
                        
                        <?php if ( $comments_count > 0 ) : ?>
                            <span class="related-post-comments">
                                <span aria-hidden="true">💬</span>
                                <?php echo esc_html( number_format_i18n( $comments_count ) ); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Post Title -->
                    <h3 class="related-post-title" itemprop="headline">
                        <a href="<?php echo esc_url( $post_url ); ?>" itemprop="url">
                            <?php echo esc_html( $post_title ); ?>
                        </a>
                    </h3>

                    <!-- Post Excerpt -->
                    <div class="related-post-excerpt" itemprop="description">
                        <?php
                        if ( $post_excerpt ) {
                            echo esc_html( wp_trim_words( $post_excerpt, 20 ) );
                        } else {
                            $content = get_post_field( 'post_content', $post_id );
                            echo esc_html( wp_trim_words( wp_strip_all_tags( $content ), 20 ) );
                        }
                        ?>
                    </div>

                    <!-- Read More Link -->
                    <a href="<?php echo esc_url( $post_url ); ?>" class="related-post-link">
                        <?php esc_html_e( 'Читать статью', 'yandexpro' ); ?>
                        <span class="link-arrow" aria-hidden="true">→</span>
                    </a>

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

                </div><!-- .related-post-content -->

            </article><!-- .related-post-card -->

        <?php endforeach; ?>
    </div><!-- .related-posts-grid -->

    <!-- View All Posts Link -->
    <div class="related-posts-footer">
        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="view-all-posts-link">
            <?php esc_html_e( 'Посмотреть все статьи', 'yandexpro' ); ?>
            <span class="link-arrow" aria-hidden="true">→</span>
        </a>
    </div>

</section><!-- .related-posts -->

<?php
/**
 * Получение похожих постов
 */
function yandexpro_get_related_posts() {
    $current_post_id = get_the_ID();
    $categories = get_the_category( $current_post_id );
    $tags = get_the_tags( $current_post_id );
    $related_posts = array();

    // Стратегия 1: Посты из тех же категорий
    if ( ! empty( $categories ) ) {
        $category_ids = wp_list_pluck( $categories, 'term_id' );
        
        $category_posts = get_posts( array(
            'post_type'      => 'post',
            'posts_per_page' => 6,
            'post_status'    => 'publish',
            'post__not_in'   => array( $current_post_id ),
            'category__in'   => $category_ids,
            'orderby'        => 'rand',
            'meta_query'     => array(
                'relation' => 'OR',
                array(
                    'key'     => 'featured_post',
                    'value'   => '1',
                    'compare' => '='
                ),
                array(
                    'key'     => 'featured_post',
                    'compare' => 'NOT EXISTS'
                )
            ),
            'no_found_rows'  => true,
        ) );

        $related_posts = array_merge( $related_posts, $category_posts );
    }

    // Стратегия 2: Посты с теми же тегами (если мало постов из категорий)
    if ( count( $related_posts ) < 3 && ! empty( $tags ) ) {
        $tag_ids = wp_list_pluck( $tags, 'term_id' );
        
        $tag_posts = get_posts( array(
            'post_type'      => 'post',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
            'post__not_in'   => array_merge( array( $current_post_id ), wp_list_pluck( $related_posts, 'ID' ) ),
            'tag__in'        => $tag_ids,
            'orderby'        => 'comment_count',
            'order'          => 'DESC',
            'date_query'     => array(
                array(
                    'after' => '6 months ago'
                )
            ),
            'no_found_rows'  => true,
        ) );

        $related_posts = array_merge( $related_posts, $tag_posts );
    }

    // Стратегия 3: Популярные посты за последнее время (если все еще мало)
    if ( count( $related_posts ) < 3 ) {
        $popular_posts = get_posts( array(
            'post_type'      => 'post',
            'posts_per_page' => 4,
            'post_status'    => 'publish',
            'post__not_in'   => array_merge( array( $current_post_id ), wp_list_pluck( $related_posts, 'ID' ) ),
            'orderby'        => 'comment_count',
            'order'          => 'DESC',
            'date_query'     => array(
                array(
                    'after' => '3 months ago'
                )
            ),
            'no_found_rows'  => true,
        ) );

        $related_posts = array_merge( $related_posts, $popular_posts );
    }

    // Стратегия 4: Последние посты (финальный fallback)
    if ( empty( $related_posts ) ) {
        $related_posts = get_posts( array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'post__not_in'   => array( $current_post_id ),
            'orderby'        => 'date',
            'order'          => 'DESC',
            'no_found_rows'  => true,
        ) );
    }

    // Удаляем дубликаты и ограничиваем количество
    $unique_posts = array();
    $seen_ids = array();

    foreach ( $related_posts as $post ) {
        if ( ! in_array( $post->ID, $seen_ids ) && count( $unique_posts ) < 3 ) {
            $unique_posts[] = $post;
            $seen_ids[] = $post->ID;
        }
    }

    return $unique_posts;
}

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
            '#a8edea, #fed6e3',
            '#ff9a9e, #fecfef',
            '#ffecd2, #fcb69f',
        );
        
        return $gradients[ array_rand( $gradients ) ];
    }
}

/**
 * Получение времени чтения (если функция еще не определена)
 */
if ( ! function_exists( 'yandexpro_get_reading_time' ) ) {
    function yandexpro_get_reading_time( $post_id = null ) {
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        
        $content = get_post_field( 'post_content', $post_id );
        $word_count = str_word_count( wp_strip_all_tags( $content ) );
        $reading_time = ceil( $word_count / 200 ); // 200 слов в минуту
        
        return sprintf(
            /* translators: %d: reading time in minutes */
            _n( '%d мин', '%d мин', $reading_time, 'yandexpro' ),
            $reading_time
        );
    }
}
?>