<?php
// Подключение стилей
add_action( 'wp_enqueue_scripts', 'style_rs_header_theme', 11 );
function style_rs_header_theme() {
	//wp_enqueue_style( 'top-header', get_stylesheet_directory_uri().'/template-parts/rs-header/css/rs-top-header.css');
	wp_enqueue_style( 'menu-cart', get_stylesheet_directory_uri().'/template-parts/rs-header/css/rs-menu-cart.css');
}

// Отключение лишних областей меню 
function wpse_remove_parent_theme_locations() {
    unregister_nav_menu('secondary');
}
add_action( 'after_setup_theme', 'wpse_remove_parent_theme_locations', 20 );

// Отключение блоков хедера родительской темы
function delete_storefront_header() {
	remove_action('storefront_header', 'storefront_header_container', 0);
	remove_action('storefront_header', 'storefront_skip_links', 5);
	remove_action('storefront_header', 'storefront_social_icons', 10);
	remove_action('storefront_header', 'storefront_site_branding', 20);
	remove_action('storefront_header', 'storefront_secondary_navigation', 30);
	remove_action('storefront_header', 'storefront_product_search', 40);
	remove_action('storefront_header', 'storefront_header_container_close', 41);
	remove_action('storefront_header', 'storefront_primary_navigation_wrapper', 42);
	remove_action('storefront_header', 'storefront_primary_navigation', 50);
	remove_action('storefront_header', 'storefront_header_cart', 60);
	remove_action('storefront_header', 'storefront_primary_navigation_wrapper_close', 68);
};
add_action( 'init', 'delete_storefront_header', 1);

// Добавление новых блоков для хедера
function add_storefront_header() {
   if(is_active_sidebar( 'top' )){
        add_action('storefront_header', 'storefront_header_top_info_child', 0);
    }
	add_action('storefront_header', 'storefront_primary_navigation_wrapper_child', 42);
	add_action('storefront_header', 'storefront_primary_navigation_logo_child', 45);
	add_action('storefront_header', 'storefront_primary_navigation_child', 50);
	add_action('storefront_header', 'storefront_header_cart_child', 60);
    add_action('storefront_header', 'rs_header_login', 61);
    add_action('storefront_header', 'rs_header_search', 62);
    add_action('storefront_header', 'rs_modal_form', 0);
	add_action('storefront_header', 'storefront_primary_navigation_wrapper_close_child', 68);
}
add_action( 'init', 'add_storefront_header', 2);

// Добавление виджета Топинфо
include('topinfo-widget.php');

// Регистрация места для виджета
add_action('after_setup_theme', 'top_widget_setup_child');
function top_widget_setup_child() {
   register_sidebar(array(
      'name'          => 'Топ сайта',
      'id'            => 'top',
      'description'   => 'Добавьте сюда виджет для размещения в топе сайта',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '',
      'after_title'   => '',
   )); 
}

// Функция вывода топ-блока
function storefront_header_top_info_child() {
	?>
	<!-- rs-top-header -->
	<div class="rs-17">
		<div class="rs-top-header">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<?php dynamic_sidebar( 'top'); ?>
						<div class="search-full">
							<?php 
								if(is_woocommerce()) {
									get_product_search_form();
								} else {
									get_search_form();
								}
							 ?>
						</div>
					</div>
				</div>
			</div>
		</div>					
	</div>
	<!-- /.rs-top-header -->
	<?php
}

// Переопределение формы поиска товаров 
function product_search_form_top_child( $form ) {
	$form = '
	<form role="search" class="search-form" method="get" action="' . esc_url( home_url( '/' ) ). '" >
	<!--
		<a class="search-close pull-right"><i class="fa fa-times-circle"></i></a>
		-->
		<div class="search-input-box pull-left">
		    <button class="search-btn-inner" type="submit"><i class="icon-search"></i></button>
			<input type="search" name="s" value="' . get_search_query() . '" placeholder="Искать">			
		</div>
		<!--<input type="hidden" name="post_type" value="product" />-->
	</form>';

	return $form;
}
add_filter( 'get_product_search_form', 'product_search_form_top_child' );

// Переопределение обычной формы поиска
function search_form_top_child( $form ){
	$form = '
	<form role="search" class="search-form" method="get" action="' . esc_url( home_url( '/' ) ). '" >
	<!--
		<a class="search-close pull-right"><i class="fa fa-times-circle"></i></a>
		-->
		<div class="search-input-box pull-left">
		    <button class="search-btn-inner" type="submit"><i class="icon-search"></i></button>
			<input type="search" name="s" value="' . get_search_query() . '" placeholder="Искать">			
		</div>
		<!--<input type="hidden" name="post_type" value="post" />-->
	</form>';
	return $form;
}
add_filter( 'get_search_form', 'search_form_top_child' );

add_action( 'init', 'rs_exclude_from_search' );
function rs_exclude_from_search()
{
    global $wp_post_types;

    $wp_post_types['custom_block']->exclude_from_search = true;
}
function rs_cpt_search( $query ) {
    if ( is_search() && $query->is_main_query() && $query->get( 's' ) ){
        $query->set( 'post_type', array(
            'post',
            'page',
            'product', // Our Product CPT.
        ) );
    }
}
add_filter('pre_get_posts', 'rs_cpt_search');

// Функция вывода открывающих тегов области главного меню
function storefront_primary_navigation_wrapper_child() {
	?>
	<div class="rs-17">
		<div class="rs-menu-cart">
			<div data-spy="affix" data-offset-top="31">
				<nav class="navbar">
					<div class="container">
	<?php
}

// Функция вывода закрывающих тегов области главного меню
function storefront_primary_navigation_wrapper_close_child() {
	?>
					</div>
				</nav>
			</div>
		</div>
	</div>
	<?php
}

