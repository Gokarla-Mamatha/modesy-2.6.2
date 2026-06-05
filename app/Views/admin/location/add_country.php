<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans("add_country")); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('countries'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('countries')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('Admin/addCountryPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= esc(trans("name")); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= esc(trans("name")); ?>" maxlength="200" data-type="name" required>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("continent")); ?></label>
                        <select name="continent_code" class="form-control">
                            <?php $continents = getAppDefault('continents');
                            if (!empty($continents)):
                                foreach ($continents as $key => $value):?>
                                    <option value="<?= $key; ?>"><?= $value; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("status")); ?></label>
                        <?= formRadio('status', 1, 0, trans("active"), trans("inactive"), 1); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_country')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>