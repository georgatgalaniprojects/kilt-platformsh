<?php
/**
 * The template for displaying search results pages.
 *
 * @package Appetite
 */

get_header(); ?>

<div <?php appetite_primary_header_attrs( 'global' ); ?>>
	<?php appetite_primary_header_image( 'global' ); ?>

	<div class="container">
	<?php if ( have_posts() ) : ?>
		<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'appetite' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	<?php else: ?>
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'appetite' ); ?></h1>
	<?php endif; ?>
	</div><!-- .container -->
</div><!-- #primary-header -->

<div class="container">
	<div class="row">
		<section id="primary" class="content-area <?php echo esc_attr( appetite_get_blog_primary_class() ); ?>">
			<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :

				while ( have_posts() ) : the_post();

					get_template_part( 'content', 'search' );

				endwhile;

				the_posts_pagination( array( 'mid_size' => 2 ) );

			else :

				get_template_part( 'content', 'none' );

			endif; ?>

			</main><!-- #main -->
		</section><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
