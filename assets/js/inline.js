let deleteShippingId = 0;

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-delete-shipping');

    if (!btn) {
        return;
    }

    e.preventDefault();

    deleteShippingId = btn.dataset.id;
    document.getElementById('deleteShippingConfirmText').innerText = btn.dataset.msg;

    bootstrap.Modal.getOrCreateInstance('#deleteShippingConfirmModal').show();
});

document.getElementById('btnConfirmDeleteShipping')?.addEventListener('click', function () {
    fetch('/csrf-token')
        .then(res => res.json())
        .then(csrf => {
            const data = new FormData();
            data.append('id', deleteShippingId);
            data.append(csrf.name, csrf.hash);

            return fetch('/delete-shipping-address-post', {
                method: 'POST',
                body: data
            });
        })
        .then(() => location.reload());
});




$(document).on('click', '.btn-item-delete', function (e) {
    e.preventDefault();

    let $this = $(this);

    if (!confirm($this.data('msg'))) {
        return;
    }

    let formData = new FormData();
    formData.append('id', $this.data('id'));
    formData.append(MdsConfig.csrfTokenName, $('meta[name="X-CSRF-TOKEN"]').attr('content'));

    fetch(generateUrl($this.data('url')), {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == 1) {
            location.reload();
        } else {
            alert(data.message || 'Delete failed');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Something went wrong');
    });
});




$(document).on('click', '.btn-activate-inactivate-countries', function (e) {
    e.preventDefault();
    activateInactivateCountries(this.dataset.action);
});

$(document).on('click', '.btn-btn-ai-reset', function (e) {
    e.preventDefault();
    resetFormAIWriter();
});

$(document).on('click', '.btn-remove-panel', function () {
    $('#' + this.dataset.target).remove();
});

$(document).on('click', '.btn-delete-selected-comments', function (e) {
    e.preventDefault();

    const fn = this.dataset.fn;

    if (typeof window[fn] === 'function') {
        window[fn](this.dataset.msg);
    }
});

$(document).on('click', '.btn-approve-selected-comments', function (e) {
    e.preventDefault();

    const fn = this.dataset.fn;

    if (typeof window[fn] === 'function') {
        window[fn]();
    }
});

$(document).on('click', '.btn-delete-category-from-field', function (e) {
    e.preventDefault();

    deleteCategoryFromField(
        this.dataset.msg,
        this.dataset.fieldId,
        this.dataset.categoryId
    );
});

$(document).on('click', '.btn-delete-img', function (e) {
    e.preventDefault();

    const fn = this.dataset.fn;

    if (typeof window[fn] === 'function') {
        window[fn](this.dataset.id);
    }
});

$(document).on('click', '.btn-confirm-delete-thread', function (e) {
    if (!confirm(this.dataset.msg)) {
        e.preventDefault();
    }
});

$(document).on('click', '.btn-delete-chat-message', function (e) {
    e.preventDefault();
    deleteChatMessage(this.dataset.id, this.dataset.msg);
});

$(document).on('click', '.btn-perform-action', function (e) {
    e.preventDefault();

    performAction(
        this.dataset.url,
        this.dataset.id,
        this.dataset.msg,
        this
    );
});

$(document).on('click', '.btn-add-membership-feature', function (e) {
    e.preventDefault();
    addMembershipFeature();
});

document.addEventListener('submit', function (e) {
    const form = e.target;
    const csrfInput = form.querySelector('input[name^="csrf"]');

    if (!csrfInput || form.dataset.csrfUpdated === '1') {
        return;
    }
    e.preventDefault();

    // form.submit() drops the submitter button's name/value — preserve it as a hidden input
    const submitter = e.submitter;
    if (submitter && submitter.name) {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = submitter.name;
        hidden.value = submitter.value;
        form.appendChild(hidden);
    }

    fetch('/csrf-token')
        .then(response => response.json())
        .then(data => {
            csrfInput.name = data.name;
            csrfInput.value = data.hash;
            form.dataset.csrfUpdated = '1';
            HTMLFormElement.prototype.submit.call(form);
        });
});

$(document).on('change', '#select_countries_guest_billing', function () {
    getStates($(this).val(), 'guest_billing');
});

$(document).on('change', '#select_countries_guest_address', function () {
    getStates($(this).val(), 'guest_address');
    $('.cart-seller-shipping-options').empty();
});

$(document).on('change', '#select_states_guest_address', function () {
    getShippingMethodsByLocation($(this).val());
});
$(document).ready(function () {
    $('#select_countries_new_address').select2({
        dropdownParent: $('#modalAddAddress'),
        width: '100%'
    });

    $('#select_states_new_address').select2({
        dropdownParent: $('#modalAddAddress'),
        width: '100%'
    });

    $('.select-countries-edit-address').each(function () {
        $(this).select2({
            dropdownParent: $(this).closest('.modal'),
            width: '100%'
        });
    });
});

