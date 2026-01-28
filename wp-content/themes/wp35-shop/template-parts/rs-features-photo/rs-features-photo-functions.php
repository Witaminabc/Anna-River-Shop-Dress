<?php
function style_rs_features_photo_theme() {
    wp_enqueue_style( 'rs-features-photo-theme', get_stylesheet_directory_uri().'/template-parts/rs-features-photo/css/rs-features-photo.css');
}
function storefront_rs_features_photo() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 9, // id блока
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
		$center_image = get_field("center_img")['url'];
		$title = get_field("title");
		$items = [];
		for($i = 0; $i < 4; $i++) {
			array_push($items, [
				'name' => get_field("feature_{$i}_name"),
				'text' => get_field("feature_{$i}_text")
			]);
		}
// Подключение стилей
        add_action( 'wp_print_scripts', 'style_rs_features_photo_theme', 12);
    }

?>
<section class="rs-17">
	<div class="rs-features-photo <?if ($bg_img) {?> b-lazy <?}?>" id="block-features-photo"   <?if ($bg_img) {?> data-src="<?=$srcF?>" data-medium="<?=$src?>" data-small="<?=$srcm?>" style="background-size: cover;"<?}?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title"  data-nekoanim="fadeInUp" data-nekodelay="100">
						<span class="section-title--text"><?=$title; ?></span>
					</h2>
				</div>
			</div>
		<div class="special-features">
			<div class="row">
				<div class="col-sm-3" data-nekoanim="fadeInLeft" data-nekodelay="200">
					<div class="special-content text-right">
						<h4><?=$items[0]['name']; ?></h4>
						<p><?=$items[0]['text']; ?></p>
					</div>
					<div class="special-content text-right">
						<h4><?=$items[1]['name']; ?></h4>
						<p><?=$items[1]['text']; ?></p>
					</div>
				</div>
				<div class="col-sm-6" data-nekoanim="fadeInUp" data-nekodelay="300">
					<div class="special-image">
						<img class="img-responsive b-lazy" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png" data-src="<?=$center_image; ?>" alt="center-img">
					</div>
				</div>
				<div class="col-sm-3" data-nekoanim="fadeInRight" data-nekodelay="400">
					<div class="special-content text-left">
						<h4><?=$items[2]['name']; ?></h4>
						<p><?=$items[2]['text']; ?></p>
					</div>
					<div class="special-content text-left">
						<h4><?=$items[3]['name']; ?></h4>
						<p><?=$items[3]['text']; ?></p>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
//Сброс данных запроса
wp_reset_query();	
}