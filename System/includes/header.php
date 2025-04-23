<?php include_once "path.php"; ?>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo $systemTitle; ?></title>

    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="Draggabble Widget Boxes with Persistent Position and State" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Duy">
    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">

    <link rel="stylesheet" href="<?php echo getPath('css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo getPath('font-awesome/4.5.0/css/font-awesome.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo getPath('css/ace.min.css') ?>" class="ace-main-stylesheet"
        id="main-ace-style" />
    <link rel="stylesheet" href="<?php echo getPath('css/ace-skins.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo getPath('css/ace-rtl.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo getPath('css/select2.min.css') ?>" />
    <link rel="stylesheet" href="<?php echo getPath('css/toastr.min.css') ?>" />
    <script type="text/javascript" src="<?php echo getPath('js/ace-extra.min.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo getPath('tabulator-master/dist/css/tabulator_bootstrap3.min.css') ?>">
    <script type="text/javascript" src="<?php echo getPath('tabulator-master/dist/js/tabulator.min.js') ?>"></script>
    <link rel="stylesheet" href="<?php echo getPath('sweetalert/dist/sweetalert2.min.css') ?>">
    <script type="text/javascript" src="<?php echo getPath('sweetalert/dist/sweetalert2.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo getPath('js/jquery-2.1.4.min.js') ?>"></script>
    <script type="text/javascript" type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script type='text/javascript' src='<?php echo getPath("js/jquery.mobile.custom.min.js") ?>'>" + "<" + "/script>");
    </script>
    <script type="text/javascript" src="<?php echo getPath('js/bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo getPath('js/select2.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo getPath('js/ace-elements.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo getPath('js/ace.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo getPath('js/toastr.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo getPath('js/xlsx.full.min.js') ?>"></script>
    <style>
        body {
            font-family: Tahoma, sans-serif;
        }

        h2 {
            font-weight: bolder;
            font-size: 30px;
        }

        .disabled {
            pointer-events: none;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            color: #212529;
            cursor: text;
        }

        div.widget-header {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        div.widget-header>div {
            color: #333;
            font-size: 18px;
            font-weight: medium;
        }

        .btn {
            border-width: 1px;
        }

        .no-skin .navbar .navbar-toggle {
            background-color: #1c74c0;
        }

        .tabulator-table .tabulator-group-level-0 {
            background-color: #ffd21f;
        }

        .tabulator-row .tabulator-cell {
            border-right: 1px #ced4da solid;
        }

        .tabulator .tabulator-row:nth-child(even) {
            background-color: rgb(237, 247, 255) !important;
        }

        .tabulator .tabulator-row:nth-child(odd) {
            background-color: #ffffff !important;
        }

        .tabulator .tabulator-tableholder .tabulator-placeholder .tabulator-placeholder-contents {
            color: #393939;
            font-size: 15px;
        }

        .tabulator .tabulator-row .action-column {
            min-width: 200px;
        }

        .page-content>.row .col-lg-12,
        .page-content>.row .col-md-12,
        .page-content>.row .col-sm-12,
        .page-content>.row .col-xs-12 {
            float: none;
        }

        .select2-container .select2-selection--single {
            height: 35px;
            font-size: 14px;
            border-radius: 0 !important;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
        }

        .select2-container .select2-results {
            max-height: 300px;
            overflow-y: auto;
        }

        .select2-container .select2-results__option {
            line-height: 30px;
        }

        #toast-container>div {
            opacity: 1;
        }

        .swal2-container.swal2-center.swal2-backdrop-show>div>div.swal2-actions>button.swal2-confirm {
            background-color: #D15B47 !important
        }

        .swal2-container.swal2-center.swal2-backdrop-show>div>div.swal2-actions>button.swal2-cancel {
            background-color: #428bca I !important;
        }
    </style>
    <script>
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            showDuration: "500",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        };
    </script>
    <script type="text/javascript" src="../../main.js<?php echo randomNum() ?>"></script>
</head>