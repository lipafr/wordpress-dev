<?php
/**
 * The template for displaying all single posts
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

                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                    
                    <!-- Post Header -->
                    <header class="entry-header">
                        <?php
                        // Post thumbnail
                        if (has_post_thumbnail()) :
                        ?>
                            <div class="post-thumbnail">
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

                        <div class="entry-meta">
                            <?php
                            // Post date
                            echo '<span class="posted-on">';
                            echo '<time datetime="' . esc_attr(get_the_date('c')) . '">';
                            printf(
                                __('Опубликовано %s', 'yandexpro'),
                                '<span class="date">' . esc_html(get_the_date()) . '</span>'
                            );
                            echo '</time>';
                            echo '</span>';

                            // Post author
                            echo '<span class="byline">';
                            printf(
                                __('Автор: %s', 'yandexpro'),
                                '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
                            );
                            echo '</span>';

                            // Reading time
                            $reading_time = yandexpro_get_reading_time();
                            if ($reading_time) :
                                echo '<span class="reading-time">';
                                printf(__('Время чтения: %s мин', 'yandexpro'), $reading_time);
                                echo '</span>';
                            endif;

                            // Post categories
                            $categories = get_the_category();
                            if (!empty($categories)) :
                                echo '<span class="cat-links">';
                                echo __('Рубрики: ', 'yandexpro');
                                $category_links = array();
                                foreach ($categories as $category) {
                                    $category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" rel="category tag">' . esc_html($category->name) . '</a>';
                                }
                                echo implode(', ', $category_links);
                                echo '</span>';
                            endif;
                            ?>
                        </div>
                    </header>

                    <!-- Post Content -->
                    <div class="entry-content">
                        <?php
                        the_content(sprintf(
                            wp_kses(
                                __('Продолжить чтение<span class="screen-reader-text"> "%s"</span>', 'yandexpro'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        ));

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Страницы:', 'yandexpro'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <!-- Post Footer -->
                    <footer class="entry-footer">
                        <?php
                        // Tags
                        $tags = get_the_tags();
                        if ($tags) :
                            echo '<div class="post-tags">';
                            echo '<span class="tags-title">' . __('Теги:', 'yandexpro') . '</span>';
                            echo '<div class="tag-list">';
                            foreach ($tags as $tag) {
                                echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-link" rel="tag">' . esc_html($tag->name) . '</a>';
                            }
                            echo '</div>';
                            echo '</div>';
                        endif;

                        // Share buttons
                        if (get_theme_mod('yandexpro_show_share_buttons', true)) :
                            yandexpro_social_share_buttons();
                        endif;

                        // Edit post link
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

                <!-- Author Bio -->
                <?php if (get_theme_mod('yandexpro_show_author_bio', true) && get_the_author_meta('description')) : ?>
                    <div class="author-bio">
                        <div class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                        </div>
                        <div class="author-info">
                            <h3 class="author-title">
                                <?php printf(__('Об авторе: %s', 'yandexpro'), '<span class="author-name">' . esc_html(get_the_author()) . '</span>'); ?>
                            </h3>
                            <p class="author-description">
                                <?php echo wp_kses_post(get_the_author_meta('description')); ?>
                            </p>
                            <div class="author-links">
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-posts-link">
                                    <?php printf(__('Все записи %s', 'yandexpro'), esc_html(get_the_author())); ?>
                                </a>
                                <?php
                                $author_website = get_the_author_meta('user_url');
                                if ($author_website) :
                                ?>
                                    <a href="<?php echo esc_url($author_website); ?>" class="author-website" target="_blank" rel="noopener noreferrer">
                                        <?php _e('Сайт автора', 'yandexpro'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Related Posts -->
                <?php if (get_theme_mod('yandexpro_show_related_posts', true)) : ?>
                    <?php
                    $related_posts = yandexpro_get_related_posts(get_the_ID(), 3);
                    if ($related_posts->have_posts()) :
                    ?>
                        <section class="related-posts">
                            <h3 class="related-title"><?php _e('Похожие статьи', 'yandexpro'); ?></h3>
                            <div class="related-posts-grid">
                                <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                                    <article class="related-post">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="related-post-thumbnail">
                                                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                                    <?php 
                                                    the_post_thumbnail('yandexpro-small', array(
                                                        'alt' => the_title_attribute(array('echo' => false)),
                                                        'loading' => 'lazy',
                                                        'decoding' => 'async'
                                                    )); 
                                                    ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="related-post-content">
                                            <h4 class="related-post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                            <div class="related-post-meta">
                                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                    <?php echo esc_html(get_the_date()); ?>
                                                </time>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                        </section>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Post Navigation -->
                <nav class="post-navigation" role="navigation" aria-label="<?php _e('Навигация по записям', 'yandexpro'); ?>">
                    <h2 class="screen-reader-text"><?php _e('Навигация по записям', 'yandexpro'); ?></h2>
                    <div class="nav-links">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <?php if ($prev_post) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                    <span class="nav-subtitle"><?php _e('Предыдущая запись:', 'yandexpro'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                    <span class="nav-subtitle"><?php _e('Следующая запись:', 'yandexpro'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>

                <?php
                // Comments
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>

            <?php endwhile; ?>

        </div>
    </div>
</main>

<?php
get_sidebar();
get_footer();

/**
 * Helper Functions for Single Post
 */

