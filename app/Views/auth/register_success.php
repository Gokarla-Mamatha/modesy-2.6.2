<div id="wrapper">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title text-success font-weight-normal"><?= esc(trans("msg_register_success")); ?></h1>
                        <p class="text-center" style="font-size: 15px;">
                            <?= esc(trans("msg_send_confirmation_email")); ?>
                        </p>
                        <div class="form-group m-t-15">
                            <button type="submit" class="btn btn-custom btn-block btn-send-activation-register" data-token="<?= esc($user->token, 'attr'); ?>"><?= esc(trans("resend_activation_email")); ?></button>
                        </div>
                        <div id="confirmation-result-register"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script <?= csp_script_nonce() ?>>
    $(document).on('click', '.btn-send-activation-register', function () {
        sendActivationEmail($(this).data('token'), 'register');
    });
</script>
