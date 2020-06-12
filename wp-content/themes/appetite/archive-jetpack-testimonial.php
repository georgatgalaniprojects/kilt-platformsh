<?php
/**
 * The template for displaying archive pages.
 *
 * @package Appetite
 */

get_header();

// Get testimonials settings.
$jetpack_options = get_theme_mod( 'jetpack_testimonials' ); ?>

<div <?php appetite_primary_header_attrs( 'testimonial', $jetpack_options ); ?>>
	<?php appetite_primary_header_image( 'testimonial', $jetpack_options ); ?>

	<div class="container">
		<h1 class="page-title">
		<?php
			if ( isset( $jetpack_options['page-title'] ) && '' != $jetpack_options['page-title'] ) {
				echo esc_html( $jetpack_options['page-title'] );
			} else {
				esc_html_e( 'Testimonials', 'appetite' );
			}
		?>
		</h1>

		<?php
		// Show an optional testimonial description.
		if ( isset( $jetpack_options['page-content'] ) && '' != $jetpack_options['page-content'] ) : ?>
		<div class="taxonomy-description">
			<?php echo convert_chars( convert_smilies( wptexturize( wp_kses_post( $jetpack_options['page-content'] ) ) ) ); ?>
		</div><!-- .taxonomy-description -->
		<?php endif; ?>
	</div><!-- .container -->
</div><!-- #primary-header -->

<div class="container">
	<div class="row">
		<section id="primary" class="content-area col-lg-12">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<div id="testimonial-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="single-testimonial">
					<?php get_template_part( 'content', 'testimonial' ); ?>
					</div><!-- .single-testimonial -->
				<?php endwhile; ?>
				</div><!-- .testimonial-grid -->

				<?php the_posts_pagination( array( 'mid_size' => 2 ) ); ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</section><!-- #primary -->
	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
