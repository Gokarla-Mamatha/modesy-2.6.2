<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
                <h1 class="page-title page-title-product m-b-15"><?= trans("start_selling"); ?></h1>
                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center">
                            <!-- <div class="row">
                                <div class="col-12">
                                    <p class="start-selling-description text-muted"><?= trans("start_selling_exp"); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?= view('partials/_messages'); ?>
                                </div>
                            </div> -->
                            <?php if (authCheck()):
                                if (user()->is_active_shop_request == 1): ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert alert-info" role="alert">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                                </svg>&nbsp;
                                                <?= trans("msg_shop_opening_requests"); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif (user()->is_active_shop_request == 2): ?>
                                    <div class="row">
                                        <div class="col-12 m-b-30">
                                            <div class="alert alert-danger display-block" role="alert">
                                                <div class="m-b-10">
                                                    <strong><?= trans("mgs_reject_open_shop"); ?></strong>
                                                </div>
                                                <div class="m-b-5">
                                                    <strong><?= trans("reason"); ?>:</strong>
                                                </div>
                                                <div>
                                                    <?= esc(user()->shop_request_reject_reason); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif (user()->is_active_shop_request == 3): ?>
                                    <div class="row">
                                        <div class="col-12 m-b-30">
                                            <div class="alert alert-danger display-block" role="alert">
                                                <div class="m-b-10">
                                                    <strong><?= trans("mgs_reject_open_shop_permanently"); ?></strong>
                                                </div>
                                                <div class="m-b-5">
                                                    <strong><?= trans("reason"); ?>:</strong>
                                                </div>
                                                <div>
                                                    <?= esc(user()->shop_request_reject_reason); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (user()->is_active_shop_request == 0 || user()->is_active_shop_request == 2): ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="<?= base_url('start-selling-post'); ?>" method="post" enctype="multipart/form-data" id="form_validate" class="validate_terms validate-form" onkeypress="return event.keyCode != 13;">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="back_url" value="<?= getCurrentUrl(); ?>">
                                                <?php if (!empty($plan)): ?>
                                                    <input type="hidden" name="plan_id" value="<?= $plan->id; ?>">
                                                <?php endif; ?>
                                                <input type="hidden" name="account_type" id="account_type" value="personal">
                                                <div class="form-box m-b-30">
                                                    <div class="form-box-head text-center">
                                                        <h4 class="title title-start-selling-box font-700 m-b-30"><?= trans('tell_us_about_shop'); ?></h4>
                                                    </div>
                                                    <div class="form-box-body">
                                                        <!-- <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6 m-b-15">
                                                                <label class="control-label"><?= trans("first_name"); ?></label>
                                                                <input type="text" name="first_name" class="form-control form-input" value="<?= esc(user()->first_name); ?>" placeholder="<?= trans("first_name"); ?>" required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 m-b-15">
                                                                <label class="control-label"><?= trans("last_name"); ?></label>
                                                                <input type="text" name="last_name" class="form-control form-input" value="<?= esc(user()->last_name); ?>" placeholder="<?= trans("last_name"); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6 m-b-15">
                                                                <label class="control-label"><?= trans("shop_name"); ?></label>
                                                                <input type="text" name="username" class="form-control form-input" value="<?= esc(getUsername(user())); ?>" placeholder="<?= trans("shop_name"); ?>" maxlength="255" required>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 m-b-15">
                                                                <label class="control-label"><?= trans("phone_number"); ?></label>
                                                                <input type="text" name="phone_number" class="form-control form-input" value="<?= esc(user()->phone_number); ?>" placeholder="<?= trans("phone_number"); ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><?= trans('location'); ?></label>
                                                        <?= view('partials/_location', ['countries' => $activeCountries, 'countryId' => user()->country_id, 'stateId' => user()->state_id, 'cityId' => user()->city_id]); ?>
                                                    </div>
                                                    <?php if ($generalSettings->request_documents_vendors == 1): ?>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <?= trans("required_files"); ?>
                                                                <?php if (!empty($generalSettings->explanation_documents_vendors)): ?>
                                                                    <span class="text-muted">(<?= $generalSettings->explanation_documents_vendors; ?>)</span>
                                                                <?php endif; ?>
                                                            </label>
                                                            <div class="m-b-15">
                                                                <a class='btn btn-lg btn-info btn-file-upload btn-file-upload-start-selling'>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                                                                        <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2z"/>
                                                                    </svg>&nbsp;
                                                                    <?= trans('select_file'); ?>
                                                                    <input type="file" name="file[]" size="40" id="input_vendor_files" multiple required>
                                                                </a>
                                                                <div id="container_vendor_files"></div>
                                                            </div>
                                                            <div id="input_vendor_files_flash_error" class="text-danger display-none"><?= transWithField('form_validation_required', trans('required_files')); ?></div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="form-group">
                                                        <label class="control-label"><?= trans("shop_description"); ?></label>
                                                        <textarea name="about_me" class="form-control form-textarea" data-type="text" placeholder="<?= trans("shop_description"); ?>"><?= user()->about_me; ?></textarea>
                                                    </div> -->

                                                        <div class="register-wrapper">
                                                            <div class="register-card">

                                                                <h2>Create an account</h2>

                                                                <div class="account-toggle">
                                                                    <button type="button" id="personalBtn" class="active">Personal</button>
                                                                    <button type="button" id="businessBtn">Business</button>
                                                                </div>

                                                                <!-- ================= PERSONAL ================= -->
                                                                <div id="personalForm" class="form-section active">

                                                                    <div class="row2">
                                                                        <input type="text" name="first_name"
                                                                            value="<?= esc(user()->first_name); ?>"
                                                                            placeholder="First name" required>

                                                                        <input type="text" name="last_name"
                                                                            value="<?= esc(user()->last_name); ?>"
                                                                            placeholder="Last name" required>
                                                                    </div>

                                                                    <input type="email" name="email_personal"
                                                                        value="<?= esc(user()->email); ?>"
                                                                        placeholder="Email" required>

                                                                    <div class="password-box">
                                                                        <input type="password" id="passwordPersonal" name="password_personal" placeholder="Password" required>
                                                                        <span class="toggle-password fa-solid fa-eye" toggle="#passwordPersonal"></span>
                                                                    </div>

                                                                    <button type="submit" class="create-btn">
                                                                        Create personal account
                                                                    </button>
                                                                </div>

                                                                <!-- ================= BUSINESS ================= -->
                                                                <div id="businessForm" class="form-section">

                                                                    <p class="info-text">
                                                                        Continue to register as a business...
                                                                    </p>

                                                                    <input type="text" name="username"
                                                                        value="<?= esc(getUsername(user())); ?>"
                                                                        placeholder="Business name" required>

                                                                    <input type="email" name="email_business"
                                                                        value="<?= esc(user()->email); ?>"
                                                                        placeholder="Business email" required>

                                                                    <div class="password-box">
                                                                        <input type="password" id="passwordBusiness" name="password_business" placeholder="Password" required>
                                                                        <span class="toggle-password fa fa-eye" toggle="#passwordBusiness"></span>
                                                                    </div>

                                                                    <select>
                                                                        <option>Where is your business registered?</option>
                                                                    </select>

                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="buyer_only">
                                                                        I'm only interested in buying
                                                                    </label>

                                                                    <button type="submit" class="create-btn">
                                                                        Create business account
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-t-15">
                                                        <div class="custom-control custom-checkbox custom-control-validate-input">
                                                            <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions" value="1" required>
                                                            <label for="terms_conditions" class="custom-control-label"><?= trans("terms_conditions_exp"); ?>&nbsp;
                                                                <?php $pageTerms = getPageByDefaultName('terms_conditions', selectedLangId());
                                                                if (!empty($pageTerms)): ?>
                                                                    <a href="<?= generateUrl($pageTerms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= esc($pageTerms->title); ?></strong></a>
                                                                <?php endif; ?>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-lg btn-custom float-right" onclick="validateFileInput('input_vendor_files');"><?= trans("submit"); ?></button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                            <?php endif;
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script <?= csp_script_nonce() ?>>
    document.addEventListener("DOMContentLoaded", function() {

        const personalBtn = document.getElementById("personalBtn");
        const businessBtn = document.getElementById("businessBtn");

        const personalForm = document.getElementById("personalForm");
        const businessForm = document.getElementById("businessForm");
        const accountType = document.getElementById("account_type");

        personalBtn.onclick = () => {
            personalBtn.classList.add("active");
            businessBtn.classList.remove("active");

            personalForm.classList.add("active");
            businessForm.classList.remove("active");

            accountType.value = "personal";
        };

        businessBtn.onclick = () => {
            businessBtn.classList.add("active");
            personalBtn.classList.remove("active");

            businessForm.classList.add("active");
            personalForm.classList.remove("active");

            accountType.value = "business";
        };

        // PASSWORD TOGGLE
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");

            var input = $($(this).attr("toggle"));

            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }

        });

    });
