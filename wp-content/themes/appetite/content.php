<?php
/**
 * The template used for displaying content for posts.
 *
 * @package Appetite
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="clearfix">
		<?php if ( has_post_thumbnail() ): ?>
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="thumb-link alignleft">
			<?php the_post_thumbnail(); ?>
		</a><!-- .thumb-link -->
		<?php endif; ?>

		<div class="frame">
			<header class="entry-header">
				<?php if ( 'post' === ( $current_post_type = get_post_type() ) ) : ?>
				<div class="entry-category cat-links">
					<?php the_category( '<span class="sep">/</span>' ); ?>
				</div><!-- .entry-category -->
				<?php
				endif;

				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

				if ( 'post' === $current_post_type ) : ?>
				<div class="entry-meta">
					<?php appetite_posted_on(); ?>

                    <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
					<span class="comments-link has-icon"><?php comments_popup_link( esc_html__( 'Leave a comment', 'appetite' ), esc_html__( '1 Comment', 'appetite' ), esc_html__( '% Comments', 'appetite' ) ); ?></span>
					<?php endif; ?>
				</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php
				/* translators: %s: Name of current post */
                the_content( sprintf(
                    wp_kses( __( 'Read More %s', 'appetite' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                ) );

				wp_link_pages( array(
					'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'appetite' ) . '</span>',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>'
				) ); ?>
			</div><!-- .entry-content -->
		</div><!-- .frame -->
	</div><!-- .clearfix -->
</article><!-- #post-## -->
