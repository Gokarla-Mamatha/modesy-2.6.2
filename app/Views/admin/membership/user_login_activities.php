<div class="row">
    <div class="col-sm-12">
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
                                    <form action="<?= adminUrl('user-login-activities'); ?>" method="get">
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
                                    <th><?= esc(trans("user")); ?></th>
                                    <th><?= esc(trans('activity')); ?></th>
                                    <th><?= esc(trans('updated_fields')); ?></th>
                                    <th><?= esc(trans('ip_address')); ?></th>
                                    <th><?= esc(trans('user_agent')); ?></th>
                                    <th><?= esc(trans('date')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($activities)):
                                    foreach ($activities as $item): ?>
                                        <tr>
                                            <td>
                                                <a href="<?= adminUrl('user-details/'.$item->user_id); ?>" target="_blank" class="table-link">
                                                    <?= esc($item->first_name) . ' ' . esc($item->last_name); ?>&nbsp;<?= !empty($item->username) ? '(' . $item->username . ')' : ''; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if (($item->activity_type ?? '') == 'profile_update'): ?>
                                                    <span class="label label-success">Profile Update</span>
                                                <?php else: ?>
                                                    <span class="label label-info">Login</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>

                                                <?php

                                                if (!empty($item->updated_fields ?? null)) {

                                                    $fields = json_decode($item->updated_fields);

                                                    if (!empty($fields)) {

                                                        echo implode(', ', $fields);
                                                    }
                                                } else {

                                                    echo '-';
                                                }

                                                ?>

                                            </td>

                                            <td><?= esc($item->ip_address); ?></td>

                                            <td style="max-width:400px;word-break:break-word;">
                                                <?= esc($item->user_agent); ?>
                                            </td>

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

<style <?= csp_style_nonce() ?>>
    .box-body-info .row {
        padding-bottom: 10px;
        margin-bottom: 10px;
        border-bottom: 1px dashed #e4e4e4;
    }
</style>