<?php $commonModel = new \App\Models\CommonModel(); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th><?= esc(trans("id")); ?></th>
                            <th><?= esc(trans("reported_content")); ?></th>
                            <th><?= esc(trans("sent_by")); ?></th>
                            <th><?= esc(trans("description")); ?></th>
                            <th><?= esc(trans("date")); ?></th>
                            <th class="max-width-120"><?= esc(trans("options")); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($abuseReports)):
                            foreach ($abuseReports as $item): ?>
                                <tr>
                                    <td><?= $item->id; ?></td>
                                    <?php if ($item->item_type == 'product'):
                                        $product = getProduct($item->item_id); ?>
                                        <td><?= esc(trans("product")); ?></td>
                                        <td><?php $user = getUser($item->report_user_id);
                                            if (!empty($user)):?>
                                                <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="link-black font-600"><?= esc(getUsername($user)); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width: 50%"><?= esc($item->description); ?></td>
                                        <td><?= formatDate($item->created_at); ?></td>
                                        <td style="width: 130px;">
                                            <div class="btn-group btn-group-option">
                                                <a href="<?= !empty($product) ? generateProductUrl($product) : ''; ?>" class="btn btn-sm btn-default btn-edit" target="_blank"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?= esc(trans("view_content")); ?></a>
                                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="deleteItem('Admin/deleteAbuseReportPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                <a href="#" class="btn-item-delete" data-url="Admin/deleteAbuseReportPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                <i class="fa fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    <?php elseif ($item->item_type == "seller"):
                                        $seller = getUser($item->item_id); ?>
                                        <td><?= esc(trans("seller")); ?></td>
                                        <td><?php $user = getUser($item->report_user_id);
                                            if (!empty($user)):?>
                                                <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="link-black font-600"><?= esc(getUsername($user)); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width: 50%"><?= esc($item->description); ?></td>
                                        <td><?= formatDate($item->created_at); ?></td>
                                        <td style="width: 130px;">
                                            <div class="btn-group btn-group-option">
                                                <a href="<?= !empty($seller) ? generateProfileUrl($seller->slug) : ''; ?>" class="btn btn-sm btn-default btn-edit" target="_blank"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?= esc(trans("view_content")); ?></a>
                                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="deleteItem('Admin/deleteAbuseReportPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                <a href="#" class="btn-item-delete" data-url="Admin/deleteAbuseReportPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                <i class="fa fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    <?php elseif ($item->item_type == "review"):
                                        $review = $commonModel->getReviewById($item->item_id); ?>
                                        <td><?= esc(trans("review")); ?></td>
                                        <td><?php $user = getUser($item->report_user_id);
                                            if (!empty($user)):?>
                                                <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="link-black font-600"><?= esc(getUsername($user)); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width: 50%"><?= esc($item->description); ?></td>
                                        <td><?= formatDate($item->created_at); ?></td>
                                        <td style="width: 130px;">
                                            <div class="btn-group btn-group-option">
                                                <?php if (!empty($review)): ?>
                                                    <a href="#" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalAbuse<?= $item->id; ?>"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?= esc(trans("view_content")); ?></a>
                                                    <div id="modalAbuse<?= $item->id; ?>" class="modal fade" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title"><?= esc(trans("review")); ?></h4>
                                                                </div>
                                                                <div class="modal-body" style="white-space: normal !important;">
                                                                    <?php $user = getUser($review->user_id);
                                                                    if (!empty($user)):?>
                                                                        <p><strong><?= esc(trans("user")); ?></strong>:&nbsp;<a href="<?= generateProfileUrl($user->slug) ?>" target="_blank"><?= esc(getUsername($user)); ?></a></p>
                                                                    <?php endif; ?>
                                                                    <p><?= esc($review->review); ?></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <!-- <a href="javascript:void(0)" class="btn btn-danger pull-right" onclick="deleteItem('Product/deleteReviewPost','<?= $review->id; ?>','<?= esc(trans("confirm_review", true)); ?>');"> -->
                                                                    <a href="#" class="btn-item-delete" data-url="Product/deleteReviewPost" data-id="<?= $review->id; ?>" data-msg="<?= esc(trans('confirm_review', true)); ?>">
                                                                    <?= esc(trans('delete')); ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="deleteItem('Admin/deleteAbuseReportPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete", true)); ?>');"> -->
                                                <a href="#" class="btn-item-delete" data-url="Admin/deleteAbuseReportPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                <i class="fa fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    <?php elseif ($item->item_type == "comment"):
                                        $comment = $commonModel->getComment($item->item_id); ?>
                                        <td><?= esc(trans("comment")); ?></td>
                                        <td><?php $user = getUser($item->report_user_id);
                                            if (!empty($user)):?>
                                                <a href="<?= generateProfileUrl($user->slug); ?>" target="_blank" class="link-black font-600"><?= esc(getUsername($user)); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width: 50%"><?= esc($item->description); ?></td>
                                        <td><?= formatDate($item->created_at); ?></td>
                                        <td style="width: 130px;">
                                            <div class="btn-group btn-group-option">
                                                <?php if (!empty($comment)): ?>
                                                    <a href="#" class="btn btn-sm btn-default btn-edit" data-toggle="modal" data-target="#modalAbuse<?= $item->id; ?>"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?= esc(trans("view_content")); ?></a>
                                                    <div id="modalAbuse<?= $item->id; ?>" class="modal fade" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title"><?= esc(trans("comment")); ?></h4>
                                                                </div>
                                                                <div class="modal-body" style="white-space: normal !important;">
                                                                    <?php $user = getUser($comment->user_id);
                                                                    if (!empty($user)):?>
                                                                        <p><strong><?= esc(trans("user")); ?></strong>:&nbsp;<a href="<?= generateProfileUrl($user->slug) ?>" target="_blank"><?= esc(getUsername($user)); ?></a></p>
                                                                    <?php endif; ?>
                                                                    <p><?= esc($comment->comment); ?></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <!-- <a href="javascript:void(0)" class="btn btn-danger pull-right" onclick="deleteItem('Product/deleteCommentPost','<?= $comment->id; ?>','<?= esc(trans("confirm_comment", true)); ?>');"> -->
                                                                    <a href="#" class="btn-item-delete" data-url="Product/deleteCommentPost" data-id="<?= $comment->id; ?>" data-msg="<?= esc(trans('confirm_comment', true)); ?>">
                                                                    <?= esc(trans('delete')); ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default btn-delete" onclick="deleteItem('Admin/deleteAbuseReportPost','<?= $item->id; ?>','<?= esc(trans("confirm_delete")); ?>');"> -->
                                                <a href="#" class="btn-item-delete" data-url="Admin/deleteAbuseReportPost" data-id="<?= $item->id; ?>" data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                                <i class="fa fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($abuseReports)): ?>
                        <p class="text-center">
                            <?= esc(trans("no_records_found")); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12">
                <?php if (!empty($abuseReports)): ?>
                    <div class="number-of-entries">
                        <span><?= esc(trans("number_of_entries")); ?>:</span>&nbsp;&nbsp;<strong><?= $numRows; ?></strong>
                    </div>
                <?php endif; ?>
                <div class="pull-right">
                    <?= $pager->links; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style <?= csp_style_nonce() ?>>
    .swal-overlay {
        z-index: 999999999 !important;
    }
</style>