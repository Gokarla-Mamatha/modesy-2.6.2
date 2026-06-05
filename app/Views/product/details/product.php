<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-products breadcrumb-mobile-scroll">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= esc(trans("home")); ?></a></li>
                        <?php if (!empty($parentCategoriesTree)):
                            foreach ($parentCategoriesTree as $item):?>
                                <li class="breadcrumb-item"><a href="<?= generateCategoryUrl($item); ?>"><?= esc($item->cat_name); ?></a></li>
                            <?php endforeach;
                        endif; ?>
                        <li class="breadcrumb-item active"><?= esc($title); ?></li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="product-details-container <?= (!empty($video) || !empty($audio)) && countItems($productImages) < 2 ? 'product-details-container-digital' : ''; ?>">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-6 col-product-details-left">
                            <div id="product_slider_container">
                                <?= view("product/details/_preview"); ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-lg-6 col-product-details-right">
                            <div id="response_product_details" class="product-content-details">
                                <?= view("product/details/_product_details"); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="product_description_content" class="product-description post-text-responsive">
                            <?php $session = session();
                            $isReviewTabActive = false;
                            if (!empty($session->getFlashdata('review_added'))) {
                                $isReviewTabActive = true;
                            } ?>
                              <!-- TABS (Smooth scroll navigation) -->
                      <ul class="nav nav-tabs nav-tabs-horizontal mb-5" id="productTabs">
                            <li class="nav-item">
                                <a class="nav-link" href="#about_section"><?= esc(trans("About")); ?></a>
                            </li>
                            <?php if (!empty($product->coupon_description)): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#need_to_know_section"><?= esc(trans("need_to_know_info")); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if (!empty($product->coupon_redeem_place)): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#where_to_redeem_section"><?= esc(trans("where_to_redeem")); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if ($generalSettings->reviews == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#reviews_section"><?= esc(trans("reviews")); ?> (<?= $reviewsCount; ?>)</a>
                            </li>
                            <?php endif; ?>

                            <?php if ($generalSettings->product_comments == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#comments_section"><?= esc(trans("comments")); ?> (<?= $commentsCount; ?>)</a>
                            </li>
                            <?php endif; ?>
                      </ul>

                        <!-- CONTENT -->
                        <div class="product-description post-text-responsive">
                            <!-- About -->
                            <div id="about_section" class="mb-2">
                                <div class="description">
                                    <?= $productDetails->description ?: '<p class="text-muted">No description available.</p>'; ?>
                                </div>
                                <div class="row-custom text-right m-b-10">
                                    <?php
                                        $vendor = getUser($product->user_id);
                                    ?>
                                    <?php if (authCheck()):
                                        if (isActiveAffiliateProduct($product, $vendor)): ?>
                                            <button type="button" id="btnCreateAffiliateLink" class="button-link text-muted link-abuse-report link-abuse-report-button display-inline-flex align-items-center" data-id="<?= $product->id; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 640 512" fill="currentColor">
                                                <path d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/>
                                                </svg>&nbsp;<?= esc(trans("create_affiliate_link")); ?>
                                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php endif;
                                        if ($product->user_id != user()->id): ?>
                                            <button type="button" class="button-link text-muted link-abuse-report link-abuse-report-button display-inline-flex align-items-center" data-toggle="modal" data-target="#reportProductModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 512 512" fill="currentColor">
                                                <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                                                </svg>&nbsp;<?= esc(trans("report_this_product")); ?>
                                            </button>
                                        <?php endif;
                                        else: ?>
                                            <button type="button" class="button-link text-muted link-abuse-report link-abuse-report-product display-inline-flex align-items-center" data-toggle="modal" data-target="#loginModal">
                                                <?= esc(trans("report_this_product")); ?>
                                            </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- NEED TO KNOW -->
                            <?php if (!empty($product->coupon_description)): ?>
                            <div id="need_to_know_section" class="mb-5">
                                <h4 class="font-weight-bold mb-4 text-primary"><?= esc(trans("need_to_know_info")); ?></h4>
                                <div class="description">
                                    <?= strip_tags($product->coupon_description, '<p><br><b><i><ul><li>'); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- WHERE TO REDEEM -->
                            <?php if (!empty($product->coupon_redeem_place) || !empty($product->coupon_contact) || !empty($product->coupon_map_link)): ?>
                            <div id="where_to_redeem_section" class="mb-5">

                                <h4 class="font-weight-bold mb-4 text-primary"><?= esc(trans("where_to_redeem")); ?></h4>

                                <?php if (!empty($product->coupon_map_link)): ?>
                                    <div class="redeem-map mb-3">
                                        <iframe
                                            src="<?= esc($product->coupon_map_link); ?>"
                                            loading="lazy"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($product->coupon_redeem_place)): ?>
                                    <label class="fw-bold mb-1" style="font-size: 15px; font-weight: 700; color: #000;">Address</label>
                                    <h5 class="fw-bold mb-3" style="font-size: 15px;">
                                        <?= esc($product->coupon_redeem_place); ?>
                                    </h5>
                                <?php endif; ?>
                                <?php if (!empty($product->coupon_contact)): ?>
                                    <a href="tel:<?= esc($product->coupon_contact); ?>"
                                    class="btn btn-outline-dark rounded-pill px-4 py-2">
                                    <i class="fa fa-phone me-2"></i> Call
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                           <!-- ADDITIONAL INFORMATION -->
                            <?php if (!empty($productCustomFieldsValues['bottom'])): ?>
                            <div id="additional_information_section" class="mb-5">
                                <h4 class="font-weight-bold mb-4 text-primary"><?= esc(trans("additional_information")); ?></h4>
                                <table class="table table-striped table-bordered">
                                    <?php foreach ($productCustomFieldsValues['bottom'] as $item): ?>
                                    <tr>
                                        <td class="font-weight-medium"><?= esc($item['name']); ?></td>
                                        <td><?= esc($item['value']); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <?php endif; ?>
                            <!-- REVIEWS -->
                            <?php if ($generalSettings->reviews == 1): ?>
                            <div id="reviews_section" class="mb-2">
                                <h4 class="font-weight-bold mb-2" style="color: #e76528;">
                                    <?= esc(trans("reviews")); ?> (<?= $reviewsCount; ?>)
                                </h4>
                                <div id="review-result"><?php if (!empty($product->review_count) && $product->review_count > 0): ?>
                                        <?= view('partials/_review_stars', ['rating' => $product->rating]); ?>
                                    <?php else: ?>
                                        <span class="text-muted">No reviews yet</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <!-- COMMENTS -->
                            <?php if ($generalSettings->product_comments == 1): ?>
                            <div id="comments_section" >
                                <h4 class="font-weight-bold mb-4" style="color: #e76528;">
                                    <?= esc(trans("comments")); ?> (<?= $commentsCount; ?>)
                                </h4>
                                <?= view('product/details/_comments', ['commentsArray' => $commentsArray]); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= view('partials/_ad_spaces', ['adSpace' => 'product_1', 'class' => 'mb-4']); ?>
            <?php if (!empty($userProducts) && $generalSettings->multi_vendor_system == 1): ?>
                <div class="col-12 section section-related-products m-t-30">
                    <strong class="title"><?= esc(trans("more_from")); ?>&nbsp;<a href="<?= generateProfileUrl($user->slug); ?>"><?= esc(getUsername($user)); ?></a></strong>
                    <div class="row row-product">
                        <?php $count = 0;
                        foreach ($userProducts as $item):
                            if ($count < 5):?>
                                <div class="col-6 col-sm-4 col-md-3 col-product <?= $generalSettings->index_products_per_row == 5 ? 'col-product-5' : 'col-product-6'; ?>">
                                    <?= view('product/_product_item', ['product' => $item]); ?>
                                </div>
                            <?php endif;
                            $count++;
                        endforeach; ?>
                    </div>
                    <?php if (countItems($userProducts) > 5): ?>
                        <div class="row-custom text-center">
                            <a href="<?= generateProfileUrl($product->user_slug); ?>" class="link-see-more"><span><?= esc(trans("view_all")); ?>&nbsp;</span><i class="icon-arrow-right"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif;
            if (!empty($relatedProducts) && countItems($relatedProducts) > 0):
                shuffle($relatedProducts); ?>
                <div class="col-12 section section-related-products">
                    <strong class="title"><?= esc(trans("you_may_also_like")); ?></strong>
                    <div class="row row-product">
                        <?php $i = 0;
                        foreach ($relatedProducts as $item):
                            if ($i < 10):?>
                                <div class="col-6 col-sm-4 col-md-3 col-product <?= $generalSettings->index_products_per_row == 5 ? 'col-product-5' : 'col-product-6'; ?>">
                                    <?= view('product/_product_item', ['product' => $item]); ?>
                                </div>
                            <?php endif;
                            $i++;
                        endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?= view('partials/_ad_spaces', ['adSpace' => 'product_2', 'class' => 'mb-4']); ?>
        </div>
    </div>
