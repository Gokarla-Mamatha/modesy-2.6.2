<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc(trans("countries")); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('add-country'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans('add_country')); ?>
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
                            <form action="<?= adminUrl('countries'); ?>" method="get">
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
                            <th><?= esc(trans('status')); ?></th>
                            <th class="max-width-120"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($countries)):
                            foreach ($countries as $item): ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->name); ?></td>
                                    <td>
                                        <?php if ($item->status == 1): ?>
                                            <label class="label label-success"><?= esc(trans("active")); ?></label>
                                        <?php else: ?>
                                            <label class="label label-danger"><?= esc(trans("inactive")); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td width="20%">
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li><a href="<?= adminUrl('edit-country/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                <li>
                                                    <!-- <a href="#" onclick="deleteItem('Admin/deleteCountryPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                    <a href="#" class="btn-item-delete" data-url="Admin/deleteCountryPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                    <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($countries)): ?>
                        <p class="text-center">
                            <?= esc(trans("no_records_found")); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-left">
                                <button type="button" class="btn btn-danger btn-activate-inactivate-countries" data-action="inactivate"><?= esc(trans("inactivate_all")); ?></button>
                                <button type="button" class="btn btn-success btn-activate-inactivate-countries" data-action="activate"><?= esc(trans("activate_all")); ?></button>
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
</div>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans('settings')); ?></h3>
            </div>
            <form action="<?= base_url('Admin/locationSettingsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= esc(trans("single_country_mode")); ?></label>
                        <?= formRadio('single_country_mode', 1, 0, trans("enable"), trans("disable"), $generalSettings->single_country_mode); ?>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("country")); ?></label>
                        <select name="single_country_id" class="form-control select2">
                            <?php if (!empty($activeCountries)):
                                foreach ($activeCountries as $country): ?>
                                    <option value="<?= $country->id; ?>" <?= $generalSettings->single_country_id == $country->id ? 'selected' : ''; ?>><?= esc($country->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" name="submit" value="general" class="btn btn-primary"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>