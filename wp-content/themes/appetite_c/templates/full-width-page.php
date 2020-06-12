<?php
/**
 * Template Name: Full Width Page
 *
 * @package Appetite
 */

get_header();

get_template_part( 'parts/single', 'page-header' ); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="content-area col-lg-12">
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'content', 'page' );

                	if ( comments_open() || get_comments_number() ) :
                        comments_template();
                	endif;

				endwhile; ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
