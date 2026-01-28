<?php
function style_rs_features_theme() {
    wp_enqueue_style( 'rs-features-theme', get_stylesheet_directory_uri().'/template-parts/rs-features/css/rs-features.css');
}
// Вывод блока Преимущества 4 колонки на главной странице
function storefront_rs_show_custom_block() {
    // Подключить стили для блока Преимущества
    add_action( 'wp_print_scripts', 'style_rs_features_theme', 18);
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 1, // id блока
				'compare' => '=' 
			)
		)
	));	
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		if (get_field('title')) $title = get_field('title');

	}
	?>
	<section class="rs-17">
		<div class="rs-features index-page">
			<div class="container">
				<?php if (true) : ?>
					<div class="row">
						<div class="col-xs-12">
							<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100">
								<span class="section-title--text"><?=$title; ?></span>
							</h2>
						</div>
					</div>					
				<?php endif; ?>
				<div class="row">
				<?php
					if ($post_meta) {
						for ($i = 1; $i < 9; $i++) {
							$feature_image = get_field("features_".$i."_img_1");
							$feature_name = get_field("features_".$i."_name_1");
							$feature_description = get_field("features_".$i."_desc_1");
							if ($feature_image || $feature_name || $feature_description) :
							?>  
								<div class="col-xs-12 col-sm-6 col-md-3 feature-block">
									<div class="feature-item" data-nekoanim="fadeInDown" data-nekodelay="400">
										<div class="feature-item--icon">
											<img class="" src="<?=$feature_image; ?>" alt="feature_picture">
										</div>
                                        <?php if($feature_name) {?>
										<h4><?=$feature_name; ?></h4>
                                        <?php } ?>
                                        <?php if($feature_description){ ?>
										<p><?=$feature_description; ?></p>
                                        <?php } ?>
									</div>
								</div>							
							<?php 
							endif;
						}
					}
					//Сброс данных запроса
					wp_reset_query();					
				?>
				</div>	
			</div>
		</div>
	</section>
	<?php
}