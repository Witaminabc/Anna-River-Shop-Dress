<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: All Blocks
 *
 * @package storefront
 */

$is_blocks_show = [
	'on_parallax_1' => get_field("on_parallax_1_on"),
	'on_parallax_2' => get_field("on_parallax_2_on"),
	'on_tabs' => get_field("on_tabs_on"),
	'on_video_new' => get_field("on_video_new_on"),
	'on_photogallery' => get_field("on_photogallery_on"),
	'on_subscribe' => get_field("on_subscribe_on"),
	'on_counter' => get_field("on_counter_on"),
	'on_price' => get_field("on_price_on"),
	'on_video' => get_field("on_video_on"),
	'on_partners' => get_field("on_partners_on"),
	'on_quote' => get_field("on_quote_on"),
	'on_contact' => get_field("on_contact_on"),
	'on_works' => get_field("on_works_on"),
	'on_team' => get_field("on_team_on"),	
	'on_reviews' => get_field("on_reviews_on"),
	'on_catalog' => get_field("on_catalog_on"),
    'on_catalog_free' => get_field("on_catalog_free_on"),
	'on_news' => get_field("on_news_on"),
	'on_form' => get_field("on_form_on"),
	'on_features_3' => get_field("on_features_3_on"),
	'on_features_4' => get_field("on_features_4_on"),
	'on_offers' => get_field("on_offers_on"),
	'on_numbers' => get_field("on_numbers_on"),
	'on_features_photo' => get_field("on_features_photo_on"),
	'on_popular' => get_field("on_popular_on"),
	'on_onsale' => get_field("on_onsale_on"),
	'on_new_products' => get_field("on_new_products_on"),
	'on_best_seller' => get_field("on_best_seller_on"),
	'on_examples' => get_field("on_examples_on"),
	'on_services_icon' => get_field("on_services_icon_on"),
	'on_contact_land' => get_field("on_contact_land_on"),
	'on_recommendations' => get_field("on_recommendations_on"),
	'on_carousel' => get_field("on_carousel_on")		
];

$is_blocks_rank = [
	'on_parallax_1' => get_field("on_parallax_1_rank"),
	'on_parallax_2' => get_field("on_parallax_2_rank"),
	'on_tabs' => get_field("on_tabs_rank"),
	'on_video_new' => get_field("on_video_new_rank"),
	'on_photogallery' => get_field("on_photogallery_rank"),
	'on_subscribe' => get_field("on_subscribe_rank"),
	'on_counter' => get_field("on_counter_rank"),
	'on_price' => get_field("on_price_rank"),
	'on_video' => get_field("on_video_rank"),
	'on_partners' => get_field("on_partners_rank"),
	'on_quote' => get_field("on_quote_rank"),
	'on_contact' => get_field("on_contact_rank"),
	'on_works' => get_field("on_works_rank"),
	'on_team' => get_field("on_team_rank"),	
	'on_reviews' => get_field("on_reviews_rank"),
	'on_catalog' => get_field("on_catalog_rank"),
	'on_catalog_free' => get_field("on_catalog_free_rank"),
	'on_news' => get_field("on_news_rank"),
	'on_form' => get_field("on_form_rank"),
	'on_features_3' => get_field("on_features_3_rank"),
	'on_features_4' => get_field("on_features_4_rank"),
	'on_offers' => get_field("on_offers_rank"),
	'on_numbers' => get_field("on_numbers_rank"),
	'on_features_photo' => get_field("on_features_photo_rank"),
	'on_popular' => get_field("on_popular_rank"),
	'on_onsale' => get_field("on_onsale_rank"),
	'on_new_products' => get_field("on_new_products_rank"),
	'on_best_seller' => get_field("on_best_seller_rank"),
	'on_examples' => get_field("on_examples_rank"),
	'on_services_icon' => get_field("on_services_icon_rank"),
	'on_contact_land' => get_field("on_contact_land_rank"),
	'on_recommendations' => get_field("on_recommendations_rank"),
	'on_carousel' => get_field("on_carousel_rank")			
];

asort($is_blocks_rank);



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

                <?php if (get_field('on_title') || get_field('short_desc') || get_field('on_content') || get_field('on_banner')) : ?>
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

                <?php if (get_field('on_title') || get_field('short_desc') || get_field('on_content')) : ?>
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
                <?php endif; ?>
                    </div>
				</div>
            <?php endif; ?>
				<?php

				foreach ($is_blocks_rank as $key => $value) {
                    // var_dump($key);
					if ($is_blocks_show[$key]) do_action( 'template_'. $key ); 
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