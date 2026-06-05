document.addEventListener("DOMContentLoaded", function () {

    // NAME (only letters)
    document.querySelectorAll('[data-type="name"]').forEach(input => {
        input.addEventListener("input", () => {
            input.value = input.value.replace(/[^A-Za-z\s]/g, '');
        });
    });

    // MOBILE (only numbers)
    document.querySelectorAll('[data-type="mobile"]').forEach(input => {
        input.addEventListener("input", () => {
            // remove non-numeric
            input.value = input.value.replace(/[^0-9]/g, '');

            // limit to 10 digits
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);
            }
        });
    });

    //NUMBER
    document.querySelectorAll('[data-type="number"]').forEach(input => {
        input.addEventListener("input", () => { 
            input.value = input.value.replace(/[^0-9]/g, '');
        });
    });
    
    // US ZIP CODE (5 digits, optional +4 e.g. 90210 or 90210-1234)
    document.querySelectorAll('[data-type="zip"]').forEach(input => {
        input.addEventListener("input", () => {
            // keep only digits and a single hyphen, max length 10 (00000-0000)
            input.value = input.value.replace(/[^0-9-]/g, '').slice(0, 10);
        });
        input.addEventListener("blur", () => {
            toggleError(input, /^\d{5}(-\d{4})?$/.test(input.value), "Enter a valid US ZIP code");
        });
    });

    // EMAIL                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
    document.querySelectorAll('[data-type="email"]').forEach(input => {
        input.addEventListener("input", () => {
            toggleError(input, /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value), "Enter valids email");
        });
    });

    // PASSWORD
    document.querySelectorAll('[data-type="password"]').forEach(input => {
        input.addEventListener("blur", () => {
            toggleError(input, input.value.length >= 4, "Minimum 4 characters required");
        });
    });

    // CONFIRM PASSWORD
    document.querySelectorAll('[data-match]').forEach(input => {
        input.addEventListener("blur", () => {
            let target = document.querySelector(`[name="${input.dataset.match}"]`);
            toggleError(input, input.value === target.value, "Passwords do not match");
        });
    });

    // REQUIRED
    document.querySelectorAll('[required]').forEach(input => {
        input.addEventListener("blur", () => {
            toggleError(input, input.value.trim() !== "", "This field is required");
        });
    });

    //TITLE (letters, numbers, spaces)
    document.querySelectorAll('[data-type="title"]').forEach(input => {
        input.addEventListener("input", () => {
            input.value = input.value.replace(/[^A-Za-z0-9\s&'-]/g, '');
        });
    });

    // TEXT (NO HTML / NO SCRIPT)
    document.querySelectorAll('[data-type="text"]').forEach(input => {

        function clean(value) {
            return value.replace(/[^A-Za-z0-9\s.,@?&()\-:'"©]/g, '');
        }
        input.addEventListener("input", () => {
            input.value = clean(input.value);
        });

        input.addEventListener("paste", function (e) {
            e.preventDefault();
            let paste = (e.clipboardData || window.clipboardData).getData('text');
            input.value += clean(paste);
        });

    });
        // DECIMAL (only numbers and one decimal point)
    document.querySelectorAll('[data-type="decimal"]').forEach(input => {

        input.addEventListener("input", () => {
            let value = input.value;

            // Remove all characters except digits and dot
            value = value.replace(/[^0-9.]/g, '');

            // Ensure only one decimal point
            let parts = value.split('.');
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }

            // Prevent decimal at the beginning (optional)
            if (value.startsWith('.')) {
                value = '0' + value;
            }

            input.value = value;
        });

        // Validate on blur
        input.addEventListener("blur", () => {
            const decimalPattern = /^\d+(\.\d+)?$/;
            toggleError(input, decimalPattern.test(input.value), "Enter a valid decimal number");
        });

    });
    
    //SLUG
    document.querySelectorAll('[data-type="slug"]').forEach(input => {

        input.addEventListener("input", function () {
            this.value = this.value .toLowerCase() .replace(/[^a-z0-9\s-]/g, '') .replace(/\s+/g, '-') .replace(/-+/g, '-');
        });

        input.addEventListener("blur", function () {
            this.value = this.value.replace(/^-+|-+$/g, '');
        });

    });
    //URL
    $(document).on('input','[data-type="url"]',e=>e.target.value=e.target.value.replace(/[^a-zA-Z0-9:/?&.=#_-]/g,''));
    
    // API KEY 
    document.querySelectorAll('[data-type="apikey"]').forEach(input => {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^A-Za-z0-9_\-+=./]/g, '');
        });
    });
    
    //IMAGE
    document.querySelectorAll('[data-type="image"]').forEach(input => {
        input.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) return;

            const fileName = file.name;
            const fileSize = file.size;
            const fileType = file.type;
            const fileInfo = document.getElementById("upload-file-info");

            // Allowed MIME types and extensions
            const allowedMimeTypes = [
                "image/jpeg",
                "image/png",
                "image/jpg",
                "image/webp"
            ];

            const allowedExtensions = ["jpg", "jpeg", "png", "webp"];
            const maxSize = 2 * 1024 * 1024; // 2MB

            // Extract file extension
            const extension = fileName.split('.').pop().toLowerCase();

            // Display selected file name
            if (fileInfo) {
                fileInfo.textContent = fileName;
            }

            // Validate MIME type
            if (!allowedMimeTypes.includes(fileType)) {
                toggleError(input, false, "Only JPG, JPEG, PNG, and WEBP files are allowed.");
                resetFileInput(input, fileInfo);
                return;
            }

            // Validate file extension
            if (!allowedExtensions.includes(extension)) {
                toggleError(input, false, "Invalid file extension.");
                resetFileInput(input, fileInfo);
                return;
            }

            // Prevent double extensions (e.g., image.php.jpg)
            if ((fileName.match(/\./g) || []).length > 1) {
                toggleError(input, false, "Invalid file name.");
                resetFileInput(input, fileInfo);
                return;
            }

            // Validate file size
            if (fileSize > maxSize) {
                toggleError(input, false, "Max file size is 2MB.");
                resetFileInput(input, fileInfo);
                return;
            }

            // Sanitize file name
            const sanitizedFileName = fileName.replace(/[^a-zA-Z0-9.\-_]/g, '');
            if (fileInfo) {
                fileInfo.textContent = sanitizedFileName;
            }

            toggleError(input, true, "");
        });
    });

    // Helper function to reset file input
    function resetFileInput(input, fileInfo) {
        input.value = "";
        if (fileInfo) {
            fileInfo.textContent = "";
        }
    }

    //IFRAME 
    document.querySelectorAll('[data-type="map-iframe"]').forEach(container => {
        let address = container.dataset.address || "";
        let lang = container.dataset.lang || "en";

        // Sanitize inputs
        address = address.replace(/[^a-zA-Z0-9\s,.\-]/g, '').trim();
        lang = lang.replace(/[^a-z]/gi, '').toLowerCase();

        if (!address) return;

        const iframe = document.createElement("iframe");
        iframe.src = `https://maps.google.com/maps?hl=${lang}&q=${encodeURIComponent(address)}&z=14&output=embed`;
        iframe.width = "100%";
        iframe.height = "600";
        iframe.style.border = "0";
        iframe.loading = "lazy";
        iframe.referrerPolicy = "no-referrer-when-downgrade";
        iframe.setAttribute("sandbox", "allow-scripts allow-same-origin allow-popups");

        container.appendChild(iframe);
    });

    // COMMON FUNCTION
    function toggleError(input, condition, message) {
        let error = input.parentNode.querySelector(".error-msg");

        if (!condition) {
            input.classList.add("error");

            if (!error) {
                let span = document.createElement("span");
                span.className = "error-msg";
                span.style.color = "red";
                span.style.fontSize = "12px";
                span.innerText = message;
                input.parentNode.appendChild(span);
            }
        } else {
            input.classList.remove("error");
            if (error) error.remove();
        }
    }

});

