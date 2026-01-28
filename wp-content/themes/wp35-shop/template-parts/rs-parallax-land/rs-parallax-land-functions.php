<?php
function style_rs_parallax_land_theme() {
    wp_enqueue_style( 'rs-parallax-land', get_stylesheet_directory_uri().'/template-parts/rs-parallax-land/css/rs-parallax-land.css');
}
function storefront_rs_parallax_land() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 13, // id блока
				'compare' => '=' 
			)
		)
	));
	$query->the_post();
	//$post_meta = get_post_meta($query->post->ID);
		$bg_img = get_field('bg_img')?: false;
        if ($bg_img) {
            $url = $bg_img['url'];
            $attachment_id = attachment_url_to_postid($url);
            $srcm = wp_get_attachment_image_url($attachment_id, 'medium_large');
            $src = wp_get_attachment_image_url($attachment_id, 'large');
            $srcF = wp_get_attachment_image_url($attachment_id, 'full');
        }
		$title = get_field("title") ?: '';
		$text = get_field("text") ?: '';
		$author = get_field("author") ?: '';
        add_action( 'wp_print_scripts', 'style_rs_parallax_land_theme', 12);
?>

<section class="rs-17">
	<div class="rs-parallax2 parallax-text parallax-land <?if ($bg_img) {?> b-lazy <?}?>" <?if ($bg_img) {?> data-src="<?=$srcF?>" data-medium="<?=$src?>" data-small="<?=$srcm?>" style="background-size: cover;"<?}?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-md-6 parallax-title text-left">
                    <?php if($title) :?>
					    <h2 data-nekoanim="fadeInUp" data-nekodelay="100"><?=$title; ?></h2>
                    <?php endif; ?>
                    <?php if($text) :?>
					    <h3 data-nekoanim="fadeInUp" data-nekodelay="100"><?=$text; ?></h3>
                    <?php endif; ?>
                    <?php if($author) :?>
                        <div class="quote" data-nekoanim="fadeInUp" data-nekodelay="150"><?=$author; ?></div>
                    <?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
wp_reset_query();	
}	