$(document).on('change', '#select_countries_new_address', function () {
    getStates($(this).val(), 'new_address');
});
$(document).on('change', '#select_countries_cart', function () {
    getStates($(this).val(), 'cart');
});
$(document).on('change', '.select-countries-edit-address', function () {
    var addressId = $(this).data('address-id');

    getStates($(this).val(), 'address_' + addressId);

    setTimeout(function () {
        $('#select_states_address_' + addressId).select2({
            dropdownParent: $('#modalAddress' + addressId),
            width: '100%'
        });
    }, 500);
});

$(document).on('click', '.btn-save-edit-address', function () {
    checkStateSelected($(this).data('state-select'));
});

$(document).on('change', '[id^="select_states_address_"]', function () {

    let stateName = $(this).find('option:selected').text();

    let addressId = $(this).attr('id').split('_').pop();

    $.post(baseUrl + '/get-state-code', {

        state_name: stateName

    }, function (response) {

        $('#state_code_' + addressId).val(response.state_code ?? '');

    }, 'json');

});


$(document).on('change', '#select_states_guest_address', function () {
    setNewLocationShippingData($(this).val());
});

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.js-remove-from-cart');
    if (!btn) return;

    e.preventDefault();

    const cartItemId = btn.getAttribute('data-cart-item-id');
    const csrfName = document.getElementById('csrf_token_name').value;
    const csrfHash = document.getElementById('csrf_hash').value;

    const formData = new FormData();
    formData.append('cart_item_id', cartItemId);
    formData.append(csrfName, csrfHash);

    fetch('/cart/remove-from-cart', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        location.reload();
    })
    .catch(() => {
        alert('Could not remove item from cart');
    });
});

$(document).off("change", ".cart-item-quantity input");

$(document).on("change", ".cart-item-quantity input", function () {
    const $input = $(this);
    const id = $input.data("cart-item-id");
    const qty = parseInt($input.val()) || 1;
    const price = parseFloat($input.data("unit-price")) || 0;

    $("#item-total-" + id).text("$" + (price * qty).toFixed(2));

    let subtotal = 0;
    $(".cart-item-quantity input").each(function () {
        subtotal += (parseInt($(this).val()) || 1) * (parseFloat($(this).data("unit-price")) || 0);
    });

    $(".cart-subtotal-price, .cart-total-price").text("$" + subtotal.toFixed(2));

    $.post(generateUrl("cart/update-quantity"), {
        product_id: $input.data("product-id"),
        cart_item_id: id,
        quantity: qty
    });
});

$(document).on("change", ".parent-category-select", function () {

    let currentSelect = $(this);
    let parentId = currentSelect.val();

    // Remove all child dropdowns below current dropdown
    currentSelect.closest('.subcategory-select-container')
        .nextAll('.subcategory-select-container')
        .remove();

    if (!parentId || parentId == 0) {
        return;
    }

    $.ajax({
        type: "POST",
        url: "/Ajax/getSubCategories",
        dataType: "json",
        data: {
            parent_id: parentId
        },
        success: function (response) {

            if (!response.htmlContent || response.htmlContent.trim() === '') {
                return;
            }

            $('#category_select_container').append(
                '<div class="subcategory-select-container">' +
                    '<select class="form-control select2 parent-category-select" name="category_id[]">' +
                        '<option value="0">None</option>' +
                        response.htmlContent +
                    '</select>' +
                '</div>'
            );

            $('.select2').select2();
        }
    });
});

$(document).on("click", "[data-tab-id]", function () {
    $("#input_active_tab").val($(this).data("tab-id"));
});

$(document).on("click", "#btn_add_loyalty_rule", function () {
    addLoyaltyRule();
});

$(document)
    .off("input keyup paste change", ".number-spinner input")
    .off("input paste change", ".cart-item-quantity .number-spinner input");

$(document).on("input change blur", ".cart-item-quantity .number-spinner input", function (e) {
    var $input = $(this);

    if ($input.val() === "" && e.type === "input") {
        return;
    }

    if ($input.val() === "" || parseInt($input.val()) < 1) {
        $input.val(1);
    }

    updateCartPrices();

    if (e.type !== "input") {
        saveCartQuantity($input);
    }
});

function updateCartPrices() {
    var subtotal = 0;

    $(".cart-item-quantity .number-spinner input").each(function () {
        var $input = $(this);
        var qty = parseInt($input.val()) || 1;
        var price = parseFloat($input.data("unit-price")) || 0;
        var total = qty * price;

        $("#item-total-" + $input.data("cart-item-id")).text("$" + total.toFixed(2));
        subtotal += total;
    });

    $(".cart-subtotal-price, .cart-total-price").text("$" + subtotal.toFixed(2));
}

