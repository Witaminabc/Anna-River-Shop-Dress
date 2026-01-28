<?php

// Отключение стандартных функций страницы товара
function rs_delete_single_product() {
	//remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	//remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
	//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
	//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

    remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs', 10 );
    remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_related_products', 20 );
    remove_action( 'storefront_after_footer', 'storefront_sticky_single_add_to_cart', 999 );
}
add_action( 'init', 'rs_delete_single_product', 1);

// Добавление новых функций страницы товара
function rs_add_single_product() {
	//add_action('rs_woocommerce_before_main_content', 'rs_woocommerce_output_content_wrapper', 10);
	add_action('rs_woocommerce_before_main_content', 'rs_woocommerce_breadcrumb', 5);

	add_action('woocommerce_single_product_summary', 'rs_woocommerce_template_single_title', 5);
	add_action('woocommerce_single_product_summary', 'rs_woocommerce_template_single_sku', 10);
	add_action('woocommerce_single_product_summary', 'rs_woocommerce_template_single_price', 15);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
	//add_action('rs_woocommerce_after_main_content', 'rs_woocommerce_output_content_wrapper_end', 30);
    add_action( 'woocommerce_single_product_summary','woocommerce_output_product_data_tabs', 40 );
    add_action('woocommerce_single_product_summary', 'rs_share_custom_action', 45);

    add_action( 'woocommerce_after_single_product_summary','rs_woocommerce_output_related_products', 20 );
    add_action( 'woocommerce_after_single_product_summary','woocommerce_upsell_display', 30 );
    add_action( 'rs_relation_woocommerce_before_shop_loop_item_title','rs_relation_woocommerce_template_loop_product', 10 );

}
add_action( 'init', 'rs_add_single_product', 2);

//gallery_image добавлен класс
function wc_get_gallery_image_html_new( $attachment_id, $main_image = false ) {
    $flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
    $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
    $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
    $image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size );
    $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
    $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
    $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
    $image             = wp_get_attachment_image(
        $attachment_id,
        $image_size,
        false,
        apply_filters(
            'woocommerce_gallery_image_html_attachment_image_params',
            array(
                'title'                   => _wp_specialchars( get_post_field( 'post_title', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
                'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $attachment_id ), ENT_QUOTES, 'UTF-8', true ),
                'data-src'                => esc_url( $full_src[0] ),
                'data-large_image'        => esc_url( $full_src[0] ),
                'data-large_image_width'  => esc_attr( $full_src[1] ),
                'data-large_image_height' => esc_attr( $full_src[2] ),
                'class'                   => esc_attr( $main_image ? 'wp-post-image' : '' ),
            ),
            $attachment_id,
            $image_size,
            $main_image
        )
    );
    return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="woocommerce-product-gallery__image carousel-inner"><a href="' . esc_url( $full_src[0] ) . '">'. $image . '</a></div>';
}

add_filter('woocommerce_get_image_size_single','add_single_size',1,10);
function add_single_size($size){
    $size['width'] = 600;
    $size['height'] = 600;
    $size['crop']   = 0;
    return $size;
}

// Вывод заголовка
function rs_woocommerce_template_single_title() {
	the_title( '<h1 class="product-title entry-title">', '</h1>' );
}

// Вывод артикула
function rs_woocommerce_template_single_sku() {
	global $product;
    if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
        <h3 class="product-code"><?php esc_html_e( 'АРТИКУЛ: ', 'woocommerce' ); ?><span><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?> </span> </h3>
    <?php endif;
}

// Вывод цены
function rs_woocommerce_template_single_price() {
	global $product;
	?>
	<div class="product-price <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) );?>"><?php echo $product->get_price_html(); ?></div>
	<?php

}

add_filter( 'wc_price', 'currency_price', 10, 3 );
function currency_price( $return, $price, $args){
    if(get_woocommerce_currency()=='RUB')
        $price=$price.' <i class="fas fa-ruble-sign"></i>';
    return $price;
}
if (!function_exists('my_commonPriceHtml')) {
    function my_commonPriceHtml($price_amt, $regular_price, $sale_price) {
        $html_price = '';
        //if product is in sale
        if (($price_amt == $sale_price) && ($sale_price != 0)) {
            $html_price .= '<span class="price-sales">' . wc_price($sale_price) . '</span>';
            $html_price .= '<span class="price-standard">' . wc_price($regular_price) . '</span>';
        }
        //in sale but free
        else if (($price_amt == $sale_price) && ($sale_price == 0)) {
            $html_price .= '<span class="price-sales"></span>';
            $html_price .= '<span class="price-standard">' . wc_price($regular_price) . '</span>';
        }
        //not is sale
        else if (($price_amt == $regular_price) && ($regular_price != 0)) {
            $html_price .= '<span class="price-sales">' . wc_price($regular_price) . '</span>';
        }
        //for free product
        else if (($price_amt == $regular_price) && ($regular_price == 0)) {
            $html_price .= '<span class="price-sales">Free!</span>';
        }
        return $html_price;
    }
}
add_filter('woocommerce_get_price_html', 'my_simple_product_price_html', 100, 2);
function my_simple_product_price_html($price, $product) {
    if ($product->is_type('simple')) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        $price_amt = $product->get_price();
        return my_commonPriceHtml($price_amt, $regular_price, $sale_price);
    } else {
        return $price;
    }
}

