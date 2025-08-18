<?php
/**
 * Карточка поста для сетки блога
 *
 * @package YandexPro_Enhanced
 */

// Получаем данные поста
$post_id = get_the_ID();
$post_url = get_permalink();
$post_title = get_the_title();
$post_excerpt = get_the_excerpt();
$post_date = get_the_date();
$reading_time = yandexpro_get_reading_time( $post_id );
$categories = get_the_category();
$primary_category = ! empty( $categories ) ? $categories[0] : null;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-card' ); ?> itemscope itemtype="https://schema.org/BlogPosting">
    
    <!-- Post Image -->
    <div class="article-image">
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php echo esc_url( $post_url ); ?>" tabindex="-1" aria-hidden="true">
                <?php
                the_post_thumbnail( 'yandexpro-blog-thumb', array(
                    'class'    => 'article-image-img',
                    'loading'  => 'lazy',
                    'decoding' => 'async',
                    'itemprop' => 'image',
                ) );
                ?>
            </a>
        <?php else : ?>
            <!-- Градиентная заглушка если нет изображения -->
            <a href="<?php echo esc_url( $post_url ); ?>" class="article-image-placeholder" tabindex="-1" aria-hidden="true">
                <div class="gradient-placeholder" style="background: linear-gradient(135deg, <?php echo esc_attr( yandexpro_get_random_gradient() ); ?>);"></div>
            </a>
        <?php endif; ?>
        
        <!-- Category Badge -->
        <?php if ( $primary_category ) : ?>
            <span class="article-category" itemprop="articleSection">
                <?php echo esc_html( $primary_category->name ); ?>
            </span>
        <?php endif; ?>
    </div>

    <!-- Post Content -->
    <div class="article-content">
        
        <!-- Meta Information -->
        <div class="article-meta">
            <time class="article-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
                <span aria-hidden="true">📅</span>
                <?php echo esc_html( $post_date ); ?>
            </time>
            
            <span class="article-reading-time">
                <span aria-hidden="true">🕐</span>
                <?php echo esc_html( $reading_time ); ?>
            </span>
            
            <?php if ( comments_open() || get_comments_number() ) : ?>
                <span class="article-comments">
                    <span aria-hidden="true">💬</span>
                    <?php
                    $comments_number = get_comments_number();
                    if ( 0 == $comments_number ) {
                        esc_html_e( '0', 'yandexpro' );
                    } else {
                        echo esc_html( number_format_i18n( $comments_number ) );
                    }
                    ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Post Title -->
        <h3 class="article-title" itemprop="headline">
            <a href="<?php echo esc_url( $post_url ); ?>" itemprop="url">
                <?php echo esc_html( $post_title ); ?>
            </a>
        </h3>

        <!-- Post Excerpt -->
        <div class="article-excerpt" itemprop="description">
            <?php
            if ( $post_excerpt ) {
                echo wp_kses_post( $post_excerpt );
            } else {
                // Автоматический excerpt с настраиваемой длиной
                $content = get_the_content();
                $excerpt_length = get_theme_mod( 'blog_excerpt_length', 25 );
                echo wp_kses_post( wp_trim_words( $content, $excerpt_length, '...' ) );
            }
            ?>
        </div>

        <!-- Post Categories (скрытые метаданные) -->
        <div class="article-categories" style="display: none;" itemprop="about">
            <?php
            if ( $categories ) {
                foreach ( $categories as $category ) {
                    echo '<span class="category-badge" itemprop="keywords">' . esc_html( $category->name ) . '</span>';
                }
            }
            ?>
        </div>

        <!-- Скрытые структурированные данные -->
        <div style="display: none;">
            <!-- Author -->
            <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                <span itemprop="name"><?php echo esc_html( get_the_author() ); ?></span>
                <span itemprop="url"><?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?></span>
            </span>
            
            <!-- Publisher -->
            <span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                <span itemprop="name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                <span itemprop="url"><?php echo esc_url( home_url() ); ?></span>
                <?php if ( has_custom_logo() ) : ?>
                    <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                        <?php
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo_image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
                        if ( $logo_image ) :
                        ?>
                            <span itemprop="url"><?php echo esc_url( $logo_image[0] ); ?></span>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>
            </span>
            
            <!-- Modified Date -->
            <time itemprop="dateModified" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
                <?php echo esc_html( get_the_modified_date() ); ?>
            </time>
            
            <!-- Main Entity -->
            <span itemprop="mainEntityOfPage" itemscope itemtype="https://schema.org/WebPage">
                <span itemprop="@id"><?php echo esc_url( $post_url ); ?></span>
            </span>
        </div>

    </div><!-- .article-content -->

</article><!-- .article-card -->

<?php
/**
 * Получение случайного градиента для заглушки изображения
 */
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
        '#ff8a80, #ffb74d',
        '#81c784, #aed581',
    );
    
    return $gradients[ array_rand( $gradients ) ];
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