</div>

<?= view('partials/_modal_send_message', ['subject' => esc($title), 'productId' => $product->id]); ?>

<?php if (isActiveAffiliateProduct($product, $vendor)): ?>
    <div class="modal fade" id="affliateLinkModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom modal-affiliate-link">
                <div class="modal-header">
                    <h5 class="modal-title m-b-15"><?= esc(trans("affiliate_link")); ?></h5>
                    <div class="affiliate-link-exp"><?= esc(trans("affiliate_link_exp")); ?></div>
                    <button type="button" class="close" data-dismiss="modal">
                        <span><i class="icon-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <?php
                            $affCommissionRate = 0;
                            $affDiscountRate = 0;
                            if ($affiliateSettings->type == 'site_based') {
                                $affCommissionRate = !empty($affiliateSettings->commission_rate) ? $affiliateSettings->commission_rate : 0;
                                $affDiscountRate = !empty($affiliateSettings->discount_rate) ? $affiliateSettings->discount_rate : 0;
                            } else {
                                $affCommissionRate = !empty($user->affiliate_commission_rate) ? $user->affiliate_commission_rate : 0;
                                $affDiscountRate = !empty($user->affiliate_discount_rate) ? $user->affiliate_discount_rate : 0;
                            } ?>

                            <?php if (!empty($affCommissionRate)): ?>
                                <div class="m-b-15"><?= esc(trans("referrer_commission_rate")); ?>:&nbsp;<strong><?= esc($affCommissionRate); ?>%</strong></div>
                            <?php endif; ?>
                            <?php if (!empty($affDiscountRate)): ?>
                                <div class="m-b-15"><?= esc(trans("buyer_discount_rate")); ?>:&nbsp;<strong><?= esc($affDiscountRate); ?>%</strong></div>
                            <?php endif; ?>
                            <div class="copy-code-container copy-code-container-link">
                                <span class="code" id="spanAffLink"></span>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="button" id="btnCopyAffLink" class="btn btn-block"><span><?= esc(trans("copy_link")); ?></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (authCheck() && $product->user_id != user()->id): ?>
    <div class="modal fade" id="reportProductModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom modal-report-abuse">
                <form id="form_report_product" method="post">
                    <input type="hidden" name="id" value="<?= $product->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= esc(trans("report_this_product")); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="response_form_report_product" class="col-12"></div>
                            <div class="col-12">
                                <div class="form-group m-0">
                                    <label class="control-label"><?= esc(trans("description")); ?></label>
                                    <textarea name="description" class="form-control form-textarea" data-type="text" placeholder="<?= esc(trans("abuse_report_exp")); ?>" minlength="5" maxlength="10000" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="submit" class="btn btn-md btn-custom"><?= esc(trans("submit")); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" id="reportCommentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <form id="form_report_comment" method="post">
                <div class="modal-header">
                    <h5 class="modal-title"><?= esc(trans("report_comment")); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span><i class="icon-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="response_form_report_comment" class="col-12"></div>
                        <div class="col-12">
                            <input type="hidden" id="report_comment_id" name="id" value="">
                            <div class="form-group m-0">
                                <label class="control-label"><?= esc(trans("description")); ?></label>
                                <textarea name="description" class="form-control form-textarea" placeholder="<?= esc(trans("abuse_report_exp")); ?>" minlength="5" maxlength="10000" data-type="text" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-md btn-custom"><?= esc(trans("submit")); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($generalSettings->facebook_comment_status == 1):
    echo $generalSettings->facebook_comment;
endif; ?>

<style <?= csp_style_nonce() ?>>
.product-location-map .embed-responsive {overflow: visible;}
.redeem-map {
    width: 70%;
    height: 320px;
    overflow: hidden;
    border-radius: 12px;
    position: relative;
}

.redeem-map iframe {
    width: 80% !important;
    height: 100% !important;
    border: 0;
    position: absolute;
    top: 0;
    left: 0;
}
</style>