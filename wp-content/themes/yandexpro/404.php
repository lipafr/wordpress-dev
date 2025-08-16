<?php
/**
 * Template for displaying 404 pages
 */

get_header();
?>

<section class="error-404">
    <div class="container">
        <h1>404</h1>
        <h2><?php esc_html_e( 'Page not found', 'yandexpro-blog' ); ?></h2>
        <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'yandexpro-blog' ); ?></p>
        
        <div class="error-actions">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn primary">
                <?php esc_html_e( 'Go to Homepage', 'yandexpro-blog' ); ?>
            </a>
            
            <div class="search-form-wrapper">
                <?php get_search_form(); ?>
            </div>
        </div>
        
        <div class="popular-content">
            <h3><?php esc_html_e( 'Popular Articles', 'yandexpro-blog' ); ?></h3>
            
            <?php
            $popular_posts = new WP_Query( array(
                'posts_per_page' => 3,
                'meta_key'       => 'post_views_count',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
            ) );
            
            if ( $popular_posts->have_posts() ) :
                ?>
                <div class="popular-grid">
                    <?php
                    while ( $popular_posts->have_posts() ) :
                        $popular_posts->the_post();
                        ?>
                        <article class="popular-item">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="popular-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'yandexpro-card', array( 'loading' => 'lazy' ) ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="popular-content">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="popular-meta">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </div>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>

<?php
get_footer();