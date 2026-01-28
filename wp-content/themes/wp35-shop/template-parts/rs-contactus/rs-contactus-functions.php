<?php
function style_rs_contactus_theme() {
    wp_enqueue_style( 'rs-contactus-theme', get_stylesheet_directory_uri().'/template-parts/rs-contactus/css/rs-contactus.css');
}
function storefront_rs_contactus() {
	$query = new WP_Query( array (
		'post_type' => 'custom_block',
		'meta_query' => array ( 
			'relation' => 'OR', 
			array (
				'key'     => 'block_id',
				'value'   => 12, // id блока
				'compare' => '=' 
			)
		)
	));
	while ( $query->have_posts() ) {
		$query->the_post();
		$post_meta = get_post_meta($query->post->ID);
	}
	if ($post_meta) {
        $bg_img = get_field('bg_img')?: false;
        if ($bg_img) {
            $url = $bg_img['url'];
            $attachment_id = attachment_url_to_postid($url);
            $srcm = wp_get_attachment_image_url($attachment_id, 'medium_large');
            $src = wp_get_attachment_image_url($attachment_id, 'large');
            $srcF = wp_get_attachment_image_url($attachment_id, 'full');
        }
		$notification_header = get_field("notification_header") ?: '';
		$notification_text = get_field("notification_text") ?: '';
		$title = get_field("title") ?: '';
		$description = get_field("description") ?: '';
		$is_contact_form_7 = get_field("is_contact_form_7") ?: '';
        add_action( 'wp_print_scripts', 'style_rs_contactus_theme', 12);
    }
?>
<section class="rs-17">
	<div class="rs-contactus <?if ($bg_img) {?> b-lazy <?}?>" id="block-feedback"  <?if ($bg_img) {?> data-src="<?=$srcF?>" data-medium="<?=$src?>" data-small="<?=$srcm?>" style="background-size: cover;"<?}?>>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h2 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="100"><?=$title; ?></h2>
					<div class="section-descr" data-nekoanim="fadeInUp" data-nekodelay="200">
						<?=$description; ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
					<!--noindex-->
					<?php if (!$is_contact_form_7) : ?>
					<form id="formMain" action="#" method="post" class="contact-form">
						<input type="hidden" name="phone">
						<div class="form-group" data-nekoanim="fadeInLeft" data-nekodelay="200">
							<input type="text" class="form-control" id="form_name" name="form_name" placeholder="Ваше имя">
						</div>
						<div class="form-group" data-nekoanim="fadeInRight" data-nekodelay="400">
							<input type="email" class="form-control" id="form_email" name="form_email" placeholder="Email">
						</div>
						<div class="form-group" data-nekoanim="fadeInLeft" data-nekodelay="600">
							<input type="tel" class="form-control" id="form_phone" name="form_phone" placeholder="Телефон">
						</div>
						<div class="form-group" data-nekoanim="fadeInRight" data-nekodelay="800">
							<textarea rows="6" class="form-control" id="form_message" name="form_message" placeholder="Ваше сообщение"></textarea>
						</div>
						<div class="checkbox" data-nekoanim="fadeInUp" data-nekodelay="900">
							<label class="checkbox-label">
								Нажимая на кнопку «Отправить сообщение», вы соглашаетесь на обработку персональных данных в соответствии с <a href="#" data-target="#agreement-contactus" data-toggle="modal">пользовательским соглашением</a>
							</label>
						</div>
						<button type="submit" id="formMainBtn" class="btn btn-color btn-form modal-btn">Отправить сообщение</button>
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
		<div class="modal fade" tabindex="-1" id="agreement-contactus">
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

<?php
wp_reset_query();	
}