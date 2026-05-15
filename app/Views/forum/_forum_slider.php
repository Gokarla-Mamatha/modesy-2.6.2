<?php if (!empty($categories)): ?>
<div class="col-12 section">
    <div class="section-header">
        <h3 class="title">Community Forum</h3>
    </div>

    <div class="swiper swiper-carousel swiper-carousel-product" <?= $baseVars->rtl == true ? 'dir="rtl"' : ''; ?>>
        <div class="swiper-wrapper">

            <?php foreach ($categories as $category): ?>
                <div class="swiper-slide swiper-col-product-6">
                    <div class="card forum-category-card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                               <div class="category-icon">
                                  <img src="<?= $category['thumbnail'];?>"  />
                                </div>
                                <h5 class="category-title ml-3 mb-0">
                                    <a href="<?= base_url('forum/category/' . $category['slug']); ?>" 
                                       class="text-dark" style="text-decoration:none;font-weight:600;">
                                        <?= esc($category['name']); ?>
                                    </a>
                                </h5>
                            </div>
                            <p class="text-muted small mb-3">
                                <?= esc($category['description'] ?? 'No description available.'); ?>
                            </p>
                            <a href="<?= base_url('forum/category/' . $category['slug']); ?>" 
                               class="btn btn-sm btn-custom btn-block">
                                View Threads →
                            </a>
                        </div>

                        <div class="card-footer bg-light text-muted small d-flex justify-content-between">
                            <span>
                                <i class="icon-layers"></i> <?= esc($category['thread_count'] ?? 0); ?> Threads
                            </span>
                            <span><i class="icon-user"></i> Active</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>
<?php endif; ?>
<style <?= csp_style_nonce() ?>>
.forum-category-card:hover {
    box-shadow: 0 0 20px 10px rgba(0,0,0,.05);
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
.category-title a{
    font-size: .938rem;
    font-weight: 600;

}
 .forum-category-card .card-body {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .forum-category-card .btn-custom {
        margin-top: auto;
    }
@media (max-width: 576px) {

    .forum-category-card .d-flex {
        flex-direction: column;
        text-align: center;
    }

    .category-icon {
        margin-right: 0;
        margin-bottom: 8px;
    }

    .category-title {
        margin-left: 0 !important;
    }
    .forum-category-card p {
    line-height: 1.3 !important;
    margin-bottom: 8px !important;  
    }
.forum-category-card .btn-custom {
    white-space: nowrap;  
    line-height: 1.2;
}
}
    
</style>
