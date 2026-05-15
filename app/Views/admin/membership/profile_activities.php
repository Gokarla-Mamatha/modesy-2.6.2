<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Profile Activities
                </h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Updated Fields</th>
                            <th>IP Address</th>
                            <th>Browser</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($activities)):
                            foreach ($activities as $item): ?>
                                <tr>
                                    <td>
                                        <?= esc($item->first_name); ?>
                                        <?= esc($item->last_name); ?>
                                        (<?= esc($item->username); ?>)
                                    </td>
                                    <td>
                                        <?php
                                        $fields = json_decode($item->updated_fields);
                                        if (!empty($fields)) {
                                            echo implode(', ', $fields);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= esc($item->ip_address); ?>
                                    </td>
                                    <td style="max-width:400px;word-break:break-word;">
                                        <?= esc($item->browser); ?>
                                    </td>
                                    <td>
                                        <?= date('d M Y h:i A', strtotime($item->created_at)); ?>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>