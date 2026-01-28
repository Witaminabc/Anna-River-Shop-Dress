<?php

add_action( 'wp_enqueue_scripts', 'style_rs_recommendations_theme', 11);
function style_rs_recommendations_theme() {
	wp_enqueue_style( 'rs-recommendations', get_stylesheet_directory_uri().'/template-parts/rs-recommendations/css/rs-recommendations.css');
}

function storefront_rs_recommendations() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 30, // id блока
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
		$company_name = get_field('company_name') ?: '';
		$description = get_field('description') ?: '';
		$review = get_field('review') ?: '';
	}
	//var_dump($review[0]['img']);
	?>
	<section class="rs-17">
		<div class="rs-recommendations" id="block-recommendations">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php if($company_name) : ?>
							<span class="text-center subsection-title" data-nekoanim="fadeInUp" data-nekodelay="100"><?=$company_name; ?></span>
						<?php endif; ?>
						<?php if($title) : ?>
							<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="200"><?=$title; ?></h2>
						<?php endif; ?>	
						<?php if($description) : ?>
							<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="300">
							<?=$description; ?>
							</div>
						<?php endif; ?>												
					</div>
				</div>
				<?php if (is_array($review)) : ?>
					<div class="row">
						<div id="recommendations-slider" class="owl-carousel">				
						<?php foreach($review as $elem) : ?>
							<div class="recommendation">
						    <a title="<?=$elem['img']['title']; ?>"
                               class="b-lazy"
						    	href="<?=$elem['img']['url']; ?>" 
						    	data-fancybox="gallery" 
						    	data-caption=""
                               data-src="<?=$elem['img']['url']; ?>"
						    	style="background-size: cover;"></a>
							</div>
						<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>	
			</div>			
		</div>
	</section>
	<?php 
	wp_reset_query();
}