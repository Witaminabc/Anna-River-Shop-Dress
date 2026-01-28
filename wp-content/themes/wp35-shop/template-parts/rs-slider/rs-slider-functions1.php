<?php

// Подключить стили для блока Слайдер
add_action( 'wp_enqueue_scripts', 'style_rs_slider_theme', 12);
function style_rs_slider_theme() {
	wp_enqueue_style( 'rs-slider', get_stylesheet_directory_uri().'/template-parts/rs-slider/css/rs-slider.css');
}

// Регистрация типа записей
add_post_type('slider', 'Слайдер', array(
	'supports'   => array( 'title', 'editor', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-format-gallery'
));

//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
add_filter('post_type_labels_slider', 'rename_posts_labels');
function rename_posts_labels( $labels ){

	$new = array(
		'name'                  => 'Слайды',
		'singular_name'         => 'Слайд',
		'add_new'               => 'Добавить слайд',
		'add_new_item'          => 'Добавить слайд',
		'edit_item'             => 'Редактировать слайд',
		'new_item'              => 'Новый слайд',
		'view_item'             => 'Просмотреть слайд',
		'search_items'          => 'Поиск слайдов',
		'not_found'             => 'Слайдов не найдено.',
		'not_found_in_trash'    => 'Слайдов в корзине не найдено.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все слайды',
		'archives'              => 'Архивы слайдов',
		'insert_into_item'      => 'Вставить в слайд',
		'uploaded_to_this_item' => 'Загруженные для этого слайда',
		'featured_image'        => 'Миниатюра слайда',
		'filter_items_list'     => 'Фильтровать список слайдов',
		'items_list_navigation' => 'Навигация по списку слайдов',
		'items_list'            => 'Список слайдов',
		'menu_name'             => 'Слайдер',
		'name_admin_bar'        => 'Слайд', // пункте "добавить"
	);

	return (object) array_merge( (array) $labels, $new );
}

// Функция вывода блока Слайдер
function storefront_slider_child() { ?>

<!-- rs-slider -->

<div class="rs-17">
	<div class="rs-slider">
		<div class="rs-slider-container">

			<?php query_posts('post_type=slider&posts_per_page=10'); ?>
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
				
					<div class="slider-item">
						<div class="slider-info">
							<div class="container">
								<?php
									
									$text_inversion = (get_field('inversion')) ? 'slider-inner-v2' : 'slider-inner-v1';

									if (get_field('slider_text') == 'Left') {
										$text_style = "col-xs-12 col-sm-8 col-md-7 col-lg-7 slider-inner $text_inversion";
									} else if (get_field('slider_text') == 'Right') {
										$text_style = "col-xs-12 col-sm-8 col-sm-offset-4 col-md-7 col-md-offset-5 col-lg-7 col-lg-offset-5 slider-inner $text_inversion";
									} else {
										$text_style = "col-xs-12 slider-inner $text_inversion text-center";
									}
								?>
								<div class="<?=$text_style ?>">
									<div class="slider-inner-text">
										<div class="topAnima animated">
											<h2><?php the_title() ?></h2>
											<?php the_content() ?>
										</div>
										<div class="group-buttons bottomAnima animated">
											<?php 
												$slider_buttons_one = get_field('slider_buttons_one');
												if ($slider_buttons_one['slider_buttons_name']) {
													$btn_one_name = $slider_buttons_one['slider_buttons_name'];
													$btn_one_link = $slider_buttons_one['slider_buttons_link'];
													$btn_one_style = ($slider_buttons_one['slider_buttons_design'] == "Цветная") ?
														"btn-color" : "btn-outline"; 

													?>
														<a href="<?=$btn_one_link?>" 
															class="btn <?=$btn_one_style?>">
															<?=$btn_one_name?></a>
													<?php
												}

												$slider_buttons_two = get_field('slider_buttons_two');
												if ($slider_buttons_two['slider_buttons_name']) {
													$btn_two_name = $slider_buttons_two['slider_buttons_name'];
													$btn_two_link = $slider_buttons_two['slider_buttons_link'];
													$btn_two_style = ($slider_buttons_two['slider_buttons_design'] == "Цветная") ?
														"btn-color" : "btn-outline"; 

													?>
														<a href="<?=$btn_two_link?>" 
															class="btn <?=$btn_two_style?>">
															<?=$btn_two_name?></a>
													<?php
												}												

											?>
											<!--<a href="<?php //get_field('link') ?>" class="btn btn-color" data-target="#order-call2"
											   data-toggle="modal">Посмотреть</a>-->
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="slider-item-img">
							<? $slider_image = get_field('image');
							$slider_image_mobile = get_field('image_mobile');							?>
							<img src="<?= $slider_image['url']?>" class="img-responsive parallaximg slider-img <?if($slider_image_mobile){?>hidden-xs<?}?>" alt="<?= $slider_image['alt']?>">
							<?if($slider_image_mobile){?>
								<img src="<?= $slider_image_mobile['url']?>" class="img-responsive parallaximg slider-img hidden-sm hidden-md hidden-lg" alt="<?= $slider_image_mobile['alt']?>">
							<?}?>
						</div>
					</div>

				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- /.rs-slider -->
<?php wp_reset_query();
}


