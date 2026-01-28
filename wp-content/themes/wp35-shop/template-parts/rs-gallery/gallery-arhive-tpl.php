<?php get_header();
	global $post;
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 21, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		$title = get_field("title");
		$description = get_field("description");		
	}
?>
<section class="rs-17">
	<div class="rs-gallery">
		<div class="container rs-gallery-inner">
			<div class="row">
				<div class="col-xs-12">
					<h1 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><span class="section-title--text"><?=$title; ?></span></h1>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<p><?=$description; ?></p>
					</div>
				</div>
			</div>
			<div class="row news-footer">
				<div class="col-xs-12">
					<?php 
						the_posts_pagination( array(
								'show_all'     => false,
								'end_size' => 2,
								'mid_size' => 2,
								'prev_text'    => __('«'),
								'next_text'    => __('»')
							) ); 
							?>
				</div>
			</div>
			<!-- Сайт разработан в компании Россайт - rosait.ru -->
			<div class="row gallery-tile">
				<?php if ( have_posts() ) : ?>
					<?php
					while ( have_posts() ) : the_post();
						get_template_part('template-parts/rs-gallery/content', $post->post_type);
					endwhile;
					?>
					<?php
				else :
					get_template_part('content', 'none');
				endif;
				?>
			</div>
			<div class="row gallery-footer">
				<div class="col-xs-12">
						<?php /*if ( function_exists('post_pagenavi') ) post_pagenavi($count_posts); */?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.rs-news -->
<?php
	unset($args);
	unset($posts);
	wp_reset_query();
?>
<?php get_footer(); ?>