<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc(trans('pages')); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('add-page'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans('add_page')); ?>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped cs_datatable_lang" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= esc(trans('id')); ?></th>
                            <th><?= esc(trans('title')); ?></th>
                            <th><?= esc(trans('language')); ?></th>
                            <th><?= esc(trans('location')); ?></th>
                            <th><?= esc(trans('visibility')); ?></th>
                            <th><?= esc(trans('page_type')); ?></th>
                            <th><?= esc(trans('date')); ?></th>
                            <th class="th-options"><?= esc(trans('options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($pages)):
                            foreach ($pages as $item): ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->title); ?></td>
                                    <td><?php
                                        $language = getLanguage($item->lang_id);
                                        if (!empty($language)) {
                                            echo $language->name;
                                        } ?>
                                    </td>
                                    <td>
                                        <?php if ($item->location == 'top_menu') {
                                            echo trans("top_menu");
                                        } elseif ($item->location == 'footer_bottom') {
                                            echo trans("footer_bottom");
                                        } else {
                                            echo trans("footer_" . $item->location);
                                        } ?>
                                    </td>
                                    <td>
                                        <?php if ($item->visibility == 1): ?>
                                            <label class="label label-success"><i class="fa fa-eye"></i></label>
                                        <?php else: ?>
                                            <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item->is_custom == 1): ?>
                                            <label class="label bg-teal"><?= esc(trans('custom')); ?></label>
                                        <?php else: ?>
                                            <label class="label label-default"><?= esc(trans('default')); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-bs-toggle btn-select-option" type="button" data-bs-toggle="dropdown"><?= esc(trans('select_option')); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li><a href="<?= adminUrl('edit-page/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= esc(trans('edit')); ?></a></li>
                                                <?php if ($item->is_custom == 1): ?>
                                                    <li>
                                                        <!-- <a href="javascript:void(0)" onclick="deleteItem('Admin/deletePagePost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                            <a href="#" class="btn-item-delete" data-url="Admin/deletePagePost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_user', true)); ?>">
                                                                <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?>
                                                            </a>
                                                    </li>
                                                <?php endif; ?>
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