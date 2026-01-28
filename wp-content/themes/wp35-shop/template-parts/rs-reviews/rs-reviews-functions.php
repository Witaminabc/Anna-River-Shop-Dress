<?php
// Подключить стили для блока
add_action( 'template_redirect', 'rs_template_reviews_include' );
function rs_template_reviews_include(){
    global $post;
    if(is_post_type_archive('examples') || isset($post->post_type) && $post->post_type == 'examples'){
        add_action( 'wp_print_scripts', 'style_rs_reviews_theme', 12);
    }
}

function style_rs_reviews_theme() {
	wp_enqueue_style( 'rs-reviews', get_stylesheet_directory_uri().'/template-parts/rs-reviews/css/rs-reviews.css');
}

// Регистрация типа записей
add_post_type('review', 'Отзыв', array(
	'supports'   => array( 'title', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-admin-page'
));

//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
add_filter('post_type_labels_review', 'rename_posts_labels_review');
function rename_posts_labels_review( $labels ){

	$new = array(
		'name'                  => 'Отзывы',
		'singular_name'         => 'Отзыв',
		'add_new'               => 'Добавить отзыв',
		'add_new_item'          => 'Добавить отзыв',
		'edit_item'             => 'Редактировать отзыв',
		'new_item'              => 'Новый отзыв',
		'view_item'             => 'Просмотреть отзыв',
		'search_items'          => 'Поиск отзывов',
		'not_found'             => 'Отзывов не найдено.',
		'not_found_in_trash'    => 'Отзывов в корзине не найдено.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все отзывы',
		'archives'              => 'Архивы отзывов',
		'insert_into_item'      => 'Вставить в отзыв',
		'uploaded_to_this_item' => 'Загруженные для этого отзыва',
		'featured_image'        => 'Миниатюра отзывов',
		'filter_items_list'     => 'Фильтровать список отзывов',
		'items_list_navigation' => 'Навигация по списку отзывов',
		'items_list'            => 'Список отзывов',
		'menu_name'             => 'Отзывы',
		'name_admin_bar'        => 'Отзыв', // пункте "добавить"
	);

	return (object) array_merge( (array) $labels, $new );
}

add_filter('template_include', 'my_template_reviews');
function my_template_reviews( $template ) {

	# шаблон для архива произвольного типа "review"
	global $posts;
	if( is_post_type_archive('review') ){
		return get_stylesheet_directory() . '/template-parts/rs-reviews/reviews-arhive-tpl.php';
	}

	# шаблон для страниц произвольного типа "review"
	global $post;
	if(isset($post->post_type) && $post->post_type == 'review' ){
		return get_stylesheet_directory() . '/template-parts/rs-reviews/reviews-tpl.php';
	}

	return $template;

}

// Функция вывода блока 
function storefront_reviews_child() {
    add_action( 'wp_print_scripts', 'style_rs_reviews_theme', 12);
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 4, // id блока
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
		$block_img = get_field("img");
		$description = get_field("description"); 
	?>

<!-- rs-reviews -->
<section class="rs-17">
	<div class="rs-reviews b-lazy" data-src="<?=$block_img['url']; ;?>"  style="background-size: cover;">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100">
						<span class="section-title--text"><?=$title; ?></span>
					</h2>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<?=$description; ?>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="reviews-slider owl-carousel" data-nekoanim="fadeInUp" data-nekodelay="400">
						<?php query_posts('post_type=review&posts_per_page=10'); ?>
						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php 
									$img = get_field('img'); 
									$author = get_field('author'); 
									$msg = get_field('msg'); 
								?>

								<div class="reviews-item">
									<a href="<?php the_permalink() ?>" class="reviews-content">
										<div class="reviews-quote">
												<?=$msg; ?>
										</div>
										<div class="reviews-name"><?=$author; ?>
										</div>
									</a>
									<div class="reviews-img">
										<a href="<?php the_permalink() ?>">
											<img  src="<?=$img['url']; ?>" alt="review" class="img-responsive ">
										</a>
									</div>
								</div>
							<?php endwhile; ?>
						<?php endif; 
						?>
					</div>
					<div class="owl-navigation">
						<a class="reviews-prev"><i class="fa fa-angle-left"></i></a>
						<a class="reviews-next"><i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.rs-reviews -->

<?php endif; 
wp_reset_query();
}