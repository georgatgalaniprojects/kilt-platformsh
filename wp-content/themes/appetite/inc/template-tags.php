<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Appetite
 */

if ( ! function_exists( 'appetite_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function appetite_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'appetite' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'appetite' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on has-icon">' . $posted_on . '</span><span class="byline has-icon"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'appetite_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function appetite_entry_footer() {
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'appetite' ) );
	if ( $tags_list ) {
		printf( '<div class="tags-links">' . esc_html__( 'Tagged: %1$s', 'appetite' ) . '</div>', $tags_list );
	}
}
endif;

if ( ! function_exists( 'appetite_filter_archive_title' ) ) :
/**
 * Add a span around the title prefix so that the prefix can be hidden with CSS if needed.
 *
 * @param string $title Archive title.
 * @return string Archive title with inserted span around prefix.
 */
function appetite_filter_archive_title( $title ) {
	// Split the title into parts so we can wrap them with span tag.
	$title_parts = explode( ': ', $title, 2 );
	// Glue title's parts back together.
	if ( ! empty( $title_parts[1] ) ) {
		// Add a span around the title.
		$title = '<span>' . $title_parts[0] . ': </span>' . $title_parts[1];
		// Sanitize our title.
		$title = wp_kses( $title, array( 'span' => array(), ) );
	}
	return $title;
}
endif;
add_filter( 'get_the_archive_title', 'appetite_filter_archive_title' );

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function appetite_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'appetite_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'appetite_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so appetite_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so appetite_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in appetite_categorized_blog.
 */
function appetite_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'appetite_categories' );
}
add_action( 'edit_category', 'appetite_category_transient_flusher' );
add_action( 'save_post',     'appetite_category_transient_flusher' );

if ( ! function_exists( 'appetite_custom_footer_text' ) ) :
/**
 * Prints custom footer content.
 */
function appetite_custom_footer_text() {
	if ( '' !== ( $footer_text = get_theme_mod( 'appetite_footer_content', '' ) ) ) {
		printf( '<span class="footer-content">%s</span>', wp_kses_post( $footer_text ) );
	}
}
endif;

if ( ! function_exists( 'appetite_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 */
function appetite_the_custom_logo() {
	if ( function_exists( 'jetpack_the_site_logo' ) ) {
		jetpack_the_site_logo();
	}
}
endif;

/**
 * Deprecated: Display navigation to next/previous set of posts when applicable.
 * This function will be removied in the future theme release.
 * Update your child theme if needed.
 */
function appetite_paging_nav() {}
