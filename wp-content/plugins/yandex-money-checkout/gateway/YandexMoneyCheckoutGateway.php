<?php

if (!class_exists('WC_Payment_Gateway')) {
    return;
}

use YandexCheckout\Client;
use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Model\ConfirmationType;
use YandexCheckout\Model\Payment;
use YandexCheckout\Model\PaymentMethodType;
use YandexCheckout\Model\PaymentStatus;
use YandexCheckout\Model\Receipt\PaymentMode;
use YandexCheckout\Model\Receipt\PaymentSubject;
use YandexCheckout\Request\Payments\CreatePaymentRequest;
use YandexCheckout\Request\Payments\CreatePaymentRequestBuilder;
use YandexCheckout\Request\Payments\CreatePaymentRequestSerializer;
use YandexCheckout\Request\Payments\CreatePaymentResponse;

class YandexMoneyCheckoutGateway extends WC_Payment_Gateway
{
    public $paymentMethod;

    public $confirmationType = ConfirmationType::REDIRECT;

    public $defaultDescription = '';

    public $defaultTitle = '';

    /**
     * @var Client
     */
    private $apiClient;

    /**
     * @var bool
     */
    protected $savePaymentMethod = false;

    protected $enableRecurrentPayment;

    private $recurentPaymentMethodId;

