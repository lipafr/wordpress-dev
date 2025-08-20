<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Header -->
<header class="site-header">
    <div class="container">
        <nav class="nav" role="navigation" aria-label="<?php esc_attr_e('Основная навигация', 'yandexpro'); ?>">
            <?php 
            // Компонент брендинга/логотипа
            if (file_exists(get_template_directory() . '/template-parts/header/site-branding.php')) {
                get_template_part('template-parts/header/site-branding'); 
            } else {
                echo '<div class="site-branding"><a href="' . esc_url(home_url('/')) . '" class="site-logo">YandexPRO</a></div>';
            }
            
            // Компонент основной навигации
            if (file_exists(get_template_directory() . '/template-parts/header/navigation.php')) {
                get_template_part('template-parts/header/navigation'); 
            } else {
                echo '<ul class="nav-menu">
                    <li><a href="#services" class="nav-link">Услуги</a></li>
                    <li><a href="#cases" class="nav-link">Кейсы</a></li>
                    <li><a href="#blog" class="nav-link active">Блог</a></li>
                    <li><a href="#about" class="nav-link">Обо мне</a></li>
                    <li><a href="#contact" class="nav-link">Контакты</a></li>
                </ul>';
            }
            
            // Компонент мобильного меню
            if (file_exists(get_template_directory() . '/template-parts/header/mobile-menu.php')) {
                get_template_part('template-parts/header/mobile-menu'); 
            } else {
                echo '<button class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="mobile-menu">
                    <ul class="mobile-menu-list">
                        <li><a href="#services">Услуги</a></li>
                        <li><a href="#cases">Кейсы</a></li>
                        <li><a href="#blog">Блог</a></li>
                        <li><a href="#about">Обо мне</a></li>
                        <li><a href="#contact">Контакты</a></li>
                    </ul>
                </div>';
            }
            ?>
        </nav>
    </div>
</header>

<?php 
// Hero секция (только на главной странице)
if (is_home() || is_front_page()) {
    if (file_exists(get_template_directory() . '/template-parts/header/hero.php')) {
        get_template_part('template-parts/header/hero');
    } else {
        echo '<section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>Блог о <span class="gradient-text">Яндекс Директ</span><br>и интернет-маркетинге</h1>
                    <p>Практические кейсы, инсайты и тренды из мира контекстной рекламы.</p>
                    <div class="search-container">
                        <div class="search-icon">🔍</div>
                        <input type="text" class="search-box" placeholder="Поиск по статьям...">
                    </div>
                </div>
            </div>
        </section>';
    }
}
?>

<main id="main" class="site-main" role="main">