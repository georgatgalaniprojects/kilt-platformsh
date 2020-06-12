<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Appetite
 */

get_header(); ?>

<div <?php appetite_primary_header_attrs( 'global' ); ?>>
	<?php appetite_primary_header_image( 'global' ); ?>
	<div class="container">
	<?php
		if ( have_posts() ) :

			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );

		else : ?>

			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can\'t be found.', 'appetite' ); ?></h1>

	<?php endif; ?>
	</div><!-- .container -->
</div><!-- #primary-header -->

<div class="container">
	<div class="row">
		<div id="primary" class="content-area <?php echo esc_attr( appetite_get_blog_primary_class() ); ?>">
			<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :

				while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

				endwhile;

				the_posts_pagination( array( 'mid_size' => 2 ) );

			else :

				get_template_part( 'content', 'none' );

			endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
