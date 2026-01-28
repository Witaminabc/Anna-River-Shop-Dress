<?php
function style_rs_offers_theme() {
wp_enqueue_style( 'rs-offers', get_stylesheet_directory_uri().'/template-parts/rs-offers/css/rs-offers.css');
    }
function storefront_rs_offers() {
    add_action( 'wp_print_scripts', 'style_rs_offers_theme', 12);
    $query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 10, // id блока
				'compare' => '=' 
			)
		)
	));	
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	?>
	<section class="rs-17">
		<div class="rs-offers">
			<ul class="offers-list">
			<?php 
				$item = 0;
				while (!empty(get_field("offers_{$item}_img"))) :
					if ($item % 2) {
						$img_position = 'fadeInRight';
						$txt_position = 'fadeInLeft';
						$img_push = 'col-md-push-6';
						$text_pull = 'col-md-pull-6';
					} else {
						$img_position = 'fadeInLeft';
						$txt_position = 'fadeInRight';
						$img_push = '';
						$text_pull = '';
					}
					$text = get_field("offers_{$item}_text");
					$img = get_field("offers_{$item}_img")['url'];
					$item++; 
					?>
					<li class="block-about">
						<div class="container">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 <?=$img_push; ?>" data-nekoanim="<?=$img_position; ?>" data-nekodelay="200">
									<img src="<?=$img; ?>" class="img-responsive" alt="предложение">
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 <?=$text_pull; ?>" data-nekoanim="<?=$txt_position; ?>" data-nekodelay="400">
									<?=$text; ?>
								</div>
							</div>
						</div>
					</li>					
			<?php endwhile; ?>
			</ul>
		</div>
	</section>
	<?php
	wp_reset_query();
}				