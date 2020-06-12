<?php
/**
 * appetite Theme Customizer
 *
 * @package Appetite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function appetite_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->remove_control( 'header_textcolor' );

	/* THEME OPTIONS */
	$wp_customize->add_panel( 'appetite_theme_panel', array(
		'priority' => 9999,
		'title' => esc_html__( 'Theme Options', 'appetite' ),
	) );

	/* General Options */
	$wp_customize->add_section( 'appetite_general_options', array(
		 'title' => esc_html__( 'General Options', 'appetite' ),
		 'priority' => 1,
		 'panel' => 'appetite_theme_panel',
	) );

	/* General Options: Sidebar Position */
	$wp_customize->add_setting( 'appetite_sidebar_position', array(
		'default' => 'right',
		'sanitize_callback' => 'appetite_sanitize_sidebar_position',
	) );

	$wp_customize->add_control( 'appetite_sidebar_position', array(
		'label' => esc_html__( 'Sidebar Position', 'appetite' ),
		'type' => 'select',
		'section' => 'appetite_general_options',
		'choices' => array(
			'right' => esc_html__( 'Right', 'appetite' ),
			'left' => esc_html__( 'Left', 'appetite' ),
		),
		'priority' => 1,
		'description' => esc_html__( 'By default the appetite theme will show the sidebar on the right side of your site. Use this option to change the position of your sidebar.', 'appetite' ),
	) );

	/* General Options: Footer Text */
	$wp_customize->add_setting( 'appetite_footer_content', array(
		'default' => '',
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( 'appetite_footer_content', array(
		'label' => esc_html__( 'Footer Text', 'appetite' ),
		'section' => 'appetite_general_options',
		'priority' => 2,
		'type' => 'textarea',
		'description' => esc_html__( 'This text will appear next to the copyright text (year and site name) at the bottom of the page.', 'appetite' ),
	) );

	/* Front Page: Featured Content section */
	$wp_customize->add_section( 'appetite_front_featured_content', array(
		'title' => esc_html__( 'Front Page: Featured Content', 'appetite' ),
		'priority' => 2,
		'panel' => 'appetite_theme_panel',
		'description' => esc_html__( 'Additional Featured Content options specifically developed for this theme.', 'appetite' ),
		'active_callback' => 'appetite_is_front_page_template',
	) );

	/* Front Page: Featured Content Autoplay */
	$wp_customize->add_setting( 'appetite_is_autoplay_featured_content', array(
	    'default' => '',
	    'sanitize_callback' => 'appetite_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'appetite_is_autoplay_featured_content', array(
	    'label' => esc_html__( 'Enable slideshow autoplay', 'appetite' ),
	    'section' => 'appetite_front_featured_content',
	    'priority' => 1,
	    'type' => 'checkbox',
	    'description' => esc_html__( 'This option allows to change Featured Content slides automatically, without clicking on Prev/Next buttons.', 'appetite' ),
	) );

	/* Front Page: Featured Content Transition Speed */
	$wp_customize->add_setting( 'appetite_featured_content_transition_speed', array(
	    'default' => 300,
	    'sanitize_callback' => 'absint',
	    'transport' => 'postMessage',
	) );

	$wp_customize->add_control( 'appetite_featured_content_transition_speed', array(
	    'type' => 'range',
	    'priority' => 1,
	    'section' => 'appetite_front_featured_content',
	    'label' => esc_html__( 'Transition Speed', 'appetite' ),
	    'description' => esc_html__( 'This option allows to change the speed of transitions between slides.', 'appetite' ),
	    'input_attrs' => array(
	        'min' => 1,
	        'max' => 300,
	        'step' => 1,
	    ),
	) );

	/* Front Page: Featured Page #1 */
	$wp_customize->add_section( 'appetite_featured_page_one', array(
		 'title' => esc_html__( 'Front Page: Featured Page #1', 'appetite' ),
		 'priority' => 2,
		 'panel' => 'appetite_theme_panel',
		 'description' => esc_html__( 'In order to display a grid layout in this section, you need to select a page that has child pages.', 'appetite' ),
		 'active_callback' => 'appetite_is_front_page_template',
	) );

	/* Front Page: Featured Page #1 ID */
	$wp_customize->add_setting( 'appetite_featured_page_one_id', array(
		'default' => '0',
		'sanitize_callback' => 'appetite_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'appetite_featured_page_one_id', array(
		'label' => esc_html__( 'Featured Page', 'appetite' ),
		'section' => 'appetite_featured_page_one',
		'priority' => 1,
		'type' => 'dropdown-pages',
	) );

	/* Front Page: Featured Page #1 Content Position */
	$wp_customize->add_setting( 'appetite_featured_page_one_align', array(
		'default' => 'right',
		'sanitize_callback' => 'appetite_sanitize_content_position',
	) );

	$wp_customize->add_control( 'appetite_featured_page_one_align', array(
		'type' => 'select',
		'label' => esc_html__( 'Content Position', 'appetite' ),
		'section' => 'appetite_featured_page_one',
		'choices' => array(
			'left' => esc_html__( 'Left', 'appetite' ),
			'right' => esc_html__( 'Right', 'appetite' ),
			'center' => esc_html__( 'Center', 'appetite' ),
		),
		'priority' => 2,
		'description' => esc_html__( 'Choose the position for your page content.', 'appetite' ),
	) );

	/* Front Page: Featured Page #1 Grid Layout */
	$wp_customize->add_setting( 'appetite_featured_page_one_layout', array(
		'default' => '3',
		'sanitize_callback' => 'appetite_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'appetite_featured_page_one_layout', array(
		'type' => 'select',
		'label' => esc_html__( 'Grid Layout', 'appetite' ),
		'section' => 'appetite_featured_page_one',
		'choices' => array(
			'2' => esc_html__( 'Two Columns', 'appetite' ),
			'3' => esc_html__( 'Three Columns', 'appetite' ),
		),
		'priority' => 3,
		'description' => esc_html__( 'Choose the layout for the grid items.', 'appetite' ),
	) );

	/* Front Page: Featured Page #2 section */
	$wp_customize->add_section( 'appetite_featured_page_two', array(
		 'title' => esc_html__( 'Front Page: Featured Page #2', 'appetite' ),
		 'priority' => 3,
		 'panel' => 'appetite_theme_panel',
		 'description' => esc_html__( 'In order to display a grid layout in this section, you need to select a page that has child pages.', 'appetite' ),
		 'active_callback' => 'appetite_is_front_page_template',
	) );

	/* Front Page: Featured Page #2 ID */
	$wp_customize->add_setting( 'appetite_featured_page_two_id', array(
		'default' => '0',
		'sanitize_callback' => 'appetite_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'appetite_featured_page_two_id', array(
		'label' => esc_html__( 'Featured Page', 'appetite' ),
		'section' => 'appetite_featured_page_two',
		'priority' => 1,
		'type' => 'dropdown-pages',
	) );

	/* Front Page: Featured Page #2 Content Position */
	$wp_customize->add_setting( 'appetite_featured_page_two_align', array(
		'default' => 'right',
		'sanitize_callback' => 'appetite_sanitize_content_position',
	) );

	$wp_customize->add_control( 'appetite_featured_page_two_align', array(
		'type' => 'select',
		'label' => esc_html__( 'Content Position', 'appetite' ),
		'section' => 'appetite_featured_page_two',
		'choices' => array(
			'left' => esc_html__( 'Left', 'appetite' ),
			'right' => esc_html__( 'Right', 'appetite' ),
			'center' => esc_html__( 'Center', 'appetite' ),
		),
		'priority' => 2,
		'description' => esc_html__( 'Choose the position for your page content.', 'appetite' ),
	) );

	/* Front Page: Featured Page #2 Grid Layout */
	$wp_customize->add_setting( 'appetite_featured_page_two_layout', array(
		'default' => '3',
		'sanitize_callback' => 'appetite_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'appetite_featured_page_two_layout', array(
		'type' => 'select',
		'label' => esc_html__( 'Grid Layout', 'appetite' ),
		'section' => 'appetite_featured_page_two',
		'choices' => array(
			'2' => esc_html__( 'Two Columns', 'appetite' ),
			'3' => esc_html__( 'Three Columns', 'appetite' ),
		),
		'priority' => 3,
		'description' => esc_html__( 'Choose the layout for the grid items.', 'appetite' ),
	) );

	/* Front Page: Featured Page #3 section */
	$wp_customize->add_section( 'appetite_featured_page_three', array(
		 'title' => esc_html__( 'Front Page: Featured Page #3', 'appetite' ),
		 'priority' => 4,
		 'panel' => 'appetite_theme_panel',
		 'description' => esc_html__( 'In order to display a grid layout in this section, you need to select a page that has child pages.', 'appetite' ),
		 'active_callback' => 'appetite_is_front_page_template',
	) );

	/* Front Page: Featured Page #3 ID */
	$wp_customize->add_setting( 'appetite_featured_page_three_id', array(
		'default' => '0',
		'sanitize_callback' => 'appetite_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'appetite_featured_page_three_id', array(
		'label' => esc_html__( 'Featured Page', 'appetite' ),
		'section' => 'appetite_featured_page_three',
		'priority' => 1,
		'type' => 'dropdown-pages',
	) );

	/* Front Page: Featured Page #3 Content Position */
	$wp_customize->add_setting( 'appetite_featured_page_three_align', array(
		'default' => 'right',
		'sanitize_callback' => 'appetite_sanitize_content_position',
	) );

	$wp_customize->add_control( 'appetite_featured_page_three_align', array(
		'type' => 'select',
		'label' => esc_html__( 'Content Position', 'appetite' ),
		'section' => 'appetite_featured_page_three',
		'choices' => array(
			'left' => esc_html__( 'Left', 'appetite' ),
			'right' => esc_html__( 'Right', 'appetite' ),
			'center' => esc_html__( 'Center', 'appetite' ),
		),
		'priority' => 2,
		'description' => esc_html__( 'Choose the position for your page content.', 'appetite' ),
	) );

	/* Front Page: Featured Page #3 Grid Layout */
	$wp_customize->add_setting( 'appetite_featured_page_three_layout', array(
		'default' => '3',
		'sanitize_callback' => 'appetite_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'appetite_featured_page_three_layout', array(
		'type' => 'select',
		'label' => esc_html__( 'Grid Layout', 'appetite' ),
		'section' => 'appetite_featured_page_three',
		'choices' => array(
			'2' => esc_html__( 'Two Columns', 'appetite' ),
			'3' => esc_html__( 'Three Columns', 'appetite' ),
		),
		'priority' => 3,
		'description' => esc_html__( 'Choose the layout for the grid items.', 'appetite' ),
	) );

	/* Front Page: Blog Posts */
	 $wp_customize->add_section( 'appetite_front_posts', array(
		 'title' => esc_html__( 'Front Page: Blog Posts', 'appetite' ),
		 'priority' => 4,
		 'panel' => 'appetite_theme_panel',
		 'active_callback' => 'appetite_is_front_page_template',
	) );

	/* Front Page: Blog Posts Visibility */
	$wp_customize->add_setting( 'appetite_front_posts_visibility', array(
		'default' => '',
		'sanitize_callback' => 'appetite_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'appetite_front_posts_visibility', array(
		'label' => esc_html__( 'Display Recent Blog Posts', 'appetite' ),
		'section' => 'appetite_front_posts',
		'priority' => 1,
		'type' => 'checkbox',
		'description' => esc_html__( 'If left checked then recent blog posts will be shown on a custom Front Page template.', 'appetite' ),
	) );

	/* Front Page: Blog Posts Section Title */
	$wp_customize->add_setting( 'appetite_front_posts_title', array(
		'default' => esc_html__( 'Recent News', 'appetite' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'appetite_front_posts_title', array(
		'label' => esc_html__( 'Section Title', 'appetite' ),
		'section' => 'appetite_front_posts',
		'type' => 'text',
		'priority' => 2,
	) );

	/* Front Page: Number of blog posts to show */
	$wp_customize->add_setting( 'appetite_front_posts_number', array(
		'default' => '6',
		'sanitize_callback' => 'appetite_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'appetite_front_posts_number', array(
		'label' => esc_html__( 'Number of posts to show', 'appetite' ),
		'section' => 'appetite_front_posts',
		'type' => 'number',
		'priority' => 3,
		'description' => esc_html__( 'Enter a number of posts you want to show in this section.', 'appetite' ),
	) );

	/* Front Page: Blog Posts Layout */
	$wp_customize->add_setting( 'appetite_front_posts_layout', array(
		'default' => '3',
		'sanitize_callback' => 'appetite_sanitize_numeric_value',
	) );

	$wp_customize->add_control( 'appetite_front_posts_layout', array(
		'type' => 'select',
		'label' => esc_html__( 'Section Layout', 'appetite' ),
		'section' => 'appetite_front_posts',
		'choices' => array(
			'2' => esc_html__( 'Two Columns', 'appetite' ),
			'3' => esc_html__( 'Three Columns', 'appetite' ),
		),
		'priority' => 4,
		'description' => esc_html__( 'Select a layout that you want to have for this section.', 'appetite' ),
	) );

	/* Front Page: Testimonials */
	$wp_customize->add_section( 'appetite_front_testimonials', array(
		 'title' => esc_html__( 'Front Page: Testimonials', 'appetite' ),
		 'priority' => 5,
		 'panel' => 'appetite_theme_panel',
		 'active_callback' => 'appetite_is_front_page_template',
	) );

	/* Front Page: Testimonials Visibility */
	$wp_customize->add_setting( 'appetite_front_testimonials_visibility', array(
		'default' => '',
		'sanitize_callback' => 'appetite_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'appetite_front_testimonials_visibility', array(
		'label' => esc_html__( 'Display Testimonials', 'appetite' ),
		'section' => 'appetite_front_testimonials',
		'priority' => 1,
		'type' => 'checkbox',
		'description' => esc_html__( 'If left checked then five random testimonials will be shown on a custom Front Page template.', 'appetite' ),
	) );
}
add_action( 'customize_register', 'appetite_customize_register' );

/**
 * Sanitize a numeric value
 */
function appetite_sanitize_numeric_value( $input ) {
	if ( is_numeric( $input ) ) {
		return intval( $input );
	} else {
		return 0;
	}
}

/**
 * Sanitize content position
 */
function appetite_sanitize_content_position( $input ) {
	if ( in_array( $input, array( 'left', 'right', 'center' ) ) ) {
		return $input;
	} else {
		return 'right';
	}
}

/**
 * Sanitize the checkbox value.
 */
function appetite_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Sanitize sidebar position
 */
function appetite_sanitize_sidebar_position( $input ) {
	if ( in_array( $input, array( 'left', 'right' ) ) ) {
		return $input;
	} else {
		return 'right';
	}
}

/**
 * Active Callback: Check if user is previewing the Front Page template.
 */
function appetite_is_front_page_template() {
	$is_template = preg_match( '%front-page.php%', get_post_meta( get_the_ID(), '_wp_page_template', true ) );

	if ( 0 !== $is_template ) {
		return true;
	}

	return false;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function appetite_customize_preview_js() {
	wp_enqueue_script( 'appetite_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20171105', true );
}
add_action( 'customize_preview_init', 'appetite_customize_preview_js' );

/**
 * Load custom scripts for Theme Customizer controls.
 */
function appetite_enqueue_customizer_scripts() {
	wp_enqueue_script( 'appetite-customizer-options-script', get_template_directory_uri() . '/js/customizer-theme-options.js', array( 'jquery', 'customize-controls', 'underscore' ), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'appetite_enqueue_customizer_scripts' );
