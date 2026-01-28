<?php get_header(); 
	global $post;
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 5, // id блока
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
	<div class="rs-news">
		<div class="container rs-news-inner">
			<div class="row">
				<div class="col-xs-12">
					<h1 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><span
							class="section-title--text"><?=$title; ?></span></h1>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<?=$description; ?>
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
			<div class="row">
				<?
				$args = array(
					'post_type'	=> 'news',
					'order'		=> 'DESC',
					'orderby' => 'date'
				);
				?>
				<?php 
				$posts = query_posts( $args );?>
				<?if ( $posts ) : ?>
					<?php
					foreach( $posts as $post ) {
					setup_postdata( $post );
					get_template_part('template-parts/rs-news/content', $post->post_type); 

					}
					wp_reset_postdata();
					?>
					<?php
				else :
					get_template_part('content', 'none');
				endif;
				?>
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