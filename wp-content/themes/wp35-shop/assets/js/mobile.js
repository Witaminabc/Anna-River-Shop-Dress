(function($) {
    jQuery(window).load(function() {
        var countLi=  jQuery('body .woocommerce-product-gallery .flex-control-paging li').length;
        jQuery('body .woocommerce-product-gallery .flex-control-paging li').width(jQuery('body .woocommerce-product-gallery .flex-control-paging').width()/countLi - 5);

        jQuery('body .incaps.in-stock').appendTo(jQuery('body .entry-summary .product-price'));
        jQuery('body').on('change','select',function($){
            jQuery('body .entry-summary .product-price:first').hide();
            //jQuery('body .woocommerce-variation.single_variation').appendTo(jQuery('body .entry-summary .product-price'));
        });
    });
    jQuery(window).resize(function() {
        var countLi=  jQuery('body .woocommerce-product-gallery .flex-control-paging li').length;
        jQuery('body .woocommerce-product-gallery .flex-control-paging li').width(jQuery('body .woocommerce-product-gallery .flex-control-paging').width()/countLi - 5);
    });
})(jQuery);