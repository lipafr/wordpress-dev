/**
 * Customizer live preview JavaScript
 */

( function( $ ) {
    'use strict';

    // Primary color
    wp.customize( 'yandexpro_primary_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--color-primary', newval);
        } );
    } );

    // Secondary color
    wp.customize( 'yandexpro_secondary_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--color-secondary', newval);
        } );
    } );

    // Container width
    wp.customize( 'yandexpro_container_width', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--container-width', newval + 'px');
        } );
    } );

    // Font family
    wp.customize( 'yandexpro_font_family', function( value ) {
        value.bind( function( newval ) {
            let fontStack = "'Space Grotesk', -apple-system, BlinkMacSystemFont, sans-serif";
            
            switch( newval ) {
                case 'inter':
                    fontStack = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";
                    break;
                case 'roboto':
                    fontStack = "'Roboto', -apple-system, BlinkMacSystemFont, sans-serif";
                    break;
                case 'open-sans':
                    fontStack = "'Open Sans', -apple-system, BlinkMacSystemFont, sans-serif";
                    break;
            }
            
            document.documentElement.style.setProperty('--font-family', fontStack);
        } );
    } );

} )( jQuery );