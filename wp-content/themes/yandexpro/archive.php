<?php
/**
 * The template for displaying archive pages
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <div class="content-wrapper">
            
            <?php if (have_posts()) : ?>

                <!-- Archive Header -->
                <header class="page-header archive-header">
                    <?php
                    the_archive_title('<h1 class="page-title">', '</h1>');
                    the_archive_description('<div class="archive-description">', '</div>');
                    ?>
                    
                    <!-- Archive Meta Information -->
                    <div class="archive-meta">
                        <?php
                        // Show post count
                        global $wp_query;
                        $total_posts = $wp_query->found_posts;
                        $posts_per_page = get_option('posts_per_page');
                        $current_page = max(1, get_query_var('paged'));
                        
                        if ($total_posts > 0) :
                            $start_post = (($current_page - 1) * $posts_per_page) + 1;
                            $end_post = min($current_page * $posts_per_page, $total_posts);
                            
                            printf(
                                _n(
                                    'Найдена %s запись',
                                    'Показаны записи %2$s-%3$s из %1$s',
                                    $total_posts,
                                    'yandexpro'
                                ),
                                number_format_i18n($total_posts),
                                number_format_i18n($start_post),
                                number_format_i18n($end_post)
                            );
                        endif;
                        ?>
                    </div>

                    <?php
                    // Category/Tag specific information
                    if (is_category() || is_tag()) :
                        $term = get_queried_object();
                        if ($term && !is_wp_error($term)) :
                    ?>
                        <div class="term-meta">
                            <?php if (is_category()) : ?>
                                <span class="term-type"><?php _e('Рубрика:', 'yandexpro'); ?></span>
                            <?php elseif (is_tag()) : ?>
                                <span class="term-type"><?php _e('Тег:', 'yandexpro'); ?></span>
                            <?php endif; ?>
                            
                            <span class="term-name"><?php echo esc_html($term->name); ?></span>
                            
                            <?php if ($term->count) : ?>
                                <span class="term-count">
                                    <?php printf(_n('(%s запись)', '(%s записей)', $term->count, 'yandexpro'), $term->count); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php
                        endif;
                    endif;
                    ?>
                </header>

                <!-- Archive Filters -->
                <?php if (get_theme_mod('yandexpro_show_archive_filters', true)) : ?>
                    <div class="archive-filters">
                        <div class="filter-controls">
                            
                            <!-- Sort Options -->
                            <div class="sort-options">
                                <label for="archive-sort" class="sort-label"><?php _e('Сортировка:', 'yandexpro'); ?></label>
                                <select id="archive-sort" class="sort-select">
                                    <option value="date-desc" <?php selected(get_query_var('orderby'), 'date'); ?>><?php _e('Сначала новые', 'yandexpro'); ?></option>
                                    <option value="date-asc"><?php _e('Сначала старые', 'yandexpro'); ?></option>
                                    <option value="title-asc"><?php _e('По названию (А-Я)', 'yandexpro'); ?></option>
                                    <option value="title-desc"><?php _e('По названию (Я-А)', 'yandexpro'); ?></option>
                                    <option value="comment-count"><?php _e('По популярности', 'yandexpro'); ?></option>
                                </select>
                            </div>

                            <!-- View Toggle -->
                            <div class="view-toggle">
                                <span class="view-label"><?php _e('Вид:', 'yandexpro'); ?></span>
                                <button type="button" class="view-option view-grid active" aria-label="<?php _e('Сетка', 'yandexpro'); ?>" data-view="grid">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
                                    </svg>
                                </button>
                                <button type="button" class="view-option view-list" aria-label="<?php _e('Список', 'yandexpro'); ?>" data-view="list">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                </button>
                            </div>