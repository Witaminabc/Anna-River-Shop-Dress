<?php

use YandexCheckout\Client;
use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Model\ConfirmationType;
use YandexCheckout\Model\Notification\NotificationFactory;
use YandexCheckout\Model\Payment;
use YandexCheckout\Model\PaymentMethod\PaymentMethodBankCard;
use YandexCheckout\Model\PaymentMethod\PaymentMethodYandexWallet;
use YandexCheckout\Model\PaymentMethodType;
use YandexCheckout\Model\PaymentStatus;

/**
 * The payment-facing functionality of the plugin.
 */
class YandexMoneyCheckoutPayment
{
    /**
     * @var Client
     */
    private $apiClient;

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }

    public function displayWidget()
    {
        global $wp;
        if (isset($_GET['ym-path']) && $_GET['ym-path'] == 'ym-widget') {
            $this->renderWidget($_GET['order-id']);
            die();
        }
        if (!empty( $wp->query_vars['order-received'] ) && isset($_GET['iframe'])) {
            echo '<html><body></body></html>';
            die();
        }
    }

    /**
     * @param int $order_id
     */
    public function renderWidget($order_id)
    {
        YandexMoneyLogger::info('hook init');
        $apiClient = $this->getApiClient();
        $order     = new WC_Order($order_id);
        $paymentId = $order->get_transaction_id();

        try {
            $payment = $apiClient->getPaymentInfo($paymentId);
            if ($confirmation = $payment->getConfirmation()) {
                if ( $confirmation->getType() === ConfirmationType::REDIRECT ) {
                    if ( $redirectUrl = $confirmation->getConfirmationUrl() ) {
                        wp_redirect( $redirectUrl );
                    }
                }
                $token     = $payment->getConfirmation()->getConfirmationToken();
                $returnUrl = $order->get_checkout_order_received_url();

                echo $this->render('partials/layout.php', array(
                    'content' => $this->render('partials/widget.php', array(
                        'token'     => $token,
                        'returnUrl' => $returnUrl,
                    ))
                ));
            } else {
                if ($payment->getStatus() == PaymentStatus::SUCCEEDED) {
                    echo $this->render('partials/layout.php', array(
                        'content' => '<p>'.__('Заказ уже оплачен!', 'yandexcheckout').'</p>'
                    ));
                } elseif ($payment->getStatus() == PaymentStatus::CANCELED) {
                    echo $this->render('partials/layout.php', array(
                        'content' => '<p>'.__('Заказ не был оплачен!', 'yandexcheckout').'</p>'
                                   . '<p><a href="'.$order->get_checkout_payment_url().'" target="_top" class="woocommerce-button button pay">'.__('Попробовать заново', 'yandexcheckout').'</a></p>'
                    ));
                }
            }

        } catch (ApiException $e) {
            echo $this->render('partials/layout.php', array(
                'content' => '<p>'.__('Что-то пошло не так!', 'yandexcheckout').'</p>'
                           . '<p><a href="'.$order->get_checkout_payment_url().'" target="_top" class="woocommerce-button button pay">'.__('Попробовать заново', 'yandexcheckout').'</a></p>'
            ));
            YandexMoneyLogger::error('Api error: '.$e->getMessage());
        }
    }

    /**
     * @param $viewPath
     * @param $args
     *
     * @return false|string
     */
    private function render($viewPath, $args)
    {
        ob_start();
        extract($args);
        include (plugin_dir_path(__FILE__) . $viewPath);
//        ob_flush();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    public function addGateways($methods)
    {
        global $woocommerce;
        $installmentsOn = !isset($woocommerce->cart)
                          || !isset($woocommerce->cart->total)
                          || $woocommerce->cart->total >= YandexMoneyCheckoutInstallments::MIN_AMOUNT;

        $shopPassword = get_option('ym_api_shop_password');
        $prefix       = substr($shopPassword, 0, 4);

        $testMode  = $prefix == "test";
        $methods[] = 'YandexMoneyWidgetGateway';
        if ($testMode) {
            $methods[] = 'YandexMoneyGatewayCard';
            $methods[] = 'YandexMoneyGatewayWallet';
        } else {
            if (get_option('ym_enable_sbbol') == 'on') {
                $methods[] = 'YandexMoneyGatewayB2bSberbank';
            }

            if (get_option('ym_api_pay_mode') == '1') {
                $methods[] = 'YandexMoneyGatewayEPL';
                if ((get_option('ym_api_epl_installments') == '1') && $installmentsOn) {
                    $methods[] = 'YandexMoneyGatewayInstallments';
                }
            } else {
                $methods[] = 'YandexMoneyGatewayCard';
                $methods[] = 'YandexMoneyGatewayAlfabank';
                $methods[] = 'YandexMoneyGatewayQiwi';
                $methods[] = 'YandexMoneyGatewayCash';
                $methods[] = 'YandexMoneyGatewayWebmoney';
                $methods[] = 'YandexMoneyGatewaySberbank';
                $methods[] = 'YandexMoneyGatewayWallet';
                $methods[] = 'YandexMoneyGatewayTinkoffBank';
                if ($installmentsOn) {
                    $methods[] = 'YandexMoneyGatewayInstallments';
                }
            }
        }

        return $methods;
    }

    public function loadGateways()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyCheckoutGateway.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayCard.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayAlfabank.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayQiwi.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayWebmoney.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayCash.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewaySberbank.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayWallet.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayEPL.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayInstallments.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayB2bSberbank.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyGatewayTinkoffBank.php';
        require_once plugin_dir_path(dirname(__FILE__)).'gateway/YandexMoneyWidgetGateway.php';
    }

    public function processCallback()
    {
        if (
            $_SERVER['REQUEST_METHOD'] == "POST" &&
            isset($_REQUEST['yandex_money'])
            && $_REQUEST['yandex_money'] == 'callback'
        ) {

            YandexMoneyLogger::info('Notification init');
            $body           = @file_get_contents('php://input');
            $callbackParams = json_decode($body, true);
            YandexMoneyLogger::info('Notification body: '.$body);

            if (!json_last_error()) {
                try {
                    $this->processNotification($callbackParams);
                } catch (Exception $e) {
                    YandexMoneyLogger::error("Error while process notification: ".$e->getMessage());
                }
            } else {
                YandexMoneyLogger::info('Notification json error');
                header("HTTP/1.1 400 Bad Request");
                header("Status: 400 Bad Request");
            }
            exit();
        }
    }

    public function returnUrl()
    {
        global $wp;
        if (!empty($wp->query_vars['order-pay'])) {

            $this->order_pay($wp->query_vars['order-pay']);

        }
    }

    /**
     * @param $callbackParams
     *
     * @throws ApiException
     * @throws \YandexCheckout\Common\Exceptions\BadApiRequestException
     * @throws \YandexCheckout\Common\Exceptions\ForbiddenException
     * @throws \YandexCheckout\Common\Exceptions\InternalServerError
     * @throws \YandexCheckout\Common\Exceptions\NotFoundException
     * @throws \YandexCheckout\Common\Exceptions\ResponseProcessingException
     * @throws \YandexCheckout\Common\Exceptions\TooManyRequestsException
     * @throws \YandexCheckout\Common\Exceptions\UnauthorizedException
     * @throws Exception
     */
    protected function processNotification($callbackParams)
    {
        try {
            $fabric = new NotificationFactory();
            $notificationModel = $fabric->factory($callbackParams);

        } catch (\Exception $e) {
            YandexMoneyLogger::error('Invalid notification object - '.$e->getMessage());
            header("HTTP/1.1 400 Bad Request");
            header("Status: 400 Bad Request");
            exit();
        }

        /** @var Payment $payment */
        $payment = $notificationModel->getObject();
        $order   = YandexMoneyCheckoutOrderHelper::getOrderIdByPayment($payment->getId());
        if (!$order) {
            $paymentMethod = $payment->getPaymentMethod();
            $userId        = $payment->getMetadata()->offsetGet('wp_user_id');
            $token         = null;
            if (!empty($userId)) {
                $tokens = WC_Payment_Tokens::get_customer_tokens($userId);
                foreach ($tokens as $tokenObject) {
                    if ($tokenObject->get_token() == $paymentMethod->id) {
                        $token = $tokenObject;
                        break;
                    }
                }
            }

            YandexMoneyLogger::info('Process notification init');

            if ($paymentMethod->getSaved() && $payment->getMetadata()->offsetExists('wp_user_id') && $payment->getStatus() === PaymentStatus::WAITING_FOR_CAPTURE) {
                YandexMoneyLogger::info('Token init');
                try {
                    $token = $this->prepareToken($paymentMethod, $payment, $token);
                } catch (\Exception $e) {
                    YandexMoneyLogger::error('Token prepare failed '.$e->getMessage());
                }

                YandexMoneyLogger::info('Token before save');

                if ($token->save()) {
                    YandexMoneyLogger::info('Token saved id:'.$token->get_id());
                    $this->getApiClient()->cancelPayment($payment->getId());
                    exit();
                } else {
                    YandexMoneyLogger::info('Token validate failed');
                }
            }

            YandexMoneyLogger::error('Order not found for payment '.$payment->getId());
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit();
        }

        $payment = $this->getApiClient()->getPaymentInfo($payment->getId());

        if ($payment->getStatus() === PaymentStatus::SUCCEEDED) {
            /** @var PaymentMethodYandexWallet $paymentMethod */
            $paymentMethod = $payment->paymentMethod;
            $userId        = $payment->getMetadata()->offsetGet('wp_user_id');

            if ($paymentMethod->getSaved() && !empty($userId)) {
                $token = $this->prepareToken($paymentMethod, $payment);
                if (!$token->save()) {
                    YandexMoneyLogger::info('Token validate failed');
                } else {
                    YandexMoneyLogger::info('Token saved id:'.$token->get_id());
                }
            } else {
                YandexMoneyLogger::info('Token not entered saved = ' . $paymentMethod->getSaved() . ' !empty($userId) = ' . $userId);
            }
            YandexMoneyLogger::info('Init complete order');
            YandexMoneyCheckoutHandler::completeOrder($order, $payment);
        } elseif ($payment->getStatus() === PaymentStatus::WAITING_FOR_CAPTURE) {
            YandexMoneyLogger::info('Init waiting for capture');
            if ($payment->getPaymentMethod()->getType() === PaymentMethodType::BANK_CARD) {
                YandexMoneyCheckoutHandler::holdOrder($order, $payment);
            } else {
                YandexMoneyCheckoutHandler::capturePayment($this->getApiClient(), $order, $payment);
            }
        } else {
            YandexMoneyLogger::error('Wrong payment status: '.$payment->getStatus());
            header("HTTP/1.1 402 Payment Required");
            header("Status: 402 Payment Required");
        }

        exit();
    }

    public function validStatuses()
    {
        return array('processing', 'completed', 'on-hold', 'pending');
    }

    public function checkPaymentStatus()
    {
        YandexMoneyLogger::info('CheckPaymentStatus Init: ' . $_GET['order-id']);
        $order_id  = $_GET['order-id'];
        $order     = wc_get_order($order_id);
        $paymentId = $order->get_transaction_id();

        try {
            $payment = $this->getApiClient()->getPaymentInfo($paymentId);
            $result = json_encode(array(
                'result' => 'success',
                'status' => $payment->getStatus(),
                'redirectUrl' => $order->get_checkout_payment_url()
            ));
            YandexMoneyLogger::info('CheckPaymentStatus: ' . $result);
            echo $result;
        } catch (Exception $e) {
            YandexMoneyLogger::error('CheckPaymentStatus Error: ' . $e->getMessage());
        }
        wp_die();
    }

    /**
     * @param int $order_id
     *
     * @throws Exception
     */
    public function changeOrderStatusToProcessing($order_id)
    {
        YandexMoneyLogger::info('Init changeOrderStatusToProcessing');
        if (!get_option('ym_api_enable_hold')) {
            return;
        }
        if (!$order_id) {
            return;
        }

        $order     = wc_get_order($order_id);
        $paymentId = $order->get_transaction_id();

        try {
            $payment = $this->getApiClient()->getPaymentInfo($paymentId);

            $payment = YandexMoneyCheckoutHandler::capturePayment($this->getApiClient(), $order, $payment);
            if ($payment->getStatus() === PaymentStatus::SUCCEEDED) {
                $order->payment_complete($payment->getId());
                $order->add_order_note(__('Вы подтвердили платёж в Яндекс.Кассе.', 'yandexcheckout'));
            } elseif ($payment->getStatus() === PaymentStatus::CANCELED) {
                YandexMoneyCheckoutHandler::cancelOrder($order, $payment);
                $order->add_order_note(__('Платёж не подтвердился. Попробуйте ещё раз.', 'yandexcheckout'));
            } else {
                $order->update_status(YandexMoneyCheckoutOrderHelper::WC_STATUS_ON_HOLD);
                $order->add_order_note(__('Платёж не подтвердился. Попробуйте ещё раз.', 'yandexcheckout'));
            }
        } catch (ApiException $e) {
            $order->update_status(YandexMoneyCheckoutOrderHelper::WC_STATUS_ON_HOLD);
            $order->add_order_note(__('Платёж не подтвердился. Попробуйте ещё раз.', 'yandexcheckout'));
            YandexMoneyLogger::error('Api error: '.$e->getMessage());
        }
    }

    /**
     * @param int $order_id
     *
     * @throws Exception
     */
    public function changeOrderStatusToCancelled($order_id)
    {
        YandexMoneyLogger::info('Init changeOrderStatusToCancelled');
        if (!get_option('ym_api_enable_hold')) {
            return;
        }
        if (!$order_id) {
            return;
        }

        $order     = wc_get_order($order_id);
        $paymentId = $order->get_transaction_id();

        try {
            $payment = $this->getApiClient()->cancelPayment($paymentId);
            if ($payment->getStatus() === PaymentStatus::CANCELED) {
                $order->add_order_note(__('Вы отменили платёж в Яндекс.Кассе. Деньги вернутся клиенту.'));
            } else {
                $order->update_status(YandexMoneyCheckoutOrderHelper::WC_STATUS_ON_HOLD);
                $order->add_order_note(__('Платёж не отменился. Попробуйте ещё раз.', 'yandexcheckout'));
            }
        } catch (ApiException $e) {
            $order->update_status(YandexMoneyCheckoutOrderHelper::WC_STATUS_ON_HOLD);
            $order->add_order_note(__('Платёж не отменился. Попробуйте ещё раз.', 'yandexcheckout'));
            YandexMoneyLogger::error('Api error: '.$e->getMessage());
        }
    }

    public function getAccountSavedPaymentMethodsListItem($item, $payment_token)
    {
        if ('ym' === strtolower($payment_token->get_type())) {
            $item['method']['last4'] = $payment_token->get_last4();
            $item['method']['brand'] = esc_html__('Кошелек Яндекс.Деньги', 'yandexcheckout');
        }

        return $item;
    }

    /**
     * @return Client
     */
    private function getApiClient()
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
     * @param $paymentMethod
     * @param $payment
     *
     * @return WC_Payment_Token|WC_Payment_Token_CC
     */
    protected function prepareToken($paymentMethod, $payment)
    {

        if ($paymentMethod->getType() == PaymentMethodType::BANK_CARD) {

            $userId = $payment->getMetadata()->offsetGet('wp_user_id');
            $token  = null;
            if (!empty($userId)) {
                $tokens = WC_Payment_Tokens::get_customer_tokens($userId, 'ym_api_'.$paymentMethod->getType());
                foreach ($tokens as $token) {
                    if ($token->get_token() == $paymentMethod->id || $token->get_last4() == $paymentMethod->getLast4()) {
                        return $token;
                    }
                }
            }

            $token = new WC_Payment_Token_CC();

            /** @var PaymentMethodBankCard $paymentMethod */
            $token->set_card_type($paymentMethod->getCardType());
            $token->set_last4($paymentMethod->getLast4());
            $token->set_expiry_month($paymentMethod->getExpiryMonth());
            $token->set_expiry_year($paymentMethod->getExpiryYear());
            $token->set_gateway_id('ym_api_'.$paymentMethod->getType());
        } else {
            $accountLast4 = substr($paymentMethod->getAccountNumber(), -4);

            $userId = $payment->getMetadata()->offsetGet('wp_user_id');
            $token  = null;
            if (!empty($userId)) {
                $tokens = WC_Payment_Tokens::get_customer_tokens($userId, 'ym_api_wallet');
                foreach ($tokens as $token) {
                    if ($token->get_token() == $paymentMethod->id || $token->get_last4() == $accountLast4) {
                        return $token;
                    }
                }
            }

            $token = new WC_Payment_Token_YM();
            $token->set_gateway_id('ym_api_wallet');
            /** @var PaymentMethodYandexWallet $paymentMethod */
            $token->set_last4($accountLast4);
        }

        $token->set_token($paymentMethod->id);
        $token->set_user_id($payment->getMetadata()->offsetGet('wp_user_id'));

        return $token;
    }
}
