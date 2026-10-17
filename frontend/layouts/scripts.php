<script src="assets/vendor/atlantis/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/vendor/atlantis/js/core/popper.min.js"></script>
<script src="assets/vendor/atlantis/js/core/bootstrap.min.js"></script>
<script src="assets/vendor/atlantis/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="assets/vendor/atlantis/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
<script src="assets/vendor/atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/vendor/atlantis/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="assets/vendor/atlantis/js/atlantis.min.js"></script>

<script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendor/datatables/dataTables.responsive.min.js"></script>
<script src="assets/vendor/datatables/responsive.bootstrap4.min.js"></script>
<script src="assets/vendor/colorpicker/bootstrap-colorpicker.min.js"></script>

<script>
    window.APP = <?= json_encode([
        'csrfToken' => Csrf::token(),
        'flash'     => Session::pullFlash(),
        'page'      => isset($page['data']) ? $page['data'] : new stdClass(),
    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>;
</script>
<script src="assets/js/app.js"></script>
<?php foreach (isset($page['scripts']) ? $page['scripts'] : [] as $script): ?>
<script src="assets/js/<?= e($script) ?>"></script>
<?php endforeach; ?>
