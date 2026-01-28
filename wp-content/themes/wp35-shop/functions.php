<?php
include("spacefix.php");//для карты сайта
//Disable Pingback
function wpschool_remove_pingback_header( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
}
function wpschool_remove_x_pingback_headers( $headers ) {
    if ( function_exists( 'header_remove' ) ) {
        header_remove( 'X-Pingback' );
        header_remove( 'Server' );
    }
}
function wpschool_block_xmlrpc_attacks( $methods ) {
    unset( $methods['pingback.ping'] );
    unset( $methods['pingback.extensions.getPingbacks'] );
    return $methods;
}
add_filter( 'wp_headers', 'wpschool_remove_pingback_header' );
add_filter( 'template_redirect', 'wpschool_remove_x_pingback_headers' );
add_filter( 'xmlrpc_methods', 'wpschool_block_xmlrpc_attacks' );
add_filter( 'xmlrpc_enabled','__return_false' );

//Disable XML-RPC RSD link from WordPress Header
remove_action ('wp_head', 'rsd_link');

//Remove WordPress version number
add_filter ( 'the_generator' ,  '__return_false' );

//Remove wlwmanifest link
remove_action( 'wp_head', 'wlwmanifest_link');

//Remove shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head');

//Remove api.w.org relation link
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('template_redirect', 'rest_output_link_header', 11, 0);

// отключение типовых скриптов Woo и Storefront
add_action( 'wp_print_scripts', 'rs_dequeue_script', 100 );
function rs_dequeue_script() {
	if ( function_exists( 'is_woocommerce' ) ) {
		wp_dequeue_script( 'storefront-header-cart' );
		wp_dequeue_style( 'storefront-icons' );
	}
    wp_dequeue_style('yandex-money-checkout');
}

add_action( 'wp_print_styles', 'rs_dequeue_styles', 100 );
function rs_dequeue_styles() {
    if(!is_admin()) {
        wp_dequeue_style('storefront-style');
        wp_deregister_style('storefront-style');
        wp_dequeue_style('storefront-style-inline');
        wp_deregister_style('storefront-woocommerce');
        wp_deregister_style('storefront-woocommerce-inline');
        wp_dequeue_style('storefront-woocommerce-style-inline');
    }
}
if(!is_admin()) {
    add_filter('storefront_customizer_woocommerce_css', '__return_false');
    add_filter('storefront_customizer_css', '__return_false');
// Disable Gutenberg editor.
    add_filter('use_block_editor_for_post_type', '__return_false', 10);
}
// Don't load Gutenberg-related stylesheets.
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );
function remove_block_css() {
    if(!is_admin()) {
        wp_dequeue_style('wp-block-library'); // Wordpress core
        wp_dequeue_style('wp-block-library-theme'); // Wordpress core
        wp_dequeue_style('wc-block-style'); // WooCommerce
        wp_dequeue_style('storefront-gutenberg-blocks'); // Storefront theme
        wp_dequeue_style('storefront-gutenberg-blocks-inline');
        wp_dequeue_style('woocommerce-inline');
        wp_dequeue_style('storefront-fonts');
        wp_dequeue_style('storefront-icons');
        wp_dequeue_style('storefront-style');
        wp_dequeue_style('storefront-woocommerce');
        wp_dequeue_style('storefront-woocommerce-inline');
        wp_dequeue_style('storefront-woocommerce-style-inline');
    }
}

