<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Appetite
 */

get_header(); ?>

<div <?php appetite_primary_header_attrs( 'global' ); ?>>
	<?php appetite_primary_header_image( 'global' ); ?>

	<?php if ( ! is_product() ) : ?>
	<div class="container">
		 <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
	</div><!-- .container -->
	<?php endif; ?>
</div><!-- #primary-header -->

<div class="container">
	<div class="row">
		<div id="primary" class="content-area <?php echo esc_attr( appetite_get_blog_primary_class() ); ?>">
			<main id="main" class="site-main" role="main">
				<?php woocommerce_content(); ?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>
	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
