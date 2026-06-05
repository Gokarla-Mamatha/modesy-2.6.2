<div id="wrapper">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title"><?= esc(trans("reset_password")); ?></h1>
                        <form action="<?= base_url('forgot-password-post'); ?>" method="post" id="form_validate" onsubmit="return runRecaptcha(event, 'FORGOT_PASSWORD');">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="recaptcha_token" class="recaptcha_token">

                            <div class="form-group">
                                <p class="p-social-media m-0"><?= esc(trans("reset_password_subtitle")); ?></p>
                            </div>

                            <?= view('partials/_messages'); ?>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control auth-form-input" placeholder="<?= esc(trans("email_address")); ?>" value="<?= old("email"); ?>" maxlength="255" data-type="email" required>
                            </div>

                            <?= view('partials/_cf_turnstile', ['turnstileCenter' => true]); ?>

                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-custom btn-block"><?= esc(trans("submit")); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
