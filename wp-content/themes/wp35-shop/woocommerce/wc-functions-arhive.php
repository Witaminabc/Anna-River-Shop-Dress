<?php

add_action( 'widgets_init', 'remove_storefront_widgets' );
function remove_storefront_widgets() {
	unregister_widget('WC_Widget_Layered_Nav');
	unregister_widget('WC_Widget_Price_Filter');
	unregister_widget('WC_Widget_Product_Categories');
}

//add_action( 'woocommerce_before_main_content', 'rs_arhive_wrapper_start', 40 );
function rs_arhive_wrapper_start() { ?>
	<div class="col-lg-9 col-md-9 col-sm-12">
<?php }

//add_action( 'woocommerce_after_main_content', 'rs_arhive_wrapper_end', 30 );
function rs_arhive_wrapper_end() { ?>
	</div>
<?php }

//add_action( 'woocommerce_sidebar', 'rs_arhive_woocommerce_sidebar', 10 );
function rs_arhive_woocommerce_sidebar() { ?>
	
<?php }

// открывающий тег внутренней сетки товаров
function rs_woocommerce_product_loop_start() { ?>
	<div class="row categoryProduct xsResponse clearfix grid-view">
<?php }

if(is_shop() || is_product_category() ){
    // подключение стилей для модального окна "быстрый просмотр"
    add_action( 'wp_enqueue_scripts', 'style_rs_product_view_theme');
    function style_rs_product_view_theme() {
        wp_enqueue_style( 'rs-product-view', get_stylesheet_directory_uri().'/woocommerce/css/rs-product-view.css');
    }
}

function rs_woocommerce_breadcrumb() {
    if(!is_shop()){
    wp_enqueue_style( 'rs-breadcrumbs', get_stylesheet_directory_uri().'/woocommerce/css/rs-breadcrumbs.css');
    ?>
<!--<div class="rs-17">-->
	<div class="rs-breadcrumbs catalog">
		<div class="row">
			<div class="col-xs-12">
				<?php woocommerce_breadcrumb(); ?>		
			</div>
		</div>
	</div>
<!--</div>-->
<?php  }}

// Отключение стандартных функций каталога
function rs_delete_arhive() {

	remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	remove_action('woocommerce_before_main_content', 'WC_Structured_Data::generate_website_data', 30);
	remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
	remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
	
	remove_action('woocommerce_before_main_content', 'storefront_before_content', 10);
	remove_action('woocommerce_after_main_content', 'storefront_after_content', 10);
	
	remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9 );
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
	//remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 30 );
	remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31 );
	
	remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
	remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31 );

	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

	remove_action( 'woocommerce_after_single_product_summary', 'storefront_upsell_display', 15 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6 );
	remove_action( 'woocommerce_after_single_product_summary', 'storefront_single_product_pagination', 30 );

	remove_action( 'woocommerce_after_single_product_summary', 'storefront_single_product_pagination', 30 );

	remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );

};
add_action( 'init', 'rs_delete_arhive', 1);

// Добавить новые блоки для каталога 
function rs_add_arhive() {
    add_action('woocommerce_before_main_content', 'rs_woocommerce_breadcrumb', 5);
	add_action('woocommerce_archive_description', 'rs_woocommerce_taxonomy_archive_description', 10);
	add_action('woocommerce_archive_description', 'rs_woocommerce_product_archive_description', 10);

	add_action('woocommerce_before_main_content', 'rs_woocommerce_output_content_wrapper', 7);
	add_action('woocommerce_before_main_content', 'rs_storefront_before_content', 10);
	add_action('woocommerce_after_main_content', 'rs_storefront_after_content', 10);
	add_action('woocommerce_after_main_content', 'rs_woocommerce_output_content_wrapper_end', 20);
	
	add_action('woocommerce_before_shop_loop', 'rs_storefront_sorting_wrapper', 10);
	add_action('woocommerce_before_shop_loop', 'rs_woocommerce_result_count', 20 );
	add_action('woocommerce_before_shop_loop', 'rs_woocommerce_catalog_ordering', 25 );
	add_action('woocommerce_before_shop_loop', 'rs_storefront_sorting_wrapper_close', 31);

	add_action( 'woocommerce_before_shop_loop_item_title', 'rs_woocommerce_template_loop_product', 10 );

	add_action( 'woocommerce_shop_loop_subcategory_title', 'rs_woocommerce_template_loop_category_title', 10 );

}
add_action( 'init', 'rs_add_arhive', 2);

