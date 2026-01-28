<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package storefront
 */

get_header(); ?>

    <div class="rs-17">
        <div class="rs-page">
            <div class="container rs-page-inner">
                <div class="row">
                    <div class="col-xs-12 col-lg-8 col-lg-offset-2">
                        <div class="no-results not-found">
                            <div class="error-404 not-found text-center">
                                <img src="<?=get_stylesheet_directory_uri()?>/assets/img/404.png" alt="404">
                                <h1 class="text-center section-title" >Данная страница не существует</h1>
                                <div class="page-content">
                                    <p class="description">Извините, но запрошенная вами страница не существует. Для того чтобы найти  интересующую вас информацию, воспользуйтесь строкой поиска. </p>
                                    <?php
                                   /* if(is_woocommerce()) {
                                        get_product_search_form();
                                    } else {
                                        get_search_form();
                                    }
                                   */ ?>
                                    <form role="search" class="search-form" method="get" action="<?=esc_url( home_url( '/' ) )?>" >
                                        <!--
                                            <a class="search-close pull-right"><i class="fa fa-times-circle"></i></a>
                                            -->
                                        <div class="search-input-box pull-left">
                                            <input type="search" name="s" value="<?=get_search_query()?>" placeholder="Искать">
                                            <button class="search-btn-inner" type="submit">Найти</button>
                                        </div>
                                        <!--<input type="hidden" name="post_type" value="product" />-->
                                    </form>
                                    <?php
                                    /*
                                    echo '<section aria-label="' . esc_html__( 'Search', 'storefront' ) . '">';

                                    if ( storefront_is_woocommerce_activated() ) {
                                        the_widget( 'WC_Widget_Product_Search' );
                                    } else {
                                        get_search_form();
                                    }

                                    echo '</section>';

                                    if ( storefront_is_woocommerce_activated() ) {

                                        echo '<div class="fourohfour-columns-2">';

                                        echo '<section class="col-1" aria-label="' . esc_html__( 'Promoted Products', 'storefront' ) . '">';

                                        storefront_promoted_products();

                                        echo '</section>';

                                        echo '<nav class="col-2" aria-label="' . esc_html__( 'Product Categories', 'storefront' ) . '">';

                                        echo '<h2>' . esc_html__( 'Product Categories', 'storefront' ) . '</h2>';

                                        the_widget(
                                            'WC_Widget_Product_Categories', array(
                                                'count' => 1,
                                            )
                                        );

                                        echo '</nav>';

                                        echo '</div>';

                                        echo '<section aria-label="' . esc_html__( 'Popular Products', 'storefront' ) . '">';

                                        echo '<h2>' . esc_html__( 'Popular Products', 'storefront' ) . '</h2>';

                                        $shortcode_content = storefront_do_shortcode(
                                            'best_selling_products', array(
                                                'per_page' => 4,
                                                'columns'  => 4,
                                            )
                                        );

                                        echo $shortcode_content; // WPCS: XSS ok.

                                        echo '</section>';
                                    }
                                    */
                                    //storefront_onsale_products_child($args);
                                   // storefront_popular_products_child($args);
                                    ?>
                                </div><!-- .page-content -->
                            </div><!-- .error-404 --><!-- .page-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
get_footer();