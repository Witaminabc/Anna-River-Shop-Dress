<?php
// Подключить стили для блока
function style_rs_services_theme() {
    wp_enqueue_style( 'rs-services', get_stylesheet_directory_uri().'/template-parts/rs-services/css/rs-services.css');
}
add_action( 'template_redirect', 'rs_template_services_include' );
function rs_template_services_include(){
    global $post;
    if( is_post_type_archive('services') || isset($post->post_type) && $post->post_type == 'services'){
        add_action( 'wp_print_scripts', 'style_rs_services_theme');
    }
}
// Регистрация типа записей
add_post_type('services', 'Услуга', array(
	'supports'   => array( 'title', 'editor', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-admin-page'
));
//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
add_filter('post_type_labels_services', 'rename_posts_labels_services');
function rename_posts_labels_services ( $labels ){
	$new = array(
		'name'                  => 'Услуги',
		'singular_name'         => 'Услуга',
		'add_new'               => 'Добавить услугу',
		'add_new_item'          => 'Добавить услугу',
		'edit_item'             => 'Редактировать услугу',
		'new_item'              => 'Новая услуга',
		'view_item'             => 'Просмотреть услугу',
		'search_items'          => 'Поиск услуг',
		'not_found'             => 'Услуг не найдено.',
		'not_found_in_trash'    => 'Услуг в корзине не найдено.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все услуги',
		'archives'              => 'Архивы услуг',
		'insert_into_item'      => 'Вставить в услугу',
		'uploaded_to_this_item' => 'Загруженные для этой услуги ',
		'featured_image'        => 'Миниатюра услуги',
		'filter_items_list'     => 'Фильтровать список услуг',
		'items_list_navigation' => 'Навигация по списку услуг',
		'items_list'            => 'Список услуг',
		'menu_name'             => 'Услуги',
		'name_admin_bar'        => 'Услуги', // пункте "добавить"
	);
	return (object) array_merge( (array) $labels, $new );
}

add_filter('template_include', 'my_template_services');
function my_template_services( $template ) {
	# шаблон для архива произвольного типа "services"
	global $posts;
	if( is_post_type_archive('services') ){
		return get_stylesheet_directory() . '/template-parts/rs-services/services-arhive-tpl.php';
	}
	# шаблон для страниц произвольного типа "services"
	global $post;
	if(isset($post->post_type) && $post->post_type == 'services' ){
		return get_stylesheet_directory() . '/template-parts/rs-services/services-tpl.php';
	}
	return $template;
}

function storefront_rs_services() {
    add_action( 'wp_print_scripts', 'style_rs_services_theme');
    $query = new WP_Query( array (
		'post_type' => 'custom_block',
		//'name' => 'katalog-na-glavnoj'
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 2, // идентификатор блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		$block_title = get_field("block_title");
		$custom_category_arr = [
			'path_name' => [
				'row_1_category_1',
				'row_1_category_2',
				'row_2_category_1',
				'row_2_category_2',
				'row_2_category_3',
				'row_3_category_1',
				'row_3_category_2',
				'row_4_category_1',
				'row_4_category_2'
			],
			'img' => [],
			'post_category' => [],
			'post_category_name' => [],
			'post_category_link' => []
		];
		$section_priority = [
			'section1' => get_field("priority_section_1"),
			'section2' => get_field("priority_section_2"),
			'section3' => get_field("priority_section_3")
		];
		asort($section_priority);
		for ($i = 0; $i < 9; $i++) {
			$path_name = $custom_category_arr["path_name"][$i];
			$post_img = get_field($path_name."_img");
			array_push($custom_category_arr['img'], $post_img);
			$custom_cat = get_field("path_" . ($i + 1));
			if ($custom_cat) {
				array_push($custom_category_arr['post_category'], $custom_cat);
				array_push($custom_category_arr['post_category_name'], $custom_cat['title']);
				array_push($custom_category_arr['post_category_link'], $custom_cat['url']);
			} else {
				$product_cat = get_field($path_name);
				array_push($custom_category_arr['post_category'], $product_cat);
				array_push($custom_category_arr['post_category_name'], $product_cat->name);
				array_push($custom_category_arr['post_category_link'], get_category_link($product_cat->term_id));					
			}
		}
	}
?>
<!-- rs-services -->
<section class="rs-17">
	<div class="rs-services">
		<div class="container">
			<?php if ( $block_title ) :?>
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50">
						<span class="section-title--text"><?=$block_title; ?></span>
					</h2>
				</div>
			</div>
			<?php endif; ?>

			<div class="row services-row">

				<?php 
					foreach($section_priority as $key => $value) {
						switch ($key) {
							case 'section1':
								if ( $value && $custom_category_arr['img'][0] && $custom_category_arr['post_category'][0] ) :?>
								<div class="col-xs-12 col-sm-6">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="100">
										<a href="<?=$custom_category_arr['post_category_link'][0];  ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][0]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][0]; ?>" title="cat-baner1-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( $value && $custom_category_arr['img'][1] && $custom_category_arr['post_category'][1] ) :?>
								<div class="col-xs-12 col-sm-6">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="100">
										<a href="<?=$custom_category_arr['post_category_link'][1];  ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][1]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][1]; ?>" title="cat-baner1-min"></div>
										</a>
									</div>
								</div>
								<div class="clearfix"></div>
								<?php endif;
								break;
							case 'section2':
								if ( $value && $custom_category_arr['img'][2] && $custom_category_arr['post_category'][2] ) :?>
								<div class="col-xs-12 col-sm-4">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="300">
										<a href="<?=$custom_category_arr['post_category_link'][2]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][2]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img data-src" data-small="<?=$custom_category_arr['img'][2]; ?>" title="cat-baner3-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>					
								<?php if ( $value && $custom_category_arr['img'][3] && $custom_category_arr['post_category'][3] ) :?>
								<div class="col-xs-12 col-sm-4">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="300">
										<a href="<?=$custom_category_arr['post_category_link'][3];  ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][3]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][3]; ?>" title="cat-baner3-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>					
								<?php if ( $value && $custom_category_arr['img'][4] && $custom_category_arr['post_category'][4] ) :?>
								<div class="col-xs-12 col-sm-4">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="300">
										<a href="<?=$custom_category_arr['post_category_link'][4]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][4]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][4]; ?>" title="cat-baner3-min"></div>
										</a>
									</div>
								</div>
								<div class="clearfix"></div>
								<?php endif;
								break;
							case 'section3':
								if ( $value && $custom_category_arr['img'][5] && $custom_category_arr['post_category'][5] ) :?>
								<div class="col-xs-12 col-sm-3 col-sm-3">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="600">
										<a href="<?=$custom_category_arr['post_category_link'][5]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][5]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][5]; ?>" title="cat-baner6-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>					
								<?php if ( $value && $custom_category_arr['img'][6] && $custom_category_arr['post_category'][6] ) :?>
								<div class="col-xs-12 col-sm-3 col-sm-3">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="600">
										<a href="<?=$custom_category_arr['post_category_link'][6]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][6]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][6]; ?>" title="cat-baner6-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>					
								<?php if ( $value && $custom_category_arr['img'][7] && $custom_category_arr['post_category'][7] ) :?>
								<div class="col-xs-12 col-sm-3 col-sm-3">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="600">
										<a href="<?=$custom_category_arr['post_category_link'][7]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][7]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][7]; ?>" title="cat-baner6-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>					
								<?php if ( $value && $custom_category_arr['img'][8] && $custom_category_arr['post_category'][8] ) :?>
								<div class="col-xs-12 col-sm-3 col-sm-3">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="600">
										<a href="<?=$custom_category_arr['post_category_link'][8]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][8]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][8]; ?>" title="cat-baner6-min"></div>
										</a>
									</div>
								</div>
								<div class="clearfix"></div>
								<?php endif;
								break;
							default:
								break;
						}
					}
				?>
			</div>
		</div>
	</div>
</section>
<!-- /.rs-services -->
<?php
}
function storefront_rs_services_2() {
    add_action( 'wp_print_scripts', 'style_rs_services_theme');
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		//'name' => 'katalog-na-glavnoj'
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 25, // идентификатор блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		$block_title = get_field("block_title");
		$custom_category_arr = [
			'path_name' => [
				'row_1_category_1',
				'row_1_category_2',
				'row_2_category_1',
				'row_2_category_2',
				'row_2_category_3',
				'row_3_category_1',
				'row_3_category_2',
				'row_4_category_1',
				'row_4_category_2'
			],
			'img' => [],
			'post_category' => [],
			'post_category_name' => [],
			'post_category_link' => []
		];
		$section_priority = [
			'section1' => get_field("priority_section_1"),
			'section2' => get_field("priority_section_2"),
			'section3' => get_field("priority_section_3")
		];
		asort($section_priority);
		for ($i = 0; $i < 9; $i++) {
			$path_name = $custom_category_arr["path_name"][$i];
			$post_img = get_field($path_name."_img");
			array_push($custom_category_arr['img'], $post_img);
			$custom_cat = get_field("path_" . ($i + 1));
			if ($custom_cat) {
				array_push($custom_category_arr['post_category'], $custom_cat);
				array_push($custom_category_arr['post_category_name'], $custom_cat['title']);
				array_push($custom_category_arr['post_category_link'], $custom_cat['url']);
			} else {
				$product_cat = get_field($path_name);
				array_push($custom_category_arr['post_category'], $product_cat);
				array_push($custom_category_arr['post_category_name'], $product_cat->post_title);
				array_push($custom_category_arr['post_category_link'], get_post_permalink($product_cat->ID));					
			}
		}
	}
?>
<!-- rs-services -->
<section class="rs-17">
	<div class="rs-services">
		<div class="container">
			<?php if ( $block_title ) :?>
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50">
						<span class="section-title--text"><?=$block_title; ?></span>
					</h2>
				</div>
			</div>
			<?php endif; ?>
			<div class="row services-row">
				<?php 
					foreach($section_priority as $key => $value) {
						switch ($key) {
							case 'section1':
								if ( $value && $custom_category_arr['img'][0] && $custom_category_arr['post_category'][0] ) :?>
								<div class="col-xs-12 col-sm-6">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="100">
										<a href="<?=$custom_category_arr['post_category_link'][0];  ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][0]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][0]; ?>" title="cat-baner1-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( $value && $custom_category_arr['img'][1] && $custom_category_arr['post_category'][1] ) :?>				
								<div class="col-xs-12 col-sm-6">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="100">
										<a href="<?=$custom_category_arr['post_category_link'][1];  ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][1]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy"  data-src="<?=$custom_category_arr['img'][1]; ?>" title="cat-baner1-min"></div>
										</a>
									</div>
								</div>
								<div class="clearfix"></div>
								<?php endif;
								break;
							case 'section2':
								if ( $value && $custom_category_arr['img'][2] && $custom_category_arr['post_category'][2] ) :?>
								<div class="col-xs-12 col-sm-4">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="300">
										<a href="<?=$custom_category_arr['post_category_link'][2]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][2]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][2]; ?>" title="cat-baner3-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( $value && $custom_category_arr['img'][3] && $custom_category_arr['post_category'][3] ) :?>
								<div class="col-xs-12 col-sm-4">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="300">
										<a href="<?=$custom_category_arr['post_category_link'][3];  ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][3]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][3]; ?>" title="cat-baner3-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( $value && $custom_category_arr['img'][4] && $custom_category_arr['post_category'][4] ) :?>
								<div class="col-xs-12 col-sm-4">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="300">
										<a href="<?=$custom_category_arr['post_category_link'][4]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][4]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][4]; ?>" title="cat-baner3-min"></div>
										</a>
									</div>
								</div>
								<div class="clearfix"></div>
								<?php endif;
								break;
							case 'section3':
								if ( $value && $custom_category_arr['img'][5] && $custom_category_arr['post_category'][5] ) :?>				
								<div class="col-xs-12 col-sm-3 col-sm-3">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="600">
										<a href="<?=$custom_category_arr['post_category_link'][5]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][5]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][5]; ?>" title="cat-baner6-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( $value && $custom_category_arr['img'][6] && $custom_category_arr['post_category'][6] ) :?>	
								<div class="col-xs-12 col-sm-3 col-sm-3">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="600">
										<a href="<?=$custom_category_arr['post_category_link'][6]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][6]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][6]; ?>" title="cat-baner6-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( $value && $custom_category_arr['img'][7] && $custom_category_arr['post_category'][7] ) :?>	
								<div class="col-xs-12 col-sm-3 col-sm-3">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="600">
										<a href="<?=$custom_category_arr['post_category_link'][7]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][7]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy" data-src="<?=$custom_category_arr['img'][7]; ?>" title="cat-baner6-min"></div>
										</a>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( $value && $custom_category_arr['img'][8] && $custom_category_arr['post_category'][8] ) :?>	
								<div class="col-xs-12 col-sm-3 col-sm-3">
									<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="600">
										<a href="<?=$custom_category_arr['post_category_link'][8]; ?>">
											<div class="services-item--title">
												<h3>
													<?=$custom_category_arr['post_category_name'][8]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
												</h3>
											</div>
											<div class="overlay"></div>
											<div class="services-item--img b-lazy"  data-src="<?=$custom_category_arr['img'][8]; ?>" title="cat-baner6-min"></div>
										</a>
									</div>
								</div>
								<div class="clearfix"></div>
								<?php endif;
								break;
							default:
								break;
						}
					}
				?>
			</div>
		</div>
	</div>
</section>
<!-- /.rs-services -->
<?php
}

function storefront_rs_services_3() {
    add_action( 'wp_print_scripts', 'style_rs_services_theme');
    $query = new WP_Query( array (
        'post_type' => 'custom_block',
        //'name' => 'katalog'
        'meta_query' => array (
            'relation' => 'OR',
            array (
                'key'     => 'block_id',
                'value'   => 33, // идентификатор блока
                'compare' => '='
            )
        )
    ));
    while ( $query->have_posts() ) {
        $query->the_post();
        $post_meta = get_post_meta($query->post->ID);
    }

    if ($post_meta) {
        $block_title = get_field("block_title");
    }
    ?>
    <!-- rs-services -->
    <section class="rs-17">
        <div class="rs-services">
            <div class="container">
                <?php if ( $block_title ) :?>
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50">
                                <span class="section-title--text"><?=$block_title; ?></span>
                            </h2>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row services-row">

                    <?php if(have_rows('catalog')):
                        $catalog = get_field('catalog');
                        ?>
                        <?php foreach ( $catalog as $item ) {
                        $size = 12/$item["item_in_row"];
                        $items = $item["list_items"];
                        if(is_array($items)):
                            foreach ( $items as $el ) {
                                $image=$el["item_image"];
                                $variation_path=$el["variation_path"];
                                $link=$el["path_item_".$variation_path]->name?get_term_link( (int)$el["path_item_".$variation_path]->term_id ):$el["path_item_".$variation_path]['url'];
                                if($el["on_title"] && $el["item_title"]){
                                    $title=$el["item_title"];
                                } else {
                                    $title=$el["path_item_".$variation_path]->name?$el["path_item_".$variation_path]->name:$el["path_item_".$variation_path]['title'];
                                }
                                ?>
                                <div class="col-xs-12 col-sm-<?=$size?>">
                                    <div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="100">
                                        <a href="<?=$link?>">
                                            <div class="services-item--title">
                                                <h3>
                                                    <?=$title?><i class="fa fa-angle-right" aria-hidden="true"></i>
                                                </h3>
                                            </div>
                                            <!--
                                            <div class="overlay"></div>
                                            -->
                                            <div class="services-item--img" style="background-image: url(<?=$image?>);" title="<?=$title?>"></div>
                                        </a>
                                        <?php
                                        ?>
                                    </div>
                                </div>
                            <?php }
                        endif; ?>
                        <div class="clear col-xs-12"></div>
                    <?php }  ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
    <!-- /.rs-services -->
    <?php
}

// Список услуг для бокового меню
function storefront_rs_services_list( $current_id = 0 ) {
	$args = array(
			'post_type' => 'services', // тип товара
			'orderby' => 'title', // сортировка
			'order'       => 'ASC',
		);
	$loop = new WP_Query( $args );
	if ($loop->have_posts()) :
		$service_posts = $loop->posts;
	?>
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
		<div class="sidebar panel panel-default">
			<div class="panel-heading">Разделы</div>
			<div class="panel-body">
				<div class="list-group">
					<div class="menu-uslugi-container">
						<ul id="menu-uslugi" class="menu">
						<?php foreach($service_posts as $value) : ?>
							<li class="<?php echo ($value->ID == $current_id) ? 'current-menu-item' : ''?>">
								<a href="<?=get_post_permalink($value->ID); ?>"><?=$value->post_title; ?>
								</a>
							</li>	
						<?php endforeach; ?>
						</ul>
					</div>							
				</div>
			</div>
		</div>
	</div>
	<?php
	endif;
}