<?php

// Виджет Фильтр по распродаже
function rs_onsale_filter_widget() {

	register_widget( 'RS_WC_Widget_Onsale_filter' );
}

add_action( 'widgets_init', 'rs_onsale_filter_widget' );
class RS_WC_Widget_Onsale_filter extends WC_Widget {

	public function __construct() {
		$this->widget_cssclass    = 'panel panel-default woocommerce widget_layered_nav woocommerce-widget-layered-nav';
		$this->widget_description = __( 'Display a list of attributes to filter products in your store.', 'woocommerce' );
		$this->widget_id          = 'rs_woocommerce_onsale_filter';
		$this->widget_name        = 'RS Фильтр товаров по скидке';
		parent::__construct();
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * @see WP_Widget->update
	 *
	 * @param array $new_instance New Instance.
	 * @param array $old_instance Old Instance.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$this->init_settings();
		return parent::update( $new_instance, $old_instance );
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @see WP_Widget->form
	 *
	 * @param array $instance Instance.
	 */
	public function form( $instance ) {
		$this->init_settings();
		parent::form( $instance );
	}

	/**
	 * Init settings after post types are registered.
	 */
	public function init_settings() {

		$this->settings  = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Filter by price', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
		);
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args Arguments.
	 * @param array $instance Instance.
	 */
	public function widget( $args, $instance ) {
		//global $products;

		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		$widget_title = rs_string_translit($instance['title']);

		$get_terms_args = array( 'hide_empty' => '1' );

		$this->widget_start( $args, $instance );

		if (isset($_GET['onsale_filter']) && $_GET['onsale_filter'] == 1) {
		    $current_filter = 1;
		} else if (isset($_GET['onsale_filter']) && $_GET['onsale_filter'] == 0) {
			$current_filter = 0;
		} else {
			$current_filter = 3;
		}

        $filter_name    = 'onsale_filter';

        $link = remove_query_arg( $filter_name, $this->get_current_page_url() );
        $link_sale=$link;
        if ( !empty( $current_filter ) ) {
            $link_sale = add_query_arg( $filter_name,  $current_filter , $link );
        }


		/*if($instance['count']) {
			$products_onsale = "<span class='badge'>". count(wc_get_product_ids_on_sale()). "</span>"; 
			$all_products = (count(wc_get_products( array( 'status' => 'publish', 'limit' => -1 ))));
		}*/
		/*$products = wc_get_products(array(
		    'numberposts' => -1,
		    'post_status' => 'published', // Only published products
		    // 'meta_key'    => '_customer_user',
		    // 'meta_value'  => get_current_user_id(), // Or $user_id
		) );*/

		//var_dump(wc_get_products( ));
		echo '<div id="collapseOnsale" class="panel-collapse collapse in">';
		echo '<div class="panel-body">';
		echo '<ul class="nav nav-pills nav-stacked">';


		echo '<li class="cat-item '.( $current_filter == 1 ? 'current-cat' : '' ) .' "><a rel="nofollow" href="' . ($current_filter == 1? $link :add_query_arg( $filter_name,  1 , $link )) . '">Товары со скидкой</a></li>';
		echo '<li class="cat-item '.( $current_filter == 0 ? 'current-cat' : '' ) .' "><a rel="nofollow" href="' . ($current_filter == 0?$link:add_query_arg( $filter_name,  0 , $link )) . '">Товары без скидки</a> <span class="badge"></span></li>';
       // echo '<li class="cat-item "><a rel="nofollow" href="' . $this->rs_url_without_get($current_filter) . '">Очистить фильтр</a> </li>';
		echo '</ul>';
		echo '</div>';	
		echo '</div>';

		$this->widget_end( $args );

	}

	
}
