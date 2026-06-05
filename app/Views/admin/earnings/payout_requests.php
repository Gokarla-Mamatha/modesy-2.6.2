<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc(trans('payout_requests')); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('add-payout'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans('add_payout')); ?>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="row table-filter-container">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-default filter-toggle collapsed m-b-10" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false">
                            <i class="fa fa-filter"></i>&nbsp;&nbsp;<?= esc(trans("filter")); ?>
                        </button>
                        <div class="collapse navbar-collapse" id="collapseFilter">
                            <form action="<?= adminUrl('payout-requests'); ?>" method="get">
                                <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                    <label><?= esc(trans("show")); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="15" <?= inputGet('show') == '15' ? 'selected' : ''; ?>>15</option>
                                        <option value="30" <?= inputGet('show') == '30' ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?= inputGet('show') == '60' ? 'selected' : ''; ?>>60</option>
                                        <option value="100" <?= inputGet('show') == '100' ? 'selected' : ''; ?>>100</option>
                                    </select>
                                </div>
                                <div class="item-table-filter" style="min-width: 150px;">
                                    <label><?= esc(trans("status")); ?></label>
                                    <select name="status" class="form-control">
                                        <option value="all" <?= inputGet('status') == 'all' ? 'selected' : ''; ?>><?= esc(trans("all")); ?></option>
                                        <option value="pending" <?= inputGet('status') == 'pending' ? 'selected' : ''; ?>><?= esc(trans("pending")); ?></option>
                                        <option value="completed" <?= inputGet('status') == 'completed' ? 'selected' : ''; ?>><?= esc(trans("completed")); ?></option>
                                    </select>
                                </div>
                                <div class="item-table-filter">
                                    <label><?= esc(trans("search")); ?></label>
                                    <input name="q" class="form-control" placeholder="<?= esc(trans("user_id")); ?>" type="search" value="<?= esc(inputget('q')); ?>">
                                </div>
                                <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                    <label style="display: block">&nbsp;</label>
                                    <button type="submit" class="btn bg-purple"><?= esc(trans("filter")); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th><?= esc(trans('id')); ?></th>
                            <th><?= esc(trans('user')); ?></th>
                            <th><?= esc(trans('withdraw_method')); ?></th>
                            <th><?= esc(trans('withdraw_amount')); ?></th>
                            <th><?= esc(trans('status')); ?></th>
                            <th><?= esc(trans('date')); ?></th>
                            <th class="max-width-120"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($payoutRequests)):
                            foreach ($payoutRequests as $payout):
                                $user = getUser($payout->user_id); ?>
                                <tr>
                                    <td><?= $payout->id; ?></td>
                                    <td>
                                        <?php if (!empty($user)): ?>
                                            <div class="tbl-table">
                                                <div class="left">
                                                    <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="table-link">
                                                        <img src="<?= getUserAvatar($user->avatar, $user->storage_avatar); ?>" alt="user" class="img-responsive">
                                                    </a>
                                                </div>
                                                <div class="right">
                                                    <div class="m-b-5">
                                                        <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="table-link"><?= trans("user_id") . ': ' . esc($user->id); ?></a>
                                                    </div>
                                                    <div class="m-b-5">
                                                        <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="table-link"><?= esc($user->first_name) . ' ' . esc($user->last_name); ?>&nbsp;<?= !empty($user->username) ? '(' . $user->username . ')' : ''; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= esc(trans($payout->payout_method)); ?>
                                        <p class="m-0">
                                            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#accountDetailsModel_<?= $payout->id; ?>"><?= esc(trans("see_details")); ?></button>
                                        </p>
                                        <?= view('admin/earnings/_user_payout_info', ['payout' => $payout, 'user' => $user]); ?>
                                    </td>
                                    <td><?= priceFormatted($payout->amount, $payout->currency); ?></td>
                                    <td>
                                        <?php if ($payout->status == 1): ?>
                                            <label class="label label-success"><?= esc(trans('completed')); ?></label>
                                        <?php else: ?>
                                            <label class="label label-warning"><?= esc(trans('pending')); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= formatDate($payout->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <?php if ($payout->status != 1): ?>
                                                    <li>
                                                        <form action="<?= base_url('Earnings/completePayoutRequestPost'); ?>" method="post">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="payout_id" value="<?= $payout->id; ?>">
                                                            <input type="hidden" name="user_id" value="<?= $payout->user_id; ?>">
                                                            <input type="hidden" name="amount" value="<?= $payout->amount; ?>">
                                                            <button type="submit" name="option" value="completed" class="btn-list-button">
                                                                <i class="fa fa-check option-icon"></i><?= esc(trans('completed')); ?>
                                                            </button>
                                                        </form>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <!-- <a href="javascript:void(0)" onclick="deleteItem('Earnings/deletePayoutPost','<?= $payout->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                        <a href="#" class="btn-item-delete" data-url="Earnings/deletePayoutPost" data-id="<?= $payout->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                        <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($payoutRequests)): ?>
                        <p class="text-center">
                            <?= esc(trans("no_records_found")); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= $pager->links; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style <?= csp_style_nonce() ?>>
    .modal-body .row {
        margin-bottom: 8px;
    }
</style>
