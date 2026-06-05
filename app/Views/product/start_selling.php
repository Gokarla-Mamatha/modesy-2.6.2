<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
                <h1 class="page-title page-title-product m-b-15"><?= esc(trans("start_selling")); ?></h1>
                <?= view('partials/_messages'); ?>
                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center">

                            <?php if (authCheck()):
                                if (user()->is_active_shop_request == 1): ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="showMsg showMsg-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                                </svg>&nbsp;
                                                <?= esc(trans("msg_shop_opening_requests")); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif (user()->is_active_shop_request == 2): ?>
                                    <div class="row">
                                        <div class="col-12 m-b-30">
                                            <div class="showMsg showMsg-danger display-block">
                                                <div class="m-b-10">
                                                    <strong><?= esc(trans("mgs_reject_open_shop")); ?></strong>
                                                </div>
                                                <div class="m-b-5">
                                                    <strong><?= esc(trans("reason")); ?>:</strong>
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
                                            <div class="showMsg showMsg-danger display-block">
                                                <div class="m-b-10">
                                                    <strong><?= esc(trans("mgs_reject_open_shop_permanently")); ?></strong>
                                                </div>
                                                <div class="m-b-5">
                                                    <strong><?= esc(trans("reason")); ?>:</strong>
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
                                            <!-- <form action="<?= base_url('start-selling-post'); ?>" method="post" enctype="multipart/form-data" id="form_validate" class="validate_terms validate-form" onkeypress="return event.keyCode != 13;"> -->
                                            <form action="<?= base_url('start-selling-post'); ?>"
                                                method="post"
                                                enctype="multipart/form-data"
                                                id="form_validate"
                                                class="validate_terms validate-form">
                                                
                                                <input type="hidden" id="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                                <input type="hidden" name="account_type" id="account_type" value="personal">

                                                <div class="register-layout">

                                                    <!-- LEFT SIDE IMAGE -->
                                                    <div class="register-left">
                                                        <img src="<?= base_url('assets/img/seller.png'); ?>" alt="Start Selling">

                                                        <div class="left-content">
                                                            <h2>Start Selling with DesiBazars</h2>
                                                            <p>
                                                                Reach thousands of customers, manage your business easily,
                                                                and grow your online presence with powerful seller tools.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="register-wrapper">
                                                        <div class="register-card" id="mainFormCard">
                                                            <div id="customshowMsg"></div>
                                                            <div id="formStep">
                                                                <h2>Create an account</h2>
                                                                <div class="account-toggle">
                                                                    <button type="button" id="personalBtn" class="active">Personal</button>
                                                                    <button type="button" id="businessBtn">Business</button>
                                                                </div>

                                                                <div id="personalForm" class="form-section active">

                                                                    <input type="text" name="first_name" placeholder="First name" data-type="name">
                                                                    <div class="error" id="error_first_name"></div>

                                                                    <input type="text" name="last_name" placeholder="Last name" data-type="name">
                                                                    <div class="error" id="error_last_name"></div>

                                                                    <input type="email" name="email_personal" placeholder="Email" data-type="email">
                                                                    <div class="error" id="error_email_personal"></div>

                                                                </div>

                                                                <div id="businessForm" class="form-section">

                                                                    <input type="text" name="business_name" placeholder="Business name" data-type="name" required>
                                                                    <div class="error" id="error_username"></div>

                                                                    <input type="email" name="business_email" placeholder="Business email" data-type="email" required>
                                                                    <div class="error" id="error_email_business"></div>

                                                                    <select name="country_id" class="form-control" required>
                                                                        <option value="">Where is your business registered?</option>
                                                                        <?php foreach ($activeCountries as $country): ?>
                                                                            <option value="<?= $country->id; ?>">
                                                                                <?= esc($country->name); ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <div class="error" id="error_country"></div>
                                                                    <label class="checkbox">
                                                                        <input type="checkbox" name="buyer_only">
                                                                        I'm only interested in buying
                                                                    </label>

                                                                </div>
                                                                <div class="form-group m-t-15">
                                                                    <div class="custom-control custom-checkbox custom-control-validate-input">
                                                                        <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions" value="1" >
                                                                        <label for="terms_conditions" class="custom-control-label"><?= esc(trans("terms_conditions_exp")); ?>&nbsp;
                                                                            <?php $pageTerms = getPageByDefaultName('terms_conditions', selectedLangId());
                                                                            if (!empty($pageTerms)): ?>
                                                                                <a href="<?= generateUrl($pageTerms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= esc($pageTerms->title); ?></strong></a>
                                                                            <?php endif; ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                               <button type="button" id="continueBtn" class="btn btn-lg btn-custom float-right"> Continue</button>
                                                            </div>

                                                            <div id="mobileOtpStep" class="step-box">

                                                                <h4>Mobile Verification</h4>

                                                                <p id="mobileMessage" class="msg-text"></p>

                                                                <div id="mobileInputBox">
                                                                    <input type="text" id="mobile_number" placeholder="Enter Mobile Number" data-type="mobile">

                                                                    <input type="hidden" name="phone_number" id="hidden_phone">

                                                                    <button type="button" id="sendOtpBtn" class="btn btn-custom"> Submit</button>
                                                                </div>

                                                                <div id="otpBox" class="hidden-box">

                                                                    <input type="text" id="otp" placeholder="Enter OTP">

                                                                    <button type="button" id="verifyOtpBtn" class="btn btn-success">
                                                                        Verify
                                                                    </button>

                                                                    <div class="resend-box">
                                                                        <button type="button" id="resendMobileBtn" class="resend-link" disabled>
                                                                            Resend OTP
                                                                        </button>
                                                                        <span id="mobileTimer"></span>
                                                                    </div>
                                                                    <span id="mobileTimer" class="timer-text"></span>

                                                                </div>

                                                            </div>
                                                            <div id="emailStep" class="step-box">

                                                                <h4>Email Verification</h4>

                                                                <p id="emailMessage" class="msg-text"></p>

                                                                <input type="text" id="email_otp" placeholder="Enter Email OTP">

                                                                <button type="button" id="verifyEmailBtn" class="btn btn-success">
                                                                    Verify Email
                                                                </button>
                                                                <div class="mt-10">
                                                                    <button type="button" id="resendEmailBtn" class="resend-link" disabled>
                                                                        Resend OTP
                                                                    </button>
                                                                    <span id="emailTimer" class="timer-text"></span>
                                                                </div>

                                                            </div>
                                                            <!-- PHONE OTP -->
                                                            <div id="phoneStep" class="step-box mt-3">
                                                                <h4>Phone Verification</h4>

                                                                <input type="text" id="business_phone" name="business_phone" placeholder="Enter Phone Number">
                                                                <input type="hidden" name="verified_business_phone" id="hidden_business_phone">

                                                                <button type="button" id="sendPhoneOtpBtn" class="btn btn-custom">Send OTP</button>

                                                                <div id="phoneOtpBox" class="hidden-box">
                                                                    <input type="text" id="phone_otp" placeholder="Enter OTP">

                                                                    <button type="button" id="verifyPhoneBtn" class="btn btn-success">Verify</button>

                                                                    <div class="resend-box">
                                                                        <button type="button" id="resendPhoneBtn" class="resend-link" disabled>
                                                                            Resend OTP
                                                                        </button>
                                                                        <span id="phoneTimer"></span>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>

                                                            <!-- BUSINESS TYPE -->
                                                            <div id="businessTypeStep" class="step-box">

                                                                <input type="hidden" name="business_type" id="business_type">

                                                                <div id="businessTypeQuestion">
                                                                    <h4>What type of business is this?</h4>

                                                                    <div class="business-options">
                                                                        <div class="business-card" data-type="sole">
                                                                            <h5>Sole proprietorship</h5>
                                                                        </div>

                                                                        <div class="business-card" data-type="registered">
                                                                            <h5>Registered business</h5>
                                                                        </div>

                                                                        <div class="business-card" data-type="nonprofit">
                                                                            <h5>Nonprofit</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="businessExtraFields" class="hidden-extra">
                                                                    <h4>Business Details</h4>

                                                                    <input type="text" name="legal_business_name" placeholder="Legal business name" data-type="name" required>
                                                                    <input type="text" name="doing_business_as" placeholder="Doing business as (optional)" data-type="text">
                                                                    <input type="text" name="ein_registered" id="ein_registered" placeholder="Employer ID Number (9 digits)" data-type="number" inputmode="numeric" maxlength="9" pattern="\d{9}">
                                                                     <!-- <button type="button" class="btn btn-secondary backBtn" data-back="businessTypeStep">
                                                                        Back
                                                                    </button> -->
                                                                </div>
                                                
                                                                <button type="button" id="goToStakeholdersBtn" class="btn btn-custom">
                                                                    Continue
                                                                </button>

                                                            </div>

                                                            <div id="soleDetailsStep" class="step-box">

                                                                <h4>Confirm account details</h4>

                                                                <p class="small-gray">
                                                                    Add your information (must match your government ID)
                                                                </p>

                                                                <!-- LEGAL NAME -->
                                                                <input type="text" name="legal_first_name" placeholder="First name" data-type="name" required>
                                                                <input type="text" name="legal_middle_name" placeholder="Middle name (optional)" data-type="name">
                                                                <input type="text" name="legal_last_name" placeholder="Last name" data-type="name" required>                        

                                                                <!-- ADDRESS -->
                                                                <input type="text" name="address_line1" placeholder="Street address" data-type="text" required>
                                                                <input type="text" name="address_line2" placeholder="Street address 2 (optional)" data-type="text">

                                                                <!-- COUNTRY / STATE / CITY (cascading) -->
                                                                <select id="select_countries_sole" name="sole_country_id" required>
                                                                    <option value=""><?= esc(trans('country')); ?></option>
                                                                    <?php foreach (($activeCountries ?? []) as $soleCountry): ?>
                                                                        <option value="<?= $soleCountry->id; ?>"><?= esc($soleCountry->name); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>

                                                                <div id="get_states_container_sole" class="display-none">
                                                                    <select id="select_states_sole" name="sole_state_id">
                                                                        <option value=""><?= esc(trans('state')); ?></option>
                                                                    </select>
                                                                </div>

                                                                <div id="get_cities_container_sole" class="display-none">
                                                                    <select id="select_cities_sole" name="sole_city_id">
                                                                        <option value=""><?= esc(trans('city')); ?></option>
                                                                    </select>
                                                                </div>

                                                                <input type="text" name="zip" placeholder="ZIP Code" data-type="number" required>

                                                                <!-- PHONE -->
                                                                <input type="text" name="contact_phone" placeholder="Phone number" data-type="mobile" required>

                                                               <div class="d-flex justify-content-between mt-15">
                                                                    <button type="button" class="btn btn-secondary backBtn" data-back="businessTypeStep">
                                                                        Back
                                                                    </button>

                                                                    <button type="button" id="goNextFromSoleBtn" class="btn btn-custom">
                                                                        Continue
                                                                    </button>
                                                                </div>

                                                            </div>

                                                            <!-- STAKEHOLDERS -->
                                                            <div id="stakeholderStep" class="step-box">
                                                                <h4>Stakeholders</h4>

                                                                <input type="text" id="director_name" data-type="title" placeholder="Director Name" required>
                                                                <input type="text" id="director_role" data-type="title" placeholder="Role" required>

                                                                <button type="button" id="addDirectorBtn" class="btn btn-custom btn-sm">
                                                                    Add Member
                                                                </button>

                                                                <ul id="directorList" class="director-list"></ul>

                                                                <button type="button" id="goToPayoutBtn" class="btn btn-custom mt-15">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                            <!-- PAYOUT -->
                                                            <div id="payoutStep" class="step-box">
                                                                <h4>Payout Information</h4>

                                                                <input type="text" name="account_number" placeholder="Account Number" data-type="number" required>
                                                                <!-- <input type="text" name="ifsc_code" placeholder="IFSC Code" data-type="text" required> -->

                                                                <button id="goToReviewBtn" class="btn btn-custom">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                            <!-- REVIEW -->
                                                            <div id="reviewStep" class="step-box">
                                                                <h4>Review & Submit</h4>

                                                                <button id="finalSubmitBtn" class="btn btn-success">
                                                                    Submit
                                                                </button>
                                                            </div>


                                                        </div>
                                                        <!-- ================= BUSINESS FLOW ================= -->
                                                        <!-- EMAIL OTP -->

                                                    </div>
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
    function getCsrfData() {
        let csrfInput = document.getElementById("csrf_token");

        return {
            csrfName: csrfInput.name,
            csrfHash: csrfInput.value
        };
    }
    function showMsg(msg) {
        let box = document.getElementById("customshowMsg");
        box.innerText = msg;
        box.style.display = "block";
    }
    function hideMsg() {
    let box = document.getElementById("customshowMsg");
    box.innerText = "";
    box.style.display = "none";
}
      function selectBusinessType(type, el) {

        document.querySelectorAll(".business-card").forEach(card => {
            card.classList.remove("active");
        });

        el.classList.add("active");
        document.getElementById("business_type").value = type;

        if (type === "sole") {
            hideAllSteps();
            document.getElementById("soleDetailsStep").classList.add("active");
            return;
        }

        let businessTypeQuestion = document.getElementById("businessTypeQuestion");
        let businessExtraFields = document.getElementById("businessExtraFields");
            businessTypeQuestion.style.display = "none";
        if (type === "registered") {
            businessExtraFields.style.display = "block";
        } else {
            businessExtraFields.style.display = "none";
        }
    }

    function goToStakeholders() {
    let type = document.getElementById("business_type").value;

    if (!type) {
        showMsg("Select business type");
        return;
    }

    if (type === "registered") {
        let legalName = document.querySelector('#businessExtraFields input[name="legal_business_name"]');
        let ein = document.querySelector('#businessExtraFields input[name="ein_registered"]');

        if (!legalName.value.trim()) {
            legalName.focus();
            showMsg("Enter legal business name");
            return;
        }

        let einVal = ein.value.trim();
        if (!einVal) {
            ein.focus();
            showMsg("Enter Employer ID Number");
            return;
        }

        if (!/^\d{9}$/.test(einVal)) {
            ein.focus();
            showMsg("Employer ID Number must be exactly 9 digits");
            return;
        }

        hideMsg();
        hideAllSteps();
            document.getElementById("stakeholderStep").classList.add("active");
            return;
        }

        if (type === "sole") {
            hideAllSteps();
            document.getElementById("soleDetailsStep").classList.add("active");
            return;
        }

        if (type === "nonprofit") {
            hideAllSteps();
            document.getElementById("stakeholderStep").classList.add("active");
            return;
        }
    }

    document.getElementById("form_validate").addEventListener("submit", function(e) {
        // ❌ block accidental submit during steps
        if (!window.allowSubmit) {
            e.preventDefault();
        }
    });

    // Cascading country -> state -> city for the sole step (uses global getStates/getCities)
    document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'select_countries_sole') {
            getStates(e.target.value, 'sole');
        } else if (e.target && e.target.id === 'select_states_sole') {
            getCities(e.target.value, 'sole');
        }
    });

    // Allow only digits (max 9) in the Employer ID Number field
    document.addEventListener('input', function (e) {
        if (e.target && e.target.id === 'ein_registered') {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 9);
        }
    });
    document.addEventListener("DOMContentLoaded", function() {

    const personalBtn = document.getElementById("personalBtn");
    const businessBtn = document.getElementById("businessBtn");
    const continueBtn = document.getElementById("continueBtn");

    const personalForm = document.getElementById("personalForm");
    const businessForm = document.getElementById("businessForm");
    const accountType = document.getElementById("account_type");

    personalBtn.addEventListener("click", function () {

        personalBtn.classList.add("active");
        businessBtn.classList.remove("active");

        personalForm.classList.add("active");
        businessForm.classList.remove("active");

        accountType.value = "personal";
    });

    businessBtn.addEventListener("click", function () {

        businessBtn.classList.add("active");
        personalBtn.classList.remove("active");

        businessForm.classList.add("active");
        personalForm.classList.remove("active");

        accountType.value = "business";
    });

    // CONTINUE BUTTON
    continueBtn.addEventListener("click", function () {
        handleStartSelling();
    });

    });

    function hideAllSteps() {
        hideMsg(); 

        document.querySelectorAll(".step-box").forEach(el => {
            el.classList.remove("active");
        });
    }

    function handleStartSelling() {
        let terms = document.getElementById("terms_conditions");

        if (!terms.checked) {
            showMsg("Please accept Terms and Conditions");
            return;
        }

        hideMsg(); // ✅ add this

        let type = document.getElementById("account_type").value;
        hideAllSteps();

        if (type === "personal") {
            if (!validatePersonal()) return;

            document.getElementById("formStep").style.display = "none";
            document.getElementById("mobileOtpStep").classList.add("active");

        } else if (type === "business") {
            if (!validateBusiness()) return;

            document.getElementById("formStep").style.display = "none";

            let email = document.querySelector('input[name="business_email"]').value;
            document.getElementById("emailStep").classList.add("active");
            document.getElementById("emailMessage").innerText =
                "Sending OTP to: " + email;

            sendEmailOtp();
        }
    }
    function validatePersonal() {
        let isValid = true;

        let first = document.querySelector('input[name="first_name"]');
        let last = document.querySelector('input[name="last_name"]');
        let email = document.querySelector('input[name="email_personal"]');

        document.getElementById("error_first_name").innerText = "";
        document.getElementById("error_last_name").innerText = "";
        document.getElementById("error_email_personal").innerText = "";

        if (!first.value.trim()) {
            document.getElementById("error_first_name").innerText = "First name required";
            isValid = false;
        }

        if (!last.value.trim()) {
            document.getElementById("error_last_name").innerText = "Last name required";
            isValid = false;
        }

        if (!email.value.trim()) {
            document.getElementById("error_email_personal").innerText = "Email required";
            isValid = false;
        } else if (!validateEmail(email.value)) {
            document.getElementById("error_email_personal").innerText = "Invalid email";
            isValid = false;
        }

        return isValid;
    }

    function validateEmail(email) {
        let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function validateBusiness() {
        let isValid = true;

        let name = document.querySelector('input[name="business_name"]');
        let email = document.querySelector('input[name="business_email"]');
        let country = document.querySelector('select[name="country_id"]');

        // clear old errors
        document.getElementById("error_username").innerText = "";
        document.getElementById("error_email_business").innerText = "";
        document.getElementById("error_country").innerText = "";

        if (!name.value.trim()) {
            document.getElementById("error_username").innerText = "Business name is required";
            isValid = false;
        }

        if (!email.value.trim()) {
            document.getElementById("error_email_business").innerText = "Email is required";
            isValid = false;
        } else if (!validateEmail(email.value)) {
            document.getElementById("error_email_business").innerText = "Invalid email";
            isValid = false;
        }

        if (!country.value) {
            document.getElementById("error_country").innerText = "Select country";
            isValid = false;
        }

        return isValid;
    }

    function sendEmailOtp() {

        let email = document.querySelector('input[name="business_email"]').value;

        let csrf = getCsrfData();

        fetch('<?= base_url("seller/send-email-otp"); ?>', {

            method: 'POST',

            credentials: 'same-origin',

            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },

            body:
                'email=' + encodeURIComponent(email) +
                '&' + csrf.csrfName + '=' + encodeURIComponent(csrf.csrfHash)

        })
        .then(async res => {

            let text = await res.text();

            try {
                return JSON.parse(text);
            } catch (e) {
                console.log(text);
                throw new Error("Invalid JSON response");
            }

        })
        .then(data => {

            if (data.token) {
                let csrfInput = document.getElementById("csrf_token");
                csrfInput.value = data.token;

                if (data.csrfName) {
                    csrfInput.name = data.csrfName;
                }
            }

            if (data.status == 1) {

                startTimer("resendEmailBtn", "emailTimer");

            } else {

                showMsg(data.msg);

            }

        })
        .catch(err => {
            console.log(err);
        });
    }

    function verifyEmail() {
        let otp = document.getElementById("email_otp").value.trim();
        let csrfInput = document.getElementById("csrf_token");

        let formData = new FormData();
        formData.append("otp", otp);
        formData.append(csrfInput.name, csrfInput.value);

        fetch('<?= base_url("seller/verify-email-otp"); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(async res => {
            let text = await res.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                console.log(text);
                throw new Error("Invalid JSON response");
            }
        })
        .then(data => {
            if (data.token) {
                csrfInput.value = data.token;
            }

            if (data.status == 1) {
                hideAllSteps();
                document.getElementById("phoneStep").classList.add("active");
            } else {
                showMsg(data.msg);
            }
        })
        .catch(err => console.log(err));
    }

    function resendEmailOtp() {
        let csrf = getCsrfData();

        fetch('<?= base_url("seller/resend-email-otp"); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: csrf.csrfName + '=' + encodeURIComponent(csrf.csrfHash)
        })
        .then(res => res.json())
        .then(data => {
            let csrfInput = document.getElementById("csrf_token");

            if (data.token) csrfInput.value = data.token;
            if (data.csrfName) csrfInput.name = data.csrfName;

            if (data.status == 1) {
                showMsg(data.msg);
                startTimer("resendEmailBtn", "emailTimer");
            } else {
                showMsg(data.msg);
            }
        })
        .catch(err => console.log(err));
    }

    function sendPhoneOtp() {
        let phone = document.getElementById("business_phone").value.trim();
        let csrf = getCsrfData();

        if (!phone) {
            showMsg("Enter phone number");
            return;
        }

        document.getElementById("hidden_business_phone").value = phone;

        fetch('<?= base_url("seller/send-otp"); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body:
                'mobile=' + encodeURIComponent(phone) +
                '&' + csrf.csrfName + '=' + encodeURIComponent(csrf.csrfHash)
        })
        .then(res => res.json())
        .then(data => {
            let csrfInput = document.getElementById("csrf_token");

            if (data.token) csrfInput.value = data.token;
            if (data.csrfName) csrfInput.name = data.csrfName;

            if (data.status == 1) {
                showMsg(data.msg);
                document.getElementById("phoneOtpBox").style.display = "block";
                startTimer("resendPhoneBtn", "phoneTimer");
            } else {
                showMsg(data.msg);
            }
        })
        .catch(err => console.log(err));
    }

    function verifyPhone() {
        let otp = document.getElementById("phone_otp").value.trim();
        let csrf = getCsrfData();

        fetch('<?= base_url("seller/verify-otp"); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body:
                'otp=' + encodeURIComponent(otp) +
                '&' + csrf.csrfName + '=' + encodeURIComponent(csrf.csrfHash)
        })
        .then(res => res.json())
        .then(data => {
            let csrfInput = document.getElementById("csrf_token");

            if (data.token) csrfInput.value = data.token;
            if (data.csrfName) csrfInput.name = data.csrfName;

            if (data.status == 1) {
                hideAllSteps();
                document.getElementById("businessTypeStep").classList.add("active");
            } else {
                showMsg(data.msg);
            }
        })
        .catch(err => console.log(err));
    }

    function resendPhoneOtp() {
        let csrf = getCsrfData();

        fetch('<?= base_url("seller/resend-otp"); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: csrf.csrfName + '=' + encodeURIComponent(csrf.csrfHash)
        })
        .then(res => res.json())
        .then(data => {
            let csrfInput = document.getElementById("csrf_token");

            if (data.token) csrfInput.value = data.token;
            if (data.csrfName) csrfInput.name = data.csrfName;

            if (data.status == 1) {
                showMsg(data.msg);
                startTimer("resendPhoneBtn", "phoneTimer");
            } else {
                showMsg(data.msg);
            }
        })
        .catch(err => console.log(err));
    }

    function sendOtp() {
 
        let mobile = document.getElementById("mobile_number").value;

        if (!mobile) {
            showMsg("Enter mobile number");
            return;
        }

        // store in hidden input
        document.getElementById("hidden_phone").value = mobile;

        // GET CSRF
        let csrf = getCsrfData();

        fetch('<?= base_url("seller/send-otp"); ?>', {

            method: 'POST',

            credentials: 'same-origin',

            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },

            body:
                'mobile=' + encodeURIComponent(mobile) +
                '&' + csrf.csrfName + '=' + encodeURIComponent(csrf.csrfHash)

        })
        .then(res => res.json())
        .then(data => {
            
            // UPDATE CSRF TOKEN
            if (data.token) {
                document.getElementById("csrf_token").value = data.token;
            }

            if (data.status == 1) {
                hideMsg();
                let last4 = mobile.slice(-4);

                document.getElementById("mobileMessage").innerText =
                    "OTP sent to ******" + last4;

                document.getElementById("mobileInputBox").style.display = "none";

                document.getElementById("otpBox").style.display = "block";

                startTimer("resendMobileBtn", "mobileTimer");

            } else {

                showMsg(data.msg);

            }

        })
        .catch(err => {
            console.log(err);
        });
    }

    function verifyOtp() {

        let otp = document.getElementById("otp").value;

        let csrfName = '<?= csrf_token() ?>';

        let csrfHash = document.getElementById("csrf_token").value;

        fetch('<?= base_url("seller/verify-otp"); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body:
                'otp=' + encodeURIComponent(otp) +
                '&' + csrfName + '=' + encodeURIComponent(csrfHash)
        })
        .then(res => res.json())
        .then(data => {

            // ✅ UPDATE NEW TOKEN
            if (data.token) {
                document.getElementById("csrf_token").value = data.token;
            }

            if (data.status == 1) {

                showMsg("Mobile Verified ✅");

                hideAllSteps();

                document.getElementById("businessTypeStep").classList.add("active");

            } else {

                showMsg(data.msg);

            }
            
        })
        .catch(err => {
            console.log(err);
        });

    }

    function resendOtp() {
        let csrf = getCsrfData();

        fetch('<?= base_url("seller/resend-otp"); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: csrf.csrfName + '=' + encodeURIComponent(csrf.csrfHash)
        })
        .then(res => res.json())
        .then(data => {
            let csrfInput = document.getElementById("csrf_token");

            if (data.token) {
                csrfInput.value = data.token;
            }

            if (data.csrfName) {
                csrfInput.name = data.csrfName;
            }

            if (data.status == 1) {
                showMsg(data.msg);
                startTimer("resendMobileBtn", "mobileTimer");
            } else {
                showMsg(data.msg);
            }
        })
        .catch(err => console.log(err));
    }

    let interval;

    function startTimer(btnId, timerId) {
        let time = 30;

        let btn = document.getElementById(btnId);
        let timer = document.getElementById(timerId);

        btn.disabled = true;

        if (interval) clearInterval(interval);

        interval = setInterval(() => {
            time--;
            timer.innerText = "Resend in " + time + "s";

            if (time <= 0) {
                clearInterval(interval);
                btn.disabled = false;
                timer.innerText = "";
            }
        }, 1000);
    }

    function goNextFromSole() {

        let step = document.getElementById("soleDetailsStep");
        let fields = step.querySelectorAll("input[required], select[required]");

        for (let field of fields) {
            if (!field.value.trim()) {
                field.focus();
                showMsg("Please fill all required fields");
                return;
            }
        }

        hideMsg();
        hideAllSteps();

        document.getElementById("payoutStep").classList.add("active");
    }

    let directorIndex = 0;

    function addDirector() {
        let name = document.getElementById("director_name").value.trim();
        let role = document.getElementById("director_role").value.trim();

        if (!name || !role) {
            showMsg("Enter director details");
            return;
        }

        let idx = directorIndex++;

        let li = document.createElement("li");
        let strong = document.createElement("strong");
        strong.textContent = name;
        let span = document.createElement("span");
        span.textContent = role;
        li.appendChild(strong);
        li.appendChild(document.createTextNode(" - "));
        li.appendChild(span);

        // remove button
        let removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.className = "btn btn-sm director-remove";
        removeBtn.textContent = "Remove";
        removeBtn.addEventListener("click", function () {
            li.remove();
        });
        li.appendChild(removeBtn);

        // hidden inputs so the stakeholder is submitted and stored as JSON
        let nameInput = document.createElement("input");
        nameInput.type = "hidden";
        nameInput.name = "stakeholders[" + idx + "][name]";
        nameInput.value = name;

        let roleInput = document.createElement("input");
        roleInput.type = "hidden";
        roleInput.name = "stakeholders[" + idx + "][role]";
        roleInput.value = role;

        li.appendChild(nameInput);
        li.appendChild(roleInput);

        document.getElementById("directorList").appendChild(li);

        document.getElementById("director_name").value = "";
        document.getElementById("director_role").value = "";
    }

    function goToPayout() {

        hideAllSteps();

        document.getElementById("payoutStep").classList.add("active");
    }

    function goToReview() {

        let step = document.getElementById("payoutStep");
        let fields = step.querySelectorAll("input[required]");

        for (let field of fields) {
            if (!field.value.trim()) {
                field.focus();
                showMsg("Please fill payout information");
                return;
            }
        }

        hideMsg();
        hideAllSteps();

        document.getElementById("reviewStep").classList.add("active");
    }

    function finalSubmit() {

        window.allowSubmit = true;

        document.getElementById("form_validate").submit();
    }

    document.addEventListener("DOMContentLoaded", function () {

       const sendOtpBtn = document.getElementById("sendOtpBtn");

        if (sendOtpBtn) {
            sendOtpBtn.addEventListener("click", sendOtp);
        }
        // MOBILE OTP
        const verifyOtpBtn = document.getElementById("verifyOtpBtn");
        if (verifyOtpBtn) {
            verifyOtpBtn.addEventListener("click", verifyOtp);
        }

        const resendMobileBtn = document.getElementById("resendMobileBtn");
        if (resendMobileBtn) {
            resendMobileBtn.addEventListener("click", resendOtp);
        }

        // EMAIL OTP
        const verifyEmailBtn = document.getElementById("verifyEmailBtn");
        if (verifyEmailBtn) {
            verifyEmailBtn.addEventListener("click", verifyEmail);
        }

        const resendEmailBtn = document.getElementById("resendEmailBtn");
        if (resendEmailBtn) {
            resendEmailBtn.addEventListener("click", resendEmailOtp);
        }

        // PHONE OTP
        const sendPhoneOtpBtn = document.getElementById("sendPhoneOtpBtn");
        if (sendPhoneOtpBtn) {
            sendPhoneOtpBtn.addEventListener("click", sendPhoneOtp);
        }

        const verifyPhoneBtn = document.getElementById("verifyPhoneBtn");
        if (verifyPhoneBtn) {
            verifyPhoneBtn.addEventListener("click", verifyPhone);
        }

        // BUSINESS TYPE
        document.querySelectorAll(".business-card").forEach(card => {

            card.addEventListener("click", function () {

                let type = this.dataset.type;

                selectBusinessType(type, this);
            });
        });

        // STAKEHOLDER
        const goToStakeholdersBtn = document.getElementById("goToStakeholdersBtn");
        if (goToStakeholdersBtn) {
            goToStakeholdersBtn.addEventListener("click", goToStakeholders);
        }

        // SOLE DETAILS
        const goNextFromSoleBtn = document.getElementById("goNextFromSoleBtn");
        if (goNextFromSoleBtn) {
            goNextFromSoleBtn.addEventListener("click", goNextFromSole);
        }

        // DIRECTOR
        const addDirectorBtn = document.getElementById("addDirectorBtn");
        if (addDirectorBtn) {
            addDirectorBtn.addEventListener("click", addDirector);
        }

        const goToPayoutBtn = document.getElementById("goToPayoutBtn");
        if (goToPayoutBtn) {
            goToPayoutBtn.addEventListener("click", goToPayout);
        }

        // PAYOUT
        const goToReviewBtn = document.getElementById("goToReviewBtn");
        if (goToReviewBtn) {
            goToReviewBtn.addEventListener("click", goToReview);
        }

        // FINAL SUBMIT
        const finalSubmitBtn = document.getElementById("finalSubmitBtn");
        if (finalSubmitBtn) {
            finalSubmitBtn.addEventListener("click", finalSubmit);
        }
        const resendPhoneBtn = document.getElementById("resendPhoneBtn");
        if (resendPhoneBtn) {
            resendPhoneBtn.addEventListener("click", resendPhoneOtp);
        }

    });
