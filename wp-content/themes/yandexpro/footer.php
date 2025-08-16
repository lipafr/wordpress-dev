<?php
/**
 * The template for displaying the footer
 */
?>

    </main><!-- #main -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
            <div class="footer-widgets">
                <div class="container">
                    <?php dynamic_sidebar( 'footer-widgets' ); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="footer-bottom
		<div class="footer-bottom">
           <div class="container">
               <div class="footer-content">
                   <div class="copyright">
                       <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'yandexpro-blog' ); ?></p>
                   </div>
                   
                   <?php
                   wp_nav_menu( array(
                       'theme_location' => 'footer',
                       'menu_class'     => 'footer-menu',
                       'container'      => 'nav',
                       'container_class' => 'footer-navigation',
                       'fallback_cb'    => false,
                       'depth'          => 1,
                   ) );
                   ?>
               </div>
           </div>
       </div>
   </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>