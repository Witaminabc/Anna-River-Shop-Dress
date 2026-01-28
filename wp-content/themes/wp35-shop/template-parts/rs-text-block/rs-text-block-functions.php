<?php
// Подключение стилей
function style_rs_text_block_theme() {
    wp_enqueue_style( 'rs-text-block-theme', get_stylesheet_directory_uri().'/template-parts/rs-text-block/css/rs-text-block.css');
}
// Регистрация типа записей
/*add_post_type('text_block', 'Текстовый блок', array(
	'supports'   => array( 'title', 'editor', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-format-aside'
));*/
//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
//add_filter('post_type_labels_text_block', 'rename_posts_labels_text_block');
function rename_posts_labels_text_block( $labels ){
	$new = array(
		'name'                  => 'Текстовые блоки',
		'singular_name'         => 'Текстовый блок',
		'add_new'               => 'Добавить новый',
		'add_new_item'          => 'Добавить новый',
		/*'edit_item'             => 'Редактировать слайд',
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
		'name_admin_bar'        => 'Слайд', // пункте "добавить"*/
	);
	return (object) array_merge( (array) $labels, $new );
}
// Вывод текстового блока на главную
function storefront_homepage_content_child() {
    add_action( 'wp_print_scripts', 'style_rs_text_block_theme', 12);
	?>
	<section class="rs-17">
		<div class="rs-text-block">
			<div class="container">
				<div class="row">
					<div class="col-xs-12" data-nekoanim="fadeInUp" data-nekodelay="200"> <?php
						while ( have_posts() ) {
							the_post();
                            $title = get_the_title();
                            $content = get_the_content();
                            ?>
                            <?php if ($title || $content) : ?>
                                <?php if ($title) : ?>
                                    <h2><?=$title?></h2>
                                <?php endif; ?>
                                <?php if ($content) : ?>
                                    <?php $content ?>
                                <?php endif; ?>
                            <?php endif;
						}
					?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php	
}