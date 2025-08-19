<?php
/**
 * The header for our theme
 * ПОЛНАЯ РАБОЧАЯ ВЕРСИЯ
 *
 * @package YandexPro
 */
?>
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
    <nav class="container">
        <div class="nav">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                YandexPRO
            </a>
            
            <ul class="nav-menu">
                <li><a href="#services">Услуги</a></li>
                <li><a href="#cases">Кейсы</a></li>
                <li><a href="#blog" class="active">Блог</a></li>
                <li><a href="#about">Обо мне</a></li>
                <li><a href="#contact">Контакты</a></li>
            </ul>
            
            <button class="mobile-menu-toggle" aria-label="Открыть меню">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
</header>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>
                Блог о <span class="gradient-text">Яндекс Директ</span><br>
                и интернет-маркетинге
            </h1>
            <p>
                Практические кейсы, инсайты и тренды из мира контекстной рекламы. 
                Только проверенная информация от практикующего специалиста.
            </p>
            <div class="search-container">
                <div class="search-icon">🔍</div>
                <input type="text" class="search-box" placeholder="Поиск по статьям..." />
            </div>
        </div>
    </div>
</section>

<main id="main" class="site-main">