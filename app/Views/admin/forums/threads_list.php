<?= view('admin/includes/_header') ?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">Forum Threads</h3>
        </div>
    </div>

    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
            <form action="<?= adminUrl('forums-threads'); ?>" method="get" class="d-flex flex-wrap align-items-end gap-2">

                <!-- Search -->
                <div class="item-table-filter" style="width:200px;">
                    <label for="q">Search</label>
                    <input
                        id="q"
                        name="q"
                        class="form-control"
                        type="search"
                        placeholder="Search Threads"
                        value="<?= esc(inputGet('q')); ?>">
                </div>

                <!-- Category -->
                <div class="item-table-filter" style="width:180px;">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="form-control">
                        <option value="">All</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id']; ?>"
                                <?= inputGet('category') == $cat['id'] ? 'selected' : ''; ?>>
                                <?= esc($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Created By -->
                <div class="item-table-filter" style="width:180px;">
                    <label for="user_id">Created By</label>
                    <select id="user_id" name="user_id" class="form-control">
                        <option value="">All</option>
                        <?php foreach ($users as $u): ?>
                            <option value="<?= $u['id']; ?>"
                                <?= inputGet('user_id') == $u['id'] ? 'selected' : ''; ?>>
                                <?= esc($u['username']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status -->
                <div class="item-table-filter" style="width:150px;">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">All</option>
                        <option value="approved" <?= inputGet('status') === 'approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="pending" <?= inputGet('status') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="rejected" <?= inputGet('status') === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="item-table-filter md-top-10" style="width: 65px;">
                    <label style="display:block">&nbsp;</label>
                    <button type="submit" class="btn bg-purple" style="height: 36px;">
                        Filter
                    </button>
                </div>


            </form>
        </div>
    </div>


        <!-- Threads Table -->
        <div class="row">
            <div class="col-sm-12">

                <table class="table table-bordered table-striped" style="margin-top:20px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th>Replies</th>
                            <th style="width:140px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($threads)): ?>
                            <?php foreach ($threads as $t): ?>
                                <tr>
                                    <td><?= $t['id']; ?></td>
                                    <td>
                                        <img src="<?= !empty($t['thumbnail']) ? base_url($t['thumbnail']) : base_url('uploads/default-thread.png'); ?>"
                                             width="50" height="50" style="object-fit:cover;border-radius:4px;">
                                    </td>
                                    <td><?= esc($t['title']); ?></td>
                                    <td><?= esc($t['category_name']); ?></td>
                                    <td><?= esc($t['username']); ?></td>
                                    <td>
                                        <span class="label label-success"><?= esc($t['status']); ?></span>
                                    </td>
                                    <td><?= esc($t['replies_count']); ?></td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a href="<?= adminUrl('invite-thread-users/'.$t['id']); ?>"class="btn btn-info btn-xs"> Invite </a>
                                            <a href="<?= adminUrl('edit-thread/'.$t['id']); ?>" class="btn btn-warning btn-xs"> Edit </a>
                                            <!-- <a href="<?= adminUrl('delete-thread/'.$t['id']); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Delete this thread?')" title="Delete"> <i class="fa fa-trash"></i> </a> -->
                                            <a href="<?= adminUrl('delete-thread/'.$t['id']); ?>" class="btn btn-danger btn-xs btn-confirm-delete-thread" data-msg="Delete this thread?" title="Delete"> <i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">
                                    No threads found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<?= view('admin/includes/_footer') ?>

