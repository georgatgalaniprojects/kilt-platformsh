<?php
/**
 * The template for displaying all single posts.
 *
 * @package Appetite
 */

get_header();

get_template_part( 'parts/single', 'post-header' ); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="content-area <?php echo esc_attr( appetite_get_blog_primary_class() ); ?>">
			<main id="main" class="site-main" role="main">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'content', 'single' );

					if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                    the_post_navigation( array(
                        'next_text' => '<span class="meta-nav primary-font">' . esc_html__( 'Next', 'appetite' ) . '</span> <span class="post-title">%title</span>',
                        'prev_text' => '<span class="meta-nav primary-font">' . esc_html__( 'Previous', 'appetite' ) . '</span> <span class="post-title">%title</span>',
                    ) );

				endwhile; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php
get_footer();
