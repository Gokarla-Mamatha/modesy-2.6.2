<div class="row">
    <div class="col-lg-10 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans('update_category')); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('categories'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('categories')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('Category/editCategoryPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $category->id; ?>">
                <input type="hidden" id="csrf_token_name" value="<?= csrf_token() ?>">
                <input type="hidden" id="csrf_hash" value="<?= csrf_hash() ?>">
                <div class="box-body">

                    <div class="form-group">
                        <label><?= esc(trans("category_name")); ?></label>
                        <?php foreach ($activeLanguages as $language): ?>
                            <input type="text" class="form-control m-b-5" name="name_<?= $language->id; ?>" value="<?= !empty($categoryDetails) && !empty($categoryDetails[$language->id]) ? esc($categoryDetails[$language->id]->name) : ''; ?>" placeholder="<?= countItems($activeLanguages) > 1 ? esc($language->name) : esc(trans("category_name")); ?>" maxlength="255" data-type="title" required>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" value="<?= esc($category->slug); ?>" placeholder="<?= esc(trans("slug")); ?>" data-type="slug" >
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="category_order" value="<?= esc($category->category_order); ?>" placeholder="<?= esc(trans('order')); ?>" value="1" min="1" max="99999" data-type="number" required>
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans('parent_category')); ?></label>
                        <div id="category_select_container">
                            <?php

                            $parentArray = [];

                            $currentCategory = getCategory($category->id);

                            if (!empty($currentCategory->parent_id)) {
                                $parentArray[] = $currentCategory->parent_id;
                            }

                            $parentArray[] = $category->id;
                            $level = 1;
                            foreach ($parentArray as $parentId):
                                $parentItem = getCategory($parentId);
                                if (!empty($parentItem)):
                                    $subCategories = getSubCategoriesByParentId($parentItem->parent_id);
                                    if (!empty($subCategories)): ?>
                                        <div class="subcategory-select-container" data-level="<?= $level; ?>">
                                            <select name="category_id[]" class="form-control select2 parent-category-select" data-level="<?= $level; ?>">
                                                <option value=""><?= esc(trans('none')); ?></option>
                                                <?php foreach ($subCategories as $subCategory):
                                                    if ($subCategory->id != $category->id):?>
                                                        <option value="<?= $subCategory->id; ?>" <?= $subCategory->id == $parentItem->id ? 'selected' : ''; ?>><?= esc($subCategory->cat_name); ?></option>
                                                    <?php endif;
                                                endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endif;
                                endif;
                                $level++;
                            endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="commission_mode"><?= esc(trans("commission")); ?></label>
                        <select name="commission_mode" id="commission_mode" class="form-control">
                            <option value="default" <?= $category->is_commission_set == 0 ? 'selected' : ''; ?>><?= esc(trans("default")); ?></option>
                            <option value="custom" <?= $category->is_commission_set == 1 && $category->commission_rate > 0 ? 'selected' : ''; ?>><?= esc(trans("custom")); ?></option>
                            <option value="none" <?= $category->is_commission_set == 1 && $category->commission_rate == 0 ? 'selected' : ''; ?>><?= esc(trans("none")); ?> (0%)</option>
                        </select>
                    </div>

                    <div class="form-group" id="custom_commission_input" style="<?= $category->is_commission_set == 1 && $category->commission_rate > 0 ? '' : 'display: none;'; ?>">
                        <label><?= esc(trans('commission_rate')); ?>&nbsp;(%)</label>
                        <input type="number" name="commission_rate" id="commission_rate" class="form-control" min="0" max="99.99" step="0.01" value="<?= $category->commission_rate > 0 ? esc(formatDecimalClean($category->commission_rate)) : ''; ?>" placeholder="E.g. 5">
                    </div>

                    <div class="form-group">
                        <?= formSwitch('status', trans('status'), $category->status); ?>
                    </div>

                    <div class="form-group">
                        <?= formSwitch('show_on_main_menu', trans('show_on_main_menu'), $category->show_on_main_menu); ?>
                    </div>

                    <div class="form-group">
                        <?= formSwitch('show_image_on_main_menu', trans('show_image_on_main_menu'), $category->show_image_on_main_menu); ?>
                    </div>

                    <div class="form-group">
                        <?= formSwitch('show_description', trans('show_description_category_page'), $category->show_description); ?>
                    </div>

                    <div class="form-group m-b-30">
                        <label class="control-label display-block"><?= esc(trans('image')); ?></label>
                        <div class='btn btn-success btn-sm btn-file-upload'>
                            <?= esc(trans('select_image')); ?>
                            <input type="file" name="file" class="image-input" accept=".jpg, .jpeg, .webp, .png, .gif" data-preview="#preview1">
                        </div>
                        <?php if (!empty($category->image)): ?>
                            <!-- <a href="#" class="btn btn-sm btn-danger btn-delete-category-img" onclick="deleteCategoryImage('<?= $category->id; ?>');"><?= esc(trans("delete")); ?></a> -->
                             <a href="#" class="btn btn-sm btn-danger btn-delete-img" data-id="<?= $category->id; ?>" data-fn="deleteCategoryImage"> <?= esc(trans("delete")); ?></a>
                        <?php endif; ?>
                        <img src="" id="preview1" class="img-thumbnail img-preview">
                        <div>
                            <?php $imgUrl = getStorageFileUrl($category->image, $category->storage); ?>
                            <img src="<?= !empty($imgUrl) ? esc($imgUrl) : ''; ?>" id="preview1" class="img-thumbnail img-preview img-category">
                        </div>
                    </div>

                    <div class="nav-tabs-custom nav-tabs-multi-lang tab-default">
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
                                        <input type="text" name="meta_title_<?= $language->id; ?>" value="<?= !empty($categoryDetails) && !empty($categoryDetails[$language->id]) ? esc($categoryDetails[$language->id]->meta_title) : ''; ?>" class="form-control" placeholder="<?= esc(trans("meta_title")); ?>">
                                    </div>
                                    <div class="form-group m-b-10">
                                        <textarea class="form-control form-textarea" data-type="text" name="meta_description_<?= $language->id; ?>" placeholder="<?= esc(trans("meta_description")); ?>"><?= !empty($categoryDetails) && !empty($categoryDetails[$language->id]) ? esc($categoryDetails[$language->id]->meta_description) : ''; ?></textarea>
                                    </div>
                                    <div class="form-group m-b-10">
                                        <input type="text" class="form-control" data-type="text" name="meta_keywords_<?= $language->id; ?>" value="<?= !empty($categoryDetails) && !empty($categoryDetails[$language->id]) ? esc($categoryDetails[$language->id]->meta_keywords) : ''; ?>" placeholder="<?= esc(trans('meta_keywords')); ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>