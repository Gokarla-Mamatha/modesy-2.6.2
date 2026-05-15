<div class="section-product-details">
    <div class="form-box">
        <div class="row">
            <?php if ($product->product_type != 'digital' && $product->listing_type != 'ordinary_listing'): ?>
                <div class="col-sm-12 col-lg-6">
                    <div class="form-box-head">
                        <h4 class="title"><?= trans('stock'); ?></h4>
                    </div>
                    <div class="form-box-body">
                        <div class="form-group">
                            <input type="number" name="stock" class="form-control form-input" min="0" max="999999999" value="<?= $product->stock; ?>" placeholder="<?= trans("stock"); ?>" required>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <input type="hidden" name="stock" value="<?= $product->stock; ?>">
            <?php endif;
            if ($product->listing_type == 'ordinary_listing' || $productSettings->marketplace_sku == 1): ?>
                <div class="col-sm-12 col-lg-6">
                    <div class="form-box-head">
                        <h4 class="title">
                            <?= trans('sku'); ?>&nbsp;<small style="width: auto;display: inline-block;margin-bottom: 0;margin-top:0;">(<?= trans("product_code"); ?>)</small>
                        </h4>
                    </div>
                    <div class="form-box-body">
                        <div class="form-group">
                            <div class="position-relative">
                                <input type="text" name="sku" id="input_sku" class="form-control form-input" value="<?= $product->sku; ?>" placeholder="<?= trans("sku"); ?>&nbsp;(<?= trans("optional"); ?>)" maxlength="90">
                                <button type="button" class="btn btn-default btn-generate-sku" onclick="$('#input_sku').val(generateUniqueString()).trigger('input');"><?= trans("generate"); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <input type="hidden" name="sku" value="">
            <?php endif; ?>
        </div>
    </div>

       <?php if ($product->listing_type == 'sell_on_site' || $product->listing_type == 'license_key'|| $product->product_type == 'coupon'): ?>
        <div class="form-box form-box-price form-box-last">
            <div class="form-box-head">
                <h4 class="title"><?= trans("product_price"); ?></h4>
            </div>
            <div class="form-box-body">
                <div id="price_input_container" class="form-group">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 m-b-sm-15">
                            <label class="font-600"><?= trans("price"); ?></label>
                            <?= renderPriceInput('price', $product->price, ['id' => 'product_price_input', 'required' => $product->is_free_product == 1 ? false : true]); ?>
                        </div>
                        <div class="col-xs-12 col-sm-4 m-b-sm-15">
                            <div class="row align-items-center">
                                <div class="col-sm-12">
                                    <label class="font-600"><?= trans("discounted_price"); ?></label>
                                    <div id="discount_input_container" class="<?= $product->discount_rate == 0 ? 'display-none' : ''; ?>">
                                        <?= renderPriceInput('price_discounted', $product->price_discounted, ['id' => 'product_discounted_price_input']); ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 m-t-10">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="checkbox_has_discount" id="checkbox_discount_rate" <?= $product->discount_rate == 0 ? 'checked' : ''; ?>>
                                        <label for="checkbox_discount_rate" class="custom-control-label"><?= trans("no_discount"); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($paymentSettings->vat_status == 1): ?>
                            <div class="col-xs-12 col-sm-4">
                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <label class="font-600"><?= trans("product_based_vat"); ?><small>&nbsp;(<?= trans("vat_exp"); ?>)</small></label>
                                        <div id="vat_input_container" class="<?= $product->vat_rate == 0 ? 'display-none' : ''; ?>">
                                            <div class="input-group">
                                                <span class="input-group-addon">%</span>
                                                <input type="hidden" name="currency" value="<?= $paymentSettings->default_currency; ?>">
                                                <input type="number" name="vat_rate" id="input_vat_rate" aria-describedby="basic-addon-vat" class="form-control form-input" value="<?= $product->vat_rate; ?>" min="0" max="100" step="0.01">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="no_vat" id="checkbox_no_vat" <?= $product->vat_rate == 0 ? 'checked' : ''; ?>>
                                            <label for="checkbox_no_vat" class="custom-control-label"><?= trans("no_vat"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($product->price) && $product->price > 0): ?>
                            <div class="col-sm-12 m-t-30">
                                <p class="calculated-price">
                                    <strong><?= trans("discount_rate"); ?>:&nbsp;&nbsp;</strong>
                                    <b id="calculated_discount_rate" class="earned-price"><?= $product->discount_rate; ?>%</b>
                                </p>
                                <p class="calculated-price">
                                    <strong><?= trans("commission_rate"); ?>:&nbsp;&nbsp;</strong>
                                    <b id="calculated_discount_rate" class="earned-price"><?= $commissionRate; ?>%</b>
                                </p>
                                <p class="calculated-price">
                                    <strong><?= trans("you_will_earn"); ?> (<?= $defaultCurrency->code; ?>):&nbsp;&nbsp;</strong>
                                    <b id="earned_amount" class="earned-price">
                                        <?php $earnedAmount = 0;
                                        if (!empty($product)) {
                                            $price = $product->price_discounted;
                                            $earnedAmount = $price - (($price * $commissionRate) / 100);
                                        }
                                        echo esc(priceFormatted($earnedAmount, $defaultCurrency->code, true)); ?>
                                    </b>
                                    &nbsp;&nbsp;<b>+&nbsp;&nbsp;&nbsp;<?= trans("vat"); ?></b>
                                    <?php if ($product->product_type != 'digital'): ?>
                                        &nbsp;&nbsp;<b>+&nbsp;&nbsp;&nbsp;<?= trans("shipping_cost"); ?></b>&nbsp;&nbsp;
                                    <?php endif; ?>
                                </p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <?php if ($product->product_type == 'digital'): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="is_free_product" id="checkbox_free_product" <?= $product->is_free_product == 1 ? 'checked' : ''; ?>>
                                <label for="checkbox_free_product" class="custom-control-label text-danger"><?= trans("free_product"); ?></label>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php elseif ($product->listing_type == 'ordinary_listing'):
        if ($productSettings->classified_price == 1): ?>
            <div class="form-box form-box-last">
                <div class="form-box-head">
                    <h4 class="title"><?= trans('price'); ?></h4>
                </div>
                <div class="form-box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-4 col-lg-3 m-b-sm-15">
                                <label class="font-600"><?= trans("currency"); ?></label>
                                <select name="currency" class="form-control custom-select select2" required>
                                    <?php if (!empty($currencies)):
                                        $allowAllCurrencies = $paymentSettings->allow_all_currencies_for_classied == 1;
                                        foreach ($currencies as $key => $value):
                                            if ($allowAllCurrencies || ($key == $defaultCurrency->code)): ?>
                                                <option value="<?= $key; ?>" <?= $key == $product->currency ? 'selected' : ''; ?>>
                                                    <?= esc($value->name) . ' (' . $value->symbol . ')'; ?>
                                                </option>
                                            <?php endif;
                                        endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-3 m-b-sm-15">
                                <label class="font-600"><?= trans("price"); ?></label>
                                <?= renderPriceInput('price', $product->price, ['id' => 'product_price_input', 'required' => $product->is_free_product == 1 ? false : true], false); ?>
                            </div>
                            <div class="col-xs-12 col-md-4 col-lg-3">
                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <label class="font-600"><?= trans("discounted_price"); ?></label>
                                        <div id="discount_input_container" class="<?= $product->discount_rate == 0 ? 'display-none' : ''; ?>">
                                            <?= renderPriceInput('price_discounted', $product->price_discounted, ['id' => 'product_discounted_price_input'], false); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="checkbox_has_discount" id="checkbox_discount_rate" <?= $product->discount_rate == 0 ? 'checked' : ''; ?>>
                                            <label for="checkbox_discount_rate" class="custom-control-label"><?= trans("no_discount"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
 elseif ( $product->listing_type == 'productbid'): ?>
        <div class="form-box form-box-last">
            <div class="form-box-head">
                <h4 class="title">Bidding Details</h4>
            </div>
            <div class="form-box-body">
                <input type="hidden" name="currency" value="<?= $paymentSettings->default_currency; ?>">
                <div class="row">
                    <!-- Bidding Status -->
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="font-600">Bidding Status</label>
                            <select name="bidding_status" class="form-control custom-select">
                                <option value="active" <?= $product->bidding_status == 'active' ? 'selected' : ''; ?>>
                                    <?= trans('active'); ?>
                                </option>
                                <option value="closed" <?= $product->bidding_status == 'closed' ? 'selected' : ''; ?>>
                                    <?= trans('closed'); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Minimum Price -->
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="font-600">Minimum Bid Price</label>
                            <input type="number" step="0.01" name="minimum_price" class="form-control"
                                value="<?= esc($product->minimum_price ?? ''); ?>">
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="font-600">Quantity</label>
                            <input type="number" name="bid_quantity" class="form-control"
                                value="<?= esc($product->bid_quantity ?? 1); ?>">
                        </div>
                    </div>

                    <!-- Bidding Start Date & Time -->
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="font-600">Bidding Start Date & Time</label>
                            <input type="datetime-local" name="bidding_start_time"class="form-control"value="<?= !empty($product->bidding_start_time)? esc(date('Y-m-d\TH:i', strtotime($product->bidding_start_time))): ''; ?>">
                        </div>
                    </div>
                    <!-- Bidding End Date & Time -->
                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="font-600">Bidding End Date & Time</label>
                            <input type="datetime-local" name="bidding_end_time"class="form-control"value="<?= !empty($product->bidding_end_time)? esc(date('Y-m-d\TH:i', strtotime($product->bidding_end_time))): ''; ?>">
                        </div>
                    </div>
            </div>
        </div>
<?php endif; ?>
</div>

<script <?= csp_script_nonce() ?>>
    $(document).on('click', '#checkbox_free_product', function () {
        if ($(this).is(':checked')) {
            $('#price_input_container').hide();
            $(".price-input").prop('required', false);
        } else {
            $('#price_input_container').show();
            $(".price-input").prop('required', true);
        }
    });
</script>
<?php if ($product->is_free_product == 1): ?>
    <style <?= csp_style_nonce() ?>>
        #price_input_container {
            display: none;;
        }
    </style>
