<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= langBaseUrl(); ?>"><?= esc(trans("home")); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?= esc($title); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?= esc($title); ?></h1>
            </div>
        </div>

        <div class="row">
            <!-- LEFT TABS -->
            <div class="col-12 col-md-3">
                <?= view("order/_tabs"); ?>
            </div>

            <!-- CONTENT -->
            <div class="col-12 col-md-9">
                <div class="sidebar-tabs-content">
                    <?= view('partials/_messages'); ?>

                    <?php if (!empty($bids)): ?>
                        <?php foreach ($bids as $bid):
                            $product = getProduct($bid->product_id);
                            if (!empty($product)): ?>

                            <div class="order-list-item">
                                <div class="row align-items-center">

                                    <!-- PRODUCT -->
                                    <div class="col-12 col-lg-4">
                                        <div class="display-flex align-items-center product">
                                            <div class="flex-item">
                                                <div class="ratio ratio-product-box">
                                                    <a href="<?= generateProductUrl($product); ?>">
                                                        <img
                                                            src="<?= getProductMainImage($product->id, 'image_small'); ?>"
                                                            alt="<?= esc($bid->title); ?>"
                                                            class="img-fluid img-product">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="flex-item">
                                                <div class="m-b-5">
                                                    <strong>Bid:&nbsp;#<?= $bid->bid_id; ?></strong>
                                                </div>
                                                <h3 class="title">
                                                    <a href="<?= generateProductUrl($product); ?>">
                                                        <?= esc($bid->title); ?>
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- STATUS -->
                                    <div class="col-12 col-lg-2 m-t-15-mobile">
                                        <?php if ($bid->status == 'active'): ?>
                                            <span class="badge badge-warning-light"><?= esc(trans('active')); ?></span>
                                        <?php elseif ($bid->status == 'accepted'): ?>
                                            <span class="badge badge-success-light"style="text-transform: capitalize;"><?= esc(trans('accepted')); ?></span>
                                        <?php elseif ($bid->status == 'closed'): ?>
                                            <span class="badge badge-dark-light"><?= esc(trans('Closed')); ?></span>
                                        <?php elseif ($bid->status == 'outbid'): ?>
                                            <span class="badge badge-info-light"><?= esc(trans('Outbid')); ?></span>
                                        <?php elseif ($bid->status == 'rejected'): ?>
                                            <span class="badge badge-danger-light"><?= esc(trans('Rejected')); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary-light"><?= esc(trans($bid->status)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <!-- BID INFO -->
                                    <div class="col-12 col-lg-3 m-t-15-mobile">
                                        <div class="m-b-5">
                                           Bidding Amount:
                                            <strong>
                                                <?= priceFormatted(
                                                    convertCurrencyByExchangeRate(
                                                        $bid->bid_amount,
                                                        $selectedCurrency->exchange_rate
                                                    ),
                                                    $selectedCurrency->code
                                                ); ?>
                                            </strong>
                                        </div>
                                        <div class="display-flex align-items-center font-size-13">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                 viewBox="0 0 512 512" fill="#6c757d">
                                                <path d="M256 8C119 8 8 119 8 256s111 248 248 248
                                                         248-111 248-248S393 8 256 8zm0 448
                                                         c-110.5 0-200-89.5-200-200
                                                         S145.5 56 256 56s200 89.5 200 200
                                                         -89.5 200-200 200zm12-320h-24v144
                                                         l124.7 72.7 12-20.8-112.7-65.9V136z"/>
                                            </svg>
                                            &nbsp;<?= timeAgo($bid->created_at); ?>
                                        </div>
                                    </div>
                                    <!-- ACTIONS -->
                                    <div class="col-12 col-lg-3 col-buttons m-t-15-mobile">
                                        <?php if ($bid->status == 'accepted'): ?>
                                            <form action="<?= base_url('add-to-cart-bid'); ?>" method="post">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?= $bid->bid_id; ?>">
                                                <button type="submit" class="btn btn-sm btn-info color-white m-b-5">
                                                    <i class="icon-cart-solid"></i> <?= esc(trans("add_to_cart")); ?>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-light js-delete-bid" data-bid-id="<?= esc($bid->bid_id, 'attr'); ?>" data-msg="<?= esc(trans("confirm_quote_request", true), 'attr'); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#6c757d" width="14" height="14">
                                                    <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                                </svg>&nbsp;<?= esc(trans("delete_quote")); ?>
                                            </button>
                                    </div>

                                </div>
                            </div>

                        <?php endif; endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted"><?= esc(trans("no_records_found")); ?></p>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-center m-t-15">
                    <?= $pager->links; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script <?= csp_script_nonce() ?>>
function deleteBid(id, message) {
    Swal.fire(swalOptions(message)).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: generateUrl('order/delete-bid'),
                data: {
                    id: id
                },
                success: function () {
                    location.reload();
                }
            });
        }
    });
}

$(document).on('click', '.js-delete-bid', function () {
    deleteBid($(this).data('bid-id'), $(this).data('msg'));
});
</script>
