<div class="row">
    <div class="col-lg-10 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans('add_category')); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('forums-categories'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('categories')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminForumCategory/addCategoryPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                
                <div class="box-body">

                    <div class="form-group">
                        <label><?= esc(trans("category_name")); ?></label>
                        <?php foreach ($activeLanguages as $language): ?>
                            <input type="text" class="form-control m-b-5" name="name_<?= $language->id; ?>" placeholder="<?= countItems($activeLanguages) > 1 ? esc($language->name) : esc(trans("category_name")); ?>" maxlength="255" data-type="title" required>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("description")); ?>
                            <small>(<?= esc(trans("description")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="description" placeholder="<?= esc(trans("description")); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?= esc(trans("slug")); ?>" data-type="slug">
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="sort_order" placeholder="<?= esc(trans('order')); ?>" value="1" min="1" max="99999" data-type="number" required>
                    </div>   
                    <div class="form-group m-b-30">
                        <label class="control-label display-block"><?= esc(trans('image')); ?></label>
                        <div class='btn btn-success btn-sm btn-file-upload'>
                            <?= esc(trans('select_image')); ?>
                            <input type="file" name="file" class="image-input" accept=".jpg, .jpeg, .webp, .png, .gif" data-preview="#preview1">
                        </div>
                        <img src="" id="preview1" class="img-thumbnail img-preview">
                    </div> 
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_category')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
