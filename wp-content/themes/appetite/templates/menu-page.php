<?php
/**
 * Template Name: Menu Page
 * The template for displaying menu items.
 *
 * @package Appetite
 */

get_header();

get_template_part( 'parts/single', 'page-header' ); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="content-area <?php echo esc_attr( appetite_get_blog_primary_class() ); ?>">
			<main id="main" class="site-main" role="main">

				<?php if ( appetite_has_content() ) : ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php
				endif;

				$menu_items = new WP_Query( array(
					'post_type' => 'nova_menu_item',
				) );

				if ( $menu_items->have_posts() ) : ?>

					<div class="menu-wrapper clearfix">
					<?php
					while ( $menu_items->have_posts() ) : $menu_items->the_post();

						get_template_part( 'content', 'menu' );

					endwhile; ?>
					</div><!-- .menu-wrapper -->

				<?php
				endif;

				wp_reset_postdata(); ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
