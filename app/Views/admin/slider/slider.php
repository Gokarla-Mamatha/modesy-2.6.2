<?php $animationArray = ['none', 'bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat', 'bounceIn', 'bounceInDown', 'bounceInLeft',
    'bounceInRight', 'bounceInUp', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'flip',
    'flipInX', 'flipInY', 'lightSpeedIn', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'slideInUp', 'slideInDown', 'slideInLeft',
    'slideInRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp', 'hinge', 'jackInTheBox', 'rollIn']; ?>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans('add_slider_item')); ?></h3>
            </div>
            <form action="<?= base_url('Admin/addSliderItemPost'); ?>" method="post" enctype="multipart/form-data">
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
                        <label class="control-label"><?= esc(trans('title')); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= esc(trans('title')); ?>" value="<?= old('title'); ?>" data-type="name">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('description')); ?></label>
                        <textarea name="description" class="form-control" data-type="text" placeholder="<?= esc(trans('description')); ?>" data-type="text"><?= old('description'); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('link')); ?></label>
                        <input type="text" class="form-control" name="link" placeholder="<?= esc(trans('link')); ?>" value="<?= old('link'); ?>" data-type="url">
                    </div>
                    <div class="row row-form">
                        <div class="col-sm-12 col-md-6 col-form">
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans('order')); ?></label>
                                <input type="number" class="form-control" name="item_order" placeholder="<?= esc(trans('order')); ?>" value="<?= old('item_order'); ?>" data-type="number">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-form">
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans('button_text')); ?></label>
                                <input type="text" class="form-control" name="button_text" placeholder="<?= esc(trans('button_text')); ?>" value="<?= old('button_text'); ?>" data-type="name">
                            </div>
                        </div>
                    </div>
                    <div class="row row-form">
                        <div class="col-sm-12 col-md-4 col-form">
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans('text_color')); ?></label>
                                <input type="color" class="form-control" name="text_color" value="#ffffff">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-form">
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans('button_color')); ?></label>
                                <input type="color" class="form-control" name="button_color" value="#222222">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-form">
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans('button_text_color')); ?></label>
                                <input type="color" class="form-control" name="button_text_color" value="#ffffff">
                            </div>
                        </div>
                    </div>
                    <div class="row row-form">
                        <div class="col-sm-12" style="padding-left: 7.5px;">
                            <label><?= esc(trans("animations")); ?></label>
                        </div>
                        <div class="col-sm-12 col-md-4 col-form">
                            <div class="form-group">
                                <label><?= esc(trans("title")); ?></label>
                                <select name="animation_title" class="form-control">
                                    <?php foreach ($animationArray as $animation): ?>
                                        <option value="<?= $animation; ?>" <?= $animation == 'fadeInUp' ? 'selected' : ''; ?>><?= $animation; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-form">
                            <div class="form-group">
                                <label><?= esc(trans("description")); ?></label>
                                <select name="animation_description" class="form-control">
                                    <?php foreach ($animationArray as $animation): ?>
                                        <option value="<?= $animation; ?>" <?= $animation == 'fadeInUp' ? 'selected' : ''; ?>><?= $animation; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-form">
                            <div class="form-group">
                                <label><?= esc(trans("button")); ?></label>
                                <select name="animation_button" class="form-control">
                                    <?php foreach ($animationArray as $animation): ?>
                                        <option value="<?= $animation; ?>" <?= $animation == 'fadeInUp' ? 'selected' : ''; ?>><?= $animation; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('image')); ?> (1920x600)</label>
                        <div class="display-block">
                            <a class='btn btn-success btn-sm btn-file-upload'>
                                <?= esc(trans('select_image')); ?>
                                <input type="file" name="file" size="40" accept=".jpg, .jpeg, .webp, .png, .gif" required onchange="showPreviewImage(this);">
                            </a>
                        </div>
                        <img id="img_preview_file" class="img-file-upload-preview">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('image')); ?>&nbsp;(for mobile) (768x500)</label>
                        <div class="display-block">
                            <a class='btn btn-success btn-sm btn-file-upload'>
                                <?= esc(trans('select_image')); ?>
                                <input type="file" name="file_mobile" size="40" accept=".jpg, .jpeg, .webp, .png, .gif" required onchange="showPreviewImage(this);">
                            </a>
                        </div>
                        <img id="img_preview_file_mobile" class="img-file-upload-preview">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_slider_item')); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans('slider_items')); ?></h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= esc(trans('id')); ?></th>
                                    <th><?= esc(trans('image')); ?></th>
                                    <th><?= esc(trans('language')); ?></th>
                                    <th><?= esc(trans('order')); ?></th>
                                    <th class="th-options"><?= esc(trans('options')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($sliderItems)):
                                    foreach ($sliderItems as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td><img src="<?= base_url($item->image); ?>" alt="" class="product-img"></td>
                                            <td>
                                                <?php $language = getLanguage($item->lang_id);
                                                if (!empty($language)) {
                                                    echo $language->name;
                                                } ?>
                                            </td>
                                            <td><?= $item->item_order; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-slider-item/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                        <li>
                                                            <!-- <a href="javascript:void(0)" onclick="deleteItem('Admin/deleteSliderItemPost','<?= $item->id; ?>','<?= esc(trans("confirm_slider_item", true)); ?>');"> -->
                                                                <a href="#" class="btn-item-delete" data-url="Admin/deleteSliderItemPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_slider_item', true)); ?>">
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

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans('slider_settings')); ?></h3>
            </div>
            <form action="<?= base_url('Admin/editSliderSettingsPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= esc(trans("status")); ?></label>
                        <?= formRadio('slider_status', 1, 0, trans("enable"), trans("disable"), $generalSettings->slider_status); ?>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("type")); ?></label>
                        <?= formRadio('slider_type', 'full_width', 'boxed', trans("full_width"), trans("boxed"), $generalSettings->slider_type); ?>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("effect")); ?></label>
                        <?= formRadio('slider_effect', 'fade', 'slide', trans("fade"), trans("slide"), $generalSettings->slider_effect); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
