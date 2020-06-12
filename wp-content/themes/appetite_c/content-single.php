<?php
/**
 * @package Appetite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php appetite_entry_footer(); ?>

		<?php get_template_part( 'parts/author', 'section' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
