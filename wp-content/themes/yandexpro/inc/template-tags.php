<?php
/**
 * Custom template tags for this theme
 *
 * @package YandexPro
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Prints HTML with meta information for the current post-date/time
 */
if (!function_exists('yandexpro_posted_on')) {
    function yandexpro_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Опубликовано %s', 'post date', 'yandexpro'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/**
 * Prints HTML with meta information for the current author
 */
if (!function_exists('yandexpro_posted_by')) {
    function yandexpro_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('Автор %s', 'post author', 'yandexpro'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

/**
 * Prints HTML with meta information for categories, tags and comments
 */
if (!function_exists('yandexpro_entry_footer')) {
    function yandexpro_entry_footer() {
        // Hide category and tag text for pages
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'yandexpro'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Опубликовано в %1$s', 'yandexpro') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'yandexpro'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Отмечено %1$s', 'yandexpro') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Оставить комментарий<span class="screen-reader-text"> к записи %s</span>', 'yandexpro'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
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
    }
}

/**
 * Displays an optional post thumbnail
 */
if (!function_exists('yandexpro_post_thumbnail')) {
    function yandexpro_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('yandexpro-large'); ?>
            </div><!-- .post-thumbnail -->
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'yandexpro-medium',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>
            <?php
        endif;
    }
}

/**
 * Display breadcrumbs
 */
if (!function_exists('yandexpro_breadcrumbs')) {
    function yandexpro_breadcrumbs() {
        if (is_front_page()) {
            return;
        }

        $breadcrumbs = array();
        
        // Add home link
        $breadcrumbs[] = '<a href="' . esc_url(home_url('/')) . '">' . __('Главная', 'yandexpro') . '</a>';

        if (is_category() || is_single()) {
            $categories = get_the_category();
            if ($categories) {
                $category = $categories[0];
                $breadcrumbs[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
            }
        } elseif (is_tag()) {
            $tag = get_queried_object();
            $breadcrumbs[] = '<span>' . esc_html($tag->name) . '</span>';
        } elseif (is_author()) {
            $author = get_queried_object();
            $breadcrumbs[] = '<span>' . esc_html($author->display_name) . '</span>';
        } elseif (is_date()) {
            if (is_year()) {
                $breadcrumbs[] = '<span>' . get_the_date('Y') . '</span>';
            } elseif (is_month()) {
                $year = get_the_date('Y');
                $breadcrumbs[] = '<a href="' . esc_url(get_year_link($year)) . '">' . $year . '</a>';
                $breadcrumbs[] = '<span>' . get_the_date('F Y') . '</span>';
            } elseif (is_day()) {
                $year = get_the_date('Y');
                $month = get_the_date('m');
                $breadcrumbs[] = '<a href="' . esc_url(get_year_link($year)) . '">' . $year . '</a>';
                $breadcrumbs[] = '<a href="' . esc_url(get_month_link($year, $month)) . '">' . get_the_date('F') . '</a>';
                $breadcrumbs[] = '<span>' . get_the_date('d F Y') . '</span>';
            }
        } elseif (is_search()) {
            $breadcrumbs[] = '<span>' . sprintf(__('Результаты поиска: %s', 'yandexpro'), get_search_query()) . '</span>';
        } elseif (is_404()) {
            $breadcrumbs[] = '<span>' . __('Страница не найдена', 'yandexpro') . '</span>';
        }

        if (is_single()) {
            $breadcrumbs[] = '<span>' . get_the_title() . '</span>';
        } elseif (is_page()) {
            // Handle page hierarchy
            $parents = array();
            $parent_id = wp_get_post_parent_id(get_the_ID());
            
            while ($parent_id) {
                $parents[] = $parent_id;
                $parent_id = wp_get_post_parent_id($parent_id);
            }
            
            $parents = array_reverse($parents);
            
            foreach ($parents as $parent) {
                $breadcrumbs[] = '<a href="' . esc_url(get_permalink($parent)) . '">' . get_the_title($parent) . '</a>';
            }
            
            $breadcrumbs[] = '<span>' . get_the_title() . '</span>';
        }

        if (!empty($breadcrumbs)) {
            echo '<nav class="breadcrumbs" aria-label="' . __('Хлебные крошки', 'yandexpro') . '">';
            echo '<ol class="breadcrumb-list">';
            foreach ($breadcrumbs as $index => $breadcrumb) {
                $item_prop = ($index === count($breadcrumbs) - 1) ? ' aria-current="page"' : '';
                echo '<li class="breadcrumb-item"' . $item_prop . '>' . $breadcrumb . '</li>';
            }
            echo '</ol>';
            echo '</nav>';
        }
    }
}

/**
 * Get estimated reading time
 */
if (!function_exists('yandexpro_reading_time')) {
    function yandexpro_reading_time($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        $content = get_post_field('post_content', $post_id);
        $word_count = str_word_count(strip_tags($content));
        $reading_time = ceil($word_count / 200); // 200 words per minute
        
        if ($reading_time <= 1) {
            return sprintf(__('1 мин', 'yandexpro'));
        } else {
            return sprintf(__('%s мин', 'yandexpro'), $reading_time);
        }
    }
}

/**
 * Display post views count
 */
if (!function_exists('yandexpro_post_views')) {
    function yandexpro_post_views($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        $views = get_post_meta($post_id, 'post_views_count', true);
        
        if (!$views) {
            $views = 0;
        }
        
        return number_format_i18n($views);
    }
}

/**
 * Update post views count
 */
if (!function_exists('yandexpro_update_post_views')) {
    function yandexpro_update_post_views($post_id) {
        if (!is_single()) {
            return;
        }
        
        if (empty($post_id)) {
            $post_id = get_the_ID();
        }
        
        // Don't count views for bots
        if (yandexpro_is_bot()) {
            return;
        }
        
        $views = get_post_meta($post_id, 'post_views_count', true);
        
        if (!$views) {
            $views = 0;
        }
        
        $views++;
        update_post_meta($post_id, 'post_views_count', $views);
    }
}

/**
 * Check if visitor is a bot
 */
if (!function_exists('yandexpro_is_bot')) {
    function yandexpro_is_bot() {
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        
        $bots = array(
            'googlebot',
            'bingbot',
            'slurp',
            'duckduckbot',
            'baiduspider',
            'yandexbot',
            'facebookexternalhit',
            'twitterbot',
            'rogerbot',
            'linkedinbot',
            'embedly',
            'quora link preview',
            'showyoubot',
            'outbrain',
            'pinterest',
            'developers.google.com/+/web/snippet'
        );
        
        foreach ($bots as $bot) {
            if (stripos($user_agent, $bot) !== false) {
                return true;
            }
        }
        
        return false;
    }
}

/**
 * Get related posts based on categories
 */
if (!function_exists('yandexpro_get_related_posts')) {
    function yandexpro_get_related_posts($post_id = null, $limit = 3) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        $categories = get_the_category($post_id);
        $category_ids = array();
        
        if ($categories) {
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
        }
        
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $limit,
            'post__not_in' => array($post_id),
            'orderby' => 'rand',
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
 * Generate excerpt with custom length
 */
if (!function_exists('yandexpro_custom_excerpt')) {
    function yandexpro_custom_excerpt($limit = 25, $more_text = '...') {
        $excerpt = get_the_excerpt();
        
        if (!$excerpt) {
            $excerpt = get_the_content();
            $excerpt = strip_shortcodes($excerpt);
            $excerpt = wp_strip_all_tags($excerpt);
        }
        
        $words = explode(' ', $excerpt);
        
        if (count($words) > $limit) {
            $words = array_slice($words, 0, $limit);
            $excerpt = implode(' ', $words) . $more_text;
        }
        
        return $excerpt;
    }
}

/**
 * Social share buttons
 */
if (!function_exists('yandexpro_social_share')) {
    function yandexpro_social_share($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        $post_url = urlencode(get_permalink($post_id));
        $post_title = urlencode(get_the_title($post_id));
        $post_excerpt = urlencode(yandexpro_custom_excerpt(20, ''));
        
        $networks = array(
            'vk' => array(
                'url' => 'https://vk.com/share.php?url=' . $post_url . '&title=' . $post_title . '&description=' . $post_excerpt,
                'name' => 'ВКонтакте',
                'icon' => 'vk'
            ),
            'telegram' => array(
                'url' => 'https://t.me/share/url?url=' . $post_url . '&text=' . $post_title,
                'name' => 'Telegram',
                'icon' => 'telegram'
            ),
            'twitter' => array(
                'url' => 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_url,
                'name' => 'Twitter',
                'icon' => 'twitter'
            ),
            'facebook' => array(
                'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url,
                'name' => 'Facebook',
                'icon' => 'facebook'
            )
        );
        
        echo '<div class="social-share">';
        echo '<span class="share-label">' . __('Поделиться:', 'yandexpro') . '</span>';
        echo '<div class="share-buttons">';
        
        foreach ($networks as $network => $data) {
            printf(
                '<a href="%s" class="share-button share-%s" target="_blank" rel="noopener noreferrer" aria-label="%s">
                    <span class="share-icon">%s</span>
                    <span class="share-text">%s</span>
                </a>',
                esc_url($data['url']),
                esc_attr($network),
                esc_attr(sprintf(__('Поделиться в %s', 'yandexpro'), $data['name'])),
                yandexpro_get_icon($data['icon']),
                esc_html($data['name'])
            );
        }
        
        echo '</div>';
        echo '</div>';
    }
}

/**
 * Get SVG icon
 */
if (!function_exists('yandexpro_get_icon')) {
    function yandexpro_get_icon($icon_name, $size = 20) {
        $icons = array(
            'vk' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0z"/></svg>',
            'telegram' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0z"/></svg>',
            'twitter' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
            'facebook' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
            'search' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>',
            'menu' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>',
            'close' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>',
            'arrow-up' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L10 4.414 4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
            'arrow-right' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>',
            'calendar' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>',
            'user' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>',
            'tag' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V3a1 1 0 011-1h7c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>',
            'comment' => '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path></svg>'
        );
        
        return isset($icons[$icon_name]) ? $icons[$icon_name] : '';
    }
}

/**
 * Display author bio box
 */
if (!function_exists('yandexpro_author_bio')) {
    function yandexpro_author_bio($author_id = null) {
        if (!$author_id) {
            $author_id = get_the_author_meta('ID');
        }
        
        $author_description = get_the_author_meta('description', $author_id);
        
        if (!$author_description) {
            return;
        }
        
        $author_name = get_the_author_meta('display_name', $author_id);
        $author_url = get_the_author_meta('user_url', $author_id);
        $author_posts_url = get_author_posts_url($author_id);
        
        echo '<div class="author-bio">';
        echo '<div class="author-avatar">';
        echo get_avatar($author_id, 80);
        echo '</div>';
        echo '<div class="author-info">';
        echo '<h3 class="author-name">' . esc_html($author_name) . '</h3>';
        echo '<p class="author-description">' . wp_kses_post($author_description) . '</p>';
        echo '<div class="author-links">';
        echo '<a href="' . esc_url($author_posts_url) . '" class="author-posts-link">' . sprintf(__('Все записи %s', 'yandexpro'), esc_html($author_name)) . '</a>';
        
        if ($author_url) {
            echo '<a href="' . esc_url($author_url) . '" class="author-website" target="_blank" rel="noopener noreferrer">' . __('Сайт автора', 'yandexpro') . '</a>';
        }
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

/**
 * Navigation for posts
 */
if (!function_exists('yandexpro_post_navigation')) {
    function yandexpro_post_navigation() {
        $prev_post = get_previous_post();
        $next_post = get_next_post();
        
        if (!$prev_post && !$next_post) {
            return;
        }
        
        echo '<nav class="post-navigation" role="navigation" aria-label="' . __('Навигация по записям', 'yandexpro') . '">';
        echo '<h2 class="screen-reader-text">' . __('Навигация по записям', 'yandexpro') . '</h2>';
        echo '<div class="nav-links">';
        
        if ($prev_post) {
            echo '<div class="nav-previous">';
            echo '<a href="' . esc_url(get_permalink($prev_post->ID)) . '" rel="prev">';
            echo '<span class="nav-subtitle">' . __('Предыдущая запись:', 'yandexpro') . '</span>';
            echo '<span class="nav-title">' . esc_html(get_the_title($prev_post->ID)) . '</span>';
            echo '</a>';
            echo '</div>';
        }
        
        if ($next_post) {
            echo '<div class="nav-next">';
            echo '<a href="' . esc_url(get_permalink($next_post->ID)) . '" rel="next">';
            echo '<span class="nav-subtitle">' . __('Следующая запись:', 'yandexpro') . '</span>';
            echo '<span class="nav-title">' . esc_html(get_the_title($next_post->ID)) . '</span>';
            echo '</a>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</nav>';
    }
}

/**
 * Custom search form
 */
if (!function_exists('yandexpro_search_form')) {
    function yandexpro_search_form() {
        $search_placeholder = __('Поиск...', 'yandexpro');
        $search_button = __('Найти', 'yandexpro');
        
        $form = '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">';
        $form .= '<label for="search-field" class="screen-reader-text">' . __('Поиск по сайту', 'yandexpro') . '</label>';
        $form .= '<div class="search-field-wrapper">';
        $form .= '<input type="search" id="search-field" class="search-field" placeholder="' . esc_attr($search_placeholder) . '" value="' . get_search_query() . '" name="s" />';
        $form .= '<button type="submit" class="search-submit" aria-label="' . esc_attr($search_button) . '">';
        $form .= yandexpro_get_icon('search', 20);
        $form .= '<span class="search-submit-text">' . esc_html($search_button) . '</span>';
        $form .= '</button>';
        $form .= '</div>';
        $form .= '</form>';
        
        return $form;
    }
}

// Add action to update post views
add_action('wp_head', function() {
    if (is_single()) {
        yandexpro_update_post_views(get_the_ID());
    }
});

// Custom search form
add_filter('get_search_form', 'yandexpro_search_form');
?>
            '