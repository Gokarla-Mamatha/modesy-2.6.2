<div class="row">
    <div class="box-header with-border" style="padding: 15px;">
        <div class="left">
            <h3 class="box-title font-600"><?= esc(trans('custom_field_options')); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('custom-fields'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('custom_fields')); ?>
            </a>
        </div>
    </div>
</div>

<div class="callout" style="margin-top: 10px;background-color: #fff; border-color:#00c0ef;max-width: 600px;">
    <h4><?= esc(trans("custom_field")); ?></h4>
    <p><?= esc(trans('field_name')); ?>:&nbsp;<strong><?= esc($field->name); ?></strong></p>
    <p>
        <?= esc(trans('type')); ?>:&nbsp;
        <strong><?= esc(trans($field->field_type)); ?></strong>
    </p>
</div>
<div class="row">
    <?php if ($field->field_type == 'single_select' || $field->field_type == 'multi_select'): ?>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= esc(trans("options")); ?></h3>
                </div>
                <div class="box-body">
                    <?php if (!empty($options)): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="custom-field-options" style="max-height: 600px; overflow: auto">
                                        <?php $count = 1;
                                        foreach ($options as $option): ?>
                                            <div class="field-option-item">
                                                        <div class="option-title">
                                                            <strong><?= trans("option") . " " . $count; ?></strong>
                                                            <!-- <button type="button" class="btn btn-xs btn-danger pull-right" onclick='deleteCustomFieldOption("<?= esc(trans("confirm_delete", true)); ?>","<?= $option->id; ?>");'><i class="fa fa-trash-can"></i></button> -->
                                                               <button type="button"  class="btn btn-xs btn-danger pull-right btn-item-delete" data-url="admin/delete-custom-field-option"  data-id="<?= $option->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>"> <i class="fa fa-trash-can"></i> </button>
                                                        </div>
                                                <?php foreach ($activeLanguages as $language):
                                                    $optionName = !empty($optionsNameArray[$option->id][$language->id]) ? $optionsNameArray[$option->id][$language->id] : ''; ?>
                                                    <p><input type='text' class="form-control input-custom-field-option" name="option" value="<?= esc($optionName); ?>"
                                                              data-option-id="<?= $option->id; ?>" data-lang-id="<?= $language->id; ?>" placeholder="<?= esc(trans("option")); ?> (<?= $language->name; ?>)" style="width: 100%;padding: 0 5px; bottom: 0 !important;box-shadow: none !important;height: 26px;" required></p>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php $count++;
                                        endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('Category/addCustomFieldOptionPost'); ?>" method="post" onkeypress="return event.keyCode != 13;">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="field_id" value="<?= $field->id; ?>">
                        <div class="form-group m-b-10">
                            <label><?= esc(trans("add_option")); ?></label>
                            <?php foreach ($activeLanguages as $language): ?>
                                <input type="text" class="form-control option-input m-b-5" name="option_name_<?= $language->id; ?>" placeholder="<?= esc(trans("option")); ?> (<?= $language->name; ?>)" data-type="title" required>
                            <?php endforeach; ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_option')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-sm-6">
        <div class="box box-primary" style="min-height: 252px;">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans("categories")); ?></h3>
                <small>(<?= esc(trans("show_under_these_categories")); ?>)</small>
            </div>
            <form action="<?= base_url('Category/addCategoryToCustomField'); ?>" method="post" onkeypress="return event.keyCode != 13;">
                <?= csrf_field(); ?>
                <input type="hidden" name="field_id" value="<?= $field->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("category")); ?></label>
                        <select id="categories" name="category_id[]" class="form-control" onchange="getSubCategories(this.value, 0);" required>
                            <option value=""><?= esc(trans('select_category')); ?></option>
                            <?php if (!empty($parentCategories)):
                                foreach ($parentCategories as $item): ?>
                                    <option value="<?= esc($item->id); ?>"><?= esc($item->cat_name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                        <div id="category_select_container"></div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary"><?= esc(trans('select_category')); ?></button>
                    </div>
                    <div class="row m-t-15">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped" role="grid">
                                <tbody>
                                <?php if (!empty($fieldCategories)):
                                    foreach ($fieldCategories as $item):
                                        if (!empty($item)):
                                            $categoriesTree = getCategoryParentTree($item->category_id, false);
                                            if (!empty($categoriesTree)):?>
                                                <tr>
                                                    <td>
                                                        <?php $count = 0;
                                                        foreach ($categoriesTree as $itemTree):
                                                            $itemCategory = getCategory($itemTree->id);
                                                            if (!empty($itemCategory)):
                                                                if ($count == 0) {
                                                                    echo esc($itemCategory->cat_name);
                                                                } else {
                                                                    echo ' / ' . esc($itemCategory->cat_name);
                                                                }
                                                            endif;
                                                            $count++;
                                                        endforeach; ?>
                                                        <!-- <button type="button" class="btn btn-xs btn-danger pull-right" onclick="deleteCategoryFromField('<?= esc(trans("confirm_delete", true)); ?>',<?= $field->id; ?>,<?= $itemCategory->id; ?>);"><?= esc(trans("delete")); ?></button> -->
                                                         <button type="button" class="btn btn-xs btn-danger pull-right btn-delete-category-from-field" data-msg="<?= esc(trans('confirm_delete', true)); ?>" data-field-id="<?= $field->id; ?>" data-category-id="<?= $itemCategory->id; ?>"><?= esc(trans("delete")); ?></button>
                                                    </td>
                                                </tr>
                                            <?php endif;
                                        endif;
                                    endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-large alert-info">
                        <strong><?= esc(trans("warning")); ?>!</strong>&nbsp;<?= esc(trans("warning_custom_field_category")); ?>
                    </div>

                </div>
            </form>
        </div>

        <?php if ($field->field_type == 'single_select' || $field->field_type == 'multi_select'): ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= esc(trans('settings')); ?></h3>
                </div>
                <form action="<?= base_url('Category/customFieldSettingsPost'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="field_id" value="<?= $field->id; ?>">
                    <div class="box-body">
                        <div class="form-group m-b-30">
                            <label><?= esc(trans("sort_options")); ?></label>
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="sort_options" value="date" id="sort_options_1" class="custom-control-input" <?= $field->sort_options == 'date' ? 'checked' : ''; ?>>
                                        <label for="sort_options_1" class="custom-control-label"><?= esc(trans("by_date")); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="sort_options" value="date_desc" id="sort_options_2" class="custom-control-input" <?= $field->sort_options == 'date_desc' ? 'checked' : ''; ?>>
                                        <label for="sort_options_2" class="custom-control-label"><?= esc(trans("by_date")); ?>&nbsp;(DESC)</label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="sort_options" value="alphabetically" id="sort_options_3" class="custom-control-input" <?= $field->sort_options == 'alphabetically' ? 'checked' : ''; ?>>
                                        <label for="sort_options_3" class="custom-control-label"><?= esc(trans("alphabetically")); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>