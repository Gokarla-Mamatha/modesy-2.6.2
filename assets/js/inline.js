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
    deleteItem(this.dataset.url,this.dataset.id, this.dataset.msg);
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
    fetch('/csrf-token')
        .then(response => response.json())
        .then(data => {
            csrfInput.name = data.name;
            csrfInput.value = data.hash;
            form.dataset.csrfUpdated = '1';
            form.submit();
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
