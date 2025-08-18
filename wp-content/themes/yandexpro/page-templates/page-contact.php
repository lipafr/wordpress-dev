<?php
/**
 * Template Name: Страница контактов
 * 
 * Специальный шаблон для страницы контактов
 * с формой обратной связи и контактной информацией
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

<!-- Page Header -->
<section class="contact-hero">
    <div class="container">
        <div class="contact-hero-content">
            <?php while ( have_posts() ) : the_post(); ?>
                <h1 class="contact-title"><?php the_title(); ?></h1>
                
                <?php if ( get_the_content() ) : ?>
                    <div class="contact-description">
                        <?php the_content(); ?>
                    </div>
                <?php else : ?>
                    <p class="contact-description">
                        <?php esc_html_e( 'Свяжитесь с нами любым удобным способом. Мы ответим в течение 24 часов.', 'yandexpro' ); ?>
                    </p>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Main Contact Content -->
<section class="contact-content">
    <div class="container">
        <div class="contact-wrapper">
            
            <!-- Contact Form -->
            <div class="contact-form-section">
                <h2 class="contact-form-title">
                    <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_contact_form_title', true ) ?: __( 'Отправьте сообщение', 'yandexpro' ) ); ?>
                </h2>
                
                <p class="contact-form-description">
                    <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_contact_form_description', true ) ?: __( 'Заполните форму ниже, и мы свяжемся с вами в ближайшее время.', 'yandexpro' ) ); ?>
                </p>

                <!-- Contact Form 7 Integration -->
                <?php 
                $cf7_shortcode = get_post_meta( get_the_ID(), '_yandexpro_contact_cf7_shortcode', true );
                if ( $cf7_shortcode && shortcode_exists( 'contact-form-7' ) ) :
                    echo do_shortcode( $cf7_shortcode );
                else :
                ?>
                    <!-- Native Contact Form -->
                    <form class="contact-form" id="yandexpro-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" novalidate>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-name" class="form-label">
                                    <?php esc_html_e( 'Ваше имя', 'yandexpro' ); ?>
                                    <span class="required" aria-label="<?php esc_attr_e( 'Обязательное поле', 'yandexpro' ); ?>">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="contact-name" 
                                    name="contact_name" 
                                    class="form-input" 
                                    required 
                                    aria-describedby="name-error"
                                    autocomplete="name"
                                >
                                <div id="name-error" class="error-message" role="alert"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-email" class="form-label">
                                    <?php esc_html_e( 'Email', 'yandexpro' ); ?>
                                    <span class="required" aria-label="<?php esc_attr_e( 'Обязательное поле', 'yandexpro' ); ?>">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="contact-email" 
                                    name="contact_email" 
                                    class="form-input" 
                                    required 
                                    aria-describedby="email-error"
                                    autocomplete="email"
                                >
                                <div id="email-error" class="error-message" role="alert"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact-phone" class="form-label">
                                    <?php esc_html_e( 'Телефон', 'yandexpro' ); ?>
                                </label>
                                <input 
                                    type="tel" 
                                    id="contact-phone" 
                                    name="contact_phone" 
                                    class="form-input" 
                                    aria-describedby="phone-error"
                                    autocomplete="tel"
                                >
                                <div id="phone-error" class="error-message" role="alert"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="contact-company" class="form-label">
                                    <?php esc_html_e( 'Компания', 'yandexpro' ); ?>
                                </label>
                                <input 
                                    type="text" 
                                    id="contact-company" 
                                    name="contact_company" 
                                    class="form-input"
                                    autocomplete="organization"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact-subject" class="form-label">
                                <?php esc_html_e( 'Тема сообщения', 'yandexpro' ); ?>
                            </label>
                            <select id="contact-subject" name="contact_subject" class="form-select">
                                <option value=""><?php esc_html_e( 'Выберите тему', 'yandexpro' ); ?></option>
                                <option value="consultation"><?php esc_html_e( 'Консультация', 'yandexpro' ); ?></option>
                                <option value="yandex-direct"><?php esc_html_e( 'Яндекс Директ', 'yandexpro' ); ?></option>
                                <option value="google-ads"><?php esc_html_e( 'Google Ads', 'yandexpro' ); ?></option>
                                <option value="analytics"><?php esc_html_e( 'Аналитика', 'yandexpro' ); ?></option>
                                <option value="audit"><?php esc_html_e( 'Аудит рекламы', 'yandexpro' ); ?></option>
                                <option value="other"><?php esc_html_e( 'Другое', 'yandexpro' ); ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="contact-message" class="form-label">
                                <?php esc_html_e( 'Сообщение', 'yandexpro' ); ?>
                                <span class="required" aria-label="<?php esc_attr_e( 'Обязательное поле', 'yandexpro' ); ?>">*</span>
                            </label>
                            <textarea 
                                id="contact-message" 
                                name="contact_message" 
                                class="form-textarea" 
                                rows="5" 
                                required 
                                aria-describedby="message-error"
                                placeholder="<?php esc_attr_e( 'Расскажите подробнее о вашей задаче...', 'yandexpro' ); ?>"
                            ></textarea>
                            <div id="message-error" class="error-message" role="alert"></div>
                        </div>

                        <!-- Privacy Policy Checkbox -->
                        <div class="form-group form-checkbox-group">
                            <label class="checkbox-label">
                                <input 
                                    type="checkbox" 
                                    id="contact-privacy" 
                                    name="contact_privacy" 
                                    class="form-checkbox" 
                                    required
                                    aria-describedby="privacy-error"
                                >
                                <span class="checkbox-custom" aria-hidden="true"></span>
                                <span class="checkbox-text">
                                    <?php
                                    printf(
                                        /* translators: %s: Privacy policy link */
                                        esc_html__( 'Я согласен с %s и даю согласие на обработку персональных данных', 'yandexpro' ),
                                        '<a href="' . esc_url( get_privacy_policy_url() ) . '" target="_blank">' . esc_html__( 'политикой конфиденциальности', 'yandexpro' ) . '</a>'
                                    );
                                    ?>
                                    <span class="required" aria-label="<?php esc_attr_e( 'Обязательное поле', 'yandexpro' ); ?>">*</span>
                                </span>
                            </label>
                            <div id="privacy-error" class="error-message" role="alert"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-submit">
                            <button type="submit" class="button button-primary form-submit-btn">
                                <span class="button-text"><?php esc_html_e( 'Отправить сообщение', 'yandexpro' ); ?></span>
                                <span class="button-spinner" aria-hidden="true"></span>
                            </button>
                        </div>

                        <!-- Form Messages -->
                        <div id="form-messages" class="form-messages" role="alert" aria-live="polite"></div>

                        <!-- Hidden Fields -->
                        <?php wp_nonce_field( 'yandexpro_contact_form', 'contact_nonce' ); ?>
                        <input type="hidden" name="action" value="yandexpro_contact_form">
                        <input type="hidden" name="contact_page_url" value="<?php echo esc_url( get_permalink() ); ?>">
                    </form>
                <?php endif; ?>
            </div>

            <!-- Contact Information -->
            <div class="contact-info-section">
                <h2 class="contact-info-title">
                    <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_contact_info_title', true ) ?: __( 'Контактная информация', 'yandexpro' ) ); ?>
                </h2>

                <div class="contact-info-list">
                    <!-- Email -->
                    <?php 
                    $contact_email = get_theme_mod( 'contact_email' ) ?: get_post_meta( get_the_ID(), '_yandexpro_contact_email', true );
                    if ( $contact_email ) :
                    ?>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <h3 class="contact-info-label"><?php esc_html_e( 'Email', 'yandexpro' ); ?></h3>
                                <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" class="contact-info-value">
                                    <?php echo esc_html( $contact_email ); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Phone -->
                    <?php 
                    $contact_phone = get_theme_mod( 'contact_phone' ) ?: get_post_meta( get_the_ID(), '_yandexpro_contact_phone', true );
                    if ( $contact_phone ) :
                    ?>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <h3 class="contact-info-label"><?php esc_html_e( 'Телефон', 'yandexpro' ); ?></h3>
                                <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $contact_phone ) ); ?>" class="contact-info-value">
                                    <?php echo esc_html( $contact_phone ); ?>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Address -->
                    <?php 
                    $contact_address = get_theme_mod( 'contact_address' ) ?: get_post_meta( get_the_ID(), '_yandexpro_contact_address', true );
                    if ( $contact_address ) :
                    ?>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <h3 class="contact-info-label"><?php esc_html_e( 'Адрес', 'yandexpro' ); ?></h3>
                                <span class="contact-info-value">
                                    <?php echo esc_html( $contact_address ); ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Working Hours -->
                    <?php 
                    $working_hours = get_post_meta( get_the_ID(), '_yandexpro_working_hours', true );
                    if ( $working_hours ) :
                    ?>
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z" fill="currentColor"/>
                                </svg>
                            </div>
                            <div class="contact-info-content">
                                <h3 class="contact-info-label"><?php esc_html_e( 'Время работы', 'yandexpro' ); ?></h3>
                                <span class="contact-info-value">
                                    <?php echo esc_html( $working_hours ); ?>
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Social Links -->
                <?php if ( get_theme_mod( 'enable_social_links', false ) ) : ?>
                    <div class="contact-social">
                        <h3 class="contact-social-title"><?php esc_html_e( 'Мы в социальных сетях', 'yandexpro' ); ?></h3>
                        <div class="contact-social-links">
                            <?php yandexpro_social_links(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div><!-- .contact-wrapper -->
    </div><!-- .container -->
</section>

<!-- FAQ Section (если есть) -->
<?php if ( get_post_meta( get_the_ID(), '_yandexpro_show_faq', true ) ) : ?>
    <section class="contact-faq">
        <div class="container">
            <h2 class="faq-title">
                <?php echo esc_html( get_post_meta( get_the_ID(), '_yandexpro_faq_title', true ) ?: __( 'Часто задаваемые вопросы', 'yandexpro' ) ); ?>
            </h2>

            <div class="faq-list">
                <?php
                for ( $i = 1; $i <= 5; $i++ ) {
                    $faq_question = get_post_meta( get_the_ID(), "_yandexpro_faq_{$i}_question", true );
                    $faq_answer = get_post_meta( get_the_ID(), "_yandexpro_faq_{$i}_answer", true );
                    
                    if ( $faq_question && $faq_answer ) :
                ?>
                    <div class="faq-item">
                        <button class="faq-question" type="button" aria-expanded="false" aria-controls="faq-answer-<?php echo $i; ?>">
                            <span class="faq-question-text"><?php echo esc_html( $faq_question ); ?></span>
                            <span class="faq-toggle" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </button>
                        <div id="faq-answer-<?php echo $i; ?>" class="faq-answer" aria-hidden="true">
                            <div class="faq-answer-content">
                                <?php echo wp_kses_post( wpautop( $faq_answer ) ); ?>
                            </div>
                        </div>
                    </div>
                <?php 
                    endif;
                }
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Map Section (если указан адрес) -->
<?php if ( get_post_meta( get_the_ID(), '_yandexpro_show_map', true ) && $contact_address ) : ?>
    <section class="contact-map">
        <div class="container">
            <h2 class="map-title"><?php esc_html_e( 'Как нас найти', 'yandexpro' ); ?></h2>
        </div>
        
        <div class="map-container">
            <?php
            $map_embed = get_post_meta( get_the_ID(), '_yandexpro_map_embed', true );
            if ( $map_embed ) :
                echo wp_kses_post( $map_embed );
            else :
                // Fallback to simple address display
                echo '<div class="map-placeholder">';
                echo '<p>' . esc_html( $contact_address ) . '</p>';
                echo '<p class="map-placeholder-note">' . esc_html__( 'Добавьте код встраивания карты в настройках страницы', 'yandexpro' ) . '</p>';
                echo '</div>';
            endif;
            ?>
        </div>
    </section>
<?php endif; ?>

<?php
get_footer();

/**
 * AJAX обработчик формы обратной связи
 */
function yandexpro_handle_contact_form() {
    // Проверка nonce
    if ( ! wp_verify_nonce( $_POST['contact_nonce'] ?? '', 'yandexpro_contact_form' ) ) {
        wp_die( json_encode( array( 'success' => false, 'message' => __( 'Ошибка безопасности', 'yandexpro' ) ) ) );
    }

    // Валидация данных
    $name = sanitize_text_field( $_POST['contact_name'] ?? '' );
    $email = sanitize_email( $_POST['contact_email'] ?? '' );
    $phone = sanitize_text_field( $_POST['contact_phone'] ?? '' );
    $company = sanitize_text_field( $_POST['contact_company'] ?? '' );
    $subject = sanitize_text_field( $_POST['contact_subject'] ?? '' );
    $message = sanitize_textarea_field( $_POST['contact_message'] ?? '' );
    $privacy = $_POST['contact_privacy'] ?? '';
    $page_url = esc_url_raw( $_POST['contact_page_url'] ?? '' );

    $errors = array();

    if ( empty( $name ) ) {
        $errors['name'] = __( 'Имя обязательно для заполнения', 'yandexpro' );
    }

    if ( empty( $email ) || ! is_email( $email ) ) {
        $errors['email'] = __( 'Введите корректный email', 'yandexpro' );
    }

    if ( empty( $message ) ) {
        $errors['message'] = __( 'Сообщение обязательно для заполнения', 'yandexpro' );
    }

    if ( empty( $privacy ) ) {
        $errors['privacy'] = __( 'Необходимо согласие с политикой конфиденциальности', 'yandexpro' );
    }

    if ( ! empty( $errors ) ) {
        wp_die( json_encode( array( 'success' => false, 'errors' => $errors ) ) );
    }

    // Подготовка email
    $to = get_option( 'admin_email' );
    $email_subject = sprintf( 
        '[%s] %s', 
        get_bloginfo( 'name' ), 
        $subject ? $subject : __( 'Новое сообщение с сайта', 'yandexpro' )
    );

    $email_message = sprintf(
        __( "Новое сообщение с сайта %s\n\nИмя: %s\nEmail: %s\nТелефон: %s\nКомпания: %s\nТема: %s\n\nСообщение:\n%s\n\nСтраница: %s", 'yandexpro' ),
        get_bloginfo( 'name' ),
        $name,
        $email,
        $phone ?: __( 'не указан', 'yandexpro' ),
        $company ?: __( 'не указана', 'yandexpro' ),
        $subject ?: __( 'не указана', 'yandexpro' ),
        $message,
        $page_url
    );

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    // Отправка email
    $sent = wp_mail( $to, $email_subject, $email_message, $headers );

    if ( $sent ) {
        // Сохранение в БД (опционально)
        yandexpro_save_contact_submission( array(
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'company' => $company,
            'subject' => $subject,
            'message' => $message,
            'page_url' => $page_url,
            'ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
        ) );

        wp_die( json_encode( array( 
            'success' => true, 
            'message' => __( 'Спасибо! Ваше сообщение отправлено. Мы свяжемся с вами в ближайшее время.', 'yandexpro' )
        ) ) );
    } else {
        wp_die( json_encode( array( 
            'success' => false, 
            'message' => __( 'Произошла ошибка при отправке сообщения. Попробуйте еще раз.', 'yandexpro' )
        ) ) );
    }
}
add_action( 'wp_ajax_yandexpro_contact_form', 'yandexpro_handle_contact_form' );
add_action( 'wp_ajax_nopriv_yandexpro_contact_form', 'yandexpro_handle_contact_form' );

/**
 * Сохранение обращения в БД (опционально)
 */
function yandexpro_save_contact_submission( $data ) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yandexpro_contacts';
    
    // Создаем таблицу если не существует
    $wpdb->query( "CREATE TABLE IF NOT EXISTS {$table_name} (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(50) DEFAULT NULL,
        company varchar(255) DEFAULT NULL,
        subject varchar(255) DEFAULT NULL,
        message text NOT NULL,
        page_url varchar(500) DEFAULT NULL,
        ip varchar(45) DEFAULT NULL,
        user_agent text DEFAULT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4" );
    
    // Вставляем данные
    $wpdb->insert(
        $table_name,
        array(
            'name'       => $data['name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'company'    => $data['company'],
            'subject'    => $data['subject'],
            'message'    => $data['message'],
            'page_url'   => $data['page_url'],
            'ip'         => $data['ip'],
            'user_agent' => $data['user_agent'],
        ),
        array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' )
    );
}
?>