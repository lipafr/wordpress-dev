<?php
/**
 * The template for displaying search results pages
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <div class="content-wrapper">
            
            <!-- Search Header -->
            <header class="page-header search-header">
                <h1 class="page-title">
                    <?php
                    printf(
                        esc_html__('Результаты поиска для: %s', 'yandexpro'),
                        '<span class="search-query">' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
                
                <!-- Search Meta -->
                <div class="search-meta">
                    <?php
                    global $wp_query;
                    $total_results = $wp_query->found_posts;
                    $search_query = get_search_query();
                    
                    if ($total_results > 0) :
                        printf(
                            _n(
                                'Найден %s результат',
                                'Найдено %s результатов',
                                $total_results,
                                'yandexpro'
                            ),
                            '<strong>' . number_format_i18n($total_results) . '</strong>'
                        );
                    else :
                        _e('Результаты не найдены', 'yandexpro');
                    endif;
                    ?>
                </div>

                <!-- Search Form -->
                <div class="search-form-container">
                    <div class="search-again">
                        <p><?php _e('Попробуйте изменить запрос или воспользуйтесь расширенным поиском:', 'yandexpro'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </header>

            <?php if (have_posts()) : ?>

                <!-- Search Filters -->
                <?php if (get_theme_mod('yandexpro_show_search_filters', true)) : ?>
                    <div class="search-filters">
                        <div class="filter-controls">
                            <div class="active-filters">
                                <span class="filter-label"><?php _e('Поиск по:', 'yandexpro'); ?></span>
                                <span class="active-filter">
                                    <?php _e('Все типы контента', 'yandexpro'); ?>
                                    <button type="button" class="remove-filter" aria-label="<?php _e('Убрать фильтр', 'yandexpro'); ?>">×</button>
                                </span>
                            </div>
                            
                            <div class="sort-options">
                                <label for="search-sort" class="sort-label"><?php _e('Сортировка:', 'yandexpro'); ?></label>
                                <select id="search-sort" class="sort-select">
                                    <option value="relevance"><?php _e('По релевантности', 'yandexpro'); ?></option>
                                    <option value="date-desc"><?php _e('Сначала новые', 'yandexpro'); ?></option>
                                    <option value="date-asc"><?php _e('Сначала старые', 'yandexpro'); ?></option>
                                    <option value="title"><?php _e('По названию', 'yandexpro'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Search Results -->
                <div class="search-results">
                    <?php
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>
                            
                            <div class="search-result-content">
                                <header class="entry-header">
                                    <div class="result-type">
                                        <?php
                                        $post_type = get_post_type();
                                        $post_type_object = get_post_type_object($post_type);
                                        
                                        if ($post_type === 'post') {
                                            _e('Запись', 'yandexpro');
                                        } elseif ($post_type === 'page') {
                                            _e('Страница', 'yandexpro');
                                        } else {
                                            echo $post_type_object ? esc_html($post_type_object->labels->singular_name) : esc_html($post_type);
                                        }
                                        ?>
                                    </div>
                                    
                                    <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
                                    
                                    <div class="entry-meta">
                                        <?php if ($post_type === 'post') : ?>
                                            <span class="posted-on">
                                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                    <?php echo esc_html(get_the_date()); ?>
                                                </time>
                                            </span>
                                            
                                            <span class="byline">
                                                <?php
                                                printf(
                                                    __('Автор: %s', 'yandexpro'),
                                                    '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>'
                                                );
                                                ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <span class="result-url">
                                            <?php echo esc_url(get_permalink()); ?>
                                        </span>
                                    </div>
                                </header>

                                <div class="entry-summary">
                                    <?php
                                    // Get the excerpt with search terms highlighted
                                    $excerpt = yandexpro_get_search_excerpt(get_the_content(), get_search_query());
                                    
                                    if ($excerpt) {
                                        echo wp_kses_post($excerpt);
                                    } elseif (has_excerpt()) {
                                        echo wp_kses_post(yandexpro_highlight_search_terms(get_the_excerpt(), get_search_query()));
                                    } else {
                                        $content = wp_strip_all_tags(get_the_content());
                                        echo wp_kses_post(yandexpro_highlight_search_terms(wp_trim_words($content, 30, '...'), get_search_query()));
                                    }
                                    ?>
                                </div>

                                <footer class="entry-footer">
                                    <?php if ($post_type === 'post') : ?>
                                        <?php
                                        // Categories for posts
                                        $categories = get_the_category();
                                        if (!empty($categories)) :
                                            echo '<div class="post-categories">';
                                            echo '<span class="categories-label">' . __('Рубрики:', 'yandexpro') . '</span>';
                                            foreach ($categories as $category) {
                                                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-link" rel="category tag">' . esc_html($category->name) . '</a>';
                                            }
                                            echo '</div>';
                                        endif;
                                        ?>
                                    <?php endif; ?>
                                    
                                    <div class="result-actions">
                                        <a href="<?php the_permalink(); ?>" class="read-more-link">
                                            <?php _e('Читать далее', 'yandexpro'); ?>
                                            <span class="screen-reader-text"><?php echo get_the_title(); ?></span>
                                        </a>
                                        
                                        <?php if ($post_type === 'post' && (comments_open() || get_comments_number())) : ?>
                                            <a href="<?php the_permalink(); ?>#comments" class="comments-link">
                                                <?php
                                                $comments_number = get_comments_number();
                                                if ($comments_number == 0) {
                                                    _e('Оставить комментарий', 'yandexpro');
                                                } else {
                                                    printf(_n('%s комментарий', '%s комментариев', $comments_number, 'yandexpro'), $comments_number);
                                                }
                                                ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </footer>
                            </div>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="search-result-thumbnail">
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
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>

                <!-- Pagination -->
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('&larr; Назад', 'yandexpro'),
                    'next_text' => __('Вперед &rarr;', 'yandexpro'),
                    'before_page_number' => '<span class="screen-reader-text">' . __('Страница', 'yandexpro') . ' </span>',
                ));
                ?>

            <?php else : ?>

                <!-- No Results -->
                <section class="no-results not-found">
                    <div class="no-results-content">
                        <div class="no-results-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                <path d="M7 9h5v1H7z"/>
                            </svg>
                        </div>
                        
                        <h2><?php _e('Ничего не найдено', 'yandexpro'); ?></h2>
                        
                        <p><?php _e('К сожалению, по вашему запросу ничего не найдено. Попробуйте:', 'yandexpro'); ?></p>
                        
                        <div class="search-suggestions">
                            <div class="suggestion-item">
                                <h4><?php _e('Измените запрос', 'yandexpro'); ?></h4>
                                <ul>
                                    <li><?php _e('Проверьте правописание', 'yandexpro'); ?></li>
                                    <li><?php _e('Используйте более общие слова', 'yandexpro'); ?></li>
                                    <li><?php _e('Попробуйте синонимы', 'yandexpro'); ?></li>
                                    <li><?php _e('Уберите лишние слова', 'yandexpro'); ?></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Alternative Search -->
                        <div class="alternative-search">
                            <h3><?php _e('Новый поиск:', 'yandexpro'); ?></h3>
                            <?php get_search_form(); ?>
                        </div>

                        <!-- Popular Content -->
                        <?php
                        $popular_posts = new WP_Query(array(
                            'posts_per_page' => 6,
                            'post_status' => 'publish',
                            'orderby' => 'comment_count',
                            'order' => 'DESC',
                            'ignore_sticky_posts' => true
                        ));
                        
                        if ($popular_posts->have_posts()) :
                        ?>
                            <div class="popular-content">
                                <h3><?php _e('Популярный контент:', 'yandexpro'); ?></h3>
                                <div class="popular-posts-grid">
                                    <?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
                                        <article class="popular-post">
                                            <h4 class="popular-post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                            <div class="popular-post-meta">
                                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                    <?php echo esc_html(get_the_date()); ?>
                                                </time>
                                                <?php if (get_comments_number()) : ?>
                                                    <span class="comment-count">
                                                        <?php printf(_n('%s комментарий', '%s комментариев', get_comments_number(), 'yandexpro'), get_comments_number()); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </article>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>

                        <!-- Categories -->
                        <?php
                        $categories = get_categories(array(
                            'orderby' => 'count',
                            'order' => 'DESC',
                            'number' => 8,
                            'hide_empty' => true
                        ));
                        
                        if ($categories) :
                        ?>
                            <div class="browse-categories">
                                <h3><?php _e('Обзор по рубрикам:', 'yandexpro'); ?></h3>
                                <div class="categories-list">
                                    <?php foreach ($categories as $category) : ?>
                                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-item">
                                            <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                            <span class="category-count"><?php echo $category->count; ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
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

/**
 * Helper Functions for Search
 */

