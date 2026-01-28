<?php get_header(); ?>
       
<?php
	// Start the loop.
	while ( have_posts() ) : the_post();
	$author = get_field('author') ?: '';
	$msg = get_field('msg') ?: '';
	$img = get_field('img') ?: ''; 
		?>
			<div class="rs-17">
				<div class="rs-page">
					<div class="container rs-page-inner">
						<div class="row">
							<div class="col-xs-12">
								<h1 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50"><span class="section-title--text"><?=$author; ?></span>
								</h1>
								<?php if ($img) : ?>
								<div class="reviews-img">
									<img data-src="<?=$img['url']; ?>" alt="review" class="img-responsive b-lazy">
								</div>
								<?php endif; ?>									
							<!-- Сайт разработан в компании Россайт - rosait.ru -->
							<div class="col-xs-12 clearfix about-main">
								<?=$msg; ?>
							</div>
							<div class="col-xs-12">
								<a href="<?php echo get_post_type_archive_link('review'); ?>" class="btn btn-link btn-back"><i class="fa fa-long-arrow-left"></i>Назад к списку</a>
							</div>
						</div>
					</div>
				</div>
			</div>		
	<? endwhile;?>

<?php get_footer(); ?>