/**
 * Calculate reading time
 */
if (!function_exists('yandexpro_get_reading_time')) {
    function yandexpro_get_reading_time() {
        $content = get_the_content();
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // 200 words per minute
        return $reading_time;
    }
}

/**
 * Get related posts
 */
if (!function_exists('yandexpro_get_related_posts')) {
    function yandexpro_get_related_posts($post_id, $number_posts = 3) {
        $categories = get_the_category($post_id);
        $category_ids = array();
        
        if ($categories) {
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
        }
        
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $number_posts,
            'post__not_in' => array($post_id),
            'meta_query' => array(
                array(
                    'key' => '_thumbnail_id',
                    'compare' => 'EXISTS'
                )
            )
        );
        
        if (!empty($category_ids)) {
            $args['category__in'] = $category_ids;
        }
        
        return new WP_Query($args);
    }
}

/**
 * Social share buttons
 */
if (!function_exists('yandexpro_social_share_buttons')) {
    function yandexpro_social_share_buttons() {
        $post_url = urlencode(get_permalink());
        $post_title = urlencode(get_the_title());
        $post_excerpt = urlencode(wp_trim_words(get_the_excerpt(), 20));
        
        ?>
        <div class="social-share">
            <span class="share-title"><?php _e('Поделиться:', 'yandexpro'); ?></span>
            <div class="share-buttons">
                <a href="https://vk.com/share.php?url=<?php echo $post_url; ?>&title=<?php echo $post_title; ?>&description=<?php echo $post_excerpt; ?>" 
                   class="share-button share-vk" target="_blank" rel="noopener noreferrer"
                   aria-label="<?php _e('Поделиться ВКонтакте', 'yandexpro'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0z"/></svg>
                    <span class="screen-reader-text"><?php _e('ВКонтакте', 'yandexpro'); ?></span>
                </a>
                
                <a href="https://t.me/share/url?url=<?php echo $post_url; ?>&text=<?php echo $post_title; ?>" 
                   class="share-button share-telegram" target="_blank" rel="noopener noreferrer"
                   aria-label="<?php _e('Поделиться в Telegram', 'yandexpro'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0z"/></svg>
                    <span class="screen-reader-text"><?php _e('Telegram', 'yandexpro'); ?></span>
                </a>
                
                <a href="https://twitter.com/intent/tweet?text=<?php echo $post_title; ?>&url=<?php echo $post_url; ?>" 
                   class="share-button share-twitter" target="_blank" rel="noopener noreferrer"
                   aria-label="<?php _e('Поделиться в Twitter', 'yandexpro'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    <span class="screen-reader-text"><?php _e('Twitter', 'yandexpro'); ?></span>
                </a>
                
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" 
                   class="share-button share-facebook" target="_blank" rel="noopener noreferrer"
                   aria-label="<?php _e('Поделиться в Facebook', 'yandexpro'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    <span class="screen-reader-text"><?php _e('Facebook', 'yandexpro'); ?></span>
                </a>
            </div>
        </div>
        <?php
    }
}
?>