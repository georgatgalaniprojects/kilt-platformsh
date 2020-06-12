<?php
/**
 * The template used for displaying home slidehsow content in front-page.php
 *
 * @package Appetite
 */
?>

<div class="featured-slide" data-slide-img="<?php echo esc_url( appetite_get_primary_header_image_url() ); ?>">
	<div class="container">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<div class="taxonomy-description">
		<?php
			/* translators: %s: Name of current post */
			 the_content( sprintf(
                wp_kses( __( 'Read More %s', 'appetite' ), array( 'span' => array( 'class' => array() ) ) ),
                the_title( '<span class="screen-reader-text">"', '"</span>', false )
            ) );
		?>
		</div><!-- .taxonomy-description -->
	</div><!-- .container -->
</div><!-- .featured-slide -->
