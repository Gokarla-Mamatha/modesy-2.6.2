<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= esc(trans("home")); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= generateUrl('settings', 'edit_profile'); ?>"><?= esc(trans("profile_settings")); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
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
                        <?php
                        $user = user();
                        $bd = $business_details ?? [];
                        $type = $bd['business_type'] ?? ($user->business_type ?? '');
                        $stakeholders = json_decode($bd['stakeholders'] ?? '[]', true);
                        $stakeholders = is_array($stakeholders) ? $stakeholders : [];
                        ?>
                        <!-- <?php if (!empty($business_details)) : ?>
                            <pre><?php print_r($business_details); ?></pre>
                        <?php else : ?>
                            <p>No business details found</p>
                        <?php endif; ?> -->
                        <?php if (empty($bd)): ?>
                            <p class="m-t-10">No details found.</p>
                        <?php else: ?>
                        <form action="<?= base_url('business-details-post'); ?>" method="post" id="form_validate">
                            <?= csrf_field(); ?>

                            <?php $isBusinessAccount = !empty($user->business_name) || !empty($user->business_email); ?>
                            <?php if ($isBusinessAccount): ?>
                                <h4>Business Account</h4>
                                <div class="form-group">
                                    <label class="control-label">Business Name</label>
                                    <input type="text" class="form-control form-input" value="<?= esc($user->business_name ?? '') ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Business Email <small>(verified)</small></label>
                                    <input type="email" class="form-control form-input" value="<?= esc($user->business_email ?? '') ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Business Phone <small>(verified)</small></label>
                                    <input type="text" class="form-control form-input" value="<?= esc($user->business_phone ?? '') ?>" readonly>
                                </div>
                            <?php endif; ?>

                            <?php if (!$isBusinessAccount): ?>
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input type="text"
                                        class="form-control form-input"
                                        value="<?= esc($user->first_name ?? '') ?>"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input type="text"
                                        class="form-control form-input"
                                        value="<?= esc($user->last_name ?? '') ?>"
                                        readonly>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="text"
                                        class="form-control form-input"
                                        value="<?= esc($user->email ?? '') ?>"
                                        readonly>
                                </div>
                            <?php endif; ?>

                            <?php if ($type == 'sole'): ?>
                                <h4>Legal details</h4>
                                <div class="form-group">
                                    <label class="control-label">Legal First Name</label>
                                    <input type="text" class="form-control form-input" name="legal_first_name" value="<?= old('legal_first_name', $bd['legal_first_name'] ?? '') ?>" placeholder="First name" data-type="name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Legal Middle Name</label>
                                    <input type="text" class="form-control form-input" name="legal_middle_name" value="<?= old('legal_middle_name', $bd['legal_middle_name'] ?? '') ?>" placeholder="Middle name" data-type="name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Legal Last Name</label>
                                    <input type="text" class="form-control form-input" name="legal_last_name" value="<?= old('legal_last_name', $bd['legal_last_name'] ?? '') ?>" placeholder="Last name" data-type="name">
                                </div>

                                <h5>Address</h5>
                                <div class="form-group">
                                    <label class="control-label">Street address</label>
                                    <input type="text" class="form-control form-input" name="address_line1" value="<?= old('address_line1', $bd['address_line1'] ?? '') ?>" placeholder="Street address" data-type="text">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Street address 2</label>
                                    <input type="text" class="form-control form-input" name="address_line2" value="<?= old('address_line2', $bd['address_line2'] ?? '') ?>" placeholder="Street address 2" data-type="text">
                                </div>
                                <?php $savedCountry = old('sole_country_id', $bd['country_id'] ?? '');
                                $savedState = old('sole_state_id', $bd['state_id'] ?? '');
                                $savedCity = old('sole_city_id', $bd['city_id'] ?? ''); ?>
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <select id="select_countries_sole" name="sole_country_id" class="form-control form-input">
                                        <option value=""><?= esc(trans('country')); ?></option>
                                        <?php foreach (($countries ?? []) as $country): ?>
                                            <option value="<?= $country->id; ?>" <?= $savedCountry == $country->id ? 'selected' : ''; ?>><?= esc($country->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="get_states_container_sole" class="form-group <?= empty($states) ? 'display-none' : ''; ?>">
                                    <label class="control-label">State</label>
                                    <select id="select_states_sole" name="sole_state_id" class="form-control form-input">
                                        <option value=""><?= esc(trans('state')); ?></option>
                                        <?php foreach (($states ?? []) as $state): ?>
                                            <option value="<?= $state->id; ?>" <?= $savedState == $state->id ? 'selected' : ''; ?>><?= esc($state->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="get_cities_container_sole" class="form-group <?= empty($cities) ? 'display-none' : ''; ?>">
                                    <label class="control-label">City</label>
                                    <select id="select_cities_sole" name="sole_city_id" class="form-control form-input">
                                        <option value=""><?= esc(trans('city')); ?></option>
                                        <?php foreach (($cities ?? []) as $city): ?>
                                            <option value="<?= $city->id; ?>" <?= $savedCity == $city->id ? 'selected' : ''; ?>><?= esc($city->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">ZIP Code</label>
                                    <input type="text" class="form-control form-input" name="zip" value="<?= old('zip', $bd['zip'] ?? '') ?>" placeholder="ZIP Code" data-type="number">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone number</label>
                                    <input type="text" class="form-control form-input" name="contact_phone" value="<?= old('contact_phone', $bd['contact_phone'] ?? '') ?>" placeholder="Phone number" data-type="mobile">
                                </div>
                            <?php endif; ?>
                            <?php if ($type == 'registered' || $type == 'nonprofit'): ?>
                                <h4>Business details</h4>
                                <div class="form-group">
                                    <label class="control-label">Legal Business Name</label>
                                    <input type="text" class="form-control form-input" name="legal_business_name" value="<?= old('legal_business_name', $bd['legal_business_name'] ?? '') ?>" placeholder="Legal business name" data-type="name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Doing Business As</label>
                                    <input type="text" class="form-control form-input" name="doing_business_as" value="<?= old('doing_business_as', $bd['doing_business_as'] ?? '') ?>" placeholder="Doing business as" data-type="name">
                                </div>
                                <?php $einVal = (string)($bd['ein_registered'] ?? '');
                                $einMasked = strlen($einVal) > 4 ? str_repeat('*', strlen($einVal) - 4) . substr($einVal, -4) : $einVal; ?>
                                <div class="form-group">
                                    <label class="control-label">EIN</label>
                                    <input type="text" class="form-control form-input" value="<?= esc($einMasked) ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone number</label>
                                    <input type="text" class="form-control form-input" name="contact_phone" value="<?= old('contact_phone', $bd['contact_phone'] ?? '') ?>" placeholder="Phone number" data-type="mobile">
                                </div>
                            <?php endif; ?>

                            <?php if ($type == 'registered' || $type == 'nonprofit'): ?>
                                <h5>Additional Stakeholders</h5>

                                <div id="stakeholderList">
                                    <?php if (!empty($stakeholders)): ?>
                                        <?php foreach ($stakeholders as $index => $s): ?>
                                            <div class="stakeholder-box">
                                                <strong><?= esc($s['name'] ?? '') ?></strong>
                                                <div class="meta">
                                                    Role: <?= esc($s['role'] ?? '') ?>
                                                </div>

                                                <button type="button" class="stakeholder-remove">Remove</button>

                                                <!-- Hidden inputs -->
                                                <input type="hidden" name="stakeholders[<?= $index ?>][name]" value="<?= esc($s['name'] ?? '') ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][role]" value="<?= esc($s['role'] ?? '') ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <button type="button" class="add-btn" id="addStakeholderBtn">+ Add Stakeholder</button>

                                <div id="stakeholderForm" style="display:none; margin-top:15px;">
                                    <div class="form-group m-b-0">
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control form-input" id="sh_name" data-type="title" placeholder="Name" data-type="title">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label class="control-label">Role</label>
                                                <input type="text" class="form-control form-input" id="sh_role" data-type="title" placeholder="Role" data-type="title">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-md btn-custom" id="saveStakeholderBtn">Save Stakeholder</button>
                                </div>
                            <?php endif; ?>

                            <?php if ($type == 'sole' || $type == 'registered' || $type == 'nonprofit'): ?>
                                <h4>Payout Information</h4>
                                <?php $accVal = (string)($bd['account_number'] ?? '');
                                $accMasked = strlen($accVal) > 4 ? str_repeat('*', strlen($accVal) - 4) . substr($accVal, -4) : $accVal; ?>
                                <div class="form-group">
                                    <label class="control-label">Account Number</label>
                                    <input type="text" class="form-control form-input" value="<?= esc($accMasked) ?>" readonly>
                                </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-md btn-custom m-t-10">
                                <?= esc(trans("save_changes")) ?>
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style <?= csp_style_nonce() ?>>
    /* ---- Simple, clean business details form ---- */
    #form_validate {
        max-width: 620px;
    }

    #form_validate .control-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #555;
        margin-bottom: 6px;
    }

    #form_validate .form-input {
        width: 100%;
        padding: 11px 14px;
        font-size: 14px;
        color: #222;
        background: #fff;
        border: 1px solid #e2e5ea;
        border-radius: 8px;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    #form_validate .form-input:focus {
        outline: none;
        border-color: #4a7cff;
        box-shadow: 0 0 0 3px rgba(74, 124, 255, .12);
    }

    #form_validate .form-input[readonly] {
        background: #f6f7f9;
        color: #888;
    }

    #form_validate textarea.form-input {
        min-height: 90px;
        resize: vertical;
    }

    #form_validate .form-group {
        margin-bottom: 16px;
    }

    /* Section headings */
    #form_validate h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1d2330;
        margin: 26px 0 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eceef2;
    }

    #form_validate h5 {
        font-size: 14px;
        font-weight: 600;
        color: #3a4151;
        margin: 20px 0 12px;
    }

    /* Checkboxes */
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
    }

    .checkbox-group label {
        font-size: 13px;
        font-weight: 500;
        color: #555;
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 0;
    }

    /* Stakeholder card */
    .stakeholder-box {
        background: #fafbfc;
        border: 1px solid #e2e5ea;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 12px;
        position: relative;
    }

    .stakeholder-box strong {
        font-size: 14px;
        color: #1d2330;
    }

    .stakeholder-box .meta {
        font-size: 12px;
        color: #7a808c;
        margin-top: 4px;
    }

    .stakeholder-box button {
        background: none;
        border: none;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        padding: 2px 6px;
        margin-left: 6px;
        color: #4a7cff;
    }

    .stakeholder-box button:last-child {
        color: #e5484d;
    }

    /* Add stakeholder */
    .add-btn {
        background: #fff;
        color: #4a7cff;
        border: 1px dashed #b9c6ff;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: background .15s ease;
    }

    .add-btn:hover {
        background: #f3f6ff;
    }

    #stakeholderForm {
        background: #fafbfc;
        border: 1px solid #e2e5ea;
        border-radius: 10px;
        padding: 16px;
        margin-top: 14px;
    }

    /* Save button */
    #form_validate .btn-custom {
        margin-top: 8px;
    }
