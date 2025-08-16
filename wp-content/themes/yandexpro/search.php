<?php
/**
 * Template for displaying search results
 */

get_header();
?>

<section class="page-header">
    <div class="container">
        <?php yandexpro_breadcrumbs(); ?>
        
        <h1 class="page-title">
            <?php
            printf(
                esc_html__( 'Search results for: %s', 'yandexpro-blog' ),
                '<span class="search-query">' . get_search_query() . '</span>'
            );
            ?>
        </h1>
        
        <div class="search-form-wrapper">
            <?php get_search_form(); ?>
        </div>
    </div>
</section>

<section class="search-results">
    <div class="container">
        <div class="content-with-sidebar">
            <div class="main-content">
                <?php if ( have_posts() ) : ?>
                    <div class="results-count">
                        <p>
                            <?php
                            global $wp_query;
                            printf(
                                esc_html( _n( 'Found %d result', 'Found %d results', $wp_query->found_posts, 'yandexpro-blog' ) ),
                                $wp_query->found_posts
                            );
                            ?>
                        </p>
                    </div>

                    <div class="articles-grid">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            get_template_part( 'template-parts/article-card' );
                        endwhile;
                        ?>
                    </div>

                    <?php yandexpro_pagination(); ?>

                <?php else : ?>
                    <div class="no-results">
                        <h2><?php esc_html_e( 'Nothing found', 'yandexpro-blog' ); ?></h2>
                        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'yandexpro-blog' ); ?></p>
                        
                        <div class="search-suggestions">
                            <h3><?php esc_html_e( 'Search suggestions:', 'yandexpro-blog' ); ?></h3>
                            <ul>
                                <li><?php esc_html_e( 'Make sure all words are spelled correctly', 'yandexpro-blog' ); ?></li>
                                <li><?php esc_html_e( 'Try different keywords', 'yandexpro-blog' ); ?></li>
                                <li><?php esc_html_e( 'Try more general keywords', 'yandexpro-blog' ); ?></li>
                            </ul>
                        </div>
                        
                        <div class="popular-categories">
                            <h3><?php esc_html_e( 'Popular categories:', 'yandexpro-blog' ); ?></h3>
                            <div class="categories-list">
                                <?php
                                $categories = get_categories( array( 'number' => 5 ) );
                                foreach ( $categories as $category ) {
                                    echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="category-tag">';
                                    echo esc_html( $category->name );
                                    echo '</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php
get_footer();