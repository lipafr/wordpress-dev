<?php
/**
 * Navigation Component
 * Компонент основной навигации
 * 
 * @package YandexPro
 * @component Navigation
 */

// Определяем текущую страницу для активного состояния
$current_page_id = get_queried_object_id();
$is_home = is_home() || is_front_page();
$is_blog = is_home() || is_single() || is_category() || is_tag();

// Проверяем есть ли назначенное меню
if (has_nav_menu('primary')) {
    wp_nav_menu([
        'theme_location' => 'primary',
        'menu_class'     => 'nav-menu',
        'container'      => false,
        'depth'          => 2,
        'walker'         => new YandexPro_Nav_Walker()
    ]);
} else {
    // Fallback меню если не назначено в админке
    ?>
    <ul class="nav-menu">
        <li class="menu-item">
            <a href="#services" class="nav-link">Услуги</a>
        </li>
        <li class="menu-item">
            <a href="#cases" class="nav-link">Кейсы</a>
        </li>
        <li class="menu-item <?php echo $is_blog ? 'current-menu-item' : ''; ?>">
            <a href="<?php echo esc_url(home_url('/')); ?>" 
               class="nav-link <?php echo $is_blog ? 'active' : ''; ?>">Блог</a>
        </li>
        <li class="menu-item">
            <a href="#about" class="nav-link">Обо мне</a>
        </li>
        <li class="menu-item">
            <a href="#contact" class="nav-link">Контакты</a>
        </li>
    </ul>
    <?php
}

/**
 * Custom Walker для навигации
 */
if (!class_exists('YandexPro_Nav_Walker')) {
    class YandexPro_Nav_Walker extends Walker_Nav_Menu {
        
        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $output .= '<li' . $class_names .'>';
            
            $link_class = 'nav-link';
            if (in_array('current-menu-item', $classes)) {
                $link_class .= ' active';
            }
            
            $output .= '<a href="' . esc_attr($item->url) . '" class="' . $link_class . '">';
            $output .= apply_filters('the_title', $item->title, $item->ID);
            $output .= '</a>';
        }
        
        function end_el(&$output, $item, $depth = 0, $args = null) {
            $output .= '</li>';
        }
    }
}