<?php
/**
 * Hero Section Component
 * Компонент главной секции
 * 
 * @package YandexPro
 * @component Hero
 */

// Настройки hero секции
$hero_title = get_theme_mod('hero_title', 'Блог о <span class="gradient-text">Яндекс Директ</span><br>и интернет-маркетинге');
$hero_description = get_theme_mod('hero_description', 'Практические кейсы, инсайты и тренды из мира контекстной рекламы. Только проверенная информация от практикующего специалиста.');
$search_placeholder = get_theme_mod('search_placeholder', 'Поиск по статьям...');
?>

<section class="hero" id="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">
                <?php echo wp_kses_post($hero_title); ?>
            </h1>
            <p class="hero-description">
                <?php echo esc_html($hero_description); ?>
            </p>
            <div class="search-container">
                <div class="search-icon" aria-hidden="true">🔍</div>
                <input type="text" 
                       class="search-box" 
                       placeholder="<?php echo esc_attr($search_placeholder); ?>"
                       aria-label="<?php esc_attr_e('Поиск по сайту', 'yandexpro'); ?>"
                       data-search-input />
            </div>
        </div>
    </div>
</section>