<div class="row">
    <div class="col-lg-10 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans('add_category')); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('categories'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('categories')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('Category/addCategoryPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="parent_id" value="0">
                <input type="hidden" id="csrf_token_name" value="<?= csrf_token() ?>">
                <input type="hidden" id="csrf_hash" value="<?= csrf_hash() ?>">
                <div class="box-body">

                    <div class="form-group">
                        <label><?= esc(trans("category_name")); ?></label>
                        <?php foreach ($activeLanguages as $language): ?>
                            <input type="text" class="form-control m-b-5" name="name_<?= $language->id; ?>" placeholder="<?= countItems($activeLanguages) > 1 ? esc($language->name) : esc(trans("category_name")); ?>" maxlength="255" data-type="title" required>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans("slug")); ?>" data-type="slug">
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="category_order" placeholder="<?= esc(trans('order')); ?>" value="1" min="1" max="99999" data-type="number" required>
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans('parent_category')); ?></label>
                        <select class="form-control select2 parent-category-select" name="category_id[]" required>
                            <option value="0"><?= esc(trans('none')); ?></option>
                            <?php if (!empty($parentCategories)):
                                foreach ($parentCategories as $parentCategory): ?>
                                    <option value="<?= $parentCategory->id; ?>"><?= esc($parentCategory->cat_name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                        <div id="category_select_container"></div>
                    </div>

                    <div class="form-group">
                        <label for="commission_mode"><?= esc(trans("commission")); ?></label>
                        <select name="commission_mode" id="commission_mode" class="form-control">
                            <option value="default"><?= esc(trans("default")); ?></option>
                            <option value="custom"><?= esc(trans("custom")); ?></option>
                            <option value="none"><?= esc(trans("none")); ?> (0%)</option>
                        </select>
                    </div>

                    <div class="form-group" id="custom_commission_input" style="display: none">
                        <label><?= esc(trans('commission_rate')); ?>&nbsp;(%)</label>
                        <input type="number" name="commission_rate" id="commission_rate" class="form-control" min="0" max="99.99" step="0.01" placeholder="E.g. 5">
                    </div>

                    <div class="form-group">
                        <?= formSwitch('status', trans('status'), 1); ?>
                    </div>

                    <div class="form-group">
                        <?= formSwitch('show_on_main_menu', trans('show_on_main_menu'), 1); ?>
                    </div>

                    <div class="form-group">
                        <?= formSwitch('show_image_on_main_menu', trans('show_image_on_main_menu'), 0); ?>
                    </div>

                    <div class="form-group">
                        <?= formSwitch('show_description', trans('show_description_category_page'), 0); ?>
                    </div>

                    <div class="form-group m-b-30">
                        <label class="control-label display-block"><?= esc(trans('image')); ?></label>
                        <div class='btn btn-success btn-sm btn-file-upload'>
                            <?= esc(trans('select_image')); ?>
                            <input type="file" name="file" class="image-input" accept=".jpg, .jpeg, .webp, .png, .gif" data-preview="#preview1">
                        </div>
                        <img src="" id="preview1" class="img-thumbnail img-preview">
                    </div>

                    <div class="nav-tabs-custom tab-default">
                        <p class="font-600"><?= esc(trans("seo_metadata")); ?></p>
                        <ul class="nav nav-tabs">
                            <?php foreach ($activeLanguages as $language): ?>
                                <li class="<?= $language->id == selectedLangId() ? 'active' : ''; ?>"><a href="#tabLang<?= $language->id; ?>" data-toggle="tab" aria-expanded="true"><?= esc($language->name); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tab-content">
                            <?php foreach ($activeLanguages as $language): ?>
                                <div class="tab-pane <?= $language->id == selectedLangId() ? 'active' : ''; ?>" id="tabLang<?= $language->id; ?>">
                                    <div class="form-group m-b-10">
                                        <input type="text" name="meta_title_<?= $language->id; ?>" class="form-control" placeholder="<?= esc(trans("meta_title")); ?>">
                                    </div>
                                    <div class="form-group m-b-10">
                                        <textarea class="form-control form-textarea" name="meta_description_<?= $language->id; ?>" placeholder="<?= esc(trans("meta_description")); ?>" data-type="text"></textarea>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <input type="text" class="form-control" name="meta_keywords_<?= $language->id; ?>" placeholder="<?= esc(trans('meta_keywords')); ?>" data-type="text">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_category')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
