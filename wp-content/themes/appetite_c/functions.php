<?php
/**
 * appetite functions and definitions
 *
 * @package Appetite
 */

 // Theme Constants.
 define( 'APPETITE_DIR', get_template_directory() );
 define( 'APPETITE_DIR_URI', get_template_directory_uri() );

if ( ! function_exists( 'appetite_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function appetite_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on appetite, use a find and replace
	 * to change 'appetite' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'appetite', APPETITE_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Set the default Post Thumbnail size
	set_post_thumbnail_size( 250, 250, true );

    add_image_size( 'appetite-standard-image', 800, 480, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'appetite' ),
		'social' => esc_html__( 'Social Menu', 'appetite' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'appetite_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

    /*
	 * This theme styles the visual editor to resemble the theme style.
	 */
	add_editor_style( array( 'css/editor-style.css', appetite_google_fonts() ) );

    /*
	 * Enable support for Automatic Updates.
	 */
    add_theme_support( 'themes-harbor-edd-license', array(
        'theme-slug' => 'appetite',
        'download-id' => '200',
    ) );

    /**
     * Load theme updater functions.
     */
    require( APPETITE_DIR . '/inc/updater/theme-updater.php' );
}
endif; // appetite_setup
add_action( 'after_setup_theme', 'appetite_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function appetite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'appetite_content_width', 750 );
}
add_action( 'after_setup_theme', 'appetite_content_width', 0 );

/**
 * Set the content width for the full width pages
 */
function appetite_content_full_width() {
	global $content_width;

	if ( is_page_template( 'templates/full-width-page.php' ) || is_page_template( 'templates/grid-full-width-page.php' ) || ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 1140;
	}
}
add_action( 'template_redirect', 'appetite_content_full_width' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function appetite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'appetite' ),
		'description'   => esc_html__( 'Appears in the sidebar section of the site.', 'appetite' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'appetite' ),
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'appetite' ),
		'id'            => 'footer-1',
		'before_widget' => '<div class="col-lg-4 col-md-4 footer-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div><!-- .col -->',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'appetite_widgets_init' );

/**
 * Register Google Fonts.
 */
function appetite_google_fonts() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext,cyrillic,cyrillic-ext';

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Montserrat font: on or off', 'appetite' ) ) {
		$fonts[] = 'Montserrat:400,400i,700,700i';
	}

	/* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== esc_html_x( 'on', 'Lato font: on or off', 'appetite' ) ) {
		$fonts[] = 'Lato:400,700,400italic,700italic';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function appetite_scripts() {

	wp_enqueue_style( 'appetite-google-fonts', appetite_google_fonts(), array(), null );
    wp_enqueue_style( 'font-awesome', APPETITE_DIR_URI . '/css/font-awesome.css', array(), '4.7.0' );
	wp_register_style( 'appetite-css-framework', APPETITE_DIR_URI . '/css/bootstrap.css' );
	wp_enqueue_style( 'appetite-style', get_stylesheet_uri(), array( 'appetite-css-framework' ) );

	if ( is_singular() && ! is_page_template( 'templates/front-page.php' ) && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    if ( is_page_template( 'templates/front-page.php' ) ) {
        wp_enqueue_script( 'bxslider', APPETITE_DIR_URI . '/js/jquery.bxslider.js', array( 'jquery' ), '4.1.2', true  );
	}

	wp_register_script( 'big-slide', APPETITE_DIR_URI . '/js/big-slide.js', array( 'jquery' ), '0.5.0', true  );
	wp_enqueue_script( 'appetite-script', APPETITE_DIR_URI . '/js/appetite.js', array( 'big-slide' ), '1.1.1', true  );
}
add_action( 'wp_enqueue_scripts', 'appetite_scripts' );

/**
 * Excerpt Length
 */
function appetite_get_excerpt_length() {
 	return 20;
}
add_filter( 'excerpt_length', 'appetite_get_excerpt_length', 999 );

/**
 *	Add div container to the post's "more" link.
 */
