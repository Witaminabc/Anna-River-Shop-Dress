<?php

function gvalidate($param='token'){
	return true;
	$secretKey = '6LdZP1oUAAAAAERu4h8oA4VUMaU6WopwxW5uHb13';
    $response = $_POST[$param];     
    $remoteIp = $_SERVER['REMOTE_ADDR'];
 
    $reCaptchaValidationUrl = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response&remoteip=$remoteIp");
    $result = json_decode($reCaptchaValidationUrl, TRUE);
	return $result['success'] == 1;
}

if ( isset($_REQUEST[ 'modeJs' ]) &&  $_REQUEST[ 'modeJs' ] == 'contactForm' ) {

	if(!empty($_REQUEST[ 'phone' ])) exit;
	
	if(!gvalidate()){
		$result = array(
			'message' => 'Ошибка recaptcha',
			'status'  => FALSE 
		);
		echo json_encode($result);
		die();
	}
	
	if(!$_REQUEST['contact_name_author'] || !$_REQUEST['contact_phone_author'] || !$_REQUEST['contact_email_author']){
		$result = array(
			'message' => 'Не все поля заполнены', 
			'status'  => FALSE
		);
		echo json_encode($result);
		exit;
	}
	
	$text = '';
	$text .= '<p>Имя: ' . $_REQUEST[ 'contact_name_author' ] . '</p>';
	$text .= '<p>Телефон: ' . $_REQUEST[ 'contact_phone_author' ] . '</p>';
	$text .= '<p>Email: ' . $_REQUEST[ 'contact_email_author' ] . '</p>';
	
	$to = get_option('admin_email');
	$subject = 'Сообщение с контактной формы';
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".get_bloginfo('charset')."" . "\r\n";
	
	wp_mail( $to, $subject, $text, $headers );

	$result = array(
		'message' => 'Ваше сообщение успешно отправлено',
		'status'  => TRUE
	);
	
	echo json_encode($result);
	
	die;

}

if ( isset($_REQUEST[ 'modeJs' ]) && $_REQUEST[ 'modeJs' ] == 'contactFormMain' ) {
	if(!empty($_REQUEST[ 'phone' ])) exit;
	
	if(!gvalidate()){
		$result = array(
			'message' => 'Ошибка recaptcha',
			'status'  => FALSE 
		);
		echo json_encode($result);
		die();
	}
	
	if(!$_REQUEST['contacts_name'] || !$_REQUEST['contacts_phone'] || !$_REQUEST['contacts_email']){
		$result = array(
			'message' => 'Не все поля заполнены', 
			'status'  => FALSE
		);
		echo json_encode($result);
		exit;
	}
	
	$text = '';
	$text .= '<p>Имя: ' . $_REQUEST[ 'contacts_name' ] . '</p>';
	$text .= '<p>Телефон: ' . $_REQUEST[ 'contacts_phone' ] . '</p>';
	$text .= '<p>Email: ' . $_REQUEST[ 'contacts_email' ] . '</p>';
	$text .= '<p>Сообщение: ' . $_REQUEST[ 'contacts_message' ] . '</p>';
	
	$to = get_option('admin_email');
	$subject = 'Сообщение с контактной формы';
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".get_bloginfo('charset')."" . "\r\n";
	
	wp_mail( $to, $subject, $text, $headers );
	
	$result = array(
		'message' => 'Ваше сообщение успешно отправлено',
		'status'  => TRUE
	);

	echo json_encode($result);
	die;

}

if ( isset($_REQUEST[ 'modeJs' ]) && $_REQUEST[ 'modeJs' ] == 'formMain' ) {
	if(!empty($_REQUEST[ 'phone' ])) exit;
	
	if(!gvalidate()){
		$result = array(
			'message' => 'Ошибка recaptcha',
			'status'  => FALSE 
		);
		echo json_encode($result);
		die();
	}
	
	if(!$_REQUEST['form_name'] || !$_REQUEST['form_phone'] || !$_REQUEST['form_email']){
		$result = array(
			'message' => 'Не все поля заполнены', 
			'status'  => FALSE
		);
		echo json_encode($result);
		exit;
	}
	
	$text = '';
	$text .= '<p>Имя: ' . $_REQUEST[ 'form_name' ] . '</p>';
	$text .= '<p>Телефон: ' . $_REQUEST[ 'form_phone' ] . '</p>';
	$text .= '<p>Email: ' . $_REQUEST[ 'form_email' ] . '</p>';
	$text .= '<p>Сообщение: ' . $_REQUEST[ 'form_message' ] . '</p>';
	
	$to = get_option('admin_email');
	$subject = 'Сообщение с контактной формы';
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".get_bloginfo('charset')."" . "\r\n";
	
	wp_mail( $to, $subject, $text, $headers );
	
	$result = array(
		'message' => 'Ваше сообщение успешно отправлено',
		'status'  => TRUE
	);

	echo json_encode($result);
	die;

}

if ( isset($_REQUEST[ 'modeJs' ]) && $_REQUEST[ 'modeJs' ] == 'contactFormMainBanner3' ) {
	if(!empty($_REQUEST[ 'phone' ])) exit;
	if($_REQUEST[ 'valueF' ]!= 'dfsd3f') exit;
	
	if(!gvalidate()){
		$result = array(
			'message' => 'Ошибка recaptcha',
			'status'  => FALSE 
		);
		echo json_encode($result);
		die();
	}
	
	if(!$_REQUEST['name_author3'] || !$_REQUEST['phone_author3']){
		$result = array(
			'message' => 'Не все поля заполнены', 
			'status'  => FALSE
		);
		echo json_encode($result);
		exit;
	}
	
	$text = '';
	$text .= '<p>Имя: ' . $_REQUEST[ 'name_author3' ] . '</p>';
	$text .= '<p>Телефон: ' . $_REQUEST[ 'phone_author3' ] . '</p>';
	$text .= '<p>Сообщение: ' . $_REQUEST[ 'message_author3' ] . '</p>';
	
	$to = get_option('admin_email');
	$subject = 'Сообщение с контактной формы';
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".get_bloginfo('charset')."" . "\r\n";
	
	wp_mail( $to, $subject, $text, $headers );

	$result = array(
		'message' => 'Ваше сообщение успешно отправлено',
		'status'  => TRUE
	);

	echo json_encode($result);

	die();
}

if ( isset($_REQUEST[ 'modeJs' ]) && $_REQUEST[ 'modeJs' ] == 'subscribeForm' ) {
	if(!empty($_REQUEST[ 'phone' ])) exit;
	
	if(!gvalidate()){
		$result = array(
			'message' => 'Ошибка recaptcha',
			'status'  => FALSE 
		);
		echo json_encode($result);
		die();
	}
	
	if(!$_REQUEST['email_subscribe_author']){
		$result = array(
			'message' => 'Не все поля заполнены', 
			'status'  => FALSE
		);
		echo json_encode($result);
		exit;
	}
	
	$text = '';
	$text .= '<p>Email: ' . $_REQUEST[ 'email_subscribe_author' ] . '</p>';
	
	$to = get_option('admin_email');
	$subject = 'Сообщение с формы подписки';
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".get_bloginfo('charset')."" . "\r\n";
	
	wp_mail( $to, $subject, $text, $headers );

	$result = array(
		'message' => 'Ваше сообщение успешно отправлено',
		'status'  => TRUE
	);

	echo json_encode($result);

	die();
}