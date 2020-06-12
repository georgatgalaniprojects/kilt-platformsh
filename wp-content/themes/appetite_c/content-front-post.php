<?php
/**
 * The template part for displaying posts in front page.
 *
 * @package Appetite
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

        <?php if ( has_post_thumbnail() ): ?>
		<div class="entry-thumb">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="thumb-link">
			<?php  the_post_thumbnail( 'appetite-standard-image' ); ?>
			</a><!-- .thumb-link -->
		</div><!-- .entry-thumb -->
        <?php endif; ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php appetite_posted_on(); ?>

            <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
            <span class="comments-link has-icon"><?php comments_popup_link( esc_html__( 'Leave a comment', 'appetite' ), esc_html__( '1 Comment', 'appetite' ), esc_html__( '% Comments', 'appetite' ) ); ?></span>
            <?php endif; ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
</article><!-- #post-## -->
