<?= view('dashboard/includes/_header', $data) ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">Threads</h3>
        </div>
    </div>

    <div class="box-body">
         <!-- Search Bar -->
        <div class="row">
            <div class="col-sm-12">
                <form action="<?= base_url('dashboard/threads'); ?>" method="get">
                    <div class="item-table-filter" style="width: 220px;">
                        <label>Search</label>
                        <input name="q" class="form-control" placeholder="Search Threads"
                               type="search" value="<?= esc(inputGet('q', true)); ?>">
                    </div>
                    <!-- Filter by Category -->
                    <div class="item-table-filter" style="width: 180px;">
                        <label>Category</label>
                        <select name="category" class="form-control">
                            <option value="">All</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id']; ?>"
                                    <?= inputGet('category') == $cat['id'] ? 'selected' : ''; ?>>
                                    <?= esc($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                      <!-- Filter by Status -->
                    <div class="item-table-filter" style="width: 150px;">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All</option>
                            <option value="approved" <?= inputGet('status') === 'approved' ? 'selected' : ''; ?>>Approved</option>
                            <option value="pending"  <?= inputGet('status') === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="rejected" <?= inputGet('status') === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>


                    <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                        <label style="display: block">&nbsp;</label>
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
                            <th>Replies</th>
                            <th>Status</th>
                            <th style="width:140px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($threads)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($threads as $t): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td>
                                        <img src="<?= !empty($t['thumbnail']) ? base_url($t['thumbnail']) : base_url('uploads/default-thread.png'); ?>"
                                             width="50" height="50" style="object-fit:cover;border-radius:4px;">
                                    </td>
                                    <td><?= esc($t['title']); ?></td>
                                    <td><?= esc($t['category_name']); ?></td>
                                    <td><?= esc($t['replies_count']); ?></td>
                                    <td><span class="label label-success"><?= esc($t['status']); ?></span></td>
                                    <td>
                                        <a href="<?= base_url('dashboard/edit-thread/'.$t['id']); ?>" 
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <a href="<?= base_url('dashboard/delete-thread/'.$t['id']); ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Delete this thread?')">
                                           <i class="fa fa-trash"></i>
                                        </a>
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

<?= view('dashboard/includes/_footer') ?>