// Открывающая и закрывающая функции контент каталога
function rs_storefront_before_content() {
	do_action( 'storefront_sidebar' );
	?>
		<div id="primary" class="col-lg-9 col-md-9 col-sm-12">
			<main id="main" class="site-main">
	<?php
}
function rs_storefront_after_content() {
	?>
			</main><!-- #main -->
		</div><!-- #primary -->
	<?php

	do_action( 'storefront_sidebar' );
}

// Обёртка для каталога и сайдбара
function rs_woocommerce_output_content_wrapper() {
	?>
		<div class="row">
	<?php
}
function rs_woocommerce_output_content_wrapper_end() {
	?>
		</div>
	<?php
}


// Кастомизация хлебных крошек
add_filter( 'woocommerce_breadcrumb_defaults', 'rs_custom_breadcrumb', 25 );
function rs_custom_breadcrumb( $defaults ) {
    if (is_woocommerce()) {
		$defaults['delimiter'] = '<span class="sep"> / </span>';
		$defaults['wrap_before'] = '<div class="breadcrumbs">';
		$defaults['wrap_after'] = '</div>';
		$defaults['before'] = '<span>';
		$defaults['after'] = '</span>';
		$defaults['home'] = get_the_title(5);
						
    } else {
        $defaults['delimiter'] = '<span class="sep"> / </span>';
		$defaults['wrap_before'] = '<div class="breadcrumbs">';
		$defaults['wrap_after'] = '</div>';
		$defaults['before'] = '<span>';
		$defaults['after'] = '</span>';
    }
    return $defaults;
}

add_filter( 'woocommerce_breadcrumb_home_url', 'rs_custom_breadcrumb_home' );
function rs_custom_breadcrumb_home( $home_url ) {
    if (is_woocommerce()) {
	    return  get_post_type_archive_link('product');
	} else {
       return $home_url;
	}

}

// Кастомизация описания раздела
function rs_woocommerce_taxonomy_archive_description() {
	global $post;
	if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
		$term = get_queried_object();
		if ($term && $img_id = get_term_meta( $term->term_id, 'thumbnail_id', true)) {
			$image = wp_get_attachment_image_src( $img_id, 'large' ); 
			?>
			<div class="img-banner">
				<img data-src='<?=$image[0]; ?>' src='<?=$image[0]; ?>' class='img-responsive b-lazy' alt>
			</div>
			<?php			
		}
		if ( $term && ! empty( $term->description ) ) {
			echo '<div>' . wc_format_content( $term->description ) . '</div>';
		}
	}
}

function rs_woocommerce_product_archive_description() {
	if ( is_search() ) {
		return;
	}
	if ( is_post_type_archive( 'product' ) && in_array( absint( get_query_var( 'paged' ) ), array( 0, 1 ), true ) ) {
		$shop_page = get_post( wc_get_page_id( 'shop' ) );
		if ( $shop_page ) {
			$description = wc_format_content( $shop_page->post_content );
			if ( $description ) {
				echo '<p>' . $description . '</p>'; // WPCS: XSS ok.
			}
		}
	}	
}

// Кастомизация фильтра сетки продуктов
function rs_storefront_sorting_wrapper() {
	echo '<div class="product-filter clearfix">';
}

