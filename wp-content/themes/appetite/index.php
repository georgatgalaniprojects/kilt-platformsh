<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Appetite
 */

get_header(); ?>

<div <?php appetite_primary_header_attrs( 'global' ); ?>>
	<?php appetite_primary_header_image( 'global' ); ?>

	<div class="container">
	<?php if ( 'page' == get_option( 'show_on_front' ) && '0' != get_option( 'page_for_posts' ) ) : ?>
		<h1 class="page-title"><?php echo get_the_title( get_option( 'page_for_posts' ) ); ?></h1>
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
