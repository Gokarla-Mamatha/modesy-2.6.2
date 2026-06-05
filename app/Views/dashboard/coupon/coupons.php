<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc($title); ?></h3>
        </div>
        <div class="right">
            <a href="<?= generateDashUrl('add_coupon'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans("add_coupon")); ?>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th><?= esc(trans("coupon_code")); ?></th>
                            <th><?= esc(trans("discount_rate")); ?></th>
                            <th><?= esc(trans("number_of_coupons")); ?></th>
                            <th><?= esc(trans("expiry_date")); ?></th>
                            <th><?= esc(trans("status")); ?></th>
                            <th><?= esc(trans("date")); ?></th>
                            <th><?= esc(trans("products")); ?></th>
                            <th class="max-width-120"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($coupons)):
                            foreach ($coupons as $item): ?>
                                <tr>
                                    <td><?= esc($item->coupon_code); ?></td>
                                    <td><?= esc($item->discount_rate); ?>%</td>
                                    <td><?= esc($item->coupon_count); ?>&nbsp;<small class="text-danger">(<?= esc(trans("used")); ?>:&nbsp;<b><?= getUsedCouponsCount($item->coupon_code); ?></b>)</small></td>
                                    <td><?= formatDate($item->expiry_date); ?>&nbsp;<span class="text-danger"></td>
                                    <td>
                                        <?php if (date('Y-m-d H:i:s') > $item->expiry_date): ?>
                                            <label class="label label-danger"><?= esc(trans("expired")); ?></label>
                                        <?php else: ?>
                                            <label class="label label-success"><?= esc(trans("active")); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <a href="<?= generateDashUrl('coupon_products'); ?>/<?= $item->id; ?>" class="btn btn-sm btn-primary"><?= esc(trans("select_products")); ?></a>
                                    </td>
                                    <td style="width: 120px;">
                                        <div class="btn-group btn-group-option">
                                            <a href="<?= generateDashUrl('edit_coupon') . '/' . $item->id; ?>" class="btn btn-sm btn-default btn-edit" data-toggle="tooltip" title="<?= esc(trans('edit')); ?>"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" data-toggle="tooltip" title="<?= esc(trans('delete')); ?>" onclick='deleteItem("Dashboard/deleteCouponPost","<?= $item->id; ?>","<?= esc(trans("confirm_delete", true)); ?>");'><i class="fa fa-trash-can"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($coupons)): ?>
                    <p class="text-center">
                        <?= esc(trans("no_records_found")); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if (!empty($coupons)): ?>
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
