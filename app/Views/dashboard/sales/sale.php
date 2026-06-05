<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc(trans("sale")); ?>:&nbsp;#<?= esc($order->order_number); ?></h3>
        </div>
        <div class="right">
            <a href="<?= langBaseUrl('invoice/' . esc($order->order_number) . '?type=seller'); ?>" target="_blank" class="btn btn-sm btn-info btn-sale-options btn-view-invoice"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<?= esc(trans('view_invoice')); ?></a>
        </div>
    </div>
    <div class="box-body">
        <div class="row m-b-30">
            <div class="col-lg-6 col-md-12">
                <div class="line-detail">
                    <span><?= esc(trans("status")); ?></span>
                    <?php $orderStatus = 1;
                    $shipping = unserializeData($order->shipping);
                    foreach ($orderProducts as $item):
                        if ($item->order_status != 'completed' && $item->order_status != 'refund_approved') {
                            $orderStatus = 0;
                        }
                    endforeach;
                    if ($order->status == 2): ?>
                        <label class="label label-danger"><?= esc(trans("cancelled")); ?></label>
                    <?php else:
                        if ($orderStatus == 1): ?>
                            <label class="label label-default"><?= esc(trans("completed")); ?></label>
                        <?php else: ?>
                            <label class="label label-success"><?= esc(trans("order_processing")); ?></label>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if ($order->status != 2): ?>
                    <div class="line-detail">
                        <span><?= esc(trans("payment_status")); ?></span>
                        <strong class="font-600"><?= esc(trans($order->payment_status)); ?></strong>
                    </div>
                    <div class="line-detail">
                        <span><?= esc(trans("payment_method")); ?></span>
                        <?= getPaymentMethod($order->payment_method); ?>
                    </div>
                <?php endif; ?>
                <div class="line-detail">
                    <span><?= esc(trans("date")); ?></span>
                    <?= formatDate($order->created_at); ?>
                </div>
                <div class="line-detail">
                    <span><?= esc(trans("updated")); ?></span>
                    <?= timeAgo($order->updated_at); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <?php if (!empty($order->buyer_id)):
                    $buyer = getUser($order->buyer_id);
                    if (!empty($buyer)):?>
                        <div class="tbl-table" style="max-width: 400px;">
                            <div class="left" style="width: 135px !important;">
                                <a href="<?= generateProfileUrl($buyer->slug); ?>" target="_blank">
                                    <img src="<?= getUserAvatar($buyer->avatar, $buyer->storage_avatar); ?>" alt="" class="img-responsive" style="width: 120px !important; max-width: 120px !important; height: 120px;">
                                </a>
                            </div>
                            <div class="right">
                                <p><strong><a href="<?= generateProfileUrl($buyer->slug); ?>" target="_blank"><?= esc(getUsername($buyer)); ?></a></strong></p>
                                <?php if ($generalSettings->show_customer_phone_seller == 1): ?>
                                    <p><strong><?= esc($buyer->phone_number); ?></strong></p>
                                <?php endif;
                                if ($generalSettings->show_customer_email_seller == 1): ?>
                                    <p><strong><?= esc($buyer->email); ?></strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif;
                else: ?>
                    <div class="tbl-table" style="max-width: 400px;">
                        <div class="left" style="width: 135px !important;">
                            <img src="<?= getUserAvatar(''); ?>" alt="" class="img-responsive" style="width: 120px !important; max-width: 120px !important; height: 120px;">
                        </div>
                        <div class="right">
                            <?= !empty($shipping->sFirstName) ? esc($shipping->sFirstName) : ''; ?>
                            <?= !empty($shipping->sLastName) ? esc($shipping->sLastName) : ''; ?>
                            <p><strong><?= esc(trans("guest")); ?></strong></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($shipping)): ?>
            <div class="row m-b-30">
                <div class="col-sm-12 col-md-6">
                    <h3 class="block-title"><?= esc(trans("shipping_address")); ?></h3>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("first_name")); ?></span>
                        <?= !empty($shipping->sFirstName) ? esc($shipping->sFirstName) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("last_name")); ?></span>
                        <?= !empty($shipping->sLastName) ? esc($shipping->sLastName) : ''; ?>
                    </div>
                    <?php if ($generalSettings->show_customer_email_seller == 1): ?>
                        <div class="line-detail line-detail-sm">
                            <span><?= esc(trans("email")); ?></span>
                            <?= !empty($shipping->sEmail) ? esc($shipping->sEmail) : ''; ?>
                        </div>
                    <?php endif;
                    if ($generalSettings->show_customer_phone_seller == 1): ?>
                        <div class="line-detail line-detail-sm">
                            <span><?= esc(trans("phone_number")); ?></span>
                            <?= !empty($shipping->sPhoneNumber) ? esc($shipping->sPhoneNumber) : ''; ?>
                        </div>
                    <?php endif; ?>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("address")); ?></span>
                        <?= !empty($shipping->sAddress) ? esc($shipping->sAddress) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("country")); ?></span>
                        <?= !empty($shipping->sCountry) ? esc($shipping->sCountry) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("state")); ?></span>
                        <?= !empty($shipping->sState) ? esc($shipping->sState) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("city")); ?></span>
                        <?= !empty($shipping->sCity) ? esc($shipping->sCity) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("zip_code")); ?></span>
                        <?= !empty($shipping->sZipCode) ? esc($shipping->sZipCode) : ''; ?>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <h3 class="block-title"><?= esc(trans("billing_address")); ?></h3>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("first_name")); ?></span>
                        <?= !empty($shipping->bFirstName) ? esc($shipping->bFirstName) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("last_name")); ?></span>
                        <?= !empty($shipping->bLastName) ? esc($shipping->bLastName) : ''; ?>
                    </div>
                    <?php if ($generalSettings->show_customer_email_seller == 1): ?>
                        <div class="line-detail line-detail-sm">
                            <span><?= esc(trans("email")); ?></span>
                            <?= !empty($shipping->bEmail) ? esc($shipping->bEmail) : ''; ?>
                        </div>
                    <?php endif;
                    if ($generalSettings->show_customer_phone_seller == 1): ?>
                        <div class="line-detail line-detail-sm">
                            <span><?= esc(trans("phone_number")); ?></span>
                            <?= !empty($shipping->bPhoneNumber) ? esc($shipping->bPhoneNumber) : ''; ?>
                        </div>
                    <?php endif; ?>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("address")); ?></span>
                        <?= !empty($shipping->bAddress) ? esc($shipping->bAddress) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("country")); ?></span>
                        <?= !empty($shipping->bCountry) ? esc($shipping->bCountry) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("state")); ?></span>
                        <?= !empty($shipping->bState) ? esc($shipping->bState) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("city")); ?></span>
                        <?= !empty($shipping->bCity) ? esc($shipping->bCity) : ''; ?>
                    </div>
                    <div class="line-detail line-detail-sm">
                        <span><?= esc(trans("zip_code")); ?></span>
                        <?= !empty($shipping->bZipCode) ? esc($shipping->bZipCode) : ''; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <h3 class="block-title"><?= esc(trans("products")); ?></h3>
                <div class="table-responsive">
                    <table class="table table-orders">
                        <thead>
                        <tr>
                            <th scope="col"><?= esc(trans("product")); ?></th>
                            <th scope="col"><?= esc(trans("status")); ?></th>
                            <th scope="col"><?= esc(trans("updated")); ?></th>
                            <th scope="col"><?= esc(trans("options")); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $saleSubtotal = 0;
                        $saleVat = 0;
                        $saleShipping = 0;
                        $saleTotal = 0;
                        $affiliateDiscount = 0;
                        $affiliateDiscountRate = 0;
                        if ($affiliateSettings->status == 1 && $affiliateSettings->type == 'seller_based') {
                            $affiliate = unserializeData($order->affiliate_data);
                            if (!empty($affiliate) && !empty($affiliate['discount']) && !empty($affiliate['sellerId']) && user()->id == $affiliate['sellerId']) {
                                $affiliateDiscount = $affiliate['discount'];
                                $affiliateDiscountRate = $affiliate['discountRate'];
                            }
                        }
                        if (!empty($orderProducts)):
                            foreach ($orderProducts as $item):
                                if ($item->seller_id == user()->id):
                                    $product = getProduct($item->product_id);
                                    $productUrl = !empty($product) ? generateProductUrl($product) : '#';
                                    $itemSku = getOrderSku($item);

                                    $saleSubtotal += $item->product_unit_price * $item->product_quantity;
                                    $saleVat += $item->product_vat;
                                    $saleShipping = $item->seller_shipping_cost;
                                    $saleTotal += $item->product_total_price; ?>
                                    <tr>
                                        <td style="width: 50%">
                                            <div class="table-item-product">
                                                <div class="left">
                                                    <div class="img-table">
                                                        <a href="<?= esc($productUrl); ?>" target="_blank">
                                                            <img src="<?= getOrderImageUrl($item->image_data, $item->product_id); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <a href="<?= esc($productUrl); ?>" target="_blank" class="table-product-title font-600"><?= esc($item->product_title); ?></a>
                                                    <div class="item m-b-15">
                                                        <?= formatCartOptionsSummary($item->product_options_snapshot, $activeLang->short_form, true, '<br>'); ?>
                                                    </div>
                                                   <?php
                                                    $orderModel = new \App\Models\OrderModel();
                                                    $coupons = $orderModel->getOrderItemCoupons($item->id);
                                                    ?>

                                                    <?php if ($item->product_type == 'coupon'): ?>
                                                        <p>
                                                            <strong>Coupon code:</strong>
                                                            <?php if (!empty($coupons)): ?>
                                                                <?php foreach ($coupons as $c): ?>
                                                                    <?= esc($c->coupon_code); ?>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                Not Assigned
                                                            <?php endif; ?>
                                                        </p>
                                                    <?php endif; ?> 
                                                    <?php if (!empty($itemSku)): ?>
                                                        <p><span class="span-product-dtl-table"><?= esc(trans("sku")); ?>:</span><b><?= esc($itemSku); ?></b></p>
                                                    <?php endif; ?>
                                                    <p><span class="span-product-dtl-table"><?= esc(trans("unit_price")); ?>:</span><b><?= priceFormatted($item->product_unit_price, $item->product_currency); ?></b></p>
                                                    <p><span class="span-product-dtl-table"><?= esc(trans("quantity")); ?>:</span><b><?= $item->product_quantity; ?></b></p>
                                                    <?php if (!empty($item->product_vat)): ?>
                                                        <p><span class="span-product-dtl-table"><?= esc(trans("vat")); ?>&nbsp;(<?= $item->product_vat_rate; ?>%):</span><b><?= priceFormatted($item->product_vat, $item->product_currency); ?></b></p>
                                                        <p><span class="span-product-dtl-table"><?= esc(trans("total")); ?>:</span><b><?= priceFormatted($item->product_total_price, $item->product_currency); ?></b></p>
                                                    <?php else: ?>
                                                        <p><span class="span-product-dtl-table"><?= esc(trans("total")); ?>:</span><b><?= priceFormatted($item->product_total_price, $item->product_currency); ?></b></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 10%; white-space: nowrap">
                                            <strong><?= esc(trans($item->order_status)) ?></strong>
                                        </td>
                                        <td style="width: 15%">
                                            <?php if ($item->product_type == 'physical') {
                                                echo timeAgo($item->updated_at);
                                            } ?>
                                        </td>
                                        <td style="width: 25%">
                                            <?php if ($order->status != 2 && $item->order_status != 'refund_approved'):
                                                if ($item->product_type != 'digital'):
                                                    if ($item->order_status == "completed"): ?>
                                                        <strong class="font-600"><i class="fa fa-check"></i>&nbsp;<?= esc(trans("approved")); ?></strong>
                                                    <?php else:
                                                        if ($order->payment_method == 'cash_on_delivery' || $order->payment_status == 'payment_received'):?>
                                                            <p class="m-b-5">
                                                                <button type="button" class="btn btn-md btn-block btn-success btn-update-order-status" data-id="<?= $item->id; ?>"><?= esc(trans('update_order_status')); ?></button>
                                                            </p>
                                                        <?php endif;
                                                    endif;
                                                endif;
                                            endif; ?>
                                        </td>
                                    </tr>
                                    <?php if ($item->product_type != "digital"): ?>
                                    <tr class="tr-shipping">
                                        <td colspan="4">
                                            <div class="order-shipping-tracking-number">
                                                <p><strong><?= esc(trans("shipping")) ?></strong></p>
                                                <p class="font-600 m-t-5"><?= esc(trans("shipping_method")) ?>:&nbsp;<?= esc(trans($item->shipping_method)); ?></p>
                                                <?php if ($item->order_status == 'shipped' || $item->order_status == 'completed'): ?>
                                                    <p class="font-600 m-t-15"><?= esc(trans("order_has_been_shipped")); ?></p>
                                                    <p><?= esc(trans("tracking_code")) ?>:&nbsp;<?= esc($item->shipping_tracking_number); ?></p>
                                                    <p class="m-0"><?= esc(trans("tracking_url")) ?>: <a href="<?= esc($item->shipping_tracking_url); ?>" target="_blank" class="link-underlined"><?= esc($item->shipping_tracking_url); ?></a></p>
                                                <?php else: ?>
                                                    <p><?= trans("order_not_yet_shipped") . trans("warning_add_order_tracking_code"); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tr-shipping-seperator">
                                        <td colspan="4"></td>
                                    </tr>
                                <?php endif;
                                endif;
                            endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="order-total">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?= esc(trans("subtotal")); ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?= priceFormatted($saleSubtotal, $order->price_currency); ?></strong>
                        </div>
                    </div>
                    <?php if (!empty($affiliateDiscount)):
                        $affiliateDiscount = numToDecimal($affiliateDiscount);
                        $saleTotal = $saleTotal - $affiliateDiscount; ?>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-left">
                                <?= esc(trans("referral_discount")); ?>&nbsp;(<?= $affiliateDiscountRate; ?>%)
                            </div>
                            <div class="col-sm-6 col-xs-6 col-right">
                                <strong>- <?= priceFormatted($affiliateDiscount, $order->price_currency); ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($saleVat)): ?>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-left">
                                <?= esc(trans("vat")); ?>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-right">
                                <strong><?= priceFormatted($saleVat, $order->price_currency); ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?= esc(trans("shipping")); ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?= priceFormatted($saleShipping, $order->price_currency); ?></strong>
                        </div>
                    </div>
                    <?php $coupon_discount = 0;
                    if (user()->id == $order->coupon_seller_id && !empty($order->coupon_discount)):
                        $saleTotal = $saleTotal - $order->coupon_discount; ?>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-left">
                                <?= esc(trans("coupon")); ?>&nbsp;&nbsp;[<?= esc($order->coupon_code); ?>]
                            </div>
                            <div class="col-sm-6 col-xs-6 col-right">
                                <strong>-&nbsp;<?= priceFormatted($order->coupon_discount, $order->price_currency); ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12 m-b-15">
                            <div class="row-seperator"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?= esc(trans("total")); ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?= priceFormatted($saleTotal + $saleShipping, $order->price_currency); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php if (!empty($orderProducts)):
    foreach ($orderProducts as $item):
        if ($item->seller_id == user()->id):?>
            <div class="modal fade" id="updateStatusModal_<?= $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-custom">
                        <form action="<?= base_url('update-order-product-status-post'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" value="<?= $item->id; ?>">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= esc(trans("update_order_status")); ?></h5>
                                <button type="button" class="close" data-bs-dismiss="modal">
                                    <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label"><?= esc(trans('status')); ?></label>
                                          <?php if ($item->product_type == 'physical' || $item->product_type == 'digital' || $item->product_type == 'coupon'): ?>
                                           <select class="select_order_status form-control" name="order_status" data-order-product-id="<?= $item->id; ?>">
                                                <option value="" disabled selected><?= esc(trans("select")); ?></option>
                                                <?php if ($item->product_type == 'physical' || $item->product_type == 'digital' || $item->product_type == 'coupon'): ?>
                                                    <option value="order_processing" <?= $item->order_status == 'order_processing' ? 'selected' : ''; ?>>
                                                        <?= esc(trans("order_processing")); ?>
                                                    </option>
                                                    <option value="shipped" <?= $item->order_status == 'shipped' ? 'selected' : ''; ?>>
                                                        <?= esc(trans("shipped")); ?>
                                                    </option>
                                                    <?php if ($item->product_type == 'coupon'): ?>
                                                        <option value="completed" <?= $item->order_status == 'completed' ? 'selected' : ''; ?>>
                                                            <?= esc(trans("completed")); ?>
                                                        </option>
                                                        <option value="cancelled" <?= $item->order_status == 'cancelled' ? 'selected' : ''; ?>>
                                                            <?= esc(trans("cancelled")); ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </select>
                                         <?php endif; ?>
                                        </div>
                                        <div class="row tracking-number-container <?= $item->order_status != 'shipped' ? 'display-none' : ''; ?>">
                                            <hr>
                                            <div class="col-12 text-center">
                                                <strong><?= esc(trans("shipping")); ?></strong>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?= esc(trans("tracking_code")); ?></label>
                                                    <input type="text" name="shipping_tracking_number" class="form-control form-input" value="<?= esc($item->shipping_tracking_number); ?>" placeholder="<?= esc(trans("tracking_code")); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label><?= esc(trans("tracking_url")); ?></label>
                                                    <input type="text" name="shipping_tracking_url" class="form-control form-input" value="<?= esc($item->shipping_tracking_url); ?>" placeholder="<?= esc(trans("tracking_url")); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-md btn-default" data-bs-dismiss="modal"><?= esc(trans("close")); ?></button>
                                <button type="submit" class="btn btn-md btn-success"><?= esc(trans("submit")); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif;
    endforeach;
endif; ?>

<script <?= csp_script_nonce() ?>>
$(document).on("change", ".select_order_status", function () {
    var val = $(this).val();
    var container = $(this).closest('.modal-body').find('.tracking-number-container');

    if (val == "shipped") {
        container.show();
    } else {
        container.hide();
    }
});

</script>