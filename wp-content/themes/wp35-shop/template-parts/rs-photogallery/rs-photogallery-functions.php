<?php
function style_rs_photogallery_theme() {
    wp_enqueue_style( 'rs-photogallery', get_stylesheet_directory_uri().'/template-parts/rs-photogallery/css/rs-photogallery.css');
}
function storefront_rs_photogallery() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 19, // id блока
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
		$gallery_3 = get_field('image_gallery_3') ?: '';
		$gallery_4 = get_field('image_gallery_4') ?: '';
		$gallery_5 = get_field('image_gallery_5') ?: '';
        add_action( 'wp_print_scripts', 'style_rs_photogallery_theme', 11);
    }
	?>
	<section class="rs-17">
		<div class="rs-photogallery" id="block-gallery">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50"><?=$title; ?></h2>
						<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
							<p><?=$description; ?></p>
						</div>
					</div>
				</div>
				<div class="row gallery-row">
					<?php if ( is_array($gallery_3) ) {
						$i = 0;
						foreach ( $gallery_3 as $key => $item ) {?>
							
							<div class="col-xs-12 col-sm-4">
								<div class="gallery-item gallery-item--col3" data-nekoanim="fadeInLeft" data-nekodelay="<?= ++$i*100 ?>">
									<a title="<?php echo $item[ 'title' ]; ?>" href="<?php echo $item[ 'url' ]; ?>" data-fancybox="gallery" data-caption="<?php echo $item[ 'description' ]; ?>" class="b-lazy" data-src="<?php echo $item[ 'url' ];?>" style="background-size: cover;">
									</a>
								</div>
							</div>
						<?  }?>
						<div class="clearfix"></div>
					<?} ?>
					<?php if ( is_array($gallery_4) ) {
						foreach ( $gallery_4 as $key => $item ) {?>
							<div class="col-xs-12 col-sm-3 col-md-3">
								<div class="gallery-item gallery-item--col4" data-nekoanim="fadeInLeft" data-nekodelay="<?= ++$i*100 ?>">
									<a title="<?php echo $item[ 'title' ]; ?>" href="<?php echo $item[ 'url' ]; ?>" data-fancybox="gallery" data-caption="<?php echo $item[ 'description' ]; ?>" class="b-lazy" data-src="<?php echo $item[ 'url' ];?>" style="background-size: cover;">
									</a>
								</div>
							</div>
						<?  }?>
						<div class="clearfix"></div>
					<?} ?>
					<?php if ( is_array($gallery_5) ) {
						foreach ( $gallery_5 as $key => $item ) {?>
							<div class="col-xs-12 col-sm-4 col-md-2">
								<div class="gallery-item gallery-item--col6" data-nekoanim="fadeInLeft" data-nekodelay="<?= ++$i*100 ?>">
									<a title="<?php echo $item[ 'title' ]; ?>" href="<?php echo $item[ 'url' ]; ?>" class="b-lazy" data-src="<?php echo $item[ 'url' ];?>" data-fancybox="gallery" data-caption="<?php echo $item[ 'description' ]; ?>" style="background-size: cover;">
									</a>
								</div>
							</div>
						<?  } ?>
						<div class="clearfix"></div>
					<?} ?>
				</div>
			</div>
		</div>
	</section>

	<?php
	wp_reset_query();
}	