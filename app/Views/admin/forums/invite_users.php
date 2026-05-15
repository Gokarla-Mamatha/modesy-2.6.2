<?= view('admin/includes/_header'); ?>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">
            Invite Members – <?= esc($thread['title']); ?>
        </h3>
    </div>
    <div class="box-body">
        <form method="post" action="<?= adminUrl('invite-thread-users-post'); ?>">
            <?= csrf_field(); ?>
            <input type="hidden" name="thread_id" value="<?= $thread['id']; ?>">
            <div class="row">
                <?php foreach ($users as $u): ?>
                    <div class="col-sm-3">
                        <label>
                            <input type="checkbox" name="users[]" value="<?= $u['id']; ?>" <?= in_array($u['id'], $invitedUsers) ? 'checked' : ''; ?>> <?= esc($u['username']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Save Invites</button>
            <a href="<?= adminUrl('forums-threads'); ?>" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>

<?= view('admin/includes/_footer'); ?>