/**
 * Get search excerpt with highlighted terms
 */
if (!function_exists('yandexpro_get_search_excerpt')) {
    function yandexpro_get_search_excerpt($content, $search_terms, $excerpt_length = 30) {
        $content = wp_strip_all_tags($content);
        $search_terms = strtolower($search_terms);
        $content_lower = strtolower($content);
        
        // Find the position of the search term
        $pos = strpos($content_lower, $search_terms);
        
        if ($pos === false) {
            // If exact phrase not found, try individual words
            $words = explode(' ', $search_terms);
            foreach ($words as $word) {
                $word = trim($word);
                if (strlen($word) > 2) {
                    $pos = strpos($content_lower, strtolower($word));
                    if ($pos !== false) {
                        break;
                    }
                }
            }
        }
        
        if ($pos !== false) {
            // Get excerpt around the found term
            $start = max(0, $pos - 100);
            $excerpt = substr($content, $start, 300);
            
            // Add ellipsis if needed
            if ($start > 0) {
                $excerpt = '...' . $excerpt;
            }
            if (strlen($content) > $start + 300) {
                $excerpt .= '...';
            }
            
            return yandexpro_highlight_search_terms($excerpt, $search_terms);
        }
        
        // Fallback to regular excerpt
        return yandexpro_highlight_search_terms(wp_trim_words($content, $excerpt_length, '...'), $search_terms);
    }
}

/**
 * Highlight search terms in text
 */
if (!function_exists('yandexpro_highlight_search_terms')) {
    function yandexpro_highlight_search_terms($text, $search_terms) {
        if (empty($search_terms)) {
            return $text;
        }
        
        $words = explode(' ', $search_terms);
        
        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($word) > 2) {
                $text = preg_replace(
                    '/(' . preg_quote($word, '/') . ')/iu',
                    '<mark class="search-highlight">$1</mark>',
                    $text
                );
            }
        }
        
        return $text;
    }
}
?>