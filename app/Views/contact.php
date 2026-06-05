<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= esc(trans("home")); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc(trans("contact")); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?= esc(trans("contact")); ?></h1>
            </div>
            <div class="col-12">
                <div class="page-contact">
                    <div class="row contact-text">
                        <div class="col-12">
                            <?= $baseSettings->contact_text; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h2 class="contact-leave-message"><?= esc(trans("leave_message")); ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12 order-1 order-lg-0">
                            <?= view('partials/_messages'); ?>
                            <form action="<?= base_url('contact-post'); ?>" method="post" id="form_validate" class="validate_terms">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="recaptcha_token" id="recaptcha_token">
                                <input type="text" name="contact_url" class="ctd">
                                <div class="form-group">
                                    <input type="text" class="form-control form-input" name="name" placeholder="<?= esc(trans("name")); ?>" maxlength="199" minlength="1" pattern=".*\S+.*" value="<?= old('name'); ?>" data-type="name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-input" name="email" maxlength="199" placeholder="<?= esc(trans("email_address")); ?>" value="<?= old('email'); ?>" data-type="email" required>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control form-input form-textarea" name="message" placeholder="<?= esc(trans("message")); ?>" maxlength="4970" minlength="5" required data-type="text"><?= old('message'); ?></textarea>
                                </div>
                                
                                <div class="form-group d-flex align-items-center">
                                    <div class="captcha-box">
                                        <img src="<?= base_url('captcha/math'); ?>" id="captcha_img" alt="captcha">
                                        <button type="button" onclick="refreshCaptcha()" class="captcha-refresh">
                                            🔄
                                        </button>
                                    </div>
                                    <input type="number" name="math_captcha" class="captcha-input ml-3" placeholder="Enter Captcha" required>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-control-validate-input">
                                        <input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" required>
                                        <label for="checkbox_terms" class="custom-control-label"><?= esc(trans("terms_conditions_exp")); ?>&nbsp;
                                            <?php $pageTerms = getPageByDefaultName('terms_conditions', selectedLangId());
                                            if (!empty($pageTerms)): ?>
                                                <a href="<?= generateUrl($pageTerms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= esc($pageTerms->title); ?></strong></a>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-custom">
                                        <?= esc(trans("submit")); ?>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-6 col-12 order-0 order-lg-1 contact-right">
                            <?php if ($baseSettings->contact_phone): ?>
                                <div class="col-12 contact-item">
                                    <i class="icon-phone" aria-hidden="true"></i>
                                    <?= esc($baseSettings->contact_phone); ?>
                                </div>
                            <?php endif;
                            if ($baseSettings->contact_email): ?>
                                <div class="col-12 contact-item">
                                    <i class="icon-envelope" aria-hidden="true"></i>
                                    <?= esc($baseSettings->contact_email); ?>
                                </div>
                            <?php endif;
                            if ($baseSettings->contact_address): ?>
                                <div class="col-12 contact-item">
                                    <i class="icon-map-marker" aria-hidden="true"></i>
                                    <?= esc($baseSettings->contact_address); ?>
                                </div>
                            <?php endif; ?>
                            <div class="col-sm-12 contact-social">
                                <?php $socialLinks = getSocialLinksArray($baseSettings, false);
                                if (!empty($socialLinks)):?>
                                    <ul>
                                        <?php foreach ($socialLinks as $socialLink):
                                            if (!empty($socialLink['value'])): ?>
                                                <li><a href="<?= esc($socialLink['value']); ?>" target="_blank"><i class="icon-<?= esc($socialLink['name']); ?>"></i></a></li>
                                            <?php endif;
                                        endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($baseSettings->contact_address)):
        $mapLang = 'en';
        if (!empty($activeLang->short_form)) {
            $mapLang = htmlspecialchars($activeLang->short_form, ENT_QUOTES, 'UTF-8');
        }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="contact-map-container">
                <div id="contact_iframe"  data-type="map-iframe" data-address="<?= htmlspecialchars($baseSettings->contact_address, ENT_QUOTES, 'UTF-8'); ?>" data-lang="<?= $mapLang; ?>"> </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<script <?= csp_script_nonce() ?>>
    var iframe = document.getElementById("contact_iframe");
    iframe.src = iframe.src;
</script>
<script <?= csp_script_nonce() ?>>
function refreshCaptcha() {
    document.getElementById('captcha_img').src =
        "<?= base_url('captcha/math'); ?>?t=" + new Date().getTime();
}
</script>
<style <?= csp_style_nonce() ?>>
    #footer {
        margin-top: 0;
    }
    .captcha-refresh {
        border: none;
        background: #107ef4;
        color: #fff;
        padding: 6px 6px;
    }

    .captcha-input {
        height: 40px;
        padding: 0 8px;
        border: 1px solid #ccc;
    }
</style>