</style>
<script <?= csp_script_nonce() ?>>
    let stakeholderIndex = <?= !empty($stakeholders) ? count($stakeholders) : 0 ?>;

    // Cascading country -> state -> city (uses global getStates/getCities)
    document.addEventListener('change', function (e) {
        if (e.target && e.target.id === 'select_countries_sole') {
            getStates(e.target.value, 'sole');
        } else if (e.target && e.target.id === 'select_states_sole') {
            getCities(e.target.value, 'sole');
        }
    });

    // CSP-safe stakeholder actions (inline onclick is blocked by CSP)
    document.addEventListener('click', function (e) {
        if (!e.target) return;
        if (e.target.id === 'addStakeholderBtn') {
            openForm();
        } else if (e.target.id === 'saveStakeholderBtn') {
            addStakeholder();
        } else if (e.target.classList.contains('stakeholder-remove')) {
            let box = e.target.closest('.stakeholder-box');
            if (box) box.remove();
        }
    });

    function openForm() {
        let form = document.getElementById("stakeholderForm");

        if (!form) {
            console.error("stakeholderForm not found");
            return;
        }

        form.style.display = "block";
    }

    document.addEventListener("DOMContentLoaded", function() {
        let form = document.getElementById("stakeholderForm");

        if (!form) return;

        form.querySelectorAll("input").forEach(el => {
            if (el.type === "checkbox") {
                el.checked = false;
            } else {
                el.value = "";
            }
        });

        form.querySelectorAll("select").forEach(el => el.value = "");

        form.style.display = "none";
    });


    function escapeHtml(text) {
        return text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // function viewStakeholder(btn) {
    //     let box = btn.closest('.stakeholder-box');

    //     let details = `
    //     Name: ${box.dataset.first} ${box.dataset.middle} ${box.dataset.last}
    //     DOB: ${box.dataset.dob}
    //     Nationality: ${box.dataset.nationality}
    //     ID Number: ${box.dataset.id}
    //     Address: ${box.dataset.address}
    //     City: ${box.dataset.city}
    //     State: ${box.dataset.state}
    //     ZIP: ${box.dataset.zip}
    //     Roles: ${box.dataset.roles}
    // `;

    //     alert(details);
    // }

    function addStakeholder() {

        let list = document.getElementById("stakeholderList");
        let index = stakeholderIndex++;

        let name = document.getElementById("sh_name").value.trim();
        let role = document.getElementById("sh_role").value.trim();

        if (!name || !role) {
            alert("Name and role required");
            return;
        }

        let box = document.createElement("div");
        box.className = "stakeholder-box";

        let strong = document.createElement("strong");
        strong.textContent = name;

        let meta = document.createElement("div");
        meta.className = "meta";
        meta.textContent = "Role: " + role;

        let removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.className = "stakeholder-remove";
        removeBtn.textContent = "Remove";

        let nameInput = document.createElement("input");
        nameInput.type = "hidden";
        nameInput.name = "stakeholders[" + index + "][name]";
        nameInput.value = name;

        let roleInput = document.createElement("input");
        roleInput.type = "hidden";
        roleInput.name = "stakeholders[" + index + "][role]";
        roleInput.value = role;

        box.appendChild(strong);
        box.appendChild(meta);
        box.appendChild(removeBtn);
        box.appendChild(nameInput);
        box.appendChild(roleInput);

        list.appendChild(box);

        document.getElementById("sh_name").value = "";
        document.getElementById("sh_role").value = "";
        document.getElementById("stakeholderForm").style.display = "none";
    }
</script>