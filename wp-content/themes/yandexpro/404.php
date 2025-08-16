<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <div class="content-wrapper">
            
            <section class="error-404 not-found">
                
                <!-- 404 Header -->
                <header class="page-header error-header">
                    <div class="error-number">404</div>
                    <h1 class="page-title"><?php _e('Страница не найдена', 'yandexpro'); ?></h1>
                    <p class="error-description">
                        <?php _e('К сожалению, запрашиваемая вами страница не существует. Возможно, она была удалена, перемещена или вы ввели неправильный адрес.', 'yandexpro'); ?>
                    </p>
                </header>

                <!-- 404 Content -->
                <div class="page-content error-content">
                    
                    <!-- Search Form -->
                    <div class="error-search">
                        <h2><?php _e('Попробуйте найти то, что вам нужно:', 'yandexpro'); ?></h2>
                        <?php get_search_form(); ?>
                    </div>

                    <!-- Helpful Links -->
                    <div class="helpful-links">
                        <h3><?php _e('Полезные ссылки:', 'yandexpro'); ?></h3>
                        <div class="links-grid">
                            
                            <!-- Home Link -->
                            <div class="helpful-link">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="link-card">
                                    <div class="link-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                                        </svg>
                                    </div>
                                    <div class="link-content">
                                        <h4><?php _e('Главная страница', 'yandexpro'); ?></h4>
                                        <p><?php _e('Вернуться на главную страницу сайта', 'yandexpro'); ?></p>
                                    </div>
                                </a>
                            </div>

                            <!-- Blog Link -->
                            <?php if (get_option('page_for_posts')) : ?>
                                <div class="helpful-link">
                                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="link-card">
                                        <div class="link-icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                            </svg>
                                        </div>
                                        <div class="link-content">
                                            <h4><?php _e('Блог', 'yandexpro'); ?></h4>
                                            <p><?php _e('Читать последние статьи', 'yandexpro'); ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- About Page -->
                            <?php
                            $about_page = get_page_by_path('about');
                            if (!$about_page) {
                                $about_page = get_page_by_path('o-nas');
                            }
                            if ($about_page) :
                            ?>
                                <div class="helpful-link">
                                    <a href="<?php echo esc_url(get_permalink($about_page->ID)); ?>" class="link-card">
                                        <div class="link-icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                            </svg>
                                        </div>
                                        <div class="link-content">
                                            <h4><?php _e('О нас', 'yandexpro'); ?></h4>
                                            <p><?php _e('Узнать больше о нашем проекте', 'yandexpro'); ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <!-- Contact Page -->
                            <?php
                            $contact_page = get_page_by_path('contact');
                            if (!$contact_page) {
                                $contact_page = get_page_by_path('kontakty');
                            }
                            if ($contact_page) :
                            ?>
                                <div class="helpful-link">
                                    <a href="<?php echo esc_url(get_permalink($contact_page->ID)); ?>" class="link-card">
                                        <div class="link-icon">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                            </svg>
                                        </div>
                                        <div class="link-content">
                                            <h4><?php _e('Контакты', 'yandexpro'); ?></h4>
                                            <p><?php _e('Связаться с нами', 'yandexpro'); ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>

                    <!-- Popular Posts -->
                    <?php
                    $popular_posts = new WP_Query(array(
                        'posts_per_page' => 6,
                        'post_status' => 'publish',
                        'meta_key' => 'post_views_count',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'ignore_sticky_posts' => true
                    ));
                    
                    // Fallback to recent posts if no view count
                    if (!$popular_posts->have_posts()) {
                        $popular_posts = new WP_Query(array(
                            'posts_per_page' => 6,
                            'post_status' => 'publish',
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'ignore_sticky_posts' => true
                        ));
                    }
                    
                    if ($popular_posts->have_posts()) :
                    ?>
                        <div class="popular-posts">
                            <h3><?php _e('Популярные статьи:', 'yandexpro'); ?></h3>
                            <div class="posts-grid">
                                <?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
                                    <article class="popular-post-card">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="post-thumbnail">
                                                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                                    <?php 
                                                    the_post_thumbnail('yandexpro-small', array(
                                                        'alt' => the_title_attribute(array('echo' => false)),
                                                        'loading' => 'lazy',
                                                        'decoding' => 'async'
                                                    )); 
                                                    ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="post-content">
                                            <h4 class="post-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                            <div class="post-meta">
                                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                    <?php echo esc_html(get_the_date()); ?>
                                                </time>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>

                    <!-- Categories -->
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'count',
                        'order' => 'DESC',
                        'number' => 8,
                        'hide_empty' => true
                    ));
                    
                    if ($categories) :
                    ?>
                        <div class="popular-categories">
                            <h3><?php _e('Рубрики:', 'yandexpro'); ?></h3>
                            <div class="categories-grid">
                                <?php foreach ($categories as $category) : ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-card">
                                        <h4 class="category-name"><?php echo esc_html($category->name); ?></h4>
                                        <p class="category-description">
                                            <?php 
                                            echo $category->description ? 
                                                wp_trim_words($category->description, 10, '...') : 
                                                sprintf(_n('%s запись', '%s записей', $category->count, 'yandexpro'), $category->count);
                                            ?>
                                        </p>
                                        <span class="category-count"><?php echo $category->count; ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Help Section -->
                    <div class="error-help">
                        <h3><?php _e('Нужна помощь?', 'yandexpro'); ?></h3>
                        <div class="help-content">
                            <div class="help-item">
                                <h4><?php _e('Проверьте URL', 'yandexpro'); ?></h4>
                                <p><?php _e('Убедитесь, что адрес введен правильно. Возможно, есть опечатка в URL.', 'yandexpro'); ?></p>
                            </div>
                            
                            <div class="help-item">
                                <h4><?php _e('Используйте поиск', 'yandexpro'); ?></h4>
                                <p><?php _e('Воспользуйтесь формой поиска выше, чтобы найти нужную информацию.', 'yandexpro'); ?></p>
                            </div>
                            
                            <div class="help-item">
                                <h4><?php _e('Вернитесь назад', 'yandexpro'); ?></h4>
                                <p>
                                    <?php _e('Вернитесь на предыдущую страницу, используя кнопку "Назад" в браузере, или ', 'yandexpro'); ?>
                                    <button onclick="history.back()" class="back-button">
                                        <?php _e('нажмите здесь', 'yandexpro'); ?>
                                    </button>
                                </p>
                            </div>
                            
                            <?php if ($contact_page) : ?>
                                <div class="help-item">
                                    <h4><?php _e('Свяжитесь с нами', 'yandexpro'); ?></h4>
                                    <p>
                                        <?php _e('Если проблема не решается, ', 'yandexpro'); ?>
                                        <a href="<?php echo esc_url(get_permalink($contact_page->ID)); ?>">
                                            <?php _e('свяжитесь с нами', 'yandexpro'); ?>
                                        </a>
                                        <?php _e(' и мы поможем найти нужную информацию.', 'yandexpro'); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
                
            </section>

        </div>
    </div>
</main>

<?php
get_footer();
?>