<?php
$listingType = $product->listing_type;
if ($listingType === 'productbid') {
    $biddingModel = new \App\Models\BiddingModel();
    $biddingModel->autoCloseBiddingIfExpired($product->id);
    $product = getProduct($product->id);
}
$productType = $product->product_type;

// Default values
$formAction = '';
$formId = '';
$formButtonHtml = '';
$needsFormWrapper = false;

// Determine stock and disabled status
$isSold = $product->is_sold == 1;
$isOutOfStock = $productStock <= 0;
$disabledAttr = $isOutOfStock ? ' disabled' : '';
$isCouponExpired = false;
$highestBidAmount = 0;

if (!empty($highestBid) && !empty($highestBid->highest_bid)) {
    $highestBidAmount = (float) $highestBid->highest_bid;
}

if ($product->product_type === 'coupon' && !empty($product->coupon_expiry)) {
    $isCouponExpired = strtotime($product->coupon_expiry) < time();
}


if ($listingType == 'sell_on_site' || $listingType == 'license_key' || $listingType == 'coupon') {

    $needsFormWrapper = true;

    if ($productType == 'digital' && $product->is_free_product == 1) {
        $formAction = base_url('download-free-digital-file-post');
        } else {
            $formAction = base_url('add-to-cart');
            $formId = 'form-add-to-cart';
            if (!$isSold && !$isCouponExpired) {
                $formButtonHtml = '<div class="inline-buttons"><button id="add-to-cart-button"class="btn btn-md btn-custom btn-product-cart btn-add-to-cart"' . $disabledAttr . '><span class="btn-cart-icon"><i class="icon-cart-solid"></i></span>' . trans("add_to_cart") . '</button>';
                $formButtonHtml .= '<button type="button"id="btn-buy-now"class="btn btn-md btn-outline-primary"' . $disabledAttr . '>' . trans("buy_now") . '</button>';
                $formButtonHtml .= '</div>';
            }
        }
    } elseif ($listingType == 'bidding') {
        $needsFormWrapper = true;
        $formAction = base_url('bidding/request-quote-post');
        $formId = 'form_request_quote';
        if (!$isSold) {
            if (!authCheck()) {
                $formButtonHtml = '<button type="button" data-toggle="modal" data-target="#loginModal" class="btn btn-md btn-custom btn-product-cart"' . $disabledAttr . '><span class="btn-cart-icon"><i class="icon-tag"></i></span>' . trans("request_a_quote") . '</button>';
            } else {
                $formButtonHtml = '<button id="add-to-cart-button" class="btn btn-md btn-custom btn-product-cart"' . $disabledAttr . '><span class="btn-cart-icon"><i class="icon-tag"></i></span>' . trans("request_a_quote") . '</button>';
            }
        }
    } elseif ($listingType == 'productbid') {
        $needsFormWrapper = true;
        $formAction = base_url('bidding/place-bid');
        $formId = 'form_place_bid';
        $now   = time();
        $start = strtotime($product->bidding_start_time ?? '');
        $end   = strtotime($product->bidding_end_time ?? '');
        if ($product->bidding_status === 'closed' || ($end && $now > $end)) {
            $formButtonHtml = '<div style="color:#666; border:1px solid #f3d19c; text-align:center; background:#fff7e6;">' . trans("Bidding closed") . '</div>';
        } elseif ($start && $now < $start) {
            $formButtonHtml = '<div style="color:#666;border:1px solid #f3d19c; text-align:center;background:#fff7e6;">' . trans("Bidding starts soon") . '</div>';
        } elseif (!authCheck()) {
            $formButtonHtml = '<button type="button"data-toggle="modal" data-target="#loginModal" class="btn btn-md btn-custom btn-product-cart"> <i class="icon-gavel"></i> ' . trans("Bid Now") . ' </button>';
        } else {
              $formButtonHtml = '<div class="d-flex align-items-center bid-inline-box">
                    <input type="number"name="bid_amount"class="form-control bid-input"="Enter bid amount"min="' . ((float)$product->minimum_price + 1) . '"placeholder="Enter the bid amount"required>
                    <button type="submit"class="btn btn-md btn-custom btn-product-cart bid-btn text-center"><i class="icon-gavel"></i> ' . trans("Bid Now") . '</button>
                </div>';
        }
    }else {
        $needsFormWrapper = false;
        if (!$isSold && !empty($product->external_link)) {
            $formButtonHtml = '<a href="' . $product->external_link . '" class="btn btn-md btn-custom btn-product-cart" target="_blank" rel="nofollow">' . trans("buy_now") . '</a>';
        } else if (!$isSold) {
            if ($showVendorContactInfo) {
                $formButtonHtml = '<button type="button" class="btn btn-md btn-custom btn-product-cart" data-toggle="modal" data-target="#messageModal">' . trans("contact_seller") . '</button>';
            } else {
                $formButtonHtml = '<button type="button" class="btn btn-md btn-custom btn-product-cart" data-toggle="modal" data-target="#loginModal">' . trans("contact_seller") . '</button>';
            }
        }
    }

