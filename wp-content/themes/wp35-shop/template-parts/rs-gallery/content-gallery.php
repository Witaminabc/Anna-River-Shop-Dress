<div class="col-xs-12 col-sm-6 col-md-4 gallery-block">
	<div class="gallery-item" data-nekoanim="fadeInUp" data-nekodelay="400">
		<a class="gallery-image  b-lazy" href="<?php the_permalink() ?>" data-src="<?php echo get_field('photo')['url'] ?>"  ></a>
		<div class="gallery-title"><h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4></div>
		<div class="gallery-content"><?= get_field('text_anons') ?></div>
		<div class="gallery-more"><a href="<?php the_permalink() ?>" class="btn btn-outline">Подробнее</a></div>
	</div>
</div>