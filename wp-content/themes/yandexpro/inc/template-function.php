<?php
/**
 * Вспомогательные функции для шаблонов
 * Template helper functions
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Запретить прямой доступ
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Подсчет времени чтения статьи
 */
function yandexpro_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Средняя скорость чтения 200 слов/мин
    
    return max(1, $reading_time);
}

/**
 * Увеличение счетчика просмотров поста
 */
function yandexpro_set_post_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $count_key = 'post_views';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

/**
 * Получение количества просмотров поста
 */
function yandexpro_get_post_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $count = get_post_meta($post_id, 'post_views', true);
    
    if ($count == '') {
        delete_post_meta($post_id, 'post_views');
        add_post_meta($post_id, 'post_views', '0');
        return 0;
    }
    
    return $count;
}

/**
 * Автоматический подсчет просмотров на single постах
 */
function yandexpro_track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;    
    }
    yandexpro_set_post_views($post_id);
}
add_action('wp_head', 'yandexpro_track_post_views');

/**
 * Получение популярных постов
 */
function yandexpro_get_popular_posts($limit = 5) {
    return get_posts([
        'numberposts' => $limit,
        'meta_key' => 'post_views',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'post_status' => 'publish'
    ]);
}

/**
 * Кастомные размеры excerpt
 */
function yandexpro_custom_excerpt($limit = 25, $post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $excerpt = get_the_excerpt($post_id);
    $words = explode(' ', $excerpt);
    
    if (count($words) > $limit) {
        $words = array_slice($words, 0, $limit);
        $excerpt = implode(' ', $words) . '...';
    }
    
    return $excerpt;
}

/**
 * Получение цвета категории
 */
function yandexpro_get_category_color($category_id) {
    $colors = [
        '#7c3aed', // Основной фиолетовый
        '#ec4899', // Акцентный розовый  
        '#10b981', // Зеленый
        '#f59e0b', // Оранжевый
        '#3b82f6', // Синий
        '#8b5cf6', // Фиолетовый светлый
        '#06b6d4', // Голубой
        '#84cc16'  // Лайм
    ];
    
    return $colors[$category_id % count($colors)];
}

/**
 * Хлебные крошки
 */
function yandexpro_breadcrumbs() {
    $delimiter = ' › ';
    $home = __('Главная', 'yandexpro');
    $before = '<span class="current">';
    $after = '</span>';
    
    if (!is_home() && !is_front_page()) {
        echo '<nav class="breadcrumbs">';
        echo '<a href="' . esc_url(home_url('/')) . '">' . $home . '</a>' . $delimiter;
        
        if (is_category()) {
            $cat = get_queried_object();
            if ($cat->parent) {
                $parent_cat = get_category($cat->parent);
                echo '<a href="' . esc_url(get_category_link($parent_cat->term_id)) . '">' . esc_html($parent_cat->name) . '</a>' . $delimiter;
            }
            echo $before . esc_html($cat->name) . $after;
            
        } elseif (is_single()) {
            $category = get_the_category();
            if ($category) {
                echo '<a href="' . esc_url(get_category_link($category[0]->term_id)) . '">' . esc_html($category[0]->name) . '</a>' . $delimiter;
            }
            echo $before . get_the_title() . $after;
            
        } elseif (is_page()) {
            echo $before . get_the_title() . $after;
            
        } elseif (is_search()) {
            echo $before . __('Поиск: ', 'yandexpro') . get_search_query() . $after;
            
        } elseif (is_tag()) {
            echo $before . __('Тег: ', 'yandexpro') . single_tag_title('', false) . $after;
            
        } elseif (is_404()) {
            echo $before . __('Страница не найдена', 'yandexpro') . $after;
        }
        
        echo '</nav>';
    }
}

/**
 * Связанные посты
 */
function yandexpro_related_posts($post_id = null, $limit = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return [];
    }
    
    return get_posts([
        'numberposts' => $limit,
        'post__not_in' => [$post_id],
        'category__in' => $categories,
        'meta_query' => [
            [
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            ]
        ],
        'orderby' => 'rand'
    ]);
}