if ($needsFormWrapper): ?>
<form action="<?= $formAction ?>" method="post" <?= !empty($formId) ? 'id="' . $formId . '"' : '' ?>>
    <?= csrf_field() ?>
    <input type="hidden" name="product_id" value="<?= $product->id ?>">
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <?= view('product/details/_product_options', ['initialProductData_json' => $initialProductData_json]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12"><?= view('product/details/_messages') ?></div>
    </div>
    <?php if ($listingType == 'productbid' && $product->bidding_status !== 'closed'): ?>
    <div class="highest-bid-box mb-2">
        <strong><?= trans("Highest Bid") ?>:</strong>
        <span class="text-success">
            <?= ($highestBidAmount); ?>
        </span>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12 product-add-to-cart-container action-row">
            <?php if (!$isSold && !$isCouponExpired && $listingType != 'ordinary_listing' && $productType != 'digital' && $listingType != 'productbid'): ?>
            <div class="number-spinner">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-spinner-minus" data-dir="dwn">-</button>
                    </span>
                    <input type="text" id="input_product_quantity" class="form-control text-center"
                        name="product_quantity" value="1" aria-label="Product quantity" min="1"
                        max="<?= clrNum($productStock) ?>">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-spinner-plus" data-dir="up">+</button>
                    </span>
                </div>
            </div>
            <?php endif;
             if ( $listingType == 'productbid'):?>
            <?php $maxQty = ($listingType == 'productbid')? (int)$product->bid_quantity: (int)$productStock;?>
            <div class="number-spinner">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-spinner-minus" data-dir="dwn">-</button>
                    </span>
                    <input type="text" id="input_product_quantity" class="form-control text-center" name="product_quantity" value="1" min="1" max="<?= $maxQty; ?>">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default btn-spinner-plus" data-dir="up">+</button>
                    </span>
                </div>
            </div>
            <?php endif;

            if (!empty($formButtonHtml)):?>
            <div class="button-container">
                <?= $formButtonHtml ?>
            </div>
            <?php endif; ?>

            <?php if ($productType == 'digital' && $product->is_free_product == 1):
                if (authCheck()):
                    if (!empty($product->digital_file_download_link)): ?>
            <div class="button-container">
                <a href="<?= esc($product->digital_file_download_link) ?>"
                    class="btn btn-md btn-custom btn-product-cart" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-download" viewBox="0 0 16 16">
                        <path
                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                        <path
                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                    </svg>&nbsp;&nbsp;<?= trans('download') ?>
                </a>
            </div>
            <?php else: ?>
            <div class="button-container">
                <button type="submit" class="btn btn-md btn-custom btn-product-cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-download" viewBox="0 0 16 16">
                        <path
                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                        <path
                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                    </svg>&nbsp;&nbsp;<?= trans('download') ?>
                </button>
            </div>
            <?php endif;
                else: ?>
            <div class="button-container">
                <button type="button" class="btn btn-md btn-custom btn-product-cart" data-toggle="modal"
                    data-target="#loginModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-download" viewBox="0 0 16 16">
                        <path
                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                        <path
                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                    </svg>&nbsp;&nbsp;<?= trans('download') ?>
                </button>
            </div>
            <?php endif;
            endif; ?>

            <div class="button-container button-container-wishlist">
                <?php if ($isProductInWishlist == 1): ?>
                <button type="button" class="button-link btn-wishlist btn-add-remove-wishlist"
                    data-product-id="<?= $product->id ?>" data-type="details"><i class="icon-heart"
                        aria-label="add-remove-wishlist"></i><span><?= trans('remove_from_wishlist') ?></span></button>
                <?php else: ?>
                <button type="button" class="button-link btn-wishlist btn-add-remove-wishlist"
                    data-product-id="<?= $product->id ?>" data-type="details"><i class="icon-heart-o"
                        aria-label="add-remove-wishlist"></i><span><?= trans('add_to_wishlist') ?></span></button>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($product->demo_url)): ?>
        <div class="col-12 product-add-to-cart-container">
            <div class="button-container">
                <a href="<?= $product->demo_url ?>" target="_blank" class="btn btn-md btn-live-preview"><i
                        class="icon-preview"></i><?= trans('live_preview') ?></a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php if ($needsFormWrapper): ?>
</form>
<?php endif; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" <?= csp_script_nonce() ?>></script>
<script <?= csp_script_nonce() ?>>
$(document).on('click', '#btn-buy-now', function () {

    const form = $('#form-add-to-cart');

    const buyNowForm = $('<form>', {
        method: 'POST',
        action: '<?= base_url('buy-now') ?>'
    });

    buyNowForm.append(form.find('input[name="product_id"]').clone());
    buyNowForm.append(form.find('input[name="product_quantity"]').clone());
    buyNowForm.append(form.find('input[name="variant_id"]').clone());
    buyNowForm.append(form.find('input[name="extra_options"]').clone());
    buyNowForm.append(form.find('input[name="<?= csrf_token() ?>"]').clone());

    $('body').append(buyNowForm);
    buyNowForm.submit();
});
</script>
<style <?= csp_style_nonce() ?>>
.action-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.inline-buttons {
    display: flex;
    gap: 8px;
}

.action-row #btn-buy-now {
    background: #0d6efd !important;
    color: #fff !important;
    border: none !important;
    white-space: nowrap;
}

.button-container-wishlist {
    white-space: nowrap;
}
.bid-inline-box {
    gap: 10px;
    width: 100%;
}

.bid-inline-box .bid-input {
    max-width: 160px;
    height: 44px;
}

.bid-inline-box .bid-btn {
    height: 44px;
    white-space: nowrap;
}
</style>

