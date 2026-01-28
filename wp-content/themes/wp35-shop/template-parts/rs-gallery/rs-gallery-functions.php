<?php
require_once( get_theme_file_path( 'inc/BFI_Thumb.php' ) );
function style_rs_gallery_theme() {
    wp_enqueue_style( 'rs-gallery', get_stylesheet_directory_uri().'/template-parts/rs-gallery/css/rs-gallery.css');
}
// Подключить стили для блока
add_action( 'template_redirect', 'rs_template_gallery_include' );
function rs_template_gallery_include(){
    global $post;
    if(is_post_type_archive('gallery') || isset($post->post_type) && $post->post_type == 'gallery'){
        add_action( 'wp_print_scripts', 'style_rs_gallery_theme', 11);
    }
}

// Регистрация типа записей
add_post_type('gallery', 'Гелерея', array(
	'supports'   => array( 'title', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-format-gallery'
));

//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
add_filter('post_type_labels_gallery', 'rename_posts_labels_gallery');
function rename_posts_labels_gallery ( $labels ){

	$new = array(
		'name'                  => 'Галерея',
		'singular_name'         => 'Альбом',
		'add_new'               => 'Добавить альбом',
		'add_new_item'          => 'Добавить альбом',
		'edit_item'             => 'Редактировать альбом',
		'new_item'              => 'Новый альбом',
		'view_item'             => 'Просмотреть альбомы',
		'search_items'          => 'Поиск альбомов',
		'not_found'             => 'Альбомов не найдено.',
		'not_found_in_trash'    => 'Альбомов в корзине не найдено.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все альбомы',
		'archives'              => 'Архивы альбомов',
		'insert_into_item'      => 'Вставить в альбом',
		'uploaded_to_this_item' => 'Загруженные для этого альбома ',
		'featured_image'        => 'Миниатюра альбома',
		'filter_items_list'     => 'Фильтровать список альбомов',
		'items_list_navigation' => 'Навигация по списку альбомов',
		'items_list'            => 'Список альбомов',
		'menu_name'             => 'Галерея',
		'name_admin_bar'        => 'Альбом', // пункте "добавить"
	);

	return (object) array_merge( (array) $labels, $new );
}

add_filter('template_include', 'my_template_gallery');
function my_template_gallery( $template ) {
	# шаблон для архива произвольного типа "gallery"
	global $posts;
	if( is_post_type_archive('gallery') ){
		return get_stylesheet_directory() . '/template-parts/rs-gallery/gallery-arhive-tpl.php';
	}

	# шаблон для страниц произвольного типа "gallery"
	global $post;
	if(isset($post->post_type) && $post->post_type == 'gallery' ){
		return get_stylesheet_directory() . '/template-parts/rs-gallery/gallery-tpl.php';
	}
	return $template;
}