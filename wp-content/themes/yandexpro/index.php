<?php
/**
 * Основной шаблон темы YandexPro Enhanced
 * 
 * Этот файл используется как fallback для всех страниц
 * и как основной шаблон для блога
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package YandexPro_Enhanced
 */

get_header();
?>

<!-- Hero Section (только на главной странице блога) -->
<?php if ( is_home() && ! is_paged() ) : ?>
    <section class="hero blog-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <?php 
                    $hero_title = get_theme_mod( 'hero_title', __( 'Блог о Яндекс Директ и интернет-маркетинге', 'yandexpro' ) );
                    echo wp_kses_post( $hero_title );
                    ?>
                </h1>
                <p class="hero-description">
                    <?php 
                    $hero_description = get_theme_mod( 'hero_description', __( 'Практические кейсы, инсайты и тренды из мира контекстной рекламы. Только проверенная информация от практикующего специалиста.', 'yandexpro' ) );
                    echo wp_kses_post( $hero_description );
                    ?>
                </p>
                
                <!-- Search Form -->
                <div class="search-container">
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <label for="search-field" class="screen-reader-text">
                            <?php esc_html_e( 'Поиск по статьям', 'yandexpro' ); ?>
                        </label>
                        <div class="search-wrapper">
                            <span class="search-icon" aria-hidden="true">🔍</span>
                            <input 
                                type="search" 
                                id="search-field"
                                class="search-box" 
                                placeholder="<?php esc_attr_e( 'Поиск по статьям...', 'yandexpro' ); ?>"
                                value="<?php echo get_search_query(); ?>" 
                                name="s"
                                autocomplete="off"
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Breadcrumbs (если включены в настройках) -->
<?php if ( get_theme_mod( 'show_breadcrumbs', true ) && ! is_front_page() ) : ?>
    <div class="breadcrumbs-wrapper">
        <div class="container">
            <?php yandexpro_breadcrumbs(); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Featured Articles Section (только на главной странице блога) -->
<?php if ( is_home() && ! is_paged() ) : ?>
    <?php get_template_part( 'template-parts/blog/featured-posts' ); ?>
<?php endif; ?>

