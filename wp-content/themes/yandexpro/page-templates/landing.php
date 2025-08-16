<?php
/**
 * Template Name: Landing Page
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <section class="hero-landing">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php the_title(); ?></h1>
                <?php if ( has_excerpt() ) : ?>
                    <p class="hero-description"><?php the_excerpt(); ?></p>
                <?php endif; ?>
                
                <div class="hero-actions">
                    <a href="#content" class="btn primary"><?php esc_html_e( 'Learn More', 'yandexpro-blog' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn secondary"><?php esc_html_e( 'Contact Us', 'yandexpro-blog' ); ?></a>
                </div>
            </div>
        </div>
    </section>

    <section id="content" class="landing-content">
        <div class="container">
            <div class="content-wrapper">
                <?php the_content(); ?>
            </div>
        </div>
    </section>

<?php endwhile; ?>

<?php
get_footer();