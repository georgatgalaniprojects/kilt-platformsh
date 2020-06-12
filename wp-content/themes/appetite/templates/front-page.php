<?php
/**
 * Template Name: Front Page
 *
 * @package Appetite
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div class="hero">
		<?php
		if ( appetite_has_featured_posts() ) :
			get_template_part( 'featured-content' );
		else :
			get_template_part( 'parts/hero-default' );
		endif; ?>
	</div><!-- .hero -->
<?php endwhile; ?>

<div class="homepage-widgets">
    <?php
        get_template_part( 'parts/featured-page-one' );
        get_template_part( 'parts/featured-page-two' );
        get_template_part( 'parts/featured-page-three' );
        get_template_part( 'parts/front-recent-posts' );
        get_template_part( 'parts/front-testimonials' );
    ?>
</div><!-- .homepage-widgets -->

<?php
get_footer();
