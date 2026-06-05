<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= $title; ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('add-state'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans('add_state')); ?>
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
                            <form action="<?= adminUrl('states'); ?>" method="get">
                                <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                    <label><?= esc(trans("show")); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="15" <?= inputGet('show') == '15' ? 'selected' : ''; ?>>15</option>
                                        <option value="30" <?= inputGet('show') == '30' ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?= inputGet('show') == '60' ? 'selected' : ''; ?>>60</option>
                                        <option value="100" <?= inputGet('show') == '100' ? 'selected' : ''; ?>>100</option>
                                    </select>
                                </div>
                                <div class="item-table-filter">
                                    <label><?= esc(trans('country')); ?></label>
                                    <select name="country" class="form-control">
                                        <option value=""><?= esc(trans("all")); ?></option>
                                        <?php if (!empty($countries)):
                                            foreach ($countries as $item): ?>
                                                <option value="<?= $item->id; ?>" <?= inputGet('country') == $item->id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                                            <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>
                                <div class="item-table-filter">
                                    <label><?= esc(trans("search")); ?></label>
                                    <input name="q" class="form-control" placeholder="<?= esc(trans("search")); ?>" type="search" value="<?= esc(inputGet('q')); ?>">
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
                            <th width="20"><?= esc(trans('id')); ?></th>
                            <th><?= esc(trans('name')); ?></th>
                            <th><?= esc(trans('country')); ?></th>
                            <th><?= esc(trans('status')); ?></th>
                            <th><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($states)):
                            foreach ($states as $item): ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->name); ?></td>
                                    <td><?= esc($item->country_name); ?></td>
                                    <td>
                                        <?php if ($item->country_status == 1): ?>
                                            <label class="label label-success m-l-15"><?= esc(trans("active")); ?></label>
                                        <?php else: ?>
                                            <label class="label label-danger m-l-15"><?= esc(trans("inactive")); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td width="20%">
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li><a href="<?= adminUrl('edit-state/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                <li>
                                                    <!-- <a href="javascript:void(0)" onclick="deleteItem('Admin/deleteStatePost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                        <a href="#" class="btn-item-delete" data-url="Admin/deleteStatePost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                            <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?>
                                                        </a>
                                                    </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($states)): ?>
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