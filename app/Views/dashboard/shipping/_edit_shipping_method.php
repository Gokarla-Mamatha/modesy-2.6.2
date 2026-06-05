<?php if (!empty($method)): ?>
    <div id="modalEditShippingMethod<?= $method->id; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="<?= base_url('Dashboard/editShippingMethodPost'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="method_id" value="<?= esc($method->id); ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                        <h4 class="modal-title"><?= esc(trans("shipping_method")); ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <?= formSwitch('status', trans('status'), $method->status); ?>
                        </div>


                        <div class="form-group m-b-10">
                            <label class="control-label"><?= esc(trans("method_name")); ?></label>
                            <?php foreach ($activeLanguages as $language): ?>
                                <input type="text" name="method_name_<?= esc($method->id); ?>_lang_<?= esc($language->id); ?>" class="form-control form-input m-b-5" value="<?= esc(@parseSerializedNameArray($method->name_array, $language->id)); ?>" placeholder="<?= esc($language->name); ?>" maxlength="255" data-type="title">
                            <?php endforeach; ?>
                        </div>

                        <?php if ($method->method_type == 'free_shipping'): ?>

                            <div class="form-group">
                                <label class="control-label"><?= esc(trans("minimum_order_amount")); ?></label>
                                <?= renderPriceInput('free_shipping_min_amount', $method->free_shipping_min_amount); ?>
                            </div>

                        <?php elseif ($method->method_type == 'local_pickup'): ?>

                            <div class="form-group">
                                <label class="control-label"><?= esc(trans("local_pickup_cost")); ?></label>
                                <?= renderPriceInput('local_pickup_cost', $method->local_pickup_cost); ?>
                            </div>

                        <?php elseif ($method->method_type == 'flat_rate'):
                            $flatRates = [];
                            if (!empty($method->flat_rate_costs)) {
                                $decodedRates = safeJsonDecode($method->flat_rate_costs);
                                if (!empty($decodedRates) && countItems($decodedRates) > 0) {
                                    $flatRates = $decodedRates;
                                }
                            }
                            ?>

                            <div class="form-group">
                                <label for="shipping_calculation_type"><?= esc(trans("shipping_calculation_type")); ?></label>
                                <select id="shipping_calculation_type" name="cost_calculation_type" class="form-control">
                                    <option value="total_weight" <?= $method->cost_calculation_type == 'total_weight' ? 'selected' : ''; ?>><?= esc(trans("shipping_by_total_weight")); ?></option>
                                    <option value="per_order" <?= $method->cost_calculation_type == 'per_order' ? 'selected' : ''; ?>><?= esc(trans("shipping_by_per_order")); ?></option>
                                    <option value="per_item" <?= $method->cost_calculation_type == 'per_item' ? 'selected' : ''; ?>><?= esc(trans("shipping_by_per_item")); ?></option>
                                </select>
                            </div>

                            <div id="weight_rules_container" style="display:<?= $method->cost_calculation_type == 'total_weight' ? 'block' : 'none'; ?>">
                                <div class="form-group">
                                    <label><?= esc(trans("flat_rate_rules")) ?> (<?= esc(trans("min_weight")) ?>/<?= esc(trans("max_weight")) ?>/<?= esc(trans("cost")) ?>)</label>
                                    <div id="shipping-rates-container">
                                        <?php
                                        $flatRates = !empty($flatRates) ? $flatRates : [(object)['min_weight' => '', 'max_weight' => '', 'cost' => '']];
                                        foreach ($flatRates as $i => $rate): ?>
                                            <div class="rate-row">
                                                <div class="rate-row-inner">
                                                    <div class="rate-input">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><?= esc(trans("kg")); ?></span>
                                                            <input type="number" name="rates[<?= $i ?>][min_weight]" value="<?= esc($rate->min_weight) ?>" class="form-control" placeholder="<?= esc(trans("min_weight")) ?>" min="0" max="999999" step="0.001" data-type="decimal">
                                                        </div>
                                                    </div>
                                                    <div class="rate-input">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><?= esc(trans("kg")); ?></span>
                                                            <input type="number" name="rates[<?= $i ?>][max_weight]" value="<?= esc($rate->max_weight) ?>" class="form-control" placeholder="<?= esc(trans("max_weight")) ?>" min="0" max="999999" step="0.001" data-type="decimal">
                                                        </div>
                                                    </div>
                                                    <div class="rate-input">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><?= esc($defaultCurrency->symbol) ?></span>
                                                            <input type="text" name="rates[<?= $i ?>][cost]" value="<?= esc($rate->cost) ?>" class="form-control input-price" maxlength="13" placeholder="<?= esc(trans("cost")) ?>" inputmode="decimal">
                                                        </div>
                                                    </div>
                                                    <div style="display: flex; align-items: center">
                                                        <button type="button" class="btn btn-sm btn-danger btn-remove-rate"><i class="fa fa-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" id="btn-add-rate" class="btn btn-success mt-2">
                                        <span class="glyphicon glyphicon-plus"></span>&nbsp;<?= esc(trans("add_rate")); ?>
                                    </button>
                                </div>
                            </div>

                            <div id="single_cost_container" style="display:<?= $method->cost_calculation_type == 'total_weight' ? 'none' : 'block'; ?>">
                                <div class="form-group">
                                    <label class="control-label"><?= esc(trans("shipping_cost")); ?></label>
                                    <?= renderPriceInput('shipping_flat_cost', $method->shipping_flat_cost, ['id' => 'shipping_flat_cost']); ?>
                                    <small class="help-block"><?= esc(trans("shipping_cost_calculation_exp")); ?></small>
                                </div>
                            </div>

                        <?php endif; ?>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><?= esc(trans("save_changes")); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>