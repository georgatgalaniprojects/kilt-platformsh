<?php
/**
 * The part displays single post header.
 *
 * @package Appetite
 */

while ( have_posts() ) : the_post(); ?>

<div <?php appetite_primary_header_attrs(); ?>>
	<?php appetite_primary_header_image(); ?>

	<div class="container">
		<div class="entry-cats cat-links has-icon">
			<?php echo get_the_category_list( '<span class="sep">/</span>' ); ?>
		</div><!-- .entry-cats -->

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php appetite_posted_on(); ?>

			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
			<span class="comments-link has-icon"><?php comments_popup_link( esc_html__( 'Leave a comment', 'appetite' ), esc_html__( '1 Comment', 'appetite' ), esc_html__( '% Comments', 'appetite' ) ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( esc_html__( 'Edit', 'appetite' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</div><!-- .container -->
</div><!-- #primary-header -->

<?php
endwhile;

rewind_posts();