// Вывод краткого описания
function rs_woocommerce_template_single_excerpt() {
	global $post;
	$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	if ( ! $short_description ) {
		return;
	}
	?>
	<div class="woocommerce-product-details__short-description details-description">
		<?php echo $short_description; // WPCS: XSS ok. ?>
	</div>
	<?php
}

//Статус В наличии
add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {
    // Change In Stock Text
    if ( $_product->is_in_stock() ) {
        $availability['availability'] = __('В наличии', 'woocommerce');
    }
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        //  $availability['availability'] = __('out of-stock', 'woocommerce');
    }
    return $availability;
}

// Utility function to get the default variation (if it exist)
function get_default_variation( $product ){
    $attributes_count = count($product->get_variation_attributes());
    $default_attributes = $product->get_default_attributes();
    // If no default variation exist we exit
    if( $attributes_count != count($default_attributes) )
        return false;
    // Loop through available variations
    foreach( $product->get_available_variations() as $variation ){
        $found = true;
        // Loop through variation attributes
        foreach( $variation['attributes'] as $key => $value ){
            $taxonomy = str_replace( 'attribute_', '', $key );
            // Searching for a matching variation as default
            if( isset($default_attributes[$taxonomy]) && $default_attributes[$taxonomy] != $value ){
                $found = false;
                break;
            }
        }
        // If we get the default variation
        if( $found ) {
            $default_variaton = $variation;
            break;
        }
        // If not we continue
        else {
            continue;
        }
    }
    return isset($default_variaton) ? $default_variaton : false;
}
add_action( 'woocommerce_before_single_product', 'move_variations_single_price', 1 );
function move_variations_single_price(){
    global $product, $post;
    if ( $product->is_type( 'variable' ) ) {
        remove_action( 'woocommerce_single_product_summary', 'rs_woocommerce_template_single_price', 15 );
        add_action( 'woocommerce_single_product_summary', 'rs_replace_variation_single_price', 18 );

        remove_action( 'woocommerce_single_variation','woocommerce_single_variation',10 );
        add_action( 'awooc_after_button','woocommerce_single_variation',10 );
    }
}
function rs_replace_variation_single_price(){
    global $product;
    // Main Price
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $active_price = $prices[0] !== $prices[1] ?    wc_price( $prices[0] ).' - '. wc_price( $prices[1] ): wc_price( $prices[0] );
    // Sale Price
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $regular_price = $prices[0] !== $prices[1] ?  wc_price( $prices[0] ).' - '. wc_price( $prices[1] ) : wc_price( $prices[0] );
    if ( $active_price !== $regular_price && $product->is_on_sale() ) {
        $price = '<span class="price-sales">' . $active_price . $product->get_price_suffix() . '</span><span class="price-standard">' . $regular_price . $product->get_price_suffix() . '</span> ';
    } else {
        $price = '<span class="price-sales">' .$regular_price. '</span>';
    }
    // When a default variation is set for the variable product
    if( get_default_variation( $product ) ) {
        $default_variaton = get_default_variation( $product );
        if( ! empty($default_variaton['price_html']) ){
            $price_html = $default_variaton['price_html'];
        } else {
            if ( ! $product->is_on_sale() )
                $price_html = $price = wc_price($default_variaton['display_price']);
            else
                $price_html = $price;
        }
        //$availiability = $default_variaton['availability_html'];
    } else {
        $price_html = $price;
        $sku = ($product->get_sku() ) ? $product->get_sku() : esc_html__( 'N/A', 'woocommerce' );
    }
    // Jquery ?>
    <script>
        var a = 'body div.product-price .price-sales',
            p = 'body div.product-price .price-standard',
            d='body div.product-price',
            s='body h3.product-code span';

        jQuery('body').on('change','.filterBox select, .filterBox [type="radio"]',function(){
                let variationData  = jQuery('.variations_form').data( 'product_variations' );
                jQuery('.variations_form').trigger( 'check_variations' );
                jQuery('body .woocommerce-product-details__short-description .woocommerce-variation-description').remove();
                let variationId = jQuery('input.variation_id').val();
                    function findVariation(variationId) {
                    for (var i = 0, len = variationData.length; i < len; i++) {
                        if (variationData[i].variation_id === parseInt(variationId)){
                            var price='';
                            if(variationData[i].display_price) price+='<span class="price-sales">'+variationData[i].display_price.toLocaleString('ru-RU')+' <i class="fas fa-ruble-sign"></i></span>';
                            if(variationData[i].display_regular_price) price+='<span class="price-standard">'+variationData[i].display_regular_price.toLocaleString('ru-RU')+' <i class="fas fa-ruble-sign"></i></span>';
                            return price; // Return as soon as the object is found
                        }
                    }
                    return null; // The object was not found
                };
                if( '' != jQuery('input.variation_id').val() ){
                    jQuery(a).html(jQuery('body div.woocommerce-variation-price > span.price ins').html());
                    jQuery(p).html(jQuery('body div.woocommerce-variation-price > span.price del').html());
                    jQuery(d).html(findVariation(variationId));
                    jQuery(s).html(jQuery('body div.woocommerce-variation-sku').html());
                    jQuery('body .woocommerce-variation.single_variation .woocommerce-variation-description').appendTo(jQuery('body .woocommerce-product-details__short-description'));
                    jQuery('body .woocommerce-variation.single_variation .woocommerce-variation-price').remove();
                } else {
                    jQuery(d).html('<?=$price_html?>');
                    jQuery(s).html('<?=$sku?>');
                }
                if(jQuery('body .single_add_to_cart_button').hasClass('disabled')){
                    jQuery('body .show-add-to-card').addClass('disabled')
                } else {
                    jQuery('body .show-add-to-card').removeClass('disabled')
                }
        });
    </script>
    <?php
    echo '<div class="product-price">'.$price_html.'</div>
    <div class="hidden-variable-price" >'.$price.'</div>
    <div class="hidden-variable-sku" >'.$sku.'</div>';
}

