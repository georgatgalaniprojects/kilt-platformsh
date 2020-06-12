<?php
/**
 * The template used for displaying content for grid pages.
 *
 * @package Appetite
 */

/**
 * Add more button to the grid post
 * http://codex.wordpress.org/Customizing_the_Read_More#How_to_use_Read_More_in_Pages
 */
global $more;
$more = 0; ?>

<article <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ): ?>
		<div class="entry-thumb">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="thumb-link">
			<?php
                the_post_thumbnail( 'appetite-standard-image' );
                $image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
            ?>
			</a><!-- .thumb-link -->
		</div><!-- .entry-thumb -->
        <?php else: ?>
            <?php $image_caption = ''; ?>
        <?php endif; ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

        <?php if( '' != $image_caption ): ?>
        <div class="entry-sub-title"><?php echo esc_html( $image_caption ); ?></div>
        <?php endif; ?>
    </header><!-- .entry-header -->

	<div class="entry-content">
        <?php
			the_content( sprintf(
				wp_kses( __( 'Read More %s', 'appetite' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- .hentry -->
