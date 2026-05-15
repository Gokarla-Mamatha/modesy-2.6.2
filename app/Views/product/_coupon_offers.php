<?php if (!empty($couponProducts)): ?>
    <div class="col-12 section section-coupon-products">
        <div class="section-header">
            <h3 class="title">
               Coupon Offers
            </h3>
        </div>

        <div class="swiper swiper-carousel swiper-carousel-product" <?= $baseVars->rtl == true ? 'dir="rtl"' : ''; ?>>
            <div class="swiper-wrapper">
                <?php foreach ($couponProducts as $item): ?>
                    <div class="swiper-slide <?= 
                        $generalSettings->index_products_per_row == 5 ? 'swiper-col-product-5' : 'swiper-col-product-6'; ?>">
                        
                        <?= view('product/_product_item', [
                            'product' => $item,
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
