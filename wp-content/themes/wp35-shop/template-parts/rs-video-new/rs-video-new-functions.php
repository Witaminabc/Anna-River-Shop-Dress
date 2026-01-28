<?php
function style_rs_video_new_theme() {
    wp_enqueue_style( 'rs-video-new', get_stylesheet_directory_uri().'/template-parts/rs-video-new/css/rs-video-new.css');
}
function storefront_rs_video_new() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 20, // id блока
				'compare' => '=' 
			)
		)
	));	
		$query->the_post();
	//	$post_meta = get_post_meta($query->post->ID);
		$title = get_field('title') ?: '';
        $bg_img = get_field('bg_img')?: false;
        if ($bg_img) {
            $url = $bg_img['url'];
            $attachment_id = attachment_url_to_postid($url);
            $srcm = wp_get_attachment_image_url($attachment_id, 'medium_large');
            $src = wp_get_attachment_image_url($attachment_id, 'large');
            $srcF = wp_get_attachment_image_url($attachment_id, 'full');
        }
		$bg_img_bottom = get_field('bg_img_bottom')['url'] ?: '';
		$video_box = get_field('new_video_block') ?: '';
        add_action( 'wp_print_scripts', 'style_rs_video_new_theme', 11);
	?>
    <section class="rs-17">
        <div class="rs-video-new <?if ($bg_img) {?> b-lazy <?}?>" <?if ($bg_img) {?> data-src="<?=$srcF?>" data-medium="<?=$src?>" data-small="<?=$srcm?>"  style="background-size: cover;"<?}?>>
            <div class="bg-video" style="background: url(<?=$bg_img_bottom; ?>) no-repeat; background-size: auto;">
                <div class="container">
                <?php if($title) :?>
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50"><span class="section-title--text"><?=$title; ?></span></h2>
                        </div>
                    </div>
                <?php endif; ?>
                    <?php if ( is_array($video_box) ) {
                        $i = 1;
                        foreach ( $video_box as $item ) { ?>
                            <div class="col-xs-12 col-sm-6">
                                <div class="video-item">
                                    <?if($item[ 'link' ]){?>
                                    <div>
                                        <iframe class="b-lazy"  width="540" height="295" style="border:0;" data-src="https://www.youtube.com/embed/<?php echo $item[ 'link' ]; ?>?modestbranding=1&rel=0&showinfo=0"  allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                    <?}?>
                                    <?if($item[ 'name' ]){?>
                                    <h3>
                                        <?php echo $item[ 'name' ]; ?>
                                    </h3>
                                    <?}?>
                                </div>
                            </div>
                        <? }?>
                        <div class="clearfix"></div>
                    <?} ?>

                </div>
            </div>
        </div>
    </section>
	<?php
	wp_reset_query();
}		