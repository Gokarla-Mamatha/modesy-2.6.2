<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= esc(trans("home")); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= generateUrl('settings', 'edit_profile'); ?>"><?= esc(trans("profile_settings")); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($title); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?= esc(trans("profile_settings")); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <?= view("settings/_tabs"); ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="sidebar-tabs-content">
                        <?= view('partials/_messages'); ?>
                        <form action="<?= base_url('edit-profile-post'); ?>" method="post" id="form_validate" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                                <div class="form-group">
                                    <div id="edit_profile_cover" class="edit-profile-cover edit-cover-no-image">
                                        <?php $coverUrl = getStorageFileUrl(user()->cover_image, user()->storage_cover); ?>
                                        <img data-src="<?= $coverUrl ?? ''; ?>" class="lazyload img-edit-cover" alt="profile-image">
                                <div class="edit-avatar">
                                    <img src="<?= getUserAvatar(user()->avatar); ?>"
                                        id="img_preview_avatar"
                                        class="avatar-img">

                                    <label class="avatar-icon avatar-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                                        </svg>
                                        <input type="file"
                                            name="file"
                                            accept=".jpg,.jpeg,.png,.webp"
                                            onchange="document.getElementById('selectedAvatarInput').value='';showImagePreview(this);">
                                    </label>
                                        <button type="button"class="avatar-icon avatar-right"data-toggle="modal" data-target="#avatarModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                    <path d="M14 14s-1-4-6-4-6 4-6 4 1 1 6 1 6-1 6-1z"/>
                                                </svg>
                                        </button>
                                </div>
                                    <div class="btn-container">
                                        <div class="cursor-pointer">
                                            <a class="btn btn-md btn-custom btn-file-upload btn-edit-cover">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                                    <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                    <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                                                </svg>
                                                <input type="file" name="image_cover" size="40" accept=".jpg, .jpeg, .webp, .png, .gif" data-img-id="edit_profile_cover" onchange="showImagePreview(this, true);">
                                            </a>
                                        </div>
                                        <?php if (!empty(user()->cover_image)): ?>
                                            <a class="btn btn-md btn-custom btn-file-upload btn-edit-cover cursor-pointer" onclick="deleteCoverImage();">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <p class="mb-4"><small class="text-muted">*<?= esc(trans("warning_edit_profile_image")); ?></small></p>
                            </div>
                            <div class="form-group">
                                <?php if (!empty(user()->profile_updated_at)): ?>
                                <div class="alert alert-info">
                                    Last Updated On:
                                    <?= date('d M Y h:i A', strtotime(user()->profile_updated_at)); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                    <?= esc(trans("email_address")); ?>
                                    <?php if ($generalSettings->email_verification == 1): ?>
                                        <?php if (user()->email_status == 1): ?>
                                            <small class="text-success">(<?= esc(trans("confirmed")); ?>)</small>
                                        <?php else: ?>
                                            <small class="text-danger">(<?= esc(trans("unconfirmed")); ?>)</small>
                                            <button type="button" data-token="<?= esc(user()->token, 'attr'); ?>" class="btn btn-sm btn-default display-inline-block btn-send-activation-profile"><?= esc(trans("resend_activation_email")); ?></button>
                                            <div class="display-inline-block font-weight-normal m-l-5" id="confirmation-result-profile"></div>
                                        <?php endif;
                                    endif; ?>
                                </label>
                                <input type="email" name="email" class="form-control form-input" value="<?= esc(user()->email); ?>" placeholder="<?= esc(trans("email_address")); ?>" required>
                            </div>
                            <script <?= csp_script_nonce() ?>>
                                $(document).on('click', '.btn-send-activation-profile', function () {
                                    sendActivationEmail($(this).data('token'), 'profile');
                                });
                            </script>
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans("slug")); ?></label>
                                <input type="text" name="slug" class="form-control form-input" value="<?= esc(user()->slug); ?>" placeholder="<?= esc(trans("slug")); ?>" maxlength="200" data-type="slug" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans("first_name")); ?></label>
                                <input type="text" name="first_name" class="form-control form-input" value="<?= esc(user()->first_name); ?>" placeholder="<?= esc(trans("first_name")); ?>" maxlength="250"data-type="name" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans("last_name")); ?></label>
                                <input type="text" name="last_name" class="form-control form-input" value="<?= esc(user()->last_name); ?>" placeholder="<?= esc(trans("last_name")); ?>" maxlength="250" data-type="name" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans("phone_number")); ?></label>
                                <input type="text" name="phone_number" class="form-control form-input" value="<?= esc(user()->phone_number); ?>" placeholder="<?= esc(trans("phone_number")); ?>" data-type="mobile" maxlength="100">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans("tax_registration_number")); ?></label>
                                <input type="text" name="tax_registration_number" class="form-control form-input" value="<?= esc(user()->tax_registration_number); ?>" placeholder="<?= esc(trans("tax_registration_number")); ?>" maxlength="255">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="control-label"><?= esc(trans('cover_image_type')); ?></label>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-12">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="cover_image_type" value="full_width" id="cover_image_type_1" class="custom-control-input" <?= user()->cover_image_type == 'full_width' ? 'checked' : ''; ?>>
                                            <label for="cover_image_type_1" class="custom-control-label"><?= esc(trans("full_width")); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-12">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="cover_image_type" value="boxed" id="cover_image_type_2" class="custom-control-input" <?= user()->cover_image_type == 'boxed' ? 'checked' : ''; ?>>
                                            <label for="cover_image_type_2" class="custom-control-label"><?= esc(trans("boxed")); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="send_email_new_message" value="1" id="send_email_new_message" class="custom-control-input" <?= user()->send_email_new_message == 1 ? 'checked' : ''; ?>>
                                    <label for="send_email_new_message" class="custom-control-label"><?= esc(trans("email_option_send_email_new_message")); ?></label>
                                </div>
                            </div>
                            <?php if ($generalSettings->show_vendor_contact_information == 1): ?>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="show_email" value="1" id="checkbox_show_email" class="custom-control-input" <?= user()->show_email == 1 ? 'checked' : ''; ?>>
                                        <label for="checkbox_show_email" class="custom-control-label"><?= esc(trans("show_my_email")); ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="show_phone" value="1" id="checkbox_show_phone" class="custom-control-input" <?= user()->show_phone == 1 ? 'checked' : ''; ?>>
                                        <label for="checkbox_show_phone" class="custom-control-label"><?= esc(trans("show_my_phone")); ?></label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="avatar" id="selectedAvatarInput">
                            <button type="submit" name="submit" value="update" class="btn btn-md btn-custom m-t-10">
                                <?= esc(trans("save_changes")) ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="avatarModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Select Avatar</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body d-flex flex-wrap justify-content-center">
                <?php
                $avatars = glob(FCPATH . 'uploads/avatars/*.png');
                foreach ($avatars as $avatar):
                    if (basename($avatar) === 'default.png') continue;
                    $path = 'uploads/avatars/' . basename($avatar);
                ?>
                    <img src="<?= base_url($path); ?>"
                         style="width:80px;height:80px;border-radius:50%;margin:8px;cursor:pointer;"
                         onclick="
                             document.getElementById('img_preview_avatar').src='<?= base_url($path); ?>';
                             document.getElementById('selectedAvatarInput').value='<?= $path; ?>';
                             $('#avatarModal').modal('hide');
                         ">
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>

<style <?= csp_style_nonce() ?>>
 .edit-avatar {
    position: relative;
    width: 180px;
    height: 180px;
}
.avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e0e0e0;
}
.avatar-icon {
    position: absolute;
    bottom: 8px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #e76528;
    color: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
.avatar-left {
    left: 8px;
}
.avatar-right {
    right: 8px;
}
.avatar-icon input {
    display: none;
}
</style>
