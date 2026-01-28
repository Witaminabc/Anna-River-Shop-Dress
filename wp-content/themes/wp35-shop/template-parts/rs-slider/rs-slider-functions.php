<?php
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
function storefront_slider_child() {
// Подключить стили для блока Слайдер
    add_action( 'wp_print_scripts', 'style_rs_slider_theme', 12);
    ?>
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
										$text_style = "col-xs-12 col-sm-8 col-sm-offset-4 col-md-7 col-md-offset-5 col-lg-5 col-lg-offset-7 slider-inner $text_inversion";
									} else {
										$text_style = "col-xs-12 slider-inner $text_inversion text-center";
									}
								?>
								<div class="<?=$text_style ?>">
									<div class="slider-inner-text">
                                        <?php
                                        if(get_the_title() || get_the_content()) :?>
                                            <div class="topAnima animated">
                                                <?php if(get_the_title()) :?>
                                                    <h2><?php the_title() ?></h2>
                                                <?php endif; ?>
                                                <?php if( get_the_content()) :?>
                                                    <?php the_content() ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                            $slider_buttons_one = get_field('slider_buttons_one');
                                            $slider_buttons_two = get_field('slider_buttons_two');
                                        ?>
                                        <?php if($slider_buttons_one['slider_buttons_name'] || $slider_buttons_two['slider_buttons_name']) :?>
										    <div class="group-buttons bottomAnima animated">
											<?php
												if ($slider_buttons_one['slider_buttons_name']) {
													$btn_one_name = $slider_buttons_one['slider_buttons_name'];
													$btn_one_link = $slider_buttons_one['slider_buttons_link'];
													$btn_one_style = ($slider_buttons_one['slider_buttons_design'] == "Цветная") ?
														"btn-color" : "btn-outline";
													$slider_button_one_os = $slider_buttons_one['slider_button_one_os'];

													?>
														<a <?php if($slider_button_one_os == true) echo 'data-toggle="modal" data-target="#order-call2"' ?> href="<?=$btn_one_link?>" 
															class="btn <?=$btn_one_style?>">
															<?=$btn_one_name?></a>
													<?php
												}
												if ($slider_buttons_two['slider_buttons_name']) {
													$btn_two_name = $slider_buttons_two['slider_buttons_name'];
													$btn_two_link = $slider_buttons_two['slider_buttons_link'];
													$btn_two_style = ($slider_buttons_two['slider_buttons_design'] == "Цветная") ?
														"btn-color" : "btn-outline";
											        $slider_button_two_os = $slider_buttons_two['slider_button_two_os'];
													?>
														<a <?php if($slider_button_two_os == true) echo 'data-toggle="modal" data-target="#order-call2"' ?> href="<?=$btn_two_link?>" 
															class="btn <?=$btn_two_style?>">
															<?=$btn_two_name?></a>
													<?php
												}
											?>
										
										</div>
                                        <?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="slider-item-img">
                            <?
                            $slider_image = get_field('image');
                            $url = $slider_image['url'];
                            $full_id = attachment_url_to_postid( $url );
                            $full_url = wp_get_attachment_image_url($full_id, 'full');
                            $full_srcset = wp_get_attachment_image_srcset( $full_id, 'full' );
                            $full_size =  wp_get_attachment_image_sizes( $full_id, 'full' );

                            $slider_image_mobile = get_field('image_mobile');
                            if($slider_image_mobile){
                               $src= $slider_image_mobile['url'];
                               $attachment_id = attachment_url_to_postid( $src );
                                $srcm = wp_get_attachment_image_url( $attachment_id, array(480, 320) );
                                $src = wp_get_attachment_image_url( $attachment_id, array(768, 400) );
                                $srcset = wp_get_attachment_image_srcset( $attachment_id, 'full' );
                                $size =  wp_get_attachment_image_sizes( $attachment_id, 'full' );
                            }?>

                            <picture>
                                <?if($slider_image_mobile){?>
                                    <source media="(min-width: 768px)" data-srcset="<?=wp_get_attachment_image_url( $full_id, 'full' );?>" srcset="<?=wp_get_attachment_image_url( $full_id, 'full' );?>">
                                    <img class="img-responsive b-lazy " data-src="<?=$src?>" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png" alt="<?= $slider_image['alt']?>" >
                            <?} else {?>
                                    <img data-src="<?=$full_url?>" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png" class="img-responsive parallaximg slider-img b-lazy <?=$full_id?> <?=$attachment_id?>"  data-srcset="<?=$full_srcset?>"  sizes="<?=$full_size?>"    alt="<?= $slider_image['alt']?>">
                            <? } ?>
                            </picture>
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