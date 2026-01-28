<?php
function add_post_type($name, $label, $args = array()) {
	add_action('init', function() use($name, $label, $args) {
		$upper = ucwords($name);
		$name = strtolower(str_replace(' ', '_', $name));

		$args = array_merge(
			array(
				'public' => true,
				'label' => "$label",
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'capability_type' => 'post',
                'has_archive' => true,
				'labels' => array('add_new_item' => 'Add New'),
				'supports' => array('comments', 'title', 'editor', 'excerpt', 'thumbnail' ),
				'taxonomies' => array('post_tag', 'category'),
			),
			$args
		);
		register_post_type($name, $args);
	});
}

function add_taxonomy($name, $label, $post_type, $args=array()) {
	$name = strtolower($name);
	add_action('init', function() use($name, $label, $post_type, $args) {
		register_taxonomy($name, $post_type, array ('hierarchical' => true,
													'label' => __($label),
													'singular_label' => $name,
													'query_var' => $name));
	}, 0);
}

// Регистрация типа записей Блок
add_post_type('custom_block', 'Блок', array(
	'supports'   => array( 'title', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-welcome-widgets-menus',
    'exclude_from_search' => true,
));

//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
add_filter('post_type_labels_custom_block', 'rename_posts_labels_custom_block');
function rename_posts_labels_custom_block( $labels ){

	$new = array(
		'name'                  => 'Блоки',
		'singular_name'         => 'Блок',
		'add_new'               => 'Добавить блок',
		'add_new_item'          => 'Добавить блок',
		'edit_item'             => 'Редактировать блок',
		'new_item'              => 'Новый блок',
		'view_item'             => 'Просмотреть блок',
		'search_items'          => 'Поиск блоков',
		'not_found'             => 'Блоков не найдено.',
		'not_found_in_trash'    => 'Блоков в корзине не найдено.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все блоки',
		'archives'              => 'Архивы блоков',
		'insert_into_item'      => 'Вставить в блок',
		'uploaded_to_this_item' => 'Загруженные для этого блока',
		'featured_image'        => 'Миниатюра блока',
		'filter_items_list'     => 'Фильтровать список блоков',
		'items_list_navigation' => 'Навигация по списку блоков',
		'items_list'            => 'Список блоков',
		'menu_name'             => 'Блоки',
		'name_admin_bar'        => 'Блоки', 
	);

	return (object) array_merge( (array) $labels, $new );
}