function rs_storefront_sorting_wrapper_close() {
	echo '</div>';
}

function rs_woocommerce_result_count() {
	//global $post;
	if ( ! wc_get_loop_prop( 'is_paginated' ) /*|| ! woocommerce_products_will_display() */) {
		return;
	}
	$args = array(
		'total'    => wc_get_loop_prop( 'total' ),
		'per_page' => wc_get_loop_prop( 'per_page' ),
		'current'  => wc_get_loop_prop( 'current_page' ),
	);
	?>
		<p class="pull-left">
			<?php
			//var_dump($args['total'] <= $args['per_page'] || -1 === $args['per_page']);
			if ( $args['total'] <= $args['per_page'] || -1 === $args['per_page'] ) {
			    echo 'Показано продуктов: <b class="count">'.$args['total'].'</b>';
               // printf( _nx( '', 'Показано продуктов: <b class="count">%1$d</b>', $args['total'],  'woocommerce' ), $args['total'] );
			}  else {
				$first = ( $args['per_page'] * $args['current'] ) - $args['per_page'] + 1;
				$last  = min( $args['total'], $args['per_page'] * $args['current'] );

				printf( _nx( '', 'Показано продуктов: <b class="count">%3$d</b>', $args['total'],  'woocommerce' ), $first, $last, $args['total'] );
			}
			?>
		</p>
	<?php
}

function rs_woocommerce_catalog_ordering() {

	if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() || ! woocommerce_product_loop() ) {
		return;
	}
	$show_default_orderby = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
	$catalog_orderby_options = apply_filters(
		'woocommerce_catalog_orderby',
		array(
			'menu_order' => __( 'Сортировать по:', 'woocommerce' ),
			'popularity' => __( 'Sort by popularity', 'woocommerce' ),
			'price'      => __( 'По цене (по возрастанию)', 'woocommerce' ),
			'price-desc' => __( 'По цене (по убыванию)', 'woocommerce' ),
			'date'       => __( 'По новизне', 'woocommerce' ),
		)
	);
	$default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
	$orderby         = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby; // WPCS: sanitization ok, input var ok, CSRF ok.
	if ( wc_get_loop_prop( 'is_search' ) ) {
		$catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'woocommerce' ) ), $catalog_orderby_options );
		unset( $catalog_orderby_options['menu_order'] );
	}
	if ( ! $show_default_orderby ) {
		unset( $catalog_orderby_options['menu_order'] );
	}
	unset( $catalog_orderby_options['rating'] );
	/*if ( ! wc_review_ratings_enabled() ) {
		unset( $catalog_orderby_options['rating'] );
	}*/
	if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
		$orderby = current( array_keys( $catalog_orderby_options ) );
	}
	?>
	<div class="change-order pull-right">
		<form class="woocommerce-ordering" method="get">
			<select name="orderby" class="orderby select2-container">
				<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
					<option class="select2-container__option" value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
			<input type="hidden" name="paged" value="1" />
			<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
		</form>
	</div>
	<?php
}

// Кастомизация сетки продуктов
function rs_woocommerce_template_loop_product_thumbnail() {
	global $product;
	?>
		<div class="product-image">
	<?php

		$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
		echo $product ? $product->get_image( $image_size ) : '';
	?>
		</div>
	<?php 
}

