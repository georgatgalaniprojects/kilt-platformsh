<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Appetite
 */

get_header(); ?>

<div <?php appetite_primary_header_attrs( 'global' ); ?>>
	<?php appetite_primary_header_image( 'global' ); ?>
	<div class="container">
        <h1 class="page-title"><?php esc_html_e( 'Oops! That page can\'t be found.', 'appetite' ); ?></h1>
	</div><!-- .container -->
</div><!-- #primary-header -->

<div id="primary" class="content-area container">
    <main id="main" class="site-main" role="main">
        <section class="error-404 not-found">
            <div class="page-content">
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'appetite' ); ?></p>
                <?php get_search_form(); ?>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
