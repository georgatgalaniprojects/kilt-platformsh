<?php
/**
 * The template for displaying Author's section
 *
 * @package Appetite
 */

$current_author_id = get_the_author_meta('ID');
$author_posts_link = '<a href="'. esc_url( get_author_posts_url( $current_author_id ) ) .'">'. esc_html( get_the_author() ) .'</a>';

if( get_the_author_meta( 'description', $current_author_id ) ): ?>

<div class="author-container">
	<div class="author-info">
		<?php echo get_avatar( $current_author_id, 192 ); ?>

		<div class="author-bio">
            <h4 class="author-name"><?php printf( esc_html__( 'Written by %s', 'appetite' ), $author_posts_link ); ?></h4>
			<?php the_author_meta( 'description', $current_author_id ); ?>
		</div><!-- .author-bio -->
	</div><!-- .author-info -->
</div><!-- .author-container -->

<?php endif; ?>