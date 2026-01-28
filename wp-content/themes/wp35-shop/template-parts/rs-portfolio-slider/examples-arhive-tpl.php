<?php get_header(); 

	global $post;
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 27, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
		$examples_name = get_field("examples_name") ?: '';
		$examples_text = get_field("examples_text") ?: '';		
	}

?>

<section class="rs-17">
	<div class="rs-portfolio-slider">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<?php if ($examples_name) : ?>
						<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><?=$examples_name; ?></h2>
					<?php endif; ?>
					<?php if ($examples_text) : ?>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<p><?=$examples_text; ?></p>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div id="examples-slider" class="owl-carousel">
						
						<?php query_posts('post_type=examples&posts_per_page=-1'); ?>
						<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>
						<? $img_example = get_field('image'); ?>
						<div class="example">
							<a href="<?php the_permalink() ?>"><img class="img-responsive  b-lazy" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png" data-src="<?=$img_example['url']; ?>" alt="<?=$img_example['alt']; ?>"></a>
							<div class="example-info">
								<a href="<?php the_permalink() ?>"><h3><?php the_title() ?></h3></a>
								<p><?php echo get_field('text_anons'); ?></p>
							</div>
							<a href="<?php the_permalink() ?>" class="btn-color">Подробнее</a>
						</div>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
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