<?php
/**
 * Template Name: Лендинг
 * 
 * Full-width landing page template without sidebar
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<main id="primary" class="site-main landing-page" role="main">
    
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('landing-content'); ?>>
            
            <!-- Hero Section -->
            <?php if (get_theme_mod('yandexpro_landing_show_hero', true)) : ?>
                <section class="landing-hero">
                    <div class="hero-background">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="hero-image">
                                <?php 
                                the_post_thumbnail('full', array(
                                    'alt' => the_title_attribute(array('echo' => false)),
                                    'loading' => 'eager',
                                    'decoding' => 'sync'
                                )); 
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="hero-overlay"></div>
                    </div>
                    
                    <div class="container">
                        <div class="hero-content">
                            <header class="entry-header">
                                <?php the_title('<h1 class="entry-title hero-title">', '</h1>'); ?>
                                
                                <?php if (has_excerpt()) : ?>
                                    <div class="hero-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                            </header>

                            <?php 
                            $hero_button_text = get_post_meta(get_the_ID(), '_yandexpro_hero_button_text', true);
                            $hero_button_url = get_post_meta(get_the_ID(), '_yandexpro_hero_button_url', true);
                            
                            if ($hero_button_text && $hero_button_url) :
                            ?>
                                <div class="hero-actions">
                                    <a href="<?php echo esc_url($hero_button_url); ?>" class="btn btn-primary btn-large hero-button">
                                        <?php echo esc_html($hero_button_text); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Main Content -->
            <div class="landing-main-content">
                <?php if (!get_theme_mod('yandexpro_landing_show_hero', true)) : ?>
                    <div class="container">
                        <header class="entry-header page-header">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                        </header>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Страницы:', 'yandexpro'),
                        'after'  => '</div>',
                        'link_before' => '<span class="page-number">',
                        'link_after' => '</span>',
                    ));
                    ?>
                </div>
            </div>

            <!-- Call to Action Section -->
            <?php 
            $cta_title = get_post_meta(get_the_ID(), '_yandexpro_cta_title', true);
            $cta_content = get_post_meta(get_the_ID(), '_yandexpro_cta_content', true);
            $cta_button_text = get_post_meta(get_the_ID(), '_yandexpro_cta_button_text', true);
            $cta_button_url = get_post_meta(get_the_ID(), '_yandexpro_cta_button_url', true);
            
            if ($cta_title || $cta_content) :
            ?>
                <section class="landing-cta">
                    <div class="container">
                        <div class="cta-content">
                            <?php if ($cta_title) : ?>
                                <h2 class="cta-title"><?php echo esc_html($cta_title); ?></h2>
                            <?php endif; ?>
                            
                            <?php if ($cta_content) : ?>
                                <div class="cta-description">
                                    <?php echo wp_kses_post($cta_content); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($cta_button_text && $cta_button_url) : ?>
                                <div class="cta-actions">
                                    <a href="<?php echo esc_url($cta_button_url); ?>" class="btn btn-accent btn-large cta-button">
                                        <?php echo esc_html($cta_button_text); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Features Section -->
            <?php 
            $features = get_post_meta(get_the_ID(), '_yandexpro_features', true);
            if ($features && is_array($features)) :
            ?>
                <section class="landing-features">
                    <div class="container">
                        <?php
                        $features_title = get_post_meta(get_the_ID(), '_yandexpro_features_title', true);
                        if ($features_title) :
                        ?>
                            <h2 class="features-title"><?php echo esc_html($features_title); ?></h2>
                        <?php endif; ?>
                        
                        <div class="features-grid">
                            <?php foreach ($features as $feature) : ?>
                                <?php if (!empty($feature['title']) || !empty($feature['description'])) : ?>
                                    <div class="feature-item">
                                        <?php if (!empty($feature['icon'])) : ?>
                                            <div class="feature-icon">
                                                <?php echo wp_kses_post($feature['icon']); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($feature['title'])) : ?>
                                            <h3 class="feature-title"><?php echo esc_html($feature['title']); ?></h3>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($feature['description'])) : ?>
                                            <p class="feature-description"><?php echo wp_kses_post($feature['description']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Statistics Section -->
            <?php 
            $stats = get_post_meta(get_the_ID(), '_yandexpro_statistics', true);
            if ($stats && is_array($stats)) :
            ?>
                <section class="landing-statistics">
                    <div class="container">
                        <?php
                        $stats_title = get_post_meta(get_the_ID(), '_yandexpro_statistics_title', true);
                        if ($stats_title) :
                        ?>
                            <h2 class="statistics-title"><?php echo esc_html($stats_title); ?></h2>
                        <?php endif; ?>
                        
                        <div class="statistics-grid">
                            <?php foreach ($stats as $stat) : ?>
                                <?php if (!empty($stat['number']) || !empty($stat['label'])) : ?>
                                    <div class="statistic-item">
                                        <?php if (!empty($stat['number'])) : ?>
                                            <div class="stat-number"><?php echo esc_html($stat['number']); ?></div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($stat['label'])) : ?>
                                            <div class="stat-label"><?php echo esc_html($stat['label']); ?></div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($stat['description'])) : ?>
                                            <div class="stat-description"><?php echo wp_kses_post($stat['description']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Testimonials Section -->
            <?php 
            $testimonials = get_post_meta(get_the_ID(), '_yandexpro_testimonials', true);
            if ($testimonials && is_array($testimonials)) :
            ?>
                <section class="landing-testimonials">
                    <div class="container">
                        <?php
                        $testimonials_title = get_post_meta(get_the_ID(), '_yandexpro_testimonials_title', true);
                        if ($testimonials_title) :
                        ?>
                            <h2 class="testimonials-title"><?php echo esc_html($testimonials_title); ?></h2>
                        <?php endif; ?>
                        
                        <div class="testimonials-grid">
                            <?php foreach ($testimonials as $testimonial) : ?>
                                <?php if (!empty($testimonial['content'])) : ?>
                                    <div class="testimonial-item">
                                        <blockquote class="testimonial-content">
                                            <?php echo wp_kses_post($testimonial['content']); ?>
                                        </blockquote>
                                        
                                        <footer class="testimonial-footer">
                                            <?php if (!empty($testimonial['author'])) : ?>
                                                <cite class="testimonial-author"><?php echo esc_html($testimonial['author']); ?></cite>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($testimonial['position'])) : ?>
                                                <span class="testimonial-position"><?php echo esc_html($testimonial['position']); ?></span>
                                            <?php endif; ?>
                                        </footer>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Contact Form Section -->
            <?php if (get_post_meta(get_the_ID(), '_yandexpro_show_contact_form', true)) : ?>
                <section class="landing-contact">
                    <div class="container">
                        <?php
                        $contact_title = get_post_meta(get_the_ID(), '_yandexpro_contact_title', true);
                        $contact_description = get_post_meta(get_the_ID(), '_yandexpro_contact_description', true);
                        ?>
                        
                        <?php if ($contact_title) : ?>
                            <h2 class="contact-title"><?php echo esc_html($contact_title); ?></h2>
                        <?php endif; ?>
                        
                        <?php if ($contact_description) : ?>
                            <div class="contact-description">
                                <?php echo wp_kses_post($contact_description); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="contact-form-container">
                            <?php yandexpro_landing_contact_form(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Footer -->
            <footer class="entry-footer">
                <?php
                edit_post_link(
                    sprintf(
                        wp_kses(
                            __('Редактировать <span class="screen-reader-text">%s</span>', 'yandexpro'),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        wp_kses_post(get_the_title())
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
                ?>
            </footer>
        </article>

    <?php endwhile; ?>

</main>

<?php
get_footer();

/**
 * Landing page contact form
 */