// вывод карточки продукта в каталоге
function rs_woocommerce_template_loop_product() {
	global $product;
	$title_products = (mb_strlen(get_the_title()) > 45) ?
								mb_substr(get_the_title(), 0, 45) . '...' : get_the_title();

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
//	if($product->is_type( 'variable' )) $discount ='от '.$discount;
	// обрезка краткого описания до 80 символов

	$short_description = get_the_excerpt();
    $description = $short_description? the_excerpt_max_charlength(strip_tags(preg_replace ('~\[[^\]]+\]~', '',$short_description)), 80):the_excerpt_max_charlength(strip_tags(preg_replace ('~\[[^\]]+\]~', '',$product->get_description())), 80);
	?>
	<div class="product">
		<div class="product-image">
			<div class="quickview">
				<a data-id="<?=$product->get_ID(); ?>" class="btn btn-xs btn-quickview" href="#" data-target="#product-details-modal" data-path="<?=get_stylesheet_directory_uri(); ?>"
				   data-toggle="modal">Быстрый просмотр</a>
			</div>
			<a href="<?php echo get_permalink() ?>">
				<?php if (has_post_thumbnail()) {
				  /*echo get_the_post_thumbnail( $product->get_ID(), 'shop_catalog');*/  ?>
				  <img src="<?php the_post_thumbnail_url( 'shop_catalog' ); ?>" alt="<?=$title_products ?>">
				<?php }
					else echo '<img src="'.wc_placeholder_img_src().'" data-src="'.wc_placeholder_img_src().'" alt="Placeholder" width="250px" height="250px" />';
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
			<p><?=$description; ?></p>					
		</div>
		 <?php
            rs_available_attributes();
            $class = ($product->is_on_sale())?'in_sale':'';
		?>
		<div class="price-block">
			<span class="price <?=$class?>">
				<?php echo $product->get_price_html(); ?> 
			</span>
		</div>
		<div class="action-control">
			<a href="<?php echo get_permalink() ?>" class="btn btn-color">Подробнее</a>
			<div class="btn btn-default addBascetAjax gridlist-buttonwrap"><?php woocommerce_template_loop_add_to_cart(); ?></div>
		</div>
		<div class="success text-center"></div>
	</div>
	<?php
}
//Вывод атрибутов в карточке продукта в каталоге
function rs_available_attributes() {
    global $product;
    if ( ! $product->is_type( 'variable' ) ) {
        return;
    }
    $attributes = rs_get_available_attributes( $product );
    ksort($attributes);
    if ( empty( $attributes ) ) {
        return;
    }
    foreach ( $attributes as $key=>$attribute ) {

        if($attribute["slug"]=='pa_color'):
        ?>
        <div class="sub-description sub-description_color">
                <?php foreach ( $attribute['values'] as $key=>$value ) {
                    ?>
                    <span class="iconic-available-attributes__value <?php echo $value['available'] ? '' : 'iconic-available-attributes__value--unavailable'; ?>" style="background-color: #<?=$key?>;"><?php echo $value['name']; ?></span>
                <?php } ?>
        </div>
        <?php elseif ($attribute["slug"]=='pa_size'):
        ?>
        <div class='sub-description sub-description_size'>
            <?php
            $tag_list = Array();
            foreach ( $attribute['values'] as $value ) {
                $tag_list[] = $value['name'];
            }
            echo implode( ' / ', $tag_list );
            ?>
         </div>
       <?php else: ?>
        <div class="sub-description">
            <ul class="iconic-available-attributes__values ">
                <?php foreach ( $attribute['values'] as $key=>$value ) {
                    ?>
                    <li class="iconic-available-attributes__value <?php echo $value['available'] ? '' : 'iconic-available-attributes__value--unavailable'; ?>" ><?php echo $value['name']; ?></li>
                <?php } ?>
            </ul>
        </div>
        <?php
        endif;
    }
}
function rs_get_available_attributes( $product ) {
	static $available_attributes = array();
	$product_id = $product->get_id();
	if ( isset( $available_attributes[ $product_id ] ) ) {
		return $available_attributes[ $product_id ];
	}
	$available_attributes[ $product_id ] = array();
	$attributes = $product->get_variation_attributes();
	if ( empty( $attributes ) ) {
		return $available_attributes[ $product_id ];
	}
	$attributes_to_show = rs_get_attributes_to_show();
	//var_dump($attributes_to_show);
	foreach ( $attributes as $attribute => $values ) {
		if ( ! in_array( $attribute, $attributes_to_show ) ) {
			continue;
		}
		$available_attribute = rs_get_available_attribute( $product, $attribute, $values );

		if ( empty( $available_attribute ) ) {
			continue;
		}
		$key = array_search($attribute, $attributes_to_show);
		$available_attributes[ $product_id ][$key] = $available_attribute;
	}
	return $available_attributes[ $product_id ];
}
//Какие атрибуты выводить
function rs_get_attributes_to_show() {
    return apply_filters( 'rs_get_attributes_to_show', array('pa_size','pa_color',) );
}
function rs_get_available_attribute( $product, $attribute, $values ) {
    $available_attribute = array(
        'slug' => $attribute,
    );
    if ( ! taxonomy_exists( $attribute ) ) {
        $available_attribute['name'] = $attribute;
        foreach ( $values as $value ) {
            $available_attribute['values'][ $value ] = array(
                'name'      => $value,
                'available' => rs_has_available_variation( $product, $attribute, $value ),
            );
        }
        return $available_attribute;
    }
    $taxonomy = get_taxonomy( $attribute );
    $labels   = get_taxonomy_labels( $taxonomy );
    $available_attribute['name']   = $labels->singular_name;
    $available_attribute['values'] = array();
    foreach ( $values as $value ) {
        $term = get_term_by( 'slug', $value, $attribute );
        if ( ! $term ) {
            continue;
        }
        $available_attribute['values'][ $value ] = array(
            'name'      => $term->name,
            'available' => rs_has_available_variation( $product, $attribute, $value ),
        );
    }
    return $available_attribute;
}
// есть ли вариант, доступный для покупки?
function rs_has_available_variation( $product, $attribute, $value ) {
    $available_variation = false;
    $attribute           = 'attribute_' . sanitize_title( $attribute );
    $variations          = $product->get_available_variations();
    if ( empty( $variations ) ) {
        return $available_variation;
    }
    foreach ( $variations as $variation ) {
        foreach ( $variation['attributes'] as $variation_attribute_name => $variation_attribute_value ) {
            if ( $attribute !== $variation_attribute_name ) {
                continue;
            }
            if ( $value !== $variation_attribute_value && ! empty( $variation_attribute_value ) ) {
                continue;
            }
            $available_variation = $variation['is_purchasable'] && $variation['is_in_stock'];
            break;
        }
        if ( $available_variation ) {
            break;
        }
    }
    return $available_variation;
}

