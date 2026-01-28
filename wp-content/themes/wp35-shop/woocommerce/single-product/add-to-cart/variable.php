<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product,$post;
$attributes = $product->get_variation_attributes();
$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
$max_quantity = apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity());
$max_value = (($max_quantity>0) && ($max_quantity<8))?$max_quantity:8;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>
	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock  out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
    <?php else :
        $images=[];
        $image='';
        $on_image_cart=get_field('on_image_cart',1910);
        if($available_variations){
            foreach ( $available_variations as $key => $options ){
                if(! empty($options['attributes']["attribute_pa_color"])){
                    $key=$options['attributes']["attribute_pa_color"];
                    $images[$key] = $options ["image"]["gallery_thumbnail_src"];
                }
            }
        }
        ?>
		<div class="variations product-filter clearfix">
            <div class="row">
				<?php foreach ( $attributes as $attribute_name => $options ) :  ?>
					<?php
                    if($attribute_name=='pa_color'){ ?>
                    <div class="col-xs-12">
                        <div class="filterBox">
                            <?php
                            $sanitized_name = sanitize_title( $attribute_name );
                           /*  ?>
                            <div class="title-attribute" ><?php echo mb_ucfirst('Выберите '. wc_attribute_label( $attribute_name )); ?>
                            </div>
                            <?php*/
                            if ( isset( $_REQUEST[ 'attribute_' . $sanitized_name ] ) ) {
                        $checked_value = $_REQUEST[ 'attribute_' . $sanitized_name ];
                    } elseif ( isset( $selected_attributes[ $sanitized_name ] ) ) {
                        $checked_value = $selected_attributes[ $sanitized_name ];
                    } else {
                        $checked_value = '';
                    }
                            ?>
                            <div class="value">
                                <?php
                                if ( ! empty( $options ) ) {

                                    if ( taxonomy_exists( $attribute_name ) ) {
                                        $terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );
                                        foreach ( $terms as $term ) {
                                            if ( ! in_array( $term->slug, $options ) ) {
                                                continue;
                                            }
                                            if($images && $on_image_cart)
                                            $image = $images[$term->slug];
                                            print_attribute_radio( $checked_value,$image, $term->slug, $term->name, $sanitized_name );
                                        }
                                    } else {
                                        foreach ( $options as $option ) {
                                            print_attribute_radio( $checked_value, $image, $term->slug, $option, $sanitized_name );
                                        }
                                    }
                                }

                             //   echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
                                ?>
                            </div>

                        </div>
                    </div>
                    <?php  } else { ?>
                     <div class="col-lg-6 col-sm-12 col-xs-6 pull-right">
						<div class="filterBox">
                            <?php
                          //  $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
                            wc_dropdown_variation_attribute_options( array(
                                    'options'   => $options,
                                    'attribute' => $attribute_name,
                                    'product'   => $product,
                                    'class' => 'form-control',
                                 //   'selected' => $selected,
                                    'show_option_none' => mb_ucfirst(wc_attribute_label( $attribute_name )),
                                ) );
                            ?>
                        </div>
                     </div>
                            <?php }?>
				<?php endforeach;
				//var_dump($product->get_stock_quantity());
				?>
                <div class="col-lg-6 col-sm-12 col-xs-6">
                    <div class="filterBox quantity_select">
                        <select id="pa_count" class="form-control qty" name="attribute_pa_count" data-attribute_name="attribute_pa_count" data-show_option_none="yes">
                            <option value="">Количество</option>
                            <?php
                            for ($x=1; $x<=$max_value; $x++) echo '<option value="'.$x.'" class="attached enabled">'.$x.'</option>';
                            ?>
                        </select>
                    </div>
                </div>
                <?php
                echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
				?>
            </div>
		</div>
		

		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
