<?php
$hasDiscount = !empty($product->price_discounted) && $product->price_discounted > 0 && $product->price_discounted < $product->price;

$convertCurrency = ($product->listing_type !== 'ordinary_listing');

$priceContainerClasses = ['product-price'];
if (!$baseVars->isPriceSingleLine) {
    $priceContainerClasses[] = 'display-block';
}

$originalPriceHtml = '';
$discountedPriceHtml = '';

if (!empty($product->price)) {
    if ($hasDiscount) {
        // show discount price
        $discountedPriceHtml = '<span class="price price-green">' . priceFormatted($product->price_discounted, $product->currency, $convertCurrency) . '</span>';
        $originalPriceHtml = '<del class="discount-original-price">' . priceFormatted($product->price, $product->currency, $convertCurrency) . '</del>';
    } else {
        // show only normal price
        $discountedPriceHtml = '<span class="price">' . priceFormatted($product->price, $product->currency, $convertCurrency) . '</span>';
    }
}
?>

<div class="<?= implode(' ', $priceContainerClasses) ?>">
    <?php if ($product->is_free_product == 1): ?>
        <span class="price-free price-green"><?= trans("free"); ?></span>
    <?php elseif ($product->listing_type == 'bidding'): ?>
        <a href="<?= generateProductUrl($product); ?>" class="a-meta-request-quote"><?= trans("request_a_quote") ?></a>
    <?php elseif (!empty($product->price) && $product->price > 0): ?>
        <?php if ($baseVars->isPriceSingleLine): ?>
            <?= $discountedPriceHtml ?>
            <?= $originalPriceHtml ?>
        <?php else: ?>
            <?= $originalPriceHtml ?>
            <?php if ($hasDiscount): ?><br><?php endif; ?>
            <?= $discountedPriceHtml ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
