<?php
/**
 * The template for displaying all pages.
 *
 * This is the templ ate that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

$add_blocks = get_field("add_blocks") ?: '';
echo 'page';
echo 'page';
//function test_for_fil(){
//var_dump( apply_filters('test_fil',
//    $elem_test=array(
//        array(
//            'type' => 'wrap_open',
//            'id' => 'woocommerce_awooc_wrap_open',
//        ),
//        array(
//            'type' => 'wrap_open',
//            'id' => 'woocommerce_awooc_wrap_open',
//        ),
//    )
//
//));
//}
//add_filter('test_fil','callback_f');
//function callback_f($data){
//    $data[0]['type']='000';
//    return $data;
//}
//add_filter('test_fil','callback_f2');
//function callback_f2($data){
//    $data[0]['type']=$data[0]['type'].'good';
//    return $data;
//}
//test_for_fil();


 apply_filters('test_fil2','cal_test3','arg1', 'arg2 ');


//return $elem_test;
//});


get_header(); ?>
    <div class="rs-child-tmpl">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <?php

                if (get_field("on_slider")) {
                    do_action('template_on_slider');
                }

                while (have_posts()) :
                    the_post();

                    do_action('storefront_page_before');

                    if (get_field("text_block_before_show")) {
                        get_template_part('template-parts/rs-text-block/rs-text-block-before');
                    }

                    ?>
                    <?php if (get_field('on_title') || get_field('short_desc') || get_field('on_content') || get_field('on_banner')) : ?>
                    <div class="rs-17">
                        <div class="rs-page">

                            <? if (get_field('on_banner')) {
                                $slider_image = get_field('img_banner');
                                $url = $slider_image['url'];
                                $attachment_id = attachment_url_to_postid($url);
                                $srcm = wp_get_attachment_image_url($attachment_id, array(768, 376));
                                $src = wp_get_attachment_image_url($attachment_id, 'large');
                                $srcF = wp_get_attachment_image_url($attachment_id, 'full');
                                ?>
                                <div class="parallax parallax-about <? if (get_field('img_banner')) { ?> b-lazy <? } ?>"
                                     <? if (get_field('img_banner')) { ?>data-src="<?= $srcF ?>"
                                     data-medium="<?= $src ?>" data-small="<?= $srcm ?>"
                                     style="background-attachment: unset; background-size: cover;"<? } ?>>
                                    <? if (get_field('text_banner')) { ?>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-8 col-sm-offset-4 col-md-7 col-md-offset-5 col-lg-6 col-lg-offset-6 slider-inner parallax-content">
                                                    <h2><?= get_field('title_banner') ?></h2>
                                                    <div class="text-description"><?= get_field('text_banner') ?></div>
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
                                                <h1 class="text-center section-title" data-nekoanim="fadeInUp"
                                                    data-nekodelay="50"><span class="section-title--text">
											<?php the_title() ?></span>
                                                </h1>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (get_field('short_desc')) : ?>
                                            <div class="col-xs-12 clearfix about-main">
                                                <div class="section-descr"><p>
                                                        <?= get_field('short_desc'); ?>
                                                    </p></div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (get_field('on_content')) : ?>
                                            <div class="col-xs-12 clearfix about-main">
                                                <?= the_content(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                    <?php
                    if ($add_blocks) {

                        foreach ($add_blocks as $value) {

                            do_action('template_' . $value['block_name']);
                        }
                    }

                    if (get_field("text_block_after_show")) {
                        get_template_part('template-parts/rs-text-block/rs-text-block-after');
                    }

                    do_action('storefront_page_after');

                endwhile; // End of the loop.
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php
        //do_action( 'storefront_sidebar' );

        ?> </div> <?php
get_footer();
