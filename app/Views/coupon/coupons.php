<div id="wrapper">
    <div class="container">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0 m-0 breadcrumb-mobile-scroll">
                <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= esc(trans("home")); ?></a></li>
                <?php if (!empty($parentCategoriesTree)): ?>
                    <?php foreach ($parentCategoriesTree as $item): ?>
                        <li class="breadcrumb-item">
                            <a href="<?= generateCategoryUrl($item); ?>"><?= esc($item->cat_name); ?></a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page"><?= esc(trans("coupons")); ?></li>
            </ol>
        </nav>


        <div class="row g-5">
            <!-- Sidebar: Categories Filter -->
            <aside class="col-lg-3">
                <div class="sticky-top" style="top: 100px;">
                    <div class="bg-white rounded-3 shadow-sm p-4 border">
                        <h2 class="h5 fw-bold mb-4 text-dark"><?= esc(trans("categories")); ?></h2>
                        <ul class="list-unstyled category-list-filter mb-0">
                            <li class="mb-2">
                                <a href="<?= langBaseUrl('coupons'); ?>" 
                                   class="d-block py-2 px-3 rounded-2 text-decoration-none fw-medium <?= empty($category) ? 'bg-primary text-white' : 'text-dark hover-bg-light'; ?>">
                                    <?= esc(trans("all_categories")); ?>
                                    <?php if (empty($category)): ?><i class="bi bi-check2 ms-2"></i><?php endif; ?>
                                </a>
                            </li>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <li class="mb-2">
                                        <a href="<?= langBaseUrl('coupons?category=' . $cat->id); ?>" 
                                           class="d-block py-2 px-3 rounded-2 text-decoration-none fw-medium <?= (!empty($category) && $category->id == $cat->id) ? 'bg-primary text-white' : 'text-dark hover-bg-light'; ?>">
                                            <?= esc($cat->cat_name); ?>
                                            <?php if (!empty($category) && $category->id == $cat->id): ?><i class="bi bi-check2 ms-2"></i><?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Main Content: Products Grid -->
            <div class="col-lg-9">
                <?php if (!empty($products)): ?>
                    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-lg-4 g-3 g-md-4">
                        <?php foreach ($products as $product): ?>
                            <?php 
                            $product->discount_rate = $product->coupon_discount_rate ?? $product->discount_rate ?? 0;
                            ?>
                            <div class="col">
                                <?= view('product/_product_item', [
                                    'product' => $product,
                                    'promotedBadge' => true,
                                    'discountLabel' => true
                                ]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination & Count -->
                    <?php if (!empty($pager) && $numRows > ($productSettings->pagination_per_page ?? 24)): ?>
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-5 pt-4 border-top">
                            <p class="text-muted mb-3 mb-md-0">
                                <strong><?= $numRows; ?></strong> <?= esc(trans("number_of_entries")); ?>
                            </p>
                            <nav aria-label="Page navigation">
                                <?= $pager->links('default', 'custom_pagination'); ?>
                            </nav>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- Clean Empty State (exactly like your screenshot) -->
                    <div class="text-center py-5 my-5">
                        <p class="text-muted fs-5 mb-4"><?= esc(trans("no_products_found")); ?></p>
                        <a href="<?= langBaseUrl('coupons'); ?>" class="btn btn-outline-primary px-4">
                            <?= esc(trans("view_all_coupons")); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

