<?php
/*add_filter( 'document_title_parts', 'filter_function_name_2114' );
function filter_function_name_2114( $title ){
	//if( is_page('cart') )
		$title['title'] = 'Моя страница портфолио — Декстер Морган';

	return $title;
}*/
// Кастомизация заголовка
function storefront_page_header_child() {
	if ( is_front_page() ) {
		return;
	}
}