// Обёртка для кнопки Покупка в один клик
add_action( 'woocommerce_before_add_to_cart_quantity', 'action_function_before_add_to_cart_quantity',10 );
function action_function_before_add_to_cart_quantity(){ ?>
    <div class="row">
    <?php
}
//add_action( 'woocommerce_after_add_to_cart_quantity', 'action_function_after_add_to_cart_button',10  );
function action_function_after_add_to_cart_button(){ ?>
    </div>
    <div class="row btn-reverce">
    <?php
}

add_action( 'awooc_before_button', 'action_function_awooc_before_button',1  );
function action_function_awooc_before_button(){ ?>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <?php
}
add_action( 'awooc_after_button', 'action_function_awooc_after_button',10  );
function action_function_awooc_after_button(){ ?>
    </div>
    </div>
    <?php
}

//Категории и метки переносим в таб “описание”
add_filter( 'woocommerce_product_tabs', 'woo_custom_description_tab', 98 );
function woo_custom_description_tab( $tabs ) {
    $tabs['description']['callback'] = 'woo_custom_description_tab_content';
    return $tabs;
}
function woo_custom_description_tab_content($tabs) {
    woocommerce_product_description_tab();
    add_action( 'description_tab_meta', 'woocommerce_template_single_meta', 5 );
    do_action( 'description_tab_meta' );
}

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    // unset( $tabs['description'] ); // Удаление вкладки с описанием товара
    unset( $tabs['reviews'] ); // Удаление вкладки с отзывами
    unset( $tabs['additional_information'] ); // Удаление вкладки с дополнительной информацией
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
    $tabs['description']['title'] = __( 'Детальное описание' ); // Переименование вкладки с описанием товара
    // $tabs['reviews']['title'] = __( 'Рейтинг' ); // Переименование вкладки с отзывами
    //$tabs['additional_information']['title'] = __( 'Характеристики' ); // Переименование с дополнительной информацией
    return $tabs;
}

