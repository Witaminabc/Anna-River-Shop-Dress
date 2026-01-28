<?php
// Подключить стили для страницы Все блоки
add_action( 'wp_enqueue_scripts', 'style_rs_page_allblocks_theme', 11);
function style_rs_page_allblocks_theme() {
	wp_enqueue_style( 'rs-page-allblocks', get_stylesheet_directory_uri().'/template-parts/rs-page-allblocks/css/rs-page-allblocks.css');
}