<?php
/**
 * The sidebar containing the main widget area
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Don't show sidebar if it's disabled in customizer
if (!get_theme_mod('yandexpro_show_sidebar', true)) {
    return;
}

// Don't show sidebar on full-width pages
$page_template = get_page_template_slug();
if (is_page() && ($page_template === 'page-templates/page-landing.php' || $page_template === 'page-templates/page-contact.php')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar" role="complementary" aria-label="<?php _e('Боковая панель', 'yandexpro'); ?>">
    <div class="sidebar-content">
        
        <?php if (is_active_sidebar('sidebar-1')) : ?>
            
            <?php dynamic_sidebar('sidebar-1'); ?>
            
        <?php else : ?>
            
            <!-- Default sidebar content when no widgets are added -->
            <section class="widget widget_search">
                <h3 class="widget-title"><?php _e('Поиск', 'yandexpro'); ?></h3>
                <?php get_search_form(); ?>
            </section>

            <section class="widget widget_recent_entries">
                <h3 class="widget-title"><?php _e('Последние записи', 'yandexpro'); ?></h3>
                <?php
                $recent_posts = new WP_Query(array(
                    'posts_per_page' => 5,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true
                ));
                
                if ($recent_posts->have_posts()) :
                ?>
                    <ul class="recent-posts-list">
                        <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                            <li class="recent-post-item">
                                <a href="<?php the_permalink(); ?>" class="recent-post-link">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="recent-post-thumbnail">
                                            <?php 
                                            the_post_thumbnail('thumbnail', array(
                                                'alt' => the_title_attribute(array('echo' => false)),
                                                'loading' => 'lazy',
                                                'decoding' => 'async'
                                            )); 
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="recent-post-content">
                                        <h4 class="recent-post-title"><?php the_title(); ?></h4>
                                        <time class="recent-post-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </time>
                                    </div>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </section>

            <section class="widget widget_categories">
                <h3 class="widget-title"><?php _e('Рубрики', 'yandexpro'); ?></h3>
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 10,
                    'hide_empty' => true
                ));
                
                if ($categories) :
                ?>
                    <ul class="categories-list">
                        <?php foreach ($categories as $category) : ?>
                            <li class="category-item">
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-link">
                                    <span class="category-name"><?php echo esc_html($category->name); ?></span>
                                    <span class="category-count">(<?php echo $category->count; ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>

            <section class="widget widget_tag_cloud">
                <h3 class="widget-title"><?php _e('Теги', 'yandexpro'); ?></h3>
                <?php
                $tags = get_tags(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 20,
                    'hide_empty' => true
                ));
                
                if ($tags) :
                ?>
                    <div class="tag-cloud">
                        <?php foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                               class="tag-link tag-link-<?php echo $tag->term_id; ?>" 
                               rel="tag"
                               style="font-size: <?php echo min(1.5, max(0.8, ($tag->count / 10) + 0.8)); ?>em;">
                                <?php echo esc_html($tag->name); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="widget widget_archive">
                <h3 class="widget-title"><?php _e('Архивы', 'yandexpro'); ?></h3>
                <?php
                $archives = wp_get_archives(array(
                    'type' => 'monthly',
                    'limit' => 12,
                    'echo' => false,
                    'show_post_count' => true
                ));
                
                if ($archives) :
                ?>
                    <ul class="archives-list">
                        <?php echo $archives; ?>
                    </ul>
                <?php endif; ?>
            </section>

            <?php if (get_theme_mod('yandexpro_show_sidebar_newsletter', false)) : ?>
                <section class="widget widget_newsletter">
                    <h3 class="widget-title"><?php _e('Подписка на новости', 'yandexpro'); ?></h3>
                    <div class="newsletter-content">
                        <p><?php _e('Подпишитесь на нашу рассылку, чтобы получать последние новости и статьи о Яндекс.Директ и интернет-маркетинге.', 'yandexpro'); ?></p>
                        
                        <form class="newsletter-form" action="#" method="post">
                            <div class="form-group">
                                <label for="newsletter-email" class="screen-reader-text">
                                    <?php _e('Ваш email адрес', 'yandexpro'); ?>
                                </label>
                                <input type="email" 
                                       id="newsletter-email" 
                                       name="newsletter_email" 
                                       placeholder="<?php _e('Ваш email', 'yandexpro'); ?>"
                                       required>
                            </div>
                            <button type="submit" class="btn btn-primary newsletter-submit">
                                <?php _e('Подписаться', 'yandexpro'); ?>
                            </button>
                            <p class="newsletter-privacy">
                                <small><?php _e('Мы не спамим и не передаем данные третьим лицам.', 'yandexpro'); ?></small>
                            </p>
                        </form>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (get_theme_mod('yandexpro_show_sidebar_social', true)) : ?>
                <section class="widget widget_social_links">
                    <h3 class="widget-title"><?php _e('Мы в соцсетях', 'yandexpro'); ?></h3>
                    <div class="social-links-sidebar">
                        <?php
                        $social_links = array(
                            'vk' => array(
                                'url' => get_theme_mod('yandexpro_vk_url', ''),
                                'label' => __('ВКонтакте', 'yandexpro'),
                                'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0z"/></svg>'
                            ),
                            'telegram' => array(
                                'url' => get_theme_mod('yandexpro_telegram_url', ''),
                                'label' => __('Telegram', 'yandexpro'),
                                'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0z"/></svg>'
                            ),
                            'youtube' => array(
                                'url' => get_theme_mod('yandexpro_youtube_url', ''),
                                'label' => __('YouTube', 'yandexpro'),
                                'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/></svg>'
                            ),
                            'twitter' => array(
                                'url' => get_theme_mod('yandexpro_twitter_url', ''),
                                'label' => __('Twitter', 'yandexpro'),
                                'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>'
                            )
                        );

                        foreach ($social_links as $network => $data) :
                            if ($data['url']) :
                        ?>
                                <a href="<?php echo esc_url($data['url']); ?>" 
                                   class="social-link social-<?php echo esc_attr($network); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   aria-label="<?php echo esc_attr($data['label']); ?>">
                                    <?php echo $data['icon']; ?>
                                    <span class="social-label"><?php echo esc_html($data['label']); ?></span>
                                </a>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </section>
            <?php endif; ?>

        <?php endif; ?>

        <?php
        // Custom widget area for promotional content
        if (get_theme_mod('yandexpro_show_sidebar_promo', false)) :
            $promo_title = get_theme_mod('yandexpro_sidebar_promo_title', __('Реклама', 'yandexpro'));
            $promo_content = get_theme_mod('yandexpro_sidebar_promo_content', '');
            
            if ($promo_content) :
        ?>
                <section class="widget widget_promo">
                    <?php if ($promo_title) : ?>
                        <h3 class="widget-title"><?php echo esc_html($promo_title); ?></h3>
                    <?php endif; ?>
                    <div class="promo-content">
                        <?php echo wp_kses_post($promo_content); ?>
                    </div>
                </section>
        <?php
            endif;
        endif;
        ?>

    </div>
</aside><!-- #secondary -->