<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= esc(trans('knowledge_base')); ?></h3>
    </div>
</div>
<div class="form-group">
    <label><?= esc(trans("language")); ?></label>
    <select name="lang_id" class="form-control" onchange="window.location.href = '<?= adminUrl('knowledge-base'); ?>?lang='+this.value;" style="max-width: 600px;">
        <?php foreach ($activeLanguages as $language): ?>
            <option value="<?= $language->id; ?>" <?= $language->id == $langId ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans("contents")); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('knowledge-base/add-content?lang=' . $langId); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans('add_content')); ?>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped data_table" role="grid">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= esc(trans('id')); ?></th>
                                    <th><?= esc(trans('title')); ?></th>
                                    <th><?= esc(trans('language')); ?></th>
                                    <th><?= esc(trans('category')); ?></th>
                                    <th><?= esc(trans('date')); ?></th>
                                    <th class="th-options"><?= esc(trans('options')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($contents)):
                                    foreach ($contents as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td><?= esc($item->title); ?></td>
                                            <td>
                                                <?php $language = getLanguage($item->lang_id);
                                                if (!empty($language)) {
                                                    echo esc($language->name);
                                                } ?>
                                            </td>
                                            <td><?= esc($item->category_name); ?></td>
                                            <td><?= formatDate($item->created_at); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('knowledge-base/edit-content/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                        <li>
                                                            <!-- <a href="javascript:void(0)" onclick="deleteItem('SupportAdmin/deleteContentPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                                <a href="#" class="btn-item-delete" data-url="SupportAdmin/deleteContentPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans("categories")); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('knowledge-base/add-category?lang=' . $langId); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans('add_category')); ?>
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped data_table" role="grid">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= esc(trans('id')); ?></th>
                                    <th><?= esc(trans('title')); ?></th>
                                    <th><?= esc(trans('language')); ?></th>
                                    <th class="th-options"><?= esc(trans('options')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($categories)):
                                    foreach ($categories as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td>
                                                <?php $language = getLanguage($item->lang_id);
                                                if (!empty($language)) {
                                                    echo esc($language->name);
                                                } ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('knowledge-base/edit-category/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                        <li>
                                                            <!-- <a href="javascript:void(0)" onclick="deleteItem('SupportAdmin/deleteCategoryPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                                <a href="#" class="btn-item-delete" data-url="SupportAdmin/deleteCategoryPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>