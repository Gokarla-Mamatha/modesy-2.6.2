<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans("update_category")); ?></h3>
            </div>
            <form action="<?= base_url('Blog/editCategoryPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $category->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= esc(trans("language")); ?></label>
                        <select name="lang_id" class="form-control">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $category->lang_id == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("category_name")); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= esc(trans("category_name")); ?>" value="<?= esc($category->name); ?>" maxlength="200" data-type="name" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans("slug")); ?>" value="<?= esc($category->slug); ?>" data-type="slug">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('description')); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="description" placeholder="<?= esc(trans('description')); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= esc($category->description); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="keywords" placeholder="<?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= esc($category->keywords); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="category_order" placeholder="<?= esc(trans('order')); ?>" value="<?= esc($category->category_order); ?>" min="1" data-type="number" required>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>