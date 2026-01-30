<script src="https://kassa.yandex.ru/checkout-ui/v2.js"></script>
<script>
    const checkout = new window.YandexCheckout({
        confirmation_token: '<?= $token; ?>',
        return_url: '<?= $returnUrl ?>&iframe',
        error_callback: function (error) {
            console.log(error);
        }
    });
</script>

<div id="ym-widget-checkout-ui"></div>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        checkout.render('ym-widget-checkout-ui');
    });
</script>
