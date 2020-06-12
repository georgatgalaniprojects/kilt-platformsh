<?php
/**
 * Template Name: Grid Page
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

					if ( appetite_has_content() ) : ?>
					<div class="grid-main-entry">
						<?php get_template_part( 'content', 'page' ); ?>
					</div><!-- .grid-main-entry -->
					<?php endif;

				endwhile;

				$count = 0;
				$child_pages = new WP_Query( array(
					'post_type' => 'page',
					'orderby' => array( 'menu_order' => 'ASC', 'date' => 'DESC'),
					'order' => 'ASC',
					'post_parent' => get_the_ID(),
					'posts_per_page' => 99,
					'no_found_rows' => true,
				) );

				if ( $child_pages->have_posts() && ! post_password_required() ) : ?>

					<div class="row grid-wrapper">
					<?php while ( $child_pages->have_posts() ) : $child_pages->the_post(); ?>

						<div class="grid-item two-columns col-lg-6 col-md-6">
							<?php get_template_part( 'content', 'grid' ); ?>
						</div><!-- .grid-item -->

						<?php $count++; ?>

						<?php if ( 0 == $count % 2 ) : ?>
							<span class="grid-sep"></span><!-- .grid-sep -->
						<?php endif; ?>

					<?php endwhile; ?>
					</div><!-- .row.grid-wrapper -->
				<?php
				endif;

				wp_reset_postdata();

				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
