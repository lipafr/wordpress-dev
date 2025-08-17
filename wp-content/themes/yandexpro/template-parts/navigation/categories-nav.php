<?php
/**
 * Template part for displaying categories navigation
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Получаем настройки компонента
$nav_args = wp_parse_args($args ?? array(), array(
    'show_all_link'    => true,
    'show_toggle'      => true,
    'max_visible'      => 6,
    'container_class'  => 'top-categories',
));

// Получаем категории
$featured_categories = yandexpro_get_featured_categories();

if (empty($featured_categories) && !$nav_args['show_all_link']) {
    return;
}

// Разделяем на видимые и скрытые
$visible_categories = array_slice($featured_categories, 0, $nav_args['max_visible']);
$hidden_categories = array_slice($featured_categories, $nav_args['max_visible']);
?>

<!-- Top Categories Navigation -->
<section class="<?php echo esc_attr($nav_args['container_class']); ?>">
    <div class="container">
        <nav class="categories-nav" role="navigation" aria-label="<?php esc_attr_e('Categories Navigation', 'yandexpro'); ?>">
            
            <?php if ($nav_args['show_all_link']) : ?>
                <!-- Кнопка "Все статьи" -->
                <a href="<?php echo esc_url(home_url('/blog')); ?>" 
                   class="category-link <?php echo (is_home() || is_front_page()) ? 'active' : ''; ?>">
                    <?php esc_html_e('Все статьи', 'yandexpro'); ?>
                </a>
            <?php endif; ?>
            
            <?php if (!empty($visible_categories)) : ?>
                <!-- Видимые категории -->
                <?php foreach ($visible_categories as $cat_id) : 
                    $category_info = yandexpro_get_category_info($cat_id);
                    if (!$category_info) continue;
                ?>
                    <a href="<?php echo esc_url($category_info['link']); ?>" 
                       class="category-link <?php echo $category_info['is_active'] ? 'active' : ''; ?>">
                        <?php echo esc_html($category_info['name']); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <?php if (!empty($hidden_categories) && $nav_args['show_toggle']) : ?>
                <!-- Кнопка "Смотреть всё" -->
                <button class="categories-toggle-btn" 
                        onclick="yandexproToggleCategories(this)" 
                        aria-expanded="false"
                        aria-controls="hiddenCategories">
                    <span class="btn-text"><?php esc_html_e('Смотреть всё', 'yandexpro'); ?></span>
                    <span class="btn-icon" aria-hidden="true">▼</span>
                </button>
                
                <!-- Скрытые категории -->
                <div class="categories-hidden" id="hiddenCategories" aria-hidden="true">
                    <?php foreach ($hidden_categories as $cat_id) : 
                        $category_info = yandexpro_get_category_info($cat_id);
                        if (!$category_info) continue;
                    ?>
                        <a href="<?php echo esc_url($category_info['link']); ?>" 
                           class="category-link <?php echo $category_info['is_active'] ? 'active' : ''; ?>">
                            <?php echo esc_html($category_info['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($featured_categories)) : ?>
                <!-- Сообщение для настройки -->
                <div class="categories-empty-state">
                    <span class="empty-message">
                        <?php esc_html_e('Настройте категории в разделе "Внешний вид → Настроить → Настройки блога"', 'yandexpro'); ?>
                    </span>
                </div>
            <?php endif; ?>
            
        </nav>
        
        <?php 
        /**
         * Хук для добавления дополнительного контента в навигацию
         */
        do_action('yandexpro_after_categories_nav', $nav_args); 
        ?>
    </div>
</section>

<?php
/**
 * Инлайн скрипт для переключения категорий
 * (минимальный JS для функциональности)
 */
if (!empty($hidden_categories) && $nav_args['show_toggle']) :
?>
<script>
window.yandexproToggleCategories = function(button) {
    const hiddenCategories = document.getElementById('hiddenCategories');
    const btnText = button.querySelector('.btn-text');
    const btnIcon = button.querySelector('.btn-icon');
    const isExpanded = button.getAttribute('aria-expanded') === 'true';
    
    if (isExpanded) {
        // Скрываем категории
        hiddenCategories.classList.remove('show');
        hiddenCategories.setAttribute('aria-hidden', 'true');
        btnText.textContent = '<?php esc_js(_e('Смотреть всё', 'yandexpro')); ?>';
        btnIcon.textContent = '▼';
        button.classList.remove('expanded');
        button.setAttribute('aria-expanded', 'false');
    } else {
        // Показываем категории
        hiddenCategories.classList.add('show');
        hiddenCategories.setAttribute('aria-hidden', 'false');
        btnText.textContent = '<?php esc_js(_e('Скрыть', 'yandexpro')); ?>';
        btnIcon.textContent = '▲';
        button.classList.add('expanded');
        button.setAttribute('aria-expanded', 'true');
    }
};
</script>
<?php endif; ?>