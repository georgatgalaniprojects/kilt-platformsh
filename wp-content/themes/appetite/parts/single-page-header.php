<?php
/**
 * The part displays single page header.
 *
 * @package Appetite
 */

while ( have_posts() ) : the_post(); ?>

<div <?php appetite_primary_header_attrs(); ?>>
	<?php appetite_primary_header_image(); ?>

	<div class="container">
		<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
			edit_post_link( esc_html__( 'Edit', 'appetite' ), '<div class="entry-meta"><span class="edit-link">', '</span></div>' );
		?>
	</div><!-- .container -->
</div><!-- #primary-header -->

<?php
endwhile;

rewind_posts();