/**
 * Социальные кнопки для поста
 */
function yandexpro_social_share_buttons($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post_url = get_permalink($post_id);
    $post_title = get_the_title($post_id);
    $post_excerpt = yandexpro_custom_excerpt(20, $post_id);
    
    $shares = [
        'telegram' => [
            'url' => 'https://t.me/share/url?url=' . urlencode($post_url) . '&text=' . urlencode($post_title),
            'title' => __('Поделиться в Telegram', 'yandexpro'),
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.13-.31-1.09-.66.03-.18.14-.37.33-.56 1.31-1.15 2.73-2.17 4.25-3.06 2.34-1.09 4.99-2.04 7.94-2.85.71-.2 1.36-.02 1.79.6z"/></svg>'
        ],
        'vk' => [
            'url' => 'https://vk.com/share.php?url=' . urlencode($post_url) . '&title=' . urlencode($post_title),
            'title' => __('Поделиться в VK', 'yandexpro'),
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zm3.692 17.123h-1.744c-.66 0-.864-.525-2.05-1.727-1.033-1.01-1.49-.834-1.49.18v1.57c0 .394-.127.506-.807.506-1.677 0-3.54-1.028-4.856-2.944C6.695 11.008 6.25 7.5 6.25 7.5s-.102-.31.36-.31h1.868c.5 0 .69.22.885.737.9 2.4 2.4 4.5 3.024 3.065.188-.434.274-1.41-.01-2.17-.24-.673-.634-.71-.634-1.436 0-.31.188-.6.49-.6h2.95c.414 0 .56.216.56.558v2.99c0 .414.188 1.23.862 1.23.688 0 1.23-.414 2.482-1.678 1.2-1.2 2.07-3.066 2.07-3.066s.188-.414.482-.438h1.744c.966 0 .12.482-.188 1.09-.36.726-1.644 2.538-1.644 2.538-.414.6-.345.867 0 1.4.258.398 1.102 1.102 1.67 1.782.66.78.12 1.2-.24 1.2z"/></svg>'
        ],
        'facebook' => [
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($post_url),
            'title' => __('Поделиться в Facebook', 'yandexpro'),
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>'
        ],
        'twitter' => [
            'url' => 'https://twitter.com/intent/tweet?url=' . urlencode($post_url) . '&text=' . urlencode($post_title),
            'title' => __('Поделиться в Twitter', 'yandexpro'),
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>'
        ],
        'linkedin' => [
            'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($post_url),
            'title' => __('Поделиться в LinkedIn', 'yandexpro'),
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>'
        ]
    ];
    
    $output = '<div class="social-share">';
    $output .= '<span class="share-label">' . __('Поделиться:', 'yandexpro') . '</span>';
    
    foreach ($shares as $network => $data) {
        $output .= sprintf(
            '<a href="%s" class="share-btn share-btn-%s" target="_blank" rel="noopener" title="%s">%s</a>',
            esc_url($data['url']),
            esc_attr($network),
            esc_attr($data['title']),
            $data['icon']
        );
    }
    
    $output .= '</div>';
    
    return $output;
}

/**
 * Форматирование даты на русском
 */
function yandexpro_format_date($date, $format = 'j F Y') {
    $months = [
        'January'   => 'января',
        'February'  => 'февраля', 
        'March'     => 'марта',
        'April'     => 'апреля',
        'May'       => 'мая',
        'June'      => 'июня',
        'July'      => 'июля',
        'August'    => 'августа',
        'September' => 'сентября',
        'October'   => 'октября',
        'November'  => 'ноября',
        'December'  => 'декабря'
    ];
    
    $formatted_date = date($format, strtotime($date));
    
    foreach ($months as $en => $ru) {
        $formatted_date = str_replace($en, $ru, $formatted_date);
    }
    
    return $formatted_date;
}

/**
 * Получение следующего и предыдущего поста
 */
