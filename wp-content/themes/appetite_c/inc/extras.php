<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Appetite
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function appetite_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'inactive-sidebar';
	} else {
        // Add a class if a sidebar is located on the left side of the site.
		if ( appetite_is_left_sidebar() ) {
			$classes[] = 'left-sidebar';
		}
    }

    // Add a class if user set a custom background.
	if ( appetite_is_custom_background() ) {
		$classes[] = 'has-custom-background';
	}

    // Add a class if the header image is not set.
    if ( ! get_header_image() ) {
        $classes[] = 'inactive-header-image';
    }

	// Adds a class if the user is visiting using a mobile device.
	if ( wp_is_mobile() ) {
		$classes[] = 'mobile-view';
	}

	return $classes;
}
add_filter( 'body_class', 'appetite_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function appetite_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'appetite_pingback_header' );

/**
 * Returns a class for the #primary div based on sidebar visibility.
 *
 * @since appetite 1.0
 */
function appetite_get_blog_primary_class() {
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		return "col-lg-12";
	} else {
		if ( appetite_is_left_sidebar() ) {
			return "pull-right col-lg-8 col-md-8";
		} else {
			return "col-lg-8 col-md-8";
		}
	}
}

/**
 * Checks if user wants to move the sidebar to the left.
 *
 * @since appetite 1.0
 */
function appetite_is_left_sidebar() {
	if ( 'left' === get_theme_mod( 'appetite_sidebar_position', 'right' ) ) {
		return true;
	}

	return false;
}

/**
 * Returns a custom query for the featured page section.
 *
 * @since appetite 1.0
 */
function appetite_featured_page_query( $page_id = 0, $has_subpages = false ) {
 	// Create a query based on the page template
 	if ( $has_subpages ) {
 		// Grid Page Query
 		return new WP_Query( array(
 			'post_type' => 'page',
 			'orderby' => array( 'menu_order' => 'ASC', 'date' => 'DESC'),
 			'order' => 'ASC',
 			'post_parent' => $page_id,
 			'posts_per_page' => 99,
 			'no_found_rows' => true,
 		) );
 	} else {
 		// Regular Page Query
 		return new WP_Query( array(
 			'post_type' => 'page',
 			'page_id' => $page_id,
 			'no_found_rows'  => true,
 		) );
 	}
}

/**
 * Returns a column class for the grid items.
 *
 * @since appetite 1.0
 */
function appetite_featured_page_grid_column_class( $layout = 3 ) {
	if ( 3 == $layout ) {
		return 'col-lg-4 col-md-4 three-columns';
	} else {
		return 'col-lg-6 col-md-6 two-columns';
	}
 }

/**
 * This function returns a column classes for the featured page
 *
 * @since appetite 1.0
 */
function appetite_featured_page_column_class( $position = 'right', $section = '' ) {
    if ( 'center' !== $position ) {
        if ( 'left' === $position && 'thumb' === $section ) {
            return 'col-lg-6 col-md-6 pull-right';
        } else {
            return 'col-lg-6 col-md-6';
        }
    } else {
        return 'col-lg-12';
    }
}

/**
 * Checks if user has set a custom background.
 *
 * @since appetite 1.0
 */
function appetite_is_custom_background() {
	$background_color = get_background_color();
	$background_image = get_background_image();

	if ( ( $background_color && 'ffffff' !== $background_color ) || $background_image ) {
		return true;
	}

	return false;
}

/**
 * Display page-links for paginated posts before jetpack share buttons and related posts.
 *
 * @since appetite 1.0
 */
function appetite_custom_link_pages( $content ) {
	if ( is_singular() ) {
		$content .= wp_link_pages( array(
			'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'appetite' ) . '</span>',
			'after' => '</div>',
			'link_before' => '<span>',
			'link_after' => '</span>',
			'echo' => 0,
		) );
	}

	return $content;
}
add_filter( 'the_content', 'appetite_custom_link_pages', 1 );

