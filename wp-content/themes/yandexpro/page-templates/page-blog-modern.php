.hero-search-input:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    background: rgba(255, 255, 255, 0.95);
}

.hero-search-input::placeholder {
    color: #9ca3af;
}

.featured-article-section {
    background: linear-gradient(135deg, #2d1b69 0%, #8b5cf6 50%, #ec4899 100%);
    padding: 80px 0;
    color: white;
    position: relative;
    overflow: hidden;
}

.featured-article {
    display: flex;
    align-items: center;
    gap: 80px;
    min-height: 400px;
}

.featured-content {
    flex: 1;
    max-width: 60%;
}

.featured-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.8);
}

.featured-category {
    background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.featured-title {
    font-size: 42px;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 24px;
    color: white;
    letter-spacing: -0.02em;
}

.featured-excerpt {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 32px;
    line-height: 1.6;
    max-width: 500px;
}

.featured-btn {
    background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%);
    color: white;
    padding: 16px 32px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    display: inline-block;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.featured-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
    color: white;
    text-decoration: none;
}

.featured-visual {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.featured-image {
    width: 350px;
    height: 250px;
    background: linear-gradient(45deg, #ec4899, #8b5cf6, #3b82f6);
    border-radius: 20px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    opacity: 0.9;
}

.articles-section {
    padding: 80px 0;
    background: #ffffff;
}

.section-title {
    text-align: center;
    font-size: 42px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 16px;
    letter-spacing: -0.02em;
}

.section-subtitle {
    text-align: center;
    font-size: 18px;
    color: #6b7280;
    margin-bottom: 60px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 32px;
    margin-bottom: 60px;
}

.article-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    display: block;
    border: 1px solid #f1f5f9;
    position: relative;
}

.article-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    text-decoration: none;
    color: inherit;
}

.article-image-container {
    position: relative;
    width: 100%;
    height: 180px;
    overflow: hidden;
}

.article-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    font-weight: 600;
}

.article-category {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    z-index: 2;
}

.article-content {
    padding: 24px;
}

.article-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 13px;
    color: #6b7280;
}

.article-date {
    display: flex;
    align-items: center;
    gap: 4px;
}

.article-reading-time {
    display: flex;
    align-items: center;
    gap: 4px;
}

.article-title {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 8px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.article-excerpt {
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 16px;
    font-size: 14px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.article-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.read-more-link {
    color: #667eea;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: color 0.3s ease;
}

.read-more-link:hover {
    color: #764ba2;
    text-decoration: none;
}

.article-views {
    font-size: 13px;
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 4px;
}

.load-more-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 14px 32px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    display: inline-block;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.load-more-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.newsletter-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
    color: #ffffff;
    text-align: center;
}

.newsletter-content {
    max-width: 600px;
    margin: 0 auto;
}

.newsletter-section h2 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 16px;
    color: #ffffff;
}

.newsletter-section p {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 40px;
}

.newsletter-form {
    display: flex;
    gap: 16px;
    max-width: 400px;
    margin: 0 auto;
}

.newsletter-input {
    flex: 1;
    padding: 16px 20px;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    outline: none;
    background: rgba(255, 255, 255, 0.95);
    color: #374151;
}

.newsletter-input::placeholder {
    color: #9ca3af;
}

.newsletter-btn {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    padding: 16px 32px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    backdrop-filter: blur(10px);
}

.newsletter-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
}

@media (max-width: 968px) {
    .featured-article {
        flex-direction: column;
        text-align: center;
        gap: 40px;
    }
    
    .featured-content {
        max-width: 100%;
    }
    
    .featured-title {
        font-size: 32px;
    }
    
    .featured-visual {
        order: -1;
    }
    
    .categories-nav {
        gap: 16px;
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 10px;
    }
    
    .category-link {
        flex-shrink: 0;
    }
}

