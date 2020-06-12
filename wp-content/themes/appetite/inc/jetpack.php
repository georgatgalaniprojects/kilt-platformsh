<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Appetite
 */
function appetite_jetpack_setup() {
	/**
	 * Add theme support for Infinite Scroll.
	 * See: http://jetpack.me/support/infinite-scroll/
	 */
	 add_theme_support( 'infinite-scroll', array(
 		'container' => 'main',
 		'render' => 'appetite_infinite_scroll_render',
 		'footer' => 'page',
 		'footer_widgets' => 'footer-1',
 	) );

	/**
	 * Add support for content options.
	 */
	add_theme_support( 'jetpack-content-options', array(
	    'blog-display' => 'content',
	    'post-details' => array(
	        'stylesheet' => 'appetite-style',
	        'date' => '.posted-on',
	        'categories' => '.cat-links',
	        'tags' => '.tags-links',
	        'author' => '.byline',
	        'comment' => '.comments-link',
	    ),
	) );

	/**
	 * Add site logo support.
	 */
	add_theme_support( 'site-logo', array( 'size' => 'large' ) );

	/**
 	 * Add support for Testimonial Post Type.
     */
    add_theme_support( 'jetpack-testimonial' );

    /**
 	 * Add responsive videos support.
     */
	add_theme_support( 'jetpack-responsive-videos' );

	/**
	 * Add support for the Nova CPT (menu items).
	 */
	add_theme_support( 'nova_menu_item' );

	/**
	 * Add support for featured content.
	 */
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'appetite_featured_posts',
		'max_posts' => 8,
		'post_types' => array( 'post', 'page' )
	) );
}
add_action( 'after_setup_theme', 'appetite_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function appetite_infinite_scroll_render() {
	if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', 'testimonial' );
		}
	} else {
		if ( is_search() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'search' );
			}
		} else {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', get_post_format() );
			}
		}
	}
} // end function appetite_infinite_scroll_render
