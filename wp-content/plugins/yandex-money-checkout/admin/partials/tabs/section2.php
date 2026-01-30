<?php

/* @var int $testMode */
/* @var int $payMode */
/* @var int $isHoldEnabled */
/* @var int $isSbBOLEnabled */
?>
<form id="yandexmoney-form-2" class="yandexmoney-form">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 padding-bottom">
                <div class="form-group">
                    <label for="ym_api_pay_mode"><?= __('Сценарий оплаты', 'yandexcheckout'); ?></label>
                    <select id="ym_api_pay_mode" name="ym_api_pay_mode" class="form-control">
                        <option value="0" <?= ($payMode != 1 || $testMode) ? 'selected="selected"' : ''; ?>><?= __('Выбор оплаты на стороне магазина', 'yandexcheckout'); ?></option>
                        <?php if (!$testMode): ?>
                        <option value="1" <?= $payMode == 1 ? 'selected="selected"' : ''; ?>><?= __('Выбор оплаты на стороне сервиса Яндекс.Касса', 'yandexcheckout'); ?></option>
                        <?php endif; ?>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>

            </div>
            <div class="col-md-5 col-md-offset-1 help-side">
                <p class="title"><b><?= __('Способы оплаты', 'yandexcheckout'); ?></b></p>
                <p id="pay-mode-1" class="pay-mode-block" style="<?= (!$testMode && $payMode == 1) ? '' : 'display:none;'; ?>">
                    <?= __('Покупатель выбирает способ оплаты и вводит платёжные данные на странице Кассы.', 'yandexcheckout'); ?><br><br>
                    <a target="_blank" href="https://kassa.yandex.ru/help/payments/accept-methods.html"><?= __('Подробнее о способах оплаты &gt;', 'yandexcheckout'); ?></a>
                </p>
                <p id="pay-mode-0" class="pay-mode-block" style="<?= ($testMode || $payMode != 1) ? '' : 'display:none;'; ?>">
                    <?= __('Выберите способы, которые подключены в Яндекс.Кассе.', 'yandexcheckout'); ?><br>
                    <?= __('После этого они появятся в платёжной форме на сайте.', 'yandexcheckout'); ?><br><br>
                    <a target="_blank" href="https://kassa.yandex.ru/help/payments/accept-methods.html"><?= __('Подробнее о способах оплаты &gt;', 'yandexcheckout'); ?></a>
                </p>
            </div>
        </div>

        <div id="ym_api_epl_installments_row" class="row" style="<?=($testMode) ? 'display:none;' : '' ?>">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="checkbox">
                        <input type="hidden" name="ym_api_epl_installments" value="0">
                        <input type="checkbox" id="ym_api_epl_installments" name="ym_api_epl_installments" value="1" <?= get_option('ym_api_epl_installments') == '1' ? ' checked="checked" ' : '' ?>>
                        <label class="control-label" for="ym_api_epl_installments">
                            <?= __('Добавить метод «Заплатить по частям» на страницу оформления заказа', 'yandexcheckout'); ?>
                        </label>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row padding-bottom">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="checkbox">
                        <input type="hidden" name="ym_api_add_installments_block" value="0">
                        <input type="checkbox" id="ym_api_add_installments_block" name="ym_api_add_installments_block" value="1" <?= get_option('ym_api_add_installments_block') == '1' ? ' checked="checked" ' : '' ?>>
                        <label class="control-label" for="ym_api_add_installments_block">
                            <?= __('Добавить блок «Заплатить по частям» в карточки товаров', 'yandexcheckout'); ?>
                        </label>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 form-group">
                <div class="btn-group btn-toggle" data-toggle="buttons">
                    <label class="btn<?=(!$isHoldEnabled)?' btn-primary active':' btn-default';?>">
                        <input type="radio" name="ym_api_enable_hold" value="0"<?=(!$isHoldEnabled)?' checked':'';?>> <?= __('Выкл', 'yandexcheckout'); ?>
                    </label>
                    <label class="btn<?=($isHoldEnabled)?' btn-primary active':' btn-default';?>">
                        <input type="radio" name="ym_api_enable_hold" value="1"<?=($isHoldEnabled)?' checked':'';?>> <?= __('Вкл', 'yandexcheckout'); ?>
                    </label>
                </div>
                <?= __('Отложенные платежи', 'yandexcheckout'); ?>
            </div>
        </div>
        <div class="row padding-bottom">
            <div class="col-md-6">
                <p><small class="text-muted"><?= __('Если опция включена, платежи с карт проходят в 2 этапа: у клиента сумма замораживается, и вам вручную нужно подтвердить её списание – через панель администратора', 'yandexcheckout'); ?></small></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 form-group">
                <div class="btn-group btn-toggle" data-toggle="buttons">
                    <label class="btn<?=(!$isSbBOLEnabled)?' btn-primary active':' btn-default';?>" data-toggle="collapse" data-target="#sbbol-collapsible">
                        <input type="radio" name="ym_enable_sbbol" value="0"<?=(!$isSbBOLEnabled)?' checked':'';?>> <?= __('Выкл', 'yandexcheckout'); ?>
                    </label>
                    <label class="btn<?=($isSbBOLEnabled)?' btn-primary active':' btn-default';?>" data-toggle="collapse" data-target="#sbbol-collapsible">
                        <input type="radio" name="ym_enable_sbbol" value="1"<?=($isSbBOLEnabled)?' checked':'';?>> <?= __('Вкл', 'yandexcheckout'); ?>
                    </label>
                </div>
                <?= __('Сбербанк Бизнес онлайн', 'yandexcheckout'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p><small class="text-muted">
                        <?= __('Если опция включена, вы можете принимать онлайн-платежи от юрлиц через Сбербанк Бизнес Онлайн.', 'yandexcheckout'); ?>
                        <?= __("Подробнее — на <a target='_blank' href='https://kassa.yandex.ru/help/payments/b2b-payments.html'>сайте Кассы</a>.", 'yandexcheckout'); ?>

                    </small></p>
            </div>
        </div>

        <div id="sbbol-collapsible" class="row collapse<?=($isSbBOLEnabled)?' in':'';?>" aria-expanded="<?=($isSbBOLEnabled)?'true':'false';?>">
            <div class="col-md-6">
                <div class="info-block">
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                    <?= __('При оплате через Сбербанк Бизнес Онлайн есть ограничение: в одном чеке могут быть только товары с одинаковой ставкой НДС. Если клиент захочет оплатить за один раз товары с разными ставками — мы покажем ему сообщение, что так сделать не получится.', 'yandexcheckout'); ?>
                </div>
            </div>
        </div>


        <div class="row form-footer">
            <div class="col-md-12">
                <button class="btn btn-default btn-back" data-tab="section1"><?= __('Назад', 'yandexcheckout'); ?></button>
                <button class="btn btn-primary btn-forward" data-tab="section3"><?= __('Сохранить и продолжить', 'yandexcheckout'); ?></button>
            </div>
        </div>
    </div>

</form>
