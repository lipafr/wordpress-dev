<?php
/**
 * The main template file
 */

get_header();
?>

<div class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">
                <?php esc_html_e( 'Blog about', 'yandexpro-blog' ); ?> 
                <span class="gradient-text"><?php esc_html_e( 'Yandex Direct', 'yandexpro-blog' ); ?></span><br>
                <?php esc_html_e( 'and Internet Marketing', 'yandexpro-blog' ); ?>
            </h1>
            <p class="hero-description">
                <?php esc_html_e( 'Practical cases, insights and trends from the world of contextual advertising. Only verified information from a practicing specialist.', 'yandexpro-blog' ); ?>
            </p>
            <div class="search-container">
                <div class="search-icon">🔍</div>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</div>

<section class="categories-section">
    <div class="container">
        <div class="categories-list">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="category-tag active">
                <?php esc_html_e( 'All Articles', 'yandexpro-blog' ); ?>
            </a>
            <?php
            $categories = get_categories( array( 'number' => 6 ) );
            foreach ( $categories as $category ) {
                echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="category-tag">';
                echo esc_html( $category->name );
                echo '</a>';
            }
            ?>
        </div>
    </div>
</section>

<?php if ( have_posts() ) : ?>
    <?php
    // Featured post
    $featured_query = new WP_Query( array(
        'posts_per_page' => 1,
        'meta_key'       => '_featured_post',
        'meta_value'     => '1',
    ) );
    
    if ( $featured_query->have_posts() ) :
        while ( $featured_query->have_posts() ) :
            $featured_query->the_post();
            ?>
            <section class="featured-article">
                <div class="container">
                    <div class="featured-content">
                        <div class="featured-text">
                            <div class="featured-meta">
                                <span>📈 <?php esc_html_e( 'Featured', 'yandexpro-blog' ); ?></span>
                                <span><?php echo esc_html( get_the_date() ); ?></span>
                                <span><?php echo esc_html( yandexpro_reading_time() ); ?> <?php esc_html_e( 'min read', 'yandexpro-blog' ); ?></span>
                            </div>
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php echo esc_html( get_the_excerpt() ); ?></p>
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e( 'Read case →', 'yandexpro-blog' ); ?>
                            </a>
                        </div>
                        <div class="featured-image">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'yandexpro-hero', array( 'loading' => 'eager' ) ); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <section class="latest-articles">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php esc_html_e( 'Latest Articles', 'yandexpro-blog' ); ?></h2>
                <p class="section-subtitle"><?php esc_html_e( 'Fresh materials and current topics', 'yandexpro-blog' ); ?></p>
            </div>

            <div class="content-with-sidebar">
                <div class="main-content">
                    <div class="articles-grid">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            get_template_part( 'template-parts/article-card' );
                        endwhile;
                        ?>
                    </div>

                    <?php yandexpro_pagination(); ?>
                </div>

                <?php get_sidebar(); ?>
            </div>
        </div>
    </section>

<?php else : ?>
    <section class="no-posts">
        <div class="container">
            <h2><?php esc_html_e( 'Nothing found', 'yandexpro-blog' ); ?></h2>
            <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'yandexpro-blog' ); ?></p>
        </div>
    </section>
<?php endif; ?>

<section class="newsletter-cta">
    <div class="container">
        <h2><?php esc_html_e( 'Don\'t miss new articles', 'yandexpro-blog' ); ?></h2>
        <p><?php esc_html_e( 'Subscribe to the newsletter and get the best materials about contextual advertising', 'yandexpro-blog' ); ?></p>
        <form class="newsletter-form" action="#" method="post">
            <input type="email" name="email" class="newsletter-input" placeholder="<?php esc_attr_e( 'Your email', 'yandexpro-blog' ); ?>" required>
            <button type="submit" class="newsletter-btn"><?php esc_html_e( 'Subscribe', 'yandexpro-blog' ); ?></button>
            <?php wp_nonce_field( 'newsletter_subscribe', 'newsletter_nonce' ); ?>
        </form>
    </div>
</section>

<?php
get_footer();