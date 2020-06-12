<?php
/**
 * The template for displaying all single testimonial posts.
 *
 * @package Appetite
 */

get_header();

// Get testimonials settings.
$jetpack_options = get_theme_mod( 'jetpack_testimonials' ); ?>

<?php while ( have_posts() ) : the_post(); ?>
<div <?php appetite_primary_header_attrs( 'testimonial', $jetpack_options ); ?>>
	<?php appetite_primary_header_image( 'testimonial', $jetpack_options ); ?>

	<div class="container">
		<?php if ( has_post_thumbnail() ): ?>
		<div class="entry-thumb">
			<?php the_post_thumbnail(); ?>
		</div><!-- .entry-thumb -->
		<?php endif; ?>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</div><!-- .container -->

</div><!-- #primary-header -->
<?php
endwhile;

rewind_posts(); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="content-area <?php echo esc_attr( appetite_get_blog_primary_class() ); ?>">
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'content', 'page' );

					the_post_navigation( array(
						'next_text' => '<span class="meta-nav primary-font">' . esc_html__( 'Next', 'appetite' ) . '</span> <span class="post-title">%title</span>',
						'prev_text' => '<span class="meta-nav primary-font">' . esc_html__( 'Previous', 'appetite' ) . '</span> <span class="post-title">%title</span>',
					) );

				endwhile; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
