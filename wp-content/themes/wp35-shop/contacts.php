<?php
	/**
	 * Template Name: Contacts
	 */

	get_header(); ?>

<div class="rs-child-tmpl">
<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				$notification_text = get_field("notification_text") ?: '';
				$notification_header = get_field("notification_header") ?: '';
				$map_script = get_field("map_script") ?: '';
				$is_contact_form_7 = get_field("is_contact_form_7") ?: '';
				?>
				<!-- rs-contacts -->
				<div class="rs-17">
					<div class="rs-contacts">
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<h1 class="text-center section-title" data-nekoanim="fadeInUp" data-nekodelay="50">
										<span class="section-title--text"><?php the_title() ?></span></h1>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<?php the_content() ?>
								</div>
								<!-- Сайт разработан в компании Россайт - rosait.ru -->
								<div class="col-xs-12 col-sm-6">
									<?php if (!$is_contact_form_7) : ?>
									<!--noindex-->
									<form action="#" method="post" class="form-horizontal contacts-form" id="contactsForm">
										<div class="row">
											<input type="hidden" name="phone">
											<div class="form-group col-xs-12 col-sm-12 col-md-6">
												<label for="contacts_name">Имя</label>
												<input type="text" class="form-control" name="contacts_name"
													   id="contacts_name" placeholder="Введите ваше имя">
											</div>
											<div class="form-group col-xs-12 col-sm-12 col-md-6">
												<label for="contacts_phone">Телефон</label>
												<input type="tel" class="form-control" name="contacts_phone"
													   id="contacts_phone" placeholder="Введите ваш телефон">
											</div>
										</div>
										<div class="form-group">
											<label for="contacts_email">E-mail</label>
											<input type="email" class="form-control" name="contacts_email"
												   id="contacts_email" placeholder="Введите ваш E-mail">
										</div>
										<div class="form-group">
											<label for="contacts_message">Сообщение</label>
											<textarea class="form-control" rows="5" name="contacts_message" id="contacts_message"
													  placeholder="Введите ваше сообщение"></textarea>
										</div>
										<div class="checkbox form-group">
											<label class="form-checkbox">
												 Нажимая на кнопку «Отправить сообщение», вы соглашаетесь на обработку персональных данных в соответствии с
												 <a href="#" class="checkbox-label" data-target="#agreement" data-toggle="modal">пользовательским соглашением</a>
											</label>
										</div>
										<div class="form-group">
											<button type="submit" id="contactsFormBtn" class="btn btn-color modal-btn">Отправить сообщение <i
													class="fa fa-arrow-right"></i></button>
										</div>
										<p class="success text-center"></p>
									</form>
									<!--/noindex-->
									<?php else : ?>
                                        <?php echo do_shortcode(get_field("contact_form_7")); ?>
									<?php endif ?>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 contacts-map">
									<?php
                                    echo $map_script; 
                                    ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- ./rs-contacts -->

			<? endwhile;
		?>

	</main><!-- .site-main -->
</div><!-- .content-area -->
</div>

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

<?php get_footer(); ?>