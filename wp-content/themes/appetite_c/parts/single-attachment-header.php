<?php
/**
 * The part displays single attachment header
 *
 * @package Appetite
 */

$attachment = wp_get_attachment_url( get_the_id() );
?>

<?php if( $attachment ): ?>
<div id="primary-header" class="has-background">
	<div class="featured-image" style="background-image: url( <?php echo esc_url( $attachment ); ?> );"></div><!-- .featured-image -->
<?php else: ?>
<div id="primary-header">
<?php endif; ?>
	<div class="container">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        <div class="entry-meta">
			<?php appetite_posted_on(); ?>

			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
			<span class="comments-link has-icon"><?php comments_popup_link( esc_html__( 'Leave a comment', 'appetite' ), esc_html__( '1 Comment', 'appetite' ), esc_html__( '% Comments', 'appetite' ) ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( esc_html__( 'Edit', 'appetite' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</div><!-- .container -->
</div><!-- #primary-header -->
