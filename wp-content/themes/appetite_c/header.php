<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Appetite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="thumbnail" content="https://kilt.io/wp-content/uploads/2019/08/kilt-logo-google-thumb.png" />
<meta name="google-site-verification" content="t_q7gnkG-tjc3grZUubzexr8xbWoERtPohkB5vLUKJE" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="KILT is a Blockchain protocol for Self-Sovereign Data and Interoperability. It describes and attests any kind of characteristics in a standardised way." />
<meta name="twitter:title" content="KILT Protocol – Claim Independence" />
<meta name="twitter:site" content="@Kiltprotocol" />
<meta name="twitter:image" content="https://kilt.io/wp-content/uploads/2019/08/kilt-logo-google-thumb.png" />
<meta name="twitter:creator" content="@Kiltprotocol" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<!--
  <PageMap>
    <DataObject type="thumbnail">      
      <Attribute name="src" value="https://kilt.io/wp-content/uploads/2019/08/kilt-logo-google-thumb.png"/>
      <Attribute name="width" value="720"/>
      <Attribute name="height" value="720"/>
    </DataObject>
  </PageMap>
-->
<script type="application/ld+json">
{"@context" : "https://schema.org",
"@type" : "Organization",
 "name" : "KILT Protocol",
 "url" : "https://kilt.io",
 "logo": "https://kilt.io/wp-content/uploads/2019/08/kilt-logo-google-thumb.png" }
</script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'appetite' ); ?></a>

	<div id="toggle-sidebar">
		<div class="inner-panel">
            <a id="close-toggle-sidebar" class="primary-font has-icon" href="#"><?php esc_html_e( 'Close', 'appetite' ); ?></a>

			<?php echo get_search_form(); ?>

			<nav id="mobile-navigation" class="mobile-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #secondary-navigation -->

			<?php if ( has_nav_menu( 'social' ) ) : ?>
			<div class="header-social">
				<?php get_template_part( 'menu', 'social' ); ?>
			</div><!-- .footer-social -->
			<?php endif; ?>
		</div><!-- .inner-panel -->
	</div><!-- #toggle-sidebar -->

	<header id="masthead" class="site-header clearfix primary-font" role="banner">
		<div class="site-branding pull-left">
			<?php

            appetite_the_custom_logo();

			if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;

			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->

		<a id="sidebar-button" class="pull-right has-icon" href="toggle-sidebar">
			<span class="screen-reader-text header-search"><?php esc_html_e( 'Search', 'appetite' ); ?></span>
            <span class="header-menu"><?php esc_html_e( 'Menu', 'appetite' ); ?></span>
		</a><!-- #header-search -->

		<nav id="site-navigation" class="main-navigation pull-right" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
