<?php $shipping = unserializeData($order->shipping); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans('order_details')); ?></h3>
                </div>
                <div class="right">
                    <?php if ($order->status != 2): ?>
                        <a href="<?= langBaseUrl('invoice/' . esc($order->order_number) . '?type=admin'); ?>" target="_blank" class="btn btn-sm btn-info btn-sale-options btn-view-invoice"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;<?= esc(trans('view_invoice')); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="box-body">
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h4 class="sec-title"><?= esc(trans("order")); ?>#<?= esc($order->order_number); ?></h4>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?= esc(trans("status")); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <?php if ($order->status == 1): ?>
                                    <label class="label label-success"><?= esc(trans("completed")); ?></label>
                                <?php elseif ($order->status == 2): ?>
                                    <label class="label label-danger"><?= esc(trans("cancelled")); ?></label>
                                <?php else: ?>
                                    <label class="label label-default"><?= esc(trans("order_processing")); ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?= esc(trans("order_id")); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?= $order->id; ?></strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?= esc(trans("order_number")); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?= esc($order->order_number); ?></strong>
                            </div>
                        </div>
                        <?php if ($order->status != 2): ?>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("payment_method")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right">
                                        <?= getPaymentMethod($order->payment_method); ?>
                                    </strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("currency")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= $order->price_currency; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("payment_status")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= esc(trans($order->payment_status)); ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?= esc(trans("updated")); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?= formatDate($order->updated_at); ?>&nbsp;(<?= timeAgo($order->updated_at); ?>)</strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?= esc(trans("date")); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?= formatDate($order->created_at); ?>&nbsp;(<?= timeAgo($order->created_at); ?>)</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h4 class="sec-title"><?= esc(trans("buyer")); ?></h4>
                        <?php if ($order->buyer_id == 0): ?>
                            <div class="row row-details">
                                <div class="col-xs-12">
                                    <div class="table-orders-user">
                                        <img src="<?= getUserAvatar(''); ?>" alt="" class="img-responsive" style="height: 120px;">
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($shipping)): ?>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?= esc(trans("buyer")); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right">
                                            <?= !empty($shipping->sFirstName) ? esc($shipping->sFirstName) : ''; ?>
                                            <?= !empty($shipping->sLastName) ? esc($shipping->sLastName) : ''; ?>
                                            <label class="label bg-olive"><?= esc(trans("guest")); ?></label>
                                        </strong>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?= esc(trans("phone_number")); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?= !empty($shipping->sPhoneNumber) ? esc($shipping->sPhoneNumber) : ''; ?></strong>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?= esc(trans("email")); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?= !empty($shipping->sEmail) ? esc($shipping->sEmail) : ''; ?></strong>
                                    </div>
                                </div>
                            <?php endif;
                        else:
                            $buyer = getUser($order->buyer_id);
                            if (!empty($buyer)):?>
                                <div class="row row-details">
                                    <div class="col-xs-12">
                                        <div class="table-orders-user">
                                            <a href="<?= generateProfileUrl($buyer->slug); ?>" target="_blank">
                                                <img src="<?= getUserAvatar($buyer->avatar, $buyer->storage_avatar); ?>" alt="" class="img-responsive" style="height: 120px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?= esc(trans("username")); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right">
                                            <a href="<?= generateProfileUrl($buyer->slug); ?>" target="_blank"><?= esc(getUsername($buyer)); ?></a>
                                        </strong>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?= esc(trans("phone_number")); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?= esc($buyer->phone_number); ?></strong>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?= esc(trans("email")); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?= esc($buyer->email); ?></strong>
                                    </div>
                                </div>
                            <?php endif;
                        endif; ?>
                    </div>
                </div>
                <?php if (!empty($shipping)): ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <h4 class="sec-title"><?= esc(trans("billing_address")); ?></h4>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("first_name")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bFirstName) ? esc($shipping->bFirstName) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("last_name")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bLastName) ? esc($shipping->bLastName) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("email")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bEmail) ? esc($shipping->bEmail) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("phone_number")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bPhoneNumber) ? esc($shipping->bPhoneNumber) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("address")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bAddress) ? esc($shipping->bAddress) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("country")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bCountry) ? esc($shipping->bCountry) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("state")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bState) ? esc($shipping->bState) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("city")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bCity) ? esc($shipping->bCity) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("zip_code")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->bZipCode) ? esc($shipping->bZipCode) : ''; ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <h4 class="sec-title"><?= esc(trans("shipping_address")); ?></h4>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("first_name")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sFirstName) ? esc($shipping->sFirstName) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("last_name")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sLastName) ? esc($shipping->sLastName) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("email")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sEmail) ? esc($shipping->sEmail) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("phone_number")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sPhoneNumber) ? esc($shipping->sPhoneNumber) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("address")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sAddress) ? esc($shipping->sAddress) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("country")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sCountry) ? esc($shipping->sCountry) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("state")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sState) ? esc($shipping->sState) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("city")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sCity) ? esc($shipping->sCity) : ''; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?= esc(trans("zip_code")); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?= !empty($shipping->sZipCode) ? esc($shipping->sZipCode) : ''; ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans("products")); ?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive" id="t_product">
                            <table class="table table-bordered" role="grid">
                                <thead>
                                <tr role="row">
                                    <th><?= esc(trans('product_id')); ?></th>
                                    <th><?= esc(trans('product')); ?></th>
                                    <th><?= esc(trans('unit_price')); ?></th>
                                    <th><?= esc(trans('quantity')); ?></th>
                                    <th><?= esc(trans('vat')); ?></th>
                                    <th><?= esc(trans('shipping_cost')); ?></th>
                                    <th><?= esc(trans('total')); ?></th>
                                    <th><?= esc(trans('status')); ?></th>
                                    <th><?= esc(trans('updated')); ?></th>
                                    <th class="max-width-120"><?= esc(trans('options')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $isOrderHasPhysicalProduct = false;
                                if (!empty($orderProducts)):
                                    foreach ($orderProducts as $item):
                                       $orderModel = new \App\Models\OrderModel();
                                       $coupons = $orderModel->getOrderItemCoupons($item->id);
                                        $itemSku = getOrderSku($item);
                                        $product = getProduct($item->product_id);
                                        if ($item->product_type == 'physical') {
                                            $isOrderHasPhysicalProduct = true;
                                        } ?>
                                        <tr class="tr-order">
                                        <td style="width: 80px;">
                                            <?= esc($item->product_id); ?>
                                        </td>
                                        <td>
                                            <div class="img-table">
                                                <a href="<?= generateProductUrl($product); ?>" target="_blank">
                                                    <img src="<?= getOrderImageUrl($item->image_data, $item->product_id); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                </a>
                                            </div>
                                            <div style="height: 100px;">
                                                <?php if ($item->product_type == 'digital'): ?>
                                                    <p>
                                                        <label class="label bg-black"><i class="icon-cloud-download"></i><?= esc(trans("instant_download")); ?></label>
                                                    </p>
                                                <?php endif; ?>
                                                <a href="<?= generateProductUrl($product); ?>" target="_blank" class="table-product-title"><?= esc($item->product_title); ?></a>
                                                <div class="item">
                                                    <?= formatCartOptionsSummary($item->product_options_snapshot, $activeLang->short_form, true, '<br>'); ?>
                                                </div>
                                                <?php if ($item->product_type === 'coupon'): ?>
                                                    <div class="item m-b-5">
                                                        <strong>Coupon code:</strong>
                                                        <?php if (!empty($coupons) && isset($coupons[0]->coupon_code)): ?>
                                                            <?= esc($coupons[0]->coupon_code); ?>
                                                        <?php else: ?>
                                                            <span>Not Assigned</span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($itemSku)): ?>
                                                    <div><?= esc(trans("sku")); ?>:&nbsp;<?= esc($itemSku); ?></div>
                                                <?php endif; ?>
                                                <p>
                                                    <span><?= esc(trans("by")); ?></span>
                                                    <?php $seller = getUser($item->seller_id);
                                                    if (!empty($seller)): ?>
                                                        <a href="<?= generateProfileUrl($seller->slug); ?>" target="_blank" class="table-product-title"><strong><?= esc(getUsername($seller)); ?></strong></a>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </td>
                                        <td><?= priceFormatted($item->product_unit_price, $item->product_currency); ?></td>
                                        <td><?= $item->product_quantity; ?></td>
                                        <td>
                                            <?php if ($item->product_vat):
                                                echo priceFormatted($item->product_vat, $item->product_currency); ?>&nbsp;(<?= $item->product_vat_rate; ?>%)
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($item->product_type == 'physical'):
                                                echo priceFormatted($item->seller_shipping_cost, $item->product_currency);
                                            endif; ?>
                                        </td>
                                        <td><?= priceFormatted($item->product_total_price, $item->product_currency); ?></td>
                                        <td>
                                            <strong><?= esc(trans($item->order_status)); ?></strong>
                                            <?php if ($item->buyer_id == 0):
                                                if ($item->is_approved == 0): ?>
                                                    <br>
                                                    <form action="<?= base_url('OrderAdmin/approveGuestOrderProduct'); ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="order_product_id" value="<?= $item->id; ?>">
                                                        <button type="submit" class="btn btn-xs btn-primary m-t-5"><?= esc(trans("approve")); ?></button>
                                                    </form>
                                                <?php endif;
                                            endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($item->product_type == 'physical'):
                                                echo timeAgo($item->updated_at);
                                            endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($order->status != 2):
                                                if (($item->product_type == 'digital' && $item->order_status != 'completed') || $item->product_type == 'physical'): ?>
                                                    <div class="dropdown">
                                                        <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?>
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu options-dropdown">
                                                            <?php if ($item->order_status != 'refund_approved'): ?>
                                                                <li>
                                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#updateStatusModal_<?= $item->id; ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('update_order_status')); ?></a>
                                                                </li>
                                                            <?php endif; ?>
                                                            <li>
                                                                <!-- <a href="javascript:void(0)" onclick="deleteItem('OrderAdmin/deleteOrderProductPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                                    <a href="#" class="btn-item-delete" data-url="OrderAdmin/deleteOrderProductPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_user', true)); ?>">
                                                                    <i class="fa fa-times option-icon"></i><?= esc(trans('delete')); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                <?php endif;
                                            endif; ?>
                                        </td>
                                        <?php if ($item->product_type != "digital"): ?>
                                        <tr class="tr-shipping " style="background-color: #F3F6F9 !important; margin-top:40px !important;">
                                            <td colspan="10">
                                                <div class="order-shipping-tracking-number">
                                                    <p><strong><?= esc(trans("shipping")) ?></strong></p>
                                                    <p class="font-600 m-t-5"><?= esc(trans("shipping_method")) ?>:&nbsp;<?= esc(trans($item->shipping_method)); ?></p>
                                                    <?php if ($item->order_status == 'shipped' || $item->order_status == 'completed'): ?>
                                                        <p class="font-600 m-t-15 m-b-5"><?= esc(trans("order_has_been_shipped")); ?></p>
                                                        <p class="m-b-5"><?= esc(trans("tracking_code")) ?>:&nbsp;<?= esc($item->shipping_tracking_number); ?></p>
                                                        <p class="m-0"><?= esc(trans("tracking_url")) ?>: <a href="<?= esc($item->shipping_tracking_url); ?>" target="_blank" class="link-underlined"><?= esc($item->shipping_tracking_url); ?></a></p>
                                                    <?php else: ?>
                                                        <p><?= esc(trans("order_not_yet_shipped")); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                            <?php if (empty($orderProducts)): ?>
                                <p class="text-center">
                                    <?= esc(trans("no_records_found")); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box-payment-total">
            <div class="row row-details">
                <div class="col-xs-12 col-sm-6 col-left">
                    <strong> <?= esc(trans("subtotal")); ?></strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-right text-right">
                    <strong class="font-right"><?= priceFormatted($order->price_subtotal, $order->price_currency); ?></strong>
                </div>
            </div>
            <?php $affiliate = unserializeData($order->affiliate_data);
            if (!empty($affiliate) && !empty($affiliate['discount'])): ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-left">
                        <strong><?= esc(trans("referral_discount")); ?>&nbsp;(<?= $affiliate['discountRate']; ?>%)</strong>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-right text-right">
                        <strong class="font-right">-&nbsp;<?= priceCurrencyFormat($affiliate['discount'], $order->price_currency); ?></strong>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($order->price_vat) && $order->price_vat > 0): ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-left">
                        <strong><?= esc(trans("vat")); ?></strong>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-right text-right">
                        <strong class="font-right"><?= priceFormatted($order->price_vat, $order->price_currency); ?></strong>
                    </div>
                </div>
            <?php endif;
            if ($isOrderHasPhysicalProduct): ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-left">
                        <strong><?= esc(trans("shipping")); ?></strong>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-right text-right">
                        <strong class="font-right"><?= priceFormatted($order->price_shipping, $order->price_currency); ?></strong>
                    </div>
                </div>
            <?php endif;
            if ($order->coupon_discount > 0): ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-left">
                        <strong><?= esc(trans("coupon")); ?>&nbsp;&nbsp;[<?= esc($order->coupon_code); ?>]</strong>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-right text-right">
                        <strong class="font-right">-&nbsp;<?= priceFormatted($order->coupon_discount, $order->price_currency); ?></strong>
                    </div>
                </div>
            <?php endif;
            if (!empty($order->global_taxes_data)):
                $globalTaxesArray = unserializeData($order->global_taxes_data);
                if (!empty($globalTaxesArray)):
                    foreach ($globalTaxesArray as $taxItem):?>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-6 col-left">
                                <strong><?= esc(getTaxName($taxItem['taxNameArray'], selectedLangId())); ?>&nbsp;(<?= $taxItem['taxRate']; ?>%)</strong>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-right text-right">
                                <strong class="font-right"><?= priceDecimal($taxItem['taxTotal'], $order->price_currency); ?></strong>
                            </div>
                        </div>
                    <?php endforeach;
                endif;
            endif;
            if (!empty($order->transaction_fee) && $order->transaction_fee > 0): ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-left">
                        <strong><?= esc(trans("transaction_fee")); ?><?= $order->transaction_fee_rate ? ' (' . $order->transaction_fee_rate . '%)' : ''; ?></strong>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-right text-right">
                        <strong class="font-right"><?= priceFormatted($order->transaction_fee, $order->price_currency); ?></strong>
                    </div>
                </div>
            <?php endif; ?>
            <hr>
            <div class="row row-details">
                <div class="col-xs-12 col-sm-6 col-left">
                    <strong><?= esc(trans("total")); ?></strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-right text-right">
                    <?php $priceSecondCurrency = "";
                    if (!empty($transaction) && $transaction->currency != $order->price_currency):
                        $priceSecondCurrency = priceCurrencyFormat($transaction->payment_amount, $transaction->currency);
                    endif; ?>
                    <strong>
                        <?= priceFormatted($order->price_total, $order->price_currency);
                        if (!empty($priceSecondCurrency)):?>
                            <br><span style="font-weight: 400;white-space: nowrap;">(<?= esc(trans("paid")); ?>:&nbsp;<?= $priceSecondCurrency; ?>&nbsp;<?= $transaction->currency; ?>)</span>
                        <?php endif; ?>
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($orderProducts)):
    foreach ($orderProducts as $item): ?>
        <div id="updateStatusModal_<?= $item->id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?= base_url('OrderAdmin/updateOrderProductStatusPost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="<?= $item->id; ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?= esc(trans("update_order_status")); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-order-status">
                                <div class="form-group">
                                    <label class="control-label"><?= esc(trans('status')); ?></label>
                                    <select name="order_status" class="form-control">
                                        <?php if ($item->product_type == 'physical'): ?>
                                            <option value="pending_payment" <?= $item->order_status == 'pending_payment' ? 'selected' : ''; ?>><?= esc(trans("pending_payment")); ?></option>
                                            <option value="payment_received" <?= $item->order_status == 'payment_received' ? 'selected' : ''; ?>><?= esc(trans("payment_received")); ?></option>
                                            <option value="order_processing" <?= $item->order_status == 'order_processing' ? 'selected' : ''; ?>><?= esc(trans("order_processing")); ?></option>
                                            <option value="shipped" <?= $item->order_status == 'shipped' ? 'selected' : ''; ?>><?= esc(trans("shipped")); ?></option>
                                        <?php endif; ?>
                                        <?php if ($item->buyer_id != 0 && $item->order_status != 'completed'): ?>
                                            <option value="completed" <?= $item->order_status == 'completed' ? 'selected' : ''; ?>><?= esc(trans("completed")); ?></option>
                                        <?php endif; ?>
                                        <option value="refund_approved" <?= $item->order_status == 'refund_approved' ? 'selected' : ''; ?>><?= esc(trans("refund_approved")); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><?= esc(trans("save_changes")); ?></button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><?= esc(trans("close")); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach;
endif; ?>

<style <?= csp_style_nonce() ?>>
    .sec-title {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }

    .font-right {
        font-weight: 700;
        margin-left: 5px;
    }

    .font-right a {
        color: #55606e;
    }

    .row-details {
        margin-bottom: 10px;
    }

    .col-right {
        max-width: 240px;
    }

    .label {
        font-size: 12px !important;
    }

    .box-payment-total {
        width: 480px;
        max-width: 100%;
        float: right;
        background-color: #fff;
        padding: 30px;
    }

    .tr-order td {
        padding: 15px 8px !important;
    }
    .tr-shipping {
    margin-top: 100px !important;
    }

    @media (max-width: 768px) {
        .col-right {
            width: 100%;
            max-width: none;
        }

        .col-sm-8 strong {
            margin-left: 0;
        }
    }

</style>