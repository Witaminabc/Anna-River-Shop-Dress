<?php 

// Регистрация стиля для темы
add_action( 'wp_enqueue_scripts', 'style_rs_footer_theme');
function style_rs_footer_theme() {
	wp_enqueue_style( 'rs-footer', get_stylesheet_directory_uri().'/template-parts/rs-footer/css/rs-footer.css');
}

// Отмена регистрации виджетов подвала родительской темы
function remove_some_widgets(){
   unregister_sidebar( 'footer-1' );
   unregister_sidebar( 'footer-2' );
   unregister_sidebar( 'footer-3' );
   unregister_sidebar( 'footer-4' );
}
add_action( 'widgets_init', 'remove_some_widgets', 11 );

function delete_footer() {
   //remove_action('storefront_footer', 'storefront_footer_widgets', 10);
   remove_action('storefront_footer', 'storefront_credit', 20);
}
add_action( 'init', 'delete_footer', 1);

add_action('after_setup_theme', 'footer_widgets_setup');
function footer_widgets_setup() {

   register_sidebar(array(
      'name'          => 'Подвал Столбец 1',
      'id'            => 'footer-left',
      'description'   => 'Добавьте сюда виджеты, которые хотите разместить в подвале сайта слева',
      'before_widget' => '<div class="info-list">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
   ));   
   register_sidebar(array(
      'name'          => 'Подвал Столбец 2',
      'id'            => 'footer-left-center',
      'description'   => 'Добавьте сюда виджеты, которые хотите разместить в подвале сайта в центре-слева',
      'before_widget' => '<div class="info-list">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
   ));   
   register_sidebar(array(
      'name'          => 'Подвал Столбец 3',
      'id'            => 'footer-right-center',
      'description'   => 'Добавьте сюда виджеты, которые хотите разместить в подвале сайта в центре-справа',
      'before_widget' => '<div class="info-list">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
   ));
   register_sidebar(array(
      'name'          => 'Подвал Столбец 4',
      'id'            => 'footer-right',
      'description'   => 'Добавьте сюда виджеты, которые хотите разместить в подвале сайта справа',
      'before_widget' => '<div class="info-list">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4>',
      'after_title'   => '</h4>',
   )); 
   register_sidebar(array(
      'name'          => 'Нижняя часть сайта',
      'id'            => 'bottom',
      'description'   => 'Место для размещения копирайтов и меню соцсетей',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '',
      'after_title'   => '',
   ));           
}

// добавление виджета Контакты
include('contact-data-widget.php');

// добавление виджета Копирайты и соцсети
include('bottom-data-widget.php');