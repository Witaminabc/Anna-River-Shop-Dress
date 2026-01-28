<section class="rs-17">
	<div class="rs-text-block">
		<div class="container">
			<div class="row">
				<div class="col-xs-12" data-nekoanim="fadeInUp" data-nekodelay="200"> 
					<?php
						if (get_field('text_block_after_show')) {
							echo "<h2>".get_field('text_block_after_title')."</h2>";
							echo get_field('text_block_after');
						}
					?> 
				</div>
			</div>
		</div>
	</div>
</section>