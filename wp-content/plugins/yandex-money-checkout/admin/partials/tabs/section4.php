<?php

/** @var int $isReceiptEnabled */
/** @var int $isSecondReceiptEnabled */
/** @var array $ymTaxRatesEnum */
/** @var array $ymTaxes */
/** @var string $wcCalcTaxes */
/** @var string $orderStatusReceipt */
/** @var array $wcTaxes */
/** @var array $paymentSubjectEnum */
/** @var array $paymentModeEnum */
/** @var array $wcOrderStatuses */
?>
<form id="yandexmoney-form-4" class="yandexmoney-form">
    <div class="col-md-12">

        <div class="row padding-bottom">
            <div class="col-md-12 form-group">
                <div class="btn-group btn-toggle" data-toggle="buttons" id="ym_api_enable_receipt">
                    <label class="btn<?=(!$isReceiptEnabled)?' btn-primary active':' btn-default';?>" data-toggle="collapse" data-target="#tax-collapsible">
                        <input type="radio" name="ym_api_enable_receipt" value="0"<?=(!$isReceiptEnabled)?' checked':'';?>> <?= __('Выкл', 'yandexcheckout'); ?>
                    </label>
                    <label class="btn<?=($isReceiptEnabled)?' btn-primary active':' btn-default';?>" data-toggle="collapse" data-target="#tax-collapsible">
                        <input type="radio" name="ym_api_enable_receipt" value="1"<?=($isReceiptEnabled)?' checked':'';?>> <?= __('Вкл', 'yandexcheckout'); ?>
                    </label>
                </div>
                <?= __('Отправлять в Яндекс.Кассу данные для чеков (54-ФЗ)', 'yandexcheckout'); ?>
            </div>
        </div>

        <div id="tax-collapsible" class="collapse<?=($isReceiptEnabled) ? ' in' : ''; ?>" aria-expanded="<?=($isReceiptEnabled)?'true':'false';?>">

            <div class="row padding-bottom">
                <div class="col-md-6">
                    <label for="ym_api_default_tax_rate"><?= __('Ставка НДС по умолчанию', 'yandexcheckout'); ?></label>
                    <p class="help-block text-muted"><?= __('Выберите ставку, которая будет в чеке, если в карточке товара не указана другая ставка.', 'yandexcheckout'); ?></p>
                    <select id="ym_api_default_tax_rate" name="ym_api_default_tax_rate" class="form-control">
                        <?php foreach ($ymTaxRatesEnum as $taxId => $taxName) : ?>
                            <option value="<?= $taxId ?>" <?= $taxId == get_option('ym_api_default_tax_rate') ? 'selected="selected"' : ''; ?>><?= $taxName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if ($wcCalcTaxes == 'yes' && $wcTaxes) : ?>
            <div class="row">
                <div class="col-md-12">
                    <h4><?= __('Сопоставьте ставки', 'yandexcheckout'); ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <label><?= __('Ставка в вашем магазине', 'yandexcheckout'); ?></label>
                </div>
                <div class="col-xs-6 col-md-3">
                    <label><?= __('Ставка для чека в налоговую', 'yandexcheckout'); ?></label>
                </div>
            </div>
            <?php foreach ($wcTaxes as $wcTax) : ?>
            <div class="row">
                <div class="col-xs-6 col-md-3"><?= round($wcTax->tax_rate) ?>%</div>
                <div class="col-xs-6 col-md-3">
                    <?php $selected = isset($ymTaxes[$wcTax->tax_rate_id]) ? $ymTaxes[$wcTax->tax_rate_id] : null; ?>
                    <select id="ym_api_tax_rate[<?= $wcTax->tax_rate_id ?>]" name="ym_api_tax_rate[<?= $wcTax->tax_rate_id ?>]" class="form-control">
                        <?php foreach ($ymTaxRatesEnum as $taxId => $taxName) : ?>
                            <option value="<?= $taxId ?>" <?= $selected == $taxId ? 'selected' : ''; ?> ><?= $taxName ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="row padding-bottom padding-top">
                <div class="col-md-6">
                    <h4><?= __('Предмет расчёта и способ расчёта (ФФД 1.05)', 'yandexcheckout'); ?></h4>
                    <p class="help-block text-muted"><?= __('Выберите значения, которые будут передаваться по умолчанию. Эти признаки можно настроить у каждой позиции отдельно — в карточке товара.', 'yandexcheckout'); ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-3">
                    <label for="ym_api_payment_subject_default"><?= __('Предмет расчёта', 'yandexcheckout'); ?></label>
                    <select id="ym_api_payment_subject_default" name="ym_api_payment_subject_default" class="form-control">
                        <?php foreach ($paymentSubjectEnum as $id => $subjectName) : ?>
                            <option value="<?= $id ?>" <?= $id == get_option('ym_api_payment_subject_default') ? 'selected="selected"' : ''; ?>><?= $subjectName ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="help-block"></p>
                </div>
                <div class="col-xs-6 col-md-3">
                    <label for="ym_api_payment_mode_default"><?= __('Способ расчёта', 'yandexcheckout'); ?></label>
                    <select id="ym_api_payment_mode_default" name="ym_api_payment_mode_default" class="form-control">
                        <?php foreach ($paymentModeEnum as $id => $modeName) : ?>
                            <option value="<?= $id ?>" <?= $id == get_option('ym_api_payment_mode_default') ? 'selected="selected"' : ''; ?>><?= $modeName ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="row padding-bottom">
                <div class="col-xs-6 col-md-3">
                    <label for="ym_api_shipping_payment_subject_default"><?= __('Предмет расчёта для доставки', 'yandexcheckout'); ?></label>
                    <select id="ym_api_shipping_payment_subject_default" name="ym_api_shipping_payment_subject_default" class="form-control">
                        <?php foreach ($paymentSubjectEnum as $id => $subjectName) : ?>
                            <option value="<?= $id ?>" <?= $id == get_option('ym_api_shipping_payment_subject_default') ? 'selected="selected"' : ''; ?>><?= $subjectName ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="help-block"></p>
                </div>
                <div class="col-xs-6 col-md-3">
                    <label for="ym_api_shipping_payment_mode_default"><?= __('Способ расчёта для доставки', 'yandexcheckout'); ?></label>
                    <select id="ym_api_shipping_payment_mode_default" name="ym_api_shipping_payment_mode_default" class="form-control">
                        <?php foreach ($paymentModeEnum as $id => $modeName) : ?>
                            <option value="<?= $id ?>" <?= $id == get_option('ym_api_shipping_payment_mode_default') ? 'selected="selected"' : ''; ?>><?= $modeName ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 form-group">
                    <div class="btn-group btn-toggle" data-toggle="buttons" id="ym_api_enable_second_receipt">
                        <label class="btn<?=(!$isSecondReceiptEnabled)?' btn-primary active':' btn-default';?>" data-toggle="collapse" data-target="#receipt-collapsible">
                            <input type="radio" name="ym_api_enable_second_receipt" value="0"<?=(!$isSecondReceiptEnabled)?' checked':'';?>> <?= __('Выкл', 'yandexcheckout'); ?>
                        </label>
                        <label class="btn<?=($isSecondReceiptEnabled)?' btn-primary active':' btn-default';?>" data-toggle="collapse" data-target="#receipt-collapsible">
                            <input type="radio" name="ym_api_enable_second_receipt" value="1"<?=($isSecondReceiptEnabled)?' checked':'';?>> <?= __('Вкл', 'yandexcheckout'); ?>
                        </label>
                    </div>
                    <?= __('Формировать второй чек', 'yandexcheckout'); ?>
                </div>
            </div>

            <div id="receipt-collapsible" class="collapse<?=($isSecondReceiptEnabled) ? ' in' : ''; ?>" aria-expanded="<?=($isSecondReceiptEnabled)?'true':'false';?>">
                <div class="row">
                    <div class="col-md-6">
                        <label for="ym_api_shipping_payment_mode_default"><?= __('При переходе заказа в статус', 'yandexcheckout'); ?></label>
                        <select id="ym_api_second_receipt_order_status" name="ym_api_second_receipt_order_status" class="form-control">
                            <?php foreach ($wcOrderStatuses as $id => $statusName): ?>
                                <option value="<?= $id ?>" <?= $id == $orderStatusReceipt ? 'selected="selected"' : ''; ?>><?= $statusName ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block text-muted">
                            <?= __('Если в заказе будут позиции с признаками «Полная предоплата» — второй чек отправится автоматически, когда заказ перейдёт в выбранный статус.', 'yandexcheckout');?>
                        </p>
                    </div>
                    <div class="col-md-4 col-md-offset-2 help-side">
                        <p class="title"><b><?= __('Второй чек', 'yandexcheckout'); ?></b></p>
                        <p><?= __('Два чека нужно формировать, если покупатель вносит предоплату и потом получает товар или услугу. Первый чек — когда деньги поступают вам на счёт, второй — при отгрузке товаров или выполнении услуг.', 'yandexcheckout'); ?></p>
                        <p><a target="_blank" href="https://kassa.yandex.ru/developers/54fz/payments#settlement-receipt"><?= __('Читать про второй чек в Яндекс.Кассе &gt;', 'yandexcheckout'); ?></a></p>

                    </div>
                </div>
            </div>

        </div>

        <div class="row form-footer">
            <div class="col-md-12">
                <button class="btn btn-default btn-back" data-tab="section3"><?= __('Назад', 'yandexcheckout'); ?></button>
                <button class="btn btn-primary btn-forward" data-tab="section5"><?= __('Сохранить и продолжить', 'yandexcheckout'); ?></button>
            </div>
        </div>
    </div>
</form>
