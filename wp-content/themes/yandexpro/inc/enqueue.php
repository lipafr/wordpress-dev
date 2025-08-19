<?php
/**
 * Enqueue scripts and styles - COMPLETE FINAL VERSION
 *
 * @package YandexPro
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue theme assets
 */
function yandexpro_enqueue_assets() {
    
    // Google Fonts
    wp_enqueue_style(
        'yandexpro-fonts',
        'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800&display=swap',
        [],
        null
    );
    
    // ПОЛНЫЕ СТИЛИ ДЛЯ ЗАВЕРШЕНИЯ ДИЗАЙНА
    wp_add_inline_style('yandexpro-fonts', '
        /* ПОЛНАЯ ДИЗАЙН-СИСТЕМА */
        :root {
            --yandexpro-primary: #7c3aed;
            --yandexpro-accent: #ec4899;
            --yandexpro-white: #ffffff;
            --yandexpro-black: #111827;
            --yandexpro-light: #f8fafc;
            --yandexpro-secondary: #64748b;
            --yandexpro-container-width: 1200px;
            --yandexpro-border-radius-large: 16px;
            --yandexpro-shadow-light: 0 2px 8px rgba(0, 0, 0, 0.06);
            --yandexpro-shadow-heavy: 0 8px 24px rgba(0, 0, 0, 0.12);
        }
        
        /* БАЗОВЫЕ СТИЛИ */
        * {
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }
        
        body {
            font-family: "Space Grotesk", -apple-system, BlinkMacSystemFont, sans-serif !important;
            line-height: 1.6 !important;
            color: var(--yandexpro-black) !important;
            background: var(--yandexpro-white) !important;
        }
        
        .container {
            max-width: var(--yandexpro-container-width) !important;
            margin: 0 auto !important;
            padding: 0 24px !important;
        }
        
        /* HEADER СТИЛИ */
        .site-header {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(12px) !important;
            border-bottom: 1px solid rgba(17, 24, 39, 0.08) !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
        }
        
        .nav {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 20px 0 !important;
        }
        
        .site-logo {
            font-size: 24px !important;
            font-weight: 700 !important;
            color: var(--yandexpro-black) !important;
            text-decoration: none !important;
        }
        
        /* HERO СЕКЦИЯ */
        .hero {
            padding: 120px 0 80px !important;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .hero-content {
            text-align: center !important;
            max-width: 800px !important;
            margin: 0 auto !important;
            position: relative !important;
        }
        
        .hero h1 {
            font-size: clamp(42px, 6vw, 64px) !important;
            font-weight: 800 !important;
            line-height: 1.1 !important;
            margin-bottom: 24px !important;
            color: var(--yandexpro-black) !important;
            letter-spacing: -0.02em !important;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #7c3aed, #ec4899) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }
        
        .hero p {
            font-size: 22px !important;
            color: var(--yandexpro-secondary) !important;
            margin-bottom: 40px !important;
            line-height: 1.5 !important;
        }
        
        /* ПОИСК */
        .search-container {
            max-width: 500px !important;
            margin: 0 auto !important;
            position: relative !important;
        }
        
        .search-box {
            width: 100% !important;
            padding: 18px 24px 18px 56px !important;
            font-size: 16px !important;
            border: 2px solid #e2e8f0 !important;
            border-radius: 50px !important;
            background: white !important;
            outline: none !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
        }
        
        .search-icon {
            position: absolute !important;
            left: 20px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 20px !important;
            color: #9ca3af !important;
        }
        
        /* СЕКЦИИ */
        .featured-articles,
        .categories,
        .latest {
            padding: 80px 0 20px !important;
            background: var(--yandexpro-light) !important;
        }
        
        .section-title,
        .categories-title {
            font-size: 32px !important;
            font-weight: 700 !important;
            color: var(--yandexpro-black) !important;
            margin-bottom: 40px !important;
            letter-spacing: -0.02em !important;
        }
        
        /* FEATURED ARTICLES */
        .featured-grid {
            display: grid !important;
            grid-template-columns: 2fr 1fr !important;
            gap: 40px !important;
            align-items: start !important;
        }
        
        .featured-main {
            background: white !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            box-shadow: var(--yandexpro-shadow-light) !important;
            border: 1px solid #e2e8f0 !important;
            display: flex !important;
            height: 320px !important;
        }
        
        .featured-content {
            padding: 24px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-start !important;
            flex: 1 !important;
        }
        
        .featured-title {
            font-size: 22px !important;
            font-weight: 700 !important;
            color: var(--yandexpro-black) !important;
            margin-bottom: 12px !important;
            line-height: 1.3 !important;
        }
        
        .featured-description {
            font-size: 14px !important;
            color: var(--yandexpro-secondary) !important;
            line-height: 1.5 !important;
            flex: 1 !important;
        }
        
        .featured-sidebar {
            display: flex !important;
            flex-direction: column !important;
            gap: 20px !important;
            height: 320px !important;
        }
        
        .featured-small {
            background: white !important;
            border-radius: 12px !important;
            padding: 16px !important;
            box-shadow: var(--yandexpro-shadow-light) !important;
            border: 1px solid #e2e8f0 !important;
            display: flex !important;
            gap: 12px !important;
            align-items: flex-start !important;
            flex: 1 !important;
        }
        
        /* КАТЕГОРИИ */
        .categories-list {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 16px !important;
            justify-content: center !important;
            margin-top: 40px !important;
        }
        
        .category-tag {
            display: inline-block !important;
            padding: 12px 24px !important;
            background: white !important;
            color: #475569 !important;
            text-decoration: none !important;
            border-radius: 50px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            border: 2px solid transparent !important;
        }
        
        .category-tag:hover,
        .category-tag.active {
            background: var(--yandexpro-primary) !important;
            color: white !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3) !important;
        }
        
        /* СЕТКА СТАТЕЙ */
        .articles-grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 24px !important;
            margin-bottom: 40px !important;
        }
        
        .articles-row {
            display: grid !important;
            gap: 24px !important;
        }
        
        .articles-row.row-3 {
            grid-template-columns: repeat(3, 1fr) !important;
        }
        
        .articles-row.row-2 {
            grid-template-columns: 2fr 1fr !important;
        }
        
        .article-card {
            background: white !important;
            border-radius: var(--yandexpro-border-radius-large) !important;
            overflow: hidden !important;
            box-shadow: var(--yandexpro-shadow-light) !important;
            transition: all 0.3s ease !important;
            border: 1px solid #e2e8f0 !important;
            cursor: pointer !important;
            display: flex !important;
            flex-direction: column !important;
            height: 480px !important;
        }
        
        .article-card:hover {
            transform: translateY(-2px) !important;
            box-shadow: var(--yandexpro-shadow-heavy) !important;
        }
        
        .article-image {
            height: 240px !important;
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
            position: relative !important;
            overflow: hidden !important;
            flex-shrink: 0 !important;
        }
        
        .article-category {
            position: absolute !important;
            top: 12px !important;
            left: 12px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            color: var(--yandexpro-primary) !important;
            padding: 4px 10px !important;
            border-radius: 12px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }
        
        .article-content {
            padding: 20px !important;
            display: flex !important;
            flex-direction: column !important;
            height: 240px !important;
        }
        
        .article-meta {
            display: flex !important;
            gap: 12px !important;
            margin-bottom: 12px !important;
            font-size: 12px !important;
            color: #9ca3af !important;
        }
        
        .article-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: var(--yandexpro-black) !important;
            margin-bottom: 12px !important;
            line-height: 1.4 !important;
        }
        
        .article-excerpt {
            color: var(--yandexpro-secondary) !important;
            line-height: 1.5 !important;
            font-size: 14px !important;
            flex: 1 !important;
        }
        
        /* NEWSLETTER */
        .newsletter {
            padding: 80px 0 !important;
            background: linear-gradient(135deg, #7c3aed, #ec4899) !important;
            color: white !important;
            text-align: center !important;
        }
        
        .newsletter h2 {
            font-size: 36px !important;
            font-weight: 800 !important;
            margin-bottom: 16px !important;
        }
        
        .newsletter p {
            font-size: 18px !important;
            margin-bottom: 40px !important;
            opacity: 0.9 !important;
        }
        
        .newsletter-form {
            max-width: 500px !important;
            margin: 0 auto !important;
            display: flex !important;
            gap: 16px !important;
        }
        
        .newsletter-input {
            flex: 1 !important;
            padding: 16px 20px !important;
            border: none !important;
            border-radius: 50px !important;
            font-size: 16px !important;
            outline: none !important;
        }
        
        .newsletter-btn {
            background: white !important;
            color: var(--yandexpro-primary) !important;
            padding: 16px 32px !important;
            border: none !important;
            border-radius: 50px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        .newsletter-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2) !important;
        }
        
        /* МОБИЛЬНАЯ АДАПТАЦИЯ */
        @media (max-width: 1024px) and (min-width: 769px) {
            .featured-grid {
                grid-template-columns: 1fr !important;
                gap: 24px !important;
            }
            
            .featured-main {
                flex-direction: column !important;
                height: auto !important;
            }
            
            .featured-sidebar {
                gap: 16px !important;
                height: auto !important;
            }
            
            .categories-list {
                justify-content: flex-start !important;
            }
        }
    ');
    
    // Main theme script - если есть
    if (file_exists(get_template_directory() . '/assets/js/script.js')) {
        wp_enqueue_script(
            'yandexpro-script',
            get_template_directory_uri() . '/assets/js/script.js',
            [],
            THEME_VERSION,
            true
        );
        
        // Localize script
        wp_localize_script('yandexpro-script', 'yandexpro_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('yandexpro_nonce')
        ]);
    }
}
add_action('wp_enqueue_scripts', 'yandexpro_enqueue_assets');

// Добавляем favicon чтобы убрать ошибку 404
function yandexpro_add_favicon() {
    echo '<link rel="icon" href="data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><text y=\'0.9em\' font-size=\'90\'>📊</text></svg>">';
}
add_action('wp_head', 'yandexpro_add_favicon');

// ОТЛАДОЧНАЯ ИНФОРМАЦИЯ
function yandexpro_debug_styles() {
    if (current_user_can('administrator')) {
        echo '<script>console.log("YandexPro: All styles loaded successfully!");</script>';
    }
}
add_action('wp_footer', 'yandexpro_debug_styles');-columns: 1fr !important;
                gap: 32px !important;
            }
            
            .featured-main {
                flex-direction: column !important;
                height: auto !important;
            }
            
            .articles-row.row-3 {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px !important;
            }
            
            .articles-row.row-3,
            .articles-row.row-2 {
                grid-template-columns: 1fr !important;
            }
            
            .article-card {
                height: auto !important;
            }
            
            .newsletter-form {
                flex-direction: column !important;
            }
            
            .featured-grid {
                grid-template