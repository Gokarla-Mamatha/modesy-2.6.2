<div class="row">
    <div class="col-lg-10 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans('update_category')); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('forums-categories'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('categories')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('AdminForumCategory/editCategoryPost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $category->id; ?>">
                <div class="box-body">

                    <div class="form-group">
                        <label><?= esc(trans("category_name")); ?></label>
                      <input type="text" class="form-control" name="name_1"    value="<?= esc($category->name); ?>" data-type="title">

                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("description")); ?>
                            <small>(<?= esc(trans("description")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="description" placeholder="<?= esc(trans("description")); ?>"  value="<?= esc($category->description); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans("slug")); ?>
                            <small>(<?= esc(trans("slug_exp")); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" value="<?= esc($category->slug); ?>" placeholder="<?= esc(trans("slug")); ?>" data-type="slug">
                    </div>

                    <div class="form-group">
                        <label><?= esc(trans('order')); ?></label>
                        <input type="number" class="form-control" name="sort_order" value="<?= esc($category->sort_order); ?>" placeholder="<?= esc(trans('order')); ?>" value="1" min="1" max="99999" data-type="number" required>
                    </div>

                    <div class="form-group m-b-30">
                        <label class="control-label display-block"><?= esc(trans('image')); ?></label>
                        <div class='btn btn-success btn-sm btn-file-upload'>
                            <?= esc(trans('select_image')); ?>
                            <input type="file" name="file" class="image-input" accept=".jpg, .jpeg, .webp, .png, .gif" data-preview="#preview1">
                        </div>
                        <?php if (!empty($category->thumbnail)): ?>
                            <!-- <a href="#" class="btn btn-sm btn-danger btn-delete-category-img" onclick="deleteForumCategoryImage('<?= $category->id; ?>');"><?= esc(trans("delete")); ?></a> -->
                            <a href="#" class="btn btn-sm btn-danger btn-delete-img" data-id="<?= $category->id; ?>" data-fn="deleteForumCategoryImage"> <?= esc(trans("delete")); ?></a>
                        <?php endif; ?>
                       
                        <div>
                            <?php $imgUrl = getStorageFileUrl($category->thumbnail, $category->storage); ?>
                            <img src="<?= !empty($imgUrl) ? esc($imgUrl) : ''; ?>" id="preview1" class="img-thumbnail img-preview img-category">
                        </div>
                         <img src="<?php echo $imgUrl;?>" id="preview1" class="img-thumbnail img-preview">
                    </div>

                   
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function deleteForumCategoryImage(categoryId) {
    var data = {
        'category_id': categoryId
    };
    $.ajax({
        type: 'POST',
        url: generateUrl('AdminForumCategory/deleteCategoryImagePost'),
        data: data,
        success: function (response) {
            $(".img-category").remove();
            $(".btn-delete-category-img").hide();
        }
    });
}
</script>