<?php endif;
if ($product->listing_type == 'sell_on_site' || $product->listing_type == 'license_key'): ?>
    <script <?= csp_script_nonce() ?>>
        //calculate product earned value
        $(document).on("change", "#product_price_input", function () {
            var priceStr = $('#product_price_input').val();
            price = parseFloat(priceStr.replace(',', '.'));
            $('#product_discounted_price_input').val(price);
        });

        //calculate discount
        $(document).on("change", "#product_discounted_price_input", function () {
            const priceStr = $('#product_price_input').val();
            const priceDiscountedStr = $('#product_discounted_price_input').val();

            const price = parseFloat(priceStr.replace(',', '.'));
            const priceDiscounted = parseFloat(priceDiscountedStr.replace(',', '.'));

            let rate = 0;
            if (isNaN(price) || isNaN(priceDiscounted)) {
                return false;
            }

            if (priceDiscounted > price) {
                $('#product_discounted_price_input').val(price.toString().replace('.', ','));
                return false;
            }

            if (priceDiscounted <= 0) {
                $('#product_discounted_price_input').val('');
                return false;
            }

            if (priceDiscounted) {
                rate = ((price - priceDiscounted) * 100) / price;
                rate = rate.toFixed(0);
            }
        });
    </script>
<?php endif; ?>
<script <?= csp_script_nonce() ?>>
    $('#checkbox_discount_rate').change(function () {
        if (!this.checked) {
            $("#discount_input_container").show();
        } else {
            var priceStr = $('#product_price_input').val();
            price = parseFloat(priceStr.replace(',', '.'));
            $('#product_discounted_price_input').val(price);
            $("#discount_input_container").hide();
        }
    });
    $('#checkbox_no_vat').change(function () {
        if (!this.checked) {
            $("#vat_input_container").show();
        } else {
            $('#input_vat_rate').val("0");
            $("#vat_input_container").hide();
        }
    });
</script>