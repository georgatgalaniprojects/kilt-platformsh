<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Appetite
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
} ?>

<div class="col-lg-4 col-md-4 sidebar-section">
	<div id="secondary" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- #secondary -->
</div><!-- .sidebar-section -->
