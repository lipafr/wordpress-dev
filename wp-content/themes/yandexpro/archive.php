<?php
/**
 * Template for displaying archive pages
 */

get_header();
?>

<section class="page-header">
    <div class="container">
        <?php yandexpro_breadcrumbs(); ?>
        
        <h1 class="page-title">
            <?php
            if ( is_category() ) {
                printf( esc_html__( 'Category: %s', 'yandexpro-blog' ), single_cat_title( '', false ) );
            } elseif ( is_tag() ) {
                printf( esc_html__( 'Tag: %s', 'yandexpro-blog' ), single_tag_title( '', false ) );
            } elseif ( is_author() ) {
                printf( esc_html__( 'Author: %s', 'yandexpro-blog' ), get_the_author() );
            } elseif ( is_date() ) {
                if ( is_year() ) {
                    printf( esc_html__( 'Year: %s', 'yandexpro-blog' ), get_the_date( 'Y' ) );
                } elseif ( is_month() ) {
                    printf( esc_html__( 'Month: %s', 'yandexpro-blog' ), get_the_date( 'F Y' ) );
                } else {
                    printf( esc_html__( 'Day: %s', 'yandexpro-blog' ), get_the_date() );
                }
            } else {
                esc_html_e( 'Archives', 'yandexpro-blog' );
            }
            ?>
        </h1>
        
        <?php
        if ( is_category() || is_tag() ) {
            $description = term_description();
            if ( $description ) {
                echo '<div class="archive-description">' . $description . '</div>';
            }
        }
        ?>
    </div>
</section>

<section class="archive-content">
    <div class="container">
        <div class="content-with-sidebar">
            <div class="main-content">
                <?php if ( have_posts() ) : ?>
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
                    <div class="no-posts">
                        <h2><?php esc_html_e( 'Nothing found', 'yandexpro-blog' ); ?></h2>
                        <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'yandexpro-blog' ); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php
get_footer();