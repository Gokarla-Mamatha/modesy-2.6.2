</section>
</div>
</div>
<?= aiWriter()->status == 1 && hasPermission('ai_writer') ? view('admin/includes/_ai_writer', ['aiContentType' => 'product']) : ''; ?>
<script src="<?= base_url('assets/admin/js/jquery-ui.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/popper/popper.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/bootstrap/js/bootstrap.v5.3.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/datatables/jquery.dataTables.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/datatables/dataTables.bootstrap.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/pace/pace.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/js/plugins-2.6.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/js/script.js?v=' . time()); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/magnific-popup/jquery.magnific-popup.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/js/admin-2.6.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/js/dashboard-2.6.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/js/inline.js'); ?>?time=<?= time(); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/vendor/tinymce/tinymce.v8.1.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/vendor/file-manager/file-manager.js'); ?>" <?= csp_script_nonce() ?>></script>

<script <?= csp_script_nonce() ?>>$('<input>').attr({type: 'hidden', name: 'back_url', value: '<?= getCurrentUrl(); ?>'}).appendTo('form[method="post"]');</script>
<script <?= csp_script_nonce() ?>>$('<input>').attr({type: 'hidden', name: 'sysLangId', value: '<?=selectedLangId(); ?>'}).appendTo('form[method="post"]');</script>
<script <?= csp_script_nonce() ?>>
    function initTinyMCE(selector, minHeight) {
        if (typeof tinymce === 'undefined') {
            return;
        }
        var menuBar = 'file insert format table help';
        if (selector == '.tinyMCEsmall') {
            menuBar = false;
        }
        tinymce.init({
            selector: selector,
            height: minHeight,
            min_height: minHeight,
            license_key: 'gpl',
            valid_elements: '*[*]',
            entity_encoding: 'raw',
            relative_urls: false,
            remove_script_host: false,
            directionality: MdsConfig.directionality,
            language: '<?= $activeLang->text_editor_lang; ?>',
            menubar: menuBar,
            plugins: 'advlist autolink lists link image charmap preview searchreplace visualblocks code codesample fullscreen insertdatetime media table',
            toolbar: 'fullscreen code preview | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat | image media link',
            content_css: ['<?= base_url('assets/vendor/tinymce/editor_content.css'); ?>'],
            mobile: {
                menubar: menuBar
            }
        });
    }
    if ($('.tinyMCE').length > 0) {
        initTinyMCE('.tinyMCE', 400);
    }
    if ($('.tinyMCEsmall').length > 0) {
        initTinyMCE('.tinyMCEsmall', 300);
    }

    function initFallbackTextEditor() {
        $('.text-editor').each(function () {
            var textarea = this;
            var $textarea = $(textarea);
            if ($textarea.data('fallback-editor') || $textarea.next('.tox-tinymce').length || $textarea.is(':hidden')) {
                return;
            }
            $textarea.data('fallback-editor', true);

            var editorId = textarea.id || 'fallback_editor_' + Math.random().toString(36).slice(2);
            textarea.id = editorId;

            var $editor = $('<div class="mds-fallback-editor" data-editor-id="' + editorId + '">' +
                '<div class="mds-fallback-toolbar">' +
                    '<button type="button" data-command="bold"><strong>B</strong></button>' +
                    '<button type="button" data-command="italic"><em>I</em></button>' +
                    '<button type="button" data-command="underline"><u>U</u></button>' +
                    '<button type="button" data-command="insertUnorderedList">List</button>' +
                    '<button type="button" data-command="insertOrderedList">1. List</button>' +
                    '<button type="button" data-command="createLink">Link</button>' +
                    '<button type="button" data-command="removeFormat">Clear</button>' +
                '</div>' +
                '<div class="mds-fallback-content" contenteditable="true"></div>' +
            '</div>');

            var $content = $editor.find('.mds-fallback-content');
            $content.html($textarea.val());
            $textarea.after($editor).hide();

            $editor.on('click', 'button', function () {
                var command = $(this).data('command');
                $content.trigger('focus');
                if (command === 'createLink') {
                    var url = prompt('Enter URL');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else {
                    document.execCommand(command, false, null);
                }
                $textarea.val($content.html());
            });

            $content.on('input blur keyup paste', function () {
                $textarea.val($content.html());
            });

            $textarea.closest('form').on('submit', function () {
                $textarea.val($content.html());
            });
        });
    }

    $(window).on('load', function () {
        setTimeout(initFallbackTextEditor, 800);
    });
</script>
<script <?= csp_script_nonce() ?>>
    $(document).ready(function () {
        $('.dataTable').DataTable({
            "order": [[0, "desc"]],
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]],
            "language": {
                "lengthMenu": "<?= esc(trans('show')); ?> _MENU_",
                "search": "<?= esc(trans('search')); ?>:",
                "zeroRecords": "<?= esc(trans('no_records_found')); ?>"
            },
            "infoCallback": function (settings, start, end, max, total, pre) {
                return total > 0 ? "<?= esc(trans('number_of_entries')); ?>: " + total : '';
            }
        });
        $('.dataTableNoSort').DataTable({
            "ordering": false,
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]],
            "language": {
                "lengthMenu": "<?= esc(trans('show')); ?> _MENU_",
                "search": "<?= esc(trans('search')); ?>:",
                "zeroRecords": "<?= esc(trans('no_records_found')); ?>"
            },
            "infoCallback": function (settings, start, end, max, total, pre) {
                return total > 0 ? "<?= esc(trans('number_of_entries')); ?>: " + total : '';
            }
        });
    });
</script>
</body>
</html>
