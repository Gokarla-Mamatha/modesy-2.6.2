<?php
$redeemedRows = [];

if (!empty($loyaltyTransactions)) {
    foreach ($loyaltyTransactions as $row) {
        if ($row->type === 'redeem') {
            $redeemedRows[] = $row;
        }
    }
}
?>

<div class="wallet-container wallet-container-table">
    <div class="table-responsive table-custom">
        <table class="table table-bordered text-center align-middle">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Activity</th>
                    <th class="text-center">Order Id</th>
                    <th class="text-center">Points Used</th>
                    <th class="text-center">Date</th>
                </tr>
            </thead>
            <tbody>

            <?php if (!empty($redeemedRows)): ?>
                <?php foreach ($redeemedRows as $row): ?>
                    <tr>
                        <td><?= ($row->source ?? '') === 'referral' ? 'Referral': (($row->source ?? '') === 'order' ? 'Order' : '—'); ?></td>
                        <td><?= $row->order_id ? '#' . esc($row->order_id) : '—'; ?></td>
                        <td>
                            <span class="text-danger font-weight-bold">-<?= esc($row->points); ?></span>
                        </td>
                        <td class="no-wrap"><?= formatDate($row->updated_at ?? $row->created_at); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted"> No redeem history found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center m-t-30">
            <?= $pager->links; ?>
        </div>
    </div>
</div>
