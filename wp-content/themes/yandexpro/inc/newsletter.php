<?php
/**
 * Newsletter функциональность
 * Обработка подписки на рассылку
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Запретить прямой доступ
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Обработка подписки на newsletter
 */
function yandexpro_handle_newsletter_signup() {
    // Проверяем nonce
    if (!isset($_POST['newsletter_nonce']) || 
        !wp_verify_nonce($_POST['newsletter_nonce'], 'yandexpro_newsletter')) {
        wp_die(esc_html__('Ошибка безопасности. Попробуйте еще раз.', 'yandexpro'));
    }

    // Получаем и валидируем email
    $email = isset($_POST['newsletter_email']) ? sanitize_email($_POST['newsletter_email']) : '';
    
    if (empty($email) || !is_email($email)) {
        wp_redirect(add_query_arg('newsletter', 'invalid_email', wp_get_referer()));
        exit;
    }

    // Проверяем что email еще не подписан
    $existing_subscriber = get_option('yandexpro_subscribers', []);
    if (in_array($email, $existing_subscriber)) {
        wp_redirect(add_query_arg('newsletter', 'already_subscribed', wp_get_referer()));
        exit;
    }

    // Добавляем подписчика
    $existing_subscriber[] = $email;
    update_option('yandexpro_subscribers', $existing_subscriber);

    // Логируем подписку
    error_log("YandexPro Newsletter: New subscriber - {$email}");

    // Отправляем уведомление администратору
    $admin_email = get_option('admin_email');
    $subject = sprintf(__('Новая подписка на %s', 'yandexpro'), get_bloginfo('name'));
    $message = sprintf(
        __("Новый подписчик на рассылку:\n\nEmail: %s\nДата: %s\nIP: %s", 'yandexpro'),
        $email,
        current_time('mysql'),
        $_SERVER['REMOTE_ADDR']
    );
    
    wp_mail($admin_email, $subject, $message);

    // Можно интегрировать с внешними сервисами:
    // yandexpro_add_to_mailchimp($email);
    // yandexpro_add_to_sendsay($email);

    // Редирект с успешным сообщением
    wp_redirect(add_query_arg('newsletter', 'success', wp_get_referer()));
    exit;
}
add_action('admin_post_yandexpro_newsletter_signup', 'yandexpro_handle_newsletter_signup');
add_action('admin_post_nopriv_yandexpro_newsletter_signup', 'yandexpro_handle_newsletter_signup');

/**
 * Показ сообщений о результате подписки
 */
function yandexpro_newsletter_messages() {
    if (!isset($_GET['newsletter'])) {
        return;
    }

    $message = '';
    $type = 'info';

    switch ($_GET['newsletter']) {
        case 'success':
            $message = __('Спасибо за подписку! Проверьте почту для подтверждения.', 'yandexpro');
            $type = 'success';
            break;
        
        case 'already_subscribed':
            $message = __('Этот email уже подписан на рассылку.', 'yandexpro');
            $type = 'warning';
            break;
        
        case 'invalid_email':
            $message = __('Пожалуйста, введите корректный email адрес.', 'yandexpro');
            $type = 'error';
            break;
    }

    if ($message) {
        echo '<div class="newsletter-notification ' . esc_attr($type) . '">';
        echo '<p>' . esc_html($message) . '</p>';
        echo '</div>';
    }
}
add_action('wp_footer', 'yandexpro_newsletter_messages');

/**
 * AJAX обработка подписки (для SPA подхода)
 */
function yandexpro_ajax_newsletter_signup() {
    // Проверяем nonce
    if (!wp_verify_nonce($_POST['nonce'], 'yandexpro_nonce')) {
        wp_send_json_error(['message' => __('Ошибка безопасности', 'yandexpro')]);
    }

    $email = sanitize_email($_POST['email']);
    
    if (empty($email) || !is_email($email)) {
        wp_send_json_error(['message' => __('Некорректный email адрес', 'yandexpro')]);
    }

    // Проверяем существующих подписчиков
    $subscribers = get_option('yandexpro_subscribers', []);
    if (in_array($email, $subscribers)) {
        wp_send_json_error(['message' => __('Этот email уже подписан', 'yandexpro')]);
    }

    // Добавляем подписчика
    $subscribers[] = $email;
    update_option('yandexpro_subscribers', $subscribers);

    wp_send_json_success(['message' => __('Спасибо за подписку!', 'yandexpro')]);
}
add_action('wp_ajax_yandexpro_newsletter', 'yandexpro_ajax_newsletter_signup');
add_action('wp_ajax_nopriv_yandexpro_newsletter', 'yandexpro_ajax_newsletter_signup');

/**
 * Интеграция с популярными email сервисами
 */

/**
 * Добавление в MailChimp (пример)
 */
