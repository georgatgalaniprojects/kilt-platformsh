<?php
/**
 * This template displays recent posts on the Front Page tempalate.
 *
 * @package Appetite
 */

// Check if user wants to display this section
if ( get_theme_mod( 'appetite_front_posts_visibility', '' ) ) :

	$count = 0;
	$section_layout = get_theme_mod( 'appetite_front_posts_layout', '3' );
	$column_class = esc_attr( appetite_featured_page_grid_column_class( $section_layout ) );

	$recent_posts = new WP_Query( array(
		'post_type' => 'post',
		'posts_per_page' => absint( get_theme_mod( 'appetite_front_posts_number', '6' ) ),
		'ignore_sticky_posts' => 1,
		'no_found_rows' => true,
	) );

	if ( $recent_posts->have_posts() ) : ?>

	<section class="widget front-page-block front-recent-posts">
		<div class="container">
			<h4 class="entry-title grid-page-title">
				<?php echo esc_html( get_theme_mod( 'appetite_front_posts_title', esc_html__( 'Recent News', 'appetite' ) ) ); ?>
			</h4><!-- .entry-title -->

			<div class="row grid-wrapper">
			<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>

				<div class="recent-post <?php echo $column_class; ?>">
					<?php get_template_part( 'content', 'front-post' ); ?>
				</div><!-- .recent-post -->

				<?php
				$count++;

				if ( 0 === $count % $section_layout ) {
					echo '<span class="grid-sep"></span>';
				}

			endwhile; ?>
			</div><!-- .row.grid-wrapper -->
		</div><!-- .container -->
	</section><!-- .front-recent-posts -->

	<?php
	endif;

	wp_reset_postdata();

endif;