add_filter('woocommerce_product_tabs','add_tabs');
function add_tabs($tabs){
    $tabs['new_tab'] = array(
        'title'    => 'Доставка',
        'priority' => 80,
        'callback' => 'product_delivery_tab'
    );
    return $tabs;
};

function product_delivery_tab(){
    echo get_field('delevery');
}

function rs_share_custom_action() { ?>
    <div class="product-share clearfix">
        <p class="text-uppercase"><strong>Поделиться</strong></p>
        <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
        <script src="https://yastatic.net/share2/share.js"></script>
        <div class="ya-share2" data-services="collections,vkontakte,facebook,odnoklassniki,moimir"></div>
    </div>
    <?php
}

//Перенос  СЧЕТЧИКА КОЛИЧЕСТВА ТОВАРОВ в форму купить в 1 клик
/*remove_action( 'awooc_popup_column_left','awooc_popup_window_qty', 50 );
add_action( 'awooc_popup_column_left', 'action_function_awooc_popup_woocommerce_quantity_input',50  );
function action_function_awooc_popup_woocommerce_quantity_input() {
    global $product; ?>
        <div class="cart-actions counter ">
            <?php
                woocommerce_quantity_input( array(
                'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', 100, $product ),
                'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                ));
            ?>
        </div>
        <script>
            jQuery('body').on('change','input.qty',function() {
                jQuery('input.awooc-hidden-product-qty').val(jQuery(this).val());
            });
        </script>
    <?php
}*/

//Добавляем уведомление в форму купить в 1 клик
add_action( 'awooc_popup_column_left', 'awooc_popup_woocommerce_agreement', 50  );
function awooc_popup_woocommerce_agreement() {
    global $post;
    $query = new WP_Query( array (
        'post_type' => 'custom_block',
        'meta_query' => array (
            'relation' => 'OR',
            array (
                'key'     => 'block_id',
                'value'   => 16, // id блока
                'compare' => '='
            )
        )
    ));
    while ( $query->have_posts() ) {
        $query->the_post();
        $post_meta = get_post_meta($query->post->ID);
    }
    if ($post_meta) {
        $notification_header = get_field("notification_header") ?: '';
        $notification_text = get_field("notification_text") ?: '';
    }
    ?>
    <div class="rs-17">
        <div class="rs-modal">
            <div class="modal fade" tabindex="-1" id="agreement-price">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <div class="modal-title"><?=$notification_header; ?></div>
                        </div>
                        <div class="modal-body">
                            <?=$notification_text; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

}

