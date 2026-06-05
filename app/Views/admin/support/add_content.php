<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= $title; ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('knowledge-base?lang=' . clrNum((inputGet('lang')))); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('knowledge_base')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('SupportAdmin/addContentPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('title')); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= esc(trans('title')); ?>" value="<?= old('title'); ?>" data-type="title" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans("slug")); ?>" value="<?= old('slug'); ?>" data-type="slug">
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("language")); ?></label>
                        <select name="lang_id" class="form-control max-600" onchange="getKnowledgeBaseCategoriesByLang(this.value);" required>
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= inputGet('lang') == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("categories")); ?></label>
                        <select name="category_id" id="categories" class="form-control max-600" required>
                            <?php if (!empty($categories)):
                                foreach ($categories as $category): ?>
                                    <option value="<?= $category->id; ?>"><?= esc($category->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control max-600" name="content_order" placeholder="<?= esc(trans('order')); ?>" value="1" min="1" data-type="number">
                    </div>
                    <div class="form-group">
                        <?= renderTextEditorAdmin('content', trans("content"), old('page_content')); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_content')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= view('admin/includes/_image_file_manager'); ?>