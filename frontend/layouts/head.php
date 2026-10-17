<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="csrf-token" content="<?= e(Csrf::token()) ?>">
<title>ระบบพิมพ์เกียรติบัตรออนไลน์ - <?= e(isset($pageTitle) ? $pageTitle : School::name()) ?></title>
<link rel="icon" href="assets/img/fav.ico" type="image/x-icon">

<script src="assets/vendor/atlantis/js/plugin/webfont/webfont.min.js"></script>
<script>
    WebFont.load({
        custom: {
            families: ['Flaticon', 'Font Awesome 5 Solid', 'Font Awesome 5 Regular', 'Font Awesome 5 Brands', 'simple-line-icons'],
            urls: ['assets/vendor/atlantis/css/fonts.min.css']
        },
        active: function () { sessionStorage.fonts = true; }
    });
</script>

<link rel="stylesheet" href="assets/vendor/atlantis/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/vendor/atlantis/css/atlantis.min.css">
<link rel="stylesheet" href="assets/vendor/datatables/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/vendor/datatables/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/vendor/colorpicker/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="assets/css/main.css">