add_action( 'wp_footer', 'rs_custom_add_to_cart_message', 15);
function rs_custom_add_to_cart_message() {
    global $woocommerce,$product;
    ?>
    <script>
        (function ($) {
            $.fn.serializeArrayAll = function () {
                var rCRLF = /\r?\n/g;
                return this.map(function () {
                    return this.elements ? jQuery.makeArray(this.elements) : this;
                }).map(function (i, elem) {
                    var val = jQuery(this).val();
                    if (val == null) {
                        return val == null
                        //next 2 lines of code look if it is a checkbox and set the value to blank
                        //if it is unchecked
                    } else if (this.type == "checkbox" && this.checked == false) {
                        return {name: this.name, value: this.checked ? this.value : ''}
                        //next lines are kept from default jQuery implementation and
                        //default to all checkboxes = on
                    } else {
                        return jQuery.isArray(val) ?
                            jQuery.map(val, function (val, i) {
                                return {name: elem.name, value: val.replace(rCRLF, "\r\n")};
                            }) :
                            {name: elem.name, value: val.replace(rCRLF, "\r\n")};
                    }
                }).get();
            };
            $(document).on('click', '.single_add_to_cart_button:not(.disabled)', function (e) {
                var $thisbutton = $(this),
                    $form = $thisbutton.closest('form.cart'),
                    quantity = $form.find('input[name=quantity]').val() || 1,
                    product_id = $form.find('input[name=variation_id]').val() || $thisbutton.val(),
                    data = $form.find('input:not([name="product_id"]), select, button, textarea').serializeArrayAll() || 0;
                $.each(data, function (i, item) {
                    if (item.name == 'add-to-cart') {
                        item.name = 'product_id';
                        item.value = $form.find('input[name=variation_id]').val() || $thisbutton.val();
                    }
                });
                e.preventDefault();
                $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

                $.ajax({
                    type: 'POST',
                    url: woocommerce_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
                    data: data,
                    beforeSend: function (response) {
                        $thisbutton.removeClass('added').addClass('loading');
                    },
                    complete: function (response) {
                        $thisbutton.addClass('added').removeClass('loading');
                        $('body').on('click','.closeModalAddCart',function(){
                            $.unblockUI();
                            return false;
                        });
                    },
                    success: function (response) {
                        if (response.error & response.product_url) {
                            window.location = response.product_url;
                            return;
                        }
                        var thumbnail   = '<?=get_the_post_thumbnail_url()?>';
                        var product_title ='<?=get_the_title()?>';
                        var tpl = '<div class="modalAddCart"><button type="button" class="button closeModalAddCart close" >&times;</button>';
                        tpl += '<p class="section-title--text">Товар добавлен в корзину</p>';
                        tpl += '<div id="checkout_thumbnail" style="float:left; padding-right:15px;"><img width="80" src="'+thumbnail+'" alt="изображение товара '+product_title+'"></div>';
                        tpl += '<p class="product-title">'+product_title + '" ('+quantity+'шт.)</p>';
                        tpl += '<div style="clear: both;" class="btn-group">';
                        tpl += '<button  class="button closeModalAddCart"  >Продолжить покупки</button>';
                        tpl += '<a href="/checkout/" class="btn button btn-color">Оформить заказ</a>';
                        tpl += '</div></div>';

                        $.blockUI({
                            onOverlayClick: $.unblockUI,
                            message: tpl,
                           // timeout: 4000,
                            css: {
                                width: '400px',
                                border: 0,
                                padding: '15px',
                                top: "5%",
                                cursor: 'default'
                            }
                        } );

                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);

                    },
                });

                return false;

            });
        })(jQuery);

    </script>
    <?php
}


