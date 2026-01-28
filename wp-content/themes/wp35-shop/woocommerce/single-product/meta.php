<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="categories">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>
    <div class="categories-content">
	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<h5>' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . '&nbsp;</h5>'); ?>
    </div>
    <div class="categories-content">
	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<h5>' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . '&nbsp;</h5>' ); ?>
    </div>
	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
