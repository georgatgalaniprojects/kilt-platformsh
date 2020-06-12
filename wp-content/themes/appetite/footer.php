<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Appetite
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">

			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="footer-inner">
				<div class="row footer-widget-area">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div><!-- .footer-widget-area -->
			</div><!-- .footer-inner -->
			<?php endif; ?>

			<?php if ( has_nav_menu( 'social' ) ) : ?>
			<div class="footer-social">
				<?php get_template_part( 'menu', 'social' ); ?>
			</div><!-- .footer-social -->
			<?php endif; ?>

			<div class="site-copyright">
				<?php echo date('Y'); ?>
				<?php bloginfo( 'name' ); ?>
				<?php appetite_custom_footer_text(); ?>
			</div><!-- .site-copyright -->

			<div class="site-info">
                <?php appetite_footer_output(); ?>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