// Класс для изменения главного меню (вставляет кнопку)
class My_Walker_Nav_Menu_Mobile extends Walker_Nav_Menu
{
	function start_lvl( &$output, $depth = 0, $args = array() )
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<button class=\"link-btn\"><i class=\"fa fa-lg fa-angle-up fa-rotate-180\"></i></button><ul class=\"dropdown-menu\">\n";
	}
}
class My_Walker_Nav_Menu extends Walker_Nav_Menu
{
	function start_lvl( &$output, $depth = 0, $args = array() )
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<button class=\"link-btn\"><i class=\"fa fa-caret-down\"></i></button><ul class=\"dropdown-menu\">\n";
	}
}

// Функция вывода главного меню
function storefront_primary_navigation_child( $menu_id ) {
	?>
	<div class="collapse navbar-collapse pull-left navbar-menu" id="menu-basket">
	<?php
		wp_nav_menu (
			array (
				'theme_location'  => 'primary',
				'menu_class' => 'nav navbar-nav navbar-main',
				'walker' => new My_Walker_Nav_Menu(),
				'fallback_cb' => '__return_empty_string'
			));
	?>
	</div>
	<div class="hidden-lg hidden-md">
		<div class="collapse navbar-collapse pull-left navbar-menu" id="mobail-menu">
		<?php 
			wp_nav_menu (
				array (
					'theme_location'  => 'handheld',
					'menu_class' => 'nav navbar-nav navbar-main',
					'walker' => new My_Walker_Nav_Menu_Mobile(),
					'fallback_cb' => '__return_empty_string'
				));
		?>
		</div>
	</div>
	<!-- #site-navigation -->
	<?php
}
function storefront_primary_navigation_child_right( $menu_id ) {
	?>
	<div class="collapse navbar-collapse pull-right navbar-menu" id="menu-basket">
	<?php
		wp_nav_menu (
			array (
				'theme_location'  => 'primary',
				'menu_class' => 'nav navbar-nav navbar-main',
				'walker' => new My_Walker_Nav_Menu(),
				'fallback_cb' => '__return_empty_string'
			));
	?>
	</div>
	<div class="hidden-lg hidden-md">
		<div class="collapse navbar-collapse pull-left navbar-menu" id="mobail-menu">
		<?php 
			wp_nav_menu (
				array (
					'theme_location'  => 'handheld',
					'menu_class' => 'nav navbar-nav navbar-main',
					'walker' => new My_Walker_Nav_Menu_Mobile(),
					'fallback_cb' => '__return_empty_string'
				));
		?>
		</div>
	</div>
	<!-- #site-navigation -->
	<?php
}
// Фильтр классов ul выпадающего меню
add_filter( 'nav_menu_submenu_css_class', 'change_wp_nav_menu_child', 10, 3 );
function change_wp_nav_menu_child( $classes, $args, $depth ) {
	foreach ( $classes as $key => $class ) {
		if ( $class == 'sub-menu' ) {
			$classes[ $key ] = 'dropdown-menu';
		}
	}
	return $classes;		
}
// Фильтр классов li выпадающего меню
add_filter( 'nav_menu_css_class', 'change_menu_item_css_classes_child', 10, 4 );
function change_menu_item_css_classes_child( $classes, $item, $args, $depth ) {
	/*if ($args->theme_location == 'primary') {
		foreach ( $classes as $key => $class ) {
			if ( $class == 'menu-item-has-children' ) {
				$classes[ $key ] = 'dropdown';
			}		
		}		
	}
	return $classes;*/	
	foreach ( $classes as $key => $class ) {
		if ( $class == 'menu-item-has-children' ) {
			$classes[ $key ] = 'dropdown';
		}		
	}
	return $classes;			
}

function storefront_primary_navigation_logo_child() {
	?>
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
				data-target="#mobail-menu" aria-expanded="false">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<?php
			$logo_img = 'logo';
			if ($custom_logo_id = get_theme_mod('custom_logo')) 
				$logo_img = wp_get_attachment_image( $custom_logo_id, 'full', true );				
			echo "<a class='navbar-brand' href='/'>$logo_img</a>";
		?>
	</div>
	<?php
}

// Подключение мини-корзины
function storefront_header_cart_child() {
	if ( storefront_is_woocommerce_activated() ) {
		include ('mini-cart.php');
	}
}
//Кнопка входа возле мини-корзины
function rs_header_login(){ ?>
    <div id="site-header-login" class="pull-right hidden-xs hidden-sm">
        <a class="login-btn user-icon-button" href="/my-account/">
            <i class="icon-user-login"></i>
            <span class="hidden-xs hidden-sm  basket-text">
               <?php if ( is_user_logged_in() ) {
                   $current_user = wp_get_current_user();
                   echo $current_user->user_login;
               }
               else {
                   echo 'Вход';
               }
               ?>
            </span>
        </a>
    </div>
<?php }
//Кнопка поиска возле мини-корзины
function rs_header_search(){?>
    <div class="search-full">
        <?php
        if(is_woocommerce()) {
            get_product_search_form();
        } else {
            get_search_form();
        }
        ?>
    </div>
    <div id="site-header-search" class="pull-right hidden-xs hidden-sm">
        <button class="search-btn user-icon-button" type="button">
            <i class="icon-search"></i>
            <span class="hidden-xs hidden-sm  basket-text">Искать</span>
        </button>
    </div>
<?php }


function rs_modal_form() { ?>
<div class="rs-17">
	<div class="rs-modal">
		<div class="modal fade" tabindex="-1" id="order-call2">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="modal-title">Свяжитесь с нами</div>
					</div>
					<div class="modal-body">
						<?php echo do_shortcode('[contact-form-7 id="2255" title="Модальная форма"]'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }