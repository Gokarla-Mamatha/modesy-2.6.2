<?php
$userPoints     = (int) ($userLoyaltyPoints ?? 0);
$requiredPoints = (int) ($settings->loyalty_convert_points ?? 0);
?>

<div class="text-center mb-3">
<?php if ($requiredPoints > 0 && $userPoints >= $requiredPoints): ?>
<button
    class="btn btn-sm px-4"
    style="background-color:#e76528;color:#fff;border:none;"
    data-toggle="modal"
    data-target="#convertPointsModal">
    Convert to Wallet
</button>
<?php else: ?>
<button class="btn btn-secondary btn-sm px-4" disabled>
    Not enough points
</button>
<?php endif; ?>
</div>

<div class="wallet-container wallet-container-table">
    <div class="text-center mb-4" style="font-size:22px;font-weight:600;">
        <?= $userPoints; ?> Points Available
    </div>

    <div class="table-responsive table-custom">
        <table class="table table-bordered text-center align-middle">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Activity</th>
                    <th class="text-center">Order Id</th>
                    <th class="text-center">Points</th>
                    <th class="text-center">Balance</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Date</th>
                </tr>
            </thead>
           <tbody>
            <?php if (!empty($loyaltyTransactions)): ?>
                <?php foreach ($loyaltyTransactions as $row): ?>
                    <?php if ($row->type !== 'earned') continue; ?>
                    <tr>
                        <td>
                            <?= ($row->source ?? '') === 'referral'? 'Referral': (($row->source ?? '') === 'order' ? 'Order' : '—'); ?>
                        </td>
                        <td><?= $row->order_id ? '#' . esc($row->order_id) : '—'; ?></td>
                        <td> <span class="text-success font-weight-bold">+<?= esc($row->points); ?> </span></td>
                        <td><?= esc($row->balance ?? 0); ?></td>
                        <td> <span class="badge badge-success px-3">Earned</span></td>
                        <td class="no-wrap"><?= formatDate($row->created_at); ?> </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted"> No records found </td>
                </tr>
            <?php endif; ?>
           </tbody>
        </table>
        <div class="d-flex justify-content-center m-t-30">
                <?= $pager->links; ?>
        </div>
    </div>
</div>
<div class="modal fade" id="convertPointsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Convert Loyalty Points</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <p><strong>Available Points:</strong> <?= $userPoints; ?></p>
                <p class="text-muted">
                    Minimum conversion: <?= $requiredPoints; ?> points
                </p>

                <div class="form-group">
                    <label>Points to Convert</label>
                    <input type="number"
                           id="convertPoints"
                           class="form-control"
                           min="<?= $requiredPoints; ?>"
                           max="<?= $userPoints; ?>"
                           placeholder="Enter points">
                </div>
                <div id="convertError" class="text-danger small d-none"></div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success btn-sm" onclick="convertPoints()">Convert</button>
            </div>

        </div>
    </div>
</div>

       
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" <?= csp_script_nonce() ?>></script>
<script <?= csp_script_nonce() ?>>
    let csrfName  = "<?= csrf_token(); ?>";
    let csrfHash  = "<?= csrf_hash(); ?>";
    let maxPoints = <?= $userPoints ?>;
    let minPoints = <?= $requiredPoints ?>;
    let ratio     = 1; 

    document.getElementById('convertPoints').addEventListener('input', function () {
        let points = parseInt(this.value) || 0;
        document.getElementById('walletAmount').innerText = points * ratio;
    });

    function convertPoints() {
        let points = parseInt(document.getElementById('convertPoints').value);
        let error  = document.getElementById('convertError');

        error.classList.add('d-none');

        if (!points || points < minPoints) {
            error.innerText = 'Minimum ' + minPoints + ' points required';
            error.classList.remove('d-none');
            return;
        }

        if (points > maxPoints) {
            error.innerText = 'Not enough points';
            error.classList.remove('d-none');
            return;
        }

        const fd = new FormData();
        fd.append('points', points);
        fd.append(csrfName, csrfHash);

        fetch("<?= langBaseUrl('ajax/loyalty/convert'); ?>", {
            method: "POST",
            headers: { "X-Requested-With": "XMLHttpRequest" },
            body: fd
        })
        .then(res => res.json())
        .then(res => {
            csrfHash = res.csrfHash;

            if (res.status === 'success') {
                location.reload();
            } else {
                error.innerText = res.message;
                error.classList.remove('d-none');
            }
        })
        .catch(() => {
            error.innerText = 'Conversion failed';
            error.classList.remove('d-none');
        });
    }
</script>