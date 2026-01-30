<?php
/**
 * Наш кастомный AJAX-обработчик
 */

// Проверяем, загружен ли родительский класс
if (!class_exists('AWOOC_Ajax')) {
    return;
}

class MyCustom_AWOOC_Ajax extends AWOOC_Ajax {

    /**
     * Переопределяем метод получения заголовка товара
     */
    public function product_title($product) {
        // Вызываем родительский метод
        $original_title = parent::product_title($product);

        // Добавляем кастомную логику
        return '🔥 ' . $original_title . ' 🔥';
    }

    /**
     * ДОПОЛНИТЕЛЬНЫЙ ПРИМЕР: добавляем новые данные в AJAX-ответ
     */

    public function product_sku( $product ) {

        if ( ! wc_product_sku_enabled() && ( ! $product->get_sku() || ! $product->is_type( 'variable' ) ) ) {
            return false;
        }

        return $product->get_sku() ? '🔥 ' .  $product->get_sku() : __( 'N/A', 'woocommerce' );
    }
//    public function ajax_scripts_callback() {
//        // Сначала вызываем оригинальный метод через parent::
//        // НО! Родительский метод использует wp_send_json() и завершает выполнение
//
//        // Поэтому лучше использовать фильтры, если нужно только добавить данные
//        // Но если нужно КАРДИНАЛЬНО изменить логику, делаем так:
//
//        // Копируем проверки безопасности из родительского метода
//        if (false === defined('WP_CACHE')) {
//            check_ajax_referer('awooc-nonce', 'nonce');
//        }
//
//        if (!isset($_POST['id']) || empty($_POST['id'])) {
//            wp_die(esc_html__('Ошибка данных', 'art-woocommerce-order-one-click'));
//        }
//
//        // Получаем товар
//        $product = wc_get_product(sanitize_text_field(wp_unslash($_POST['id'])));
//        $product_qty = $_POST['qty'] ? (int) sanitize_text_field(wp_unslash($_POST['qty'])) : 1;
//
//        // Формируем БАЗОВЫЙ массив данных через родительские методы
//        $data = [
//            'title' => $this->product_title($product), // Уже использует наш переопределённый метод!
//            'image' => $this->product_image($product),
//            'price' => $this->product_price($product),
//            // ... другие поля по аналогии
//        ];
//
//        // ДОБАВЛЯЕМ СВОИ ДАННЫЕ
//        $data['my_custom_field'] = 'Это моё кастомное поле';
//        $data['product_weight'] = $product->get_weight() ?: 'Нет веса';
//
//        // Применяем стандартный фильтр плагина
//        $data = apply_filters('awooc_data_ajax', $data, $product);
//
//        // Отправляем результат
//        wp_send_json($data);
//    }
//
//    /**
//     * ДОПОЛНИТЕЛЬНЫЙ ПРИМЕР: добавляем новый метод
//     */
//    public function get_product_brand($product) {
//        // Ваша кастомная логика для получения бренда
//        $brand = get_the_terms($product->get_id(), 'product_brand');
//        return $brand ? $brand[0]->name : 'Без бренда';
//    }
}