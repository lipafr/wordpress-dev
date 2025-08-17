<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @package YandexPro
 * @since 1.0.0
 */

get_header();
?>

<main id="main" class="site-main page-content" role="main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="page-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
                
                <!-- Page header -->
                <header class="page-header">
                    
                    <!-- Page title -->
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    
                    <!-- Page meta (if needed) -->
                    <?php if (yandexpro_get_theme_option('show_page_meta', false)) : ?>
                        <div class="page-meta">
                            <time class="page-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php
                                printf(
                                    esc_html__('Published on %s', 'yandexpro'),
                                    '<span class="date">' . esc_html(get_the_date()) . '</span>'
                                );
                                ?>
                            </time>
                            
                            <?php if (get_the_modified_date() !== get_the_date()) : ?>
                                <time class="page-modified" datetime="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                    <?php
                                    printf(
                                        esc_html__('Updated on %s', 'yandexpro'),
                                        '<span class="date">' . esc_html(get_the_modified_date()) . '</span>'
                                    );
                                    ?>
                                </time>
                            <?php endif; ?>
                            
                            <?php if (get_the_author() && yandexpro_get_theme_option('show_page_author', false)) : ?>
                                <span class="page-author">
                                    <?php
                                    printf(
                                        esc_html__('by %s', 'yandexpro'),
                                        '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a>'
                                    );
                                    ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                </header><!-- .page-header -->
                
                <!-- Featured image -->
                <?php if (has_post_thumbnail() && yandexpro_get_theme_option('show_page_featured_image', true)) : ?>
                    <div class="page-thumbnail">
                        <?php
                        the_post_thumbnail('yandexpro-large', array(
                            'alt' => the_title_attribute(array('echo' => false)),
                            'loading' => 'eager', // Don't lazy load featured image
                            'decoding' => 'async',
                        ));
                        ?>
                        
                        <?php
                        $caption = get_the_post_thumbnail_caption();
                        if ($caption) :
                        ?>
                            <figcaption class="wp-caption-text"><?php echo wp_kses_post($caption); ?></figcaption>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Page content layout -->
                <div class="page-content-wrapper">
                    
                    <!-- Main page content -->
                    <div class="page-main-content">
                        
                        <!-- Page content -->
                        <div class="page-content">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'yandexpro'),
                                'after'  => '</div>',
                                'link_before' => '<span class="page-number">',
                                'link_after'  => '</span>',
                            ));
                            ?>
                        </div><!-- .page-content -->
                        
                        <!-- Page footer -->
                        <footer class="page-footer">
                            
                            <!-- Last updated -->
                            <?php if (yandexpro_get_theme_option('show_page_updated', true) && get_the_modified_date() !== get_the_date()) : ?>
                                <div class="page-updated">
                                    <small>
                                        <?php
                                        printf(
                                            esc_html__('Last updated: %s', 'yandexpro'),
                                            '<time datetime="' . esc_attr(get_the_modified_date('c')) . '">' . esc_html(get_the_modified_date()) . '</time>'
                                        );
                                        ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Edit link for logged in users -->
                            <?php
                            edit_post_link(
                                sprintf(
                                    wp_kses(
                                        __('Edit<span class="screen-reader-text"> "%s"</span>', 'yandexpro'),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    wp_kses_post(get_the_title())
                                ),
                                '<div class="edit-link">',
                                '</div>'
                            );
                            ?>
                            
                        </footer><!-- .page-footer -->
                        
                    </div><!-- .page-main-content -->
                    
                    <!-- Page sidebar (optional) -->
                    <?php if (is_active_sidebar('sidebar-1') && yandexpro_get_theme_option('show_page_sidebar', false)) : ?>
                        <aside id="secondary" class="page-sidebar widget-area" role="complementary">
                            <h2 class="screen-reader-text"><?php esc_html_e('Page Sidebar', 'yandexpro'); ?></h2>
                            <?php dynamic_sidebar('sidebar-1'); ?>
                        </aside>
                    <?php endif; ?>
                    
                </div><!-- .page-content-wrapper -->
                
            </article><!-- #page-<?php the_ID(); ?> -->
            
            <!-- Page comments (if enabled) -->
            <?php
            if (comments_open() || get_comments_number()) :
                ?>
                <div class="page-comments-wrapper">
                    <?php comments_template(); ?>
                </div>
                <?php
            endif;
            ?>
            
            <!-- Child pages (if this is a parent page) -->
            <?php if (yandexpro_get_theme_option('show_child_pages', true)) : ?>
                <?php yandexpro_child_pages(); ?>
            <?php endif; ?>
            
            <!-- Contact form (if this is contact page) -->
            <?php if (yandexpro_is_contact_page()) : ?>
                <?php yandexpro_contact_form(); ?>
            <?php endif; ?>
            
        <?php endwhile; // End of the loop. ?>
        
    </div><!-- .container -->
</main><!-- #main -->

<?php
get_footer();

/**
 * Display child pages
 */
if (!function_exists('yandexpro_child_pages')) {
    function yandexpro_child_pages() {
        global $post;
        
        $child_pages = get_pages(array(
            'parent'      => $post->ID,
            'sort_column' => 'menu_order',
            'sort_order'  => 'ASC'
        ));

        if ($child_pages) :
        ?>
            <section class="child-pages">
                <h3 class="child-pages-title"><?php esc_html_e('Sub-pages', 'yandexpro'); ?></h3>
                <div class="child-pages-grid">
                    <?php foreach ($child_pages as $child) : ?>
                        <article class="child-page-card">
                            <?php if (has_post_thumbnail($child->ID)) : ?>
                                <div class="child-page-thumbnail">
                                    <a href="<?php echo esc_url(get_permalink($child->ID)); ?>">
                                        <?php echo get_the_post_thumbnail($child->ID, 'yandexpro-small'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="child-page-content">
                                <h4 class="child-page-title">
                                    <a href="<?php echo esc_url(get_permalink($child->ID)); ?>">
                                        <?php echo esc_html($child->post_title); ?>
                                    </a>
                                </h4>
                                
                                <?php if ($child->post_excerpt) : ?>
                                    <p class="child-page-excerpt"><?php echo esc_html($child->post_excerpt); ?></p>
                                <?php else : ?>
                                    <p class="child-page-excerpt">
                                        <?php echo wp_trim_words(apply_filters('the_content', $child->post_content), 20, '...'); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <a href="<?php echo esc_url(get_permalink($child->ID)); ?>" class="child-page-link">
                                    <?php esc_html_e('Read more', 'yandexpro'); ?> →
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php
        endif;
    }
}

/**
 * Check if this is a contact page
 */
if (!function_exists('yandexpro_is_contact_page')) {
    function yandexpro_is_contact_page() {
        global $post;
        
        // Check if page slug or title contains "contact"
        $is_contact = false;
        
        if (is_page()) {
            $page_slug = $post->post_name;
            $page_title = strtolower($post->post_title);
            
            $contact_keywords = array('contact', 'kontakt', 'контакт', 'contacts', 'контакты');
            
            foreach ($contact_keywords as $keyword) {
                if (strpos($page_slug, $keyword) !== false || strpos($page_title, $keyword) !== false) {
                    $is_contact = true;
                    break;
                }
            }
        }
        
        return apply_filters('yandexpro_is_contact_page', $is_contact);
    }
}

/**
 * Display contact form
 */
if (!function_exists('yandexpro_contact_form')) {
    function yandexpro_contact_form() {
        // Only show if Contact Form 7 is not active
        if (class_exists('WPCF7')) {
            return;
        }
        ?>
        <section class="contact-form-section">
            <h3 class="contact-form-title"><?php esc_html_e('Get in Touch', 'yandexpro'); ?></h3>
            
            <form id="contact-form" class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="yandexpro_contact_form">
                <?php wp_nonce_field('yandexpro_contact_form', 'contact_nonce'); ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-name"><?php esc_html_e('Name', 'yandexpro'); ?> <span class="required">*</span></label>
                        <input type="text" id="contact-name" name="contact_name" required aria-describedby="name-error">
                        <div id="name-error" class="error-message" role="alert"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-email"><?php esc_html_e('Email', 'yandexpro'); ?> <span class="required">*</span></label>
                        <input type="email" id="contact-email" name="contact_email" required aria-describedby="email-error">
                        <div id="email-error" class="error-message" role="alert"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="contact-subject"><?php esc_html_e('Subject', 'yandexpro'); ?></label>
                    <input type="text" id="contact-subject" name="contact_subject">
                </div>
                
                <div class="form-group">
                    <label for="contact-message"><?php esc_html_e('Message', 'yandexpro'); ?> <span class="required">*</span></label>
                    <textarea id="contact-message" name="contact_message" rows="6" required aria-describedby="message-error"></textarea>
                    <div id="message-error" class="error-message" role="alert"></div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <span class="submit-text"><?php esc_html_e('Send Message', 'yandexpro'); ?></span>
                        <span class="submit-loading" style="display: none;"><?php esc_html_e('Sending...', 'yandexpro'); ?></span>
                    </button>
                </div>
                
                <div id="contact-form-response" class="form-response" role="alert"></div>
            </form>
        </section>
        <?php
    }
}

/**
 * Handle contact form submission
 */
add_action('admin_post_yandexpro_contact_form', 'yandexpro_handle_contact_form');
add_action('admin_post_nopriv_yandexpro_contact_form', 'yandexpro_handle_contact_form');

if (!function_exists('yandexpro_handle_contact_form')) {
    function yandexpro_handle_contact_form() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['contact_nonce'], 'yandexpro_contact_form')) {
            wp_die(__('Security check failed', 'yandexpro'));
        }
        
        // Sanitize form data
        $name = sanitize_text_field($_POST['contact_name']);
        $email = sanitize_email($_POST['contact_email']);
        $subject = sanitize_text_field($_POST['contact_subject']);
        $message = sanitize_textarea_field($_POST['contact_message']);
        
        // Validate required fields
        if (empty($name) || empty($email) || empty($message)) {
            wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
            exit;
        }
        
        // Validate email
        if (!is_email($email)) {
            wp_redirect(add_query_arg('contact', 'invalid_email', wp_get_referer()));
            exit;
        }
        
        // Prepare email
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        
        $email_subject = sprintf(__('[%s] Contact Form: %s', 'yandexpro'), $site_name, $subject ?: __('No Subject', 'yandexpro'));
        
        $email_body = sprintf(
            __("New message from %s (%s):\n\n%s", 'yandexpro'),
            $name,
            $email,
            $message
        );
        
        $headers = array(
            'Reply-To: ' . $name . ' <' . $email . '>',
            'Content-Type: text/plain; charset=UTF-8'
        );
        
        // Send email
        $sent = wp_mail($admin_email, $email_subject, $email_body, $headers);
        
        if ($sent) {
            wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
        } else {
            wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        }
        
        exit;
    }
}
?>