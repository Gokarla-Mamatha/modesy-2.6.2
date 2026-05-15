<?php if (!empty($trendingProducts)): ?>
    <div class="col-12 section section-trending-products">
        <div class="section-header">
            <h3 class="title"><?= trans("trending_products"); ?></h3>
        </div>

        <div class="swiper swiper-carousel swiper-carousel-product"
             <?= $baseVars->rtl == true ? 'dir="rtl"' : ''; ?>>

            <div class="swiper-wrapper">
                <?php foreach ($trendingProducts as $product): ?>
                    <div class="swiper-slide <?= $generalSettings->index_products_per_row == 5
                        ? 'swiper-col-product-5'
                        : 'swiper-col-product-6'; ?>">

                        <?= view('product/_product_item', [
                            'product' => $product,
                            'promotedBadge' => false,
                            'discountLabel' => 0
                        ]); ?>

                    </div>
                <?php endforeach; ?>
            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
<?php endif; ?>