<!-- Categories Section (только на главной странице блога) -->
<?php if ( is_home() && ! is_paged() ) : ?>
    <section class="categories">
        <div class="container">
            <h2 class="categories-title"><?php esc_html_e( 'Популярные темы', 'yandexpro' ); ?></h2>
            
            <?php 
            $categories = get_categories( array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => 8,
                'hide_empty' => true,
            ) );
            
            if ( $categories ) : ?>
                <div class="categories-list" role="group" aria-label="<?php esc_attr_e( 'Категории блога', 'yandexpro' ); ?>">
                    <!-- Ссылка "Все статьи" -->
                    <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" 
                       class="category-tag<?php echo ( ! is_category() ? ' active' : '' ); ?>">
                        <?php esc_html_e( 'Все статьи', 'yandexpro' ); ?>
                    </a>
                    
                    <?php foreach ( $categories as $category ) : ?>
                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
                           class="category-tag<?php echo ( is_category( $category->term_id ) ? ' active' : '' ); ?>">
                            <?php echo esc_html( $category->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<!-- Main Content Area -->
<section class="latest<?php echo ( is_home() && ! is_paged() ? '' : ' main-content' ); ?>">
    <div class="container">
        <div class="content-wrapper">
            
            <!-- Main Content -->
            <div class="primary-content">
                
                <!-- Archive Header (для архивных страниц) -->
                <?php if ( ! is_home() && ( is_archive() || is_search() ) ) : ?>
                    <header class="archive-header">
                        <?php if ( is_search() ) : ?>
                            <h1 class="archive-title">
                                <?php
                                printf(
                                    /* translators: %s: search query */
                                    esc_html__( 'Результаты поиска: %s', 'yandexpro' ),
                                    '<span class="search-query">' . get_search_query() . '</span>'
                                );
                                ?>
                            </h1>
                            <?php if ( have_posts() ) : ?>
                                <p class="archive-description">
                                    <?php
                                    global $wp_query;
                                    printf(
                                        /* translators: %s: number of search results */
                                        _n(
                                            'Найдена %s статья',
                                            'Найдено %s статей',
                                            $wp_query->found_posts,
                                            'yandexpro'
                                        ),
                                        number_format_i18n( $wp_query->found_posts )
                                    );
                                    ?>
                                </p>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php the_archive_title( '<h1 class="archive-title">', '</h1>' ); ?>
                            <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
                        <?php endif; ?>
                    </header>
                <?php endif; ?>

                <!-- Blog Header (для главной страницы блога) -->
                <?php if ( is_home() && ! is_paged() ) : ?>
                    <div class="section-header">
                        <h2 class="section-title"><?php esc_html_e( 'Новое на сайте', 'yandexpro' ); ?></h2>
                    </div>
                <?php endif; ?>

                <!-- Posts Grid -->
                <?php if ( have_posts() ) : ?>
                    <div class="articles-grid">
                        
                        <!-- Posts Loop -->
                        <?php
                        $post_count = 0;
                        $posts_per_row = array( 3, 2, 3, 2, 3 ); // Паттерн из макета
                        $current_row = 0;
                        $posts_in_current_row = 0;
                        
                        while ( have_posts() ) :
                            the_post();
                            
                            // Начинаем новую строку
                            if ( $posts_in_current_row === 0 ) {
                                $row_class = 'row-' . $posts_per_row[ $current_row % count( $posts_per_row ) ];
                                echo '<div class="articles-row ' . esc_attr( $row_class ) . '">';
                            }
                            
                            // Выводим карточку поста
                            get_template_part( 'template-parts/content/post-card' );
                            
                            $post_count++;
                            $posts_in_current_row++;
                            
                            // Закрываем строку если достигли лимита
                            if ( $posts_in_current_row >= $posts_per_row[ $current_row % count( $posts_per_row ) ] ) {
                                echo '</div><!-- .articles-row -->';
                                $current_row++;
                                $posts_in_current_row = 0;
                            }
                            
                        endwhile;
                        
                        // Закрываем последнюю строку если она не была закрыта
                        if ( $posts_in_current_row > 0 ) {
                            echo '</div><!-- .articles-row -->';
                        }
                        ?>
                        
                    </div><!-- .articles-grid -->

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        <?php yandexpro_posts_pagination(); ?>
                    </div>

                <?php else : ?>
                    
                    <!-- No Posts Found -->
                    <div class="no-posts-found">
                        <div class="no-posts-content">
                            <?php if ( is_search() ) : ?>
                                <h2 class="no-posts-title">
                                    <?php esc_html_e( 'Ничего не найдено', 'yandexpro' ); ?>
                                </h2>
                                <p class="no-posts-text">
                                    <?php esc_html_e( 'К сожалению, по вашему запросу ничего не найдено. Попробуйте изменить поисковый запрос.', 'yandexpro' ); ?>
                                </p>
                                
                                <!-- Search Form -->
                                <div class="no-posts-search">
                                    <h3><?php esc_html_e( 'Попробуйте другой запрос:', 'yandexpro' ); ?></h3>
                                    <?php get_search_form(); ?>
                                </div>
                                
                            <?php else : ?>
                                <h2 class="no-posts-title">
                                    <?php esc_html_e( 'Статей пока нет', 'yandexpro' ); ?>
                                </h2>
                                <p class="no-posts-text">
                                    <?php esc_html_e( 'Пока что здесь нет опубликованных статей. Загляните позже!', 'yandexpro' ); ?>
                                </p>
                            <?php endif; ?>
                            
                            <!-- Suggested Actions -->
                            <div class="no-posts-actions">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-primary">
                                    <?php esc_html_e( 'На главную', 'yandexpro' ); ?>
                                </a>
                                
                                <?php if ( ! is_search() ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="button button-secondary">
                                        <?php esc_html_e( 'Все статьи', 'yandexpro' ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                <?php endif; ?>
                
            </div><!-- .primary-content -->

            <!-- Sidebar -->
            <?php if ( get_theme_mod( 'show_sidebar', true ) && is_active_sidebar( 'sidebar-1' ) ) : ?>
                <aside class="secondary-content" role="complementary" aria-label="<?php esc_attr_e( 'Боковая панель', 'yandexpro' ); ?>">
                    <?php dynamic_sidebar( 'sidebar-1' ); ?>
                </aside>
            <?php endif; ?>
            
        </div><!-- .content-wrapper -->
    </div><!-- .container -->
</section><!-- .latest/.main-content -->

<?php
get_footer();

/**
 * Хлебные крошки
 */
function yandexpro_breadcrumbs() {
    // Проверяем, что не на главной странице
    if ( is_front_page() ) {
        return;
    }

    $separator = '<span class="breadcrumb-separator" aria-hidden="true">/</span>';
    $home_title = esc_html__( 'Главная', 'yandexpro' );

    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Навигация по сайту', 'yandexpro' ) . '">';
    echo '<ol class="breadcrumb-list">';

    // Главная страница
    echo '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . $home_title . '</a></li>';

    if ( is_home() ) {
        // Страница блога
        echo $separator;
        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( 'Блог', 'yandexpro' ) . '</li>';
        
    } elseif ( is_category() ) {
        // Страница категории
        echo $separator;
        echo '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html__( 'Блог', 'yandexpro' ) . '</a></li>';
        echo $separator;
        echo '<li class="breadcrumb-item active" aria-current="page">' . single_cat_title( '', false ) . '</li>';
        
    } elseif ( is_tag() ) {
        // Страница тега
        echo $separator;
        echo '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html__( 'Блог', 'yandexpro' ) . '</a></li>';
        echo $separator;
        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( 'Тег: ', 'yandexpro' ) . single_tag_title( '', false ) . '</li>';
        
    } elseif ( is_search() ) {
        // Страница поиска
        echo $separator;
        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( 'Поиск: ', 'yandexpro' ) . get_search_query() . '</li>';
        
    } elseif ( is_404() ) {
        // 404 страница
        echo $separator;
        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html__( 'Страница не найдена', 'yandexpro' ) . '</li>';
        
    } elseif ( is_single() ) {
        // Отдельный пост
        $categories = get_the_category();
        if ( ! empty( $categories ) ) {
            echo $separator;
            echo '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html__( 'Блог', 'yandexpro' ) . '</a></li>';
            echo $separator;
            echo '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a></li>';
        }
        echo $separator;
        echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
        
    } elseif ( is_page() ) {
        // Обычная страница
        if ( $post->post_parent ) {
            // Если есть родительская страница
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            
            while ( $parent_id ) {
                $page = get_page( $parent_id );
                $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a></li>';
                $parent_id = $page->post_parent;
            }
            
            $breadcrumbs = array_reverse( $breadcrumbs );
            foreach ( $breadcrumbs as $crumb ) {
                echo $separator . $crumb;
            }
        }
        echo $separator;
        echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';
    }

    echo '</ol>';
    echo '</nav>';
}

/**
 * Пагинация для постов
 */
function yandexpro_posts_pagination() {
    $pagination_args = array(
        'mid_size'  => 2,
        'prev_text' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><span>' . esc_html__( 'Сюда', 'yandexpro' ) . '</span>',
        'next_text' => '<span>' . esc_html__( 'Туда', 'yandexpro' ) . '</span><svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'type'      => 'array',
    );

    $paginate_links = paginate_links( $pagination_args );

    if ( $paginate_links ) {
        echo '<div class="pagination">';
        
        // Показать ещё (для мобильных)
        echo '<div class="pagination-left">';
        echo '<div class="show-more-dropdown">';
        echo '<span>' . esc_html__( 'Показать ещё', 'yandexpro' ) . '</span>';
        echo '<svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        echo '</div>';
        echo '</div>';
        
        // Основная пагинация
        echo '<div class="pagination-center">';
        echo '<nav class="pagination-nav" role="navigation" aria-label="' . esc_attr__( 'Навигация по страницам', 'yandexpro' ) . '">';
        echo '<ul class="pagination-list">';
        
        foreach ( $paginate_links as $key => $link ) {
            echo '<li class="pagination-item">' . $link . '</li>';
        }
        
        echo '</ul>';
        echo '</nav>';
        echo '</div>';
        
        echo '</div>';
    }
}
?>