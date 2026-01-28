<?php
function contact_data_widget() {

	register_widget( 'contact_widget' );
}

add_action( 'widgets_init', 'contact_data_widget' );

class contact_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// widget ID
		'contact_widget',
		// widget name
		'Контактная информация',
		//__('Contact data', 'twentyfifteen'),
		// widget description
		array( 'description' => 'Виджет для размещения контактных данных', )
		//array( 'description' => __( 'Contact data widget', 'twentyfifteen' ), )
		);
	}
	public function widget( $args, $instance ) {
		//$title = apply_filters( 'widget_title', $instance['title'] );
        $title = $instance['title'];
		$phone_one = $instance['phone_one'];
		$phone_two = $instance['phone_two'];
		$email = $instance['email'];
		$work_time = $instance['work_time'];
		$addres = $instance['addres'];
		$skype = $instance['skype'];
		echo $args['before_widget'];
		//if title is present
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		//output
		?>
			<ul class="contacts-list">
				<?php if($phone_one) { ?>
					<li>
						<a href="tel:<?= preg_replace('/[^0-9\+]+/', '', $phone_one) ?>">
						<i class="fa fa-phone"></i>
						<span><?=$phone_one ?></span></a>
					</li>
				<?php } ?>
				<?php if($phone_two) { ?>
					<li>
						<a href="tel:<?= preg_replace('/[^0-9\+]+/', '', $phone_two) ?>">
						<i class="fa fa-phone"></i>
						<span><?=$phone_two ?></span></a>
					</li>
				<?php } ?>
				<?php if($email) { ?>
					<li>
						<a href="mailto:<?=$email ?>" class="link-underline">
						<i class="fa fa-envelope"></i>
						<span><?=$email ?></span></a>
					</li>
				<?php } ?>
				<?php if($skype) { ?>
					<li>
						<a href="skype:<?=$skype ?>?call">
						<i class="fa fa-skype"></i>
						<span><?=$skype ?></span></a>
					</li>
				<?php } ?>								
				<?php if($work_time) { ?>
					<li>
                        <i class="far fa-clock"></i>
						<span ><?=$work_time ?></span>
					</li>
				<?php } ?>
				<?php if($addres) { ?>
					<li>
						<i class="fa fa-home"></i>
						<span><?=$addres ?></span>
					</li>
				<?php } ?>				
			</ul>		
		<?php
		echo $args['after_widget'];
	}
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; else $title = 'Контактная информация';
		if ( isset( $instance[ 'phone_one' ] ) ) $phone_one = $instance[ 'phone_one' ]; else $phone_one = '';	
		if ( isset( $instance[ 'phone_two' ] ) ) $phone_two = $instance[ 'phone_two' ];	else $phone_two = '';
		if ( isset( $instance[ 'email' ] ) ) $email = $instance[ 'email' ];	else $email = '';
		if ( isset( $instance[ 'skype' ] ) ) $skype = $instance[ 'skype' ]; else $skype = '';			
		if ( isset( $instance[ 'work_time' ] ) ) $work_time = $instance[ 'work_time' ];	else $work_time = '';	
		if ( isset( $instance[ 'addres' ] ) ) $addres = $instance[ 'addres' ]; else $addres = '';														
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'phone_one' ); ?>"><?php _e( 'Телефон 1:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'phone_one' ); ?>" name="<?php echo $this->get_field_name( 'phone_one' ); ?>" type="text" value="<?php echo esc_attr( $phone_one); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'phone_two' ); ?>"><?php _e( 'Телефон 2:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'phone_two' ); ?>" name="<?php echo $this->get_field_name( 'phone_two' ); ?>" type="text" value="<?php echo esc_attr( $phone_two); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'E-mail:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e( 'Скайп:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" type="text" value="<?php echo esc_attr( $skype ); ?>" />
			</p>			
			<p>
				<label for="<?php echo $this->get_field_id( 'work_time' ); ?>"><?php _e( 'Время работы:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'work_time' ); ?>" name="<?php echo $this->get_field_name( 'work_time' ); ?>" type="text" value="<?php echo esc_attr( $work_time ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'addres' ); ?>"><?php _e( 'Адрес:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'addres' ); ?>" name="<?php echo $this->get_field_name( 'addres' ); ?>" type="text" value="<?php echo esc_attr( $addres ); ?>" />
			</p>															
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['phone_one'] = ( ! empty( $new_instance['phone_one'] ) ) ? strip_tags( $new_instance['phone_one'] ) : '';
		$instance['phone_two'] = ( ! empty( $new_instance['phone_two'] ) ) ? strip_tags( $new_instance['phone_two'] ) : '';
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';	
		$instance['skype'] = ( ! empty( $new_instance['skype'] ) ) ? strip_tags( $new_instance['skype'] ) : '';	
		$instance['work_time'] = ( ! empty( $new_instance['work_time'] ) ) ? strip_tags( $new_instance['work_time'] ) : '';	
		$instance['addres'] = ( ! empty( $new_instance['addres'] ) ) ? strip_tags( $new_instance['addres'] ) : '';					
		return $instance;
	}

}