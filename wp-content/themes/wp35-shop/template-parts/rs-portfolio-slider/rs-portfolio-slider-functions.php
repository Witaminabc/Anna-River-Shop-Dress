<?php
// Подключить стили для блока
add_action( 'template_redirect', 'rs_template_portfolio_include' );
function rs_template_portfolio_include(){
    global $post;
    if(is_post_type_archive('examples') || isset($post->post_type) && $post->post_type == 'examples'){
        add_action( 'wp_print_scripts', 'style_rs_portfolio_slider_theme', 11);
    }
}

function style_rs_portfolio_slider_theme() {
    wp_enqueue_style( 'rs-portfolio-slider', get_stylesheet_directory_uri().'/template-parts/rs-portfolio-slider/css/rs-portfolio-slider.css');
}

// Регистрация типа записей
add_post_type('examples', 'Наши проекты', array(
	'supports'   => array( 'title', 'editor', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-admin-page'
));

add_filter('post_type_labels_examples', 'rename_posts_labels_examples');
function rename_posts_labels_examples ( $labels ){

	$new = array(
		'name'                  => 'Проекты',
		'singular_name'         => 'Проект',
		'add_new'               => 'Добавить проект',
		'add_new_item'          => 'Добавить проект',
		'edit_item'             => 'Редактировать проект',
		'new_item'              => 'Новый проект',
		'view_item'             => 'Просмотреть проект',
		'search_items'          => 'Поиск проектов',
		'not_found'             => 'Проектов не найдено.',
		'not_found_in_trash'    => 'Проектов в корзине не найдено.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все проекты',
		'archives'              => 'Архивы проектов',
		'insert_into_item'      => 'Вставить в проект',
		'uploaded_to_this_item' => 'Загруженные для этого проекта ',
		'featured_image'        => 'Миниатюра проекта',
		'filter_items_list'     => 'Фильтровать список проектов',
		'items_list_navigation' => 'Навигация по списку проектов',
		'items_list'            => 'Список проектов',
		'menu_name'             => 'Наши проекты',
		'name_admin_bar'        => 'Наши проекты', // пункте "добавить"
	);

	return (object) array_merge( (array) $labels, $new );
}

add_filter('template_include', 'my_template_examples');
function my_template_examples( $template ) {

	# шаблон для архива произвольного типа "examples"
	global $posts;
	if( is_post_type_archive('examples') ){
		return get_stylesheet_directory() . '/template-parts/rs-portfolio-slider/examples-arhive-tpl.php';
	}

	# шаблон для страниц произвольного типа "examples"
	global $post;
	if(isset($post->post_type) && $post->post_type == 'examples' ){
		return get_stylesheet_directory() . '/template-parts/rs-portfolio-slider/examples-tpl.php';
	}

	return $template;

}

// Функция вывода блока 
function storefront_examples_child() {
    add_action( 'wp_print_scripts', 'style_rs_portfolio_slider_theme', 11);
	global $post;
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 27, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		$examples_name = get_field("examples_name") ?: '';
		$examples_text = get_field("examples_text") ?: '';		
	}

?>

<section class="rs-17">
	<div class="rs-portfolio-slider">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<?php if ($examples_name) : ?>
						<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><?=$examples_name; ?></h2>
					<?php endif; ?>
					<?php if ($examples_text) : ?>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<p><?=$examples_text; ?></p>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div id="examples-slider" class="owl-carousel">
						
						<?php query_posts('post_type=examples&posts_per_page=-1'); ?>
						<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>
						<? $img_example = get_field('image'); ?>
						<div class="example">
							<a href="<?php the_permalink() ?>"><img class="img-responsive b-lazy" data-src="<?=$img_example['url']?>" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png" alt="<?=$img_example['alt']; ?>"></a>
							<div class="example-info">
								<a href="<?php the_permalink() ?>"><h3><?php the_title() ?></h3></a>
								<p><?php echo get_field('text_anons'); ?></p>
							</div>
							<a href="<?php the_permalink() ?>" class="btn-color">Подробнее</a>
						</div>
							<?php endwhile; ?>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- /.rs-news -->
<?php
	wp_reset_query();
}
 //var_dump(doing_action('template_on_examples'));