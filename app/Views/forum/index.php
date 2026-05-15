<div class="container mt-4 mb-5">
    <div class="container mt-4 mb-5">
    <div class="text-center mb-5">
        <h1 class="title" style="font-weight:700;">💬 Community Forum</h1>
        <p class="text-muted">Ask questions, share experiences, and connect with buyers & sellers.</p>
    </div>
    <div class="input-group mb-3">
        <input type="text" id="forumSearch" class="form-control"placeholder="Search threads, categories,tags">
        <button id="forumSearchBtn" class="btn btn-custom">Search Threads</button>
    </div>
    <div id="forumSearchResults" class="mb-4" style="display:none;"></div>
    <div class="row" id="forumCategoryGrid">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card forum-category-card shadow-sm border-0 h-100">
                        <div class="card-body">

                            <!-- Category Icon -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="category-icon">
                                  <img src="<?= $category['thumbnail'];?>"  />
                                </div>
                                <h5 class="ml-3 mb-0">
                                    <a href="<?= base_url('forum/category/' . $category['slug']); ?>" 
                                       class="text-dark" style="text-decoration:none;font-weight:600;">
                                        <?= esc($category['name']); ?>
                                    </a>
                                </h5>
                            </div>

                            <!-- Description -->
                            <p class="text-muted small mb-3">
                                <?= esc($category['description'] ?? 'No description available.'); ?>
                            </p>

                            <!-- Button -->
                            <a href="<?= base_url('forum/category/' . $category['slug']); ?>" 
                               class="btn btn-sm btn-custom btn-block">
                                View Threads →
                            </a>
                        </div>

                        <div class="card-footer bg-light text-muted small d-flex justify-content-between">
                            <span><i class="icon-layers"></i> <?= esc($category['thread_count'] ?? 0); ?> Threads</span>
                            <span><i class="icon-user"></i> Active Now</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-warning">No categories found.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" <?= csp_script_nonce() ?>></script>

<script <?= csp_script_nonce() ?>>
$('#forumSearchBtn').on('click', function () {
    let q = $('#forumSearch').val().trim();
    if (q.length < 1) {
        alert('Please enter something to search');
        return;
    }
    $.get("<?= base_url('forum/forum-search') ?>", { q: q }, function (res) {
        let html = '';
        /* ✅ CATEGORIES */
        if (res.categories.length > 0) {
            html += `<h5 class="mb-2">Categories</h5>`;

            res.categories.forEach(cat => {
                html += `
                <div class="card mb-2 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url() ?>/${cat.thumbnail}"
                                 style="width:50px;height:50px;border-radius:50%;object-fit:cover;margin-right:10px;">
                            <strong>${cat.name}</strong>
                        </div>
                        <a href="<?= base_url('forum/category/') ?>${cat.slug}" 
                           class="btn btn-sm btn-custom">
                            View Threads →
                        </a>
                    </div>
                </div>`;
            });
        }
        /* ✅ THREADS */
        if (res.threads.length > 0) {
            html += `<h5 class="mt-3 mb-2">Threads</h5>`;
            res.threads.forEach(thread => {
                html += `
                <div class="card mb-2 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <img src="<?= base_url() ?>/${thread.thumbnail ?? 'uploads/default-thread.png'}"
                             style="width:50px;height:50px;border-radius:50%;object-fit:cover;margin-right:10px;">
                        <div>
                            <a href="<?= base_url('forum/thread/') ?>${thread.slug}">
                                <strong>${thread.title}</strong>
                            </a>
                            <div class="small text-muted">
                                Category: ${thread.category_name} | By: ${thread.username}
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        }
        /* ✅ NO RESULTS */
        if (res.categories.length === 0 && res.threads.length === 0) {
            html = `<div class="alert alert-warning">No results found</div>`;
        }
        $('#forumSearchResults').html(html).show();
        $('#forumCategoryGrid').hide();
    });
});
</script>

<script <?= csp_script_nonce() ?>>
$('#forumSearch').on('keyup', function () {
    if ($(this).val().trim() === '') {
        $('#forumSearchResults').hide().html('');
        $('#forumCategoryGrid').show();
    }
});
</script>

<style <?= csp_style_nonce() ?>>
.forum-category-card {
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
}
.forum-category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}
.category-icon {
    width: 55px;
    height: 55px;
    min-width: 55px;
    min-height: 55px;
    border-radius: 50%;
    overflow: hidden;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.08);
    transition: 0.25s ease-in-out;
    padding:10px;
}

.category-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;      /* Ensures image fits perfectly */
    border-radius: 50%;
}

.forum-category-card:hover .category-icon {
    transform: scale(1.08);
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
}
.btn-custom {
    background:var(--mds-color-main) !important; 
    color: #fff;
    border-radius: 4px;
}
.btn-custom:hover {
    background:var(--mds-color-main) !important;
    color: #fff;
}
.card-footer i {
    font-size: 14px;
}
</style>
