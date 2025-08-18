<?php
/**
 * Мета-боксы для настройки лендинговых страниц
 *
 * @package YandexPro_Enhanced
 */

// Блокируем прямой доступ
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Регистрация мета-боксов
 */
function yandexpro_add_meta_boxes() {
    // Мета-бокс для лендинговых страниц
    add_meta_box(
        'yandexpro_landing_settings',
        __( 'Настройки лендинга YandexPro', 'yandexpro' ),
        'yandexpro_landing_meta_box_callback',
        'page',
        'normal',
        'high'
    );

    // Мета-бокс для общих настроек страниц
    add_meta_box(
        'yandexpro_page_settings',
        __( 'Настройки страницы YandexPro', 'yandexpro' ),
        'yandexpro_page_meta_box_callback',
        'page',
        'side',
        'default'
    );

    // Мета-бокс для постов (featured посты)
    add_meta_box(
        'yandexpro_post_settings',
        __( 'Настройки поста YandexPro', 'yandexpro' ),
        'yandexpro_post_meta_box_callback',
        'post',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'yandexpro_add_meta_boxes' );

/**
 * Callback для мета-бокса лендинговых настроек
 */
function yandexpro_landing_meta_box_callback( $post ) {
    wp_nonce_field( 'yandexpro_landing_meta_box', 'yandexpro_landing_meta_box_nonce' );
    
    // Получаем текущие значения
    $values = array();
    $fields = yandexpro_get_landing_fields();
    
    foreach ( $fields as $field => $config ) {
        $values[ $field ] = get_post_meta( $post->ID, $field, true );
    }
    ?>
    
    <div class="yandexpro-meta-tabs">
        <nav class="nav-tab-wrapper">
            <a href="#tab-hero" class="nav-tab nav-tab-active"><?php esc_html_e( 'Hero секция', 'yandexpro' ); ?></a>
            <a href="#tab-features" class="nav-tab"><?php esc_html_e( 'Преимущества', 'yandexpro' ); ?></a>
            <a href="#tab-services" class="nav-tab"><?php esc_html_e( 'Услуги', 'yandexpro' ); ?></a>
            <a href="#tab-testimonials" class="nav-tab"><?php esc_html_e( 'Отзывы', 'yandexpro' ); ?></a>
            <a href="#tab-stats" class="nav-tab"><?php esc_html_e( 'Статистика', 'yandexpro' ); ?></a>
            <a href="#tab-cta" class="nav-tab"><?php esc_html_e( 'Призыв к действию', 'yandexpro' ); ?></a>
        </nav>

        <!-- Hero Section Tab -->
        <div id="tab-hero" class="tab-content active">
            <h3><?php esc_html_e( 'Настройки Hero секции', 'yandexpro' ); ?></h3>
            <p class="description"><?php esc_html_e( 'Если поля пусты, будут использованы значения из Customizer', 'yandexpro' ); ?></p>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="yandexpro_show_blog"><?php esc_html_e( 'Показывать блог', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="yandexpro_show_blog" name="_yandexpro_show_blog" value="1" <?php checked( $values['_yandexpro_show_blog'] ?? '', '1' ); ?>>
                        <label for="yandexpro_show_blog"><?php esc_html_e( 'Показать последние статьи', 'yandexpro' ); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_cta_title"><?php esc_html_e( 'Заголовок CTA', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_cta_title" name="_yandexpro_cta_title" value="<?php echo esc_attr( $values['_yandexpro_cta_title'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_cta_description"><?php esc_html_e( 'Описание CTA', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <textarea id="yandexpro_cta_description" name="_yandexpro_cta_description" rows="3" class="large-text"><?php echo esc_textarea( $values['_yandexpro_cta_description'] ?? '' ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_cta_button_text"><?php esc_html_e( 'Текст кнопки', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_cta_button_text" name="_yandexpro_cta_button_text" value="<?php echo esc_attr( $values['_yandexpro_cta_button_text'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_cta_button_url"><?php esc_html_e( 'Ссылка кнопки', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="yandexpro_cta_button_url" name="_yandexpro_cta_button_url" value="<?php echo esc_url( $values['_yandexpro_cta_button_url'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_cta_phone"><?php esc_html_e( 'Телефон', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="tel" id="yandexpro_cta_phone" name="_yandexpro_cta_phone" value="<?php echo esc_attr( $values['_yandexpro_cta_phone'] ?? '' ); ?>" class="regular-text">
                        <p class="description"><?php esc_html_e( 'Будет показан как дополнительная кнопка', 'yandexpro' ); ?></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <style>
        .yandexpro-meta-tabs .nav-tab-wrapper { margin-bottom: 20px; }
        .yandexpro-meta-tabs .tab-content { display: none; }
        .yandexpro-meta-tabs .tab-content.active { display: block; }
        .feature-group, .service-group, .testimonial-group, .stat-group { 
            background: #f9f9f9; 
            border-left: 4px solid #7c3aed !important; 
        }
        .feature-group h5, .service-group h5, .testimonial-group h5, .stat-group h5 {
            margin-top: 0;
            color: #7c3aed;
            font-weight: 600;
        }
        .upload-avatar-button { margin-left: 10px; }
    </style>

    <script>
    jQuery(document).ready(function($) {
        // Переключение табов
        $('.nav-tab').on('click', function(e) {
            e.preventDefault();
            
            $('.nav-tab').removeClass('nav-tab-active');
            $('.tab-content').removeClass('active');
            
            $(this).addClass('nav-tab-active');
            $($(this).attr('href')).addClass('active');
        });

        // Загрузка изображений
        $('.upload-avatar-button').on('click', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var targetInput = $('#' + button.data('target'));
            
            var mediaUploader = wp.media({
                title: '<?php esc_html_e( 'Выберите изображение', 'yandexpro' ); ?>',
                button: {
                    text: '<?php esc_html_e( 'Использовать это изображение', 'yandexpro' ); ?>'
                },
                multiple: false
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                targetInput.val(attachment.url);
            });
            
            mediaUploader.open();
        });
    });
    </script>
    
    <?php
}

/**
 * Callback для мета-бокса настроек страницы
 */
function yandexpro_page_meta_box_callback( $post ) {
    wp_nonce_field( 'yandexpro_page_meta_box', 'yandexpro_page_meta_box_nonce' );
    
    $fullwidth = get_post_meta( $post->ID, '_yandexpro_fullwidth', true );
    $show_share = get_post_meta( $post->ID, '_yandexpro_show_share', true );
    $show_cta = get_post_meta( $post->ID, '_yandexpro_show_cta', true );
    ?>
    
    <table class="form-table">
        <tr>
            <th scope="row"><?php esc_html_e( 'Макет страницы', 'yandexpro' ); ?></th>
            <td>
                <label>
                    <input type="checkbox" name="_yandexpro_fullwidth" value="1" <?php checked( $fullwidth, '1' ); ?>>
                    <?php esc_html_e( 'Полноширинная страница', 'yandexpro' ); ?>
                </label>
                <p class="description"><?php esc_html_e( 'Скрыть сайдбар на этой странице', 'yandexpro' ); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Социальные кнопки', 'yandexpro' ); ?></th>
            <td>
                <label>
                    <input type="checkbox" name="_yandexpro_show_share" value="1" <?php checked( $show_share, '1' ); ?>>
                    <?php esc_html_e( 'Показать кнопки "Поделиться"', 'yandexpro' ); ?>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e( 'Призыв к действию', 'yandexpro' ); ?></th>
            <td>
                <label>
                    <input type="checkbox" name="_yandexpro_show_cta" value="1" <?php checked( $show_cta, '1' ); ?>>
                    <?php esc_html_e( 'Показать секцию CTA', 'yandexpro' ); ?>
                </label>
            </td>
        </tr>
    </table>
    
    <?php
}

/**
 * Callback для мета-бокса настроек поста
 */
function yandexpro_post_meta_box_callback( $post ) {
    wp_nonce_field( 'yandexpro_post_meta_box', 'yandexpro_post_meta_box_nonce' );
    
    $featured = get_post_meta( $post->ID, 'featured_post', true );
    ?>
    
    <table class="form-table">
        <tr>
            <th scope="row"><?php esc_html_e( 'Рекомендуемый пост', 'yandexpro' ); ?></th>
            <td>
                <label>
                    <input type="checkbox" name="featured_post" value="1" <?php checked( $featured, '1' ); ?>>
                    <?php esc_html_e( 'Показывать в блоке "Рекомендуемое"', 'yandexpro' ); ?>
                </label>
                <p class="description"><?php esc_html_e( 'Пост будет отображаться в секции featured posts', 'yandexpro' ); ?></p>
            </td>
        </tr>
    </table>
    
    <?php
}

/**
 * Сохранение мета-полей
 */
function yandexpro_save_meta_boxes( $post_id ) {
    // Проверяем nonce и права доступа
    if ( ! isset( $_POST['yandexpro_landing_meta_box_nonce'] ) && 
         ! isset( $_POST['yandexpro_page_meta_box_nonce'] ) && 
         ! isset( $_POST['yandexpro_post_meta_box_nonce'] ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Сохраняем мета-поля лендинга
    if ( isset( $_POST['yandexpro_landing_meta_box_nonce'] ) && 
         wp_verify_nonce( $_POST['yandexpro_landing_meta_box_nonce'], 'yandexpro_landing_meta_box' ) ) {
        
        $fields = yandexpro_get_landing_fields();
        
        foreach ( $fields as $field => $config ) {
            $value = $_POST[ $field ] ?? '';
            
            // Санитизация в зависимости от типа поля
            switch ( $config['type'] ) {
                case 'url':
                    $value = esc_url_raw( $value );
                    break;
                case 'email':
                    $value = sanitize_email( $value );
                    break;
                case 'textarea':
                    $value = sanitize_textarea_field( $value );
                    break;
                case 'checkbox':
                    $value = $value ? '1' : '';
                    break;
                default:
                    $value = sanitize_text_field( $value );
            }
            
            if ( $value ) {
                update_post_meta( $post_id, $field, $value );
            } else {
                delete_post_meta( $post_id, $field );
            }
        }
    }

    // Сохраняем мета-поля страницы
    if ( isset( $_POST['yandexpro_page_meta_box_nonce'] ) && 
         wp_verify_nonce( $_POST['yandexpro_page_meta_box_nonce'], 'yandexpro_page_meta_box' ) ) {
        
        $page_fields = array(
            '_yandexpro_fullwidth' => 'checkbox',
            '_yandexpro_show_share' => 'checkbox', 
            '_yandexpro_show_cta' => 'checkbox',
        );
        
        foreach ( $page_fields as $field => $type ) {
            $value = $_POST[ $field ] ?? '';
            
            if ( $type === 'checkbox' ) {
                $value = $value ? '1' : '';
            }
            
            if ( $value ) {
                update_post_meta( $post_id, $field, $value );
            } else {
                delete_post_meta( $post_id, $field );
            }
        }
    }

    // Сохраняем мета-поля поста
    if ( isset( $_POST['yandexpro_post_meta_box_nonce'] ) && 
         wp_verify_nonce( $_POST['yandexpro_post_meta_box_nonce'], 'yandexpro_post_meta_box' ) ) {
        
        $featured = $_POST['featured_post'] ?? '';
        $featured = $featured ? '1' : '';
        
        if ( $featured ) {
            update_post_meta( $post_id, 'featured_post', $featured );
        } else {
            delete_post_meta( $post_id, 'featured_post' );
        }
    }
}
add_action( 'save_post', 'yandexpro_save_meta_boxes' );

/**
 * Получение всех полей лендинга для обработки
 */
function yandexpro_get_landing_fields() {
    return array(
        // Hero
        '_yandexpro_hero_title' => array( 'type' => 'textarea' ),
        '_yandexpro_hero_subtitle' => array( 'type' => 'textarea' ),
        '_yandexpro_hero_button_text' => array( 'type' => 'text' ),
        '_yandexpro_hero_button_url' => array( 'type' => 'url' ),
        '_yandexpro_hero_secondary_text' => array( 'type' => 'text' ),
        '_yandexpro_hero_secondary_url' => array( 'type' => 'url' ),
        
        // Features
        '_yandexpro_show_features' => array( 'type' => 'checkbox' ),
        '_yandexpro_features_title' => array( 'type' => 'text' ),
        '_yandexpro_features_subtitle' => array( 'type' => 'text' ),
        
        // Services
        '_yandexpro_show_services' => array( 'type' => 'checkbox' ),
        '_yandexpro_services_title' => array( 'type' => 'text' ),
        '_yandexpro_services_subtitle' => array( 'type' => 'text' ),
        
        // Testimonials
        '_yandexpro_show_testimonials' => array( 'type' => 'checkbox' ),
        '_yandexpro_testimonials_title' => array( 'type' => 'text' ),
        
        // Stats
        '_yandexpro_show_stats' => array( 'type' => 'checkbox' ),
        
        // Blog
        '_yandexpro_show_blog' => array( 'type' => 'checkbox' ),
        '_yandexpro_blog_title' => array( 'type' => 'text' ),
        '_yandexpro_blog_subtitle' => array( 'type' => 'text' ),
        
        // CTA
        '_yandexpro_show_contact_cta' => array( 'type' => 'checkbox' ),
        '_yandexpro_cta_title' => array( 'type' => 'text' ),
        '_yandexpro_cta_description' => array( 'type' => 'textarea' ),
        '_yandexpro_cta_button_text' => array( 'type' => 'text' ),
        '_yandexpro_cta_button_url' => array( 'type' => 'url' ),
        '_yandexpro_cta_phone' => array( 'type' => 'text' ),
    );
    
    // Добавляем повторяющиеся поля
    $fields = array();
    
    // Features (6 штук)
    for ( $i = 1; $i <= 6; $i++ ) {
        $fields["_yandexpro_feature_{$i}_icon"] = array( 'type' => 'text' );
        $fields["_yandexpro_feature_{$i}_title"] = array( 'type' => 'text' );
        $fields["_yandexpro_feature_{$i}_description"] = array( 'type' => 'textarea' );
    }
    
    // Services (4 штуки)
    for ( $i = 1; $i <= 4; $i++ ) {
        $fields["_yandexpro_service_{$i}_title"] = array( 'type' => 'text' );
        $fields["_yandexpro_service_{$i}_price"] = array( 'type' => 'text' );
        $fields["_yandexpro_service_{$i}_description"] = array( 'type' => 'textarea' );
        $fields["_yandexpro_service_{$i}_features"] = array( 'type' => 'textarea' );
        $fields["_yandexpro_service_{$i}_link"] = array( 'type' => 'url' );
    }
    
    // Testimonials (3 штуки)
    for ( $i = 1; $i <= 3; $i++ ) {
        $fields["_yandexpro_testimonial_{$i}_text"] = array( 'type' => 'textarea' );
        $fields["_yandexpro_testimonial_{$i}_author"] = array( 'type' => 'text' );
        $fields["_yandexpro_testimonial_{$i}_company"] = array( 'type' => 'text' );
        $fields["_yandexpro_testimonial_{$i}_avatar"] = array( 'type' => 'url' );
    }
    
    // Stats (4 штуки)
    for ( $i = 1; $i <= 4; $i++ ) {
        $fields["_yandexpro_stat_{$i}_number"] = array( 'type' => 'text' );
        $fields["_yandexpro_stat_{$i}_suffix"] = array( 'type' => 'text' );
        $fields["_yandexpro_stat_{$i}_label"] = array( 'type' => 'text' );
    }
    
    return array_merge( yandexpro_get_base_landing_fields(), $fields );
}

/**
 * Базовые поля лендинга
 */
function yandexpro_get_base_landing_fields() {
    return array(
        // Hero
        '_yandexpro_hero_title' => array( 'type' => 'textarea' ),
        '_yandexpro_hero_subtitle' => array( 'type' => 'textarea' ),
        '_yandexpro_hero_button_text' => array( 'type' => 'text' ),
        '_yandexpro_hero_button_url' => array( 'type' => 'url' ),
        '_yandexpro_hero_secondary_text' => array( 'type' => 'text' ),
        '_yandexpro_hero_secondary_url' => array( 'type' => 'url' ),
        
        // Features
        '_yandexpro_show_features' => array( 'type' => 'checkbox' ),
        '_yandexpro_features_title' => array( 'type' => 'text' ),
        '_yandexpro_features_subtitle' => array( 'type' => 'text' ),
        
        // Services
        '_yandexpro_show_services' => array( 'type' => 'checkbox' ),
        '_yandexpro_services_title' => array( 'type' => 'text' ),
        '_yandexpro_services_subtitle' => array( 'type' => 'text' ),
        
        // Testimonials
        '_yandexpro_show_testimonials' => array( 'type' => 'checkbox' ),
        '_yandexpro_testimonials_title' => array( 'type' => 'text' ),
        
        // Stats
        '_yandexpro_show_stats' => array( 'type' => 'checkbox' ),
        
        // Blog
        '_yandexpro_show_blog' => array( 'type' => 'checkbox' ),
        '_yandexpro_blog_title' => array( 'type' => 'text' ),
        '_yandexpro_blog_subtitle' => array( 'type' => 'text' ),
        
        // CTA
        '_yandexpro_show_contact_cta' => array( 'type' => 'checkbox' ),
        '_yandexpro_cta_title' => array( 'type' => 'text' ),
        '_yandexpro_cta_description' => array( 'type' => 'textarea' ),
        '_yandexpro_cta_button_text' => array( 'type' => 'text' ),
        '_yandexpro_cta_button_url' => array( 'type' => 'url' ),
        '_yandexpro_cta_phone' => array( 'type' => 'text' ),
    );
}

/**
 * Подключение стилей и скриптов для админки
 */
function yandexpro_admin_enqueue_scripts( $hook ) {
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }
    
    wp_enqueue_media();
    wp_enqueue_script( 'jquery' );
}
add_action( 'admin_enqueue_scripts', 'yandexpro_admin_enqueue_scripts' );<label for="yandexpro_hero_title"><?php esc_html_e( 'Заголовок Hero', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <textarea id="yandexpro_hero_title" name="_yandexpro_hero_title" rows="3" class="large-text"><?php echo esc_textarea( $values['_yandexpro_hero_title'] ?? '' ); ?></textarea>
                        <p class="description"><?php esc_html_e( 'Можно использовать HTML теги для стилизации', 'yandexpro' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_hero_subtitle"><?php esc_html_e( 'Описание Hero', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <textarea id="yandexpro_hero_subtitle" name="_yandexpro_hero_subtitle" rows="3" class="large-text"><?php echo esc_textarea( $values['_yandexpro_hero_subtitle'] ?? '' ); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_hero_button_text"><?php esc_html_e( 'Текст основной кнопки', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_hero_button_text" name="_yandexpro_hero_button_text" value="<?php echo esc_attr( $values['_yandexpro_hero_button_text'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_hero_button_url"><?php esc_html_e( 'Ссылка основной кнопки', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="yandexpro_hero_button_url" name="_yandexpro_hero_button_url" value="<?php echo esc_url( $values['_yandexpro_hero_button_url'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_hero_secondary_text"><?php esc_html_e( 'Текст дополнительной кнопки', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_hero_secondary_text" name="_yandexpro_hero_secondary_text" value="<?php echo esc_attr( $values['_yandexpro_hero_secondary_text'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_hero_secondary_url"><?php esc_html_e( 'Ссылка дополнительной кнопки', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="url" id="yandexpro_hero_secondary_url" name="_yandexpro_hero_secondary_url" value="<?php echo esc_url( $values['_yandexpro_hero_secondary_url'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
            </table>
        </div>

        <!-- Features Tab -->
        <div id="tab-features" class="tab-content">
            <h3><?php esc_html_e( 'Секция преимуществ', 'yandexpro' ); ?></h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="yandexpro_show_features"><?php esc_html_e( 'Показывать секцию', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="yandexpro_show_features" name="_yandexpro_show_features" value="1" <?php checked( $values['_yandexpro_show_features'] ?? '', '1' ); ?>>
                        <label for="yandexpro_show_features"><?php esc_html_e( 'Включить секцию преимуществ', 'yandexpro' ); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_features_title"><?php esc_html_e( 'Заголовок секции', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_features_title" name="_yandexpro_features_title" value="<?php echo esc_attr( $values['_yandexpro_features_title'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_features_subtitle"><?php esc_html_e( 'Подзаголовок секции', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_features_subtitle" name="_yandexpro_features_subtitle" value="<?php echo esc_attr( $values['_yandexpro_features_subtitle'] ?? '' ); ?>" class="large-text">
                    </td>
                </tr>
            </table>

            <h4><?php esc_html_e( 'Преимущества (до 6 штук)', 'yandexpro' ); ?></h4>
            
            <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
                <div class="feature-group" style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 4px;">
                    <h5><?php printf( esc_html__( 'Преимущество %d', 'yandexpro' ), $i ); ?></h5>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_feature_<?php echo $i; ?>_icon"><?php esc_html_e( 'Иконка', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_feature_<?php echo $i; ?>_icon" name="_yandexpro_feature_<?php echo $i; ?>_icon" value="<?php echo esc_attr( $values["_yandexpro_feature_{$i}_icon"] ?? '' ); ?>" class="regular-text">
                                <p class="description"><?php esc_html_e( 'Emoji (🚀) или URL изображения', 'yandexpro' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_feature_<?php echo $i; ?>_title"><?php esc_html_e( 'Заголовок', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_feature_<?php echo $i; ?>_title" name="_yandexpro_feature_<?php echo $i; ?>_title" value="<?php echo esc_attr( $values["_yandexpro_feature_{$i}_title"] ?? '' ); ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_feature_<?php echo $i; ?>_description"><?php esc_html_e( 'Описание', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <textarea id="yandexpro_feature_<?php echo $i; ?>_description" name="_yandexpro_feature_<?php echo $i; ?>_description" rows="3" class="large-text"><?php echo esc_textarea( $values["_yandexpro_feature_{$i}_description"] ?? '' ); ?></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Services Tab -->
        <div id="tab-services" class="tab-content">
            <h3><?php esc_html_e( 'Секция услуг', 'yandexpro' ); ?></h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="yandexpro_show_services"><?php esc_html_e( 'Показывать секцию', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="yandexpro_show_services" name="_yandexpro_show_services" value="1" <?php checked( $values['_yandexpro_show_services'] ?? '', '1' ); ?>>
                        <label for="yandexpro_show_services"><?php esc_html_e( 'Включить секцию услуг', 'yandexpro' ); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_services_title"><?php esc_html_e( 'Заголовок секции', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_services_title" name="_yandexpro_services_title" value="<?php echo esc_attr( $values['_yandexpro_services_title'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_services_subtitle"><?php esc_html_e( 'Подзаголовок секции', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_services_subtitle" name="_yandexpro_services_subtitle" value="<?php echo esc_attr( $values['_yandexpro_services_subtitle'] ?? '' ); ?>" class="large-text">
                    </td>
                </tr>
            </table>

            <h4><?php esc_html_e( 'Услуги (до 4 штук)', 'yandexpro' ); ?></h4>
            
            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                <div class="service-group" style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 4px;">
                    <h5><?php printf( esc_html__( 'Услуга %d', 'yandexpro' ), $i ); ?></h5>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_service_<?php echo $i; ?>_title"><?php esc_html_e( 'Название услуги', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_service_<?php echo $i; ?>_title" name="_yandexpro_service_<?php echo $i; ?>_title" value="<?php echo esc_attr( $values["_yandexpro_service_{$i}_title"] ?? '' ); ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_service_<?php echo $i; ?>_price"><?php esc_html_e( 'Цена', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_service_<?php echo $i; ?>_price" name="_yandexpro_service_<?php echo $i; ?>_price" value="<?php echo esc_attr( $values["_yandexpro_service_{$i}_price"] ?? '' ); ?>" class="regular-text">
                                <p class="description"><?php esc_html_e( 'Например: "от 15 000 ₽"', 'yandexpro' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_service_<?php echo $i; ?>_description"><?php esc_html_e( 'Описание', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <textarea id="yandexpro_service_<?php echo $i; ?>_description" name="_yandexpro_service_<?php echo $i; ?>_description" rows="3" class="large-text"><?php echo esc_textarea( $values["_yandexpro_service_{$i}_description"] ?? '' ); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_service_<?php echo $i; ?>_features"><?php esc_html_e( 'Особенности', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <textarea id="yandexpro_service_<?php echo $i; ?>_features" name="_yandexpro_service_<?php echo $i; ?>_features" rows="5" class="large-text"><?php echo esc_textarea( $values["_yandexpro_service_{$i}_features"] ?? '' ); ?></textarea>
                                <p class="description"><?php esc_html_e( 'Каждая особенность с новой строки', 'yandexpro' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_service_<?php echo $i; ?>_link"><?php esc_html_e( 'Ссылка', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="url" id="yandexpro_service_<?php echo $i; ?>_link" name="_yandexpro_service_<?php echo $i; ?>_link" value="<?php echo esc_url( $values["_yandexpro_service_{$i}_link"] ?? '' ); ?>" class="regular-text">
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Testimonials Tab -->
        <div id="tab-testimonials" class="tab-content">
            <h3><?php esc_html_e( 'Секция отзывов', 'yandexpro' ); ?></h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="yandexpro_show_testimonials"><?php esc_html_e( 'Показывать секцию', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="yandexpro_show_testimonials" name="_yandexpro_show_testimonials" value="1" <?php checked( $values['_yandexpro_show_testimonials'] ?? '', '1' ); ?>>
                        <label for="yandexpro_show_testimonials"><?php esc_html_e( 'Включить секцию отзывов', 'yandexpro' ); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="yandexpro_testimonials_title"><?php esc_html_e( 'Заголовок секции', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="yandexpro_testimonials_title" name="_yandexpro_testimonials_title" value="<?php echo esc_attr( $values['_yandexpro_testimonials_title'] ?? '' ); ?>" class="regular-text">
                    </td>
                </tr>
            </table>

            <h4><?php esc_html_e( 'Отзывы (до 3 штук)', 'yandexpro' ); ?></h4>
            
            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                <div class="testimonial-group" style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 4px;">
                    <h5><?php printf( esc_html__( 'Отзыв %d', 'yandexpro' ), $i ); ?></h5>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_testimonial_<?php echo $i; ?>_text"><?php esc_html_e( 'Текст отзыва', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <textarea id="yandexpro_testimonial_<?php echo $i; ?>_text" name="_yandexpro_testimonial_<?php echo $i; ?>_text" rows="4" class="large-text"><?php echo esc_textarea( $values["_yandexpro_testimonial_{$i}_text"] ?? '' ); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_testimonial_<?php echo $i; ?>_author"><?php esc_html_e( 'Имя автора', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_testimonial_<?php echo $i; ?>_author" name="_yandexpro_testimonial_<?php echo $i; ?>_author" value="<?php echo esc_attr( $values["_yandexpro_testimonial_{$i}_author"] ?? '' ); ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_testimonial_<?php echo $i; ?>_company"><?php esc_html_e( 'Компания', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_testimonial_<?php echo $i; ?>_company" name="_yandexpro_testimonial_<?php echo $i; ?>_company" value="<?php echo esc_attr( $values["_yandexpro_testimonial_{$i}_company"] ?? '' ); ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_testimonial_<?php echo $i; ?>_avatar"><?php esc_html_e( 'Аватар (URL)', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="url" id="yandexpro_testimonial_<?php echo $i; ?>_avatar" name="_yandexpro_testimonial_<?php echo $i; ?>_avatar" value="<?php echo esc_url( $values["_yandexpro_testimonial_{$i}_avatar"] ?? '' ); ?>" class="regular-text">
                                <button type="button" class="button upload-avatar-button" data-target="yandexpro_testimonial_<?php echo $i; ?>_avatar"><?php esc_html_e( 'Выбрать изображение', 'yandexpro' ); ?></button>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Statistics Tab -->
        <div id="tab-stats" class="tab-content">
            <h3><?php esc_html_e( 'Секция статистики', 'yandexpro' ); ?></h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="yandexpro_show_stats"><?php esc_html_e( 'Показывать секцию', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="yandexpro_show_stats" name="_yandexpro_show_stats" value="1" <?php checked( $values['_yandexpro_show_stats'] ?? '', '1' ); ?>>
                        <label for="yandexpro_show_stats"><?php esc_html_e( 'Включить секцию статистики', 'yandexpro' ); ?></label>
                    </td>
                </tr>
            </table>

            <h4><?php esc_html_e( 'Статистика (до 4 показателей)', 'yandexpro' ); ?></h4>
            
            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                <div class="stat-group" style="border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 4px;">
                    <h5><?php printf( esc_html__( 'Показатель %d', 'yandexpro' ), $i ); ?></h5>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_stat_<?php echo $i; ?>_number"><?php esc_html_e( 'Число', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_stat_<?php echo $i; ?>_number" name="_yandexpro_stat_<?php echo $i; ?>_number" value="<?php echo esc_attr( $values["_yandexpro_stat_{$i}_number"] ?? '' ); ?>" class="regular-text">
                                <p class="description"><?php esc_html_e( 'Например: "500", "1.2K", "99"', 'yandexpro' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_stat_<?php echo $i; ?>_suffix"><?php esc_html_e( 'Суффикс', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_stat_<?php echo $i; ?>_suffix" name="_yandexpro_stat_<?php echo $i; ?>_suffix" value="<?php echo esc_attr( $values["_yandexpro_stat_{$i}_suffix"] ?? '' ); ?>" class="regular-text">
                                <p class="description"><?php esc_html_e( 'Например: "+", "%", "₽"', 'yandexpro' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="yandexpro_stat_<?php echo $i; ?>_label"><?php esc_html_e( 'Подпись', 'yandexpro' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="yandexpro_stat_<?php echo $i; ?>_label" name="_yandexpro_stat_<?php echo $i; ?>_label" value="<?php echo esc_attr( $values["_yandexpro_stat_{$i}_label"] ?? '' ); ?>" class="regular-text">
                                <p class="description"><?php esc_html_e( 'Например: "Довольных клиентов"', 'yandexpro' ); ?></p>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endfor; ?>
        </div>

        <!-- CTA Tab -->
        <div id="tab-cta" class="tab-content">
            <h3><?php esc_html_e( 'Призыв к действию', 'yandexpro' ); ?></h3>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="yandexpro_show_contact_cta"><?php esc_html_e( 'Показывать секцию', 'yandexpro' ); ?></label>
                    </th>
                    <td>
                        <input type="checkbox" id="yandexpro_show_contact_cta" name="_yandexpro_show_contact_cta" value="1" <?php checked( $values['_yandexpro_show_contact_cta'] ?? '', '1' ); ?>>
                        <label for="yandexpro_show_contact_cta"><?php esc_html_e( 'Включить секцию CTA', 'yandexpro' ); ?></label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">