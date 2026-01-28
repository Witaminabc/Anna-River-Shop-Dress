<?php
function style_rs_services_icon_theme() {
    wp_enqueue_style( 'rs-services-icon', get_stylesheet_directory_uri().'/template-parts/rs-services-icon/css/rs-services-icon.css');
}
function storefront_rs_services_icon() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 28, // идентификатор блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
        // Подключить стили для блока
        add_action( 'wp_print_scripts', 'style_rs_services_icon_theme');
		$box_services_2_icon = get_field('box_services_2_icon');
		$box_services_3_icon = get_field('box_services_3_icon');
		$box_services_4_icon = get_field('box_services_4_icon');
	}
?>
<section class="rs-17">
	<div class="rs-services-icon">
		<div class="container">
			<?if (get_field('block_title')) : ?>
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50"><?php the_field('block_title'); ?></h2>
				</div>
			</div>
			<?php endif; ?>
			<div class="row services-row">
				<?php if ( is_array($box_services_2_icon) ) {
					$i = 1;
					foreach ( $box_services_2_icon as $item ) { ?>
						<div class="col-xs-12 col-sm-6">
							<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="<?= 100 * $i++ ?>">
								<a href="<?php echo $item[ 'link' ]; ?>">
									<div class="services-item--title">
										<?if($item[ 'name' ]){?>
										<h3>
											<?php echo $item[ 'name' ]; ?>
										</h3>
										<?}?>
									</div>
									<div class="services-item--description">
										<?if($item[ 'desc' ]){?>
										<p>
											<?php echo $item[ 'desc' ]; ?>
										</p>
										<?}?>
									</div>
									<div class="overlay"></div>
									<?if($item[ 'image' ]){?>
									<?$item_image2 = $item[ 'image' ]?>
									<div class="services-item--img b-lazy"
                                         data-src="<?php echo $item_image2['url']; ?>" ></div>
									<?}?>
								</a>
							</div>
						</div>
					<? }?>
					<div class="clearfix"></div>
				<?} ?>
				<?php if ( is_array($box_services_3_icon) ) {
					foreach ( $box_services_3_icon as $item ) { ?>
						<div class="col-xs-12 col-sm-4">
							<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="<?= 100 * $i++ ?>">
								<a href="<?php echo $item[ 'link' ]; ?>">
									<div class="services-item--title">
										<?if($item[ 'name' ]){?>
										<h3>
											<?php echo $item[ 'name' ]; ?>
										</h3>
										<?}?>
									</div>
									<div class="services-item--description">
										<?if($item[ 'desc' ]){?>
										<p>
											<?php echo $item[ 'desc' ]; ?>
										</p>
										<?}?>
									</div>
									<div class="overlay"></div>
									<?if($item[ 'image' ]){?>
									<?$item_image3 = $item[ 'image' ]?>
									<div class="services-item--img b-lazy"
                                         data-src="<?php echo $item_image3['url']; ?>"></div>
									<?}?>
								</a>
							</div>
						</div>
					<? }?>
					<div class="clearfix"></div>
				<?} ?>
				<?php if ( is_array($box_services_4_icon) ) {
					foreach ( $box_services_4_icon as $item ) { ?>
						<div class="col-xs-12 col-sm-3 col-sm-3">
							<div class="services-item" data-nekoanim="fadeInUp" data-nekodelay="<?= 100 * $i++ ?>">
								<a href="<?php echo $item[ 'link' ]; ?>">
									<div class="services-item--title">
										<?if($item[ 'name' ]){?>
										<h3>
											<?php echo $item[ 'name' ]; ?>
										</h3>
										<?}?>
									</div>
									<div class="services-item--description">
										<?if($item[ 'desc' ]){?>
										<p>
											<?php echo $item[ 'desc' ]; ?>
										</p>
										<?}?>
									</div>
									<div class="overlay"></div>
									<?if($item[ 'image' ]){?>
									<?$item_image4 = $item[ 'image' ]?>
									<div class="services-item--img b-lazy"
                                         data-src="<?php echo $item_image4['url']; ?>"></div>
									<?}?>
								</a>
							</div>
						</div>
					<? }?>
					<div class="clearfix"></div>
				<? } ?>
			</div>
		</div>
	</div>
</section>
<?php
}