// Подключение глобальных стилей
add_action( 'wp_enqueue_scripts', 'style_theme');
function style_theme() {
    wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri().'/assets/css/bootstrap.min.css');
    wp_enqueue_style( 'icons', get_stylesheet_directory_uri().'/assets/css/icons.css'); //Font Awesome Free 5.0.9
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri().'/assets/css/font-awesome.min.css'); // Font Awesome 4.7.0
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri().'/assets/css/slick.css');
    wp_enqueue_style( 'main', get_stylesheet_directory_uri().'/assets/css/style.css');
    wp_enqueue_style( 'owl-carousel', get_stylesheet_directory_uri().'/assets/css/owl.carousel.min.css');
    wp_enqueue_style( 'jquery-fancybox', get_stylesheet_directory_uri().'/assets/css/jquery.fancybox.min.css');
    wp_enqueue_style( 'jquery-mCustomScrollbar', get_stylesheet_directory_uri().'/assets/css/jquery.mCustomScrollbar.min.css');
    wp_enqueue_style( 'select2', get_stylesheet_directory_uri().'/assets/css/select.min.css');
    wp_enqueue_style( 'opensans', get_stylesheet_directory_uri().'/assets/fonts/opensans/stylesheet.css');
    wp_enqueue_style( 'nekoanim', get_stylesheet_directory_uri().'/assets/css/nekoanim.css');
    wp_enqueue_style( 'animate', get_stylesheet_directory_uri().'/assets/css/animate.min.css');
}

