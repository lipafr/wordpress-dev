<?php
/**
 * Шаблон для обычных страниц
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#pages
 *
 * @package YandexPro_Enhanced
 */

get_header();
?>

<!-- Breadcrumbs -->
<?php if ( get_theme_mod( 'show_breadcrumbs', true ) && ! is_front_page() ) : ?>
    <div class="breadcrumbs-wrapper">
        <div class="container">
            <?php yandexpro_breadcrumbs(); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Main Content -->
<div class="page-wrapper">
    <div class="container">
        <div class="content-wrapper">
            
            <!-- Primary Content -->
            <main class="primary-content page-content" role="main">
                
                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <article id="page-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?> itemscope itemtype="https://schema.org/WebPage">
                        
                        <!-- Page Header -->
                        <header class="page-header">
                            <h1 class="page-title" itemprop="name">
                                <?php the_title(); ?>
                            </h1>
                            
                            <!-- Page Meta (если нужно) -->
                            <?php if ( ! is_front_page() && ( get_the_modified_date() !== get_the_date() ) ) : ?>
                                <div class="page-meta">
                                    <span class="page-updated">
                                        <span class="updated-label"><?php esc_html_e( 'Обновлено:', 'yandexpro' ); ?></span>
                                        <time class="updated-date" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>" itemprop="dateModified">
                                            <?php the_modified_date(); ?>
                                        </time>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Featured Image (если есть) -->
                        <?php if ( has_post_thumbnail() && ! is_front_page() ) : ?>
                            <div class="page-featured-image" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                <?php
                                the_post_thumbnail( 'yandexpro-featured-large', array(
                                    'class'    => 'page-featured-img',
                                    'loading'  => 'eager',
                                    'decoding' => 'async',
                                ) );
                                
                                // Добавляем данные изображения для Schema
                                $image_data = wp_get_attachment_image_src( get_post_thumbnail_id(), 'yandexpro-featured-large' );
                                if ( $image_data ) :
                                ?>
                                    <meta itemprop="url" content="<?php echo esc_url( $image_data[0] ); ?>">
                                    <meta itemprop="width" content="<?php echo esc_attr( $image_data[1] ); ?>">
                                    <meta itemprop="height" content="<?php echo esc_attr( $image_data[2] ); ?>">
                                <?php endif; ?>
                                
                                <!-- Caption если есть -->
                                <?php
                                $caption = get_the_post_thumbnail_caption();
                                if ( $caption ) :
                                ?>
                                    <figcaption class="page-featured-caption">
                                        <?php echo wp_kses_post( $caption ); ?>
                                    </figcaption>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Page Content -->
                        <div class="page-content-text" itemprop="mainContentOfPage">
                            <?php
                            the_content();

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'yandexpro' ),
                                'after'  => '</div>',
                                'pagelink' => '<span class="page-number">%</span>',
                            ) );
                            ?>
                        </div>

                        <!-- Page Footer -->
                        <footer class="page-footer">
                            
                            <!-- Edit Link for Admin -->
                            <?php
                            edit_post_link(
                                sprintf(
                                    wp_kses(
                                        /* translators: %s: Post title */
                                        __( 'Редактировать <span class="screen-reader-text">"%s"</span>', 'yandexpro' ),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    wp_kses_post( get_the_title() )
                                ),
                                '<div class="edit-link">',
                                '</div>'
                            );
                            ?>
                            
                            <!-- Social Share for Important Pages -->
                            <?php if ( yandexpro_should_show_page_share() ) : ?>
                                <div class="page-share">
                                    <h3 class="share-title"><?php esc_html_e( 'Поделиться страницей:', 'yandexpro' ); ?></h3>
                                    <?php yandexpro_page_social_share(); ?>
                                </div>
                            <?php endif; ?>
                        </footer>

                        <!-- Скрытые структурированные данные -->
                        <div style="display: none;">
                            <span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                <span itemprop="name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                                <span itemprop="url"><?php echo esc_url( home_url() ); ?></span>
                            </span>
                            <time itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                <?php echo esc_html( get_the_date() ); ?>
                            </time>
                            <span itemprop="mainEntity" itemscope itemtype="https://schema.org/WebPage">
                                <span itemprop="@id"><?php echo esc_url( get_permalink() ); ?></span>
                            </span>
                        </div>

                    </article>

                    <!-- Child Pages (если есть) -->
                    <?php yandexpro_child_pages(); ?>

                    <!-- Comments (если включены для страниц) -->
                    <?php
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>

            </main><!-- .primary-content -->

            <!-- Sidebar (показываем только если не полноширинная страница) -->
            <?php 
            $show_sidebar = get_theme_mod( 'show_sidebar', true ) && 
                           is_active_sidebar( 'sidebar-1' ) && 
                           ! yandexpro_is_fullwidth_page();
            
            if ( $show_sidebar ) : 
            ?>
                <aside class="secondary-content" role="complementary" aria-label="<?php esc_attr_e( 'Боковая панель', 'yandexpro' ); ?>">
                    <?php dynamic_sidebar( 'sidebar-1' ); ?>
                </aside>
            <?php endif; ?>

        </div><!-- .content-wrapper -->
    </div><!-- .container -->
</div><!-- .page-wrapper -->

<!-- Call to Action Section (для важных страниц) -->
<?php if ( yandexpro_should_show_page_cta() ) : ?>
    <section class="page-cta" role="region" aria-label="<?php esc_attr_e( 'Призыв к действию', 'yandexpro' ); ?>">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">
                    <?php echo esc_html( get_theme_mod( 'page_cta_title', __( 'Готовы начать?', 'yandexpro' ) ) ); ?>
                </h2>
                <p class="cta-description">
                    <?php echo esc_html( get_theme_mod( 'page_cta_description', __( 'Свяжитесь с нами для консультации по вашему проекту.', 'yandexpro' ) ) ); ?>
                </p>
                <div class="cta-buttons">
                    <?php
                    $cta_button_text = get_theme_mod( 'page_cta_button_text', __( 'Связаться', 'yandexpro' ) );
                    $cta_button_url = get_theme_mod( 'page_cta_button_url', '#contact' );
                    
                    if ( $cta_button_text && $cta_button_url ) :
                    ?>
                        <a href="<?php echo esc_url( $cta_button_url ); ?>" class="button button-primary cta-button">
                            <?php echo esc_html( $cta_button_text ); ?>
                        </a>
                    <?php endif; ?>
                    
                    <!-- Secondary Button -->
                    <?php
                    $cta_secondary_text = get_theme_mod( 'page_cta_secondary_text', __( 'Узнать больше', 'yandexpro' ) );
                    $cta_secondary_url = get_theme_mod( 'page_cta_secondary_url', '/about' );
                    
                    if ( $cta_secondary_text && $cta_secondary_url ) :
                    ?>
                        <a href="<?php echo esc_url( $cta_secondary_url ); ?>" class="button button-secondary cta-button-secondary">
                            <?php echo esc_html( $cta_secondary_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
get_footer();

/**
 * Проверка, является ли страница полноширинной
 */
function yandexpro_is_fullwidth_page() {
    return is_page_template( array(
        'page-templates/page-landing.php',
        'page-templates/page-fullwidth.php',
        'page-templates/page-landing-alt.php'
    ) ) || get_post_meta( get_the_ID(), '_yandexpro_fullwidth', true );
}

/**
 * Показывать ли социальные кнопки на странице
 */
function yandexpro_should_show_page_share() {
    // Показываем на важных страницах или если включено в мета-поле
    $important_pages = array( 'about', 'services', 'contact' );
    $page_slug = get_post_field( 'post_name', get_the_ID() );
    
    return in_array( $page_slug, $important_pages ) || 
           get_post_meta( get_the_ID(), '_yandexpro_show_share', true ) ||
           get_theme_mod( 'show_page_share_by_default', false );
}

/**
 * Показывать ли CTA секцию
 */
function yandexpro_should_show_page_cta() {
    // Не показываем на главной и специальных шаблонах
    if ( is_front_page() || yandexpro_is_fullwidth_page() ) {
        return false;
    }
    
    // Показываем если включено в настройках или в мета-поле страницы
    return get_theme_mod( 'show_page_cta', false ) || 
           get_post_meta( get_the_ID(), '_yandexpro_show_cta', true );
}

/**
 * Социальные кнопки для страниц (упрощенная версия)
 */
function yandexpro_page_social_share() {
    $page_url = urlencode( get_permalink() );
    $page_title = urlencode( get_the_title() );
    
    $share_links = array(
        'vk' => array(
            'url'   => 'https://vk.com/share.php?url=' . $page_url . '&title=' . $page_title,
            'label' => 'ВКонтакте',
            'icon'  => '🔗',
        ),
        'telegram' => array(
            'url'   => 'https://t.me/share/url?url=' . $page_url . '&text=' . $page_title,
            'label' => 'Telegram', 
            'icon'  => '📱',
        ),
        'twitter' => array(
            'url'   => 'https://twitter.com/intent/tweet?url=' . $page_url . '&text=' . $page_title,
            'label' => 'Twitter',
            'icon'  => '🐦',
        ),
        'facebook' => array(
            'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $page_url,
            'label' => 'Facebook',
            'icon'  => '👥',
        ),
    );

    echo '<div class="page-share-links">';
    foreach ( $share_links as $network => $data ) {
        printf(
            '<a href="%1$s" class="page-share-link page-share-%2$s" target="_blank" rel="noopener noreferrer" aria-label="%3$s">
                <span class="share-icon" aria-hidden="true">%4$s</span>
                <span class="share-label">%5$s</span>
            </a>',
            esc_url( $data['url'] ),
            esc_attr( $network ),
            esc_attr( sprintf( __( 'Поделиться в %s', 'yandexpro' ), $data['label'] ) ),
            $data['icon'],
            esc_html( $data['label'] )
        );
    }
    echo '</div>';
}

/**
 * Дочерние страницы (если есть)
 */
function yandexpro_child_pages() {
    $child_pages = get_children( array(
        'post_parent' => get_the_ID(),
        'post_type'   => 'page',
        'post_status' => 'publish',
        'orderby'     => 'menu_order',
        'order'       => 'ASC',
        'numberposts' => 10,
    ) );

    if ( empty( $child_pages ) ) {
        return;
    }
    ?>
    
    <section class="child-pages" role="region" aria-label="<?php esc_attr_e( 'Подстраницы', 'yandexpro' ); ?>">
        <div class="child-pages-header">
            <h2 class="child-pages-title">
                <?php esc_html_e( 'Разделы этой страницы:', 'yandexpro' ); ?>
            </h2>
        </div>
        
        <div class="child-pages-grid">
            <?php foreach ( $child_pages as $child_page ) : ?>
                <article class="child-page-card">
                    <?php if ( has_post_thumbnail( $child_page->ID ) ) : ?>
                        <div class="child-page-image">
                            <a href="<?php echo esc_url( get_permalink( $child_page->ID ) ); ?>" tabindex="-1" aria-hidden="true">
                                <?php echo get_the_post_thumbnail( $child_page->ID, 'yandexpro-blog-thumb', array(
                                    'loading'  => 'lazy',
                                    'decoding' => 'async',
                                ) ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="child-page-content">
                        <h3 class="child-page-title">
                            <a href="<?php echo esc_url( get_permalink( $child_page->ID ) ); ?>">
                                <?php echo esc_html( get_the_title( $child_page->ID ) ); ?>
                            </a>
                        </h3>
                        
                        <?php
                        $child_excerpt = get_the_excerpt( $child_page->ID );
                        if ( $child_excerpt ) :
                        ?>
                            <p class="child-page-excerpt">
                                <?php echo esc_html( wp_trim_words( $child_excerpt, 15 ) ); ?>
                            </p>
                        <?php endif; ?>
                        
                        <a href="<?php echo esc_url( get_permalink( $child_page->ID ) ); ?>" class="child-page-link">
                            <?php esc_html_e( 'Читать далее', 'yandexpro' ); ?>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    
    <?php
}
?>