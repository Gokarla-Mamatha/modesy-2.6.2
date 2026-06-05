<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= esc(trans('language_settings')); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= esc(trans('languages')); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped data_table" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= esc(trans('id')); ?></th>
                                    <th><?= esc(trans('language_name')); ?></th>
                                    <th><?= esc(trans('default_language')); ?></th>
                                    <th><?= esc(trans('translation')); ?>/<?= esc(trans('export')); ?></th>
                                    <th class="th-options"><?= esc(trans('options')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($languages)):
                                    foreach ($languages as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td>
                                                <?= esc($item->name); ?>&nbsp;
                                                <?php if ($item->status == 1): ?>
                                                    <label class="label label-success lbl-lang-status"><?= esc(trans('active')); ?></label>
                                                <?php else: ?>
                                                    <label class="label label-danger lbl-lang-status"><?= esc(trans('inactive')); ?></label>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (defaultLangId() == $item->id): ?>
                                                    <label class="label label-default lbl-lang-status"><?= esc(trans('default')); ?></label>
                                                <?php else: ?>
                                                    <form action="<?= base_url('Language/setDefaultLanguagePost'); ?>" method="post" class="display-inline-block">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="site_lang" value="<?= $item->id; ?>">
                                                        <button type="submit" class="btn btn-sm btn-success float-right">
                                                            <i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;<?= esc(trans('set_as_default')); ?>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= adminUrl('edit-translations/' . $item->id . '?show=50'); ?>" class="btn btn-sm btn-info float-right">
                                                    <i class="fa fa-exchange"></i>&nbsp;&nbsp;<?= esc(trans('edit_translations')); ?>
                                                </a>&nbsp;&nbsp;
                                                <form action="<?= base_url('Language/exportLanguagePost'); ?>" method="post" class="display-inline-block">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="lang_id" value="<?= $item->id; ?>">
                                                    <button type="submit" class="btn btn-sm btn-warning float-right">
                                                        <i class="fa fa-cloud-download" aria-hidden="true"></i>&nbsp;&nbsp;<?= esc(trans('export')); ?>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?><span class="caret"></span></button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li><a href="<?= adminUrl('edit-language/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                        <li>
                                                            <!-- <a href="javascript:void(0)" onclick="deleteItem('Language/deleteLanguagePost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                                <a href="#" class="btn-item-delete" data-url="Language/deleteLanguagePost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                                    <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?>
                                                                </a>
                                                            </li>
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
    <div class="col-lg-6 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans("add_language")); ?></h3>
            </div>
            <form action="<?= base_url('Language/addLanguagePost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= esc(trans("language_name")); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= esc(trans("language_name")); ?>" value="<?= old('name'); ?>" maxlength="200" data-type="name" required>
                        <small>(Ex: English)</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("short_form")); ?> </label>
                        <input type="text" class="form-control" name="short_form" placeholder="<?= esc(trans("short_form")); ?>" value="<?= old('short_form'); ?>" maxlength="200" data-type="text" required>
                        <small>(Ex: en)</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("language_code")); ?> </label>
                        <input type="text" class="form-control" name="language_code" placeholder="<?= esc(trans("language_code")); ?>" value="<?= old('language_code'); ?>" maxlength="200" data-type="text" required>
                        <small>(Ex: en-US)</small>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="language_order" placeholder="<?= esc(trans('order')); ?>" value="1" min="1" data-type="number" required>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("text_direction")); ?></label>
                        <?= formRadio('text_direction', 'ltr', 'rtl', trans("left_to_right"), trans("right_to_left"), 'ltr'); ?>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans('text_editor_language')); ?></label>
                        <select name="text_editor_lang" class="form-control" required>
                            <option value=""><?= esc(trans("select")); ?></option>
                            <?php if (!empty($editorLanguageOptions)):
                                foreach ($editorLanguageOptions as $item): ?>
                                    <option value="<?= $item['short']; ?>"><?= $item['name']; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("flag")); ?></label>
                        <div class="display-block">
                            <a class='btn btn-default btn-sm btn-file-upload'>
                                <i class="fa fa-image text-muted"></i>&nbsp;&nbsp;<?= esc(trans("select_image")); ?>
                                <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info-flag').html($(this).val().replace(/.*[\/\\]/, ''));" required>
                            </a>
                            <br>
                            <span class='label label-default label-file-upload' id="upload-file-info-flag"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("status")); ?></label>
                        <?= formRadio('status', 1, 0, trans("active"), trans("inactive"), '1'); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_language')); ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="box" style="max-width: 500px;">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans("import_language")); ?></h3>
            </div>
            <form action="<?= base_url('Language/importLanguagePost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('json_language_file')); ?></label>
                        <div class="display-block">
                            <a class='btn btn-default btn-sm btn-file-upload'>
                                <i class="fa fa-file text-muted"></i>&nbsp;&nbsp;<?= esc(trans('select_file')); ?>
                                <input type="file" name="file" size="40" accept=".json" required onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));">
                            </a>
                            <br>
                            <span class='label label-default label-file-upload' id="upload-file-info"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('flag')); ?></label>
                        <div class="display-block">
                            <a class='btn btn-default btn-sm btn-file-upload'>
                                <i class="fa fa-image text-muted"></i>&nbsp;&nbsp;<?= esc(trans('select_image')); ?>
                                <input type="file" name="flag" size="40" accept=".png, .jpg, .jpeg, .gif" required onchange="$('#upload-file-info-1').html($(this).val().replace(/.*[\/\\]/, ''));">
                            </a>
                        </div>
                        <span class='label label-default label-file-upload' id="upload-file-info-1"></span>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('import_language')); ?></button>
                </div>
            </form>
        </div>
        <div class="alert alert-info alert-large" style="width: auto !important;display: inline-block;max-width: 500px;">
            <?= esc(trans("languages")); ?>: <a href="https://codingest.com/languages" target="_blank" style="color: #0c5460;font-weight: bold">https://codingest.com/languages</a>
        </div>
    </div>
</div>