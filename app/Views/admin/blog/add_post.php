<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans("add_post")); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('blog-posts'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('posts')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('Blog/addPostPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('title')); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= esc(trans('title')); ?>" value="<?= old('title'); ?>" data-type="name" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('slug')); ?>
                            <small>(<?= esc(trans('slug_exp')); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans('slug')); ?>" value="<?= old('slug'); ?>" data-type="slug">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('summary')); ?> & <?= esc(trans("description")); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <textarea class="form-control text-area" name="summary" data-type="text" placeholder="<?= esc(trans('summary')); ?> & <?= esc(trans("description")); ?> (<?= esc(trans('meta_tag')); ?>)"><?= old('summary');  ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="keywords" placeholder="<?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= old('keywords'); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label"><?= esc(trans('tags')); ?></label>
                                <input type="text" name="tags" value="" class="form-control tags-input input-tagify" data-type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("language")); ?></label>
                        <select name="lang_id" class="form-control max-600" onchange="getBlogCategoriesByLang(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= selectedLangId() == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('category')); ?></label>
                        <select id="categories" name="category_id" class="form-control max-600" required>
                            <option value=""><?= esc(trans('select_category')); ?></option>
                            <?php if (!empty($categories)):
                                foreach ($categories as $item): ?>
                                    <option value="<?= $item->id; ?>"><?= esc($item->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('image')); ?></label>
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="blog_select_image_container" class="post-select-image-container">
                                    <a class="btn-select-image btn-file-manager" data-image-type="main" data-toggle="modal" data-target="#imageFileManagerModal">
                                        <div class="btn-select-image-inner">
                                            <i class="fa fa-image"></i>
                                            <button class="btn"><?= esc(trans("select_image")); ?></button>
                                        </div>
                                    </a>
                                </div>
                                <input type="hidden" name="blog_image_id" id="blog_image_id">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= renderTextEditorAdmin('content', trans("content"), old('content')); ?>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_post')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= view('admin/includes/_image_file_manager'); ?>