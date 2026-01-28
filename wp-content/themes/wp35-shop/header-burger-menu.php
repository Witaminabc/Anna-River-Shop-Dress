<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<link rel="stylesheet" href="<?=get_stylesheet_directory_uri().'/template-parts/rs-page-burger-menu/css/rs-page-burger-menu.css';	?>">

<?php wp_head(); ?>
</head>

<body <?php body_class('activateAppearAnimation'); ?>>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>
	<div class="rs-burger-menu">
		<header id="masthead" style="<?php storefront_header_styles(); ?>" >

			<?php
			remove_action('storefront_header', 'storefront_header_top_info_child', 0);
			remove_action('storefront_header', 'storefront_header_cart_child', 60);
			remove_action('storefront_header', 'storefront_primary_navigation_child', 50);
			add_action('storefront_header', 'rs_burger_block', 55);			
			add_action('storefront_header', 'storefront_primary_navigation_child_right', 60);
			add_action('storefront_header', 'rs_modal_sidemenu', 65);
			?>

            <?php		
			/**
			 * Functions hooked into storefront_header action
			 *
			 * @hooked storefront_header_container                 - 0
			 * @hooked storefront_skip_links                       - 5
			 * @hooked storefront_social_icons                     - 10
			 * @hooked storefront_site_branding                    - 20
			 * @hooked storefront_secondary_navigation             - 30
			 * @hooked storefront_product_search                   - 40
			 * @hooked storefront_header_container_close           - 41
			 * @hooked storefront_primary_navigation_wrapper       - 42
			 * @hooked storefront_primary_navigation               - 50
			 * @hooked storefront_header_cart                      - 60
			 * @hooked storefront_primary_navigation_wrapper_close - 68
			 */
			do_action( 'storefront_header' );
			?>

		</header><!-- #masthead -->
	</div>

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	//do_action( 'storefront_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">
		<!-- расширяем контейнер на всю ширину для дочерней темы -->
		<div class="wrapper rs-one-menu-body">

		<?php
		do_action( 'storefront_content_top' );