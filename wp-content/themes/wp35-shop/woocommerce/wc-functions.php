<?php

// Дополнительные типы полей
require 'rs-woo-custom-fields.php';

// Функционал Каталога
require 'wc-functions-arhive.php';

// Функционал Карточки товара
require 'wc-functions-single.php';

// Виджет Каталог товаров
require 'widgets/rs-wc-widget-product-categories.php';

// Виджет Фильтр по цене
require 'widgets/rs-wc-widget-price-filter.php';

// Виджет Фильтр по атрибутам
require 'widgets/rs-wc-widget-layered-nav.php';

// Виджет Фильтр по распродаже
require 'widgets/rs-wc-widget-onsale-filter.php';

// Виджет Кнопка Сбросить все фильтры
require 'widgets/rs-wc-widget-reset-button.php';

add_action( 'wp_enqueue_scripts', 'rs_wc_addition_style', 11 );
function rs_wc_addition_style() {
    if(is_woocommerce()){
      //  wp_enqueue_style( 'rs-top-header', get_stylesheet_directory_uri().'/woocommerce/css/rs-top-header.css');
    }
    wp_enqueue_style( 'rs-woo-addition', WP_CONTENT_URL . '/themes/storefront/assets/css/woocommerce/woocommerce.css');
    wp_enqueue_style( 'rs-awooc-addition', WP_PLUGIN_URL . '/art-woocommerce-order-one-click/assets/css/awooc-styles.min.css');
    if(is_shop() || is_product_category() || is_tax()){
        wp_enqueue_style( 'rs-catalog', get_stylesheet_directory_uri().'/woocommerce/css/rs-catalog.css');
        wp_enqueue_style( 'rs-single-product', get_stylesheet_directory_uri().'/woocommerce/css/rs-product-view.css');
    }
    if(is_product()){
        wp_enqueue_style( 'rs-single-product', get_stylesheet_directory_uri().'/woocommerce/css/rs-product.css');
    }
    if( is_cart() || is_checkout()) {
        wp_enqueue_style( 'rs-cart', get_stylesheet_directory_uri().'/woocommerce/css/rs-cart.css');
    }
	if (rs_is_cart_off()) {
		wp_enqueue_style( 'rs-cart-off', get_stylesheet_directory_uri().'/woocommerce/css/rs-cart-off.css');
	}
    if (!(wc_get_product() && wc_get_product()->is_type('bundle'))) {
        wp_deregister_script( 'wc-add-to-cart-variation' );
        wp_register_script( 'wc-add-to-cart-variation', get_stylesheet_directory_uri() . '/assets/js/add-to-cart-variation.js', array( 'jquery', 'wp-util' ));
    }
}

// Кастомизация заголовков виджетов
function rs_change_widget_title($title, $instance, $wid) { 
	if ($wid == 'rs_woocommerce_product_categories') {
		$title = '<span class="panel-heading"><span class="panel-title"><a data-toggle="collapse" href="#collapseCategory"><i class="fa fa-caret-right"></i>' . $title .
			'</a></span></span>';		
	} else if ($wid == 'rs_woocommerce_price_filter') {
		$title = '<span class="panel-heading"><span class="panel-title"><a data-toggle="collapse" href="#collapsePrice"><i class="fa fa-caret-right"></i>' . $title .
			'</a></span></span>';				
	} else if ($wid == 'rs_woocommerce_layered_nav') {
		$title_translit = rs_string_translit($title);
		$title = '<span class="panel-heading"><span class="panel-title"><a data-toggle="collapse" href="#collapse_' . $title_translit. '"><i class="fa fa-caret-right"></i>' . $title .
			'</a></span></span>';					
	} else if ($wid == 'rs_woocommerce_onsale_filter') {
		$title = '<span class="panel-heading"><span class="panel-title"><a data-toggle="collapse" href="#collapseOnsale"><i class="fa fa-caret-right"></i>' . $title .
			'</a></span></span>';			
	} else if ($wid == 'rs_woocommerce_reset_button') {
        $title = '';
    }

	return $title;
}
add_filter('widget_title', 'rs_change_widget_title', 10, 3);

/*Отключение блока оплты*/
//add_filter( 'woocommerce_cart_needs_payment', '__return_false' );

