<?php
/**
 * Blog Categories Module
 * 
 * Управление категориями блога и их отображением в навигации
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ========================================
 * НАСТРОЙКИ CUSTOMIZER ДЛЯ КАТЕГОРИЙ
 * ========================================
 */

/**
 * Регистрация настроек категорий в Customizer
 */
if (!function_exists('yandexpro_customize_blog_categories')) {
    function yandexpro_customize_blog_categories($wp_customize) {
        
        // Добавляем секцию для настроек блога
        $wp_customize->add_section('yandexpro_blog_settings', array(
            'title'       => __('Настройки блога', 'yandexpro'),
            'priority'    => 35,
            'description' => __('Выберите категории для отображения в навигации блога', 'yandexpro'),
        ));
        
        // Получаем все категории
        $categories = yandexpro_get_all_categories();
        
        if (empty($categories)) {
            yandexpro_add_no_categories_message($wp_customize);
            return;
        }
        
        // Создаем чекбоксы для каждой категории
        yandexpro_add_category_checkboxes($wp_customize, $categories);
        
        // Дополнительные настройки
        yandexpro_add_category_settings($wp_customize);
    }
}
add_action('customize_register', 'yandexpro_customize_blog_categories');

/**
 * Добавление сообщения об отсутствии категорий
 */
if (!function_exists('yandexpro_add_no_categories_message')) {
    function yandexpro_add_no_categories_message($wp_customize) {
        $wp_customize->add_setting('yandexpro_no_categories_message', array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('yandexpro_no_categories_message', array(
            'type'        => 'hidden',
            'section'     => 'yandexpro_blog_settings',
            'description' => sprintf(
                '<div class="notice notice-info"><p>%s</p></div>',
                __('Пока нет созданных категорий. Создайте категории в разделе "Записи → Рубрики".', 'yandexpro')
            ),
        ));
    }
}

/**
 * Добавление чекбоксов для категорий
 */
if (!function_exists('yandexpro_add_category_checkboxes')) {
    function yandexpro_add_category_checkboxes($wp_customize, $categories) {
        
        foreach ($categories as $category) {
            
            // Настройка для каждой категории
            $setting_id = 'yandexpro_show_category_' . $category->term_id;
            
            $wp_customize->add_setting($setting_id, array(
                'default'           => false,
                'sanitize_callback' => 'wp_validate_boolean',
                'transport'         => 'refresh',
            ));
            
            // Контрол чекбокс для каждой категории
            $wp_customize->add_control($setting_id, array(
                'label'   => sprintf(
                    '%s (%s)',
                    $category->name,
                    yandexpro_format_post_count($category->count)
                ),
                'section' => 'yandexpro_blog_settings',
                'type'    => 'checkbox',
            ));
        }
    }
}

/**
 * Добавление дополнительных настроек
 */
if (!function_exists('yandexpro_add_category_settings')) {
    function yandexpro_add_category_settings($wp_customize) {
        
        // Максимальное количество категорий
        $wp_customize->add_setting('yandexpro_max_categories', array(
            'default'           => 8,
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        ));
        
        $wp_customize->add_control('yandexpro_max_categories_control', array(
            'label'       => __('Максимум категорий', 'yandexpro'),
            'description' => __('Максимальное количество категорий для отображения (от 4 до 12)', 'yandexpro'),
            'section'     => 'yandexpro_blog_settings',
            'settings'    => 'yandexpro_max_categories',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 4,
                'max'  => 12,
                'step' => 1,
            ),
        ));
        
        // Автоматический выбор популярных категорий
        $wp_customize->add_setting('yandexpro_auto_popular_categories', array(
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
            'transport'         => 'refresh',
        ));
        
        $wp_customize->add_control('yandexpro_auto_popular_categories', array(
            'label'       => __('Автоматически показывать популярные категории', 'yandexpro'),
            'description' => __('Если не выбрано ни одной категории, автоматически показывать самые популярные', 'yandexpro'),
            'section'     => 'yandexpro_blog_settings',
            'type'        => 'checkbox',
        ));
    }
}

