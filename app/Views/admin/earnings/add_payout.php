<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans('add_payout')); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('payout-requests'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?= esc(trans('payout_requests')); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('Earnings/addPayoutPost'); ?>" method="post" class="validate_price">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div id="select2-users-container" class="form-group">
                        <label><?= esc(trans("user")); ?></label>
                        <select name="user_id" class="form-control select2-users" required></select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("withdraw_method")); ?></label>
                        <select name="payout_method" class="form-control select2" required>
                            <option value="" selected><?= esc(trans("select")); ?></option>
                            <option value="paypal"><?= esc(trans("paypal")); ?></option>
                            <option value="bitcoin"><?= esc(trans("bitcoin")); ?></option>
                            <option value="iban"><?= esc(trans("iban")); ?></option>
                            <option value="swift"><?= esc(trans("swift")); ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("withdraw_amount")); ?></label>
                        <?= renderPriceInput('amount', null, ['required' => true]); ?>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("status")); ?></label>
                        <select name="status" class="form-control select2" required>
                            <option value="" selected><?= esc(trans("select")); ?></option>
                            <option value="0"><?= esc(trans("pending")); ?></option>
                            <option value="1"><?= esc(trans("completed")); ?></option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('add_payout')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>