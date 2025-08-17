<?php
/**
 * The template for displaying all single posts
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<main id="main" class="site-main single-post" role="main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
                
                <!-- Post header -->
                <header class="single-post-header">
                    
                    <!-- Post meta -->
                    <div class="single-post-meta">
                        <div class="meta-left">
                            <time class="post-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date()); ?>
                            </time>
                            
                            <?php if (get_the_author()) : ?>
                                <span class="post-author">
                                    <?php
                                    printf(
                                        esc_html__('by %s', 'yandexpro'),
                                        '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>'
                                    );
                                    ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (function_exists('yandexpro_reading_time')) : ?>
                                <span class="reading-time">
                                    <?php
                                    printf(
                                        esc_html__('%s min read', 'yandexpro'),
                                        yandexpro_reading_time()
                                    );
                                    ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="meta-right">
                            <?php if (comments_open() || get_comments_number()) : ?>
                                <span class="comments-count">
                                    <a href="#comments">
                                        <?php
                                        printf(
                                            _nx(
                                                '%s Comment',
                                                '%s Comments',
                                                get_comments_number(),
                                                'comments title',
                                                'yandexpro'
                                            ),
                                            number_format_i18n(get_comments_number())
                                        );
                                        ?>
                                    </a>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Post title -->
                    <h1 class="single-post-title"><?php the_title(); ?></h1>
                    
                    <!-- Post categories -->
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) :
                    ?>
                        <div class="single-post-categories">
                            <span class="categories-label"><?php esc_html_e('Filed under:', 'yandexpro'); ?></span>
                            <?php
                            $category_links = array();
                            foreach ($categories as $category) {
                                $category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link" rel="category tag">' . esc_html($category->name) . '</a>';
                            }
                            echo implode(', ', $category_links);
                            ?>
                        </div>
                    <?php endif; ?>
                    
                </header><!-- .single-post-header -->
                
                <!-- Featured image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="single-post-thumbnail">
                        <?php
                        the_post_thumbnail('yandexpro-large', array(
                            'alt' => the_title_attribute(array('echo' => false)),
                            'loading' => 'eager', // Don't lazy load featured image
                            'decoding' => 'async',
                        ));
                        ?>
                        
                        <?php
                        $caption = get_the_post_thumbnail_caption();
                        if ($caption) :
                        ?>
                            <figcaption class="wp-caption-text"><?php echo wp_kses_post($caption); ?></figcaption>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Post content -->
                <div class="single-post-content">
                    <?php
                    the_content(sprintf(
                        wp_kses(
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'yandexpro'),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        wp_kses_post(get_the_title())
                    ));

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'yandexpro'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div><!-- .single-post-content -->
                
                <!-- Post footer -->
                <footer class="single-post-footer">
                    
                    <!-- Tags -->
                    <?php
                    $tags = get_the_tags();
                    if ($tags) :
                    ?>
                        <div class="post-tags">
                            <span class="tags-label"><?php esc_html_e('Tags:', 'yandexpro'); ?></span>
                            <div class="tags-list">
                                <?php
                                foreach ($tags as $tag) {
                                    echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-link" rel="tag">' . esc_html($tag->name) . '</a>';
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Share buttons -->
                    <?php if (yandexpro_get_theme_option('show_share_buttons', true)) : ?>
                        <div class="post-share">
                            <span class="share-label"><?php esc_html_e('Share this post:', 'yandexpro'); ?></span>
                            <div class="share-buttons">
                                <?php
                                $post_url = urlencode(get_permalink());
                                $post_title = urlencode(get_the_title());
                                $post_excerpt = urlencode(wp_trim_words(get_the_excerpt(), 20));
                                ?>
                                
                                <!-- VKontakte -->
                                <a href="https://vk.com/share.php?url=<?php echo $post_url; ?>&title=<?php echo $post_title; ?>&description=<?php echo $post_excerpt; ?>" 
                                   target="_blank" rel="noopener noreferrer" class="share-button share-vk" 
                                   aria-label="<?php esc_attr_e('Share on VKontakte', 'yandexpro'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zm3.692 17.123h-1.744c-.66 0-.864-.525-2.05-1.727-1.033-1.01-1.49-.856-1.49.239v1.727c0 .464-.15.748-1.38.748-2.05 0-4.32-1.24-5.928-3.54C5.196 10.308 4.592 6.76 6.86 6.76c.628 0 .864.338 1.155 1.008.393.9.844 1.774 1.387 2.611.39.6.615.748.848.748.233 0 .465-.15.465-.988V8.1c-.078-1.395-.915-1.513-.915-2.006 0-.262.21-.525.554-.525h2.744c.554 0 .758.3.758.974v3.3c0 .555.247.758.405.758.233 0 .465-.203.93-.668 1.17-1.163 2.006-2.97 2.006-2.97.157-.338.448-.645.916-.645h1.744c1.19 0 1.133.615.758 1.455-.75 1.673-3.396 4.643-3.396 4.643-.3.405-.233.615 0 1.02.165.285 1.042 1.027 1.577 1.652.9 1.073 1.577 1.97.525 1.97z"/>
                                    </svg>
                                </a>
                                
                                <!-- Telegram -->
                                <a href="https://t.me/share/url?url=<?php echo $post_url; ?>&text=<?php echo $post_title; ?>" 
                                   target="_blank" rel="noopener noreferrer" class="share-button share-telegram"
                                   aria-label="<?php esc_attr_e('Share on Telegram', 'yandexpro'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 0C5.374 0 0 5.373 0 12s5.374 12 12 12 12-5.373 12-12S18.626 0 12 0zm5.568 8.16c-.18 1.896-.962 6.502-1.359 8.627-.168.9-.499 1.201-.82 1.23-.697.064-1.226-.461-1.901-.903-1.056-.692-1.653-1.123-2.678-1.799-1.185-.781-.417-1.21.258-1.911.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                    </svg>
                                </a>
                                
                                <!-- Twitter -->
                                <a href="https://twitter.com/intent/tweet?url=<?php echo $post_url; ?>&text=<?php echo $post_title; ?>" 
                                   target="_blank" rel="noopener noreferrer" class="share-button share-twitter"
                                   aria-label="<?php esc_attr_e('Share on Twitter', 'yandexpro'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                
                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $post_url; ?>" 
                                   target="_blank" rel="noopener noreferrer" class="share-button share-facebook"
                                   aria-label="<?php esc_attr_e('Share on Facebook', 'yandexpro'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                
                                <!-- Copy link -->
                                <button class="share-button share-copy" type="button" 
                                        data-url="<?php echo esc_url(get_permalink()); ?>"
                                        aria-label="<?php esc_attr_e('Copy link', 'yandexpro'); ?>">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </footer><!-- .single-post-footer -->
                
            </article><!-- #post-<?php the_ID(); ?> -->
            
            <!-- Author bio -->
            <?php if (yandexpro_get_theme_option('show_author_bio', true) && get_the_author_meta('description')) : ?>
                <div class="author-bio">
                    <div class="author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                    </div>
                    <div class="author-info">
                        <h3 class="author-name">
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                <?php echo esc_html(get_the_author()); ?>
                            </a>
                        </h3>
                        <p class="author-description"><?php echo wp_kses_post(get_the_author_meta('description')); ?></p>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-posts-link">
                            <?php esc_html_e('View all posts', 'yandexpro'); ?> →
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Post navigation -->
            <?php if (yandexpro_get_theme_option('show_post_navigation', true)) : ?>
                <nav class="post-navigation" role="navigation" aria-label="<?php esc_attr_e('Post navigation', 'yandexpro'); ?>">
                    <div class="nav-links">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        
                        if ($prev_post) :
                        ?>
                            <div class="nav-previous">
                                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" rel="prev">
                                    <span class="nav-subtitle"><?php esc_html_e('Previous Post', 'yandexpro'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <a href="<?php echo esc_url(get_permalink($next_post)); ?>" rel="next">
                                    <span class="nav-subtitle"><?php esc_html_e('Next Post', 'yandexpro'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($next_post)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>
            <?php endif; ?>
            
            <!-- Related posts -->
            <?php if (yandexpro_get_theme_option('show_related_posts', true)) : ?>
                <?php yandexpro_related_posts(); ?>
            <?php endif; ?>
            
            <!-- Comments -->
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
            
        <?php endwhile; // End of the loop. ?>
        
    </div><!-- .container -->
</main><!-- #main -->

<?php
get_footer();

/**
 * Related posts function
 */
if (!function_exists('yandexpro_related_posts')) {
    function yandexpro_related_posts() {
        $related = get_posts(array(
            'category__in'   => wp_get_post_categories(get_the_ID()),
            'numberposts'    => 3,
            'post__not_in'   => array(get_the_ID()),
            'meta_key'       => '_thumbnail_id', // Only posts with featured images
        ));

        if ($related) :
        ?>
            <section class="related-posts">
                <h3 class="related-posts-title"><?php esc_html_e('Related Posts', 'yandexpro'); ?></h3>
                <div class="related-posts-grid">
                    <?php foreach ($related as $post) : setup_postdata($post); ?>
                        <article class="related-post">
                            <div class="related-post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('yandexpro-small'); ?>
                                </a>
                            </div>
                            <div class="related-post-content">
                                <h4 class="related-post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
                                <time class="related-post-date"><?php echo esc_html(get_the_date()); ?></time>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php
            wp_reset_postdata();
        endif;
    }
}
?>