if (!function_exists('yandexpro_landing_contact_form')) {
    function yandexpro_landing_contact_form() {
        ?>
        <form class="landing-contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <?php wp_nonce_field('yandexpro_landing_contact', 'yandexpro_contact_nonce'); ?>
            <input type="hidden" name="action" value="yandexpro_process_landing_contact">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="contact-name"><?php _e('Имя *', 'yandexpro'); ?></label>
                    <input type="text" id="contact-name" name="contact_name" required maxlength="100">
                </div>
                
                <div class="form-group">
                    <label for="contact-email"><?php _e('Email *', 'yandexpro'); ?></label>
                    <input type="email" id="contact-email" name="contact_email" required maxlength="100">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="contact-phone"><?php _e('Телефон', 'yandexpro'); ?></label>
                    <input type="tel" id="contact-phone" name="contact_phone" maxlength="20">
                </div>
                
                <div class="form-group">
                    <label for="contact-company"><?php _e('Компания', 'yandexpro'); ?></label>
                    <input type="text" id="contact-company" name="contact_company" maxlength="100">
                </div>
            </div>
            
            <div class="form-group">
                <label for="contact-subject"><?php _e('Тема', 'yandexpro'); ?></label>
                <select id="contact-subject" name="contact_subject">
                    <option value=""><?php _e('Выберите тему', 'yandexpro'); ?></option>
                    <option value="consultation"><?php _e('Консультация', 'yandexpro'); ?></option>
                    <option value="audit"><?php _e('Аудит рекламы', 'yandexpro'); ?></option>
                    <option value="management"><?php _e('Ведение рекламы', 'yandexpro'); ?></option>
                    <option value="training"><?php _e('Обучение', 'yandexpro'); ?></option>
                    <option value="other"><?php _e('Другое', 'yandexpro'); ?></option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="contact-message"><?php _e('Сообщение *', 'yandexpro'); ?></label>
                <textarea id="contact-message" name="contact_message" rows="5" required maxlength="1000" placeholder="<?php _e('Расскажите о вашем проекте или задаче...', 'yandexpro'); ?>"></textarea>
                <div class="character-counter">
                    <span class="counter">0</span> / 1000
                </div>
            </div>
            
            <div class="form-group checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="contact_privacy" value="1" required>
                    <span class="checkmark"></span>
                    <?php 
                    printf(
                        __('Я согласен с <a href="%s" target="_blank">политикой конфиденциальности</a> *', 'yandexpro'),
                        esc_url(get_privacy_policy_url())
                    ); 
                    ?>
                </label>
            </div>
            
            <div class="form-group checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="contact_newsletter" value="1">
                    <span class="checkmark"></span>
                    <?php _e('Подписаться на рассылку с полезными материалами', 'yandexpro'); ?>
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large submit-button">
                    <span class="button-text"><?php _e('Отправить заявку', 'yandexpro'); ?></span>
                    <span class="button-spinner" style="display: none;">
                        <svg width="20" height="20" viewBox="0 0 50 50">
                            <circle cx="25" cy="25" r="20" fill="none" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-dasharray="31.416" stroke-dashoffset="31.416">
                                <animate attributeName="stroke-array" dur="2s" values="0 31.416;15.708 15.708;0 31.416" repeatCount="indefinite"/>
                                <animate attributeName="stroke-dashoffset" dur="2s" values="0;-15.708;-31.416" repeatCount="indefinite"/>
                            </circle>
                        </svg>
                    </span>
                </button>
            </div>
            
            <div class="form-messages">
                <div class="success-message" style="display: none;">
                    <p><?php _e('Спасибо! Ваша заявка отправлена. Мы свяжемся с вами в ближайшее время.', 'yandexpro'); ?></p>
                </div>
                <div class="error-message" style="display: none;">
                    <p><?php _e('Произошла ошибка при отправке. Попробуйте еще раз или свяжитесь с нами напрямую.', 'yandexpro'); ?></p>
                </div>
            </div>
        </form>
        <?php
    }
}

