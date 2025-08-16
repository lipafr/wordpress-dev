<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header(); ?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <div class="content-wrapper">
            
            <?php if (is_home() && !is_front_page()) : ?>
                <header class="page-header">
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <?php if (have_posts()) : ?>

                <?php if (is_home() && is_front_page()) : ?>
                    <!-- Hero Section for Blog Homepage -->
                    <section class="hero-section">
                        <div class="hero-content">
                            <h1 class="hero-title">
                                <?php 
                                $hero_title = get_theme_mod('yandexpro_hero_title', get_bloginfo('name'));
                                echo esc_html($hero_title);
                                ?>
                            </h1>
                            <p class="hero-description">
                                <?php 
                                $hero_description = get_theme_mod('yandexpro_hero_description', get_bloginfo('description'));
                                echo esc_html($hero_description);
                                ?>
                            </p>
                            <?php 
                            $hero_button_text = get_theme_mod('yandexpro_hero_button_text', __('Читать блог', 'yandexpro'));
                            $hero_button_url = get_theme_mod('yandexpro_hero_button_url', '#latest-posts');
                            if ($hero_button_text && $hero_button_url) : 
                            ?>
                                <a href="<?php echo esc_url($hero_button_url); ?>" class="btn btn-primary hero-button">
                                    <?php echo esc_html($hero_button_text); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Posts Section -->
                <section id="latest-posts" class="posts-section">
                    <?php if (is_home() && is_front_page()) : ?>
                        <h2 class="section-title"><?php _e('Последние статьи', 'yandexpro'); ?></h2>
                    <?php endif; ?>
                    
                    <div class="posts-grid">
                        <?php
                        // Start the Loop
                        while (have_posts()) :
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
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

                                <div class="post-content">
                                    <header class="entry-header">
                                        <?php
                                        if (is_singular()) :
                                            the_title('<h1 class="entry-title">', '</h1>');
                                        else :
                                            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                        endif;
                                        ?>

                                        <?php if ('post' === get_post_type()) : ?>
                                            <div class="entry-meta">
                                                <?php
                                                yandexpro_posted_on();
                                                yandexpro_posted_by();
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </header>

                                    <div class="entry-summary">
                                        <?php
                                        if (has_excerpt()) {
                                            the_excerpt();
                                        } else {
                                            echo wp_trim_words(get_the_content(), 25, '...');
                                        }
                                        ?>
                                    </div>

                                    <footer class="entry-footer">
                                        <?php yandexpro_entry_footer(); ?>
                                        <a href="<?php the_permalink(); ?>" class="read-more-link">
                                            <?php _e('Читать далее', 'yandexpro'); ?>
                                            <span class="screen-reader-text"><?php echo get_the_title(); ?></span>
                                        </a>
                                    </footer>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        ?>
                    </div>

                    <?php
                    // Pagination
                    the_posts_navigation(array(
                        'prev_text' => __('&larr; Предыдущие записи', 'yandexpro'),
                        'next_text' => __('Следующие записи &rarr;', 'yandexpro'),
                    ));
                    ?>

                </section>

            <?php else : ?>

                <!-- No Content Found -->
                <section class="no-results not-found">
                    <header class="page-header">
                        <h1 class="page-title"><?php _e('Ничего не найдено', 'yandexpro'); ?></h1>
                    </header>

                    <div class="page-content">
                        <?php if (is_home() && current_user_can('publish_posts')) : ?>

                            <p>
                                <?php
                                printf(
                                    wp_kses(
                                        __('Готовы опубликовать свою первую запись? <a href="%1$s">Начните отсюда</a>.', 'yandexpro'),
                                        array(
                                            'a' => array(
                                                'href' => array(),
                                            ),
                                        )
                                    ),
                                    esc_url(admin_url('post-new.php'))
                                );
                                ?>
                            </p>

                        <?php elseif (is_search()) : ?>

                            <p><?php _e('Извините, но ничего не найдено по вашему запросу. Попробуйте другие ключевые слова.', 'yandexpro'); ?></p>
                            <?php get_search_form(); ?>

                        <?php else : ?>

                            <p><?php _e('Кажется, здесь ничего нет. Попробуйте воспользоваться поиском.', 'yandexpro'); ?></p>
                            <?php get_search_form(); ?>

                        <?php endif; ?>
                    </div>
                </section>

            <?php endif; ?>

        </div>
    </div>
</main>

<?php
get_sidebar();
get_footer();
?>