<footer class="rs-17">
	<div class="rs-footer">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-4 footer-block">
					<?php if (is_active_sidebar( 'footer-left' )) dynamic_sidebar( 'footer-left'); ?>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-lg-offset-1 footer-block">
					<?php if (is_active_sidebar( 'footer-left-center' )) dynamic_sidebar( 'footer-left-center'); ?>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-2 footer-block">
					<?php if (is_active_sidebar( 'footer-right-center' )) dynamic_sidebar( 'footer-right-center'); ?>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 footer-block">
					<?php if (is_active_sidebar( 'footer-right' )) dynamic_sidebar( 'footer-right'); ?>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php if (is_active_sidebar( 'bottom' )) dynamic_sidebar( 'bottom'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- /.rs-footer -->