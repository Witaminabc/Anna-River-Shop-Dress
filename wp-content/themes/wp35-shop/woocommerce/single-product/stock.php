<?php
/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( esc_attr( $class )!="out-of-stock" ){ ?>
    <h3 class="incaps  <?php echo esc_attr( $class ); ?>"><i class="far fa-check-circle color-in"></i><?php echo wp_kses_post( $availability ); ?>

        <?php if( $product->get_stock_quantity()>0)  echo '('.$product->get_stock_quantity().')'; ?>
    </h3>
<?php
} else {
?>
<h3 class="incaps stock <?php echo esc_attr( $class ); ?>">
    <?php echo wp_kses_post( $availability ); ?>
</h3>
<?php
}