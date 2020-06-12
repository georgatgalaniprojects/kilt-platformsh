<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Appetite
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( '1' === $comments_number ) {
					esc_html_e( 'One comment', 'appetite' );
				} else {
					printf( _n( '%s comment', '%s comments', $comments_number, 'appetite' ), number_format_i18n( $comments_number ) ); // WPCS: XSS OK.
				}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style' => 'ol',
					'short_ping' => true,
					'avatar_size' => 96,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

	endif; // have_comments()

	if ( ! comments_open() ) :
		printf( '<p class="no-comments">%s</p>', esc_html__( 'Comments are closed.', 'appetite' ) ); // WPCS: XSS OK.
	endif;
	comment_form(); ?>

</div><!-- #comments -->
