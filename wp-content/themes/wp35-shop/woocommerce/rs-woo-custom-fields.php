<?php

// Добавление произвольных полей к товару
function rs_woo_add_custom_fields() {
	global $product, $post;

	echo '<div class="options_group">';
	woocommerce_wp_checkbox( array(
		'id'            => '_new_product',
		'label'         => 'Новинка',
		'description'   => 'Показывать в блоке "Новые товары"',
	) );
	echo '</div>';

	echo '<div class="options_group">';
	woocommerce_wp_checkbox( array(
		'id'            => '_best_seller',
		'label'         => 'Лучший по продажам',
		'description'   => 'Показывать в блоке "Самые продаваемые"',
	) );
	echo '</div>';	

	echo '<div class="options_group">';
	woocommerce_wp_checkbox( array(
		'id'            => '_popular_product',
		'label'         => 'Популярные',
		'description'   => 'Показывать в блоке "Популярные"',
	) );
	echo '</div>';

	echo '<div class="options_group">';
	woocommerce_wp_checkbox( array(
		'id'            => '_onsale_product',
		'label'         => 'Распродажа',
		'description'   => 'Показывать в блоке "Распродажа"',
	) );
	echo '</div>';

}

add_action( 'woocommerce_product_options_general_product_data', 'rs_woo_add_custom_fields', 10 );

// Сохранение произвольных полей
function rs_woo_custom_fields_save( $post_id ) {

   $woocommerce_checkbox = isset( $_POST['_new_product'] ) ? 'yes' : 'no';
   update_post_meta( $post_id, '_new_product', $woocommerce_checkbox );

   $woocommerce_checkbox = isset( $_POST['_best_seller'] ) ? 'yes' : 'no';
   update_post_meta( $post_id, '_best_seller', $woocommerce_checkbox );

   $woocommerce_checkbox = isset( $_POST['_popular_product'] ) ? 'yes' : 'no';
   update_post_meta( $post_id, '_popular_product', $woocommerce_checkbox ); 

   $woocommerce_checkbox = isset( $_POST['_onsale_product'] ) ? 'yes' : 'no';
   update_post_meta( $post_id, '_onsale_product', $woocommerce_checkbox );        
}

add_action( 'woocommerce_process_product_meta', 'rs_woo_custom_fields_save', 10 );