$(document).on('click', '.js-delete-blog-comment', function () {
    deleteBlogComment($(this).data('comment-id'), $(this).data('post-id'), $(this).data('msg'));
});

$(document).on('click', '.js-load-more-blog-comments', function () {
    loadMoreBlogComments($(this).data('post-id'));
});

$(document).on('click', '.js-show-comment-form', function () {
    showCommentForm($(this).data('comment-id'));
});

$(document).on('click', '.js-delete-product-comment', function () {
    deleteComment($(this).data('comment-id'), $(this).data('type'), $(this).data('msg'));
});

$(document).on('click', '.js-report-product-comment', function () {
    $('#report_comment_id').val($(this).data('comment-id'));
});

$(document).on('click', '.js-report-product-review', function () {
    $('#report_review_id').val($(this).data('review-id'));
});

$(document).on('click', '.js-remove-from-cart', function () {
    removeFromCart($(this).data('cart-item-id'));
});

$(document).on('click', '.js-remove-cart-discount-coupon', function () {
    removeCartDiscountCoupon();
});

$(document).on('click', '.js-delete-quote-request', function () {
    deleteQuoteRequest($(this).data('quote-id'), $(this).data('msg'));
});

$(document).on('click', '.js-delete-chat', function () {
    deleteChat($(this).data('chat-id'), $(this).data('msg'));
});

