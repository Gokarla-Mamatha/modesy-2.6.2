<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= esc($title); ?></h3>
    </div>

    <div class="box-body">
        
        <form method="get" >
            <div class="item-table-filter">
                 <label><?= trans("status"); ?></label>
                <select name="status" class="form-control">
                    <option value=""><?= trans('all'); ?></option>
                    <option value="active" <?= inputGet('status') == 'active' ? 'selected' : ''; ?>><?= trans('active'); ?></option>
                    <option value="accepted" <?= inputGet('status') == 'accepted' ? 'selected' : ''; ?>><?= trans('Accepted'); ?></option>
                    <option value="outbid" <?= inputGet('status') == 'outbid' ? 'selected' : ''; ?>><?= trans('Outbid'); ?></option>
                    <option value="rejected" <?= inputGet('status') == 'rejected' ? 'selected' : ''; ?>><?= trans('Rejected'); ?></option>
                    <option value="closed" <?= inputGet('status') == 'closed' ? 'selected' : ''; ?>><?= trans('Closed'); ?></option>
                    <option value="completed" <?= inputGet('status') == 'completed' ? 'selected' : ''; ?>><?= trans('Completed'); ?></option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?= trans("search"); ?></label>
                <input type="text"
                       name="q"
                       class="form-control"
                       placeholder="<?= trans('search'); ?>"
                       value="<?= esc(inputGet('q')); ?>">
            </div>

            <div class="item-table-filter md-top-10" style="width: 65px;">
                <label>&nbsp;</label>
                    <button type="submit" class="btn bg-purple"><?= trans("filter"); ?></button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th><?= trans('bid'); ?></th>
                    <th><?= trans('Product'); ?></th>
                    <th><?= trans('Bid_amount'); ?></th>
                    <th><?= trans('Bidder'); ?></th>
                    <th><?= trans('status'); ?></th>
                    <th><?= trans('date'); ?></th>
                    <th class="max-width-120"><?= trans('options'); ?></th>
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
                                    <label class="label label-warning"><?= trans($item->status); ?></label>
                                <?php elseif ($item->status == "accepted"): ?>
                                    <label class="label label-success" style="text-transform: capitalize;"><?= trans($item->status); ?></label>
                                <?php elseif ($item->status == "outbid"): ?>
                                    <label class="label label-info"><?= trans($item->status); ?></label>
                                <?php elseif ($item->status == "rejected"): ?>
                                    <label class="label label-danger"><?= trans($item->status); ?></label>
                                <?php elseif ($item->status == "completed"): ?>
                                    <label class="label label-success"><?= trans($item->status); ?></label>
                                <?php elseif ($item->status == "closed"): ?>
                                    <label class="label label-default"><?= trans($item->status); ?></label>
                                <?php else: ?>
                                    <label class="label label-default"><?= trans($item->status); ?></label>
                                <?php endif; ?>
                            </td>
                            <td><?= formatDate($item->created_at); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-purple dropdown-toggle btn-select-option"type="button"data-toggle="dropdown"><?= trans('select_option'); ?><span class="caret"></span></button>
                                    <ul class="dropdown-menu options-dropdown">
                                        <?php if ($item->status == 'active'): ?>
                                            <li>
                                                <a href="javascript:void(0)"onclick="event.preventDefault(); document.getElementById('acceptBidForm<?= $item->product_id; ?>').submit();"><i class="fa fa-check option-icon"></i><?= trans('accept_bid'); ?></a>
                                                <form id="acceptBidForm<?= $item->product_id; ?>"method="post"action="<?= base_url('dashboard/accept-bid'); ?>"style="display:none;"><?= csrf_field(); ?>
                                                    <input type="hidden" name="product_id" value="<?= $item->product_id; ?>">
                                                </form>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <!-- <a href="javascript:void(0)"onclick="deleteItem('dashboard/deleteBid','<?= $item->bid_id; ?>','<?= trans("confirm_delete", true); ?>');"> -->
                                                <a href="#" class="btn-item-delete" data-url="dashboard/deleteBid" data-id="<?= $item->bid_id; ?>" data-msg="<?= trans('confirm_delete', true); ?>">
                                                <i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <?= trans("no_records_found"); ?>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