@media (max-width: 768px) {
    .blog-hero {
        padding: 80px 0 60px;
    }
    
    .blog-hero h1 {
        font-size: 32px;
    }
    
    .blog-hero p {
        font-size: 16px;
    }
    
    .featured-article-section {
        padding: 60px 0;
    }
    
    .featured-title {
        font-size: 28px;
    }
    
    .featured-excerpt {
        font-size: 16px;
    }
    
    .featured-image {
        width: 280px;
        height: 180px;
    }
    
    .articles-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .top-categories {
        position: relative;
        top: 0;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-on-scroll {
    opacity: 0;
    animation: fadeInUp 0.6s ease forwards;
}
</style>

<main id="primary" class="site-main blog-modern" role="main">
    
    <!-- Hero Section -->
    <?php 
    // Пытаемся подключить модульный компонент, если нет - используем встроенный
    if (file_exists(get_template_directory() . '/template-parts/hero/blog-hero.php')) {
        get_template_part('template-parts/hero/blog', 'hero');
    } else {
        // Встроенный Hero
        ?>
        <section class="blog-hero">
            <div class="container">
                <div class="blog-hero-content">
                    <h1>
                        <?php esc_html_e('Блог о ', 'yandexpro'); ?><span class="gradient-text"><?php esc_html_e('Яндекс Директ', 'yandexpro'); ?></span><br>
                        <?php esc_html_e('и интернет-маркетинге', 'yandexpro'); ?>
                    </h1>
                    <p>
                        <?php esc_html_e('Практические кейсы, инсайты и тренды из мира контекстной рекламы. Только проверенная информация от практикующего специалиста.', 'yandexpro'); ?>
                    </p>
                    
                    <div class="hero-search">
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="hero-search-form">
                            <div class="search-input-wrapper">
                                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21L16.514 16.506M19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <input type="search" name="s" placeholder="<?php esc_attr_e('Поиск по статьям...', 'yandexpro'); ?>" value="<?php echo get_search_query(); ?>" class="hero-search-input" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
    ?>
    
    <!-- Categories Navigation -->
    <?php 
    // Пытаемся подключить модульный компонент, если нет - используем встроенный
    if (file_exists(get_template_directory() . '/template-parts/navigation/categories-nav.php')) {
        get_template_part('template-parts/navigation/categories', 'nav');
    } else {
        // Встроенная навигация по категориям
        ?>
        <section class="top-categories">
            <div class="container">
                <nav class="categories-nav" role="navigation" aria-label="<?php esc_attr_e('Categories Navigation', 'yandexpro'); ?>">
                    
                    <!-- Кнопка "Все статьи" -->
                    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="category-link <?php echo (is_home() || is_front_page()) ? 'active' : ''; ?>">
                        <?php esc_html_e('Все статьи', 'yandexpro'); ?>
                    </a>
                    
                    <!-- Видимые категории -->
                    <?php
                    $featured_categories = yandexpro_get_featured_categories();
                    if (!empty($featured_categories)) :
                        foreach ($featured_categories as $cat_id) :
                            $category = get_category($cat_id);
                            if ($category && !is_wp_error($category)) :
                                $is_active = yandexpro_is_category_active($cat_id) ? 'active' : '';
                    ?>
                                <a href="<?php echo esc_url(get_category_link($cat_id)); ?>" 
                                   class="category-link <?php echo $is_active; ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                    <?php 
                            endif;
                        endforeach;
                    endif;
                    
                    // Проверяем есть ли скрытые категории
                    $hidden_categories = yandexpro_get_hidden_categories();
                    if (!empty($hidden_categories)) :
                    ?>
                    
                    <!-- Кнопка "Смотреть всё" -->
                    <button class="categories-toggle-btn" onclick="toggleCategories(this)" aria-expanded="false">
                        <span class="btn-text"><?php esc_html_e('Смотреть всё', 'yandexpro'); ?></span>
                        <span class="btn-icon">▼</span>
                    </button>
                    
                    <!-- Скрытые категории -->
                    <div class="categories-hidden" id="hiddenCategories">
                        <?php
                        foreach ($hidden_categories as $cat_id) :
                            $category = get_category($cat_id);
                            if ($category && !is_wp_error($category)) :
                                $is_active = yandexpro_is_category_active($cat_id) ? 'active' : '';
                        ?>
                                <a href="<?php echo esc_url(get_category_link($cat_id)); ?>" 
                                   class="category-link <?php echo $is_active; ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                        <?php 
                            endif;
                        endforeach;
                        ?>
                    </div>
                    
                    <?php endif; ?>
                    
                </nav>
            </div>
        </section>
        <?php
    }
    ?>
    
    <!-- Featured Article Section -->
    <section class="featured-article-section">
        <div class="container">
            <div class="featured-article">
                <div class="featured-content">
                    <div class="featured-meta">
                        <span class="featured-category"><?php esc_html_e('БЕЗ РУБРИКИ', 'yandexpro'); ?></span>
                        <time datetime="2025-08-17"><?php esc_html_e('17 августа 2025', 'yandexpro'); ?></time>
                        <span class="article-reading-time">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" fill="currentColor"/>
                            </svg>
                            <?php esc_html_e('8 мин чтения', 'yandexpro'); ?>
                        </span>
                    </div>
                    
                    <h2 class="featured-title">
                        <?php esc_html_e('Как я увеличил конверсию интернет-магазина на 340% за 3 месяца', 'yandexpro'); ?>
                    </h2>
                    
                    <p class="featured-excerpt">
                        <?php esc_html_e('Подробный разбор кейса по настройке Яндекс Директ для крупного e-commerce проекта. Все стратегии, ошибки и инсайты, которые привели к взрывному росту продаж.', 'yandexpro'); ?>
                    </p>
                    
                    <a href="#" class="featured-btn">
                        <?php esc_html_e('Читать кейс →', 'yandexpro'); ?>
                    </a>
                </div>
                
                <div class="featured-visual">
                    <div class="featured-image"></div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Articles Section -->
    <section class="articles-section">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('Последние статьи', 'yandexpro'); ?></h2>
            <p class="section-subtitle">
                <?php esc_html_e('Свежие материалы о контекстной рекламе, аналитике и оптимизации кампаний', 'yandexpro'); ?>
            </p>
            
            <div class="articles-grid">
                <?php
                $blog_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 9,
                    'post_status' => 'publish',
                ));
                
                if ($blog_posts->have_posts()) :
                    while ($blog_posts->have_posts()) : $blog_posts->the_post();
                ?>
                    <article class="article-card">
                        <a href="<?php the_permalink(); ?>">
                            <div class="article-image-container">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('yandexpro-medium', array(
                                        'class' => 'article-image',
                                        'alt' => the_title_attribute(array('echo' => false)),
                                        'loading' => 'lazy',
                                        'decoding' => 'async',
                                    )); ?>
                                <?php else : ?>
                                    <div class="article-image">
                                        <?php echo esc_html(mb_substr(get_the_title(), 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Категория над изображением -->
                                <?php 
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                ?>
                                    <span class="article-category">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="article-content">
                                <div class="article-meta">
                                    <span class="article-date">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5C3.89 3 3 3.9 3 5v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                        </svg>
                                        <?php echo get_the_date('j M Y'); ?>
                                    </span>
                                    
                                    <span class="article-reading-time">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                        </svg>
                                        <?php 
                                        if (function_exists('yandexpro_reading_time')) {
                                            echo yandexpro_reading_time();
                                        } else {
                                            $content = get_the_content();
                                            $word_count = str_word_count(strip_tags($content));
                                            echo ceil($word_count / 200);
                                        }
                                        ?> мин
                                    </span>
                                </div>
                                
                                <h3 class="article-title">
                                    <?php the_title(); ?>
                                </h3>
                                
                                <div class="article-excerpt">
                                    <?php 
                                    $excerpt = get_the_excerpt();
                                    if (empty($excerpt)) {
                                        $excerpt = wp_trim_words(get_the_content(), 20, '...');
                                    } else {
                                        $excerpt = wp_trim_words($excerpt, 20, '...');
                                    }
                                    echo esc_html($excerpt);
                                    ?>
                                </div>
                                
                                <div class="article-footer">
                                    <span class="read-more-link">
                                        Читать далее
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                                        </svg>
                                    </span>
                                    
                                    <span class="article-views">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                        </svg>
                                        <?php echo rand(150, 999); ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-posts" style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                        <h3><?php esc_html_e('Пока нет опубликованных статей', 'yandexpro'); ?></h3>
                        <p><?php esc_html_e('Скоро здесь появятся интересные материалы!', 'yandexpro'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Load More Button -->
            <div style="text-align: center; margin-top: 50px;">
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="load-more-btn">
                    <?php esc_html_e('Показать все статьи', 'yandexpro'); ?>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2><?php esc_html_e('Подпишитесь на рассылку', 'yandexpro'); ?></h2>
                <p><?php esc_html_e('Получайте новые статьи и эксклюзивные материалы первыми', 'yandexpro'); ?></p>
                
                <form class="newsletter-form" action="#" method="post">
                    <input type="email" class="newsletter-input" placeholder="<?php esc_attr_e('Введите ваш email', 'yandexpro'); ?>" required>
                    <button type="submit" class="newsletter-btn"><?php esc_html_e('Подписаться', 'yandexpro'); ?></button>
                    <?php wp_nonce_field('newsletter_subscription', 'newsletter_nonce'); ?>
                </form>
                
                <p style="font-size: 14px; color: #9ca3af; margin-top: 20px;">
                    <?php esc_html_e('Никакого спама. Только полезные материалы раз в неделю.', 'yandexpro'); ?>
                </p>
            </div>
        </div>
    </section>
    
</main>

<script>
// Встроенный JavaScript (всегда работает)
function toggleCategories(button) {
    const hiddenCategories = document.getElementById('hiddenCategories');
    const btnText = button.querySelector('.btn-text');
    const btnIcon = button.querySelector('.btn-icon');
    const isExpanded = button.getAttribute('aria-expanded') === 'true';
    
    if (isExpanded) {
        hiddenCategories.classList.add('show');
        btnText.textContent = '<?php esc_js(__('Скрыть', 'yandexpro')); ?>';
        btnIcon.textContent = '▲';
        button.classList.add('expanded');
        button.setAttribute('aria-expanded', 'true');
    }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Анимация при скролле
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-on-scroll');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Анимируем карточки статей
    document.querySelectorAll('.article-card').forEach(card => {
        observer.observe(card);
    });
    
    // Активная категория в навигации
    const categoryLinks = document.querySelectorAll('.category-link');
    const currentUrl = window.location.href;
    
    categoryLinks.forEach(link => {
        if (link.href === currentUrl) {
            categoryLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        }
    });
    
    // Обработка формы подписки
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('.newsletter-input').value;
            const nonce = this.querySelector('[name="newsletter_nonce"]').value;
            
            if (!email) {
                alert('<?php esc_js(__('Пожалуйста, введите email адрес', 'yandexpro')); ?>');
                return;
            }
            
            // Показываем загрузку
            const btn = this.querySelector('.newsletter-btn');
            const originalText = btn.textContent;
            btn.textContent = '<?php esc_js(__('Подписываем...', 'yandexpro')); ?>';
            btn.disabled = true;
            
            // Имитация отправки (в реальном проекте здесь AJAX)
            setTimeout(() => {
                alert('<?php esc_js(__('Спасибо за подписку!', 'yandexpro')); ?>');
                this.reset();
                btn.textContent = originalText;
                btn.disabled = false;
            }, 1500);
        });
    }
});

