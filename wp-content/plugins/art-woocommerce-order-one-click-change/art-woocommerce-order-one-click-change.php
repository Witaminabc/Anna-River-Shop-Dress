<?php
/**
 * Plugin Name: Мой первый плагин по изменению уан клик
 * Description: Модификация плагина Art WooCommerce Order One Click
 */





if (!defined('ABSPATH')) exit;

add_action('plugins_loaded', 'my_awooc_plugin_init', 9999);

function my_awooc_plugin_init() {
    // 1. Проверяем, что основной плагин загружен
    if (!isset($GLOBALS['awooc']) || !isset($GLOBALS['awooc']->front_end)) {
        return;
    }

    // 2. Создаём свой класс с дополнительной логикой
    class My_AWOOC_Extension {

        public function __construct() {
            // Вызываем нашу функцию при инициализации фронтенда
            $this->attach_to_front_end();
        }

        private function attach_to_front_end() {
            // Добавляем вызов нашей функции через фильтры и хуки
            $this->add_custom_hooks();
        }

        private function add_custom_hooks() {
            // Хук, который сработает после конструктора AWOOC_Front_End
            add_action('init', [$this, 'my_custom_function'], 20);

            // Или привязаться к хукам самого класса AWOOC_Front_End
            add_action('wp_footer', [$this, 'my_custom_footer_content'], 31); // После оригинального (30)

            // Добавляем фильтр к существующей логике
            add_filter('awooc_button_label', [$this, 'customize_button_label'], 15);

            add_filter('awooc_id_button', [$this, 'customize_button_label2'], 20);
            add_action('awooc_popup_column_left',[$this,'my_add_string'],60);
//            print_r(add_filter('awooc_settings_section_main',[$this,'my_filter_admin']));
            add_filter('awooc_settings_section_main', [$this, 'my_filter_admin'], 20, 1);
            add_filter('awooc_data_ajax', [$this, 'my_filter_ajax_callback'], 10, 2);


        }

        function my_filter_ajax_callback($data) {
            // 1. Изменяем заголовок
//            global $product;
            $product     = wc_get_product( sanitize_text_field( wp_unslash( $_POST['id'] ) ) );

            $data['title'] = '🔥 ' . $product->get_title() . ' 🔥';

            // 2. Или через фильтр product_title (если он есть)
            // Можно добавить фильтр, если он не существует
            if (!has_filter('awooc_product_title')) {
                add_filter('awooc_product_title', 'my_custom_title', 10, 2);
            }

            // 3. Добавляем дополнительные данные
//            $data['my_custom_field'] = get_post_meta($product->get_id(), '_custom_field', true);
            $data['product_weight'] = $product->get_weight() ?: 'Не указан';

            // 4. Модифицируем другие поля
            $data['price'] = str_replace('Price:', '💰 Цена:', $data['price']);

            return $data;
        }
        public function my_filter_admin($settings) {
            // 1. Проверяем, что это массив
            if (!is_array($settings)) {
                return $settings;
            }

            // Для отладки: записываем в лог
            error_log('Фильтр my_filter_admin вызван. Количество элементов: ' . count($settings));

            // 2. Пример: Изменяем дефолтные элементы в настройках
            foreach ($settings as $key => $setting) {
                // Находим поле выбора элементов
                if (isset($setting['id']) && $setting['id'] === 'woocommerce_awooc_select_item') {
                    // Добавляем новые элементы по умолчанию
                    $settings[$key]['default'] = array(
                        'title', 'image', 'price', 'sku', 'attr', 'qty', 'sum',
                        'brand', 'weight'  // Ваши новые элементы
                    );
                    $settings[$key]['options'] = array(
                        'title', 'image', 'price', 'sku', 'attr', 'qty', 'sum',
                        'brand', 'weight'  // Ваши новые элементы
                    );

                    error_log('Изменены дефолтные элементы в настройках');
                    break;
                }

                // Пример: изменяем поле "Operating mode"
                if (isset($setting['id']) && $setting['id'] === 'woocommerce_awooc_mode_catalog') {
                    // Можно добавить новые опции или изменить существующие
                    // $settings[$key]['options']['my_custom_mode'] = 'Мой режим';
                }
            }

            // 3. Пример: добавляем новое поле в настройки
            $new_setting = array(
                'name'     => __('Мои настройки', 'art-woocommerce-order-one-click'),
                'type'     => 'title',
                'desc'     => __('Дополнительные настройки от моего плагина', 'art-woocommerce-order-one-click'),
                'id'       => 'woocommerce_awooc_my_custom_settings',
            );

            // Вставляем после "Others" секции
            $insert_position = false;
            foreach ($settings as $key => $setting) {
                if (isset($setting['id']) && $setting['id'] === 'woocommerce_awooc_settings_others') {
                    $insert_position = $key + 1; // После sectionend
                    break;
                }
            }

            if ($insert_position !== false) {
                array_splice($settings, $insert_position, 0, [$new_setting]);
            }

            // 4. ВАЖНО: всегда возвращаем изменённый массив!
            return $settings;
        }
        public function my_add_string(){
            echo '<div>плюс</div>';
        }
        public function my_custom_function() {
            // Ваша логика, которая должна выполняться
            if (is_product()) {
                $this->display_custom_content();
            }
        }

        public function customize_button_label2($original_label) {
            return  $original_label . ' newid';
        }
        public function my_custom_footer_content() {
            echo '<div class="my-custom-notice">Доставка по всей России!</div>';
        }

        public function customize_button_label($original_label) {
            return '🚀 ' . $original_label . ' 🚀';
        }

        public function display_custom_content() {
            echo '<div class="custom-delivery-info">Бесплатная доставка при заказе от 3000 руб.</div>';
        }
    }

    // Инициализируем наше расширение
    new My_AWOOC_Extension();

    // 3. Альтернатива: сразу добавить функцию к объекту front_end
    add_custom_method_to_front_end();
}

function add_custom_method_to_front_end() {
    $front_end = $GLOBALS['awooc']->front_end;

    // Добавляем метод к объекту
    $front_end->my_custom_method = function($param = '') {
        echo "Вызвана моя кастомная функция с параметром: {$param}<br/>";

        // Можем обратиться к свойствам объекта
        echo "Текущий режим: {$this->mode}<br/>";

        return 'Результат выполнения';
    };

    // Теперь можно вызвать где угодно:
    // $GLOBALS['awooc']->front_end->my_custom_method('тест');
}