function saveCartQuantity($input) {
    $.post(generateUrl("cart/update-quantity"), {
        product_id: $input.data("product-id"),
        cart_item_id: $input.data("cart-item-id"),
        quantity: parseInt($input.val()) || 1
    });
}

$(document).off("click", ".btn-add-remove-wishlist");

$(document).on("click", ".btn-add-remove-wishlist", function (e) {
    e.preventDefault();

    var $btn = $(this);

    $.post(generateUrl("Ajax/addRemoveWishlist"), {
        product_id: $btn.data("product-id"),
        sysLangId: 1
    }, function () {
        $btn.find("i").toggleClass("icon-heart icon-heart-o");
    });
});

document.querySelectorAll(".backBtn").forEach(btn => {
    btn.addEventListener("click", function () {
        let backStep = this.getAttribute("data-back");

        hideAllSteps();

        document.getElementById(backStep).classList.add("active");
    });
});

$(document).off('change', '.subcategory-select');

$(document).on('change', '.subcategory-select', function () {
    var parentId = $(this).val();
    var currentLevel = parseInt($(this).attr('data-level'));
    var nextLevel = currentLevel + 1;
    var langId = $(this).attr('data-lang-id') || 1;

    $('.subcategory-select-container').each(function () {
        if (parseInt($(this).attr('data-level')) > currentLevel) {
            $(this).remove();
        }
    });

    if (parentId == '') {
        return;
    }

    $.ajax({
        url: '/dashboard/get-sub-categories',
        type: 'POST',
        dataType: 'json',
        data: {
            parent_id: parentId,
            sys_lang_id: langId,
            csrf_token: $('input[name="csrf_token"]').val()
        },
        success: function (response) {
            // console.log(response);

            if (response.result == 1) {
                var html = '<div class="subcategory-select-container m-t-5" data-level="' + nextLevel + '">' +
                    '<select name="category_id[]" class="select2 form-control subcategory-select" data-level="' + nextLevel + '" data-lang-id="' + langId + '">' +
                    '<option value="">Select Category</option>' +
                    response.options +
                    '</select>' +
                    '</div>';

                $('#category_select_container').append(html);
                $('#category_select_container .select2').select2();
            }
        }
    });
});
$(document).on('click', '.btn-promote-product', function (e) {
    e.preventDefault();

    $('.pricing_product_id').val($(this).data('product-id'));

    $('#modalPricing').removeClass('fade');
    $('#modalPricing').modal('show');
});
$(document).on('click', '.approve-payment-btn', function (e) {
    e.preventDefault();

    var id = $(this).data('id');

    $('#modalApprovePayment' + id).addClass('in');
    $('#modalApprovePayment' + id).css('display', 'block');
});
$(document).on('click', '.close', function () {
    $(this).closest('.modal').removeClass('show').css('display', 'none');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
});

$(document).on('change', '#select_countries', function () {
    getStates($(this).val());
});

$(document).on('change', '#select_states', function () {
    getCities($(this).val());
});

$(document).on('click', '.btn-add-shipping-method', function () {
    $('#modalShippingMethod').addClass('in').show();
});
$(document).on('click', '.btn-shipping-method-edit', function () {
    var id = $(this).data('id');

    $('#modalEditShippingMethod' + id)
        .addClass('in')
        .css('display', 'block');
});

$(document).on('click', '.btn-add-delivery-time', function (e) {
    e.preventDefault();

    $('#modalAddDeliveryTime').show().addClass('in');
});

$(document).on('click', '.btn-edit-delivery-time', function (e) {
    e.preventDefault();

    var id = $(this).data('id');

    $('#modalEditDeliveryTime' + id)
        .addClass('in')
        .css('display', 'block');
});

$(document).on('change', 'input[name="shipping_address_id"]', function () {

    let addressId = $(this).val();

    let csrfInput = $('#form_validate input[type="hidden"]').first();

    let postData = {
        shipping_address_id: addressId
    };

    postData[csrfInput.attr('name')] = csrfInput.val();

    $.ajax({
        url: "/cart/saveShippingAddress",
        type: "POST",
        data: postData,
        success: function (response) {
            console.log(response);

            if (response.status == 1) {
                location.reload();
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });
});
$(document).on('click', '.btn-alert-close', function () {
    $(this).closest('.alert').remove();
});
$(document).on('click', '.btn-update-order-status', function () {
    $('#updateStatusModal_' + $(this).data('id')).addClass('in').show();
});