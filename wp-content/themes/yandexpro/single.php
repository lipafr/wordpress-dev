<?php
/**
 * Шаблон для отдельных постов
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package YandexPro_Enhanced
 */

get_header();
?>

<!-- Breadcrumbs -->
<?php if ( get_theme_mod( 'show_breadcrumbs', true ) ) : ?>
    <div class="breadcrumbs-wrapper">
        <div class="container">
            <?php yandexpro_breadcrumbs(); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Main Content -->
<div class="single-post-wrapper">
    <div class="container">
        <div class="content-wrapper">
            
            <!-- Primary Content -->
            <main class="primary-content single-content" role="main">
                
                <?php while ( have_posts() ) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?> itemscope itemtype="https://schema.org/BlogPosting">
                        
                        <!-- Post Header -->
                        <header class="post-header">
                            
                            <!-- Categories -->
                            <?php 
                            $categories = get_the_category();
                            if ( $categories ) : 
                            ?>
                                <div class="post-categories" itemprop="about">
                                    <?php foreach ( $categories as $category ) : ?>
                                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
                                           class="post-category-link" 
                                           itemprop="keywords">
                                            <?php echo esc_html( $category->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Post Title -->
                            <h1 class="post-title" itemprop="headline">
                                <?php the_title(); ?>
                            </h1>
                            
                            <!-- Post Meta -->
                            <div class="post-meta">
                                <div class="post-meta-main">
                                    <!-- Author -->
                                    <span class="post-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                        <span class="author-avatar">
                                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
                                        </span>
                                        <span class="author-info">
                                            <span class="author-name" itemprop="name">
                                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="url">
                                                    <?php the_author(); ?>
                                                </a>
                                            </span>
                                        </span>
                                    </span>
                                    
                                    <!-- Date -->
                                    <time class="post-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
                                        <span aria-hidden="true">📅</span>
                                        <?php the_date(); ?>
                                    </time>
                                    
                                    <!-- Reading Time -->
                                    <span class="post-reading-time">
                                        <span aria-hidden="true">🕐</span>
                                        <?php echo esc_html( yandexpro_get_reading_time() ); ?>
                                    </span>
                                    
                                    <!-- Views (если есть функция подсчета) -->
                                    <?php if ( function_exists( 'yandexpro_get_post_views' ) ) : ?>
                                        <span class="post-views">
                                            <span aria-hidden="true">👁</span>
                                            <?php echo esc_html( yandexpro_get_post_views() ); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Updated Date (если отличается от даты публикации) -->
                                <?php if ( get_the_modified_date() !== get_the_date() ) : ?>
                                    <div class="post-updated">
                                        <span class="updated-label"><?php esc_html_e( 'Обновлено:', 'yandexpro' ); ?></span>
                                        <time class="updated-date" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>" itemprop="dateModified">
                                            <?php the_modified_date(); ?>
                                        </time>
                                    </div>
                                <?php else : ?>
                                    <!-- Скрытая дата обновления для Schema -->
                                    <time style="display: none;" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>" itemprop="dateModified">
                                        <?php the_modified_date(); ?>
                                    </time>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Featured Image -->
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-featured-image" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                    <?php
                                    the_post_thumbnail( 'yandexpro-featured-large', array(
                                        'class'    => 'post-featured-img',
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
                                        <figcaption class="post-featured-caption">
                                            <?php echo wp_kses_post( $caption ); ?>
                                        </figcaption>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Post Content -->
                        <div class="post-content" itemprop="articleBody">
                            <?php
                            the_content( sprintf(
                                wp_kses(
                                    /* translators: %s: Post title */
                                    __( 'Продолжить чтение<span class="screen-reader-text"> "%s"</span>', 'yandexpro' ),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                wp_kses_post( get_the_title() )
                            ) );

                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'yandexpro' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>

                        <!-- Post Footer -->
                        <footer class="post-footer">
                            
                            <!-- Tags -->
                            <?php
                            $tags = get_the_tags();
                            if ( $tags ) :
                            ?>
                                <div class="post-tags">
                                    <h3 class="tags-title"><?php esc_html_e( 'Теги:', 'yandexpro' ); ?></h3>
                                    <div class="tags-list">
                                        <?php foreach ( $tags as $tag ) : ?>
                                            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" 
                                               class="tag-link" 
                                               rel="tag"
                                               itemprop="keywords">
                                                #<?php echo esc_html( $tag->name ); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Social Share -->
                            <?php if ( get_theme_mod( 'show_social_share', true ) ) : ?>
                                <div class="post-share">
                                    <h3 class="share-title"><?php esc_html_e( 'Поделиться:', 'yandexpro' ); ?></h3>
                                    <?php yandexpro_social_share(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Author Bio (если заполнен в профиле) -->
                            <?php if ( get_the_author_meta( 'description' ) ) : ?>
                                <div class="post-author-bio" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                    <div class="author-bio-avatar">
                                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                                    </div>
                                    <div class="author-bio-content">
                                        <h3 class="author-bio-name" itemprop="name">
                                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" itemprop="url">
                                                <?php the_author(); ?>
                                            </a>
                                        </h3>
                                        <div class="author-bio-description" itemprop="description">
                                            <?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?>
                                        </div>
                                        
                                        <!-- Author Social Links -->
                                        <?php yandexpro_author_social_links(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </footer>

                        <!-- Скрытые структурированные данные -->
                        <div style="display: none;">
                            <span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                                <span itemprop="name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
                                <span itemprop="url"><?php echo esc_url( home_url() ); ?></span>
                                <?php if ( has_custom_logo() ) : ?>
                                    <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                                        <?php
                                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                                        $logo_image = wp_get_attachment_image_src( $custom_logo_id, 'full' );
                                        if ( $logo_image ) :
                                        ?>
                                            <span itemprop="url"><?php echo esc_url( $logo_image[0] ); ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </span>
                            <span itemprop="mainEntityOfPage" itemscope itemtype="https://schema.org/WebPage">
                                <span itemprop="@id"><?php echo esc_url( get_permalink() ); ?></span>
                            </span>
                        </div>

                    </article>

                    <!-- Post Navigation -->
                    <nav class="post-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Навигация между постами', 'yandexpro' ); ?>">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <div class="nav-links">
                            <?php if ( $prev_post ) : ?>
                                <div class="nav-previous">
                                    <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="nav-link nav-link-prev">
                                        <span class="nav-direction">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <?php esc_html_e( 'Предыдущая статья', 'yandexpro' ); ?>
                                        </span>
                                        <span class="nav-title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $next_post ) : ?>
                                <div class="nav-next">
                                    <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="nav-link nav-link-next">
                                        <span class="nav-direction">
                                            <?php esc_html_e( 'Следующая статья', 'yandexpro' ); ?>
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                <path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        <span class="nav-title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </nav>

                    <!-- Related Posts -->
                    <?php get_template_part( 'template-parts/blog/related-posts' ); ?>

                    <!-- Comments -->
                    <?php
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>

            </main><!-- .primary-content -->

            <!-- Sidebar -->
            <?php if ( get_theme_mod( 'show_sidebar', true ) && is_active_sidebar( 'sidebar-1' ) ) : ?>
                <aside class="secondary-content" role="complementary" aria-label="<?php esc_attr_e( 'Боковая панель', 'yandexpro' ); ?>">
                    <?php dynamic_sidebar( 'sidebar-1' ); ?>
                </aside>
            <?php endif; ?>

        </div><!-- .content-wrapper -->
    </div><!-- .container -->
</div><!-- .single-post-wrapper -->

<?php
get_footer();

/**
 * Социальные кнопки "Поделиться"
 */
function yandexpro_social_share() {
    $post_url = urlencode( get_permalink() );
    $post_title = urlencode( get_the_title() );
    $post_excerpt = urlencode( wp_trim_words( get_the_excerpt(), 20 ) );
    
    $share_links = array(
        'vk' => array(
            'url'   => 'https://vk.com/share.php?url=' . $post_url . '&title=' . $post_title,
            'label' => 'ВКонтакте',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zm3.692 17.123h-1.744c-.66 0-.864-.525-2.05-1.727-1.033-1.01-1.49-.834-1.49.18v1.57c0 .394-.127.506-.807.506-1.677 0-3.54-1.028-4.856-2.944C6.695 11.008 6.25 7.5 6.25 7.5s-.102-.31.36-.31h1.868c.5 0 .69.22.885.737.9 2.4 2.4 4.5 3.024 3.065.188-.434.274-1.41-.01-2.17-.24-.673-.634-.71-.634-1.436 0-.31.188-.6.49-.6h2.95c.414 0 .56.216.56.558v2.99c0 .414.188 1.23.862 1.23.688 0 1.23-.414 2.482-1.678 1.2-1.2 2.07-3.066 2.07-3.066s.188-.414.482-.438h1.744c.966 0 .12.482-.188 1.09-.36.726-1.644 2.538-1.644 2.538-.414.6-.345.867 0 1.4.258.398 1.102 1.102 1.67 1.782.66.78.12 1.2-.24 1.2z"/></svg>',
        ),
        'telegram' => array(
            'url'   => 'https://t.me/share/url?url=' . $post_url . '&text=' . $post_title,
            'label' => 'Telegram',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.13-.31-1.09-.66.03-.18.14-.37.33-.56 1.31-1.15 2.73-2.17 4.25-3.06 2.34-1.09 4.99-2.04 7.94-2.85.71-.2 1.36-.02 1.79.6z"/></svg>',
        ),
        'twitter' => array(
            'url'   => 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $post_title,
            'label' => 'Twitter',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
        ),
        'facebook' => array(
            'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url,
            'label' => 'Facebook',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        ),
        'linkedin' => array(
            'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $post_url,
            'label' => 'LinkedIn',
            'icon'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
        ),
    );

    echo '<div class="social-share-links">';
    foreach ( $share_links as $network => $data ) {
        printf(
            '<a href="%1$s" class="share-link share-link-%2$s" target="_blank" rel="noopener noreferrer" aria-label="%3$s">
                %4$s
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
 * Социальные ссылки автора
 */
function yandexpro_author_social_links() {
    $author_id = get_the_author_meta( 'ID' );
    $social_fields = array(
        'twitter'   => __( 'Twitter', 'yandexpro' ),
        'facebook'  => __( 'Facebook', 'yandexpro' ),
        'linkedin'  => __( 'LinkedIn', 'yandexpro' ),
        'instagram' => __( 'Instagram', 'yandexpro' ),
        'telegram'  => __( 'Telegram', 'yandexpro' ),
    );

    $has_social = false;
    foreach ( $social_fields as $field => $label ) {
        if ( get_the_author_meta( $field, $author_id ) ) {
            $has_social = true;
            break;
        }
    }

    if ( ! $has_social ) {
        return;
    }

    echo '<div class="author-social-links">';
    foreach ( $social_fields as $field => $label ) {
        $url = get_the_author_meta( $field, $author_id );
        if ( $url ) {
            printf(
                '<a href="%1$s" class="author-social-link" target="_blank" rel="noopener noreferrer" aria-label="%2$s">%3$s</a>',
                esc_url( $url ),
                esc_attr( sprintf( __( '%s автора', 'yandexpro' ), $label ) ),
                esc_html( $label )
            );
        }
    }
    echo '</div>';
}
?>