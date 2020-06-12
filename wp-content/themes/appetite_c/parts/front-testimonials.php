<?php
/**
 * This template displays recent testimonials.
 *
 * @package Appetite
 */

// Check if user wants to display this section
if( get_theme_mod( 'appetite_front_testimonials_visibility', '' ) ):

	$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
    $count = 0;
    $testimonial_authors = '';

	$testimonials = new WP_Query( array(
		'post_type'      => 'jetpack-testimonial',
		'posts_per_page' => 30,
		'no_found_rows'  => true,
        'orderby'        => 'rand'
	) );

	if ( $testimonials->have_posts() ): ?>

	<section class="widget front-page-block testimonial-block">

		<div class="container">
			<h4 class="entry-title">
			<?php
				if ( isset( $jetpack_options['page-title'] ) && '' != $jetpack_options['page-title'] ) {
					echo esc_html( $jetpack_options['page-title'] );
				} else {
					esc_html_e( 'Testimonials', 'appetite' );
				}
			?>
			</h4>

			<ul id="testimonial-container" class="bxslider list-unstyled">
			<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>

                <?php if ( has_post_thumbnail() ): ?>
			         <?php $testimonial_authors .= '<li><a data-slide-index="'. esc_attr( $count ) .'" href="#">' . get_the_post_thumbnail() . '</a></li>'; ?>
                <?php else: ?>
			         <?php $testimonial_authors .= '<li class="empty"><a data-slide-index="'. esc_attr( $count ) .'" href="#"></a></li>'; ?>
                <?php endif; ?>
                <li class="testimonial-body">
                    <div class="testimonial-content">
                        <?php echo get_the_content(); ?>
                        <?php the_title( '<div class="testimonial-author">', '</div>' ); ?>
                    </div><!-- .testimonial-content -->
				</li><!-- .testimonial-body -->

                <?php $count++; ?>

			<?php endwhile; ?>		
        
			</ul><!-- #testimonial-container -->
           <div class="testimonial-content">
<div class="testimonial-content more-link-container">
<a class="more-link" href="/testimonial">zum Team</a>
</div>
</div>
            

            <ul id="testimonials-pager" class="testimonial-pager list-unstyled">
                <?php echo $testimonial_authors; ?>
            </ul><!-- .testimonial-pager -->
		</div><!-- .container -->
       
	</section><!-- .testimonial-block -->

	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

<?php endif; ?>