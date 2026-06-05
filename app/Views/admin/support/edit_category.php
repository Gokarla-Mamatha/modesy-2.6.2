<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= esc(trans('knowledge_base')); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= $title; ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('knowledge-base?lang=' . $category->lang_id); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('knowledge_base')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('SupportAdmin/editCategoryPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $category->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= esc(trans("language")); ?></label>
                        <select name="lang_id" class="form-control" required>
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $category->lang_id == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('name')); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= esc(trans('name')); ?>" value="<?= esc($category->name); ?>" data-type="title" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans("slug")); ?>" value="<?= esc($category->slug); ?>" data-type="slug" required>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="category_order" placeholder="<?= esc(trans('order')); ?>" value="<?= esc($category->category_order); ?>" min="1" style="max-width: 300px;" data-type="number">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>