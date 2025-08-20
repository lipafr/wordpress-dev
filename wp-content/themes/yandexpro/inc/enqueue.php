<?php
/**
 * Проверяем что в inc/enqueue.php есть подключение navigation.css
 * 
 * ДОЛЖНО БЫТЬ ПРИМЕРНО ТАК:
 */

// Navigation модуль
$nav_css = get_template_directory() . '/assets/css/modules/navigation.css';
if (file_exists($nav_css)) {
    wp_enqueue_style(
        'yandexpro-navigation',
        get_template_directory_uri() . '/assets/css/modules/navigation.css',
        ['yandexpro-header'],
        YANDEXPRO_VERSION
    );
}