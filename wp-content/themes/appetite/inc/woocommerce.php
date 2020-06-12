<?php
/**
 * WooCommerce Compatibility File
 * See: https://docs.woocommerce.com/
 *
 * @package Appetite
 */

 /**
  * WooCommerce setup function.
  */
function appetite_woocommerce_setup() {
 	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 450,
		'single_image_width' => 700,
	) );

    add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'appetite_woocommerce_setup' );

/**
 * Hide Woo title on the main shop page.
 */
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function appetite_woocommerce_scripts() {
	wp_enqueue_style( 'appetite-woocommerce-style', get_template_directory_uri() . '/css/woocommerce.css' );

    if ( is_rtl() ) {
        wp_enqueue_style( 'appetite-woocommerce-rtl-style', get_template_directory_uri() . '/css/woocommerce-rtl.css' );
    }

    $font_path = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
	}';

	wp_add_inline_style( 'appetite-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'appetite_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Set a number of products per page.
 *
 * @return integer number of products
 */
function appetite_woocommerce_products_per_page() {
	return intval( apply_filters( 'appetite_woocommerce_products_per_page', 12 ) );
}

add_filter( 'loop_shop_per_page', 'appetite_woocommerce_products_per_page' );

/**
 * Change number of products per row.
 */
function appetite_woocommerce_loop_columns() {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		return 3;
	}

	return 4;
}
add_filter( 'loop_shop_columns', 'appetite_woocommerce_loop_columns' );

/**
 * Set the number of products to display in the related and upsell sections.
 */
function appetite_woocommerce_output_related_upsell_products( $args ) {
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$args = wp_parse_args( array(
            'posts_per_page' => 4,
            'columns' => 4,
        ), $args );
	} else {
		$args = wp_parse_args( array(
            'posts_per_page' => 3,
            'columns' => 3,
        ), $args );
	}

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'appetite_woocommerce_output_related_upsell_products' );
add_filter( 'woocommerce_upsell_display_args', 'appetite_woocommerce_output_related_upsell_products' );

/**
 * Set the number of products to display in the cross-sells section.
 */
function appetite_set_cross_sells_number( $number ) {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$number = 3;
	}

	return $number;
}
add_filter( 'woocommerce_cross_sells_total', 'appetite_set_cross_sells_number' );

/**
 * Remove support for Jetpack infinite scroll for WooCommerce products
 * due to the issue in the Jetpack core.
 *
 * See: https://github.com/Automattic/jetpack/issues/8385
 *
 * @param  WP_Query $query The current archive object.
 */
function appetite_wc_disable_infinite_scroll( $query ) {
	// Define the context.
	// Not on dashboard pages when inside the main query only on cpt archives.
	if ( ! is_admin() && $query->is_main_query() && ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) ) ) {
		// Remove infinite scroll inside this context.
		remove_theme_support( 'infinite-scroll' );
	}
}
add_action( 'pre_get_posts', 'appetite_wc_disable_infinite_scroll' );

if ( ! function_exists( 'appetite_woocommerce_cart_link' ) ) :
/**
 * The cart callback function for the mobile cart icon.
 */
function appetite_woocommerce_cart_link() {
	?>
		<a class="cart-contents has-icon" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'appetite' ); ?>">
			<span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() );?></span>
		</a>
	<?php
}
endif;

if ( ! function_exists( 'appetite_woocommerce_cart_link_fragment' ) ) :
/**
 * Cart Fragments.
 *
 * Ensure cart contents update when products are added to the cart via AJAX.
 *
 * @param array $fragments Fragments to refresh via AJAX.
 * @return array Fragments to refresh via AJAX.
 */
function appetite_woocommerce_cart_link_fragment( $fragments ) {
    ob_start();
	appetite_woocommerce_cart_link();
	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}
endif;
add_filter( 'woocommerce_add_to_cart_fragments', 'appetite_woocommerce_cart_link_fragment' );