/**
 * Checks if the current page has subpages.
 *
 * @since appetite 1.0
 */
function appetite_has_subpages( $page_id = 0 ) {
    $children = get_children( array(
        'post_parent' => $page_id,
        'post_type' => 'page',
        'post_status'=> 'publish',
    ) );

    if ( count( $children ) > 0 ) {
        return true;
    }

	return false;
}

/**
 * Print Featured Content HTML data tags.
 */
function appetite_featured_content_data_tags() {
	$data = array();
	$attr = array(
		'data-transition-speed' => get_theme_mod( 'appetite_featured_content_transition_speed', '300' ),
		'data-autoplay' => get_theme_mod( 'appetite_is_autoplay_featured_content', '' ),
	);

	$attr = array_map( 'esc_attr', $attr );

	foreach( $attr as $key => $value ) {
		if ( $value ) {
			$data[] = $key . '=' . $value;
		}
	}

	printf( '%s', join( ' ', $data ) ); // WPCS: XSS OK.
}

/**
 * Returns the URL of featured image displayed in the primary header section.
 *
 * @param string $type Type of the post for which we need to get the URL.
 * @param array $options Specific option for the selected type.
 * @return string
 */
function appetite_get_primary_header_image_url( $type = false, $options = false ) {
	$image_url = '';

	// Are we looking for the specific type of featured image?
	if ( ! empty( $type ) ) {
		if ( 'global' === $type ) {
			// Display featured image URL for archive views.
			return get_header_image();

		} else if ( 'testimonial' === $type ) {
			// Get testimonial options if needed.
			if ( ! isset( $options ) ) {
				$options = get_theme_mod( 'jetpack_testimonials' );
			}
			// Get the URL of the testimonial image.
			if ( isset( $options['featured-image'] ) && '' !== $options['featured-image'] ) {
				$image_url = esc_url( wp_get_attachment_url( (int)$options['featured-image'] ) );
			}
		}
	} else {
		// Display featured image URL for post and page types.
		if ( has_post_thumbnail() ) {
			$image_url = esc_url( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) );
		}
	}

	// Check for header image as a fallback.
	if ( '' === $image_url && get_header_image() ) {
		$image_url = get_header_image();
	}

	return $image_url;
}

/**
 * Prints attributes (id and class) for the primary header section.
 *
 * @param string $type Type of the post for which we need to get the URL.
 * @param array $options Specific option for the selected type.
 */
function appetite_primary_header_attrs( $type = false, $options = false ) {
	if ( '' !== appetite_get_primary_header_image_url( $type, $options ) ) {
		$attrs = 'id="primary-header" class="has-background"';
	} else {
		$attrs = 'id="primary-header"';
	}

	printf( '%s', $attrs ); // WPCS: XSS OK.
}

/**
 * Prints featured image HTML for the primary header section.
 *
 * @param string $type Type of the post for which we need to get the URL.
 * @param array $options Specific option for the selected type.
 */
function appetite_primary_header_image( $type = false, $options = false ) {
	$image_url = appetite_get_primary_header_image_url( $type, $options );

	if ( '' !== $image_url ) {
		printf( '<div class="featured-image" style="background-image: url(%s);"></div>', $image_url ); // WPCS: XSS OK.
	}
}

/**
 * Checks if the current post has a content.
 *
 * @return bool
 */
function appetite_has_content() {
	return '' !== get_post_field( 'post_content', get_the_ID() ) ? true : false;
}

/**
 * Deprecated: Check if user wants to hide blog sidebar.
 * This function will be removied in the future theme release.
 * Update your child theme if needed.
 */
function appetite_is_hidden_sidebar() {}

/**
 * Deprecated: Check if user wants to hide blog sidebar.
 * This function will be removied in the future theme release.
 * Update your child theme if needed.
 */
function appetite_numeric_pagination( $pages = '', $range = 2 ) {}