// фильтр для добавления в мини-корзину через аякс
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	storefront_header_cart_child();
	$fragments['div#header-cart-content'] = ob_get_clean();
	return $fragments;
}

function remove_product(){
    $cart_item_key = $_POST['cart_item_key'];
    if ($cart_item_key) {
		WC()->cart->remove_cart_item( $cart_item_key );
    }
}

// Кастомизация вывода заголовка катеорий
function rs_woocommerce_template_loop_category_title( $category ) {
	?>
	<div class="catalog-description">
		<?php
		echo '<h4>'. esc_html( $category->name ); 
		/*if ( $category->count > 0 ) {
			echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="badge">' . esc_html( $category->count ) . '</mark>', $category ); // WPCS: XSS ok.
		}*/
		echo '</h4>';
		?>
	</div>
	<?php
}

// вывод товаров по фильтру со скидкой
add_action( 'woocommerce_product_query', 'so_20990199_product_query' );
function so_20990199_product_query( $q ){
	if (isset($_GET['onsale_filter']) && $_GET['onsale_filter'] == 1) {
	    $product_ids_on_sale = wc_get_product_ids_on_sale();
	    $q->set( 'post__in', $product_ids_on_sale );
	} else if (isset($_GET['onsale_filter']) && $_GET['onsale_filter'] == 0) {
	    $product_ids_on_sale = wc_get_product_ids_on_sale();
	    $q->set( 'post__not_in', $product_ids_on_sale );
	}
}