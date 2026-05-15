<div class="container mt-5 mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h3 class="mb-4">📝 Start a New Discussion</h3>

            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?= implode('<br>', session()->getFlashdata('errors')); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('forum/submit-thread'); ?>" method="post" enctype="multipart/form-data">
             <?= csrf_field(); ?>
              <?php if (session('error')): ?>
                    <div class="alert alert-danger">
                        <?= session('error') ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?= old('title'); ?>" data-type="title" data-type="title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id']; ?>" 
                                    <?= $category->id == $cat['id'] ? 'selected' : ''; ?>>
                                    <?= esc($cat['name']); ?>
                                </option> 
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="editor" rows="6" class="form-control" data-type="text" required><?= old('content'); ?></textarea>
                </div>
                <div class="mt-2">
                    <label>Thread Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    <small class="text-muted">Only JPG, PNG, WEBP allowed</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tags</label>
                    <input type="text" name="tags" class="form-control">
                    <small class="text-muted">Add multiple tags separated by commas.</small>
                </div>

               
                <?= view('partials/_cf_turnstile'); ?>
                <button class="btn btn-custom">Create Thread</button>
            </form>
        </div>
    </div>
</div>
