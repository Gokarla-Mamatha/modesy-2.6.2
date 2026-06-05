<div class="wallet-container wallet-container-table">
    <div class="table-responsive table-custom">
        <table class="table">
            <thead>
            <tr role="row">
                <th scope="col"><?= esc(trans("product")); ?></th>
                <th scope="col"><?= esc(trans("commission_rate")); ?></th>
                <th scope="col"><?= esc(trans("earned_amount")); ?></th>
                <th scope="col"><?= esc(trans("date")); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($earnings)): ?>
                <?php foreach ($earnings as $earning):
                    $product = getProduct($earning->product_id); ?>
                    <tr>
                        <td>
                            <?php if (!empty($product)): ?>
                                <a href="<?= generateProductUrl($product); ?>" class="a-hover-underline" target="_blank"><?= esc($product->title); ?></a>
                            <?php else: ?>
                                <?= esc(trans("product_id")); ?>:&nbsp;<?= $earning->product_id; ?>
                            <?php endif; ?>
                        </td>
                        <td><?= $earning->commission_rate . '%' ?></td>
                        <td><strong class="text-success"><?= priceFormatted($earning->earned_amount, $earning->currency); ?>&nbsp;(<?= $earning->currency; ?>)</strong></td>
                        <td><?= formatDate($earning->created_at); ?></td>
                    </tr>
                <?php endforeach;
            endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (empty($earnings)): ?>
        <p class="text-center m-t-15">
            <?= esc(trans("no_records_found")); ?>
        </p>
    <?php endif; ?>
    <div class="d-flex justify-content-center m-t-30">
        <?= $pager->links; ?>
    </div>
</div>