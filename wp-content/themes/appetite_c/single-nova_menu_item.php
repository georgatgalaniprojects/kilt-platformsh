<?php
/**
 * The template for displaying all single menu items.
 *
 * @package Appetite
 */

get_header();

get_template_part( 'parts/single', 'page-header' ); ?>

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
