<?php
/**
 * Template part for displaying article cards
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="article-image">
            <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php the_post_thumbnail( 'yandexpro-card', array( 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
            </a>
            <?php
            $categories = get_the_category();
            if ( $categories ) :
                ?>
                <span class="article-category"><?php echo esc_html( $categories[0]->name ); ?></span>
                <?php
            endif;
            ?>
        </div>
    <?php endif; ?>

    <div class="article-content">
        <div class="article-meta">
            <span class="article-date"><?php echo esc_html( get_the_date() ); ?></span>
            <span class="reading-time"><?php echo esc_html( yandexpro_reading_time() ); ?> <?php esc_html_e( 'min', 'yandexpro-blog' ); ?></span>
            <?php if ( function_exists( 'yandexpro_get_post_views' ) ) : ?>
                <span class="article-views"><?php echo esc_html( yandexpro_get_post_views() ); ?> <?php esc_html_e( 'views', 'yandexpro-blog' ); ?></span>
            <?php endif; ?>
        </div>

        <h3 class="article-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="article-excerpt">
            <?php echo esc_html( get_the_excerpt() ); ?>
        </div>

        <div class="article-footer">
            <a href="<?php the_permalink(); ?>" class="article-link">
                <?php esc_html_e( 'Read more →', 'yandexpro-blog' ); ?>
            </a>
            
            <div class="article-actions">
                <button class="action-btn" title="<?php esc_attr_e( 'Bookmark', 'yandexpro-blog' ); ?>" onclick="yandexpro_bookmark()">📖</button>
                <button class="action-btn" title="<?php esc_attr_e( 'Share', 'yandexpro-blog' ); ?>" onclick="yandexpro_share_post()">📤</button>
            </div>
        </div>
    </div>
</article>