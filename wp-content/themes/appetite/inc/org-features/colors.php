<?php
/**
 * Custom color.
 *
 * @package Appetite
 */

if ( !function_exists( 'appetite_saved_custom_colors' ) ):

function appetite_saved_custom_colors() {
	
    $custom_colors = '';

	/* Accent Color */
	if( '#c7a84e' !== ( $accent_color = get_theme_mod( 'appetite_accent_color', '#c7a84e' ) ) ) {

		$custom_colors .= " a, #colophon .site-info,
							.widget_tag_cloud a:hover,
							#secondary .widget a:hover,
							.hentry .entry-header .entry-title a:hover,
							.hentry .entry-content .more-link-container a:hover,
							.hentry .entry-summary .more-link-container a:hover,
							#primary-header .entry-cats:before,
							body:not(.search) #page .jetpack-testimonial.hentry .entry-title a,
							body:not(.search) #page .jetpack-testimonial.hentry .entry-title:after,
							.menu-wrapper .menu-group-title { color: " . $accent_color . "; } \n";
		
        $custom_colors .= " #page .social-list li a:hover::before,
							#page .mejs-controls .mejs-time-rail .mejs-time-current,
							#page .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,
                            #primary-header .edit-link .post-edit-link,
							body:not(.search) #page .jetpack-testimonial.hentry .thumb-link:before { background: " . $accent_color . "; } \n";
		
        $custom_colors .= " #page .social-list li a:hover::before,
							blockquote,
							body:not(.search) #page .jetpack-testimonial.hentry .thumb-link img { border-color: " . $accent_color . "; } \n";
		
        $custom_colors .= " @media only screen and (max-width:500px) {
							  .menu-wrapper .hentry .menu-price { color: " . $accent_color . "; }
						  } \n";
        
	}
    
    // Footer Background Color.
    if( '#383a3b' !== ( $footer_bg_color = get_theme_mod( 'appetite_footer_bg_color', '#383a3b' ) ) ) {
        $custom_colors .= " #colophon { background: " . $footer_bg_color . "; } \n";
        
        $custom_colors .= "#colophon {
                                color: " . appetite_get_readable_color( $footer_bg_color ) . ";
                           } \n";
        
        
    }

	if( $custom_colors ) {
		wp_add_inline_style( 'appetite-style', $custom_colors );
	}
}

endif;
add_action( 'wp_enqueue_scripts', 'appetite_saved_custom_colors' );

/**
 * Get readable color depending on the color of the background.
 */
function appetite_get_readable_color( $hexcolor ) {
    
    $r = hexdec( substr( $hexcolor, 0, 2 ) );
	$g = hexdec( substr( $hexcolor, 2, 2 ) );
	$b = hexdec( substr( $hexcolor, 4, 2 ) );
	$new_hexcolor = ( ( $r*299 )+( $g*587 )+( $b*114 ) )/1000;
    
	return ( $new_hexcolor >= 128 ) ? '#000000' : '#ffffff';

}

/**
 * Convert hexdec color string to rgb(a) string
 */
function appetite_hex_to_rgba( $color, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if(empty($color))
		  return $default;

	//Sanitize $color if "#" is provided
		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
				return $default;
		}

		//Convert hexadec to rgb
		$rgb =  array_map('hexdec', $hex);

		//Check if opacity is set(rgba or rgb)
		if($opacity){
			if(abs($opacity) > 1)
				$opacity = 1.0;
			$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
		} else {
			$output = 'rgb('.implode(",",$rgb).')';
		}

		//Return rgb(a) color string
		return $output;
}