function appetite_more_link_container( $link ) {
	// Removes the anchor from the permalinks.
	$link = preg_replace( '/#more\-\d+/', '', $link );

	return sprintf( '<div class="more-link-container">%s</div>', $link );
}
add_filter( 'the_content_more_link', 'appetite_more_link_container' );

/**
 *	Customize excerpts more tag
 */
function appetite_excerpt_more( $more ) {
	if ( ! is_search() ) {
		$post_id = get_the_ID();

 		return sprintf( '&#x2026; <div class="more-link-container"><a href="%1$s" class="more-link">%2$s</a></div>',
 			  esc_url( get_permalink( $post_id ) ),
 			  sprintf( esc_html__( 'Read More %s', 'appetite' ), '<span class="screen-reader-text">' . get_the_title( $post_id ) . '</span>' )
 		);
	}
}
add_filter( 'excerpt_more', 'appetite_excerpt_more' );

/**
 *	Flush rewrite rules for CPTs on setup and switch
 */
function appetite_flush_rewrite_rules() {
     flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'appetite_flush_rewrite_rules' );

/**
 * Getter function for Featured Content Plugin.
 */
function appetite_get_featured_posts() {
	return apply_filters( 'appetite_featured_posts', array() );
}

/**
 * A helper conditional function that checks if there are featured posts.
 */
function appetite_has_featured_posts() {
	return ! is_paged() && (bool) appetite_get_featured_posts();
}

/**
 * Register the required plugins for this theme.
 */
function appetite_register_required_plugins() {

	$plugins = array(
		array(
			'name'      => 'Jetpack by WordPress.com',
			'slug'      => 'jetpack',
			'required'  => false,
		),

        array(
			'name'      => 'Easy Google Fonts',
			'slug'      => 'easy-google-fonts',
			'required'  => false,
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'id'           => 'appetite',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'appetite_register_required_plugins' );

/**
 * Implement the Custom Header feature.
 */
require APPETITE_DIR . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require APPETITE_DIR . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require APPETITE_DIR . '/inc/extras.php';

/**
 * Customizer additions.
 */
require APPETITE_DIR . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require APPETITE_DIR . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load WordPress.org compatibility file.
 */
require APPETITE_DIR . '/inc/org-features/wporg.php';

/**
 *  Include the TGM_Plugin_Activation class.
 */
require APPETITE_DIR . '/inc/class-tgm-plugin-activation.php';

// add tag support to pages
function tags_support_all() {
 register_taxonomy_for_object_type('post_tag', 'page');
}
 
// ensure all tags are included in queries
function tags_support_query($wp_query) {
 if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}
 
// tag hooks
add_action('init', 'tags_support_all');
add_action('pre_get_posts', 'tags_support_query');

//page excerpts
add_action( 'init', 'kb_page_excerpts' );

function kb_page_excerpts() {
  add_post_type_support( 'page', 'excerpt' );
}

//Open Graph Function

add_action( 'wp_head', 'kb_load_open_graph' );
 
function kb_load_open_graph() {

global $post;

// Standard-Grafik für Seiten ohne Beitragsbild
$kb_site_logo = 'https://kilt.io/wp-content/uploads/2019/08/kilt-logo-google-thumb.png';

// Wenn Startseite
if ( is_front_page() ) { // Alternativ is_home
echo '<meta property="og:type" content="website" />';
echo '<meta property="og:url" content="' . get_bloginfo( 'url' ) . '" />';
echo '<meta property="og:title" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />';
echo '<meta property="og:image" content="' . $kb_site_logo . '" />';
echo '<meta property="og:description" content="' . esc_attr( get_bloginfo( 'description' ) ) . '" />';
}

// Wenn Einzelansicht von Seite, Beitrag oder Custom Post Type
elseif ( is_singular() ) {
echo '<meta property="og:type" content="article" />';
echo '<meta property="og:url" content="' . get_permalink() . '" />';
echo '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />';
if ( has_post_thumbnail( $post->ID ) ) {
    $kb_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
    echo '<meta property="og:image" content="' . esc_attr( $kb_thumbnail[0] ) . '" />';
} else
    echo '<meta property="og:image" content="' . $kb_site_logo . '" />';
    echo '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />';
}
}