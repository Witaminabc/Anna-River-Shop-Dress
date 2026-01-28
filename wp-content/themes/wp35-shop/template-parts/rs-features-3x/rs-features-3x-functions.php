<?php
function style_rs_features_3x_theme() {
    wp_enqueue_style( 'rs-features-3x', get_stylesheet_directory_uri().'/template-parts/rs-features-3x/css/rs-features-3x.css');
}
// Вывод блока Преимущества 3 колонки на главной странице
function storefront_rs_features_3x() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 6, // id блока
				'compare' => '=' 
			)
		)
	));	
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		if (get_field('preference_3x_title')) $title = get_field('preference_3x_title');
        if (get_field('preference_3x_text')) $description = get_field('preference_3x_text');
        // Подключить стили для блока Преимущества
        add_action( 'wp_print_scripts', 'style_rs_features_3x_theme', 12);
	}
	?>
	<section class="rs-17">
		<div class="rs-features index-page">
			<div class="container">
				<?php if ($title || $description) : ?>
					<div class="row">
						<div class="col-xs-12">
							<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100">
								<span class="section-title--text"><?=$title; ?></span>
							</h2>
                            <div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
                                <div><?=$description; ?></div>
                            </div>
						</div>
					</div>					
				<?php endif; ?>
				<div class="row">
				<?php if($post_meta) :?>
					<?php 
						$item = 0;
						//var_dump(get_field("preference_3x_{$item}_img"));
						while (!empty(get_field("preference_3x_{$item}_img"))) {
							$feature_image = get_field("preference_3x_".$item."_img")['url'];
							$feature_name = get_field("preference_3x_".$item."_title");
							$feature_description = get_field("preference_3x_".$item."_text");
							$item++; ?>
								<div class="col-xs-12 col-sm-6 col-md-4 feature-block">
									<div class="feature-item" data-nekoanim="fadeInDown" data-nekodelay="400">
										<div class="feature-item--icon">
											<img class="b-lazy" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png" data-src="<?=$feature_image; ?>" alt="feature_picture">
										</div>
										<h4><?=$feature_name; ?></h4>					
										<div><?=$feature_description; ?></div>
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
function storefront_rs_features_x() {
    $query = new WP_Query( array (
        'post_type' => 'custom_block',
        'meta_query' => array (
            'relation' => 'OR',
            array (
                'key'     => 'block_id',
                'value'   => 60, // id блока
                'compare' => '='
            )
        )
    ));
    while ( $query->have_posts() ) {
        $query->the_post();
        $post_meta = get_post_meta($query->post->ID);
    }
    if ($post_meta) {
        if (get_field('preference_3x_title')) $title = get_field('preference_3x_title');
        $description = get_field('preference_3x_text')?get_field('preference_3x_text'):'';
        // Подключить стили для блока Преимущества
        add_action( 'wp_print_scripts', 'style_rs_features_3x_theme', 12);
    }
    ?>
    <section class="rs-17">
        <div class="rs-features index-page">
            <div class="container">
                <?php if($title || $description) : ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100">
                                <span class="section-title--text"><?=$title; ?></span>
                            </h2>
                            <?php if($description) : ?>
                                <div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
                                    <div><?=$description; ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <?php if($post_meta) :?>
                        <?php
                        $item = 0;
                        //var_dump(get_field("preference_3x_{$item}_img"));
                        while (!empty(get_field("preference_3x_{$item}_img"))) {
                            $feature_image = get_field("preference_3x_".$item."_img")['url'];
                            $feature_name = get_field("preference_3x_".$item."_title");
                            $feature_description = get_field("preference_3x_".$item."_text");
                            $item++; ?>
                            <div class="col-xs-12 col-sm-6 col-md-4 feature-block">
                                <div class="feature-item" data-nekoanim="fadeInDown" data-nekodelay="400">
                                    <div class="feature-item--icon">
                                        <img class="b-lazy" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png" data-src="<?=$feature_image; ?>" alt="feature_picture">
                                    </div>
                                    <h4><?=$feature_name; ?></h4>
                                    <div><?=$feature_description; ?></div>
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