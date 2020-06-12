<?php
/**
 * The template for displaying featured content ( Homepage Slideshow )
 *
 * @package appetite
 */

$featured_posts = appetite_get_featured_posts(); ?>

<div id="primary-header">
	<div class="featured-image"></div><!-- .featured-image -->

	<div class="featured-content" <?php appetite_featured_content_data_tags(); ?>>
	<?php
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );
			get_template_part( 'parts/hero-slideshow' );
		endforeach;
		wp_reset_postdata();
	?>
	</div><!-- .featured-content -->
</div><!-- #primary-header -->