// Debug информация для модульной архитектуры
<?php if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('manage_options')) : ?>
console.log('YandexPro Modular Blog Template Loaded');
console.log('Modules directory exists:', <?php echo is_dir(YANDEXPRO_INC_DIR) ? 'true' : 'false'; ?>);
console.log('Featured categories:', <?php echo json_encode(yandexpro_get_featured_categories()); ?>);
<?php endif; ?>
</script>

<?php
// Подключаем JS модули если функция существует
if (function_exists('yandexpro_enqueue_blog_scripts')) {
    yandexpro_enqueue_blog_scripts();
}

get_footer();ories.classList.remove('show');
        btnText.textContent = '<?php esc_js(__('Смотреть всё', 'yandexpro')); ?>';
        btnIcon.textContent = '▼';
        button.classList.remove('expanded');
        button.setAttribute('aria-expanded', 'false');
    } else {
        hiddenCateg<?php
/**
 * Template Name: Modern Blog Page
 * 
 * Модульная страница блога с fallback'ами
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();

// Пытаемся подключить модульные стили, но если функции нет - ничего страшного
if (function_exists('yandexpro_enqueue_blog_styles')) {
    yandexpro_enqueue_blog_styles();
}
?>

<style>
/* Встроенные стили (всегда работают) */
.blog-modern {
    font-family: 'Space Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;
}

@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800&display=swap');

.top-categories {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(17, 24, 39, 0.08);
    padding: 20px 0;
}

.categories-nav {
    display: flex;
    gap: 40px;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}

.category-link {
    color: #6b7280;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    padding: 12px 0;
    transition: color 0.3s ease;
    position: relative;
    white-space: nowrap;
}

.category-link:hover {
    color: #8b5cf6;
    text-decoration: none;
}

.category-link.active {
    background: #8b5cf6;
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 600;
}

.blog-hero {
    padding: 120px 0 80px;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
    overflow: hidden;
}

.blog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23e2e8f0' fill-opacity='0.4'%3E%3Ccircle cx='9' cy='9' r='2'/%3E%3Ccircle cx='49' cy='49' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.5;
}

.blog-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.blog-hero h1 {
    font-size: clamp(42px, 6vw, 64px);
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
    color: #111827;
    letter-spacing: -0.02em;
}

.gradient-text {
    background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 50%, #06b6d4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.blog-hero p {
    font-size: 22px;
    color: #64748b;
    margin-bottom: 40px;
    line-height: 1.5;
}

.hero-search {
    margin-bottom: 40px;
}

.hero-search-form {
    max-width: 500px;
    margin: 0 auto;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 20px;
    color: #9ca3af;
    z-index: 2;
}

.hero-search-input {
    width: 100%;
    padding: 16px 20px 16px 50px;
    border: 2px solid #e5e7eb;
    border-radius: 50px;
    font-size: 16px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    outline: none;
    transition: all 0.3s ease;
}

.hero-search-input:focus {
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237,