$(document).on('click', '.js-cancel-order', function () {
    cancelOrder($(this).data('order-id'), $(this).data('msg'));
});

$(document).on('click', '.js-approve-order-product', function () {
    approveOrderProduct($(this).data('item-id'), $(this).data('msg'));
});

$(document).on('click', '.js-delete-product-video-preview', function () {
    deleteProductVideoPreview($(this).data('product-id'), $(this).data('msg'));
});

$(document).on('click', '.js-delete-product-audio-preview', function () {
    deleteProductAudioPreview($(this).data('product-id'), $(this).data('msg'));
});

$(document).on('click', '.js-download-digital-file', function () {
    $('#form_download_digital_file').submit();
});

$(document).on('click', '.js-delete-product-digital-file', function () {
    deleteProductDigitalFile($(this).data('file-id'), $(this).data('msg'));
});

$(document).on('click', '.js-delete-license-key', function () {
    deleteLicenseKey($(this).data('license-key-id'), $(this).data('product-id'));
});

document.addEventListener("DOMContentLoaded", function () {

    const config = document.getElementById("editor-config");
    if (!config) return; // only run where editor exists

    const language = config.dataset.lang;
    const editorCss = config.dataset.css;
    const uploadUrl = config.dataset.uploadUrl;
    const safeExtensions = JSON.parse(config.dataset.safeExt);
    const msgInvalid = config.dataset.msgInvalid;
    const msgSizeError = config.dataset.msgSize;

    // ✅ TinyMCE
    if (typeof tinymce !== "undefined") {
        tinymce.init({
            selector: '.tinyMCEticket',
            height: 320,
            min_height: 320,
            valid_elements: '*[*]',
            entity_encoding: 'raw',
            relative_urls: false,
            remove_script_host: false,
            directionality: window.MdsConfig?.rtl || 'ltr',
            language: language,
            menubar: false,
            plugins: [],
            toolbar: 'fullscreen code preview | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat | image media link',
            content_css: [editorCss],
        });
    }

    // ✅ File uploader
    if (typeof $ !== "undefined" && $('#drag-and-drop-zone').length) {

        $('#drag-and-drop-zone').dmUploader({
            url: uploadUrl,
            queue: false,
            extraData: function (id) {
                return {
                    file_id: id,
                    ticket_type: 'client',
                    [window.MdsConfig?.csrfTokenName]: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                };
            },
            onNewFile: function (id, file) {
                const ext = file.name.split('.').pop().toLowerCase();

                if (!safeExtensions.includes(ext)) {
                    Swal.fire({
                        text: msgInvalid,
                        icon: 'warning',
                        confirmButtonText: window.MdsConfig?.text?.ok || 'OK'
                    });
                    return false;
                }

                ui_multi_add_file(id, file, "file");
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                if (data.result == 1) {
                    document.getElementById("response_uploaded_files").innerHTML = data.response;
                }
                document.getElementById("uploaderFile" + id)?.remove();
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
            },
            onFileSizeError: function () {
                Swal.fire({
                    text: msgSizeError,
                    icon: 'warning',
                    confirmButtonText: window.MdsConfig?.text?.ok || 'OK'
                });
            }
        });
    }

});
document.addEventListener("DOMContentLoaded", function () {

    const csvConfig = document.getElementById("csv-config");
    if (!csvConfig) return; // run only on this page

    const uploadUrl = csvConfig.dataset.uploadUrl;
    const processUrl = csvConfig.dataset.processUrl;

    // ✅ CSV UPLOADER
    if (typeof $ !== "undefined" && $('#drag-and-drop-zone').length) {

        $('#drag-and-drop-zone').dmUploader({
            url: uploadUrl,
            multiple: false,
            extFilter: ['csv'],
            extraData: function () {
                return {
                    [window.MdsConfig?.csrfTokenName]: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onNewFile: function () {
                $("#csv_upload_spinner").show();
                $("#csv_upload_spinner .spinner").show();
                $("#csv_upload_spinner .text-csv-importing").show();
                $("#csv_upload_spinner .text-csv-import-completed").hide();
                $("#csv_uploaded_files").empty();
            },
            onUploadSuccess: function (id, data) {
                try {
                    if (data.result == 1 && data.file_name) {
                        handleCsvUpload(data.file_name);
                    } else {
                        $("#csv_upload_spinner").hide();
                    }
                } catch (e) {
                    alert("Invalid CSV file! Make sure there are no double quotes in your content.");
                }
            }
        });
    }

    // ✅ HANDLE CSV PROCESS
    function handleCsvUpload(fileName) {

        let currentIndex = 0;
        const chunkSize = 50;

        function processChunk() {

            $.ajax({
                type: 'POST',
                url: processUrl,
                data: {
                    file_name: fileName,
                    start: currentIndex,
                    limit: chunkSize,
                    data_type: 'category'
                },
                dataType: 'json',
                success: function (res) {

                    if (res.success) {

                        currentIndex += chunkSize;

                        let percent = Math.round((Math.min(currentIndex, res.total) / res.total) * 100);

                        if (percent > 0 && percent < 100) {
                            $(".text-csv-importing").html(`
                                <div class="process">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>&nbsp;&nbsp;${percent}%
                                </div>
                            `);
                        }

                        if (currentIndex < res.total) {
                            setTimeout(processChunk, 200);
                        } else {
                            $("#csv_upload_spinner .spinner").hide();
                            $("#csv_upload_spinner .text-csv-importing").hide();
                            $("#csv_upload_spinner .text-csv-import-completed").show();
                        }

                    } else {
                        $("#csv_upload_spinner .spinner").hide();
                        $("#csv_upload_spinner .text-csv-importing")
                            .text("Error: " + res.message);
                    }
                },
                error: function (xhr, status, error) {
                    $("#csv_upload_spinner .spinner").hide();
                    $("#csv_upload_spinner .text-csv-importing")
                        .text("AJAX error: " + error);
                }
            });
        }

        setTimeout(processChunk, 500);
    }

});

document.addEventListener("DOMContentLoaded", function () {

    const csvConfig = document.getElementById("csv-config");
    if (!csvConfig) return;

    const uploadUrl = csvConfig.dataset.uploadUrl;
    const processUrl = csvConfig.dataset.processUrl;
    const dataType = csvConfig.dataset.type; // 👈 dynamic

    if (typeof $ !== "undefined" && $('#drag-and-drop-zone').length) {

        $('#drag-and-drop-zone').dmUploader({
            url: uploadUrl,
            multiple: false,
            extFilter: ['csv'],
            extraData: function () {
                return {
                    [window.MdsConfig?.csrfTokenName]: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onNewFile: function () {
                $("#csv_upload_spinner").show();
                $("#csv_upload_spinner .spinner").show();
                $("#csv_upload_spinner .text-csv-importing").show();
                $("#csv_upload_spinner .text-csv-import-completed").hide();
                $("#csv_uploaded_files").empty();
            },
            onUploadSuccess: function (id, data) {
                try {
                    if (data.result == 1 && data.file_name) {
                        handleCsvUpload(data.file_name);
                    } else {
                        $("#csv_upload_spinner").hide();
                    }
                } catch (e) {
                    alert("Invalid CSV file!");
                }
            }
        });
    }

    function handleCsvUpload(fileName) {

        let currentIndex = 0;
        const chunkSize = 50;

        function processChunk() {

            $.ajax({
                type: 'POST',
                url: processUrl,
                data: {
                    file_name: fileName,
                    start: currentIndex,
                    limit: chunkSize,
                    data_type: dataType // 👈 dynamic here
                },
                dataType: 'json',
                success: function (res) {

                    if (res.success) {

                        currentIndex += chunkSize;

                        let percent = Math.round((Math.min(currentIndex, res.total) / res.total) * 100);

                        if (percent > 0 && percent < 100) {
                            $(".text-csv-importing").html(`
                                <div class="process">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>&nbsp;&nbsp;${percent}%
                                </div>
                            `);
                        }

                        if (currentIndex < res.total) {
                            setTimeout(processChunk, 200);
                        } else {
                            $("#csv_upload_spinner .spinner").hide();
                            $("#csv_upload_spinner .text-csv-importing").hide();
                            $("#csv_upload_spinner .text-csv-import-completed").show();
                        }

                    } else {
                        $("#csv_upload_spinner .spinner").hide();
                        $("#csv_upload_spinner .text-csv-importing")
                            .text("Error: " + res.message);
                    }
                },
                error: function (xhr, status, error) {
                    $("#csv_upload_spinner .spinner").hide();
                    $("#csv_upload_spinner .text-csv-importing")
                        .text("AJAX error: " + error);
                }
            });
        }

        setTimeout(processChunk, 500);
    }

});
document.addEventListener("DOMContentLoaded", function () {

    const fmConfig = document.getElementById("file-manager-config");
    if (!fmConfig) return;

    const uploadUrl = fmConfig.dataset.uploadUrl;

    function initImageUploader() {

        if (typeof $ === "undefined" || !$('#drag-and-drop-zone-file-manager').length) {
            return;
        }

        $('#drag-and-drop-zone-file-manager').dmUploader({
            url: uploadUrl,
            queue: true,
            allowedTypes: 'image/*',
            extFilter: ["jpg", "jpeg", "webp", "png", "gif"],
            extraData: function (id) {
                return {
                    file_id: id,
                    [window.MdsConfig?.csrfTokenName]: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                };
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "file-manager");

                if (typeof FileReader !== "undefined") {
                    let reader = new FileReader();
                    let img = $('#uploaderFile' + id).find('img');

                    reader.onload = function (e) {
                        img.attr('src', e.target.result);
                    };

                    reader.readAsDataURL(file);
                }
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
                $("#btn_reset_upload_image").show();
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id) {
                document.getElementById("uploaderFile" + id)?.remove();
                if (typeof refreshFileManagerImages === "function") {
                    refreshFileManagerImages();
                }
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
                $("#btn_reset_upload_image").hide();
            }
        });
    }

    // INIT
    initImageUploader();

    // re-init after ajax
    $(document).ajaxStop(function () {
        initImageUploader();
    });

    // reset button
    $(document).on('click', '#btn_reset_upload_image', function () {
        $("#drag-and-drop-zone-file-manager").dmUploader("reset");
        $("#files-file-manager").empty();
        $(this).hide();
    });

});
document.querySelectorAll('[data-type="quantity"]').forEach(input => {
    input.addEventListener("input", () => {
        input.value = input.value.replace(/[^0-9]/g, '');
    });
});