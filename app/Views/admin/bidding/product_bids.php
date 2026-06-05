<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <!-- FILTER -->
                <div class="row table-filter-container">
                    <div class="col-sm-12">
                        <button type="button"
                                class="btn btn-default filter-toggle collapsed m-b-10"
                                data-toggle="collapse"
                                data-target="#collapseFilter">
                            <i class="fa fa-filter"></i>&nbsp;&nbsp;<?= esc(trans("filter")); ?>
                        </button>

                        <div class="collapse navbar-collapse" id="collapseFilter">
                            <form action="<?= adminUrl('product-bids') ?>" method="get">

                                <div class="item-table-filter" style="width: 80px;">
                                    <label><?= esc(trans("show")); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="60">60</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>

                                <div class="item-table-filter">
                                    <label><?= esc(trans("status")); ?></label>
                                    <select name="status" class="form-control custom-select">
                                        <option value="" selected><?= esc(trans("all")); ?></option>
                                        <option value="active" <?= inputGet('status') == 'active' ? 'selected' : ''; ?>><?= esc(trans("active")); ?></option>
                                        <option value="accepted" <?= inputGet('status') == 'accepted' ? 'selected' : ''; ?>><?= esc(trans("accepted")); ?></option>
                                        <option value="outbid" <?= inputGet('status') == 'outbid' ? 'selected' : ''; ?>><?= esc(trans("outbid")); ?></option>
                                        <option value="rejected" <?= inputGet('status') == 'rejected' ? 'selected' : ''; ?>><?= esc(trans('Rejected')); ?></option>
                                        <option value="closed" <?= inputGet('status') == 'closed' ? 'selected' : ''; ?>><?= esc(trans("closed")); ?></option>
                                        <option value="completed" <?= inputGet('status') == 'completed' ? 'selected' : ''; ?>><?= esc(trans('Completed')); ?></option>
                                    </select>
                                </div>

                                <div class="item-table-filter">
                                    <label><?= esc(trans("search")); ?></label>
                                    <input name="q"
                                           class="form-control"
                                           placeholder="<?= esc(trans("search")); ?>"
                                           type="search">
                                </div>

                                <div class="item-table-filter md-top-10" style="width: 65px;">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn bg-purple">
                                        <?= esc(trans("filter")); ?>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th><?= esc(trans('bid_id')); ?></th>
                            <th><?= esc(trans('product')); ?></th>
                            <th><?= esc(trans('seller')); ?></th>
                            <th><?= esc(trans('bidder')); ?></th>
                            <th><?= esc(trans('bid_amount')); ?></th>
                            <th><?= esc(trans('status')); ?></th>
                            <th><?= esc(trans('date')); ?></th>
                            <th class="max-width-120"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($products)):
                            foreach ($products as $item): ?>
                                <tr>

                                    <td>#<?= $item->id; ?></td>

                                    <td class="td-product">
                                        <div class="img-table">
                                            <a href="<?= generateProductUrl($item); ?>" target="_blank"><img src="<?= getProductMainImage($item->product_id, 'image_small'); ?>"class="img-responsive"/></a>
                                        </div>
                                        <a href="<?= generateProductUrl($item); ?>" target="_blank" class="table-product-title"> <?= esc($item->title); ?></a>
                                    </td>
                                    <td>
                                        <?php $seller = getUser($item->seller_id); ?><?= !empty($seller)? '<a href="'.generateProfileUrl($seller->slug).'" target="_blank">'.$seller->username.'</a>': '-'; ?>
                                    </td>
                                    <td>
                                        <?php $buyer = getUser($item->bidder_id); ?><?= !empty($buyer)? '<a href="'.generateProfileUrl($buyer->slug).'" target="_blank">'.$buyer->username.'</a>': '-'; ?>
                                    </td>
                                    <td><strong><?= priceFormatted($item->bid_amount, $defaultCurrency->code); ?></strong></td>
                                    <td><?= esc($item->status); ?></td>
                                    <td><?= formatDate($item->created_at); ?></td>

                                    <td>
                                     <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <!-- <a href="javascript:void(0)" onclick="deleteItem('Product/deleteBidPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                        <a href="#" class="btn-item-delete" data-url="Product/deleteBidPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                    <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>

                    <?php if (empty($products)): ?>
                        <p class="text-center"><?= esc(trans("no_records_found")); ?></p>
                    <?php endif; ?>

                    <div class="pull-right">
                        <?= $pager->links; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
