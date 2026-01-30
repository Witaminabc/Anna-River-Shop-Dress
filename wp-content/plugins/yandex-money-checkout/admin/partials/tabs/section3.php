<?php

/** @var string $descriptionTemplate */
/** @var WP_Post[] $pages */
/** @var bool $forceClearCart */
/** @var bool $isDebugEnabled */
?>
<form id="yandexmoney-form-3" class="yandexmoney-form">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label class="control-label" for="ym_api_description_template">
                        <?= __('Описание платежа', 'yandexcheckout'); ?>
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip"
                              title="<?= __('Это описание транзакции, которое пользователь увидит при оплате, а вы — в личном кабинете Яндекс.Кассы. Например, «Оплата заказа №72». '.
                                  'Чтобы в описание подставлялся номер заказа (как в примере), поставьте на его месте %order_number% (Оплата заказа №%order_number%). '.
                                  'Ограничение для описания — 128 символов.',
                                  'yandexcheckout'); ?>"><span>
                    </label>
                    <textarea type="text" id="ym_api_description_template" name="ym_api_description_template" class="form-control"
                              placeholder="<?= __('Заполните поле', 'yandexcheckout'); ?>"><?= $descriptionTemplate ?></textarea>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label class="control-label" for="ym_api_success">
                        <?= __('Страница успеха', 'yandexcheckout'); ?>
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip"
                              title="<?= __('Эту страницу увидит покупатель, когда оплатит заказ', 'yandexcheckout'); ?>"><span>
                    </label>
                    <select id="ym_api_success" name="ym_api_success" class="form-control">
                        <option value="wc_success" <?php echo((get_option('ym_api_success') == 'wc_success') ? ' selected' : ''); ?>>
                            <?= __('Страница "Заказ принят" от WooCommerce', 'yandexcheckout'); ?>
                        </option>
                        <option value="wc_checkout" <?php echo((get_option('ym_api_success') == 'wc_checkout') ? ' selected' : ''); ?>>
                            <?= __('Страница оформления заказа от WooCommerce', 'yandexcheckout'); ?>
                        </option>
                        <?php
                        if ($pages) {
                            foreach ($pages as $page) {
                                $selected = ($page->ID == get_option('ym_api_success')) ? ' selected' : '';
                                echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label class="control-label" for="ym_api_fail">
                        <?= __('Страница отказа', 'yandexcheckout'); ?>
                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip"
                              title="<?= __('Эту страницу увидит покупатель, если что-то пойдет не так: например, если ему не хватит денег на карте',
                                  'yandexcheckout'); ?>"><span>
                    </label>
                    <select id="ym_api_fail" name="ym_api_fail" class="form-control">
                        <option value="wc_checkout" <?= ((get_option('ym_api_fail') == 'wc_checkout') ? ' selected' : ''); ?>>
                            <?= __('Страница оформления заказа от WooCommerce', 'yandexcheckout'); ?>
                        </option>
                        <option value="wc_payment" <?= ((get_option('ym_api_fail') == 'wc_payment') ? ' selected' : ''); ?>>
                            <?= __('Страница оплаты заказа от WooCommerce', 'yandexcheckout'); ?>
                        </option>
                        <?php
                        if ($pages) {
                            foreach ($pages as $page) {
                                $selected = ($page->ID == get_option('ym_api_fail')) ? ' selected' : '';
                                echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="checkbox">
                        <input type="hidden" name="ym_force_clear_cart" value="0">
                        <input type="checkbox" id="ym_force_clear_cart" name="ym_force_clear_cart" value="1" <?= $forceClearCart ? ' checked="checked" ' : '' ?>>
                        <label class="control-label" for="ym_force_clear_cart">
                            <?= __('Удалить товары из корзины, когда покупатель переходит к оплате.', 'yandexcheckout'); ?>
                        </label>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="checkbox">
                        <input type="hidden" name="ym_debug_enabled" value="0">
                        <input type="checkbox" id="ym_debug_enabled" name="ym_debug_enabled" value="1" <?= $isDebugEnabled ? ' checked="checked" ' : '' ?>>
                        <label class="control-label" for="ym_debug_enabled">
                            <?= __('Запись отладочной информации', 'yandexcheckout'); ?>
                        </label>
                    </div>
                    <p class="help-block help-block-error">
                        <?= __('Настройку нужно будет поменять, только если попросят специалисты Яндекс.Денег', 'yandexcheckout'); ?>
                    </p>
                    <?php if ($isDebugEnabled && file_exists(WP_CONTENT_DIR.'/ym-checkout-debug.log')): ?>
                        <p>
                            <a class="btn-link" href="<?= content_url(); ?>/ym-checkout-debug.log"
                               target="_blank" rel="nofollow" download="debug.log"><?= __('Скачать лог', 'yandexcheckout'); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row form-footer">
            <div class="col-md-12">
                <button class="btn btn-default btn-back" data-tab="section2"><?= __('Назад', 'yandexcheckout'); ?></button>
                <button class="btn btn-primary btn-forward" data-tab="section4"><?= __('Сохранить и продолжить', 'yandexcheckout'); ?></button>
            </div>
        </div>
    </div>
</form>
