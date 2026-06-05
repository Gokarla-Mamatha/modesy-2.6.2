<?= view('email/_header', ['title' => trans("contact_message")]); ?>
<?php $emailData = unserializeData($emailRow->email_data); ?>
<table role="presentation" class="main">
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?= esc(trans("contact_message")); ?></h1>
                        <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                            <p style='text-align: left'>
                                <?= esc(trans("name")); ?>:&nbsp;<?= !empty($emailData['messageName']) ? esc($emailData['messageName']) : ''; ?><br>
                                <?= esc(trans("email_address")); ?>:&nbsp;<?= !empty($emailData['messageEmail']) ? esc($emailData['messageEmail']) : ''; ?><br><br>
                                <?= !empty($emailData['messageText']) ? esc($emailData['messageText']) : ''; ?>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?= view('email/_footer'); ?>
