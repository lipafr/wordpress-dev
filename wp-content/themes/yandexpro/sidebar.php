<?php
/**
 * The sidebar containing the main widget area
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar" role="complementary">
    <?php if ( is_single() ) : ?>
        <!-- Author Card -->
        <div class="widget author-card">
            <div class="author-avatar">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
            </div>
            <div class="author-name"><?php the_author(); ?></div>
            <div class="author-title">
                <?php
                $author_title = get_the_author_meta( 'description' );
                if ( $author_title ) {
                    echo esc_html( wp_trim_words( $author_title, 10 ) );
                } else {
                    esc_html_e( 'Yandex Direct Specialist', 'yandexpro-blog' );
                }
                ?>
            </div>
            <div class="author-social">
                <a href="#" class="social-link" title="<?php esc_attr_e( 'Telegram', 'yandexpro-blog' ); ?>">📱</a>
                <a href="#" class="social-link" title="<?php esc_attr_e( 'Email', 'yandexpro-blog' ); ?>">✉️</a>
                <a href="#" class="social-link" title="<?php esc_attr_e( 'LinkedIn', 'yandexpro-blog' ); ?>">💼</a>
            </div>
        </div>

        <!-- Related Articles -->
        <?php
        $related_posts = yandexpro_get_related_posts( 5 );
        if ( $related_posts->have_posts() ) :
            ?>
            <div class="widget related-section">
                <h3 class="widget-title">📚 <?php esc_html_e( 'Related Articles', 'yandexpro-blog' ); ?></h3>
                
                <?php
                while ( $related_posts->have_posts() ) :
                    $related_posts->the_post();
                    ?>
                    <a href="<?php the_permalink(); ?>" class="related-article">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="related-image">
                                <?php the_post_thumbnail( 'thumbnail', array( 'loading' => 'lazy' ) ); ?>
                            </div>
                        <?php else : ?>
                            <div class="related-image"></div>
                        <?php endif; ?>
                        <div class="related-content">
                            <div class="related-article-title"><?php the_title(); ?></div>
                            <div class="related-meta">
                                <?php echo esc_html( yandexpro_reading_time() ); ?> <?php esc_html_e( 'min read', 'yandexpro-blog' ); ?>
                            </div>
                        </div>
                    </a>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php
        endif;
        ?>
    <?php else : ?>
        <!-- Trending Articles for archive pages -->
        <div class="widget trending-section">
            <h3 class="widget-title">🔥 <?php esc_html_e( 'Trending in Category', 'yandexpro-blog' ); ?></h3>
            <ul class="trending-list">
                <?php
                $trending_posts = new WP_Query( array(
                    'posts_per_page' => 5,
                    'meta_key'       => 'post_views_count',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                ) );
                
                $counter = 1;
                while ( $trending_posts->have_posts() ) :
                    $trending_posts->the_post();
                    ?>
                    <li class="trending-item">
                        <span class="trending-number"><?php echo $counter; ?></span>
                        <div class="trending-content">
                            <div class="trending-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div>
                            <div class="trending-meta">
                                <?php echo esc_html( yandexpro_get_post_views() ); ?> <?php esc_html_e( 'views', 'yandexpro-blog' ); ?>
                            </div>
                        </div>
                    </li>
                    <?php
                    $counter++;
                endwhile;
                wp_reset_postdata();
                ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Tags Cloud -->
    <?php
    $tags = get_tags( array( 'number' => 15 ) );
    if ( $tags ) :
        ?>
        <div class="widget tags-section">
            <h3 class="widget-title">🏷️ <?php esc_html_e( 'Popular Tags', 'yandexpro-blog' ); ?></h3>
            <div class="tags-cloud">
                <?php
                foreach ( $tags as $tag ) {
                    echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag">';
                    echo esc_html( $tag->name );
                    echo '</a>';
                }
                ?>
            </div>
			</div>
       </div>
       <?php
   endif;
   ?>

   <!-- Newsletter Subscription -->
   <div class="widget newsletter-widget">
       <h3 class="widget-title">📧 <?php esc_html_e( 'Subscribe to Updates', 'yandexpro-blog' ); ?></h3>
       <p style="font-size: 14px; color: #64748b; margin-bottom: 16px;">
           <?php esc_html_e( 'Get new Yandex Direct articles via email', 'yandexpro-blog' ); ?>
       </p>
       <form class="newsletter-form" style="display: flex; flex-direction: column; gap: 12px;">
           <input type="email" placeholder="<?php esc_attr_e( 'Your email', 'yandexpro-blog' ); ?>" style="padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; outline: none;">
           <button type="submit" style="padding: 12px; background: #7c3aed; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
               <?php esc_html_e( 'Subscribe', 'yandexpro-blog' ); ?>
           </button>
       </form>
   </div>

   <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>