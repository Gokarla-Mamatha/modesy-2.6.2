<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc(trans('reviews')); ?></h3>
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
                            <form action="<?= adminUrl('reviews'); ?>" method="get">
                                <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                    <label><?= esc(trans("show")); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="15" <?= inputGet('show', true) == '15' ? 'selected' : ''; ?>>15</option>
                                        <option value="30" <?= inputGet('show', true) == '30' ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?= inputGet('show', true) == '60' ? 'selected' : ''; ?>>60</option>
                                        <option value="100" <?= inputGet('show', true) == '100' ? 'selected' : ''; ?>>100</option>
                                    </select>
                                </div>
                                <div class="item-table-filter">
                                    <label><?= esc(trans("search")); ?></label>
                                    <input name="q" class="form-control" placeholder="<?= esc(trans("search")) ?>" type="search" value="<?= esc(inputGet('q', true)); ?>">
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
                            <th width="20" class="table-no-sort" style="text-align: center !important;"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= esc(trans('id')); ?></th>
                            <th><?= esc(trans('user')); ?></th>
                            <th><?= esc(trans('review')); ?></th>
                            <th style="min-width: 20%"><?= esc(trans('product')); ?></th>
                            <th><?= esc(trans('ip_address')); ?></th>
                            <th style="min-width: 10%"><?= esc(trans('date')); ?></th>
                            <th class="max-width-120"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($reviews)):
                            foreach ($reviews as $item):
                                $product = getProduct($item->product_id); ?>
                                <tr>
                                    <td style="text-align: center !important;"><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->user_username); ?></td>
                                    <td class="break-word" style="min-width: 100px;">
                                        <div class="pull-left" style="width: 100%;">
                                            <?= view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                                        </div>
                                        <p class="pull-left"><?= esc($item->review); ?></p>
                                    </td>
                                    <td style="width: 30%;">
                                        <?php if (!empty($product)): ?>
                                            <a href="<?= generateProductUrl($product); ?>" target="_blank"><?= esc($product->title); ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item->ip_address; ?></td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <!-- <a href="javascript:void(0)" onclick="deleteItem('Product/deleteReviewPost','<?= $item->id; ?>','<?= esc(trans("confirm_review", true)); ?>');"> -->
                                                        <a href="#" class="btn-item-delete" data-url="Product/deleteReviewPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_review', true)); ?>">
                                                    <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="pull-left">
                            <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedReviews('<?= esc(trans("confirm_reviews", true)); ?>');"><?= esc(trans('delete')); ?></button>
                        </div>
                        <div class="pull-right">
                            <?= $pager->links; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>