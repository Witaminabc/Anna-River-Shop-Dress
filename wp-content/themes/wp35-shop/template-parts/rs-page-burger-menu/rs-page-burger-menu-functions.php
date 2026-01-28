<?php
// Рендер кнопки меню
function rs_burger_block() {
	?>
		<div class="burger-menu-key pull-right" data-toggle="modal" data-target="#burgerMenuModal">
            <span class="line-1"></span>
            <span class="line-2"></span>
            <span class="line-3"></span>
        </div>
	<?php
}

// Рендер модального окна
function rs_modal_sidemenu() {
	?>
	<div class="modal right fade" id="burgerMenuModal" tabindex="-1" role="dialog">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
	        	<div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                		<span aria-hidden="true"><i class="fa fa-times fa-lg" aria-hidden="true"></i></span>
                	</button>
                	<h2 class="modal-title" id="myModalLabel2">
                		<?=get_custom_logo(); ?>

                	</h2>
            	</div>
            	<div class="modal-body">
            		<?php dynamic_sidebar( 'burger' ); ?>
            	</div>
	        </div>
		</div>
	</div>
	<?php
}

// Регистрация места для виджета
add_action('after_setup_theme', 'burger_menu_widget');
function burger_menu_widget() {
   register_sidebar(array(
      'name'          => 'Бургер меню',
      'id'            => 'burger',
      'description'   => 'Добавьте сюда виджет для размещения в бургер-меню',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '',
      'after_title'   => '',
   )); 
}