// Подключение глобальных скриптов
add_action( 'wp_footer', 'scripts_child_theme', 10);
function scripts_child_theme() {
	// отключение типовых скриптов Woo
	if ( function_exists( 'is_woocommerce' ) ) {
	    if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
	        wp_dequeue_script( 'storefront-header-cart' );
	        wp_dequeue_style( 'woocommerce_frontend_styles' );
	        wp_dequeue_style( 'woocommerce_fancybox_styles' );
	        wp_dequeue_style( 'woocommerce_chosen_styles' );
	        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	        //wp_dequeue_script( 'wc_price_slider' );
	        //wp_dequeue_script( 'wc-single-product' );
	        //wp_dequeue_script( 'wc-add-to-cart' );
	        //wp_dequeue_script( 'wc-cart-fragments' );
	        //wp_dequeue_script( 'wc-checkout' );
	        //wp_dequeue_script( 'wc-add-to-cart-variation' );
	        //wp_dequeue_script( 'wc-single-product' );
	        //wp_dequeue_script( 'wc-cart' );
	        //wp_dequeue_script( 'wc-chosen' );
	        //wp_dequeue_script( 'woocommerce' );
	        wp_dequeue_script( 'prettyPhoto' );
	        wp_dequeue_script( 'prettyPhoto-init' );
	        wp_dequeue_script( 'jquery-blockui' );
	        wp_dequeue_script( 'jquery-placeholder' );
	        wp_dequeue_script( 'fancybox' );
	        wp_dequeue_script( 'jqueryui' );
	    }
	}
    wp_enqueue_script( 'jquery321min', get_stylesheet_directory_uri() . '/assets/js/jquery-3.2.1.min.js');
	wp_enqueue_script( 'jquery-cookie', get_stylesheet_directory_uri() . '/assets/js/jquery.cookie.min.js');
    wp_enqueue_script( 'bootstrap-min', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery321min'));
	wp_enqueue_script( 'jquery-mCustomScrollbar', get_stylesheet_directory_uri() . '/assets/js/jquery.mCustomScrollbar.concat.min.js', array('jquery321min','bootstrap-min'));
	wp_enqueue_script( 'owl-carousel', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery321min'));
	wp_enqueue_script( 'mousewheel', get_stylesheet_directory_uri() . '/assets/js/jquery.mousewheel.min.js', array('jquery321min'));
	wp_enqueue_script( 'jquery-easing', get_stylesheet_directory_uri() . '/assets/js/jquery.easing.1.3.js', array('jquery321min'));
	wp_enqueue_script( 'slider-slick', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array('jquery321min'));
	wp_enqueue_script( 'jquery-appear', get_stylesheet_directory_uri() . '/assets/js/jquery.appear.js', array('jquery321min'));
	wp_enqueue_script( 'jquery-validate', get_stylesheet_directory_uri() . '/assets/js/jquery.validate.min.js', array('jquery321min'));
	wp_enqueue_script( 'jquery-counterup', get_stylesheet_directory_uri() . '/assets/js/jquery.counterup.min.js', array('jquery321min'));
	wp_enqueue_script( 'jquery-waypoints', get_stylesheet_directory_uri() . '/assets/js/jquery.waypoints.min.js', array('jquery321min'));
	wp_enqueue_script( 'jquery-maskedinput', get_stylesheet_directory_uri() . '/assets/js/jquery.maskedinput.min.js', array('jquery321min'));
    wp_enqueue_script( 'jquery-fancybox', get_stylesheet_directory_uri() . '/assets/js/jquery.fancybox.min.js', array('jquery321min'));
	wp_enqueue_script( 'main-javascript', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery321min', 'owl-carousel', 'slider-slick', 'jquery-validate', 'jquery-counterup','jquery-mCustomScrollbar'));
}

function rs_add_defer_attribute( $tag, $handle ) {
    $handles = array(
        'jquery321min',
        'jquery-cookie',
        'bootstrap-min',
        'jquery-mCustomScrollbar',
        'owl-carousel',
        'mousewheel',
        'jquery-easing',
        'slider-slick',
        'jquery-appear',
        'jquery-validate',
        'jquery-maskedinput',
        'jquery-fancybox',
        'main-javascript',
    );
    foreach( $handles as $defer_script) {
        if ( $defer_script === $handle ) {
            return str_replace( ' src', ' defer="defer" src', $tag );
        }
    }
    return $tag;
}
//add_filter( 'script_loader_tag', 'rs_add_defer_attribute', 10, 2 );

if(!is_admin()){
    remove_action('wp_head', 'wp_print_scripts');
   // remove_action('wp_head', 'wp_print_head_scripts', 9);
    // remove_action('wp_head', 'wp_enqueue_scripts', 1);
    //add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_scripts', 5);
    //add_action('wp_footer', 'wp_print_head_scripts', 9);
}

//add_action('wp_loaded', 'output_buffer_start');
function output_buffer_start() { 
    ob_start("output_callback"); 
}

//add_action('shutdown', 'output_buffer_end');
function output_buffer_end() { 
    ob_end_flush(); 
}

function output_callback($tag) {
    return preg_replace( "%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", '', $tag);
}

// Подключение обработчика отправки форм
require 'inc/common.php';

// Подключение библиотеки обработки миниатюр
//require 'inc/BFI_Thumb.php';

// Подключение обработчика дополнительных типов записей
require 'inc/post-types.php';

// Подключение сервисных функций 
require 'inc/services-functions.php';

// Подключение функций Woo дочерней темы
if ( function_exists( 'is_woocommerce' ) ) {
	require 'woocommerce/wc-functions.php';	
}

// Подключение функционала для хедера
require 'template-parts/rs-header/rs-header-functions.php';

// Подключение функционала для текстовых блоков
require 'template-parts/rs-text-block/rs-text-block-functions.php';

// Подключение функционала для блока Преимущества
require 'template-parts/rs-features/rs-features-functions.php';

// Подключение функционала для блока Преимущества 3 колонки
require 'template-parts/rs-features-3x/rs-features-3x-functions.php';

// Подключение функционала для блока Каталог
require 'template-parts/rs-services/rs-services-functions.php';

// Подключение функционала для слайдера
require 'template-parts/rs-slider/rs-slider-functions.php';

// Подключение функционала для блока Самые продаваемые
require 'template-parts/rs-best-sellers/rs-best-sellers-functions.php';

// Подключение функционала для блока Популярные
require 'template-parts/rs-popular/rs-popular-functions.php';

// Подключение функционала для блока Распродажа
require 'template-parts/rs-onsale/rs-onsale-functions.php';

// Подключение функционала для блока Новинки
require 'template-parts/rs-new-products/rs-new-products-functions.php';

// Подключение функционала для формы обратной связи
require 'template-parts/rs-form/rs-form-functions.php';

// Подключение функционала для блока Отзывы
require 'template-parts/rs-reviews/rs-reviews-functions.php';

// Подключение функционала для блока Новости
require 'template-parts/rs-news/rs-news-functions.php';

// Подключение функционала для блока Наша команда
require 'template-parts/rs-team/rs-team-functions.php';

// Подключение функционала для блока Как мы работаем
require 'template-parts/rs-howworks/rs-howworks-functions.php';

// Подключение функционала для блока Предложения
require 'template-parts/rs-offers/rs-offers-functions.php';

// Подключение функционала для блока Преимущества с картинкой
require 'template-parts/rs-features-photo/rs-features-photo-functions.php';

// Подключение функционала для блока Цифры
require 'template-parts/rs-numbers/rs-numbers-functions.php';

// Подключение функционала для блока Свяжитесь с нами
require 'template-parts/rs-contactus/rs-contactus-functions.php';

// Подключение функционала для блока Цитата
require 'template-parts/rs-parallax-land/rs-parallax-land-functions.php';

// Подключение функционала для блока Партнёры
require 'template-parts/rs-partners/rs-partners-functions.php';

// Подключение функционала для блока Видео
require 'template-parts/rs-video/rs-video-functions.php';

// Подключение функционала для блока Тарифы
require 'template-parts/rs-price/rs-price-functions.php';

// Подключение функционала для блока Таймер
require 'template-parts/rs-counter/rs-counter-functions.php';

// Подключение функционала для блока Подписаться
require 'template-parts/rs-subscribe/rs-subscribe-functions.php';

// Подключение функционала для блока Фотогалерея
require 'template-parts/rs-photogallery/rs-photogallery-functions.php';

// Подключение функционала для блока Видеоролики
require 'template-parts/rs-video-new/rs-video-new-functions.php';

// Подключение функционала для страницы Галерея
require 'template-parts/rs-gallery/rs-gallery-functions.php';

// Подключение функционала для блока с переключателями
require 'template-parts/rs-tabs/rs-tabs-functions.php';

// Подключение функционала для блока Параллакс 1
require 'template-parts/rs-parallax-1/rs-parallax-1-functions.php';

// Подключение функционала для блока Параллакс 2
require 'template-parts/rs-parallax-2/rs-parallax-2-functions.php';

// Подключение функционала для блока Иконки с услугами
require 'template-parts/rs-services-icon/rs-services-icon-functions.php';

// Подключение функционала для блока Форма ОС с картнкой
require 'template-parts/rs-contact-land/rs-contact-land-functions.php';

// Подключение функционала для блока Рекоммендации
require 'template-parts/rs-recommendations/rs-recommendations-functions.php';

// Подключение функционала для блока наши проекты
require 'template-parts/rs-portfolio-slider/rs-portfolio-slider-functions.php';

// Подключение функционала для блока карусель фотографий
require 'template-parts/rs-carousel/rs-carousel-functions.php';

// Подключение функционала для футера
require 'template-parts/rs-footer/rs-footer-functions.php';



add_action( 'template_redirect', 'rs_get_tpl_include' );
function rs_get_tpl_include(){
    $get_template = get_page_template_slug( get_the_ID());
    if($get_template =='template-allblocks.php'){
        $file_path = locate_template( $get_template );
        // Подключение функционала для шаблона страницы Все блоки
        require 'template-parts/rs-page-allblocks/rs-page-allblocks-functions.php';
    } else if ($get_template =='contacts.php'){
        // Подключение функционала для шаблона страницы контакты
        require 'template-parts/rs-page-contacts/rs-page-contacts-functions.php';
    } else if ($get_template =='template-burger') {
        // Подключение функционала для шаблона страницы бургер-меню
        require 'template-parts/rs-page-burger-menu/rs-page-burger-menu-functions.php';
    } else {


    }
    // Подключение функционала для шаблона основной страницы
    require 'template-parts/rs-page-base/rs-page-base-functions.php';
}

//Вывод вспомогательной информации в администраторе #0.23
add_action('wp_dashboard_setup', 'blogood_ru_help_widgets');
 
function blogood_ru_help_widgets() {
global $wp_meta_boxes;
 
wp_add_dashboard_widget(
'help_widget', //Слаг виджета
'Добро пожаловать в РСУ', //Заголовок виджета
'help' //Функция вывода
);
}
 
function help() {
echo '<p><a href="https://rosait.ru/wordpress-instruktsiya/" target="_blank">Руководство по работе</a> с системой управления WordPress</p>';
echo '<p>Техническая поддержка: support@rosait.ru<p>';
echo '<p>Отдел продаж: +7 (800) 222-90-72 по всей России (бесплатно)<p>';
echo '<hr/><p>РСУ - Россайт Система управления для Wordpress</p>';
}