function yandexpro_add_to_mailchimp($email) {
    $api_key = get_option('yandexpro_mailchimp_api');
    $list_id = get_option('yandexpro_mailchimp_list');
    
    if (empty($api_key) || empty($list_id)) {
        return false;
    }

    $datacenter = substr($api_key, strpos($api_key, '-') + 1);
    $url = "https://{$datacenter}.api.mailchimp.com/3.0/lists/{$list_id}/members";

    $data = [
        'email_address' => $email,
        'status'        => 'subscribed',
        'tags'          => ['YandexPro Blog']
    ];

    $response = wp_remote_post($url, [
        'headers' => [
            'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
            'Content-Type'  => 'application/json',
        ],
        'body' => json_encode($data),
    ]);

    return !is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200;
}

/**
 * Добавление в SendSay (российский сервис)
 */
function yandexpro_add_to_sendsay($email) {
    $api_key = get_option('yandexpro_sendsay_api');
    $list_id = get_option('yandexpro_sendsay_list');
    
    if (empty($api_key) || empty($list_id)) {
        return false;
    }

    $url = 'https://api.sendsay.ru/';
    
    $data = [
        'action' => 'member.set',
        'list'   => $list_id,
        'email'  => $email,
        'source' => 'YandexPro Blog',
    ];

    $response = wp_remote_post($url, [
        'headers' => [
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
        ],
        'body' => json_encode($data),
    ]);

    return !is_wp_error($response);
}

/**
 * Экспорт подписчиков в админке
 */
function yandexpro_export_subscribers() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $subscribers = get_option('yandexpro_subscribers', []);
    
    if (empty($subscribers)) {
        wp_die(__('Нет подписчиков для экспорта', 'yandexpro'));
    }

    $filename = 'yandexpro-subscribers-' . date('Y-m-d') . '.csv';
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Email', 'Дата подписки']);
    
    foreach ($subscribers as $email) {
        fputcsv($output, [$email, date('Y-m-d H:i:s')]);
    }
    
    fclose($output);
    exit;
}

/**
 * Админ панель для управления подписчиками
 */
function yandexpro_newsletter_admin_menu() {
    add_submenu_page(
        'options-general.php',
        __('Newsletter подписчики', 'yandexpro'),
        __('Newsletter', 'yandexpro'),
        'manage_options',
        'yandexpro-newsletter',
        'yandexpro_newsletter_admin_page'
    );
}
add_action('admin_menu', 'yandexpro_newsletter_admin_menu');

/**
 * Страница админки для newsletter
 */
function yandexpro_newsletter_admin_page() {
    $subscribers = get_option('yandexpro_subscribers', []);
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Newsletter подписчики', 'yandexpro'); ?></h1>
        
        <div class="card">
            <h2><?php esc_html_e('Статистика', 'yandexpro'); ?></h2>
            <p><?php printf(__('Всего подписчиков: %d', 'yandexpro'), count($subscribers)); ?></p>
            
            <?php if (!empty($subscribers)) : ?>
                <a href="<?php echo esc_url(admin_url('admin-post.php?action=yandexpro_export_subscribers')); ?>" 
                   class="button button-secondary">
                    <?php esc_html_e('Экспорт в CSV', 'yandexpro'); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($subscribers)) : ?>
            <div class="card">
                <h2><?php esc_html_e('Последние подписчики', 'yandexpro'); ?></h2>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Email', 'yandexpro'); ?></th>
                            <th><?php esc_html_e('Дата', 'yandexpro'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice(array_reverse($subscribers), 0, 10) as $email) : ?>
                            <tr>
                                <td><?php echo esc_html($email); ?></td>
                                <td><?php echo esc_html(date('Y-m-d H:i:s')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="card">
            <h2><?php esc_html_e('Настройки интеграции', 'yandexpro'); ?></h2>
            <form method="post" action="options.php">
                <?php settings_fields('yandexpro_newsletter_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('MailChimp API Key', 'yandexpro'); ?></th>
                        <td>
                            <input type="text" 
                                   name="yandexpro_mailchimp_api" 
                                   value="<?php echo esc_attr(get_option('yandexpro_mailchimp_api')); ?>" 
                                   class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('MailChimp List ID', 'yandexpro'); ?></th>
                        <td>
                            <input type="text" 
                                   name="yandexpro_mailchimp_list" 
                                   value="<?php echo esc_attr(get_option('yandexpro_mailchimp_list')); ?>" 
                                   class="regular-text">
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Регистрация настроек
 */
function yandexpro_newsletter_settings() {
    register_setting('yandexpro_newsletter_settings', 'yandexpro_mailchimp_api');
    register_setting('yandexpro_newsletter_settings', 'yandexpro_mailchimp_list');
    register_setting('yandexpro_newsletter_settings', 'yandexpro_sendsay_api');
    register_setting('yandexpro_newsletter_settings', 'yandexpro_sendsay_list');
}
add_action('admin_init', 'yandexpro_newsletter_settings');

/**
 * Обработка экспорта
 */
add_action('admin_post_yandexpro_export_subscribers', 'yandexpro_export_subscribers');