if (wp_is_mobile()) {
	remove_action( 'awooc_after_button','woocommerce_single_variation',10 );
	add_action( 'woocommerce_single_product_summary','woocommerce_single_variation',19 );

	//Перенос хлебных крошек в мобильной версии
    //remove_action( 'rs_woocommerce_before_main_content', 'rs_woocommerce_breadcrumb', 5 );
    //add_action( 'woocommerce_after_single_product', 'rs_woocommerce_breadcrumb',20 );

    //добавление стрелочки назад в категорию
    add_action( 'woocommerce_product_thumbnails','action_function_back_category',15 );
    function action_function_back_category(){
        global $product;
        $terms = wp_get_post_terms( get_the_id(), 'product_cat', array( 'include_children' => false ) );
        $term = reset($terms);
        $term_link =  get_term_link( $term->term_id, 'product_cat' ); // The link
    ?>
        <script>
            jQuery(window).load(function() {
                jQuery('body .woocommerce-product-gallery').prepend('<div class="backward"><a href="<?php echo $term_link; ?>"><svg width="31px" height="31px" viewBox="0 0 31 31" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(0.000000, -1.000000)"><path id="Combined-Shape" d="M16.5771645,12 L31,12 L31,21 L17.363961,21 L21.2132034,24.8492424 L14.8492424, 31.2132034 L-2.84217094e-14, 16.363961 L0.257359313,16.1066017 L-2.84217094e-14, 15.8492424 L14.8492424,1 L21.2132034, 7.36396103 L16.5771645,12 Z" fill="#FFFFFF"></path><path id="Combined-Shape" d="M9.34314575,15 L28,15 L28,18 L10.3431458,18 L16.8284271,24.4852814 L14.7071068, 26.6066017 L6.10050506,18 L6,18 L6,17.8994949 L4.10050506,16 L6.22182541,13.8786797 L14.7071068,5.39339828 L16.8284271,7.51471863 L9.34314575,15 Z" fill="#222222"></path></g></g></svg></a></div>');
				//jQuery('#header-cart-content').hide();
            });
        </script>
    <?php
    }

    add_filter( 'woocommerce_single_product_carousel_options', 'ud_update_woo_flexslider_options' );
    function ud_update_woo_flexslider_options( $options ) {
        $options['controlNav'] = true;
        $options['sync'] = '';
        return $options;

    }
	function add_mobile_script() {
		wp_enqueue_script( 'mobile-part', get_stylesheet_directory_uri(). '/assets/js/mobile.js', array('jquery'), '1.0', true );
    }
    add_action( 'wp_enqueue_scripts', 'add_mobile_script' );

}

// Добавление SALE к миниатюре
add_filter( 'woocommerce_single_product_image_thumbnail_html', 'add_flash_to_thumbs', 100, 2 );
function add_flash_to_thumbs( $html, $attachment_id ) {
     global $post, $product;
     $div_close = '</div>';
     $div_start = '<div';
	if ( get_post_thumbnail_id() !== intval( $attachment_id ) ) {
		if ( $product->is_on_sale() ) {
		    $length=strpos($html,$div_close);
		    $end_html=substr( $html,  $length );
		    $html = substr( $html, 0, $length );
		    $html .= apply_filters( 'woocommerce_sale_flash', '<span class="discount">' . esc_html__( 'SALE', 'woocommerce' ) . '</span>', $post, $product );
		    $html .= $end_html;
		}
	}
	return $html;
}

// Похожие товары
function rs_woocommerce_output_related_products() {
    global $product;
    if ( ! $product ) {
        return;
    }
    $args = array(
        'posts_per_page' => 8,
        'columns'        => 4,
        'orderby'        => 'rand', // @codingStandardsIgnoreLine.
        'order'          => 'desc',
    );
    // Get visible related products then sort them at random.
    $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
    // Handle orderby.
    $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );
    // Set global loop values.
    wc_set_loop_prop( 'name', 'related' );
    wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );
    wc_get_template( 'single-product/related.php', $args );
}

