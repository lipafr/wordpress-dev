<?php
/**
 * Site Branding Component
 * Компонент логотипа и брендинга
 * 
 * @package YandexPro
 * @component SiteBranding
 */

// Настройки компонента
$logo_text = get_bloginfo('name') ?: 'YandexPRO';
$logo_url = esc_url(home_url('/'));
?>

<div class="site-branding">
    <a href="<?php echo $logo_url; ?>" class="site-logo" rel="home">
        <?php if (has_custom_logo()): ?>
            <?php the_custom_logo(); ?>
        <?php else: ?>
            <?php echo esc_html($logo_text); ?>
        <?php endif; ?>
    </a>
</div>