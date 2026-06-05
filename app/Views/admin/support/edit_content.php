<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= $title; ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('knowledge-base?lang=' . $content->lang_id); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('knowledge_base')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('SupportAdmin/editContentPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <input type="hidden" name="id" value="<?= $content->id; ?>">
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('title')); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= esc(trans('title')); ?>" value="<?= esc($content->title); ?>" data-type="title" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans("slug")); ?>" value="<?= esc($content->slug); ?>" data-type="slug">
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("language")); ?></label>
                        <select name="lang_id" class="form-control max-600" onchange="getKnowledgeBaseCategoriesByLang(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $content->lang_id == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("categories")); ?></label>
                        <select name="category_id" id="categories" class="form-control max-600" required>
                            <?php if (!empty($categories)):
                                foreach ($categories as $category): ?>
                                    <option value="<?= $category->id; ?>" <?= $content->category_id == $category->id ? 'selected' : ''; ?>><?= esc($category->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control max-600" name="content_order" placeholder="<?= esc(trans('order')); ?>" value="<?= esc($content->content_order); ?>" min="1" data-type="number">
                    </div>
                    <div class="form-group">
                        <?= renderTextEditorAdmin('content', trans("content"), $content->content); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= view('admin/includes/_image_file_manager'); ?>