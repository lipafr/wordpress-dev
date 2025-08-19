<?php
/**
 * Mobile Menu Component
 * Компонент мобильного меню
 * 
 * @package YandexPro
 * @component MobileMenu
 */

// Определяем текущую страницу
$is_blog = is_home() || is_single() || is_category() || is_tag();
?>

<!-- Mobile Menu Toggle -->
<button class="mobile-menu-toggle" 
        aria-label="<?php esc_attr_e('Открыть меню', 'yandexpro'); ?>" 
        aria-expanded="false"
        aria-controls="mobile-menu"
        data-mobile-toggle>
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
    <span class="hamburger-line"></span>
</button>

<!-- Mobile Menu -->
<div id="mobile-menu" 
     class="mobile-menu" 
     aria-hidden="true"
     data-mobile-menu>
    <div class="mobile-menu-container">
        <?php
        // Используем то же меню что и в десктопе
        if (has_nav_menu('primary')) {
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class'     => 'mobile-menu-list',
                'container'      => false,
                'depth'          => 2,
                'walker'         => new YandexPro_Mobile_Nav_Walker()
            ]);
        } else {
            // Fallback для мобильного меню
            ?>
            <ul class="mobile-menu-list">
                <li class="mobile-menu-item">
                    <a href="#services" class="mobile-nav-link">Услуги</a>
                </li>
                <li class="mobile-menu-item">
                    <a href="#cases" class="mobile-nav-link">Кейсы</a>
                </li>
                <li class="mobile-menu-item <?php echo $is_blog ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url(home_url('/')); ?>" 
                       class="mobile-nav-link <?php echo $is_blog ? 'active' : ''; ?>">Блог</a>
                </li>
                <li class="mobile-menu-item">
                    <a href="#about" class="mobile-nav-link">Обо мне</a>
                </li>
                <li class="mobile-menu-item">
                    <a href="#contact" class="mobile-nav-link">Контакты</a>
                </li>
            </ul>
            <?php
        }
        ?>
    </div>
</div>

<?php
/**
 * Custom Walker для мобильной навигации
 */
if (!class_exists('YandexPro_Mobile_Nav_Walker')) {
    class YandexPro_Mobile_Nav_Walker extends Walker_Nav_Menu {
        
        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'mobile-menu-item';
            $classes[] = 'menu-item-' . $item->ID;
            
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $output .= '<li' . $class_names .'>';
            
            $link_class = 'mobile-nav-link';
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
?>