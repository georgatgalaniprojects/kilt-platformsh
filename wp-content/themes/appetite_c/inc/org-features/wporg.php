<?php 
/**
 * Support for self-hosted WordPress instalations.
 *
 * @package Appetite
 */

if ( !function_exists( 'appetite_footer_output' ) ):
/**
 * Custom Text for the Footer Section
 */
function appetite_footer_output() {
	if( '' != ( $custom_credits = get_theme_mod( 'appetite_footer_credits', '' ) ) ):
		echo $custom_credits;
	else:
	?>

		<a href="<?php echo esc_url( 'https://wordpress.org/' ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'appetite' ), 'WordPress' ); ?></a>
		<span class="sep"> | </span>
		<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'appetite' ), 'Appetite', '<a href="https://themesharbor.com/" rel="designer">Themes Harbor</a>' ); ?>
	
    <?php
	endif;
}
endif;

/**
 * Custom Customizer options.
 */
require_once get_template_directory() . '/inc/org-features/theme-options.php';

/**
 * Custom colors.
 */
require_once get_template_directory() . '/inc/org-features/colors.php';
