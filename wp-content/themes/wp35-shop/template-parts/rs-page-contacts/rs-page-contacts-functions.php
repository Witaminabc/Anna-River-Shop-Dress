<?php

add_action( 'wp_enqueue_scripts', 'style_rs_page_contacts_theme', 11);
function style_rs_page_contacts_theme() {
	wp_enqueue_style( 'rs-page-contacts', get_stylesheet_directory_uri().'/template-parts/rs-page-contacts/css/rs-page-contacts.css');
}