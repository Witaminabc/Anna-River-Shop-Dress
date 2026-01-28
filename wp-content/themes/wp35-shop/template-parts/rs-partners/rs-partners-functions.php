<?php
function style_rs_partners_theme() {
    wp_enqueue_style( 'rs-partners-theme', get_stylesheet_directory_uri().'/template-parts/rs-partners/css/rs-partners.css');
}
function storefront_rs_partners() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 14, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) :
		$title = get_field("title") ?: '';
		$description = get_field("description") ?: '';
        add_action( 'wp_print_scripts', 'style_rs_partners_theme', 12);
        ?>
<section class="rs-17">
	<div class="rs-partners" id="block-logos">
		<div class="container">
            <?php if($title || $description): ?>
			<div class="row">
				<div class="col-xs-12">
				    <h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><?=$title; ?></h2>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<p><?=$description; ?></p>
					</div>
				</div>
			</div>
            <?php endif; ?>
			<div class="row">
				<div id="logos-slider" class="owl-carousel">
				<?php
				$item = 0;
				while (!empty(get_field("logo_{$item}_img"))) :
					$img = get_field("logo_".$item."_img")['url'] ?: '';
					$link = get_field("logo_".$item."_link") ?: '';
					$item++; 
					?>
                    <div class="logo">
    				    <a href="<?=$link; ?>" target="_blank">
    					    <img class=""  src="<?=$img; ?>" alt="partner-logo" />
    					</a>
    				</div>
					<?php
				endwhile;		
				?>				
                </div>
			</div>
		</div>
	</div>
</section>					
<?php
	endif;
	wp_reset_query();	
}