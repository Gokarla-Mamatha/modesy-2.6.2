<div class="row">
    <div class="col-sm-12 col-lg-5">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans('user_details')); ?></h3>
                </div>
            </div>
            <div class="box-body box-body-info">
                <div class="row">
                    <div class="col-sm-12 col-profile">
                        <img src="<?= getUserAvatar($user->avatar, $user->storage_avatar); ?>" alt="avatar" class="thumbnail img-responsive img-update" style="max-width: 200px;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("role")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <?php $role = getRoleById($user->role_id);
                        if (!empty($role)): ?>
                            <label class="label label-success"><?= esc(getRoleName($role)); ?></label>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans('shop_name')); ?>&nbsp;(<?= esc(trans("username")); ?>)</strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc(getUsername($user)); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans('first_name')); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc($user->first_name); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans('last_name')); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc($user->last_name); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans('slug')); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc($user->slug); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("email")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc($user->email); ?></strong>
                        <?php if ($user->email_status == 1): ?>
                            <small class="text-success">(<?= esc(trans("confirmed")); ?>)</small>
                        <?php else: ?>
                            <small class="text-danger">(<?= esc(trans("unconfirmed")); ?>)</small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("phone_number")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc($user->phone_number); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("membership_plan")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600">
                            <?php $membershipModel = new \App\Models\MembershipModel();
                            $membershipPlan = $membershipModel->getUserPlanByUserId($user->id, false);
                            echo !empty($membershipPlan) ? esc($membershipPlan->plan_title) : ''; ?>
                        </strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("location")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc(getLocation($user)); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("sales")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= $user->number_of_sales; ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("balance")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= priceFormatted($user->balance, $paymentSettings->default_currency); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("commission_debt")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= priceFormatted($user->commission_debt, $paymentSettings->default_currency); ?></strong>
                    </div>
                </div>
                <?php $socialArray = getSocialLinksArray($user);
                foreach ($socialArray as $item):?>
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <strong><?= esc(trans($item['inputName'])); ?></strong>
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <strong class="font-600"><?= esc($item['value']); ?></strong>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("last_seen")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= !empty($user->last_seen) ? timeAgo($user->last_seen) : ''; ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("banned")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= $user->banned == 1 ? trans("yes") : trans("no"); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("affiliate_program")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= $user->is_affiliate == 1 ? trans("yes") : trans("no"); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("description")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc($user->about_me); ?></strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong><?= esc(trans("member_since")); ?></strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <strong class="font-600"><?= esc(formatDate($user->created_at)); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-7">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= esc(trans("user_login_activities")); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row table-filter-container">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-default filter-toggle collapsed m-b-10" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false">
                                    <i class="fa fa-filter"></i>&nbsp;&nbsp;<?= esc(trans("filter")); ?>
                                </button>
                                <div class="collapse navbar-collapse" id="collapseFilter">
                                    <form action="<?= adminUrl('user-details/'.$user->id); ?>" method="get">
                                        <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                            <label><?= esc(trans("show")); ?></label>
                                            <select name="show" class="form-control">
                                                <option value="15" <?= inputGet('show') == '15' ? 'selected' : ''; ?>>15</option>
                                                <option value="30" <?= inputGet('show') == '30' ? 'selected' : ''; ?>>30</option>
                                                <option value="60" <?= inputGet('show') == '60' ? 'selected' : ''; ?>>60</option>
                                                <option value="100" <?= inputGet('show') == '100' ? 'selected' : ''; ?>>100</option>
                                            </select>
                                        </div>
                                        <div class="item-table-filter">
                                            <label><?= esc(trans("search")); ?></label>
                                            <input name="q" class="form-control" placeholder="<?= esc(trans("search")); ?>" type="search" value="<?= esc(inputGet('q')); ?>">
                                        </div>
                                        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                            <label style="display: block">&nbsp;</label>
                                            <button type="submit" class="btn bg-purple"><?= esc(trans("filter")); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" role="grid">
                                <thead>
                                <tr role="row">
                                    <th><?= esc(trans('ip_address')); ?></th>
                                    <th><?= esc(trans('user_agent')); ?></th>
                                    <th><?= esc(trans('date')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($activities)):
                                    foreach ($activities as $item): ?>
                                        <tr>
                                            <td><?= esc($item->ip_address); ?></td>
                                            <td><?= esc($item->user_agent); ?></td>
                                            <td><?= formatDate($item->created_at); ?></td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                            <?php if (empty($activities)): ?>
                                <p class="text-center">
                                    <?= esc(trans("no_records_found")); ?>
                                </p>
                            <?php endif; ?>
                            <div class="col-sm-12 table-ft">
                                <div class="row">
                                    <div class="pull-right">
                                        <?= $pager->links; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($businessDetails)):
    $bd = $businessDetails;
    $acc = (string)($bd['account_number'] ?? '');
    // $accMasked = strlen($acc) > 4 ? str_repeat('*', strlen($acc) - 4) . substr($acc, -4) : $acc;
    $ein = (string)($bd['ein_registered'] ?? '');
    // $einMasked = strlen($ein) > 4 ? str_repeat('*', strlen($ein) - 4) . substr($ein, -4) : $ein;
    $bdStakeholders = json_decode($bd['stakeholders'] ?? '[]', true);
    $bdStakeholders = is_array($bdStakeholders) ? $bdStakeholders : [];
    $bdRow = function ($label, $value) {
        if ($value === null || $value === '') return;
        echo '<div class="row"><div class="col-sm-12 col-md-4"><strong>' . esc($label) . '</strong></div>'
            . '<div class="col-sm-12 col-md-8"><strong class="font-600">' . esc($value) . '</strong></div></div>';
    };
    $bdAddress = trim(($bd['address_line1'] ?? '') . ' ' . ($bd['address_line2'] ?? ''));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Business Details</h3>
                </div>
            </div>
            <div class="box-body box-body-info">
                <?php
                $bdRow('Business Type', $bd['business_type'] ?? '');
                $bdRow('Business Name', $user->business_name ?? '');
                $bdRow('Business Email', $user->business_email ?? '');
                $bdRow('First Name', $bd['legal_first_name'] ?? '');
                $bdRow('Middle Name', $bd['legal_middle_name'] ?? '');
                $bdRow('Last Name', $bd['legal_last_name'] ?? '');
                $bdRow('Legal Business Name', $bd['legal_business_name'] ?? '');
                $bdRow('Doing Business As', $bd['doing_business_as'] ?? '');
                $bdRow('EIN', $ein);
                $bdRow('Address', $bdAddress);
                $bdRow('City', $bdCity->name ?? '');
                $bdRow('State', $bdState->name ?? '');
                $bdRow('Country', $bdCountry->name ?? '');
                $bdRow('ZIP Code', $bd['zip'] ?? '');
                $bdRow('Contact Phone', $bd['contact_phone'] ?? '');
                $bdRow('Account Number', $acc);
                ?>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <strong>Stakeholders</strong>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <?php if (!empty($bdStakeholders)): ?>
                            <?php foreach ($bdStakeholders as $s): ?>
                                <div><strong class="font-600"><?= esc($s['name'] ?? '') ?></strong>
                                    <?php if (!empty($s['role'])): ?> &ndash; <?= esc($s['role']) ?><?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="font-600">&mdash;</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<style <?= csp_style_nonce() ?>>
    .box-body-info .row {
        padding-bottom: 10px;
        margin-bottom: 10px;
        border-bottom: 1px dashed #e4e4e4;
    }
</style>