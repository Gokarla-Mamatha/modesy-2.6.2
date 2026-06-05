<?= aiWriter()->status == 1 && hasPermission('ai_writer') ? view('admin/includes/_ai_writer') : ''; ?>
</section>
</div>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b style="font-weight: 600;">Version</b> <?= MODESY_VERSION; ?>
    </div>
    <strong style="font-weight: 600;"><?= esc($baseSettings->copyright); ?></strong>
</footer>
</div>
<script src="<?= base_url('assets/admin/js/jquery-ui.min.js'); ?>"></script>


<!-- <script src="<?= base_url('assets/admin/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script> -->
<script src="<?= base_url('assets/admin/vendor/popper/popper.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/vendor/bootstrap/js/bootstrap.v5.3.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/vendor/datatables/jquery.dataTables.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/datatables/dataTables.bootstrap.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/pace/pace.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/js/plugins-2.6.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/js/script.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/tagify/tagify.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/vendor/magnific-popup/jquery.magnific-popup.min.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/admin/js/admin-2.6.js'); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/js/script.js?v='.time()); ?>" <?= csp_script_nonce() ?>></script>
<script src="<?= base_url('assets/js/inline.js'); ?>?time=<?= time(); ?>" <?= csp_script_nonce() ?>></script>
<!-- <script src="<?= base_url('assets/vendor/tinymce/tinymce.min.js'); ?>"></script> -->
<!-- <script src="<?= base_url('assets/vendor/tinymce/tinymce.min.8.4.js'); ?>"></script> -->
<script src="<?= base_url('assets/admin/vendor/ckeditor/build/ckeditor.js'); ?>" <?= csp_script_nonce() ?>></script>
<script <?= csp_script_nonce() ?>>
    $('<input>').attr({
        type: 'hidden',
        name: 'back_url',
        value: '<?= getCurrentUrl(false); ?>'
    }).appendTo('form[method="post"]');
</script>
<script <?= csp_script_nonce() ?>>
    $(function() {
        if ($.widget) $.widget.bridge('uibutton', $.ui.button);
    });
</script>
<script <?= csp_script_nonce() ?>>
    const editorElement = document.querySelector('#editor');

    if (editorElement) {
        ClassicEditor
            .create(editorElement)
            .catch(error => {
                console.error(error);
            });
    }

    function initTinyMCE(selector, minHeight, toolbar) {
        var menuBar = 'file edit view insert format tools table help';
        if (selector == '.tinyMCEsmall') {
            menuBar = false;
        }
        if (toolbar == null) {
            toolbar = 'fullscreen code preview | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat | image media link';
        }
        tinymce.init({
            selector: selector,
            height: minHeight,
            min_height: minHeight,
            valid_elements: '*[*]',
            entity_encoding: 'raw',
            relative_urls: false,
            remove_script_host: false,
            directionality: MdsConfig.directionality,
            language: '<?= $activeLang->text_editor_lang; ?>',
            menubar: menuBar,
            plugins: 'advlist autolink lists link image charmap preview searchreplace visualblocks code codesample fullscreen insertdatetime media table',
            toolbar: toolbar,
            content_css: ['<?= base_url('assets/vendor/tinymce/editor_content.css'); ?>'],
            mobile: {
                menubar: menuBar
            }
        });
    }

    if ($('.tinyMCE').length > 0) {
        initTinyMCE('.tinyMCE', 400, null);
    }
    if ($('.tinyMCEsmall').length > 0) {
        initTinyMCE('.tinyMCEsmall', 300, null);
    }
    $(document).ready(function() {
        $('.data_table').DataTable({
            "order": [
                [0, "desc"]
            ],
            "aLengthMenu": [
                [15, 30, 60, 100],
                [15, 30, 60, 100, "All"]
            ],
            "language": {
                "lengthMenu": "<?= esc(trans('show')); ?> _MENU_",
                "search": "<?= esc(trans('search')); ?>:",
                "zeroRecords": "<?= esc(trans('no_records_found')); ?>"
            },
            "infoCallback": function(settings, start, end, max, total, pre) {
                return total > 0 ? "<?= esc(trans('number_of_entries')); ?>: " + total : '';
            }
        });
    });
    $(document).ready(function() {
        $('#cs_datatable_currency').DataTable({
            "ordering": false,
            "aLengthMenu": [
                [15, 30, 60, 100],
                [15, 30, 60, 100, "All"]
            ],
            "language": {
                "lengthMenu": "<?= esc(trans('show')); ?> _MENU_",
                "search": "<?= esc(trans('search')); ?>:",
                "zeroRecords": "<?= esc(trans('no_records_found')); ?>"
            },
            "infoCallback": function(settings, start, end, max, total, pre) {
                return total > 0 ? "<?= esc(trans('number_of_entries')); ?>: " + total : '';
            }
        });
    });
</script>
<?php if (isset($langSearchColumn)): ?>
    <script <?= csp_script_nonce() ?>>
        //datatable
        var table = $('.cs_datatable_lang').DataTable({
            dom: 'l<"#table_dropdown">frtip',
            "order": [
                [0, "desc"]
            ],
            "aLengthMenu": [
                [15, 30, 60, 100],
                [15, 30, 60, 100, "All"]
            ],
            "language": {
                "lengthMenu": "<?= esc(trans('show')); ?> _MENU_",
                "search": "<?= esc(trans('search')); ?>:",
                "zeroRecords": "<?= esc(trans('no_records_found')); ?>",
                "info": "<?= esc(trans('number_of_entries')); ?>: _TOTAL_"
            },
            "infoCallback": function(settings, start, end, max, total, pre) {
                return total > 0 ? "<?= esc(trans('number_of_entries')); ?>: " + total : '';
            }
        });
        $('<label class="table-label"><label/>').text("<?= esc(trans('language')); ?>").appendTo('#table_dropdown');
        //insert the select and some options
        $select = $('<select class="form-control input-sm"><select/>').appendTo('#table_dropdown');
        $('<option/>').val('').text('<?= esc(trans("all")); ?>').appendTo($select);
        <?php foreach ($activeLanguages as $lang): ?>
            $('<option/>').val('<?= $lang->name; ?>').text('<?= $lang->name; ?>').appendTo($select);
        <?php endforeach; ?>
        table.column(<?= $langSearchColumn; ?>).search('').draw();
        $("#table_dropdown select").change(function() {
            table.column(<?= $langSearchColumn; ?>).search($(this).val()).draw();
        });
    </script>
<?php endif; ?>
<script <?= csp_script_nonce() ?>>
    $('#location_1').on('ifChecked', function() {
        $("#location_countries").hide();
    });
    $('#location_2').on('ifChecked', function() {
        $("#location_countries").show();
    });
</script>
</body>

</html>