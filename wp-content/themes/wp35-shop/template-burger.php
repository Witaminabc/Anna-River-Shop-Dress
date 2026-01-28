<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Burger Page
 *
 * @package storefront
 */

$add_blocks = get_field("add_blocks") ?: '';
//get_header('burger-menu');
get_header(); ?>
<div class="rs-child-tmpl">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" >
			<?php
			if (get_field("on_slider")) {
				do_action( 'template_on_slider' ); 
			}

			while ( have_posts() ) :
				the_post();

				do_action( 'storefront_page_before' );

				if (get_field("text_block_before_show")) {
					get_template_part('template-parts/rs-text-block/rs-text-block-before');				
				}
	

				?> 
				<div class="rs-17">
					<div class="rs-page">

                        <? if(get_field('on_banner') ) {
                            $slider_image = get_field('img_banner');
                            $url = $slider_image['url'];
                            $attachment_id = attachment_url_to_postid( $url );
                            $srcm = wp_get_attachment_image_url( $attachment_id, array(768,376) );
                            $src = wp_get_attachment_image_url( $attachment_id, 'large' );
                            $srcF = wp_get_attachment_image_url( $attachment_id, 'full' );
                            ?>
                            <div  class="parallax parallax-about <? if(get_field('img_banner') ) { ?> b-lazy <?}?>" <? if(get_field('img_banner') ) { ?>data-src="<?=$srcF?>" data-medium="<?=$src?>" data-small="<?=$srcm?>" style="background-attachment: fixed; background-size: cover;"<?}?>>
                                <? if(get_field('text_banner') ) { ?>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xs-12 parallax-content">
                                                <h2><?=get_field('text_banner') ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        <? } ?>

						<div class="container rs-page-inner">
							<div class="row">
								<?php if (get_field('on_title')) : ?>
									<div class="col-xs-12">
										<h1 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50"><span class="section-title--text">
											<?php the_title() ?></span>
										</h1>
									</div>
								<?php endif; ?>
								<?php if (get_field('short_desc')) : ?>
									<div class="col-xs-12 clearfix about-main">
										<div class="section-descr"><p>
											<?=get_field('short_desc'); ?>
										</p></div>
									</div>
								<?php endif; ?>
								<?php if (get_field('on_content')) : ?>
									<div class="col-xs-12 clearfix about-main">
										<?=the_content() ; ?>
									</div>
								<?php endif; ?>								
							</div>
						</div>

					</div>
				</div>

				<?php

				if ($add_blocks) {
					foreach ($add_blocks as $value) {
						do_action( 'template_'. $value['block_name'] ); 
					}					
				}


				if (get_field("text_block_after_show")) {
					get_template_part('template-parts/rs-text-block/rs-text-block-after');
				}

			do_action( 'storefront_page_after' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
//do_action( 'storefront_sidebar' );

?> </div> <?php
get_footer();