<div class="container mt-4 mb-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-white p-2 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="<?= base_url('forum'); ?>">Forum Home</a></li>
            <li class="breadcrumb-item active"><?= esc($category['name']); ?></li>
        </ol>
    </nav>

    <div class="row">

        <!-- LEFT SIDEBAR — Categories -->
        <div class="col-md-3 mb-4"> 
            <div class="card-header bg-light font-weight-bold">📂 Categories</div>
                <ul class="list-group list-group-flush">
                    <?php foreach($categories as $cat): ?>
                        <li class="list-group-item <?= $cat['id'] == $category['id']  ? 'active' : ''; ?>">
                            <a href="<?= base_url('forum/category/'.$cat['slug']); ?>" class="<?= $cat['id']== $category['id'] ? 'text-white':'text-dark'; ?>">
                                <?= esc($cat['name']); ?>
                                <span class="badge badge-secondary float-right"><?= $cat['thread_count']; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul> 
        </div>

        <!-- RIGHT — Threads Table -->
        <div class="col-md-9">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0"><?= esc($category['name']); ?></h3>
                <?php if (authCheck()): ?>
                    <a href="<?= base_url('forum/create-thread/'.$category['slug']); ?>" 
                       class="btn btn-custom">
                        <i class="icon-file-text"></i> Create New Thread
                    </a>
                <?php endif; ?>
            </div>

            <!-- Category Description -->
            <p class="text-muted"><?= esc($category['description']); ?></p>

            <!-- Thread List -->
            <?php if (!empty($threads)): ?>
                <div class="table-responsive">
                    <table class="table table-hover forum-thread-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Thread Title</th>
                                <th>Replies</th>
                                <th>Views</th>
                                <th>Started By</th>
                                <th>Last Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($threads as $thread): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($thread['thumbnail'])): ?>
                                    <img src="<?= base_url($thread['thumbnail']); ?>"
                                        style="width:70px;height:70px;object-fit:cover;border-radius:8px; margin-right:15px;">
                                    <?php else: ?>
                                    <img src="<?= base_url('uploads/default-thread.png'); ?>"
                                        style="width:70px;height:70px;object-fit:cover;border-radius:8px;margin-right:15px;">
                                    <?php endif; ?>
                                    <?php if ($thread['is_pinned']): ?>
                                        <span class="badge bg-warning text-dark">📌 Pinned</span>
                                    <?php endif; ?>
                                    <a href="<?= base_url('forum/thread/'.$thread['slug']); ?>" class="fw-bold">
                                        <?= esc($thread['title']); ?>
                                    </a>
                                    <div class="text-muted small">
                                        <?= character_limiter(strip_tags($thread['content']), 90); ?>
                                    </div>
                                </td>
                                <td>💬 <?= esc($thread['replies_count']); ?></td>
                                <td>👁 <?= esc($thread['views_count']); ?></td>
                                <td>
                                    <a href="<?= base_url('profile/'.$thread['user_slug']); ?>">
                                        <?= esc($thread['username']); ?>
                                    </a>
                                </td>
                                <td><?= timeAgo($thread['updated_at'] ?? $thread['created_at']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    <?= $pager->links(); ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">No threads in this category yet.</div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style <?= csp_style_nonce() ?>>
.forum-thread-table tr:hover {
    background-color: #f8f9fa;
}
.list-group-item.active {
    background-color: #e76528 !important;
    border-color: #e76528 !important;
}
.btn-custom {
    background: var(--mds-color-main);
    color: #fff;
}
.forum-thread-table img {
    max-height: 70px !important;
    object-fit: cover !important;
    border-radius: 8px !important;
    margin-right: 15px !important;
}
</style>