/**
 * Process landing contact form
 */
function yandexpro_process_landing_contact() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['yandexpro_contact_nonce'], 'yandexpro_landing_contact')) {
        wp_die(__('Ошибка безопасности', 'yandexpro'));
    }
    
    // Sanitize input data
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $company = sanitize_text_field($_POST['contact_company']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);
    $privacy = isset($_POST['contact_privacy']) ? 1 : 0;
    $newsletter = isset($_POST['contact_newsletter']) ? 1 : 0;
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message) || !$privacy) {
        wp_redirect(wp_get_referer() . '?contact=error');
        exit;
    }
    
    // Validate email
    if (!is_email($email)) {
        wp_redirect(wp_get_referer() . '?contact=error');
        exit;
    }
    
    // Spam protection - simple honeypot and time check
    if (isset($_POST['website']) && !empty($_POST['website'])) {
        wp_redirect(wp_get_referer() . '?contact=error');
        exit;
    }
    
    // Prepare email
    $to = get_option('admin_email');
    $email_subject = sprintf(__('[%s] Новая заявка с лендинга', 'yandexpro'), get_bloginfo('name'));
    
    $subject_labels = array(
        'consultation' => __('Консультация', 'yandexpro'),
        'audit' => __('Аудит рекламы', 'yandexpro'),
        'management' => __('Ведение рекламы', 'yandexpro'),
        'training' => __('Обучение', 'yandexpro'),
        'other' => __('Другое', 'yandexpro'),
    );
    
    $subject_text = isset($subject_labels[$subject]) ? $subject_labels[$subject] : __('Не указано', 'yandexpro');
    
    $email_body = sprintf(
        __("Новая заявка с лендинга:\n\nИмя: %s\nEmail: %s\nТелефон: %s\nКомпания: %s\nТема: %s\nСообщение: %s\n\nПодписка на рассылку: %s\n\nДата: %s\nIP: %s\nUser Agent: %s", 'yandexpro'),
        $name,
        $email,
        $phone ?: __('Не указан', 'yandexpro'),
        $company ?: __('Не указана', 'yandexpro'),
        $subject_text,
        $message,
        $newsletter ? __('Да', 'yandexpro') : __('Нет', 'yandexpro'),
        current_time('mysql'),
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email,
    );
    
    // Send email
    $sent = wp_mail($to, $email_subject, $email_body, $headers);
    
    // Save to database for future reference
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'yandexpro_contacts';
    
    // Create table if it doesn't exist
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20),
        company varchar(100),
        subject varchar(50),
        message text NOT NULL,
        newsletter tinyint(1) DEFAULT 0,
        ip_address varchar(45),
        user_agent text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    
    // Insert contact
    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'subject' => $subject,
            'message' => $message,
            'newsletter' => $newsletter,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        ),
        array(
            '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s'
        )
    );
    
    // Add to newsletter if requested
    if ($newsletter) {
        // This is where you would integrate with your newsletter service
        // For example, Mailchimp, ConvertKit, etc.
        do_action('yandexpro_newsletter_subscribe', $email, $name);
    }
    
    // Redirect with success message
    if ($sent) {
        wp_redirect(wp_get_referer() . '?contact=success');
    } else {
        wp_redirect(wp_get_referer() . '?contact=error');
    }
    exit;
}
add_action('admin_post_yandexpro_process_landing_contact', 'yandexpro_process_landing_contact');
add_action('admin_post_nopriv_yandexpro_process_landing_contact', 'yandexpro_process_landing_contact');

