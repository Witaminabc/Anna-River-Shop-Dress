<?php

/** @var int $isReceiptEnabled */
/** @var int $isSecondReceiptEnabled */
/** @var array $ymTaxRatesEnum */
/** @var array $ymTaxSystemCodesEnum */
/** @var array $ymTaxes */
/** @var string $wcCalcTaxes */
/** @var string $orderStatusReceipt */
/** @var array $wcTaxes */
/** @var array $paymentSubjectEnum */
/** @var array $paymentModeEnum */
/** @var array $wcOrderStatuses */
/** @var bool $isSelfEmployed */
/** @var string $yookassaNonce */
/** @var string $isMarkingEnabled */
?>
<form id="yoomoney-form-4" class="yoomoney-form">
    <div class="col-md-12">

        <div class="row padding-bottom">
            <div class="col-md-12 form-group">
                <div class="custom-control custom-switch qa-enable-receipt-control">
                    <input type="hidden" name="yookassa_enable_receipt" value="0">
                    <input <?=($isReceiptEnabled)?' checked':'';?> type="checkbox" class="custom-control-input" id="yookassa_enable_receipt" name="yookassa_enable_receipt" value="1" data-toggle="collapse" data-target="#tax-collapsible" aria-controls="tax-collapsible">
                    <label class="custom-control-label" for="yookassa_enable_receipt">
                        <?= __('Автоматическая отправка чеков', 'yookassa'); ?>
                    </label>
                </div>
            </div>
        </div>

        <div id="tax-collapsible" class="in collapse<?=($isReceiptEnabled) ? ' show' : ''; ?>">

            <h6 class="qa-title"><?= __('Выберите ваш статус:', 'yookassa'); ?></h6>

            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-3 form-group">
                    <div class="custom-control custom-switch-radio qa-enable-self-employed-control">
                        <label for="yookassa_legal_entity" data-target="yookassa_legal_entity">
                            <input <?= (!$isSelfEmployed) ? ' checked' : ''; ?> type="radio" id="yookassa_legal_entity" name="yookassa_self_employed" value="0">
                            <span><?= __('ИП или юрлицо', 'yookassa'); ?></span>
                        </label>
                        <label for="yookassa_self_employed" data-target="yookassa_self_employed">
                            <input <?= ($isSelfEmployed) ? ' checked' : ''; ?> type="radio" id="yookassa_self_employed" name="yookassa_self_employed" value="1">
                            <span><?= __('Самозанятый', 'yookassa'); ?></span>
                        </label>
                    </div>
                </div>
            </div>


            <div class="content yookassa_self_employed in collapse <?= ($isSelfEmployed) ? 'show' : ''; ?>">
                <div><strong><?= __('Чтобы платёж прошёл и чек отправился:', 'yookassa');?></strong></div>
                <ul>
                    <li>
                        <?= __('В нём должно быть не больше 6 позиций. Позиции — это разные наименования, а не экземпляры одного и того же товара.', 'yookassa');?>
                    </li>
                    <li>
                        <?= __('Количество должно выражаться целым числом, дробные использовать нельзя. Например, 1.5 — не пройдёт, а 2 — пройдёт.', 'yookassa');?>
                    </li>
                    <li>
                        <?= __('Цена каждой позиции должна быть больше 0 ₽ — иначе платёж не пройдёт. Если доставка бесплатная — она автоматически удалится из чека.', 'yookassa');?>
                    </li>
                </ul>
            </div>

            <div class="content yookassa_legal_entity in collapse <?= (!$isSelfEmployed) ? 'show' : ''; ?>">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="qa-title"><?= __('Налоги', 'yookassa'); ?></h5>
                    </div>
                </div>
                <div class="row padding-bottom">
                    <div class="col-md-6 qa-tax-system">
                        <label class="qa-title" for="yookassa_default_tax_system_code"><?= __('Система налогообложения по умолчанию', 'yookassa'); ?></label>
                        <div class="qa-tax-system-control">
                            <p class="help-block text-muted"><?= __('Выберите систему налогообложения по умолчанию. Параметр необходим, только если у вас несколько систем налогообложения, в остальных случаях не передается.', 'yookassa'); ?></p>
                            <select id="yookassa_default_tax_system_code" name="yookassa_default_tax_system_code" class="form-control">
                                <option value="">-</option>
                                <?php foreach ($ymTaxSystemCodesEnum as $taxCodeId => $taxCodeName) : ?>
                                    <option value="<?= $taxCodeId ?>" <?= $taxCodeId == get_option('yookassa_default_tax_system_code') ? 'selected="selected"' : ''; ?>><?= $taxCodeName ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row padding-bottom">
                    <div class="col-md-6 qa-vat">
                        <div class="row padding-bottom">
                            <div class="col-md-12">
                                <label for="yookassa_default_tax_rate" class="qa-title"><?= __('Ставка НДС по умолчанию', 'yookassa'); ?></label>
                                <div class="qa-vat-control">
                                    <p class="help-block text-muted"><?= __('Выберите ставку, которая будет в чеке, если в карточке товара не указана другая ставка.', 'yookassa'); ?></p>
                                    <?php $selected20 = get_option('yookassa_default_tax_rate') == '4'; ?>
                                    <?php $selected120 = get_option('yookassa_default_tax_rate') == '6'; ?>
                                    <select id="yookassa_default_tax_rate" name="yookassa_default_tax_rate" class="form-control yookassa_tax_rate_select">
                                        <?php foreach ($ymTaxRatesEnum as $taxId => $taxName) : ?>
                                            <option value="<?= $taxId ?>" <?= $taxId == get_option('yookassa_default_tax_rate') ? 'selected="selected"' : ''; ?>><?= $taxName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php if ($wcCalcTaxes === 'yes' && $wcTaxes) : ?>
                            <div class="qa-match-rates">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="qa-title"><?= __('Сопоставьте ставки', 'yookassa'); ?></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <label><?= __('Ставка в вашем магазине', 'yookassa'); ?></label>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <label><?= __('Ставка для чека в налоговую', 'yookassa'); ?></label>
                                    </div>
                                </div>
                                <?php foreach ($wcTaxes as $wcTax) : ?>
                                    <div class="row mb-1">
                                        <div class="col-xs-12 col-md-6 qa-shop-rate"><?= round($wcTax->tax_rate) ?>%</div>
                                        <div class="col-xs-6 col-md-6">
                                            <?php
                                                $selected = isset($ymTaxes[$wcTax->tax_rate_id]) ? $ymTaxes[$wcTax->tax_rate_id] : null;
                                                if ($selected == '4') { $selected20 = true; }
                                                if ($selected == '6') { $selected120 = true; }
                                            ?>
                                            <select id="yookassa_tax_rate[<?= $wcTax->tax_rate_id ?>]" name="yookassa_tax_rate[<?= $wcTax->tax_rate_id ?>]" class="form-control qa-control yookassa_tax_rate_select">
                                                <?php foreach ($ymTaxRatesEnum as $taxId => $taxName) : ?>
                                                    <option value="<?= $taxId ?>" <?= $selected == $taxId ? 'selected' : ''; ?> ><?= $taxName ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="col-md-5 col-md-offset-2 help-side ">
                        <div id="if-nds-20" class="info-block very-important" style="display: <?= $selected20 || $selected120 ? 'block' : 'none' ?>">
                            <span class="dashicons dashicons-info" aria-hidden="true"></span>
                            <span class="qa-info-text"><?= __('С 1 января для соответствия 54-ФЗ ставку НДС и расчётную ставку нужно изменить с 20% и 20/120 на 22% и 22/122 — новые платежи будут проходить по ним. Если не поменять, возможны вопросы и штрафы от ФНС, а операции придётся исправлять вручную.', 'yookassa'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="qa-calculation-method">
                    <div class="row">
                        <div class="col">
                            <hr>
                            <h4 class="qa-title"><?= __('54-ФЗ', 'yookassa'); ?></h4>
                        </div>
                    </div>
                    <div class="row padding-bottom">
                        <div class="col-md-6">
                            <h4 class="qa-title"><?= __('Предмет расчёта и способ расчёта', 'yookassa'); ?></h4>
                            <p class="help-block text-muted qa-info"><?= __('Выберите значения, которые будут передаваться по умолчанию. Эти признаки можно настроить у каждой позиции отдельно — в карточке товара.', 'yookassa'); ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-md-3 qa-calculation-subject">
                            <label for="yookassa_payment_subject_default"><?= __('Предмет расчёта', 'yookassa'); ?></label>
                            <select id="yookassa_payment_subject_default" name="yookassa_payment_subject_default" class="form-control">
                                <?php foreach ($paymentSubjectEnum as $id => $subjectName) : ?>
                                    <option value="<?= $id ?>" <?= $id == get_option('yookassa_payment_subject_default') ? 'selected="selected"' : ''; ?>><?= $subjectName ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="help-block"></p>
                        </div>
                        <div class="col-xs-6 col-md-3 qa-calculation-method">
                            <label for="yookassa_payment_mode_default"><?= __('Способ расчёта', 'yookassa'); ?></label>
                            <select id="yookassa_payment_mode_default" name="yookassa_payment_mode_default" class="form-control">
                                <?php foreach ($paymentModeEnum as $id => $modeName) : ?>
                                    <option value="<?= $id ?>" <?= $id == get_option('yookassa_payment_mode_default') ? 'selected="selected"' : ''; ?>><?= $modeName ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="help-block"></p>
                        </div>
                    </div>

                    <div class="row padding-bottom">
                        <div class="col-xs-6 col-md-3 qa-delivery-subject">
                            <label for="yookassa_shipping_payment_subject_default"><?= __('Предмет расчёта для доставки', 'yookassa'); ?></label>
                            <select id="yookassa_shipping_payment_subject_default" name="yookassa_shipping_payment_subject_default" class="form-control">
                                <?php foreach ($paymentSubjectEnum as $id => $subjectName) : ?>
                                    <option value="<?= $id ?>" <?= $id == get_option('yookassa_shipping_payment_subject_default') ? 'selected="selected"' : ''; ?>><?= $subjectName ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="help-block"></p>
                        </div>
                        <div class="col-xs-6 col-md-3 qa-delivery-method">
                            <label for="yookassa_shipping_payment_mode_default"><?= __('Способ расчёта для доставки', 'yookassa'); ?></label>
                            <select id="yookassa_shipping_payment_mode_default" name="yookassa_shipping_payment_mode_default" class="form-control">
                                <?php foreach ($paymentModeEnum as $id => $modeName) : ?>
                                    <option value="<?= $id ?>" <?= $id == get_option('yookassa_shipping_payment_mode_default') ? 'selected="selected"' : ''; ?>><?= $modeName ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="help-block"></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7 form-group">
                        <div class="custom-control custom-switch qa-marking-control">
                            <input type="hidden" name="yookassa_marking_enabled" value="0">
                            <input <?= ($isMarkingEnabled && $isSecondReceiptEnabled) ? ' checked' : ''; ?> type="checkbox" class="custom-control-input" id="yookassa_marking_enabled" name="yookassa_marking_enabled" value="1">
                            <label class="custom-control-label" for="yookassa_marking_enabled">
                                <?= __('Указывать маркировку товара', 'yookassa'); ?>
                            </label>
                        </div>
                        <p class="help-block text-muted qa-marking-control-info">
                            <?= __('Актуальный список товарных категорий, которые нужно маркировать, можно посмотреть на сайте <a href="https://честныйзнак.рф/" target="_blank">Честного знака</a>.', 'yookassa');?>
                        </p>
                    </div>
                </div>

                <div class="qa-second-receipt">
                    <div class="row">
                        <div class="col-md-7 form-group">
                            <div class="custom-control custom-switch qa-second-receipt-control">
                                <input type="hidden" name="yookassa_enable_second_receipt" value="0">
                                <input <?=($isSecondReceiptEnabled)?' checked':'';?> type="checkbox" class="custom-control-input" id="yookassa_enable_second_receipt" name="yookassa_enable_second_receipt" value="1" data-toggle="collapse" data-target="#receipt-collapsible" aria-controls="receipt-collapsible">
                                <label class="custom-control-label" for="yookassa_enable_second_receipt">
                                    <?= __('Формировать второй чек', 'yookassa'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="receipt-collapsible" class="in collapse<?=($isSecondReceiptEnabled) ? ' show' : ''; ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="qa-second-receipt-status">
                                    <label for="yookassa_second_receipt_order_status"><?= __('При переходе заказа в статус', 'yookassa'); ?></label>
                                    <select id="yookassa_second_receipt_order_status" name="yookassa_second_receipt_order_status" class="form-control">
                                        <?php foreach ($wcOrderStatuses as $id => $statusName): ?>
                                            <option value="<?= $id ?>" <?= $id == $orderStatusReceipt ? 'selected="selected"' : ''; ?>><?= $statusName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <p class="help-block text-muted qa-second-receipt-status-info">
                                    <?= __('Если в заказе будут позиции с признаками «Полная предоплата» — второй чек отправится автоматически, когда заказ перейдёт в выбранный статус.', 'yookassa');?>
                                </p>
                            </div>
                            <div class="col-md-4 col-md-offset-2 help-side qa-second-receipt-info">
                                <p class="title qa-title"><b><?= __('Второй чек', 'yookassa'); ?></b></p>
                                <p class="qa-info-text"><?= __('Два чека нужно формировать, если покупатель вносит предоплату и потом получает товар или услугу. Первый чек — когда деньги поступают вам на счёт, второй — при отгрузке товаров или выполнении услуг.', 'yookassa'); ?></p>
                                <p><a class="qa-link" target="_blank" href="https://yookassa.ru/developers/54fz/payments#settlement-receipt"><?= __('Читать про второй чек в ЮKassa &gt;', 'yookassa'); ?></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row form-footer">
            <div class="col-md-12">
                <button class="btn btn-default btn-back qa-back-button" data-tab="section3"><?= __('Назад', 'yookassa'); ?></button>
                <button class="btn btn-primary btn-forward qa-forward-button" data-tab="section5"><?= __('Сохранить и продолжить', 'yookassa'); ?></button>
            </div>
        </div>
    </div>
    <input name="form_nonce" type="hidden" value="<?=$yookassaNonce?>" />
</form>
