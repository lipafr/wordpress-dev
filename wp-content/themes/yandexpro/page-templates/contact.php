<?php
/**
 * Template Name: Contact Page
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <section class="page-header">
        <div class="container">
            <?php yandexpro_breadcrumbs(); ?>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php if ( has_excerpt() ) : ?>
                <div class="page-excerpt"><?php the_excerpt(); ?></div>
            <?php endif; ?>
        </div>
    </section>

    <section class="contact-content">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <?php the_content(); ?>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <h3>📧 <?php esc_html_e( 'Email', 'yandexpro-blog' ); ?></h3>
                            <p><a href="mailto:info@yandexpro.ru">info@yandexpro.ru</a></p>
                        </div>
                        
                        <div class="contact-item">
                            <h3>📱 <?php esc_html_e( 'Telegram', 'yandexpro-blog' ); ?></h3>
                            <p><a href="https://t.me/yandexpro" target="_blank">@yandexpro</a></p>
                        </div>
                        
                        <div class="contact-item">
                            <h3>🕒 <?php esc_html_e( 'Working Hours', 'yandexpro-blog' ); ?></h3>
                            <p><?php esc_html_e( 'Monday - Friday: 9:00 - 18:00 MSK', 'yandexpro-blog' ); ?></p>
                        </div>
                    </div>
                </div>

                <div class="contact-form-wrapper">
                    <form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                        <h3><?php esc_html_e( 'Send us a message', 'yandexpro-blog' ); ?></h3>
                        
                        <div class="form-group">
                            <label for="contact-name"><?php esc_html_e( 'Name *', 'yandexpro-blog' ); ?></label>
                            <input type="text" id="contact-name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-email"><?php esc_html_e( 'Email *', 'yandexpro-blog' ); ?></label>
                            <input type="email" id="contact-email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-subject"><?php esc_html_e( 'Subject', 'yandexpro-blog' ); ?></label>
                            <input type="text" id="contact-subject" name="subject">
                        </div>
                        
                        <div class="form-group">
                            <label for="contact-message"><?php esc_html_e( 'Message *', 'yandexpro-blog' ); ?></label>
                            <textarea id="contact-message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <input type="hidden" name="action" value="contact_form_submit">
                        <?php wp_nonce_field( 'contact_form', 'contact_nonce' ); ?>
                        
                        <button type="submit" class="btn primary">
                            <?php esc_html_e( 'Send Message', 'yandexpro-blog' ); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php endwhile; ?>

<?php
get_footer();