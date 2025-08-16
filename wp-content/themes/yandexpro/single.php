<?php
/**
 * Template for displaying single posts
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
    
    <div class="progress-bar" id="progressBar"></div>

    <section class="breadcrumbs-section">
        <div class="container">
            <?php yandexpro_breadcrumbs(); ?>
        </div>
    </section>

    <section class="article-header">
        <div class="container">
            <div class="article-meta">
                <?php
                $categories = get_the_category();
                if ( $categories ) {
                    echo '<span class="category-badge">' . esc_html( $categories[0]->name ) . '</span>';
                }
                ?>
                <span class="article-date">📅 <?php echo esc_html( get_the_date() ); ?></span>
                <span class="reading-time">⏱ <?php echo esc_html( yandexpro_reading_time() ); ?> <?php esc_html_e( 'min read', 'yandexpro-blog' ); ?></span>
                <span class="article-views">👁 <?php echo esc_html( yandexpro_get_post_views() ); ?> <?php esc_html_e( 'views', 'yandexpro-blog' ); ?></span>
            </div>
            
            <h1 class="article-title"><?php the_title(); ?></h1>
            
            <?php if ( has_excerpt() ) : ?>
                <p class="article-subtitle"><?php the_excerpt(); ?></p>
            <?php endif; ?>
            
            <div class="article-actions">
                <a href="#" class="action-button primary" onclick="yandexpro_save_post(<?php the_ID(); ?>)">
                    💾 <?php esc_html_e( 'Save article', 'yandexpro-blog' ); ?>
                </a>
                <a href="#" class="action-button" onclick="yandexpro_share_post()">
                    📤 <?php esc_html_e( 'Share', 'yandexpro-blog' ); ?>
                </a>
            </div>
        </div>
    </section>

    <section class="article-content">
        <div class="container">
            <div class="content-grid">
                <main class="main-content">
                    <div class="content-text">
                        <?php
                        the_content();
                        
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'yandexpro-blog' ),
                            'after'  => '</div>',
                        ) );
                        ?>
                    </div>

                    <?php
                    // Author bio
                    if ( get_the_author_meta( 'description' ) ) :
                        ?>
                        <div class="author-bio">
                            <div class="author-avatar">
                                <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                            </div>
                            <div class="author-info">
                                <h3 class="author-name"><?php the_author(); ?></h3>
                                <p class="author-description"><?php the_author_meta( 'description' ); ?></p>
                            </div>
                        </div>
                        <?php
                    endif;
                    ?>

                    <?php
                    // Related posts
                    $related_posts = yandexpro_get_related_posts();
                    if ( $related_posts->have_posts() ) :
                        ?>
                        <section class="related-posts">
                            <h3><?php esc_html_e( 'Related Articles', 'yandexpro-blog' ); ?></h3>
                            <div class="related-grid">
                                <?php
                                while ( $related_posts->have_posts() ) :
                                    $related_posts->the_post();
                                    ?>
                                    <article class="related-item">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <div class="related-image">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail( 'yandexpro-card', array( 'loading' => 'lazy' ) ); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="related-content">
                                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <div class="related-meta">
                                                <?php echo esc_html( get_the_date() ); ?> • <?php echo esc_html( yandexpro_reading_time() ); ?> <?php esc_html_e( 'min', 'yandexpro-blog' ); ?>
                                            </div>
                                        </div>
                                    </article>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </section>
                        <?php
                    endif;
                    ?>

                    <?php
                    // Comments
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    ?>
                </main>

                <aside class="sidebar">
                    <?php get_template_part( 'template-parts/table-of-contents' ); ?>
                    <?php get_sidebar(); ?>
                </aside>
            </div>
        </div>
    </section>

    <div class="floating-share">
        <a href="#" class="share-btn" title="<?php esc_attr_e( 'Share on Telegram', 'yandexpro-blog' ); ?>" onclick="yandexpro_share_telegram()">📱</a>
        <a href="#" class="share-btn" title="<?php esc_attr_e( 'Share on VK', 'yandexpro-blog' ); ?>" onclick="yandexpro_share_vk()">📘</a>
        <a href="#" class="share-btn" title="<?php esc_attr_e( 'Copy link', 'yandexpro-blog' ); ?>" onclick="yandexpro_copy_link()">🔗</a>
        <a href="#" class="share-btn" title="<?php esc_attr_e( 'Bookmark', 'yandexpro-blog' ); ?>" onclick="yandexpro_bookmark()">📖</a>
    </div>

<?php endwhile; ?>

<?php
get_footer();