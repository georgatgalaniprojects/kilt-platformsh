<?php
/**
 * This template displays the content for the Featured Page #0
 *
 * @package Appetite
 */

$page_id = get_theme_mod( 'appetite_featured_page_zero_id', '0' );

// Check if user has selected a page
if( $page_id > 0 ):

	$count = 0;
	$has_subpages = appetite_has_subpages( $page_id );
	$page_query = appetite_featured_page_query( $page_id, $has_subpages );

	if ( $page_query->have_posts() ) : ?>

	<section class="widget front-page-block featured-page-zero">
		<div class="container">

			<?php if( $has_subpages ): ?>

                <?php
                    $section_layout = get_theme_mod( 'appetite_featured_page_zero_layout', '3' );
	                $column_class = esc_attr( appetite_featured_page_grid_column_class( $section_layout ) );
                ?>

                <h2 class="entry-title grid-page-title"><?php echo esc_html( get_the_title( $page_id ) ); ?></h2>

				<div class="row grid-wrapper">
				<?php while ( $page_query->have_posts() ) : $page_query->the_post(); ?>

					<div class="grid-item <?php echo $column_class; ?>">
						<?php get_template_part( 'content', 'grid' ); ?>
					</div><!-- .grid-item -->

					<?php $count++; ?>
					<?php if( 0 == $count % $section_layout ) echo '<span class="grid-sep"></span><!-- .grid-sep -->'; ?>

				<?php endwhile; ?>
				</div><!-- .row.grid-wrapper -->

			<?php else: ?>

				<?php while ( $page_query->have_posts() ) : $page_query->the_post(); ?>
				    <?php get_template_part( 'parts/featured-pages/content', 'zero' ); ?>
				<?php endwhile; ?>

			<?php endif; ?>

		</div><!-- .container -->
	</section><!-- .featured-page-zero -->

	<?php wp_reset_postdata(); ?>

	<?php endif; ?>
<?php endif; ?>