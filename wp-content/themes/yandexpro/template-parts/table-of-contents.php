<?php
/**
 * Template part for table of contents
 */

if ( ! is_single() ) {
    return;
}

global $post;
$content = $post->post_content;

// Extract headings
preg_match_all( '/<h([2-6])[^>]*>(.*?)<\/h[2-6]>/i', $content, $matches, PREG_SET_ORDER );

if ( empty( $matches ) ) {
    return;
}

// Generate table of contents
?>
<div class="table-of-contents">
    <h3 class="toc-title"><?php esc_html_e( 'Table of Contents', 'yandexpro-blog' ); ?></h3>
    <ul class="toc-list">
        <?php
        foreach ( $matches as $index => $match ) {
            $level = intval( $match[1] );
            $title = strip_tags( $match[2] );
            $id = 'section' . ( $index + 1 );
            
            $class = '';
            if ( $level > 2 ) {
                $class = ' class="toc-sub"';
            }
            
            echo '<li' . $class . '>';
            echo '<a href="#' . esc_attr( $id ) . '" class="toc-link">' . esc_html( $title ) . '</a>';
            echo '</li>';
        }
        ?>
    </ul>
</div>