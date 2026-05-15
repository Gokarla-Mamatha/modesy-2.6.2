<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= generateUrl('settings', 'edit_profile'); ?>"><?= trans("profile_settings"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?= trans("profile_settings"); ?></h1>
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
                        $bd = $business_details ?? null;
                        $type = $bd['business_type'] ?? '';
                        $stakeholders = json_decode($bd['stakeholders'] ?? '[]', true);
                        ?>
                        <!-- <?php if (!empty($business_details)) : ?>
                            <pre><?php print_r($business_details); ?></pre>
                        <?php else : ?>
                            <p>No business details found</p>
                        <?php endif; ?> -->
                        <form action="<?= base_url('business-details-post'); ?>" method="post" id="form_validate">
                            <?= csrf_field(); ?>

                            <?php if ($type == 'sole'): ?>
                                <div class="form-group">
                                    <label class="control-label">Legal First Name</label>
                                    <input type="text" class="form-control form-input" name="legal_first_name" value="<?= $bd->legal_first_name ?? '' ?>" placeholder="First name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= trans("legal_middle_name"); ?></label>
                                    <input type="text" class="form-control form-input" name="legal_middle_name" value="<?= $bd->legal_middle_name ?? '' ?>" placeholder="Middle name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?= trans("legal_last_name"); ?></label>
                                    <input type="text" class="form-control form-input" name="legal_last_name" value="<?= $bd->legal_last_name ?? '' ?>" placeholder="Last name">
                                </div>
                                <div class="form-group">
                                    <select name="nationality" class="select2 form-control">
                                        <option value=""><?= trans('country'); ?></option>
                                        <?php foreach ($countries as $item):
                                            if ($item->status == 1):
                                                if (!empty($countryId)): ?>
                                                    <option value="<?= $item->id; ?>" <?= $item->id == $countryId ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $item->id; ?>"><?= esc($item->name); ?></option>
                                        <?php endif;
                                            endif;
                                        endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="address_line1" class="control-label">Street Address</label>
                                    <input type="text" class="form-control form-input" name="address_line1" value="<?= $bd->address_line1 ?? '' ?>" placeholder="Street address">
                                </div>
                                <div class="form-group">
                                    <label for="address_line2" class="control-label">Street Address 2</label>
                                    <input type="text" class="form-control form-input" name="address_line2" value="<?= $bd->address_line2 ?? '' ?>" placeholder="Street address 2">
                                </div>
                                <div class="form-group">
                                    <label for="city" class="control-label">City</label>
                                    <input type="text" class="form-control form-input" name="city" value="<?= $bd->city ?? '' ?>" placeholder="City">
                                </div>
                                <div class="form-group">
                                    <label for="state" class="control-label">State</label>
                                    <input type="text" class="form-control form-input" name="state" value="<?= $bd->state ?? '' ?>" placeholder="State">
                                </div>
                                <div class="form-group">
                                    <label for="zip" class="control-label">ZIP Code</label>
                                    <input type="text" class="form-control form-input" name="zip" value="<?= $bd->zip ?? '' ?>" placeholder="ZIP Code">
                                </div>
                                <div class="form-group">
                                    <label for="contact_phone" class="control-label">Phone number</label>
                                    <input type="text" class="form-control form-input" name="contact_phone" value="<?= $bd->contact_phone ?? '' ?>" placeholder="Phone number">
                                </div>
                            <?php endif; ?>
                            <?php if ($type == 'registered'): ?>
                                <h4>Business details</h4>
                                <div class="form-group">
                                    <label class="control-label">Legal Business Name</label>
                                    <input type="text" class="form-control form-input" name="legal_business_name" value="<?= old('legal_business_name', $bd['legal_business_name'] ?? '') ?>" placeholder="Legal business name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Doing Business As</label>
                                    <input type="text" class="form-control form-input" name="doing_business_as" value="<?= old('doing_business_as', $bd['doing_business_as'] ?? '') ?>" placeholder="Doing business as">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">EIN (9 digits)</label>
                                    <input type="text" class="form-control form-input" name="ein_registered" id="ein_registered" value="<?= old('ein_registered', $bd['ein_registered'] ?? '') ?>" placeholder="EIN (9 digits)">
                                </div>
                                <h5>Business address</h5>
                                <div class="form-group">
                                    <label class="control-label">Street address</label>
                                    <input type="text" class="form-control form-input" name="business_address_line1" value="<?= old('business_address_line1', $bd['business_address_line1'] ?? '') ?>" placeholder="Street address">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Street address 2</label>
                                    <input type="text" class="form-control form-input" name="business_address_line2" value="<?= old('business_address_line2', $bd['business_address_line2'] ?? '') ?>" placeholder="Street address 2">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">City</label>
                                    <input type="text" class="form-control form-input" name="business_city" value="<?= old('business_city', $bd['business_city'] ?? '') ?>" placeholder="City">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input type="text" class="form-control form-input" name="business_state" value="<?= old('business_state', $bd['business_state'] ?? '') ?>" placeholder="State">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">ZIP Code</label>
                                    <input type="text" class="form-control form-input" name="business_zip" value="<?= old('business_zip', $bd['business_zip'] ?? '') ?>" placeholder="ZIP Code">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone number</label>
                                    <input type="text" class="form-control form-input" name="contact_phone" value="<?= old('contact_phone', $bd['contact_phone'] ?? '') ?>" placeholder="Phone number">
                                </div>


                                <h5>Primary Contact</h5>
                                <div class="form-group">
                                    <label class="control-label">Primary First Name</label>
                                    <input type="text" class="form-control form-input" name="primary_first_name" value="<?= old('primary_first_name', $bd['primary_first_name'] ?? '') ?>" placeholder="First name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Primary Middle Name</label>
                                    <input type="text" class="form-control form-input" name="primary_middle_name" value="<?= old('primary_middle_name', $bd['primary_middle_name'] ?? '') ?>" placeholder="Middle name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Primary Last Name</label>
                                    <input type="text" class="form-control form-input" name="primary_last_name" value="<?= old('primary_last_name', $bd['primary_last_name'] ?? '') ?>" placeholder="Last name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Primary Date of Birth</label>
                                    <input type="date" class="form-control form-input" name="primary_dob" value="<?= old('primary_dob', $bd['primary_dob'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Primary Nationality</label>
                                    <select name="primary_nationality" class="select2 form-control">
                                        <option value=""><?= trans('country'); ?></option>
                                        <?php foreach ($countries as $country): ?>
                                            <option value="<?= $country->id; ?>"
                                                <?= old('primary_nationality', $bd['primary_nationality'] ?? '') == $country->id ? 'selected' : ''; ?>>
                                                <?= esc($country->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Primary SSN / ITIN</label>
                                    <input type="text" class="form-control form-input" name="ssn_last4" value="<?= old('ssn_last4', $bd['ssn_last4'] ?? '') ?>" placeholder="Last 4 digits of SSN / ITIN">
                                </div>
                                <!-- ✅ ADDRESS -->
                                <h5>Address</h5>
                                <div class="form-group">
                                    <label class="control-label">Contact Address 1</label>
                                    <input type="text" class="form-control form-input" name="contact_address1" value="<?= old('contact_address1', $bd['contact_address1'] ?? '') ?>" placeholder="Street address">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Contact Address 2</label>
                                    <input type="text" class="form-control form-input" name="contact_address2" value="<?= old('contact_address2', $bd['contact_address2'] ?? '') ?>" placeholder="Street address 2">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Contact City</label>
                                    <input type="text" class="form-control form-input" name="contact_city" value="<?= old('contact_city', $bd['contact_city'] ?? '') ?>" placeholder="City">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Contact State</label>
                                    <input type="text" class="form-control form-input" name="contact_state" value="<?= old('contact_state', $bd['contact_state'] ?? '') ?>" placeholder="State">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Contact ZIP Code</label>
                                    <input type="text" class="form-control form-input" name="contact_zip" value="<?= old('contact_zip', $bd['contact_zip'] ?? '') ?>" placeholder="ZIP Code">
                                </div>

                                <?php
                                $roles = json_decode($bd['roles'] ?? '[]', true);
                                $roles = is_array($roles) ? $roles : [];
                                ?>

                                <h5>Role with company</h5>

                                <div class="checkbox-group">

                                    <label>
                                        <input type="checkbox" name="roles[]" value="primary_contact"
                                            <?= in_array('primary_contact', $roles) ? 'checked' : '' ?>>
                                        Primary Contact
                                    </label>

                                    <label>
                                        <input type="checkbox" name="roles[]" value="beneficial_owner"
                                            <?= in_array('beneficial_owner', $roles) ? 'checked' : '' ?>>
                                        Beneficial Owner
                                    </label>

                                    <label>
                                        <input type="checkbox" name="roles[]" value="director"
                                            <?= in_array('director', $roles) ? 'checked' : '' ?>>
                                        Director
                                    </label>

                                </div>
                                <h5>Additional Stakeholders</h5>

                                <div id="stakeholderList">
                                    <?php if (!empty($stakeholders)): ?>
                                        <?php foreach ($stakeholders as $index => $s): ?>
                                            <div class="stakeholder-box"
                                                data-first="<?= esc($s['first_name']) ?>"
                                                data-middle="<?= esc($s['middle_name'] ?? '') ?>"
                                                data-last="<?= esc($s['last_name']) ?>"
                                                data-dob="<?= esc($s['dob'] ?? '') ?>"
                                                data-nationality="<?= esc($s['nationality'] ?? '') ?>"
                                                data-id="<?= esc($s['id_number'] ?? '') ?>"
                                                data-address="<?= esc($s['address1'] ?? '') ?>"
                                                data-city="<?= esc($s['city'] ?? '') ?>"
                                                data-state="<?= esc($s['state'] ?? '') ?>"
                                                data-zip="<?= esc($s['zip'] ?? '') ?>"
                                                data-roles="<?= implode(',', $s['role'] ?? []) ?>">

                                                <strong><?= esc($s['first_name']) ?> <?= esc($s['last_name']) ?></strong>
                                                <div class="meta">
                                                    Role: <?= implode(', ', $s['role'] ?? []) ?><br>
                                                    City: <?= esc($s['city'] ?? '') ?>
                                                </div>

                                                <button type="button" onclick="viewStakeholder(this)">View</button>
                                                <button type="button" onclick="this.parentElement.remove()">Remove</button>

                                                <!-- Hidden inputs -->
                                                <input type="hidden" name="stakeholders[<?= $index ?>][first_name]" value="<?= esc($s['first_name']) ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][middle_name]" value="<?= esc($s['middle_name'] ?? '') ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][last_name]" value="<?= esc($s['last_name']) ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][dob]" value="<?= esc($s['dob'] ?? '') ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][nationality]" value="<?= esc($s['nationality'] ?? '') ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][id_number]" value="<?= esc($s['id_number'] ?? '') ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][address1]" value="<?= esc($s['address1'] ?? '') ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][city]" value="<?= esc($s['city'] ?? '') ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][state]" value="<?= esc($s['state'] ?? '') ?>">
                                                <input type="hidden" name="stakeholders[<?= $index ?>][zip]" value="<?= esc($s['zip'] ?? '') ?>">

                                                <?php foreach (($s['role'] ?? []) as $r): ?>
                                                    <input type="hidden" name="stakeholders[<?= $index ?>][role][]" value="<?= esc($r) ?>">
                                                <?php endforeach; ?>

                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <button type="button" class="add-btn" onclick="openForm()">+ Add Stakeholder</button>

                                <div id="stakeholderForm" style="display:none; margin-top:15px;">
                                    <div class="form-group m-b-0">
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">First Name</label>
                                                <input type="text" class="form-control form-input" name="first_name" id="sh_first_name" placeholder="First name">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">Middle Name</label>
                                                <input type="text" class="form-control form-input" name="middle_name" id="sh_middle_name" placeholder="Middle name">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">Last Name</label>
                                                <input type="text" class="form-control form-input" name="last_name" id="sh_last_name" placeholder="Last name">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">Date of Birth</label>
                                                <input type="date" class="form-control form-input" id="sh_dob" name="dob">

                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">Nationality</label>
                                                <select id="sh_nationality" class="select2 form-control">
                                                    <option value="">Select Country</option>
                                                    <?php foreach ($countries as $country): ?>
                                                        <option value="<?= $country->id; ?>"><?= esc($country->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">ID Number</label>
                                                <input type="text" class="form-control form-input" id="sh_id_number" placeholder="ID Number">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">Address</label>
                                                <input type="text" class="form-control form-input" id="sh_address1" placeholder="Address">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">City</label>
                                                <input type="text" class="form-control form-input" id="sh_city" placeholder="City">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">State</label>
                                                <input type="text" class="form-control form-input" id="sh_state" placeholder="State">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">ZIP</label>
                                                <input type="text" class="form-control form-input" id="sh_zip" placeholder="ZIP">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 m-b-15">
                                                <label for="control-label">Roles</label>
                                                <div class="checkbox-group">

                                                    <label>
                                                        <input type="checkbox" name="stakeholder_roles[]" value="owner">
                                                        Beneficial Owner
                                                    </label>

                                                    <label>
                                                        <input type="checkbox" name="stakeholder_roles[]" value="director">
                                                        Director
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-md btn-custom" onclick="addStakeholder()">Save Stakeholder</button>
                                </div>
                                <h4>Payout Information</h4>
                                <div class="form-group">
                                    <label class="control-label">Account Number</label>
                                    <input type="text" class="form-control form-input" value="<?= old('account_number', $bd['account_number'] ?? '') ?>" name="account_number" placeholder="Account Number">
                                </div>
                                <div class="form-group">
                                    <label for="control-label">IFSC Code</label>
                                    <input type="text" class="form-control form-input" value="<?= old('ifsc_code', $bd['ifsc_code'] ?? '') ?>" name="ifsc_code" placeholder="IFSC Code">
                                </div>

                            <?php endif; ?>
                            <button type="submit" class="btn btn-md btn-custom m-t-10">
                                <?= trans("save_changes") ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style <?= csp_style_nonce() ?>>
    .btn-group {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 6px;
    }

    .view-btn {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .remove-btn {
        background: #ff4d4f;
        color: #fff;
        border: none;
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    /* FORM LAYOUT */
    .form-section {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: 1px solid #eee;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    /* SECTION HEADINGS */
    h4,
    h5 {
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: 600;
    }

    /* CHECKBOX GROUP */
    .checkbox-group label {
        margin-right: 15px;
        font-weight: 500;
    }

    /* STAKEHOLDER CARD */
    .stakeholder-box {
        background: #f9fafb;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
        position: relative;
    }

    .stakeholder-box strong {
        font-size: 15px;
        color: #333;
    }

    .stakeholder-box .meta {
        font-size: 13px;
        color: #666;
    }

    /* REMOVE BUTTON */
    .stakeholder-box button {
        position: absolute;
        top: 8px;
        right: 8px;
        background: #ff4d4f;
        color: #fff;
        border: none;
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    /* ADD BUTTON */
    .add-btn {
        background: #007bff;
        color: #fff;
        padding: 8px 14px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .add-btn:hover {
        background: #0056b3;
    }
</style>
<script <?= csp_script_nonce() ?>>
    let stakeholderIndex = <?= !empty($stakeholders) ? count($stakeholders) : 0 ?>;

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

    function viewStakeholder(btn) {
        let box = btn.closest('.stakeholder-box');

        let details = `
        Name: ${box.dataset.first} ${box.dataset.middle} ${box.dataset.last}
        DOB: ${box.dataset.dob}
        Nationality: ${box.dataset.nationality}
        ID Number: ${box.dataset.id}
        Address: ${box.dataset.address}
        City: ${box.dataset.city}
        State: ${box.dataset.state}
        ZIP: ${box.dataset.zip}
        Roles: ${box.dataset.roles}
    `;

        alert(details);
    }

    function addStakeholder() {

        let list = document.getElementById("stakeholderList");
        let index = stakeholderIndex++;

        let first = document.getElementById("sh_first_name").value.trim();
        let middle = document.getElementById("sh_middle_name").value.trim();
        let last = document.getElementById("sh_last_name").value.trim();
        let dob = document.getElementById("sh_dob").value;
        let nationality = document.getElementById("sh_nationality").value;
        let id_number = document.getElementById("sh_id_number").value.trim();
        let address1 = document.getElementById("sh_address1").value.trim();
        let city = document.getElementById("sh_city").value.trim();
        let state = document.getElementById("sh_state").value.trim();
        let zip = document.getElementById("sh_zip").value.trim();

        let roles = [];
        document.querySelectorAll('#stakeholderForm input[name="stakeholder_roles[]"]:checked')
            .forEach(el => roles.push(el.value));

        if (!first || !city) {
            alert("First name and city required");
            return;
        }

        first = escapeHtml(first);
        middle = escapeHtml(middle);
        last = escapeHtml(last);

        let html = `
    <div class="stakeholder-box"
         data-first="${first}"
         data-middle="${middle}"
         data-last="${last}"
         data-dob="${dob}"
         data-nationality="${nationality}"
         data-id="${id_number}"
         data-address="${address1}"
         data-city="${city}"
         data-state="${state}"
         data-zip="${zip}"
         data-roles="${roles.join(',')}">

        <strong>${first} ${last}</strong>
        <div class="meta">
            Role: ${roles.join(', ')}<br>
            City: ${city}
        </div>

        <button type="button" onclick="viewStakeholder(this)">View</button>
        <button type="button" onclick="this.parentElement.remove()">Remove</button>

        <input type="hidden" name="stakeholders[${index}][first_name]" value="${first}">
        <input type="hidden" name="stakeholders[${index}][middle_name]" value="${middle}">
        <input type="hidden" name="stakeholders[${index}][last_name]" value="${last}">
        <input type="hidden" name="stakeholders[${index}][dob]" value="${dob}">
        <input type="hidden" name="stakeholders[${index}][nationality]" value="${nationality}">
        <input type="hidden" name="stakeholders[${index}][id_number]" value="${id_number}">
        <input type="hidden" name="stakeholders[${index}][address1]" value="${address1}">
        <input type="hidden" name="stakeholders[${index}][city]" value="${city}">
        <input type="hidden" name="stakeholders[${index}][state]" value="${state}">
        <input type="hidden" name="stakeholders[${index}][zip]" value="${zip}">
    `;

        roles.forEach(r => {
            html += `<input type="hidden" name="stakeholders[${index}][role][]" value="${r}">`;
        });

        html += `</div>`;

        list.insertAdjacentHTML("beforeend", html);

        document.getElementById("stakeholderForm").reset();
        document.getElementById("stakeholderForm").style.display = "none";
    }
</script>