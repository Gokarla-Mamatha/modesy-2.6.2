<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans('update_page')); ?></h3>
            </div>
            <form action="<?= base_url('Admin/editPagePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $page->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('title')); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= esc(trans('title')); ?>" value="<?= esc($page->title); ?>" data-type="title" required>
                    </div>
                    <?php if (empty($page->page_default_name)): ?>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans("slug")); ?>
                                <small>(<?= esc(trans("slug_exp")); ?>)</small>
                            </label>
                            <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans("slug")); ?>" value="<?= esc($page->slug); ?>" data-type="slug">
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="slug" value="<?= esc($page->slug); ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("description")); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="description" placeholder="<?= esc(trans("description")); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= esc($page->description); ?>" data-type="text">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="keywords" placeholder="<?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= esc($page->keywords); ?>">
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans("language")); ?></label>
                        <select name="lang_id" class="form-control" style="max-width: 600px;">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $page->lang_id == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" clas s="form-control" name="page_order" placeholder="<?= esc(trans('order')); ?>" value="<?= $page->page_order; ?>" min="1" style="max-width: 600px;" data-type="number">
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans("location")); ?></label>
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="top_menu" id="location_1" class="custom-control-input" <?= $page->location == 'top_menu' ? 'checked' : ''; ?>>
                                    <label for="location_1" class="custom-control-label"><?= esc(trans("top_menu")); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="quick_links" id="location_2" class="custom-control-input" <?= $page->location == 'quick_links' ? 'checked' : ''; ?>>
                                    <label for="location_2" class="custom-control-label"><?= esc(trans("footer_quick_links")); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="information" id="location_3" class="custom-control-input" <?= $page->location == 'information' ? 'checked' : ''; ?>>
                                    <label for="location_3" class="custom-control-label"><?= esc(trans("footer_information")); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="footer_bottom" id="location_4" class="custom-control-input" <?= $page->location == 'footer_bottom' ? 'checked' : ''; ?>>
                                    <label for="location_4" class="custom-control-label"><?= esc(trans("footer_bottom")); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans("visibility")); ?></label>
                        <?= formRadio('visibility', 1, 0, trans("show"), trans("hide"), $page->visibility, 'col-md-2'); ?>
                    </div>

                    <?php if ($page->page_default_name != 'blog' && $page->page_default_name != 'contact' && $page->page_default_name != 'shops'): ?>
                        <div class="form-group">
                            <label><?= esc(trans("show_title")); ?></label>
                            <?= formRadio('title_active', 1, 0, trans("yes"), trans("no"), $page->title_active, 'col-md-2'); ?>
                        </div>
                    <?php else: ?>
                        <input type="hidden" value="1" name="title_active">
                    <?php endif;
                    if ($page->page_default_name != 'blog' && $page->page_default_name != 'contact' && $page->page_default_name != 'shops'): ?>
                        <?= renderTextEditorAdmin('page_content', trans("content"), $page->page_content); ?>
                    <?php else: ?>
                        <input type="hidden" value="" name="page_content">
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= view('admin/includes/_image_file_manager'); ?>