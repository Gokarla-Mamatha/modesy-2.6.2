<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Edit Thread</h3>
    </div>

    <div class="box-body">
        <form action="<?= ($isAdmin ? adminUrl('edit-thread-post') : base_url('dashboard/edit-thread-post')); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" value="<?= $thread['id']; ?>">

            <!-- Thread Title -->
            <div class="form-group mb-3">
                <label class="font-weight-bold">Thread Title</label>
                <input type="text" name="title" value="<?= esc($thread['title']); ?>" class="form-control" data-type="title">
            </div>
            <!-- Thread content -->
            <div class="form-group mb-3">
                <label class="font-weight-bold">Thread Content</label>
                <input type="text" name="content" value="<?= esc($thread['content']); ?>" class="form-control" data-type="text">
            </div>

            <!-- Thread Status -->
            <div class="form-group mb-3">
                <label class="font-weight-bold">Thread Status</label>

                <?php if ($isAdmin): ?>
                    <select name="status" class="form-control">
                        <option value="approved" <?= $thread['status'] == 'approved' ? 'selected' : '' ?>>approved</option>
                        <option value="pending"  <?= $thread['status'] == 'pending'  ? 'selected' : '' ?>>pending</option>
                        <option value="rejected" <?= $thread['status'] == 'rejected' ? 'selected' : '' ?>>rejected</option>
                    </select>
                <?php else: ?>
                    <input type="text" class="form-control" value="<?= ucfirst($thread['status']); ?>" disabled>
                <?php endif; ?>
            </div>


            <!-- Lock Thread -->
            <div class="form-group mb-3">
                <label class="font-weight-bold">Thread Options</label>
                <div class="p-2 border rounded bg-light">
                    <label class="d-flex align-items-center">
                        <input type="checkbox" name="is_locked" <?= $thread['is_locked'] ? 'checked' : '' ?>>
                        <span class="ml-2">Lock Thread (Stop new replies)</span>
                    </label>
                </div>
            </div>

            <!-- Hide Replies -->
            <div class="form-group mb-4">
                <label class="font-weight-bold">Reply Visibility</label>
                <div class="p-2 border rounded bg-light">
                    <input type="hidden" name="hide_replies" value="0">

                    <label class="d-flex align-items-center">
                        <input type="checkbox" name="hide_replies" value="1"
                            <?= $thread['hide_replies'] == 1 ? 'checked' : '' ?>>
                        <span class="ml-2">Hide all replies</span>
                    </label>

                    <small class="text-muted">When checked, no one can see replies or reply to the thread.</small>
                </div>
            </div>

            <!-- Buttons -->
            <div class="form-group">
                <button class="btn btn-success">Save Changes</button>

                <?php if ($isAdmin): ?>
                    <a href="<?= adminUrl('forums-threads'); ?>" class="btn btn-danger">Cancel</a>
                <?php else: ?>
                    <a href="<?= base_url('dashboard/threads'); ?>" class="btn btn-danger">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
