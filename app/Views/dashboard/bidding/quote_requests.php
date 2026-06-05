<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc($title); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row table-filter-container">
                    <div class="col-sm-12">
                        <form action="<?= generateDashUrl('quote_requests'); ?>" method="get">
                            <div class="item-table-filter">
                                <label><?= esc(trans("status")); ?></label>
                                <select name="status" class="form-control custom-select">
                                    <option value="" selected><?= esc(trans("all")); ?></option>
                                    <option value="new_quote_request" <?= inputGet('status') == 'new_quote_request' ? 'selected' : ''; ?>><?= esc(trans("new_quote_request")); ?></option>
                                    <option value="pending_quote" <?= inputGet('status') == 'pending_quote' ? 'selected' : ''; ?>><?= esc(trans("pending_quote")); ?></option>
                                    <option value="pending_payment" <?= inputGet('status') == 'pending_payment' ? 'selected' : ''; ?>><?= esc(trans("pending_payment")); ?></option>
                                    <option value="rejected_quote" <?= inputGet('status') == 'rejected_quote' ? 'selected' : ''; ?>><?= esc(trans("rejected_quote")); ?></option>
                                    <option value="closed" <?= inputGet('status') == 'closed' ? 'selected' : ''; ?>><?= esc(trans("closed")); ?></option>
                                    <option value="completed" <?= inputGet('status') == 'completed' ? 'selected' : ''; ?>><?= esc(trans("completed")); ?></option>
                                </select>
                            </div>
                            <div class="item-table-filter">
                                <label><?= esc(trans("search")); ?></label>
                                <input name="q" class="form-control" placeholder="<?= esc(trans("search")); ?>" type="search" value="<?= esc(inputGet('q')); ?>">
                            </div>
                            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                <label style="display: block">&nbsp;</label>
                                <button type="submit" class="btn bg-purple btn-filter"><?= esc(trans("filter")); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th><?= esc(trans('quote')); ?></th>
                            <th><?= esc(trans('product')); ?></th>
                            <th><?= esc(trans('buyer')); ?></th>
                            <th><?= esc(trans('status')); ?></th>
                            <th><?= esc(trans('sellers_bid')); ?></th>
                            <th><?= esc(trans('updated')); ?></th>
                            <th><?= esc(trans('date')); ?></th>
                            <th class="max-width-120"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($quoteRequests)):
                            foreach ($quoteRequests as $item): ?>
                                <tr>
                                    <td>#<?= $item->id; ?></td>
                                    <td>
                                        <?php $product = getProduct($item->product_id);
                                        if (!empty($product)):?>
                                            <div class="img-table">
                                                <a href="<?= generateProductUrl($product); ?>" target="_blank">
                                                    <img data-src="<?= getOrderImageUrl($item->product_image_data, $product->id); ?>" alt="<?= esc($product->title); ?>" class="lazyload img-fluid img-product">
                                                </a>
                                            </div>
                                            <a href="<?= generateProductUrl($product); ?>" target="_blank" class="table-product-title"><?= esc($item->product_title); ?></a>
                                            <?php if (!empty($item->product_options_summary)): ?>
                                                <div class="product-variant-info m-b-5">
                                                    <?= $item->product_options_summary; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($item->product_sku)): ?>
                                                <div class="product-variant-info m-b-5">
                                                    <strong><?= esc(trans("sku")); ?></strong>:&nbsp;<?= esc($item->product_sku); ?>
                                                </div>
                                            <?php endif; ?>
                                            <?= trans("quantity") . ': ' . $item->product_quantity; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $user = getUser($item->buyer_id);
                                        if (!empty($user)):?>
                                            <div class="table-orders-user">
                                                <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank"><?= esc(getUsername($user)); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item->status == "new_quote_request"): ?>
                                            <label class="label label-success"><?= esc(trans($item->status)); ?></label>
                                        <?php elseif ($item->status == "pending_quote"): ?>
                                            <label class="label label-warning"><?= esc(trans($item->status)); ?></label>
                                        <?php elseif ($item->status == "pending_payment"): ?>
                                            <label class="label label-info"><?= esc(trans($item->status)); ?></label>
                                        <?php elseif ($item->status == "rejected_quote"): ?>
                                            <label class="label label-danger"><?= esc(trans($item->status)); ?></label>
                                        <?php elseif ($item->status == "closed"): ?>
                                            <label class="label label-default"><?= esc(trans($item->status)); ?></label>
                                        <?php elseif ($item->status == "completed"): ?>
                                            <label class="label label-primary"><?= esc(trans($item->status)); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item->status != 'new_quote_request' && $item->price_offered != 0): ?>
                                            <label class="label label-success"><strong><?= priceFormatted($item->price_offered, $item->price_currency); ?></strong></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= timeAgo($item->updated_at); ?></td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <?php if ($item->status == 'new_quote_request'): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?= $item->id; ?>"><i class="fa fa-plus option-icon"></i><?= esc(trans("submit_a_quote")); ?></a>
                                                    </li>
                                                <?php elseif ($item->status == 'pending_quote'): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?= $item->id; ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans("update_quote")); ?></a>
                                                    </li>
                                                <?php elseif ($item->status == 'rejected_quote'): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modalSubmitQuote<?= $item->id; ?>"><i class="fa fa-refresh option-icon"></i><?= esc(trans("submit_a_new_quote")); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <!-- <a href="javascript:void(0)" onclick="deleteItem('Order/deleteQuoteRequest','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                        <a href="#" class="btn-item-delete" data-url="Order/deleteQuoteRequest" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                        <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?></a>
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
                <?php if (empty($quoteRequests)): ?>
                    <p class="text-center">
                        <?= esc(trans("no_records_found")); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($quoteRequests)): ?>
                    <div class="number-of-entries">
                        <span><?= esc(trans("number_of_entries")); ?>:</span>&nbsp;&nbsp;<strong><?= $numRows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="table-pagination">
                    <?= $pager->links; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($quoteRequests)):
    foreach ($quoteRequests as $quoteRequest):
        $quoteProduct = getProduct($quoteRequest->product_id); ?>
        <div class="modal fade" id="modalSubmitQuote<?= $quoteRequest->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <form action="<?= base_url('bidding/submit-quote-post'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title"><?= esc(trans("submit_a_quote")); ?></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" class="form-control" value="<?= $quoteRequest->id; ?>">
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans('price')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><?= $defaultCurrency->symbol; ?></span>
                                    <input type="hidden" name="currency" value="<?= $paymentSettings->default_currency; ?>">
                                    <input type="text" name="price" class="form-control form-input input-price" maxlength="13" placeholder="<?= $defaultCurrency->currency_format == 'european' ? '0,00' : '0.00'; ?>"
                                           data-item-id="<?= $quoteRequest->id; ?>" data-product-quantity="<?= $quoteRequest->product_quantity; ?>" inputmode="decimal" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="calculated-price">
                                    <strong><?= esc(trans("unit_price")); ?> (<?= $defaultCurrency->symbol; ?>):&nbsp;&nbsp;
                                        <span id="unit_price_<?= $quoteRequest->id; ?>" class="earned-price">
                                        <?= number_format(0, 2, '.', ''); ?>
                                    </span>
                                    </strong><br>
                                    <strong><?= esc(trans("commission_rate")); ?>:&nbsp;&nbsp;<?= $paymentSettings->commission_rate; ?>%</strong><br>
                                    <strong><?= esc(trans("you_will_earn")); ?> (<?= $defaultCurrency->symbol; ?>):&nbsp;&nbsp;
                                        <span id="earned_price_<?= $quoteRequest->id; ?>" class="earned-price">
                                        <?php $earnedPrice = $quoteProduct->price - (($quoteProduct->price * $paymentSettings->commission_rate) / 100);
                                        if (!empty($earnedPrice)) {
                                            $earnedPrice = number_format($earnedPrice, 2, '.', '');
                                        }
                                        echo numToDecimal($earnedPrice); ?>
                                            &nbsp;+&nbsp;<?= esc(trans("shipping_cost")) ?>
                                    </span>
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?= esc(trans("close")); ?></button>
                            <button type="submit" class="btn btn-md btn-success"><?= esc(trans("submit")); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach;
endif; ?>

<script <?= csp_script_nonce() ?>>
    //calculate product earned value
    $(document).on("input keyup paste change", ".price-input", function () {
        var input_val = $(this).val();
        var data_item_id = $(this).attr('data-item-id');
        var data_product_quantity = $(this).attr('data-product-quantity');
        input_val = input_val.replace(',', '.');
        var price = parseFloat(input_val);
        var commission_rate = parseInt(MdsConfig.commissionRate);
        //calculate earned price
        if (!Number.isNaN(price)) {
            var earned_price = price - ((price * commission_rate) / 100);
            earned_price = earned_price.toFixed(2);
            if (MdsConfig.decimalSeparator == ',') {
                earned_price = earned_price.replace('.', ',');
            }
        } else {
            earned_price = '0' + MdsConfig.decimalSeparator + '00';
        }
        //calculate unit price
        if (!Number.isNaN(price)) {
            var unit_price = price / data_product_quantity;
            unit_price = unit_price.toFixed(2);
            if (MdsConfig.decimalSeparator == ',') {
                unit_price = unit_price.replace('.', ',');
            }
        } else {
            unit_price = '0' + MdsConfig.decimalSeparator + '00';
        }
        $("#earned_price_" + data_item_id).html(earned_price);
        $("#unit_price_" + data_item_id).html(unit_price);
    });

    $(document).on("click", ".btn_submit_quote", function () {
        $('.modal-title').text("<?= esc(trans("submit_a_quote")); ?>");
    });
    $(document).on("click", ".btn_update_quote", function () {
        $('.modal-title').text("<?= esc(trans("update_quote")); ?>");
    });
</script>

