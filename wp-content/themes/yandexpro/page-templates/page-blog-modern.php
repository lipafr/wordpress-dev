<?php
/**
 * Template Name: Modern Blog Page
 * 
 * Красивая страница блога по дизайну из HTML макета
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<style>
/* Дополнительные стили для современного дизайна блога */
.blog-modern {
    font-family: 'Space Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Подключение Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800&display=swap');

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
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    background: rgba(255, 255, 255, 0.95);
}

.hero-search-input::placeholder {
    color: #9ca3af;
}

.categories-section {
    padding: 60px 0;
    background: #ffffff;
}

.categories-list {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    margin: 40px 0;
}

.category-tag {
    padding: 12px 24px;
    background: #f8fafc;
    border: 2px solid transparent;
    border-radius: 50px;
    text-decoration: none;
    color: #374151;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.category-tag:hover,
.category-tag.active {
    background: #7c3aed;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
}

.articles-section {
    padding: 80px 0;
    background: #fefefe;
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
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    margin-bottom: 60px;
}

.article-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s ease;
    text-decoration: none;
    color: inherit;
    display: block;
}

.article-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    text-decoration: none;
    color: inherit;
}

.article-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.article-card:hover .article-image {
    transform: scale(1.05);
}

.article-content {
    padding: 30px;
}

.article-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px;
    font-size: 14px;
    color: #6b7280;
}

.article-date {
    display: flex;
    align-items: center;
    gap: 6px;
}

.article-reading-time {
    display: flex;
    align-items: center;
    gap: 6px;
}

.article-title {
    font-size: 20px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 12px;
    line-height: 1.4;
}

.article-excerpt {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 20px;
}

.article-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.article-author {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    color: #374151;
}

.author-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.read-more-btn {
    background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%);
    color: #ffffff;
    padding: 8px 16px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.read-more-btn:hover {
    transform: translateX(4px);
    text-decoration: none;
    color: #ffffff;
}

.newsletter-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #111827 0%, #374151 100%);
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
    color: #d1d5db;
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
}

.newsletter-btn {
    background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%);
    color: #ffffff;
    padding: 16px 32px;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.newsletter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(124, 58, 237, 0.4);
}

/* Адаптивность */
@media (max-width: 768px) {
    .blog-hero h1 {
        font-size: 32px;
    }
    
    .blog-hero p {
        font-size: 16px;
    }
    
    .articles-grid {
        grid-template-columns: 1fr;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .categories-list {
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 10px;
    }
    
    .category-tag {
        flex-shrink: 0;
    }
}

/* Анимации */
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
    <section class="blog-hero">
        <div class="container">
            <div class="blog-hero-content">
                <h1>
                    Блог о <span class="gradient-text">Яндекс Директ</span><br>
                    и интернет-маркетинге
                </h1>
                <p>
                    Практические кейсы, инсайты и тренды из мира контекстной рекламы. 
                    Только проверенная информация от практикующего специалиста.
                </p>
                
                <!-- Поиск в Hero -->
                <div class="hero-search">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="hero-search-form">
                        <div class="search-input-wrapper">
                            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 21L16.514 16.506M19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <input type="search" name="s" placeholder="Поиск по статьям..." value="<?php echo get_search_query(); ?>" class="hero-search-input" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <h2 class="section-title">Выберите интересную тему</h2>
            
            <div class="categories-list">
                <a href="<?php echo esc_url(home_url('/blog')); ?>" class="category-tag active">
                    Все статьи
                </a>
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order'   => 'DESC',
                    'number'  => 6,
                    'hide_empty' => true,
                ));
                
                foreach ($categories as $category) :
                ?>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-tag">
                        <?php echo esc_html($category->name); ?>
                        <span style="margin-left: 8px; opacity: 0.7;">(<?php echo $category->count; ?>)</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Articles Section -->
    <section class="articles-section">
        <div class="container">
            <h2 class="section-title">Последние статьи</h2>
            <p class="section-subtitle">
                Свежие материалы о контекстной рекламе, аналитике и оптимизации кампаний
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
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('yandexpro-medium', array(
                                    'class' => 'article-image',
                                    'alt' => the_title_attribute(array('echo' => false)),
                                    'loading' => 'lazy',
                                )); ?>
                            <?php else : ?>
                                <div class="article-image" style="background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                    <?php echo esc_html(substr(get_the_title(), 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="article-content">
                                <div class="article-meta">
                                    <span class="article-date">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5C3.89 3 3 3.9 3 5v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                                        </svg>
                                        <?php echo get_the_date('j M Y'); ?>
                                    </span>
                                    
                                    <?php if (function_exists('yandexpro_reading_time')) : ?>
                                        <span class="article-reading-time">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                            <?php echo yandexpro_reading_time(); ?> мин
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="article-title"><?php the_title(); ?></h3>
                                
                                <div class="article-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                                
                                <div class="article-footer">
                                    <div class="article-author">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 32, '', '', array('class' => 'author-avatar')); ?>
                                        <span><?php the_author(); ?></span>
                                    </div>
                                    
                                    <span class="read-more-btn">
                                        Читать →
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            
            <!-- Load More Button -->
            <div style="text-align: center; margin-top: 40px;">
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="read-more-btn" style="padding: 16px 32px; font-size: 16px;">
                    Показать все статьи
                </a>
            </div>
        </div>
    </section>
    
    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2>Подпишитесь на рассылку</h2>
                <p>Получайте новые статьи и эксклюзивные материалы первыми</p>
                
                <form class="newsletter-form" action="#" method="post">
                    <input type="email" class="newsletter-input" placeholder="Введите ваш email" required>
                    <button type="submit" class="newsletter-btn">Подписаться</button>
                </form>
                
                <p style="font-size: 14px; color: #9ca3af; margin-top: 20px;">
                    Никакого спама. Только полезные материалы раз в неделю.
                </p>
            </div>
        </div>
    </section>
    
</main>

<script>
// Простая анимация при скролле
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-on-scroll');
            }
        });
    }, observerOptions);
    
    // Анимируем карточки статей
    document.querySelectorAll('.article-card').forEach(card => {
        observer.observe(card);
    });
});
</script>

<?php
get_footer();