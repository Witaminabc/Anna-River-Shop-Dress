<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<div class="rs-17">
		<div class="rs-page">
			<div class="container rs-page-inner">
				<div class="row">
					<div class="col-xs-12">
						<h1 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50"><?php the_title() ?></h1>

							
						<div class="news-date text-center"><?php echo get_the_date("j F Y"); ?></div>
						<? if(get_field('desc') ) { ?>
							<div class="section-descr">
								<p><?= get_field('desc') ?></p>
							</div>
						<? } ?>
					</div>
					<!-- Сайт разработан в компании Россайт - rosait.ru -->
					<div class="col-xs-12 clearfix about-main">
						<?php the_content() ?>
					</div>
					<div class="col-xs-12">
					<a href="<?php echo get_post_type_archive_link('news'); ?>" class="btn btn-link btn-back"><i class="fa fa-long-arrow-left"></i>Назад к списку</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
<? endwhile; ?>

<?php get_footer(); ?>