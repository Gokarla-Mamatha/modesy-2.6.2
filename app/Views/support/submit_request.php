<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="support">
                    <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= langBaseUrl() ?>"><?= esc(trans('home')) ?></a></li>
                            <li class="breadcrumb-item"><a
                                    href="<?= generateUrl('help_center') ?>"><?= esc(trans('help_center')) ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= esc(trans('submit_a_request')) ?></li>
                        </ol>
                    </nav>
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-sm-12 m-t-15">
                            <h1 class="page-title text-center m-b-30"><?= esc(trans('submit_a_request')) ?></h1>
                        </div>
                        <div class="col-lg-10 col-sm-12">
                            <?= view('partials/_messages') ?>
                            <form action="<?= base_url('submit-request-post') ?>" method="post" id="form_validate">
                                <?= csrf_field() ?>
                                <?php if (!authCheck()): ?>
                                <div class="form-group">
                                    <label class="control-label"><?= esc(trans('name')) ?></label>
                                    <input type="text" class="form-control form-input" name="name"
                                      data-type="name"  value="<?= old('name') ?>" placeholder="<?= esc(trans('name')) ?>" maxlength="255"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= esc(trans('email')) ?></label>
                                    <input type="email" class="form-control form-input" name="email"
                                      data-type="email"  value="<?= old('email') ?>" placeholder="<?= esc(trans('email')) ?>" maxlength="255"
                                        required>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label class="control-label"><?= esc(trans('subject')) ?></label>
                                    <input type="text" class="form-control form-input" name="subject"
                                        value="<?= old('subject') ?>" placeholder="<?= esc(trans('subject')) ?>"
                                        maxlength="500" required>
                                </div>
                                <div class="form-group m-0">
                                    <label class="control-label"><?= esc(trans('message')) ?></label>
                                </div>
                                <div class="form-group" style="min-height: 320px">
                                    <textarea name="message" class="tinyMCEticket" aria-hidden="true"><?= old('message') ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= esc(trans('attachments')) ?></label>
                                    <div class="dm-uploader-container">
                                        <div id="drag-and-drop-zone" class="dm-uploader text-center mb-2">
                                            <p class="dm-upload-text">
                                                <?= esc(trans('drag_drop_file_here')) ?>&nbsp;<span
                                                    style="text-decoration: underline; font-weight: 600;"><?= esc(trans('browse_files')) ?>
                                            </p>
                                            <a class='btn btn-md dm-btn-select-files'>
                                                <input type="file" name="file" size="40" multiple="multiple">
                                            </a>
                                        </div>
                                        <ul class="dm-uploaded-files" id="files-file"></ul>
                                    </div>
                                    <script type="text/html" id="files-template-file">
                                        <li class="media">
                                            <div class="media-body">
                                                <div class="progress">
                                                    <div class="dm-progress-waiting"></div>
                                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </li>
                                    </script>
                                    <div id="response_uploaded_files" class="uploaded-files m-b-15">
                                        <?php $attachments = helperGetSession('ticket_attachments');
                                        if (!empty($attachments)):
                                            foreach ($attachments as $file):
                                                if (!empty($file->fileId) && !empty($file->name) && !empty($file->ticketType) && $file->ticketType == 'client'): ?>
                                        <div class="item">
                                            <div class="item-inner">
                                                <?= esc($file->name) ?>
                                                <a href="javascript:void(0)" class="js-delete-support-attachment" data-file-id="<?= esc($file->fileId, 'attr') ?>"><i
                                                        class="icon-times"></i></a>
                                            </div>
                                        </div>
                                        <?php endif;
                                            endforeach;
                                        endif; ?>
                                    </div>
                                </div>

                                <div class="form-group d-flex align-items-center">
                                    <div class="captcha-box">
                                        <img src="<?= base_url('captcha/math') ?>" id="captcha_img_support"
                                            alt="captcha">
                                        <button type="button" onclick="refreshSupportCaptcha()"
                                            class="captcha-refresh">
                                            🔄
                                        </button>
                                    </div>

                                    <input type="number" name="math_captcha" class="captcha-input ml-3"
                                        placeholder="Enter Captcha" required>
                                </div>

                                <div class="text-right m-t-20">
                                    <button type="submit"
                                        class="btn btn-md btn-custom"><?= esc(trans('send_message')) ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script <?= csp_script_nonce() ?>>
function refreshSupportCaptcha() {
    document.getElementById('captcha_img_support').src =
        "<?= base_url('captcha/math'); ?>?t=" + new Date().getTime();
}

$(document).on('click', '.js-delete-support-attachment', function () {
    deleteSupportAttachment($(this).data('file-id'));
});
</script>
<style <?= csp_style_nonce() ?>>
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
