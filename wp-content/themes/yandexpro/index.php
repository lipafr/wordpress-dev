<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<main id="main" class="site-main" role="main">
    <div class="container">
        
        <?php if (is_home() && !is_front_page()) : ?>
            <!-- Blog page header -->
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Latest Articles', 'yandexpro'); ?></h1>
                <?php
                $blog_description = yandexpro_get_theme_option('blog_description', '');
                if ($blog_description) :
                ?>
                    <div class="page-description">
                        <p><?php echo esc_html($blog_description); ?></p>
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn-primary">
                            <?php esc_html_e('Read blog', 'yandexpro'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </header>
        <?php elseif (is_home() && is_front_page()) : ?>
            <!-- Home page header -->
            <header class="page-header">
                <h1 class="page-title sr-only"><?php esc_html_e('Latest articles', 'yandexpro'); ?></h1>
            </header>
        <?php endif; ?>
        
        <div class="content-area">
            <div class="main-content">
                
                <?php if (have_posts()) : ?>
                    
                    <!-- Posts grid -->
                    <div class="posts-grid">
                        
                        <?php while (have_posts()) : the_post(); ?>
                            
                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                                
                                <!-- Post thumbnail -->
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                            <?php
                                            the_post_thumbnail('yandexpro-medium', array(
                                                'alt' => the_title_attribute(array('echo' => false)),
                                                'loading' => 'lazy',
                                                'decoding' => 'async',
                                            ));
                                            ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Post content -->
                                <div class="post-content">
                                    
                                    <!-- Post meta -->
                                    <div class="post-meta">
                                        <time class="post-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php
                                            printf(
                                                esc_html__('Published %s', 'yandexpro'),
                                                '<span class="date">' . esc_html(get_the_date()) . '</span>'
                                            );
                                            ?>
                                        </time>
                                        
                                        <?php if (get_the_author()) : ?>
                                            <span class="post-author">
                                                <?php
                                                printf(
                                                    esc_html__('Author: %s', 'yandexpro'),
                                                    '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>'
                                                );
                                                ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if (function_exists('yandexpro_reading_time')) : ?>
                                            <span class="reading-time">
                                                <?php
                                                printf(
                                                    esc_html__('Reading time: %s min', 'yandexpro'),
                                                    yandexpro_reading_time()
                                                );
                                                ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Post title -->
                                    <header class="post-header">
                                        <?php
                                        if (is_singular()) :
                                            the_title('<h1 class="post-title">', '</h1>');
                                        else :
                                            the_title('<h2 class="post-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                        endif;
                                        ?>
                                    </header>
                                    
                                    <!-- Post categories -->
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) :
                                    ?>
                                        <div class="post-categories">
                                            <span class="categories-label"><?php esc_html_e('Categories: ', 'yandexpro'); ?></span>
                                            <?php
                                            $category_links = array();
                                            foreach ($categories as $category) {
                                                $category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link">' . esc_html($category->name) . '</a>';
                                            }
                                            echo implode(', ', $category_links);
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Post excerpt -->
                                    <div class="post-excerpt">
                                        <?php
                                        if (has_excerpt()) {
                                            the_excerpt();
                                        } else {
                                            echo wp_trim_words(get_the_content(), yandexpro_get_theme_option('excerpt_length', 30), '...');
                                        }
                                        ?>
                                    </div>
                                    
                                    <!-- Read more link -->
                                    <div class="post-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary read-more-link">
                                            <?php esc_html_e('Read more', 'yandexpro'); ?>
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </div>
                                    
                                </div><!-- .post-content -->
                                
                            </article><!-- #post-<?php the_ID(); ?> -->
                            
                        <?php endwhile; ?>
                        
                    </div><!-- .posts-grid -->
                    
                    <!-- Pagination -->
                    <?php
                    $prev_text = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> ' . esc_html__('← Previous posts', 'yandexpro');
                    $next_text = esc_html__('Next posts →', 'yandexpro') . ' <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                    
                    the_posts_pagination(array(
                        'prev_text' => $prev_text,
                        'next_text' => $next_text,
                        'class'     => 'pagination-wrapper',
                    ));
                    ?>
                    
                <?php else : ?>
                    
                    <!-- No posts found -->
                    <div class="no-posts-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e('Nothing found', 'yandexpro'); ?></h1>
                        </header>
                        
                        <div class="page-content">
                            <?php if (is_home() && current_user_can('publish_posts')) : ?>
                                <p>
                                    <?php
                                    printf(
                                        wp_kses(
                                            __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'yandexpro'),
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
                                <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'yandexpro'); ?></p>
                                <?php get_search_form(); ?>
                            <?php else : ?>
                                <p><?php esc_html_e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'yandexpro'); ?></p>
                                <?php get_search_form(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                <?php endif; ?>
                
            </div><!-- .main-content -->
            
            <!-- Sidebar -->
            <?php if (is_active_sidebar('sidebar-1') && yandexpro_get_theme_option('show_sidebar', true)) : ?>
                <aside id="secondary" class="widget-area sidebar" role="complementary">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </aside>
            <?php endif; ?>
            
        </div><!-- .content-area -->
        
    </div><!-- .container -->
</main><!-- #main -->

<?php
get_footer();