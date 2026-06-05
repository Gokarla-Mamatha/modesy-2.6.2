<?php $productUrl = urlencode(generateProductUrl($product));
$productTitle = urlencode($title);
$productImage = urlencode($ogImage); ?>
<div class="row-custom product-share">
    <ul>
        <li>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= esc($productUrl, 'attr'); ?>" target="_blank" rel="noopener noreferrer" aria-label="share-facebook">
                <i class="icon-facebook"></i>
            </a>
        </li>
        <li>
            <a href="https://twitter.com/share?url=<?= esc($productUrl, 'attr'); ?>&amp;text=<?= esc($productTitle, 'attr'); ?>" target="_blank" rel="noopener noreferrer" aria-label="share-twitter">
                <i class="icon-twitter"></i>
            </a>
        </li>
        <li>
            <a href="https://api.whatsapp.com/send?text=<?= esc($productTitle, 'attr'); ?> - <?= esc($productUrl, 'attr'); ?>" target="_blank" rel="noopener noreferrer" title="share-whatsapp">
                <i class="icon-whatsapp"></i>
            </a>
        </li>
        <li>
            <a href="http://pinterest.com/pin/create/button/?url=<?= esc($productUrl, 'attr'); ?>&amp;media=<?= esc($productImage, 'attr'); ?>" target="_blank" rel="noopener noreferrer" aria-label="share-pinterest">
                <i class="icon-pinterest"></i>
            </a>
        </li>
        <li>
            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?= esc($productUrl, 'attr'); ?>" target="_blank" rel="noopener noreferrer" aria-label="share-linkedin">
                <i class="icon-linkedin"></i>
            </a>
        </li>
        <li>
            <a href="https://t.me/share/url?url=<?= esc($productUrl, 'attr'); ?>&amp;text=<?= esc($productTitle, 'attr'); ?>" target="_blank" rel="noopener noreferrer" aria-label="share-telegram">
                <i class="icon-telegram"></i>
            </a>
        </li>
    </ul>
</div>
