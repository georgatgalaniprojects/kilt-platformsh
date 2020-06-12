/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	});

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	});

    // Custom background image.
	wp.customize( 'background_image', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( 'body' ).addClass( 'has-custom-background' );
			} else {
				// remove class if a custom background color is not set
				if ( '#ffffff' === wp.customize.value('background_color')() || '' == wp.customize.value('background_color')() ) {
					$( 'body' ).removeClass( 'has-custom-background' );
				}
			}
		} );
	});

	// Custom background color.
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			if ( '#ffffff' !== to ) {
				$( 'body' ).addClass( 'has-custom-background' );
			} else {
				// remove class if a custom background image is not set
				if ( '' === wp.customize.value('background_image')() ) {
					$( 'body' ).removeClass( 'has-custom-background' );
				}
			}
		} );
	} );

	// Featured Content Transition Speed.
	wp.customize( 'appetite_featured_content_transition_speed', function( value ) {
		var featuredContent = $( '#page' ).find( '.featured-content' );
		value.bind( function( to ) {
			featuredContent.data( 'transition-speed', to );
			featuredContent.attr( 'data-transition-speed', to );
		});
	});
} )( jQuery );
