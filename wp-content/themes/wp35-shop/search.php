<?php
/**
 * The template for displaying search results pages.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area rs-17">
		<main id="main" class="site-main">
		
			<div class="container rs-page-inner page-search">
			<?php if ( have_posts() ) :
               rs_woocommerce_breadcrumb();
                ?>
				<header class="page-header">
					<h1 class="page-title">
						<?php
							/* translators: %s: search term */
							printf( esc_attr__( 'Search Results for: %s', 'storefront' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
				</header><!-- .page-header -->

                <?php
                    while (have_posts()) : the_post();
                        $title = get_the_title();
                        $keys = explode(" ",$s);
                      //  $title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $title);
                        ?>
                        <div class="posts-search">
                            <h3 class="beta entry-title"><a rel="bookmark" href="<?php the_permalink() ?>"><?php echo $title; ?></a></h3>
                            <div class="entry-content">
                                <?php
                                if ( has_post_thumbnail() ) { ?>
                                <div class="pull-left img-responcive">
                                    <?php  the_post_thumbnail( 'thumbnail', array( 'itemprop' => 'image' ) ); ?>
                                </div>
                                <?php  }
                                $description = the_excerpt_max_charlength(strip_tags(preg_replace('~\[[^\]]+\]~', '',get_the_content())), 250);
                                echo $description;
                                        ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php
                else :
                    get_template_part( 'content', 'none' );
                endif;
                ?>

			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();