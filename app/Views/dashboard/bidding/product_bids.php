<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= esc($title); ?></h3>
    </div>

    <div class="box-body">
        
        <form method="get" >
            <div class="item-table-filter">
                 <label><?= esc(trans("status")); ?></label>
                <select name="status" class="form-control">
                    <option value=""><?= esc(trans('all')); ?></option>
                    <option value="active" <?= inputGet('status') == 'active' ? 'selected' : ''; ?>><?= esc(trans('active')); ?></option>
                    <option value="accepted" <?= inputGet('status') == 'accepted' ? 'selected' : ''; ?>><?= esc(trans('Accepted')); ?></option>
                    <option value="outbid" <?= inputGet('status') == 'outbid' ? 'selected' : ''; ?>><?= esc(trans('Outbid')); ?></option>
                    <option value="rejected" <?= inputGet('status') == 'rejected' ? 'selected' : ''; ?>><?= esc(trans('Rejected')); ?></option>
                    <option value="closed" <?= inputGet('status') == 'closed' ? 'selected' : ''; ?>><?= esc(trans('Closed')); ?></option>
                    <option value="completed" <?= inputGet('status') == 'completed' ? 'selected' : ''; ?>><?= esc(trans('Completed')); ?></option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?= esc(trans("search")); ?></label>
                <input type="text"
                       name="q"
                       class="form-control"
                       placeholder="<?= esc(trans('search')); ?>"
                       value="<?= esc(inputGet('q')); ?>">
            </div>

            <div class="item-table-filter md-top-10" style="width: 65px;">
                <label>&nbsp;</label>
                    <button type="submit" class="btn bg-purple"><?= esc(trans("filter")); ?></button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th><?= esc(trans('bid')); ?></th>
                    <th><?= esc(trans('Product')); ?></th>
                    <th><?= esc(trans('Bid_amount')); ?></th>
                    <th><?= esc(trans('Bidder')); ?></th>
                    <th><?= esc(trans('status')); ?></th>
                    <th><?= esc(trans('date')); ?></th>
                    <th class="max-width-120"><?= esc(trans('options')); ?></th>
                </tr>
                </thead>

                <tbody>
                <?php if (!empty($bids)): ?>
                    <?php foreach ($bids as $item): ?>
                        <tr>
                            <td>#<?= $item->bid_id; ?></td>
                            <td><a href="<?= generateProductUrlBySlug($item->slug); ?>" target="_blank"> <?= esc($item->title); ?></a></td>
                            <td><?= priceFormatted($item->bid_amount, $defaultCurrency->code); ?></td>
                            <td>
                                <?php $buyer = getUser($item->bidder_id); ?>
                                <?= !empty($buyer)? '<a href="'.generateProfileUrl($buyer->slug).'" target="_blank">'.$buyer->username.'</a>': '-'; ?>
                            </td>
                            <td>
                               <?php if ($item->status == "active"): ?>
                                    <label class="label label-warning"><?= esc(trans($item->status)); ?></label>
                                <?php elseif ($item->status == "accepted"): ?>
                                    <label class="label label-success" style="text-transform: capitalize;"><?= esc(trans($item->status)); ?></label>
                                <?php elseif ($item->status == "outbid"): ?>
                                    <label class="label label-info"><?= esc(trans($item->status)); ?></label>
                                <?php elseif ($item->status == "rejected"): ?>
                                    <label class="label label-danger"><?= esc(trans($item->status)); ?></label>
                                <?php elseif ($item->status == "completed"): ?>
                                    <label class="label label-success"><?= esc(trans($item->status)); ?></label>
                                <?php elseif ($item->status == "closed"): ?>
                                    <label class="label label-default"><?= esc(trans($item->status)); ?></label>
                                <?php else: ?>
                                    <label class="label label-default"><?= esc(trans($item->status)); ?></label>
                                <?php endif; ?>
                            </td>
                            <td><?= formatDate($item->created_at); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-purple dropdown-bs-toggle btn-select-option"type="button"data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                    <ul class="dropdown-menu options-dropdown">
                                        <?php if ($item->status == 'active'): ?>
                                            <li>
                                                <a href="javascript:void(0)"onclick="event.preventDefault(); document.getElementById('acceptBidForm<?= $item->product_id; ?>').submit();"><i class="fa fa-check option-icon"></i><?= esc(trans('accept_bid')); ?></a>
                                                <form id="acceptBidForm<?= $item->product_id; ?>"method="post"action="<?= base_url('dashboard/accept-bid'); ?>"style="display:none;"><?= csrf_field(); ?>
                                                    <input type="hidden" name="product_id" value="<?= $item->product_id; ?>">
                                                </form>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <!-- <a href="javascript:void(0)"onclick="deleteItem('dashboard/deleteBid','<?= $item->bid_id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                <a href="#" class="btn-item-delete" data-url="dashboard/deleteBid" data-id="<?= $item->bid_id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                <i class="fa fa-trash option-icon"></i><?= esc(trans('delete')); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <?= esc(trans("no_records_found")); ?>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
