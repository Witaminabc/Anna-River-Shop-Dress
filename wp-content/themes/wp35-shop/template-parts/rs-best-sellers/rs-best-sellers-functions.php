<?php
function style_rs_best_sellers_theme() {
    wp_enqueue_style( 'rs-best-sellers', get_stylesheet_directory_uri().'/template-parts/rs-best-sellers/css/rs-best-sellers.css');
}
// Функция вывода блока Самые продаваемые вместо стандартной
function storefront_best_selling_products_child( $args ) {

// Подключить стили для блока Самые продаваемые
    add_action( 'wp_print_scripts', 'style_rs_best_sellers_theme');
    // Выполнение запроса по категориям и атрибутам
	$args = array(
			'post_type' => 'product', // тип товара
			'orderby' => 'date', // сортировка
			'meta_query' => array(
				array(
					'key' => '_best_seller',
					'value' => 'yes'
				)
			)						
		);
	$loop = new WP_Query( $args );
	if ($loop->have_posts()) :
	?>
	<section class="rs-17">
		<div class="rs-best-sellers">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><span class="section-title--text">самые продаваемые</span></h2>
					</div>
					<div class="col-xs-12 no-padding">
						<div id="product-slider-bs" class="owl-carousel" data-nekoanim="fadeInUp">
						<?php
							while ( $loop->have_posts() ) : $loop->the_post();
							global $product;
                                if($product->is_type( 'variable' )){
                                    $regular_price = $product->get_variation_regular_price( 'min' );
                                    $sale_price = $product->get_variation_sale_price( 'min' );
                                } else {
                                    $regular_price = $product->get_regular_price();
                                    $sale_price = $product->get_sale_price();
                                }
                                $discount = ($regular_price && $sale_price) ? ceil((($regular_price - $sale_price) * 100) / $regular_price) : '';
                                $onsale = $product->is_on_sale();
                                $discount = $discount == 100 ? '' : $discount;
                                $discount = $discount ? $discount . ' %' : '';
							ob_start();
							the_title();
							$title_products = ob_get_clean();

							$title_products = (mb_strlen($title_products) > 45) ?
								mb_substr($title_products, 0, 45) . '...' : $title_products;
						?>
						<!-- Цикл для вывода выбранных товаров -->
						<div class="product-item">
							<div class="product">
								<div class="product-image">
									<div class="quickview">
										<a data-id="<?=$loop->post->ID?>"  class="btn btn-xs btn-quickview" href="#" data-path="<?=get_stylesheet_directory_uri(); ?>" data-target="#best-product-details-modal" data-toggle="modal">Быстрый просмотр</a>
									</div>
                                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>">
                                        <?php if (has_post_thumbnail( $loop->post->ID )) {
                                            $thumbnail_id  = get_post_thumbnail_id( $loop->post->ID );
                                            $default_attr = array(
                                                'src'   => wc_placeholder_img_src(),
                                                'data-src'   => wp_get_attachment_image_url( $thumbnail_id, 'shop_catalog' ),
                                                'class' => "b-lazy ",
                                            );
                                            echo '<img class="" src="'.wp_get_attachment_image_url( $thumbnail_id, 'shop_catalog' ).'"  alt=" "  />';
                                            //get_the_post_thumbnail($loop->post->ID, 'shop_catalog',$default_attr);

                                        } else echo '<img src="'.wc_placeholder_img_src().'" alt="Placeholder" width="250px" height="250px" />';
                                        ?>
                                    </a>
                                    <ul class="promotion">
                                        <?php
                                        if(get_field('_new_product')=='yes') :?>
                                            <li class="new">NEW </li>
                                        <?php endif; ?>
                                        <?php if($onsale ) :?>
                                            <li class="discount">SALE <?=$discount; ?></li>
                                        <?php endif; ?>
                                    </ul>
								</div>
								<div class="description">
									<h3><a href="<?php echo get_permalink( $loop->post->ID ) ?>"><?=$title_products; ?></a></h3>
									<p>
										<?php
                                        $short_description = get_the_excerpt();
                                        $description = $short_description? the_excerpt_max_charlength(strip_tags(preg_replace ('~\[[^\]]+\]~', '',$short_description)), 80):the_excerpt_max_charlength(strip_tags(preg_replace ('~\[[^\]]+\]~', '',$product->get_description())), 80);
                                        echo $description;
                                        ?>
									</p>
								</div>
                                <?php
                                    $product = wc_get_product();
                                    $values = explode(",",$product->get_attribute( 'pa_size' ));
                                    echo "<div class='sub-description'>".  implode( '/', $values )."</div>";
                                 ?>
								<div class="price">
									<?php echo $product->get_price_html(); ?> 
								</div>
								<div class="action-control">
									<a href="<?php echo get_permalink( $loop->post->ID ) ?>" class="btn btn-color">Подробнее</a>
								</div>
							</div>
						</div>
						<?php endwhile; ?>
						<!-- Сброс данных запроса -->
						<?php wp_reset_query(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
        <div class="rs-17">
            <div class="rs-product-view">
                <div class="modal fade" id="best-product-details-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div id="modal-product-best" class="modal-content">


                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php endif;
}