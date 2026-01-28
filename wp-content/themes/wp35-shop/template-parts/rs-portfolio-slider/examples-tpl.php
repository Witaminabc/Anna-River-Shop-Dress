<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div class="rs-17">
		<div class="rs-page">
			<div class="container rs-page-inner">
				<div class="row">
					<div class="col-xs-12">
						<h1 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50"><?php the_title() ?></h1>
						<?$dateformatstring = "j F Y";
						$unixtimestamp = strtotime(get_field('date_post'));?>
							
						<div class="news-date text-center"><?php echo date_i18n($dateformatstring, $unixtimestamp); ?></div>

					</div>
					<!-- Сайт разработан в компании Россайт - rosait.ru -->
					<div class="col-xs-12 clearfix about-main">
					    <a href="<?=get_field('image')['url']; ?>" data-fancybox><img class="img-responsive alignleft size-full b-lazy" src="<?=get_stylesheet_directory_uri()?>/assets/img/img0.png" data-src="<?=get_field('image')['url']; ?>" alt="<?=get_field('image')['alt']; ?>"></a>
						<?php the_content() ?>
					</div>
					<div class="col-xs-12">
					<a href="<?php echo get_post_type_archive_link('examples'); ?>" class="btn btn-link btn-back"><i class="fa fa-long-arrow-left"></i>Назад к списку</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
<? endwhile; ?>
<?unset($dateformatstring);
unset($unixtimestamp);
?>
<?php get_footer(); ?>