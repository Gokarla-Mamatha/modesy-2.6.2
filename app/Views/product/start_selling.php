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

                            <?php if (authCheck()):
                                if (user()->is_active_shop_request == 1): ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert alert-info">
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
                                            <div class="alert alert-danger display-block">
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
                                            <div class="alert alert-danger display-block">
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
                                            <!-- <form action="<?= base_url('start-selling-post'); ?>" method="post" enctype="multipart/form-data" id="form_validate" class="validate_terms validate-form" onkeypress="return event.keyCode != 13;"> -->
                                            <form action="<?= base_url('start-selling-post'); ?>"
                                                method="post"
                                                enctype="multipart/form-data"
                                                id="form_validate"
                                                class="validate_terms validate-form">
                                                <?= csrf_field(); ?>

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
                                                                        <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions" value="1" required>
                                                                        <label for="terms_conditions" class="custom-control-label"><?= trans("terms_conditions_exp"); ?>&nbsp;
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

                                                                <p id="mobileMessage" style="font-size:14px; color:gray;"></p>

                                                                <div id="mobileInputBox">
                                                                    <input type="text" id="mobile_number" placeholder="Enter Mobile Number" data-type="mobile">

                                                                    <input type="hidden" name="phone_number" id="hidden_phone">

                                                                    <button type="button" id="sendOtpBtn" class="btn btn-custom"> Submit</button>
                                                                </div>

                                                                <div id="otpBox" style="display:none;">

                                                                    <input type="text" id="otp" placeholder="Enter OTP">

                                                                    <button type="button" onclick="verifyOtp()" class="btn btn-success">
                                                                        Verify
                                                                    </button>

                                                                    <button type="button" id="resendMobileBtn" onclick="resendOtp()" disabled>
                                                                        Resend OTP
                                                                    </button>

                                                                    <span id="mobileTimer" style="font-size:12px; color:gray;"></span>

                                                                </div>

                                                            </div>
                                                            <div id="emailStep" class="step-box">

                                                                <h4>Email Verification</h4>

                                                                <p id="emailMessage" style="font-size:14px; color:gray;"></p>

                                                                <input type="text" id="email_otp" placeholder="Enter Email OTP">

                                                                <button type="button" onclick="verifyEmail()" class="btn btn-success">
                                                                    Verify Email
                                                                </button>
                                                                <div style="margin-top:10px;">
                                                                    <button type="button" id="resendEmailBtn" onclick="resendEmailOtp()" disabled class="btn btn-link">
                                                                        Resend OTP
                                                                    </button>
                                                                    <span id="emailTimer" style="font-size:12px; color:gray;"></span>
                                                                </div>

                                                            </div>
                                                            <!-- PHONE OTP -->
                                                            <div id="phoneStep" class="step-box">
                                                                <h4>Phone Verification</h4>

                                                                <input type="text" id="business_phone" name="business_phone" placeholder="Enter Phone Number">
                                                                <input type="hidden" name="business_phone" id="hidden_business_phone">
                                                                <button type="button" onclick="sendPhoneOtp()" class="btn btn-custom">Send OTP</button>

                                                                <div id="phoneOtpBox" style="display:none;">
                                                                    <input type="text" id="phone_otp" placeholder="Enter OTP">
                                                                    <button type="button" onclick="verifyPhone()" class="btn btn-success">Verify</button>
                                                                </div>
                                                            </div>

                                                            <!-- BUSINESS TYPE -->
                                                            <div id="businessTypeStep" class="step-box">

                                                                <h4>What type of business is this?</h4>

                                                                <input type="hidden" name="business_type" id="business_type">

                                                                <div class="business-options">

                                                                    <div class="business-card" onclick="selectBusinessType('sole', this)">
                                                                        <h5>Sole proprietorship</h5>
                                                                    </div>

                                                                    <div class="business-card" onclick="selectBusinessType('registered', this)">
                                                                        <h5>Registered business</h5>
                                                                    </div>

                                                                    <div class="business-card" onclick="selectBusinessType('nonprofit', this)">
                                                                        <h5>Nonprofit</h5>
                                                                    </div>

                                                                </div>

                                                                <!-- 🔥 DYNAMIC FIELDS -->
                                                                <div id="businessExtraFields" style="display:none; margin-top:15px;">

                                                                    <input type="text" name="legal_business_name" placeholder="Legal business name">

                                                                    <input type="text" name="doing_business_as" placeholder="Doing business as (optional)">

                                                                    <input type="text" name="ein_registered" id="ein_registered" placeholder="Employer ID Number (9 digits)">

                                                                </div>

                                                                <button type="button" onclick="goToStakeholders()" class="btn btn-custom">
                                                                    Continue
                                                                </button>

                                                            </div>

                                                            <div id="soleDetailsStep" class="step-box">

                                                                <h4>Confirm account details</h4>

                                                                <p style="font-size:13px;color:#777;">
                                                                    Add your information (must match your government ID)
                                                                </p>

                                                                <!-- LEGAL NAME -->
                                                                <input type="text" name="legal_first_name" placeholder="First name">
                                                                <input type="text" name="legal_middle_name" placeholder="Middle name (optional)">
                                                                <input type="text" name="legal_last_name" placeholder="Last name">

                                                                <!-- PERSONAL INFO -->
                                                                <select name="nationality">
                                                                    <option value="">Select Nationality</option>
                                                                    <option value="india">India</option>
                                                                    <option value="us">United States</option>
                                                                </select>

                                                                <!-- ADDRESS -->
                                                                <input type="text" name="address_line1" placeholder="Street address">
                                                                <input type="text" name="address_line2" placeholder="Street address 2 (optional)">
                                                                <input type="text" name="city" placeholder="City">
                                                                <input type="text" name="state" placeholder="State">
                                                                <input type="text" name="zip" placeholder="ZIP Code">

                                                                <!-- PHONE -->
                                                                <input type="text" name="contact_phone" placeholder="Phone number">

                                                                <button type="button" onclick="goNextFromSole()" class="btn btn-custom">
                                                                    Continue
                                                                </button>

                                                            </div>

                                                            <!-- STAKEHOLDERS -->
                                                            <div id="stakeholderStep" class="step-box">
                                                                <h4>Stakeholders</h4>

                                                                <input type="text" id="director_name" placeholder="Director Name">
                                                                <input type="text" id="director_role" placeholder="Role">

                                                                <button onclick="addDirector()">Add Member</button>

                                                                <ul id="directorList"></ul>

                                                                <button onclick="goToPayout()" class="btn btn-custom">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                            <div id="registeredFields" style="display:none; margin-top:20px;">

                                                                <h5>Business details</h5>

                                                                <!-- BUSINESS PROFILE -->
                                                                <input type="text" name="legal_business_name" placeholder="Legal business name">
                                                                <input type="text" name="doing_business_as" placeholder="Doing business as (optional)">
                                                                <input type="text" name="ein_registered" id="ein_registered" placeholder="Employer ID Number (9 digits)">

                                                                <!-- ADDRESS -->
                                                                <h5 style="margin-top:15px;">Business address</h5>

                                                                <input type="text" name="address_line1" placeholder="Street address">
                                                                <input type="text" name="address_line2" placeholder="Street address 2 (optional)">
                                                                <input type="text" name="city" placeholder="City">
                                                                <input type="text" name="state" placeholder="State">
                                                                <input type="text" name="zip" placeholder="ZIP Code">

                                                                <!-- CONTACT -->
                                                                <h5 style="margin-top:15px;">Contact information</h5>

                                                                <input type="text" name="contact_phone" placeholder="Phone number">

                                                                <p style="font-size:12px;color:#777;">
                                                                    We'll verify your phone number for security purposes.
                                                                </p>

                                                            </div>

                                                            <!-- PAYOUT -->
                                                            <div id="payoutStep" class="step-box">
                                                                <h4>Payout Information</h4>

                                                                <input type="text" placeholder="Account Number">
                                                                <input type="text" placeholder="IFSC Code">

                                                                <button onclick="goToReview()" class="btn btn-custom">
                                                                    Continue
                                                                </button>
                                                            </div>

                                                            <!-- REVIEW -->
                                                            <div id="reviewStep" class="step-box">
                                                                <h4>Review & Submit</h4>

                                                                <button onclick="finalSubmit()" class="btn btn-success">
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
    function selectBusinessType(type, el) {

        document.querySelectorAll(".business-card").forEach(card => {
            card.classList.remove("active");
        });

        el.classList.add("active");

        document.getElementById("business_type").value = type;

        let registeredFields = document.getElementById("registeredFields");

        // 🔥 SHOW FULL FORM ONLY FOR REGISTERED
        if (type === "registered") {
            registeredFields.style.display = "block";
        } else {
            registeredFields.style.display = "none";
        }
    }

    function goToStakeholders() {

        let type = document.getElementById("business_type").value;

        if (!type) {
            alert("Select business type");
            return;
        }

        // 🔥 validate only registered
        if (type === "registered") {

            let ein = document.getElementById("ein_registered").value;

            if (!ein || ein.length !== 9) {
                alert("Enter valid 9 digit EIN");
                return;
            }
        }

        hideAllSteps();
        document.getElementById("nextStep").classList.add("active");
    }

    document.getElementById("form_validate").addEventListener("submit", function(e) {
        // ❌ block accidental submit during steps
        if (!window.allowSubmit) {
            e.preventDefault();
        }
    });
    document.addEventListener("DOMContentLoaded", function() {

    const personalBtn = document.getElementById("personalBtn");
    const businessBtn = document.getElementById("businessBtn");
    const continueBtn = document.getElementById("continueBtn");

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

    // CONTINUE BUTTON
    continueBtn.addEventListener("click", function () {
        handleStartSelling();
    });

    });

    function hideAllSteps() {
        document.querySelectorAll(".step-box").forEach(el => {
            el.classList.remove("active");
        });
    }

    function handleStartSelling() {
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

        fetch('<?= base_url("seller/send-email-otp"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'email=' + email + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 1) {
                    startTimer("resendEmailBtn", "emailTimer");
                } else {
                    alert(data.msg);
                }
            });
    }

    function verifyEmail() {
        let otp = document.getElementById("email_otp").value;

        fetch('<?= base_url("seller/verify-email-otp"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'otp=' + otp + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {

                    hideAllSteps();

                    // ✅ SHOW PHONE STEP (NEW SCREEN)
                    document.getElementById("phoneStep").classList.add("active");

                } else {
                    alert("Invalid OTP");
                }
            });
    }

    function resendEmailOtp() {
        let email = document.querySelector('input[name="business_email"]').value;

        fetch('<?= base_url("seller/send-email-otp"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'email=' + email + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 1) {

                    // ✅ better UX (no alert)
                    document.getElementById("emailTimer").innerText = "OTP resent";

                    // ✅ correct timer target
                    startTimer("resendEmailBtn", "emailTimer");

                } else {
                    alert(data.msg);
                }
            });
    }

    function sendPhoneOtp() {
        let phone = document.getElementById("business_phone").value;

        if (!phone) {
            alert("Enter phone number");
            return;
        }

        // ✅ STORE VERIFIED PHONE
        document.getElementById("hidden_business_phone").value = phone;

        fetch('<?= base_url("seller/send-phone-otp"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'phone=' + phone + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    document.getElementById("phoneOtpBox").style.display = "block";
                }
            });
    }

    function verifyPhone() {
        let otp = document.getElementById("phone_otp").value;

        fetch('<?= base_url("seller/verify-phone-otp"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'otp=' + otp + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {
                    hideAllSteps();
                    document.getElementById("businessTypeStep").classList.add("active");
                } else {
                    alert("Invalid OTP");
                }
            });
    }

    function sendOtp() {
        let mobile = document.getElementById("mobile_number").value;

        if (!mobile) {
            alert("Enter mobile number");
            return;
        }

        // ✅ store in hidden input (IMPORTANT)
        document.getElementById("hidden_phone").value = mobile;

        fetch('<?= base_url("seller/send-otp"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'mobile=' + mobile + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 1) {

                    let last4 = mobile.slice(-4);

                    document.getElementById("mobileMessage").innerText =
                        "OTP sent to ******" + last4;

                    document.getElementById("mobileInputBox").style.display = "none";
                    document.getElementById("otpBox").style.display = "block";

                } else {
                    alert(data.msg);
                }
            });
    }

    function verifyOtp() {
        let otp = document.getElementById("otp").value;

        fetch('<?= base_url("seller/verify-otp"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'otp=' + otp + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status == 1) {

                    // ✅ MOBILE VERIFIED
                    alert("Mobile Verified ✅");

                    hideAllSteps();

                    // ✅ GO TO NEXT STEP (business type)
                    document.getElementById("businessTypeStep").classList.add("active");

                } else {
                    alert(data.msg);
                }
            });
    }

    function resendOtp() {
        fetch('<?= base_url("seller/resend-otp"); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: '<?= csrf_token() ?>=<?= csrf_hash() ?>'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status) {

                    document.getElementById("mobileTimer").innerText = "OTP resent";

                    // ✅ correct timer target
                    startTimer("resendMobileBtn", "mobileTimer");

                } else {
                    alert(data.msg);
                }
            });
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
    document.addEventListener("DOMContentLoaded", function () {

        const sendOtpBtn = document.getElementById("sendOtpBtn");

        if (sendOtpBtn) {
            sendOtpBtn.addEventListener("click", sendOtp);
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
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
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
</style>