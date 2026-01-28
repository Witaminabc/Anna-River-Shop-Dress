<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="rs-cart">
	<div class="container">

		<div class="row">
			<div class="col-xxs-12 col-xs-6 col-sm-7 col-md-9 col-lg-9 text-center-xs">
				<h1 class="section-title-inner"><i class="fa fa-shopping-cart"></i>Корзина пуста</h1>
			</div>
			<div class="col-xxs-12 col-xs-6 col-sm-5 col-md-3 col-lg-3">
				<h4 class="caps"><a href="<?=get_post_type_archive_link('product'); ?>"><i class="fa fa-arrow-left"></i>вернуться к покупкам</a></h4>
			</div>
		</div>

	</div>
	<div class="footer-down"></div>
</div>
