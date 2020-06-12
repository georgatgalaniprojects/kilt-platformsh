<?php
/**
 * Template Name: Grid Page (Full Width)
 *
 * @package Appetite
 */

get_header();

get_template_part( 'parts/single', 'page-header' ); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="content-area col-lg-12">
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();

					if ( appetite_has_content() ) : ?>
					<div class="grid-main-entry">
						<?php get_template_part( 'content', 'page' ); ?>
					</div><!-- .grid-main-entry -->
					<?php endif;

				endwhile; // have_posts()

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

						<div class="grid-item three-columns col-lg-4 col-md-4">
							<?php get_template_part( 'content', 'grid' ); ?>
						</div><!-- .grid-item -->

						<?php $count++; ?>

						<?php if ( 0 == $count % 3 ) : ?>
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
	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