</script>
<style <?= csp_style_nonce() ?>>
    #registeredFields input {
        margin-bottom: 10px;
    }

    #registeredFields h5 {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .business-options {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin: 15px 0;
    }

    .business-card {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 15px;
        cursor: pointer;
        transition: 0.2s;
    }

    .business-card:hover {
        border-color: #ff6a00;
        background: #fff7f0;
    }

    .business-card.active {
        border: 2px solid #ff6a00;
        background: #fff3e8;
    }

    .business-card h5 {
        margin: 0;
        font-size: 15px;
    }

    .business-card p {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
    }

    .error {
        color: red;
        font-size: 12px;
        margin-top: -8px;
        margin-bottom: 8px;
    }

    .step-box {
        margin-top: 15px;
        display: none;
        max-width: 420px;
        background: #fff;
        padding: 28px;
        border-radius: 16px;
    }

    .step-box.active {
        display: block;
    }

    .step-box input {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }

    .checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        margin-top: 8px;
    }

    .checkbox input[type="checkbox"] {
        width: 14px;
        height: 14px;
        margin: 0;
    }

    .checkbox label,
    .checkbox {
        cursor: pointer;
    }

    .register-layout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 40px;
        max-width: 1300px;
        margin: auto;
        padding: 50px 20px;
    }

    /* ===============================
   LEFT SIDE
=================================*/
    .register-left {
        flex: 1;
        min-height: 700px;
        border-radius: 24px;
        overflow: hidden;
        position: relative;
        background: #f5f7ff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-left img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        inset: 0;
    }

    .register-left::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg,
                rgba(0, 0, 0, 0.15),
                rgba(0, 0, 0, 0.55));
        z-index: 1;
    }

    .left-content {
        position: relative;
        z-index: 2;
        color: #fff;
        padding: 40px;
        max-width: 500px;
    }

    .left-content h2 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 18px;
        line-height: 1.2;
    }

    .left-content p {
        font-size: 16px;
        line-height: 1.7;
        opacity: 0.95;
    }

    /* ===============================
   RIGHT SIDE FORM
=================================*/
    .register-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* CARD */
    .register-card {
        width: 100%;
        max-width: 650px;
        border-radius: 24px;
        padding: 40px;
        background: #fff;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
    }

    /* ===============================
   RESPONSIVE
=================================*/
    @media(max-width:991px) {

        .register-layout {
            flex-direction: column;
        }

        .register-left {
            min-height: 320px;
            width: 100%;
        }

        .left-content h2 {
            font-size: 30px;
        }

        .register-card {
            max-width: 100%;
        }
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
    .msg-text{
    font-size:14px;
    color:gray;
    }

    .timer-text{
        font-size:12px;
        color:gray;
    }

    .hidden-box{
        display:none;
    }

    .hidden-extra{
        display:none;
        margin-top:15px;
    }

    .mt-10{
        margin-top:10px;
    }

    .mt-15{
        margin-top:15px;
    }

    .small-gray{
        font-size:13px;
        color:#777;
    }

    .tiny-gray{
        font-size:12px;
        color:#777;
    }
    .registered-fields{
        display:none;
        margin-top:20px;
    }
    .director-list {
        list-style: none;
        padding: 0;
        margin: 12px 0;
    }

    .director-list li {
        background: #f7f7f7;
        border: 1px solid #ddd;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        font-size: 14px;
    }

    #addDirectorBtn {
        margin-bottom: 10px;
    }

    #goToPayoutBtn {
        width: 100%;
    }
    .resend-box {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .resend-box button {
        background: none;
        border: none;
        color: #ff6a00;
        font-size: 13px;
        cursor: pointer;
        padding: 0;
    }

    .resend-box button:disabled {
        color: #999;
        cursor: not-allowed;
    }

    .resend-box span {
        font-size: 12px;
        color: #777;
    }
    #customshowMsg {
        display: none;
        color: red;
        background: #fff3f3;
        border: 1px solid #ffb3b3;
        padding: 10px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 12px;
    }
</style>