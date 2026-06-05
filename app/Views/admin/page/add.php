<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans('add_page')); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl("pages"); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('pages')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('Admin/addPagePost'); ?>" method="post">
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
                        <label class="control-label"><?= esc(trans("description")); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="description" placeholder="<?= esc(trans("description")); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= old('description'); ?>" data-type="text">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)</label>
                        <input type="text" class="form-control" name="keywords" placeholder="<?= esc(trans('keywords')); ?> (<?= esc(trans('meta_tag')); ?>)" value="<?= old('keywords'); ?>">
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("language")); ?></label>
                        <select name="lang_id" class="form-control" style="max-width: 600px;">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= selectedLangId() == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="page_order" placeholder="<?= esc(trans('order')); ?>" value="1" min="1" style="max-width: 600px;" data-type="number">
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans("location")); ?></label>
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="top_menu" id="location_1" class="custom-control-input" checked>
                                    <label for="location_1" class="custom-control-label"><?= esc(trans("top_menu")); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="quick_links" id="location_2" class="custom-control-input">
                                    <label for="location_2" class="custom-control-label"><?= esc(trans("footer_quick_links")); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="information" id="location_3" class="custom-control-input">
                                    <label for="location_3" class="custom-control-label"><?= esc(trans("footer_information")); ?></label>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="location" value="footer_bottom" id="location_4" class="custom-control-input">
                                    <label for="location_4" class="custom-control-label"><?= esc(trans("footer_bottom")); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans("visibility")); ?></label>
                        <?= formRadio('visibility', 1, 0, trans("show"), trans("hide"), 1, 'col-md-2'); ?>
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans("show_title")); ?></label>
                        <?= formRadio('title_active', 1, 0, trans("yes"), trans("no"), 1, 'col-md-2'); ?>
                    </div>

                    <div class="form-group" style="margin-top: 30px;">
                        <?= renderTextEditorAdmin('page_content', trans("content")); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_page')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= view('admin/includes/_image_file_manager'); ?>