<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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
 * @version     6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="rs-17">
        <div class="rs-related">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><span class="section-title--text"><?php esc_html_e( 'Related products', 'woocommerce' ); ?></span></h2>
                    </div>
                    <div class="col-xs-12 no-padding">
                        <div id="product-related" class="owl-carousel" data-nekoanim="fadeInUp">
                            <?php //woocommerce_product_loop_start(); ?>
                            <?php foreach ( $related_products as $related_product ) : ?>
                                <?php
                                $post_object = get_post( $related_product->get_id() );
                                setup_postdata( $GLOBALS['post'] =& $post_object );
                                wc_get_template_part( 'content', 'related-product' ); ?>
                            <?php endforeach; ?>
                            <?php //woocommerce_product_loop_end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</section>

<?php endif;

wp_reset_postdata();
