<?php


use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Model\ConfirmationType;
use YandexCheckout\Model\PaymentMethodType;
use YandexCheckout\Model\PaymentStatus;
use YandexCheckout\Request\Payments\CreatePaymentRequest;
use YandexCheckout\Request\Payments\CreatePaymentRequestSerializer;

class YandexMoneyWidgetGateway extends YandexMoneyCheckoutGateway
{

    public $paymentMethod = PaymentMethodType::BANK_CARD;

    public $id = 'ym_api_widget';
    /**
     * Gateway title.
     * @var string
     */
    public $method_title;

    public $defaultTitle;

    /**
     * Gateway description.
     * @var string
     */
    public $method_description = '';

    public function __construct()
    {
        parent::__construct();

        $this->icon               = YandexMoneyCheckout::$pluginUrl . '/assets/images/ac_in.png';
        $this->method_title       = __('Платёжный виджет Кассы (карты, Apple Pay и Google Pay)', 'yandexcheckout');
        $this->method_description = __('Покупатель вводит платёжные данные прямо во время заказа, без редиректа на страницу Яндекс.Кассы. Опция работает для платежей с карт (в том числе, через Apple Pay и Google Pay).', 'yandexcheckout');
        $this->title              = __('Банковские карты, Apple Pay, Google Pay', 'yandexcheckout');
        $this->defaultTitle       = __('Банковские карты, Apple Pay, Google Pay', 'yandexcheckout');
        $this->description        = __('Оплата банковской картой на сайте', 'yandexcheckout');
        $this->defaultDescription = __('Оплата банковской картой на сайте', 'yandexcheckout');
    }

    public $confirmationType = ConfirmationType::EMBEDDED;

    /**
     * Receipt Page
     *
     * @param int $order_id
     *
     * @throws Exception
     */
    public function receipt_page($order_id)
    {
        YandexMoneyLogger::info('Receipt page init');

        $order     = new WC_Order($order_id);
        $paymentId = $order->get_transaction_id();
        YandexMoneyLogger::info(
            sprintf(__('Пользователь вернулся с формы оплаты. Id заказа - %1$s. Идентификатор платежа - %2$s.',
                'yandexcheckout'), $order_id, $paymentId)
        );

        $this->render('partials/iframe.php', array(
            'widgetUrl' => get_site_url(null, '?ym-path=ym-widget&order-id=' . $order_id),
            'checkPaymentUrl'  => admin_url('admin-ajax.php') . '?action=yandex_checkout_check_payment&order-id='.$order_id,
            'orderNotPaid' => __('Заказ не был оплачен!', 'yandexcheckout'),
            'tryAgain' => __('Попробовать заново', 'yandexcheckout'),
        ));
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

        $order = new WC_Order($order_id);

        $result     = $this->createPayment($order);
        $receiptUrl = $order->get_checkout_payment_url(true);

        if ($result) {
            $order->set_transaction_id($result->id);

            if ($result->status == PaymentStatus::PENDING) {
                $order->update_status('wc-pending');
//                if (get_option('ym_force_clear_cart') == 'on') {
//                    $woocommerce->cart->empty_cart();
//                }

                return array(
                    'result'   => 'success',
                    'redirect' => $receiptUrl,
                );
            } elseif ($result->status == PaymentStatus::WAITING_FOR_CAPTURE) {
                return array('result' => 'success', 'redirect' => $order->get_checkout_order_received_url());
            } elseif ($result->status == PaymentStatus::SUCCEEDED) {
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
        } else {
            YandexMoneyLogger::warning(sprintf(__('Неудалось создать платеж. Для заказа %1$s', 'yandexcheckout'),
                $order_id));
            wc_add_notice(__('Платеж не прошел. Попробуйте еще или выберите другой способ оплаты', 'yandexcheckout'),
                'error');

            return array('result' => 'fail', 'redirect' => '');
        }
    }

    /**
     * @param WC_Order $order
     *
     * @return mixed|WP_Error|\YandexCheckout\Request\Payments\CreatePaymentResponse
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
     * @param WC_Order $order
     * @param $save
     *
     * @return \YandexCheckout\Request\Payments\CreatePaymentRequestBuilder
     */
    protected function getBuilder($order, $save)
    {
        $enableHold = get_option('ym_api_enable_hold');

        $builder = CreatePaymentRequest::builder()
                   ->setAmount(YandexMoneyCheckoutOrderHelper::getTotal($order))
                   ->setDescription($this->createDescription($order))
                   ->setCapture(!$enableHold)
                   ->setConfirmation(array('type' => ConfirmationType::EMBEDDED))
                   ->setMetadata(array(
                       'cms_name'       => 'ya_api_woocommerce',
                       'module_version' => YAMONEY_API_VERSION,
                       'wp_user_id'     => get_current_user_id(),
                   ));

        YandexMoneyLogger::info('Return url: ' . $order->get_checkout_payment_url(true));
        YandexMoneyCheckoutHandler::setReceiptIfNeeded($builder, $order);

        return $builder;
    }

    private function render($viewPath, $args)
    {
        extract($args);

        include(plugin_dir_path(__FILE__).$viewPath);
    }
}