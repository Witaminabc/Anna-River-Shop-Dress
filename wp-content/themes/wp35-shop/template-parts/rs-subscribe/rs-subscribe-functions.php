<?php
function style_rs_subscribe_theme() {
    wp_enqueue_style( 'rs-subscribe', get_stylesheet_directory_uri().'/template-parts/rs-subscribe/css/rs-subscribe.css');
}
function storefront_rs_subscribe() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 18, // id блока
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
        add_action( 'wp_print_scripts', 'style_rs_subscribe_theme', 11);
	}
?>
<section class="rs-17">
	<div class="rs-subscribe" id="block-subscribe">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><?=$title; ?></h2>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<p><?=$description; ?></p>
					</div>
					<!--noindex-->
					<form action="#" method="post" id="subscribeForm" class="form-inline form-subscribe" data-nekoanim="fadeInUp" data-nekodelay="800">
						<div class="form-group">
							<input type="hidden" name="phone">
							<div class="input-group">
								<input type="email" id="email_subscribe_author" class="form-control" name="email_subscribe_author" placeholder="Введите ваш E-mail">
							</div>
						</div>
						<button id="subscribeFormBtn" class="btn btn-color">Подписаться</button>
					</form>
					<p class="success text-center"></p>
					<!--/noindex-->
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	wp_reset_query();	
}