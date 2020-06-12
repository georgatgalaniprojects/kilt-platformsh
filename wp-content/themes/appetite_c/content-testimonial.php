<?php
/**
 * The template used for displaying testimonials.
 *
 * @package Appetite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="clearfix">
		<?php if ( has_post_thumbnail() ): ?>
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="thumb-link alignleft">
		<?php the_post_thumbnail(); ?>
		</a><!-- .thumb-link -->
		<?php endif; ?>

		<div class="frame">
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php
					/* translators: %s: Name of current post */
                    the_content( sprintf(
                        wp_kses( __( 'Read More %s', 'appetite' ), array( 'span' => array( 'class' => array() ) ) ),
                        the_title( '<span class="screen-reader-text">"', '"</span>', false )
                    ) );
				?>
			</div><!-- .entry-content -->
		</div><!-- .frame -->
	</div><!-- .clearfix -->
</article><!-- #post-## -->