/**
 * ========================================
 * ПОЛУЧЕНИЕ И ОБРАБОТКА КАТЕГОРИЙ
 * ========================================
 */

/**
 * Получение всех категорий (кеширование)
 */
if (!function_exists('yandexpro_get_all_categories')) {
    function yandexpro_get_all_categories() {
        
        // Пытаемся получить из кеша
        $cache_key = 'yandexpro_all_categories';
        $categories = wp_cache_get($cache_key);
        
        if (false === $categories) {
            $categories = get_categories(array(
                'hide_empty' => false,
                'exclude'    => array(1), // Исключаем "Без рубрики"
                'orderby'    => 'name',
                'order'      => 'ASC',
            ));
            
            // Кешируем на 1 час
            wp_cache_set($cache_key, $categories, '', HOUR_IN_SECONDS);
        }
        
        return apply_filters('yandexpro_all_categories', $categories);
    }
}

/**
 * Получение избранных категорий для отображения
 */
if (!function_exists('yandexpro_get_featured_categories')) {
    function yandexpro_get_featured_categories($force_refresh = false) {
        
        // Проверяем кеш
        $cache_key = 'yandexpro_featured_categories';
        if (!$force_refresh) {
            $cached = wp_cache_get($cache_key);
            if (false !== $cached) {
                return $cached;
            }
        }
        
        $max_categories = get_theme_mod('yandexpro_max_categories', 8);
        $selected_categories = array();
        
        // Получаем все категории
        $all_categories = yandexpro_get_all_categories();
        
        // Проверяем какие категории выбраны через чекбоксы
        foreach ($all_categories as $category) {
            $is_selected = get_theme_mod('yandexpro_show_category_' . $category->term_id, false);
            if ($is_selected) {
                $selected_categories[] = $category->term_id;
            }
        }
        
        // Если ничего не выбрано и включен автовыбор
        if (empty($selected_categories) && get_theme_mod('yandexpro_auto_popular_categories', true)) {
            $selected_categories = yandexpro_get_popular_categories($max_categories);
        } else {
            // Ограничиваем количество выбранных категорий
            $selected_categories = array_slice($selected_categories, 0, $max_categories);
        }
        
        // Кешируем результат
        wp_cache_set($cache_key, $selected_categories, '', HOUR_IN_SECONDS);
        
        return apply_filters('yandexpro_featured_categories', $selected_categories);
    }
}

/**
 * Получение популярных категорий
 */
if (!function_exists('yandexpro_get_popular_categories')) {
    function yandexpro_get_popular_categories($limit = 8) {
        
        $popular_categories = get_categories(array(
            'orderby'    => 'count',
            'order'      => 'DESC',
            'number'     => $limit,
            'hide_empty' => true,
            'exclude'    => array(1), // Исключаем "Без рубрики"
        ));
        
        $category_ids = array();
        foreach ($popular_categories as $category) {
            $category_ids[] = $category->term_id;
        }
        
        return $category_ids;
    }
}

/**
 * Проверка активности категории
 */
if (!function_exists('yandexpro_is_category_active')) {
    function yandexpro_is_category_active($category_id) {
        return is_category($category_id);
    }
}

/**
 * ========================================
 * ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
 * ========================================
 */

/**
 * Форматирование количества постов
 */
if (!function_exists('yandexpro_format_post_count')) {
    function yandexpro_format_post_count($count) {
        return sprintf(
            _n('%d пост', '%d постов', $count, 'yandexpro'),
            $count
        );
    }
}

/**
 * Получение ссылки на категорию
 */
if (!function_exists('yandexpro_get_category_link_safe')) {
    function yandexpro_get_category_link_safe($category_id) {
        $link = get_category_link($category_id);
        return is_wp_error($link) ? '#' : $link;
    }
}

/**
 * Получение информации о категории
 */
if (!function_exists('yandexpro_get_category_info')) {
    function yandexpro_get_category_info($category_id) {
        $category = get_category($category_id);
        
        if (!$category || is_wp_error($category)) {
            return false;
        }
        
        return array(
            'id'          => $category->term_id,
            'name'        => $category->name,
            'slug'        => $category->slug,
            'description' => $category->description,
            'count'       => $category->count,
            'link'        => yandexpro_get_category_link_safe($category_id),
            'is_active'   => yandexpro_is_category_active($category_id),
        );
    }
}

