<?php
/**
 * The default template for displaying social menu content.
 *
 * @package Appetite
 */

wp_nav_menu( array(
	'theme_location'  => 'social',
	'container_class' => 'social-list',
	'menu_class'      => 'menu-items list-unstyled clearfix',
	'depth'           => 1,
	'link_before'     => '<span class="screen-reader-text social-meta">',
	'link_after'      => '</span>',
) );
