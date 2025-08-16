<?php
/**
 * Template for displaying pages
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <section class="page-header">
        <div class="container">
            <?php yandexpro_breadcrumbs(); ?>
            
            <h1 class="page-title"><?php the_title(); ?></h1>
            
            <?php if ( has_excerpt() ) : ?>
                <div class="page-excerpt"><?php the_excerpt(); ?></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <div class="content-wrapper">
                <?php
                the_content();
                
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'yandexpro-blog' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </div>
    </section>

    <?php
    // Comments for pages
    if ( comments_open() || get_comments_number() ) :
        ?>
        <section class="page-comments">
            <div class="container">
                <?php comments_template(); ?>
            </div>
        </section>
        <?php
    endif;
    ?>

<?php endwhile; ?>

<?php
get_footer();