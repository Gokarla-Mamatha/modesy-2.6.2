<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= esc($title); ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?= view('admin/product/_filter_products'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= esc(trans('id')); ?></th>
                            <th><?= esc(trans('product')); ?></th>
                            <th><?= esc(trans('product_type')); ?></th>
                            <th><?= esc(trans('category')); ?></th>
                            <th><?= esc(trans('user')); ?></th>
                            <th><?= esc(trans('price')); ?></th>
                            <th><?= esc(trans('stock')); ?></th>
                            <?php if ($listType == 'featured_products'): ?>
                                <th><?= esc(trans('purchased_plan')); ?></th>
                                <th><?= esc(trans('remaining_days')); ?></th>
                            <?php endif; ?>
                            <?php if ($listType == 'edited_products' || $listType == 'pending_products'): ?>
                                <th><?= esc(trans('status')); ?></th>
                            <?php endif; ?>
                            <th><?= esc(trans('page_views')); ?></th>
                            <th><?= esc(trans('updated')); ?></th>
                            <th><?= esc(trans('date')); ?></th>
                            <th class="max-width-120"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($products)):
                            foreach ($products as $item): ?>
                                <tr>
                                    <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
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
                                                <p class="m-b-5">
                                                    <?php if ($item->is_promoted == 1): ?>
                                                        <label class="label label-success"><?= esc(trans("featured")); ?></label>
                                                    <?php endif;
                                                    if ($item->is_special_offer == 1): ?>
                                                        <label class="label label-info"><?= esc(trans("special_offer")); ?></label>
                                                    <?php endif;
                                                    if ($item->is_commission_set == 1): ?>
                                                        &nbsp;<label class="label bg-warning"><i class="fa fa-hand-holding-dollar"></i>&nbsp;<?= esc(formatDecimalClean($item->commission_rate)) ?>%</label>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= esc(trans($item->product_type)); ?></td>
                                    <td><?= esc($item->cat_name); ?></td>
                                    <td>
                                        <a href="<?= generateProfileUrl($item->user_slug); ?>" target="_blank" class="table-username">
                                            <?= esc($item->user_username); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if (!empty($item->price_discounted)): ?>
                                            <span><?= priceFormatted($item->price_discounted, $item->currency, true); ?></span>
                                        <?php else: ?>
                                            <span>-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="white-space-nowrap">
                                        <?php if ($item->product_type == "digital"): ?>
                                            <span class="text-success"><?= esc(trans("in_stock")); ?></span>
                                        <?php else:
                                            if ($item->stock < 1): ?>
                                                <span class="text-danger"><?= $item->listing_type == 'ordinary_listing' ? trans("sold") : trans("out_of_stock"); ?></span>
                                            <?php else: ?>
                                                <span class="text-success"><?= esc(trans("in_stock")); ?>&nbsp;<?= $item->listing_type != 'ordinary_listing' ? '(' . $item->stock . ')' : ''; ?></span>
                                            <?php endif;
                                        endif; ?>
                                    </td>

                                    <?php if ($listType == 'featured_products'): ?>
                                        <td>
                                            <div class="label label-default" style="font-size: 12px; font-weight: 600;">
                                                <span>
                                                    <?php if ($item->is_promoted == 1):
                                                        echo esc($item->promote_plan);
                                                    endif; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td style="min-width: 120px;">
                                            <?php if ($item->is_promoted == 1): ?>
                                                <strong><?= dateDifference($item->promote_end_date, date('Y-m-d H:i:s')); ?></strong>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>

                                    <?php if ($listType == 'edited_products' || $listType == 'pending_products'): ?>
                                        <td>
                                            <?php if ($item->is_rejected == 1): ?>
                                                <p>
                                                    <label class="label label-danger"><?= esc(trans("rejected")); ?></label>
                                                </p>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalReason<?= $item->id; ?>"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;<?= esc(trans("show_reason")); ?></button>
                                                <div id="modalReason<?= $item->id; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"><?= esc(trans("reason")); ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="m-t-10"><?= esc($item->reject_reason); ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?= esc(trans("close")); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else:
                                                if ($item->status == 1):?>
                                                    <label class="label label-success"><?= esc(trans("active")); ?></label>
                                                <?php else: ?>
                                                    <label class="label label-default"><?= esc(trans("pending")); ?></label>
                                                <?php endif;
                                            endif; ?>
                                        </td>
                                    <?php endif; ?>

                                    <td><?= numberFormatShort($item->pageviews); ?></td>
                                    <td><?= !empty($item->updated_at) ? timeAgo($item->updated_at) : ''; ?></td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans("select_option")); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="<?= adminUrl('product-details/' . $item->id); ?>"><i class="fa fa-info option-icon"></i><?= esc(trans("view_details")); ?></a>
                                                </li>

                                                <?php if ($item->is_deleted != 1 && $item->is_draft != 1 && $item->is_sold != 1): ?>

                                                    <?php if ($item->is_promoted == 1): ?>
                                                        <li>
                                                            <a href="javascript:void(0)" class="js-remove-from-featured" data-product-id="<?= esc($item->id, 'attr'); ?>"><i class="fa fa-minus option-icon"></i><?= esc(trans("remove_from_featured")); ?></a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <a href="javascript:void(0)" class="js-set-featured-product" data-product-id="<?= esc($item->id, 'attr'); ?>" data-toggle="modal" data-target="#modalAddFeatured"><i class="fa fa-plus option-icon"></i><?= esc(trans('add_to_featured')); ?></a>
                                                        </li>
                                                    <?php endif;
                                                    if ($item->is_special_offer == 1): ?>
                                                        <li>
                                                            <a href="javascript:void(0)" class="js-add-remove-special-offer" data-product-id="<?= esc($item->id, 'attr'); ?>"><i class="fa fa-minus option-icon"></i><?= esc(trans("remove_from_special_offers")); ?></a>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <a href="javascript:void(0)" class="js-add-remove-special-offer" data-product-id="<?= esc($item->id, 'attr'); ?>"><i class="fa fa-plus option-icon"></i><?= esc(trans('add_to_special_offers')); ?></a>
                                                        </li>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                                <?php if ($listType == 'edited_products' || $listType == 'pending_products'): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" class="js-approve-product" data-product-id="<?= esc($item->id, 'attr'); ?>"><i class="fa fa-check option-icon"></i><?= esc(trans("approve")); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" class="js-set-reject-product" data-toggle="modal" data-target="#modalReject" data-product-id="<?= esc($item->id, 'attr'); ?>"><i class="fa fa-ban option-icon"></i><?= esc(trans("reject")); ?></a>
                                                    </li>
                                                <?php endif; ?>

                                                <li>
                                                    <a href="<?= generateDashUrl('edit_product') . '/' . $item->id; ?>" target="_blank"><i class="fa fa-edit option-icon"></i><?= esc(trans("edit")); ?></a>
                                                </li>
                                                <?php if ($item->is_deleted != 1): ?>
                                                 <li>
                                                    <a href="#"
                                                    class="btn-item-delete"
                                                    data-url="Product/deleteProduct"
                                                    data-id="<?= $item->id; ?>"
                                                    data-msg="<?= esc(trans('confirm_product', true), 'attr'); ?>">
                                                        <i class="fa fa-times option-icon"></i><?= esc(trans('delete')); ?>
                                                    </a>
                                                  </li>
                                                <?php endif;
                                                if ($item->is_deleted == 1): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" class="js-restore-product" data-product-id="<?= esc($item->id, 'attr'); ?>"><i class="fa fa-reply option-icon"></i><?= esc(trans('restore')); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <!-- <a href="javascript:void(0)" onclick="deleteItem('Product/deleteProductPermanently','<?= $item->id; ?>','<?= esc(trans("confirm_product_permanent", true)); ?>');"> -->
                                                        <a href="#" class="btn-item-delete" data-url="Product/deleteProductPermanently" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_product_permanent', true)); ?>">
                                                        <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete_permanently')); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($products)): ?>
                        <p class="text-center">
                            <?= esc(trans("no_records_found")); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= $pager->links; ?>
                            </div>
                            <?php if (countItems($products) > 0):
                                if ($listType == 'deleted_products'):?>
                                    <div class="pull-left">
                                        <button class="btn btn-sm btn-danger btn-table-delete js-delete-selected-products-permanently" data-msg="<?= esc(trans("confirm_products", true), 'attr'); ?>"><?= esc(trans('delete')); ?></button>
                                    </div>
                                <?php else: ?>
                                    <div class="pull-left">
                                        <button class="btn btn-sm btn-danger btn-table-delete js-delete-selected-products" data-msg="<?= esc(trans("confirm_products", true), 'attr'); ?>"><?= esc(trans('delete')); ?></button>
                                    </div>
                                <?php endif;
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script <?= csp_script_nonce() ?>>
    $(document).on('click', '.js-remove-from-featured', function () {
        removeFromFeatured($(this).data('product-id'));
    });
    $(document).on('click', '.js-set-featured-product', function () {
        $('#day_count_product_id').val($(this).data('product-id'));
    });
    $(document).on('click', '.js-add-remove-special-offer', function () {
        addRemoveSpecialOffer($(this).data('product-id'));
    });
    $(document).on('click', '.js-approve-product', function () {
        approveProduct($(this).data('product-id'));
    });
    $(document).on('click', '.js-set-reject-product', function () {
        $('#reject_product_id').val($(this).data('product-id'));
    });
    $(document).on('click', '.js-restore-product', function () {
        restoreProduct($(this).data('product-id'));
    });
    $(document).on('click', '.js-delete-selected-products-permanently', function () {
        deleteSelectedProductsPermanently($(this).data('msg'));
    });
    $(document).on('click', '.js-delete-selected-products', function () {
        deleteSelectedProducts($(this).data('msg'));
    });
</script>
</script>

<div id="modalAddFeatured" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('Product/addRemoveFeaturedProduct'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= esc(trans('add_to_featured')); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><?= esc(trans('number_of_days')); ?></label>
                        <input type="hidden" class="form-control" name="product_id" id="day_count_product_id" value="">
                        <input type="hidden" class="form-control" name="is_ajax" value="0">
                        <input type="number" class="form-control" name="day_count" placeholder="<?= esc(trans('number_of_days')); ?>" value="1" min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?= esc(trans("submit")); ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?= esc(trans("close")); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalReject" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('Product/rejectProduct'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="reject_product_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= esc(trans("reject")); ?></h4>
                </div>
                <div class="modal-body">
                    <textarea name="reject_reason" class="form-control form-textarea" placeholder="<?= esc(trans("reason")); ?>.." style="min-height: 150px;" data-type="text"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?= esc(trans("submit")); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<style <?= csp_style_nonce() ?>>
.swal2-container {
    position: fixed !important;
    z-index: 999999 !important;
}   
</style> 