// Редактирование кастомайзера
add_action( 'customize_register', 'my_theme_customize_register', 11 );
function my_theme_customize_register($wp_customize) {
   $wp_customize->remove_section('storefront_footer');
   $wp_customize->remove_control('woocommerce_catalog_columns');
}; 

// Отключение корзины
function rs_is_cart_off() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 32, // id блока
				'compare' => '=' 
			)
		)
	));	
	while ( $query->have_posts() ) {
		$query->the_post();
	}
	$result = get_field("cart_on") ?: '';
	wp_reset_query();	
	return $result;
}

// Что выводить сумму или количество у мини-корзины
function rs_is_cart_count() {
    $query = new WP_Query( array (
        'post_type' => 'custom_block',
        'meta_query' => array (
            'relation' => 'OR',
            array (
                'key'     => 'block_id',
                'value'   => 32, // id блока
                'compare' => '='
            )
        )
    ));
    while ( $query->have_posts() ) {
        $query->the_post();
    }
    $result = get_field("check_params");
    wp_reset_query();
    return $result;
}

// Отключение хуков главной и корзины 
function delete_homepage() {
	remove_action( 'storefront_page', 'storefront_page_header', 10 );
	remove_action('homepage', 'storefront_homepage_content', 10);
	remove_action('homepage', 'storefront_product_categories', 20);
	remove_action('homepage', 'storefront_recent_products', 30);
	remove_action('homepage', 'storefront_featured_products', 40);
	remove_action('homepage', 'storefront_popular_products', 50);
	remove_action('homepage', 'storefront_on_sale_products', 60);
	remove_action('homepage', 'storefront_best_selling_products', 70);
};
add_action( 'init', 'delete_homepage', 1);

// Добавить новые хуки для главной 
function add_homepage() {
	//add_action('storefront_page', 'storefront_page_header_child', 10);
	// блок template-parts/rs-slider
	add_action('homepage', 'storefront_slider_child', 5);
	// блок template-parts/rs-text-blocks
	//add_action('homepage', 'storefront_homepage_content_child', 10);
	// блок template-parts/rs-services
	add_action('homepage', 'storefront_rs_services', 30);	
	// блок template-parts/rs-popular
	add_action('homepage', 'storefront_popular_products_child', 50);
	// блок template-parts/rs-onsale
	add_action('homepage', 'storefront_onsale_products_child', 60);			
	// блок template-parts/rs-new-products
	add_action('homepage', 'storefront_best_selling_products_child', 70);
	// блок template-parts/rs-best-sellers
	add_action('homepage', 'storefront_recent_products_child', 80);
}
add_action( 'init', 'add_homepage', 2);

add_action( 'init', 'rs_wc_mobile_menu', 3);
function rs_wc_mobile_menu(){
    global $del_link,$add_link;
    if(!is_admin()):
//Кастомизация ссылок мобильного меню
    $on_mobile_menu= get_field("on_mobile_menu",1910);
    if(!$on_mobile_menu){
        //Отключение всего блока
        add_action( 'init', 'rs_remove_storefront_handheld_footer_bar' );
        function rs_remove_storefront_handheld_footer_bar() {
            remove_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );
        }
    } else {

        $field_del_link=get_field_object("del_link",1910);
        $del_link = $field_del_link['value'];
        $link_home = get_field("link_home",1910);
        if( $del_link ):  ?>
            <?php
            //Отключение ссылок
            add_filter ('storefront_handheld_footer_bar_links', 'rs_remove_handheld_footer_links');
            function rs_remove_handheld_footer_links ($links) {
                global $del_link;
                foreach( $del_link  as $link ): ?>
                    <?php unset( $links[$link] );?>
                <?php endforeach;
                return $links;
             } ?>
        <?php endif;
        //Добавление ссылки на главную страницу
        if( $link_home ):  ?>
            <?php
            add_filter( 'storefront_handheld_footer_bar_links', 'rs_add_home_link' );
            function rs_add_home_link( $links ) {
                $new_links = array(
                    'home' => array(
                        'priority' => 10,
                        'callback' => 'rs_home_link',
                    ),
                );
                $links = array_merge( $new_links, $links );
                return $links;
            }
            function rs_home_link() {
                echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home' ) . '</a>';
            }
            ?>
        <?php  endif;
    }
    endif;
}

add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );