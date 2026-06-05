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
                        <button type="button" class="btn btn-default filter-toggle collapsed m-b-10" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false">
                            <i class="fa fa-filter"></i>&nbsp;&nbsp;<?= esc(trans("filter")); ?>
                        </button>
                        <div class="collapse navbar-collapse" id="collapseFilter">
                            <form action="<?= generateDashUrl('products'); ?>" method="get" id="formVendorProducts">
                                <?php if (!empty(inputGet('st'))): ?>
                                    <input type="hidden" name="st" value="<?= strSlug(inputGet('st')); ?>">
                                <?php endif; ?>
                                <div class="item-table-filter">
                                    <label><?= esc(trans('listing_type')); ?></label>
                                    <select name="listing_type" class="form-control custom-select">
                                        <option value="" selected><?= esc(trans("all")); ?></option>
                                        <option value="sell_on_site" <?= inputGet('listing_type') == 'sell_on_site' ? 'selected' : ''; ?>><?= esc(trans("marketplace_selling_product_on_the_site")); ?></option>
                                        <option value="ordinary_listing" <?= inputGet('listing_type') == 'ordinary_listing' ? 'selected' : ''; ?>><?= esc(trans("classified_ads_adding_product_as_listing")); ?></option>
                                        <option value="bidding" <?= inputGet('listing_type') == 'bidding' ? 'selected' : ''; ?>><?= esc(trans("bidding_system_request_quote")); ?></option>
                                        <option value="license_key" <?= inputGet('listing_type') == 'license_key' ? 'selected' : ''; ?>><?= esc(trans("selling_license_keys")); ?></option>
                                    </select>
                                </div>
                                <div class="item-table-filter">
                                    <label><?= esc(trans('product_type')); ?></label>
                                    <select name="product_type" class="form-control custom-select">
                                        <option value="" selected><?= esc(trans("all")); ?></option>
                                        <option value="physical" <?= inputGet('product_type') == 'physical' ? 'selected' : ''; ?>><?= esc(trans("physical")); ?></option>
                                        <option value="digital" <?= inputGet('product_type') == 'digital' ? 'selected' : ''; ?>><?= esc(trans("digital")); ?></option>
                                        <option value="coupon" <?= inputGet('product_type') == 'coupon' ? 'selected' : ''; ?>><?= esc(trans("coupon")); ?></option>
                                    </select>
                                </div>
                                <div class="item-table-filter">
                                    <label><?= esc(trans('category')); ?></label>
                                    <select id="categories" name="category" class="form-control custom-select" onchange="getFilterSubCategoriesDashboard(this.value);">
                                        <option value=""><?= esc(trans("all")); ?></option>
                                        <?php if (!empty($parentCategories)):
                                            foreach ($parentCategories as $item): ?>
                                                <option value="<?= $item->id; ?>" <?= inputGet('category', true) == $item->id ? 'selected' : ''; ?>><?= esc($item->cat_name); ?></option>
                                            <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="item-table-filter">
                                    <label class="control-label"><?= esc(trans('subcategory')); ?></label>
                                    <select id="subcategories" name="subcategory" class="form-control custom-select">
                                        <option value=""><?= esc(trans("all")); ?></option>
                                        <?php if (!empty(inputGet('category'))):
                                            $subCategories = getSubCategories(inputGet('category'));
                                            if (!empty($subCategories)):
                                                foreach ($subCategories as $item):?>
                                                    <option value="<?= $item->id; ?>" <?= inputGet('subcategory', true) == $item->id ? 'selected' : ''; ?>><?= esc($item->cat_name); ?></option>
                                                <?php endforeach;
                                            endif;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="item-table-filter">
                                    <label><?= esc(trans('stock')); ?></label>
                                    <select name="stock" class="form-control custom-select">
                                        <option value="" selected><?= esc(trans("all")); ?></option>
                                        <option value="in_stock" <?= inputGet("stock") == 'in_stock' ? 'selected' : ''; ?>><?= esc(trans("in_stock")); ?></option>
                                        <option value="out_of_stock" <?= inputGet("stock") == 'out_of_stock' ? 'selected' : ''; ?>><?= esc(trans("out_of_stock")); ?></option>
                                    </select>
                                </div>
                                <div class="item-table-filter item-table-filter-large">
                                    <label><?= esc(trans("search")); ?></label>
                                    <div class="item-table-filter-search">
                                        <input name="q" class="form-control" placeholder="<?= esc(trans("search")); ?>" type="search" value="<?= esc(inputGet('q')); ?>">
                                        <button type="submit" class="btn bg-purple"><?= esc(trans("filter")); ?></button>
                                        <div class="btn-group table-export">
                                            <button type="button" class="btn btn-default dropdown-bs-toggle btn-table-export" data-bs-toggle="dropdown"><?= esc(trans("export")); ?>&nbsp;&nbsp;<i class="fa fa-caret-down"></i></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <button type="button" class="btn-export-data" data-export-form="formVendorProducts" data-export-type="vendor_products" data-export-file-type="csv" data-section="vn">CSV</button>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn-export-data" data-export-form="formVendorProducts" data-export-type="vendor_products" data-export-file-type="xml" data-section="vn">XML</button>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn-export-data" data-export-form="formVendorProducts" data-export-type="vendor_products" data-export-file-type="excel" data-section="vn"><?= esc(trans("excel")); ?>&nbsp;(.xlsx)</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-products" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= esc(trans('id')); ?></th>
                            <th><?= esc(trans('product')); ?></th>
                            <th><?= esc(trans('product_type')); ?></th>
                            <th><?= esc(trans('category')); ?></th>
                            <?php if (!empty($generalSettings->promoted_products)): ?>
                                <th><?= esc(trans('purchased_plan')); ?></th>
                            <?php endif; ?>
                            <th><?= esc(trans('price')); ?></th>
                            <th><?= trans("stock") . '/' . trans("status"); ?></th>
                            <th><?= esc(trans('page_views')); ?></th>
                            <th><?= esc(trans('date')); ?></th>
                            <th class="max-width-120"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($products)):
                            foreach ($products as $item): ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td>
                                        <div class="media">
                                            <div class="<?= $activeLang->text_direction == 'rtl' ? 'media-right' : 'media-left'; ?>">
                                                <a href="<?= generateProductUrl($item); ?>" target="_blank">
                                                    <img data-src="<?= getProductItemImage($item); ?>" alt="" class="lazyload product-img">
                                                </a>
                                            </div>
                                            <div class="media-body <?= $activeLang->text_direction == 'rtl' ? 'text-right' : 'text-left'; ?>">
                                                <div class="m-b-5">
                                                    <a href="<?= generateProductUrl($item); ?>" target="_blank" class="table-link">
                                                        <?= esc($item->title); ?>
                                                    </a>
                                                </div>
                                                <?php if (!empty($item->sku)): ?>
                                                    <p class="m-b-5 font-size-13">
                                                        <strong><?= esc(trans('sku')); ?>:</strong>&nbsp;<?= esc($item->sku); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <p class="m-t-5">
                                                    <?php if ($item->is_promoted == 1): ?>
                                                        <span class="label label-success m-b-5"><?= esc(trans("featured")); ?></span>
                                                    <?php endif;
                                                    if ($affiliateSettings->status == 1 && $affiliateSettings->type == 'seller_based' && user()->vendor_affiliate_status == 2 && $item->is_affiliate == 1): ?>
                                                        <span class="label label-primary m-b-5"><?= esc(trans("affiliate_program")); ?></span>
                                                    <?php endif;
                                                    if ($item->is_commission_set == 1): ?>
                                                        &nbsp;&nbsp;<span class="label bg-warning"><i class="fa fa-hand-holding-dollar"></i>&nbsp;<?= esc(formatDecimalClean($item->commission_rate)) ?>%</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc(trans($item->product_type)); ?></td>
                                    <td><?= esc($item->cat_name); ?></td>
                                    <?php if (!empty($generalSettings->promoted_products)): ?>
                                        <td>
                                            <?php if ($item->is_draft != 1):
                                                if ($item->is_promoted == 1 && $item->promote_plan != 'none'):
                                                    echo esc($item->promote_plan);
                                                else: ?>
                                               <button type="button" class="btn btn-sm btn-success btn-promote-product"  data-bs-toggle="modal" data-bs-target="#modalPricing" data-product-id="<?= $item->id; ?>"> <i class="fa fa-plus"></i>&nbsp;<?= esc(trans("promote")); ?></button>
                                                <?php endif;
                                            endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if (!empty($item->price_discounted)): ?>
                                            <span><?= priceFormatted($item->price_discounted, $item->currency); ?></span>
                                        <?php else: ?>
                                            <span>-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="white-space-nowrap">
                                        <div class="m-b-5"><?= getProductStockStatus($item); ?></div>
                                        <?php if (!empty($productListStatus) && $productListStatus == 'pending'):
                                            if ($item->is_rejected == 1): ?>
                                                <div class="m-b-5">
                                                    <label class="label label-danger"><?= esc(trans("rejected")); ?></label>
                                                </div>
                                                <button type="button" class="btn btn-info btn-xs" data-bs-toggle="modal" data-bs-target="#modalReason<?= $item->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;<?= esc(trans("show_reason")); ?></button>
                                                <div id="modalReason<?= $item->id; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                                                                <h4 class="modal-title"><?= esc(trans("reason")); ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="m-t-10"><?= esc($item->reject_reason); ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?= esc(trans("close")); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <label class="label label-default"><?= esc(trans("pending")); ?></label>
                                            <?php endif;
                                        endif; ?>
                                    </td>
                                    <td><?= $item->pageviews; ?></td>
                                    <td>
                                        <?= formatDate($item->created_at); ?>
                                        <?php if (!empty($item->updated_at)): ?>
                                            <div class="text-muted m-t-5">
                                                <small><?= ucfirst(trans("edited") ?? ''); ?>:&nbsp;<?= timeAgo($item->updated_at); ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 120px;">
                                        <form action="<?= base_url('Dashboard/addRemoveAffiliateProductPost'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="product_id" value="<?= $item->id; ?>">
                                            <div class="btn-group btn-group-option">
                                                <a href="<?= generateDashUrl('edit_product') . '/' . $item->id; ?>" class="btn btn-sm btn-default btn-edit" data-bs-toggle="tooltip" title="<?= esc(trans('edit')); ?>"><i class="fa fa-edit"></i></a>
                                                <button type="button" class="btn btn-sm btn-default btn-edit" data-bs-toggle="tooltip" title="<?= esc(trans('duplicate')); ?>" onclick="duplicateProduct('<?= $item->id; ?>','<?= esc(trans("confirm_duplicate_product")); ?>');"><i class="fa-regular fa-copy"></i></button>
                                                <?php if ($affiliateSettings->status == 1 && $affiliateSettings->type == 'seller_based' && user()->vendor_affiliate_status == 2): ?>
                                                    <button type="submit" class="btn btn-sm btn-default btn-edit" data-bs-toggle="tooltip" title="<?= esc(trans('affiliate_program')); ?>"><i class="fa fa-link"></i></button>
                                                <?php endif; ?>
                                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-toggle="tooltip" title="<?= esc(trans('delete')); ?>" onclick="deleteItem('Dashboard/deleteProduct','<?= $item->id; ?>','<?= esc(trans("confirm_delete")); ?>');"> -->
                                                    <a href="#" class="btn-item-delete" data-url="Dashboard/deleteProduct" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                    <i class="fa fa-trash-can"></i></a>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($products)): ?>
                    <p class="text-center">
                        <?= esc(trans("no_records_found")); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($products)): ?>
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
<?= view('dashboard/product/_modal_promote'); ?>
