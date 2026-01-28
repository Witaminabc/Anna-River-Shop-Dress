<?php
function style_rs_video_theme() {
    wp_enqueue_style( 'rs-video-theme', get_stylesheet_directory_uri().'/template-parts/rs-video/css/rs-video.css');
}
function storefront_rs_video() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 15, // id блока
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
		$button_title = get_field("button_title") ?: '';

        add_action( 'wp_print_scripts', 'style_rs_video_theme', 12);

	}
?>
<section class="rs-17">
	<div class="rs-video" id="block-video">
        <?php if ($title || $button_title) : ?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 section-title">
					<h2 class="text-center" data-nekoanim="fadeInUp" data-nekodelay="100">
                    <?php if ($title) : ?>
                        <?=$title; ?>
                    <?php endif; ?>
                    <?php if ($button_title) : ?>
						<a href="#" data-target="#video-block-full" data-toggle="modal" class="play-btn"><i class="fa fa-play"></i></a>								
						<?=$button_title; ?>
                    <?php endif; ?>
					</h2>	
				</div>
			</div>
		</div>
        <?php endif; ?>
		<video  autoplay="" loop="" muted="" class="video-bg" poster="<?php if(get_field('poster_video')) echo get_field('poster_video')['url']; ?>">
			<?if(get_field('link_video_mp4')) { ?><source src="<?php the_field('link_video_mp4'); ?>" type="video/mp4"><?}?>
			<?if(get_field('link_video_webm')) { ?><source src="<?php the_field('link_video_webm'); ?>" type="video/webm"><?}?>
			<?if(get_field('link_video_ogg')) { ?><source src="<?php the_field('link_video_ogg'); ?>" type="video/ogg"><?}?>
		</video>
	</div>
</section>
<div class="rs-17">
	<div class="rs-modal">
		<div class="modal fade" tabindex="-1" id="video-block-full">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<div class="embed-responsive embed-responsive-16by9" id="yt-player">
						<?php if(get_field('insert_video')=='outlink_video') {?>
							<?if(get_field('insert_video_link')){?><iframe src="<?php the_field('insert_video_link'); ?>" allowfullscreen></iframe><?}?>
						<?} else {?>
						<?php if(get_field('insert_video_poster')||get_field('insert_video_mp4')||get_field('insert_video_webm')||get_field('insert_video_ogg')){?>
							<video autoplay="" loop="" muted="" controls class="video-bg" poster="<?php if(get_field('insert_video_poster'))  echo get_field('insert_video_poster')['url']; ?>">
								<?if(get_field('insert_video_mp4')) { ?><source src="<?php the_field('insert_video_mp4'); ?>" type="video/mp4"><?}?>
								<?if(get_field('insert_video_webm')) { ?><source src="<?php the_field('insert_video_webm'); ?>" type="video/webm"><?}?>
								<?if(get_field('insert_video_ogg')) { ?><source src="<?php the_field('insert_video_ogg'); ?>" type="video/webm"><?}?>
							</video>
						<?}
						}?>							
						</div>
					</div>
					<script>

					</script>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	wp_reset_query();	
}