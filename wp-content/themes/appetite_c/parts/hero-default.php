<?php
/**
 * The template used for displaying home content in front-page.php
 *
 * @package Appetite
 */
 
?>

<div <?php appetite_primary_header_attrs(); ?>>
	<?php appetite_primary_header_image(); ?>

	<div class="container">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="taxonomy-description">
			<?php the_content(); ?>
		</div><!-- .taxonomy-description -->
	</div><!-- .container -->
</div><!-- #primary-header -->
