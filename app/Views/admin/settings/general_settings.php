<?php $activeTab = inputGet('tab');
if (empty($activeTab)):
    $activeTab = '1';
endif; ?>
<div class="row">
    <div class="col-md-12">
        <form action="<?= base_url('Admin/generalSettingsPost'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="active_tab" id="input_active_tab" value="<?= clrNum($activeTab); ?>">
            <input type="hidden" name="lang_id" value="<?= clrNum(inputGet('lang')); ?>">
            <div class="form-group">
                <label><?= esc(trans("settings_language")); ?></label>
                <select name="lang_id" class="form-control" onchange="window.location.href = '<?= adminUrl('general-settings'); ?>?lang='+this.value+'&tab=<?= clrNum($activeTab); ?>';" style="max-width: 600px;">
                    <?php foreach ($activeLanguages as $language): ?>
                        <option value="<?= $language->id; ?>" <?= $language->id == $settingsLang ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="<?= $activeTab == '1' ? ' active' : ''; ?>"><a href="#tab_1" data-bs-toggle="tab" data-tab-id="1"><?= esc(trans('general_settings')); ?></a></li>
                    <li class="<?= $activeTab == '2' ? ' active' : ''; ?>"><a href="#tab_2" data-bs-toggle="tab" data-tab-id="2"><?= esc(trans('contact_settings')); ?></a></li>
                    <li class="<?= $activeTab == '3' ? ' active' : ''; ?>"><a href="#tab_3" data-bs-toggle="tab" data-tab-id="3"><?= esc(trans('social_media_settings')); ?></a></li>
                    <li class="<?= $activeTab == '4' ? ' active' : ''; ?>"><a href="#tab_4" data-bs-toggle="tab" data-tab-id="4"><?= esc(trans('facebook_comments')); ?></a></li>
                    <li class="<?= $activeTab == '5' ? ' active' : ''; ?>"><a href="#tab_5" data-bs-toggle="tab" data-tab-id="5"><?= esc(trans('custom_header_codes')); ?></a></li>
                    <li class="<?= $activeTab == '6' ? ' active' : ''; ?>"><a href="#tab_6" data-bs-toggle="tab" data-tab-id="6"><?= esc(trans('custom_footer_codes')); ?></a></li>
                    <li class="<?= $activeTab == '7' ? ' active' : ''; ?>"><a href="#tab_7" data-bs-toggle="tab" data-tab-id="7"><?= esc(trans('cookies_warning')); ?></a></li>
                    <li class="<?= $activeTab == '8' ? ' active' : ''; ?>"><a href="#tab_8" data-bs-toggle="tab" data-tab-id="8"><?= esc(trans('bulk_upload_documentation')); ?></a></li>
                    <li class="<?= $activeTab == '9' ? ' active' : ''; ?>"><a href="#tab_9" data-bs-toggle="tab" data-tab-id="9"><?= esc(trans('Loyalty Points')); ?></a></li>
                </ul>
                <div class="tab-content settings-tab-content">
                    <div class="tab-pane<?= $activeTab == '1' ? ' active' : ''; ?>" id="tab_1">
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('app_name')); ?></label>
                            <input type="text" class="form-control" name="application_name" placeholder="<?= esc(trans('app_name')); ?>" value="<?= esc($generalSettings->application_name); ?>" data-type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('site_title')); ?></label>
                            <input type="text" class="form-control" name="site_title" placeholder="<?= esc(trans('site_title')); ?>" value="<?= esc($settings->site_title); ?>" data-type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('homepage_title')); ?></label>
                            <input type="text" class="form-control" name="homepage_title" placeholder="<?= esc(trans('homepage_title')); ?>" value="<?= esc($settings->homepage_title); ?>" data-type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('site_description')); ?></label>
                            <input type="text" class="form-control" name="site_description" placeholder="<?= esc(trans('site_description')); ?>" value="<?= esc($settings->site_description); ?>" data-type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('keywords')); ?></label>
                            <input type="text" class="form-control" name="keywords" placeholder="<?= esc(trans('keywords')); ?>" value="<?= esc($settings->keywords); ?>" data-type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('copyright')); ?></label>
                            <input type="text" class="form-control" name="copyright" placeholder="<?= esc(trans('copyright')); ?>" value="<?= esc($settings->copyright); ?>" data-type="text">
                        </div>
                        <div class="form-group">
                            <?= renderTextEditorAdmin('about_footer', trans("footer_about_section"), $settings->about_footer, false, false, 'tinyMCEsmall'); ?>
                        </div>
                    </div>
                    <div class="tab-pane<?= $activeTab == '2' ? ' active' : ''; ?>" id="tab_2">
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('address')); ?></label>
                            <input type="text" class="form-control" name="contact_address" placeholder="<?= esc(trans('address')); ?>" value="<?= esc($settings->contact_address); ?>" data-type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('email_address')); ?></label>
                            <input type="text" class="form-control" name="contact_email" placeholder="<?= esc(trans('email_address')); ?>" value="<?= esc($settings->contact_email); ?>" data-type="email">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('phone')); ?></label>
                            <input type="text" class="form-control" name="contact_phone" placeholder="<?= esc(trans('phone')); ?>" value="<?= esc($settings->contact_phone); ?>" data-type="mobile">
                        </div>
                        <div class="form-group">
                            <?= renderTextEditorAdmin('contact_text', trans("contact_text"), $settings->contact_text, false, false, 'tinyMCEsmall'); ?>
                        </div>
                    </div>
                    <div class="tab-pane<?= $activeTab == '3' ? ' active' : ''; ?>" id="tab_3">
                        <?php $socialArray = getSocialLinksArray($settings, false);
                        foreach ($socialArray as $item): ?>
                            <div class="form-group">
                                <label class="control-label"><?= esc(trans($item['inputName'])); ?></label>
                                <input type="text" class="form-control" name="<?= $item['inputName']; ?>" placeholder="<?= esc(trans($item['inputName'])); ?>" value="<?= esc($item['value']); ?>" maxlength="1000" data-type="url">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="tab-pane<?= $activeTab == '4' ? ' active' : ''; ?>" id="tab_4">
                        <div class="form-group">
                            <label><?= esc(trans("facebook_comments")); ?></label>
                            <?= formRadio('facebook_comment_status', 1, 0, trans("enable"), trans("disable"), $generalSettings->facebook_comment_status); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('facebook_comments_code')); ?></label>
                            <textarea class="form-control text-area" name="facebook_comment" placeholder="<?= esc(trans('facebook_comments_code')); ?>" style="min-height: 140px;" data-type="text"><?= $generalSettings->facebook_comment; ?></textarea>
                        </div>
                    </div>
                    <div class="tab-pane<?= $activeTab == '5' ? ' active' : ''; ?>" id="tab_5">
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('custom_header_codes')); ?></label>&nbsp;<small class="small-title-inline">(<?= esc(trans("custom_header_codes_exp")); ?>)</small>
                            <textarea class="form-control text-area" name="custom_header_codes" placeholder="<?= esc(trans('custom_header_codes')); ?>" data-type="text" style="min-height: 200px;" data-type="text"><?= $generalSettings->custom_header_codes; ?></textarea>
                        </div>
                        E.g. <?= esc("<style <?= csp_style_nonce() ?>> body {background-color: #00a65a;} </style>"); ?>
                    </div>
                    <div class="tab-pane<?= $activeTab == '6' ? ' active' : ''; ?>" id="tab_6">
                        <div class="form-group">
                            <label class="control-label"><?= esc(trans('custom_footer_codes')); ?></label>&nbsp;<small class="small-title-inline">(<?= esc(trans("custom_footer_codes_exp")); ?>)</small>
                            <textarea class="form-control text-area" name="custom_footer_codes" placeholder="<?= esc(trans('custom_footer_codes')); ?>" data-type="text" style="min-height: 200px;" data-type="text"><?= $generalSettings->custom_footer_codes; ?></textarea>
                        </div>
                        E.g. <?= esc("<script <?= csp_script_nonce() ?>> alert('Hello!'); </script>"); ?>
                    </div>
                    <div class="tab-pane<?= $activeTab == '7' ? ' active' : ''; ?>" id="tab_7">
                        <div class="form-group">
                            <label><?= esc(trans("show_cookies_warning")); ?></label>
                            <?= formRadio('cookies_warning', 1, 0, trans("yes"), trans("no"), $settings->cookies_warning); ?>
                        </div>
                        <div class="form-group">
                            <?= renderTextEditorAdmin('cookies_warning_text', '', $settings->cookies_warning_text, false, false, 'tinyMCEsmall'); ?>
                        </div>
                    </div>
                    <div class="tab-pane<?= $activeTab == '8' ? ' active' : ''; ?>" id="tab_8">
                        <div class="form-group">
                            <?= renderTextEditorAdmin('bulk_upload_documentation', trans('bulk_upload_documentation'), $settings->bulk_upload_documentation, false, false); ?>
                        </div>
                    </div>
                    <div class="tab-pane <?= $activeTab == '9' ? 'active' : ''; ?>" id="tab_9">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Loyalty Points Required for Conversion</label>
                                    <input type="number" name="loyalty_convert_points" class="form-control" value="<?= esc((int) ($settings->loyalty_convert_points ?? 0)); ?>" min="0">
                                    <small class="text-muted">Example: 400 points</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Wallet Amount to Credit (₹)</label>
                                    <input type="number" name="loyalty_convert_amount" class="form-control" value="<?= esc((float) ($settings->loyalty_convert_amount ?? 0)); ?>" min="0" step="0.01">
                                    <small class="text-muted"> Example: ₹30 </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Referral Reward Points</label>
                                    <input type="number" name="referral_points" class="form-control" value="<?= esc((int) ($settings->referral_points ?? 0)); ?>" min="0">
                                </div>
                            </div>
                        </div>
                        <h4><strong>Loyalty Points Rules</strong></h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Min Amount ($)</label>
                                <input type="number" id="min_amount" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>Max Amount ($)</label>
                                <input type="number" id="max_amount" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>Points</label>
                                <input type="number" id="points" class="form-control">
                            </div>

                            <div class="col-md-3" style="margin-top:25px;">
                                <button type="button" class="btn btn-primary" id="btn_add_loyalty_rule">Add</button>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-bordered" id="loyaltyTable">
                            <thead>
                                <tr>
                                    <th>Min Amount</th>
                                    <th>Max Amount</th>
                                    <th>Points</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans('cloudflare_turnstile')); ?></h3>
            </div>
            <form action="<?= base_url('Admin/cloudflareTurnstileSettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="lang_id" value="<?= clrNum(inputGet('lang')); ?>">
                <div class="box-body">
                    <div class="form-group">
                        <?= formSwitch('turnstile_status', trans('status'), $generalSettings->turnstile_status); ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('site_key')); ?></label>
                        <input type="text" class="form-control" name="turnstile_site_key" placeholder="<?= esc(trans('site_key')); ?>" value="<?= esc($generalSettings->turnstile_site_key); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('secret_key')); ?></label>
                        <input type="text" class="form-control" name="turnstile_secret_key" placeholder="<?= esc(trans('secret_key')); ?>" value="<?= esc($generalSettings->turnstile_secret_key); ?>" data-type="text">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= esc(trans('maintenance_mode')); ?></h3>
            </div>
            <form action="<?= base_url('Admin/maintenanceModePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="lang_id" value="<?= clrNum(inputGet('lang')); ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('title')); ?></label>
                        <input type="text" class="form-control" name="maintenance_mode_title" placeholder="<?= esc(trans('title')); ?>" value="<?= esc($generalSettings->maintenance_mode_title); ?>" data-type="text">
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= esc(trans('description')); ?></label>
                        <textarea class="form-control text-area" name="maintenance_mode_description" placeholder="<?= esc(trans('description')); ?>" data-type="text" style="min-height: 100px;" data-type="text"><?= esc($generalSettings->maintenance_mode_description); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans("status")); ?></label>
                        <?= formRadio('maintenance_mode_status', 1, 0, trans("enable"), trans("disable"), $generalSettings->maintenance_mode_status); ?>
                    </div>
                    <div class="form-group">
                        <label><?= esc(trans('image')); ?></label>: assets/img/maintenance_bg.jpg
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= esc(trans('save_changes')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" <?= csp_script_nonce() ?>></script>

<script <?= csp_script_nonce() ?>>
    tinymce.init({
        selector: '#editor',
        height: 300,
        menubar: false,
        plugins: 'lists link image table code fullscreen preview wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist | link image table | code fullscreen preview',

        /* Define available formats */
        block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; ' +
            'Heading 4=h4; Heading 5=h5; Heading 6=h6',

        branding: false,
        resize: 'both',
        width: '100%',
        statusbar: true
    });

    function addLoyaltyRule() {

        const min = $('#min_amount').val();
        const max = $('#max_amount').val();
        const pts = $('#points').val();

        if (!min || !pts) {
            alert('Min Amount and Points are required');
            return;
        }

        $.post("<?= base_url('ajax/save-loyalty-points'); ?>", {
            min_amount: min,
            max_amount: max,
            points: pts,
            <?= csrf_token() ?>: "<?= csrf_hash() ?>"
        }, () => {
            $('#min_amount, #max_amount, #points').val('');
            loadLoyaltyRules();
        }, 'json');
    }

    function loadLoyaltyRules() {
        $.ajax({
            url: "<?= base_url('ajax/get-loyalty-points'); ?>",
            type: "GET",
            dataType: "json",
            success: function(res) {
                let html = '';
                if (res.length === 0) {
                    html = `<tr><td colspan="4" class="text-center">No records found</td></tr>`;
                } else {
                    res.forEach(function(row) {
                        html += `
                        <tr>
                            <td>$${row.min_amount}</td>
                            <td>${row.max_amount ? '$' + row.max_amount : '-'}</td>
                            <td>${row.points}</td>
                            <td>
                                <a href="javascript:void(0)"
                                   onclick="deleteItem(
                                       'ajax/delete-loyalty-points',
                                       '${row.id}',
                                       '<?= esc(trans("confirm_delete", true)); ?>',
                                       loadLoyaltyRules
                                   );"
                                   class="text-danger">
                                   <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?>
                                    <a href="#"
                                        class="text-danger btn-delete-loyalty-rule"
                                        data-url="ajax/delete-loyalty-points"
                                        data-id="${row.id}"
                                        data-msg="<?= esc(trans('confirm_delete', true)); ?>">
                                    <i class="fa fa-trash-can option-icon"></i><?= esc(trans('delete')); ?>
                                </a>
                                </a>
                            </td>
                        </tr>
                    `;
                    });
                }
                $('#loyaltyTable tbody').html(html);
            }
        });
    }

    $(loadLoyaltyRules);
</script>