// Сопутствующие товары вывод карточки
function rs_relation_woocommerce_template_loop_product() {
    global $product;
    /*$title_products = (mb_strlen(get_the_title()) > 40) ?
                                mb_substr(get_the_title(), 0, 40) . '...' : get_the_title();*/
    if($product->is_type( 'variable' )){
        $regular_price = $product->get_variation_regular_price( 'min' );
        $sale_price = $product->get_variation_sale_price( 'min' );
    } else {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
    }
    $discount = ($regular_price && $sale_price) ? ceil((($regular_price - $sale_price) * 100) / $regular_price) : '';
    $onsale = $product->is_on_sale();
    $discount = $discount == 100 ? '' : $discount;
    $discount = $discount ? $discount . ' %' : '';
    $title_products = the_excerpt_max_charlength(get_the_title(), 40);
    ?>
    <div class="product-rel">
        <div class="product-image">

            <a href="<?php echo get_permalink() ?>">
                <?php if (has_post_thumbnail()) {
                    $thumbnail_id  = get_post_thumbnail_id( $product->get_ID() );
                    $default_attr = array(
                        'src'   => wc_placeholder_img_src(),
                        'data-src'   => wp_get_attachment_image_url( $thumbnail_id, 'shop_catalog' ),
                        'class' => "b-lazy ",
                    );
                    echo '<img class="b-lazy" data-src="'.wp_get_attachment_image_url( $thumbnail_id, 'shop_catalog' ).'" src="'.get_stylesheet_directory_uri() . '/assets/img/img0.png" alt=" "   />';
                    //get_the_post_thumbnail($loop->post->ID, 'shop_catalog',$default_attr);

                } else echo '<img src="'.wc_placeholder_img_src().'" alt="Placeholder" width="250px" height="250px" />';
                ?>
            </a>

            <ul class="promotion">
                <?php

                if(get_field('_new_product')=='yes') :?>
                    <li class="new">NEW </li>
                <?php endif; ?>
                <?php if($onsale ) :?>
                    <li class="discount">SALE <?=$discount; ?></li>
                <?php endif; ?>
            </ul>

        </div>
        <div class="description">
            <h4><a href="<?php echo get_permalink() ?>"><?=$title_products ?></a></h4>
        </div>
        <div class="price-block">
            <span class="price">
                <?php echo $product->get_price_html(); ?>
            </span>
        </div>

    </div>
    <?php
}

//вывод атрибутов радио кнопками
if ( ! function_exists( 'print_attribute_radio' ) ) {
    function print_attribute_radio( $checked_value,$image, $value, $label, $name ) {
        global $product;

        $input_name = 'attribute_' . esc_attr( $name ) ;
        $esc_value = esc_attr( $value );
        $bg = '#'.$esc_value;
        $id = esc_attr( $name . '_v_' . $value . $product->get_id() ); //added product ID at the end of the name to target single products
        $checked = checked( $checked_value, $value, false );
        $filtered_label = apply_filters( 'woocommerce_variation_option_name', $label, esc_attr( $name ) );
        if($image){
            printf( '<div><label for="%3$s"><input type="radio" name="%1$s" value="%2$s" id="%3$s" %4$s><span class="color-square" ><img alt="цвет" src="%6$s"></span>%5$s</label></div>', $input_name, $esc_value, $id, $checked, $filtered_label,$image );
        } else {
            printf( '<div><label for="%3$s"><input type="radio" name="%1$s" value="%2$s" id="%3$s" %4$s><span class="color-square" style="background-color:  %6$s"><i class="fas fa-check"></i></span></label></div>', $input_name, $esc_value, $id, $checked, $filtered_label,$bg );
        }
    }
}
