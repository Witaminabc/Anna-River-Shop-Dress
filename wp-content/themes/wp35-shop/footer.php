<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */
?>
		</div><!-- .col-full -->
	</div><!-- #content -->
	<?php do_action( 'storefront_before_footer' ); ?>
			<?php
				do_action( 'storefront_footer' );
				// Подключение футера дочерней темы
				get_template_part('template-parts/rs-footer/rs-footer');
			?>
	<?php do_action( 'storefront_after_footer' ); ?>
</div><!-- #page -->
<div class="rs-17">
	<div class="rs-button-up" id="button-up"></div>
</div>
<?php wp_footer(); ?>
</body>
</html>