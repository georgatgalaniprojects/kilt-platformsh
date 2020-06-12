<?php
/**
 * The default template for displaying attachment content
 *
 * @package Appetite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
        <div class="entry-attachment wp-caption">
            <?php echo wp_get_attachment_image( get_the_ID(), 'full' );  ?>

            <?php if ( has_excerpt() ) : ?>
            <div class="wp-caption-text">
                <?php the_excerpt(); ?>
            </div><!-- .wp-caption-text -->
            <?php endif; ?>
        </div><!-- .entry-attachment -->
    </div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php appetite_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->