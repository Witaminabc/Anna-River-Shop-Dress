<?php
function style_rs_parallax_2_theme() {
    wp_enqueue_style( 'rs-parallax-2-theme', get_stylesheet_directory_uri().'/template-parts/rs-parallax-2/css/rs-parallax-2.css');
}
function storefront_parallax_2() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 24, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
        $bg_img = get_field('bg_img')?: false;
        if ($bg_img) {
            $url = $bg_img['url'];
            $attachment_id = attachment_url_to_postid($url);
            $srcm = wp_get_attachment_image_url($attachment_id, 'medium_large');
            $src = wp_get_attachment_image_url($attachment_id, 'large');
            $srcF = wp_get_attachment_image_url($attachment_id, 'full');
        }

		$title = get_field("title") ?: '';
    }
    add_action( 'wp_print_scripts', 'style_rs_parallax_2_theme', 11);
?>
<section class="rs-17">
	<div class="rs-parallax-2 parallax-block <?if ($bg_img) {?> b-lazy <?}?>" <?if ($bg_img) {?> data-src="<?=$srcF?>" data-medium="<?=$src?>" data-small="<?=$srcm?>" style="background-size: cover;"<?}?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 parallax-title">
					<h2 data-nekoanim="fadeInUp" data-nekodelay="100" class="text-center"><?=$title; ?></h2>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	wp_reset_query();	
}