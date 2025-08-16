<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <div class="content-wrapper">
            
            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('single-page'); ?>>
                    
                    <!-- Page Header -->
                    <header class="entry-header">
                        <?php
                        // Page thumbnail (if exists)
                        if (has_post_thumbnail() && get_theme_mod('yandexpro_show_page_featured_image', true)) :
                        ?>
                            <div class="page-thumbnail">
                                <?php 
                                the_post_thumbnail('yandexpro-large', array(
                                    'alt' => the_title_attribute(array('echo' => false)),
                                    'loading' => 'eager',
                                    'decoding' => 'sync'
                                )); 
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        
                        <?php
                        // Show page meta only if it's not the front page
                        if (!is_front_page() && get_theme_mod('yandexpro_show_page_meta', false)) :
                        ?>
                            <div class="entry-meta">
                                <span class="posted-on">
                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php
                                        printf(
                                            __('Опубликовано %s', 'yandexpro'),
                                            '<span class="date">' . esc_html(get_the_date()) . '</span>'
                                        );
                                        ?>
                                    </time>
                                </span>
                                
                                <?php if (get_the_modified_date() !== get_the_date()) : ?>
                                    <span class="updated-on">
                                        <time datetime="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                            <?php
                                            printf(
                                                __('Обновлено %s', 'yandexpro'),
                                                '<span class="date">' . esc_html(get_the_modified_date()) . '</span>'
                                            );
                                            ?>
                                        </time>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </header>

                    <!-- Page Content -->
                    <div class="entry-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Страницы:', 'yandexpro'),
                            'after'  => '</div>',
                            'link_before' => '<span class="page-number">',
                            'link_after' => '</span>',
                        ));
                        ?>
                    </div>

                    <!-- Page Footer -->
                    <footer class="entry-footer">
                        <?php
                        // Edit page link
                        edit_post_link(
                            sprintf(
                                wp_kses(
                                    __('Редактировать <span class="screen-reader-text">%s</span>', 'yandexpro'),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                wp_kses_post(get_the_title())
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                        ?>
                    </footer>
                </article>

                <?php
                // Page comments
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; ?>

            <?php
            // Child pages (if this is a parent page)
            if (get_theme_mod('yandexpro_show_child_pages', true)) :
                $child_pages = yandexpro_get_child_pages();
                if ($child_pages->have_posts()) :
                ?>
                    <section class="child-pages">
                        <h2 class="child-pages-title"><?php _e('Подстраницы', 'yandexpro'); ?></h2>
                        <div class="child-pages-grid">
                            <?php while ($child_pages->have_posts()) : $child_pages->the_post(); ?>
                                <article class="child-page-card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="child-page-thumbnail">
                                            <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                                <?php 
                                                the_post_thumbnail('yandexpro-medium', array(
                                                    'alt' => the_title_attribute(array('echo' => false)),
                                                    'loading' => 'lazy',
                                                    'decoding' => 'async'
                                                )); 
                                                ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="child-page-content">
                                        <h3 class="child-page-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        
                                        <?php if (has_excerpt()) : ?>
                                            <div class="child-page-excerpt">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="child-page-excerpt">
                                                <?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <a href="<?php the_permalink(); ?>" class="child-page-link">
                                            <?php _e('Читать далее', 'yandexpro'); ?>
                                            <span class="screen-reader-text"><?php echo get_the_title(); ?></span>
                                        </a>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    </section>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php
// Show sidebar only for specific pages or if enabled in customizer
$show_sidebar = get_theme_mod('yandexpro_show_page_sidebar', false);
$page_template = get_page_template_slug();

// Don't show sidebar for full-width templates
if ($page_template !== 'page-templates/page-landing.php' && $show_sidebar) {
    get_sidebar();
}

get_footer();

/**
 * Helper function to get child pages
 */
if (!function_exists('yandexpro_get_child_pages')) {
    function yandexpro_get_child_pages() {
        global $post;
        
        $args = array(
            'post_type' => 'page',
            'post_parent' => $post->ID,
            'posts_per_page' => 6,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => 'publish'
        );
        
        return new WP_Query($args);
    }
}
?>