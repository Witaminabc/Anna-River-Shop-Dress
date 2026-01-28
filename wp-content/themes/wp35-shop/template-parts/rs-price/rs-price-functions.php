<?php
function style_rs_price_theme() {
    wp_enqueue_style( 'rs-price', get_stylesheet_directory_uri().'/template-parts/rs-price/css/rs-price.css');
}
// Регистрация типа записей
add_post_type('price', 'Тариф', array(
	'supports'   => array( 'title', 'editor', 'thumbnail' ),
	'taxonomies' => array( 'post_tag' ),
	'menu_icon' => 'dashicons-admin-page'
));
//$labels = apply_filters( "post_type_labels_{$post_type}", $labels );
add_filter('post_type_labels_price', 'rename_posts_labels_price');
function rename_posts_labels_price ( $labels ){
	$new = array(
		'name'                  => 'Тарифный план',
		'singular_name'         => 'Тарифный план',
		'add_new'               => 'Добавить тарифный план',
		'add_new_item'          => 'Добавить тарифный план',
		'edit_item'             => 'Редактировать тарифный план',
		'new_item'              => 'Новый тарифный план',
		'view_item'             => 'Просмотреть тарифные планы',
		'search_items'          => 'Поиск тарифных планов',
		'not_found'             => 'Тарифных планов не найдено.',
		'not_found_in_trash'    => 'Тарифных планов в корзине не найдено.',
		'parent_item_colon'     => '',
		'all_items'             => 'Все тарифные планы',
		'archives'              => 'Архивы тарифов',
		'insert_into_item'      => 'Вставить в тариф',
		'uploaded_to_this_item' => 'Загруженные для этого тарифа ',
		'featured_image'        => 'Миниатюра тарифа',
		'filter_items_list'     => 'Фильтровать список тарифов',
		'items_list_navigation' => 'Навигация по списку тарифов',
		'items_list'            => 'Список тарифных планов',
		'menu_name'             => 'Тарифные планы',
		'name_admin_bar'        => 'Тарифный план', // пункте "добавить"
	);
	return (object) array_merge( (array) $labels, $new );
}
function storefront_price_child() {
	global $post;
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 16, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		$title = get_field("title") ?: '';
		$description = get_field("description") ?: '';	
		$notification_header = get_field("notification_header") ?: '';
		$notification_text = get_field("notification_text") ?: '';	
		$is_contact_form_7 = get_field("is_contact_form_7") ?: '';
		$contact_form_7 = get_field("contact_form_7") ?: '';


// Подключить стили для блока
        add_action( 'wp_print_scripts', 'style_rs_price_theme', 12);

	}

?>
<section class="rs-17">
	<div class="rs-price" id="block-price">
		<div id="hidden-cf7">
			<?php //if($is_contact_form_7) echo get_field("contact_form_7") ?>
		</div>		
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><?=$title; ?></h2>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<p><?=$description; ?></p>
					</div>
				</div>
			</div>
			<div class="row price-row">
				<?php query_posts('post_type=price&posts_per_page=10'); ?>
				<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>

				<div class="col-xs-12 col-sm-6 col-md-3 price-wrap" data-nekoanim="fadeInUp" data-nekodelay="500">
					<div class="price-inner <?= get_field('active') ? 'special-block' : 'fill-color' ?>">
						<h2 class="price-title"><?php the_title() ?></h2>
						<div class="price-text"><?php the_content() ?></div>
						<?if (get_field('price')){?>
							<div class="price-cost-round">
								<span class="price-cost"><?php the_field('price') ?></span>
							</div>
						<?}?>
						<div class="price-descr">
							<?php $preference = get_field('preference') ?>
							<ul class="price-descr-list">
								<?php if(is_array($preference)) {
									foreach ( $preference as $item ) { ?>
										<li><?= $item['name'] ?></li>
									<? }
								} ?>
							</ul>
						</div>
						<div class="price-more">
							<a href="" class="btn btn-outline rs-price-cf7" data-target="#order-call3" data-toggle="modal">Подробнее</a>
						</div>
					</div>
				</div>

				<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<div class="rs-17">
	<div class="rs-modal">
		<div class="modal rs-cf7-modal fade" tabindex="-1" id="order-call3">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" id="rs-cf7-close" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Свяжитесь с нами</h3>
				<p class="text-center">Свяжитесь с нашей службой поддержки клиентов, если у Вас есть какие-либо вопросы.</p>
			  </div>
			  <div class="modal-body">
			  	<?php if (!$is_contact_form_7) : ?>
				<form method="post" action="#" class="form-order" id="FormMainBanner3">
					<input type="hidden" name="modeJs" value="contactFormMainBanner3" >
					<input type="hidden" name="phone">
					<div class="input_spec">
						<input type="hidden" name="valueJs">
					</div>
					<input type="text" placeholder="Ваше имя" id="name_author3" name="name_author3">
					<input type="tel" placeholder="88002229072" id="phone_author3" name="phone_author3">
					<textarea placeholder="Ваше сообщение" id="message_author3" name="message_author3"></textarea>
					<div class="checkbox">
						<label>
						  Нажимая на кнопку «Отправить сообщение», вы соглашаетесь на обработку персональных данных в соответствии с <a href="#" class="checkbox-label" data-target="#rs-agreement-price" data-toggle="modal">пользовательским соглашением</a>
						</label>
					  </div>
					<button id="contactFormMainBanner3" type="submit" class="btn btn-default modal-btn btn-form">Отправить сообщение</button>
					<p class="success text-center"></p>
				</form>
				<?php else : ?>
					<?=$contact_form_7 ?>
				<?php endif ?>				
			  </div>
			</div>
		  </div>
		</div>
	</div>
</div>
<div class="rs-17">
	<div class="rs-modal">
		<div class="modal fade" tabindex="-1" id="rs-agreement-price">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="modal-title"><?=$notification_header; ?></div>
					</div>
					<div class="modal-body">
						<?=$notification_text; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
	wp_reset_query();
}	