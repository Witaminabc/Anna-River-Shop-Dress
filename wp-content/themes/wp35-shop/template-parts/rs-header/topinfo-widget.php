<?php
function topinfo_widget() {
	register_widget( 'topinfo_widget' );
}

add_action( 'widgets_init', 'topinfo_widget' );

class topinfo_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// widget ID
		'topinfo_widget',
		// widget name
		'Контакты в топе',
		//__('Contact data', 'twentyfifteen'),
		// widget description
		array( 'description' => 'Виджет для размещения контактных данных в топе сайта', )
		);
	}
	public function widget( $args, $instance ) {
		$address = $instance['address'];
		$email = $instance['email'];
		$phone = $instance['phone'];
		
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		echo $args['before_widget'];

		?>
			<div class="pull-left hidden-xs">
				<div class="address-block">
					<i class="fa fa-home"></i><?=$address ?>
				</div>
			</div>
			<div class="pull-right">
				<ul class="contacts-block pull-left">
					<li><a href="mailto:<?=$email ?>"><i class="fa fa-envelope"></i><span class="hidden-xs"><?=$email ?></span></a></li>
					<li><a href="tel:<?= preg_replace('/[^0-9\+]+/', '', $phone) ?>"><i class="fa fa-phone"></i><span class="hidden-xs"><?=$phone ?></span></a></li>
					<!--
						<li><a href="mailto:mail@mail"><i class="fa fa-envelope"></i><span class="hidden-xs">email@email.ru</a></li> 
					-->
				</ul>
				<div class="search-block pull-right hidden-xs">
					<button class="btn search-btn" type="button"><i class="fa fa-search"></i></button>
				</div>
			</div>			

		<?php
		echo $args['after_widget'];
	}
	public function form( $instance ) {
		if ( isset( $instance[ 'address' ] ) ) $address = $instance[ 'address' ]; else $address = 'Адрес организации';
		if ( isset( $instance[ 'email' ] ) ) $email = $instance[ 'email' ]; else $email = '';
		if ( isset( $instance[ 'phone' ] ) ) $phone = $instance[ 'phone' ]; else $phone = '';
										
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Адрес организации:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo esc_attr( $address ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'E-mail' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Основной телефон' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>" />
			</p>
																							
		<?php 
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['address'] = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : ''; 
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : ''; 
		$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? strip_tags( $new_instance['phone'] ) : ''; 
		
		return $instance;
	}

}