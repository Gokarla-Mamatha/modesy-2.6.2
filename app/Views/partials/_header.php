<!DOCTYPE html>
<html lang="<?= esc($activeLang->short_form); ?>" <?= $baseVars->rtl ? 'dir="rtl"' : ''; ?>>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= escMeta($title); ?> - <?= escMeta($baseSettings->site_title); ?></title>
    <meta name="description" content="<?= escMeta($description); ?>" />
    <meta name="keywords" content="<?= escMeta($keywords); ?>" />
    <meta name="author" content="<?= escMeta($generalSettings->application_name); ?>" />
    <link rel="shortcut icon" type="image/png" href="<?= getFavicon(); ?>" />

    <meta property="og:locale" content="<?= escMeta($activeLang->language_code); ?>" />
    <meta property="og:site_name" content="<?= escMeta($generalSettings->application_name); ?>" />

    <?= csrf_meta(); ?>

    <?php if (isset($showOgTags)): ?>
        <meta property="og:type" content="<?= !empty($ogType) ? escMeta($ogType) : 'website'; ?>" />
        <meta property="og:title" content="<?= !empty($ogTitle) ? escMeta($ogTitle) : 'index'; ?>" />
        <meta property="og:description" content="<?= escMeta($ogDescription); ?>" />
        <meta property="og:url" content="<?= escMeta($ogUrl); ?>" />
        <meta property="og:image" content="<?= escMeta($ogImage); ?>" />
        <meta property="og:image:width" content="<?= !empty($ogWidth) ? $ogWidth : 250; ?>" />
        <meta property="og:image:height" content="<?= !empty($ogHeight) ? $ogHeight : 250; ?>" />
    <?php else: ?>
        <meta property="og:image" content="<?= getLogo(); ?>" />
        <meta property="og:image:width" content="<?= $baseVars->logoWidth; ?>" />
        <meta property="og:image:height" content="<?= $baseVars->logoHeight; ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?= escMeta($title); ?> - <?= escMeta($baseSettings->site_title); ?>" />
        <meta property="og:description" content="<?= escMeta($description); ?>" />
        <meta property="og:url" content="<?= base_url(); ?>" />
    <?php endif; ?>

    <?= view('partials/_fonts'); ?>

    <link rel="preload" href="<?= base_url("assets/css/icon-font/mds-icons.woff2"); ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?= base_url('assets/css/plugins-2.6.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/style-2.6.min.css'); ?>" />

    <!-- ⚠️ THIS LOADS YOUR JS FILES -->
    <?= view('partials/_css_js_header'); ?>

    <?= $generalSettings->google_adsense_code; ?>
    <?= $generalSettings->custom_header_codes; ?>

</head>

<body>
    <header id="header">
        <?= view('nav/_top_bar'); ?>
        <div class="main-menu">
            <div class="container-fluid">
                <div class="row">
                    <div class="nav-top">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-7 nav-top-left">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="logo">
                                            <a href="<?= langBaseUrl(); ?>"><img src="<?= getLogo(); ?>" alt="logo" width="<?= $baseVars->logoWidth; ?>" height="<?= $baseVars->logoHeight; ?>"></a>
                                        </div>
                                        <div class="top-search-bar">
                                            <form action="<?= generateUrl('products'); ?>" method="get" id="form_validate_search" class="form_search_main">
                                                <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search_main" class="form-control input-search ajax-search-input" data-device="desktop" placeholder="<?= trans("search_products_categories_brands"); ?>" required autocomplete="off">
                                                <button class="btn btn-default btn-search" aria-label="search"><i class="icon-search"></i></button>
                                                <div id="response_search_results" class="search-results-ajax"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 nav-top-right">
                                    <ul class="nav align-items-center">
                                        <?php if (isSaleActive()): ?>
                                            <li class="nav-item nav-item-cart li-main-nav-right">
                                                <a href="<?= generateUrl('cart'); ?>">
                                                    <i class="icon-cart"></i>
                                                    <span class="label-nav-icon"><?= trans("cart"); ?></span>
                                                    <span class="notification span_cart_product_count <?= $cartItemCount <= 0 ? 'visibility-hidden' : ''; ?>"><?= esc($cartItemCount); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="nav-item li-main-nav-right"><a href="<?= generateUrl('wishlist'); ?>"><i class="icon-heart-o"></i><span class="label-nav-icon"><?= trans("wishlist"); ?></span></a></li>
                                        <?php if (authCheck()): ?>
                                            <?php if ($generalSettings->multi_vendor_system == 1): ?>
                                                <li class="nav-item m-r-0">
                                                    <a href="<?= generateDashUrl("add_product"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0"><?= trans("sell_now"); ?></a>
                                                </li>
                                            <?php endif;
                                        else: ?>
                                            <?php if ($generalSettings->multi_vendor_system == 1): ?>
                                                <li class="nav-item m-r-0">
                                                    <button type="button" class="btn btn-md btn-custom btn-sell-now m-r-0" data-bs-toggle="modal" data-target="#loginModal" onclick="handleSellNowClick()" aria-label="sell-now"><?= trans("sell_now"); ?></button>
                                                </li>
                                        <?php endif;
                                        endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-main">
                        <?= renderCategoryMenu($activeLang->id, $parentCategories); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-nav-container">
            <div class="nav-mobile-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="nav-mobile-header-container">
                            <div class="flex-item flex-item-left item-menu-icon justify-content-start align-items-center">
                                <button type="button" class="btn-open-mobile-nav button-link" aria-label="open-mobile-menu"><i class="icon-menu"></i></button>
                            </div>
                            <div class="flex-item flex-item-mid justify-content-center">
                                <div class="mobile-logo">
                                    <a href="<?= langBaseUrl(); ?>"><img src="<?= getLogo(); ?>" alt="logo" width="<?= esc($baseVars->logoWidth); ?>" height="<?= esc($baseVars->logoHeight); ?>"></a>
                                </div>
                            </div>
                            <div class="flex-item flex-item-right justify-content-end">
                                <button type="button" class="button-link a-search-icon" aria-label="button-mobile-search-icon"><i id="searchIconMobile" class="icon-search"></i></button>
                                <?php if (isSaleActive()): ?>
                                    <a href="<?= generateUrl('cart'); ?>" class="a-mobile-cart"><i class="icon-cart"></i><span class="notification span_cart_product_count"><?= esc($cartItemCount); ?></span></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="top-search-bar mobile-search-form">
                            <form action="<?= generateUrl('products'); ?>" method="get">
                                <input type="text" id="input_search_mobile" name="search" maxlength="300" pattern=".*\S+.*" class="form-control input-search ajax-search-input" data-device="mobile" placeholder="<?= trans("search_products_categories_brands"); ?>" required autocomplete="off">
                                <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
                                <div id="response_search_results_mobile" class="search-results-ajax"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="overlay_bg" class="overlay-bg"></div>
    <?= view("nav/_nav_mobile"); ?>
   