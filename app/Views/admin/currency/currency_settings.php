<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans("currency_settings")); ?></h3>
            </div>
            <form action="<?= base_url('Admin/currencySettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('default_currency')); ?></label>
                        <select name="default_currency" class="form-control" required>
                            <option value=""><?= esc(trans("select")); ?></option>
                            <?php if (!empty($currencies)):
                                foreach ($currencies as $item):
                                    if ($item->status == 1):?>
                                        <option value="<?= $item->code; ?>" <?= $paymentSettings->default_currency == $item->code ? 'selected' : ''; ?>><?= $item->name . ' (' . $item->symbol . ')'; ?></option>
                                    <?php endif;
                                endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("allow_all_currencies_classified_ads")); ?></label>
                        <?= formRadio('allow_all_currencies_for_classied', 1, 0, trans("yes"), trans("no"), $paymentSettings->allow_all_currencies_for_classied); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans("currency_converter")); ?></h3>
            </div>
            <form action="<?= base_url('Admin/currencyConverterPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= esc(trans("status")); ?></label>
                        <?= formRadio('currency_converter', 1, 0, trans("enable"), trans("disable"), $paymentSettings->currency_converter); ?>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("automatically_update_exchange_rates")); ?></label>
                        <?= formRadio('auto_update_exchange_rates', 1, 0, trans("yes"), trans("no"), $paymentSettings->auto_update_exchange_rates); ?>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("currency_converter_api")); ?></label>
                        <select name="currency_converter_api" class="form-control">
                            <option value=""><?= esc(trans("select")); ?></option>
                            <option value="fixer" <?= $paymentSettings->currency_converter_api == 'fixer' ? 'selected' : ''; ?>>Fixer.io</option>
                            <option value="currencyapi" <?= $paymentSettings->currency_converter_api == 'currencyapi' ? 'selected' : ''; ?>>Currencyapi.net</option>
                            <option value="openexchangerates" <?= $paymentSettings->currency_converter_api == 'openexchangerates' ? 'selected' : ''; ?>>Openexchangerates.org</option>
                        </select>
                        <input type="text" name="currency_converter_api_key" value="<?= $paymentSettings->currency_converter_api_key; ?>" class="form-control m-t-5" placeholder="<?= esc(trans("access_key")); ?>">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans("currencies")); ?></h3>
                </div>
                <div class="right">
                    <?php if ($paymentSettings->currency_converter == 1): ?>
                        <form action="<?= base_url('Admin/updateCurrencyRates'); ?>" method="post" class="display-inline-block">
                            <?= csrf_field(); ?>
                            <button class="btn btn-info btn-add-new"><i class="fa fa-refresh"></i>&nbsp;&nbsp;<?= esc(trans("update_exchange_rates")); ?></button>
                        </form>
                    <?php endif; ?>
                    <a href="<?= adminUrl('add-currency'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans("add_currency")); ?>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped" id="cs_datatable_currency" role="grid">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= esc(trans('id')); ?></th>
                                    <th><?= esc(trans('currency')); ?></th>
                                    <th><?= esc(trans('currency_code')); ?></th>
                                    <th><?= esc(trans('currency_symbol')); ?></th>
                                    <th><?= esc(trans('exchange_rate')); ?></th>
                                    <th class="th-options"><?= esc(trans('options')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($currencies)):
                                    foreach ($currencies as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td>
                                                <?= esc($item->name); ?>&nbsp;
                                                <?php if ($item->status == 1): ?>
                                                    <label class="label label-success pull-right"><?= esc(trans("active")); ?></label>
                                                <?php else: ?>
                                                    <label class="label label-default pull-right"><?= esc(trans("inactive")); ?></label>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($item->code); ?></td>
                                            <td><?= esc($item->symbol); ?></td>
                                            <td>
                                                <?php if ($paymentSettings->default_currency == $item->code):
                                                    echo trans("default"); ?>
                                                <?php else: ?>
                                                    <input type="number" class="form-control input-exchange-rate" value="<?= $item->exchange_rate; ?>" data-currency-id="<?= $item->id; ?>" min="0" max="999999999" step="0.00001" placeholder="<?= esc(trans("exchange_rate")); ?>" style="width: 150px;" data-type="decimal">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-currency/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                        <li>
                                                            <!-- <a href="javascript:void(0)" onclick="deleteItem('Admin/deleteCurrencyPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                            <a href="#" class="btn-item-delete" data-url="Admin/deleteCurrencyPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                                <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>