</script>
<style <?= csp_style_nonce() ?>>
    .register-wrapper {
        display: flex;
        justify-content: center;
        padding: 40px 0;
    }


    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #555;
        font-size: 16px;
    }

    .register-card {
        width: 420px;
        background: #fff;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        font-family: sans-serif;
    }

    .register-card h2 {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* TOGGLE */
    .account-toggle {
        display: flex;
        background: #eee;
        border-radius: 30px;
        padding: 3px;
        margin-bottom: 20px;
    }

    .account-toggle button {
        flex: 1;
        border: none;
        background: transparent;
        padding: 8px;
        border-radius: 30px;
        cursor: pointer;
    }

    .account-toggle .active {
        background: #000;
        color: #fff;
    }

    /* FORM */
    .form-section {
        display: none;
    }

    .form-section.active {
        display: block;
    }

    .row2 {
        display: flex;
        gap: 10px;
    }

    input,
    select {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }

    /* PASSWORD */
    .password-box {
        position: relative;
    }

    .password-box input {
        width: 100%;
        padding-right: 45px;
        /* space for icon */
    }

    .eye-icon {
        position: absolute;
        right: 10px;
        top: 10px;
    }

    /* TEXT */
    .info-text {
        font-size: 13px;
        margin-bottom: 10px;
    }

    .small-text {
        font-size: 12px;
        color: #777;
        margin-bottom: 10px;
    }

    .terms-text {
        font-size: 12px;
        color: #666;
        margin-bottom: 15px;
    }

    /* BUTTON */
    .create-btn {
        width: 100%;
        padding: 12px;
        border-radius: 25px;
        border: none;
        background: #ccc;
        color: #fff;
    }

    /* SOCIAL */
    .divider {
        text-align: center;
        margin: 15px 0;
        font-size: 12px;
        color: #777;
    }

    .social-btns {
        display: flex;
        gap: 10px;
    }

    .social-btns button {
        flex: 1;
        padding: 10px;
        border-radius: 25px;
        border: 1px solid #ddd;
        background: #fff;
    }

    /* CHECKBOX */
    .checkbox {
        font-size: 13px;
        display: flex;
        gap: 8px;
        margin: 10px 0;
    }
</style>