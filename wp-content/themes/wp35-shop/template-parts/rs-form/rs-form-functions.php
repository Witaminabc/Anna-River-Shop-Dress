<?php
function style_rs_form_theme() {
    wp_enqueue_style( 'rs-form-theme', get_stylesheet_directory_uri().'/template-parts/rs-form/css/rs-form.css');
}
function storefront_rs_form_child() {
    // Подключение стилей
    add_action( 'wp_print_scripts', 'style_rs_form_theme', 18);
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 3, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
        $bg_img = get_field('img')?: false;
        if ($bg_img) {
            $url = $bg_img;//$bg_img['url'];
            $attachment_id = attachment_url_to_postid($url);
            $srcm = wp_get_attachment_image_url($attachment_id, 'medium_large');
            $src = wp_get_attachment_image_url($attachment_id, 'large');
            $srcF = wp_get_attachment_image_url($attachment_id, 'full');
        }
		$notification_header = get_field("notification_header");
		$notification_text = get_field("notification_text");
		$title = get_field("title");
		$is_contact_form_7 = get_field("is_contact_form_7") ?: '';
	}
?>
<section class="rs-17">
	<div class="rs-form <?if ($bg_img) {?> b-lazy <?}?>" <?if ($bg_img) {?> data-src="<?=$srcF?>" data-medium="<?=$src?>" data-small="<?=$srcm?>" style="background-size: cover;"<?}?>>
		<div class="container">
			<div class="row form-row">
				<div class="col-xs-12 col-sm-3 form-title">
					<h4><?= $title ?></h4>
				</div>
				<div class="col-xs-12 col-sm-9">
					<!--noindex-->
					<?php if (!$is_contact_form_7) : ?>
					<form method="post" action="#" class="form-inline" id="contact-form">
						<input type="hidden" name="phone">
						<div class="col-sm-12 col-md-9 col-lg-left no-padding clearfix">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Ваше имя" id="contact_name_author" name="contact_name_author">
							</div>
							<div class="form-group">
								<input type="email" class="form-control" placeholder="E-mail" id="contact_email_author" name="contact_email_author">
							</div>
							<div class="form-group">
								<input type="tel" class="form-control" placeholder="Телефон" id="contact_phone_author" name="contact_phone_author">
							</div>
						</div>
						<div class="col-sm-12 col-md-3 col-lg-right no-padding">
							<button type="submit" id="contactFormBtn" class="btn form-button modal-btn">Оставить заявку</button>
						</div>
						<div class="clearfix"></div>
						<div class="checkbox form-group">
							<label class="form-checkbox">
								 Нажимая на кнопку «Оставить заявку», вы соглашаетесь на обработку персональных данных в соответствии с
								 <a href="#" class="checkbox-label" data-target="#agreement" data-toggle="modal">пользовательским соглашением</a>
							</label>
						</div>
						<p class="success text-center"></p>
					</form>
					<?php else : ?>
						<?php echo do_shortcode(get_field("contact_form_7")); ?>
					<?php endif ?>					
					<!--/noindex-->
				</div>
			</div>
		</div>
	</div>
</section>
<div class="rs-17">
	<div class="rs-modal">
		<div class="modal fade" tabindex="-1" id="agreement">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="modal-title"><?=$notification_header; ?></div>
					</div>
					<div class="modal-body">
						<?=$notification_text; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.rs-form -->	
<?php
//Сброс данных запроса
wp_reset_query();	
}