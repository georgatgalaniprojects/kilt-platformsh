<?php
/**
 * The template used for displaying featured page #5 content in front-page.php
 *
 * @package Appetite
 */

$content_position = get_theme_mod( 'appetite_featured_page_five_align', 'right' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row regular-page">
        <div class="<?php echo esc_attr( appetite_featured_page_column_class( $content_position, 'thumb' ) ); ?> entry-thumb">
        <?php
            if ( has_post_thumbnail() ):
                the_post_thumbnail( 'full' );
                $image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
            else:
                $image_caption = '';
            endif;
        ?>
        </div><!-- .featured-image -->

        <div class="<?php echo esc_attr( appetite_featured_page_column_class( $content_position, 'content' ) ); ?> entry-body">
            <header class="entry-header">
                <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                <?php if( '' != $image_caption ): ?>
                <div class="entry-sub-title"><?php echo esc_html( $image_caption ); ?></div>
                <?php endif; ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php
                    the_content( sprintf(
                        wp_kses( __( 'Read More %s', 'appetite' ), array( 'span' => array( 'class' => array() ) ) ),
                        the_title( '<span class="screen-reader-text">"', '"</span>', false )
                    ) );
                ?>
            </div><!-- .entry-content -->
        </div><!-- .entry-body -->
    </div><!-- .row -->
</article><!-- #post-## -->