    public function __construct()
    {
        $this->has_fields = false;
        $this->init_form_fields();
        $this->init_settings();
        $this->title       = $this->settings['title'];
        $this->description = $this->settings['description'];
        $this->supports    = array(
            'products',
        );

        if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=')) {
            add_action(
                'woocommerce_update_options_payment_gateways_'.$this->id,
                array(
                    $this,
                    'process_admin_options',
                )
            );
        } else {
            add_action('woocommerce_update_options_payment_gateways', array($this, 'process_admin_options'));
        }
        add_action('woocommerce_receipt_'.$this->id, array($this, 'receipt_page'));
    }

    /**
     * Init settings for gateways.
     */
    public function init_settings()
    {
        parent::init_settings();

        $paymentSubjectEnum = array(
            PaymentSubject::COMMODITY             => 'Товар ('.PaymentSubject::COMMODITY.')',
            PaymentSubject::EXCISE                => 'Подакцизный товар ('.PaymentSubject::EXCISE.')',
            PaymentSubject::JOB                   => 'Работа ('.PaymentSubject::JOB.')',
            PaymentSubject::SERVICE               => 'Услуга ('.PaymentSubject::SERVICE.')',
            PaymentSubject::GAMBLING_BET          => 'Ставка в азартной игре ('.PaymentSubject::GAMBLING_BET.')',
            PaymentSubject::GAMBLING_PRIZE        => 'Выигрыш в азартной игре ('.PaymentSubject::GAMBLING_PRIZE.')',
            PaymentSubject::LOTTERY               => 'Лотерейный билет ('.PaymentSubject::LOTTERY.')',
            PaymentSubject::LOTTERY_PRIZE         => 'Выигрыш в лотерею ('.PaymentSubject::LOTTERY_PRIZE.')',
            PaymentSubject::INTELLECTUAL_ACTIVITY => 'Результаты интеллектуальной деятельности ('.PaymentSubject::INTELLECTUAL_ACTIVITY.')',
            PaymentSubject::PAYMENT               => 'Платеж ('.PaymentSubject::PAYMENT.')',
            PaymentSubject::AGENT_COMMISSION      => 'Агентское вознаграждение ('.PaymentSubject::AGENT_COMMISSION.')',
            PaymentSubject::COMPOSITE             => 'Несколько вариантов ('.PaymentSubject::COMPOSITE.')',
            PaymentSubject::ANOTHER               => 'Другое ('.PaymentSubject::ANOTHER.')',
        );

        $paymentModeEnum = array(
            PaymentMode::FULL_PREPAYMENT    => 'Полная предоплата ('.PaymentMode::FULL_PREPAYMENT.')',
            PaymentMode::PARTIAL_PREPAYMENT => 'Частичная предоплата ('.PaymentMode::PARTIAL_PREPAYMENT.')',
            PaymentMode::ADVANCE            => 'Аванс ('.PaymentMode::ADVANCE.')',
            PaymentMode::FULL_PAYMENT       => 'Полный расчет ('.PaymentMode::FULL_PAYMENT.')',
            PaymentMode::PARTIAL_PAYMENT    => 'Частичный расчет и кредит ('.PaymentMode::PARTIAL_PAYMENT.')',
            PaymentMode::CREDIT             => 'Кредит ('.PaymentMode::CREDIT.')',
            PaymentMode::CREDIT_PAYMENT     => 'Выплата по кредиту ('.PaymentMode::CREDIT_PAYMENT.')',
        );

        $this->addReceiptAttribute('ym_payment_subject', __('Признак предмета расчета', 'yandexcheckout'),
            $paymentSubjectEnum);
        $this->addReceiptAttribute('ym_payment_mode', __('Признак способа расчёта', 'yandexcheckout'),
            $paymentModeEnum);
    }

    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled'     => array(
                'title'   => __('Включить/Выключить', 'yandexcheckout'),
                'type'    => 'checkbox',
                'label'   => $this->method_description,
                'default' => 'no',
            ),
            'title'       => array(
                'title'       => __('Заголовок', 'yandexcheckout'),
                'type'        => 'text',
                'description' => __('Название, которое пользователь видит во время оплаты', 'yandexcheckout'),
                'default'     => $this->defaultTitle,
            ),
            'description' => array(
                'title'       => __('Описание', 'yandexcheckout'),
                'type'        => 'textarea',
                'description' => __('Описание, которое пользователь видит во время оплаты', 'yandexcheckout'),
                'default'     => $this->defaultDescription,
            ),
        );
    }

    public function admin_options()
    {
        echo '<h5>'.__(
                'Для работы с модулем необходимо <a href="https://money.yandex.ru/joinups/">подключить магазин к Яндек.Кассе</a>. После подключения вы получите параметры для приема платежей (идентификатор магазина — shopId  и секретный ключ).',
                'yandexcheckout'
            ).'</h5>';
        echo '<table class="form-table">';
        $this->generate_settings_html();
        echo '</table>';
    }

    /**
     *  There are no payment fields, but we want to show the description if set.
     */
    public function payment_fields()
    {
        if ($this->description) {
            echo wpautop(wptexturize($this->description));
        }
    }

    /**
     * Receipt Page
     *
     * @param int $order_id
     *
     * @throws Exception
     */
    public function receipt_page($order_id)
    {
        YandexMoneyLogger::info(
            'Receipt page init.'
        );
        global $woocommerce;
        $apiClient = $this->getApiClient();
        $order     = new WC_Order($order_id);
        $paymentId = $order->get_transaction_id();
        YandexMoneyLogger::info(
            sprintf(__('Пользователь вернулся с формы оплаты. Id заказа - %1$s. Идентификатор платежа - %2$s.',
                'yandexcheckout'), $order_id, $paymentId)
        );
        try {
            $payment = $apiClient->getPaymentInfo($paymentId);
            if (in_array($payment->getStatus(), array(PaymentStatus::SUCCEEDED, PaymentStatus::WAITING_FOR_CAPTURE))
                || ($payment->getStatus() === PaymentStatus::PENDING && $payment->getPaid())
            ) {
                $woocommerce->cart->empty_cart();
                wp_redirect($this->get_success_fail_url('ym_api_success', $order));
            } else {
                wp_redirect($this->get_success_fail_url('ym_api_fail', $order));
            }
        } catch (ApiException $e) {
            YandexMoneyLogger::error('Api error: '.$e->getMessage());
        }
    }

    /**
     * @param WC_Order $order
     *
     * @return mixed|WP_Error|CreatePaymentResponse
     *
     * @throws Exception
     */
    public function createPayment($order)
    {
        $builder        = $this->getBuilder($order, $this->savePaymentMethod);
        $paymentRequest = $builder->build();
        if (YandexMoneyCheckoutHandler::isReceiptEnabled()) {
            $receipt = $paymentRequest->getReceipt();
            if ($receipt instanceof \YandexCheckout\Model\Receipt) {
                $receipt->normalize($paymentRequest->getAmount());
            }
        }
        $serializer     = new CreatePaymentRequestSerializer();
        $serializedData = $serializer->serialize($paymentRequest);
        YandexMoneyLogger::info('Create payment request: '.json_encode($serializedData));
        try {
            $response = $this->getApiClient()->createPayment($paymentRequest);

            return $response;
        } catch (ApiException $e) {
            YandexMoneyLogger::error('Api error: '.$e->getMessage());

            return new WP_Error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Process the payment and return the result
     *
     * @param $order_id
     *
     * @return array
     * @throws WC_Data_Exception
     * @throws Exception
     */
    public function process_payment($order_id)
    {
        global $woocommerce;

        $order                   = new WC_Order($order_id);
        $this->savePaymentMethod = $this->saveNewPaymentMethod();
        if (isset($_POST["wc-{$this->id}-payment-token"]) && 'new' !== $_POST["wc-{$this->id}-payment-token"]) {
            $token_id = wc_clean($_POST["wc-{$this->id}-payment-token"]);
            $token    = WC_Payment_Tokens::get($token_id);
            if ($token->get_user_id() !== get_current_user_id()) {
                //@TODO Optionally display a notice with `wc_add_notice`
                return;
            }

            $this->recurentPaymentMethodId = $token->get_token();
        }
        $result = $this->createPayment($order);
        if ($result) {
            if (is_wp_error($result)) {
                wc_add_notice(__('Платеж не прошел. Попробуйте еще или выберите другой способ оплаты',
                    'yandexcheckout'), 'error');

                return array('result' => 'fail', 'redirect' => $order->get_view_order_url());
            } else {
                $order->set_transaction_id($result->id);
                if ($result->status == PaymentStatus::PENDING) {
                    $order->update_status('wc-pending');
                    if (get_option('ym_force_clear_cart') == 'on') {
                        $woocommerce->cart->empty_cart();
                    }
                    if ($result->confirmation->type == ConfirmationType::EXTERNAL) {
                        return array('result' => 'success', 'redirect' => $order->get_checkout_order_received_url());
                    } elseif ($result->confirmation->type == ConfirmationType::REDIRECT) {
                        return array('result' => 'success', 'redirect' => $result->confirmation->confirmationUrl);
                    }
                } elseif ($result->status == PaymentStatus::WAITING_FOR_CAPTURE) {
                    return array('result' => 'success', 'redirect' => $order->get_checkout_order_received_url());
                } elseif ($result->status == PaymentStatus::SUCCEEDED) {
                    if ($this->recurentPaymentMethodId) {
                        $order->update_status('wc-success');
                    }

                    return array(
                        'result'   => 'success',
                        'redirect' => $this->get_success_fail_url('ym_api_success', $order),
                    );
                } else {
                    YandexMoneyLogger::warning(sprintf(__('Неудалось создать платеж. Для заказа %1$s',
                        'yandexcheckout'), $order_id));
                    wc_add_notice(__('Платеж не прошел. Попробуйте еще или выберите другой способ оплаты',
                        'yandexcheckout'), 'error');
                    $order->update_status('wc-cancelled');

                    return array('result' => 'fail', 'redirect' => '');
                }
            }
        } else {
            YandexMoneyLogger::warning(sprintf(__('Неудалось создать платеж. Для заказа %1$s', 'yandexcheckout'),
                $order_id));
            wc_add_notice(__('Платеж не прошел. Попробуйте еще или выберите другой способ оплаты', 'yandexcheckout'),
                'error');

            return array('result' => 'fail', 'redirect' => '');
        }
    }

    public function showMessage($content)
    {
        return '<div class="box '.$this->msg['class'].'-box">'.$this->msg['message'].'</div>'.$content;
    }

    // get all pages
    public function get_pages($title = false, $indent = true)
    {
        $wp_pages  = get_pages('sort_column=menu_order');
        $page_list = array();
        if ($title) {
            $page_list[] = $title;
        }
        foreach ($wp_pages as $page) {
            $prefix = '';
            // show indented child pages?
            if ($indent) {
                $has_parent = $page->post_parent;
                while ($has_parent) {
                    $prefix     .= ' - ';
                    $next_page  = get_page($has_parent);
                    $has_parent = $next_page->post_parent;
                }
            }
            // add to page list array array
            $page_list[$page->ID] = $prefix.$page->post_title;
        }

        return $page_list;
    }

    /**
     * @param $name
     * @param WC_Order $order
     *
     * @return string
     */
    protected function get_success_fail_url($name, $order)
    {
        switch (get_option($name)) {
            case "wc_success":
                return $order->get_checkout_order_received_url();
                break;
            case "wc_checkout":
                return $order->get_view_order_url();
                break;
            case "wc_payment":
                return $order->get_checkout_payment_url();
                break;
            default:
                return get_page_link(get_option($name));
                break;
        }
    }

    /**
     * @return Client
     */
    public function getApiClient()
    {
        if (!$this->apiClient) {
            $shopId          = get_option('ym_api_shop_id');
            $shopPassword    = get_option('ym_api_shop_password');

            $this->apiClient = new Client();
            $userAgent = $this->apiClient->getApiClient()->getUserAgent();
            $userAgent->setCms('Wordpress', $GLOBALS['wp_version']);
            $userAgent->setFramework('Woocommerce',WOOCOMMERCE_VERSION);
            $userAgent->setModule('PaymentGateway', YAMONEY_API_VERSION);
            $this->apiClient->setAuth($shopId, $shopPassword);
            $this->apiClient->setLogger(new YandexMoneyLogger());
        }

        return $this->apiClient;
    }

    /**
     * @param WC_Order $order
     *
     * @param $save
     *
     * @return CreatePaymentRequestBuilder
     */
    protected function getBuilder($order, $save)
    {
        $enableHold = get_option('ym_api_enable_hold')
                      && in_array($this->paymentMethod, array('', PaymentMethodType::BANK_CARD));

        $builder = CreatePaymentRequest::builder()
                   ->setAmount(YandexMoneyCheckoutOrderHelper::getTotal($order))
                   ->setCapture(!$enableHold)
                   ->setDescription($this->createDescription($order))
                   ->setSavePaymentMethod($save)
                   ->setMetadata(array(
                       'cms_name'       => 'ya_api_woocommerce',
                       'module_version' => YAMONEY_API_VERSION,
                       'wp_user_id'     => get_current_user_id(),
                   ));

        if ($this->recurentPaymentMethodId) {
            $builder->setPaymentMethodId($this->recurentPaymentMethodId);
        } else {
            $builder->setPaymentMethodData($this->paymentMethod)
                    ->setConfirmation(
                        array(
                            'type'      => $this->confirmationType,
                            'returnUrl' => $order->get_checkout_payment_url(true),
                        )
                    );
        }
        YandexMoneyLogger::info('Return url: '.$order->get_checkout_payment_url(true));
        YandexMoneyCheckoutHandler::setReceiptIfNeeded($builder, $order);

        return $builder;
    }

    /**
     * @param WC_Order $order
     *
     * @return string
     */
    public function createDescription($order)
    {
        $descriptionTemplate = get_option('ym_api_description_template',
            __('Оплата заказа №%order_number%', 'yandexcheckout'));

        $replace  = array();
        $patterns = explode('%', $descriptionTemplate);
        foreach ($patterns as $pattern) {
            $value  = null;
            $method = 'get_'.$pattern;
            if (method_exists($order, $method)) {
                $value = $order->{$method}();
            }
            if (!is_null($value) && is_scalar($value)) {
                $replace['%'.$pattern.'%'] = $value;
            }
        }
        $description = strtr($descriptionTemplate, $replace);

        return mb_substr($description, 0, Payment::MAX_LENGTH_DESCRIPTION);
    }

    public function addReceiptAttribute($attributeName, $rawName, $terms)
    {
        $isAttributeCreated = wc_attribute_taxonomy_id_by_name($attributeName);
        if (!$isAttributeCreated) {

            $args = array(
                'name' => $rawName,
                'slug' => $attributeName,
            );
            wc_create_attribute($args);

            $taxonomy_name = wc_attribute_taxonomy_name($attributeName);
            register_taxonomy(
                $taxonomy_name,
                apply_filters('woocommerce_taxonomy_objects_'.$taxonomy_name, array('product')),
                apply_filters('woocommerce_taxonomy_args_'.$taxonomy_name, array(
                    'labels'       => array(
                        'name' => $rawName,
                    ),
                    'hierarchical' => true,
                    'show_ui'      => false,
                    'query_var'    => true,
                    'rewrite'      => false,
                ))
            );
            foreach ($terms as $term => $description) {
                $insert_result = wp_insert_term($term, $taxonomy_name, array(
                    'description' => $description,
                    'parent'      => 0,
                    'slug'        => $term,
                ));
            }
        }
    }

    /**
     * @return bool
     */
    private function saveNewPaymentMethod()
    {
        $savePaymentMethod = is_checkout() && !empty($_POST["wc-{$this->id}-new-payment-method"]);

        return $savePaymentMethod;
    }

    /**
     * @inheritdoc
     */
    public function add_payment_method()
    {
        try {
            $builder = CreatePaymentRequest::builder()
                       ->setAmount('2.00')
                       ->setCapture(false)
                       ->setSavePaymentMethod(true)
                       ->setPaymentMethodData($this->paymentMethod)
                       ->setConfirmation(
                           array(
                               'type'      => ConfirmationType::REDIRECT,
                               'returnUrl' => wc_get_endpoint_url('payment-methods'),
                           )
                       )
                       ->setMetadata(array(
                           'cms_name'       => 'ya_api_woocommerce',
                           'module_version' => YAMONEY_API_VERSION,
                           'wp_user_id'     => get_current_user_id(),
                       ));
            if (YandexMoneyCheckoutHandler::isReceiptEnabled()) {
                $user = wp_get_current_user();
                $builder->setReceiptEmail($user->user_email);
                $builder->addReceiptItem('Recurent test product', '2.00', 1, get_option('ym_api_default_tax_rate'));
            }

            $paymentRequest = $builder->build();

            $response = $this->getApiClient()->createPayment($paymentRequest);

        } catch (ApiException $e) {
            return array(
                'result'   => 'failure',
                'redirect' => wc_get_endpoint_url('payment-methods'),
            );
        }

        return array(
            'result'   => 'success',
            'redirect' => $response->confirmation->confirmationUrl,
        );
    }
}