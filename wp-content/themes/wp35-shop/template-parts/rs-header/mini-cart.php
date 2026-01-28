<div id="header-cart-content">
<?php if ( ! WC()->cart->is_empty() ) : ?>
    <div id="site-header-cart" class="pull-right hidden-xs hidden-sm dropdown basket-area">
        <a href="#" class="basket-btn dropdown-toggle user-icon-button" id="basket"  data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">
            <span class="cart-total-summ">
                <i class="icon-shopping-cart"></i>
                <span class="hidden-xs">
                <?php //rs_cart_total_sum();
                $rs_is_cart_count=rs_is_cart_count();
                   if($rs_is_cart_count!='count'){
                     echo wp_kses_post(WC()->cart->get_cart_subtotal());
                   } else {
                       echo wp_kses_post(WC()->cart->get_cart_contents_count());
                   }  ?>
                </span>
            </span>
            <span class="hidden-xs hidden-sm  basket-text">Корзина</span>
            <!--
            <i class="fa fa-caret-down"></i>
            -->
        </a>
        <div class="dropdown-menu basket-dropdown">
            <div class="basket-table smoothscroll ">
                <ul class="basket-list site-header-cart">
                    <?php
                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $_product  = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                                $thumbnail= apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                $product_quantity = $cart_item['quantity'];
                                $product_subtotal = $cart_item['line_subtotal'];
                                $product_sku = $_product->get_sku();
                                ?>
                                <li class="basket-list--item">
                                    <div class="basket-img">
                                        <a href="<?php echo esc_url( $product_permalink ); ?>">
                                            <?=$thumbnail; ?>
                                        </a>
                                    </div>
                                    <div class="basket-descr">
                                        <div class="basket-title">
                                            <h4>
                                                <a href="<?php echo esc_url( $product_permalink ); ?>"><?=$product_name; ?></a>
                                            </h4>
                                        </div>
                                        <div class="basket-subscription">
                                            <div class="basket-line">Артикул <?=$product_sku; ?></div>

                                            <div class="basket-quantity">
                                                <a><?=$product_quantity; ?> шт</a>
                                            </div>
                                            <div class="basket-subtotal">
                                                <?=$product_subtotal; ?><!--<i class="fa fa-rub"></i>-->
                                            </div>
                                        </div>
                                        <div class="basket-price">
                                            <?=$product_price; ?><!--<i class="fa fa-rub"></i>-->
                                        </div>
                                    </div>
                                    <?php
                                    // значок удаления
                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="%s" class="basket-item-delete text-right" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="fa fa-times"></i></a>',
                                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                        __( 'Remove this item', 'woocommerce' ),
                                        esc_attr( $product_id ),
                                        esc_attr( $cart_item_key ),
                                        esc_attr( $_product->get_sku() )
                                    ), $cart_item_key ); ?>
                                </li>
                                <?php
                            }
                        }
                    ?>
                </ul>
            </div>
            <div class="basket-footer text-right">
                <h3 class="basket-total">ИТОГО: <?php echo WC()->cart->get_cart_subtotal(); ?></h3>
                <a href="<?php echo get_home_url().'/cart' ?>" class="btn btn-sm btn-cart"><i class="fa fa-shopping-cart"></i> корзина</a>
                <a href="<?php echo get_home_url().'/checkout' ?>" class="btn btn-sm btn-order">Заказать</a>
            </div>
    <?php else : ?>
    <div id="site-header-cart" class="pull-right hidden-xs hidden-sm dropdown basket-area">
        <a href="#" class="basket-btn  dropdown-toggle user-icon-button" id="basket"  data-toggle="dropdown" role="button"  aria-haspopup="true" aria-expanded="false">
            <span class="cart-total-summ">
                <i class="icon-shopping-cart"></i>
                <span class="hidden-xs">0</span>
            </span>
            <span class="hidden-xs hidden-sm hidden-md basket-text">Корзина</span>
        </a>
        <div class="dropdown-menu basket-dropdown">
    <?php endif; ?>
        </div>
    </div>
</div>