/**
 * ========================================
 * ОЧИСТКА КЕША
 * ========================================
 */

/**
 * Очистка кеша категорий при изменениях
 */
if (!function_exists('yandexpro_clear_categories_cache')) {
    function yandexpro_clear_categories_cache() {
        wp_cache_delete('yandexpro_all_categories');
        wp_cache_delete('yandexpro_featured_categories');
        
        // Очищаем транзиенты если используются
        delete_transient('yandexpro_categories_cache');
    }
}

// Очищаем кеш при изменении категорий
add_action('created_category', 'yandexpro_clear_categories_cache');
add_action('edited_category', 'yandexpro_clear_categories_cache');
add_action('delete_category', 'yandexpro_clear_categories_cache');

// Очищаем кеш при сохранении настроек темы
add_action('customize_save_after', 'yandexpro_clear_categories_cache');

/**
 * ========================================
 * API ДЛЯ ШАБЛОНОВ
 * ========================================
 */

/**
 * Вывод навигации по категориям
 */
if (!function_exists('yandexpro_render_categories_nav')) {
    function yandexpro_render_categories_nav($args = array()) {
        
        $defaults = array(
            'show_all_link'    => true,
            'all_link_text'    => __('Все статьи', 'yandexpro'),
            'all_link_url'     => home_url('/blog'),
            'container_class'  => 'categories-nav',
            'link_class'       => 'category-link',
            'active_class'     => 'active',
        );
        
        $args = wp_parse_args($args, $defaults);
        
        $featured_categories = yandexpro_get_featured_categories();
        
        if (empty($featured_categories) && !$args['show_all_link']) {
            return;
        }
        
        // Начинаем вывод
        echo '<nav class="' . esc_attr($args['container_class']) . '" role="navigation" aria-label="' . esc_attr__('Categories Navigation', 'yandexpro') . '">';
        
        // Ссылка "Все статьи"
        if ($args['show_all_link']) {
            $all_active = (is_home() || is_front_page()) ? ' ' . $args['active_class'] : '';
            echo '<a href="' . esc_url($args['all_link_url']) . '" class="' . esc_attr($args['link_class'] . $all_active) . '">';
            echo esc_html($args['all_link_text']);
            echo '</a>';
        }
        
        // Категории
        foreach ($featured_categories as $cat_id) {
            $category_info = yandexpro_get_category_info($cat_id);
            
            if (!$category_info) {
                continue;
            }
            
            $active_class = $category_info['is_active'] ? ' ' . $args['active_class'] : '';
            
            echo '<a href="' . esc_url($category_info['link']) . '" class="' . esc_attr($args['link_class'] . $active_class) . '">';
            echo esc_html($category_info['name']);
            echo '</a>';
        }
        
        echo '</nav>';
        
        // Хук для дополнительного контента
        do_action('yandexpro_after_categories_nav', $args);
    }
}

/**
 * ========================================
 * СОВМЕСТИМОСТЬ И МИГРАЦИЯ
 * ========================================
 */

/**
 * Обратная совместимость со старыми функциями
 */
if (!function_exists('yandexpro_get_categories_choices')) {
    function yandexpro_get_categories_choices() {
        $categories = yandexpro_get_all_categories();
        $choices = array();
        
        foreach ($categories as $category) {
            $choices[$category->term_id] = sprintf(
                '%s (%s)',
                $category->name,
                yandexpro_format_post_count($category->count)
            );
        }
        
        return $choices;
    }
}

/**
 * ========================================
 * ХУКИ ДЛЯ РАСШИРЕНИЯ
 * ========================================
 */

// Позволяем другим модулям модифицировать логику категорий
do_action('yandexpro_blog_categories_loaded');

// Хук для добавления кастомных настроек категорий
add_action('yandexpro_category_settings', function($wp_customize) {
    do_action('yandexpro_custom_category_settings', $wp_customize);
});