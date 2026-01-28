<?php
function style_rs_news_theme() {
    wp_enqueue_style( 'rs-news', get_stylesheet_directory_uri().'/template-parts/rs-news/css/rs-news.css');
}
add_action( 'template_redirect', 'rs_template_news_include' );
function rs_template_news_include(){
    global $post;
    if(is_post_type_archive('news') || isset($post->post_type) && $post->post_type == 'news'){
        add_action( 'wp_print_scripts', 'style_rs_news_theme', 12);
    }
}



// Регистрация типа записей
add_post_type('news', 'Новость', array(
	'supports'   => array( 'title', 'editor', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-admin-page'
));
//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
add_filter('post_type_labels_news', 'rename_posts_labels_news');
function rename_posts_labels_news ( $labels ){

	$new = array(
		'name'                  => 'Новость',
		'singular_name'         => 'Новость',
		'add_new'               => 'Добавить новость',
		'add_new_item'          => 'Добавить новость',
		'edit_item'             => 'Редактировать новость',
		'new_item'              => 'Новая новость',
		'view_item'             => 'Просмотреть новость',
		'search_items'          => 'Поиск новостей',
		'not_found'             => 'Новостей не найдено.',
		'not_found_in_trash'    => 'Новостей в корзине не найдено.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все новости',
		'archives'              => 'Архивы новостей',
		'insert_into_item'      => 'Вставить в новость',
		'uploaded_to_this_item' => 'Загруженные для этой новости ',
		'featured_image'        => 'Миниатюра новости',
		'filter_items_list'     => 'Фильтровать список новостей',
		'items_list_navigation' => 'Навигация по списку новостей',
		'items_list'            => 'Список новостей',
		'menu_name'             => 'Новости',
		'name_admin_bar'        => 'Новость', // пункте "добавить"
	);

	return (object) array_merge( (array) $labels, $new );
}

add_filter('template_include', 'my_template_news');
function my_template_news( $template ) {
	# шаблон для архива произвольного типа "news"
	global $posts;
	if( is_post_type_archive('news') ){
		return get_stylesheet_directory() . '/template-parts/rs-news/news-arhive-tpl.php';
	}
	# шаблон для страниц произвольного типа "news"
	global $post;
	if(isset($post->post_type) && $post->post_type == 'news' ){
		return get_stylesheet_directory() . '/template-parts/rs-news/news-tpl.php';
	}
	return $template;
}




// Функция вывода блока
function storefront_news_child() {
    add_action( 'wp_print_scripts', 'style_rs_news_theme', 12);
	global $post;
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array (
			'relation' => 'OR',
			array (
				'key'     => 'block_id',
				'value'   => 5, // id блока
				'compare' => '='
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) :
		$title = get_field("title");
		$description = get_field("description");
	?>
<!-- rs-news -->
<section class="rs-17">
	<div class="rs-news">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100">
						<span class="section-title--text"><?=$title; ?></span>
					</h2>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<p><?=$description; ?></p>
					</div>
				</div>
			</div>
			<div class="row">
				<?
				wp_reset_query();
				$args = array(
					'post_type'	=> 'news',
					'posts_per_page' => 4,
					'order'		=> 'DESC',
					'orderby' => 'date'
				);
				$posts = query_posts( $args );

				if ( $posts ) {
					 foreach( $posts as $post ) {
						setup_postdata( $post );
						get_template_part('template-parts/rs-news/content', $post->post_type);
					}
					wp_reset_postdata();
				} ?>

			</div>
		</div>
	</div>
</section>
<!-- /.rs-news -->
<?php
	unset($args);
	unset($posts);
	endif;
	wp_reset_query();
}
