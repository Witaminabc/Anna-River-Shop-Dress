<?php

// Подключить стили для основной страницы
add_action( 'wp_enqueue_scripts', 'style_rs_page_base_theme', 11);
function style_rs_page_base_theme() {
	wp_enqueue_style( 'rs-page-base', get_stylesheet_directory_uri().'/template-parts/rs-page-base/css/rs-page-base.css');
}

// Вывод дополнительных блоков в шаблоне

// блок template-parts/rs-slider блок Слайдер
add_action('template_on_slider', 'storefront_slider_child');

// блок template-parts/rs-features блок Преимущества 4х
add_action('template_on_features_4', 'storefront_rs_show_custom_block');
// блок template-parts/rs-features-3x блок Преимущества 3х
add_action('template_on_features_3', 'storefront_rs_features_3x');
// блок template-parts/rs-features-3x блок Преимущества 3х
add_action('template_on_features_x', 'storefront_rs_features_x');
// блок template-parts/rs-features-photo блок Преимущества с картинкой
add_action('template_on_features_photo', 'storefront_rs_features_photo');
// блок template-parts/rs-offers блок Предложения
add_action('template_on_offers', 'storefront_rs_offers');
// блок template-parts/rs-offers блок Наши цифры
add_action('template_on_numbers', 'storefront_rs_numbers');
// блок template-parts/rs-team блок Наша команда
add_action('template_on_team', 'storefront_rs_team');
// блок template-parts/rs-popular блок Форма обратной связи
add_action('template_on_form', 'storefront_rs_form_child');
// блок template-parts/rs-news блок Новости
add_action('template_on_news', 'storefront_news_child');
// блок template-parts/rs-reviews блок Отзывы
add_action('template_on_reviews', 'storefront_reviews_child');
// блок template-parts/rs-services блок Каталог
add_action('template_on_catalog', 'storefront_rs_services');

// блок template-parts/rs-services блок Каталог произвольный
add_action('template_on_catalog_free', 'storefront_rs_services_3');

// блок template-parts/rs-services блок Как мы работаем
add_action('template_on_works', 'storefront_rs_howworks');	
// блок template-parts/rs-contactus блок Свяжитесь с нами
add_action('template_on_contact', 'storefront_rs_contactus');
// блок template-parts/rs-parallax-land блок Цитата
add_action('template_on_quote', 'storefront_rs_parallax_land');
// блок template-parts/rs-partners блок Партнёры
add_action('template_on_partners', 'storefront_rs_partners');
// блок template-parts/rs-video блок Видео
add_action('template_on_video', 'storefront_rs_video');
// блок template-parts/rs-price блок тарифные планы (прайс)
add_action('template_on_price', 'storefront_price_child');
// блок template-parts/rs-counter блок Таймер
add_action('template_on_counter', 'storefront_rs_counter');
// блок template-parts/rs-subscribe блок Подписаться
add_action('template_on_subscribe', 'storefront_rs_subscribe');
// блок template-parts/rs-photogallery блок Фотогалерея
add_action('template_on_photogallery', 'storefront_rs_photogallery');
// блок template-parts/rs-video-new блок Видеоролики
add_action('template_on_video_new', 'storefront_rs_video_new');
// блок template-parts/rs-tabs блок с переключателями
add_action('template_on_tabs', 'storefront_rs_tabs');
// блок template-parts/rs-parallax-1 блок Параллакс 1
add_action('template_on_parallax_1', 'storefront_parallax_1');
// блок template-parts/rs-parallax-2 блок Параллакс 2
add_action('template_on_parallax_2', 'storefront_parallax_2');
// блок template-parts/rs-portfolio-slider блок Наши проекты
add_action('template_on_examples', 'storefront_examples_child');
// блок template-parts/rs-services-icon блок Услуги с иконками
add_action('template_on_services_icon', 'storefront_rs_services_icon');
// блок template-parts/rs-contact-land блок Форма ОС с картинкой
add_action('template_on_contact_land', 'storefront_rs_contact_land_child');
// блок template-parts/rs-recommendations блок рекомендации
add_action('template_on_recommendations', 'storefront_rs_recommendations');
// блок template-parts/rs-carousel блок карусель фотографий
add_action('template_on_carousel', 'storefront_rs_carousel');

// блок template-parts/rs-popular блок Популярные
add_action('template_on_popular', 'storefront_popular_products_child');
// блок template-parts/rs-onsale блок Распродажа
add_action('template_on_onsale', 'storefront_onsale_products_child');		
// блок template-parts/rs-new-products блок Новинки
add_action('template_on_best_seller', 'storefront_best_selling_products_child');
// блок template-parts/rs-best-sellers блок Самые продаваемые
add_action('template_on_new_products', 'storefront_recent_products_child');


