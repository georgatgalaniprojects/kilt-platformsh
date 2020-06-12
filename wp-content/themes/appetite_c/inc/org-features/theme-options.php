<?php 
/**
 * Custom options that will be located in the Cusomizer.
 *
 * @package Appetite
 */

if ( !function_exists( 'appetite_custom_options_customize_register' ) ):

function appetite_custom_options_customize_register( $wp_customize ) {
	
    // Accent Color
	$wp_customize->add_setting( 'appetite_accent_color', array(
		'default' => '#c7a84e',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'appetite_accent_color', array(
		'label'		=> esc_html__( 'Accent Color', 'appetite' ),
		'section'	=> 'colors',
		'priority'	=> 100,
	) ) );
    
    // Footer Background Color
	$wp_customize->add_setting( 'appetite_footer_bg_color', array(
		'default' => '#383a3b',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'appetite_footer_bg_color', array(
		'label'		=> esc_html__( 'Footer Background Color', 'appetite' ),
		'section'	=> 'colors',
		'priority'	=> 101,
	) ) );
    
    // Footer Credits
	$wp_customize->add_setting( 'appetite_footer_credits', array(
		'default'        => '',
		'sanitize_callback' => 'wp_kses_post'
	) );
	$wp_customize->add_control( 'appetite_footer_credits', array(
		'type' => 'textarea',
		'label'   => esc_html__( 'Footer Credits', 'appetite' ),
		'section' => 'appetite_general_options',
        'description' => esc_html__( 'You can add your own credit text to WordPress footer by using this option.', 'appetite' ),
	) );
}

endif;
add_action( 'customize_register', 'appetite_custom_options_customize_register', 11 );