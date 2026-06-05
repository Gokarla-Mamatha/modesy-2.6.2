<div class="modal-license-key-list">
    <div class="table-responsive">
        <?php if (!empty($licenseKeys)): ?>
            <table class="table table-striped table-custom-modal">
                <thead>
                <tr>
                    <th scope="col"><?= esc(trans("license_key")); ?></th>
                    <th scope="col"><?= esc(trans("used")); ?></th>
                    <th scope="col"><?= esc(trans("options")); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($licenseKeys)):
                    foreach ($licenseKeys as $licenseKey): ?>
                        <tr id="tr_license_key_<?= $licenseKey->id; ?>">
                            <td><?= esc($licenseKey->license_key); ?></td>
                            <td style="width: 50px;">
                                <?php if ($licenseKey->is_used == 1):
                                    echo trans("yes");
                                else:
                                    echo trans("no");
                                endif; ?>
                            </td>
                            <td style="width: 80px;">
                                <a href="javascript:void(0)" class="btn btn-xs btn-danger js-delete-license-key" data-license-key-id="<?= esc($licenseKey->id, 'attr'); ?>" data-product-id="<?= esc($product->id, 'attr'); ?>"><?= esc(trans("delete")); ?></a>
                            </td>
                        </tr>
                    <?php endforeach;
                endif; ?>
                </tbody>
            </table>
        <?php endif;
        if (empty($licenseKeys)): ?>
            <p class="text-center">
                <?= esc(trans("no_records_found")); ?>
            </p>
        <?php endif; ?>
    </div>
</div>