function yandexpro_post_navigation() {
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    
    if (!$prev_post && !$next_post) {
        return;
    }
    
    echo '<nav class="post-navigation">';
    
    if ($prev_post) {
        echo '<div class="nav-previous">';
        echo '<a href="' . esc_url(get_permalink($prev_post->ID)) . '" rel="prev">';
        echo '<span class="nav-direction">← ' . __('Предыдущая статья', 'yandexpro') . '</span>';
        echo '<span class="nav-title">' . esc_html(get_the_title($prev_post->ID)) . '</span>';
        echo '</a>';
        echo '</div>';
    }
    
    if ($next_post) {
        echo '<div class="nav-next">';
        echo '<a href="' . esc_url(get_permalink($next_post->ID)) . '" rel="next">';
        echo '<span class="nav-direction">' . __('Следующая статья', 'yandexpro') . ' →</span>';
        echo '<span class="nav-title">' . esc_html(get_the_title($next_post->ID)) . '</span>';
        echo '</a>';
        echo '</div>';
    }
    
    echo '</nav>';
}

/**
 * Структурированные данные для SEO
 */
function yandexpro_structured_data($type = 'article', $post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post = get_post($post_id);
    $author = get_userdata($post->post_author);
    $site_name = get_bloginfo('name');
    $site_url = home_url();
    
    $structured_data = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title($post_id),
        'description' => yandexpro_custom_excerpt(30, $post_id),
        'author' => [
            '@type' => 'Person',
            'name' => $author->display_name,
            'url' => get_author_posts_url($author->ID)
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $site_name,
            'url' => $site_url,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => get_site_icon_url(512) ?: $site_url . '/wp-content/themes/yandexpro/assets/img/logo.png'
            ]
        ],
        'datePublished' => get_the_date('c', $post_id),
        'dateModified' => get_the_modified_date('c', $post_id),
        'mainEntityOfPage' => get_permalink($post_id),
        'url' => get_permalink($post_id)
    ];
    
    if (has_post_thumbnail($post_id)) {
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        if ($thumbnail) {
            $structured_data['image'] = [
                '@type' => 'ImageObject',
                'url' => $thumbnail[0],
                'width' => $thumbnail[1],
                'height' => $thumbnail[2]
            ];
        }
    }
    
    return json_encode($structured_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

/**
 * Автоматический alt текст для изображений
 */
function yandexpro_auto_image_alt($attr, $attachment, $size) {
    if (empty($attr['alt'])) {
        $post_title = get_the_title(wp_get_post_parent_id($attachment->ID));
        if ($post_title) {
            $attr['alt'] = $post_title;
        } else {
            $attr['alt'] = get_the_title($attachment->ID);
        }
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'yandexpro_auto_image_alt', 10, 3);

/**
 * Проверка есть ли контент в футере
 */
function yandexpro_has_footer_widgets() {
    return is_active_sidebar('footer-1') || 
           is_active_sidebar('footer-2') || 
           is_active_sidebar('footer-3');
}

/**
 * Кастомные query vars для фильтрации
 */
function yandexpro_add_query_vars($vars) {
    $vars[] = 'post_year';
    $vars[] = 'post_views_min';
    $vars[] = 'reading_time';
    return $vars;
}
add_filter('query_vars', 'yandexpro_add_query_vars');

/**
 * Модификация main query для фильтров
 */
function yandexpro_pre_get_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        
        // Фильтр по году
        if (get_query_var('post_year')) {
            $year = intval(get_query_var('post_year'));
            $query->set('year', $year);
        }
        
        // Фильтр по популярности
        if (get_query_var('post_views_min')) {
            $views_min = intval(get_query_var('post_views_min'));
            $query->set('meta_query', [
                [
                    'key' => 'post_views',
                    'value' => $views_min,
                    'compare' => '>='
                ]
            ]);
        }
        
        // Сортировка по популярности на главной
        if ($query->is_home() && !$query->get('orderby')) {
            $query->set('meta_key', 'post_views');
            $query->set('orderby', 'meta_value_num date');
            $query->set('order', 'DESC');
        }
    }
}
add_action('pre_get_posts', 'yandexpro_pre_get_posts');