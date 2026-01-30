<?php

/*
 * Plugin Name: Мой первый плагин по изменению уан клик
 */

if (!defined('ABSPATH')) {
    exit;
}
add_action('awooc_popup_before_column', 'new_title');
function new_title()
{
    echo 'superdata';
}

//add_action('plugins_loaded', 'my_plugin_init');
//function my_plugin_init()
//{


class MyAWOOC_Wrapper
{

    /**
     * @var AWOOC Оригинальный экземпляр плагина
     */
    private $original_awooc;

    /**
     * @var MyCustom_AWOOC_Ajax Наш кастомный AJAX-обработчик
     */
    public $ajax;

    /**
     * Конструктор
     */
    public function __construct(AWOOC $original)
    {
        $this->original_awooc = $original;

        // Сохраняем оригинальные публичные свойства
        $this->front_end = $original->front_end;
        $this->enqueue = $original->enqueue;
        $this->orders = $original->orders;

        // ЗАМЕНЯЕМ ТОЛЬКО НУЖНЫЙ КОМПОНЕНТ!
        $this->replace_ajax_component();

        // При необходимости можно заменить и другие компоненты
        // $this->replace_orders_component();
    }

    /**
     * Заменяем AJAX-компонент на свой
     */
    private function replace_ajax_component()
    {
        // 1. Создаём наш кастомный AJAX-обработчик
        require_once __DIR__ . '/my-custom-awooc-ajax.php';
        $this->ajax = new MyCustom_AWOOC_Ajax();

        // 2. Удаляем все AJAX-хуки оригинального обработчика
        // Важно: используем оригинальный объект, который сохранили в конструкторе
        remove_action('wp_ajax_nopriv_awooc_ajax_product_form', [$this->original_awooc->ajax, 'ajax_scripts_callback']);
        remove_action('wp_ajax_awooc_ajax_product_form', [$this->original_awooc->ajax, 'ajax_scripts_callback']);

        // 3. Наш обработчик УЖЕ зарегистрировал свои хуки в конструкторе
        // (т.к. MyCustom_AWOOC_Ajax наследует от AWOOC_Ajax)
    }

    /**
     * Магический метод для прозрачного доступа к оригинальным методам
     * Это ключевой момент паттерна "Декоратор"
     */
    public function __call($method, $args)
    {
        if (method_exists($this->original_awooc, $method)) {
            return call_user_func_array([$this->original_awooc, $method], $args);
        }

        throw new BadMethodCallException("Метод $method не существует");
    }

    /**
     * Магический метод для доступа к оригинальным свойствам
     */
    public function __get($property)
    {
        if (property_exists($this->original_awooc, $property)) {
            return $this->original_awooc->$property;
        }

        return null;
    }

    /**
     * Магический метод для установки свойств
     */
    public function __set($property, $value)
    {
        if (property_exists($this->original_awooc, $property)) {
            $this->original_awooc->$property = $value;
        } else {
            $this->$property = $value;
        }
    }
}

/**
 * Основная функция инициализации нашего плагина
 */
function my_awooc_extension_init()
{
    // 1. Проверяем, существует ли оригинальный плагин
    if (!class_exists('AWOOC')) {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-warning"><p>Для работы My AWOOC Extension требуется плагин Art WooCommerce Order One Click.</p></div>';
        });
        return;
    }

    // 2. Получаем оригинальный экземпляр
    $original_instance = AWOOC::instance();

    // 3. Подменяем глобальный экземпляр на нашу обёртку
    // Используем Reflection для доступа к приватному статическому свойству
    $reflection = new ReflectionClass('AWOOC');
    $property = $reflection->getProperty('instance');
    $property->setAccessible(true);

    // 4. Создаём обёртку и устанавливаем как глобальный экземпляр
    $wrapper = new MyAWOOC_Wrapper($original_instance);
    $property->setValue(null, $wrapper);

    // 5. Также сохраняем в глобальной переменной для удобства
    $GLOBALS['my_awooc_wrapper'] = $wrapper;
}

/**
 * Хук для инициализации ПОСЛЕ оригинального плагина
 * Приоритет 20 гарантирует, что оригинальный плагин уже загружен
 */
add_action('plugins_loaded', 'my_awooc_extension_init', 20);

//}
