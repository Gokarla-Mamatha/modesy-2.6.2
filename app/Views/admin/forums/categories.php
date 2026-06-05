<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= esc(trans('categories')); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('add-forums-category'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= esc(trans('add_category')); ?>
            </a>
             
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <form action="<?= adminUrl('forums-categories'); ?>" method="get">
                    <div class="item-table-filter" style="width: 220px;">
                        <label><?= esc(trans("search")); ?></label>
                        <input name="q" class="form-control" placeholder="<?= esc(trans("search")) ?>" type="search" value="<?= esc(inputGet('q', true)); ?>">
                    </div>
                    <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                        <label style="display: block">&nbsp;</label>
                        <button type="submit" class="btn bg-purple" style="height: 36px;"><?= esc(trans("filter")); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="categories-panel-group nested-sortable">
                    <?= view('admin/forums/_load_categories', ['categories' => $categories]); ?>
                </div>
            </div>
            
        </div>
    </div>
</div>
 
<script <?= csp_script_nonce() ?>>
    $(document).on("click", ".panel .panel-heading-parent", function (e) {
        if ($(e.target).is('div') || $(e.target).is('span') || $(e.target).is('.fa-caret-right') || $(e.target).is('.fa-caret-down')) {
            var id = $(this).attr('data-item-id');
            $('#collapse_' + id).collapse("toggle");
            $('.left .fa', this).toggleClass('fa-caret-right').toggleClass('fa-caret-down');
        }
    });
    $(document).on("click", ".panel .panel-heading .btn-delete", function (e) {
        var id = $(this).attr('data-item-id');
        deleteItem("AdminForumCategory/deleteCategoryPost", id, "<?= esc(trans("confirm_delete", true));?>");
    });
 
</script>

<style <?= csp_style_nonce() ?>>
    .btn-group-option {
        display: inline-block !important;
    }

    .spinner {
        visibility: hidden;
    }

    .spinner > div {
        width: 16px;
        height: 16px;
        background-color: #999;
    }

    .cursor-default {
        cursor: default !important;
    }
</style>
