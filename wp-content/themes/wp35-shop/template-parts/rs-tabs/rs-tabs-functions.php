<?php
function style_rs_tabs_theme() {
    wp_enqueue_style( 'rs-tabs-theme', get_stylesheet_directory_uri().'/template-parts/rs-tabs/css/rs-tabs.css');
}

function storefront_rs_tabs() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 22, // id блока
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
		$tab_content = get_field("tab_content") ?: '';


        add_action( 'wp_print_scripts', 'style_rs_tabs_theme', 11);

	}
	//var_dump(get_field('tab_content'));
	?>
	<section class="rs-17">
		<div class="rs-tabs" id="block-tabs">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="text-center section-title" data-nekoanim="fadeInUp"
							data-nekodelay="100"><?=$title; ?></h2>
						<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
							<p><?=$description; ?></p>
						</div>

					</div>
				</div>
				<div class="tabs-row row">
					<div class="col-xs-12 col-sm-4 col-md-3" data-nekoanim="fadeInLeft" data-nekodelay="300">
						<ul class="nav nav-pills nav-stacked" role="tablist">
						<?php
							$i = 0;
							foreach($tab_content as $item) {
								?> 
								<li role="presentation" class="<?php if ( $i++ == 0 ) echo 'active' ?>"><a
										href="#tab-text<?=$i ?>" role="tab"
										data-toggle="tab"><?=$item['name']; ?></a></li>
								<?php
							}
						?>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-9" data-nekoanim="fadeInRight" data-nekodelay="600">
						<div class="tab-content">
						<?php
							$i = 0;
							foreach($tab_content as $item) {
								?> 
								<div role="tabpanel" class="tab-pane <?php if ( $i++ == 0 ) echo 'active' ?> fade in" id="tab-text<?=$i; ?>">
									<?=$item['data']; ?>
								</div>
								<?php
							}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	wp_reset_query();	
}