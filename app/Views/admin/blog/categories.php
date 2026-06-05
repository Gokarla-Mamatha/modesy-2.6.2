<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans("add_category")); ?></h3>
            </div>
            <form action="<?= base_url('Blog/addCategoryPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= esc(trans("language")); ?></label>
                        <select name="lang_id" class="form-control">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= selectedLangId() == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("category_name")); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= esc(trans("category_name")); ?>" value="<?= old('name'); ?>" maxlength="200" data-type="name" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans("slug")); ?>" value="<?= old('slug'); ?>" data-type="slug">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('description')); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="description" placeholder="<?= esc(trans('description')); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= old('description'); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="keywords" placeholder="<?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= old('keywords'); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="category_order" placeholder="<?= esc(trans('order')); ?>" value="1" min="1" data-type="number" required>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_category')); ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= esc(trans('categories')); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= esc(trans('id')); ?></th>
                                    <th><?= esc(trans('category_name')); ?></th>
                                    <th><?= esc(trans('language')); ?></th>
                                    <th><?= esc(trans('order')); ?></th>
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
                                                    echo $language->name;
                                                } ?>
                                            </td>
                                            <td><?= esc($item->category_order); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-blog-category/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                        <li>
                                                            <!-- <a href="javascript:void(0)" onclick="deleteItem('Blog/deleteCategoryPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                            <a href="#" class="btn-item-delete" data-url="Blog/deleteCategoryPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
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