/**
 * Add landing page meta boxes
 */
function yandexpro_add_landing_meta_boxes() {
    add_meta_box(
        'yandexpro-landing-options',
        __('Настройки лендинга', 'yandexpro'),
        'yandexpro_landing_meta_box_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'yandexpro_add_landing_meta_boxes');

/**
 * Landing meta box callback
 */
function yandexpro_landing_meta_box_callback($post) {
    wp_nonce_field('yandexpro_landing_meta_box', 'yandexpro_landing_meta_box_nonce');
    
    // Get current values
    $hero_button_text = get_post_meta($post->ID, '_yandexpro_hero_button_text', true);
    $hero_button_url = get_post_meta($post->ID, '_yandexpro_hero_button_url', true);
    $cta_title = get_post_meta($post->ID, '_yandexpro_cta_title', true);
    $cta_content = get_post_meta($post->ID, '_yandexpro_cta_content', true);
    $cta_button_text = get_post_meta($post->ID, '_yandexpro_cta_button_text', true);
    $cta_button_url = get_post_meta($post->ID, '_yandexpro_cta_button_url', true);
    $show_contact_form = get_post_meta($post->ID, '_yandexpro_show_contact_form', true);
    $contact_title = get_post_meta($post->ID, '_yandexpro_contact_title', true);
    $contact_description = get_post_meta($post->ID, '_yandexpro_contact_description', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="hero_button_text"><?php _e('Текст кнопки в Hero', 'yandexpro'); ?></label></th>
            <td><input type="text" id="hero_button_text" name="hero_button_text" value="<?php echo esc_attr($hero_button_text); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="hero_button_url"><?php _e('Ссылка кнопки в Hero', 'yandexpro'); ?></label></th>
            <td><input type="url" id="hero_button_url" name="hero_button_url" value="<?php echo esc_attr($hero_button_url); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="cta_title"><?php _e('Заголовок CTA секции', 'yandexpro'); ?></label></th>
            <td><input type="text" id="cta_title" name="cta_title" value="<?php echo esc_attr($cta_title); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="cta_content"><?php _e('Содержание CTA секции', 'yandexpro'); ?></label></th>
            <td><textarea id="cta_content" name="cta_content" rows="3" class="large-text"><?php echo esc_textarea($cta_content); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="cta_button_text"><?php _e('Текст кнопки CTA', 'yandexpro'); ?></label></th>
            <td><input type="text" id="cta_button_text" name="cta_button_text" value="<?php echo esc_attr($cta_button_text); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="cta_button_url"><?php _e('Ссылка кнопки CTA', 'yandexpro'); ?></label></th>
            <td><input type="url" id="cta_button_url" name="cta_button_url" value="<?php echo esc_attr($cta_button_url); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="show_contact_form"><?php _e('Показать форму обратной связи', 'yandexpro'); ?></label></th>
            <td><input type="checkbox" id="show_contact_form" name="show_contact_form" value="1" <?php checked($show_contact_form, 1); ?>></td>
        </tr>
        <tr>
            <th><label for="contact_title"><?php _e('Заголовок формы обратной связи', 'yandexpro'); ?></label></th>
            <td><input type="text" id="contact_title" name="contact_title" value="<?php echo esc_attr($contact_title); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="contact_description"><?php _e('Описание формы обратной связи', 'yandexpro'); ?></label></th>
            <td><textarea id="contact_description" name="contact_description" rows="3" class="large-text"><?php echo esc_textarea($contact_description); ?></textarea></td>
        </tr>
    </table>
    <?php
}

/**
 * Save landing meta box data
 */
function yandexpro_save_landing_meta_box_data($post_id) {
    if (!isset($_POST['yandexpro_landing_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['yandexpro_landing_meta_box_nonce'], 'yandexpro_landing_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }
    
    $fields = array(
        'hero_button_text',
        'hero_button_url',
        'cta_title',
        'cta_content',
        'cta_button_text',
        'cta_button_url',
        'contact_title',
        'contact_description',
    );
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_yandexpro_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Handle checkbox
    $show_contact_form = isset($_POST['show_contact_form']) ? 1 : 0;
    update_post_meta($post_id, '_yandexpro_show_contact_form', $show_contact_form);
}
add_action('save_post', 'yandexpro_save_landing_meta_box_data');
?>