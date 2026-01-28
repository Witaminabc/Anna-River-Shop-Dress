<?php
/**
 * The template for displaying services pages.
 *
 * Template Name: Сервисные страницы
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area rs-17">
		<main id="main" class="site-main" >
            <div class="container rs-page-inner">
			<?php
			while ( have_posts() ) :
				the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop.
			?>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();