<?php
function style_rs_howworks_theme() {
    wp_enqueue_style( 'rs-howworks', get_stylesheet_directory_uri().'/template-parts/rs-howworks/css/rs-howworks.css');
}
// Вывод блока Как мы работаем 
function storefront_rs_howworks() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 8, // id блока
				'compare' => '=' 
			)
		)
	));	
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		$title = get_field('title') ?: '';
		$description = get_field('description') ?: '';
// Подключить стили для блока Как мы работаем
        add_action( 'wp_print_scripts', 'style_rs_howworks_theme', 12);
    }
	?>
	<section class="rs-17">
		<div class="rs-howworks" id="block-how-works">
			<div class="container">
				<?php if ($title) : ?>
					<div class="row">
						<div class="col-xs-12">
							<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100">
								<span class="section-title--text"><?=$title; ?></span>
							</h2>
							<?php if ($description) : ?>
								<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
									<p><?=$description; ?></p> 
								</div>
							<?php endif; ?>								
						</div>
					</div>					
				<?php endif; ?>
				<div class="row">
				<?php if($post_meta) :?>
					<?php 
						$item = 0;
						while (!empty(get_field("howworks_{$item}_img"))) {
							$feature_image_main = get_field("howworks_".$item."_img_main")['url'];
							$feature_image = get_field("howworks_".$item."_img")['url'];
							$feature_name = get_field("howworks_".$item."_name");
							$feature_description = get_field("howworks_".$item."_text");
							$item++; ?>
								<div class="col-xs-12 col-sm-4 works-item" data-nekoanim="fadeInUp" data-nekodelay="200">
									<div class="works-block <?php if ($item == 3) echo 'line-connector-vertical'; ?>">
										<div class="works-wrap line-connector-right">
											<div class="works-icon">
												<img src="<?=$feature_image_main; ?>" alt="works-picture">
											</div>
											<div class="works-icon-hover">
												<img class="b-lazy" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png"  data-src="<?=$feature_image; ?>" alt="works-picture">
											</div>
										</div>
										<h4><?=$feature_name; ?></h4>
										<p><?=$feature_description; ?></p>
									</div>
								</div>
							<?php
						}
					?>
				<?php endif; 
					wp_reset_query();
				?>
				</div>	
			</div>
		</div>
	</section>
	<?php
}